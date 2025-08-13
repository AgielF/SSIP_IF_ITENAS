<?php
// Data dummy, seharusnya diambil dari database
$repositories = [
    [
        'title' => 'Kode Sumber Proyek SSIP',
        'description' => 'Repositori utama untuk pengembangan Sistem Informasi Laboratorium.',
        'link' => '#',
        'icon' => 'fab fa-github',
        'category' => 'Kode Sumber'
    ],
    [
        'title' => 'Dataset Praktikum Fisika',
        'description' => 'Kumpulan data hasil praktikum dari tahun 2020-2024.',
        'link' => '#',
        'icon' => 'fas fa-database',
        'category' => 'Dataset'
    ],
    [
        'title' => 'Tools Analisis Spektrum',
        'description' => 'Software buatan lab untuk analisis data spektrum optik.',
        'link' => '#',
        'icon' => 'fas fa-tools',
        'category' => 'Tools'
    ]
];
?>
<style>
    .repo-card {
        transition: all 0.3s ease-in-out;
        border: 1px solid #e9ecef;
    }
    .repo-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        border-color: #0d6efd;
    }
    .repo-card .card-icon {
        font-size: 2rem;
        color: #0d6efd;
    }
</style>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3">Repositori Proyek</h2>
    </div>
    <hr class="mb-4">
    <div class="row g-4">
        <?php foreach ($repositories as $repo): ?>
            <div class="col-md-4">
                <div class="card h-100 text-center repo-card">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="card-icon <?= esc($repo['icon']) ?>"></i>
                        </div>
                        <h5 class="card-title"><?= esc($repo['title']) ?></h5>
                        <p class="card-text text-muted small"><?= esc($repo['description']) ?></p>
                        <a href="<?= esc($repo['link']) ?>" class="btn btn-outline-primary mt-auto">Kunjungi</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
