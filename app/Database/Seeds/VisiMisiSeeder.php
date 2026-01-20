<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class VisiMisiSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'judul' => 'Visi',
                'isi'   => 'To become a center of excellence in the development of smart systems and information processing technology that is innovative, adaptive, and applicable to the needs of society and data-based industry.',
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'judul' => 'Misi',
                'isi'   => "1. Organizing educational and practical activities based on smart systems and information processing.\n2. Carrying out innovative research in the fields of AI, machine learning, deep learning, data mining, IR, NLP, and expert systems.\n3. Providing a collaborative platform for lecturers, students, and industry to develop smart data-based solutions.\n4. Encourage scientific publications, research products, and patents based on exploration results in the field of smart systems and data processing.\n5. Building a project-based learning ecosystem that is relevant to the needs of the global workplace and research world.",
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('content_visi_misi')->insertBatch($data);
    }
}