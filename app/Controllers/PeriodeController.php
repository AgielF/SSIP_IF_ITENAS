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
        // 🛡️ 1. VALIDASI INPUT
        $rules = [
            'nama_periode' => 'required|max_length[50]',
            'tahun'        => 'required|numeric|exact_length[4]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Format data tidak valid: ' . implode(', ', $this->validator->getErrors()));
        }

        // 🛡️ 2. TRY-CATCH ERROR HANDLING
        try {
            $this->periodeModel->insert([
                'nama_periode' => $this->request->getPost('nama_periode'),
                'tahun'        => $this->request->getPost('tahun'),
            ]);

            return redirect()->to('/periode_admin')->with('success', 'Data Periode berhasil ditambahkan.');
            
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat menyimpan periode.');
        }
    }

    /**
     * Memperbarui data periode
     */
    public function update($id)
    {
        // 🛡️ PASTIKAN ID NUMERIC
        if (!is_numeric($id)) {
            return redirect()->to('/periode_admin')->with('error', 'ID Periode tidak valid.');
        }

        // 🛡️ 1. VALIDASI INPUT
        $rules = [
            'nama_periode' => 'required|max_length[50]',
            'tahun'        => 'required|numeric|exact_length[4]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Format data tidak valid: ' . implode(', ', $this->validator->getErrors()));
        }

        // 🛡️ 2. TRY-CATCH ERROR HANDLING
        try {
            $this->periodeModel->update($id, [
                'nama_periode' => $this->request->getPost('nama_periode'),
                'tahun'        => $this->request->getPost('tahun'),
            ]);

            return redirect()->to('/periode_admin')->with('success', 'Data Periode berhasil diperbarui.');

        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat memperbarui periode.');
        }
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