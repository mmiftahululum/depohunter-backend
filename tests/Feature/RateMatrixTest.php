<?php

namespace Tests\Feature;

use App\Models\Bank;
use App\Models\DepositProduct;
use App\Models\DepositRate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RateMatrixTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::first() ?? User::factory()->create();
    }

    /**
     * Test tamu (guest) diarahkan ke halaman login.
     */
    public function test_guests_cannot_access_rate_matrix()
    {
        $response = $this->get(route('admin.rate-matrix.index'));
        $response->assertRedirect(route('login'));
    }

    /**
     * Test halaman list Bank memiliki tombol "Update with table".
     */
    public function test_banks_index_has_update_with_table_button()
    {
        $response = $this->actingAs($this->user)->get(route('admin.banks.index'));

        $response->assertStatus(200);
        $response->assertSee('Update with table');
        $response->assertSee(route('admin.rate-matrix.index'));
    }

    /**
     * Test admin dapat mengakses halaman matriks suku bunga.
     */
    public function test_admin_can_view_rate_matrix_page()
    {
        $response = $this->actingAs($this->user)->get(route('admin.rate-matrix.index'));

        $response->assertStatus(200);
        $response->assertSee('Matriks Suku Bunga Deposito');
        $response->assertSee('rate-matrix-app');
    }

    /**
     * Test endpoint API getData mengembalikan struktur matriks yang tepat.
     */
    public function test_admin_can_get_rate_matrix_data()
    {
        $bank = Bank::first();
        if (!$bank) {
            $this->markTestSkipped('Tidak ada bank di database.');
        }

        $response = $this->actingAs($this->user)->getJson(route('admin.rate-matrix.data', ['bank_id' => $bank->id]));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'bank' => ['id', 'name', 'type'],
                'products_list',
                'tenors',
                'rows' => [
                    '*' => [
                        'product_id',
                        'product_name',
                        'min_deposit',
                        'min_deposit_formatted',
                        'rates',
                    ]
                ]
            ]);
    }

    /**
     * Test endpoint update-rate dapat menyimpan atau memperbarui suku bunga.
     */
    public function test_admin_can_update_individual_rate_cell()
    {
        $product = DepositProduct::first();
        if (!$product) {
            $this->markTestSkipped('Tidak ada produk deposito di database.');
        }

        $payload = [
            'deposit_product_id' => $product->id,
            'duration_months' => 1,
            'interest_rate' => 5.75,
        ];

        $response = $this->actingAs($this->user)->postJson(route('admin.rate-matrix.update-rate'), $payload);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'deposit_product_id' => $product->id,
                    'duration_months' => 1,
                    'interest_rate' => 5.75,
                ]
            ]);

        $this->assertDatabaseHas('deposit_rates', [
            'deposit_product_id' => $product->id,
            'duration_months' => 1,
            'interest_rate' => 5.75,
        ]);
    }

    /**
     * Test endpoint update-rate memvalidasi input tidak valid.
     */
    public function test_admin_cannot_save_invalid_rate()
    {
        $product = DepositProduct::first();
        if (!$product) {
            $this->markTestSkipped('Tidak ada produk deposito di database.');
        }

        $payload = [
            'deposit_product_id' => $product->id,
            'duration_months' => 1,
            'interest_rate' => 150, // Lebih dari 100%
        ];

        $response = $this->actingAs($this->user)->postJson(route('admin.rate-matrix.update-rate'), $payload);
        $response->assertStatus(422);
    }
}
