<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class PwaTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::first() ?? User::factory()->create();
    }

    /**
     * Test file manifest.json dapat diakses publik dengan format valid.
     */
    public function test_manifest_json_is_accessible_and_valid()
    {
        $manifestPath = public_path('manifest.json');
        $this->assertFileExists($manifestPath);

        $json = json_decode(file_get_contents($manifestPath), true);
        $this->assertIsArray($json);
        $this->assertEquals('BankRate ID - Komparasi Suku Bunga Deposito', $json['name']);
        $this->assertEquals('BankRate ID', $json['short_name']);
        $this->assertEquals('standalone', $json['display']);
        $this->assertEquals('#4f46e5', $json['theme_color']);
        $this->assertNotEmpty($json['icons']);
    }

    /**
     * Test file sw.js (Service Worker) ada dan berisi konfigurasi caching.
     */
    public function test_service_worker_file_exists()
    {
        $swPath = public_path('sw.js');
        $this->assertFileExists($swPath);

        $content = file_get_contents($swPath);
        $this->assertStringContainsString('bankrate-pwa', $content);
        $this->assertStringContainsString('offline.html', $content);
    }

    /**
     * Test file offline.html tersedia.
     */
    public function test_offline_page_exists()
    {
        $offlinePath = public_path('offline.html');
        $this->assertFileExists($offlinePath);

        $content = file_get_contents($offlinePath);
        $this->assertStringContainsString('Anda Sedang Offline', $content);
    }

    /**
     * Test icons PWA utama tersedia di direktori public/icons.
     */
    public function test_pwa_icons_exist()
    {
        $this->assertFileExists(public_path('icons/icon-192x192.png'));
        $this->assertFileExists(public_path('icons/icon-512x512.png'));
        $this->assertFileExists(public_path('icons/icon-maskable-192x192.png'));
        $this->assertFileExists(public_path('icons/apple-touch-icon.png'));
        $this->assertFileExists(public_path('icons/icon.svg'));
    }

    /**
     * Test homepage memuat tag PWA manifest dan script pwa.js.
     */
    public function test_homepage_includes_pwa_assets()
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee('manifest.json');
        $response->assertSee('js/pwa.js');
        $response->assertSee('apple-touch-icon.png');
    }

    /**
     * Test admin dashboard memuat tag PWA manifest dan script pwa.js.
     */
    public function test_admin_dashboard_includes_pwa_assets()
    {
        $response = $this->actingAs($this->user)->get(route('admin.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('manifest.json');
        $response->assertSee('js/pwa.js');
    }
}
