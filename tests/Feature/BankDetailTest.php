<?php

namespace Tests\Feature;

use App\Models\Bank;
use App\Models\DepositProduct;
use Tests\TestCase;

class BankDetailTest extends TestCase
{
    /**
     * Test homepage renders bank title linking to detail page.
     */
    public function test_homepage_links_to_bank_detail_page()
    {
        $bank = Bank::first();
        if (!$bank) {
            $this->markTestSkipped('No bank available in database.');
        }

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee(route('bank.detail', $bank->id));
    }

    /**
     * Test homepage deposit buttons have referral links or fallbacks.
     */
    public function test_homepage_deposit_button_links()
    {
        $bank = Bank::with('depositProducts')->first();
        if (!$bank) {
            $this->markTestSkipped('No bank available in database.');
        }

        $response = $this->get('/');
        $response->assertStatus(200);

        $productWithLink = DepositProduct::whereNotNull('referral_link')
            ->where('referral_link', '!=', '')
            ->first();

        if ($productWithLink) {
            $response->assertSee(e($productWithLink->referral_link), false);
        }
    }

    /**
     * Test bank detail page renders successfully for existing bank.
     */
    public function test_bank_detail_page_renders_successfully()
    {
        $bank = Bank::with(['depositProducts.depositRates'])->first();
        if (!$bank) {
            $this->markTestSkipped('No bank available in database.');
        }

        $response = $this->get(route('bank.detail', $bank->id));
        $response->assertStatus(200);
        $response->assertSee($bank->name);

        $product = $bank->depositProducts->first();
        if ($product && !empty($product->referral_link)) {
            $response->assertSee(e($product->referral_link), false);
            $response->assertSee('Buka Deposito');
        }
    }

    /**
     * Test bank detail returns 404 for nonexistent bank ID.
     */
    public function test_bank_detail_returns_404_for_invalid_id()
    {
        $response = $this->get(route('bank.detail', 999999));
        $response->assertStatus(404);
    }

    /**
     * Test homepage table rows have Simulasi buttons.
     */
    public function test_homepage_has_simulasi_button()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('btn-apply-rate');
        $response->assertSee('Simulasi');
    }

    /**
     * Test homepage has both min and max tenor sliders.
     */
    public function test_homepage_has_tenor_range_sliders()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('id="filter-min-tenor"', false);
        $response->assertSee('id="filter-max-tenor"', false);
        $response->assertSee('id="filter-tenor-range-display"', false);
        $response->assertSee('id="dual-range-fill"', false);
    }
}
