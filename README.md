# Perpustakaan Digital

Selamat datang di repositori Perpustakaan Digital! Ini adalah projek aplikasi manajemen perpustakaan digital yang dibangun menggunakan Laravel. Aplikasi ini dirancang untuk mengelola seluruh proses sirkulasi buku, mulai dari manajemen data buku, peminjaman, pengembalian, hingga pengelolaan denda.

Proyek ini dirancang dengan sistem hak akses berbasis peran, di mana terdapat tiga jenis pengguna: **Admin**, **Pustakawan**, dan **User (Peminjam)**, masing-masing dengan dashboard dan fungsionalitas yang disesuaikan untuk kebutuhannya.

### Fitur Utama

🔐 **Otentikasi & Hak Akses Berbasis Peran**: Sistem login yang aman dengan tiga level pengguna:
- **Admin**: Dapat mengelola semua data pengguna (Pustakawan dan User).
- **Pustakawan**: Mengelola data master seperti buku, kategori, dan memvalidasi sirkulasi peminjaman & pengembalian.
- **User**: Dapat melihat daftar buku dan riwayat peminjaman pribadi.

📚 **Manajemen Data Master (CRUD)**: Fungsionalitas penuh untuk Create, Read, Update, dan Delete oleh Pustakawan untuk data-data inti perpustakaan, meliputi:
- Manajemen Buku
- Manajemen Kategori Buku
- Manajemen Stok Buku

🔄 **Manajemen Sirkulasi**: Fitur utama untuk operasional perpustakaan yang dikelola oleh Pustakawan, mencakup:
- Manajemen Peminjaman Buku
- Proses Pengembalian Buku
- Pengelolaan dan Perhitungan Denda Keterlambatan

### Teknologi yang Digunakan

- **PHP / Laravel 11**
- **Tailwind CSS** (untuk styling pada bagian UI)
- **Vite** (untuk kompilasi aset frontend)
- **MySQL** (Sebagai database)

### Panduan Instalasi & Konfigurasi

Untuk menjalankan proyek ini di lingkungan lokal Anda, ikuti langkah-langkah berikut:

**1. Clone Repositori & Masuk ke Direktori**
```bash
git clone [https://github.com/RainerAdityatama/Pepustakaan-digital.git](https://github.com/RainerAdityatama/Pepustakaan-digital.git) && cd Pepustakaan-digital

2. Install Dependensi Composer

Bash

composer install
3. Konfigurasi Environment
Salin file .env.example menjadi .env. Kemudian, lakukan konfigurasi database (DB_DATABASE, DB_USERNAME, DB_PASSWORD) di dalam file .env.

Bash

cp .env.example .env
4. Generate Application Key

Bash

php artisan key:generate
5. Jalankan Migrasi & Seeder Database
Perintah ini akan membuat semua tabel database dan mengisinya dengan data awal.

Bash

php artisan migrate --seed
6. Jalankan Server Lokal

Bash

php artisan serve
Aplikasi akan berjalan di http://127.0.0.1:8000.

Membuat Pengguna Admin Pertama
Proyek ini tidak secara otomatis membuat akun dengan peran 'admin' saat proses seeding. Anda perlu membuatnya secara manual melalui Tinker setelah instalasi selesai.

1. Jalankan Tinker

Bash

php artisan tinker
2. Buat Pengguna Admin

Anda bisa memilih salah satu dari dua cara berikut:

Opsi A: Memberikan peran 'admin' ke pengguna yang sudah ada (jika seeder membuat pengguna)

PHP

// Cari pengguna yang sudah ada (misalnya, user dengan ID 1)
$user = App\Models\User::find(1);

// Berikan peran 'admin'
$user->assignRole('admin');
Opsi B: Membuat pengguna admin baru dari awal

PHP

// Buat user baru
$admin = App\Models\User::create([
    'name' => 'Admin User',
    'email' => 'admin@example.com',
    'password' => bcrypt('password123')
]);

// Berikan peran 'admin'
$admin->assignRole('admin');
3. Keluar dari Tinker
Setelah selesai, ketik exit dan tekan Enter.

exit
Sekarang Anda memiliki satu pengguna dengan peran 'admin' dan dapat login untuk mulai mengelola aplikasi.