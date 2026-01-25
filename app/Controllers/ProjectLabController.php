<?php

namespace App\Controllers;

use App\Models\ProjectLabModel;
use App\Models\ProjectLabMemberModel;

use CodeIgniter\Exceptions\PageNotFoundException;

class ProjectLabController extends BaseController
{
    protected $projectLabModel;
    protected $memberModel;

    public function __construct()
    {
        $this->projectLabModel = new ProjectLabModel();
        $this->memberModel     = new ProjectLabMemberModel();
    }

    /**
     * 📋 LIST UNTUK USER
     */
    public function index()
    {
        $data = [
            'title'   => 'Daftar Project Laboratorium',
            'projects'=> $this->projectLabModel->getProjectFormattedForView()
        ];

        return view('project_list_view', $data);
    }

    /**
     * 📋 LIST UNTUK ADMIN
     */
    public function getDataAdmin()
{
    $userModel = new \App\Models\UserModel();

    $data = [
        'title'    => 'Repositori Proyek Lab',
        'projects' => $this->projectLabModel->getProjectForAdminWithMembers(),
        'users'    => $userModel->findAll(),
    ];

    return view('project_admin_list_view', $data);
}


    /**
     * 🔍 DETAIL PROJECT + MEMBER
     */
    public function detail($id)
    {
        $project = $this->projectLabModel->getProjectDetail($id);

        if (!$project) {
            throw PageNotFoundException::forPageNotFound();
        }

        $members = $this->memberModel->getMembersByProject($id);

        return view('project_detail_list_view', [
            'title'   => 'Detail Project | ' . $project['judul'],
            'project' => $project,
            'members' => $members
        ]);
    }

    /**
     * 🟢 CREATE
     */
   public function create()
{
    // 1. SIMPAN PROJECT
    $projectData = [
    'judul'           => $this->request->getPost('judul'),
    'deskripsi'       => $this->request->getPost('deskripsi'),
    'topik'           => $this->request->getPost('topik'),
    'status'          => $this->request->getPost('status'),
    'teknologi'       => $this->request->getPost('teknologi'),
    'created_by'      => $this->request->getPost('created_by'),

   
    'link_repository' => $this->request->getPost('link_repository'),
    'link_deploy'     => $this->request->getPost('link_deploy'),
    'tanggal_mulai'   => $this->request->getPost('tanggal_mulai'),
    'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),

    'created_at'      => date('Y-m-d H:i:s')
];

    $this->projectLabModel->insert($projectData);

    // 🔑 ambil ID project BARU
    $projectId = $this->projectLabModel->getInsertID();

    // 2. SIMPAN MEMBERS (JIKA ADA)
    $members = $this->request->getPost('members');

    if ($members) {
        foreach ($members as $m) {
            if (!empty($m['id_user'])) {
                $this->memberModel->insert([
                    'id_project'   => $projectId,
                    'id_user'      => $m['id_user'],
                    'role_project' => $m['role_project'] ?? 'Anggota',
                    'joined_at'    => date('Y-m-d H:i:s')
                ]);
            }
        }
    }

    return redirect()->to('/project-lab_admin')
        ->with('success', 'Project & anggota berhasil ditambahkan');
}

    /**
     * 🟡 UPDATE
     */
    public function update($id)
{
    // 1. UPDATE PROJECT
    $projectData = [
    'judul'           => $this->request->getPost('judul'),
    'deskripsi'       => $this->request->getPost('deskripsi'),
    'topik'           => $this->request->getPost('topik'),
    'status'          => $this->request->getPost('status'),
    'teknologi'       => $this->request->getPost('teknologi'),
    'created_by'      => $this->request->getPost('created_by'),

    // ✅ TAMBAHKAN INI
    'link_repository' => $this->request->getPost('link_repository'),
    'link_deploy'     => $this->request->getPost('link_deploy'),
    'tanggal_mulai'   => $this->request->getPost('tanggal_mulai'),
    'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),

    'updated_at'      => date('Y-m-d H:i:s')
];

    $this->projectLabModel->update($id, $projectData);

    // 2. HAPUS MEMBER LAMA
    $this->memberModel
        ->where('id_project', $id)
        ->delete();

    // 3. SIMPAN MEMBER BARU
    $members = $this->request->getPost('members');

    if ($members) {
        foreach ($members as $m) {
            if (!empty($m['id_user'])) {
                $this->memberModel->insert([
                    'id_project'   => $id,
                    'id_user'      => $m['id_user'],
                    'role_project' => $m['role_project'] ?? 'Anggota',
                    'joined_at'    => date('Y-m-d H:i:s')
                ]);
            }
        }
    }

    return redirect()->to('/project-lab_admin')
        ->with('success', 'Project & anggota berhasil diperbarui');
}


    /**
     * 🔴 DELETE
     */
    public function delete($id)
    {
        $this->projectLabModel->delete($id);

        return redirect()->to('/project-lab_admin')
            ->with('success', 'Project lab berhasil dihapus.');
    }

    /**
     * ➕ TAMBAH MEMBER KE PROJECT
     */
    public function addMember()
    {
        $data = [
            'id_project'   => $this->request->getPost('id_project'),
            'id_user'      => $this->request->getPost('id_user'),
            'role_project' => $this->request->getPost('role_project'),
            'joined_at'    => date('Y-m-d H:i:s'),
        ];

        $this->memberModel->insert($data);

        return redirect()->back()->with('success', 'Anggota project berhasil ditambahkan.');
    }
}
