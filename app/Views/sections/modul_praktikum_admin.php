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
            <a class="nav-link active" href="#">Daftar Modul Praktikum</a>
        </li>
    </ul>

    <main class="fm-content card rounded-0 rounded-bottom border-top-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4 gap-3">
                <h4>Daftar Modul Praktikum</h4>
                <div class="d-flex gap-2 flex-wrap non-printable">
                    <input type="text" id="search-input" class="form-control form-control-sm"
                        placeholder="Cari data..." style="width: auto;">
                    <div class="d-flex align-items-center">
                        <label for="sort-filter" class="me-2 mb-0 small">Urutkan:</label>
                        <select id="sort-filter" class="form-select form-select-sm">
                            <option value="newest">Terbaru</option>
                            <option value="oldest">Terlama</option>
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
                    <button id="export-pdf-btn" class="btn btn-sm btn-danger">
                        <i class="fas fa-file-pdf me-1"></i> PDF
                    </button>
                    <!-- Tombol tambah data -->
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="fas fa-plus me-1"></i> Tambah
                    </button>
                </div>
            </div>

            <p class="text-muted small mb-3">
                Menampilkan <?= count($modulPraktikum) ?> data
            </p>

            <div class="table-responsive">
                <table class="table fm-table table-hover" id="rekrutmen-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>File URL</th>
                            <th>Jadwal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($modulPraktikum)) : ?>
                            <?php foreach ($modulPraktikum as $i => $row) : ?>
                                <tr>
                                    <td><?= esc($i + 1) ?></td>
                                    <td><?= esc($row['judul']) ?></td>
                                    <td><?= esc($row['deskripsi']) ?></td>
                                    <td>
                                        <?php if (!empty($row['file_url'])): ?>
                                            <a href="<?= base_url('modul-praktikum/preview/'.$row['file_url']) ?>" target="_blank" class="badge bg-info text-dark">👁️ Preview</a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($row['jadwal_tanggal']) ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning btn-edit"
                                            data-id="<?= $row['id_modul'] ?>"
                                            data-judul="<?= esc($row['judul']) ?>"
                                            data-deskripsi="<?= esc($row['deskripsi']) ?>"
                                            data-file="<?= esc($row['file_url']) ?>"
                                            data-jadwal="<?= esc($row['id_jadwal']) ?>"
                                            data-bs-toggle="modal" data-bs-target="#modalEdit">
                                            Edit
                                        </button>
                                        <a href="/modul-praktikum/delete/<?= $row['id_modul'] ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Hapus modul ini?')">Hapus</a>
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
    </main>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="/modul-praktikum/create" method="post" enctype="multipart/form-data" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Modul Praktikum</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label">Judul</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>
                <div class="mb-3"><label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">File PDF</label>
                    <input type="file" name="file_modul" class="form-control" accept=".pdf" placeholder="Pilih file PDF">
                    <small class="text-muted d-block mt-1">Format: PDF | Ukuran maksimal: 10MB</small>
                </div>
                <div class="mb-3">
                    <label class="form-label"> ID Jadwal</label>
                    <select name="id_jadwal" class="form-select" required>
                        <option value="">-- Pilih Jadwal --</option>
                        <?php foreach ($jadwalList as $jadwal): ?>
                            <option value="<?= $jadwal['id_jadwal'] ?>">
                                <?= isset($jadwal['waktu_mulai']) ? '(' . $jadwal['waktu_mulai'] . ' - ' . $jadwal['waktu_selesai'] . ')' : '' ?>
                            </option>
                        <?php endforeach; ?>
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

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="formEdit" method="post" enctype="multipart/form-data" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Modul Praktikum</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_modul" id="edit-id">
                <div class="mb-3"><label class="form-label">Judul</label>
                    <input type="text" name="judul" id="edit-judul" class="form-control" required>
                </div>
                <div class="mb-3"><label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="edit-deskripsi" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">File PDF</label>
                    <input type="file" name="file_modul" id="edit-file" class="form-control" accept=".pdf">
                    <small class="text-muted d-block mt-1">Format: PDF | Ukuran maksimal: 10MB | Kosongkan jika tidak ingin mengubah file</small>
                    <div id="current-file-info" class="mt-2"></div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Jadwal</label>
                    <select name="id_jadwal" id="edit-jadwal" class="form-select" required>
                        <option value="">-- Pilih Jadwal --</option>
                        <?php foreach ($jadwalList as $jadwal): ?>
                            <option value="<?= $jadwal['id_jadwal'] ?>">
                                <?= isset($jadwal['waktu_mulai']) ? '(' . $jadwal['waktu_mulai'] . ' - ' . $jadwal['waktu_selesai'] . ')' : '' ?>
                            </option>
                        <?php endforeach; ?>
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
document.addEventListener('DOMContentLoaded', function () {
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
});

    // Search
    const searchInput = document.getElementById('search-input');
    const tableRows = document.querySelectorAll('#rekrutmen-table tbody tr');
    searchInput.addEventListener('keyup', function () {
        const searchText = this.value.toLowerCase();
        tableRows.forEach(row => {
            const rowText = row.innerText.toLowerCase();
            row.style.display = rowText.includes(searchText) ? '' : 'none';
        });
    });

    // Sort
    document.getElementById('sort-filter').addEventListener('change', function () {
        const tbody = document.querySelector('#rekrutmen-table tbody');
        const rows = Array.from(tbody.querySelectorAll('tr')).filter(r => r.style.display !== 'none');
        rows.sort((a, b) => {
            const aVal = parseInt(a.cells[0].innerText);
            const bVal = parseInt(b.cells[0].innerText);
            return this.value === 'newest' ? bVal - aVal : aVal - bVal;
        });
        rows.forEach(r => tbody.appendChild(r));
    });

    // Items per page
    document.getElementById('items-per-page-filter').addEventListener('change', function () {
        const perPage = this.value === 'all' ? tableRows.length : parseInt(this.value);
        tableRows.forEach((row, i) => {
            row.style.display = i < perPage ? '' : 'none';
        });
    });
    document.getElementById('items-per-page-filter').dispatchEvent(new Event('change'));

    // Export PDF
    document.getElementById('export-pdf-btn').addEventListener('click', () => window.print());

    // Isi data ke modal edit
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function () {
            const currentFile = this.dataset.file;
            document.getElementById('formEdit').action = "/modul-praktikum/update/" + this.dataset.id;
            document.getElementById('edit-id').value = this.dataset.id;
            document.getElementById('edit-judul').value = this.dataset.judul;
            document.getElementById('edit-deskripsi').value = this.dataset.deskripsi;
            document.getElementById('edit-jadwal').value = this.dataset.jadwal;
            
            // Tampilkan informasi file saat ini
            const fileInfo = document.getElementById('current-file-info');
            if (currentFile) {
                fileInfo.innerHTML = `<small class="text-success"><i class="fas fa-file-pdf me-1"></i>File saat ini: <a href="<?= base_url('modul-praktikum/preview/') ?>${currentFile}" target="_blank">${currentFile}</a></small>`;
            } else {
                fileInfo.innerHTML = '<small class="text-muted">Belum ada file</small>';
            }
        });
    });
</script>
