<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">

<style>
    .schedule-container {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    #jadwalTable thead th {
        background-color: #f8f9fa;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        border-bottom: 2px solid #e9ecef;
    }
    #jadwalTable tbody tr {
        border-bottom: 1px solid #e9ecef;
    }
    #jadwalTable tbody tr:last-child {
        border-bottom: none;
    }
    #jadwalTable .btn-group .btn {
        border-radius: 6px;
    }
    .dataTables_wrapper .dataTables_paginate .page-item.active .page-link {
        background-color: #ffc107; /* Warna kuning untuk paginasi aktif */
        border-color: #ffc107;
    }
    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        border-radius: 6px;
    }
</style>

<div class="container my-5">
    <div class="schedule-container">
        <h4 class="mb-4">Jadwal Kuliah</h4>
        <div class="table-responsive">
            <table id="jadwalTable" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Matakuliah</th>
                        <th>Kelas</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Dosen</th>
                        <th>Ruang</th>
                        <th>Jenis</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($schedules)): ?>
                        <?php foreach ($schedules as $schedule): ?>
                            <tr>
                                <td><?= esc($schedule['title']) ?></td>
                                <td>AA</td> <!-- Data dummy untuk Kelas -->
                                <td><?= esc(strtoupper(explode(',', $schedule['date'])[0])) ?></td>
                                <td><?= esc($schedule['time']) ?></td>
                                <td><?= esc($schedule['instructor']) ?></td>
                                <td><?= esc($schedule['lab']) ?></td>
                                <td>KULIAH</td> <!-- Data dummy untuk Jenis -->
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-light btn-sm" title="Lihat Detail">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        <button type="button" class="btn btn-light btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="visually-hidden">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                            <li><a class="dropdown-item" href="#">Hapus</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                         <tr>
                            <td colspan="8" class="text-center">Tidak ada jadwal yang tersedia.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>

<script>
    // Inisialisasi DataTables
    document.addEventListener('DOMContentLoaded', function () {
        new DataTable('#jadwalTable');
    });
</script>
