<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nomor', 'nama', 'no_telp', 'jurusan','password', 'role_id', 'created_at', 'updated_at'];
    
    // FUNGSI YANG SUDAH ADA (TIDAK DIUBAH)
    public function getAsistenLab() 
    {
        return $this->where('role_id', 2)->findAll();
    }
    
    public function getDosenLab()
    {
        return $this->where('role_id', 4)->findAll();
    }

    public function praktikan()
    {
        return $this->where('role_id', 3)->findAll();
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
        $asisten = $this->getAsistenLab();
        $dosen = $this->getDosenLab();
        $praktikan = $this->praktikan();
        
        
        $allPersonnel = [];
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
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
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