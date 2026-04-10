# Distanbun V2 - Sistem Informasi Inventaris Barang

<p align="center"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo"></p>

## Tentang Proyek
Distanbun V2 adalah aplikasi berbasis web untuk manajemen inventaris barang, mencakup pencatatan barang masuk, barang keluar, serta sistem peminjaman dan pengembalian barang.

## Struktur Folder View
Untuk meningkatkan kerapian dan kemudahan navigasi, struktur folder view telah diatur ulang menjadi:
- `resources/views/admin/`: Halaman untuk fungsionalitas Administrator.
- `resources/views/user/`: Halaman untuk fungsionalitas Pengguna Umum (termasuk Landing Page).
- `resources/views/layouts/`: Template layout utama.
- `resources/views/components/`: Komponen Blade yang dapat digunakan kembali.

## Instalasi dan Pengembangan Lokal

### Prasyarat
- [Laragon](https://laragon.org/download/) (Direkomendasikan)
- [Composer](https://getcomposer.org/)
- [Node.js & NPM](https://nodejs.org/)

### Langkah Instalasi
1.  **Clone Repositori**:
    ```bash
    git clone [url-repositori]
    cd distanbunV2
    ```
2.  **Instal Dependensi PHP**:
    ```bash
    composer install
    ```
3.  **Instal Dependensi Frontend**:
    ```bash
    npm install
    ```
4.  **Konfigurasi Environment**:
    - Salin file `.env.example` menjadi `.env`.
    - Buat database baru di MySQL (via Laragon/phpMyAdmin) dengan nama `distanbun_v2`.
    - Sesuaikan `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` di file `.env`.
5.  **Generate Key**:
    ```bash
    php artisan key:generate
    ```
6.  **Migrasi Database**:
    ```bash
    php artisan migrate
    ```
7.  **Menjalankan Aplikasi**:
    - Jalankan server Laravel: `php artisan serve`
    - Jalankan Vite: `npm run dev`

## Integrasi MySQL dengan Laragon
1. Buka Laragon, klik **Start All**.
2. Klik tombol **Database** untuk membuka phpMyAdmin atau HeidiSQL.
3. Buat database baru bernama `distanbun_v2`.
4. Pastikan file `.env` sudah mengarah ke database tersebut.
5. Jalankan `php artisan migrate` untuk membuat tabel-tabel yang diperlukan.

## Informasi Detail
Untuk informasi lebih mendalam mengenai fitur dan teknologi, silakan baca [INFO.md](INFO.md).

Admin: admindistanbun@gmail.com (password: admin123)
User: userdistanbun@gmail.com (password: user123)