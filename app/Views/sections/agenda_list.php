<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Agenda & Acara</title>
    
    <!-- Bootstrap CSS -->
   
    
    <!-- Font Awesome untuk Ikon -->
    

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

<div class="container my-5">
    <!-- Header dan Filter -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <h2 class="h3">Agenda & Acara</h2>
        <div class="filter-buttons btn-group" role="group">
            <button type="button" class="btn btn-outline-primary active" data-filter="semua">Semua</button>
            <button type="button" class="btn btn-outline-primary" data-filter="praktikum">Praktikum</button>
            <button type="button" class="btn btn-outline-primary" data-filter="seminar">Seminar</button>
            <button type="button" class="btn btn-outline-primary" data-filter="lomba">Lomba</button>
        </div>
    </div>

    <!-- Daftar Acara -->
    <div class="event-list">
        <?php if (!empty($schedules)): ?>
            <?php foreach ($schedules as $schedule): ?>
                <?php
                    // Logika untuk memecah tanggal dari format "Monday, 28 July 2025"
                    $dateObj = DateTime::createFromFormat('l, d F Y', $schedule['date']);
                    $tanggal = $dateObj ? $dateObj->format('d') : '';
                    $bulan = $dateObj ? strtoupper($dateObj->format('M')) : '';
                    $hari = $dateObj ? strtoupper(substr($schedule['date'], 0, 3)) : '';
                ?>
                <!-- 
                    CATATAN: data-kategori di bawah ini tidak akan cocok dengan filter di atas
                    karena controller mengirim 'status' (e.g., Upcoming) bukan 'jenis' (e.g., praktikum).
                    Ini perlu disesuaikan di controller jika filter ingin berfungsi.
                -->
                <div class="event-list-item d-flex align-items-start p-3" data-kategori="<?= esc(strtolower($schedule['status'])) ?>">
                    <!-- Kotak Tanggal di Kiri -->
                    <div class="date-box me-4">
                        <div class="day"><?= esc($hari) ?></div>
                        <div class="date"><?= esc($tanggal) ?></div>
                        <div class="month"><?= esc($bulan) ?></div>
                    </div>
                    <!-- Detail Acara di Kanan -->
                    <div>
                        <h5 class="mb-1"><?= esc($schedule['title']) ?></h5>
                        <p class="text-muted small mb-2">
                            <i class="far fa-clock"></i> <?= esc($schedule['time']) ?>
                        </p>
                        <!-- Menampilkan Dosen dan Ruangan sebagai deskripsi -->
                        <p>
                            <strong>Dosen/Instruktur:</strong> <?= esc($schedule['instructor']) ?><br>
                            <strong>Ruangan:</strong> <?= esc($schedule['lab']) ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">Tidak ada acara yang tersedia.</p>
        <?php endif; ?>
    </div>
</div>

<!-- === SECTION BARU: KEGIATAN INTERNAL === -->
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3">Kegiatan Internal</h2>
    </div>
    <hr class="mb-4">
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm mb-3">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-users fa-2x text-primary me-4"></i>
                    <div>
                        <h5 class="card-title">Lab Meeting Rutin</h5>
                        <p class="card-text">Setiap hari Jumat, pukul 16:00. Pembahasan progres riset dan proyek.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm mb-3">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-industry fa-2x text-success me-4"></i>
                    <div>
                        <h5 class="card-title">Kunjungan Industri ke PT. Telkom</h5>
                        <p class="card-text">Akan dilaksanakan pada bulan September 2025. Pendaftaran akan segera dibuka.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Bootstrap & Custom JS -->

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
