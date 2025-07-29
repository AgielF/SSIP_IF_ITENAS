<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Agenda & Acara</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

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
    </style>
</head>
<body>


<!-- === SECTION BARU: GALERI & MEDIA === -->
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3">Galeri & Media</h2>
    </div>
    <hr class="mb-4">
    <div class="row g-4">
        <!-- Card 1: Video -->
        <!-- <div class="col-md-4">
            <div class="card h-100 shadow-sm gallery-card">
                <div class="video-container">
                    <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Video Profil Laboratorium</h5>
                </div>
            </div>
        </div> -->
        <!-- Card 2: Foto -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm gallery-card">
                <img src="https://placehold.co/600x400/E2E8F0/334155?text=Foto+Kegiatan+1" class="card-img-top" alt="Foto Kegiatan 1">
                <div class="card-body">
                    <h5 class="card-title">Dokumentasi Praktikum</h5>
                </div>
            </div>
        </div>
        <!-- Card 3: Foto -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm gallery-card">
                <img src="https://placehold.co/600x400/E2E8F0/334155?text=Foto+Kegiatan+2" class="card-img-top" alt="Foto Kegiatan 2">
                <div class="card-body">
                    <h5 class="card-title">Seminar AI 2025</h5>
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
    const eventItems = document.querySelectorAll('.event-list-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            const filter = this.getAttribute('data-filter');

            eventItems.forEach(item => {
                // CATATAN: Logika filter ini mungkin tidak berfungsi seperti yang diharapkan
                // karena data-kategori berisi 'upcoming', 'completed', dll.
                if (filter === 'semua' || item.getAttribute('data-kategori') === filter) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});
</script>

</body>
</html>
