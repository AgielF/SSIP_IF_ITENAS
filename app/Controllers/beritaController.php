<?php

namespace App\Controllers;

use App\Models\BeritaModel;

class BeritaController extends BaseController
{
    protected $beritaModel;

    public function __construct()
    {
        $this->beritaModel = new BeritaModel();
    }

    
    public function index()
    {
        // Ambil kategori dari query string (?kategori=seminar)
        $kategori = $this->request->getGet('kategori');

        $builder = $this->beritaModel
            ->select('berita.*, users.nama as creator')
            ->join('users', 'users.id = berita.id_user')
            ->orderBy('berita.tanggal', 'DESC');

        if ($kategori && $kategori !== 'semua') {
            $builder->where('berita.kategori', $kategori);
        }

        $berita = $builder->findAll();

        return view('berita_list_view', [
            'schedules' => $berita,
            'kategoriAktif' => $kategori ?? 'semua'
        ]);
    }
    public function admin(){
        // Ambil kategori dari query string (?kategori=seminar)
        $kategori = $this->request->getGet('kategori');

        $builder = $this->beritaModel
            ->select('berita.*, users.nama as creator')
            ->join('users', 'users.id = berita.id_user')
            ->orderBy('berita.tanggal', 'DESC');

        if ($kategori && $kategori !== 'semua') {
            $builder->where('berita.kategori', $kategori);
        }

        $berita = $builder->findAll();

        return view('berita_list_admin_view', [
            'schedules' => $berita,
            'kategoriAktif' => $kategori ?? 'semua'
        ]);
    }




    // 💾 Simpan berita baru
    public function store()
    {
        $userId = $this->getUserIdOrRedirect(); // ✅ langsung ambil id user 
        $data = [
            'judul' => $this->request->getPost('judul'),
            'konten' => $this->request->getPost('konten'),
            'kategori' => $this->request->getPost('kategori'),
            'tanggal' => $this->request->getPost('tanggal'),
            'id_user' => $userId, // default admin user
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->beritaModel->insert($data);

        return redirect()->to('/berita')->with('success', 'Berita berhasil ditambahkan');
    }


    // 🔄 Update berita
    public function update($id)
    {
         $userId = $this->getUserIdOrRedirect(); // ✅ langsung ambil id user 
        $data = [
            'judul' => $this->request->getPost('judul'),
            'konten' => $this->request->getPost('konten'),
            'kategori' => $this->request->getPost('kategori'),
            'tanggal' => $this->request->getPost('tanggal'),
            'id_user' => $userId,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->beritaModel->update($id, $data);

        return redirect()->to('/berita')->with('success', 'Berita berhasil diperbarui');
    }

    // ❌ Hapus berita
    public function delete($id)
    {
        $this->beritaModel->delete($id);

        return redirect()->to('/berita')->with('success', 'Berita berhasil dihapus');
    }
}
