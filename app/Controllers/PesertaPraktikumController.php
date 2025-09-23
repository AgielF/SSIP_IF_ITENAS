<?php

namespace App\Controllers;

use App\Models\PesertaPraktikumModel;
use App\Models\UserModel;
use App\Models\JadwalModel;

class PesertaPraktikumController extends BaseController
{
    protected $pesertaPraktikumModel;
    protected $userModel;
    protected $jadwalModel;

    public function __construct()
    {
        $this->pesertaPraktikumModel = new PesertaPraktikumModel();
        $this->userModel = new UserModel();
        $this->jadwalModel = new JadwalModel();
    }

    // Tampilkan daftar peserta
    public function index()
    {
        $search = $this->request->getVar('search');
        $jadwal = $this->request->getVar('jadwal');
        $status = $this->request->getVar('status');

        $builder = $this->pesertaPraktikumModel
    ->select('peserta_praktikum.id as id_peserta_praktikum, peserta_praktikum.*, users.nama as peserta, jadwal.tanggal as jadwal_tanggal')
    ->join('users', 'users.id = peserta_praktikum.id_user')
    ->join('jadwal', 'jadwal.id_jadwal = peserta_praktikum.id_jadwal');


        if ($search) {
            $builder->like('users.nama', $search);
        }
        if ($jadwal) {
            $builder->where('peserta_praktikum.id_jadwal', $jadwal);
        }
        if ($status) {
            $builder->where('peserta_praktikum.status', $status);
        }

        $data = [
            'pesertaPraktikum' => $builder->findAll(),
            'users' => $this->userModel->findAll(),
            'jadwal' => $this->jadwalModel->findAll()
        ];

        return view('peserta_praktikum_list_view', $data);
    }
    public function admin(){
         $search = $this->request->getVar('search');
        $jadwal = $this->request->getVar('jadwal');
        $status = $this->request->getVar('status');

        $builder = $this->pesertaPraktikumModel
    ->select('peserta_praktikum.id as id_peserta_praktikum, peserta_praktikum.*, users.nama as peserta, jadwal.tanggal as jadwal_tanggal')
    ->join('users', 'users.id = peserta_praktikum.id_user')
    ->join('jadwal', 'jadwal.id_jadwal = peserta_praktikum.id_jadwal');


        if ($search) {
            $builder->like('users.nama', $search);
        }
        if ($jadwal) {
            $builder->where('peserta_praktikum.id_jadwal', $jadwal);
        }
        if ($status) {
            $builder->where('peserta_praktikum.status', $status);
        }

        $data = [
            'pesertaPraktikum' => $builder->findAll(),
            'users' => $this->userModel->findAll(),
            'jadwal' => $this->jadwalModel->findAll()
        ];

        return view('peserta_praktikum_list_admin_view', $data);
    }

    // Tambah peserta
    public function create()
    {
        $data = [
            'id_user'   => $this->request->getPost('id_user'),
            'id_jadwal' => $this->request->getPost('id_jadwal'),
            'status'    => $this->request->getPost('status'),
            'nilai'     => $this->request->getPost('nilai')
        ];

        if ($this->pesertaPraktikumModel->save($data)) {
            return redirect()->to('/peserta-praktikum')->with('success', 'Peserta berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan peserta');
        }
    }

    // Update peserta
    public function update($id)
    {
        $data = [
            'id_user'   => $this->request->getPost('id_user'),
            'id_jadwal' => $this->request->getPost('id_jadwal'),
            'status'    => $this->request->getPost('status'),
            'nilai'     => $this->request->getPost('nilai')
        ];

        if ($this->pesertaPraktikumModel->update($id, $data)) {
            return redirect()->to('/peserta-praktikum')->with('success', 'Peserta berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui peserta');
        }
    }

    // Hapus peserta
    public function delete($id)
    {
        if ($this->pesertaPraktikumModel->delete($id)) {
            return redirect()->to('/peserta-praktikum')->with('success', 'Peserta berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus peserta');
        }
    }
}
