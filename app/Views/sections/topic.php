<?php
// Memuat helper untuk membuat URL-friendly slug
helper('url');
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
                    <!-- SETIAP ITEM SEKARANG ADALAH LINK -->
                    <a href="/topic_detail/<?= url_title($field['title'], '-', true) ?>" class="text-decoration-none text-dark">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="fas <?= esc($field['icon']) ?> fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h4 class="h5"><?= esc($field['title']) ?></h4>
                                <p class="text-muted small">
                                    <?= esc($field['description']) ?>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Tidak ada data untuk ditampilkan.</p>
        <?php endif; ?>

    </div>
</div>
