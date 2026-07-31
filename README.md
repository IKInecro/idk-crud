# Sistem Informasi Akademik — MNC University

Aplikasi web CRUD data mahasiswa (Laravel 13) dengan autentikasi, verifikasi email OTP, role admin/user, dan soft delete. Dibuat buat tugas/testing 😎

> **Landing page:** "moga gak error :V" — semoga aja pas penguji nyobain gak error wkwk

---

## 📌 Daftar Isi

- [Teknologi yang Dipakai](#-teknologi-yang-dipakai)
- [Akun yang Tersedia](#-akun-yang-tersedia)
- [Cara Menjalankan](#-cara-menjalankan)
- [Cara Kerja Sistem](#-cara-kerja-sistem)
- [Struktur Database](#-struktur-database)
- [Hak Akses & Route](#-hak-akses--route)
- [Fitur Autentikasi](#-fitur-autentikasi)
- [Fitur CRUD Mahasiswa](#-fitur-crud-mahasiswa)
- [Fitur Unggah Foto](#-fitur-unggah-foto)
- [Error Page Custom (403/404)](#-error-page-custom-403404)
- [Penjelasan Test Case](#-penjelasan-test-case)

---

## 🔧 Teknologi yang Dipakai

| Komponen | Keterangan |
|---|---|
| **Framework** | Laravel 13.23.0 |
| **Bahasa** | PHP 8.3, JavaScript (vanilla + Alpine.js) |
| **Database** | SQLite |
| **CSS** | Tailwind CSS (via Vite) |
| **Template Engine** | Blade |
| **Frontend Scaffolding** | Laravel Breeze (Blade + Alpine.js) |
| **Image Cropper** | Cropper.js v1.6.2 |
| **Build Tool** | Vite (npm) |
| **Mail (lokal)** | `MAIL_MAILER=log` → OTP ditulis ke `storage/logs/mail.log` |
| **Session** | Database driver (`sessions` table), lifetime 5 menit |

---

## 👤 Akun yang Tersedia

Ada **1 akun admin** yang sudah dibuat. Buat akun user baru lewat halaman **Register** di aplikasi.

| Role | Email | Password |
|---|---|---|
| **Admin** | `admin@mncu.univ.ac.id` | `jawa1234` |

> Akun admin dibuat otomatis via `DatabaseSeeder` atau langsung ada di `database.sqlite` yang sudah ke-push. Kalau mau tambah user, tinggal daftar lewat halaman Register (nanti role-nya otomatis jadi `user`).

---

## 🚀 Cara Menjalankan

```bash
# 1. Clone repo
git clone https://github.com/IKInecro/idk-crud.git
cd idk-crud

# 2. Install dependencies
composer install
npm install

# 3. Siapkan environment (sudah ada APP_KEY yang sesuai)
cp .env.example .env

# 4. Generate key kalau .env sudah diubah (atau pakai yang ada di .env.example)
php artisan key:generate

# 5. Build frontend
npm run build

# 6. Link storage (buat akses foto upload)
php artisan storage:link

# 7. Jalankan migrasi + seeder (pakai ini kalau mau database fresh)
php artisan migrate --seed

# 8. Jalankan server
php artisan serve
```

Buka `http://localhost:8000`.

> **Catatan:** Repo ini sudah menyertakan file `database/database.sqlite` yang berisi data test. Jadi aplikasi **langsung bisa dipakai tanpa migrate**. Kalau mau database bersih/reset, hapus file sqlite lalu jalankan `php artisan migrate --seed`.

---

## 🧠 Cara Kerja Sistem

1. **User daftar** lewat `/register` → sistem otomatis buat 2 record: satu di tabel `users` (akun login) dan satu di tabel `mahasiswas` (profil mahasiswa yang link via `user_id`). Field akademik (jurusan, angkatan, dll) kosong dulu.
2. Setelah daftar, user harus **verifikasi email pakai OTP 6 digit**. OTP dikirim ke log (`storage/logs/mail.log`) karena pakai `MAIL_MAILER=log` (localhost, bukan mailtrap hehe).
3. User yang belum verifikasi hanya bisa akses halaman verifikasi. Dashboard & data mahasiswa butuh `auth` + `verified`.
4. User biasa bisa **lengkapi profil mahasiswa**-nya di halaman Profile (isi NIM, jurusan, dll).
5. **Admin** bisa tambah/edit/hapus data mahasiswa apa pun.
6. Hapus pakai **soft delete** → data tetap ada di DB, cuma `deleted_at` terisi.

---

## 🗄️ Struktur Database

Tabel utama (10 total):

| Tabel | Fungsi |
|---|---|
| `users` | Akun login (name, email, password hash, `role`, `verification_code`) |
| `mahasiswas` | Data mahasiswa (nim, nama, jurusan, dll) + `user_id` (link ke users) + `created_by` + `deleted_at` (soft delete) + `alamat` (terenkripsi) |
| `sessions` | Session login (driver database) |
| `password_reset_tokens` | Token reset password |
| `cache`, `cache_locks`, `jobs`, `job_batches`, `failed_jobs` | Template bawaan Laravel (tidak dipakai aktif) |
| `migrations` | Riwayat migration |

### Relasi
- `User` **hasOne** `Mahasiswa` (lewat `mahasiswas.user_id`)
- `Mahasiswa` **belongsTo** `User`

### Kolom `mahasiswas`
`id, nim, nama, email, jurusan, angkatan, tgl_lahir, alamat, foto, created_by, created_at, updated_at, deleted_at, user_id, jenis_kelamin`

---

## 🔐 Hak Akses & Route

| Path | Method | Siapa yang Bisa |
|---|---|---|
| `/` | GET | **Publik** (landing page) |
| `/login`, `/register`, `/forgot-password`, `/reset-password/*` | GET/POST | **Publik** (guest) |
| `/verify-email` + `/verify-email/otp` | GET/POST | **Sudah login, belum verifikasi** |
| `/dashboard` | GET | **Login + terverifikasi** |
| `/profile`, `/profile/mahasiswa` | GET/PATCH | **Login + terverifikasi** |
| `/mahasiswa` (list), `/mahasiswa/{id}` (detail) | GET | **Semua yang login + terverifikasi** (view-only utk user biasa) |
| `/mahasiswa/create`, `/mahasiswa` (store) | GET/POST | **Hanya Admin** (via policy) |
| `/mahasiswa/{id}/edit`, `/mahasiswa/{id}` (update/delete) | GET/PUT/DELETE | **Hanya Admin** (via policy) |
| `/logout` | POST | **Semua yang login** |

> Non-admin yang paksa akses `/mahasiswa/create` dkk akan dapat **403**. (Error page 403 custom = tombol TEKAN + rock.jpg 😄)
>
> Yang belum login akses halaman terlindungi → diarahkan ke `/login` otomatis oleh middleware `auth`. Abis login, balik lagi ke halaman yang tadi mau dibuka (`redirect()->intended()`).

---

## ✉️ Fitur Autentikasi

- **Register** → auto-login + generate OTP 6 digit
- **Verifikasi OTP** → cocokkan dengan `users.verification_code`, lalu set `email_verified_at`
- **Login** → pesan error generik "Email atau password salah." (tidak bocorin email terdaftar atau enggak)
- **Rate limit login** → 5 kali percobaan per menit per email+IP, abis itu lockout 1 menit
- **Logout** → konfirmasi dulu ("Yakin Mau Logout?") → redirect ke `/login`
- **Session** → kadaluarsa setelah 5 menit (SESSION_LIFETIME=5)

---

## 📋 Fitur CRUD Mahasiswa

### Create (Tambah)
- Field **wajib**: NIM (unik), Nama, Jenis Kelamin (L/P), Email (unik), Jurusan, Angkatan (dropdown 2021–2026), Tanggal Lahir (harus sebelum hari ini)
- Field **opsional**: Alamat, Foto

### Update (Edit)
- Validasi sama seperti create, tapi `unique` di-ignore untuk data sendiri (biar NIM/email sendiri gak dianggap duplikat)
- Kalau field wajib dikosongkan → ditolak, data lama tetap tersimpan

### Delete (Hapus)
- Modal konfirmasi (Batal / Ya, Hapus)
- **Soft delete** → `deleted_at` terisi, data tetap ada di DB (lihat TC-DEL-04)

### Filter & Pencarian
- Live search (NIM, nama, email, jurusan, angkatan) + filter fakultas, jurusan, angkatan — semuanya via AJAX tanpa reload

### Kartu Mahasiswa (ID Card)
- Tombol kartu di tiap baris → popup ID card (foto, NIM, nama, tgl lahir, alamat, **kelamin**, jurusan, angkatan, status AKTIF)

---

## 🖼️ Fitur Unggah Foto

- Pakai **Cropper.js**: pilih foto → crop → konfirmasi
- File **> 2MB ditolak langsung di browser** (alert sebelum di-crop) — validasi ganda di server juga ada (`max:2048`)
- Format: jpg, jpeg, png

---

## 🤡 Error Page Custom (403/404)

Kalau akses halaman yang gak boleh (403) atau halaman yang gak ada (404):

1. Muncul halaman navy gelap dengan tombol **"TEKAN"**
2. Klik tombol → **rock.jpg** muncul (50% layar) + **sound.mp3** bunyi (browser butuh user gesture buat autoplay suara)
3. 1,5 detik → fade out → balik ke halaman sebelumnya, atau `/dashboard` (sudah login) / `/login` (belum login)

---

## 📝 Penjelasan Test Case

> Beberapa test case ternyata **mirip/sama**, jadi dijelasin biar gak bingung.

### Login
| ID | Skenario | Penjelasan |
|---|---|---|
| **TC-LGN-01** | Login valid | Pakai `admin@mncu.univ.ac.id` / `jawa1234` → masuk dashboard |
| **TC-LGN-02** | Email tidak terdaftar | Pesan: **"Email atau password salah."** (tidak bilang email-nya gak ada — biar aman) |
| **TC-LGN-03** | Password salah | Pesan sama: "Email atau password salah." |
| **TC-LGN-04** | Field kosong | Validasi `required` → error field kosong |
| **TC-LGN-05** | Gagal berulang | 5x gagal → lockout 1 menit ("Too many attempts") |
| **TC-LGN-06** | Akses halaman tanpa login | Middleware `auth` → redirect ke `/login` |
| **TC-LGN-07** | Logout | Konfirmasi dulu → POST `/logout` → redirect `/login` + pesan |
| **TC-LGN-08** | Session kadaluarsa | `SESSION_LIFETIME=5` menit → abis itu minta login lagi |

### Input Data (Create)
| ID | Skenario | Penjelasan |
|---|---|---|
| **TC-INP-01** | Semua field valid | Data masuk, muncul flash "berhasil ditambahkan" |
| **TC-INP-02** | Field wajib kosong | Ditolak, error per-field, data tidak tersimpan |
| **TC-INP-03** | NIM/email duplikat | `unique` → error "NIM sudah terdaftar." / "Email sudah terdaftar." |
| **TC-INP-04** | Tanggal invalid | `date` + `before:today` → ditolak |
| **TC-INP-05** | File > 2MB | Ditolak di browser (alert) + di server |
| **TC-INP-06** | File jenis tidak diizinkan | `mimes:jpg,jpeg,png` → ditolak |
| **TC-INP-07** | Batal sebelum simpan | Form gak di-submit, data gak ada di DB |

### Edit Data (Update)
| ID | Skenario | Penjelasan |
|---|---|---|
| **TC-EDT-01** | Buka form edit | Hanya admin, via tombol edit |
| **TC-EDT-02** | Edit semua valid | Data berubah, flash "berhasil diperbarui" |
| **TC-EDT-03** | Field wajib dikosongkan | Ditolak, **data lama tetap tersimpan** |
| **TC-EDT-04** | Nilai unik jadi duplikat | **Sama dengan TC-INP-03**: `unique` ditolak. Bedanya di sini `->ignore(id)` biar data sendiri gak dianggap duplikat |
| **TC-EDT-05** | Edit tanpa otorisasi | Non-admin → 403 |
| **TC-EDT-06** | Batal sebelum simpan | **Sama dengan TC-INP-07**: form gak di-submit, data gak berubah |

### Hapus Data (Delete)
| ID | Skenario | Penjelasan |
|---|---|---|
| **TC-DEL-01** | Hapus + konfirmasi setuju | Modal → "Ya, Hapus" → soft delete, hilang dari daftar |
| **TC-DEL-02** | Batal konfirmasi | Modal ditutup, data **tetap ada** |
| **TC-DEL-03** | Hapus tanpa otorisasi | Non-admin → 403 |
| **TC-DEL-04** | Cek data setelah soft delete | **Data tetap ada di DB!** Lihat detail di bawah |
| **TC-DEL-05** | Hapus data yang sudah gak ada | Route model binding gagal → 404, tidak ada hapus ganda |

### 🔍 Detail TC-DEL-04 (Soft Delete)

Setelah hapus lewat aplikasi, data **TIDAK benar-benar hilang** dari database. Cuma kolom `deleted_at` yang terisi tanggal hapus.

Cara buktiin:

```bash
# Di Laravel Tinker
php artisan tinker

# Lihat semua termasuk yang terhapus
App\Models\Mahasiswa::withTrashed()->get();

# Hanya yang terhapus
App\Models\Mahasiswa::onlyTrashed()->get();
```

```sql
-- Langsung di SQLite
SELECT * FROM mahasiswas WHERE deleted_at IS NOT NULL;
```

Contoh nyata di DB yang ke-push:
```
15 | 9999 | lutfi | aisdhad@gmail.co | deleted_at=2026-07-31 09:33:40
```

Data ini **tidak tampil di daftar utama** (query otomatis filter `deleted_at IS NULL`), tapi **masih tersimpan** di tabel `mahasiswas`.

- Restore: `App\Models\Mahasiswa::withTrashed()->find(15)->restore()`
- Hapus permanen (hard delete): `App\Models\Mahasiswa::withTrashed()->find(15)->forceDelete()`

---

## 📂 Struktur Folder Utama

```
app/Http/Controllers/Auth/    → Register, Login, Verifikasi OTP
app/Http/Controllers/MahasiswaController.php → CRUD mahasiswa
app/Http/Controllers/ProfileController.php   → Profil + sync email + hapus akun
app/Http/Requests/            → Validasi create/update & login
app/Models/                   → User, Mahasiswa (SoftDeletes)
app/Policies/MahasiswaPolicy.php → Aturan akses admin vs user
resources/views/              → Blade (auth, mahasiswa, profile, dashboard)
resources/views/errors/       → 403/404 custom (rock.jpg + sound.mp3)
routes/web.php & auth.php     → Definisi route
database/migrations/          → Skema tabel
database/seeders/             → Seeder admin + mahasiswa
public/images/                → Asset (logo, rock.jpg, sound.mp3)
```

---

## 📸 Screenshot Area

- **Login**: navy gelap + gold accent
- **Dashboard**: stat card (total mahasiswa, total user, jumlah jurusan), mahasiswa terbaru, alert profil belum lengkap buat user
- **Daftar Mahasiswa**: tabel + live search/filter + ID card popup
- **Error 403/404**: tombol TEKAN → rock.jpg + sound.mp3

---

Dibuat dengan ❤️ + banyak ngoding dan debugging. Semoga lulus testing 🙏
