<section class="py-5">
    <div class="container">
        <h2 class="text-left mb-4">Berita & Kegiatan</h2>

        <?php if (!empty($berita_list)): ?>
            <?php foreach (array_slice($berita_list, 0, 3) as $berita): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?= esc($berita['judul']) ?></h5>
                        <p class="card-text">
                            <small class="text-muted">
                                <i class="far fa-calendar"></i> <?= date('d M Y', strtotime($berita['tanggal'])) ?> |
                                <i class="far fa-user"></i> <?= esc($berita['creator']) ?>
                            </small>
                        </p>
                        <p class="card-text"><?= esc(substr(strip_tags($berita['konten']), 0, 150)) ?>...</p>
                        <a href="#" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">Tidak ada berita tersedia.</p>
        <?php endif; ?>

        <!-- Tombol Selengkapnya -->
        <div class="text-center mt-4">
            <a href="/berita" class="btn btn-primary">Selengkapnya</a>
        </div>
    </div>
</section>