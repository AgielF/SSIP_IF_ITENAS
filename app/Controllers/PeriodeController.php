<?php

namespace App\Controllers;

use App\Models\PeriodeModel;

class PeriodeController extends BaseController
{
    protected $periodeModel;

    public function __construct()
    {
        $this->periodeModel = new PeriodeModel();
    }

    /**
     * Menampilkan daftar periode
     */
    public function index()
    {
        $data = [
            'title'   => 'Kelola Periode',
            // Tetap mengurutkan berdasarkan tahun terbaru
            'periode' => $this->periodeModel->orderBy('tahun', 'DESC')->findAll()
        ];

        return view('periode_admin_list', $data);
    }

    /**
     * Menyimpan periode baru
     */
    public function store()
    {
        $this->periodeModel->insert([
            'nama_periode' => $this->request->getPost('nama_periode'),
            'tahun'        => $this->request->getPost('tahun'),
        ]);

        return redirect()->to('/periode_admin')->with('success', 'Data Periode berhasil ditambahkan.');
    }

    /**
     * Memperbarui data periode
     */
    public function update($id)
    {
        $this->periodeModel->update($id, [
            'nama_periode' => $this->request->getPost('nama_periode'),
            'tahun'        => $this->request->getPost('tahun'),
        ]);

        return redirect()->to('/periode_admin')->with('success', 'Data Periode berhasil diperbarui.');
    }

    /**
     * Menghapus periode
     */
    public function delete($id)
{
    if (!is_numeric($id)) return redirect()->to('/periode_admin')->with('error', 'ID tidak valid');
    try {
        $this->periodeModel->delete($id);
        return redirect()->to('/periode_admin')->with('success', 'Data Periode berhasil dihapus.');
    } catch (\Throwable $e) {
        return redirect()->to('/periode_admin')->with('error', 'Gagal menghapus periode. Data mungkin masih digunakan.');
    }
}
}