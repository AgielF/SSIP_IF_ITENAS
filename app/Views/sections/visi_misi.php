<!-- Section Visi & Misi (Minimalist & Modern) -->
<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold display-6 mb-2">Visi & Misi</h2>
        <p class="text-muted mb-0">Panduan arah dan tujuan kami</p>
    </div>

    <div class="row g-4 align-items-stretch">
        <!-- Kolom Visi -->
        <div class="col-md-6">
            <div class="p-4 bg-white rounded-4 shadow-sm text-center h-100">
                <div class="mb-3">
                    <i class="fas fa-eye fa-2x text-primary"></i>
                </div>
                <h3 class="fw-semibold mb-3">Visi</h3>
                <p class="lead text-muted fst-italic mb-0">
                    <?= esc($visi) ?>
                </p>
            </div>
        </div>

        <!-- Kolom Misi -->
        <div class="col-md-6 d-flex">
            <div class="p-4 bg-white rounded-4 shadow-sm text-center flex-fill d-flex flex-column justify-content-center text-center">
                <div class="text-center mb-3">
                    <i class="fas fa-bullseye fa-2x text-primary"></i>
                    <h3 class="fw-semibold mt-2">Misi</h3>
                </div>

                <ul class="list-unstyled m-0 flex-grow-1">
                    <?php foreach (explode("\n", $misi) as $misi_item): ?>
                    <li class="d-flex align-items-start mb-3">
                        <div class="me-3 mt-1 text-primary">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <span class="text-muted"><?= esc($misi_item) ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Tambahan CSS -->
<style>
    body {
        background-color: #f8f9fa;
    }

    .card-hover:hover {
        transform: translateY(-5px);
        transition: 0.3s ease;
        border-radius: 100%;
    }

    .list-unstyled li {
        transition: background-color 0.2s ease;
        justify-content: center;
        padding: 0.25rem 0;
    }

    .list-unstyled li:hover {
        background-color: #f1f5f9;
        border-radius: 8px;
    }
    .bg-white {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .bg-white:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

</style>
