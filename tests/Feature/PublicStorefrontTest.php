<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicStorefrontTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_pages_render_with_seeded_content(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('data-banner-carousel', false)
            ->assertSee('Dari Kebun ke Meja Anda');
        $this->get('/menu')->assertOk()->assertSee('Purple Latte');
        $this->get('/menu/purple-latte')->assertOk()->assertSee('Tambah ke Keranjang');
        $this->get('/galeri')->assertOk();
        $this->get('/promo')->assertOk();
        $this->get('/kontak')->assertOk();
        $this->get('/sitemap.xml')->assertOk()->assertHeader('Content-Type', 'application/xml');
    }

    public function test_catalog_search_filter_and_product_configuration_work(): void
    {
        $product = Product::where('slug', 'purple-latte')->firstOrFail();
        $this->get('/menu?q=purple')->assertOk()->assertSee('Purple Latte');
        $this->get('/menu?category='.$product->category_id)->assertOk()->assertSee($product->name);
        $this->getJson('/api/products/'.$product->id.'/configuration')
            ->assertOk()->assertJsonPath('name', 'Purple Latte')->assertJsonCount(2, 'variants');
    }

    public function test_public_navigation_marks_current_page_active(): void
    {
        $this->get('/menu')
            ->assertOk()
            ->assertSee('public-nav-link active', false)
            ->assertSee('aria-current="page"', false);
    }
}
