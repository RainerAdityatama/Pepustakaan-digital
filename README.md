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

### Panduan Instalasi & Konfigurasi

Untuk menjalankan proyek ini di lingkungan lokal Anda, ikuti langkah-langkah berikut:

Baik, saya paham. Anda ingin formatnya lebih ringkas dan seragam, di mana setiap judul langkah langsung diikuti oleh blok kodenya, tanpa ada teks penjelasan tambahan di antaranya.

Ini adalah format yang telah direvisi sesuai dengan preferensi Anda. Anda bisa langsung menyalin dan menempelkan seluruh kode ini ke dalam file `README.md` Anda di GitHub.

### Panduan Instalasi & Konfigurasi

Untuk menjalankan proyek ini di lingkungan lokal Anda, ikuti langkah-langkah berikut:

**1. Clone Repositori & Masuk ke Direktori**
```bash
git clone [https://github.com/RainerAdityatama/Pepustakaan-digital.git](https://github.com/RainerAdityatama/Pepustakaan-digital.git) && cd Pepustakaan-digital
````

**2. Install Dependensi Composer**

```bash
composer install
```

**3. Konfigurasi Environment**

```bash
cp .env.example .env
```

*(Catatan: Setelah menjalankan perintah ini, jangan lupa untuk mengedit file `.env` dan mengisi detail database Anda: DB\_DATABASE, DB\_USERNAME, DB\_PASSWORD).*

**4. Generate Application Key**

```bash
php artisan key:generate
```

**5. Jalankan Migrasi & Seeder Database**

```bash
php artisan migrate --seed
```

**6. Jalankan Server Lokal**

```bash
php artisan serve
```

### Membuat Pengguna Admin Pertama

Proses *seeding* tidak membuat akun admin secara otomatis. Ikuti langkah ini untuk membuatnya secara manual.

**1. Jalankan Tinker**

```bash
php artisan tinker
```

**2. Buat Pengguna Admin**

Pilih salah satu dari dua opsi berikut:

  * **Opsi A: Memberikan peran 'admin' ke pengguna yang sudah ada**

    ```php
    $user = App\Models\User::find(1);
    $user->assignRole('admin');
    ```

  * **Opsi B: Membuat pengguna admin baru dari awal**

    ```php
    $admin = App\Models\User::create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => bcrypt('password123')
    ]);
    $admin->assignRole('admin');
    ```

**3. Keluar dari Tinker**

```bash
exit
```

```
```
