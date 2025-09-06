<?php
$publicationData = $publicationData ?? [
    'jurnal'    => ['headers' => [], 'rows' => []],
    'prosiding' => ['headers' => [], 'rows' => []],
    'paten'     => ['headers' => [], 'rows' => []],
];
?>
<style>
    .fm-content {
        padding: 30px;
        background-color: #ffffff;
    }
    .fm-table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
    }
    .fm-table tbody tr:hover {
        background-color: #f8f9fa;
    }
    .nav-tabs .nav-link {
        color: #555;
        font-weight: 500;
    }
    .nav-tabs .nav-link.active {
        color: #0d6efd;
        border-color: #dee2e6 #dee2e6 #fff;
    }
    /* STYLE BARU UNTUK PRINT PDF */
    @media print {
        body * {
            visibility: hidden;
        }
        #printable-area, #printable-area * {
            visibility: visible;
        }
        #printable-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .btn, .nav-tabs, #search-input, #sort-filter, #items-per-page-filter, #pagination-controls, label, #record-info, .non-printable { 
            display: none !important; /* Sembunyikan semua elemen interaktif di PDF */
        }
    }
</style>

<div class="container my-5">
    <ul class="nav nav-tabs" id="publication-nav">
        <li class="nav-item">
            <a class="nav-link active" href="#" data-content="jurnal">Jurnal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" data-content="prosiding">Prosiding</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" data-content="paten">Paten</a>
        </li>
    </ul>

    <main class="fm-content card rounded-0 rounded-bottom border-top-0">
        <div class="card-body">
            <div id="printable-area">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                    <div id="content-title-wrapper">
                        <h4 class="mb-0" id="content-title">Jurnal</h4>
                    </div>
                    
                    <div class="d-flex align-items-center gap-2 flex-wrap non-printable">
                        <input type="text" id="search-input" class="form-control form-control-sm" placeholder="Cari data..." style="width: auto;">
                        
                        <div class="d-flex align-items-center">
                            <label for="sort-filter" class="form-label me-2 mb-0 small text-nowrap">Urutkan:</label>
                            <select class="form-select form-select-sm" id="sort-filter">
                                <option value="newest">Terbaru</option>
                                <option value="oldest">Terlama</option>
                            </select>
                        </div>
                        <div class="d-flex align-items-center">
                            <label for="items-per-page-filter" class="form-label me-2 mb-0 small text-nowrap">Tampilkan:</label>
                            <select class="form-select form-select-sm" id="items-per-page-filter">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="all">Semua</option>
                            </select>
                        </div>
                        <button id="export-pdf-btn" class="btn btn-sm btn-danger">
                            <i class="fas fa-file-pdf me-1"></i> PDF
                        </button>
                        <button id="add-data-btn" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#dataModal">
                            <i class="fas fa-plus me-1"></i> Tambah Data
                        </button>
                    </div>
                </div>

                <p class="text-muted small mb-3" id="record-info">Menampilkan data...</p>

                <div class="table-responsive">
                    <table class="table fm-table table-hover">
                        <thead id="table-header"></thead>
                        <tbody id="table-body"></tbody>
                    </table>
                </div>
            </div>
            
            <nav>
                <ul class="pagination pagination-sm justify-content-end" id="pagination-controls">
                    <!-- Tombol paginasi akan dirender oleh JavaScript -->
                </ul>
            </nav>
        </div>
    </main>
</div>

<!-- Modal untuk Tambah/Edit Data -->
<div class="modal fade" id="dataModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Form Data</h5>
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
document.addEventListener('DOMContentLoaded', function() {
    const publicationData = <?= json_encode($publicationData) ?>;

    const navLinks = document.querySelectorAll('#publication-nav .nav-link');
    const contentTitle = document.getElementById('content-title');
    const tableHeader = document.getElementById('table-header');
    const tableBody = document.getElementById('table-body');
    const sortFilter = document.getElementById('sort-filter');
    const itemsPerPageFilter = document.getElementById('items-per-page-filter');
    const recordInfo = document.getElementById('record-info');
    const searchInput = document.getElementById('search-input');
    const paginationControls = document.getElementById('pagination-controls');
    const exportPdfBtn = document.getElementById('export-pdf-btn');
    const dataModal = new bootstrap.Modal(document.getElementById('dataModal'));
    const modalTitle = document.getElementById('modal-title');
    const modalForm = document.getElementById('data-form');
    const saveDataBtn = document.getElementById('save-data-btn');

    let currentState = {
        category: 'jurnal',
        sortOrder: 'newest',
        itemsPerPage: 5,
        currentPage: 1,
        searchTerm: '',
        editingIndex: null // Untuk melacak mode edit
    };
    
    function parseDate(dateStr) {
        if (String(dateStr).includes('/')) {
            const parts = dateStr.split('/');
            return `${parts[2]}-${parts[1]}-${parts[0]}`;
        }
        return dateStr;
    }

    function updateView() {
        const data = publicationData[currentState.category];
        if (!data) return;

        const linkText = document.querySelector(`.nav-link[data-content="${currentState.category}"]`).textContent;
        contentTitle.textContent = linkText;

        let processedRows = data.rows.filter(row => 
            row.some(cell => String(cell).toLowerCase().includes(currentState.searchTerm))
        );

        const dateColumnIndex = (currentState.category === 'jurnal') ? 5 : (currentState.category === 'prosiding' ? 4 : 3);
        processedRows.sort((a, b) => {
            const dateA = parseDate(a[dateColumnIndex]);
            const dateB = parseDate(b[dateColumnIndex]);
            return (currentState.sortOrder === 'newest') 
                ? String(dateB).localeCompare(String(dateA))
                : String(dateA).localeCompare(String(dateB));
        });
        
        const totalRows = processedRows.length;
        const limit = currentState.itemsPerPage === 'all' ? totalRows : parseInt(currentState.itemsPerPage, 10);
        const startIndex = (currentState.currentPage - 1) * limit;
        const endIndex = startIndex + limit;
        const paginatedRows = processedRows.slice(startIndex, endIndex);

        let headerHtml = '<tr><th>No.</th>';
        data.headers.forEach(header => headerHtml += `<th>${header}</th>`);
        headerHtml += '<th class="non-printable">Aksi</th></tr>';
        tableHeader.innerHTML = headerHtml;
        
        let bodyHtml = '';
        if (paginatedRows.length === 0) {
            bodyHtml = `<tr><td colspan="${data.headers.length + 2}" class="text-center text-muted">Data tidak ditemukan.</td></tr>`;
        } else {
            paginatedRows.forEach((row, index) => {
                const originalIndex = data.rows.indexOf(row); // Dapatkan indeks asli untuk edit/hapus
                bodyHtml += `<tr><td>${startIndex + index + 1}</td>`;
                row.forEach(cell => bodyHtml += `<td>${cell}</td>`);
                bodyHtml += `
                    <td class="non-printable">
                        <button class="btn btn-sm btn-outline-secondary me-1 edit-btn" title="Edit" data-index="${originalIndex}"><i class="fas fa-pencil-alt"></i></button>
                        <button class="btn btn-sm btn-outline-danger delete-btn" title="Hapus" data-index="${originalIndex}"><i class="fas fa-trash-alt"></i></button>
                    </td>
                `;
                bodyHtml += '</tr>';
            });
        }
        tableBody.innerHTML = bodyHtml;

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

    // --- Event Listeners ---
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            navLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            currentState.category = this.getAttribute('data-content');
            currentState.currentPage = 1;
            updateView();
        });
    });

    sortFilter.addEventListener('change', () => { currentState.sortOrder = sortFilter.value; updateView(); });
    itemsPerPageFilter.addEventListener('change', () => { currentState.itemsPerPage = itemsPerPageFilter.value; currentState.currentPage = 1; updateView(); });
    searchInput.addEventListener('keyup', () => { currentState.searchTerm = searchInput.value.toLowerCase(); currentState.currentPage = 1; updateView(); });
    exportPdfBtn.addEventListener('click', () => window.print());
    
    document.getElementById('add-data-btn').addEventListener('click', () => {
        currentState.editingIndex = null;
        modalTitle.textContent = `Tambah Data ${document.querySelector(`.nav-link[data-content="${currentState.category}"]`).textContent}`;
        const headers = projectData[currentState.category].headers;
        let formHtml = '';
        headers.forEach(header => {
            formHtml += `<div class="mb-3"><label class="form-label">${header}</label><input type="text" class="form-control" required></div>`;
        });
        modalForm.innerHTML = formHtml;
    });

    saveDataBtn.addEventListener('click', () => {
        const formInputs = modalForm.querySelectorAll('input');
        const newRow = [];
        let isValid = true;
        formInputs.forEach(input => {
            if (!input.value) isValid = false;
            newRow.push(input.value);
        });

        if (isValid) {
            if (currentState.editingIndex !== null) {
                // Mode Edit
                publicationData[currentState.category].rows[currentState.editingIndex] = newRow;
            } else {
                // Mode Tambah
                publicationData[currentState.category].rows.push(newRow);
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
            const rowData = publicationData[currentState.category].rows[index];
            const headers = publicationData[currentState.category].headers;
            modalTitle.textContent = `Edit Data ${document.querySelector(`.nav-link[data-content="${currentState.category}"]`).textContent}`;
            
            let formHtml = '';
            headers.forEach((header, i) => {
                formHtml += `<div class="mb-3"><label class="form-label">${header}</label><input type="text" class="form-control" value="${rowData[i]}" required></div>`;
            });
            modalForm.innerHTML = formHtml;
            dataModal.show();
        }

        if (target.classList.contains('delete-btn')) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                publicationData[currentState.category].rows.splice(index, 1);
                updateView();
            }
        }
    });

    updateView();
});
</script>