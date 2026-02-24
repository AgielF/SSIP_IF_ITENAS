<style>
    /* Wrapper Kartu Visi Misi */
    .vm-card {
        background-color: #fff;
        border-radius: 20px; /* Radius lebih membulat agar modern */
        padding: 40px;
        height: 100%;
        position: relative;
        overflow: hidden; /* Untuk memotong dekorasi background */
        border: 1px solid rgba(0,0,0,0.03); /* Border sangat tipis */
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        display: flex;
        flex-direction: column;
    }

    /* Efek Hover 3D Halus (Konsisten dengan section lain) */
    .vm-card:hover {
        transform: translateY(-10px) rotateX(2deg) rotateY(2deg); /* Miring sedikit */
        box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
        border-color: rgba(13, 110, 253, 0.3); /* Border biru tipis saat hover */
        z-index: 2;
    }

    /* Ikon Utama di atas */
    .vm-icon-box {
        width: 70px;
        height: 70px;
        background: rgba(13, 110, 253, 0.1); /* Biru transparan */
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px auto;
        transition: transform 0.4s ease;
    }

    .vm-card:hover .vm-icon-box {
        transform: scale(1.1) rotate(-10deg); /* Ikon berputar sedikit saat hover */
        background: rgba(13, 110, 253, 0.2);
    }

    /* Dekorasi Background (Quote Mark Besar) untuk Visi */
    .bg-decor-quote {
        position: absolute;
        top: 20px;
        left: 20px;
        font-size: 10rem;
        color: rgba(0,0,0,0.03);
        font-family: serif;
        line-height: 0;
        pointer-events: none;
        z-index: 0;
    }

    /* Styling List Misi */
    .misi-list li {
        padding: 12px 15px;
        margin-bottom: 8px;
        border-radius: 10px;
        transition: all 0.3s ease;
        border-left: 3px solid transparent; /* Garis indikator kiri */
    }

    .misi-list li:hover {
        background-color: #f8f9fa;
        border-left: 3px solid #0d6efd; /* Muncul garis biru saat hover item */
        transform: translateX(5px); /* Geser sedikit ke kanan */
    }
</style>

<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold display-6 mb-2">Visi & Misi</h2>
        <div style="width: 60px; height: 3px; background: #0d6efd; margin: 0 auto;"></div> <p class="text-muted mt-3">Panduan arah strategis dan tujuan operasional laboratorium kami.</p>
    </div>

    <div class="row g-4 align-items-stretch">
        
        <div class="col-md-5">
            <div class="vm-card shadow-sm text-center justify-content-center">
                <div class="bg-decor-quote">“</div>
                
                <div class="position-relative" style="z-index: 1;">
                    <div class="vm-icon-box text-primary">
                        <i class="fas fa-eye fa-2x"></i>
                    </div>
                    
                    <h3 class="fw-bold mb-4">Visi Kami</h3>
                    
                    <p class="lead fst-italic text-dark mb-0" style="font-size: 1.25rem; line-height: 1.8;">
                        "<?= esc($visi) ?>"
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="vm-card shadow-sm">
                <div class="text-center mb-2">
                    <div class="vm-icon-box text-primary">
                        <i class="fas fa-rocket fa-2x"></i> </div>
                    <h3 class="fw-bold mb-4">Misi Kami</h3>
                </div>

                <ul class="list-unstyled misi-list m-0 text-start">
                    <?php foreach (explode("\n", $misi) as $index => $misi_item): ?>
                    <li class="d-flex align-items-start mb-2">
                        <div class="me-3 fw-bold text-primary" style="min-width: 25px; font-size: 1.2rem;">
                            0<?= $index + 1 ?>.
                        </div>
                        
                        <span class="text-secondary" style="line-height: 1.6; font-size: 1.2rem;">
                            <?= esc($misi_item) ?>
                        </span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

    </div>
</div>