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
            <table id="adminTable" class="table table-hover align-middle" style="width:100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>NRP/NIDN</th>
                        <th>Nama</th>
                        <th>Jurusan</th>
                        <th>Role</th>
                        <th>Periode</th> 
                        <th class="non-printable text-center">Status</th>
                        <th class="non-printable text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($asisten)): ?>
                        <?php foreach ($asisten as $i => $person): ?>
                            <tr data-timestamp="<?= strtotime($person['created_at'] ?? time()) ?>" data-user-id="<?= esc($person['id']) ?>" data-role-id="<?= esc($person['role_id'] ?? '') ?>">
                                <td></td> 
                                <td><?= esc($person['nomor'] ?? '') ?></td>
                                <td><?= esc($person['nama']) ?></td>
                                <td><?= esc($person['jurusan'] ?? '') ?></td>
                                <td>
                                    <?php 
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
                                    <span class="badge bg-info text-dark"><?= esc($person['nama_periode'] ?? '-') ?></span>
                                </td>
                                
                                <!-- Field Status di Sebelah Kiri Kolom Aksi -->
                                <td class="text-center">
                                    <?php if ($person['role_id'] == 2 && !empty($person['id_asisten_periode'])) : ?>
                                        <?php 
                                            $statusTugas = $person['status_tugas'] ?? 'belum selesai';
                                            $isSelesai   = ($statusTugas === 'selesai');
                                            $btnClass    = $isSelesai ? 'btn-success' : 'btn-secondary';
                                            $textLabel   = $isSelesai ? 'Selesai' : 'Masih Berjalan';
                                            $tooltipMsg  = $isSelesai ? 'Status: Selesai (Klik untuk ubah ke Masih Berjalan)' : 'Status: Masih Berjalan (Klik untuk ubah ke Selesai)';
                                        ?>
                                        <button type="button" 
                                                class="btn btn-sm <?= $btnClass ?> text-white text-nowrap px-2 py-1" 
                                                title="<?= $tooltipMsg ?>" 
                                                onclick="toggleStatusTugas(<?= $person['id_asisten_periode'] ?>, '<?= $statusTugas ?>')">
                                            <?= $textLabel ?>
                                        </button>
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>

                                <!-- Kolom Aksi -->
                                <td class="text-center">
                                    <div class="btn-group d-flex justify-content-center">
                                        <!-- Tombol Edit & Delete Bawaan -->
                                        <button class="btn btn-light btn-sm edit-btn border-end" title="Edit" data-index="<?= $i ?>" data-user-id="<?= esc($person['id']) ?>" data-periode-name="<?= esc($person['nama_periode'] ?? '') ?>">
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

<div class="modal fade" id="dataModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Form Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="data-form">
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
// --- FUNGSI AJAX STATUS TUGAS SERTIFIKAT ---
function toggleStatusTugas(idAsistenPeriode, statusSaatIni) {
    let statusBaru = (statusSaatIni === 'selesai') ? 'belum selesai' : 'selesai';
    
    if (!confirm(`Ubah status tugas sertifikat menjadi "${statusBaru.toUpperCase()}"?`)) {
        return;
    }

    const csrfName = '<?= csrf_token() ?>';
    const csrfHash = '<?= csrf_hash() ?>';

    fetch(`<?= site_url('sertifikat/status/') ?>${idAsistenPeriode}`, {
        method: 'POST', 
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ 
            status_tugas: statusBaru,
            [csrfName]: csrfHash
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            location.reload(); 
        } else {
            alert('Gagal: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan koneksi saat mengubah status.');
    });
}

// --- FUNGSI UI BAWAAN ---
const listPeriode = <?= json_encode($listPeriode ?? []) ?>;

document.addEventListener('DOMContentLoaded', function () {
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
        editingIndex: null 
    };

    function updateView() {
        let processedRows = allRows.filter(row =>
            row.textContent.toLowerCase().includes(currentState.searchTerm)
        );

        processedRows.sort((a, b) => {
            const timeA = parseInt(a.dataset.timestamp, 10);
            const timeB = parseInt(b.dataset.timestamp, 10);
            return (currentState.sortOrder === 'newest') ? timeB - timeA : timeA - timeB;
        });

        const totalRows = processedRows.length;
        const limit = currentState.itemsPerPage === 'all' ? totalRows : parseInt(currentState.itemsPerPage, 10);
        const startIndex = (currentState.currentPage - 1) * limit;
        const endIndex = startIndex + limit;
        const paginatedRows = processedRows.slice(startIndex, endIndex);

        tableBody.innerHTML = ''; 
        if (paginatedRows.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="8" class="text-center text-muted">Data tidak ditemukan.</td></tr>`;
        } else {
            paginatedRows.forEach((row, index) => {
                row.cells[0].textContent = startIndex + index + 1; 
                tableBody.appendChild(row);
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

    document.getElementById('add-data-btn').addEventListener('click', () => {
        currentState.editingIndex = null;
        modalTitle.textContent = 'Tambah Anggota Baru';
        
        let periodeOptions = '<option value="">-- Pilih Periode --</option>';
        listPeriode.forEach(p => {
            periodeOptions += `<option value="${p.id_periode}">${p.nama_periode}</option>`;
        });

        const formHtml = `<input type="hidden" name="${csrfTokenName}" value="${csrfTokenValue}">
            <div class="mb-3"><label class="form-label">Nomor <span class="text-danger">*</span></label><input type="text" class="form-control" name="nomor" required></div>
            <div class="mb-3"><label class="form-label">Nama <span class="text-danger">*</span></label><input type="text" class="form-control" name="nama" required></div>
            <div class="mb-3"><label class="form-label">Password <span class="text-danger">*</span></label><input type="password" class="form-control" name="password" required></div>
            <div class="mb-3"><label class="form-label">Jurusan</label><input type="text" class="form-control" name="jurusan"></div>
            <div class="mb-3"><label class="form-label">Foto</label><input type="file" class="form-control" name="foto" accept="image/*"></div>
            <div class="mb-3"><label class="form-label">Role <span class="text-danger">*</span></label>
                <select class="form-select" name="role_id" id="dynamic-role-select" required>
                    <option value="1">Kepala Laboratorium</option>
                    <option value="2">Asisten</option>
                    <option value="3">Dosen</option>
                    
                </select>
            </div>
            <div class="mb-3" id="dynamic-periode-container" style="display:none;">
                <label class="form-label">Periode Kepengurusan</label>
                <select class="form-select" name="id_periode">
                    ${periodeOptions}
                </select>
            </div>`;
        
        modalForm.innerHTML = formHtml;
        
        document.getElementById('dynamic-role-select').addEventListener('change', function() {
            document.getElementById('dynamic-periode-container').style.display = this.value === '2' ? 'block' : 'none';
        });

        dataModal.show();
    });

    saveDataBtn.addEventListener('click', async () => {
        const form = modalForm;
        const formData = new FormData(form);
        const data = {};
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }

        let isValid = true;
        let errorMessage = '';

        if (currentState.editingIndex === null) {
            if (!data.nomor || !data.nama || !data.password || !data.role_id) {
                isValid = false;
                errorMessage = 'Semua field yang wajib diisi harus diisi!';
            }
        }

        if (!isValid) {
            alert(errorMessage);
            return;
        }

        try {
            const baseUrl = '<?= site_url() ?>';
            let url = baseUrl + '/admin/users/create';
            let method = 'POST';

            if (currentState.editingIndex !== null) {
                const rowIndex = currentState.editingIndex;
                const userData = allRows[rowIndex];
                const userId = userData.dataset.userId; 
                url = baseUrl + `/admin/users/update/${userId}`;
                method = 'POST';
            }

            const response = await fetch(url, {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData
            });

            if (!response.ok) {
                const errorText = await response.text();
                let errorMessage = `HTTP ${response.status}: ${response.statusText}`;
                try {
                    const errorJson = JSON.parse(errorText);
                    if (errorJson.message) errorMessage = errorJson.message;
                } catch (e) {}
                
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
            } else {
                const textResult = await response.text();
                try {
                    result = JSON.parse(textResult);
                } catch (e) {
                    throw new Error('Response is not valid JSON');
                }
            }

            if (result && result.success) {
                location.reload();
            } else {
                alert((result && result.message) || 'Terjadi kesalahan');
            }
        } catch (error) {
            alert('Network error: ' + error.message);
        }
    });

    tableBody.addEventListener('click', function(e) {
        const target = e.target.closest('button');
        if (!target) return;

        const userId = target.dataset.userId;
        const rowIndex = parseInt(target.dataset.index);

        if (target.classList.contains('edit-btn')) {
            currentState.editingIndex = rowIndex;
            const rowData = allRows[rowIndex];
            modalTitle.textContent = 'Edit Anggota';

            const currentPeriodeName = target.dataset.periodeName || '';
            
            let periodeOptions = '<option value="">-- Pilih Periode --</option>';
            listPeriode.forEach(p => {
                const isSelected = (p.nama_periode === currentPeriodeName) ? 'selected' : '';
                periodeOptions += `<option value="${p.id_periode}" ${isSelected}>${p.nama_periode}</option>`;
            });

            const isAsisten = rowData.dataset.roleId === '2';
            const displayPeriode = isAsisten ? 'block' : 'none';

            const formHtml = `<input type="hidden" name="${csrfTokenName}" value="${csrfTokenValue}">
                <div class="mb-3"><label class="form-label">Nomor</label><input type="text" class="form-control" name="nomor" value="${rowData.cells[1].textContent}"></div>
                <div class="mb-3"><label class="form-label">Nama</label><input type="text" class="form-control" name="nama" value="${rowData.cells[2].textContent}"></div>
                <div class="mb-3"><label class="form-label">Password</label><input type="password" class="form-control" name="password" placeholder="Kosongkan jika tidak ingin mengubah"></div>
                <div class="mb-3"><label class="form-label">Jurusan</label><input type="text" class="form-control" name="jurusan" value="${rowData.cells[3].textContent}"></div>
                <div class="mb-3"><label class="form-label">Foto</label><input type="file" class="form-control" name="foto" accept="image/*"></div>
                <div class="mb-3"><label class="form-label">Role</label>
                    <select class="form-select" name="role_id" id="dynamic-role-select-edit">
                        <option value="1" ${rowData.dataset.roleId === '1' ? 'selected' : ''}>Kepala Laboratorium</option>
                        <option value="2" ${rowData.dataset.roleId === '2' ? 'selected' : ''}>Asisten</option>
                        <option value="3" ${rowData.dataset.roleId === '3' ? 'selected' : ''}>Dosen</option>
                        
                    </select>
                </div>
                <div class="mb-3" id="dynamic-periode-container-edit" style="display:${displayPeriode};">
                    <label class="form-label">Periode Kepengurusan</label>
                    <select class="form-select" name="id_periode">
                        ${periodeOptions}
                    </select>
                </div>`;
            
            modalForm.innerHTML = formHtml;

            document.getElementById('dynamic-role-select-edit').addEventListener('change', function() {
                document.getElementById('dynamic-periode-container-edit').style.display = this.value === '2' ? 'block' : 'none';
            });

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
                    if (!response.ok) {
                        const errorText = await response.text();
                        let errorMessage = `HTTP ${response.status}: ${response.statusText}`;
                        try {
                            const errorJson = JSON.parse(errorText);
                            if (errorJson.message) errorMessage = errorJson.message;
                        } catch (e) {}
                        
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
                    } else {
                        const textResult = await response.text();
                        try {
                            result = JSON.parse(textResult);
                        } catch (e) {
                            throw new Error('Response is not valid JSON');
                        }
                    }

                    if (result && result.success) {
                        location.reload();
                    } else {
                        alert((result && result.message) || 'Gagal menghapus data');
                    }
                }).catch(error => {
                    alert('Network error: ' + error.message);
                });
            }
        }
    });

    updateView();
});
</script>