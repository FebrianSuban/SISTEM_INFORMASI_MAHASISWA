# TUGAS 
# SOFTWARE QUALITY ASSURANCE DAN LEGAL
## SISTEM INFORMASI MAHASISWA INSTITUT DIGITAL EKONOMI LPKIA

## Dokumentasi lengkap untuk menjalankan, mengembangkan, dan men-deploy aplikasi "Sistem Informasi Biodata Mahasiswa".

## 🎥 Demo Aplikasi
![Demo Aplikasi](Demo.gif)

Ringkasan singkat
- Framework: Laravel (PHP)
- Frontend: Blade + Tailwind CSS
- DB: MySQL (dijalankan di XAMPP pada lingkungan pengembangan lokal)
- Fitur utama: manajemen data mahasiswa (CRUD), halaman publik dengan live-search, dashboard admin, cetak biodata (print/PDF-ready)

Daftar isi
- Persyaratan
- Instalasi (Lokal dengan XAMPP)
- Konfigurasi .env
- Migrasi dan seeder
- Menjalankan aplikasi
- Bagaimana menggunakan (user/admin)
- Fitur cetak (print)
- Pengaturan tampilan & tema
- Pengembangan: assets, testing
- Troubleshooting umum
- Keamanan & catatan produksi

---

## Persyaratan
Pastikan sistem development Anda memiliki:
- PHP >= 8.x (cek `composer.json` untuk versi minimum yang dibutuhkan oleh project)
- Composer
- Node.js + npm
- MySQL (XAMPP menyediakan MySQL/MariaDB)
- Git (opsional)

Di Windows/XAMPP: gunakan `xampp` untuk MySQL dan `php` yang disediakan (atau jalankan PHP dari path sistem Anda).

---

## Instalasi (Lokal)
Petunjuk ini diasumsikan Anda berada di folder `c:\xampp\htdocs`.

1. Clone repository (jika belum):

```powershell
cd c:\xampp\htdocs
git clone <repo-url> biodata-mahasiswa
cd biodata-mahasiswa
```

2. Install dependensi PHP menggunakan Composer:

```powershell
composer install
```

3. Install dependensi Node.js dan build asset (development):

```powershell
npm install
npm run dev
```

> Jika menggunakan Vite (project ini punya `vite.config.js`), `npm run dev` akan menjalankan vite dev server.

4. Salin file lingkungan dan generate APP_KEY:

```powershell
copy .env.example .env
php artisan key:generate
```

5. Konfigurasi database pada `.env` (contoh untuk XAMPP/MySQL):

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=biodata_db
DB_USERNAME=root
DB_PASSWORD=
```

Buat database `biodata_db` lewat phpMyAdmin atau CLI.

6. Jalankan migration dan seeder (opsional: jalankan seeder admin):

```powershell
php artisan migrate
php artisan db:seed
```

Seeder `DatabaseSeeder` / `AdminSeeder` sudah ada untuk membuat user admin default (cek isi seeder untuk kredensial). Jika Anda hanya ingin menjalankan AdminSeeder:

```powershell
php artisan db:seed --class=AdminSeeder
```

7. Buat symlink storage agar dapat menampilkan foto yang diupload:

```powershell
php artisan storage:link
```

> Pada Windows, pastikan command ini dijalankan dengan hak akses yang sesuai.

---

## Menjalankan Aplikasi
Untuk development cepat gunakan built-in server:

```powershell
php artisan serve
```

Lalu buka `http://127.0.0.1:8000`.

Jika ingin menggunakan XAMPP/Apache, Anda bisa set virtual host pointing ke `c:\xampp\htdocs\biodata-mahasiswa\public`.

---

## Fitur & Cara Pakai
- Halaman publik: `GET /` — menampilkan daftar mahasiswa dengan live-search.
- Halaman detail publik: `GET /mahasiswa/{mahasiswa}` — melihat biodata publik. Terdapat tombol Print di kanan atas untuk mencetak biodata.
- Autentikasi: Login (admin) menggunakan route yang disediakan oleh package auth (cek `routes/auth.php`).
- Dashboard admin: `GET /admin/dashboard` — menampilkan ringkasan dan tabel mahasiswa terbaru.
- Manajemen mahasiswa (CRUD): `GET /admin/mahasiswa` dan route resource untuk create/edit/delete.

Cetak biodata
- Admin print: `GET /admin/mahasiswa/{mahasiswa}/print` — print-friendly (juga dapat menambahkan `?autoprint=1` untuk memicu dialog print otomatis saat membuka di tab baru).
- Public print: `GET /mahasiswa/{mahasiswa}/print` — versi publik untuk dicetak, sama mendukung `?autoprint=1`.

---

## Pengaturan Tampilan / Branding
- Logo header: `resources/views/layouts/public.blade.php` dan `resources/views/layouts/admin.blade.php` memuat `images/642.jpg` sebagai logo; ganti file pada `public/images/642.jpg` atau ubah tag `img` di Blade untuk menunjuk lokasi lain.
- Warna tema utama: menggunakan `#2b0b5a` (ungu gelap) — lihat CSS inline di beberapa layout untuk menyesuaikan.
- Photo crop/face-focus: Gambar kartu menggunakan CSS `object-position: center 30%` untuk memfokuskan wajah bagian atas. Untuk akurasi sempurna gunakan face-detection saat upload (opsional).

---

## Pengembangan & Assets
- Development assets: `npm run dev` (Vite) — live reload untuk CSS/JS.
- Build production: `npm run build` menghasilkan asset di `public/build` (sesuai konfigurasi Vite).

Jika menambahkan package frontend baru, jalankan `npm install` lalu build ulang.

---

## Testing
Project berisi folder `tests/`.

Jalankan unit/feature tests:

```powershell
./vendor/bin/phpunit
# atau di Windows
vendor\\bin\\phpunit.bat
```

---

## Deployment (Produksi) — ringkasan cepat
- Gunakan PHP-FPM + Nginx atau Apache pada server produksi.
- Pastikan `APP_ENV=production` dan `APP_DEBUG=false` pada `.env`.
- Jalankan migration & seeder.
- Jalankan `php artisan config:cache`, `php artisan route:cache`, `php artisan view:cache`.
- Build assets: `npm run build` dan pastikan `public/build/*` tersedia.
- Set file permission yang tepat: direktori `storage/` dan `bootstrap/cache` harus dapat ditulis oleh user web server.

---

## Troubleshooting Umum
- 500 / white screen: cek `storage/logs/laravel.log`.
- Error database: cek `.env` DB_* dan pastikan database dibuat.
- Foto tidak tampil: jalankan `php artisan storage:link` dan pastikan file disimpan di disk `public`.
- Permission error di Windows: jalankan terminal sebagai Administrator jika perlu (hati-hati dengan hak akses).

---

## Catatan Keamanan & Rekomendasi
- Validasi input pada controller: sudah ditambahkan batas panjang dan tipe file untuk upload foto.
- Live-search: query menggunakan Eloquent binding — bukan raw SQL — namun batasi input panjang dan pertimbangkan rate-limit (`throttle`) bila terbuka ke publik.
- Untuk produksi, gunakan HTTPS dan set `SESSION_SECURE_COOKIE=true` dan pengaturan mail untuk reset password.
- Jika ingin menampilkan foto secara aman, pertimbangkan validasi dan scanning (virus/malware) di upload pipeline.

---

## Fitur Tambahan yang Bisa Ditambahkan
- PDF export server-side (pakai `barryvdh/laravel-dompdf` atau `wkhtmltopdf` via snappy) — berguna untuk unduhan biodata yang konsisten.
- Face detection saat upload untuk crop otomatis (meningkatkan tampilan thumbnail).
- Search indexing (Laravel Scout + Meilisearch) untuk kinerja pencarian lebih baik di dataset besar.
- Role & permission management (mis. `spatie/laravel-permission`) jika ingin granularitas hak akses lebih kompleks.

---

## Kontak / Referensi
- Struktur proyek utama: lihat folder `resources/views` (Blade), `app/Http/Controllers`, `routes/web.php`, `database/migrations`, `database/seeders`.
- Jika butuh bantuan saya dapat bantu: menambahkan PDF export, face-detection, atau mengoptimalkan pagination dan search.

---

Terima kasih — semoga README ini membantu Anda men-setup dan menjalankan aplikasi. Jika Anda ingin, saya bisa menambahkan skrip otomatis (PowerShell) untuk cepat setup di Windows/XAMPP.

