<?= $this->include('layout/header') ?>

<?= $this->include('sections/slider') ?>

<main>
    <div class="container my-5">
        <h1 class="mb-4">Agenda Laboratorium</h1>

        <p class="mb-4">Daftar agenda dan jadwal kegiatan laboratorium</p>

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
                <h4 class="h5 mb-3"><?= esc($fieldName) ?></h4>
                <div class="row g-4">
                    <?php
                    $fieldSchedules = array_filter($schedules, function($schedule) use ($fieldKey) {
                        return stripos($schedule['title'], $fieldKey) !== false;
                    });
                    ?>
                    <?php if (!empty($fieldSchedules)): ?>
                        <?php foreach ($fieldSchedules as $schedule): ?>
                            <!-- Item Agenda -->
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start">
                                            <div class="bg-primary text-white p-3 rounded me-3 text-center">
                                                <div class="h5 fw-bold"><?= date('d', strtotime($schedule['date'])) ?></div>
                                                <div class="small"><?= date('M', strtotime($schedule['date'])) ?></div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h5 class="card-title mb-1"><?= esc($schedule['title']) ?></h5>
                                                <p class="card-text text-muted small mb-2">
                                                    <i class="far fa-clock"></i> <?= esc($schedule['time']) ?><br>
                                                    <i class="fas fa-map-marker-alt"></i> <?= esc($schedule['lab']) ?><br>
                                                    <i class="fas fa-user"></i> <?= esc($schedule['instructor']) ?>
                                                </p>
                                                <span class="badge bg-<?= esc($schedule['status_color']) ?>"><?= esc($schedule['status']) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <p class="text-center text-muted">Tidak ada agenda untuk <?= esc($fieldName) ?>.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?= $this->include('layout/footer') ?>