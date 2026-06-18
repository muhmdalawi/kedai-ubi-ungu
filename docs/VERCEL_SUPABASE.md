# Deployment Vercel + Supabase

## 1. Siapkan Supabase

1. Buat project Supabase.
2. Dari menu **Connect**, salin connection string **Session Pooler**.
3. Dari **Storage**, buat bucket public bernama `kedai-ubi-ungu`.
4. Dari pengaturan S3 Storage, buat S3 access key dan secret key.

Gunakan Session Pooler agar koneksi database lebih cocok untuk lingkungan serverless Vercel.

## 2. Environment Variables Vercel

Tambahkan variabel berikut pada Project Settings → Environment Variables:

```env
APP_NAME=Kedai Ubi Ungu
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:HASIL_PHP_ARTISAN_KEY_GENERATE_SHOW
APP_URL=https://domain-vercel-anda.vercel.app

DB_CONNECTION=pgsql
DB_URL=postgresql://USER:PASSWORD@HOST_POOLER:5432/postgres
DB_SSLMODE=require

SESSION_DRIVER=database
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax
CACHE_STORE=database
QUEUE_CONNECTION=sync

FILESYSTEM_DISK=supabase
UPLOAD_DISK=supabase
SUPABASE_S3_ACCESS_KEY_ID=ACCESS_KEY
SUPABASE_S3_SECRET_ACCESS_KEY=SECRET_KEY
SUPABASE_S3_REGION=us-east-1
SUPABASE_S3_ENDPOINT=https://PROJECT_REF.storage.supabase.co/storage/v1/s3
SUPABASE_STORAGE_BUCKET=kedai-ubi-ungu
SUPABASE_STORAGE_PUBLIC_URL=https://PROJECT_REF.supabase.co/storage/v1/object/public/kedai-ubi-ungu

LOG_CHANNEL=stderr
LOG_LEVEL=error
```

Generate `APP_KEY` tanpa mengubah `.env`:

```bash
php artisan key:generate --show
```

## 3. Jalankan Migration ke Supabase

Sebelum website digunakan, jalankan migration dari komputer lokal dengan environment Supabase:

```bash
php artisan migrate --force
php artisan db:seed --force
```

Jangan menjalankan `migrate:fresh` pada database production karena akan menghapus seluruh data.

## 4. Deploy

Push repository ke GitHub lalu import repository tersebut ke Vercel. File `vercel.json` akan:

- Menjalankan Vite untuk menghasilkan CSS/JavaScript.
- Menyajikan isi `public` sebagai static assets.
- Menjalankan Laravel melalui `vercel-php@0.9.0`.
- Mengarahkan request dinamis ke `api/index.php`.

Deploy juga dapat dilakukan menggunakan Vercel CLI:

```bash
npx vercel
npx vercel --prod
```

## 5. Pemeriksaan Setelah Deploy

- Buka `/up` dan pastikan respons berhasil.
- Buka homepage dan pastikan CSS serta gambar `public/assets` tampil.
- Login ke `/admin/login`.
- Upload satu banner percobaan dan pastikan URL mengarah ke domain Supabase Storage.
- Buat pesanan percobaan dan pastikan data masuk ke Supabase PostgreSQL.
- Unduh laporan PDF dari admin.

## Catatan Keamanan

- Jangan menyimpan kredensial Supabase atau `APP_KEY` di repository.
- S3 secret key hanya boleh tersedia di environment server Vercel.
- Bucket upload harus public karena gambar produk ditampilkan langsung pada halaman publik.
- Ganti password admin seed sebelum website dibuka untuk umum.
