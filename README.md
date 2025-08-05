Sistem Informasi Laboratorium (SSIP) - IF Itenas
Ini adalah repositori untuk proyek Sistem Informasi Laboratorium (SSIP) yang dibangun menggunakan CodeIgniter 4. Proyek ini bertujuan untuk mengelola berbagai aspek kegiatan laboratorium, termasuk jadwal, data pengguna, event, dan lainnya.

Prasyarat
Sebelum memulai, pastikan lingkungan pengembangan Anda telah memenuhi persyaratan berikut:

PHP versi 7.4 atau lebih baru

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
