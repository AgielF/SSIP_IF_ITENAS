<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JadwalModel;
use App\Models\AsistenJadwalModel;
use App\Models\EventModel;
use App\Models\UserModel;

class JadwalController extends BaseController
{
    protected $jadwalModel;
    protected $asistenJadwalModel;
    protected $eventModel;
    protected $userModel;

    public function __construct()
    {
        $this->jadwalModel        = new JadwalModel();
        $this->asistenJadwalModel = new AsistenJadwalModel();
        $this->eventModel         = new EventModel();
        $this->userModel          = new UserModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'Daftar Jadwal Lab',
            'schedules' => $this->jadwalModel->getProcessedJadwalData()
        ];

        return view('jadwal_card_view', $data);
    }

    // NEW METHOD: Dedicated Jadwal Praktikum Page
    public function praktikum()
    {
        $view = $this->request->getGet('view') ?? 'list';

        $data = [
            'title'     => 'Jadwal Praktikum Laboratorium',
            'schedules' => $this->jadwalModel->getProcessedJadwalData(),
            'current_view' => $view
        ];

        return view('jadwal_praktikum_view', $data);
    }

    public function admin()
    {
        $jadwals = $this->jadwalModel->getProcessedJadwalData();

        $rows = [];
        foreach ($jadwals as $j) {
            // Get raw jadwal data for editing
            $rawJadwal = $this->jadwalModel->find($j['id_jadwal']);

            $rows[] = [
                $j['id_jadwal'],
                $j['title'],
                $rawJadwal['kelas'] ?? '-', // Index 2: kelas
                $j['date'],
                $j['time'],
                $j['instructor'],
                $j['lab'],
                $j['assistants'] ?? '-', // Index 7: assistants from processed data
                $j['jenis'] ?? '-',
                $rawJadwal['id_event'] ?? '', // Index 9: id_event
                $rawJadwal['tanggal'] ?? '', // Index 10: tanggal
                $rawJadwal['waktu_mulai'] ?? '', // Index 11: waktu_mulai
                $rawJadwal['waktu_selesai'] ?? '', // Index 12: waktu_selesai
                $rawJadwal['ruangan'] ?? '', // Index 13: ruangan
                $rawJadwal['kelas'] ?? '', // Index 14: kelas for editing
            ];
        }

        // Get available assistants (users with role_id = 2 for asisten)
        $assistants = $this->userModel->select('users.id, users.nama')
            ->join('roles', 'roles.id = users.role_id')
            ->where('users.role_id', 2) // Asisten role
            ->findAll();

        $data = [
            'title'     => 'Daftar Jadwal Lab',
            'schedules' => ['rows' => $rows],
            'events'    => $this->eventModel->findAll(),
            'assistants' => $assistants
        ];

        return view('jadwal_admin_view', $data);
    }

    public function store()
    {
        $data = [
            'id_event'      => $this->request->getPost('id_event'),
            'tanggal'       => $this->request->getPost('tanggal'),
            'waktu_mulai'   => $this->request->getPost('waktu_mulai'),
            'waktu_selesai' => $this->request->getPost('waktu_selesai'),
            'ruangan'       => $this->request->getPost('ruangan'),
            'kelas'         => $this->request->getPost('kelas'),
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
        ];

        $this->jadwalModel->insert($data);
        return redirect()->to('/jadwal_admin')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function update($id)
    {
        $data = [
            'id_event'      => $this->request->getPost('id_event'),
            'tanggal'       => $this->request->getPost('tanggal'),
            'waktu_mulai'   => $this->request->getPost('waktu_mulai'),
            'waktu_selesai' => $this->request->getPost('waktu_selesai'),
            'ruangan'       => $this->request->getPost('ruangan'),
            'kelas'         => $this->request->getPost('kelas'),
            'updated_at'    => date('Y-m-d H:i:s')
        ];

        $this->jadwalModel->update($id, $data);
        return redirect()->to('/jadwal_admin')->with('success', 'Jadwal berhasil diperbarui');
    }

    public function delete($id)
    {
        $this->jadwalModel->delete($id);
        return redirect()->to('/jadwal_admin')->with('success', 'Jadwal berhasil dihapus');
    }
}
