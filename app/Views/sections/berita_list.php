<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agenda & Acara (Berita)</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

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

<div class="container my-5">
    <!-- Header dan Filter -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <h2 class="h3">Agenda & Acara (Berita)</h2>
    <div class="filter-buttons btn-group" role="group">
        <?php 
        $kategoriList = ['semua', 'seminar', 'workshop', 'internal']; 
        foreach ($kategoriList as $kat): 
        ?>
            <a href="?kategori=<?= $kat ?>" 
               class="btn btn-outline-primary <?= ($kategoriAktif == $kat ? 'active' : '') ?>">
                <?= ucfirst($kat) ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>

    <!-- Daftar Berita -->
    <div class="event-list">
        <?php if (!empty($schedules)): ?>
            <?php foreach ($schedules as $row): ?>
                <?php
                    $dateObj = DateTime::createFromFormat('Y-m-d', $row['tanggal']);
                    $tanggal = $dateObj ? $dateObj->format('d') : '';
                    $bulan   = $dateObj ? strtoupper($dateObj->format('M')) : '';
                    $hari    = $dateObj ? strtoupper($dateObj->format('D')) : '';
                ?>
                <div class="event-list-item d-flex align-items-start p-3" 
                     data-kategori="<?= esc(strtolower($row['kategori'])) ?>">
                    <div class="date-box me-4">
                        <div class="day"><?= esc($hari) ?></div>
                        <div class="date"><?= esc($tanggal) ?></div>
                        <div class="month"><?= esc($bulan) ?></div>
                    </div>
                    <div>
                        <h5 class="mb-1"><?= esc($row['judul']) ?></h5>
                        <p class="text-muted small mb-2">
                            <i class="far fa-clock"></i> <?= esc($row['tanggal']) ?>
                        </p>
                        <p>
                            <strong>Kategori:</strong> <?= esc($row['kategori']) ?><br>
                            <strong>Penulis:</strong> <?= esc($row['creator']) ?><br>
                            <small><?= esc(substr(strip_tags($row['konten']), 0, 100)) ?>...</small>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">Tidak ada berita tersedia.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Bootstrap & Custom JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
