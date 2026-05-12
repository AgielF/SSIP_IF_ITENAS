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


## ⚙️ Pengujian (Unit Testing)

1. **Menjalankan Tes**
   ```bash
   vendor/bin/phpunit tests/Feature/MasterRoleTest.php > hasil_text.txt

2. **Menjalankan Tes sqlinject**
   Merubah CI_ENVIRONMENT = development pada .env 
   ```bash
   # Menjalankan server pada mode testing
   php spark serve --env testing

   # Memberikan izin eksekusi jika file skrip baru dibuat
   chmod +x test_sqli.sh
   
   # Menjalankan skrip pengujian terhadap endpoint target
   ./test_sqli.sh


3. **Menjalankan Tes XSS**
   Buka folder selain folder project 
   ```bash
   # Clone dari repositori resmi
   git clone https://github.com/s0md3v/XSStrike.git

   # Masuk ke direktori
   cd XSStrike

   # Instal pustaka yang dibutuhkan
   pip install -r requirements.txt

   #menyalakan app
   php spark serve --env testing

   # Melakukan crawling mendalam pada target (contoh: rute login/berita)
   python3 xsstrike.py -u "http://localhost:8080/" --crawl > hasil_scan.txt