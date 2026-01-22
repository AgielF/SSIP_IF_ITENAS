<style>
    /* Style untuk Kartu Jadwal */
    .schedule-card {
        background-color: #fff; /* Pastikan background putih */
        border-radius: 12px;
        padding: 20px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); /* Efek membal yang halus */
        border: 1px solid rgba(0,0,0,0.05); /* Border tipis */
        position: relative;
        overflow: hidden;
    }

    /* Efek saat Mouse Hover pada Card */
    .schedule-card:hover {
        transform: translateY(-5px) rotate(2deg); /* Naik sedikit dan miring 2 derajat */
        box-shadow: 0 15px 30px rgba(0,0,0,0.15) !important; /* Bayangan makin nyata */
        border-color: #0d6efd; /* Opsional: Border berubah jadi biru */
        z-index: 2; /* Agar kartu tampil di atas elemen lain */
    }

    /* Style untuk Kotak Tanggal (Sub-card) */
    .date-box {
        transition: transform 0.4s ease;
    }

    /* Efek: Saat Card di-hover, Kotak Tanggal ikut berotasi tapi berlawanan arah (biar keren) */
    .schedule-card:hover .date-box {
        transform: rotate(-5deg) scale(1.1); /* Miring berlawanan dan membesar dikit */
    }
</style>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 fw-bold">Jadwal Praktikum</h2>
        <a href="/jadwal-praktikum" class="text-decoration-none fw-bold">Selengkapnya →</a>
    </div>
    <hr class="mb-4">

    <div class="row g-4">
        <?php if (!empty($schedules)): ?>
            <?php foreach (array_slice($schedules, 0, 3) as $schedule): ?>
                <div class="col-md-4">
                    <div class="schedule-card shadow-sm h-100 d-flex align-items-start">
                        
                        <div class="date-box bg-primary text-white p-3 rounded me-3 text-center flex-shrink-0" style="min-width: 70px;">
                            <div class="h3 fw-bold mb-0"><?= date('d', strtotime($schedule['date'])) ?></div>
                            <div class="small text-uppercase"><?= date('M', strtotime($schedule['date'])) ?></div>
                        </div>
                        
                        <div class="flex-grow-1">
                            <h5 class="mb-2 fw-bold text-dark"><?= esc($schedule['title']) ?></h5>
                            <p class="text-muted small mb-1">
                                <i class="far fa-clock text-primary me-1"></i> <?= esc($schedule['time']) ?>
                            </p>
                            <p class="text-muted small mb-0">
                                <i class="fas fa-map-marker-alt text-danger me-1"></i> <?= esc($schedule['lab']) ?>
                            </p>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-light text-center" role="alert">
                    <i class="fas fa-calendar-times fa-2x mb-3 text-muted"></i>
                    <p class="text-muted mb-0">Tidak ada jadwal praktikum saat ini.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>