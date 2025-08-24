<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Agenda & Acara</title>
    
    <!-- Custom CSS -->
    <style>
        .event-list-item {
            border-bottom: 1px solid #e0e0e0;
        }
        .date-box {
            width: 80px;
            flex-shrink: 0;
            text-align: center;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 10px 5px;
        }
        .date-box .day {
            font-size: 0.8rem;
            color: #6c757d;
        }
        .date-box .date {
            font-size: 2rem;
            font-weight: bold;
            color: #343a40;
        }
        .date-box .month {
            font-size: 0.9rem;
            font-weight: 500;
        }
        .filter-buttons .btn.active {
            background-color: #0d6efd;
            color: white;
        }
        .announcement-card .card-img-top {
            aspect-ratio: 16 / 9;
            object-fit: cover;
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
        <!-- Card 1: Open Recruitment -->
        <div class="col-md-6 announcement-item" data-category="rekrutmen">
            <div class="card h-100 shadow-sm announcement-card">
                <img src="https://placehold.co/600x400/0d6efd/ffffff?text=Open+Recruitment" class="card-img-top" alt="Poster Rekrutmen">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-bullhorn me-2"></i>Open Recruitment Asisten Lab</h5>
                    <p class="card-text text-muted">
                        Pendaftaran untuk rekrutmen asisten laboratorium periode 2025/2026 telah dibuka! Batas akhir pendaftaran adalah 15 Agustus 2025.
                    </p>
                </div>
                <div class="card-footer bg-white border-0 pb-3">
                    <a href="#" class="btn btn-primary w-100">Daftar Sekarang (GForm)</a>
                </div>
            </div>
        </div>
        <!-- Card 2: Maintenance -->
        <div class="col-md-6 announcement-item" data-category="pengumuman">
            <div class="card h-100 shadow-sm announcement-card">
                <img src="https://placehold.co/600x400/ffc107/000000?text=Maintenance" class="card-img-top" alt="Poster Maintenance">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-exclamation-triangle me-2"></i>Maintenance Sistem</h5>
                    <p class="card-text text-muted">
                        Akan dilakukan maintenance pada sistem informasi laboratorium pada hari Sabtu, 2 Agustus 2025, mulai pukul 22:00 WIB. Sistem mungkin tidak dapat diakses selama beberapa jam.
                    </p>
                </div>
                 <div class="card-footer bg-white border-0 pb-3">
                    <a href="#" class="btn btn-outline-secondary w-100 disabled">Info Selengkapnya</a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap & Custom JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-buttons .btn');
    // Target the announcement cards instead of event-list-item
    const announcementItems = document.querySelectorAll('#announcement-list .announcement-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.getAttribute('data-filter');
            
            announcementItems.forEach(item => {
                // Check the 'data-category' attribute
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
