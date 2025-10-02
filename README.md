Perpustakaan Digital
Panduan untuk menginstal dan menjalankan proyek ini di lingkungan pengembangan lokal Anda.

🚀 Instalasi & Konfigurasi
Ikuti langkah-langkah berikut untuk menyiapkan proyek.

1. Clone Repositori

Pertama, clone repositori ini ke mesin lokal Anda dan masuk ke dalam direktorinya.

Bash

git clone https://github.com/RainerAdityatama/Pepustakaan-digital.git
cd Pepustakaan-digital
2. Instal Dependensi Composer

Install semua dependensi PHP yang dibutuhkan oleh proyek.

Bash

composer install
3. Konfigurasi Environment

Salin file .env.example menjadi .env. Kemudian, buka file .env dan sesuaikan konfigurasi database (DB_DATABASE, DB_USERNAME, DB_PASSWORD) dengan pengaturan lokal Anda.

Bash

cp .env.example .env
4. Generate Application Key

Buat kunci enkripsi unik untuk aplikasi Anda.

Bash

php artisan key:generate
5. Jalankan Migrasi & Seeder Database

Perintah ini akan membuat semua tabel yang diperlukan di database Anda dan mengisinya dengan data awal (jika ada).

Bash

php artisan migrate --seed
6. Jalankan Server Lokal

Sekarang, jalankan server pengembangan bawaan Laravel.

Bash

php artisan serve
Aplikasi Anda akan berjalan dan dapat diakses melalui http://127.0.0.1:8000.

👨‍💻 Membuat Pengguna Admin Pertama
Secara default, proses seeding tidak membuat akun dengan peran admin. Anda perlu membuatnya secara manual menggunakan tinker setelah instalasi selesai.

1. Jalankan Tinker

Buka command-line interface interaktif Laravel.

Bash

php artisan tinker
2. Buat Pengguna Admin

Anda bisa memilih salah satu dari dua opsi berikut:

Opsi A: Memberikan peran 'admin' ke pengguna yang sudah ada

Jika seeder sudah membuat beberapa pengguna, Anda bisa memberikan peran admin ke salah satunya (misalnya, pengguna dengan ID 1).

PHP

// Cari pengguna yang sudah ada
$user = App\Models\User::find(1);

// Berikan peran 'admin'
$user->assignRole('admin');
Opsi B: Membuat pengguna admin baru dari awal

PHP

// Buat instance user baru
$admin = App\Models\User::create([
    'name' => 'Admin User',
    'email' => 'admin@example.com',
    'password' => bcrypt('password123') // Ganti dengan password yang aman
]);

// Berikan peran 'admin' ke user yang baru dibuat
$admin->assignRole('admin');
3. Keluar dari Tinker

Setelah selesai, ketik exit dan tekan Enter untuk keluar dari sesi Tinker.

exit
Sekarang Anda dapat login menggunakan akun yang telah diberi peran admin untuk mulai mengelola aplikasi.
