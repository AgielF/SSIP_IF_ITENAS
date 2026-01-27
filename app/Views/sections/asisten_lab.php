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
                            <option value="2023/2024">2023/2024</option>
                            <option value="2022/2023" selected>2022/2023</option>
                            <option value="2021/2022">2021/2022</option>
                        </select>
                    </div>
                    </div>
            </div> 
        </div>

        <div class="row g-4 filterable-items">
            <?php if (!empty($asisten)): ?>
                <?php foreach ($asisten as $i => $a): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 filter-item" data-role="<?= esc(strtolower($a['role'] ?? '')) ?>" data-period="2022/2023">
                    <!-- Debug: Role value is <?= esc($a['role'] ?? 'N/A') ?> -->
                    <div class="card h-100 shadow-sm">
                        <div class="position-relative">
                            <div class="role-badge bg-primary text-white py-1 px-2 rounded position-absolute top-0 end-0 m-2 small">
                                <?= $a['role'] === 'admin' ? 'Kepala Laboratorium' : ucfirst(esc($a['role'] ?? '')) ?>
                            </div>
                            <?php if (!empty($a['foto'])): ?>
                                <img src="/<?= esc($a['foto']) ?>" class="card-img-top aspect-ratio-1x1" alt="Foto <?= esc($a['nama']) ?>" onerror="this.src='https://placehold.co/400x600/E2E8F0/334155?text=<?= urlencode(esc($a['nama'])) ?>'">
                            <?php else: ?>
                                <img src="https://placehold.co/400x600/E2E8F0/334155?text=<?= urlencode(esc($a['nama'])) ?>" class="card-img-top aspect-ratio-1x1" alt="Foto <?= esc($a['nama']) ?>">
                            <?php endif; ?>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title mb-1">
                                <a href="<?= base_url('asisten/' . $a['id']) ?>" class="text-decoration-none text-dark">
                                    <?= esc($a['nama']) ?>
                                </a>
                            </h5>
                            <p class="card-text text-muted small mb-2">
                                <?= esc($a['jurusan'] ?? 'Jurusan tidak tersedia') ?>
                            </p>
                            <p class="card-text text-muted small mb-3">
                                <?= esc($a['nomor'] ?? 'N/A') ?>
                            </p>
                             <p class="card-text text-muted small mb-3">
                                2023/2024
                            </p>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="#" class="btn btn-primary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="fab fa-facebook-f fa-sm"></i>
                                </a>
                                <a href="#" class="btn btn-success btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="fab fa-whatsapp fa-sm"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="fab fa-google-plus-g fa-sm"></i>
                                </a>
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
.aspect-ratio-1x1 {
    aspect-ratio: 1/1;
    width: 100%;
    object-fit: cover;
}
.role-badge {
    z-index: 2;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
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
        // Kosongkan container
        this.itemsContainer.innerHTML = '';

        // Tampilkan item yang sudah difilter dan diurutkan
        if (itemsToRender.length > 0) {
            itemsToRender.forEach(item => {
                this.itemsContainer.appendChild(item);
            });
        } else {
            this.itemsContainer.innerHTML = '<p class="text-center text-muted">Tidak ada anggota yang cocok dengan filter.</p>';
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