<?php

namespace App\Controllers;

use App\Models\VisiMisiModel;
use CodeIgniter\Controller;

class VisiMisiController extends BaseController
{
    protected $visiMisiModel;

    public function __construct()
    {
        // Inisialisasi model
        $this->visiMisiModel = new VisiMisiModel();
    }

    // 1. READ: Menampilkan daftar data Visi & Misi
    public function index()
    {
        $data = [
            'title'     => 'Daftar Visi Misi',
            'visi_misi' => $this->visiMisiModel->findAll()
        ];

        // Sesuaikan path view dengan lokasi file Anda (misal: admin/visi_misi/index)
        return view('visi-misi_admin_list', $data);
    }

    // 2. CREATE: Memproses simpan data baru
    // Rute: POST visi-misi_admin/store -> VisiMisiController::create
    public function create()
    {
        // Aturan validasi
        $rules = [
            'judul' => 'required',
            'isi'   => 'required'
        ];

        // Cek validasi input
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Simpan data
        $this->visiMisiModel->insert([
            'judul' => $this->request->getPost('judul'),
            'isi'   => $this->request->getPost('isi')
        ]);

        return redirect()->to('/visi-misi_admin')->with('success', 'Data Visi Misi berhasil ditambahkan.');
    }

    // 3. UPDATE: Memproses perubahan data ke database
    // Rute: POST visi-misi_admin/update/(:num)
    public function update($id = null)
    {
        // Aturan validasi
        $rules = [
            'judul' => 'required',
            'isi'   => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update data
        $this->visiMisiModel->update($id, [
            'judul' => $this->request->getPost('judul'),
            'isi'   => $this->request->getPost('isi')
        ]);

        return redirect()->to('/visi-misi_admin')->with('success', 'Data Visi Misi berhasil diperbarui.');
    }

    // 4. DELETE: Menghapus data dari database
    // Rute: POST visi-misi_admin/delete/(:num)
    public function delete($id = null)
    {
        // Cek apakah data ada
        $data = $this->visiMisiModel->find($id);
        
        if ($data) {
            $this->visiMisiModel->delete($id);
            return redirect()->to('/visi-misi_admin')->with('success', 'Data Visi Misi berhasil dihapus.');
        }

        return redirect()->to('/visi-misi_admin')->with('error', 'Data tidak ditemukan.');
    }
}