<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JadwalModel;
use App\Models\AsistenJadwalModel;
use App\Models\EventModel;

class JadwalController extends BaseController
{
    protected $jadwalModel;
    protected $asistenJadwalModel;
    protected $eventModel;

    public function __construct()
    {
        $this->jadwalModel        = new JadwalModel();
        $this->asistenJadwalModel = new AsistenJadwalModel();
        $this->eventModel         = new EventModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'Daftar Jadwal Lab',
            'schedules' => $this->jadwalModel->getProcessedJadwalData()
        ];

        return view('jadwal_card_view', $data);
    }

    public function admin()
    {
        $jadwals = $this->jadwalModel->getProcessedJadwalData();

        $rows = [];
        foreach ($jadwals as $j) {
            $rows[] = [
                $j['id_jadwal'],
                $j['title'],
                $j['kelas'] ?? '-',
                $j['date'],
                $j['time'],
                $j['instructor'],
                $j['lab'],
                $j['jenis'] ?? '-',
            ];
        }

        $data = [
            'title'     => 'Daftar Jadwal Lab',
            'schedules' => ['rows' => $rows],
            'events'    => $this->eventModel->findAll()
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
