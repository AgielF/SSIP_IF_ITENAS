<?php
// Data dummy, seharusnya diambil dari database
$announcements = [
    [
        'id' => 1,
        'judul' => 'Maintenance Sistem',
        'isi' => 'Akan dilakukan maintenance pada sistem informasi laboratorium pada hari Sabtu, 2 Agustus 2025, mulai pukul 22:00 WIB.',
        'tipe' => 'warning' // 'warning', 'info', 'success', 'danger'
    ],
    [
        'id' => 2,
        'judul' => 'Open Recruitment Asisten Lab',
        'isi' => 'Pendaftaran untuk rekrutmen asisten laboratorium periode 2025/2026 telah dibuka! Batas akhir pendaftaran adalah 15 Agustus 2025.',
        'tipe' => 'info'
    ],
];

// Fungsi helper untuk mendapatkan ikon berdasarkan tipe
function getAnnouncementIcon($type) {
    switch ($type) {
        case 'warning': return 'fas fa-exclamation-triangle';
        case 'info': return 'fas fa-bullhorn';
        case 'success': return 'fas fa-check-circle';
        case 'danger': return 'fas fa-times-circle';
        default: return 'fas fa-info-circle';
    }
}
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
    #announcementTable thead th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
</style>

<div class="container my-5">
    <div class="admin-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Kelola Pengumuman Penting</h4>
            <a href="#" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Tambah Pengumuman</a>
        </div>
        
        <div class="table-responsive">
            <table id="announcementTable" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Judul</th>
                        <th>Isi Pengumuman</th>
                        <th>Tipe</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($announcements as $item): ?>
                        <tr>
                            <td><?= esc($item['id']) ?></td>
                            <td>
                                <i class="<?= getAnnouncementIcon($item['tipe']) ?> me-2 text-<?= esc($item['tipe']) ?>"></i>
                                <strong><?= esc($item['judul']) ?></strong>
                            </td>
                            <td><?= esc($item['isi']) ?></td>
                            <td>
                                <span class="badge bg-<?= esc($item['tipe']) ?>"><?= esc(ucfirst($item['tipe'])) ?></span>
                            </td>
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
        new DataTable('#announcementTable');
    });
</script>
