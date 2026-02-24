<?php helper('url'); ?>

<style>
    /* Style Kartu Topik */
    .topic-card {
        background-color: #fff;
        border-radius: 12px;
        padding: 25px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(0,0,0,0.05);
        height: 100%; /* Agar tinggi kartu sama rata */
        display: flex;
        align-items: flex-start;
        text-decoration: none; /* Hilangkan garis bawah link */
        color: inherit; /* Ikuti warna teks parent */
    }

    /* Efek Hover: Kartu miring sedikit ke kanan & naik */
    .topic-card:hover {
        transform: translateY(-5px) rotate(2deg);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15) !important;
        border-color: #0d6efd;
        z-index: 2;
        color: inherit;
    }

    /* Wrapper Ikon */
    .topic-icon-wrapper {
        transition: transform 0.4s ease;
        display: inline-block;
    }

    /* Efek Hover: Ikon miring ke kiri (berlawanan arah) & membesar */
    .topic-card:hover .topic-icon-wrapper {
        transform: rotate(-5deg) scale(1.2);
    }
    
    /* Agar judul berubah warna saat hover (opsional) */
    .topic-card:hover h4 {
        color: #0d6efd;
        transition: color 0.3s ease;
    }
</style>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 fw-bold">Field of Study and Topic Coverage</h2>
    </div>
    <hr class="mb-4">
    
    <div class="row g-4"> <?php if (!empty($fields)): ?>
            <?php foreach ($fields as $field): ?>
                <div class="col-md-4">
                    <a href="/topic_detail/<?= url_title($field['title'], '-', true) ?>" class="text-decoration-none text-dark h-100 d-block" style="font-size: 1.2rem;">
                        
                        <div class="topic-card shadow-sm">
                            
                            <div class="me-4 mt-1 topic-icon-wrapper text-center" style="min-width: 50px;">
                                <i class="fas <?= esc($field['icon']) ?> fa-2x text-primary"></i>
                            </div>
                            
                            <div>
                                <h4 class="h5 fw-bold mb-2"><?= esc($field['title']) ?></h4>
                                <p class="text-secondary small mb-0" style="line-height: 1.6; font-size:1.2rem ;">
                                    <?= esc($field['description']) ?>
                                </p>
                            </div>
                            
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-light text-center py-4 text-muted">
                    <i class="fas fa-info-circle me-2"></i>Tidak ada data topik untuk ditampilkan.
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>