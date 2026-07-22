<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * ConfigSertifikatSeeder
 *
 * Mengisi tabel `config_sertifikat` dengan data konfigurasi master sertifikat.
 *
 * Menggunakan metode replace() agar idempotent:
 *   - INSERT jika record belum ada
 *   - DELETE + INSERT jika record sudah ada (berdasarkan PK)
 * Aman dijalankan berulang kali tanpa menyebabkan duplikasi.
 *
 * CATATAN: Kolom file upload (template_gambar, ttd_kepala_lab, ttd_ketua_prodi)
 * dikosongkan (NULL) karena file fisik tidak dapat disertakan dalam seeder.
 * Administrator perlu mengupload ulang file-file tersebut melalui admin panel.
 */
class ConfigSertifikatSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'id'                 => 1,
            'template_gambar'    => null,
            'judul'              => 'SERTIFIKAT APRESIASI',
            'deskripsi_template' => 'telah berdidikasi sebagai asisten laboratorium PCD',
            'nama_kepala_lab'    => 'Jasman Pardede',
            'ttd_kepala_lab'     => null,
            'nama_ketua_prodi'   => 'Dr. sc. Lisa Kristiana, ST., MT.',
            'ttd_ketua_prodi'    => null,
            'updated_at'         => date('Y-m-d H:i:s'),
        ];

        // replace() = INSERT jika belum ada, DELETE+INSERT jika sudah ada (by PK)
        $this->db->table('config_sertifikat')->replace($data);

        echo "[ConfigSertifikatSeeder] Konfigurasi sertifikat berhasil di-seed (id=1).\n";
        echo "[ConfigSertifikatSeeder] PERHATIAN: File template dan TTD perlu diupload ulang via admin panel.\n";
    }
}
