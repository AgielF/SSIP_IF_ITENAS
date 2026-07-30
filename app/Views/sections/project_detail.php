<link rel="stylesheet" href="<?= base_url('assets/vendor/fontawesome/css/all.min.css') ?>">

<div class="container my-5">

    <!-- BACK BUTTON -->
    <a href="<?= base_url('project-lab') ?>" class="btn btn-light mb-4 border">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Proyek
    </a>

    <div class="row">

        <!-- ================= LEFT CONTENT ================= -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">

                    <!-- TITLE & STATUS -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h1 class="h4 fw-bold text-primary mb-0">
                            <?= esc($project['judul']) ?>
                        </h1>

                        <?php if ($project['status'] === 'selesai'): ?>
                            <span class="badge bg-success rounded-pill px-3">Selesai</span>
                        <?php elseif ($project['status'] === 'sedang dilaksanakan'): ?>
                            <span class="badge bg-primary rounded-pill px-3">Sedang Berjalan</span>
                        <?php else: ?>
                            <span class="badge bg-secondary rounded-pill px-3">Akan Dilaksanakan</span>
                        <?php endif; ?>
                    </div>

                    <!-- META INFO -->
                    <div class="mb-4 text-muted small">
                        <span class="me-3">
                            <i class="far fa-calendar me-1"></i>
                            Mulai: <?= date('d M Y', strtotime($project['tanggal_mulai'])) ?>
                        </span>
                        <span>
                            <i class="fas fa-tag me-1"></i>
                            <?= esc(ucwords($project['topik'])) ?>
                        </span>
                    </div>

                    <!-- DESCRIPTION -->
                    <h6 class="fw-bold border-bottom pb-2 mb-3">Deskripsi Proyek</h6>
                    <p class="text-secondary" style="line-height:1.8">
                        <?= nl2br(esc($project['deskripsi'])) ?>
                    </p>

                    <!-- TECHNOLOGY -->
                    <h6 class="fw-bold border-bottom pb-2 mb-3 mt-4">Teknologi yang Digunakan</h6>
                    <div>
                        <?php
                        $techs = array_filter(array_map('trim', explode(',', $project['teknologi'] ?? '')));
                        ?>
                        <?php if (empty($techs)): ?>
                            <span class="text-muted small">Tidak ada data teknologi</span>
                        <?php else: ?>
                            <?php foreach ($techs as $tech): ?>
                                <span class="badge bg-secondary me-1 mb-1 p-2">
                                    <?= esc($tech) ?>
                                </span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>

        <!-- ================= RIGHT SIDEBAR ================= -->
        <div class="col-lg-4">

            <!-- TEAM CARD -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-bold py-3">
                    <i class="fas fa-users me-2 text-primary"></i> Tim Pengembang
                </div>

                <ul class="list-group list-group-flush">

                    <!-- LEADER -->
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold"><?= esc($project['nama_ketua']) ?></div>
                            <small class="text-muted">Ketua / Penanggung Jawab</small>
                        </div>
                        <i class="fas fa-crown text-warning"></i>
                    </li>

                    <!-- MEMBERS -->
                    <?php if (!empty($members)): ?>
                        <?php foreach ($members as $m): ?>
                            <li class="list-group-item">
                                <div class="fw-bold"><?= esc($m['nama']) ?></div>
                                <small class="text-muted">
                                    <?= esc($m['role_project'] ?? 'Anggota') ?>
                                </small>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="list-group-item text-muted small">
                            Belum ada anggota tambahan.
                        </li>
                    <?php endif; ?>

                </ul>
            </div>

            <!-- LINKS CARD -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Tautan Proyek</h6>

                    <?php if (!empty($project['link_repository'])): ?>
                        <a href="<?= esc($project['link_repository']) ?>" target="_blank"
                           class="btn btn-dark w-100 mb-2">
                            <i class="fab fa-github me-2"></i> Repository
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($project['link_deploy'])): ?>
                        <a href="<?= esc($project['link_deploy']) ?>" target="_blank"
                           class="btn btn-primary w-100">
                            <i class="fas fa-external-link-alt me-2"></i> Live Demo
                        </a>
                    <?php endif; ?>

                    <?php if (empty($project['link_repository']) && empty($project['link_deploy'])): ?>
                        <p class="text-muted small text-center mb-0">
                            Tidak ada tautan tersedia
                        </p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>
