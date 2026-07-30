<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\AsistenJadwalModel;

class JadwalModel extends Model
{
    protected $table = 'jadwal';
    protected $primaryKey = 'id_jadwal';
    protected $useTimestamps = true; // [T3.1] CI4 mengelola timestamps otomatis
    protected $allowedFields = ['id_event', 'tanggal', 'waktu_mulai', 'waktu_selesai', 'id_ruangan', 'kelas'];

    public function getJadwalWithDetails()
    {
        return $this->select('events.nama_event')
                    ->join('events', 'events.id_event = jadwal.id_event')
                    ->findAll();
    }

    /**
     * [T2.1] Method baru yang menggantikan pola N+1 query.
     *
     * Mengambil data jadwal LENGKAP beserta nama-nama asisten yang ditugaskan
     * dalam SATU query tunggal menggunakan GROUP_CONCAT + JOIN.
     * Ini menggantikan pola lama: 1 query utama + N query asisten per baris.
     *
     * Referensi: Refactoring (Martin Fowler) — Replace Loop with Pipeline.
     *
     * @param  int|null $limit Batasi jumlah jadwal yang diambil (null = semua).
     * @return array Data jadwal yang sudah teragregasi.
     */
    public function getJadwalWithAsisten(?int $limit = null): array
    {
        $builder = $this->db->table('jadwal')
            ->select('jadwal.*,
                      events.nama_event,
                      ruangan.nama_ruangan AS ruangan,
                      GROUP_CONCAT(users.nama ORDER BY users.nama SEPARATOR ", ") AS nama_asisten')
            ->join('events', 'events.id_event = jadwal.id_event', 'left')
            ->join('ruangan', 'ruangan.id_ruangan = jadwal.id_ruangan', 'left')
            ->join('asisten_jadwal', 'asisten_jadwal.id_jadwal = jadwal.id_jadwal', 'left')
            ->join('users', 'users.id = asisten_jadwal.id_user', 'left')
            ->groupBy('jadwal.id_jadwal')
            ->orderBy('jadwal.tanggal', 'ASC');

        if ($limit !== null) {
            $builder->limit($limit);
        }

        return $builder->get()->getResultArray();
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
            'kapasitas'    => 30, // default kapasitas   => date('Y-m-d H:i:s')   => date('Y-m-d H:i:s')
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
    public function getJadwalSayaWithDetails($id_user)
    {
        return $this->select('events.nama_event')
                    ->join('events', 'events.id_event = jadwal.id_event')
                    ->join('asisten_jadwal', 'asisten_jadwal.id_jadwal = jadwal.id_jadwal')
                    ->where('asisten_jadwal.id_user', $id_user)
                    ->findAll();
    }

    public function getProcessedJadwalSaya($id_user)
    {
        $asistenJadwalModel = model(AsistenJadwalModel::class);
        $databaseData = $this->getJadwalSayaWithDetails($id_user);
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
                'id_jadwal'  => $item['id_jadwal'],
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
