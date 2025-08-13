# Frontend API Guide

Dokumen ini berisi panduan lengkap untuk menggunakan API backend dalam pengembangan frontend. API ini menyediakan endpoint-endpoint yang mengembalikan data dalam format JSON untuk setiap bagian dari website.

## Daftar Isi
1. [Penggunaan Dasar API](#penggunaan-dasar-api)
2. [Endpoint API Lengkap](#endpoint-api-lengkap)
3. [Contoh Implementasi](#contoh-implementasi)
4. [Struktur Data Response](#struktur-data-response)

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

## Contoh Implementasi

### Menggunakan Fetch API (JavaScript)

```javascript
// Mengambil data visi dan misi
async function getVisiMisi() {
  try {
    const response = await fetch('/api/visi-misi');
    const data = await response.json();
    console.log('Visi:', data.visi);
    console.log('Misi:', data.misi);
  } catch (error) {
    console.error('Error fetching visi misi:', error);
  }
}

// Mengambil daftar agenda
async function getAgenda() {
  try {
    const response = await fetch('/api/agenda');
    const agenda = await response.json();
    displayAgenda(agenda);
  } catch (error) {
    console.error('Error fetching agenda:', error);
  }
}

// Menampilkan agenda di DOM
function displayAgenda(agenda) {
  const agendaContainer = document.getElementById('agenda-container');
  agendaContainer.innerHTML = agenda.map(item => `
    <div class="agenda-item">
      <h3>${item.title}</h3>
      <p>Lab: ${item.lab}</p>
      <p>Tanggal: ${item.date}</p>
      <p>Waktu: ${item.time}</p>
      <p>Instruktur: ${item.instructor}</p>
    </div>
  `).join('');
}
```

### Menggunakan Axios (JavaScript)

```javascript
// Mengambil data personel
axios.get('/api/asisten')
  .then(response => {
    const personnel = response.data;
    displayPersonnel(personnel);
  })
  .catch(error => {
    console.error('Error fetching personnel:', error);
  });

// Mengambil data publikasi
axios.get('/api/publikasi')
  .then(response => {
    const publications = response.data;
    displayPublications(publications);
  })
  .catch(error => {
    console.error('Error fetching publications:', error);
  });
```

## Struktur Data Response

### Status Response
Semua endpoint mengembalikan response dengan struktur berikut:

```json
{
  "status": {
    "code": 200,
    "description": "OK"
  },
  "data": [/* data response */]
}
```

### Error Response
Jika terjadi error, response akan memiliki struktur:

```json
{
  "status": {
    "code": 404,
    "description": "Not Found"
  },
  "messages": {
    "error": "Data tidak ditemukan"
  }
}
```

### Tips Penggunaan
1. Selalu tangani error dalam implementasi frontend
2. Gunakan async/await atau promise untuk menangani response asynchronous
3. Cache data yang jarang berubah untuk meningkatkan performa
4. Gunakan loading state saat mengambil data dari API
5. Validasi data sebelum menampilkannya di UI

Dengan panduan ini, frontend developer dapat dengan mudah mengintegrasikan website dengan API backend yang telah disediakan.