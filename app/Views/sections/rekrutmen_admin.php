<style>
    .fm-content { padding: 30px; background-color: #ffffff; }
    .fm-table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
    }
    .fm-table tbody tr:hover { background-color: #f8f9fa; }
    .nav-tabs .nav-link { color: #555; font-weight: 500; }
    .nav-tabs .nav-link.active {
        color: #0d6efd; border-color: #dee2e6 #dee2e6 #fff;
    }
    @media print {
        body * { visibility: hidden; }
        #printable-area, #printable-area * { visibility: visible; }
        #printable-area { position: absolute; left: 0; top: 0; width: 100%; }
        .btn, .nav-tabs, #search-input, #sort-filter, #items-per-page-filter,
        #pagination-controls, label, #record-info, .non-printable { display: none !important; }
    }
</style>

<div class="container my-5">
    <!-- Flash Message -->
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <!-- Navigasi Tab -->
    <ul class="nav nav-tabs" id="project-nav">
        <li class="nav-item">
            <a class="nav-link active" href="#" data-content="rekrutmen">Daftar Rekrutmen</a>
        </li>
    </ul>

    <!-- Konten Utama -->
    <main class="fm-content card rounded-0 rounded-bottom border-top-0">
        <div class="card-body">
            <div id="printable-area">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3 non-printable">
                    <div>
                        <h4 class="mb-0" id="content-title">Daftar Rekrutmen</h4>
                    </div>

                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <input type="text" id="search-input" class="form-control form-control-sm" placeholder="Cari data..." style="width: auto;">
                        <select id="sort-filter" class="form-select form-select-sm">
                            <option value="desc">Terbaru</option>
                            <option value="asc">Terlama</option>
                        </select>
                        <select id="items-per-page-filter" class="form-select form-select-sm">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="all">Semua</option>
                        </select>
                        <button id="export-pdf-btn" class="btn btn-sm btn-danger">
                            <i class="fas fa-file-pdf me-1"></i> PDF
                        </button>
                        <button id="add-data-btn" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addDataModal">
                            <i class="fas fa-plus me-1"></i> Tambah Data
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table fm-table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Syarat</th>
                                <th class="non-printable">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="rekrutmen-table-body">
                            <?php if (!empty($rekrutmen['rows'])): ?>
                                <?php foreach ($rekrutmen['rows'] as $i => $row): ?>
                                    <tr data-id="<?= $row['id'] ?>" data-date="<?= esc($row['id']) ?>">
                                        <td><?= $i+1 ?></td>
                                        <td><?= esc($row['deskripsi']) ?></td>
                                        <td><?= esc($row['status']) ?></td>
                                        <td><?= esc($row['syarat']) ?></td>
                                        <td class="non-printable">
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-secondary me-1 edit-btn"
                                                    data-id="<?= $row['id'] ?>"
                                                    data-deskripsi="<?= esc($row['deskripsi']) ?>"
                                                    data-status="<?= esc($row['status']) ?>"
                                                    data-syarat="<?= esc($row['syarat']) ?>"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editDataModal">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <form action="/rekrutmen/delete/<?= $row['id'] ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="text-center text-muted">Belum ada data</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center non-printable mt-3">
                    <div id="record-info" class="text-muted"></div>
                    <div id="pagination-controls" class="btn-group"></div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="addDataModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="/rekrutmen/store" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Rekrutmen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <input type="text" name="deskripsi" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <input type="text" name="status" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Syarat</label>
                    <textarea name="syarat" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jadwal</label>
                    <select name="id_jadwal" class="form-select" required>
                        <?php if (!empty($jadwal)): ?>
                            <?php foreach ($jadwal as $j): ?>
                                <option value="<?= $j['id_jadwal'] ?>">
                                    <?= $j['tanggal'] ?> - <?= $j['waktu_mulai'] ?> (<?= $j['nama_event'] ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option disabled selected>-- Belum ada jadwal --</option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Data -->
<div class="modal fade" id="editDataModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="edit-form" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Rekrutmen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <input type="text" name="deskripsi" id="edit-deskripsi" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <input type="text" name="status" id="edit-status" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Syarat</label>
                    <textarea name="syarat" id="edit-syarat" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jadwal</label>
                    <select name="id_jadwal" id="edit-jadwal" class="form-select" required>
                        <?php if (!empty($jadwal)): ?>
                            <?php foreach ($jadwal as $j): ?>
                                <option value="<?= $j['id_jadwal'] ?>">
                                    <?= $j['tanggal'] ?> - <?= $j['waktu_mulai'] ?> (<?= $j['nama_event'] ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option disabled selected>-- Belum ada jadwal --</option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const exportPdfBtn = document.getElementById('export-pdf-btn');
    const sortFilter = document.getElementById('sort-filter');
    const itemsPerPageFilter = document.getElementById('items-per-page-filter');
    const tableBody = document.getElementById('rekrutmen-table-body');
    const rows = Array.from(tableBody.querySelectorAll('tr'));
    const recordInfo = document.getElementById('record-info');
    const paginationControls = document.getElementById('pagination-controls');

    let currentPage = 1;
    let itemsPerPage = parseInt(itemsPerPageFilter.value);

    function renderTable() {
        let filtered = rows.filter(row => {
            const term = searchInput.value.toLowerCase();
            return row.textContent.toLowerCase().includes(term);
        });

        // Sorting
        filtered.sort((a, b) => {
            let idA = parseInt(a.dataset.id);
            let idB = parseInt(b.dataset.id);
            return sortFilter.value === 'asc' ? idA - idB : idB - idA;
        });

        // Pagination
        if (itemsPerPageFilter.value !== 'all') {
            itemsPerPage = parseInt(itemsPerPageFilter.value);
            let start = (currentPage - 1) * itemsPerPage;
            let end = start + itemsPerPage;
            filtered.forEach((row, idx) => row.style.display = (idx >= start && idx < end) ? '' : 'none');
        } else {
            filtered.forEach(row => row.style.display = '');
        }

        // Info & Pagination
        recordInfo.textContent = `Menampilkan ${filtered.length} data`;
        paginationControls.innerHTML = '';
        if (itemsPerPageFilter.value !== 'all') {
            let totalPages = Math.ceil(filtered.length / itemsPerPage);
            for (let i = 1; i <= totalPages; i++) {
                let btn = document.createElement('button');
                btn.className = 'btn btn-sm ' + (i === currentPage ? 'btn-primary' : 'btn-outline-primary');
                btn.textContent = i;
                btn.onclick = () => { currentPage = i; renderTable(); };
                paginationControls.appendChild(btn);
            }
        }
    }

    searchInput.addEventListener('keyup', renderTable);
    sortFilter.addEventListener('change', () => { currentPage = 1; renderTable(); });
    itemsPerPageFilter.addEventListener('change', () => { currentPage = 1; renderTable(); });
    exportPdfBtn.addEventListener('click', () => window.print());

    // Modal Edit
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            let id = btn.dataset.id;
            document.getElementById('edit-form').action = `/rekrutmen/update/${id}`;
            document.getElementById('edit-deskripsi').value = btn.dataset.deskripsi;
            document.getElementById('edit-status').value = btn.dataset.status;
            document.getElementById('edit-syarat').value = btn.dataset.syarat;
        });
    });

    renderTable();
});
</script>
