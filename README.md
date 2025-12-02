🛒 Project Pengadaan Barang – Laravel & Livewire
<p align="center"> <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300"> </p> <h2 align="center">Sistem Pengadaan Barang • Laravel 12 + Livewire 3</h2>
📘 Deskripsi Singkat

Sistem Pengadaan Barang ini merupakan aplikasi manajemen proses pengadaan berbasis Laravel dan Livewire.
Aplikasi ini dirancang untuk mendukung alur kerja pengajuan barang oleh staff, verifikasi oleh manager, hingga pengelolaan data secara menyeluruh oleh admin.

Sistem dilengkapi antarmuka modern, validasi real-time, serta notifikasi interaktif untuk meningkatkan efisiensi dan ketepatan proses pengadaan.

🛠 Teknologi yang Digunakan

Laravel 12

Livewire 3

Blade Template

Bootstrap

MySQL / MariaDB

SweetAlert2

⭐ Fitur Utama
🔐 1. Sistem Autentikasi Terintegrasi

Login & register

Pembagian role otomatis: Admin, Manager, Staff

Proteksi akses halaman

👤 2. Modul Pengelolaan Profil Pengguna

Edit profil

Upload foto profil

Validasi real-time

📦 3. Sistem Manajemen Inventaris

CRUD data barang

CRUD kategori barang

Tabel dengan pencarian & filter

📝 4. Modul Pengajuan Pengadaan Barang (Staff)

Pengajuan resmi pengadaan barang

Form dinamis Livewire

Tambah beberapa item sekaligus

📋 5. Fitur Multi-Item Request

Input banyak item dalam satu pengajuan

Tanpa reload halaman

✔️ 6. Workspace Verifikasi Pengadaan (Manager)

Peninjauan pengajuan

Persetujuan atau penolakan

Pemberian catatan verifikasi

🔄 7. Pemantauan Status Pengadaan

Tracking status: Pending, Completed, Approved, Rejected

Riwayat status per pengajuan

🗂 8. Pusat Kontrol Administrator

Pengelolaan data user, barang, kategori, dan pengadaan

Manajemen alur proses pengadaan

📤 9. Sistem Unggah Dokumen

Upload bukti pengadaan

Upload lampiran pendukung

Penyimpanan file aman

⚡ 10. Validasi Real-Time Berbasis Livewire

Validasi saat mengetik

Error ditampilkan langsung

🎨 11. Notifikasi Interaktif

SweetAlert2 untuk notifikasi sukses, gagal, dan konfirmasi

📊 12. Dashboard Berbasis Role

Dashboard Staff → buat pengajuan

Dashboard Manager → verifikasi pengajuan

Dashboard Admin → kelola seluruh data


⚙️ Cara Instalasi

Clone Repository

git clone https://github.com/username/nama-project.git
cd nama-project


Install Dependency

composer install


Copy File Environment

cp .env.example .env


Generate Key

php artisan key:generate


Atur Database di .env

DB_DATABASE=pengadaan-barang
DB_USERNAME=root
DB_PASSWORD=


Migrate Database

php artisan migrate


Link Storage

php artisan storage:link

▶️ Cara Menjalankan Project

Jalankan Server Laravel

php artisan serve


Buka Browser

http://localhost:8000

📄 Lisensi

Proyek ini dibuat untuk kebutuhan pembelajaran dan pengembangan internal.
Bisa dimodifikasi sesuai kebutuhan.
