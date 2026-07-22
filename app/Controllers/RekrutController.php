<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RekrutModel;
use App\Models\JadwalModel;

class RekrutController extends BaseController
{
    protected $rekrutModel;
    protected $jadwalModel;

    public function __construct()
    {
        $this->rekrutModel = new RekrutModel();
        $this->jadwalModel = new JadwalModel();
    }

    // =========================================================================
    // 📋 HALAMAN PUBLIK (Aman dari Crash)
    // =========================================================================
    public function index()
    {
        try {
            return view('rekrutmen_view', [
                'title'     => 'Informasi Rekrutmen',
                'rekrutmen' => $this->rekrutModel->getDataPublik()
            ]);
        } catch (\Throwable $e) {
            return redirect()->to('/')->with('error', 'Gagal memuat halaman rekrutmen.');
        }
    }

    // =========================================================================
    // 📋 HALAMAN ADMIN (Aman dari Manipulasi URL SQLMap)
    // =========================================================================
    public function admin()
    {
        try {
            // 🛡️ Amankan parameter sort agar tidak disusupi skrip SQLi
            $sortRaw = $this->request->getGet('sort');
            $sort    = (strtolower($sortRaw) === 'asc') ? 'asc' : 'desc';

            return view('rekrutmen_admin_view', [
                'title'     => 'Kelola Rekrutmen',
                'sort'      => $sort, 
                'rekrutmen' => $this->rekrutModel->getDataAdminFormatted($sort)['rekrutmen'],
                'jadwal'    => $this->jadwalModel
                                    ->select('jadwal.*, events.nama_event')
                                    ->join('events', 'events.id_event = jadwal.id_event', 'left')
                                    ->findAll()
            ]);
        } catch (\Throwable $e) {
            return redirect()->to('/')->with('error', 'Gagal memuat dashboard rekrutmen.');
        }
    }

    
    public function create()
    {
        // Jika form create menggunakan modal di halaman admin, kita redirect saja
        return redirect()->to('/rekrutmen_admin');
    }

    public function edit($id)
    {
        if (!is_numeric($id)) return redirect()->to('/rekrutmen_admin')->with('error', 'ID tidak valid');
        return redirect()->to('/rekrutmen_admin');
    }

    // =========================================================================
    // 🟢 CREATE DATA (Aman dari SQLMap & Crash)
    // =========================================================================
    public function store()
    {
        // 🛡️ 1. Validasi Input
        $rules = [
            'id_jadwal' => 'required|numeric',
            'deskripsi' => 'required',
            'status'    => 'required|max_length[50]',
            'syarat'    => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Format data tidak valid.');
        }

        // 🛡️ 2. Try-Catch Pembungkus Error
        try {
            $userId = $this->getUserIdOrRedirect(); 
            $data = [
                'id_user'    => $userId, 
                'id_jadwal'  => $this->request->getPost('id_jadwal'),
                'deskripsi'  => $this->request->getPost('deskripsi'),
                'status'     => $this->request->getPost('status'),
                'syarat'     => $this->request->getPost('syarat'),
            ];

            $this->rekrutModel->insert($data);
            return redirect()->to('/rekrutmen_admin')->with('success', 'Rekrutmen berhasil ditambahkan');
            
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat menyimpan data.');
        }
    }

    // =========================================================================
    // 🟡 UPDATE DATA (Aman dari SQLMap & Crash)
    // =========================================================================
    public function update($id)
    {
        // 🛡️ 1. Pastikan ID angka
        if (!is_numeric($id)) return redirect()->to('/rekrutmen_admin')->with('error', 'ID tidak valid');

        // 🛡️ 2. Validasi Input
        $rules = [
            'id_jadwal' => 'required|numeric',
            'deskripsi' => 'required',
            'status'    => 'required|max_length[50]',
            'syarat'    => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Format data tidak valid.');
        }

        // 🛡️ 3. Try-Catch Pembungkus Error
        try {
            $userId = $this->getUserIdOrRedirect(); 
            $data = [
                'id_user'    => $userId,
                'id_jadwal'  => $this->request->getPost('id_jadwal'),
                'deskripsi'  => $this->request->getPost('deskripsi'),
                'status'     => $this->request->getPost('status'),
                'syarat'     => $this->request->getPost('syarat'),
            ];

            $this->rekrutModel->update($id, $data);
            return redirect()->to('/rekrutmen_admin')->with('success', 'Rekrutmen berhasil diperbarui');
            
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat memperbarui data.');
        }
    }

    // =========================================================================
    // 🔴 DELETE DATA (Aman dari Constraint Error)
    // =========================================================================
    public function delete($id)
{
    if (!is_numeric($id)) return redirect()->to('/rekrutmen_admin')->with('error', 'ID tidak valid');
    try {
        $this->rekrutModel->delete($id);
        return redirect()->to('/rekrutmen_admin')->with('success', 'Rekrutmen berhasil dihapus');
    } catch (\Throwable $e) {
        return redirect()->to('/rekrutmen_admin')->with('error', 'Gagal menghapus data rekrutmen.');
    }
}
}