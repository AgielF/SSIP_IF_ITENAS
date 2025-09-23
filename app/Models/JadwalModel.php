<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\AsistenJadwalModel;

class JadwalModel extends Model
{
    protected $table = 'jadwal';
    protected $primaryKey = 'id_jadwal';
    protected $allowedFields = ['id_event', 'tanggal', 'waktu_mulai', 'waktu_selesai', 'ruangan', 'created_at', 'updated_at'];

    public function getJadwalWithDetails()
    {
        return $this->select('jadwal.*, events.nama_event')
                    ->join('events', 'events.id_event = jadwal.id_event')
                    ->findAll();
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
            $instructor = !empty($asisten) ? $asisten[0]['nama'] : 'Belum Ditentukan';

            $processedSchedules[] = [
                'id_jadwal'  => $item['id_jadwal'],   // tambahkan ini
                'title'       => $item['nama_event'],
                'lab'         => $item['ruangan'],
                'status'      => $status,
                'status_color'=> $status_color,
                'date'        => $scheduleDate->format('l, d F Y'),
                'time'        => date('H:i', strtotime($item['waktu_mulai'])) . ' - ' . date('H:i', strtotime($item['waktu_selesai'])),
                'instructor'  => $instructor
            ];
        }

        return $processedSchedules;
    }
}
