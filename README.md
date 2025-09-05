# SSIP IF ITENAS - Sistem Informasi Akademik

## 📋 Project Overview

SSIP IF ITENAS adalah sistem informasi akademik yang dirancang untuk mengelola kegiatan akademik di jurusan Informatika. Sistem ini mencakup manajemen user, events, praktikum, publikasi, riset, berita, galeri, dan rekrutmen asisten.

## 🗓️ Progress Timeline

### **Minggu 1: Planning & Design**
- ✅ Database schema design (DBML)
- ✅ System architecture planning
- ✅ Requirements analysis
- ✅ Technology stack selection

### **Minggu 2: Database Implementation** 
- ✅ Complete database structure (13 tables)
- ✅ Migration files (14 files)
- ✅ Seeder files with realistic data (14 files)
- ✅ Model files (13 files)
- ✅ Data integrity and relationships
- ✅ Comprehensive test data

### **Minggu 3: Admin Page** ⭐ **CURRENT**

Frontend (Admin):

- ✅ Implementasi UI tabel interaktif menggunakan DataTables.net untuk semua fitur CRUD.
- ✅ Halaman untuk mengelola Jadwal dan Anggota Lab.
- ✅ Mengintegrasikan data dari backend pada jadwal dan asisten.
🔜 Selanjutnya: Mengintegrasikan dengan controller data BACKEND.

## 🗄️ Database Structure

### **Core Tables (13 Total)**

#### **1. User Management**
- `roles` - User roles (admin, asisten, mahasiswa, dosen)
- `users` - User accounts with NIM format (152022xxx)

#### **2. Academic System**
- `events` - Events (praktikum, seminar, lomba, rapat)
- `jadwal` - Event schedules with rooms and times
- `asisten_jadwal` - Assistant assignments to schedules
- `praktikum` - Practical work records
- `modul_praktikum` - Practical modules
- `peserta_praktikum` - Practical participants with grades

#### **3. Publication & Research**
- `publikasi` - Publications (jurnal, prosiding, paten)
- `proyek_riset` - Research projects with funding sources

#### **4. Content Management**
- `berita` - News/articles with categories
- `galeri_umum` - General gallery (photos/videos)

#### **5. Recruitment**
- `rekrut` - Assistant recruitment with requirements

## 📊 Data Coverage

### **Sample Users (12+ Records)**
```
✅ Admin: Jeffry Sukmawidiajja (152022001)
✅ Asisten: Mohammad Rohman (152022002)
✅ Mahasiswa: 8 students (152022003-010)
✅ Dosen: 2 lecturers (D001, D002)
```

### **Sample Events & Schedules**
```
✅ 3 Events: Praktikum, Seminar AI, Lomba Programming
✅ 4 Schedules: Lab 1, Aula, Lab 2, Lab 3
✅ 3 Assistant Assignments
```

### **Sample Academic Data**
```
✅ 3 Practical Records with rules
✅ 4 Practical Modules (Algoritma, Struktur Data, Basis Data, Web)
✅ 6 Practical Participants with grades
```

### **Sample Publications & Research**
```
✅ 3 Publications (jurnal, prosiding, paten)
✅ 3 Research Projects with DIKTI/LPDP funding
```

### **Sample Content**
```
✅ 4 News Articles (workshop, seminar, announcement, internal)
✅ 4 Gallery Items (3 photos, 1 video)
✅ 3 Recruitment Records (2 open, 1 closed)
```

## 🔧 Technical Implementation

### **Migration Files (14 Total)**
```
✅ 2025-07-24-193451_CreateRoles.php
✅ 2025-07-24-193452_CreateUsers.php
✅ 2025-07-24-193453_CreateEvents.php
✅ 2025-07-24-193454_CreateJadwal.php
✅ 2025-07-24-193455_CreateAsistenJadwal.php
✅ 2025-07-24-193456_CreatePublikasi.php
✅ 2025-07-24-193457_CreatePraktikum.php
✅ 2025-07-24-193458_CreateRekrut.php
✅ 2025-07-24-193459_CreateProyekRiset.php
✅ 2025-07-24-193460_CreateBerita.php
✅ 2025-07-24-193461_CreateGaleriUmum.php
✅ 2025-07-24-193462_CreateModulPraktikum.php
✅ 2025-07-24-193463_CreatePesertaPraktikum.php
✅ 2025-07-24-193466_FixPesertaPraktikumNilai.php
```

### **Seeder Files (14 Total)**
```
✅ RolesSeeder.php - 4 roles (admin, asisten, mahasiswa, dosen)
✅ UsersSeeder.php - 12 users with realistic NIMs
✅ EventsSeeder.php - 3 events with proper timestamps
✅ JadwalSeeder.php - 4 schedules with rooms
✅ AsistenJadwalSeeder.php - 3 assistant assignments
✅ PublikasiSeeder.php - 3 publications with links
✅ PraktikumSeeder.php - 3 practical records with rules
✅ RekrutSeeder.php - 3 recruitment records
✅ ProyekRisetSeeder.php - 3 research projects
✅ BeritaSeeder.php - 4 news articles
✅ GaleriUmumSeeder.php - 4 gallery items
✅ ModulPraktikumSeeder.php - 4 practical modules
✅ PesertaPraktikumSeeder.php - 6 participants with grades
✅ DatabaseSeeder.php - Main seeder orchestrator
```

### **Model Files (13 Total)**
```
✅ RoleModel.php
✅ UserModel.php
✅ EventModel.php
✅ JadwalModel.php
✅ AsistenModel.php
✅ PublikasiModel.php
✅ PraktikumModel.php
✅ RekrutModel.php
✅ ProyekRisetModel.php
✅ BeritaModel.php
✅ GaleriUmumModel.php
✅ ModulPraktikumModel.php
✅ PesertaPraktikumModel.php
```

## 🎨 Frontend Architecture (Planned)

### **Technology Stack**
```
Frontend: HTML5, CSS3, JavaScript, Bootstrap 5
Backend: CodeIgniter 4 (PHP)
Database: MySQL
Additional: jQuery, FontAwesome, Chart.js
```

## Installation & Setup

### **Prerequisites**
```bash
PHP >= 8.0
MySQL >= 8.0
Composer

Server lokal (misalnya XAMPP atau Laragon)

Database MySQL

Panduan Instalasi
Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal Anda.

1. Clone Repositori
Pertama, salin (clone) repositori ini ke komputer Anda menggunakan perintah berikut:

git clone https://github.com/AgielF/SSIP_IF_ITENAS.git

Masuk ke dalam direktori proyek yang baru saja dibuat:

cd SSIP_IF_ITENAS

2. Instal Dependensi
Proyek ini menggunakan Composer untuk mengelola library PHP. Jalankan perintah berikut untuk menginstal semua dependensi yang diperlukan:

composer install

Perintah ini akan membuat folder vendor/ yang berisi semua kerangka kerja CodeIgniter dan library lainnya.

3. Konfigurasi Lingkungan (.env)
File .env digunakan untuk menyimpan semua konfigurasi sensitif seperti kredensial database.

Salin file env menjadi .env:

cp env .env

Buka file .env yang baru dibuat dengan editor teks.

Atur baseURL dan aktifkan mode development:

CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'

Atur koneksi database Anda. Pastikan Anda sudah membuat database kosong terlebih dahulu.

database.default.hostname = 127.0.0.1
database.default.database = nama_database_anda
database.default.username = root
database.default.password = 

4. Migrasi dan Seeding Database
Langkah ini akan membuat semua tabel yang diperlukan dan mengisinya dengan data awal.

Jalankan Migrasi: Perintah ini akan membuat struktur tabel di database Anda.

php spark migrate

Jalankan Seeder: Perintah ini akan mengisi tabel dengan data dummy (contoh data) agar aplikasi memiliki konten awal.

php spark db:seed DatabaseSeeder

Jika Anda ingin mereset dan menjalankan ulang semua migrasi dan seeder, Anda bisa menggunakan perintah php spark migrate:refresh --seed.

5. Jalankan Aplikasi
Gunakan server pengembangan bawaan CodeIgniter untuk menjalankan aplikasi.

php spark serve

Sekarang, buka browser Anda dan kunjungi http://localhost:8080 untuk melihat aplikasi berjalan.

**Week 5 Status: progress**  


## 🏗️ Struktur Proyek

Berikut adalah file-file utama yang menjadi inti dari aplikasi ini:

  - `app/Controllers/AnggotaController.php`: Mengatur logika untuk halaman daftar anggota dan profil.
  - `app/Models/UserModel.php`: Mengelola semua query dan logika yang berhubungan dengan data pengguna di database.
  - `app/Views/asisten_list_view.php`: File tampilan untuk halaman daftar semua anggota.
  - `app/Views/user_profile_view.php`: File tampilan untuk halaman profil detail per anggota.
  - `app/Config/Routes.php`: Mendefinisikan URL endpoint aplikasi.

## 🌐 Rute (Endpoints)

  - `GET /`: Menampilkan halaman utama berisi daftar semua anggota laboratorium.
  - `GET /profil/{id}`: Menampilkan halaman profil detail untuk anggota dengan `:num` sebagai ID unik. Contoh: `/profil/1`.

-----





