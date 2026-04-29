<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<style>
    *, *::before, *::after { 
        box-sizing: border-box; 
    }

    .org-chart { padding: 30px 0; }
    .level { display: flex; justify-content: center; align-items: stretch; gap : 20px; margin: 30px 0; position: relative; flex-wrap: wrap; }
    .person-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        margin: 15px;
        width: 260px;
        height: 180px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        min-width: 220px; max-width: 280px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 2px solid transparent;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    .person-card:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.15); text-decoration: none; color: inherit; border-color: #006994 !important; }
    .person-card .person-name:hover, .person-card .person-role:hover { color: inherit; }
    .person-card::after { content: ''; position: absolute; bottom: 10px; right: 10px; width: 20px; height: 20px; background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23006994'%3E%3Cpath d='M14,3V5H17.59L7.76,14.83L9.17,16.24L19,6.41V10H21V3M19,19H5V5H12V3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V12H19V19Z'/%3E%3C/svg%3E") no-repeat center; background-size: contain; opacity: 0.6; }
    .person-card.kepala-lab { border-color: #ffd700; background: linear-gradient(135deg, #fff8dc, #f0e68c); }
    .person-card.dosen-lab { border-color: #3498db; background: linear-gradient(135deg, #e8f4fd, #b8d4e3); }
    .person-card.asisten-lab { border-color: #27ae60; background: linear-gradient(135deg, #e8f5e8, #c8e6c9); }
    .person-name { 
        font-size: 16px; 
        font-weight: bold; 
        margin-bottom: 8px; 
        color: #333; 
        text-align: center;
        line-height: 1.3;
        width: 100%;
        white-space: normal; 
        text-overflow: ellipsis;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .person-role { font-size: 14px; color: #666; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; }
    .person-icon { font-size: 48px; margin-bottom: 15px; }
    .person-avatar img { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; margin-bottom: 15px; }
    .person-card.kepala-lab .person-icon { color: #b8860b; }
    .person-card.dosen-lab .person-icon { color: #2980b9; }
    .person-card.asisten-lab .person-icon { color: #27ae60; }
    .connector { width: 3px; height: 40px; background: linear-gradient(135deg, #E6F3FF 0%, #b8d4e3 100%); position: relative; border-radius: 2px; }
    .connector::before { content: ''; position: absolute; top: -8px; left: -8px; width: 18px; height: 18px; background: linear-gradient(135deg, #E6F3FF 0%, #b8d4e3 100%); border-radius: 50%; border: 2px solid #006994; }
    .horizontal-line { position: absolute; top: 50%; left: 50%; transform: translateX(-50%); width: calc(100% - 60px); height: 3px; background: linear-gradient(135deg, #E6F3FF 0%, #b8d4e3 100%); border-radius: 2px; }
    .level-2 .horizontal-line { width: calc(100% - 80px); }
    .level-3 .horizontal-line { display: none; }
    .level-title { text-align: center; margin: 40px 0 20px 0; font-size: 28px; font-weight: bold; color: #006994; position: relative; }
    .level-title::after { content: ''; position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 80px; height: 3px; background: linear-gradient(135deg, #E6F3FF 0%, #b8d4e3 100%); border-radius: 2px; }
    .stats-section { background: linear-gradient(135deg, #f0f8ff 0%, #e6f3ff 100%); border-radius: 15px; padding: 30px; margin: 30px 0; border: 2px solid #E6F3FF; }
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; margin-top: 20px; }
    .stat-card { background: white; border-radius: 12px; padding: 20px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #E6F3FF; transition: transform 0.3s ease; }
    .stat-card:hover { transform: translateY(-2px); }
    .stat-number { font-size: 32px; font-weight: bold; color: #006994; display: block; margin-bottom: 5px; }
    .stat-label { font-size: 14px; color: #666; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; }
    .page-title { 
        text-align: center; 
        margin-bottom: 40px; 
        color: #006994; }
    .page-title h1 { 
        font-size: 36px;
        font-weight: bold;
        margin-bottom: 10px; }
    .page-title p { 
        font-size: 18px; 
        color: #666; }
    @media (max-width: 768px) {
        .level { flex-direction: column; }
        .person-card { margin: 15px 0; width: 280px; }
        .horizontal-line { display: none; }
        .level-title { font-size: 24px; }
        .stats-grid { grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); }
    }

    /* --- STYLE TAMBAHAN UNTUK NAVIGASI PAGINATION --- */
    .pagination-nav {
        display: flex;
        justify-content: center;
        gap: 5px;
        margin-top: 20px;
        margin-bottom: 40px;
    }
    .page-btn {
        border: 1px solid #006994;
        background: white;
        color: #006994;
        padding: 5px 12px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .page-btn.active {
        background: #006994;
        color: white;
    }
    .page-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        background: #f0f0f0;
        border-color: #ccc;
        color: #999;
    }
    .page-info {
        text-align: center;
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 10px;
    }
</style>

<div class="org-chart">
    <div class="page-title">
        <h1><i class="fas fa-sitemap me-3"></i>Struktur Organisasi</h1>
        <p>Laboratorium SSIP Informatika - Institut Teknologi Nasional Bandung</p>
    </div>

    <div class="stats-section">
        <h3 class="text-center mb-4" style="color: #006994;">
            <i class="fas fa-chart-bar me-2"></i>Statistik Keanggotaan
        </h3>
        <div class="stats-grid">
            <div class="stat-card">
                <span class="stat-number"><?= count($kepalaLab ?? []) ?></span>
                <span class="stat-label">Kepala Lab</span>
            </div>
            <div class="stat-card">
                <span class="stat-number"><?= count($dosenLab ?? []) ?></span>
                <span class="stat-label">Dosen Lab</span>
            </div>
            <div class="stat-card">
                <span class="stat-number"><?= count($asistenLab ?? []) ?></span>
                <span class="stat-label">Asisten Lab</span>
            </div>
            <div class="stat-card">
                <span class="stat-number"><?= (count($kepalaLab ?? []) + count($dosenLab ?? []) + count($asistenLab ?? [])) ?></span>
                <span class="stat-label">Total Anggota</span>
            </div>
        </div>
    </div>

    <div class="level-title">
        <i class="fas fa-crown me-2"></i>Kepala Laboratorium
    </div>
    <div class="level">
        <?php if (!empty($kepalaLab)): ?>
            <?php foreach ($kepalaLab as $person): ?>
                <a href="/asisten/<?= esc($person['id']) ?>" class="person-card kepala-lab searchable" data-name="<?= strtolower(esc($person['nama'])) ?>">
                    <div class="person-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="person-name"><?= esc($person['nama']) ?></div>
                    <div class="person-role">Kepala Lab</div>
                    <small class="text-muted mt-2 d-block">
                        <i class="fas fa-id-badge me-1"></i><?= esc($person['nomor']) ?>
                    </small>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="person-card kepala-lab">
                <div class="person-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="person-name">Belum Ditentukan</div>
                <div class="person-role">Kepala Lab</div>
            </div>
        <?php endif; ?>
    </div>

    <div class="connector"></div>

    <div class="level-title">
        <i class="fas fa-chalkboard-teacher me-2"></i>Dosen Laboratorium
    </div>
    <div class="level level-2" style="position: relative;">
        <div class="horizontal-line"></div>
        <?php if (!empty($dosenLab)): ?>
            <?php foreach ($dosenLab as $person): ?>
                <a href="/asisten/<?= esc($person['id']) ?>" class="person-card dosen-lab searchable" data-name="<?= strtolower(esc($person['nama'])) ?>">
                    <div class="person-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="person-name"><?= esc($person['nama']) ?></div>
                    <div class="person-role">Dosen Lab</div>
                    <small class="text-muted mt-2 d-block">
                        <i class="fas fa-id-badge me-1"></i><?= esc($person['nomor']) ?>
                    </small>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="person-card dosen-lab">
                <div class="person-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="person-name">Belum Ada Dosen</div>
                <div class="person-role">Dosen Lab</div>
            </div>
        <?php endif; ?>
    </div>

    <div class="connector"></div>

    <div class="container mt-4 mb-4" style="max-width: 900px;">
        <div class="card border-0 shadow-sm" style="background: #f8fbff;">
            <div class="card-body p-3">
                <div class="row align-items-center g-3">
                    <div class="col-md-7">
                        <div class="input-group">
                            <span class="input-group-text bg-white text-primary border-end-0">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Cari nama anggota (Dosen/Asisten)...">
                        </div>
                    </div>
                    <div class="col-md-5 text-md-end">
                        <div class="d-flex align-items-center justify-content-md-end">
                            <label for="rowsPerPage" class="me-2 text-muted small fw-bold mb-0">Tampilkan:</label>
                            <select id="rowsPerPage" class="form-select form-select-sm w-auto" style="min-width: 80px;">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="all">Semua</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="level-title">
        <i class="fas fa-users me-2"></i>Asisten Laboratorium
    </div>
    
    <div class="level level-3" id="asistenContainer" style="position: relative;">
        <div class="horizontal-line"></div>
        <?php if (!empty($asistenLab)): ?>
            <?php foreach ($asistenLab as $person): ?>
                <a href="/asisten/<?= esc($person['id']) ?>" 
                   class="person-card asisten-lab searchable asisten-item" 
                   data-name="<?= strtolower(esc($person['nama'])) ?>">
                    
                    <div class="person-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="person-name"><?= esc($person['nama']) ?></div>
                    <div class="person-role">Asisten Lab</div>
                    <small class="text-muted mt-2 d-block">
                        <i class="fas fa-id-badge me-1"></i><?= esc($person['nomor']) ?>
                    </small>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="person-card asisten-lab">
                <div class="person-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="person-name">Belum Ada Asisten</div>
                <div class="person-role">Asisten Lab</div>
            </div>
        <?php endif; ?>
    </div>

    <div id="paginationNavContainer" class="container">
        <div id="pageInfo" class="page-info"></div>
        <div id="paginationControls" class="pagination-nav"></div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const rowsPerPageSelect = document.getElementById('rowsPerPage');
        const asistenItems = document.querySelectorAll('.asisten-item'); // Items to paginate
        const allSearchableItems = document.querySelectorAll('.searchable'); // All items for search
        const paginationContainer = document.getElementById('paginationNavContainer');
        const pageInfo = document.getElementById('pageInfo');
        const paginationControls = document.getElementById('paginationControls');

        let currentPage = 1;
        let rowsPerPage = 5; // Default setting

        // --- 1. FUNGSI RENDER PAGINATION (Hanya untuk Asisten) ---
        function renderPagination() {
            const totalItems = asistenItems.length;
            const totalPages = Math.ceil(totalItems / rowsPerPage);
            
            // Validasi current page
            if (currentPage > totalPages) currentPage = totalPages;
            if (currentPage < 1) currentPage = 1;

            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            // Sembunyikan semua asisten dulu
            asistenItems.forEach(item => item.style.display = 'none');

            // Tampilkan asisten sesuai halaman aktif
            // Tapi cek dulu apakah mode "all"
            if (rowsPerPageSelect.value === 'all') {
                asistenItems.forEach(item => item.style.display = 'flex');
                pageInfo.innerText = `Menampilkan semua ${totalItems} Asisten`;
                paginationControls.innerHTML = ''; // Hapus tombol navigasi
                return;
            }

            // Loop range halaman
            for (let i = start; i < end && i < totalItems; i++) {
                asistenItems[i].style.display = 'flex';
            }

            // Update Info Text
            pageInfo.innerText = `Menampilkan ${start + 1} - ${Math.min(end, totalItems)} dari ${totalItems} Asisten`;

            // Render Tombol (Prev, Angka, Next)
            renderPaginationButtons(totalPages);
        }

        function renderPaginationButtons(totalPages) {
            paginationControls.innerHTML = '';

            if (totalPages <= 1) return;

            // Prev Button
            const prevBtn = document.createElement('button');
            prevBtn.className = 'page-btn';
            prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
            prevBtn.disabled = currentPage === 1;
            prevBtn.addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    renderPagination();
                }
            });
            paginationControls.appendChild(prevBtn);

            // Number Buttons
            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement('button');
                btn.className = `page-btn ${i === currentPage ? 'active' : ''}`;
                btn.innerText = i;
                btn.addEventListener('click', () => {
                    currentPage = i;
                    renderPagination();
                });
                paginationControls.appendChild(btn);
            }

            // Next Button
            const nextBtn = document.createElement('button');
            nextBtn.className = 'page-btn';
            nextBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
            nextBtn.disabled = currentPage === totalPages;
            nextBtn.addEventListener('click', () => {
                if (currentPage < totalPages) {
                    currentPage++;
                    renderPagination();
                }
            });
            paginationControls.appendChild(nextBtn);
        }

        // --- 2. EVENT LISTENER: DROPDOWN CHANGE ---
        rowsPerPageSelect.addEventListener('change', function() {
            if (this.value === 'all') {
                rowsPerPage = asistenItems.length;
            } else {
                rowsPerPage = parseInt(this.value);
            }
            currentPage = 1; // Reset ke halaman 1
            renderPagination();
        });

        // --- 3. EVENT LISTENER: SEARCH FUNCTION ---
        searchInput.addEventListener('keyup', function(e) {
            const term = e.target.value.toLowerCase();

            if (term.length > 0) {
                // --- MODE SEARCHING AKTIF ---
                
                // 1. Matikan Paginasi Kontrol
                paginationContainer.style.display = 'none';
                rowsPerPageSelect.disabled = true;

                // 2. Loop semua searchable item (Kepala, Dosen, Asisten)
                allSearchableItems.forEach(item => {
                    const name = item.getAttribute('data-name');
                    if (name.includes(term)) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });

            } else {
                // --- SEARCH KOSONG (RESET KE NORMAL) ---
                
                // 1. Nyalakan Paginasi Kontrol
                paginationContainer.style.display = 'block';
                rowsPerPageSelect.disabled = false;

                // 2. Tampilkan kembali Kepala & Dosen (karena mereka bukan bagian dari paginasi asisten)
                allSearchableItems.forEach(item => {
                    if (!item.classList.contains('asisten-item')) {
                        item.style.display = 'flex';
                    }
                });

                // 3. Render ulang paginasi asisten sesuai halaman terakhir
                renderPagination();
            }
        });

        // Init pertama kali load
        renderPagination();
    });
</script>

<?= $this->endSection() ?>