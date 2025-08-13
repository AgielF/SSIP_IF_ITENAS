<?php
// Data dummy, seharusnya diambil dari database
$repositories = [
    ['id' => 1, 'nama' => 'Kode Sumber Proyek SSIP', 'kategori' => 'Kode Sumber', 'link' => 'https://github.com/...', 'deskripsi' => 'Repositori utama...'],
    ['id' => 2, 'nama' => 'Dataset Praktikum Fisika', 'kategori' => 'Dataset', 'link' => 'https://data.lab.ac.id/...', 'deskripsi' => 'Kumpulan data hasil...'],
    ['id' => 3, 'nama' => 'Tools Analisis Spektrum', 'kategori' => 'Tools', 'link' => 'https://github.com/...', 'deskripsi' => 'Software buatan lab...'],
];
?>
<!-- DataTables CSS -->
<link rel="stylesheet" href="<?= base_url('assets/datatables/css/dataTables.bootstrap5.min.css') ?>"/>

<style>
    .admin-container {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    #repoTable thead th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
</style>

<div class="container my-5">
    <div class="admin-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Kelola Repositori Proyek</h4>
            <a href="#" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Tambah Repositori</a>
        </div>
        
        <div class="table-responsive">
            <table id="repoTable" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Repositori</th>
                        <th>Kategori</th>
                        <th>Link</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($repositories as $repo): ?>
                        <tr>
                            <td><?= esc($repo['id']) ?></td>
                            <td><?= esc($repo['nama']) ?></td>
                            <td><span class="badge bg-secondary"><?= esc($repo['kategori']) ?></span></td>
                            <td><a href="<?= esc($repo['link']) ?>" target="_blank">Link</a></td>
                            <td><?= esc($repo['deskripsi']) ?></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-secondary me-1" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                <a href="#" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="<?= base_url('assets/datatables/js/dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/datatables/js/dataTables.bootstrap5.min.js') ?>"></script>

<script>
    // Inisialisasi DataTables
    document.addEventListener('DOMContentLoaded', function () {
        new DataTable('#repoTable');
    });
</script>
