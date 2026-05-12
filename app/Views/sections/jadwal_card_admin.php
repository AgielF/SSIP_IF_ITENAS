<meta name="csrf-token" content="<?= csrf_hash() ?>">

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

    /* Modal visibility improvements */
    #assignAsistenModal .modal-content {
        background-color: #ffffff !important;
        border: 2px solid #dee2e6 !important;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.5) !important;
    }
    #assignAsistenModal .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.7) !important;
    }
    #assignAsistenModal .form-check {
        background-color: #f8f9fa;
        padding: 8px;
        margin-bottom: 5px;
        border-radius: 4px;
        border: 1px solid #dee2e6;
    }
    #assignAsistenModal .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    @media print {
        body * { visibility: hidden; }
        #printable-area, #printable-area * { visibility: visible; }
        #printable-area { position: absolute; left: 0; top: 0; width: 100%; }
        .btn, .nav-tabs, #search-input, #sort-filter, #items-per-page-filter,
        #pagination-controls, label, #record-info, .non-printable {
            display: none !important;
        }
    }
</style>

<div class="container my-5">
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

    <ul class="nav nav-tabs" id="project-nav">
        <li class="nav-item">
            <a class="nav-link active" href="#">Daftar Jadwal</a>
        </li>
    </ul>

    <main class="fm-content card rounded-0 rounded-bottom border-top-0">
        <div class="card-body">
            <div id="printable-area">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                    <h4 class="mb-0">Daftar Jadwal</h4>
                    
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
                        <button id="add-data-btn" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addDataModal">
                            <i class="fas fa-plus me-1"></i> Tambah Jadwal
                        </button>
                    </div>
                </div>

                <p class="text-muted small mb-3" id="record-info">Menampilkan data...</p>

                <div class="table-responsive">
                    <table class="table fm-table table-hover" id="jadwal-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Matakuliah</th>
                                <th>Kelas</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Dosen</th>
                                <th>Ruangan</th>
                                <th>Asisten</th>
                                <th>Jenis</th>
                                <th class="non-printable">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($schedules['rows'])) : ?>
                                <?php foreach ($schedules['rows'] as $row) : ?>
                                    <tr>
                                        <td><?= esc($row[0]) ?></td>
                                        <td><?= esc($row[1]) ?></td>
                                        <td><?= esc($row[2]) ?></td>
                                        <td><?= esc($row[3]) ?></td>
                                        <td><?= esc($row[4]) ?></td>
                                        <td><?= esc($row[5]) ?></td>
                                        <td><?= esc($row[6]) ?></td>
                                        <td><?= esc($row[7]) ?></td>
                                        <td><?= esc($row[8]) ?></td>
                                        <td class="non-printable">
                                            <button class="btn btn-sm btn-outline-secondary me-1 btn-edit"
                                                data-id="<?= $row[0] ?>"
                                                data-id_event="<?= esc($row[9] ?? '') ?>"
                                                data-tanggal="<?= esc($row[10]) ?>"
                                                data-waktu_mulai="<?= esc($row[11]) ?>"
                                                data-waktu_selesai="<?= esc($row[12]) ?>"
                                                data-ruangan="<?= esc($row[13]) ?>"
                                                data-kelas="<?= esc($row[14]) ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editDataModal">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-info me-1 btn-assign"
                                                data-id="<?= $row[0] ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#assignAsistenModal">
                                                <i class="fas fa-user-plus"></i>
                                            </button>
                                            
                                            <form action="<?= site_url('jadwal/delete/'.$row[0]) ?>" 
                                                  method="POST" 
                                                  class="d-inline" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="10" class="text-center text-muted">Data tidak ditemukan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <nav>
                <ul class="pagination pagination-sm justify-content-end" id="pagination-controls"></ul>
            </nav>
        </div>
    </main>
</div>

<div class="modal fade" id="addDataModal" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" action="<?= site_url('jadwal/store') ?>" method="post">
            <?= csrf_field() ?>
            <div class="modal-header">
                <h5 class="modal-title">Tambah Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Event</label>
                    <select name="id_event" class="form-control" required>
                        <option value="">-- Pilih Event --</option>
                        <?php foreach ($events as $event): ?>
                            <option value="<?= $event['id_event']; ?>"><?= $event['nama_event']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Waktu Mulai</label>
                    <input type="time" name="waktu_mulai" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Waktu Selesai</label>
                    <input type="time" name="waktu_selesai" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ruangan</label>
                    <input type="text" name="ruangan" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kelas</label>
                    <select name="kelas" class="form-control">
                        <option value="">-- Pilih Kelas --</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="editDataModal" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" id="editForm" method="post">
            <?= csrf_field() ?>
            <div class="modal-header">
                <h5 class="modal-title">Edit Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_jadwal" id="edit-id">
                <div class="mb-3">
                    <label class="form-label">Event</label>
                    <select name="id_event" id="edit-id-event" class="form-control" required>
                        <option value="">-- Pilih Event --</option>
                        <?php foreach ($events as $event): ?>
                            <option value="<?= $event['id_event']; ?>"><?= $event['nama_event']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" id="edit-tanggal" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Waktu Mulai</label>
                    <input type="time" name="waktu_mulai" id="edit-waktu-mulai" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Waktu Selesai</label>
                    <input type="time" name="waktu_selesai" id="edit-waktu-selesai" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ruangan</label>
                    <input type="text" name="ruangan" id="edit-ruangan" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kelas</label>
                    <select name="kelas" id="edit-kelas" class="form-control">
                        <option value="">-- Pilih Kelas --</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="assignAsistenModal" tabindex="-1" style="z-index: 1055;" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-white shadow-lg border">
            <form id="assignAsistenForm" method="post">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Assign Asisten ke Jadwal</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_jadwal" id="assign-jadwal-id">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Asisten Laboratorium</label>
                        <div id="asisten-list" class="border rounded p-3 bg-light" style="max-height: 300px; overflow-y: auto;">
                            </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Assignment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
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
    
    const searchInput = document.getElementById('search-input');
    const table = document.getElementById('jadwal-table');
    const tableRows = Array.from(table.querySelectorAll('tbody tr'));
    const sortFilter = document.getElementById('sort-filter');
    const itemsPerPageFilter = document.getElementById('items-per-page-filter');
    const recordInfo = document.getElementById('record-info');
    const paginationControls = document.getElementById('pagination-controls');
    const exportPdfBtn = document.getElementById('export-pdf-btn');

    let currentPage = 1;

    function updateTable() {
        let rows = [...tableRows];
        const searchTerm = searchInput.value.toLowerCase();

        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(searchTerm) ? '' : 'none';
        });
        rows = rows.filter(row => row.style.display !== 'none');

        // Sorting by Jam (index 4)
        rows.sort((a, b) => {
            const valA = a.cells[4].innerText;
            const valB = b.cells[4].innerText;
            return sortFilter.value === 'newest' ? valB.localeCompare(valA) : valA.localeCompare(valB);
        });

        const perPage = itemsPerPageFilter.value === 'all' ? rows.length : parseInt(itemsPerPageFilter.value, 10);
        const totalRows = rows.length;
        const totalPages = Math.ceil(totalRows / perPage) || 1;
        if (currentPage > totalPages) currentPage = 1;
        const startIndex = (currentPage - 1) * perPage;
        const endIndex = startIndex + perPage;

        rows.forEach((row, i) => {
            row.style.display = (i >= startIndex && i < endIndex) ? '' : 'none';
        });

        recordInfo.textContent = totalRows === 0 
            ? "Tidak ada data ditemukan." 
            : `Menampilkan ${startIndex + 1}-${Math.min(endIndex, totalRows)} dari ${totalRows} data.`;

        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        paginationControls.innerHTML = '';
        if (totalPages <= 1) return;

        const createPageItem = (label, page, disabled = false, active = false) => {
            const li = document.createElement('li');
            li.className = `page-item ${disabled ? 'disabled' : ''} ${active ? 'active' : ''}`;
            li.innerHTML = `<a class="page-link" href="#">${label}</a>`;
            li.addEventListener('click', e => {
                e.preventDefault();
                if (!disabled) {
                    currentPage = page;
                    updateTable();
                }
            });
            return li;
        };

        paginationControls.appendChild(createPageItem("«", currentPage - 1, currentPage === 1));
        for (let i = 1; i <= totalPages; i++) {
            paginationControls.appendChild(createPageItem(i, i, false, i === currentPage));
        }
        paginationControls.appendChild(createPageItem("»", currentPage + 1, currentPage === totalPages));
    }

    searchInput.addEventListener('keyup', () => { currentPage = 1; updateTable(); });
    sortFilter.addEventListener('change', () => { currentPage = 1; updateTable(); });
    itemsPerPageFilter.addEventListener('change', () => { currentPage = 1; updateTable(); });
    exportPdfBtn.addEventListener('click', () => window.print());

    updateTable();

    // === Edit Modal ===
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const idEvent = this.getAttribute('data-id_event');
            const tanggal = this.getAttribute('data-tanggal');
            const waktuMulai = this.getAttribute('data-waktu_mulai');
            const waktuSelesai = this.getAttribute('data-waktu_selesai');
            const ruangan = this.getAttribute('data-ruangan');
            const kelas = this.getAttribute('data-kelas');

            document.getElementById("edit-id").value = id;
            document.getElementById("edit-id-event").value = idEvent;
            document.getElementById("edit-tanggal").value = tanggal;
            document.getElementById("edit-waktu-mulai").value = waktuMulai;
            document.getElementById("edit-waktu-selesai").value = waktuSelesai;
            document.getElementById("edit-ruangan").value = ruangan;
            document.getElementById("edit-kelas").value = kelas;

            document.getElementById("editForm").action = "<?= site_url('jadwal/update/') ?>" + id;
        });
    });

    // === Assign Asisten Modal ===
    document.querySelectorAll('.btn-assign').forEach(button => {
        button.addEventListener('click', function() {
            const jadwalId = this.getAttribute('data-id');
            document.getElementById('assign-jadwal-id').value = jadwalId;

            // Load available assistants
            loadAssistantsForJadwal(jadwalId);
        });
    });

    function loadAssistantsForJadwal(jadwalId) {
        const asistenList = document.getElementById('asisten-list');
        asistenList.innerHTML = '<div class="text-center"><div class="spinner-border" role="status"></div></div>';

        // Get available assistants from PHP data
        const assistants = <?php echo json_encode($assistants ?? []); ?>;

        // Get currently assigned assistants for this jadwal
        fetch('<?php echo site_url('api/asisten-jadwal'); ?>?jadwal=' + jadwalId, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const assignedIds = data.data ? data.data.map(item => item.id_user) : [];

            let html = '';
            if (assistants && assistants.length > 0) {
                assistants.forEach(asisten => {
                    const isAssigned = assignedIds.includes(asisten.id);
                    html += `
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                   name="assigned_asisten[]" value="${asisten.id}"
                                   id="asisten-${asisten.id}" ${isAssigned ? 'checked' : ''}>
                            <label class="form-check-label" for="asisten-${asisten.id}">
                                ${asisten.nama}
                            </label>
                        </div>
                    `;
                });
            }

            asistenList.innerHTML = html || '<p class="text-muted">Tidak ada asisten tersedia</p>';
        })
        .catch(error => {
            console.error('Error loading assistants:', error);
            asistenList.innerHTML = '<p class="text-danger">Error loading assistants: ' + error.message + '</p>';
        });
    }

    // Handle assign asisten form submission
    document.getElementById('assignAsistenForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const jadwalId = formData.get('id_jadwal');

        // Clear existing assignments first
        fetch('<?= site_url('api/asisten-jadwal') ?>?jadwal=' + jadwalId, {
            method: 'GET'
        })
        .then(response => response.json())
        .then(data => {
            const deletePromises = (data.data || []).map(item => {
                return fetch('<?= site_url('api/asisten-jadwal/delete/') ?>' + item.id, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                });
            });

            return Promise.all(deletePromises);
        })
        .then(() => {
            // Add new assignments
            const selectedAsisten = formData.getAll('assigned_asisten[]');
            const assignPromises = selectedAsisten.map(asistenId => {
                const assignData = new FormData();
                assignData.append('id_jadwal', jadwalId);
                assignData.append('id_user', asistenId);

                return fetch('<?= site_url('api/asisten-jadwal/create') ?>', {
                    method: 'POST',
                    body: assignData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
            });

            return Promise.all(assignPromises);
        })
        .then(() => {
            // Close modal and reload page
            const modal = bootstrap.Modal.getInstance(document.getElementById('assignAsistenModal'));
            modal.hide();
            location.reload();
        })
        .catch(error => {
            console.error('Error updating assignments:', error);
            alert('Terjadi kesalahan saat menyimpan assignment');
        });
    });
});
</script>