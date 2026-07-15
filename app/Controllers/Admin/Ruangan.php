<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RuanganModel;

class Ruangan extends BaseController
{
    protected $ruanganModel;

    public function __construct()
    {
        $this->ruanganModel = new RuanganModel();
    }

    public function index()
    {
        // Get all rooms and check if they have schedules associated with them
        $db = \Config\Database::connect();
        
        $ruangans = $this->ruanganModel->orderBy('nama_ruangan', 'ASC')->findAll();
        
        $today = date('Y-m-d');
        $now = date('H:i:s');
        
        // Count schedules for each room and check real-time status
        foreach ($ruangans as &$r) {
            $r['schedule_count'] = $db->table('jadwal')
                                      ->where('id_ruangan', $r['id_ruangan'])
                                      ->countAllResults();
                                      
            // Get schedules for today
            $todaySchedules = $db->table('jadwal')
                                 ->select('jadwal.*, events.nama_event')
                                 ->join('events', 'events.id_event = jadwal.id_event')
                                 ->where('id_ruangan', $r['id_ruangan'])
                                 ->where('tanggal', $today)
                                 ->get()
                                 ->getResultArray();

            $status = 'available';
            $activeSchedule = null;

            if (!empty($todaySchedules)) {
                $status = 'occupied_today';
                foreach ($todaySchedules as $s) {
                    if ($now >= $s['waktu_mulai'] && $now <= $s['waktu_selesai']) {
                        $status = 'occupied_now';
                        $activeSchedule = $s;
                        break;
                    }
                }
            }

            $r['today_status'] = $status;
            $r['today_schedules'] = $todaySchedules;
            $r['active_schedule'] = $activeSchedule;
        }

        $data = [
            'title' => 'Admin - Kelola Ruangan',
            'ruangans' => $ruangans
        ];

        return view('ruangan_list_admin_view', $data);
    }

    public function create()
    {
        $data = [
            'nama_ruangan' => $this->request->getPost('nama_ruangan'),
            'kapasitas'    => (int)$this->request->getPost('kapasitas'),
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s')
        ];

        // Check if name is already taken
        $existing = $this->ruanganModel->where('nama_ruangan', $data['nama_ruangan'])->first();
        if ($existing) {
            return redirect()->back()->with('error', 'Nama ruangan sudah digunakan. Harap gunakan nama lain.');
        }

        if ($this->ruanganModel->insert($data)) {
            return redirect()->to('/ruangan_admin')->with('success', 'Ruangan berhasil ditambahkan');
        }

        return redirect()->back()->with('error', 'Gagal menambahkan ruangan');
    }

    public function update($id)
    {
        $data = [
            'nama_ruangan' => $this->request->getPost('nama_ruangan'),
            'kapasitas'    => (int)$this->request->getPost('kapasitas'),
            'updated_at'   => date('Y-m-d H:i:s')
        ];

        // Check if name is already taken by another room
        $existing = $this->ruanganModel->where('nama_ruangan', $data['nama_ruangan'])
                                       ->where('id_ruangan !=', $id)
                                       ->first();
        if ($existing) {
            return redirect()->back()->with('error', 'Nama ruangan sudah digunakan oleh ruangan lain.');
        }

        if ($this->ruanganModel->update($id, $data)) {
            return redirect()->to('/ruangan_admin')->with('success', 'Ruangan berhasil diperbarui');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui ruangan');
    }

    public function delete($id)
    {
        try {
            if ($this->ruanganModel->delete($id)) {
                return redirect()->to('/ruangan_admin')->with('success', 'Ruangan berhasil dihapus');
            }
        } catch (\Throwable $e) {
            return redirect()->to('/ruangan_admin')->with('error', 'Gagal menghapus ruangan. Pastikan ruangan ini tidak sedang digunakan pada jadwal praktikum.');
        }

        return redirect()->to('/ruangan_admin')->with('error', 'Gagal menghapus ruangan');
    }
}
