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
    <!-- Tabs -->
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

    <!-- Content -->
    <main class="fm-content card rounded-0 rounded-bottom border-top-0">
        <div class="card-body">
            <div id="printable-area">

                <!-- Toolbar -->
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

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table fm-table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Jenis</th>
                                <th>Kategori</th>
                                <th>Penulis Utama</th>
                                <th>Tanggal</th>
                                <th>Penulis</th>
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
                                        <td><?= esc($row['jenis_publikasi']) ?></td>
                                        <td><?= esc($row['kategori']) ?></td>
                                         <td><?= esc($row['penulis_utama'] ?? '-') ?></td> <!-- ✅ hasil join -->
                                        <td><?= esc($row['tanggal_publikasi']) ?></td>
                                        <td><?= esc($row['penulis_pendamping']) ?></td>
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
                                                method="get" 
                                                class="d-inline delete-form"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger btn-delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal<?= $row['id_publikasi'] ?>" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <form method="post" action="<?= site_url('publikasi-ilmiah/update/'.$row['id_publikasi']) ?>">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Publikasi</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label>Jenis Publikasi</label>
                                                            <select name="jenis_publikasi" class="form-control">
                                                                <option value="jurnal" <?= $row['jenis_publikasi']=='jurnal'?'selected':'' ?>>Jurnal</option>
                                                                <option value="prosiding" <?= $row['jenis_publikasi']=='prosiding'?'selected':'' ?>>Prosiding</option>
                                                                <option value="paten" <?= $row['jenis_publikasi']=='paten'?'selected':'' ?>>Paten</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Judul / Link Publikasi</label>
                                                            <input type="text" name="link_publikasi" class="form-control" value="<?= esc($row['link_publikasi']) ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Kategori</label>
                                                            <input type="text" name="kategori" class="form-control" value="<?= esc($row['kategori']) ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Tanggal Publikasi</label>
                                                            <input type="date" name="tanggal_publikasi" class="form-control" value="<?= esc($row['tanggal_publikasi']) ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Penulis Pendamping</label>
                                                            <input type="text" name="penulis_pendamping" class="form-control" value="<?= esc($row['penulis_pendamping']) ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Volume</label>
                                                            <input type="text" name="volume" class="form-control" value="<?= esc($row['volume']) ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Nomor</label>
                                                            <input type="text" name="nomor" class="form-control" value="<?= esc($row['nomor']) ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Tahun</label>
                                                            <input type="text" name="tahun" class="form-control" value="<?= esc($row['tahun']) ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Link DOI</label>
                                                            <input type="text" name="link_doi" class="form-control" value="<?= esc($row['link_doi']) ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Link GDrive</label>
                                                            <input type="text" name="link_gdrive" class="form-control" value="<?= esc($row['link_gdrive']) ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Conference</label>
                                                            <input type="text" name="conference" class="form-control" value="<?= esc($row['conference']) ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Deskripsi</label>
                                                            <textarea name="deskripsi" class="form-control"><?= esc($row['deskripsi']) ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
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

            <!-- Pagination -->
            <?php if ($pager): ?>
                <div class="d-flex justify-content-end">
                    <?= $pager->links() ?>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" action="<?= site_url('publikasi-ilmiah/store') ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Publikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Jenis Publikasi</label>
                        <select name="jenis_publikasi" class="form-control">
                            <option value="jurnal">Jurnal</option>
                            <option value="prosiding">Prosiding</option>
                            <option value="paten">Paten</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Judul / Link Publikasi</label>
                        <input type="text" name="link_publikasi" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Kategori</label>
                        <input type="text" name="kategori" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Tanggal Publikasi</label>
                        <input type="date" name="tanggal_publikasi" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Penulis Pendamping</label>
                        <input type="text" name="penulis_pendamping" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Volume</label>
                        <input type="text" name="volume" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Nomor</label>
                        <input type="text" name="nomor" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Tahun</label>
                        <input type="text" name="tahun" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Link DOI</label>
                        <input type="text" name="link_doi" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Link GDrive</label>
                        <input type="text" name="link_gdrive" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Conference</label>
                        <input type="text" name="conference" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('export-pdf-btn').addEventListener('click', function() {
    window.print();
});
</script>
