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
        .video-container {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
            height: 0;
            overflow: hidden;
        }
        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .gallery-card .card-img-top {
            aspect-ratio: 16 / 9;
            object-fit: cover;
        }
    </style>
</head>
<body>



<!-- === SECTION BARU: GALERI & MEDIA === -->
<div class="container my-5">
    <?php
    // Data dummy untuk galeri
    $gallery_items = [
        ['type' => 'video', 'title' => 'Video Profil Laboratorium', 'description' => 'Pengenalan singkat tentang fasilitas dan kegiatan di lab kami.', 'url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'date' => '2025-08-15'],
        ['type' => 'foto', 'title' => 'Dokumentasi Praktikum', 'description' => 'Kegiatan praktikum mahasiswa semester genap 2024/2025.', 'url' => 'https://placehold.co/600x400/E2E8F0/334155?text=Foto+Praktikum', 'date' => '2025-07-20'],
        ['type' => 'foto', 'title' => 'Seminar AI 2025', 'description' => 'Foto bersama para pembicara di acara seminar kecerdasan buatan.', 'url' => 'https://placehold.co/600x400/334155/E2E8F0?text=Foto+Seminar', 'date' => '2025-06-10'],
    ];
    ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3">Galeri & Media</h2>
    </div>
    <hr class="mb-4">

    <!-- Kontrol Filter dan Sortir -->
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex flex-column flex-md-row justify-content-md-between align-items-start align-items-md-center gap-3">
            <div class="gallery-filter-controls btn-group btn-group-sm" role="group">
                <button type="button" class="btn btn-outline-primary active" data-filter="semua">Semua</button>
                <button type="button" class="btn btn-outline-primary" data-filter="foto">Foto</button>
                <button type="button" class="btn btn-outline-primary" data-filter="video">Video</button>
            </div>
            <div class="d-flex align-items-center">
                <label for="gallery-sort-filter" class="form-label me-2 mb-0 small text-nowrap">Urutkan:</label>
                <select class="form-select form-select-sm" id="gallery-sort-filter">
                    <option value="newest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row g-4" id="gallery-items-container">
        <?php foreach ($gallery_items as $item): ?>
            <div class="col-md-4 gallery-item" data-type="<?= esc($item['type']) ?>" data-date="<?= esc($item['date']) ?>">
                <div class="card h-100 shadow-sm gallery-card">
                    <?php if ($item['type'] === 'video'): ?>
                        <div class="video-container">
                            <iframe src="<?= esc($item['url']) ?>" title="<?= esc($item['title']) ?>" frameborder="0" allowfullscreen></iframe>
                        </div>
                    <?php else: ?>
                        <img src="<?= esc($item['url']) ?>" class="card-img-top" alt="<?= esc($item['title']) ?>">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= esc($item['title']) ?></h5>
                        <p class="card-text small text-muted"><?= esc($item['description']) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<!-- Bootstrap & Custom JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Skrip untuk filter Agenda & Acara
    const filterButtons = document.querySelectorAll('.filter-buttons .btn');
    const eventItems = document.querySelectorAll('.event-list-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            const filter = this.getAttribute('data-filter');
            eventItems.forEach(item => {
                if (filter === 'semua' || item.getAttribute('data-kategori') === filter) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

    // Skrip baru untuk filter dan sortir Galeri
    const galleryFilterButtons = document.querySelectorAll('.gallery-filter-controls button');
    const gallerySortSelect = document.getElementById('gallery-sort-filter');
    const galleryContainer = document.getElementById('gallery-items-container');
    const galleryItems = Array.from(galleryContainer.querySelectorAll('.gallery-item'));

    function updateGalleryView() {
        const currentFilter = document.querySelector('.gallery-filter-controls button.active').getAttribute('data-filter');
        const currentSort = gallerySortSelect.value;

        // 1. Filter
        const filteredItems = galleryItems.filter(item => {
            return currentFilter === 'semua' || item.getAttribute('data-type') === currentFilter;
        });

        // 2. Sortir
        filteredItems.sort((a, b) => {
            const dateA = new Date(a.getAttribute('data-date'));
            const dateB = new Date(b.getAttribute('data-date'));
            return currentSort === 'newest' ? dateB - dateA : dateA - dateB;
        });

        // 3. Render
        galleryContainer.innerHTML = ''; // Kosongkan container
        if (filteredItems.length > 0) {
            filteredItems.forEach(item => galleryContainer.appendChild(item));
        } else {
            galleryContainer.innerHTML = '<p class="text-center text-muted col-12">Tidak ada media yang cocok dengan filter.</p>';
        }
    }

    galleryFilterButtons.forEach(button => {
        button.addEventListener('click', function() {
            galleryFilterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            updateGalleryView();
        });
    });

    gallerySortSelect.addEventListener('change', updateGalleryView);
});
</script>

</body>
</html>
