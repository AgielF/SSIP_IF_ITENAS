<div class="container my-5">
    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
        <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-check-circle me-2"></i>
                    <span id="successMessage"></span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

        <div id="errorToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <span id="errorMessage"></span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs" id="project-nav">
        <li class="nav-item">
            <a class="nav-link active" href="#">Daftar Ruangan</a>
        </li>
    </ul>

    <main class="fm-content card rounded-0 rounded-bottom border-top-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4 gap-3">
                <h4 class="mb-0">Daftar Ruangan</h4>
                <div class="d-flex gap-2 flex-wrap non-printable">
                    <input type="text" id="search-input" class="form-control form-control-sm"
                        placeholder="Cari data..." style="width: auto;">
                    <div class="d-flex align-items-center">
                        <label for="sort-filter" class="me-2 mb-0 small">Urutkan:</label>
                        <select id="sort-filter" class="form-select form-select-sm">
                            <option value="asc">A-Z</option>
                            <option value="desc">Z-A</option>
                        </select>
                    </div>
                    <div class="d-flex align-items-center">
                        <label for="items-per-page-filter" class="me-2 mb-0 small">Tampilkan:</label>
                        <select id="items-per-page-filter" class="form-select form-select-sm">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="all">Semua</option>
                        </select>
                    </div>
                    <button type="button" id="export-pdf-btn" class="btn btn-sm btn-danger">
                        <i class="fas fa-file-pdf me-1"></i> PDF
                    </button>
                    <button type="button" id="export-excel-btn" class="btn btn-sm btn-success">
                        <i class="fas fa-file-excel me-1"></i> Excel
                    </button>
                    <!-- Tombol tambah data -->
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="fas fa-plus me-1"></i> Tambah Ruangan
                    </button>
                </div>
            </div>

            <p class="text-muted small mb-3" id="record-info">
                Menampilkan <?= count($ruangans) ?> data
            </p>

            <div class="table-responsive">
                <table class="table fm-table table-hover" id="ruangan-table">
                    <thead>
                        <tr>
                            <th>ID Ruangan</th>
                            <th>Nama Ruangan</th>
                            <th>Kapasitas</th>
                            <th>Status Penggunaan</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($ruangans)) : ?>
                            <?php foreach ($ruangans as $row) : ?>
                                <tr>
                                    <td><?= esc($row['id_ruangan']) ?></td>
                                    <td><strong><?= esc($row['nama_ruangan']) ?></strong></td>
                                    <td><?= esc($row['kapasitas']) ?> orang</td>
                                    <td>
                                        <?php if ($row['today_status'] === 'occupied_now') : ?>
                                            <span class="badge bg-danger mb-1"><i class="fas fa-calendar-times me-1"></i> Sedang Digunakan</span>
                                            <div class="small text-danger">
                                                <strong><?= esc($row['active_schedule']['nama_event']) ?></strong><br>
                                                (<?= esc(date('H:i', strtotime($row['active_schedule']['waktu_mulai']))) ?> - <?= esc(date('H:i', strtotime($row['active_schedule']['waktu_selesai']))) ?>)
                                            </div>
                                        <?php elseif ($row['today_status'] === 'occupied_today') : ?>
                                            <span class="badge bg-warning text-dark mb-1"><i class="fas fa-calendar-alt me-1"></i> Terpakai Hari Ini</span>
                                            <div class="small text-muted" style="font-size: 0.8rem;">
                                                <?php foreach ($row['today_schedules'] as $s) : ?>
                                                    • <?= esc(date('H:i', strtotime($s['waktu_mulai']))) ?>-<?= esc(date('H:i', strtotime($s['waktu_selesai']))) ?>: <?= esc($s['nama_event']) ?><br>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php else : ?>
                                            <span class="badge bg-success"><i class="fas fa-check me-1"></i> Kosong / Tersedia</span>
                                            <?php if ($row['schedule_count'] > 0) : ?>
                                                <div class="small text-muted mt-1" style="font-size: 0.8rem;">(Total <?= $row['schedule_count'] ?> jadwal)</div>
                                            <?php else: ?>
                                                <div class="small text-muted mt-1" style="font-size: 0.8rem;">(Belum pernah digunakan)</div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc(date('d M Y H:i', strtotime($row['created_at'] ?? 'now'))) ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary btn-edit"
                                            data-id="<?= $row['id_ruangan'] ?>"
                                            data-nama_ruangan="<?= esc($row['nama_ruangan']) ?>"
                                            data-kapasitas="<?= esc($row['kapasitas']) ?>"
                                            data-bs-toggle="modal" data-bs-target="#modalEdit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <form action="<?= base_url('/admin/ruangan/delete/' . $row['id_ruangan']) ?>" 
                                            method="POST" 
                                            class="d-inline" 
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus ruangan ini?');">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
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
            
            <nav>
                <ul class="pagination pagination-sm justify-content-end" id="pagination-controls"></ul>
            </nav>
        </div>
    </main>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form action="/admin/ruangan/create" method="post" class="modal-content">
            <?= csrf_field() ?>
            <div class="modal-header">
                <h5 class="modal-title">Tambah Ruangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Ruangan</label>
                    <input type="text" name="nama_ruangan" class="form-control" placeholder="Contoh: Lab Komputer 5" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kapasitas</label>
                    <input type="number" name="kapasitas" class="form-control" placeholder="Contoh: 30" required>
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
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog">
        <form id="editForm" method="post" class="modal-content">
            <?= csrf_field() ?>
            <div class="modal-header">
                <h5 class="modal-title">Edit Ruangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Ruangan</label>
                    <input type="text" name="nama_ruangan" id="edit-nama-ruangan" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kapasitas</label>
                    <input type="number" name="kapasitas" id="edit-kapasitas" class="form-control" required>
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
    // Toast notification handling
    <?php if (session()->getFlashdata('success')): ?>
        const successToast = new bootstrap.Toast(document.getElementById('successToast'));
        document.getElementById('successMessage').textContent = '<?= session()->getFlashdata('success') ?>';
        successToast.show();
        setTimeout(() => successToast.hide(), 3000);
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        const errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
        document.getElementById('errorMessage').textContent = '<?= session()->getFlashdata('error') ?>';
        errorToast.show();
        setTimeout(() => errorToast.hide(), 3000);
    <?php endif; ?>
    
    const searchInput = document.getElementById('search-input');
    const table = document.getElementById('ruangan-table');
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
            if (row.cells.length > 1) { // Skip empty row
                row.style.display = row.innerText.toLowerCase().includes(searchTerm) ? '' : 'none';
            }
        });
        rows = rows.filter(row => row.style.display !== 'none' && row.cells.length > 1);

        // Sorting by Name (index 1)
        rows.sort((a, b) => {
            const valA = a.cells[1].innerText;
            const valB = b.cells[1].innerText;
            return sortFilter.value === 'desc' ? valB.localeCompare(valA) : valA.localeCompare(valB);
        });

        // Re-append sorted rows to tbody
        const tbody = table.querySelector('tbody');
        rows.forEach(row => tbody.appendChild(row));

        const perPage = itemsPerPageFilter.value === 'all' ? rows.length : parseInt(itemsPerPageFilter.value, 10);
        const totalRows = rows.length;
        const totalPages = Math.ceil(totalRows / perPage) || 1;
        if (currentPage > totalPages) currentPage = 1;
        const startIndex = (currentPage - 1) * perPage;
        const endIndex = startIndex + perPage;

        tableRows.forEach(row => {
            if (row.cells.length > 1) {
                row.style.display = 'none';
            }
        });

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

        const createPageItem = (text, page, disabled = false, active = false) => {
            const li = document.createElement('li');
            li.className = `page-item ${disabled ? 'disabled' : ''} ${active ? 'active' : ''}`;
            const a = document.createElement('a');
            a.className = 'page-link';
            a.href = '#';
            a.textContent = text;
            li.appendChild(a);

            a.addEventListener('click', (e) => {
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
    exportPdfBtn.addEventListener('click', () => printTableOnly('ruangan-table', 'Daftar Ruangan'));
    document.getElementById('export-excel-btn').addEventListener('click', () => exportTableToExcel('ruangan-table', 'Daftar_Ruangan'));

    updateTable();

    // === Edit Modal ===
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const namaRuangan = this.getAttribute('data-nama_ruangan');
            const kapasitas = this.getAttribute('data-kapasitas');

            document.getElementById("edit-nama-ruangan").value = namaRuangan;
            document.getElementById("edit-kapasitas").value = kapasitas;

            document.getElementById("editForm").action = "/admin/ruangan/update/" + id;
        });
    });
});
</script>
