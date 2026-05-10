<?php

namespace Tests\Feature;

use Tests\TestCase;

class MasterRoleTest extends TestCase
{
    protected $migrate = true;
    protected $refresh = true;
    protected $seed    = 'DatabaseSeeder';

    // =========================================================================
    // 1. SKENARIO ADMIN (ROLE 1) - BISA AKSES SEMUA
    // =========================================================================
    public function testAdminCanAccessAllCrud()
    {
        $this->loginAs(1, '152022001', 'Kepala Lab Admin');

        // Gunakan ID 1 (Admin) yang dipastikan aman dan tidak dihapus selama tes
        $validUserId = 1;

        // 1. Periode 
        $this->post('/periode_admin/store', [
            'nama_periode' => '2026/2027', 
            'tahun'        => '2026'
        ])->assertRedirect();
        
        $this->post('/periode_admin/update/1', [
            'nama_periode' => '2026/2027 Update', 
            'tahun'        => '2026'
        ])->assertRedirect();
        
        $this->get('/periode_admin/delete/1')->assertRedirect();

        // 2. Users 
        $this->post('/admin/users/create', [
            'nomor'    => '152022999', 
            'nama'     => 'User Test Lengkap', 
            'no_telp'  => '081234567899',
            'jurusan'  => 'Informatika',
            'role_id'  => 2,
            'password' => 'password123'
        ])->assertRedirect();
        
        $this->post('/admin/users/update/1', [
            'nama'    => 'Update Test',
            'no_telp' => '081234567899'
        ])->assertRedirect();
        
        // Hapus asisten dengan ID 26 (Bukan Admin)
        $this->post('/admin/users/delete/26')->assertRedirect(); 

        // 3. Rekrutmen
        $this->post('/rekrutmen/store', [
            'id_user'   => $validUserId,
            'id_jadwal' => 1,
            'deskripsi' => 'Rekrutmen Asisten Baru',
            'status'    => 'dibuka',
            'syarat'    => 'Minimal IPK 3.0'
        ])->assertRedirect();

        $this->post('/rekrutmen/update/1', [
            'id_user'   => $validUserId,
            'id_jadwal' => 1,
            'deskripsi' => 'Rekrutmen Diperbarui',
            'status'    => 'ditutup',
            'syarat'    => 'Minimal IPK 3.5'
        ])->assertRedirect();

        $this->get('/rekrutmen/delete/1')->assertRedirect();

        // 4. Galeri Umum
        $this->post('galeri_admin/store', [
            'kategori'       => 'foto',
            'keterangan'     => 'Foto Kegiatan 1',
            'file_url'       => '/uploads/test1.jpg',
            'tanggal_upload' => '2026-05-10',
            'id_user'        => $validUserId 
        ])->assertRedirect();
        
        $this->post('galeri_admin/update/1', [
            'kategori'       => 'foto',
            'keterangan'     => 'Foto Kegiatan 2',
            'file_url'       => '/uploads/test2.jpg',
            'tanggal_upload' => '2026-05-11',
            'id_user'        => $validUserId 
        ])->assertRedirect();
        
        $this->get('galeri_admin/delete/1')->assertRedirect();

        // 5. Modul Praktikum
        $this->post('modul-praktikum/create', [
            'judul'     => 'Modul IoT',
            'deskripsi' => 'Modul dasar IoT',
            'file_url'  => '/uploads/modul_iot.pdf',
            'id_jadwal' => 1
        ])->assertRedirect();
        
        $this->post('modul-praktikum/update/1', [
            'judul'     => 'Modul IoT V2',
            'deskripsi' => 'Update Modul dasar IoT',
            'file_url'  => '/uploads/modul_iot_v2.pdf',
            'id_jadwal' => 1
        ])->assertRedirect();
        
        $this->get('modul-praktikum/delete/1')->assertRedirect();

        // 6. Asisten (Diubah menjadi ID 25 agar Admin ID 1 tidak terhapus)
        $this->post('asisten/store', [
            'nomor'   => '152022888',
            'nama'    => 'Asisten Baru',
            'no_telp' => '08111222333',
            'jurusan' => 'Informatika',
            'role_id' => 2
        ])->assertRedirect();
        
        $this->post('asisten/update/25', ['nama' => 'Asisten Update'])->assertRedirect();
        $this->get('asisten/delete/25')->assertRedirect();

        // 7. Berita
        $this->post('berita/store', [
            'judul'    => 'Berita 1',
            'konten'   => 'Isi berita pengumuman lab',
            'kategori' => 'pengumuman',
            'tanggal'  => '2026-05-10',
            'id_user'  => $validUserId 
        ])->assertRedirect();
        
        $this->post('berita/update/1', [
            'judul'    => 'Berita 2',
            'konten'   => 'Isi berita update',
            'kategori' => 'seminar',
            'tanggal'  => '2026-05-11',
            'id_user'  => $validUserId 
        ])->assertRedirect();
        
        $this->get('berita/delete/1')->assertRedirect();

        // 8. Peserta Praktikum
        $this->post('peserta-praktikum/store', [
            'id_user'   => $validUserId, 
            'id_jadwal' => 1,
            'status'    => 'terdaftar'
        ])->assertRedirect();
        
        $this->post('peserta-praktikum/update/1', [
            'id_user'   => $validUserId,
            'id_jadwal' => 1,
            'status'    => 'lulus'
        ])->assertRedirect();
        
        $this->get('peserta-praktikum/delete/1')->assertRedirect();

        // 9. Visi Misi 
        $this->post('visi-misi_admin/store', [
            'judul' => 'Visi 1',
            'isi'   => 'Menjadi lab terbaik'
        ])->assertRedirect();
        
        $this->post('visi-misi_admin/update/1', [
            'judul' => 'Visi 2',
            'isi'   => 'Menjadi lab inovatif'
        ])->assertRedirect();
        
        $this->post('visi-misi_admin/delete/1')->assertRedirect();

        // 10. Events
        $this->post('/events/store', [
            'nama_event' => 'Event 1',
            'deskripsi'  => 'Deskripsi event praktikum',
            'jenis'      => 'praktikum',
            'created_by' => $validUserId
        ])->assertRedirect();
        
        $this->post('/events/update/1', [
            'nama_event' => 'Event 2',
            'deskripsi'  => 'Deskripsi event seminar',
            'jenis'      => 'seminar',
            'created_by' => $validUserId
        ])->assertRedirect();
        
        // Menghapus Event 6 agar Event 1 tetap hidup untuk dipakai oleh Jadwal di Langkah 11
        $this->get('/events/delete/6')->assertRedirect();

        // 11. JADWAL
        $this->post('/jadwal/store', [
            'id_event'      => 1,
            'tanggal'       => '2026-06-01',
            'waktu_mulai'   => '08:00:00', 
            'waktu_selesai' => '10:00:00',
            'ruangan'       => 'Lab Riset'
        ])->assertRedirect();
        
        $this->post('/jadwal/update/1', [
            'id_event'      => 1,
            'tanggal'       => '2026-06-02',
            'waktu_mulai'   => '10:00:00', 
            'waktu_selesai' => '12:00:00',
            'ruangan'       => 'Lab Cerdas'
        ])->assertRedirect();
        
        $this->get('/jadwal/delete/1')->assertRedirect();

        // 12. PROYEK RISET
        $this->post('proyek-riset/store', [
            'judul'         => 'Riset AI',
            'topik'         => 'machine learning',
            'deskripsi'     => 'Riset deteksi BCI',
            'mitra'         => 'Universitas Lain',
            'sumber_dana'   => 'Dikti',
            'tahun_mulai'   => '2025',
            'tahun_selesai' => '2027',
            'status'        => 'akan dilaksanakan',
            'id_user'       => $validUserId
        ])->assertRedirect();
        
        $this->post('proyek-riset/update/1', [
            'judul'         => 'Riset AI V2',
            'topik'         => 'deep learning',
            'deskripsi'     => 'Riset deteksi BCI Update',
            'mitra'         => 'Universitas Lain',
            'sumber_dana'   => 'Dikti',
            'tahun_mulai'   => '2025',
            'tahun_selesai' => '2027',
            'status'        => 'sedang dilaksanakan',
            'id_user'       => $validUserId
        ])->assertRedirect();
        
        $this->get('proyek-riset/delete/1')->assertRedirect();

        // 13. PUBLIKASI
        $this->post('publikasi-ilmiah/store', [
            'jenis_publikasi'   => 'jurnal',
            'judul'             => 'Paper Sistem Pakar',
            'link_publikasi'    => 'http://jurnal.com',
            'kategori'          => 'Internasional',
            'tanggal_publikasi' => '2026-05-10',
            'id_user'           => $validUserId
        ])->assertRedirect();
        
        $this->post('publikasi-ilmiah/update/1', [
            'jenis_publikasi'   => 'prosiding',
            'judul'             => 'Paper Sistem Pakar V2',
            'link_publikasi'    => 'http://jurnal.com/v2',
            'kategori'          => 'Nasional',
            'tanggal_publikasi' => '2026-05-11',
            'id_user'           => $validUserId
        ])->assertRedirect();
        
        $this->get('publikasi-ilmiah/delete/1')->assertRedirect();

        // 14. PROJECT LAB 
        $this->post('/project-lab/create', [
            'created_by'    => $validUserId, 
            'judul'         => 'Sistem Informasi Lab',
            'deskripsi'     => 'Deskripsi pengembangan sistem SSIP',
            'teknologi'     => 'CodeIgniter, MySQL',
            'tanggal_mulai' => '2026-01-01',
            'status'        => 'akan dilaksanakan'
        ])->assertRedirect();
        
        $this->post('/project-lab/update/1', [
            'created_by'    => $validUserId,
            'judul'         => 'Update Sistem Informasi',
            'deskripsi'     => 'Deskripsi update sistem SSIP',
            'teknologi'     => 'CodeIgniter, API',
            'tanggal_mulai' => '2026-01-01',
            'status'        => 'sedang dilaksanakan'
        ])->assertRedirect();
        
        // Penambahan id_project untuk memastikan tidak ada Column cannot be null
        $this->post('/project-lab/member/add', ['id_project' => 1, 'id_user' => $validUserId, 'role_project' => 'Programmer'])->assertRedirect();
        $this->get('/project-lab/delete/1')->assertRedirect();

        $this->get('/logout');
    }

    // =========================================================================
    // 2. SKENARIO ASISTEN (ROLE 2)
    // =========================================================================
    public function testAsistenCrudPermissions()
    {
        $this->loginAs(2, '152022006', 'Asisten Lab'); 

        // --- BISA AKSES (ROLE 1,2) ---
        $this->post('/jadwal/store', [
            'id_event'      => 1,
            'tanggal'       => '2026-06-03',
            'waktu_mulai'   => '13:00:00',
            'waktu_selesai' => '15:00:00',
            'ruangan'       => 'Lab Komputer 1'
        ])->assertRedirect();
        
        $this->post('/jadwal/update/1', [
            'id_event'      => 1,
            'tanggal'       => '2026-06-04',
            'waktu_mulai'   => '08:00:00',
            'waktu_selesai' => '10:00:00',
            'ruangan'       => 'Lab Komputer 2'
        ])->assertRedirect();
        
        $this->get('/jadwal/delete/1')->assertRedirect();

        // --- DITOLAK: PENGUJIAN MUTLAK DENGAN DATABASE ---
        $this->post('/periode_admin/store', ['nama_periode' => 'HACK_PERIODE', 'tahun' => '2099']);
        $this->dontSeeInDatabase('periode', ['nama_periode' => 'HACK_PERIODE']);

        $this->post('/admin/users/create', ['nomor' => '999999', 'nama' => 'HACK_USER', 'no_telp' => '123', 'jurusan' => 'IF', 'role_id' => 2, 'password' => '123']);
        $this->dontSeeInDatabase('users', ['nomor' => '999999']);

        $this->post('berita/store', ['judul' => 'HACK_BERITA', 'konten' => 'Hack', 'kategori' => 'pengumuman', 'tanggal' => '2099-01-01']);
        $this->dontSeeInDatabase('berita', ['judul' => 'HACK_BERITA']);

        $this->post('proyek-riset/store', ['judul' => 'HACK_RISET', 'deskripsi' => 'Hack', 'mitra' => 'Hack', 'sumber_dana' => 'Hack', 'tahun_mulai' => '2099', 'tahun_selesai' => '2099']);
        $this->dontSeeInDatabase('proyek_riset', ['judul' => 'HACK_RISET']);

        $this->post('/project-lab/create', ['judul' => 'HACK_LAB', 'deskripsi' => 'Hack', 'teknologi' => 'Hack', 'tanggal_mulai' => '2099-01-01']);
        $this->dontSeeInDatabase('project_lab', ['judul' => 'HACK_LAB']);

        $this->get('/logout');
    }

    // =========================================================================
    // 3. SKENARIO DOSEN (ROLE 3)
    // =========================================================================
    public function testDosenCrudPermissions()
    {
        $this->loginAs(3, '152022002', 'Dosen Riset');
        $validUserId = 1;

        // --- BISA AKSES (ROLE 1,3) ---
        $this->post('proyek-riset/store', [
            'judul'         => 'Riset AI Dosen',
            'topik'         => 'machine learning',
            'deskripsi'     => 'Pengujian algoritma BCI',
            'mitra'         => 'ITB',
            'sumber_dana'   => 'LPDP',
            'tahun_mulai'   => '2026',
            'tahun_selesai' => '2028',
            'status'        => 'akan dilaksanakan',
            'id_user'       => $validUserId
        ])->assertRedirect();
        
        $this->post('proyek-riset/update/1', [
            'judul'         => 'Riset AI Dosen v2',
            'topik'         => 'deep learning',
            'deskripsi'     => 'Pengujian algoritma BCI lanjutan',
            'mitra'         => 'ITB',
            'sumber_dana'   => 'LPDP',
            'tahun_mulai'   => '2026',
            'tahun_selesai' => '2028',
            'status'        => 'sedang dilaksanakan',
            'id_user'       => $validUserId
        ])->assertRedirect();
        
        $this->get('proyek-riset/delete/1')->assertRedirect();

        $this->post('publikasi-ilmiah/store', [
            'jenis_publikasi'   => 'jurnal',
            'judul'             => 'Paper BCI Dosen',
            'link_publikasi'    => 'http://jurnal.com',
            'kategori'          => 'Internasional',
            'tanggal_publikasi' => '2026-05-15',
            'id_user'           => $validUserId
        ])->assertRedirect();
        
        $this->post('publikasi-ilmiah/update/1', [
            'jenis_publikasi'   => 'prosiding',
            'judul'             => 'Paper BCI Dosen v2',
            'link_publikasi'    => 'http://jurnal.com/v2',
            'kategori'          => 'Nasional',
            'tanggal_publikasi' => '2026-05-16',
            'id_user'           => $validUserId
        ])->assertRedirect();
        
        $this->get('publikasi-ilmiah/delete/1')->assertRedirect();

        $this->post('/project-lab/create', [
            'created_by'    => $validUserId,
            'judul'         => 'Riset Drone Berbasis BCI',
            'deskripsi'     => 'Pengujian drone menggunakan sinyal EEG dan Python',
            'teknologi'     => 'Python, DJI SDK',
            'tanggal_mulai' => '2026-02-01',
            'status'        => 'sedang dilaksanakan'
        ])->assertRedirect();
        
        $this->post('/project-lab/update/1', [
            'created_by'    => $validUserId,
            'judul'         => 'Riset Lanjutan Drone',
            'deskripsi'     => 'Pengujian lanjutan formasi drone',
            'teknologi'     => 'Python, DJI SDK, OpenCV',
            'tanggal_mulai' => '2026-02-01',
            'status'        => 'selesai'
        ])->assertRedirect();
        
        $this->get('/project-lab/delete/1')->assertRedirect();

        // --- DITOLAK: PENGUJIAN MUTLAK DENGAN DATABASE ---
        $this->post('modul-praktikum/create', ['judul' => 'HACK_MODUL', 'deskripsi' => 'Hack', 'file_url' => 'hack', 'id_jadwal' => 1]);
        $this->dontSeeInDatabase('modul_praktikum', ['judul' => 'HACK_MODUL']);

        $this->post('visi-misi_admin/store', ['judul' => 'HACK_VISI', 'isi' => 'Hack']);
        $this->dontSeeInDatabase('content_visi_misi', ['judul' => 'HACK_VISI']);

        $this->post('/jadwal/store', ['tanggal' => '2099-01-01', 'waktu_mulai' => '08:00', 'waktu_selesai' => '10:00', 'id_event' => 1, 'ruangan' => 'HACK_RUANGAN']);
        $this->dontSeeInDatabase('jadwal', ['ruangan' => 'HACK_RUANGAN']);

        $this->get('/logout');
    }
}