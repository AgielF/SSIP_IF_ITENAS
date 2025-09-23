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
                    <!-- Tombol Tambah -->
                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="fas fa-plus me-2"></i>Tambah Anggota
                    </a>
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
                        <?php foreach ($asisten as $person): ?>
                            <tr data-timestamp="<?= strtotime($person['created_at'] ?? time()) ?>">
                                <td></td>
                                <td><?= esc($person['nomor'] ?? '') ?></td>
                                <td><?= esc($person['nama']) ?></td>
                                <td><?= esc($person['jurusan']) ?></td>
                                <td><?= esc($person['no_telp']) ?></td>
                                <td>
                                    <span class="badge bg-secondary"><?= esc(ucfirst($person['role'])) ?></span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" 
                                                class="btn btn-light btn-sm btn-edit" 
                                                data-user='<?= json_encode($person) ?>'>
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <a href="<?= base_url('asisten/delete/'.$person['id']) ?>" 
                                           class="btn btn-light btn-sm text-danger"
                                           onclick="return confirm('Hapus user ini?')">
                                           <i class="fas fa-trash-alt"></i>
                                        </a>
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

<!-- Modal Tambah User -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="<?= base_url('asisten/store') ?>" method="post" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Anggota</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body row g-3">
        <div class="col-md-6">
          <label class="form-label">NRP/NIDN</label>
          <input type="text" name="nomor" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Nama</label>
          <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Jurusan</label>
          <input type="text" name="jurusan" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">No. Telp</label>
          <input type="text" name="no_telp" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Password</label>
          <input type="text" name="password" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Role</label>
          <select name="role_id" class="form-select" required>
            <option value="2">Asisten</option>
            <option value="3">Praktikan</option>
            <option value="4">Dosen</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit User -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="editUserForm" method="post" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Anggota</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body row g-3">
        <input type="hidden" name="id" id="edit_id">
        <div class="col-md-6">
          <label class="form-label">NRP/NIDN</label>
          <input type="text" name="nomor" id="edit_nomor" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Nama</label>
          <input type="text" name="nama" id="edit_nama" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Jurusan</label>
          <input type="text" name="jurusan" id="edit_jurusan" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">No. Telp</label>
          <input type="text" name="no_telp" id="edit_no_telp" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Password (opsional)</label>
          <input type="text" name="password" id="edit_password" class="form-control">
        </div>
        <div class="col-md-6">
          <label class="form-label">Role</label>
          <select name="role_id" id="edit_role_id" class="form-select" required>
            <option value="2">Asisten</option>
            <option value="3">Praktikan</option>
            <option value="4">Dosen</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-success">Update</button>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.querySelector('#adminTable tbody');
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
            tableBody.innerHTML = `<tr><td colspan="7" class="text-center text-muted">Data tidak ditemukan.</td></tr>`;
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

    // === Edit Modal Handling ===
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const user = JSON.parse(btn.getAttribute('data-user'));
            document.getElementById('edit_id').value = user.id;
            document.getElementById('edit_nomor').value = user.nomor;
            document.getElementById('edit_nama').value = user.nama;
            document.getElementById('edit_jurusan').value = user.jurusan;
            document.getElementById('edit_no_telp').value = user.no_telp;
            document.getElementById('edit_role_id').value = user.role_id;
            document.getElementById('editUserForm').action = "<?= base_url('asisten/update/') ?>" + user.id;
            new bootstrap.Modal(document.getElementById('editUserModal')).show();
        });
    });

    updateView();
});
</script>
