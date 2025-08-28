<?php
// Data dummy untuk setiap kategori. Seharusnya ini diambil dari database.
$data = [
    'riset' => [
        'headers' => ['Nama Proyek', 'Ketua Peneliti', 'Status', 'Tahun'],
        'rows' => [
            ['Pengembangan AI untuk Analisis Citra Medis', 'Dr. Smith', 'Selesai', '2023'],
            ['Sistem IoT untuk Smart Agriculture', 'Prof. Johnson', 'Berjalan', '2024'],
            ['Analisis Big Data untuk Prediksi Pasar Saham', 'Dr. Williams', 'Selesai', '2022'],
        ]
    ],
    'kolaborasi' => [
        'headers' => ['Nama Mitra', 'Jenis Kolaborasi', 'Proyek Terkait', 'Durasi'],
        'rows' => [
            ['PT. Teknologi Maju', 'Riset Bersama', 'Sistem IoT', '2023-2025'],
            ['Universitas Sebelah', 'Pertukaran Peneliti', 'AI Medis', '2024'],
            ['GovTech Indonesia', 'Pengembangan Produk', 'Aplikasi Layanan Publik', '2023-2024'],
        ]
    ],
    'pendanaan' => [
        'headers' => ['Sumber Dana', 'Nama Hibah', 'Jumlah', 'Periode'],
        'rows' => [
            ['DIKTI', 'Hibah Penelitian Dasar', 'Rp 150.000.000', '2023'],
            ['LPDP', 'Riset Inovatif Produktif (RISPRO)', 'Rp 300.000.000', '2024-2026'],
            ['Industri XYZ', 'Dana Riset Terapan', 'Rp 75.000.000', '2023'],
        ]
    ]
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
        .btn, .nav-tabs, #search-input, #sort-filter, #items-per-page-filter, #pagination-controls, label, #record-info { 
            display: none !important; /* Sembunyikan semua elemen interaktif di PDF */
        }
    }
</style>

<div class="container my-5">
    <!-- Navigasi Tab di Atas -->
    <ul class="nav nav-tabs" id="project-nav">
        <li class="nav-item">
            <a class="nav-link active" href="#" data-content="riset">Daftar Proyek Riset</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" data-content="kolaborasi">Kolaborasi Mitra</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" data-content="pendanaan">Pendanaan Riset</a>
        </li>
    </ul>

    <!-- Konten Utama (Tabel Dinamis) -->
    <main class="fm-content card rounded-0 rounded-bottom border-top-0">
        <div class="card-body">
            <div id="printable-area">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                    <div id="content-title-wrapper">
                        <h4 class="mb-0" id="content-title">Daftar Proyek Riset</h4>
                    </div>
                    
                    <div class="d-flex align-items-center gap-2 flex-wrap">
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
                            <i class="fas fa-file-pdf me-1"></i> Export PDF
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const projectData = <?= json_encode($data) ?>;

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

        const linkText = document.querySelector(`.nav-link[data-content="${currentState.category}"]`).textContent;
        contentTitle.textContent = linkText;

        // 1. Filter
        let processedRows = data.rows.filter(row => 
            row.some(cell => String(cell).toLowerCase().includes(currentState.searchTerm))
        );

        // 2. Sortir
        const dateColumnIndex = data.headers.length - 1; // Asumsi kolom terakhir adalah Tahun/Durasi/Periode
        processedRows.sort((a, b) => {
            const yearA = String(a[dateColumnIndex]).match(/\d{4}/g)?.pop() || 0;
            const yearB = String(b[dateColumnIndex]).match(/\d{4}/g)?.pop() || 0;
            return (currentState.sortOrder === 'newest') ? yearB - yearA : yearA - yearB;
        });
        
        const totalRows = processedRows.length;

        // 3. Paginasi
        const limit = currentState.itemsPerPage === 'all' ? totalRows : parseInt(currentState.itemsPerPage, 10);
        const startIndex = (currentState.currentPage - 1) * limit;
        const endIndex = startIndex + limit;
        const paginatedRows = processedRows.slice(startIndex, endIndex);

        // Render Header
        let headerHtml = '<tr><th>No.</th>';
        data.headers.forEach(header => headerHtml += `<th>${header}</th>`);
        tableHeader.innerHTML = headerHtml + '</tr>';
        
        // Render Body
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

    sortFilter.addEventListener('change', function() {
        currentState.sortOrder = this.value;
        updateView();
    });

    itemsPerPageFilter.addEventListener('change', function() {
        currentState.itemsPerPage = this.value;
        currentState.currentPage = 1;
        updateView();
    });

    searchInput.addEventListener('keyup', function() {
        currentState.searchTerm = this.value.toLowerCase();
        currentState.currentPage = 1;
        updateView();
    });

    exportPdfBtn.addEventListener('click', function() {
        window.print();
    });

    updateView();
});
</script>
