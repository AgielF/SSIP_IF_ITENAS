<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AsistenSeeder extends Seeder
{
    public function run()
    {
        // Data asisten baru (21 asisten) - nama sesuai folder Foto Aslab Praktikum PBD
        $asistenData = [
            ['nomor' => '152022006', 'nama' => 'Aditya Budi Septiawan', 'no_telp' => '08123456790', 'foto' => 'uploads/photos/AdityaBudiSeptiawan.jpg'],
            ['nomor' => '152022007', 'nama' => 'Aliyya Rahmawati Putri', 'no_telp' => '08123456791', 'foto' => 'uploads/photos/AliyyaRahmawatiPutri.jpg'],
            ['nomor' => '152022008', 'nama' => 'Delisya Pramesti Fitriya', 'no_telp' => '08123456792', 'foto' => 'uploads/photos/DelisyaPramestiFitriya.jpg'],
            ['nomor' => '152022009', 'nama' => 'Dindin Imanudin', 'no_telp' => '08123456793', 'foto' => 'uploads/photos/DindinImanudin.jpg'],
            ['nomor' => '152022010', 'nama' => 'Fathurrahman Pratama Putra', 'no_telp' => '08123456794', 'foto' => 'uploads/photos/FathurrahmanPratamaPutra.jpg'],
            ['nomor' => '152022011', 'nama' => 'Felix Angga Resky', 'no_telp' => '08123456795', 'foto' => 'uploads/photos/FelixAnggaResky.jpg'],
            ['nomor' => '152022012', 'nama' => 'Ghinova Klarisa Irawadi', 'no_telp' => '08123456796', 'foto' => 'uploads/photos/GhinovaKlarisaIrawadi.jpg'],
            ['nomor' => '152022013', 'nama' => 'Hikam Hikmatul Huda', 'no_telp' => '08123456797', 'foto' => 'uploads/photos/HikamHikmatulHuda.jpg'],
            ['nomor' => '152022014', 'nama' => 'Moh Ilyas', 'no_telp' => '08123456798', 'foto' => 'uploads/photos/MohIlyas.jpg'],
            ['nomor' => '152022015', 'nama' => 'Muhamad Rizky', 'no_telp' => '08123456799', 'foto' => 'uploads/photos/MuhamadRizky.jpg'],
            ['nomor' => '152022016', 'nama' => 'Muhammad Hasby As-shiddiqy', 'no_telp' => '08123456800', 'foto' => 'uploads/photos/MuhammadHasbyAs-shiddiqy.jpg'],
            ['nomor' => '152022017', 'nama' => 'Muhammad Rifqi Yusufi', 'no_telp' => '08123456801', 'foto' => 'uploads/photos/MuhammadRifqiYusufi.jpg'],
            ['nomor' => '152022018', 'nama' => 'Nakhwa Ghinayah Rahadatul Aisy', 'no_telp' => '08123456802', 'foto' => 'uploads/photos/NakhwaGhinayahRahadatulAisy.jpg'],
            ['nomor' => '152022019', 'nama' => 'Nasywa Adita Zain', 'no_telp' => '08123456803', 'foto' => 'uploads/photos/NasywaAditaZain.jpg'],
            ['nomor' => '152022020', 'nama' => 'Nazwa Nur Salsa Bella', 'no_telp' => '08123456804', 'foto' => 'uploads/photos/NazwaNurSalsaBella.jpg'],
            ['nomor' => '152022021', 'nama' => 'Nizar Abdul Malik', 'no_telp' => '08123456805', 'foto' => 'uploads/photos/NizarAbdulMalik.jpg'],
            ['nomor' => '152022022', 'nama' => 'Raden Muhammad Ariil Al Hafizh', 'no_telp' => '08123456806', 'foto' => 'uploads/photos/RadenMuhammadAriilAlHafizh.jpg'],
            ['nomor' => '152022023', 'nama' => 'Rizki Saepul Aziz', 'no_telp' => '08123456807', 'foto' => 'uploads/photos/RizkiSaepulAziz.jpg'],
            ['nomor' => '152022024', 'nama' => 'Sintia Wati', 'no_telp' => '08123456808', 'foto' => 'uploads/photos/SintiaWati.jpg'],
            ['nomor' => '152022025', 'nama' => 'Taras Al Fariz', 'no_telp' => '08123456809', 'foto' => 'uploads/photos/TarasAlFariz.jpg'],
            ['nomor' => '152022026', 'nama' => 'Tedy Sukma Permana', 'no_telp' => '08123456810', 'foto' => 'uploads/photos/TedySukmaPermana.jpg'],
        ];

        // Cek dan insert/update asisten
        foreach ($asistenData as $asisten) {
            $existing = $this->db->table('users')->where('nomor', $asisten['nomor'])->get()->getRow();
            if ($existing) {
                // Update jika sudah ada (tanpa mengubah password)
                $updateData = [
                    'nama' => $asisten['nama'],
                    'no_telp' => $asisten['no_telp'],
                    'foto' => $asisten['foto'],
                    'jurusan' => 'Informatika',
                    'role_id' => 2, // asisten
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $this->db->table('users')->where('nomor', $asisten['nomor'])->update($updateData);
                echo "Updated asisten: {$asisten['nama']} ({$asisten['nomor']})\n";
            } else {
                // Insert baru
                $newAsisten = [
                    'nomor' => $asisten['nomor'],
                    'nama' => $asisten['nama'],
                    'no_telp' => $asisten['no_telp'],
                    'foto' => $asisten['foto'],
                    'jurusan' => 'Informatika',
                    'role_id' => 2, // asisten
                    'password' => password_hash('asisten123', PASSWORD_DEFAULT),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $this->db->table('users')->insert($newAsisten);
                echo "Inserted new asisten: {$asisten['nama']} ({$asisten['nomor']})\n";
            }
        }
    }
}