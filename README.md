# ☕ KedaiSeduh

**Platform Pemesanan Menu & Reservasi Meja Cafe — Bertema Premium Dark**

KedaiSeduh adalah aplikasi web untuk menemukan cafe, memesan menu secara online, dan melakukan reservasi meja. Dibangun dengan **Laravel 11** dan antarmuka *premium dark* yang elegan, ringan, dan sepenuhnya responsif. Aplikasi ini menerapkan **Role-Based Access Control (RBAC)** dengan tiga jenis pengguna: Customer, Vendor, dan Admin.

> Mata Kuliah Pemrograman Web — Tugas Besar

---

## 🌟 Fitur Utama

### 👤 Customer (Pelanggan)
- Menjelajahi daftar cafe yang tersedia beserta detailnya (alamat, deskripsi, jam operasional, fasilitas, galeri).
- Melihat menu beserta status ketersediaan dan kategori.
- Menambahkan menu ke **keranjang** dan melakukan **checkout**.
- Pembayaran fleksibel: **Tunai (cash)** atau **QRIS** (simulasi scan).
- **Reservasi meja** (booking) dengan pilihan jumlah orang & catatan.
- Melacak **riwayat & status pesanan**, konfirmasi selesai, dan mengirim komplain.

### 🏪 Vendor (Pemilik Cafe)
- **Dashboard** ringkasan (total pesanan, pesanan baru, pesanan dibayar, total menu).
- **Kelola Menu** (CRUD) lengkap dengan harga, kategori, gambar, dan status.
- **Kelola Pesanan** masuk + update status + tampilkan QRIS.
- **Kelola Reservasi/Booking** (konfirmasi / tolak).
- **Kelola Meja** (CRUD) dengan kapasitas orang.
- **Kelola Profil Cafe & Galeri** + toggle status Buka/Tutup.

### 🛡️ Admin (Administrator)
- **Dashboard analitik** (jumlah vendor aktif/pending, jumlah customer, statistik & pendapatan per cafe).
- **Approve / Reject** pendaftaran cafe baru.
- Memantau seluruh **transaksi & booking** (dengan filter & pencarian).
- **Suspend / aktifkan** akun customer.
- **Manajemen laporan/komplain** dari pengguna.

---

## 🎨 Desain

- Tema **Premium Dark** — latar espresso gelap dengan aksen emas hangat (*gold/amber*), tipografi **Playfair Display** (judul) + **Inter** (teks).
- 100% **Mobile Responsive** (sidebar hamburger untuk panel Vendor & Admin).
- Mikro-interaksi: password visibility, tombol loading state, hover elegan, sticky navigation.

---

## 🛠️ Teknologi

| Lapisan | Teknologi |
|--------|-----------|
| Backend | PHP 8.2, **Laravel 11** (MVC, Query Builder) |
| Frontend | Blade, **Tailwind CSS** (CDN), Vanilla JS |
| Database | **MySQL** / MariaDB |
| Chart | Chart.js |
| Ikon & Font | Font Awesome 6, Google Fonts |

---

## 🚀 Cara Instalasi (Local Development)

Pastikan sudah terpasang **PHP 8.2+**, **Composer**, dan **MySQL** (disarankan pakai [Laragon](https://laragon.org/)).

```bash
# 1. Clone repository
git clone https://github.com/USERNAME-KAMU/kedaiseduh.git
cd kedaiseduh

# 2. Install dependency
composer install

# 3. Siapkan file environment
cp .env.example .env
php artisan key:generate

# 4. Buat database kosong bernama "kedaiseduh" di MySQL/phpMyAdmin,
#    lalu sesuaikan konfigurasi DB di file .env bila perlu.

# 5. Jalankan migrasi + data awal (seeder)
php artisan migrate --seed

# 6. Jalankan server
php artisan serve
```

Buka **http://localhost:8000** di browser.

> Jika memakai Laragon, cukup akses `http://kedaiseduh.test` (pretty URL) setelah menjalankan langkah 1–5.

---

## 🔑 Akun Demo

Semua akun memakai password: **`password`**

| Role | Email | Keterangan |
|------|-------|-----------|
| Admin | `admin@kedaiseduh.test` | Panel admin |
| Vendor | `vendor1@kedaiseduh.test` | Pemilik cafe **Seduh Senja** |
| Vendor | `vendor2@kedaiseduh.test` | Pemilik cafe **Nocturnal Brew** |
| Vendor | `vendor3@kedaiseduh.test` | Vendor baru (belum punya cafe — untuk demo setup) |
| Customer | `budi@kedaiseduh.test` | Pelanggan |
| Customer | `ayu@kedaiseduh.test` | Pelanggan |

---

## 🗂️ Struktur Database (ringkas)

`users` · `cafe` · `cafe_table` · `menu` · `gallery` · `transaksi` · `transaksi_detail` · `booking` · `reports`

Seluruh skema dibuat melalui **migration** dan diisi otomatis melalui **seeder**, sehingga aplikasi langsung siap dipakai setelah `php artisan migrate --seed`.

---

## 👨‍💻 Author

- **[Nama Lengkap Kamu]** — **[NIM]**

Program Studi Informatika · Fakultas Ilmu Komputer · Universitas Mercu Buana
