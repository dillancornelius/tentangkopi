# Tentang Kopi

Website pemesanan kedai kopi: pelanggan menelusuri menu, mengisi keranjang, memesan, dan memantau status pesanan. Admin mengelola menu, pengguna, dan pesanan lewat panel terpisah.

> Dibangun dengan Laravel 11, PostgreSQL, dan front-end tanpa framework JavaScript.

## Fitur

**Pelanggan**
- Beranda, halaman menu dengan pencarian, filter kategori, dan pengurutan harga atau nama
- Keranjang berupa drawer (tanpa muat ulang halaman) yang tersimpan di session, termasuk untuk tamu
- Checkout dengan data pengiriman (wajib login), pembayaran di tempat
- Riwayat pesanan dengan status yang diperbarui otomatis, detail pesanan, dan tombol "Pesan lagi"
- Ulasan pelanggan (tulis, ubah, hapus ulasan milik sendiri)
- Profil: ubah data akun, ganti password, hapus akun (dengan konfirmasi password)

**Admin**
- Dashboard: pesanan dan pendapatan hari ini, pesanan menunggu konfirmasi, jumlah menu dan pelanggan
- Pesanan: filter per status, lihat item dan alamat, ubah status
- Menu: tambah, ubah, hapus, unggah gambar
- Pengguna: tambah, ubah, hapus, atur role (dengan pengaman agar admin tidak menurunkan atau menghapus akunnya sendiri)

## Teknologi

| Bagian | Pilihan |
|---|---|
| Backend | PHP 8.2+, Laravel 11 |
| Database | PostgreSQL (pencarian memakai `ILIKE`) |
| Front-end | Blade (komponen anonim), CSS murni, JavaScript murni (ES modules) |
| Build aset | Vite |
| Font | Font bawaan sistem |

## Persyaratan

- PHP 8.2 atau lebih baru dengan ekstensi `pdo_pgsql`, `mbstring`, `xml`, `fileinfo`
- Composer 2
- PostgreSQL 13+
- Node.js 18+ dan npm (hanya untuk membangun ulang CSS dan JS)

## Instalasi

```bash
git clone https://github.com/dillancornelius/tentangkopi.git
cd tentangkopi

composer install
cp .env.example .env
php artisan key:generate
```

Atur koneksi database di `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=tentang_kopi
DB_USERNAME=postgres
DB_PASSWORD=

# Opsional, untuk akun admin dari seeder
ADMIN_EMAIL=admin@example.com
ADMIN_PASSWORD=ganti-dengan-password-kuat
```

Lanjutkan:

```bash
php artisan migrate --seed      # membuat tabel, kategori, menu, dan akun admin
php artisan storage:link        # agar gambar menu hasil unggahan bisa diakses
npm install
npm run build                   # untuk pemakaian biasa
php artisan serve
```

Buka http://127.0.0.1:8000.

Jika `ADMIN_PASSWORD` dikosongkan, seeder membuat password acak dan menampilkannya **sekali** di terminal. Catat password itu. Admin masuk lewat halaman login biasa dan otomatis diarahkan ke `/admin/dashboard`.

### Mode pengembangan

```bash
php artisan serve
npm run dev        # Vite dev server (hot reload)
```

Setelah selesai, hentikan `npm run dev` dan hapus `public/hot` jika tertinggal, lalu jalankan `npm run build`.

## Struktur kode

```
app/
├── Actions/PlaceOrder.php          # membuat pesanan dalam satu transaksi
├── Enums/                          # UserRole, OrderStatus (label dan warna badge)
├── Http/
│   ├── Controllers/                # controller pelanggan; Admin/ untuk panel admin
│   ├── Middleware/                 # EnsureAdmin, RedirectAdminToDashboard
│   └── Requests/                   # validasi (FormRequest)
├── Models/                         # Eloquent: User, Menu, Order, OrderItem, Review, dst.
├── Policies/                       # otorisasi pesanan dan ulasan
├── Services/CartService.php        # satu-satunya tempat logika keranjang dan total
└── Support/Format.php              # format rupiah
config/cafe.php                     # nama, alamat, ongkir, pajak, kartu beranda, admin seeder
lang/id/                            # pesan validasi dan autentikasi (Indonesia)
resources/
├── css/                            # base, components, site, admin
├── js/                             # ui.js (interaksi umum), cart.js (keranjang)
└── views/
    ├── components/                 # layouts, form, icon, menu-card, status-badge
    ├── partials/                   # header, footer, cart-drawer
    └── ...                         # halaman: home, menu, checkout, orders, profile, admin
```

## Keputusan desain

- **Keranjang disimpan sebagai `[menu_id => jumlah]` di session.** Harga selalu dibaca dari database saat ditampilkan dan saat checkout, jadi tidak pernah basi.
- **`order_items` menyimpan snapshot** nama dan harga saat pesanan dibuat. Mengubah atau menghapus menu tidak mengubah riwayat pesanan (`menu_id` menjadi `NULL` jika menu dihapus).
- **Uang dalam rupiah bulat** (tanpa sen). Pajak dan ongkir diatur di `config/cafe.php`.
- **Waktu disimpan UTC**, ditampilkan dalam zona `Asia/Jakarta` (`config/cafe.php`).
- **Otorisasi lewat Policy**, bukan pengecekan manual di setiap controller.
- **Logika bisnis dipisah dari controller**: `CartService` untuk keranjang, `PlaceOrder` untuk pembuatan pesanan.
- **Status pesanan** didefinisikan sekali di `OrderStatus`, dipakai oleh validasi, tampilan, dan filter admin.

## Keamanan

- Password di-hash otomatis (cast `hashed`), session diregenerasi saat login dan daftar, dan session dibatalkan saat logout
- Login dibatasi 5 percobaan per kombinasi email dan IP
- Validasi input lewat FormRequest, termasuk validasi tipe dan ukuran gambar unggahan
- Pesanan dan ulasan hanya bisa diakses pemiliknya (Policy)
- Hapus akun mewajibkan konfirmasi password, ganti password mewajibkan password saat ini
- Area admin dilindungi middleware `auth` dan `admin`

## Rute utama

| URL | Keterangan |
|---|---|
| `/` | Beranda |
| `/menu` | Daftar menu (`?search=`, `?subcategory=`, `?sort=`) |
| `/about-us` | Tentang kami |
| `/reviews` | Ulasan pelanggan |
| `/checkout` | Checkout (login) |
| `/orders`, `/orders/{id}` | Riwayat dan detail pesanan (login) |
| `/profile` | Profil (login) |
| `/cart` (JSON) | Endpoint keranjang yang dipakai JavaScript |
| `/admin/dashboard` | Dashboard admin |
| `/admin/orders` | Kelola pesanan |
| `/admin/menus`, `/admin/users` | Kelola menu dan pengguna |

## Kustomisasi

Ubah nama, alamat, nomor telepon, tautan sosial media, pajak, ongkir, dan kartu kategori beranda di `config/cafe.php`. Warna dan token desain ada di `resources/css/base.css`. Gambar menu bawaan ada di `public/assets/menu/{Nama Menu}.png`. Menu yang ditambah admin bisa mengunggah gambarnya sendiri.