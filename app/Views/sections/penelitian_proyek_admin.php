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
            <a class="nav-link active" href="#">Daftar Proyek Riset</a>
        </li>
    </ul>

    <main class="fm-content card rounded-0 rounded-bottom border-top-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4 gap-3">
                <h4>Daftar Proyek Riset</h4>
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
                Menampilkan <?= count($proyek) ?> data
            </p>

            <div class="table-responsive">
                <table class="table fm-table table-hover" id="rekrutmen-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Judul</th>
                            <th>Admin</th>
                            <th>Deskripsi</th>
                            <th>Mitra</th>
                            <th>Sumber Dana</th>
                            <th>Tahun Mulai</th>
                            <th>Tahun selesai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($proyek)) : ?>
                            <?php foreach ($proyek as $i => $row) : ?>
                                <tr>
                                    <td><?= esc($i + 1) ?></td>
                                    <td><?= esc($row['judul']) ?></td>
                                    <td><?=esc($row['pembuat'])?></td>
                                    <td><?= esc($row['deskripsi']) ?></td>
                                    <td><?= esc($row['mitra']) ?></td>
                                    <td><?= esc($row['sumber_dana']) ?></td>
                                    <td><?= esc($row['tahun_mulai']) ?></td>
                                    <td><?= esc($row['tahun_selesai']) ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary btn-edit"
                                            data-id="<?= $row['id_proyek'] ?>"
                                            data-judul="<?= esc($row['judul']) ?>"
                                            data-deskripsi="<?= esc($row['deskripsi']) ?>"
                                            data-mitra="<?= esc($row['mitra']) ?>"
                                            data-sumber="<?= esc($row['sumber_dana']) ?>"
                                            data-mulai="<?= esc($row['tahun_mulai']) ?>"
                                            data-selesai="<?= esc($row['tahun_selesai']) ?>"
                                            data-bs-toggle="modal" data-bs-target="#modalEdit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <a href="/proyek-riset/delete/<?= $row['id_proyek'] ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Hapus data ini?')"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted">Data tidak ditemukan.</td>
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
        <form action="/proyek-riset/store" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Proyek Riset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label">Judul</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>
                <div class="mb-3"><label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" required></textarea>
                </div>
                <div class="mb-3"><label class="form-label">Mitra</label>
                    <input type="text" name="mitra" class="form-control">
                </div>
                <div class="mb-3"><label class="form-label">Sumber Dana</label>
                    <input type="text" name="sumber_dana" class="form-control">
                </div>
                <div class="row">
                    <div class="col"><label class="form-label">Tahun Mulai</label>
                        <input type="number" name="tahun_mulai" class="form-control">
                    </div>
                    <div class="col"><label class="form-label">Tahun Selesai</label>
                        <input type="number" name="tahun_selesai" class="form-control">
                    </div>
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
            <div class="modal-header">
                <h5 class="modal-title">Edit Proyek Riset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_proyek" id="edit-id">
                <div class="mb-3"><label class="form-label">Judul</label>
                    <input type="text" name="judul" id="edit-judul" class="form-control" required>
                </div>
                <div class="mb-3"><label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="edit-deskripsi" class="form-control" required></textarea>
                </div>
                <div class="mb-3"><label class="form-label">Mitra</label>
                    <input type="text" name="mitra" id="edit-mitra" class="form-control">
                </div>
                <div class="mb-3"><label class="form-label">Sumber Dana</label>
                    <input type="text" name="sumber_dana" id="edit-sumber" class="form-control">
                </div>
                <div class="row">
                    <div class="col"><label class="form-label">Tahun Mulai</label>
                        <input type="number" name="tahun_mulai" id="edit-mulai" class="form-control">
                    </div>
                    <div class="col"><label class="form-label">Tahun Selesai</label>
                        <input type="number" name="tahun_selesai" id="edit-selesai" class="form-control">
                    </div>
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
            document.getElementById('formEdit').action = "/proyek-riset/update/" + this.dataset.id;
            document.getElementById('edit-id').value = this.dataset.id;
            document.getElementById('edit-judul').value = this.dataset.judul;
            document.getElementById('edit-deskripsi').value = this.dataset.deskripsi;
            document.getElementById('edit-mitra').value = this.dataset.mitra;
            document.getElementById('edit-sumber').value = this.dataset.sumber;
            document.getElementById('edit-mulai').value = this.dataset.mulai;
            document.getElementById('edit-selesai').value = this.dataset.selesai;
        });
    });
</script>
