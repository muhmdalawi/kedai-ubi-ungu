<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Topping;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_recalculates_multi_item_total_and_stores_snapshots(): void
    {
        $category = Category::create(['name' => 'Minuman']);
        $product = Product::create(['category_id' => $category->id, 'name' => 'Purple Latte', 'slug' => 'purple-latte', 'description' => 'Creamy', 'price' => 18000, 'stock_status' => 'available']);
        $variant = $product->variants()->create(['variant_name' => 'Large', 'additional_price' => 5000, 'is_active' => true]);
        $topping = Topping::create(['name' => 'Boba', 'additional_price' => 4000, 'is_active' => true]);
        $product->toppings()->attach($topping);

        $response = $this->postJson('/pesan', [
            'customer_name' => 'Nadia', 'whatsapp' => '08123456789', 'address' => 'Jakarta', 'notes' => 'Cepat ya',
            'items' => [
                ['product_id' => $product->id, 'variant_id' => $variant->id, 'topping_ids' => [$topping->id], 'quantity' => 2],
                ['product_id' => $product->id, 'variant_id' => null, 'topping_ids' => [], 'quantity' => 1],
            ],
        ]);

        $response->assertCreated()->assertJsonPath('total', 72000);
        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseHas('order_items', ['product_name' => 'Purple Latte', 'variant_name' => 'Large', 'subtotal' => 54000]);
        $this->assertDatabaseHas('order_item_toppings', ['topping_name' => 'Boba', 'topping_price' => 4000]);
    }

    public function test_checkout_rejects_out_of_stock_and_unavailable_options(): void
    {
        $category = Category::create(['name' => 'Dessert']);
        $product = Product::create(['category_id' => $category->id, 'name' => 'Waffle', 'slug' => 'waffle', 'description' => 'Test', 'price' => 10000, 'stock_status' => 'out_of_stock']);
        $this->postJson('/pesan', ['customer_name' => 'A', 'whatsapp' => '0812', 'address' => 'Alamat', 'items' => [['product_id' => $product->id, 'quantity' => 1]]])
            ->assertUnprocessable()->assertJsonValidationErrors('items');
    }
}
