<style>
    /* Style Kartu Berita (Mirip dengan Jadwal) */
    .news-card {
        background-color: #fff;
        border-radius: 12px;
        padding: 20px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(0,0,0,0.05);
        height: 100%; /* Agar tinggi kartu sama rata */
        display: flex;
        flex-direction: column;
    }

    /* Efek Hover: Kartu miring sedikit ke kanan & naik */
    .news-card:hover {
        transform: translateY(-5px) rotate(2deg);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15) !important;
        border-color: #0d6efd;
        z-index: 2;
    }

    /* Style untuk Kotak Tanggal Berita */
    .news-date-box {
        min-width: 60px;
        height: 60px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        border-radius: 8px;
        transition: transform 0.4s ease;
    }

    /* Efek Hover: Kotak tanggal miring ke kiri (berlawanan arah) */
    .news-card:hover .news-date-box {
        transform: rotate(-5deg) scale(1.1);
    }

    /* Membatasi jumlah baris teks deskripsi (agar kartu rapi) */
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 fw-bold text-left">Berita & Kegiatan</h2>
            <a href="/berita" class="text-decoration-none fw-bold">Lihat Semua →</a>
        </div>
        <hr class="mb-4">

        <div class="row g-4">
            <?php if (!empty($berita_list)): ?>
                <?php foreach (array_slice($berita_list, 0, 3) as $berita): ?>
                    <div class="col-md-4">
                        <div class="news-card shadow-sm position-relative">
                            
                            <div class="d-flex align-items-start mb-3">
                                <div class="news-date-box bg-primary text-white me-3 flex-shrink-0">
                                    <span class="fw-bold h4 mb-0"><?= date('d', strtotime($berita['tanggal'])) ?></span>
                                    <span class="small text-uppercase" style="font-size: 0.7rem;"><?= date('M', strtotime($berita['tanggal'])) ?></span>
                                </div>
                                
                                <div>
                                    <h5 class="card-title fw-bold text-dark mb-1" style="font-size: 1.2rem;">
                                        <?= esc($berita['judul']) ?>
                                    </h5>
                                    <small class="text-muted" style="font-size: 1.1rem">
                                        <i class="far fa-user me-1"></i> <?= esc($berita['creator']) ?>
                                    </small>
                                </div>
                            </div>

                            <div class="flex-grow-1">
                                <p class="card-text text-secondary line-clamp-3 mb-3" style="font-size: 1.1rem;">
                                    <?= esc(substr(strip_tags($berita['konten']), 0, 150)) ?>...
                                </p>
                            </div>

                            <div class="mt-auto pt-3 border-top">
                                
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-light text-center py-5" role="alert">
                        <i class="fas fa-newspaper fa-2x mb-3 text-muted"></i>
                        <p class="text-muted mb-0">Tidak ada berita tersedia saat ini.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>


    </div>
</section>