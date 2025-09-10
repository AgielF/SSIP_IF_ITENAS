<div class="container my-5">
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
                </div>
            </div>

            <p class="text-muted small mb-3">
                Menampilkan <?= count($data) ?> data
            </p>

            <div class="table-responsive">
                <table class="table fm-table table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data)) : ?>
                            <?php foreach ($data as $i => $row) : ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= esc($row['judul'] ?? '') ?></td>
                                    <td><?= esc($row['kategori'] ?? '') ?></td>
                                    <td><?= esc($row['tanggal'] ?? '') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">Data tidak ditemukan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<script>
    // Tambahkan fitur search, sort, export PDF jika mau (optional JS)
    document.getElementById('export-pdf-btn')
        .addEventListener('click', () => window.print());
</script>
