# Rental Mobil

Aplikasi web manajemen rental mobil berbasis **Laravel 10** dengan Bootstrap 5 (Sass) dan Vue 3 (komponen DataTable, statistik dashboard, dan grafik pendapatan).

Terintegrasi penuh dengan **Supabase**:
- **Auth** — login/registrasi/lupa password memakai Supabase Auth (GoTrue), session via JWT.
- **Database** — PostgreSQL di Supabase sebagai database utama.
- **Storage** — foto mobil, bukti pembayaran, dan foto profil disimpan di Supabase Storage (endpoint S3-compatible).

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
- PostgreSQL (Supabase) atau MySQL/MariaDB (XAMPP) untuk mode lokal

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

## Integrasi Supabase

### 1. Buat project Supabase

Buka [supabase.com](https://supabase.com) → **New project**. Catat **Project Ref** (ada di URL dashboard: `https://supabase.com/dashboard/project/<project-ref>`).

### 2. Konfigurasi `.env`

Salin nilai dari **Project Settings → API** ke `.env`:

```dotenv
# Database (Project Settings → Database → Connection string)
DB_CONNECTION=pgsql
DATABASE_URL=postgresql://postgres.<project-ref>:<password>@aws-0-<region>.pooler.supabase.com:5432/postgres
# atau isi manual:
# DB_HOST=db.<project-ref>.supabase.co
# DB_PORT=5432
# DB_DATABASE=postgres
# DB_USERNAME=postgres
# DB_PASSWORD=<password-database>
DB_SSLMODE=require

# Auth (Project Settings → API)
SUPABASE_URL=https://<project-ref>.supabase.co
SUPABASE_ANON_KEY=<anon-public-key>
SUPABASE_SERVICE_ROLE_KEY=<service-role-key>
SUPABASE_JWT_SECRET=<jwt-secret>        # opsional; jika kosong, verifikasi pakai JWKS publik

# Storage (Project Settings → Storage → S3 Access Keys)
SUPABASE_S3_ACCESS_KEY=<s3-access-key>
SUPABASE_S3_SECRET_KEY=<s3-secret-key>
SUPABASE_S3_REGION=ap-northeast-2
SUPABASE_BUCKET=rental
SUPABASE_S3_ENDPOINT=https://<project-ref>.supabase.co/storage/v1/s3
SUPABASE_PUBLIC_URL=https://<project-ref>.supabase.co/storage/v1/object/public/rental
```

### 3. Jalankan migrasi

```bash
php artisan migrate
```

> Catatan: `DB_CONNECTION=mysql` untuk MySQL/XAMPP lokal tetap bisa dipakai — aplikasi otomatis memakai Supabase Auth asalkan `SUPABASE_URL` & `SUPABASE_ANON_KEY` terisi.

### 4. Siapkan Storage

1. Buat bucket bernama `rental` di **Supabase Dashboard → Storage** dengan akses **public**.
2. Buat **S3 Access Keys** di **Storage → S3 Access Keys**, tempel ke `.env` (`SUPABASE_S3_ACCESS_KEY`, `SUPABASE_S3_SECRET_KEY`).
3. Pastikan kolom `STORAGE_DISK=supabase` di `.env`.

### 5. Buat akun admin & pelanggan

Password akun dikelola oleh Supabase Auth (bukan lagi tabel lokal), jadi gunakan command ini:

```bash
php artisan supabase:create-user admin@rentalmobil.test --role=admin --name="Admin Rental"
php artisan supabase:create-user test@gmail.test --role=pelanggan --name="Test Pelanggan"
```

Command mencetak password acak ke layar (atau beri lewat `--password=...`).

### 6. (Opsional) Halaman reset password

Supabase mengirim email berisi tautan reset. Agar tautan mengarah ke aplikasi:

1. Di **Authentication → URL Configuration**, isi **Site URL** dengan URL aplikasi (mis. `http://127.0.0.1:8000`), dan **Redirect URLs** tambahkan `http://127.0.0.1:8000/password/reset/complete`.
2. Pengguna akan mengisi password baru di halaman `/password/reset/complete` aplikasi.

### 7. Deploy ke Vercel

Masukkan variabel `SUPABASE_URL`, `SUPABASE_ANON_KEY`, `SUPABASE_SERVICE_ROLE_KEY`, `DATABASE_URL` (atau `DB_HOST`/`DB_USERNAME`/`DB_PASSWORD`), dan key Storage ke **Vercel → Settings → Environment Variables** (jangan disimpan di `vercel.json` karena isi repo publik). `SESSION_DRIVER=cookie` sudah diatur agar session JWT berfungsi di serverless.

## Akun Demo

Akun demo di seeder (`password123`) **tidak bisa login** setelah beralih ke Supabase Auth karena password disimpan di Supabase. Gunakan `supabase:create-user` di atas untuk membuat akun yang bisa login.

| Peran      | Contoh perintah                          |
|------------|------------------------------------------|
| Admin      | `supabase:create-user admin@rentalmobil.test --role=admin` |
| Pelanggan  | `supabase:create-user test@gmail.test`   |

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
- Gambar upload disimpan di disk `STORAGE_DISK` (Supabase Storage bila `supabase`, atau `storage/app/public` untuk lokal). `php artisan storage:link` hanya diperlukan bila memakai disk `public`.
