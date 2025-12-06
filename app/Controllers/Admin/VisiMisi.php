<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\VisiMisiModel;

class VisiMisi extends BaseController
{
    protected $visiMisiModel;

    public function __construct()
    {
        $this->visiMisiModel = new VisiMisiModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Visi & Misi',
            'contents' => $this->visiMisiModel->findAll()
        ];
        
        return view('admin/visi_misi/index', $data);
    }

    public function edit($id)
    {
        $content = $this->visiMisiModel->find($id);
        if (!$content) {
            return redirect()->to('/admin/visi-misi')->with('error', 'Konten tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Visi & Misi',
            'content' => $content
        ];

        return view('admin/visi_misi/edit', $data);
    }

    public function update($id)
    {
        $data = [
            'judul' => $this->request->getPost('judul'),
            'isi' => $this->request->getPost('isi'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->visiMisiModel->update($id, $data)) {
            return redirect()->to('/admin/visi-misi')->with('success', 'Konten berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui konten')->withInput();
        }
    }
}