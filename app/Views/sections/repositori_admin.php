<?php
// Data Dummy yang Diperkaya (Ditambah: creator, tahun, status, tags, supervisor, project_type, license, version, paper_link)
$repositories = [
    [
        'id' => 1,
        'nama' => 'SSIP Lab Web System',
        'kategori' => 'Kode Sumber',
        'project_type' => 'Proyek Mandiri', // BARU: Jenis Proyek
        'creator' => 'Tim Asisten 2023',
        'supervisor' => 'Bpk. Fajar, M.T.', // BARU: Pembimbing
        'tahun' => '2024',
        'version' => 'v2.0-stable', // BARU: Versi
        'status' => 'Active',
        'license' => 'Proprietary', // BARU: Lisensi
        'tags' => ['PHP', 'CI4', 'Bootstrap'],
        'platform' => 'github',
        'link' => '#',
        'paper_link' => '', // Kosong jika tidak ada paper
        'deskripsi' => 'Repositori utama berisi core system untuk manajemen lab SSIP berbasis CodeIgniter 4.'
    ],
    [
        'id' => 2,
        'nama' => 'Dataset Sensor Gempa',
        'kategori' => 'Dataset',
        'project_type' => 'Penelitian Dosen', // BARU
        'creator' => 'Dr. Budi Santoso',
        'supervisor' => '-', // Strip jika tidak ada
        'tahun' => '2023',
        'version' => 'Final Release', // BARU
        'status' => 'Archived',
        'license' => 'CC-BY-4.0', // BARU: Creative Commons
        'tags' => ['CSV', 'Excel', 'Raw Data'],
        'platform' => 'drive',
        'link' => '#',
        'paper_link' => 'https://jurnal.ac.id/gempa', // BARU: Ada link paper
        'deskripsi' => 'Kumpulan data CSV hasil pembacaan sensor accelerometer selama 30 hari.'
    ],
    [
        'id' => 3,
        'nama' => 'Spectrum Analyzer Tool',
        'kategori' => 'Tools',
        'project_type' => 'Tugas Akhir', // BARU
        'creator' => 'Jeffry S.',
        'supervisor' => 'Ibu Rina, Ph.D.', // BARU
        'tahun' => '2022',
        'version' => 'v1.1', // BARU
        'status' => 'Maintenance',
        'license' => 'MIT License', // BARU
        'tags' => ['Python', 'PyQt', 'NumPy'],
        'platform' => 'gitlab',
        'link' => '#',
        'paper_link' => '',
        'deskripsi' => 'Aplikasi desktop berbasis Python untuk analisis spektrum sinyal suara.'
    ],
];

// Helper Warna Kategori
function getBsColor($cat) {
    return match($cat) {
        'Kode Sumber' => 'primary',
        'Dataset' => 'success',
        'Tools' => 'warning',
        default => 'secondary'
    };
}

// Helper Ikon Platform
function getIcon($platform) {
    return match($platform) {
        'github' => 'fab fa-github',
        'gitlab' => 'fab fa-gitlab',
        'drive' => 'fab fa-google-drive',
        default => 'fas fa-link'
    };
}

// Helper Warna Status
function getStatusColor($status) {
    return match($status) {
        'Active' => 'success',      // Hijau
        'Archived' => 'secondary',  // Abu-abu
        'Maintenance' => 'warning', // Kuning
        'Deprecated' => 'danger',   // Merah
        default => 'light'
    };
}

// BARU: Helper Warna Jenis Proyek
function getProjectTypeColor($type) {
    return match($type) {
        'Tugas Akhir' => 'info',
        'Proyek Mandiri' => 'primary',
        'Penelitian Dosen' => 'danger',
        default => 'secondary'
    };
}
?>

<link rel="stylesheet" href="<?= base_url('assets/vendor/fontawesome/css/all.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/datatables/css/dataTables.bootstrap5.min.css') ?>"/>

<div class="container my-5">
    
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        
        <div class="card-header bg-white py-4 px-4 border-bottom border-light d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1 fw-bold text-dark">Repositori Proyek</h5>
                <p class="text-muted small mb-0">Manajemen aset digital, kode sumber, dan dataset.</p>
            </div>
            <a href="#" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="fas fa-plus me-2"></i>Tambah Repo
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="repoTable" class="table table-hover align-middle mb-0" style="width:100%">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3 text-secondary text-uppercase small fw-bold" width="35%">Repository Info</th>
                            <th class="py-3 text-secondary text-uppercase small fw-bold" width="20%">Category & Tags</th>
                            <th class="py-3 text-secondary text-uppercase small fw-bold" width="10%">Status</th>
                            <th class="py-3 text-secondary text-uppercase small fw-bold" width="20%">Description</th>
                            <th class="px-4 py-3 text-secondary text-uppercase small fw-bold text-end" width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($repositories as $repo): ?>
                            <?php $catColor = getBsColor($repo['kategori']); ?>
                            <?php $statusColor = getStatusColor($repo['status']); ?>
                            
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-light text-primary d-flex align-items-center justify-content-center rounded-3 me-3 flex-shrink-0" style="width: 45px; height: 45px;">
                                            <i class="fas fa-folder-open fs-5"></i>
                                        </div>
                                        <div>
                                            <span class="badge bg-<?= getProjectTypeColor($repo['project_type']) ?> bg-opacity-10 text-<?= getProjectTypeColor($repo['project_type']) ?> border border-<?= getProjectTypeColor($repo['project_type']) ?> border-opacity-25 rounded-1 p-1 mb-1" style="font-size: 0.65rem;">
                                                <?= esc($repo['project_type']) ?>
                                            </span>

                                            <div class="fw-bold text-dark lh-sm mb-1">
                                                <?= esc($repo['nama']) ?> 
                                                <span class="text-muted fw-normal small ms-1">(<?= esc($repo['version']) ?>)</span>
                                            </div>
                                            
                                            <div class="text-muted small d-flex flex-column">
                                                <div class="d-flex align-items-center flex-wrap mb-1">
                                                    <span class="me-2" title="ID Repo"><i class="fas fa-hashtag me-1"></i><?= esc($repo['id']) ?></span>
                                                    <span class="me-2">&bull;</span>
                                                    <span class="me-2" title="Creator"><i class="fas fa-user-circle me-1"></i><?= esc($repo['creator']) ?></span>
                                                    <span class="me-2">&bull;</span>
                                                    <span title="Tahun"><i class="fas fa-calendar-alt me-1"></i><?= esc($repo['tahun']) ?></span>
                                                </div>
                                                
                                                <?php if($repo['supervisor'] !== '-'): ?>
                                                <div class="text-secondary" style="font-size: 0.75rem;">
                                                    <i class="fas fa-chalkboard-teacher me-2" style="width: 12px;"></i> Pembimbing: <?= esc($repo['supervisor']) ?>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-3">
                                    <div class="mb-2 d-flex align-items-center gap-2">
                                        <span class="badge bg-<?= $catColor ?> bg-opacity-10 text-<?= $catColor ?> border border-<?= $catColor ?> border-opacity-10 rounded-pill px-3">
                                            <?= esc($repo['kategori']) ?>
                                        </span>
                                        <span class="badge bg-light text-secondary border" title="License Type">
                                            <i class="fas fa-balance-scale me-1 small"></i> <?= esc($repo['license']) ?>
                                        </span>
                                    </div>
                                    
                                    <div class="d-flex flex-wrap gap-1">
                                        <?php foreach($repo['tags'] as $tag): ?>
                                            <span class="badge bg-white text-secondary border fw-normal" style="font-size: 0.7rem;">
                                                <?= esc($tag) ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                </td>

                                <td class="py-3">
                                    <div class="d-flex align-items-center">
                                        <span class="d-inline-block rounded-circle bg-<?= $statusColor ?> me-2" style="width: 8px; height: 8px;"></span>
                                        <span class="text-dark small fw-semibold"><?= esc($repo['status']) ?></span>
                                    </div>
                                </td>

                                <td class="py-3">
                                    <div class="d-inline-block text-truncate text-muted small" style="max-width: 200px;" title="<?= esc($repo['deskripsi']) ?>">
                                        <?= esc($repo['deskripsi']) ?>
                                    </div>

                                    <?php if(!empty($repo['paper_link'])): ?>
                                    <div class="mt-1">
                                        <a href="<?= esc($repo['paper_link']) ?>" target="_blank" class="text-decoration-none small text-primary fw-semibold">
                                            <i class="fas fa-file-pdf me-1"></i> Baca Publikasi
                                        </a>
                                    </div>
                                    <?php endif; ?>
                                </td>

                                <td class="px-4 py-3 text-end">
                                    <div class="btn-group">
                                        <a href="<?= esc($repo['link']) ?>" target="_blank" class="btn btn-outline-dark btn-sm rounded-start-pill ps-3 pe-2" title="Buka Link">
                                            <i class="<?= getIcon($repo['platform']) ?>"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-secondary btn-sm" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm rounded-end-pill pe-3 ps-2" title="Hapus" onclick="return confirm('Hapus?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card-footer bg-white border-top border-light py-3 px-4 d-flex justify-content-between align-items-center">
            <small class="text-muted">Menampilkan <strong><?= count($repositories) ?></strong> repositori aktif</small>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/datatables/js/dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/datatables/js/dataTables.bootstrap5.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        $('#repoTable').DataTable({
            "language": { "search": "", "searchPlaceholder": "Cari (Judul, Tags, Tahun)...", "lengthMenu": "_MENU_" },
            "dom": "<'row px-4 pt-3'<'col-md-6'l><'col-md-6'f>>" +
                   "<'row'<'col-sm-12'tr>>" +
                   "<'row px-4 pb-3'<'col-md-5'i><'col-md-7'p>>",
            "columnDefs": [ { "orderable": false, "targets": [4] } ]
        });
    });
</script>