<!-- DataTables CSS -->
<link rel="stylesheet" href="<?= base_url('assets/datatables/css/dataTables.bootstrap5.min.css') ?>"/>

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
        .btn, #controls-wrapper, .pagination, .record-info, .non-printable {
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
                        <i class="fas fa-file-pdf me-1"></i> PDF
                    </button>
                    <button id="add-data-btn" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#dataModal">
                        <i class="fas fa-plus me-1"></i> Tambah Jadwal
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
                        <th class="non-printable">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data akan dirender oleh JavaScript -->
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

<!-- Modal untuk Tambah/Edit Data -->
<div class="modal fade" id="dataModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Form Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="data-form">
                    <!-- Input form akan dirender oleh JavaScript di sini -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="save-data-btn">Simpan</button>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    // Menggunakan data dari PHP
    let schedulesData = <?= json_encode($schedules ?? []) ?>;

    const tableBody = document.querySelector('#jadwalTable tbody');
    const searchInput = document.getElementById('search-input');
    const sortFilter = document.getElementById('sort-filter');
    const itemsPerPageFilter = document.getElementById('items-per-page-filter');
    const paginationControls = document.getElementById('pagination-controls');
    const recordInfo = document.querySelector('.record-info');
    const exportPdfBtn = document.getElementById('export-pdf-btn');
    const dataModal = new bootstrap.Modal(document.getElementById('dataModal'));
    const modalTitle = document.getElementById('modal-title');
    const modalForm = document.getElementById('data-form');
    const saveDataBtn = document.getElementById('save-data-btn');

    let currentState = {
        sortOrder: 'newest',
        itemsPerPage: 5,
        currentPage: 1,
        searchTerm: '',
        editingIndex: null
    };

    function updateView() {
        let processedRows = schedulesData.map((schedule, index) => {
            const scheduleDate = new Date(schedule.date.replace(/(\d+)(st|nd|rd|th)/, '$1'));
            return { ...schedule, originalIndex: index, sortableDate: scheduleDate };
        });

        // 1. Filter
        if (currentState.searchTerm) {
            processedRows = processedRows.filter(row => 
                Object.values(row).some(val => String(val).toLowerCase().includes(currentState.searchTerm))
            );
        }

        // 2. Sortir
        processedRows.sort((a, b) => {
            return (currentState.sortOrder === 'newest') 
                ? b.sortableDate - a.sortableDate 
                : a.sortableDate - b.sortableDate;
        });
        
        const totalRows = processedRows.length;

        // 3. Paginasi
        const limit = currentState.itemsPerPage === 'all' ? totalRows : parseInt(currentState.itemsPerPage, 10);
        const startIndex = (currentState.currentPage - 1) * limit;
        const endIndex = startIndex + limit;
        const paginatedRows = processedRows.slice(startIndex, endIndex);

        // Render Body & Penomoran
        tableBody.innerHTML = '';
        if (paginatedRows.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="9" class="text-center text-muted">Data tidak ditemukan.</td></tr>`;
        } else {
            paginatedRows.forEach((row, index) => {
                const day = row.sortableDate.toLocaleDateString('en-US', { weekday: 'long' }).toUpperCase();
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>${startIndex + index + 1}</td>
                    <td>${row.title}</td>
                    <td>AA</td>
                    <td>${day}</td>
                    <td>${row.time}</td>
                    <td>${row.instructor}</td>
                    <td>${row.lab}</td>
                    <td>KULIAH</td>
                    <td class="non-printable">
                        <button class="btn btn-sm btn-outline-secondary me-1 edit-btn" data-index="${row.originalIndex}"><i class="fas fa-pencil-alt"></i></button>
                        <button class="btn btn-sm btn-outline-danger delete-btn" data-index="${row.originalIndex}"><i class="fas fa-trash-alt"></i></button>
                    </td>
                `;
                tableBody.appendChild(newRow);
            });
        }

        const startRecord = totalRows > 0 ? startIndex + 1 : 0;
        const endRecord = Math.min(endIndex, totalRows);
        recordInfo.textContent = `Menampilkan ${startRecord}-${endRecord} dari ${totalRows} data.`;

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
    searchInput.addEventListener('keyup', () => { currentState.searchTerm = searchInput.value.toLowerCase(); currentState.currentPage = 1; updateView(); });
    sortFilter.addEventListener('change', () => { currentState.sortOrder = sortFilter.value; updateView(); });
    itemsPerPageFilter.addEventListener('change', () => { currentState.itemsPerPage = itemsPerPageFilter.value; currentState.currentPage = 1; updateView(); });
    exportPdfBtn.addEventListener('click', () => window.print());

    document.getElementById('add-data-btn').addEventListener('click', () => {
        currentState.editingIndex = null;
        modalTitle.textContent = `Tambah Jadwal Baru`;
        modalForm.innerHTML = `
            <div class="mb-3"><label class="form-label">Matakuliah</label><input type="text" class="form-control" name="title" required></div>
            <div class="mb-3"><label class="form-label">Tanggal</label><input type="date" class="form-control" name="date" required></div>
            <div class="mb-3"><label class="form-label">Waktu</label><input type="text" class="form-control" name="time" placeholder="HH:MM - HH:MM" required></div>
            <div class="mb-3"><label class="form-label">Dosen</label><input type="text" class="form-control" name="instructor" required></div>
            <div class="mb-3"><label class="form-label">Ruang</label><input type="text" class="form-control" name="lab" required></div>
        `;
    });

    saveDataBtn.addEventListener('click', () => {
        const form = document.getElementById('data-form');
        const inputs = form.querySelectorAll('input');
        const newEntry = {};
        let isValid = true;
        inputs.forEach(input => {
            if (!input.value) isValid = false;
            newEntry[input.name] = input.value;
        });

        if (isValid) {
            if (currentState.editingIndex !== null) {
                schedulesData[currentState.editingIndex] = { ...schedulesData[currentState.editingIndex], ...newEntry };
            } else {
                schedulesData.push(newEntry);
            }
            updateView();
            dataModal.hide();
        } else {
            alert('Semua field harus diisi!');
        }
    });
    
    tableBody.addEventListener('click', function(e) {
        const target = e.target.closest('button');
        if (!target) return;

        const index = parseInt(target.dataset.index);

        if (target.classList.contains('edit-btn')) {
            currentState.editingIndex = index;
            const rowData = schedulesData[index];
            modalTitle.textContent = `Edit Jadwal`;
            modalForm.innerHTML = `
                <div class="mb-3"><label class="form-label">Matakuliah</label><input type="text" class="form-control" name="title" value="${rowData.title}" required></div>
                <div class="mb-3"><label class="form-label">Tanggal</label><input type="date" class="form-control" name="date" value="${new Date(rowData.date).toISOString().split('T')[0]}" required></div>
                <div class="mb-3"><label class="form-label">Waktu</label><input type="text" class="form-control" name="time" value="${rowData.time}" placeholder="HH:MM - HH:MM" required></div>
                <div class="mb-3"><label class="form-label">Dosen</label><input type="text" class="form-control" name="instructor" value="${rowData.instructor}" required></div>
                <div class="mb-3"><label class="form-label">Ruang</label><input type="text" class="form-control" name="lab" value="${rowData.lab}" required></div>
            `;
            dataModal.show();
        }

        if (target.classList.contains('delete-btn')) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                schedulesData.splice(index, 1);
                updateView();
            }
        }
    });

    updateView();
});
</script>
