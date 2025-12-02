<p align="center">
  <a href="#" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300">
  </a>
</p>

<h2 align="center">Laravel Pengadaan Barang</h2>

<p align="center">
Sistem manajemen pengadaan barang modern berbasis <strong>Laravel</strong> dan <strong>Livewire</strong>, dilengkapi dengan alur pengajuan, verifikasi, dan kontrol admin.
</p>

---

## **Deskripsi Singkat**

Aplikasi ini merupakan sistem pengelolaan proses pengadaan barang berbasis **Laravel + Livewire**.  
Fitur inti meliputi autentikasi role, pengajuan pengadaan barang oleh staff, verifikasi oleh manager, manajemen data oleh admin, serta upload dokumen pendukung.

Aplikasi dirancang dengan UI modern, validasi real-time, dan notifikasi interaktif menggunakan **SweetAlert2** untuk memberikan pengalaman pengguna yang lebih responsif.

---

## **Fitur Utama**

- **Authentication System (Role: Admin, Manager, Staff)**
- **Edit Profile + Upload Foto**
- **Manajemen Barang & Kategori**
- **Pengajuan Pengadaan Barang (Staff)**
- **Verifikasi Pengadaan (Manager)**
- **Status Pengadaan (Pending, Review, Approved, Rejected)**
- **Livewire Real-Time Validation**
- **UI Interaktif dengan SweetAlert2**
- **Upload File (Foto Profil, Lampiran, Bukti Pengadaan)**
- **Notifikasi Toast Success**
- **Dashboard Berbasis Role**

---

## 🛠 **Teknologi yang Digunakan**

- **Laravel 12**
- **Livewire v3**
- **MySQL / MariaDB**
- **Blade Template**
- **SweetAlert2**
- **Bootstrap**

---

## ⚙️ **Cara Instalasi Project**

### 1. Clone repository
```bash
git clone https://github.com/username/nama-project.git
cd nama-project
```

### 2. Install dependencies
```bash
composer install
```

### 3. Copy file environment
```bash
cp .env.example .env
```

### 4. Generate key
```bash
php artisan key:generate
```

### 5. Atur konfigurasi database di file .env
```
DB_DATABASE=pengadaan_barang
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Jalankan migrasi
```bash
php artisan migrate
```

### 7. Link storage
```bash
php artisan storage:link
```

### 8. Jalankan Seeder
```bash
php artisan db:seed --class=UserSeeder
```

---

## ▶️ **Cara Menjalankan Project**

### Jalankan server Laravel
```bash
php artisan serve
```

### Buka di browser
```
http://localhost:8000
```
