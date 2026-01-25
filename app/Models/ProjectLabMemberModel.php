<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectLabMemberModel extends Model
{
    protected $table      = 'project_lab_members';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id_project',
        'id_user',
        'role_project',
        'joined_at',
    ];

    protected $useTimestamps = false;

    /**
     * 👥 Ambil member berdasarkan project
     */
    public function getMembersByProject($idProject)
    {
        return $this->select('project_lab_members.*, users.nama, users.jurusan')
            ->join('users', 'users.id = project_lab_members.id_user', 'left')
            ->where('project_lab_members.id_project', $idProject)
            ->findAll();
    }
}
