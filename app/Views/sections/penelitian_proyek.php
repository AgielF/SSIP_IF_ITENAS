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
    @media print {
        body * { visibility: hidden; }
        #printable-area, #printable-area * { visibility: visible; }
        #printable-area {
            position: absolute; left: 0; top: 0; width: 100%;
        }
        .btn, .nav-tabs, #search-input, #sort-filter, #items-per-page-filter, 
        #pagination-controls, label, #record-info, .non-printable { 
            display: none !important;
        }
    }
</style>

<div class="container my-5">
    <!-- Navigasi Tab -->
    <ul class="nav nav-tabs" id="project-nav">
        <li class="nav-item">
            <a class="nav-link active" href="#" data-content="riset">Daftar Proyek Riset</a>
        </li>
    </ul>

    <main class="fm-content card rounded-0 rounded-bottom border-top-0">
        <div class="card-body">
            <div id="printable-area">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                    <h4 class="mb-0" id="content-title">Daftar Proyek Riset</h4>
                    
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
                <ul class="pagination pagination-sm justify-content-end" id="pagination-controls"></ul>
            </nav>
        </div>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const projectData = <?= json_encode($data ?? ['riset' => ['headers' => [], 'rows' => []]]) ?>;

    const navLinks = document.querySelectorAll('#project-nav .nav-link');
    const contentTitle = document.getElementById('content-title');
    const tableHeader = document.getElementById('table-header');
    const tableBody = document.getElementById('table-body');
    const sortFilter = document.getElementById('sort-filter');
    const itemsPerPageFilter = document.getElementById('items-per-page-filter');
    const recordInfo = document.getElementById('record-info');
    const searchInput = document.getElementById('search-input');
    const paginationControls = document.getElementById('pagination-controls');
    const exportPdfBtn = document.getElementById('export-pdf-btn');

    let currentState = {
        category: 'riset',
        sortOrder: 'newest',
        itemsPerPage: 5,
        currentPage: 1,
        searchTerm: ''
    };

    function updateView() {
        const data = projectData[currentState.category];
        if (!data) return;

        contentTitle.textContent = document.querySelector(`.nav-link[data-content="${currentState.category}"]`).textContent;

        let processedRows = data.rows.filter(row => 
            row.some(cell => String(cell).toLowerCase().includes(currentState.searchTerm))
        );

        // Cari kolom tanggal (misal kolom terakhir)
        const dateColumnIndex = data.headers.indexOf("Tanggal Upload") !== -1 
            ? data.headers.indexOf("Tanggal Upload") 
            : data.headers.length - 1;

        processedRows.sort((a, b) => {
            const dateA = new Date(a[dateColumnIndex]);
            const dateB = new Date(b[dateColumnIndex]);
            return (currentState.sortOrder === 'newest') ? dateB - dateA : dateA - dateB;
        });

        const totalRows = processedRows.length;
        const limit = currentState.itemsPerPage === 'all' ? totalRows : parseInt(currentState.itemsPerPage, 10);
        const startIndex = (currentState.currentPage - 1) * limit;
        const endIndex = startIndex + limit;
        const paginatedRows = processedRows.slice(startIndex, endIndex);

        let headerHtml = '<tr><th>No.</th>';
        data.headers.forEach(header => headerHtml += `<th>${header}</th>`);
        headerHtml += '</tr>';
        tableHeader.innerHTML = headerHtml;

        let bodyHtml = '';
        if (paginatedRows.length === 0) {
            bodyHtml = `<tr><td colspan="${data.headers.length + 1}" class="text-center text-muted">Data tidak ditemukan.</td></tr>`;
        } else {
            paginatedRows.forEach((row, index) => {
                bodyHtml += `<tr><td>${startIndex + index + 1}</td>`;
                row.forEach(cell => bodyHtml += `<td>${cell}</td>`);
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

    // Event Listeners
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

    updateView();
});
</script>
