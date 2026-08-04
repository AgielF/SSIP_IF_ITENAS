<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="h3">ANGGOTA LAB. SSIP</h2>
        <hr class="w-50 mx-auto">
    </div>

    <div class="filterable-container">
        <div class="card shadow-sm mb-4">
            <div class="card-body d-flex flex-column flex-md-row justify-content-md-between align-items-start align-items-md-center gap-3">
                <div class="filter-controls btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-outline-primary active" data-filter="semua">Semua</button>
                    <button type="button" class="btn btn-outline-primary" data-filter="admin">Kepala Laboratorium</button>
                    <button type="button" class="btn btn-outline-primary" data-filter="dosen">Dosen</button>
                    <button type="button" class="btn btn-outline-primary" data-filter="asisten">Asisten</button>
                </div>
                <div class="d-flex align-items-center gap-3">
                  
                    <div class="d-flex align-items-center">
                        <input type="text" id="search-input" class="form-control form-control-sm" placeholder="Cari nama...">
                    </div>
                    <div class="d-flex align-items-center">
                        <label for="period-filter" class="form-label me-2 mb-0">Periode:</label>
                        <select class="form-select form-select-sm" id="period-filter" style="width: auto;">
                            <option value="semua">Semua</option>
                            <?php if (!empty($listPeriode)): ?>
                                <?php foreach ($listPeriode as $p): ?>
                                    <option value="<?= esc($p['nama_periode']) ?>"><?= esc($p['nama_periode']) ?></option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="2023/2024">2023/2024</option>
                                <option value="2022/2023" selected>2022/2023</option>
                                <option value="2021/2022">2021/2022</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
            </div> 
        </div>

        <div class="row g-4 filterable-items">
            <?php if (!empty($asisten)): ?>
                <?php foreach ($asisten as $i => $a): ?>
                <?php 
                $links = [
                    'scholar' => !empty($a['google_scholar']) ? $a['google_scholar'] : (!empty($a['scholar_url']) ? $a['scholar_url'] : '#'),
                    'sinta'   => !empty($a['sinta']) ? $a['sinta'] : (!empty($a['sinta_url']) ? $a['sinta_url'] : '#'),
                    'scopus'  => !empty($a['scopus']) ? $a['scopus'] : (!empty($a['scopus_url']) ? $a['scopus_url'] : '#'),
                    'orcid'   => !empty($a['orcid']) ? $a['orcid'] : (!empty($a['orcid_url']) ? $a['orcid_url'] : '#')
                ];
                ?>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 filter-item" data-role="<?= esc(strtolower($a['role'] ?? '')) ?>" data-period="<?= esc($a['nama_periode'] ?? 'semua') ?>">
                    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden" style="transition: transform 0.2s ease, box-shadow 0.2s ease;">
                        <div class="position-relative">
                            <div class="role-badge bg-primary text-white py-1 px-2 rounded position-absolute top-0 end-0 m-2 small">
                                <?= $a['role'] === 'admin' ? 'Kepala Laboratorium' : ucfirst(esc($a['role'] ?? '')) ?>
                            </div>
                            <?php if (!empty($a['foto'])): ?>
                                <img src="<?= base_url(esc($a['foto'])) ?>" class="card-img-top aspect-ratio-portrait" alt="Foto <?= esc($a['nama']) ?>" onerror="this.src='https://placehold.co/400x600/E2E8F0/334155?text=<?= urlencode(esc($a['nama'])) ?>'">
                            <?php else: ?>
                                <img src="https://placehold.co/400x600/E2E8F0/334155?text=<?= urlencode(esc($a['nama'])) ?>" class="card-img-top aspect-ratio-portrait" alt="Foto <?= esc($a['nama']) ?>">
                            <?php endif; ?>
                        </div>
                        <div class="card-body text-center p-4 d-flex flex-column">
                            <h5 class="card-title mb-1 fw-bold card-title-height">
                                <a href="<?= base_url('asisten/' . $a['id']) ?>" class="text-decoration-none text-dark card-name-link">
                                    <?= esc($a['nama']) ?>
                                </a>
                            </h5>
                            <p class="card-text text-muted small mb-2 d-flex align-items-center justify-content-center">
                                <i class="far fa-id-card text-muted" style="margin-right: 5px;"></i> <?= esc($a['nomor'] ?? 'N/A') ?>
                            </p>
                            <div>
                                <span class="badge bg-light text-secondary border px-3 py-1.5 mb-3 small d-inline-block rounded-pill">
                                    <?= esc($a['jurusan'] ?? 'Informatika') ?>
                                </span>
                            </div>

                            <div class="mt-auto">
                                <hr class="my-3 opacity-25">

                                <?php if (in_array(strtolower($a['role'] ?? ''), ['admin', 'dosen'])): ?>
                                <div class="d-flex justify-content-center gap-2">
                                    <!-- Google Scholar -->
                                    <a href="<?= esc($links['scholar']) ?>" target="_blank" class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 36px; height: 36px; background-color: #4285F4; border: none; transition: transform 0.2s;" title="Google Scholar" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                        <i class="fas fa-graduation-cap fa-sm"></i>
                                    </a>
                                    
                                    <!-- Sinta -->
                                    <a href="<?= esc($links['sinta']) ?>" target="_blank" class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 36px; height: 36px; background-color: #005a9c; border: none; transition: transform 0.2s;" title="SINTA" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                        <i class="fas fa-book fa-sm"></i>
                                    </a>
                                    
                                    <!-- Scopus -->
                                    <a href="<?= esc($links['scopus']) ?>" target="_blank" class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 36px; height: 36px; background-color: #f6821f; border: none; transition: transform 0.2s;" title="Scopus" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                        <i class="fas fa-book-open fa-sm"></i>
                                    </a>
                                    
                                    <!-- ORCID -->
                                    <a href="<?= esc($links['orcid']) ?>" target="_blank" class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 36px; height: 36px; background-color: #a6ce39; border: none; transition: transform 0.2s;" title="ORCID" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                        <i class="fab fa-orcid fa-sm"></i>
                                    </a>
                                </div>
                                <?php else: ?>
                                <!-- Tampilan Asisten/Mahasiswa: WhatsApp, Email & Periode -->
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <?php 
                                    $waNumber = preg_replace('/[^0-9]/', '', $a['no_telp'] ?? '');
                                    if (strpos($waNumber, '0') === 0) {
                                        $waNumber = '62' . substr($waNumber, 1);
                                    }
                                    ?>
                                    <!-- WhatsApp -->
                                    <?php if (!empty($waNumber)): ?>
                                    <a href="https://wa.me/<?= $waNumber ?>" target="_blank" class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 36px; height: 36px; background-color: #25D366; border: none; transition: transform 0.2s;" title="WhatsApp" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                    <?php endif; ?>

                                    <!-- Email Akademik Itenas -->
                                    <a href="mailto:<?= esc($a['nomor']) ?>@mahasiswa.itenas.ac.id" class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 36px; height: 36px; background-color: #EA4335; border: none; transition: transform 0.2s;" title="Kirim Email" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                        <i class="fas fa-envelope"></i>
                                    </a>

                                    <!-- Periode Tag -->
                                    <span class="badge bg-light text-dark border rounded-pill px-3 py-2 d-inline-flex align-items-center small" style="font-weight: 500; height: 36px;">
                                        <i class="far fa-calendar-alt text-muted" style="margin-right: 6px;"></i> <?= esc($a['nama_periode'] ?? '-') ?>
                                    </span>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="card shadow-sm mt-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center ">
                      <label for="sort-filter" class="form-label me-2 mb-0">Urutkan:</label>
                      <select class="form-select form-select-sm" id="sort-filter" style="width: auto;">
                          <option value="default">Urutan Asli</option>
                          <option value="newest">Terbaru</option>
                          <option value="oldest">Terlama</option>
                      </select>
               </div>
                 <div class="d-flex align-items-center">
                    <label for="items-per-page-filter" class="form-label me-2 mb-0">Tampilkan:</label>
                    <select class="form-select form-select-sm" id="items-per-page-filter" style="width: auto;">
                        <option value="semua">Semua</option>
                        <option value="5">5</option>
                        <option value="10">10</option>
                    </select>
                </div>
            </div>
        </div>
    </div> 
<style>
.aspect-ratio-portrait {
    aspect-ratio: 3/4;
    width: 100%;
    object-fit: cover;
    object-position: top;
    background-color: #E2E8F0;
}
.role-badge {
    z-index: 2;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.card-title-height {
    min-height: 3rem;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<script>
class AdvancedFilter {
    constructor(container) {
        this.container = container;
        this.roleButtons = this.container.querySelectorAll('.filter-controls button');
        this.periodSelect = this.container.querySelector('#period-filter');
        this.sortSelect = this.container.querySelector('#sort-filter');
        this.searchInput = this.container.querySelector('#search-input');
        // Script ini akan otomatis menemukan elemen #items-per-page-filter di lokasi barunya
        this.itemsPerPageSelect = this.container.querySelector('#items-per-page-filter');
        this.itemsContainer = this.container.querySelector('.filterable-items');
        this.originalItems = Array.from(this.container.querySelectorAll('.filter-item'));
        
        this.currentRoleFilter = 'semua';
        this.currentPeriodFilter = this.periodSelect.value;
        this.currentSort = this.sortSelect.value;
        this.currentSearchTerm = '';
        this.currentItemsPerPage = this.itemsPerPageSelect.value;
        
        this.init();
    }

    init() {
        this.roleButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                this.currentRoleFilter = e.currentTarget.getAttribute('data-filter');
                this.roleButtons.forEach(btn => btn.classList.remove('active'));
                e.currentTarget.classList.add('active');
                this.applyFiltersAndSort();
            });
        });

        this.periodSelect.addEventListener('change', (e) => {
            this.currentPeriodFilter = e.currentTarget.value;
            this.applyFiltersAndSort();
        });

        this.sortSelect.addEventListener('change', (e) => {
            this.currentSort = e.currentTarget.value;
            this.applyFiltersAndSort();
        });

        this.searchInput.addEventListener('keyup', (e) => {
            this.currentSearchTerm = e.currentTarget.value.toLowerCase();
            this.applyFiltersAndSort();
        });

        this.itemsPerPageSelect.addEventListener('change', (e) => {
            this.currentItemsPerPage = e.currentTarget.value;
            this.applyFiltersAndSort();
        });

        this.applyFiltersAndSort();
    }

    applyFiltersAndSort() {
        // 1. Filter item based on all criteria
        let processedItems = this.originalItems.filter(item => {
            const roleMatch = this.currentRoleFilter === 'semua' || item.dataset.role === this.currentRoleFilter;
            const periodMatch = this.currentPeriodFilter === 'semua' || item.dataset.period === this.currentPeriodFilter;
            const itemText = item.querySelector('.card-title').textContent.toLowerCase();
            const searchMatch = itemText.includes(this.currentSearchTerm);
            return roleMatch && periodMatch && searchMatch;
        });

        // 2. Sortir item yang sudah difilter
        if (this.currentSort === 'newest') {
            processedItems.reverse(); // Membalik urutan array
        }
        
        // 3. Separate items by role for pagination
        const adminItems = processedItems.filter(item => item.dataset.role === 'admin');
        const dosenItems = processedItems.filter(item => item.dataset.role === 'dosen');
        const asistenItems = processedItems.filter(item => item.dataset.role === 'asisten');

        // 4. Apply pagination to each role separately
        const paginateItems = (items) => {
            if (this.currentItemsPerPage !== 'semua') {
                const limit = parseInt(this.currentItemsPerPage, 10);
                return items.slice(0, limit);
            }
            return items;
        };

        const paginatedAdminItems = paginateItems(adminItems);
        const paginatedDosenItems = paginateItems(dosenItems);
        const paginatedAsistenItems = paginateItems(asistenItems);

        // 5. Combine paginated items for rendering
        const combinedItems = [...paginatedAdminItems, ...paginatedDosenItems, ...paginatedAsistenItems];
        
        // 6. Render item
        this.renderItems(combinedItems);
    }
    
    renderItems(itemsToRender) {
        // ✅ PERBAIKAN XSS: Kosongkan container dengan metode aman
        this.itemsContainer.replaceChildren();

        // Tampilkan item yang sudah difilter dan diurutkan
        if (itemsToRender.length > 0) {
            if (this.currentRoleFilter === 'semua') {
                // Kelompokkan berdasarkan role
                const admins = itemsToRender.filter(item => item.dataset.role === 'admin');
                const dosens = itemsToRender.filter(item => item.dataset.role === 'dosen');
                const asistens = itemsToRender.filter(item => item.dataset.role === 'asisten');

                const renderSection = (title, iconClass, items) => {
                    if (items.length === 0) return;
                    
                    // Buat header kategori/pemisah
                    const headerCol = document.createElement('div');
                    headerCol.className = 'col-12 mt-5 mb-3 role-section-header';
                    headerCol.innerHTML = `
                        <div class="d-flex align-items-center">
                            <h5 class="fw-bold text-dark mb-0"><i class="${iconClass} me-2 text-primary"></i>${title}</h5>
                            <span class="badge bg-secondary ms-2 rounded-pill small">${items.length}</span>
                            <div class="flex-grow-1 border-bottom ms-3 opacity-25" style="border-width: 2px !important;"></div>
                        </div>
                    `;
                    this.itemsContainer.appendChild(headerCol);

                    // Tambahkan kartu anggota
                    items.forEach(item => {
                        this.itemsContainer.appendChild(item);
                    });
                };

                renderSection('Kepala Laboratorium', 'fas fa-crown text-warning', admins);
                renderSection('Dosen', 'fas fa-chalkboard-teacher text-success', dosens);
                renderSection('Asisten', 'fas fa-users-cog text-primary', asistens);
            } else {
                // Tampilkan langsung tanpa pemisah jika filter kategori aktif
                itemsToRender.forEach(item => {
                    this.itemsContainer.appendChild(item);
                });
            }
        } else {
            // ✅ PERBAIKAN XSS: Render pesan error menggunakan textContent
            const p = document.createElement('p');
            p.className = 'text-center text-muted col-12 my-5';
            p.textContent = 'Tidak ada anggota yang cocok dengan filter.';
            this.itemsContainer.appendChild(p);
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const container = document.querySelector('.filterable-container');
    if (container) {
        new AdvancedFilter(container);
    }
});
</script>