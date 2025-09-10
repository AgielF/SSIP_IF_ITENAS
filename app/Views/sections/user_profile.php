<style>
    .profile-card {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    .profile-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid #e9ecef;
    }
    .platform-links a {
        color: #6c757d;
        font-size: 1.5rem;
        transition: color 0.2s;
    }
    .platform-links a:hover {
        color: #0d6efd;
    }
    .nav-tabs .nav-link.active {
        background-color: #f8f9fa;
        border-bottom: 2px solid #0d6efd;
        color: #0d6efd;
    }
    .table thead th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
     /* === STYLE BARU UNTUK TABEL (MENGIKUTI REFERENSI) === */
    .nav-tabs {
        border-bottom: 1px solid #dee2e6;
    }
    .nav-tabs .nav-link {
        border: none;
        color: #6c757d;
        font-weight: 500;
        padding-left: 0;
        padding-right: 0;
        margin-right: 2rem;
    }
    .nav-tabs .nav-link.active {
        color: #0d6efd;
        background-color: transparent;
        border-bottom: 2px solid #0d6efd;
    }
    .table thead th {
        background-color: transparent;
        color: #6c757d;
        border: none;
        font-weight: 600;
        text-transform: uppercase;
        font-size: .8rem;
    }
    .table tbody tr td {
        vertical-align: middle;
        padding-top: 1rem;
        padding-bottom: 1rem;
        border-color: #f0f2f5;
    }
    .table .text-muted {
        font-size: .9rem;
    }
    .table tbody tr:last-child td {
        border-bottom: none;
    }
</style>

<div class="container my-5">
    <div class="profile-card mb-4">
        <div class="row align-items-center">
            <div class="col-md-3 text-center">
                <img src="https://placehold.co/150x150/E2E8F0/334155?text=<?= urlencode(esc($user['nama'])) ?>" class="profile-avatar" alt="Foto <?= esc($user['nama']) ?>">
            </div>
            <div class="col-md-9">
                <h2 class="h3 mb-1"><?= esc($user['nama']) ?></h2>
                
                <?php // Logika Kondisional: Tampilkan hanya jika role adalah 'dosen' ?>
                <?php if (isset($user['role']) && $user['role'] === 'dosen'): ?>
                    <p class="text-muted">Kepala Laboratorium SSIP</p>
                    <p class="text-muted small"><?= esc($user['nomor']) ?></p>
                    <h5 class="h6 mt-4">Keahlian Dosen:</h5>
                    <div class="mb-3">
                        <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill">Machine Learning</span>
                        <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill">Data Mining</span>
                        <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill">Artificial Intelligence</span>
                    </div>
                <?php else: // Tampilkan jurusan jika bukan dosen ?>
                    <p class="text-muted"><?= esc($user['jurusan'] ?? 'Anggota Laboratorium') ?></p>
                     <p class="text-muted small"><?= esc($user['nomor']) ?></p>
                <?php endif; ?>

                <h5 class="h6 mt-4">Platform Penelitian:</h5>
                <div class="d-flex gap-3 platform-links">
                    <a href="#" title="Google Scholar"><i class="fas fa-graduation-cap"></i></a>
                    <a href="#" title="SINTA"><i class="fas fa-book"></i></a>
                    <a href="#" title="GitHub"><i class="fab fa-github"></i></a>
                    <a href="#" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
    </div>




       <!-- Panel Tab untuk Publikasi dan Proyek -->
    <div class="profile-card">
        <ul class="nav nav-tabs" id="dosenTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="publikasi-tab" data-bs-toggle="tab" data-bs-target="#publikasi" type="button" role="tab">
                    Publikasi Ilmiah
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="proyek-tab" data-bs-toggle="tab" data-bs-target="#proyek" type="button" role="tab">
                    Penelitian & Proyek
                </button>
            </li>
        </ul>

        <div class="tab-content pt-4" id="dosenTabContent">
            <!-- Konten Tab Publikasi Ilmiah -->
            <div class="tab-pane fade show active" id="publikasi" role="tabpanel">
                <div class="printable-area">
                    <div class="d-flex justify-content-between align-items-center mb-3 non-printable">
                        <input type="text" class="form-control form-control-sm me-2" placeholder="Cari publikasi..." style="width: 250px;" data-table="publikasiTable">
                        <div class="d-flex align-items-center">
                             <label class="form-label me-2 mb-0 small text-nowrap">Urutkan:</label>
                             <select class="form-select form-select-sm" data-table="publikasiTable" style="width: auto;">
                                 <option value="newest">Terbaru</option>
                                 <option value="oldest">Terlama</option>
                             </select>
                             <button class="btn btn-sm btn-danger ms-2" onclick="exportToPdf('publikasi')"><i class="fas fa-file-pdf me-1"></i> PDF</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="publikasiTable">
                            <thead>
                                <tr>
                                    <th>nomor</th>
                                    <th>Judul</th>
                                    <th>Jenis</th>
                                    <th data-sortable="true">Tahun</th>
                                    <th>Link</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>AI in Medical Imaging: A Review</td>
                                    <td>Jurnal Internasional</td>
                                    <td>2023</td>
                                    <td><a href="#">DOI</a></td>
                                </tr>
                                <tr>
                                     <td>2</td>
                                    <td>A Novel Approach to IoT Security</td>
                                    <td>Prosiding Konferensi</td>
                                    <td>2023</td>
                                    <td><a href="#">IEEE Xplore</a></td>
                                </tr>
                                <tr>
                                     <td>3</td>
                                    <td>Big Data for Stock Market Prediction</td>
                                    <td>Jurnal Nasional</td>
                                    <td>2022</td>
                                    <td><a href="#">SINTA</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Konten Tab Penelitian & Proyek -->
            <div class="tab-pane fade" id="proyek" role="tabpanel">
                 <div class="printable-area">
                    <div class="d-flex justify-content-between align-items-center mb-3 non-printable">
                        <input type="text" class="form-control form-control-sm me-2" placeholder="Cari proyek..." style="width: 250px;" data-table="proyekTable">
                        <div class="d-flex align-items-center">
                             <label class="form-label me-2 mb-0 small text-nowrap">Urutkan:</label>
                             <select class="form-select form-select-sm" data-table="proyekTable" style="width: auto;">
                                 <option value="newest">Terbaru</option>
                                 <option value="oldest">Terlama</option>
                             </select>
                             <button class="btn btn-sm btn-danger ms-2" onclick="exportToPdf('proyek')"><i class="fas fa-file-pdf me-1"></i> PDF</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="proyekTable">
                            <thead>
                                <tr>
                                    <th>Nama Proyek</th>
                                    <th>Status</th>
                                    <th>Sumber Dana</th>
                                    <th data-sortable="true">Periode</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Pengembangan AI untuk Analisis Citra Medis</td>
                                    <td><span class="badge bg-primary">Selesai</span></td>
                                    <td>Hibah DIKTI</td>
                                    <td>2023</td>
                                </tr>
                                <tr>
                                    <td>Sistem IoT untuk Smart Agriculture</td>
                                    <td><span class="badge bg-info">Berjalan</span></td>
                                    <td>Kolaborasi Industri</td>
                                    <td>2024</td>
                                </tr>
                            </tbody>
                        </table>
                        

                    </div>
                    
                </div>
            </div>
        </div>
          <!-- Paginasi -->
                        <nav class="d-flex justify-content-center">
                            <ul class="pagination pagination-sm">
                                <li class="page-item disabled"><a class="page-link" href="#">First page</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">4</a></li>
                                <li class="page-item"><a class="page-link" href="#">5</a></li>
                                <li class="page-item"><a class="page-link" href="#">6</a></li>
                                <li class="page-item"><a class="page-link" href="#">7</a></li>
                                <li class="page-item"><a class="page-link" href="#">Last page</a></li>
                            </ul>
                        </nav>
    </div>


</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    function setupTableControls(tableId) {
        const table = document.getElementById(tableId);
        if (!table) return;

        const searchInput = document.querySelector(`input[data-table="${tableId}"]`);
        const sortSelect = document.querySelector(`select[data-table="${tableId}"]`);
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        const sortableHeader = table.querySelector('th[data-sortable="true"]');
        const sortableIndex = sortableHeader ? Array.from(sortableHeader.parentNode.children).indexOf(sortableHeader) : -1;

        function updateTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const sortOrder = sortSelect.value;

            // 1. Filter
            const filteredRows = rows.filter(row => {
                return row.textContent.toLowerCase().includes(searchTerm);
            });

            // 2. Sort
            if (sortableIndex !== -1) {
                filteredRows.sort((a, b) => {
                    const valA = a.cells[sortableIndex].textContent.trim();
                    const valB = b.cells[sortableIndex].textContent.trim();
                    return sortOrder === 'newest' ? valB.localeCompare(valA) : valA.localeCompare(valB);
                });
            }

            // 3. Render
            tbody.innerHTML = ''; // Clear table
            if(filteredRows.length === 0){
                 tbody.innerHTML = `<tr><td colspan="${table.querySelector('thead th').length}" class="text-center text-muted">Data tidak ditemukan.</td></tr>`;
            } else {
                filteredRows.forEach(row => tbody.appendChild(row));
            }
        }

        searchInput.addEventListener('keyup', updateTable);
        sortSelect.addEventListener('change', updateTable);
    }

    setupTableControls('publikasiTable');
    setupTableControls('proyekTable');
});

function exportToPdf(tabId) {
    const originalTitle = document.title;
    const tabContent = document.getElementById(tabId);
    if(tabContent){
        document.title = tabContent.querySelector('h4') ? tabContent.querySelector('h4').textContent : 'Exported Data';
        window.print();
        document.title = originalTitle;
    }
}
</script>

