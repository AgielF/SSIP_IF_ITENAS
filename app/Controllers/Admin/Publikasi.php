<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PublikasiModel;
use App\Models\UserModel;

class Publikasi extends BaseController
{
    protected $publikasiModel;
    protected $userModel;

    public function __construct()
    {
        $this->publikasiModel = new PublikasiModel();
        $this->userModel = new UserModel();
    }

    //Menampilkan daftar publikasi
    public function index()
    {
        $publikasis = $this->publikasiModel->findAll();

        // Format data sesuai dengan yang diharapkan JavaScript
        $publicationData = [
            'jurnal' => ['headers' => [], 'rows' => []],
            'prosiding' => ['headers' => [], 'rows' => []],
            'paten' => ['headers' => [], 'rows' => []]
        ];

        // Set headers
        $headers = ['Kategori', 'Judul', 'Link Publikasi', 'Tanggal Publikasi', 'Penulis Pendamping', 'Volume', 'Nomor', 'Tahun', 'Conference', 'Deskripsi', 'Link DOI', 'Link GDrive'];
        $publicationData['jurnal']['headers'] = $headers;
        $publicationData['prosiding']['headers'] = $headers;
        $publicationData['paten']['headers'] = $headers;

        // Group data by jenis_publikasi
        foreach ($publikasis as $pub) {
            // Clean up any HTML that might be in the database from previous operations
            $cleanLinkPublikasi = $this->cleanHtmlFromUrl($pub['link_publikasi'] ?? '');
            $cleanLinkDoi = $this->cleanHtmlFromUrl($pub['link_doi'] ?? '');
            $cleanLinkGdrive = $this->cleanHtmlFromUrl($pub['link_gdrive'] ?? '');

            $row = [
                $pub['kategori'] ?? '',
                $pub['judul'] ?? '',
                $cleanLinkPublikasi,
                $pub['tanggal_publikasi'] ?? '',
                $pub['penulis_pendamping'] ?? '',
                $pub['volume'] ?? '',
                $pub['nomor'] ?? '',
                $pub['tahun'] ?? '',
                $pub['conference'] ?? '',
                $pub['deskripsi'] ?? '',
                $cleanLinkDoi,
                $cleanLinkGdrive
            ];

            $jenis = $pub['jenis_publikasi'] ?? 'jurnal';
            if (isset($publicationData[$jenis])) {
                $row[] = $pub['id_publikasi']; // Add ID for editing/deleting
                $publicationData[$jenis]['rows'][] = $row;
            }
        }

        // Debug: Log the data structure
        log_message('debug', 'Publication Data: ' . json_encode($publicationData));

        $data = [
            'title' => 'Manajemen Publikasi',
            'publicationData' => $publicationData
        ];

        return view('publikasi_ilmiah_admin_list_view', $data);
    }

    //Menampilkan form untuk membuat publikasi baru
    public function new()
    {
        $data = [
            'title' => 'Tambah Publikasi Baru',
            'users' => $this->userModel->findAll()
        ];

        return view('admin/publikasi/create', $data);
    }

    //Menyimpan publikasi baru
    public function create()
    {
        $data = [
            'jenis_publikasi' => $this->request->getPost('jenis_publikasi'),
            'kategori' => $this->request->getPost('kategori'),
            'judul' => $this->request->getPost('judul'),
            'tanggal_publikasi' => $this->request->getPost('tanggal_publikasi'),
            'penulis_pendamping' => $this->request->getPost('penulis_pendamping'),
            'volume' => $this->request->getPost('volume'),
            'nomor' => $this->request->getPost('nomor'),
            'tahun' => $this->request->getPost('tahun'),
            'link_publikasi' => $this->cleanHtmlFromUrl($this->request->getPost('link_publikasi')),
            'link_doi' => $this->cleanHtmlFromUrl($this->request->getPost('link_doi')),
            'link_gdrive' => $this->cleanHtmlFromUrl($this->request->getPost('link_gdrive')),
            'conference' => $this->request->getPost('conference'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'id_user' => $this->request->getPost('id_user') ?: 1, // Default to admin user
        ];

        if ($this->publikasiModel->save($data)) {
            if ($this->request->isAJAX()) {
                return \Config\Services::response()->setJSON(['success' => true, 'message' => 'Publikasi berhasil ditambahkan']);
            }
            return redirect()->to('/admin/publikasi-ilmiah')->with('success', 'Publikasi berhasil ditambahkan');
        } else {
            if ($this->request->isAJAX()) {
                return \Config\Services::response()->setJSON(['success' => false, 'message' => 'Gagal menambahkan publikasi']);
            }
            return redirect()->back()->with('error', 'Gagal menambahkan publikasi')->withInput();
        }
    }

    //Menampilkan form untuk mengedit publikasi
    public function edit($id)
    {
        $publikasi = $this->publikasiModel->find($id);
        if (!$publikasi) {
            return redirect()->to('/admin/publikasi-ilmiah')->with('error', 'Publikasi tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Publikasi',
            'publikasi' => $publikasi,
            'users' => $this->userModel->findAll()
        ];

        return view('admin/publikasi/edit', $data);
    }

    //Memperbarui publikasi
    public function update($id)
    {
        $data = [
            'jenis_publikasi' => $this->request->getPost('jenis_publikasi'),
            'kategori' => $this->request->getPost('kategori'),
            'judul' => $this->request->getPost('judul'),
            'tanggal_publikasi' => $this->request->getPost('tanggal_publikasi'),
            'penulis_pendamping' => $this->request->getPost('penulis_pendamping'),
            'volume' => $this->request->getPost('volume'),
            'nomor' => $this->request->getPost('nomor'),
            'tahun' => $this->request->getPost('tahun'),
            'link_publikasi' => $this->cleanHtmlFromUrl($this->request->getPost('link_publikasi')),
            'link_doi' => $this->cleanHtmlFromUrl($this->request->getPost('link_doi')),
            'link_gdrive' => $this->cleanHtmlFromUrl($this->request->getPost('link_gdrive')),
            'conference' => $this->request->getPost('conference'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'id_user' => $this->request->getPost('id_user') ?: 1,
        ];

        if ($this->publikasiModel->update($id, $data)) {
            if ($this->request->isAJAX()) {
                return \Config\Services::response()->setJSON(['success' => true, 'message' => 'Publikasi berhasil diperbarui']);
            }
            return redirect()->to('/admin/publikasi-ilmiah')->with('success', 'Publikasi berhasil diperbarui');
        } else {
            if ($this->request->isAJAX()) {
                return \Config\Services::response()->setJSON(['success' => false, 'message' => 'Gagal memperbarui publikasi']);
            }
            return redirect()->back()->with('error', 'Gagal memperbarui publikasi')->withInput();
        }
    }

    //Menghapus publikasi
    public function delete($id)
    {
        if ($this->publikasiModel->delete($id)) {
            if ($this->request->isAJAX()) {
                return \Config\Services::response()->setJSON(['success' => true, 'message' => 'Publikasi berhasil dihapus']);
            }
            return redirect()->to('/admin/publikasi-ilmiah')->with('success', 'Publikasi berhasil dihapus');
        } else {
            if ($this->request->isAJAX()) {
                return \Config\Services::response()->setJSON(['success' => false, 'message' => 'Gagal menghapus publikasi']);
            }
            return redirect()->to('/admin/publikasi-ilmiah')->with('error', 'Gagal menghapus publikasi');
        }
    }

    // Helper method to clean HTML from URLs
    private function cleanHtmlFromUrl($url)
    {
        if (empty($url)) {
            return '';
        }

        // If it contains HTML link tags, extract the URL
        if (preg_match('/<a[^>]+href=["\']([^"\']+)["\'][^>]*>/i', $url, $matches)) {
            return $matches[1];
        }

        // If it contains HTML entities, decode them
        $decoded = html_entity_decode($url, ENT_QUOTES | ENT_HTML5);

        // If it still contains HTML, strip it
        if (strip_tags($decoded) !== $decoded) {
            return strip_tags($decoded);
        }

        return $url;
    }
}