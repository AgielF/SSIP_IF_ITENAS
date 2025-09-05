<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nomor', 'nama', 'no_telp', 'jurusan', 'role_id', 'created_at', 'updated_at'];
<<<<<<< HEAD

    public function getUserByRole($roleId)
    {
        return $this->select('users.*, roles.role_name')
            ->join('roles', 'roles.id = users.role_id')
            ->findAll();
    }

    public function getAsistenLab () 
=======
    
    // FUNGSI YANG SUDAH ADA (TIDAK DIUBAH)
    public function getAsistenLab() 
>>>>>>> agiel
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
<<<<<<< HEAD
    
    public function getUsersWithRoles()
    {
        return $this->select('users.*, roles.role_name')
                    ->join('roles', 'roles.id = users.role_id')
                    ->findAll();
=======

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
>>>>>>> agiel
    }
}