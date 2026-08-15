# Rental Mobil

Aplikasi web manajemen rental mobil berbasis **Laravel 10** dengan Bootstrap 5 (Sass) dan Vue 3 (komponen DataTable, statistik dashboard, dan grafik pendapatan).

## Fitur

### Publik (Pelanggan)
- Beranda dengan daftar mobil, statistik, dan grafik pendapatan
- Halaman daftar mobil + pencarian + halaman detail
- Pemesanan (booking) dengan cek tanggal — anti double-booking
- Konfirmasi pembayaran dengan upload bukti (gambar)
- Melihat, membatalkan, dan mengecek status pesanan sendiri
- Halaman kontak (pesan tersimpan ke admin)

### Admin
- Dashboard statistik (jumlah mobil, pesanan, pendapatan, dll.)
- CRUD data mobil (dengan preview gambar), pengguna, transaksi, pengembalian
- Detail transaksi + konfirmasi pembayaran dari sisi admin
- Pengembalian otomatis menyelesaikan transaksi (status `selesai`) dan mengubah status mobil menjadi `tersedia`
- Kotak masuk pesan kontak (dengan badge belum dibaca)
- Cetak laporan / bukti sewa (PDF via DomPDF)
- Pengaturan aplikasi (tarif denda, dll.)

### Siklus status transaksi
`pending` → `lunas` → `selesai` (atau `batal`)

- **pending** — menunggu pembayaran; pelanggan dapat mengunggah bukti pembayaran
- **lunas** — pembayaran sudah dikonfirmasi, mobil disewa
- **selesai** — mobil dikembalikan dan pengembalian dicatat
- **batal** — pemesanan dibatalkan

## Persyaratan

- PHP ≥ 8.1
- Composer
- Node.js ≥ 18
- MySQL / MariaDB (XAMPP disarankan)

## Instalasi

```bash
# 1. Salin konfigurasi dan buat kunci aplikasi
cp .env.example .env
php artisan key:generate

# 2. Atur koneksi database di .env
#    DB_DATABASE=rental_mobil, DB_USERNAME=root, DB_PASSWORD=

# 3. Install dependensi
composer install
npm install

# 4. Buat database lalu jalankan migrasi + seeder
php artisan migrate --seed

# 5. Build aset frontend
npm run build

# 6. Jalankan server
php artisan serve
```

Akses aplikasi di `http://127.0.0.1:8000`.

## Akun Demo (password: `password123`)

| Peran      | Email                    |
|------------|--------------------------|
| Admin      | `admin@rentalmobil.test` |
| Pelanggan  | `test@gmail.test`        |

## Struktur Penting

```
app/
  Contracts/Repositories/   # kontrak repository
  Repositories/             # implementasi repository (Query Builder)
  Services/                 # logika bisnis (TransaksiService, PublicService, dll.)
  Http/Controllers/
database/
  migrations/
  seeders/                  # MobilSeeder, DemoDataSeeder
resources/
  js/components/            # Vue: DataTable, DashboardStats, RevenueChart
  sass/app.scss             # seluruh gaya aplikasi
  views/                    # Blade (layouts.admin / layouts.public)
routes/web.php
```

## Catatan

- `resources/css/app.css` dihapus; seluruh gaya di `resources/sass/app.scss`.
- Rute API/Sanctum tidak dipakai dan sudah dihapus.
- Gambar upload disimpan di `storage/app/public` (baca selengkapnya di `config/filesystems.php`), dan `php artisan storage:link` harus dijalankan sekali.
