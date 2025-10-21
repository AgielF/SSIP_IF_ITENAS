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
    @media print {
        body * { visibility: hidden; }
        #printable-area, #printable-area * { visibility: visible; }
        #printable-area { position: absolute; left: 0; top: 0; width: 100%; }
        .btn, .nav-tabs, #search-input, #sort-filter, #items-per-page-filter,
        #pagination-controls, label, #record-info, .non-printable {
            display: none !important;
        }
    }
</style>

<div class="container my-5">
    <ul class="nav nav-tabs" id="project-nav">
        <li class="nav-item">
            <a class="nav-link active" href="#">Daftar Galeri</a>
        </li>
    </ul>

    <main class="fm-content card rounded-0 rounded-bottom border-top-0">
        <div class="card-body">
            <div id="printable-area">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                    <h4 class="mb-0">Daftar Galeri</h4>
                    
                    <div class="d-flex align-items-center gap-2 flex-wrap non-printable">
                        <input type="text" id="search-input" class="form-control form-control-sm" placeholder="Cari data..." style="width: auto;">
                        
                        <div class="d-flex align-items-center">
                            <label for="sort-filter">Urutkan:</label>
<select id="sort-filter" class="form-select form-select-sm"
        onchange="location.href='?sort=' + this.value">
    <option value="DESC" <?= ($sort === 'DESC') ? 'selected' : '' ?>>Terbaru</option>
    <option value="ASC" <?= ($sort === 'ASC') ? 'selected' : '' ?>>Terlama</option>
</select>

                        </div>
                        <div class="d-flex align-items-center">
                            <label for="items-per-page-filter" class="form-label me-2 mb-0 small text-nowrap">Tampilkan:</label>
                            <select class="form-select form-select-sm" id="items-per-page-filter">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="all">Semua</option>
                            </select>
                        </div>
                        <button id="export-pdf-btn" class="btn btn-sm btn-danger">
                            <i class="fas fa-file-pdf me-1"></i> PDF
                        </button>
                        <button id="add-data-btn" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addDataModal">
                            <i class="fas fa-plus me-1"></i> Tambah Data
                        </button>
                    </div>
                </div>

                <p class="text-muted small mb-3" id="record-info">Menampilkan data...</p>

                <div class="table-responsive">
                    <table class="table fm-table table-hover" id="galeri-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>admin penyunting</th>
                                <th>Kategori</th>
                                <th>Keterangan</th>
                                <th>File</th>
                                <th>Tanggal Upload</th>
                                <th class="non-printable">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
    <?php if (!empty($media_items['rows'])) : ?>
        <?php foreach ($media_items['rows'] as $row) : ?>
            <tr>
                <td><?= esc($row[0]) ?></td> <!-- ID -->
                <td><?= esc($row[1]) ?></td> <!-- Kategori -->
                <td><?= esc($row[2]) ?></td> <!-- Keterangan -->
                <td><?= esc($row[3]) ?></td> <!-- File -->
                <td><?= esc($row[4]) ?></td> <!-- Tanggal -->
                <td><?= esc($row[5]) ?></td> <!-- Tanggal -->
                <td class="non-printable">
                    <button class="btn btn-sm btn-outline-secondary me-1 btn-edit"
                            data-id="<?= $row[0] ?>"
                            data-kategori="<?= esc($row[1]) ?>"
                            data-keterangan="<?= esc($row[2]) ?>"
                            data-file="<?= esc($row[3]) ?>">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                    <a href="<?= site_url('galeri_admin/delete/'.$row[0]) ?>"
                       class="btn btn-sm btn-outline-danger"
                       onclick="return confirm('Hapus data ini?')">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td colspan="6" class="text-center text-muted">Data tidak ditemukan.</td>
        </tr>
    <?php endif; ?>
</tbody>


                    </table>
                </div>
            </div>
            
            <nav>
                <ul class="pagination pagination-sm justify-content-end" id="pagination-controls"></ul>
            </nav>
        </div>
    </main>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="addDataModal" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" action="<?= site_url('galeri_admin/store') ?>" method="post">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <input type="text" name="kategori" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">File (URL/Path)</label>
                    <input type="text" name="file_url" class="form-control">
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
        <form method="post" id="editForm" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_galeri" id="edit-id">
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <input type="text" name="kategori" id="edit-kategori" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" id="edit-keterangan" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">File (URL/Path)</label>
                    <input type="text" name="file_url" id="edit-file" class="form-control">
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
    const table = document.getElementById('galeri-table');
    const tableRows = Array.from(table.querySelectorAll('tbody tr'));
    const sortFilter = document.getElementById('sort-filter');
    const itemsPerPageFilter = document.getElementById('items-per-page-filter');
    const recordInfo = document.getElementById('record-info');
    const paginationControls = document.getElementById('pagination-controls');
    const exportPdfBtn = document.getElementById('export-pdf-btn');

    let currentPage = 1;

    function updateTable() {
        let rows = [...tableRows];
        const searchTerm = searchInput.value.toLowerCase();

        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(searchTerm) ? '' : 'none';
        });
        rows = rows.filter(row => row.style.display !== 'none');

        // Sorting berdasarkan tanggal
        const headers = table.querySelectorAll('thead th');
        let dateIndex = -1;
        headers.forEach((th, i) => {
            if (th.innerText.toLowerCase().includes('tanggal')) dateIndex = i;
        });
        if (dateIndex >= 0) {
            rows.sort((a, b) => {
                const dateA = new Date(a.cells[dateIndex].innerText);
                const dateB = new Date(b.cells[dateIndex].innerText);
                return sortFilter.value === 'newest' ? dateB - dateA : dateA - dateB;
            });
        }

        // Pagination
        const perPage = itemsPerPageFilter.value === 'all' ? rows.length : parseInt(itemsPerPageFilter.value, 10);
        const totalRows = rows.length;
        const totalPages = Math.ceil(totalRows / perPage) || 1;
        if (currentPage > totalPages) currentPage = 1;
        const startIndex = (currentPage - 1) * perPage;
        const endIndex = startIndex + perPage;

        rows.forEach((row, i) => {
            row.style.display = (i >= startIndex && i < endIndex) ? '' : 'none';
        });

        recordInfo.textContent = totalRows === 0 
            ? "Tidak ada data ditemukan." 
            : `Menampilkan ${startIndex + 1}-${Math.min(endIndex, totalRows)} dari ${totalRows} data.`;

        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        paginationControls.innerHTML = '';
        if (totalPages <= 1) return;

        const createPageItem = (label, page, disabled = false, active = false) => {
            const li = document.createElement('li');
            li.className = `page-item ${disabled ? 'disabled' : ''} ${active ? 'active' : ''}`;
            li.innerHTML = `<a class="page-link" href="#">${label}</a>`;
            li.addEventListener('click', e => {
                e.preventDefault();
                if (!disabled) {
                    currentPage = page;
                    updateTable();
                }
            });
            return li;
        };

        paginationControls.appendChild(createPageItem("«", currentPage - 1, currentPage === 1));
        for (let i = 1; i <= totalPages; i++) {
            paginationControls.appendChild(createPageItem(i, i, false, i === currentPage));
        }
        paginationControls.appendChild(createPageItem("»", currentPage + 1, currentPage === totalPages));
    }

    searchInput.addEventListener('keyup', () => { currentPage = 1; updateTable(); });
    sortFilter.addEventListener('change', () => { currentPage = 1; updateTable(); });
    itemsPerPageFilter.addEventListener('change', () => { currentPage = 1; updateTable(); });
    exportPdfBtn.addEventListener('click', () => window.print());

    updateTable();

    // === Edit Modal ===
    const editButtons = document.querySelectorAll(".btn-edit");
    const editModal = new bootstrap.Modal(document.getElementById("editDataModal"));
    const editForm = document.getElementById("editForm");

    editButtons.forEach(btn => {
        btn.addEventListener("click", function () {
            document.getElementById("edit-id").value = this.dataset.id;
            document.getElementById("edit-kategori").value = this.dataset.kategori;
            document.getElementById("edit-keterangan").value = this.dataset.keterangan;
            document.getElementById("edit-file").value = this.dataset.file;
            editForm.action = "<?= site_url('galeri_admin/update/') ?>" + this.dataset.id;
            editModal.show();
        });
    });
});
</script>
