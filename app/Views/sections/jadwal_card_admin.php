<!-- DataTables CSS -->
<link rel="stylesheet" href="<?= base_url('assets/datatables/css/dataTables.bootstrap5.min.css') ?>"/>


<style>
    .admin-container {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    #adminJadwalTable thead th {
        background-color: #f8f9fa;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        border-bottom: 2px solid #e9ecef;
    }
    #adminJadwalTable .btn-group .btn {
        border-radius: 6px;
    }
    .dataTables_wrapper .dataTables_paginate .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
</style>

<div class="container my-5">
    <div class="admin-container">
        <!-- Header Halaman Admin -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h3">Admin: Kelola Jadwal</h2>
                <p class="text-muted">Tambah, ubah, atau hapus jadwal praktikum dan acara.</p>
            </div>
            <div>
                <a href="#" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Tambah Jadwal Baru</a>
            </div>
        </div>

        <!-- Tabel Jadwal -->
        <div class="table-responsive">
            <table id="adminJadwalTable" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Judul Acara</th>
                        <th>Ruangan/Lab</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Instruktur</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($schedules)): ?>
                        <?php foreach ($schedules as $schedule): ?>
                            <tr>
                                <td><?= esc($schedule['title']) ?></td>
                                <td><?= esc($schedule['lab']) ?></td>
                                <td><?= esc($schedule['date']) ?></td>
                                <td><?= esc($schedule['time']) ?></td>
                                <td><?= esc($schedule['instructor']) ?></td>
                                <td>
                                    <span class="badge bg-<?= esc($schedule['status_color']) ?>"><?= esc($schedule['status']) ?></span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-secondary me-1" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada jadwal yang tersedia.</td>
                        </tr>
                    <?php endif; ?>
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
        new DataTable('#adminJadwalTable');
    });
</script>