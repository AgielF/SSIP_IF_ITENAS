<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useTimestamps = true; // [T3.1] CI4 mengelola timestamps otomatis
    protected $allowedFields = ['nomor', 'nama', 'no_telp', 'jurusan','password', 'role_id', 'foto'];
    
    // 🔹 DIUBAH: Fungsi ini sekarang melakukan JOIN untuk mengambil data periode
    public function getAsistenLab() 
    {
        return $this->select('users.*, periode.nama_periode')
            ->join('asisten_periode', 'asisten_periode.id_user = users.id', 'left')
            ->join('periode', 'periode.id_periode = asisten_periode.id_periode', 'left')
            ->where('users.role_id', 2)
            ->findAll();
    }
    
    // FUNGSI YANG SUDAH ADA (TIDAK DIUBAH)
    public function getDosenLab()
    {
        // Sesuai seed: dosen memiliki role_id = 3
        return $this->where('role_id', 3)->findAll();
    }

    public function praktikan()
    {
        // Praktikan/mahasiswa gunakan role_id terpisah (jika ada), default kosong
        return $this->where('role_id', 4)->findAll();
    }
    
    public function admin(){
        return $this->where('role_id',1)->findAll();
    }

    // FUNGSI YANG DIINTEGRASIKAN DAN DIPERBAIKI
    /**
     * Mengambil dan memproses data personel dari beberapa peran.
     * @return array
     */
    public function getProcessedPersonnelData(): array
    {
        // 1. Panggil fungsi lain di dalam kelas ini menggunakan "$this"
        $admin = $this->admin();
        $asisten = $this->getAsistenLab(); // 🔹 Variabel $asisten ini sekarang membawa field "nama_periode"
        $dosen = $this->getDosenLab();
        $praktikan = $this->praktikan();


        $allPersonnel = [];
        foreach ($admin as $adm) {
            $adm['role'] = 'admin'; // Menambahkan key 'role'
            $allPersonnel[] = $adm;
        }
        foreach ($dosen as $d) {
            $d['role'] = 'dosen'; // Menambahkan key 'role'
            $allPersonnel[] = $d;
        }
        foreach ($asisten as $a) {
            $a['role'] = 'asisten';
            $allPersonnel[] = $a;
        }
        foreach ($praktikan as $p) {
            $p['role'] = 'praktikan';
            $allPersonnel[] = $p;
        }

        return $allPersonnel;
    }
    
    protected function hashPassword(array $data){

        if (isset($data['data']['password'])) {
            // Use bcrypt with cost factor for better security
            $options = [
                'cost' => 12, // Higher cost for more security (slower hashing)
            ];
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_BCRYPT, $options);
        }

        return $data;
    }

    public function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];
}