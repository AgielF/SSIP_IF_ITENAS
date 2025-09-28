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
                            <th>Tanggal praktikum</th>
                            <th>Praktikum </th>
                            <th>Status</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pesertaPraktikum)) : ?>
                            <?php foreach ($pesertaPraktikum as $i => $row) : ?>
                                <tr>
                                    <td><?= esc($i + 1) ?></td>
                                    <td><?= esc($row['peserta']) ?></td>
                                    <td><?= esc($row['jadwal_tanggal']) ?></td>
                                    <td><?=esc($row['nama_event'])?></td>
                                    <td><?= esc($row['status']) ?></td>
                                    <td><?= esc($row['nilai']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">Data tidak ditemukan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
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
</script>
