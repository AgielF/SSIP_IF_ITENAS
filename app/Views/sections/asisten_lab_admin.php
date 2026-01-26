<style>
    .admin-container {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    #adminTable thead th {
        background-color: #f8f9fa;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        border-bottom: 2px solid #e9ecef;
    }
    #adminTable .btn-group .btn {
        border-radius: 6px;
    }
    @media print {
        body * { visibility: hidden; }
        .printable-area, .printable-area * { visibility: visible; }
        .printable-area { position: absolute; left: 0; top: 0; width: 100%; }
        .btn, #controls-wrapper, .pagination, .record-info, .non-printable {
            display: none !important;
        }
        th:last-child, td:last-child {
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

    <div class="admin-container printable-area">
        <div id="controls-wrapper">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                <h4 class="mb-0">Kelola Anggota Laboratorium</h4>
                <div class="d-flex align-items-center gap-2 flex-wrap non-printable">
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
                    <button id="add-data-btn" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#dataModal">
                        <i class="fas fa-plus me-1"></i> Tambah Anggota
                    </button>
                </div>
            </div>
        </div>

        <p class="text-muted small mb-3 record-info">Menampilkan data...</p>
        
        <div class="table-responsive">
            <table id="adminTable" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>NRP/NIDN</th>
                        <th>Nama</th>
                        <th>Jurusan</th>
                        <th>No. Telp</th>
                        <th>Role</th>
                        <th class="non-printable">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($asisten)): ?>
                        <?php foreach ($asisten as $i => $person): ?>
                            <tr data-timestamp="<?= strtotime($person['created_at'] ?? time()) ?>" data-user-id="<?= esc($person['id']) ?>" data-role-id="<?= esc($person['role_id'] ?? '') ?>">
                                <td></td> <!-- Nomor diisi oleh JS -->
                                <td><?= esc($person['nomor'] ?? '') ?></td>
                                <td><?= esc($person['nama']) ?></td>
                                <td><?= esc($person['jurusan'] ?? '') ?></td>
                                <td>-</td> <!-- No phone field in current data -->
                                <td>
                                    <?php 
                                    // Tampilkan role_name dari database, atau fallback ke role field
                                    $roleDisplay = '';
                                    if (isset($person['role_name'])) {
                                        $roleDisplay = $person['role_name'] === 'admin' ? 'Kepala Laboratorium' : ucfirst($person['role_name']);
                                    } elseif (isset($person['role'])) {
                                        $roleDisplay = ucfirst($person['role']);
                                    } else {
                                        $roleDisplay = 'User';
                                    }
                                    ?>
                                    <span class="badge bg-secondary"><?= esc($roleDisplay) ?></span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-light btn-sm edit-btn" title="Edit" data-index="<?= $i ?>" data-user-id="<?= esc($person['id']) ?>">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <button class="btn btn-light btn-sm text-danger delete-btn" title="Hapus" data-index="<?= $i ?>" data-user-id="<?= esc($person['id']) ?>">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
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
                <ul class="pagination pagination-sm mb-0" id="pagination-controls"></ul>
            </nav>
        </div>
    </div>
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
    const tableBody = document.querySelector('#adminTable tbody');
    const allRows = Array.from(tableBody.querySelectorAll('tr'));
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

    const csrfTokenName = '<?= csrf_token() ?>';
    const csrfTokenValue = '<?= csrf_hash() ?>';

    let currentState = {
        sortOrder: 'newest',
        itemsPerPage: 5,
        currentPage: 1,
        searchTerm: '',
        editingIndex: null // For tracking edit mode
    };

    function updateView() {
        // 1. Filter
        let processedRows = allRows.filter(row =>
            row.textContent.toLowerCase().includes(currentState.searchTerm)
        );

        // 2. Sort
        processedRows.sort((a, b) => {
            const timeA = parseInt(a.dataset.timestamp, 10);
            const timeB = parseInt(b.dataset.timestamp, 10);
            return (currentState.sortOrder === 'newest') ? timeB - timeA : timeA - timeB;
        });

        const totalRows = processedRows.length;

        // 3. Pagination
        const limit = currentState.itemsPerPage === 'all' ? totalRows : parseInt(currentState.itemsPerPage, 10);
        const startIndex = (currentState.currentPage - 1) * limit;
        const endIndex = startIndex + limit;
        const paginatedRows = processedRows.slice(startIndex, endIndex);

        // Render Body & Numbering
        tableBody.innerHTML = ''; // Clear table
        if (paginatedRows.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="7" class="text-center text-muted">Data tidak ditemukan.</td></tr>`;
        } else {
            paginatedRows.forEach((row, index) => {
                row.cells[0].textContent = startIndex + index + 1; // Fill number
                tableBody.appendChild(row);
            });
        }

        const startRecord = totalRows > 0 ? startIndex + 1 : 0;
        const endRecord = Math.min(endIndex, totalRows);
        recordInfo.textContent = `Menampilkan ${startRecord}-${endRecord} dari ${totalRows} data.`;

        // Render Pagination
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

    // Add new data button
    document.getElementById('add-data-btn').addEventListener('click', () => {
        currentState.editingIndex = null;
        modalTitle.textContent = 'Tambah Anggota Baru';
        const formHtml = `<input type="hidden" name="${csrfTokenName}" value="${csrfTokenValue}">
            <div class="mb-3"><label class="form-label">Nomor <span class="text-danger">*</span></label><input type="text" class="form-control" name="nomor" required></div>
            <div class="mb-3"><label class="form-label">Nama <span class="text-danger">*</span></label><input type="text" class="form-control" name="nama" required></div>
            <div class="mb-3"><label class="form-label">Password <span class="text-danger">*</span></label><input type="password" class="form-control" name="password" required></div>
            <div class="mb-3"><label class="form-label">Jurusan</label><input type="text" class="form-control" name="jurusan"></div>
            <div class="mb-3"><label class="form-label">Foto</label><input type="file" class="form-control" name="foto" accept="image/*"></div>
            <div class="mb-3"><label class="form-label">Role <span class="text-danger">*</span></label>
        <select class="form-select" name="role_id" required>
            <option value="1">Kepala Laboratorium</option>
            <option value="2">Asisten</option>
            <option value="3">Dosen</option>
        </select>
    </div>`;
        modalForm.innerHTML = formHtml;
        dataModal.show();
    });

    // Save data button
    saveDataBtn.addEventListener('click', async () => {
        const form = modalForm;
        const formData = new FormData(form);

        // Get form data as object for validation
        const data = {};
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }

        // Basic validation
        let isValid = true;
        let errorMessage = '';

        if (currentState.editingIndex === null) {
            // For create
            if (!data.nomor || !data.nama || !data.password || !data.role_id) {
                isValid = false;
                errorMessage = 'Semua field yang wajib diisi harus diisi!';
            }
        } else {
            // For edit, no required fields
            isValid = true;
        }

        if (!isValid) {
            alert(errorMessage);
            return;
        }

        try {
            // Use site_url helper for proper URL generation
            const baseUrl = '<?= site_url() ?>';
            let url = baseUrl + '/admin/users/create';
            let method = 'POST';

            if (currentState.editingIndex !== null) {
                // For edit, we need to get the user ID from the data
                const rowIndex = currentState.editingIndex;
                const userData = allRows[rowIndex];
                const userId = userData.dataset.userId; // Get user ID from data attribute
                url = baseUrl + `/admin/users/update/${userId}`;
                method = 'POST';
                // No need for _method field - CodeIgniter route is already POST
                console.log('Update URL:', url, 'User ID:', userId, 'Role ID:', data.role_id);
            } else {
                console.log('Create URL:', url);
            }

            const response = await fetch(url, {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData
            });

            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            console.log('Response content-type:', response.headers.get('content-type'));

            if (!response.ok) {
                const errorText = await response.text();
                console.error('Response error:', errorText);
                
                // Try to parse as JSON for better error message
                let errorMessage = `HTTP ${response.status}: ${response.statusText}`;
                try {
                    const errorJson = JSON.parse(errorText);
                    if (errorJson.message) {
                        errorMessage = errorJson.message;
                    }
                } catch (e) {
                    // Not JSON, use text as is
                }
                
                // If 401 or 403, redirect to login
                if (response.status === 401 || response.status === 403) {
                    alert('Session expired. Please login again.');
                    window.location.href = '/login';
                    return;
                }
                
                throw new Error(errorMessage);
            }

            let result;
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                result = await response.json();
                console.log('Response result:', result);
            } else {
                const textResult = await response.text();
                console.log('Response text:', textResult);
                // Try to parse as JSON anyway
                try {
                    result = JSON.parse(textResult);
                    console.log('Parsed JSON result:', result);
                } catch (e) {
                    console.error('Failed to parse response as JSON:', e);
                    throw new Error('Response is not valid JSON');
                }
            }

            if (result && result.success) {
                location.reload();
            } else {
                alert((result && result.message) || 'Terjadi kesalahan');
            }
        } catch (error) {
            console.error('Fetch error:', error);
            alert('Network error: ' + error.message);
        }
    });

    // Table action buttons
    tableBody.addEventListener('click', function(e) {
        const target = e.target.closest('button');
        if (!target) return;

        const userId = target.dataset.userId;
        const rowIndex = parseInt(target.dataset.index);

        if (target.classList.contains('edit-btn')) {
            currentState.editingIndex = rowIndex;
            const rowData = allRows[rowIndex];
            modalTitle.textContent = 'Edit Anggota';

            const formHtml = `<input type="hidden" name="${csrfTokenName}" value="${csrfTokenValue}">
                <div class="mb-3"><label class="form-label">Nomor</label><input type="text" class="form-control" name="nomor" value="${rowData.cells[1].textContent}"></div>
                <div class="mb-3"><label class="form-label">Nama</label><input type="text" class="form-control" name="nama" value="${rowData.cells[2].textContent}"></div>
                <div class="mb-3"><label class="form-label">Password</label><input type="password" class="form-control" name="password" placeholder="Kosongkan jika tidak ingin mengubah"></div>
                <div class="mb-3"><label class="form-label">Jurusan</label><input type="text" class="form-control" name="jurusan" value="${rowData.cells[3].textContent}"></div>
                <div class="mb-3"><label class="form-label">Foto</label><input type="file" class="form-control" name="foto" accept="image/*"></div>
                <div class="mb-3"><label class="form-label">Role</label>
                    <select class="form-select" name="role_id">
                        <option value="1" ${rowData.dataset.roleId === '1' ? 'selected' : ''}>Kepala Laboratorium</option>
                        <option value="2" ${rowData.dataset.roleId === '2' ? 'selected' : ''}>Asisten</option>
                        <option value="3" ${rowData.dataset.roleId === '3' ? 'selected' : ''}>Dosen</option>
                    </select>
                </div>`;
            modalForm.innerHTML = formHtml;
            dataModal.show();
        }

        if (target.classList.contains('delete-btn')) {
            if (confirm('Apakah Anda yakin ingin menghapus anggota ini?')) {
                const baseUrl = '<?= site_url() ?>';
                fetch(baseUrl + `/admin/users/delete/${userId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: new URLSearchParams({
                        [csrfTokenName]: csrfTokenValue
                    })
                }).then(async response => {
                    console.log('Delete response status:', response.status);
                    console.log('Delete response content-type:', response.headers.get('content-type'));

                    if (!response.ok) {
                        const errorText = await response.text();
                        console.error('Delete response error:', errorText);
                        
                        // Try to parse as JSON for better error message
                        let errorMessage = `HTTP ${response.status}: ${response.statusText}`;
                        try {
                            const errorJson = JSON.parse(errorText);
                            if (errorJson.message) {
                                errorMessage = errorJson.message;
                            }
                        } catch (e) {
                            // Not JSON, use text as is
                        }
                        
                        // If 401 or 403, redirect to login
                        if (response.status === 401 || response.status === 403) {
                            alert('Session expired. Please login again.');
                            window.location.href = '/login';
                            return;
                        }
                        
                        throw new Error(errorMessage);
                    }

                    let result;
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        result = await response.json();
                        console.log('Delete response result:', result);
                    } else {
                        const textResult = await response.text();
                        console.log('Delete response text:', textResult);
                        try {
                            result = JSON.parse(textResult);
                            console.log('Delete parsed JSON result:', result);
                        } catch (e) {
                            console.error('Failed to parse delete response as JSON:', e);
                            throw new Error('Response is not valid JSON');
                        }
                    }

                    if (result && result.success) {
                        location.reload();
                    } else {
                        alert((result && result.message) || 'Gagal menghapus data');
                    }
                }).catch(error => {
                    console.error('Delete fetch error:', error);
                    alert('Network error: ' + error.message);
                });
            }
        }
    });

    // Initial render
    updateView();
});
</script>
