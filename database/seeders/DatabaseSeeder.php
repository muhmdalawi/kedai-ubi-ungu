<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\BusinessProfile;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Gallery;
use App\Models\Order;
use App\Models\OrderItem;
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

        $bannerContent = [
            ['Dari Kebun ke Meja Anda', 'Kreasi ubi ungu premium yang dibuat segar setiap hari dengan bahan pilihan.', 'Lihat Menu', '/menu'],
            ['Rasakan Manisnya Purple Week', 'Nikmati menu favorit dengan promo spesial untuk momen yang lebih hangat.', 'Lihat Promo', '/promo'],
            ['Camilan Ungu, Mood Jadi Baru', 'Temukan dessert, minuman, dan camilan unik untuk menemani harimu.', 'Pesan Sekarang', '/menu'],
            ['Dibuat dengan Hangat', 'Setiap pesanan diracik penuh perhatian dari dapur Kedai Ubi Ungu.', 'Tentang Kedai', '/kontak'],
            ['Pilih Variasi Favoritmu', 'Regular atau Large, lengkap dengan topping yang bisa kamu kombinasikan sendiri.', 'Racik Menu', '/menu'],
            ['Momen Manis Bersama', 'Kedai Ubi Ungu hadir untuk teman ngobrol, keluarga, dan perayaan kecilmu.', 'Lihat Galeri', '/galeri'],
            ['Mudah Dipesan, Siap Dinikmati', 'Masukkan menu ke keranjang dan kirim pesanan langsung melalui WhatsApp.', 'Mulai Pesan', '/pesan'],
        ];
        foreach ($bannerContent as $index => [$title, $subtitle, $buttonText, $buttonUrl]) {
            Banner::updateOrCreate(['sort_order' => $index + 1], [
                'title' => $title,
                'subtitle' => $subtitle,
                'image' => 'assets/banner/banner-' . ($index + 1) . '.png',
                'button_text' => $buttonText,
                'button_url' => $buttonUrl,
                'is_active' => true,
            ]);
        }

        $categories = collect([
            ['name' => 'Makanan', 'description' => 'Aneka makanan dan camilan berbahan dasar ubi ungu.'],
            ['name' => 'Minuman', 'description' => 'Minuman segar khas ubi ungu.'],
            ['name' => 'Topping', 'description' => 'Pilihan topping tambahan untuk menu Kedai Ubi Ungu.'],
        ])->mapWithKeys(fn($data) => [$data['name'] => Category::updateOrCreate(['name' => $data['name']], $data)]);

        $products = [
            ['Makanan', 'Lumpia Ubi Ungu Coklat Lumer', 'lumpia-ubi-ungu-coklat-lumer', 10000, 'product-5.png', 'Lumpia ubi ungu dengan isian coklat lumer, harga 10k isi 3 pcs.', true, false],
            ['Makanan', 'Lumpia Ubi Ungu Keju Lumer', 'lumpia-ubi-ungu-keju-lumer', 10000, 'product-5.png', 'Lumpia ubi ungu dengan isian keju lumer, harga 10k isi 3 pcs.', true, false],
            ['Makanan', 'Lumpia Ubi Ungu Mozarella', 'lumpia-ubi-ungu-mozarella', 12000, 'product-5.png', 'Lumpia ubi ungu dengan isian mozarella, harga 12k isi 3 pcs.', true, false],

            ['Makanan', 'Bola-Bola Ubi Ungu Coklat Lumer', 'bola-bola-ubi-ungu-coklat-lumer', 10000, 'product-2.png', 'Bola-bola ubi ungu dengan isian coklat lumer, harga 10k isi 3 pcs.', true, false],
            ['Makanan', 'Bola-Bola Ubi Ungu Keju Lumer', 'bola-bola-ubi-ungu-keju-lumer', 10000, 'product-2.png', 'Bola-bola ubi ungu dengan isian keju lumer, harga 10k isi 3 pcs.', true, false],
            ['Makanan', 'Bola-Bola Ubi Ungu Mozarella', 'bola-bola-ubi-ungu-mozarella', 10000, 'product-2.png', 'Bola-bola ubi ungu dengan isian mozarella, harga 10k isi 3 pcs.', false, false],

            ['Makanan', 'Gabin Ubi Ungu', 'gabin-ubi-ungu', 3000, 'product-4.png', 'Gabin renyah dengan isian ubi ungu, tersedia harga satuan 3k atau 10k isi 4 pcs.', true, false],

            ['Minuman', 'Es Ubi Ungu Original 380ml', 'es-ubi-ungu-original-380ml', 7000, 'product-3.png', 'Es ubi ungu original ukuran 380ml.', true, false],
            ['Minuman', 'Es Ubi Ungu Original 400ml', 'es-ubi-ungu-original-400ml', 8000, 'product-3.png', 'Es ubi ungu original ukuran 400ml.', true, false],
            ['Minuman', 'Es Ubi Ungu Topping Keju', 'es-ubi-ungu-topping-keju', 10000, 'product-3.png', 'Es ubi ungu dengan topping keju.', true, true],
            ['Minuman', 'Es Ubi Ungu Original 500ml', 'es-ubi-ungu-original-500ml', 10000, 'product-3.png', 'Es ubi ungu original ukuran 500ml.', false, false],
            ['Minuman', 'Es Ubi Ungu 500ml Topping Keju', 'es-ubi-ungu-500ml-topping-keju', 12000, 'product-3.png', 'Es ubi ungu ukuran 500ml dengan topping keju.', false, true],

            ['Makanan', 'Roti Goyeng Original', 'roti-goyeng-original', 10000, 'product-6.png', 'Roti goyeng original dengan 1 pilihan topping.', true, false],
            ['Makanan', 'Roti Goyeng Pistachio', 'roti-goyeng-pistachio', 13000, 'product-6.png', 'Roti goyeng original dengan topping pistachio.', false, true],
            ['Makanan', 'Roti Goyeng Mozarella', 'roti-goyeng-mozarella', 12000, 'product-6.png', 'Roti goyeng mozarella dengan 1 pilihan topping.', false, false],

            ['Makanan', 'Gabin Fla Coklat', 'gabin-fla-coklat', 10000, 'product-1.png', 'Gabin fla coklat dengan tambahan topping.', false, true],
            ['Makanan', 'Gabin Fla Vanila', 'gabin-fla-vanila', 10000, 'product-1.png', 'Gabin fla vanila dengan tambahan topping.', false, true],
        ];

        $savedProducts = collect();
        foreach ($products as [$category, $name, $slug, $price, $image, $description, $best, $promo]) {
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

        $toppingNames = ['Bubuk Ubi', 'Keju Parut', 'Boba', 'Oreo Crumb', 'Saus Cokelat', 'Krim Keju', 'Kacang Pistachio', 'Berry Kering', 'Caramel', 'Whipped Cream', 'Choco Chips', 'Matcha Crumb', 'Susu Kental', 'Almond Slice'];
        $toppings = collect();
        foreach ($toppingNames as $index => $name) {
            $toppings->push(Topping::updateOrCreate(['name' => $name], [
                'image' => 'assets/topping/topping-' . ($index + 1) . '.png',
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

        $customerNames = [
            'Andi', 'Budi', 'Citra', 'Dewi', 'Eka', 'Fajar', 'Gita', 'Hana',
            'Indra', 'Joko', 'Karin', 'Lina', 'Maya', 'Nadia', 'Oki', 'Putri',
            'Raka', 'Salsa', 'Tia', 'Vina', 'Wahyu', 'Yani', 'Zaki', 'Rizky',
        ];
        $statuses = ['completed', 'completed', 'completed', 'completed', 'processing', 'shipping', 'pending'];
        $demoOrders = [];
        $orderCount = 1248;
        $customerCount = 864;

        for ($index = 1; $index <= $orderCount; $index++) {
            $customerIndex = ($index - 1) % $customerCount;
            $product = $savedProducts[($index - 1) % $savedProducts->count()];
            $quantity = 1 + ($index % 4);
            $variantPrice = $index % 3 === 0 ? 5000 : 0;
            $createdAt = now()
                ->subMonths(($index - 1) % 12)
                ->subDays(($index * 7) % 25)
                ->setTime(8 + ($index % 12), ($index * 13) % 60);

            $demoOrders[] = [
                'order_number' => 'KUU-DEMO-'.str_pad((string) $index, 4, '0', STR_PAD_LEFT),
                'customer_name' => $customerNames[$customerIndex % count($customerNames)].' '.str_pad((string) ($customerIndex + 1), 3, '0', STR_PAD_LEFT),
                'whatsapp' => '62813'.str_pad((string) ($customerIndex + 1), 8, '0', STR_PAD_LEFT),
                'address' => 'Pelanggan demo wilayah Jakarta dan sekitarnya',
                'total_price' => ($product->price + $variantPrice) * $quantity,
                'status' => $statuses[$index % count($statuses)],
                'notes' => 'Data demo untuk statistik website.',
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];
        }

        foreach (array_chunk($demoOrders, 250) as $chunk) {
            Order::upsert($chunk, ['order_number'], [
                'customer_name', 'whatsapp', 'address', 'total_price', 'status',
                'notes', 'created_at', 'updated_at',
            ]);
        }

        $demoOrderIds = Order::where('order_number', 'like', 'KUU-DEMO-%')->pluck('id');
        OrderItem::whereIn('order_id', $demoOrderIds)->delete();

        $ordersByNumber = Order::where('order_number', 'like', 'KUU-DEMO-%')
            ->get(['id', 'order_number'])
            ->keyBy('order_number');
        $variants = $savedProducts->mapWithKeys(fn ($product) => [
            $product->id => $product->variants()->get()->keyBy('variant_name'),
        ]);
        $demoItems = [];

        foreach ($demoOrders as $index => $orderData) {
            $product = $savedProducts[$index % $savedProducts->count()];
            $quantity = 1 + (($index + 1) % 4);
            $variantName = ($index + 1) % 3 === 0 ? 'Large' : 'Regular';
            $variant = $variants[$product->id][$variantName];
            $variantPrice = $variant->additional_price;

            $demoItems[] = [
                'order_id' => $ordersByNumber[$orderData['order_number']]->id,
                'product_id' => $product->id,
                'product_variant_id' => $variant->id,
                'product_name' => $product->name,
                'variant_name' => $variantName,
                'quantity' => $quantity,
                'price' => $product->price,
                'variant_price' => $variantPrice,
                'subtotal' => ($product->price + $variantPrice) * $quantity,
                'notes' => null,
                'created_at' => $orderData['created_at'],
                'updated_at' => $orderData['updated_at'],
            ];
        }

        foreach (array_chunk($demoItems, 250) as $chunk) {
            OrderItem::insert($chunk);
        }

        Promo::updateOrCreate(['title' => 'Menu Favorit Pelanggan, Wajib Dicoba!'], [
            'banner' => 'assets/promo/promo-1.png',
            'description' => 'Temukan produk best seller Kedai Ubi Ungu mulai dari Es Ubi Ungu, Lumpia Ubi Ungu, hingga Bola-Bola Ubi Ungu yang selalu menjadi pilihan pelanggan.',
            'start_date' => now()->subDays(7),
            'end_date' => now()->addMonths(3),
            'is_active' => true,
        ]);
        Promo::updateOrCreate(['title' => 'Bebas Pilih Topping Sesukamu'], [
            'banner' => 'assets/promo/promo-2.png',
            'description' => 'Lengkapi pesanan dengan berbagai pilihan topping favorit seperti keju, oreo, almond, pistachio, meses, dan masih banyak lagi.',
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

        foreach (
            [
                ['Nadia Putri', 5, 'Purple Latte-nya creamy dan tidak terlalu manis. Favorit!'],
                ['Rizky Pratama', 5, 'Bola ubi isi kejunya lumer, pesan lagi pasti.'],
                ['Salsa Aulia', 4, 'Kemasan rapi, produk datang hangat dan rasanya unik.'],
            ] as [$name, $rating, $text]
        ) {
            Testimonial::updateOrCreate(['customer_name' => $name], compact('rating') + ['testimonial' => $text]);
        }

        BusinessProfile::updateOrCreate(['id' => 1], [
            'business_name' => 'Kedai Ubi Ungu',
            'logo' => 'assets/logo/logo-1.png',
            'description' => 'Kedai Ubi Ungu adalah usaha kuliner yang menyediakan aneka makanan, camilan, dan minuman berbahan dasar ubi ungu dengan rasa manis, lembut, dan cocok dinikmati kapan saja.',
            'history' => 'Kedai Ubi Ungu hadir dari ide sederhana untuk mengolah ubi ungu menjadi produk kuliner yang unik, enak, dan mudah dinikmati oleh semua kalangan.',
            'address' => 'Jl. Labu depan LSM, Jl. H. Murtado tikungan depan Niceso',
            'operational_hours' => 'Setiap hari, selama persediaan masih ada',
        ]);

        Contact::updateOrCreate(['id' => 1], [
            'whatsapp' => '6288808759491',
            'instagram' => 'https://instagram.com/kedaiubiungu',
            'email' => 'kedaiubiungu@gmail.com',
            'maps_link' => 'https://maps.google.com/',
            'shopee_link' => 'https://shopee.co.id/universal-link/now-food/shop/23128297?deep_and_deferred=1&shareChannel=whatsapp',
        ]);
    }
}
