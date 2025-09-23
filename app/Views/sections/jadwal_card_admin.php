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
            <a class="nav-link active" href="#">Daftar Jadwal</a>
        </li>
    </ul>

    <main class="fm-content card rounded-0 rounded-bottom border-top-0">
        <div class="card-body">
            <div id="printable-area">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                    <h4 class="mb-0">Daftar Jadwal</h4>
                    
                    <div class="d-flex align-items-center gap-2 flex-wrap non-printable">
                        <input type="text" id="search-input" class="form-control form-control-sm" placeholder="Cari data..." style="width: auto;">
                        
                        <div class="d-flex align-items-center">
                            <label for="sort-filter" class="form-label me-2 mb-0 small text-nowrap">Urutkan:</label>
                            <select class="form-select form-select-sm" id="sort-filter">
                                <option value="newest">Terbaru</option>
                                <option value="oldest">Terlama</option>
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
                            <i class="fas fa-plus me-1"></i> Tambah Jadwal
                        </button>
                    </div>
                </div>

                <p class="text-muted small mb-3" id="record-info">Menampilkan data...</p>

                <div class="table-responsive">
                    <table class="table fm-table table-hover" id="jadwal-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Matakuliah</th>
                                <th>Kelas</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Dosen</th>
                                <th>Ruangan</th>
                                <th>Jenis</th>
                                <th class="non-printable">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($schedules['rows'])) : ?>
                                <?php foreach ($schedules['rows'] as $row) : ?>
                                    <tr>
                                        <td><?= esc($row[0]) ?></td>
                                        <td><?= esc($row[1]) ?></td>
                                        <td><?= esc($row[2]) ?></td>
                                        <td><?= esc($row[3]) ?></td>
                                        <td><?= esc($row[4]) ?></td>
                                        <td><?= esc($row[5]) ?></td>
                                        <td><?= esc($row[6]) ?></td>
                                        <td><?= esc($row[7]) ?></td>
                                        <td class="non-printable">
                                            <button class="btn btn-sm btn-outline-secondary me-1 btn-edit"
                                                data-id="<?= $row[0] ?>"
                                                data-id_event="<?= esc($row[8] ?? '') ?>"
                                                data-tanggal="<?= esc($row[3]) ?>"
                                                data-waktu_mulai="<?= esc($row[4]) ?>"
                                                data-waktu_selesai="<?= esc($row[4]) ?>"
                                                data-ruangan="<?= esc($row[6]) ?>">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <a href="<?= site_url('jadwal/delete/'.$row[0]) ?>"
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Hapus data ini?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="9" class="text-center text-muted">Data tidak ditemukan.</td>
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

<!-- Modal Tambah -->
<div class="modal fade" id="addDataModal" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" action="<?= site_url('jadwal/store') ?>" method="post">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Event</label>
                    <select name="id_event" class="form-control" required>
                        <option value="">-- Pilih Event --</option>
                        <?php foreach ($events as $event): ?>
                            <option value="<?= $event['id_event']; ?>"><?= $event['nama_event']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Waktu Mulai</label>
                    <input type="time" name="waktu_mulai" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Waktu Selesai</label>
                    <input type="time" name="waktu_selesai" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ruangan</label>
                    <input type="text" name="ruangan" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editDataModal" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" id="editForm" method="post">
            <div class="modal-header">
                <h5 class="modal-title">Edit Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_jadwal" id="edit-id">
                <div class="mb-3">
                    <label class="form-label">Event</label>
                    <select name="id_event" id="edit-id-event" class="form-control" required>
                        <option value="">-- Pilih Event --</option>
                        <?php foreach ($events as $event): ?>
                            <option value="<?= $event['id_event']; ?>"><?= $event['nama_event']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" id="edit-tanggal" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Waktu Mulai</label>
                    <input type="time" name="waktu_mulai" id="edit-waktu-mulai" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Waktu Selesai</label>
                    <input type="time" name="waktu_selesai" id="edit-waktu-selesai" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ruangan</label>
                    <input type="text" name="ruangan" id="edit-ruangan" class="form-control" required>
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
    const table = document.getElementById('jadwal-table');
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

        // Sorting by Jam (index 4)
        rows.sort((a, b) => {
            const valA = a.cells[4].innerText;
            const valB = b.cells[4].innerText;
            return sortFilter.value === 'newest' ? valB.localeCompare(valA) : valA.localeCompare(valB);
        });

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
            document.getElementById("edit-id-event").value = this.dataset.id_event;
            document.getElementById("edit-tanggal").value = this.dataset.tanggal;
            document.getElementById("edit-waktu-mulai").value = this.dataset.waktu_mulai;
            document.getElementById("edit-waktu-selesai").value = this.dataset.waktu_selesai;
            document.getElementById("edit-ruangan").value = this.dataset.ruangan;

            editForm.action = "<?= site_url('jadwal/update/') ?>" + this.dataset.id;
            editModal.show();
        });
    });
});
</script>
