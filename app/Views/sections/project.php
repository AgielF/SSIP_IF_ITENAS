<style>
    .repo-card {
        transition: all 0.3s ease-in-out;
        border: 1px solid #e9ecef;
        background: #fff;
    }
    .repo-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        border-color: #0d6efd;
    }
    .repo-card .card-icon {
        font-size: 2.5rem;
        color: #0d6efd;
        margin-bottom: 15px;
    }
    /* Badge status styling */
    .badge-status-selesai { background-color: #198754; }
    .badge-status-sedang { background-color: #0d6efd; }
    .badge-status-akan { background-color: #6c757d; }
</style>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 fw-bold">Etalase Proyek Lab</h2>
            <p class="text-muted">Kumpulan hasil karya, riset, dan pengembangan tools laboratorium.</p>
        </div>
    </div>
    
    <hr class="mb-4">

    <div class="card bg-light border-0 mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted">Pencarian</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Cari judul proyek...">
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted">Topik</label>
                    <select id="filterTopic" class="form-select">
                        <option value="">Semua Topik</option>
                        <option value="machine learning">Machine Learning</option>
                        <option value="iot">Internet of Things (IoT)</option>
                        <option value="data mining">Data Mining</option>
                        <option value="artificial intelligence">Artificial Intelligence</option>
                        <option value="mobile">Mobile Development</option>
                        <option value="expert system">Expert System</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted">Status</label>
                    <select id="filterStatus" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="akan dilaksanakan">Akan Dilaksanakan</option>
                        <option value="sedang dilaksanakan">Sedang Dilaksanakan</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button id="btnReset" class="btn btn-secondary w-100">
                        <i class="fas fa-sync-alt me-1"></i> Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php if (empty($projects)) : ?>
        <div class="alert alert-info text-center">
            Belum ada proyek yang dipublikasikan saat ini.
        </div>
    <?php else : ?>
        <div class="row g-4" id="projectContainer">
            <?php foreach ($projects as $proj): ?>
                <div class="col-md-4 col-sm-6 project-item" 
                     data-judul="<?= strtolower(esc($proj['judul'])) ?>" 
                     data-topik="<?= strtolower(esc($proj['topik'])) ?>" 
                     data-status="<?= strtolower(esc($proj['status'])) ?>">
                    
                    <div class="card h-100 text-center repo-card p-3">
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                <?php 
                                    $icon = 'fa-laptop-code'; // Default
                                    if($proj['topik'] == 'machine learning') $icon = 'fa-brain';
                                    if($proj['topik'] == 'iot') $icon = 'fa-wifi';
                                    if($proj['topik'] == 'mobile') $icon = 'fa-mobile-alt';
                                ?>
                                <i class="fas <?= $icon ?> card-icon"></i>
                            </div>

                            <h5 class="card-title fw-bold text-dark"><?= esc($proj['judul']) ?></h5>
                            
                            <div class="mb-3">
                                <span class="badge bg-light text-dark border"><?= esc(ucwords($proj['topik'])) ?></span>
                                <?php
                                    $badgeClass = 'badge-status-akan';
                                    if ($proj['status'] == 'sedang dilaksanakan') $badgeClass = 'badge-status-sedang';
                                    if ($proj['status'] == 'selesai') $badgeClass = 'badge-status-selesai';
                                ?>
                                <span class="badge <?= $badgeClass ?>"><?= esc(ucfirst($proj['status'])) ?></span>
                            </div>

                            <p class="card-text text-muted small flex-grow-1">
                                <?= substr(esc($proj['deskripsi']), 0, 100) ?>...
                            </p>

                            <a href="<?= base_url('project-lab/' . $proj['id_project']) ?>" class="btn btn-outline-primary w-100 mt-3">
                                <i class="fas fa-eye me-1"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div id="noResults" class="alert alert-warning text-center mt-4" style="display: none;">
            <i class="fas fa-search-minus me-2"></i> Tidak ditemukan proyek yang sesuai dengan filter Anda.
        </div>

    <?php endif; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Ambil Elemen
        const searchInput = document.getElementById('searchInput');
        const filterTopic = document.getElementById('filterTopic');
        const filterStatus = document.getElementById('filterStatus');
        const btnReset = document.getElementById('btnReset');
        const projectItems = document.querySelectorAll('.project-item');
        const noResultsMsg = document.getElementById('noResults');

        // 2. Fungsi Utama Filtering
        function filterProjects() {
            const searchValue = searchInput.value.toLowerCase().trim();
            const topicValue = filterTopic.value.toLowerCase();
            const statusValue = filterStatus.value.toLowerCase();
            
            let visibleCount = 0;

            projectItems.forEach(item => {
                // Ambil data dari atribut HTML
                const itemJudul = item.getAttribute('data-judul');
                const itemTopik = item.getAttribute('data-topik');
                const itemStatus = item.getAttribute('data-status');

                // Logika Pencocokan (AND Logic)
                // Item harus cocok dengan Search DAN Topik DAN Status
                const matchesSearch = itemJudul.includes(searchValue);
                const matchesTopic = topicValue === '' || itemTopik === topicValue;
                const matchesStatus = statusValue === '' || itemStatus === statusValue;

                if (matchesSearch && matchesTopic && matchesStatus) {
                    item.style.display = ''; // Tampilkan (reset display CSS)
                    visibleCount++;
                } else {
                    item.style.display = 'none'; // Sembunyikan
                }
            });

            // Tampilkan pesan jika tidak ada hasil
            if (visibleCount === 0) {
                noResultsMsg.style.display = 'block';
            } else {
                noResultsMsg.style.display = 'none';
            }
        }

        // 3. Pasang Event Listener
        // Jalankan fungsi filter setiap kali user mengetik atau memilih dropdown
        searchInput.addEventListener('keyup', filterProjects);
        filterTopic.addEventListener('change', filterProjects);
        filterStatus.addEventListener('change', filterProjects);

        // 4. Tombol Reset
        btnReset.addEventListener('click', function() {
            searchInput.value = '';
            filterTopic.value = '';
            filterStatus.value = '';
            filterProjects(); // Jalankan filter ulang (semua akan tampil)
        });
    });
</script>