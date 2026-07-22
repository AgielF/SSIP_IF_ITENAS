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
            'title'    => 'Daftar Project Laboratorium',
            'projects' => $this->projectLabModel->getProjectFormattedForView()
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
     * 🟢 CREATE (Aman dari SQLMap & Crash)
     */
    public function create()
    {
        // 1. ATURAN VALIDASI PINTU DEPAN
        $rules = [
            'judul'           => 'required|max_length[255]',
            'deskripsi'       => 'required',
            'topik'           => 'required|max_length[100]',
            'status'          => 'required|max_length[50]',
            'teknologi'       => 'required',
            'created_by'      => 'required|numeric',
            'link_repository' => 'permit_empty|max_length[255]',
            'link_deploy'     => 'permit_empty|max_length[255]',
            'tanggal_mulai'   => 'permit_empty|valid_date',
            'tanggal_selesai' => 'permit_empty|valid_date',
        ];

        // Jika validasi gagal, kembalikan ke form dengan pesan error
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. MULAI TRANSAKSI DATABASE
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // SIMPAN PROJECT
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
            ];

            $this->projectLabModel->insert($projectData);
            $projectId = $this->projectLabModel->getInsertID();

            // SIMPAN MEMBERS (JIKA ADA DAN BERUPA ARRAY)
            $members = $this->request->getPost('members');

            if (is_array($members)) {
                foreach ($members as $m) {
                    if (!empty($m['id_user']) && is_numeric($m['id_user'])) {
                        $this->memberModel->insert([
                            'id_project'   => $projectId,
                            'id_user'      => $m['id_user'],
                            'role_project' => $m['role_project'] ?? 'Anggota',
                            'joined_at'    => date('Y-m-d H:i:s')
                        ]);
                    }
                }
            }

            // SELESAIKAN TRANSAKSI
            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data ke database.');
            }

            return redirect()->to('/project-lab_admin')->with('success', 'Project & anggota berhasil ditambahkan');

        } catch (\Exception $e) {
            // Tangkap error MySQL (seperti data terlalu panjang/tipe salah)
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: Data tidak valid.');
        }
    }

    /**
     * 🟡 UPDATE (Aman dari SQLMap & Crash)
     */
    public function update($id)
    {
        // 1. ATURAN VALIDASI PINTU DEPAN
        $rules = [
            'judul'           => 'required|max_length[255]',
            'deskripsi'       => 'required',
            'topik'           => 'required|max_length[100]',
            'status'          => 'required|max_length[50]',
            'teknologi'       => 'required',
            'created_by'      => 'required|numeric',
            'link_repository' => 'permit_empty|max_length[255]',
            'link_deploy'     => 'permit_empty|max_length[255]',
            'tanggal_mulai'   => 'permit_empty|valid_date',
            'tanggal_selesai' => 'permit_empty|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. MULAI TRANSAKSI DATABASE
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // UPDATE PROJECT
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
            ];

            $this->projectLabModel->update($id, $projectData);

            // HAPUS MEMBER LAMA
            $this->memberModel->where('id_project', $id)->delete();

            // SIMPAN MEMBER BARU
            $members = $this->request->getPost('members');

            if (is_array($members)) {
                foreach ($members as $m) {
                    if (!empty($m['id_user']) && is_numeric($m['id_user'])) {
                        $this->memberModel->insert([
                            'id_project'   => $id,
                            'id_user'      => $m['id_user'],
                            'role_project' => $m['role_project'] ?? 'Anggota',
                            'joined_at'    => date('Y-m-d H:i:s')
                        ]);
                    }
                }
            }

            // SELESAIKAN TRANSAKSI
            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data di database.');
            }

            return redirect()->to('/project-lab_admin')->with('success', 'Project & anggota berhasil diperbarui');

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: Data tidak valid.');
        }
    }

    /**
     * 🔴 DELETE
     */
    public function delete($id)
    {
        // 🛡️ PASTIKAN ID NUMERIC & TRY-CATCH
        if (!is_numeric($id)) {
            return redirect()->to('/project-lab_admin')->with('error', 'ID Project tidak valid.');
        }

        try {
            $this->projectLabModel->delete($id);
            return redirect()->to('/project-lab_admin')->with('success', 'Project lab berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to('/project-lab_admin')->with('error', 'Gagal menghapus data project.');
        }
    }

    /**
     * ➕ TAMBAH MEMBER KE PROJECT
     */
    public function addMember()
    {
        // Validasi ekstra agar SQLMap tidak memasukkan data aneh
        $rules = [
            'id_project'   => 'required|numeric',
            'id_user'      => 'required|numeric',
            'role_project' => 'required|max_length[100]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Format data anggota tidak valid.');
        }

        try {
            $data = [
                'id_project'   => $this->request->getPost('id_project'),
                'id_user'      => $this->request->getPost('id_user'),
                'role_project' => $this->request->getPost('role_project'),
                'joined_at'    => date('Y-m-d H:i:s'),
            ];

            $this->memberModel->insert($data);
            return redirect()->back()->with('success', 'Anggota project berhasil ditambahkan.');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan anggota.');
        }
    }
}