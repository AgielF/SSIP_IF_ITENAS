<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Rekrutmen' ?></title>
    
    <!-- Bootstrap dan Font Awesome akan dimuat dari layout utama Anda -->

    <!-- Custom CSS -->
    <style>
        .announcement-card .card-img-top {
            aspect-ratio: 16 / 9;
            object-fit: cover;
        }
        .status-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 0.9rem;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <!-- Header dan Filter -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <h2 class="h3">Pengumuman & Rekrutmen</h2>
        <div class="filter-buttons btn-group" role="group">
            <button type="button" class="btn btn-outline-primary active" data-filter="semua">Semua</button>
            <button type="button" class="btn btn-outline-primary" data-filter="pengumuman">Pengumuman</button>
            <button type="button" class="btn btn-outline-primary" data-filter="rekrutmen">Rekrutmen</button>
        </div>
    </div>
    <hr class="mb-4">
</div>

<!-- === SECTION PENGUMUMAN & REKRUTMEN === -->
<div class="container my-5">
    <div class="row g-4" id="announcement-list">
        
        <!-- DATA REKRUTMEN DINAMIS DARI DATABASE -->
        <?php if (!empty($rekrutmen)): ?>
            <?php foreach($rekrutmen as $item): ?>
                <div class="col-md-6 announcement-item" data-category="rekrutmen">
                    <div class="card h-100 shadow-sm announcement-card">
                        <div class="position-relative">
                             <img src="https://placehold.co/600x400/0d6efd/ffffff?text=<?= urlencode(esc($item['nama_event'])) ?>" class="card-img-top" alt="Poster Rekrutmen">
                             <?php
                                // Logika untuk menentukan warna status
                                $statusClass = ($item['status'] === 'dibuka') ? 'bg-success' : 'bg-danger';
                                $statusText = ($item['status'] === 'dibuka') ? 'Dibuka' : 'Ditutup';
                             ?>
                             <span class="status-badge badge <?= $statusClass ?>"><?= $statusText ?></span>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><i class="fas fa-bullhorn me-2"></i><?= esc($item['nama_event']) ?></h5>
                            <p class="card-text text-muted flex-grow-1">
                                <?= esc($item['deskripsi']) ?>
                            </p>
                            <p class="card-text"><strong>Syarat:</strong><br><?= esc($item['syarat']) ?></p>
                        </div>
                        <div class="card-footer bg-white border-0 pb-3">
                            <?php if($item['status'] === 'dibuka'): ?>
                                <a href="#" class="btn btn-primary w-100">Daftar Sekarang (GForm)</a>
                            <?php else: ?>
                                <a href="#" class="btn btn-outline-secondary w-100 disabled">Pendaftaran Ditutup</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- DATA PENGUMUMAN STATIS (BISA DIBUAT DINAMIS JUGA) -->
        <div class="col-md-6 announcement-item" data-category="pengumuman">
            <div class="card h-100 shadow-sm announcement-card">
                <img src="https://placehold.co/600x400/ffc107/000000?text=Maintenance" class="card-img-top" alt="Poster Maintenance">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><i class="fas fa-exclamation-triangle me-2"></i>Maintenance Sistem</h5>
                    <p class="card-text text-muted flex-grow-1">
                        Akan dilakukan maintenance pada sistem informasi laboratorium pada hari Sabtu, 2 Agustus 2025, mulai pukul 22:00 WIB.
                    </p>
                </div>
                <div class="card-footer bg-white border-0 pb-3">
                    <a href="#" class="btn btn-outline-secondary w-100 disabled">Info Selengkapnya</a>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-buttons .btn');
    const announcementItems = document.querySelectorAll('#announcement-list .announcement-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.getAttribute('data-filter');
            
            announcementItems.forEach(item => {
                if (filter === 'semua' || item.getAttribute('data-category') === filter) {
                    item.style.display = ''; // Show the item
                } else {
                    item.style.display = 'none'; // Hide the item
                }
            });
        });
    });
});
</script>

</body>
</html>
