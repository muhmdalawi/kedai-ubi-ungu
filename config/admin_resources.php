<?php

use App\Models\Category;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Promo;
use App\Models\Testimonial;
use App\Models\Topping;

return [
    'categories' => [
        'label' => 'Kategori', 'model' => Category::class, 'search' => ['name', 'description'],
        'fields' => [
            'name' => ['label' => 'Nama kategori', 'type' => 'text', 'rules' => ['required', 'string', 'max:100']],
            'description' => ['label' => 'Deskripsi', 'type' => 'textarea', 'rules' => ['nullable', 'string', 'max:1000']],
        ],
    ],
    'products' => [
        'label' => 'Produk', 'model' => Product::class, 'search' => ['name', 'description'], 'with' => ['category', 'toppings'],
        'fields' => [
            'category_id' => ['label' => 'Kategori', 'type' => 'select', 'model' => Category::class, 'option' => 'name', 'rules' => ['required', 'exists:categories,id']],
            'name' => ['label' => 'Nama produk', 'type' => 'text', 'rules' => ['required', 'string', 'max:150']],
            'slug' => ['label' => 'Slug (otomatis jika kosong)', 'type' => 'text', 'rules' => ['nullable', 'string', 'max:170']],
            'price' => ['label' => 'Harga dasar', 'type' => 'number', 'rules' => ['required', 'integer', 'min:0']],
            'description' => ['label' => 'Deskripsi', 'type' => 'textarea', 'rules' => ['required', 'string', 'max:3000']],
            'image' => ['label' => 'Foto produk', 'type' => 'image', 'rules' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096']],
            'stock_status' => ['label' => 'Status stok', 'type' => 'select_static', 'options' => ['available' => 'Tersedia', 'out_of_stock' => 'Habis'], 'rules' => ['required', 'in:available,out_of_stock']],
            'is_best_seller' => ['label' => 'Best seller', 'type' => 'boolean', 'rules' => ['boolean']],
            'is_promo' => ['label' => 'Label promo', 'type' => 'boolean', 'rules' => ['boolean']],
            'shopee_link' => ['label' => 'Link Shopee', 'type' => 'url', 'rules' => ['nullable', 'url', 'max:1000']],
            'topping_ids' => ['label' => 'Topping tersedia', 'type' => 'multiselect', 'model' => Topping::class, 'option' => 'name', 'relation' => 'toppings', 'rules' => ['nullable', 'array'], 'item_rules' => ['integer', 'exists:toppings,id']],
        ],
    ],
    'toppings' => [
        'label' => 'Topping', 'model' => Topping::class, 'search' => ['name'],
        'fields' => [
            'name' => ['label' => 'Nama topping', 'type' => 'text', 'rules' => ['required', 'string', 'max:120']],
            'additional_price' => ['label' => 'Harga tambahan', 'type' => 'number', 'rules' => ['required', 'integer', 'min:0']],
            'image' => ['label' => 'Foto topping', 'type' => 'image', 'rules' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096']],
            'is_active' => ['label' => 'Aktif', 'type' => 'boolean', 'rules' => ['boolean']],
        ],
    ],
    'variants' => [
        'label' => 'Variasi Produk', 'model' => ProductVariant::class, 'search' => ['variant_name'], 'with' => ['product'],
        'fields' => [
            'product_id' => ['label' => 'Produk', 'type' => 'select', 'model' => Product::class, 'option' => 'name', 'rules' => ['required', 'exists:products,id']],
            'variant_name' => ['label' => 'Nama variasi', 'type' => 'text', 'rules' => ['required', 'string', 'max:120']],
            'additional_price' => ['label' => 'Harga tambahan', 'type' => 'number', 'rules' => ['required', 'integer', 'min:0']],
            'is_active' => ['label' => 'Aktif', 'type' => 'boolean', 'rules' => ['boolean']],
        ],
    ],
    'promos' => [
        'label' => 'Promo', 'model' => Promo::class, 'search' => ['title', 'description'],
        'fields' => [
            'title' => ['label' => 'Judul promo', 'type' => 'text', 'rules' => ['required', 'string', 'max:180']],
            'description' => ['label' => 'Deskripsi', 'type' => 'textarea', 'rules' => ['required', 'string', 'max:3000']],
            'banner' => ['label' => 'Banner', 'type' => 'image', 'rules' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096']],
            'start_date' => ['label' => 'Tanggal mulai', 'type' => 'date', 'rules' => ['required', 'date']],
            'end_date' => ['label' => 'Tanggal selesai', 'type' => 'date', 'rules' => ['required', 'date', 'after_or_equal:start_date']],
            'is_active' => ['label' => 'Aktif', 'type' => 'boolean', 'rules' => ['boolean']],
        ],
    ],
    'galleries' => [
        'label' => 'Galeri', 'model' => Gallery::class, 'search' => ['title', 'category', 'description'],
        'fields' => [
            'title' => ['label' => 'Judul', 'type' => 'text', 'rules' => ['required', 'string', 'max:180']],
            'category' => ['label' => 'Kategori', 'type' => 'text', 'rules' => ['required', 'string', 'max:100']],
            'description' => ['label' => 'Deskripsi', 'type' => 'textarea', 'rules' => ['nullable', 'string', 'max:2000']],
            'image' => ['label' => 'Foto', 'type' => 'image', 'rules' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096']],
        ],
    ],
    'testimonials' => [
        'label' => 'Testimoni', 'model' => Testimonial::class, 'search' => ['customer_name', 'testimonial'],
        'fields' => [
            'customer_name' => ['label' => 'Nama pelanggan', 'type' => 'text', 'rules' => ['required', 'string', 'max:120']],
            'rating' => ['label' => 'Rating', 'type' => 'number', 'rules' => ['required', 'integer', 'between:1,5']],
            'testimonial' => ['label' => 'Testimoni', 'type' => 'textarea', 'rules' => ['required', 'string', 'max:2000']],
            'photo' => ['label' => 'Foto (opsional)', 'type' => 'image', 'rules' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096']],
        ],
    ],
];
