<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ResourceController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Promo;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/menu', [CatalogController::class, 'index'])->name('menu.index');
Route::get('/menu/{product:slug}', [CatalogController::class, 'show'])->name('menu.show');
Route::get('/api/products/{product}/configuration', [CatalogController::class, 'configuration'])->name('products.configuration');
Route::get('/pesan', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/pesan', [CheckoutController::class, 'store'])->middleware('throttle:20,1')->name('checkout.store');
Route::view('/kontak', 'public.contact')->name('contact');
Route::get('/galeri', fn () => view('public.gallery', ['galleries' => Gallery::latest()->paginate(12)]))->name('gallery');
Route::get('/promo', fn () => view('public.promos', ['promos' => Promo::latest()->paginate(9)]))->name('promos');
Route::get('/sitemap.xml', function () {
    $urls = collect([route('home'), route('menu.index'), route('checkout.index'), route('gallery'), route('promos'), route('contact')])
        ->merge(Product::pluck('slug')->map(fn ($slug) => route('menu.show', $slug)));

    return response()->view('sitemap', compact('urls'))->header('Content-Type', 'application/xml');
})->name('sitemap');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'create'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'store'])->name('admin.login.store');
});

Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/receipt', [OrderController::class, 'receipt'])->name('orders.receipt');
    Route::patch('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::get('/reports/products', [ReportController::class, 'products'])->name('reports.products');
    Route::get('/reports/orders', [ReportController::class, 'orders'])->name('reports.orders');
    Route::get('/reports/promos', [ReportController::class, 'promos'])->name('reports.promos');
    Route::get('/manage/{resource}', [ResourceController::class, 'index'])->name('resources.index');
    Route::get('/manage/{resource}/create', [ResourceController::class, 'create'])->name('resources.create');
    Route::post('/manage/{resource}', [ResourceController::class, 'store'])->name('resources.store');
    Route::get('/manage/{resource}/{record}/edit', [ResourceController::class, 'edit'])->name('resources.edit');
    Route::put('/manage/{resource}/{record}', [ResourceController::class, 'update'])->name('resources.update');
    Route::delete('/manage/{resource}/{record}', [ResourceController::class, 'destroy'])->name('resources.destroy');
});
