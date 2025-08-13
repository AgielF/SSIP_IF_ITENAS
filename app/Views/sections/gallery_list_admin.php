<?php
// Data dummy, seharusnya diambil dari database
$media_items = [
    [
        'id' => 1,
        'kategori' => 'Video',
        'keterangan' => 'Video Profil Laboratorium',
        'file_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'tanggal_upload' => '2025-08-01'
    ],
    [
        'id' => 2,
        'kategori' => 'Foto',
        'keterangan' => 'Dokumentasi Praktikum Sesi 1',
        'file_url' => 'https://placehold.co/600x400/E2E8F0/334155?text=Foto+Praktikum',
        'tanggal_upload' => '2025-07-30'
    ],
    [
        'id' => 3,
        'kategori' => 'Foto',
        'keterangan' => 'Foto Kegiatan Seminar AI 2025',
        'file_url' => 'https://placehold.co/600x400/334155/E2E8F0?text=Foto+Seminar',
        'tanggal_upload' => '2025-07-28'
    ],
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
    #galleryTable thead th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    .media-preview {
        max-width: 120px;
        height: auto;
        border-radius: 6px;
    }
    .video-preview-wrapper {
        width: 120px;
        height: 67.5px; /* 16:9 ratio */
        background-color: #000;
        border-radius: 6px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }
</style>

<div class="container my-5">
    <div class="admin-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Kelola Galeri & Media</h4>
            <a href="#" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Tambah Media Baru</a>
        </div>
        
        <div class="table-responsive">
            <table id="galleryTable" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Preview</th>
                        <th>Keterangan</th>
                        <th>Kategori</th>
                        <th>Tanggal Upload</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($media_items as $item): ?>
                        <tr>
                            <td><?= esc($item['id']) ?></td>
                            <td>
                                <?php if ($item['kategori'] === 'Foto'): ?>
                                    <img src="<?= esc($item['file_url']) ?>" alt="<?= esc($item['keterangan']) ?>" class="media-preview">
                                <?php elseif ($item['kategori'] === 'Video'): ?>
                                    <div class="video-preview-wrapper" title="Video: <?= esc($item['keterangan']) ?>">
                                        <i class="fas fa-play-circle"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><?= esc($item['keterangan']) ?></td>
                            <td><span class="badge bg-secondary"><?= esc($item['kategori']) ?></span></td>
                            <td><?= esc($item['tanggal_upload']) ?></td>
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
        new DataTable('#galleryTable');
    });
</script>
