# Kedai Ubi Ungu

Website company profile, katalog, pemesanan WhatsApp, dan dashboard administrasi UMKM kuliner berbasis Laravel 13.

## Fitur

- Home, katalog dengan pencarian/filter, galeri, promo, dan kontak.
- Carousel banner autoplay yang dapat dikelola melalui CRUD admin.
- Variasi produk serta topping bergambar dengan perhitungan harga langsung.
- Keranjang multi-produk berbasis browser.
- Checkout tersimpan ke database dan diteruskan ke WhatsApp.
- Login admin manual berbasis session.
- CRUD banner, kategori, produk, topping, variasi, promo, galeri, dan testimoni.
- Pengelolaan pesanan dan lima status proses.
- Profil usaha, kontak, link serta QR Code Shopee.
- Dashboard statistik dan laporan PDF menu, pesanan, serta promo.
- Upload gambar lokal yang dikompresi ke WebP.
- Meta SEO, Open Graph, `robots.txt`, dan sitemap XML.

## Kebutuhan

- PHP 8.3 atau lebih baru beserta ekstensi PostgreSQL, GD, dan mbstring.
- Composer.
- Node.js dan npm.
- PostgreSQL.

## Instalasi Lokal

```bash
composer install
npm install
copy .env.example .env
php artisan key:generate
```

Buat database PostgreSQL bernama `kedai_ubi_ungu`, lalu sesuaikan kredensial berikut di `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=kedai_ubi_ungu
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

Siapkan database, data contoh, dan public storage:

```bash
php artisan migrate:fresh --seed
php artisan storage:link
npm run build
php artisan serve
```

Website tersedia di `http://127.0.0.1:8000`.

## Akun Admin Development

- URL: `http://127.0.0.1:8000/admin/login`
- Email: `admin@kedaiubiungu.test`
- Password: `password`

Ganti password dan seluruh data contoh sebelum digunakan di lingkungan publik.

## Menjalankan Saat Development

Terminal pertama:

```bash
php artisan serve
```

Terminal kedua:

```bash
npm run dev
```

## Pengujian

```bash
php artisan test
npm run build
php artisan route:list
```

Test otomatis menggunakan SQLite in-memory agar terisolasi. Aplikasi lokal tetap menggunakan PostgreSQL.

## Penyimpanan Gambar

- Aset bawaan berada di `public/assets`.
- Upload admin berada di `storage/app/public`.
- Jalankan `php artisan storage:link` agar upload dapat diakses melalui `/storage`.
- Upload baru diperkecil maksimal 1600 × 1600 dan dikonversi ke WebP bila GD tersedia.

## Deployment Vercel + Supabase

Project telah dilengkapi entrypoint serverless Vercel, konfigurasi runtime PHP, koneksi Supabase PostgreSQL, dan disk Supabase Storage yang kompatibel dengan S3.

Panduan lengkap terdapat di [docs/VERCEL_SUPABASE.md](docs/VERCEL_SUPABASE.md).
