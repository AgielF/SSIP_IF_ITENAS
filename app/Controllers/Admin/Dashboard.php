<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RekrutModel;
use App\Models\ProyekRisetModel;
use App\Models\UserModel;
use App\Models\BeritaModel;

class Dashboard extends BaseController
{
    protected $rekrutModel;
    protected $proyekRisetModel;
    protected $userModel;
    protected $beritaModel;

    public function __construct()
    {
        $this->rekrutModel = new RekrutModel();
        $this->proyekRisetModel = new ProyekRisetModel();
        $this->userModel = new UserModel();
        $this->beritaModel = new BeritaModel();
    }

    public function index()
    {
        // Get counts for various entities to display on dashboard
        $data = [
            'title' => 'Admin Dashboard',
            'rekrutCount' => $this->rekrutModel->countAll(),
            'proyekCount' => $this->proyekRisetModel->countAll(),
            'userCount' => $this->userModel->countAll(),
            'beritaCount' => $this->beritaModel->countAll()
        ];

        return view('admin/dashboard/index', $data);
    }
}