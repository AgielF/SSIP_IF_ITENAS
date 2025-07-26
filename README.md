# SSIP_IF_ITENAS

## Progress Minggu 1

### 1. Setup Project
- Inisialisasi project CodeIgniter 4.
- Konfigurasi database pada `.env` dan `app/Config/Database.php`.

### 2. Pembuatan Migration
- Membuat migration untuk tabel:
  - `roles`
  - `users`
  - `events`
  - `jadwal`
  - `asisten_jadwal`
- Mengatur relasi antar tabel menggunakan foreign key.

### 3. Pembuatan Seeder
- Membuat seeder untuk mengisi data dummy pada setiap tabel:
  - `RolesSeeder`
  - `UsersSeeder`
  - `EventsSeeder`
  - `JadwalSeeder`
  - `AsistenJadwalSeeder`
- Seeder diletakkan di folder `app/Database/Seeds/`.

### 4. Menjalankan Migration dan Seeder

**Jalankan migrasi:**
```sh
php spark migrate
```

**Jalankan seeder (masing-masing):**
```sh
php spark db:seed RolesSeeder
php spark db:seed UsersSeeder
php spark db:seed EventsSeeder
php spark db:seed JadwalSeeder
php spark db:seed AsistenJadwalSeeder
```

**Atau jalankan semua seeder sekaligus dengan DatabaseSeeder:**
```sh
php spark db:seed DatabaseSeeder
```

### 5. Git Workflow: Push ke Branch Tertentu

1. Pastikan berada di folder project:
   ```sh
   cd /c/@PC/Laragon/laragon/www/SSIP_IF_ITENAS
   ```
2. Checkout ke branch tujuan (misal: `jeffry`):
   ```sh
   git checkout jeffry
   ```
3. Tambahkan dan commit perubahan:
   ```sh
   git add .
   git commit -m "Progress minggu 1: setup migration dan seeder"
   ```
4. Push ke remote:
   ```sh
   git push origin jeffry
   ```

---

**Catatan:**
- Pastikan urutan migration sesuai dependensi foreign key.
- Jika ada error pada seeder, cek kembali nama kolom di migration dan seeder harus sama.
- Untuk reset database dan migrasi ulang:
  ```sh
  php spark migrate:refresh
  ```
