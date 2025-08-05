# SSIP IF ITENAS - Sistem Informasi Akademik

## 📋 Project Overview

SSIP IF ITENAS adalah sistem informasi akademik yang dirancang untuk mengelola kegiatan akademik di jurusan Informatika. Sistem ini mencakup manajemen user, events, praktikum, publikasi, riset, berita, galeri, dan rekrutmen asisten.

## 🗓️ Progress Timeline

### **Minggu 1: Planning & Design**
- ✅ Database schema design (DBML)
- ✅ System architecture planning
- ✅ Requirements analysis
- ✅ Technology stack selection

### **Minggu 2: Database Implementation** ⭐ **CURRENT**
- ✅ Complete database structure (13 tables)
- ✅ Migration files (14 files)
- ✅ Seeder files with realistic data (14 files)
- ✅ Model files (13 files)
- ✅ Data integrity and relationships
- ✅ Comprehensive test data

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
Git
```

### **Installation Steps**
```bash
# 1. Clone repository
git clone [repository-url]
cd SSIP_IF_ITENAS

# 2. Install dependencies
composer install

# 3. Configure database
cp env .env
# Edit .env with database credentials

# 4. Run migrations
php spark migrate

# 5. Seed database
php spark db:seed DatabaseSeeder

# 6. Start development server
php spark serve
```

### **Database Setup**
```sql
-- Database will be created automatically
-- All tables will be created via migrations
-- Sample data will be inserted via seeders
```

## 🎯 Next Phase (Minggu 3-4)

### **Backend Development**
- [ ] Controller implementation
- [ ] API endpoints
- [ ] Authentication system
- [ ] Authorization middleware
- [ ] File upload handling

### **Frontend Development**
- [ ] HTML templates
- [ ] CSS styling
- [ ] JavaScript functionality
- [ ] Bootstrap integration
- [ ] Responsive design

### **Integration**
- [ ] API integration
- [ ] Form handling
- [ ] Data validation
- [ ] Error handling
- [ ] User feedback

## 🛠️ Development Guidelines

### **Code Standards**
- PSR-12 coding standards
- Consistent naming conventions
- Proper documentation
- Error handling
- Security best practices

### **Database Conventions**
- Snake_case for table/column names
- Proper foreign key relationships
- Index optimization
- Data validation constraints

### **Frontend Conventions**
- Semantic HTML5
- BEM CSS methodology
- ES6+ JavaScript
- Mobile-first responsive design

## 📝 Documentation

### **API Documentation**
- RESTful API endpoints
- Request/response formats
- Authentication methods
- Error codes

### **User Manual**
- Admin guide
- Dosen guide
- Asisten guide
- Mahasiswa guide

## 📄 License

This project is licensed under the MIT License.

---

**Week 2 Status: ✅ COMPLETE**  
**Next Milestone: Frontend Development** 🚀
