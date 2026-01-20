<?php
$fields = [
    'Machine Learning' => 'Machine Learning',
    'Data Mining' => 'Data Mining',
    'Deep Learning' => 'Deep Learning',
    'Artificial Intelligence' => 'Artificial Intelligence',
    'Expert Systems' => 'Expert Systems',
    'Smart Systems' => 'Smart Systems'
];
?>

<?php foreach ($fields as $fieldKey => $fieldName): ?>
    <div class="mb-5">
        <h4 class="h5 mb-3 border-bottom pb-2">
            <i class="fas fa-brain me-2"></i>
            <?= esc($fieldName) ?>
        </h4>
        <div class="row">
            <?php
            $fieldSchedules = array_filter($schedules, function($schedule) use ($fieldKey) {
                return stripos($schedule['title'], $fieldKey) !== false;
            });
            ?>
            <?php if (!empty($fieldSchedules)): ?>
                <?php foreach ($fieldSchedules as $schedule): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-calendar-check me-2"></i>
                                    <?= esc($schedule['title']) ?>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <span class="badge bg-<?= esc($schedule['status_color']) ?> mb-2">
                                        <i class="fas fa-clock me-1"></i>
                                        <?= esc($schedule['status']) ?>
                                    </span>
                                </div>

                                <div class="row g-2">
                                    <div class="col-12">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-day me-1"></i>
                                            <?= esc($schedule['date']) ?>
                                        </small>
                                    </div>
                                    <div class="col-12">
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            <?= esc($schedule['time']) ?>
                                        </small>
                                    </div>
                                    <div class="col-12">
                                        <small class="text-muted">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            Ruangan: <?= esc($schedule['lab']) ?>
                                        </small>
                                    </div>
                                    <div class="col-12">
                                        <small class="text-muted">
                                            <i class="fas fa-user-graduate me-1"></i>
                                            Asisten: <?= esc($schedule['assistants']) ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-light">
                                <small class="text-muted">
                                    ID Jadwal: #<?= esc($schedule['id_jadwal']) ?>
                                </small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-light text-center border">
                        <i class="fas fa-info-circle fa-lg mb-2 text-muted"></i>
                        <p class="mb-0 text-muted">Tidak ada jadwal untuk <?= esc($fieldName) ?>.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>