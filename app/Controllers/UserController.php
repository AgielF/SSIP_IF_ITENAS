<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PeriodeModel;

class UserController extends BaseController
{
    protected $userModel;
    protected $periodeModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->periodeModel = new PeriodeModel();
    }

    /**
     * 🌐 HALAMAN PUBLIK: Daftar Asisten
     */
    public function index()
    {
        return view('asisten_list_view', [
            'title'       => 'Anggota Laboratorium',
            'asisten'     => $this->userModel->getProcessedPersonnelData(),
            'listPeriode' => $this->periodeModel->findAll()
        ]);
    }

    /**
     * 🌐 HALAMAN PUBLIK: Detail Profil Asisten
     */
    public function profil($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $roleMap = [
            1 => 'admin',
            2 => 'asisten',
            3 => 'dosen',
            4 => 'praktikan'
        ];
        $user['role'] = $roleMap[$user['role_id']] ?? 'tidak diketahui';

        $publikasiModel = new \App\Models\PublikasiModel();
        $proyekModel    = new \App\Models\ProyekRisetModel();

        return view('user_profile_view', [
            'title'           => 'Profil Anggota | ' . $user['nama'],
            'user'            => $user,
            'publicationData' => $publikasiModel->where('id_user', $id)->findAll() ?? [],
            'proyekData'      => $proyekModel->where('id_user', $id)->findAll() ?? []
        ]);
    }
}