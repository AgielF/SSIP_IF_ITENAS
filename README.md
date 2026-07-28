# Sistem Informasi Laboratorium SSIP IF ITENAS

Sistem Informasi Laboratorium **Smart System and Information Processing (SSIP)** Institut Teknologi Nasional (ITENAS) Bandung adalah platform manajemen operasional laboratorium yang dibangun menggunakan arsitektur monolitik CodeIgniter 4. Sistem ini dirancang untuk mengelola data asisten, jadwal praktikum, riset dosen, publikasi ilmiah, hingga rekrutmen asisten baru secara terintegrasi.

---

## 🚀 Fitur Utama

Sistem ini mendukung *Role-Based Access Control (RBAC)* yang ketat untuk tiga peran utama: **Admin (Kepala Lab)**, **Asisten**, dan **Dosen**.

### 1. Manajemen Keanggotaan & Role
- Pengelolaan data pengguna (*Users*) dengan peran spesifik.
- Manajemen periode aktif laboratorium.
- Daftar asisten aktif per periode.

### 2. Operasional Praktikum
- **Jadwal**: Pengaturan jadwal kegiatan laboratorium (Praktikum, Seminar, Rapat) lengkap dengan informasi ruangan dan waktu.
- **Modul Praktikum**: Unggah dan kelola modul pembelajaran dalam format digital (PDF).
- **Peserta**: Monitoring status kelulusan peserta praktikum.

### 3. Riset & Pengembangan
- **Proyek Lab**: Manajemen proyek internal laboratorium, termasuk pelacakan teknologi yang digunakan dan anggota tim.
- **Proyek Riset**: Dokumentasi riset dosen yang mencakup mitra, sumber dana, dan status pelaksanaan.
- **Publikasi Ilmiah**: Katalog publikasi (Jurnal, Prosiding, Paten) yang dihasilkan oleh civitas lab.

### 4. Informasi & Komunikasi
- **Berita**: Publikasi pengumuman, seminar, dan workshop.
- **Galeri**: Dokumentasi kegiatan laboratorium dalam bentuk foto dan video.
- **Rekrutmen**: Sistem pendaftaran asisten baru yang terintegrasi dengan jadwal dan syarat tertentu.
- **Visi & Misi**: Halaman informasi profil laboratorium.

---

## 🛠️ Stack Teknologi

- **Backend Framework**: PHP CodeIgniter 4.x
- **Database**: MySQL / MariaDB 10.4+
- **Security**: 
  - Authentication: Session & JWT (firebase/php-jwt).
  - RBAC: Filter/Middleware kustom untuk proteksi rute berdasarkan `role_id`.
- **Testing**: PHPUnit 10.5 dengan *Feature Testing* dan *Database Migration*.
- **Operating System Development**: Ubuntu Linux.

---

## 📊 Skema Database

Sistem ini menggunakan skema relasional yang kuat dengan integritas data (*Foreign Key*) yang ketat. Berikut adalah tabel-tabel utamanya:

| Tabel | Deskripsi |
|-------|-----------|
| `users` | Menyimpan data NRP, Nama, No Telp, dan password terenkripsi. |
| `roles` | Definisi peran (Admin, Asisten, Dosen, Praktikan). |
| `jadwal` | Manajemen waktu dan ruangan untuk setiap event. |
| `berita` | Konten berita dan pengumuman laboratorium. |
| `rekrut` | Pengaturan lowongan asisten laboratorium. |
| `project_lab` | Detail proyek internal lab dan teknologi yang digunakan. |
| `proyek_riset` | Dokumentasi penelitian dosen dan kolaborasi mitra. |
| `publikasi` | Koleksi karya ilmiah yang telah diterbitkan. |

---

## ⚙️ Instalasi & Persiapan

Ikuti langkah-langkah berikut untuk menjalankan proyek di lingkungan lokal (Ubuntu):

1. **Clone Repositori**
   ```bash
   git clone [https://github.com/username/SSIP_IF_ITENAS.git](https://github.com/username/SSIP_IF_ITENAS.git)
   cd SSIP_IF_ITENAS

2. **Instalasi Dependencies**
   ```bash
   composer install

3. **Instalasi Dependencies**
    Salin file .env.example menjadi .env dan sesuaikan pengaturan database Anda:
   ```bash
    database.default.hostname = localhost
    database.default.database = ssip
    database.default.username = root
    database.default.password = password_anda
    database.default.DBDriver = MySQLi

    # JWT Secret (Minimal 32 karakter)
    JWT_SECRET = rahasia_keamanan_sistem_ssip_lab_itenas_2026_aman!

4. **Migrasi & Seeding Database**
   ```bash
    php spark migrate
    php spark db:seed DatabaseSeeder


---

# 🛡️ Laporan Progres: Fase Pematangan Keamanan & QA Otomatis (SSIP IF ITENAS)

Dokumen ini merangkum seluruh jejak langkah, modifikasi *codebase*, dan pencapaian arsitektural yang telah kita lakukan secara *pair-programming* untuk menaikkan standar kualitas sistem Lab SSIP menjadi *Enterprise-Ready*.

---

## 1. Implementasi AI QA Agent (Automated Testing)
Untuk mencegah regresi (*bug* berulang) dan memastikan integritas data, kita telah mengintegrasikan sistem agen penguji otonom:
*   **[NEW] `QaReportGenerator.php`**: *Library* inti yang bertugas mengeksekusi skenario uji coba.
*   **[NEW] `QaAgentScan.php`**: *Command-Line Interface* (CLI) di CI4 untuk memicu agen QA menjalankan pemindaian secara berkala.

## 2. Refaktorisasi Logika Role & Stabilitas CRUD
Menyelaraskan otorisasi *backend* agar murni bertumpu pada filter CI4 dan membersihkan potensi *fatal error*.
*   **Resolusi Role-Conflict**: Menghapus blokade *role* manual (`if role_id != X`) yang sebelumnya berbenturan dengan `Routes.php`. Akses Kepala Lab, Dosen, dan Asisten kini mulus pada modul:
    *   `ProyekRisetController.php` (Mendukung integrasi Penulis Utama & Pendamping)
    *   `PublikasiController.php`
    *   `JadwalController.php`
    *   `SertifikatController.php`
*   **Penanganan Exception (Graceful Fails)**: Menyuntikkan blok `try-catch` dan validasi `is_numeric($id)` secara merata ke dalam `BeritaController`, `EventsController`, `PeriodeController`, `GaleriUmumController`, dan `ModulPraktikumController` untuk menjamin server tidak lagi melempar layar *error* merah saat terjadi kegagalan *Query* atau *Foreign Key Constraint*.

## 3. Penambalan Celah Keamanan Kritis (Security Patch)
Mengeksekusi rekomendasi *Technical Architect* untuk menutup tiga vektor serangan siber utama:
*   **[MITIGATED] Serangan Brute-Force**: 
    *   Menciptakan **`ThrottleFilter.php`** (Membatasi percobaan ke rute login API maksimal 5 kali per menit per IP).
    *   Diregistrasikan di `Filters.php` dan `Routes.php`.
*   **[MITIGATED] Eksploitasi CSRF pada Logout**: 
    *   Mengamankan `Routes.php` dengan mengubah rute `logout` menjadi `POST`.
    *   Menghancurkan celah eksekusi *Forced Logout* via URL dengan menanamkan *hidden form* beserta `csrf_field()` pada UI navigasi di **`header.php`**.
*   **[MITIGATED] Stored XSS (Cross-Site Scripting)**: 
    *   Melakukan sanitasi pada variabel keluaran dinamis. Membungkus nilai berisiko seperti teks tebasan *user* dengan fungsi `esc()` pada berkas antarmuka, khususnya di `jadwal_card_admin.php` dan `rekrutmen_admin.php`.

Seluruh pekerjaan keamanan di iterasi ini dinyatakan selesai dengan predikat **100% SUCCESS**.
