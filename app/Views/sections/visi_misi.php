<!-- Section Visi & Misi -->
<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="h3">Visi & Misi</h2>
        <hr class="w-25 mx-auto">
    </div>

    <div class="row g-5 align-items-center">
        <!-- Kolom Visi -->
        <div class="col-md-6">
            <div class="text-center">
                <i class="fas fa-eye fa-3x text-primary mb-3"></i>
                <h3 class="h4">Visi</h3>
                <p class="lead fst-italic">
                    <?= esc($visi) ?>
                </p>
            </div>
        </div>

        <!-- Kolom Misi -->
        <div class="col-md-6">
            <div class="text-center">
                <i class="fas fa-bullseye fa-3x text-primary mb-3"></i>
                <h3 class="h4">Misi</h3>
            </div>
            <ul class="list-group list-group-flush">
                <?php foreach (explode("\n", $misi) as $misi_item): ?>
                <li class="list-group-item border-0">
                    <i class="fas fa-check-circle text-success me-2"></i>
                    <?= esc($misi_item) ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
?>