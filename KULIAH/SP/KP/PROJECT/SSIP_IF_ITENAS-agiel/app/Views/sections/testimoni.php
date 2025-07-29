<?php
// Data sekarang didefinisikan langsung di dalam file view ini.
$fields = [
    [
        'title' => 'Machine Learning',
        'description' => 'Supervised & unsupervised learning, evaluation models, ensemble models.',
        'icon' => 'fa-brain' // Ikon untuk Machine Learning
    ],
    [
        'title' => 'Data Mining',
        'description' => 'Clustering, classification, association, anomalies.',
        'icon' => 'fa-database' // Ikon untuk Data Mining
    ],
    [
        'title' => 'Deep Learning',
        'description' => 'Deep Learning for NLP, Deep Learning for Image & Visual, and Time Series & Signal.',
        'icon' => 'fa-layer-group' // Ikon untuk Deep Learning
    ],
    [
        'title' => 'Artificial Intelligence',
        'description' => 'Fuzzy logic, symbolic AI, heuristics, intelligent agents.',
        'icon' => 'fa-robot' // Ikon untuk AI
    ],
    [
        'title' => 'Expert Systems',
        'description' => 'Rule-based systems, inference engines, knowledge bases.',
        'icon' => 'fa-cogs' // Ikon untuk Expert Systems
    ],
    [
        'title' => 'Smart Systems',
        'description' => 'Predictive systems, recommendation systems, adaptive systems.',
        'icon' => 'fa-lightbulb' // Ikon untuk Smart Systems
    ],
];
?>

<!-- Section Field of Study -->
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3">Field of Study and Topic Coverage</h2>
    </div>
    <hr class="mb-4">
    <div class="row g-5">
        
        <?php if (!empty($fields)): ?>
            <?php foreach ($fields as $field): ?>
                <div class="col-md-4">
                    <div class="d-flex">
                        <div class="me-3">
                            <!-- Ikon sekarang dinamis berdasarkan data dari array di atas -->
                            <i class="fas <?= esc($field['icon']) ?> fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h4 class="h5"><?= esc($field['title']) ?></h4>
                            <p class="text-muted small">
                                <?= esc($field['description']) ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Tidak ada data untuk ditampilkan.</p>
        <?php endif; ?>

    </div>
</div>
