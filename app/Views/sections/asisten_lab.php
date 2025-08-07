<!-- Section Asisten Lab -->
<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="h3">ANGGOTA LAB. SSIP 2022/2023</h2>
        <hr class="w-50 mx-auto">
    </div>

    <div class="d-flex flex-wrap justify-content-center align-items-center mb-4">
        <div class="filter-buttons btn-group" role="group">
            <button type="button" class="btn btn-outline-primary active" data-filter="semua">Semua</button>
            <button type="button" class="btn btn-outline-primary" data-filter="asisten">Asisten</button>
            <button type="button" class="btn btn-outline-primary" data-filter="dosen">Dosen</button>
            <button type="button" class="btn btn-outline-primary" data-filter="praktikan">Praktikan</button>
        </div>
    </div>

    <div class="row g-4" id="asisten-list">
        <?php foreach ($asisten as $a): ?>
        <div class="col-lg-3 col-md-4 col-sm-6 col-12 asisten-item" data-role="<?= esc(strtolower($a['role'] ?? 'asisten')) ?>">
            <div class="card h-100 shadow-sm">
                <div class="position-relative">
                    <div class="role-badge bg-primary text-white py-1 px-2 rounded position-absolute top-0 end-0 m-2 small">
                        <?= ucfirst(esc($a['role'] ?? 'asisten')) ?>
                    </div>
                    <img src="<?= base_url('uploads/foto/' . (!empty($a['foto']) ? $a['foto'] : 'default.png')) ?>"
                         class="card-img-top aspect-ratio-1x1"
                         alt="Foto <?= esc($a['nama']) ?>"
                         style="object-fit: cover; height: 200px;">
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title mb-1"><?= esc($a['nama']) ?></h5>
                    <p class="card-text text-muted small mb-2">
                        <?php 
                        $jurusan = esc($a['jurusan'] ?? '');
                        echo !empty($jurusan) ? $jurusan : 'Jurusan tidak tersedia';
                        ?>
                    </p>
                    <p class="card-text text-muted small mb-3">
                        <?php 
                        $nomor = esc($a['nomor'] ?? '');
                        echo !empty($nomor) ? $nomor : 'N/A';
                        ?>
                    </p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="<?= esc($a['facebook'] ?? '#') ?>" class="btn btn-primary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                            <i class="fab fa-facebook-f fa-sm"></i>
                        </a>
                        <a href="<?= esc($a['whatsapp'] ?? '#') ?>" class="btn btn-success btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                            <i class="fab fa-whatsapp fa-sm"></i>
                        </a>
                        <a href="<?= esc($a['google'] ?? '#') ?>" class="btn btn-danger btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                            <i class="fab fa-google-plus-g fa-sm"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
.aspect-ratio-1x1 {
    aspect-ratio: 1/1;
    width: 100%;
    object-fit: cover;
}

.role-badge {
    z-index: 2;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
</style>

<script>
document.querySelectorAll('.filter-buttons button').forEach(function(btn) {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.filter-buttons button').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        let filter = btn.getAttribute('data-filter');
        document.querySelectorAll('.asisten-item').forEach(function(item) {
            if (filter === 'semua' || item.getAttribute('data-role') === filter) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });
});
</script>