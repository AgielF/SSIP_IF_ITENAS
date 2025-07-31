# 📊 Database Progress - Frontend Team Guide

## 🎯 **Apa yang Sudah Dikerjakan (Minggu 2)**

### **✅ Database Structure Lengkap**
- **13 Tabel** dengan relasi yang sudah terdefinisi
- **14 File Migrasi** untuk membuat struktur database
- **14 File Seeder** dengan data dummy yang realistis
- **13 File Model** untuk akses data

### **📋 Tabel yang Tersedia untuk Frontend:**

#### **1. User Management**
```
roles - Role pengguna (admin, asisten, mahasiswa, dosen)
users - Data pengguna dengan NIM format 152022xxx
```

#### **2. Academic System**
```
events - Event (praktikum, seminar, lomba, rapat)
jadwal - Jadwal dengan ruangan dan waktu
asisten_jadwal - Assignment asisten ke jadwal
praktikum - Data praktikum dengan aturan
modul_praktikum - Modul praktikum (file PDF)
peserta_praktikum - Peserta dengan nilai (bisa NULL)
```

#### **3. Content Management**
```
berita - Berita dengan kategori (seminar, workshop, internal, pengumuman)
galeri_umum - Galeri foto/video
publikasi - Publikasi (jurnal, prosiding, paten)
proyek_riset - Proyek riset dengan funding
rekrut - Rekrutmen asisten dengan status
```

## 🎨 **Data yang Siap untuk Frontend:**

### **Sample Users (12 Records)**
```
Admin: Jeffry Sukmawidiajja (152022001)
Asisten: Mohammad Rohman (152022002)
Mahasiswa: 8 students (152022003-010)
Dosen: 2 lecturers (D001, D002)
```

### **Sample Events & Schedules**
```
3 Events: Praktikum, Seminar AI, Lomba Programming
4 Schedules: Lab 1, Aula, Lab 2, Lab 3
3 Assistant Assignments
```

### **Sample Content**
```
4 News Articles (workshop, seminar, announcement, internal)
4 Gallery Items (3 photos, 1 video)
3 Publications (jurnal, prosiding, paten)
3 Research Projects (DIKTI/LPDP funding)
3 Recruitment Records (2 open, 1 closed)
```

## 🚀 **Yang Bisa Dilakukan Frontend:**

### **1. Login System**
- Gunakan field `nomor` (NIM) dan `password`
- Check `role_id` untuk menentukan dashboard

### **2. Dashboard Berdasarkan Role**
```
Admin: Akses semua data
Dosen: Kelola praktikum, nilai, publikasi
Asisten: Kelola praktikum, bantu mahasiswa
Mahasiswa: Lihat jadwal, nilai, modul
```

### **3. Data yang Tersedia**
- **User data** dengan role dan NIM
- **Event & Schedule** dengan ruangan
- **News & Gallery** untuk homepage
- **Publications & Research** untuk showcase
- **Practical data** dengan nilai dan modul

### **Minggu 3-4:**
1. **Setup project** dengan Bootstrap 5
2. **Buat login page** dengan form NIM/password
3. **Buat dashboard** berdasarkan role
4. **Integrasi API** yang akan dibuat backend

### **Yang Sudah Siap:**
- ✅ **Database structure** lengkap
- ✅ **Sample data** untuk testing
- ✅ **User roles** dan permissions
- ✅ **Content data** untuk homepage

## 📊 **Variabel dari Seeder untuk Frontend:**

### **1. User Authentication Variables**
```php
// Login form fields
$nomor = "152022001"; // NIM format
$password = "password"; // Will be hashed
$role_id = 1; // 1=admin, 2=asisten, 3=mahasiswa, 4=dosen

// User profile data
$nama = "Jeffry Sukmawidiajja";
$no_telp = "08123456789";
$jurusan = "Informatika";
```

### **2. Event & Schedule Variables**
```php
// Event data
$nama_event = "Praktikum Basis Data";
$jenis = "praktikum"; // praktikum, seminar, lomba, rapat
$deskripsi = "Praktikum untuk mahasiswa semester 4";

// Schedule data
$tanggal = "2025-08-01";
$waktu_mulai = "08:00:00";
$waktu_selesai = "10:00:00";
$ruangan = "Lab 1";
```

### **3. Academic System Variables**
```php
// Practical data
$desc_aturan = "Praktikum Algoritma dan Pemrograman - Dilarang menggunakan AI untuk coding";
$status = "terdaftar"; // terdaftar, lulus, tidak lulus
$nilai = 85.5; // float, bisa NULL

// Module data
$judul = "Modul Praktikum Algoritma dan Pemrograman";
$file_url = "/uploads/modul/modul_algoritma.pdf";
```

### **4. Content Management Variables**
```php
// News data
$judul = "Workshop Pengembangan Aplikasi Web Modern";
$kategori = "workshop"; // workshop, seminar, internal, pengumuman
$konten = "Jurusan Informatika akan mengadakan workshop...";
$tanggal = "2024-12-15";

// Gallery data
$kategori = "foto"; // foto, video
$file_url = "/uploads/galeri/praktikum_lab.jpg";
$keterangan = "Foto kegiatan praktikum di laboratorium komputer";

// Publication data
$jenis_publikasi = "jurnal"; // jurnal, prosiding, paten
$link_publikasi = "https://doi.org/10.1000/example1";
$kategori = "Jurnal Nasional";
$tanggal_publikasi = "2024-01-15";
```

### **5. Research & Recruitment Variables**
```php
// Research data
$judul = "Pengembangan Sistem Informasi Akademik Berbasis Web";
$mitra = "Universitas Indonesia";
$sumber_dana = "DIKTI"; // DIKTI, LPDP
$tahun_mulai = 2024;
$tahun_selesai = 2026;

// Recruitment data
$deskripsi = "Rekrutmen Asisten Praktikum Algoritma dan Pemrograman";
$status = "dibuka"; // dibuka, ditutup
$syarat = "Minimal IPK 3.5, Lulus mata kuliah...";
```

## **Tinggal lakukan:**

1. **Gunakan NIM format** 152022xxx untuk testing
2. **Check role_id** untuk menentukan akses
3. **Data sudah ada** - tinggal integrasi API
4. **Responsive design** dengan Bootstrap 5
5. **Mobile-first** approach

---

**Status: Database ✅ READY**  
**Frontend bisa mulai development!** 🚀 