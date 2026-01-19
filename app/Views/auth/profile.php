<?php
// Mapping role_id ke nama role
$roles = [
    1 => 'Admin',
    2 => 'Asisten',
    3 => 'Mahasiswa',
    4 => 'Dosen',
];
$user = session('user');
$roleName = $user && isset($roles[$user['role_id']]) ? $roles[$user['role_id']] : 'Tidak diketahui';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php
// Mapping role_id → nama role
$roles = [
    1 => 'Admin',
    2 => 'Asisten',
    3 => 'Mahasiswa',
    4 => 'Dosen'
];

// Ambil role dari user
$userRole = $roles[$user['role_id']] ?? 'Anggota';
?>

<div class="container my-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <!-- Avatar -->
                <div class="col-md-3 text-center mb-3 mb-md-0">
                    <img src="https://placehold.co/150x150/E2E8F0/334155?text=<?= urlencode(esc($user['nama'])) ?>"
                         class="rounded-circle shadow-sm border profile-avatar"
                         alt="Foto <?= esc($user['nama']) ?>">
                </div>

                <!-- Info Utama -->
                <div class="col-md-9">
                    <h2 class="h4 mb-1"><?= esc($user['nama']) ?></h2>

                    <!-- Role / Jabatan -->
                    <p class="text-muted mb-1">
                        <i class="fas fa-user-tag me-2 text-primary"></i><?= esc($userRole) ?>
                    </p>
                    <p class="text-muted small mb-3">
                        <i class="fas fa-id-badge me-2"></i><?= esc($user['nomor']) ?>
                    </p>

                    <!-- Kondisi khusus: jika role Dosen -->
                    <?php if ($userRole === 'Dosen'): ?>
                        <h5 class="h6 mt-3 mb-2"><i class="fas fa-brain me-2 text-primary"></i>Keahlian Dosen:</h5>
                        <div class="mb-3">
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3">Machine Learning</span>
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3">Data Mining</span>
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3">Artificial Intelligence</span>
                        </div>
                    <?php else: ?>
                        <!-- Jika bukan dosen, tampilkan jurusan -->
                        <p class="text-muted"><?= esc($user['jurusan'] ?? 'Anggota Laboratorium') ?></p>
                    <?php endif; ?>

                    <!-- Platform Penelitian -->
                    <h5 class="h6 mt-3 mb-2"><i class="fas fa-link me-2 text-primary"></i>Platform Penelitian:</h5>
                    <div class="d-flex gap-3 fs-5">
                        <a href="#" class="text-dark" title="Google Scholar"><i class="fas fa-graduation-cap"></i></a>
                        <a href="#" class="text-dark" title="SINTA"><i class="fas fa-book"></i></a>
                        <a href="#" class="text-dark" title="GitHub"><i class="fab fa-github"></i></a>
                        <a href="#" class="text-dark" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>
