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
        // 🛡️ 1. VALIDASI INPUT
        $rules = [
            'judul'    => 'required|max_length[100]',
            'konten'   => 'required',
            'kategori' => 'required|max_length[50]',
            'tanggal'  => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Format data tidak valid: ' . implode(', ', $this->validator->getErrors()));
        }

        // 🛡️ 2. TRY-CATCH ERROR HANDLING
        try {
            $userId = $this->getUserIdOrRedirect();
            $data = [
                'judul'    => $this->request->getPost('judul'),
                'konten'   => $this->request->getPost('konten'),
                'kategori' => $this->request->getPost('kategori'),
                'tanggal'  => $this->request->getPost('tanggal'),
                'id_user'  => $userId,
            ];

            $this->beritaModel->insert($data);
            return redirect()->to('/berita_admin')->with('success', 'Berita berhasil ditambahkan');

        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat menyimpan berita.');
        }
    }

    // 🔄 Update berita
    public function update($id)
    {
        // 🛡️ PASTIKAN ID NUMERIC
        if (!is_numeric($id)) {
            return redirect()->to('/berita_admin')->with('error', 'ID Berita tidak valid.');
        }

        // 🛡️ 1. VALIDASI INPUT
        $rules = [
            'judul'    => 'required|max_length[100]',
            'konten'   => 'required',
            'kategori' => 'required|max_length[50]',
            'tanggal'  => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Format data tidak valid: ' . implode(', ', $this->validator->getErrors()));
        }

        // 🛡️ 2. TRY-CATCH ERROR HANDLING
        try {
            $userId = $this->getUserIdOrRedirect();
            $data = [
                'judul'    => $this->request->getPost('judul'),
                'konten'   => $this->request->getPost('konten'),
                'kategori' => $this->request->getPost('kategori'),
                'tanggal'  => $this->request->getPost('tanggal'),
                'id_user'  => $userId,
            ];

            $this->beritaModel->update($id, $data);
            return redirect()->to('/berita_admin')->with('success', 'Berita berhasil diperbarui');

        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat memperbarui berita.');
        }
    }

    // ❌ Hapus berita
    public function delete($id)
{
    if (!is_numeric($id)) return redirect()->to('/berita_admin')->with('error', 'ID tidak valid');
    try {
        $this->beritaModel->delete($id);
        return redirect()->to('/berita_admin')->with('success', 'Berita berhasil dihapus');
    } catch (\Throwable $e) {
        return redirect()->to('/berita_admin')->with('error', 'Gagal menghapus berita.');
    }
}
}
