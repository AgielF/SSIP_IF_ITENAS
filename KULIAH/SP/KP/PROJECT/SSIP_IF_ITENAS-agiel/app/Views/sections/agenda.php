<!-- Section Agenda -->
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3">Agenda & Acara</h2>
        <a href="/agenda" class="text-decoration-none">Selengkapnya →</a>
    </div>
    <hr class="mb-4">

    <div class="row g-4">
        <?php if (!empty($schedules)): ?>
            <?php foreach ($schedules as $schedule): ?>
                <!-- Item Agenda Dinamis -->
                <div class="col-md-4">
                    <div class="d-flex align-items-start">
                        <div class="bg-primary text-white p-3 rounded me-3 text-center">
                            <div class="h3 fw-bold"><?= esc($schedule['date']) ?></div>
                            
                        </div>
                        <div>
                            <h5 class="mb-1"><?= esc($schedule['title']) ?></h5>
                            <p class="text-muted small"><i class="far fa-clock"></i> <?= esc($schedule['time']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-center">Tidak ada agenda atau acara mendatang.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
