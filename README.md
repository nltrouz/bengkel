Berikut adalah README untuk proyek bengkel **Abakura**, yang dibangun menggunakan Laravel, Breeze, dan Tailwind CSS.

---

# Abakura - Sistem Manajemen Bengkel

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://instagram.fjog1-1.fna.fbcdn.net/v/t51.2885-19/435102845_1451276282145176_6585258867859699327_n.jpg?stp=dst-jpg_s150x150_tt6&_nc_ht=instagram.fjog1-1.fna.fbcdn.net&_nc_cat=108&_nc_oc=Q6cZ2QF48qu-50kPOIqM-jiuzmDBXIoUYwp0gf1ynKctQWBX2iWTEFG_-1JZdTku7T7Vfag&_nc_ohc=RlGY4Ris1A4Q7kNvgGu27Ay&_nc_gid=fOW5I8ozDznk62oMncclPQ&edm=APoiHPcBAAAA&ccb=7-5&oh=00_AYG248BV-uBRv7moqdbY9m0qjTC5vEjniqXU-hMjmpFjLA&oe=67E15EC1&_nc_sid=22de04" width="200" alt="Abakura Logo">
  </a>
</p>

## 📌 Tentang Abakura

**Abakura** adalah sistem manajemen bengkel berbasis web yang dibuat menggunakan **Laravel**, dengan autentikasi menggunakan **Breeze** dan tampilan menggunakan **Tailwind CSS**. Sistem ini memudahkan pengelolaan booking kendaraan, riwayat servis, dan monitoring status perbaikan.

## 🚀 Teknologi yang Digunakan

- **Laravel** - Framework PHP untuk backend
- **Laravel Breeze** - Sistem autentikasi sederhana dan ringan
- **Tailwind CSS** - Framework CSS untuk tampilan yang responsif dan modern
- **Vite** - Build tool untuk optimasi frontend

## 🔧 Instalasi

1. **Clone repository ini**
   ```bash
   git clone https://github.com/username/abakura.git
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
   ``
