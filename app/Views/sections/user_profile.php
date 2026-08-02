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
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">
                    <i class="fas fa-user-circle me-2 text-primary"></i>Profil Anggota
                </h4>
            </div>

            <div class="row align-items-center">
                <div class="col-md-3 text-center mb-3 mb-md-0">
                    <?php if (!empty($user['foto'])): ?>
                        <img src="<?= base_url(esc($user['foto'])) ?>"
                             class="rounded-circle shadow-sm border animate-hover"
                             alt="Foto <?= esc($user['nama']) ?>"
                             style="width: 150px; height: 150px; object-fit: cover;"
                             onerror="this.src='https://placehold.co/150x150/E2E8F0/334155?text=<?= urlencode(esc($user['nama'])) ?>'">
                    <?php else: ?>
                        <img src="https://placehold.co/150x150/E2E8F0/334155?text=<?= urlencode(esc($user['nama'])) ?>"
                             class="rounded-circle shadow-sm border animate-hover"
                             alt="Foto <?= esc($user['nama']) ?>"
                             style="width: 150px; height: 150px; object-fit: cover;">
                    <?php endif; ?>
                </div>

                <div class="col-md-9">
                    <div class="mb-1">
                        <h5 class="mb-0 fw-bold fs-4 text-dark"><?= esc($user['nama']) ?></h5>
                    </div>

                    <?php 
                        $roleLabel = 'Anggota Laboratorium';
                        if (isset($user['role'])) {
                            if ($user['role'] === 'admin') $roleLabel = 'Kepala Laboratorium SSIP';
                            elseif ($user['role'] === 'dosen') $roleLabel = 'Dosen Informatika';
                            elseif ($user['role'] === 'asisten') $roleLabel = 'Asisten Laboratorium';
                        }
                    ?>
                    <p class="text-muted mb-1">
                        <i class="fas fa-user-tag me-2 text-primary"></i><?= esc($roleLabel) ?>
                    </p>
                    <p class="text-muted mb-2">
                        <i class="fas fa-id-badge me-2"></i><?= esc($user['nomor'] ?? '-') ?>
                    </p>

                    <?php 
                    $roleId = (int)($user['role_id'] ?? 0);
                    $isAcademic = ($roleId === 1 || $roleId === 3 || in_array(strtolower($user['role'] ?? ''), ['admin', 'dosen']));
                    if ($isAcademic): 
                    ?>
                        <h6 class="mt-3 mb-2"><i class="fas fa-link me-2 text-primary"></i>Platform Penelitian</h6>
                        <div class="d-flex gap-3 fs-5">
                            <?php 
                            $scholar = !empty($user['google_scholar']) ? $user['google_scholar'] : (!empty($user['scholar_url']) ? $user['scholar_url'] : '');
                            $sinta   = !empty($user['sinta']) ? $user['sinta'] : (!empty($user['sinta_url']) ? $user['sinta_url'] : '');
                            $scopus  = !empty($user['scopus']) ? $user['scopus'] : (!empty($user['scopus_url']) ? $user['scopus_url'] : '');
                            $orcid   = !empty($user['orcid']) ? $user['orcid'] : (!empty($user['orcid_url']) ? $user['orcid_url'] : '');
                            ?>
                            <?php if (!empty($scholar)): ?>
                                <a href="<?= esc($scholar) ?>" target="_blank" class="text-dark" title="Google Scholar"><i class="fas fa-graduation-cap"></i></a>
                            <?php endif; ?>
                            <?php if (!empty($sinta)): ?>
                                <a href="<?= esc($sinta) ?>" target="_blank" class="text-dark" title="SINTA"><i class="fas fa-book"></i></a>
                            <?php endif; ?>
                            <?php if (!empty($scopus)): ?>
                                <a href="<?= esc($scopus) ?>" target="_blank" class="text-dark" title="Scopus"><i class="fas fa-university"></i></a>
                            <?php endif; ?>
                            <?php if (!empty($orcid)): ?>
                                <a href="<?= esc($orcid) ?>" target="_blank" class="text-dark" title="ORCID"><i class="fab fa-orcid"></i></a>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <h6 class="mt-3 mb-2"><i class="fas fa-link me-2 text-primary"></i>Hubungi Kontak</h6>
                        <div class="d-flex gap-3 fs-5">
                            <?php 
                            $waNumber = preg_replace('/[^0-9]/', '', $user['no_telp'] ?? '');
                            if (strpos($waNumber, '0') === 0) {
                                $waNumber = '62' . substr($waNumber, 1);
                            }
                            ?>
                            <?php if (!empty($waNumber)): ?>
                                <a href="https://wa.me/<?= $waNumber ?>" target="_blank" class="text-success" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                            <?php endif; ?>
                            <a href="mailto:<?= esc($user['nomor']) ?>@mahasiswa.itenas.ac.id" class="text-secondary" title="Email"><i class="fas fa-envelope"></i></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
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

