<style>
    .schedule-container {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    #jadwalTable thead th {
        background-color: #f8f9fa;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        border-bottom: 2px solid #e9ecef;
    }
    #jadwalTable tbody tr {
        border-bottom: 1px solid #e9ecef;
    }
    #jadwalTable tbody tr:last-child {
        border-bottom: none;
    }
    #jadwalTable .btn-group .btn {
        border-radius: 6px;
    }
    /* Style untuk Print/Export PDF */
    @media print {
        body * { visibility: hidden; }
        .printable-area, .printable-area * { visibility: visible; }
        .printable-area { position: absolute; left: 0; top: 0; width: 100%; }
        .btn, #controls-wrapper, .pagination, .record-info {
            display: none !important;
        }
        th:last-child, td:last-child {
             display: none !important; /* Sembunyikan kolom Aksi saat print */
        }
    }
</style>

<div class="container my-5">
    <div class="schedule-container printable-area">
        <div id="controls-wrapper">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                <h4 class="mb-0">Jadwal Kuliah</h4>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <input type="text" id="search-input" class="form-control form-control-sm" placeholder="Cari data..." style="width: auto;">
                    <div class="d-flex align-items-center">
                        <label for="sort-filter" class="form-label me-2 mb-0 small text-nowrap">Urutkan:</label>
                        <select class="form-select form-select-sm" id="sort-filter">
                            <option value="newest">Terbaru</option>
                            <option value="oldest">Terlama</option>
                        </select>
                    </div>
                    <button id="export-pdf-btn" class="btn btn-sm btn-danger">
                        <i class="fas fa-file-pdf me-1"></i> Export PDF
                    </button>
                </div>
            </div>
        </div>

        <p class="text-muted small mb-3 record-info">Menampilkan data...</p>
        
        <div class="table-responsive">
            <table id="jadwalTable" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Matakuliah</th>
                        <th>Kelas</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Dosen</th>
                        <th>Ruang</th>
                        <th>Jenis</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($schedules)): ?>
                        <?php foreach ($schedules as $schedule): ?>
                             <?php
                                // Mengonversi string tanggal tampilan menjadi format yang andal untuk disortir (YYYYMMDD)
                                $timestamp = strtotime($schedule['date']);
                                $sortableDate = $timestamp ? date('Ymd', $timestamp) : '0';
                            ?>
                            <tr data-order="<?= $sortableDate ?>">
                                <td></td> <!-- Nomor diisi oleh JS -->
                                <td><?= esc($schedule['title']) ?></td>
                                <td>AA</td>
                                <td><?= esc(strtoupper(explode(',', $schedule['date'])[0])) ?></td>
                                <td><?= esc($schedule['time']) ?></td>
                                <td><?= esc($schedule['instructor']) ?></td>
                                <td><?= esc($schedule['lab']) ?></td>
                                <td>KULIAH</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-light btn-sm" title="Lihat Detail"><i class="fas fa-search"></i></button>
                                        <button type="button" class="btn btn-light btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown"></button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                            <li><a class="dropdown-item" href="#">Hapus</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div id="controls-wrapper" class="d-flex justify-content-between align-items-center mt-4">
            <div>
                <label for="items-per-page-filter" class="form-label me-2 mb-0 small">Tampilkan:</label>
                <select class="form-select form-select-sm d-inline-block" id="items-per-page-filter" style="width: auto;">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="all">Semua</option>
                </select>
            </div>
            <nav>
                <ul class="pagination pagination-sm mb-0" id="pagination-controls">
                    <!-- Tombol paginasi akan dirender oleh JavaScript -->
                </ul>
            </nav>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.querySelector('#jadwalTable tbody');
    const allRows = Array.from(tableBody.querySelectorAll('tr'));
    const searchInput = document.getElementById('search-input');
    const sortFilter = document.getElementById('sort-filter');
    const itemsPerPageFilter = document.getElementById('items-per-page-filter');
    const paginationControls = document.getElementById('pagination-controls');
    const recordInfo = document.querySelector('.record-info');
    const exportPdfBtn = document.getElementById('export-pdf-btn');

    let currentState = {
        sortOrder: 'newest',
        itemsPerPage: 5,
        currentPage: 1,
        searchTerm: ''
    };

    function updateView() {
        // 1. Filter
        let processedRows = allRows.filter(row => 
            row.textContent.toLowerCase().includes(currentState.searchTerm)
        );

        // 2. Sortir
        processedRows.sort((a, b) => {
            const dateA = a.dataset.order;
            const dateB = b.dataset.order;
            return (currentState.sortOrder === 'newest') 
                ? dateB.localeCompare(dateA) 
                : dateA.localeCompare(dateB);
        });
        
        const totalRows = processedRows.length;

        // 3. Paginasi
        const limit = currentState.itemsPerPage === 'all' ? totalRows : parseInt(currentState.itemsPerPage, 10);
        const startIndex = (currentState.currentPage - 1) * limit;
        const endIndex = startIndex + limit;
        const paginatedRows = processedRows.slice(startIndex, endIndex);

        // Render Body & Penomoran
        tableBody.innerHTML = ''; // Kosongkan tabel
        if (paginatedRows.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="9" class="text-center text-muted">Data tidak ditemukan.</td></tr>`;
        } else {
            paginatedRows.forEach((row, index) => {
                row.cells[0].textContent = startIndex + index + 1; // Isi nomor
                tableBody.appendChild(row);
            });
        }

        // Update Info
        const startRecord = totalRows > 0 ? startIndex + 1 : 0;
        const endRecord = Math.min(endIndex, totalRows);
        recordInfo.textContent = `Menampilkan ${startRecord}-${endRecord} dari ${totalRows} data.`;

        // Render Paginasi
        renderPagination(totalRows, limit);
    }

    function renderPagination(totalItems, limit) {
        const totalPages = Math.ceil(totalItems / limit);
        paginationControls.innerHTML = '';
        if (totalPages <= 1) return;

        const createPageLink = (page, text, isDisabled = false, isActive = false) => {
            const li = document.createElement('li');
            li.className = `page-item ${isDisabled ? 'disabled' : ''} ${isActive ? 'active' : ''}`;
            li.innerHTML = `<a class="page-link" href="#">${text}</a>`;
            li.addEventListener('click', (e) => {
                e.preventDefault();
                if (!isDisabled) {
                    currentState.currentPage = page;
                    updateView();
                }
            });
            return li;
        };

        paginationControls.appendChild(createPageLink(currentState.currentPage - 1, 'Previous', currentState.currentPage === 1));
        for (let i = 1; i <= totalPages; i++) {
            paginationControls.appendChild(createPageLink(i, i, false, currentState.currentPage === i));
        }
        paginationControls.appendChild(createPageLink(currentState.currentPage + 1, 'Next', currentState.currentPage === totalPages));
    }

    // Event Listeners
    searchInput.addEventListener('keyup', () => {
        currentState.searchTerm = searchInput.value.toLowerCase();
        currentState.currentPage = 1;
        updateView();
    });

    sortFilter.addEventListener('change', () => {
        currentState.sortOrder = sortFilter.value;
        updateView();
    });

    itemsPerPageFilter.addEventListener('change', () => {
        currentState.itemsPerPage = itemsPerPageFilter.value;
        currentState.currentPage = 1;
        updateView();
    });

    exportPdfBtn.addEventListener('click', () => window.print());

    // Initial render
    updateView();
});
</script>
