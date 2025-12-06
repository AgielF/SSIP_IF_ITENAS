<!-- Section Jadwal Praktikum -->
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3">Jadwal Praktikum</h2>
        <a href="/jadwal-praktikum" class="text-decoration-none">Selengkapnya →</a>
    </div>
    <hr class="mb-4">

    <div class="row g-4">
        <?php if (!empty($schedules)): ?>
            <?php foreach (array_slice($schedules, 0, 3) as $schedule): ?>
                <!-- Item Jadwal Praktikum -->
                <div class="col-md-4">
                    <div class="d-flex align-items-start">
                        <div class="bg-primary text-white p-3 rounded me-3 text-center">
                            <div class="h3 fw-bold"><?= date('d', strtotime($schedule['date'])) ?></div>
                            <div class="small"><?= date('M', strtotime($schedule['date'])) ?></div>
                        </div>
                        <div>
                            <h5 class="mb-1"><?= esc($schedule['title']) ?></h5>
                            <p class="text-muted small"><i class="far fa-clock"></i> <?= esc($schedule['time']) ?></p>
                            <p class="text-muted small"><i class="fas fa-map-marker-alt"></i> <?= esc($schedule['lab']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-center text-muted">Tidak ada jadwal praktikum saat ini.</p>
            </div>
        <?php endif; ?>
    </div>
</div>