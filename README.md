
# Abakura - Sistem Manajemen Bengkel

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://i.pinimg.com/originals/0b/18/d7/0b18d74a360882472be99d2ad8e9d966.gif" width="200" alt="Abakura Logo">
  </a>
</p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## 📌 Tentang Abakura

**Abakura** adalah sistem manajemen bengkel berbasis web yang dibuat menggunakan **Laravel**, dengan autentikasi menggunakan **Breeze** dan tampilan menggunakan **Tailwind CSS**. Sistem ini memudahkan pengelolaan booking kendaraan, riwayat servis, dan monitoring status perbaikan.

## 🚀 Tools yang Digunakan

- **Laravel** - Framework PHP untuk backend
- **Laravel Breeze** - Sistem autentikasi sederhana dan ringan
- **Tailwind CSS** - Framework CSS untuk tampilan yang responsif dan modern
- **Vite** - Build tool untuk optimasi frontend

## 🔧 Instalasi

1. **Clone repository ini**
   ```bash
   git clone https://github.com/nltrouz/bengkel.git
   cd abakura
   ```
2. **Install dependensi**
   ```bash
   composer install
   npm install
   ```
3. **Buat file konfigurasi**
   ```bash
   cp .env.example .env
   ```
4. **Generate aplikasi key**
   ```bash
   php artisan key:generate
   ```
5. **Setup database**
   - Atur koneksi database di file `.env`
   - Jalankan migrasi:
     ```bash
     php artisan migrate --seed
     ```
6. **Jalankan server**
   ```bash
   php artisan serve
   npm run dev
   ```
