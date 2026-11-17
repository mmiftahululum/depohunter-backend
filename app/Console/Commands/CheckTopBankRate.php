<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Bank;
use App\Models\DepositRate;
use Illuminate\Http\Client\Response;

/**
 * Command that runs daily to determine the bank with the highest interest rate.
 * If the top‑ranked bank changes compared to the previous run, a notification
 * is sent to the Firebase topic "deposito_hunter".
 */
class CheckTopBankRate extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'bank:check-top-rate';

    /**
     * The console command description.
     */
    protected $description = 'Check which bank has the highest deposit rate and notify via Firebase if it changes.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('CheckTopBankRate started', [
            'command' => $this->signature,
            'environment' => app()->environment(),
        ]);

        // Allow a dry-run with fake data for local testing.
        if (app()->environment('local') && env('CHECK_TOP_BANK_RATE_DUMMY', false)  ) {
            $topRate = (object) [
                'product' => (object) [
                    'bank' => (object) [
                        'id' => 999,
                        'name' => 'Dami Bank',
                        'depositRates' => collect([(object) ['interest_rate' => 7.25], (object) ['interest_rate' => 6.95]]),
                    ],
                ],
            ];
        } else {
            // Retrieve the bank with the highest rate based on the real database.
            $topRate = DepositRate::with('product.bank')
                ->orderByDesc('interest_rate')
                ->first();
        }

        if (! $topRate) {
            $this->info('No deposit rates found.');
            return 0;
        }

        $topBank = $topRate->product->bank;

        if (! $topBank) {
            $this->info('No bank with deposit rates found.');
            return 0;
        }

        $currentTopId = $topBank->id;
        $previousTopId = Cache::get('top_bank_id');

        if ($previousTopId && $previousTopId == $currentTopId) {
            $this->info('Top bank unchanged – no notification sent.');
            return 0;
        }

        // Store the new top bank for the next run.
        Cache::forever('top_bank_id', $currentTopId);

        // Prepare the notification payload for Firebase Cloud Messaging.
        $messageBody = "{$topBank->name} now offers the highest deposit rate of {$topBank->depositRates->max('interest_rate')}%.";

        $payload = [
            'message' => [
                'topic' => 'deposito_hunter',
                'notification' => [
                    'title' => 'Bank Rate Update',
                    'body' => $messageBody,
                ],
                'data' => [
                    'bank_id' => (string) $topBank->id,
                    'bank_name' => (string) $topBank->name,
                    'interest_rate' => (string) $topBank->depositRates->max('interest_rate'),
                ],
            ],
        ];

        Log::info('Firebase notification payload prepared', [
            'payload' => $payload,
            'top_bank_id' => $topBank->id,
            'top_bank_name' => $topBank->name,
            'previous_top_id' => $previousTopId,
            'current_top_id' => $currentTopId,
        ]);

        $response = $this->sendFirebaseNotification($payload);

        Log::info('Firebase notification response received', [
            'status' => $response->status(),
            'successful' => $response->successful(),
            'headers' => $response->headers(),
            'body' => $response->body(),
            'json' => $response->json(),
        ]);

        if ($response->successful()) {
            $this->info('Notification sent to Firebase topic.');
        } else {
            $this->error('Failed to send Firebase notification: ' . $response->body());
        }

        return 0;
    }

    protected function sendFirebaseNotification(array $payload): Response
    {
        $serviceAccountPath = storage_path('app/service-account.json');
        $legacyEndpoint = 'https://fcm.googleapis.com/fcm/send';

        if (! is_string($serviceAccountPath) || ! file_exists($serviceAccountPath)) {
            $this->warn('service-account.json not found, falling back to server key.');

            Log::warning('Firebase notification using legacy server key fallback', [
                'reason' => 'service-account.json not found',
                'service_account_path' => $serviceAccountPath,
                'endpoint' => $legacyEndpoint,
                'payload' => $payload,
            ]);

            return Http::withHeaders([
                'Authorization' => 'key=' . env('FIREBASE_SERVER_KEY'),
                'Content-Type' => 'application/json',
            ])->post($legacyEndpoint, $payload);
        }

        $serviceAccount = json_decode(file_get_contents($serviceAccountPath), true);

        if (! is_array($serviceAccount) || empty($serviceAccount['client_email']) || empty($serviceAccount['private_key'])) {
            $this->warn('Invalid service-account.json, falling back to server key.');

            Log::warning('Firebase notification using legacy server key fallback', [
                'reason' => 'invalid service-account.json',
                'service_account_path' => $serviceAccountPath,
                'service_account_keys' => is_array($serviceAccount) ? array_keys($serviceAccount) : null,
                'endpoint' => $legacyEndpoint,
                'payload' => $payload,
            ]);

            return Http::withHeaders([
                'Authorization' => 'key=' . env('FIREBASE_SERVER_KEY'),
                'Content-Type' => 'application/json',
            ])->post($legacyEndpoint, $payload);
        }

        $now = time();
        $header = $this->base64UrlEncode(json_encode(['alg' => 'RS256', 'typ' => 'JWT']));
        $claim = $this->base64UrlEncode(json_encode([
            'iss' => $serviceAccount['client_email'],
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => 'https://oauth2.googleapis.com/token',
            'iat' => $now,
            'exp' => $now + 3600,
        ]));

        $signatureInput = $header . '.' . $claim;
        $privateKey = openssl_pkey_get_private($serviceAccount['private_key']);
        $signature = '';

        if (! $privateKey || ! openssl_sign($signatureInput, $signature, $privateKey, 'SHA256')) {
            $this->warn('Failed to sign JWT, falling back to server key.');

            Log::warning('Firebase notification using legacy server key fallback', [
                'reason' => 'failed to sign JWT',
                'endpoint' => $legacyEndpoint,
                'project_id' => $serviceAccount['project_id'] ?? null,
                'client_email' => $serviceAccount['client_email'] ?? null,
                'payload' => $payload,
            ]);

            return Http::withHeaders([
                'Authorization' => 'key=' . env('FIREBASE_SERVER_KEY'),
                'Content-Type' => 'application/json',
            ])->post($legacyEndpoint, $payload);
        }

        $jwt = $signatureInput . '.' . $this->base64UrlEncode($signature);

        $tokenResponse = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);

        Log::info('Firebase OAuth token response received', [
            'status' => $tokenResponse->status(),
            'successful' => $tokenResponse->successful(),
            'headers' => $tokenResponse->headers(),
            'body' => $tokenResponse->body(),
            'json' => $tokenResponse->json(),
        ]);

        $token = $tokenResponse->json('access_token');

        if (! $token) {
            $this->warn('Failed to fetch access token from service account, falling back to server key.');

            Log::warning('Firebase notification using legacy server key fallback', [
                'reason' => 'failed to fetch access token',
                'endpoint' => $legacyEndpoint,
                'project_id' => $serviceAccount['project_id'] ?? null,
                'token_response_status' => $tokenResponse->status(),
                'token_response_body' => $tokenResponse->body(),
                'payload' => $payload,
            ]);

            return Http::withHeaders([
                'Authorization' => 'key=' . env('FIREBASE_SERVER_KEY'),
                'Content-Type' => 'application/json',
            ])->post($legacyEndpoint, $payload);
        }

        $fcmEndpoint = 'https://fcm.googleapis.com/v1/projects/' . $serviceAccount['project_id'] . '/messages:send';

        Log::info('Firebase notification using HTTP v1 API', [
            'endpoint' => $fcmEndpoint,
            'project_id' => $serviceAccount['project_id'] ?? null,
            'client_email' => $serviceAccount['client_email'] ?? null,
            'payload' => $payload,
        ]);

        return Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ])->post(
            $fcmEndpoint,
            $payload
        );
    }

    protected function base64UrlEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }
}

