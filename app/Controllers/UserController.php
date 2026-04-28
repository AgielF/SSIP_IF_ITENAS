<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PeriodeModel;        // Ditambahkan
use App\Models\AsistenPeriodeModel; // Ditambahkan

class UserController extends BaseController
{
    protected $userModel;
    protected $periodeModel;        // Ditambahkan
    protected $asistenPeriodeModel; // Ditambahkan

    public function __construct()
    {
        $this->userModel = new UserModel();
        // Inisialisasi model baru
        $this->periodeModel = new PeriodeModel();
        $this->asistenPeriodeModel = new AsistenPeriodeModel();
    }

    /**
     * Menampilkan daftar semua anggota laboratorium (untuk user biasa).
     */
    public function index()
    {
        // Panggil model periode
        $periodeModel = new \App\Models\PeriodeModel();

        return view('asisten_list_view', [
            'title'       => 'Anggota Laboratorium',
            'asisten'     => $this->userModel->getProcessedPersonnelData(),
            'listPeriode' => $periodeModel->findAll() // 🔹 DITAMBAHKAN INI
        ]);
    }

    /**
     * Menampilkan daftar semua anggota (untuk admin).
     */
    public function getDataAdmin()
    {
        // 🔹 DIUBAH: Tambah join ke tabel pivot asisten_periode dan tabel periode
        $users = $this->userModel->select('users.*, roles.role_name, periode.nama_periode')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->join('asisten_periode', 'asisten_periode.id_user = users.id', 'left')
            ->join('periode', 'periode.id_periode = asisten_periode.id_periode', 'left')
            ->orderBy('users.created_at', 'DESC')
            ->findAll();

        // Map role_name ke format yang konsisten untuk view
        $processedUsers = [];
        foreach ($users as $user) {
            $roleName = $user['role_name'] ?? 'user';
            $user['role'] = strtolower($roleName); 
            // 🔹 DITAMBAHKAN: Default string jika user belum memiliki periode (misal: admin/dosen)
            $user['nama_periode'] = $user['nama_periode'] ?? '-'; 
            $processedUsers[] = $user;
        }

        // 🔹 DITAMBAHKAN: Ambil daftar periode untuk dikirim ke view (berguna untuk dropdown form)
        $listPeriode = $this->periodeModel->findAll();

        return view('asisten_admin_list_view', [
            'title'       => 'Kelola Anggota Laboratorium',
            'asisten'     => $processedUsers,
            'listPeriode' => $listPeriode // Kirim data periode
        ]);
    }

    /**
     * Menampilkan profil anggota berdasarkan ID
     */
    public function profil($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Mapping role_id sesuai seed: 1 admin, 2 asisten, 3 dosen, 4 praktikan/mahasiswa
        $roleMap = [
            1 => 'admin',
            2 => 'asisten',
            3 => 'dosen',
            4 => 'praktikan'
        ];
        $user['role'] = $roleMap[$user['role_id']] ?? 'tidak diketahui';

        // 🔹 Ambil data publikasi & proyek
        $publikasiModel = new \App\Models\PublikasiModel();
        $proyekModel    = new \App\Models\ProyekRisetModel();

        $publicationData = $publikasiModel->where('id_user', $id)->findAll() ?? [];
        $proyekData      = $proyekModel->where('id_user', $id)->findAll() ?? [];

        return view('user_profile_view', [
            'title'           => 'Profil Anggota | ' . $user['nama'],
            'user'            => $user,
            'publicationData' => $publicationData,
            'proyekData'      => $proyekData
        ]);
    }

    /**
     * Tambah user baru
     */
    public function store()
    {
        $roleId = $this->request->getPost('role_id');

        $data = [
            'nomor'     => $this->request->getPost('nomor'),
            'nama'      => $this->request->getPost('nama'),
            'no_telp'   => $this->request->getPost('no_telp'),
            'jurusan'   => $this->request->getPost('jurusan'),
            'password'  => $this->request->getPost('password'), // tanpa hash (akan dihash otomatis oleh UserModel)
            'role_id'   => $roleId,
            'created_at'=> date('Y-m-d H:i:s'),
        ];

        // 🔹 DITAMBAHKAN: Mulai transaksi database agar aman
        $this->userModel->db->transStart();

        $this->userModel->insert($data);
        $userId = $this->userModel->getInsertID(); // Ambil ID dari user yang baru ditambahkan

        // 🔹 DITAMBAHKAN: Jika user adalah asisten (role 2) dan ada input id_periode, simpan ke tabel pivot
        if ($roleId == 2 && !empty($this->request->getPost('id_periode'))) {
            $this->asistenPeriodeModel->insert([
                'id_user'    => $userId,
                'id_periode' => $this->request->getPost('id_periode'),
                'jabatan'    => 'Asisten Praktikum',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        // 🔹 DITAMBAHKAN: Selesaikan transaksi
        $this->userModel->db->transComplete();

        return redirect()->to('/asisten_admin')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Update data user
     */
    public function update($id)
    {
        $roleId = $this->request->getPost('role_id');

        $updateData = [
            'nomor'     => $this->request->getPost('nomor'),
            'nama'      => $this->request->getPost('nama'),
            'no_telp'   => $this->request->getPost('no_telp'),
            'jurusan'   => $this->request->getPost('jurusan'),
            'role_id'   => $roleId,
            'updated_at'=> date('Y-m-d H:i:s'),
        ];

        if (!empty($this->request->getPost('password'))) {
            $updateData['password'] = $this->request->getPost('password'); 
        }

        // 🔹 DITAMBAHKAN: Mulai transaksi database
        $this->userModel->db->transStart();
        
        $this->userModel->update($id, $updateData);

        // 🔹 DITAMBAHKAN: Update relasi asisten periode
        if ($roleId == 2 && !empty($this->request->getPost('id_periode'))) {
            // Cek apakah relasi sudah ada sebelumnya
            $existingRelasi = $this->asistenPeriodeModel->where('id_user', $id)->first();
            
            if ($existingRelasi) {
                // Update data jika sudah ada
                $this->asistenPeriodeModel->update($existingRelasi['id'], [
                    'id_periode' => $this->request->getPost('id_periode'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                // Insert baru jika sebelumnya belum punya periode
                $this->asistenPeriodeModel->insert([
                    'id_user'    => $id,
                    'id_periode' => $this->request->getPost('id_periode'),
                    'jabatan'    => 'Asisten Praktikum',
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        // 🔹 DITAMBAHKAN: Selesaikan transaksi
        $this->userModel->db->transComplete();

        return redirect()->to('/asisten_admin')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Hapus user
     */
    public function delete($id)
    {
        // Fitur hapus tidak perlu diubah, 
        // karena Foreign Key 'ON DELETE CASCADE' otomatis menghapus data di tabel asisten_periode
        $this->userModel->delete($id);
        return redirect()->to('/asisten_admin')->with('success', 'User berhasil dihapus.');
    }
}