<?= $this->include('layout/header') ?>
<?= $this->include('sections/slider') ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'Profile') ?></title>
    <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/vendor/fontawesome/css/all.min.css') ?>" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container my-5">

    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">
                    <i class="fas fa-user-circle me-2 text-primary"></i>Profil Saya
                </h4>
                
                <form action="<?= base_url('logout') ?>" method="POST" class="d-inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Yakin ingin logout?')">
                        <i class="fas fa-right-from-bracket me-1"></i> Logout
                    </button>
                </form>
            </div>

            <div class="row align-items-center">
                <div class="col-md-3 text-center mb-3 mb-md-0">
                    <?php if (!empty($user['foto'])): ?>
                        <img src="<?= base_url(esc($user['foto'])) ?>"
                             class="rounded-circle shadow-sm border"
                             alt="Foto <?= esc($user['nama']) ?>"
                             style="width: 150px; height: 150px; object-fit: cover;"
                             onerror="this.src='https://placehold.co/150x150/E2E8F0/334155?text=<?= urlencode(esc($user['nama'])) ?>'">
                    <?php else: ?>
                        <img src="https://placehold.co/150x150/E2E8F0/334155?text=<?= urlencode(esc($user['nama'])) ?>"
                             class="rounded-circle shadow-sm border"
                             alt="Foto <?= esc($user['nama']) ?>"
                             style="width: 150px; height: 150px; object-fit: cover;">
                    <?php endif; ?>
                </div>

                <div class="col-md-9">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h5 class="mb-0"><?= esc($user['nama']) ?></h5>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                            <i class="fas fa-edit me-1"></i> Edit Profil
                        </button>
                    </div>

                    <p class="text-muted mb-1">
                        <i class="fas fa-user-tag me-2 text-primary"></i><?= esc($user['role_id_label'] ?? 'Anggota') ?>
                    </p>
                    <p class="text-muted mb-2">
                        <i class="fas fa-id-badge me-2"></i><?= esc($user['nomor'] ?? '-') ?>
                    </p>

                    <?php 
                        $roleIdNum = (int)($user['role_id'] ?? 0);
                        if ($roleIdNum === 1 || $roleIdNum === 3):
                    ?>
                        <h6 class="mt-3 mb-2"><i class="fas fa-link me-2 text-primary"></i>Platform Penelitian</h6>
                        <div class="d-flex gap-3 fs-5">
                            <?php if (!empty($user['google_scholar'])): ?>
                                <a href="<?= esc($user['google_scholar']) ?>" class="text-dark" title="Google Scholar" target="_blank"><i class="fas fa-graduation-cap"></i></a>
                            <?php endif; ?>
                            <?php if (!empty($user['sinta'])): ?>
                                <a href="<?= esc($user['sinta']) ?>" class="text-dark" title="SINTA" target="_blank"><i class="fas fa-book"></i></a>
                            <?php endif; ?>
                            <?php if (!empty($user['orcid'])): ?>
                                <a href="<?= esc($user['orcid']) ?>" class="text-dark" title="ORCID" target="_blank"><i class="fab fa-orcid"></i></a>
                            <?php endif; ?>
                            <?php if (!empty($user['scopus'])): ?>
                                <a href="<?= esc($user['scopus']) ?>" class="text-dark" title="Scopus" target="_blank"><i class="fas fa-university"></i></a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (in_array(strtolower($user['role_id'] ?? ''), ['admin', 'dosen', '1', '3'])): ?>
                        <h6 class="mt-3 mb-2"><i class="fas fa-link me-2 text-primary"></i>Platform Penelitian</h6>
                        <div class="d-flex gap-3 fs-5">
                            <?php if (!empty($user['scholar_url'])): ?>
                                <a href="<?= esc($user['scholar_url']) ?>" target="_blank" class="text-dark" title="Google Scholar"><i class="fas fa-graduation-cap"></i></a>
                            <?php endif; ?>
                            <?php if (!empty($user['sinta_url'])): ?>
                                <a href="<?= esc($user['sinta_url']) ?>" target="_blank" class="text-dark" title="SINTA"><i class="fas fa-book"></i></a>
                            <?php endif; ?>
                            <?php if (!empty($user['scopus_url'])): ?>
                                <a href="<?= esc($user['scopus_url']) ?>" target="_blank" class="text-dark" title="Scopus"><i class="fas fa-book-open"></i></a>
                            <?php endif; ?>
                            <?php if (!empty($user['orcid_url'])): ?>
                                <a href="<?= esc($user['orcid_url']) ?>" target="_blank" class="text-dark" title="ORCID"><i class="fab fa-orcid"></i></a>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <h6 class="mt-3 mb-2"><i class="fas fa-link me-2 text-primary"></i>Hubungi Kontak</h6>
                        <div class="d-flex gap-3 fs-5">
                            <?php 
                            $waNumber = preg_replace('/[^0-9]/', '', $user['no_telp'] ?? '');
                            if (strpos($waNumber, '0') === 0) {
                                $waNumber = '62' . substr($waNumber, 1);
                            }
                            ?>
                            <?php if (!empty($waNumber)): ?>
                                <a href="https://wa.me/<?= $waNumber ?>" target="_blank" class="text-success" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                            <?php endif; ?>
                            <a href="mailto:<?= esc($user['nomor']) ?>@mahasiswa.itenas.ac.id" class="text-secondary" title="Email"><i class="fas fa-envelope"></i></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-header bg-white p-4 border-bottom-0">
                    <h5 class="mb-0"><i class="fas fa-book-open text-primary me-2"></i>Publikasi Ilmiah Saya</h5>
                </div>
                <div class="card-body px-4 pb-4 pt-0">
                    <?php if (empty($publicationData)): ?>
                        <div class="alert alert-light text-muted border text-center">
                            Belum ada publikasi tercatat.
                        </div>
                    <?php else: ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($publicationData as $pub): ?>
                                <li class="list-group-item px-0 py-3">
                                    <h6 class="mb-1 text-dark fw-bold"><?= esc($pub['judul'] ?? '-') ?></h6>
                                    
                                    <div class="mb-2 text-muted small">
                                        <?php if(!empty($pub['jenis_publikasi'])): ?>
                                            <span class="badge bg-secondary me-1 text-uppercase"><?= esc($pub['jenis_publikasi']) ?></span>
                                        <?php endif; ?>
                                        <?php if(!empty($pub['kategori'])): ?>
                                            <span class="badge bg-info text-dark me-2"><?= esc($pub['kategori']) ?></span>
                                        <?php endif; ?>
                                        
                                        <span class="me-2"><i class="far fa-calendar-alt me-1"></i><?= esc($pub['tahun'] ?? '-') ?></span>
                                    </div>
                                    
                                    <div class="mb-2 text-muted small">
                                        <span><i class="fas fa-users me-1"></i> 
                                            <strong>Utama:</strong> <?= esc($pub['penulis_utama'] ?? $user['nama']) ?> 
                                            <?php if(!empty($pub['penulis_pendamping'])): ?>
                                                | <strong>Pendamping:</strong> <?= esc($pub['penulis_pendamping']) ?>
                                            <?php endif; ?>
                                        </span>
                                    </div>

                                    <p class="mb-2 text-muted small"><?= esc($pub['deskripsi'] ?? 'Tidak ada deskripsi.') ?></p>
                                    
                                    <div class="d-flex gap-2 mt-2">
                                        <?php if (!empty($pub['link_publikasi'])): ?>
                                            <a href="<?= esc($pub['link_publikasi']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-external-link-alt me-1"></i> Jurnal
                                            </a>
                                        <?php endif; ?>
                                        <?php if (!empty($pub['link_doi'])): ?>
                                            <a href="<?= esc($pub['link_doi']) ?>" target="_blank" class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-link me-1"></i> DOI
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-header bg-white p-4 border-bottom-0">
                    <h5 class="mb-0"><i class="fas fa-flask text-success me-2"></i>Proyek Riset Saya</h5>
                </div>
                <div class="card-body px-4 pb-4 pt-0">
                    <?php 
                    // Cek ketersediaan data (jika di controller nama variabelnya $proyekData atau $proyekRiset)
                    $dataProyek = $proyekData ?? $proyekRiset ?? []; 
                    if (empty($dataProyek)): 
                    ?>
                        <div class="alert alert-light text-muted border text-center">
                            Belum ada proyek riset tercatat.
                        </div>
                    <?php else: ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($dataProyek as $proyek): ?>
                                <li class="list-group-item px-0 py-3">
                                    <h6 class="mb-1 text-dark fw-bold"><?= esc($proyek['judul'] ?? '-') ?></h6>
                                    
                                    <div class="mb-2 mt-2 text-muted small">
                                        <?php 
                                            // Menentukan warna badge status
                                            $statusProyek = strtolower($proyek['status'] ?? '');
                                            $badgeClass = 'bg-secondary-subtle text-secondary'; // Default
                                            
                                            if (strpos($statusProyek, 'sedang') !== false) {
                                                $badgeClass = 'bg-primary-subtle text-primary border-primary-subtle border';
                                            } elseif (strpos($statusProyek, 'akan') !== false) {
                                                $badgeClass = 'bg-warning-subtle text-warning border-warning-subtle border';
                                            } elseif (strpos($statusProyek, 'selesai') !== false) {
                                                $badgeClass = 'bg-success-subtle text-success border-success-subtle border';
                                            }
                                        ?>
                                        <span class="badge <?= $badgeClass ?> me-2 text-uppercase">
                                            <?= esc($proyek['status'] ?? 'Draft') ?>
                                        </span>
                                        
                                        <span class="me-2">
                                            <i class="far fa-clock me-1"></i> 
                                            <?= esc($proyek['tahun_mulai'] ?? '-') ?> - <?= esc($proyek['tahun_selesai'] ?? 'Selesai') ?>
                                        </span>
                                    </div>

                                    <div class="mb-2 text-muted small">
                                        <?php if(!empty($proyek['mitra'])): ?>
                                            <span class="me-3"><i class="fas fa-handshake me-1"></i> <?= esc($proyek['mitra']) ?></span>
                                        <?php endif; ?>
                                        <?php if(!empty($proyek['sumber_dana'])): ?>
                                            <span><i class="fas fa-coins me-1"></i> <?= esc($proyek['sumber_dana']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <p class="mb-0 text-muted small"><?= esc($proyek['deskripsi'] ?? 'Tidak ada deskripsi.') ?></p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- Modal Edit Profil -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('profile/update') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="foto" class="form-label"><i class="fas fa-camera me-1"></i> Foto Profil</label>
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG, WEBP. Maks: 2MB.</small>
                    </div>
                    <?php 
                    $roleIdNumEdit = (int)($user['role_id'] ?? 0);
                    if ($roleIdNumEdit === 1 || $roleIdNumEdit === 3): ?>
                        <hr>
                        <h6>Tautan Penelitian</h6>
                        <div class="mb-3">
                            <label for="google_scholar" class="form-label"><i class="fas fa-graduation-cap me-1"></i> Google Scholar</label>
                            <input type="url" class="form-control" id="google_scholar" name="google_scholar" value="<?= esc($user['google_scholar'] ?? '') ?>" placeholder="https://scholar.google.com/...">
                        </div>
                        <div class="mb-3">
                            <label for="sinta" class="form-label"><i class="fas fa-book me-1"></i> SINTA</label>
                            <input type="url" class="form-control" id="sinta" name="sinta" value="<?= esc($user['sinta'] ?? '') ?>" placeholder="https://sinta.kemdikbud.go.id/...">
                        </div>
                        <div class="mb-3">
                            <label for="orcid" class="form-label"><i class="fab fa-orcid me-1"></i> ORCID</label>
                            <input type="url" class="form-control" id="orcid" name="orcid" value="<?= esc($user['orcid'] ?? '') ?>" placeholder="https://orcid.org/...">
                        </div>
                        <div class="mb-3">
                            <label for="scopus" class="form-label"><i class="fas fa-university me-1"></i> Scopus</label>
                            <input type="url" class="form-control" id="scopus" name="scopus" value="<?= esc($user['scopus'] ?? '') ?>" placeholder="https://www.scopus.com/...">
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
<?= $this->include('layout/footer') ?>