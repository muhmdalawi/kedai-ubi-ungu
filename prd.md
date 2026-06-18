Berikut versi full yang sudah ditambahkan **Topping & Variasi Produk lengkap dengan foto topping**, tanpa menghilangkan bagian sebelumnya.

```markdown
# PRODUCT REQUIREMENTS DOCUMENT (PRD)
# Website Kedai Ubi Ungu

**Versi:** 1.0  
**Framework:** Laravel 12  
**Frontend:** Tailwind CSS  
**Database:** PostgreSQL (Supabase PostgreSQL)  
**Storage:** Supabase Storage  
**Hosting:** Vercel  
**Export PDF:** DomPDF  
**Authentication:** Manual Session Authentication Laravel

---

# 1. Project Overview

## Latar Belakang

Kedai Ubi Ungu merupakan UMKM kuliner yang menjual berbagai makanan dan minuman berbahan dasar ubi ungu. Saat ini sebagian besar promosi dan pemesanan masih dilakukan melalui media sosial dan WhatsApp secara manual.

Kondisi tersebut menimbulkan beberapa kendala:

- Informasi produk tidak terpusat.
- Pelanggan harus bertanya satu per satu mengenai menu dan harga.
- Pemilik usaha kesulitan mengelola promo.
- Data pesanan tidak terdokumentasi dengan baik.
- Sulit melakukan rekap penjualan dan laporan usaha.

Untuk mengatasi permasalahan tersebut, dibutuhkan website yang berfungsi sebagai:

- Company Profile
- Katalog Produk/Menu
- Sistem Pemesanan Sederhana
- Media Promosi Digital
- Dashboard Administrasi Usaha

---

# 2. Analisis Kebutuhan Bisnis UMKM Kuliner

## Gambaran Kondisi Saat Ini

Pemilik Kedai Ubi Ungu saat ini mengelola usaha secara manual melalui WhatsApp, Instagram, dan marketplace. Informasi produk biasanya dibagikan melalui chat atau posting media sosial sehingga pelanggan harus bertanya terlebih dahulu untuk mengetahui harga, stok, dan promo yang tersedia.

Pesanan pelanggan dicatat secara manual melalui WhatsApp. Cara ini cukup efektif untuk usaha kecil, namun semakin sulit dikelola ketika jumlah pelanggan meningkat karena berisiko terjadi kesalahan pencatatan, pesanan terlewat, dan kesulitan dalam melakukan rekap data.

Selain itu, promosi yang dilakukan melalui media sosial memiliki keterbatasan karena informasi lama akan tertutup oleh postingan baru sehingga pelanggan tidak selalu mendapatkan informasi terbaru mengenai produk, promo, maupun paket hemat yang sedang berlangsung.

Oleh karena itu, diperlukan website yang dapat menjadi pusat informasi resmi Kedai Ubi Ungu sekaligus membantu proses promosi dan pemesanan secara lebih terstruktur.

---

# 3. Business Goals

## Goal Utama

Meningkatkan penjualan dan promosi digital Kedai Ubi Ungu melalui website profesional yang mudah digunakan pelanggan dan mudah dikelola pemilik usaha.

## Tujuan Bisnis

### Jangka Pendek

- Menampilkan profil usaha secara profesional.
- Menampilkan katalog menu secara lengkap.
- Mempermudah pelanggan melakukan pemesanan.
- Meningkatkan kepercayaan pelanggan.

### Jangka Menengah

- Meningkatkan jumlah pesanan online.
- Memperluas jangkauan promosi.
- Mengurangi proses pencatatan manual.

### Jangka Panjang

- Menjadi pusat informasi resmi Kedai Ubi Ungu.
- Mendukung integrasi marketplace dan media sosial.
- Mendukung pengembangan usaha ke skala yang lebih besar.

---

# 4. User Roles

## 1. Pengunjung / Customer

Hak akses:

- Melihat profil usaha.
- Melihat menu.
- Melihat promo.
- Melihat galeri.
- Memilih produk.
- Memilih variasi produk.
- Memilih topping.
- Mengirim pesanan.
- Menghubungi WhatsApp.
- Mengakses Shopee.

## 2. Admin

Hak akses:

- Login sistem.
- Mengelola menu.
- Mengelola kategori.
- Mengelola topping.
- Mengelola variasi produk.
- Mengelola pesanan.
- Mengelola promo.
- Mengelola galeri.
- Mengelola testimoni.
- Mengelola profil usaha.
- Mengelola kontak.
- Mengelola link Shopee.
- Mengunduh laporan PDF.

---

# 5. Sitemap

## Frontend

Home
├── Menu
├── Delivery / Pesanan
├── Galeri
├── Promo & Informasi
└── Kontak

## Admin

Login

Dashboard
├── Menu
├── Kategori
├── Topping
├── Variasi Produk
├── Pesanan
├── Promo
├── Galeri
├── Testimoni
├── Profil Usaha
├── Kontak & Sosial Media
├── Pengaturan Shopee
└── Laporan PDF

---

# 6. User Flow

## Customer Flow

Masuk Website
↓
Lihat Menu
↓
Pilih Produk
↓
Pilih Variasi Produk
↓
Pilih Topping
↓
Isi Form Pesanan
↓
Lihat Ringkasan Pesanan
↓
Klik Pesan via WhatsApp
↓
WhatsApp Terbuka
↓
Pesanan Terkirim

## Admin Flow

Login
↓
Dashboard
↓
Kelola Data
(Menu / Kategori / Topping / Variasi / Promo / Pesanan)
↓
Simpan Perubahan
↓
Data Ditampilkan ke Website

---

# 7. Functional Requirements

# A. FRONTEND

## 7.1 Home

### Hero Banner

Menampilkan:

- Banner produk unggulan.
- Foto produk utama.
- Tombol Pesan Sekarang.
- Tombol Beli di Shopee.

### Profil Singkat

Menampilkan:

- Logo usaha.
- Nama usaha.
- Deskripsi singkat.

### Produk Best Seller

Menampilkan produk yang ditandai sebagai best seller.

### Promo Terbaru

Menampilkan promo yang sedang aktif.

### Testimoni Pelanggan

Menampilkan ulasan pelanggan.

### Statistik Usaha

Menampilkan:

- Total produk.
- Total pesanan.
- Total pelanggan.

### Call To Action

- Pesan Sekarang.
- Beli di Shopee.

---

## 7.2 Menu

### Menampilkan

- Foto produk.
- Nama produk.
- Harga.
- Deskripsi.
- Kategori.
- Pilihan topping jika tersedia.
- Foto topping.
- Pilihan variasi produk jika tersedia.

### Fitur

- Pencarian menu.
- Filter kategori.
- Label Best Seller.
- Label Promo.
- Status stok.
- Preview topping dengan foto.
- Update harga berdasarkan pilihan variasi dan topping.

### Status Stok

- Tersedia.
- Habis.

### Tombol

- Pesan Sekarang.
- Lihat di Shopee.

---

## 7.3 Delivery / Pesanan

### Form Pemesanan

Field:

- Nama pelanggan.
- Nomor WhatsApp.
- Alamat.
- Produk.
- Variasi produk.
- Topping.
- Jumlah pesanan.
- Catatan tambahan.

### Ringkasan Pesanan

Menampilkan:

- Nama produk.
- Variasi produk.
- Daftar topping.
- Harga produk.
- Harga tambahan variasi.
- Harga tambahan topping.
- Jumlah.
- Subtotal.
- Total pembayaran.

### Perhitungan Otomatis

Total dihitung secara otomatis berdasarkan produk, variasi, topping, dan jumlah pesanan.

Rumus:

(Harga Produk + Harga Variasi + Total Harga Topping) × Jumlah Pesanan

### Integrasi WhatsApp

Pesanan akan dikirim ke WhatsApp admin dengan format otomatis.

Contoh format pesan:

Halo Kedai Ubi Ungu, saya ingin memesan:

Nama:
Nomor WhatsApp:
Alamat:

Produk:
Variasi:
Topping:
Jumlah:
Catatan:

Total Pembayaran:

---

## 7.4 Galeri

Menampilkan:

- Foto produk.
- Aktivitas usaha.
- Dokumentasi kedai.

---

## 7.5 Promo & Informasi

Menampilkan:

- Promo terbaru.
- Diskon.
- Paket hemat.
- Pengumuman usaha.

---

## 7.6 Kontak

Menampilkan:

- Alamat usaha.
- Nomor WhatsApp.
- Instagram.
- Email.
- Jam operasional.
- Google Maps.
- Link Shopee.

---

# B. ADMIN PANEL

## 7.7 Login Admin

### Authentication

Menggunakan:

- Session Laravel.
- Hash Password Laravel.

### Security

- Middleware Admin.
- Session Protection.
- Logout Session.

---

## 7.8 Dashboard

### Summary Card

- Total Menu.
- Total Kategori.
- Total Topping.
- Total Pesanan.
- Total Galeri.

### Statistik

- Grafik pesanan bulanan.
- Grafik produk terlaris.
- Topping terfavorit.
- Variasi produk terfavorit.

### Informasi Cepat

- Pesanan terbaru.
- Produk terlaris.
- Promo aktif.
- Topping paling sering dipilih.

---

## 7.9 Manajemen Menu (CRUD)

Field:

- Nama produk.
- Slug.
- Harga.
- Kategori.
- Deskripsi.
- Foto produk.
- Status stok.
- Status best seller.
- Status promo.
- Link Shopee.

Fitur:

- Tambah produk.
- Edit produk.
- Hapus produk.
- Detail produk.
- Mengatur topping yang tersedia untuk produk tertentu.
- Mengatur variasi produk untuk produk tertentu.

---

## 7.10 Manajemen Pesanan (CRUD)

Field:

- Data pelanggan.
- Detail produk.
- Variasi produk.
- Topping yang dipilih.
- Total pesanan.
- Catatan pelanggan.
- Status pesanan.

Status:

- Menunggu Konfirmasi
- Diproses
- Dalam Pengiriman
- Selesai
- Dibatalkan

---

## 7.11 Manajemen Kategori Menu (CRUD)

Field:

- Nama kategori.
- Deskripsi kategori.

---

## 7.12 Manajemen Promo (CRUD)

Field:

- Judul promo.
- Banner promo.
- Deskripsi.
- Tanggal mulai.
- Tanggal selesai.
- Status aktif.

---

## 7.13 Manajemen Galeri (CRUD)

Field:

- Judul.
- Foto.
- Kategori.
- Deskripsi.

---

## 7.14 Manajemen Testimoni (CRUD)

Field:

- Nama pelanggan.
- Rating.
- Testimoni.
- Foto (opsional).

---

## 7.15 Manajemen Profil Usaha

Field:

- Nama usaha.
- Logo.
- Deskripsi.
- Sejarah singkat.
- Alamat.
- Jam operasional.

---

## 7.16 Manajemen Kontak & Sosial Media

Field:

- WhatsApp.
- Instagram.
- Email.
- Google Maps.
- Link Shopee.

---

## 7.17 Pengaturan Shopee

Fitur:

- Mengubah link Shopee utama.
- Mengubah link Shopee tiap produk.
- Menampilkan QR Code Shopee.

---

## 7.18 Laporan PDF

Menggunakan DomPDF.

### Laporan Menu

Menampilkan:

- Nama produk.
- Harga.
- Kategori.

### Laporan Pesanan

Menampilkan:

- Nama pelanggan.
- Produk.
- Variasi produk.
- Topping.
- Jumlah.
- Total.
- Status.

### Laporan Promo

Menampilkan:

- Promo aktif.
- Periode promo.

---

## 7.19 Manajemen Topping & Variasi Produk (CRUD)

### Tujuan

Memungkinkan pelanggan menambahkan topping atau memilih variasi produk saat melakukan pemesanan.

Fitur ini penting karena produk makanan dan minuman seperti Es Ubi Ungu, Purple Latte, Ubi Boba, Dessert Box Ubi Ungu, dan menu lainnya biasanya memiliki pilihan tambahan yang dapat memengaruhi harga.

### Contoh Produk

Produk:

- Es Ubi Ungu

Topping:

- Keju (+Rp3.000)
- Boba (+Rp4.000)
- Oreo (+Rp2.000)
- Cokelat (+Rp2.000)

Variasi Produk:

- Regular
- Large (+Rp5.000)

### Field Topping

- Nama topping.
- Foto topping.
- Harga tambahan.
- Status aktif.

### Field Variasi Produk

- Nama variasi.
- Harga tambahan.
- Status aktif.

### Contoh Data Topping

Nama Topping: Keju  
Foto: keju.jpg  
Harga Tambahan: Rp3.000  
Status: Aktif

Nama Topping: Boba  
Foto: boba.jpg  
Harga Tambahan: Rp4.000  
Status: Aktif

Nama Topping: Oreo  
Foto: oreo.jpg  
Harga Tambahan: Rp2.000  
Status: Aktif

### Fitur Admin Topping

Admin dapat:

- Menambah topping.
- Mengubah topping.
- Menghapus topping.
- Mengunggah foto topping.
- Mengatur harga tambahan topping.
- Mengaktifkan atau menonaktifkan topping.
- Menentukan topping yang tersedia pada produk tertentu.

### Fitur Admin Variasi Produk

Admin dapat:

- Menambah variasi produk.
- Mengubah variasi produk.
- Menghapus variasi produk.
- Mengatur harga tambahan variasi.
- Mengaktifkan atau menonaktifkan variasi.
- Menentukan variasi untuk produk tertentu.

### Fitur Customer

Customer dapat:

- Melihat daftar topping.
- Melihat foto topping.
- Memilih satu atau lebih topping.
- Memilih variasi produk.
- Melihat perubahan harga secara otomatis.
- Melihat topping dan variasi pada ringkasan pesanan.

### Perhitungan Harga

Rumus:

(Harga Produk + Harga Variasi + Total Harga Topping) × Jumlah Pesanan

Contoh:

Produk: Es Ubi Ungu  
Harga Dasar: Rp15.000  
Variasi: Large (+Rp5.000)  
Topping: Boba (+Rp4.000)  
Topping: Keju (+Rp3.000)  
Jumlah: 1

Total:

(Rp15.000 + Rp5.000 + Rp4.000 + Rp3.000) × 1 = Rp27.000

### Alasan Bisnis

Fitur topping dan variasi produk membuat sistem lebih sesuai dengan kebutuhan UMKM kuliner karena:

- Pelanggan bisa menyesuaikan pesanan.
- Produk terlihat lebih menarik.
- Peluang upselling meningkat.
- Admin lebih mudah mengatur tambahan produk.
- Harga pesanan dapat dihitung lebih akurat.
- Foto topping membantu pelanggan memahami pilihan topping yang tersedia.

---

# 8. Non Functional Requirements

## Performance

- Waktu loading kurang dari 3 detik.
- Optimasi gambar otomatis.
- Gambar produk dan topping dikompresi agar tidak memperlambat website.

## Security

- CSRF Protection.
- Input Validation.
- Session Authentication.
- Password Hashing.
- Validasi file upload.
- Pembatasan ukuran file gambar.

## Scalability

- Struktur modular Laravel.
- Mudah dikembangkan.
- Relasi produk, topping, dan variasi dibuat fleksibel.

## Availability

- Deploy di Vercel.
- Database Supabase PostgreSQL.
- Gambar disimpan menggunakan Supabase Storage.

## Responsive

- Desktop.
- Tablet.
- Mobile.

## SEO

- Meta Title.
- Meta Description.
- Open Graph.
- Sitemap XML.

---

# 9. Database Design

## users

- id
- name
- email
- password
- created_at
- updated_at

## categories

- id
- name
- description
- created_at
- updated_at

## products

- id
- category_id
- name
- slug
- description
- price
- image
- stock_status
- is_best_seller
- is_promo
- shopee_link
- created_at
- updated_at

## toppings

- id
- name
- image
- additional_price
- is_active
- created_at
- updated_at

## product_toppings

- id
- product_id
- topping_id
- created_at
- updated_at

## product_variants

- id
- product_id
- variant_name
- additional_price
- is_active
- created_at
- updated_at

## orders

- id
- customer_name
- whatsapp
- address
- total_price
- status
- notes
- created_at
- updated_at

## order_items

- id
- order_id
- product_id
- product_variant_id
- quantity
- price
- variant_price
- subtotal

## order_item_toppings

- id
- order_item_id
- topping_id
- topping_name
- topping_price
- created_at
- updated_at

## promos

- id
- title
- banner
- description
- start_date
- end_date
- is_active

## galleries

- id
- title
- image
- category
- description

## testimonials

- id
- customer_name
- rating
- testimonial
- photo

## business_profiles

- id
- business_name
- logo
- description
- address
- operational_hours

## contacts

- id
- whatsapp
- instagram
- email
- maps_link
- shopee_link

---

# 10. ERD Concept

Categories
│
└── Products
      │
      ├── Product Variants
      │
      ├── Product Toppings >── Toppings
      │
      └── Order Items
              │
              ├── Order Item Toppings
              │
              └── Orders

Products
│
└── Promo

Business Profile
│
└── Contact

Gallery

Testimonials

Users

---

# 11. Frontend Workflow

Admin Input Data
↓
Database
↓
Frontend Menampilkan Data
↓
Customer Melihat Produk
↓
Customer Memilih Variasi Produk
↓
Customer Memilih Topping
↓
Customer Mengisi Form Pesanan
↓
Sistem Menghitung Total Otomatis
↓
WhatsApp Terbuka
↓
Pesanan Dikirim

---

# 12. Admin Workflow

Login
↓
Dashboard
↓
Kelola Produk
↓
Kelola Kategori
↓
Kelola Topping
↓
Kelola Variasi Produk
↓
Kelola Promo
↓
Kelola Pesanan
↓
Kelola Galeri
↓
Kelola Profil
↓
Generate PDF
↓
Monitoring Usaha

---

# 13. Acceptance Criteria

## Home

✅ Hero banner tampil

✅ Produk best seller tampil

✅ Promo tampil

✅ Testimoni tampil

## Menu

✅ Search berjalan

✅ Filter kategori berjalan

✅ Status stok tampil

✅ Pilihan topping tampil

✅ Foto topping tampil

✅ Pilihan variasi produk tampil

✅ Harga berubah sesuai topping dan variasi

## Pesanan

✅ Total otomatis dihitung

✅ Ringkasan pesanan tampil

✅ Variasi produk tampil di ringkasan

✅ Topping tampil di ringkasan

✅ WhatsApp terbuka otomatis

## Admin

✅ Login berhasil

✅ Session berjalan

✅ Middleware berjalan

✅ Semua CRUD berjalan

✅ CRUD topping berjalan

✅ CRUD variasi produk berjalan

✅ Upload foto topping berjalan

## PDF

✅ Export Menu PDF

✅ Export Pesanan PDF

✅ Export Promo PDF

## Storage

✅ Upload gambar produk menggunakan Supabase Storage

✅ Upload gambar topping menggunakan Supabase Storage

✅ Upload gambar galeri menggunakan Supabase Storage

## Deployment

✅ Website berjalan di Vercel

---

# 14. Development Roadmap

## Phase 1 - Foundation

- Setup Laravel 12
- Setup PostgreSQL
- Setup Supabase
- Setup Supabase Storage
- Setup Tailwind CSS
- Setup Authentication Manual

## Phase 2 - Master Data

- Kategori
- Produk
- Topping
- Variasi Produk
- Profil Usaha
- Kontak

## Phase 3 - Frontend

- Home
- Menu
- Galeri
- Promo
- Kontak
- Tampilan pilihan topping
- Tampilan pilihan variasi produk

## Phase 4 - Pemesanan

- Form Pesanan
- Pilihan Produk
- Pilihan Variasi Produk
- Pilihan Topping
- Ringkasan Pesanan
- Perhitungan Total Otomatis
- WhatsApp Integration
- Status Pesanan

## Phase 5 - Dashboard Admin

- Statistik
- Grafik Pesanan
- Produk Terlaris
- Topping Terfavorit
- Variasi Produk Terfavorit

## Phase 6 - Reporting

- DomPDF
- Export Menu
- Export Pesanan
- Export Promo

## Phase 7 - Deployment

- Supabase PostgreSQL
- Supabase Storage
- Vercel Production

---

# Fitur Tambahan yang Direkomendasikan

## Produk Terlaris Otomatis

Sistem menghitung produk terlaris berdasarkan jumlah pesanan sehingga admin tidak perlu mengatur secara manual.

## Topping Terfavorit Otomatis

Sistem menghitung topping yang paling sering dipilih pelanggan sehingga admin dapat mengetahui topping yang paling diminati.

## Variasi Produk Terfavorit Otomatis

Sistem menghitung variasi produk yang paling banyak dipilih, seperti Regular atau Large.

## Banner Promo Terjadwal

Promo aktif dan nonaktif otomatis berdasarkan tanggal.

## QR Code Shopee

Memudahkan pelanggan menuju marketplace.

## Dashboard Grafik Penjualan

Membantu pemilik usaha melihat perkembangan usaha.

## Stok Minimum Alert

Memberikan notifikasi stok hampir habis.

## SEO Management

Meningkatkan visibilitas website di mesin pencari.

## Visitor Counter

Menampilkan jumlah pengunjung website untuk kebutuhan analisis sederhana.

## Backup Database Berkala

Membantu menjaga keamanan data usaha apabila terjadi masalah pada sistem.
```
