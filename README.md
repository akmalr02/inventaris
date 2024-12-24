<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Laravel Inventaris

![Laravel Logo](https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg)

## Deskripsi

Laravel Inventaris adalah aplikasi web untuk manajemen inventaris barang berbasis Laravel. Aplikasi ini menggunakan JSON Web Tokens (JWT) untuk autentikasi dan menyediakan berbagai fitur manajemen barang, termasuk pengelolaan stok, pemakaian, dan laporan barang rusak.

## Fitur

-   **Autentikasi menggunakan JWT**: Menggunakan JWT untuk login dan akses aplikasi dengan token yang aman.
-   **Manajemen Barang**: Pengelolaan stok barang, pemakaian barang, dan pencatatan barang rusak.
-   **Peran Pengguna**: Tiga peran pengguna (admin, pengelola, pemakai) dengan kontrol akses yang berbeda.
-   **CRUD Barang**: Menambahkan, mengubah, dan menghapus data barang.
-   **Laporan**: Menyediakan laporan barang rusak dan pemakaian barang.

## Instalasi

1. **Clone Repository**:
    ```bash
    git clone https://github.com/username/laravel-inventaris.git
    ```
2. **Instal Dependensi**:
    ```
    cd laravel-inventaris
    composer install
    ```
3. **Konfigurasi File .env**:

    ```
    cp .env.example .env
    ```

    sesuaikan konfiguransi

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=inventaris
    DB_USERNAME=root
    DB_PASSWORD=

    ```

4. **Generate Key Aplikasi**:
    ```
    php artisan key:generate
    ```
5. **Migrasi Database**:
    ```
    php artisan migrate
    ```
