<div class="container my-5">
    <ul class="nav nav-tabs" id="project-nav">
        <li class="nav-item">
            <a class="nav-link active" href="#">Daftar Peserta Praktikum</a>
        </li>
    </ul>

    <main class="fm-content card rounded-0 rounded-bottom border-top-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4 gap-3">
                <h4>Daftar Peserta Praktikum</h4>
                <div class="d-flex gap-2 flex-wrap non-printable">
                    <input type="text" id="search-input" class="form-control form-control-sm"
                        placeholder="Cari peserta..." style="width: auto;">
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
                Menampilkan <?= count($pesertaPraktikum) ?> data
            </p>

            <div class="table-responsive">
                <table class="table fm-table table-hover" id="rekrutmen-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Peserta</th>
                            <th>Jadwal</th>
                            <th>Status</th>
                            <th>Nilai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pesertaPraktikum)) : ?>
                            <?php foreach ($pesertaPraktikum as $i => $row) : ?>
                                <tr>
                                    <td><?= esc($i + 1) ?></td>
                                    <td><?= esc($row['peserta']) ?></td>
                                    <td><?= esc($row['jadwal_tanggal']) ?></td>
                                    <td><?= esc($row['status']) ?></td>
                                    <td><?= esc($row['nilai']) ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning btn-edit"
                                            data-id="<?= $row['id_peserta_praktikum'] ?>"
                                            data-user="<?= $row['id_user'] ?>"
                                            data-jadwal="<?= $row['id_jadwal'] ?>"
                                            data-status="<?= $row['status'] ?>"
                                            data-nilai="<?= $row['nilai'] ?>"
                                            data-bs-toggle="modal" data-bs-target="#modalEdit">
                                            Edit
                                        </button>
                                        <a href="/peserta-praktikum/delete/<?= $row['id_peserta_praktikum'] ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Hapus peserta ini?')">Hapus</a>
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
        <form action="/peserta-praktikum/store" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Peserta Praktikum</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label">Peserta</label>
                    <select name="id_user" class="form-control" required>
                        <option value="">-- Pilih Peserta --</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= $user['id'] ?>"><?= esc($user['nama']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3"><label class="form-label">Jadwal</label>
                    <select name="id_jadwal" class="form-control" required>
                        <option value="">-- Pilih Jadwal --</option>
                        <?php foreach ($jadwal as $j): ?>
                            <option value="<?= $j['id_jadwal'] ?>"><?= esc($j['tanggal']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3"><label class="form-label">Status</label>
                    <input type="text" name="status" class="form-control" required>
                </div>
                <div class="mb-3"><label class="form-label">Nilai</label>
                    <input type="text" name="nilai" class="form-control">
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
                <h5 class="modal-title">Edit Peserta Praktikum</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_peserta_praktikum" id="edit-id">
                <div class="mb-3"><label class="form-label">Peserta</label>
                    <select name="id_user" id="edit-user" class="form-control" required>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= $user['id'] ?>"><?= esc($user['nama']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3"><label class="form-label">Jadwal</label>
                    <select name="id_jadwal" id="edit-jadwal" class="form-control" required>
                        <?php foreach ($jadwal as $j): ?>
                            <option value="<?= $j['id_jadwal'] ?>"><?= esc($j['tanggal']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3"><label class="form-label">Status</label>
                    <input type="text" name="status" id="edit-status" class="form-control" required>
                </div>
                <div class="mb-3"><label class="form-label">Nilai</label>
                    <input type="text" name="nilai" id="edit-nilai" class="form-control">
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
            document.getElementById('formEdit').action = "/peserta-praktikum/update/" + this.dataset.id;
            document.getElementById('edit-id').value = this.dataset.id;
            document.getElementById('edit-user').value = this.dataset.user;
            document.getElementById('edit-jadwal').value = this.dataset.jadwal;
            document.getElementById('edit-status').value = this.dataset.status;
            document.getElementById('edit-nilai').value = this.dataset.nilai;
        });
    });
</script>
