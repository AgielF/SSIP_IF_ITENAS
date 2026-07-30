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
            <a class="nav-link active" href="#">Daftar Berita</a>
        </li>
    </ul>

    <main class="fm-content card rounded-0 rounded-bottom border-top-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4 gap-3">
                <h4>Daftar Berita</h4>
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
                Menampilkan <?= count($schedules) ?> data
            </p>

            <div class="table-responsive">
                <table class="table fm-table table-hover" id="rekrutmen-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Judul</th>
                            <th>Konten</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Pembuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($schedules)) : ?>
                            <?php foreach ($schedules as $i => $row) : ?>
                                <tr>
                                    <td><?= esc($i + 1) ?></td>
                                    <td><?= esc($row['judul']) ?></td>
                                    <td><?= esc($row['konten']) ?></td>
                                    <td><?= esc($row['kategori']) ?></td>
                                    <td><?= esc($row['tanggal']) ?></td>
                                    <td><?= esc($row['creator']) ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary btn-edit"
                                            data-id="<?= $row['id_berita'] ?>"
                                            data-judul="<?= esc($row['judul']) ?>"
                                            data-konten="<?= esc($row['konten']) ?>"
                                            data-kategori="<?= esc($row['kategori']) ?>"
                                            data-tanggal="<?= esc($row['tanggal']) ?>"
                                            data-bs-toggle="modal" data-bs-target="#modalEdit">
                                             <i class="fas fa-pencil-alt"></i>
                                        </button>
                                          <form action="<?= site_url('berita/delete/'.$row['id_berita']) ?>" 
                                                method="post" 
                                                class="d-inline delete-form"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger btn-delete">
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
        </div>
    </main>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="/berita/store" method="post" class="modal-content">
            <?= csrf_field() ?>
            <div class="modal-header">
                <h5 class="modal-title">Tambah Berita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label">Judul</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>
                <div class="mb-3"><label class="form-label">Konten</label>
                    <textarea name="konten" class="form-control" required></textarea>
                </div>
                <div class="mb-3"><label class="form-label">Kategori</label>
                    <input type="text" name="kategori" class="form-control" required>
                </div>
                <div class="mb-3"><label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" required>
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
        <form id="formEdit" method="post" class="modal-content">
            <?= csrf_field() ?>
            <div class="modal-header">
                <h5 class="modal-title">Edit Berita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_berita" id="edit-id">
                <div class="mb-3"><label class="form-label">Judul</label>
                    <input type="text" name="judul" id="edit-judul" class="form-control" required>
                </div>
                <div class="mb-3"><label class="form-label">Konten</label>
                    <textarea name="konten" id="edit-konten" class="form-control" required></textarea>
                </div>
                <div class="mb-3"><label class="form-label">Kategori</label>
                    <input type="text" name="kategori" id="edit-kategori" class="form-control" required>
                </div>
                <div class="mb-3"><label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" id="edit-tanggal" class="form-control" required>
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
            const aVal = new Date(a.cells[4].innerText);
            const bVal = new Date(b.cells[4].innerText);
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
            document.getElementById('formEdit').action = "/berita/update/" + this.dataset.id;
            document.getElementById('edit-id').value = this.dataset.id;
            document.getElementById('edit-judul').value = this.dataset.judul;
            document.getElementById('edit-konten').value = this.dataset.konten;
            document.getElementById('edit-kategori').value = this.dataset.kategori;
            document.getElementById('edit-tanggal').value = this.dataset.tanggal;
        });
    });
</script>
