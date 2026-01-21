<?php
// Pastikan variabel ada agar tidak error
$publicationData = $publicationData ?? [];
$pager = $pager ?? null;
$search = $search ?? '';
$kategori = $kategori ?? '';
$sort = $sort ?? 'newest';
$limit = $limit ?? 10;

// Bagi data berdasarkan jenis publikasi
$groupedData = [
    'jurnal'    => [],
    'prosiding' => [],
    'paten'     => [],
];
foreach ($publicationData as $row) {
    $jenis = strtolower($row['jenis_publikasi']);
    if (isset($groupedData[$jenis])) {
        $groupedData[$jenis][] = $row;
    }
}
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
/* Print PDF */
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
    .btn, .nav-tabs, #search-input, #sort-filter, #items-per-page-filter,
    #pagination-controls, label, .action-buttons {
        display: none !important;
    }
}
</style>

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

    <!-- Tabs -->
    <ul class="nav nav-tabs" id="publication-nav">
        <li class="nav-item">
            <a class="nav-link <?= $kategori === 'jurnal' || $kategori==='' ? 'active' : '' ?>" href="?kategori=jurnal">Jurnal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $kategori === 'prosiding' ? 'active' : '' ?>" href="?kategori=prosiding">Prosiding</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $kategori === 'paten' ? 'active' : '' ?>" href="?kategori=paten">Paten</a>
        </li>
    </ul>

    <!-- Content -->
    <main class="fm-content card rounded-0 rounded-bottom border-top-0">
        <div class="card-body">
            <div id="printable-area">

                <!-- Toolbar -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                    <h4 class="mb-0">
                        <?= ucfirst($kategori ?: 'Jurnal') ?>
                    </h4>
                    
                    <form method="get" class="d-flex align-items-center gap-2 flex-wrap">
                        <input type="hidden" name="kategori" value="<?= esc($kategori) ?>">
                        <input type="text" name="search" value="<?= esc($search) ?>" 
                               class="form-control form-control-sm" placeholder="Cari data..." style="width: auto;">

                        <div class="d-flex align-items-center">
                            <label for="sort-filter" class="form-label me-2 mb-0 small text-nowrap">Urutkan:</label>
                            <select name="sort" class="form-select form-select-sm" id="sort-filter" onchange="this.form.submit()">
                                <option value="newest" <?= $sort==='newest'?'selected':'' ?>>Terbaru</option>
                                <option value="oldest" <?= $sort==='oldest'?'selected':'' ?>>Terlama</option>
                            </select>
                        </div>
                        <div class="d-flex align-items-center">
                            <label for="items-per-page-filter" class="form-label me-2 mb-0 small text-nowrap">Tampilkan:</label>
                            <select name="limit" class="form-select form-select-sm" id="items-per-page-filter" onchange="this.form.submit()">
                                <option value="5" <?= $limit==5?'selected':'' ?>>5</option>
                                <option value="10" <?= $limit==10?'selected':'' ?>>10</option>
                                <option value="25" <?= $limit==25?'selected':'' ?>>25</option>
                                <option value="50" <?= $limit==50?'selected':'' ?>>50</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-sm btn-secondary">
                            <i class="fas fa-search"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="fas fa-plus me-1"></i> Tambah
                        </button>
                        <button type="button" id="export-pdf-btn" class="btn btn-sm btn-danger">
                            <i class="fas fa-file-pdf me-1"></i> Export PDF
                        </button>
                    </form>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table fm-table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Judul</th>
                                <!-- <th>Jenis</th> -->
                                <th>Kategori</th>
                                <th>Topik</th>
                                <th>Kategori</th>
                                <th>Tanggal </th>
                                <th>Penulis Utama</th>
                                <th>Penulis Pendamping</th>
                                <th>Volume</th>
                                <th>Tahun</th>
                                <th>Nomor</th>
                                <th>Deskripsi</th>
                                <th>Link Publikasi</th>
                                <th class="action-buttons">Aksi</th>
                            </tr>
                        </thead>

                        
                        <tbody>
                            <?php if (empty($groupedData[$kategori ?: 'jurnal'])): ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Tidak ada data</td>
                                </tr>
                            <?php else: ?>
                                <?php $i=1 + ($limit * (max(1, (int)($_GET['page'] ?? 1)) -1)); ?>
                                <?php foreach ($groupedData[$kategori ?: 'jurnal'] as $row): ?>
                                    <tr>
                                        <td><?=esc($row['id_publikasi'])?></td>
                                        <td><?=esc($row['judul'])?></td>
                                        <!-- <td><?= esc($row['jenis_publikasi']) ?></td> -->
                                        <td><?=esc($row['kategori'])?></td>
                                        <td><?=esc($row['topik'])?></td>
                                        <td><?= esc($row['kategori']) ?></td>
                                        <td><?= esc($row['tanggal_publikasi']) ?></td>
                                         <td><?= esc($row['penulis_utama'] ?? '-') ?></td> <!-- ✅ hasil join -->
                                        <td><?= esc($row['penulis_pendamping']) ?></td>
                                        <td><?= esc($row['volume']) ?></td>
                                        <td><?= esc($row['tahun']) ?></td>
                                        <td><?= esc($row['nomor']) ?></td>
                                        <td><?= esc($row['deskripsi']) ?></td>
                                        <td>
                                            <?php if (!empty($row['link_publikasi'])): ?>
                                                <a href="<?= esc($row['link_publikasi']) ?>" target="_blank" class="btn btn-sm btn-info">Publikasi</a>
                                            <?php endif; ?>
                                            <?php if (!empty($row['link_doi'])): ?>
                                                <a href="<?= esc($row['link_doi']) ?>" target="_blank" class="btn btn-sm btn-success">DOI</a>
                                            <?php endif; ?>
                                            <?php if (!empty($row['link_gdrive'])): ?>
                                                <a href="<?= esc($row['link_gdrive']) ?>" target="_blank" class="btn btn-sm btn-secondary">GDrive</a>
                                            <?php endif; ?>
                                        </td>
                                        <td class="action-buttons">
                                            <button class="btn btn-sm btn-outline-secondary btn-edit" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id_publikasi'] ?>"> <i class="fas fa-pencil-alt"></i></button>
                                            <form action="<?= site_url('publikasi-ilmiah/delete/'.$row['id_publikasi']) ?>" 
                                                method="get" 
                                                class="d-inline delete-form"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger btn-delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal<?= $row['id_publikasi'] ?>" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <form method="post" action="<?= site_url('publikasi-ilmiah/update/'.$row['id_publikasi']) ?>">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Publikasi</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label>Jenis Publikasi</label>
                                                            <select name="jenis_publikasi" class="form-control">
                                                                <option value="jurnal" <?= $row['jenis_publikasi']=='jurnal'?'selected':'' ?>>Jurnal</option>
                                                                <option value="prosiding" <?= $row['jenis_publikasi']=='prosiding'?'selected':'' ?>>Prosiding</option>
                                                                <option value="paten" <?= $row['jenis_publikasi']=='paten'?'selected':'' ?>>Paten</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Judul / Link Publikasi</label>
                                                            <input type="text" name="link_publikasi" class="form-control" value="<?= esc($row['link_publikasi']) ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Kategori</label>
                                                            <input type="text" name="kategori" class="form-control" value="<?= esc($row['kategori']) ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Tanggal Publikasi</label>
                                                            <input type="date" name="tanggal_publikasi" class="form-control" value="<?= esc($row['tanggal_publikasi']) ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Penulis Pendamping</label>
                                                            <input type="text" name="penulis_pendamping" class="form-control" value="<?= esc($row['penulis_pendamping']) ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Volume</label>
                                                            <input type="text" name="volume" class="form-control" value="<?= esc($row['volume']) ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Nomor</label>
                                                            <input type="text" name="nomor" class="form-control" value="<?= esc($row['nomor']) ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Tahun</label>
                                                            <input type="text" name="tahun" class="form-control" value="<?= esc($row['tahun']) ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Link DOI</label>
                                                            <input type="text" name="link_doi" class="form-control" value="<?= esc($row['link_doi']) ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Link GDrive</label>
                                                            <input type="text" name="link_gdrive" class="form-control" value="<?= esc($row['link_gdrive']) ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Conference</label>
                                                            <input type="text" name="conference" class="form-control" value="<?= esc($row['conference']) ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Deskripsi</label>
                                                            <textarea name="deskripsi" class="form-control"><?= esc($row['deskripsi']) ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
    <label class="form-label">Topik</label>
    <select name="topik" class="form-select" required>
        <option value="">-- Pilih Topik --</option>
        <option value="machine learning">Machine Learning</option>
        <option value="system expert">System Expert</option>
        <option value="smart system">Smart System</option>
        <option value="artificial-intelligence">Artificial Intelligence</option>
        <option value="data mining">Data Mining</option>
        <option value="deep learning">Deep Learning</option>
    </select>
</div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
                
            </div>

            <!-- Pagination -->
            <?php if ($pager): ?>
                <div class="d-flex justify-content-end">
                    <?= $pager->links() ?>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" action="<?= site_url('publikasi-ilmiah/store') ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Publikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Jenis Publikasi</label>
                        <select name="jenis_publikasi" class="form-control">
                            <option value="jurnal">Jurnal</option>
                            <option value="prosiding">Prosiding</option>
                            <option value="paten">Paten</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Judul / Link Publikasi</label>
                        <input type="text" name="link_publikasi" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Kategori</label>
                        <input type="text" name="kategori" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Tanggal Publikasi</label>
                        <input type="date" name="tanggal_publikasi" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Penulis Pendamping</label>
                        <input type="text" name="penulis_pendamping" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Volume</label>
                        <input type="text" name="volume" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Nomor</label>
                        <input type="text" name="nomor" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Tahun</label>
                        <input type="text" name="tahun" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Link DOI</label>
                        <input type="text" name="link_doi" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Link GDrive</label>
                        <input type="text" name="link_gdrive" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Conference</label>
                        <input type="text" name="conference" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control"></textarea>
                    </div>
                </div>
                <div class="mb-3">
    <label class="form-label">Topik</label>
    <select name="topik" class="form-select" required>
        <option value="">-- Pilih Topik --</option>
        <option value="machine learning">Machine Learning</option>
        <option value="system expert">System Expert</option>
        <option value="smart system">Smart System</option>
        <option value="artificial-intelligence">Artificial Intelligence</option>
        <option value="data mining">Data Mining</option>
        <option value="deep learning">Deep Learning</option>
    </select>
</div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const publicationData = <?= json_encode($publicationData ?? []) ?>;
    const csrfTokenName = '<?= csrf_token() ?>';
    const csrfTokenValue = '<?= csrf_hash() ?>';

    // Debug: Check if data is loaded
    console.log('Publication Data:', publicationData);
    console.log('CSRF Token:', csrfTokenName, csrfTokenValue);

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
                const actualIndex = data.rows.indexOf(row); // Get actual index in original data
                const recordId = row[row.length - 1]; // Get ID from last column
                bodyHtml += `<tr><td>${startIndex + index + 1}</td>`;
                // Display all columns except the ID
                for (let i = 0; i < row.length - 1; i++) {
                    bodyHtml += `<td>${row[i]}</td>`;
                }
                bodyHtml += `
                    <td class="non-printable">
                        <button class="btn btn-sm btn-outline-secondary me-1 edit-btn" title="Edit" data-id="${recordId}"><i class="fas fa-pencil-alt"></i></button>
                        <button class="btn btn-sm btn-outline-danger delete-btn" title="Hapus" data-id="${recordId}"><i class="fas fa-trash-alt"></i></button>
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
        const headers = publicationData[currentState.category].headers;
        let formHtml = `<input type="hidden" name="${csrfTokenName}" value="${csrfTokenValue}">`;
        formHtml += `<input type="hidden" name="jenis_publikasi" value="${currentState.category}">`;
        formHtml += `<input type="hidden" name="id_user" value="1">`;
        headers.forEach((header, i) => {
            const fieldName = header.toLowerCase().replace(/\s+/g, '_');
            formHtml += `<div class="mb-3"><label class="form-label">${header}</label><input type="text" class="form-control" name="${fieldName}" value="${rowData ? rowData[i] : ''}" required></div>`;
        });
        modalForm.innerHTML = formHtml;
    });

    saveDataBtn.addEventListener('click', async () => {
        const form = modalForm;
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        // Basic validation
        let isValid = true;
        for (const key in data) {
            if (key !== csrfTokenName && key !== 'id_user' && !data[key]) {
                isValid = false;
                break;
            }
        }

        if (!isValid) {
            alert('Semua field harus diisi!');
            return;
        }

        try {
            let url = '/admin/publikasi-ilmiah/create';
            let method = 'POST';

            if (currentState.editingIndex !== null) {
                url = `/admin/publikasi-ilmiah/update/${data.id_publikasi}`;
                method = 'POST';
                // Add _method field to simulate PUT request
                data['_method'] = 'PUT';
            }

            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams(data)
            });

            const result = await response.json();
            if (result.success) {
                location.reload();
            } else {
                alert(result.message);
            }
        } catch (error) {
            alert('Network error: ' + error.message);
        }
    });
    
    tableBody.addEventListener('click', function(e) {
        const target = e.target.closest('button');
        if (!target) return;

        const recordId = target.dataset.id;

        if (target.classList.contains('edit-btn')) {
            // Find the row data by ID
            const rows = publicationData[currentState.category].rows;
            const rowData = rows.find(row => row[row.length - 1] == recordId);
            const headers = publicationData[currentState.category].headers;

            if (rowData) {
                modalTitle.textContent = `Edit Data ${document.querySelector(`.nav-link[data-content="${currentState.category}"]`).textContent}`;

                let formHtml = `<input type="hidden" name="${csrfTokenName}" value="${csrfTokenValue}">`;
                formHtml += `<input type="hidden" name="jenis_publikasi" value="${currentState.category}">`;
                formHtml += `<input type="hidden" name="id_publikasi" value="${recordId}">`;
                formHtml += `<input type="hidden" name="id_user" value="1">`;
                headers.forEach((header, i) => {
                    const fieldName = header.toLowerCase().replace(/\s+/g, '_');
                    formHtml += `<div class="mb-3"><label class="form-label">${header}</label><input type="text" class="form-control" name="${fieldName}" value="${rowData[i]}" required></div>`;
                });
                modalForm.innerHTML = formHtml;
                dataModal.show();
            }
        }

        if (target.classList.contains('delete-btn')) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                fetch(`/admin/publikasi-ilmiah/delete/${recordId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new URLSearchParams({
                        [csrfTokenName]: csrfTokenValue
                    })
                }).then(async response => {
                    const result = await response.json();
                    if (result.success) {
                        location.reload();
                    } else {
                        alert(result.message);
                    }
                }).catch(error => {
                    alert('Network error: ' + error.message);
                });
            }
        }
    });

    updateView();
});

document.getElementById('export-pdf-btn').addEventListener('click', function() {
    window.print();
});
</script>
