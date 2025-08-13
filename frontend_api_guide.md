## Penggunaan Dasar API

Semua endpoint API dapat diakses melalui URL dasar website diikuti dengan path endpoint. Semua endpoint menggunakan metode HTTP GET dan mengembalikan data dalam format JSON.

Contoh URL dasar:
```
http://localhost:8080/api/endpoint-name
```

## Endpoint API Lengkap

### 1. Informasi Dasar

#### GET /api/visi-misi
Mengambil visi dan misi laboratorium.

**Response:**
```json
{
  "visi": "Visi laboratorium...",
  "misi": "Misi laboratorium..."
}
```

### 2. Agenda & Jadwal

#### GET /api/agenda
Mengambil daftar agenda/acara lengkap dengan detail jadwal.

**Response:**
```json
[
  {
    "title": "Praktikum Fisika Dasar",
    "lab": "Lab Fisika A",
    "status": "Upcoming",
    "status_color": "success",
    "date": "Senin, 15 Agustus 2025",
    "time": "08:00 - 12:00",
    "instructor": "Dr. Budi Santoso",
    "actions": ["details", "cancel"]
  }
]
```

#### GET /api/jadwal
Mengambil daftar jadwal (sama dengan /api/agenda).

#### GET /api/jadwal-list
Mengambil daftar jadwal dalam format card (sama dengan /api/agenda).

### 3. Personel Laboratorium

#### GET /api/asisten
Mengambil daftar semua personel laboratorium (asisten, dosen, praktikan).

**Response:**
```json
[
  {
    "id": 1,
    "nama": "Andi Prasetyo",
    "role": "asisten",
    "email": "andi@universitas.ac.id"
  },
  {
    "id": 2,
    "nama": "Dr. Budi Santoso",
    "role": "dosen",
    "email": "budi@universitas.ac.id"
  }
]
```

#### GET /api/asisten-admin
Mengambil daftar asisten untuk admin (sama dengan /api/asisten).

### 4. Penelitian & Proyek

#### GET /api/penelitian-proyek
Mengambil daftar proyek riset laboratorium.

**Response:**
```json
[
  {
    "id_proyek": 1,
    "judul": "Pengembangan Material Nano",
    "penanggung_jawab": "Dr. Budi Santoso",
    "tahun": "2025"
  }
]
```

#### GET /api/proyek-riset
Mengambil daftar proyek riset (alternatif endpoint, sama dengan /api/penelitian-proyek).

### 5. Publikasi

#### GET /api/publikasi
Mengambil daftar publikasi ilmiah laboratorium.

**Response:**
```json
[
  {
    "id_publikasi": 1,
    "judul": "Studi tentang Material Konduktif",
    "penulis": "Dr. Budi Santoso",
    "tahun": "2025",
    "jenis_publikasi": "jurnal"
  }
]
```

#### GET /api/publikasi-page
Mengambil daftar publikasi untuk halaman publikasi (sama dengan /api/publikasi).

### 6. Galeri

#### GET /api/galeri
Mengambil daftar item galeri (foto/video).

**Response:**
```json
[
  {
    "id_galeri": 1,
    "kategori": "foto",
    "keterangan": "Kegiatan Praktikum 2025",
    "file_url": "/assets/galeri/foto1.jpg",
    "uploader": "Andi Prasetyo"
  }
]
```

### 7. Repositori

#### GET /api/repositori
Mengambil daftar modul praktikum.

**Response:**
```json
[
  {
    "id_modul": 1,
    "judul": "Modul Praktikum Fisika Dasar I",
    "deskripsi": "Modul untuk praktikum fisika dasar semester ganjil",
    "file_url": "/assets/modul/modul1.pdf"
  }
]
```

### 8. Rekrutmen

#### GET /api/rekrutmen
Mengambil daftar rekrutmen asisten.

**Response:**
```json
[
  {
    "id_rekrut": 1,
    "judul": "Rekrutmen Asisten Praktikum Semester Ganjil 2025/2026",
    "pembuat": "Dr. Budi Santoso",
    "tanggal": "2025-08-15"
  }
]
```

#### GET /api/rekrutmen-page
Mengambil daftar rekrutmen untuk halaman rekrutmen (sama dengan /api/rekrutmen).

### 9. Berita

#### GET /api/berita
Mengambil daftar berita laboratorium.

**Response:**
```json
[
  {
    "id_berita": 1,
    "judul": "Prestasi Mahasiswa Laboratorium",
    "penulis": "Dr. Budi Santoso",
    "tanggal": "2025-08-10",
    "konten": "Mahasiswa laboratorium berhasil meraih juara..."
  }
]
```

### 10. Events

#### GET /api/events
Mengambil daftar events laboratorium.

**Response:**
```json
[
  {
    "id_event": 1,
    "nama_event": "Seminar Teknologi Nano",
    "creator": "Dr. Budi Santoso",
    "tanggal": "2025-08-20"
  }
]
```

### 11. Peserta Praktikum

#### GET /api/peserta-praktikum
Mengambil daftar peserta praktikum.

**Response:**
```json
[
  {
    "id_peserta": 1,
    "nama_peserta": "Andi Prasetyo",
    "tanggal": "2025-08-15",
    "status": "terdaftar",
    "nilai": null
  }
]
```