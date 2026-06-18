<?php

namespace Database\Seeders;

use App\Models\BusinessProfile;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Promo;
use App\Models\Testimonial;
use App\Models\Topping;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@kedaiubiungu.test'],
            ['name' => 'Admin Kedai Ubi Ungu', 'password' => Hash::make('password'), 'is_admin' => true],
        );

        $categories = collect([
            ['name' => 'Dessert', 'description' => 'Kreasi pencuci mulut berbahan ubi ungu.'],
            ['name' => 'Minuman', 'description' => 'Minuman segar dan creamy khas ubi ungu.'],
            ['name' => 'Camilan', 'description' => 'Camilan gurih dan manis untuk segala suasana.'],
        ])->mapWithKeys(fn ($data) => [$data['name'] => Category::updateOrCreate(['name' => $data['name']], $data)]);

        $products = [
            ['Dessert', 'Waffle Ubi Cokelat', 'waffle-ubi-cokelat', 26000, 'product-1.png', 'Waffle renyah dengan krim ubi ungu lembut dan saus cokelat premium.', true, true],
            ['Camilan', 'Bola Ubi Isi', 'bola-ubi-isi', 22000, 'product-2.png', 'Bola ubi ungu renyah dengan pilihan isian keju atau cokelat lumer.', true, false],
            ['Minuman', 'Purple Latte', 'purple-latte', 18000, 'product-3.png', 'Minuman ubi ungu creamy dengan foam susu yang lembut dan menyegarkan.', true, true],
            ['Camilan', 'Cracker Ubi', 'cracker-ubi', 20000, 'product-4.png', 'Cracker berlapis krim ubi ungu, ringan dan cocok untuk teman minum.', false, false],
            ['Dessert', 'Roll Ubi Isi', 'roll-ubi-isi', 24000, 'product-5.png', 'Pastry roll berisi ubi ungu dengan pilihan saus lumer favorit.', false, true],
            ['Camilan', 'Toast Ubi Keju', 'toast-ubi-keju', 23000, 'product-6.png', 'Roti panggang dengan selai ubi ungu dan keju mozzarella yang gurih.', true, false],
        ];

        $savedProducts = collect();
        foreach ($products as [$category,$name,$slug,$price,$image,$description,$best,$promo]) {
            $savedProducts->push(Product::updateOrCreate(['slug' => $slug], [
                'category_id' => $categories[$category]->id,
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'image' => "assets/product/{$image}",
                'stock_status' => 'available',
                'is_best_seller' => $best,
                'is_promo' => $promo,
                'shopee_link' => 'https://shopee.co.id/',
            ]));
        }

        $toppingNames = ['Bubuk Ubi', 'Keju Parut', 'Boba', 'Oreo Crumb', 'Saus Cokelat', 'Krim Keju', 'Kacang Pistachio', 'Berry Kering', 'Caramel', 'Whipped Cream', 'Choco Chips', 'Matcha Crumb', 'Susu Kental', 'Almond Slice', 'Golden Sprinkle'];
        $toppings = collect();
        foreach ($toppingNames as $index => $name) {
            $toppings->push(Topping::updateOrCreate(['name' => $name], [
                'image' => 'assets/topping/topping-'.($index + 1).'.png',
                'additional_price' => 2000 + (($index % 4) * 1000),
                'is_active' => true,
            ]));
        }

        foreach ($savedProducts as $index => $product) {
            $product->toppings()->sync($toppings->slice($index * 2, 6)->pluck('id')->all());
            foreach ([['Regular', 0], ['Large', 5000]] as [$name, $price]) {
                $product->variants()->updateOrCreate(['variant_name' => $name], ['additional_price' => $price, 'is_active' => true]);
            }
        }

        Promo::updateOrCreate(['title' => 'Purple Week'], [
            'banner' => 'assets/banner/banner-2.png',
            'description' => 'Nikmati harga spesial untuk pilihan menu best seller selama Purple Week.',
            'start_date' => now()->subDays(7),
            'end_date' => now()->addMonths(3),
            'is_active' => true,
        ]);
        Promo::updateOrCreate(['title' => 'Paket Nongkrong Hemat'], [
            'banner' => 'assets/banner/banner-3.png',
            'description' => 'Paket camilan dan Purple Latte untuk dinikmati bersama.',
            'start_date' => now()->subDay(),
            'end_date' => now()->addMonths(2),
            'is_active' => true,
        ]);

        foreach (range(1, 7) as $number) {
            Gallery::updateOrCreate(['title' => "Cerita Kedai {$number}"], [
                'image' => "assets/banner/banner-{$number}.png",
                'category' => $number <= 3 ? 'Produk' : 'Aktivitas Kedai',
                'description' => 'Dokumentasi kreasi dan kegiatan Kedai Ubi Ungu.',
            ]);
        }

        foreach ([
            ['Nadia Putri', 5, 'Purple Latte-nya creamy dan tidak terlalu manis. Favorit!'],
            ['Rizky Pratama', 5, 'Bola ubi isi kejunya lumer, pesan lagi pasti.'],
            ['Salsa Aulia', 4, 'Kemasan rapi, produk datang hangat dan rasanya unik.'],
        ] as [$name,$rating,$text]) {
            Testimonial::updateOrCreate(['customer_name' => $name], compact('rating') + ['testimonial' => $text]);
        }

        BusinessProfile::updateOrCreate(['id' => 1], [
            'business_name' => 'Kedai Ubi Ungu',
            'logo' => 'assets/logo/logo-4.png',
            'description' => 'Kreasi makanan dan minuman premium berbahan ubi ungu, dibuat segar untuk menghadirkan rasa hangat di setiap gigitan.',
            'history' => 'Berawal dari dapur rumahan pada 2024, Kedai Ubi Ungu tumbuh dari kecintaan pada bahan lokal menjadi dessert cafe dengan aneka kreasi modern.',
            'address' => 'Jl. Contoh Kuliner No. 24, Jakarta',
            'operational_hours' => 'Senin–Minggu, 09.00–21.00 WIB',
        ]);

        Contact::updateOrCreate(['id' => 1], [
            'whatsapp' => '6281234567890',
            'instagram' => 'https://instagram.com/kedaiubiungu',
            'email' => 'halo@kedaiubiungu.test',
            'maps_link' => 'https://maps.google.com/',
            'shopee_link' => 'https://shopee.co.id/',
        ]);
    }
}
