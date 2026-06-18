<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Topping;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create(['is_admin' => true]));
    }

    public function test_category_crud_works(): void
    {
        $this->post('/admin/manage/categories', ['name' => 'Minuman', 'description' => 'Segar'])->assertRedirect();
        $category = Category::firstOrFail();
        $this->put('/admin/manage/categories/'.$category->id, ['name' => 'Minuman Dingin', 'description' => 'Segar'])->assertRedirect();
        $this->assertDatabaseHas('categories', ['name' => 'Minuman Dingin']);
        $this->delete('/admin/manage/categories/'.$category->id)->assertRedirect();
        $this->assertDatabaseCount('categories', 0);
    }

    public function test_topping_upload_is_stored_and_validated(): void
    {
        Storage::fake('public');
        $response = $this->post('/admin/manage/toppings', [
            'name' => 'Boba', 'additional_price' => 4000, 'is_active' => 1,
            'image' => UploadedFile::fake()->image('boba.png', 800, 800),
        ]);
        $response->assertRedirect();
        $path = Topping::firstOrFail()->image;
        Storage::disk('public')->assertExists($path);
        $this->post('/admin/manage/toppings', ['name' => 'Bad', 'additional_price' => -1])->assertSessionHasErrors('additional_price');
    }

    public function test_order_status_and_reports_work(): void
    {
        $order = Order::create(['order_number' => 'KUU-TEST', 'customer_name' => 'Nadia', 'whatsapp' => '0812', 'address' => 'Jakarta', 'total_price' => 10000, 'status' => 'pending']);
        $this->patch('/admin/orders/'.$order->id, ['status' => 'completed'])->assertRedirect();
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'completed']);
        $this->get('/admin/reports/orders')->assertOk()->assertHeader('content-type', 'application/pdf');
        $this->get('/admin/reports/products')->assertOk();
        $this->get('/admin/reports/promos')->assertOk();
    }
}
