<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\AsistenJadwalModel;

class JadwalModel extends Model
{
    protected $table = 'jadwal';
    protected $primaryKey = 'id_jadwal';
    protected $allowedFields = ['id_event', 'tanggal', 'waktu_mulai', 'waktu_selesai', 'id_ruangan', 'kelas', 'created_at', 'updated_at'];

    public function getJadwalWithDetails()
    {
        return $this->select('events.nama_event')
                    ->join('events', 'events.id_event = jadwal.id_event')
                    ->findAll();
    }

    public function find($id = null)
    {
        $this->select('jadwal.*, ruangan.nama_ruangan as ruangan')
             ->join('ruangan', 'ruangan.id_ruangan = jadwal.id_ruangan', 'left');
        return parent::find($id);
    }

    public function findAll(?int $limit = null, int $offset = 0)
    {
        $this->select('jadwal.*, ruangan.nama_ruangan as ruangan')
             ->join('ruangan', 'ruangan.id_ruangan = jadwal.id_ruangan', 'left');
        return parent::findAll($limit, $offset);
    }

    public function resolveRuanganId($namaRuangan)
    {
        if (empty($namaRuangan)) {
            return null;
        }
        $db = \Config\Database::connect();
        $builder = $db->table('ruangan');
        $row = $builder->where('nama_ruangan', $namaRuangan)->get()->getRow();
        if ($row) {
            return (int)$row->id_ruangan;
        }
        // If room doesn't exist, create it
        $builder->insert([
            'nama_ruangan' => $namaRuangan,
            'kapasitas'    => 30, // default kapasitas
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s')
        ]);
        return (int)$db->insertID();
    }

    public function insert($data = null, bool $returnID = true)
    {
        if (is_array($data) && isset($data['ruangan'])) {
            $data['id_ruangan'] = $this->resolveRuanganId($data['ruangan']);
            unset($data['ruangan']);
        } elseif (is_object($data) && isset($data->ruangan)) {
            $data->id_ruangan = $this->resolveRuanganId($data->ruangan);
            unset($data->ruangan);
        }
        return parent::insert($data, $returnID);
    }

    public function update($id = null, $data = null): bool
    {
        if (is_array($data) && isset($data['ruangan'])) {
            $data['id_ruangan'] = $this->resolveRuanganId($data['ruangan']);
            unset($data['ruangan']);
        } elseif (is_object($data) && isset($data->ruangan)) {
            $data->id_ruangan = $this->resolveRuanganId($data->ruangan);
            unset($data->ruangan);
        }
        return parent::update($id, $data);
    }

    public function getProcessedJadwalData()
    {
        $asistenJadwalModel = model(AsistenJadwalModel::class);
        $databaseData = $this->getJadwalWithDetails();
        $processedSchedules = [];
        $today = new \DateTime('today');

        foreach ($databaseData as $item) {
            $scheduleDate = new \DateTime($item['tanggal']);
            if ($scheduleDate > $today) {
                $status = 'Upcoming'; $status_color = 'success';
            } elseif ($scheduleDate < $today) {
                $status = 'Completed'; $status_color = 'primary';
            } else {
                $status = 'Today'; $status_color = 'warning';
            }

            $asisten = $asistenJadwalModel->getAsistenByJadwal($item['id_jadwal']);
            $instructor = 'Dosen Pengampu'; // Default instructor name
            $assistants = !empty($asisten) ? implode(', ', array_column($asisten, 'nama')) : 'Belum Ditentukan';

            $processedSchedules[] = [
                'id_jadwal'  => $item['id_jadwal'],   // tambahkan ini
                'title'       => $item['nama_event'],
                'kelas'       => $item['kelas'],
                'lab'         => $item['ruangan'] ?? '',
                'status'      => $status,
                'status_color'=> $status_color,
                'date'        => $scheduleDate->format('l, d F Y'),
                'raw_date'    => $item['tanggal'],
                'time'        => date('H:i', strtotime($item['waktu_mulai'])) . ' - ' . date('H:i', strtotime($item['waktu_selesai'])),
                'instructor'  => $instructor,
                'assistants'  => $assistants
            ];
        }

        return $processedSchedules;
    }
}
