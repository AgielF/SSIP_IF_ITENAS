<?php
// Pastikan variabel ada agar tidak error
$publicationData = $publicationData ?? [];
$pager = $pager ?? null;
$search = $search ?? '';
$kategori = $kategori ?? '';
$sort = $sort ?? 'newest';
$limit = $limit ?? 10;

// Bagi data berdasarkan jenis publikasi
$groupedData = [
    'jurnal'    => [],
    'prosiding' => [],
    'paten'     => [],
];
foreach ($publicationData as $row) {
    $jenis = strtolower($row['jenis_publikasi']);
    if (isset($groupedData[$jenis])) {
        $groupedData[$jenis][] = $row;
    }
}
?>

<style>
.fm-content {
    padding: 30px;
    background-color: #ffffff;
}
.fm-table thead th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
}
.fm-table tbody tr:hover {
    background-color: #f8f9fa;
}
.nav-tabs .nav-link {
    color: #555;
    font-weight: 500;
}
.nav-tabs .nav-link.active {
    color: #0d6efd;
    border-color: #dee2e6 #dee2e6 #fff;
}
/* Print PDF */
@media print {
    body * {
        visibility: hidden;
    }
    #printable-area, #printable-area * {
        visibility: visible;
    }
    #printable-area {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    .btn, .nav-tabs, #search-input, #sort-filter, #items-per-page-filter,
    #pagination-controls, label, .action-buttons {
        display: none !important;
    }
}
</style>

<div class="container my-5">
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
        <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4000">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-check-circle me-2"></i>
                    <span id="successMessage"></span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

        <div id="errorToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4000">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <span id="errorMessage"></span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('successMessage').textContent = "<?= session()->getFlashdata('success') ?>";
                const successToast = new bootstrap.Toast(document.getElementById('successToast'));
                successToast.show();
            });
        </script>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('errorMessage').textContent = "<?= session()->getFlashdata('error') ?>";
                const errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                errorToast.show();
            });
        </script>
    <?php endif; ?>
    <ul class="nav nav-tabs" id="publication-nav">
        <li class="nav-item">
            <a class="nav-link <?= $kategori === 'jurnal' || $kategori==='' ? 'active' : '' ?>" href="?kategori=jurnal">Jurnal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $kategori === 'prosiding' ? 'active' : '' ?>" href="?kategori=prosiding">Prosiding</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $kategori === 'paten' ? 'active' : '' ?>" href="?kategori=paten">Paten</a>
        </li>
    </ul>

    <main class="fm-content card rounded-0 rounded-bottom border-top-0">
        <div class="card-body">
            <div id="printable-area">

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                    <h4 class="mb-0">
                        <?= ucfirst($kategori ?: 'Jurnal') ?>
                    </h4>
                    
                    <form method="get" class="d-flex align-items-center gap-2 flex-wrap">
                        <input type="hidden" name="kategori" value="<?= esc($kategori) ?>">
                        <input type="text" name="search" value="<?= esc($search) ?>" 
                               class="form-control form-control-sm" placeholder="Cari data..." style="width: auto;">

                        <div class="d-flex align-items-center">
                            <label for="sort-filter" class="form-label me-2 mb-0 small text-nowrap">Urutkan:</label>
                            <select name="sort" class="form-select form-select-sm" id="sort-filter" onchange="this.form.submit()">
                                <option value="newest" <?= $sort==='newest'?'selected':'' ?>>Terbaru</option>
                                <option value="oldest" <?= $sort==='oldest'?'selected':'' ?>>Terlama</option>
                            </select>
                        </div>
                        <div class="d-flex align-items-center">
                            <label for="items-per-page-filter" class="form-label me-2 mb-0 small text-nowrap">Tampilkan:</label>
                            <select name="limit" class="form-select form-select-sm" id="items-per-page-filter" onchange="this.form.submit()">
                                <option value="5" <?= $limit==5?'selected':'' ?>>5</option>
                                <option value="10" <?= $limit==10?'selected':'' ?>>10</option>
                                <option value="25" <?= $limit==25?'selected':'' ?>>25</option>
                                <option value="50" <?= $limit==50?'selected':'' ?>>50</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-sm btn-secondary">
                            <i class="fas fa-search"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="fas fa-plus me-1"></i> Tambah
                        </button>
                        <button type="button" id="export-pdf-btn" class="btn btn-sm btn-danger">
                            <i class="fas fa-file-pdf me-1"></i> Export PDF
                        </button>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table fm-table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Topik</th>
                                <th>Kategori</th>
                                <th>Tanggal </th>
                                <th>Penulis Utama</th>
                                <th>Penulis Pendamping</th>
                                <th>Volume</th>
                                <th>Tahun</th>
                                <th>Nomor</th>
                                <th>Conference</th>
                                <th>Deskripsi</th>
                                <th>Link Publikasi</th>
                                <th class="action-buttons">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($groupedData[$kategori ?: 'jurnal'])): ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Tidak ada data</td>
                                </tr>
                            <?php else: ?>
                                <?php $i=1 + ($limit * (max(1, (int)($_GET['page'] ?? 1)) -1)); ?>
                                <?php foreach ($groupedData[$kategori ?: 'jurnal'] as $row): ?>
                                    <tr>
                                        <td><?=esc($row['id_publikasi'])?></td>
                                        <td><?=esc($row['judul'])?></td>
                                        <td><?=esc($row['kategori'])?></td>
                                        <td><?=esc($row['topik'])?></td>
                                        <td><?= esc($row['kategori']) ?></td>
                                        <td><?= esc($row['tanggal_publikasi']) ?></td>
                                         <td><?= esc($row['penulis_utama'] ?? '-') ?></td> <td><?= esc($row['penulis_pendamping']) ?></td>
                                        <td><?= esc($row['volume']) ?></td>
                                        <td><?= esc($row['tahun']) ?></td>
                                        <td><?= esc($row['nomor']) ?></td>
                                        <td><?= esc($row['conference']) ?></td>
                                        <td><?= esc($row['deskripsi']) ?></td>
                                        <td>
                                            <?php if (!empty($row['link_publikasi'])): ?>
                                                <a href="<?= esc($row['link_publikasi']) ?>" target="_blank" class="btn btn-sm btn-info">Publikasi</a>
                                            <?php endif; ?>
                                            <?php if (!empty($row['link_doi'])): ?>
                                                <a href="<?= esc($row['link_doi']) ?>" target="_blank" class="btn btn-sm btn-success">DOI</a>
                                            <?php endif; ?>
                                            <?php if (!empty($row['link_gdrive'])): ?>
                                                <a href="<?= esc($row['link_gdrive']) ?>" target="_blank" class="btn btn-sm btn-secondary">GDrive</a>
                                            <?php endif; ?>
                                        </td>
                                        <td class="action-buttons">
                                            <button class="btn btn-sm btn-outline-secondary btn-edit" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id_publikasi'] ?>"> <i class="fas fa-pencil-alt"></i></button>
                                            <form action="<?= site_url('publikasi-ilmiah/delete/'.$row['id_publikasi']) ?>" 
                                                method="POST" class="d-inline delete-form"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data publikasi ini?');">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger btn-delete" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="editModal<?= $row['id_publikasi'] ?>" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <form method="post" action="<?= site_url('publikasi-ilmiah/update/'.$row['id_publikasi']) ?>">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Publikasi</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Jenis Publikasi</label>
                                                                    <select name="jenis_publikasi" class="form-select">
                                                                        <option value="jurnal" <?= $row['jenis_publikasi']=='jurnal'?'selected':'' ?>>Jurnal</option>
                                                                        <option value="prosiding" <?= $row['jenis_publikasi']=='prosiding'?'selected':'' ?>>Prosiding</option>
                                                                        <option value="paten" <?= $row['jenis_publikasi']=='paten'?'selected':'' ?>>Paten</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Judul</label>
                                                                    <input type="text" name="judul" class="form-control" value="<?= esc($row['judul']) ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Penulis Utama <span class="text-danger">*</span></label>
                                                                    <select name="id_user" class="form-select" required>
                                                                        <option value="">-- Pilih Penulis --</option>
                                                                        <?php foreach ($allUsers ?? [] as $user): ?>
                                                                            <option value="<?= $user['id'] ?>" <?= $row['id_user'] == $user['id'] ? 'selected' : '' ?>>
                                                                                <?= esc($user['nama']) ?> (<?= $user['role_id'] == 1 ? 'Kepala Lab' : ($user['role_id'] == 2 ? 'Asisten' : 'Dosen') ?>)
                                                                            </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Penulis Pendamping</label>
                                                                    <select name="penulis_pendamping" class="form-select">
                                                                        <option value="">-- Pilih Penulis Pendamping (Opsional) --</option>
                                                                        <?php foreach ($allUsers ?? [] as $user): ?>
                                                                            <option value="<?= esc($user['nama']) ?>" <?= esc($row['penulis_pendamping']) == esc($user['nama']) ? 'selected' : '' ?>>
                                                                                <?= esc($user['nama']) ?> (<?= $user['role_id'] == 1 ? 'Kepala Lab' : ($user['role_id'] == 2 ? 'Asisten' : 'Dosen') ?>)
                                                                            </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Kategori</label>
                                                                    <input type="text" name="kategori" class="form-control" value="<?= esc($row['kategori']) ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Topik</label>
                                                                    <select name="topik" class="form-select" required>
                                                                        <option value="">-- Pilih Topik --</option>
                                                                        <option value="machine learning" <?= $row['topik']=='machine learning'?'selected':'' ?>>Machine Learning</option>
                                                                        <option value="system expert" <?= $row['topik']=='system expert'?'selected':'' ?>>System Expert</option>
                                                                        <option value="smart system" <?= $row['topik']=='smart system'?'selected':'' ?>>Smart System</option>
                                                                        <option value="artificial-intelligence" <?= $row['topik']=='artificial-intelligence'?'selected':'' ?>>Artificial Intelligence</option>
                                                                        <option value="data mining" <?= $row['topik']=='data mining'?'selected':'' ?>>Data Mining</option>
                                                                        <option value="deep learning" <?= $row['topik']=='deep learning'?'selected':'' ?>>Deep Learning</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Tanggal Publikasi</label>
                                                                    <input type="date" name="tanggal_publikasi" class="form-control" value="<?= esc($row['tanggal_publikasi']) ?>">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Volume</label>
                                                                    <input type="text" name="volume" class="form-control" value="<?= esc($row['volume']) ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Nomor</label>
                                                                    <input type="text" name="nomor" class="form-control" value="<?= esc($row['nomor']) ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Tahun</label>
                                                                    <input type="text" name="tahun" class="form-control" value="<?= esc($row['tahun']) ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Conference</label>
                                                                    <input type="text" name="conference" class="form-control" value="<?= esc($row['conference']) ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Link Publikasi</label>
                                                                    <input type="text" name="link_publikasi" class="form-control" value="<?= esc($row['link_publikasi']) ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Link DOI</label>
                                                                    <input type="text" name="link_doi" class="form-control" value="<?= esc($row['link_doi']) ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Link GDrive</label>
                                                                    <input type="text" name="link_gdrive" class="form-control" value="<?= esc($row['link_gdrive']) ?>">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Deskripsi</label>
                                                                    <textarea name="deskripsi" class="form-control" rows="3"><?= esc($row['deskripsi']) ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
                
            </div>

            <?php if ($pager): ?>
                <div class="d-flex justify-content-end">
                    <?= $pager->links() ?>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>

<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" action="<?= site_url('publikasi-ilmiah/store') ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Publikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Jenis Publikasi</label>
                                <select name="jenis_publikasi" class="form-select">
                                    <option value="jurnal">Jurnal</option>
                                    <option value="prosiding">Prosiding</option>
                                    <option value="paten">Paten</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Judul</label>
                                <input type="text" name="judul" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Penulis Utama <span class="text-danger">*</span></label>
                                <select name="id_user" class="form-select" required>
                                    <option value="">-- Pilih Penulis --</option>
                                    <?php foreach ($allUsers ?? [] as $user): ?>
                                        <option value="<?= $user['id'] ?>">
                                            <?= esc($user['nama']) ?> (<?= $user['role_id'] == 1 ? 'Kepala Lab' : ($user['role_id'] == 2 ? 'Asisten' : 'Dosen') ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Penulis Pendamping</label>
                                <select name="penulis_pendamping" class="form-select">
                                    <option value="">-- Pilih Penulis Pendamping (Opsional) --</option>
                                    <?php foreach ($allUsers ?? [] as $user): ?>
                                        <option value="<?= esc($user['nama']) ?>">
                                            <?= esc($user['nama']) ?> (<?= $user['role_id'] == 1 ? 'Kepala Lab' : ($user['role_id'] == 2 ? 'Asisten' : 'Dosen') ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <input type="text" name="kategori" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Topik</label>
                                <select name="topik" class="form-select" required>
                                    <option value="">-- Pilih Topik --</option>
                                    <option value="machine learning">Machine Learning</option>
                                    <option value="system expert">System Expert</option>
                                    <option value="smart system">Smart System</option>
                                    <option value="artificial-intelligence">Artificial Intelligence</option>
                                    <option value="data mining">Data Mining</option>
                                    <option value="deep learning">Deep Learning</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Publikasi</label>
                                <input type="date" name="tanggal_publikasi" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Volume</label>
                                <input type="text" name="volume" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nomor</label>
                                <input type="text" name="nomor" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tahun</label>
                                <input type="text" name="tahun" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Conference</label>
                                <input type="text" name="conference" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Link Publikasi</label>
                                <input type="text" name="link_publikasi" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Link DOI</label>
                                <input type="text" name="link_doi" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Link GDrive</label>
                                <input type="text" name="link_gdrive" class="form-control">
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Simple functionality for publikasi admin
document.addEventListener('DOMContentLoaded', function() {

        // Hide results when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target)) {
                const results = searchInput.parentNode.querySelector('.search-results');
                if (results) {
                    results.remove();
                }
            }
        });

        // Allow manual entry for penulis pendamping
        if (hiddenInput) {
            searchInput.addEventListener('blur', function() {
                // If user typed something not in dropdown, keep it
                setTimeout(() => {
                    hiddenInput.value = this.value;
                }, 100);
            });
        }
    });
    initializeSearchableDropdown('search-penulis-utama-add', 'penulis-utama-add');
    initializeSearchableDropdown('search-penulis-pendamping-add', 'penulis-pendamping-add', 'penulis-pendamping-hidden-add');

    // Initialize searchable dropdowns for edit modals when they open
    document.addEventListener('shown.bs.modal', function(event) {
        const modal = event.target;
        if (modal.classList.contains('modal') && modal.id.startsWith('editModal')) {
            const publikasiId = modal.id.replace('editModal', '');

            // Initialize dropdowns for this specific modal
            setTimeout(() => {
                initializeSearchableDropdown('search-penulis-utama-' + publikasiId, 'penulis-utama-' + publikasiId);
                initializeSearchableDropdown('search-penulis-pendamping-' + publikasiId, 'penulis-pendamping-' + publikasiId, 'penulis-pendamping-hidden-' + publikasiId);
            }, 100);
        }
    });

    // Export PDF functionality
    document.getElementById('export-pdf-btn').addEventListener('click', function() {
        window.print();
    });

    // Toast notifications
    <?php if (session()->getFlashdata('success')): ?>
        // Success toast
        const successToast = document.createElement('div');
        successToast.className = 'toast align-items-center text-white bg-success border-0 position-fixed';
        successToast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        successToast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        document.body.appendChild(successToast);
        const bsToast = new bootstrap.Toast(successToast);
        bsToast.show();
        setTimeout(() => successToast.remove(), 5000);
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        // Error toast
        const errorToast = document.createElement('div');
        errorToast.className = 'toast align-items-center text-white bg-danger border-0 position-fixed';
        errorToast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        errorToast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        document.body.appendChild(errorToast);
        const bsToast = new bootstrap.Toast(errorToast);
        bsToast.show();
        setTimeout(() => errorToast.remove(), 5000);
    <?php endif; ?>

// Export PDF functionality
document.getElementById('export-pdf-btn').addEventListener('click', function() {
    window.print();
});
</script>