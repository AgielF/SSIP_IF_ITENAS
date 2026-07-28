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
                        <select id="sort-filter" class="form-select form-select-sm"
        onchange="window.location='?sort='+this.value">
    <option value="desc" <?= $sort == 'desc' ? 'selected' : '' ?>>Terbaru</option>
    <option value="asc"  <?= $sort == 'asc' ? 'selected' : '' ?>>Terlama</option>
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
                                <th>ID rekrut</th>
                                <th>Admin penyunting</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Syarat</th>
                                <th>Jadwal</th>
                                <th class="non-printable">Aksi</th>
                            </tr>
                        </thead> 
                        
                        

                        <tbody id="rekrutmen-table-body">
    <?php if (!empty($rekrutmen['rows'])) : ?>
        <?php foreach ($rekrutmen['rows'] as $row) : ?>
            <tr data-id="<?= esc($row['id_rekrut'] ?? '') ?>" data-created="<?= !empty($row['created_at']) ? strtotime($row['created_at']) : 0 ?>">
                <td><?= esc($row['id_rekrut'] ?? '') ?></td>
                <td><?= esc($row['pembuat'] ?? '-') ?></td>
                <td><?= esc($row['deskripsi'] ?? '') ?></td>
                <td><?= esc($row['status'] ?? '') ?></td>
                <td><?= esc($row['syarat'] ?? '') ?></td>
                <td><?= esc($row['jadwal'] ?? '-') ?> (<?= esc($row['event'] ?? '-') ?>)</td>
                <td class="non-printable">

                    <!-- form edit -->
                    <button
                        class="btn btn-sm btn-outline-secondary btn-edit"
                        data-id="<?= esc($row['id_rekrut'] ?? '') ?>"
                        data-deskripsi="<?= esc($row['deskripsi'] ?? '') ?>"
                        data-status="<?= esc($row['status'] ?? '') ?>"
                        data-syarat="<?= esc($row['syarat'] ?? '') ?>"
                        data-link_gform="<?= esc($row['link_gform'] ?? '') ?>"
                        data-jadwal="<?= esc($row['id_jadwal'] ?? '') ?>"
                        data-bs-toggle="modal"
                        data-bs-target="#editDataModal">
                        <i class="fas fa-pencil-alt"></i>
                    </button>

                    <!-- Tombol Hapus -->
                    <form action="<?= site_url('rekrutmen/delete/' . ($row['id_rekrut'] ?? '')) ?>" 
                        method="post" 
                        class="d-inline delete-form"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data rekrutmen ini?');">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-sm btn-outline-danger btn-delete" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td colspan="7" class="text-center text-muted">Data tidak ditemukan.</td>
        </tr>
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
            <?= csrf_field() ?>
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
                    <label class="form-label">Link Google Form</label>
                    <input type="url" name="link_gform" class="form-control" placeholder="https://forms.google.com/...">
                </div>
                <div class="mb-3">
                    <label class="form-label">Jadwal</label>
                    <select name="id_jadwal" class="form-select" required>
                        <?php if (!empty($jadwal)): ?>
                            <?php foreach ($jadwal as $j): ?>
                                <option value="<?= $j['id_jadwal'] ?>">
                                    <?= $j['tanggal'] ?> - <?= $j['waktu_mulai'] ?> (<?= esc($j['nama_event']) ?>)
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
            <?= csrf_field() ?>
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
                    <label class="form-label">Link Google Form</label>
                    <input type="url" name="link_gform" id="edit-link_gform" class="form-control" placeholder="https://forms.google.com/...">
                </div>
                <div class="mb-3">
                    <label class="form-label">Jadwal</label>
                    <select name="id_jadwal" id="edit-jadwal" class="form-select" required>
                        <?php if (!empty($jadwal)): ?>
                            <?php foreach ($jadwal as $j): ?>
                                <option value="<?= $j['id_jadwal'] ?>">
                                    <?= $j['tanggal'] ?> - <?= $j['waktu_mulai'] ?> (<?= esc($j['nama_event']) ?>)
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
document.addEventListener("DOMContentLoaded", function () {
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
    const searchInput = document.getElementById("search-input");
    const sortFilter = document.getElementById("sort-filter");
    const itemsPerPageFilter = document.getElementById("items-per-page-filter");
    const tableBody = document.getElementById("rekrutmen-table-body");
    const recordInfo = document.getElementById("record-info");
    const paginationControls = document.getElementById("pagination-controls");

    let currentPage = 1;

    function getRows() {
        return Array.from(tableBody.querySelectorAll("tr[data-id]"));
    }

    function renderPagination(totalRows, perPage) {
        let totalPages = Math.ceil(totalRows / perPage);
        paginationControls.innerHTML = "";

        if (totalPages > 1) {
            for (let i = 1; i <= totalPages; i++) {
                let btn = document.createElement("button");
                btn.className = "btn btn-sm " + (i === currentPage ? "btn-primary" : "btn-outline-primary");
                btn.textContent = i;
                btn.onclick = () => {
                    currentPage = i;
                    renderTable();
                };
                paginationControls.appendChild(btn);
            }
        }
    }

    function renderTable() {
        let rows = getRows();
        let term = searchInput.value.toLowerCase();

        // 🔎 Filter data
        let filtered = rows.filter(row => {
            let cells = row.querySelectorAll("td");
            let teks = Array.from(cells).slice(1, 5).map(td => td.innerText.toLowerCase()).join(" ");
            return teks.includes(term);
        });

        // ↕️ Sort berdasarkan created_at (lebih akurat daripada ID)
        // ↕️ Sort berdasarkan created_at
filtered.sort((a, b) => {
    let tA = Number(a.dataset.created) || 0;
    let tB = Number(b.dataset.created) || 0;
    return sortFilter.value === "asc" ? tA - tB : tB - tA;
});


        // 📄 Pagination
        let perPage = itemsPerPageFilter.value === "all" ? filtered.length : parseInt(itemsPerPageFilter.value);
        let totalRows = filtered.length;
        let totalPages = Math.max(1, Math.ceil(totalRows / perPage));

        if (currentPage > totalPages) currentPage = 1;

        let start = (currentPage - 1) * perPage;
        let end = Math.min(start + perPage, totalRows);

        rows.forEach(row => row.style.display = "none");
        filtered.forEach((row, idx) => {
            row.style.display = (idx >= start && idx < end) ? "" : "none";
        });

        // ℹ️ Info jumlah data
        recordInfo.textContent = totalRows > 0
            ? `Menampilkan ${start + 1}–${end} dari ${totalRows} data`
            : "Tidak ada data ditemukan";

        renderPagination(totalRows, perPage);
    }

    // Event listener
    searchInput.addEventListener("keyup", () => { currentPage = 1; renderTable(); });
    sortFilter.addEventListener("change", () => { currentPage = 1; renderTable(); });
    itemsPerPageFilter.addEventListener("change", () => { currentPage = 1; renderTable(); });

    // Modal Edit
    document.querySelectorAll(".btn-edit").forEach(btn => {
        btn.addEventListener("click", function () {
            document.getElementById("edit-form").action = "<?= site_url('rekrutmen/update/') ?>" + this.dataset.id;
            document.getElementById("edit-deskripsi").value = this.dataset.deskripsi;
            document.getElementById("edit-status").value = this.dataset.status;
            document.getElementById("edit-syarat").value = this.dataset.syarat;
            document.getElementById("edit-link_gform").value = this.dataset.link_gform;
            document.getElementById("edit-jadwal").value = this.dataset.jadwal;
        });
    });

    renderTable();
});
document.getElementById('export-pdf-btn').addEventListener('click', function() {
    window.print();
});
</script>
