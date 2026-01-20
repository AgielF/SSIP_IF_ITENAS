<?php
// Ambil data user dari session
$user = session('user');

// Mapping role_id ke nama role
$roles = [
    1 => 'Admin',
    2 => 'Asisten',
    3 => 'Mahasiswa',
    4 => 'Dosen',
];

$roleName = $roles[$user['role_id']] ?? 'Anggota';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>

    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container my-5">

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">

            <!-- Header + Logout -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">
                    <i class="fas fa-user-circle me-2 text-primary"></i>Profil Pengguna
                </h4>

                <a href="<?= base_url('logout') ?>"
                   class="btn btn-outline-danger btn-sm"
                   onclick="return confirm('Yakin ingin logout?')">
                    <i class="fas fa-right-from-bracket me-1"></i> Logout
                </a>
            </div>

            <div class="row align-items-center">
                <!-- Avatar -->
                <div class="col-md-3 text-center mb-3 mb-md-0">
                    <img
                        src="https://placehold.co/150x150/E2E8F0/334155?text=<?= urlencode(esc($user['nama'])) ?>"
                        class="rounded-circle shadow-sm border"
                        alt="Foto <?= esc($user['nama']) ?>"
                    >
                </div>

                <!-- Informasi User -->
                <div class="col-md-9">
                    <h5 class="mb-1"><?= esc($user['nama']) ?></h5>

                    <p class="text-muted mb-1">
                        <i class="fas fa-user-tag me-2 text-primary"></i>
                        <?= esc($roleName) ?>
                    </p>

                    <p class="text-muted mb-2">
                        <i class="fas fa-id-badge me-2"></i>
                        <?= esc($user['nomor']) ?>
                    </p>

                    <?php if ($roleName === 'Dosen'): ?>
                        <!-- Khusus Dosen -->
                        <h6 class="mt-3 mb-2">
                            <i class="fas fa-brain me-2 text-primary"></i>
                            Keahlian Dosen
                        </h6>

                        <div class="mb-3">
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3">Machine Learning</span>
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3">Data Mining</span>
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3">Artificial Intelligence</span>
                        </div>
                    <?php else: ?>
                        <!-- Selain Dosen -->
                        <p class="text-muted">
                            <i class="fas fa-graduation-cap me-2"></i>
                            <?= esc($user['jurusan'] ?? 'Anggota Laboratorium') ?>
                        </p>
                    <?php endif; ?>

                    <!-- Platform Penelitian -->
                    <h6 class="mt-3 mb-2">
                        <i class="fas fa-link me-2 text-primary"></i>
                        Platform Penelitian
                    </h6>

                    <div class="d-flex gap-3 fs-5">
                        <a href="#" class="text-dark" title="Google Scholar">
                            <i class="fas fa-graduation-cap"></i>
                        </a>
                        <a href="#" class="text-dark" title="SINTA">
                            <i class="fas fa-book"></i>
                        </a>
                        <a href="#" class="text-dark" title="GitHub">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="#" class="text-dark" title="LinkedIn">
                            <i class="fab fa-linkedin"></i>
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>

</body>
</html>
