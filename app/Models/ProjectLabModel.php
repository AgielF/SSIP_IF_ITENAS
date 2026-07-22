<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectLabModel extends Model
{
    protected $table      = 'project_lab';
    protected $primaryKey = 'id_project';

    protected $allowedFields = [
        'judul',
        'deskripsi',
        'topik',
        'status',
        'teknologi',
        'link_repository',
        'link_deploy',
        'tanggal_mulai',
        'tanggal_selesai',
        'created_by',
    ];

    protected $useTimestamps = false;

    /**
     * 📋 LIST ADMIN + MEMBERS
     */
    public function getProjectForAdminWithMembers()
    {
        $projects = $this->select('
                project_lab.*,
                users.nama AS nama_ketua
            ')
            ->join('users', 'users.id = project_lab.created_by', 'left')
            ->orderBy('project_lab.created_at', 'DESC')
            ->findAll();

        $db = \Config\Database::connect();

        foreach ($projects as &$p) {
            $p['members'] = $db->table('project_lab_members pm')
                ->select('pm.id_user, pm.role_project, u.nama')
                ->join('users u', 'u.id = pm.id_user', 'left')
                ->where('pm.id_project', $p['id_project'])
                ->get()
                ->getResultArray();
        }

        return $projects;
    }

    /**
     * 🔍 DETAIL PROJECT
     */
    public function getProjectDetail($id)
    {
        return $this->select('project_lab.*, users.nama AS nama_ketua')
            ->join('users', 'users.id = project_lab.created_by', 'left')
            ->where('project_lab.id_project', $id)
            ->first();
    }
        public function getProjectFormattedForView()
    {
        return $this->select('project_lab.*, users.nama AS creator_name')
            ->join('users', 'users.id = project_lab.created_by', 'left')
            ->orderBy('project_lab.created_at', 'DESC')
            ->findAll();
    }
}
