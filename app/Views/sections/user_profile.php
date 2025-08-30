<style>
    .profile-card {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    .profile-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid #e9ecef;
    }
    .platform-links a {
        color: #6c757d;
        font-size: 1.5rem;
        transition: color 0.2s;
    }
    .platform-links a:hover {
        color: #0d6efd;
    }
    .nav-tabs .nav-link.active {
        background-color: #f8f9fa;
        border-bottom: 2px solid #0d6efd;
        color: #0d6efd;
    }
    .table thead th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
</style>

<div class="container my-5">
    <div class="profile-card mb-4">
        <div class="row align-items-center">
            <div class="col-md-3 text-center">
                <img src="https://placehold.co/150x150/E2E8F0/334155?text=<?= urlencode(esc($user['nama'])) ?>" class="profile-avatar" alt="Foto <?= esc($user['nama']) ?>">
            </div>
            <div class="col-md-9">
                <h2 class="h3 mb-1"><?= esc($user['nama']) ?></h2>
                <p class="text-muted">Kepala Laboratorium SSIP</p> <p class="text-muted small"><?= esc($user['nomor']) ?></p> <h5 class="h6 mt-4">Keahlian Dosen:</h5>
                <div class="mb-3">
                    <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill">Machine Learning</span>
                    <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill">Data Mining</span>
                    <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill">Artificial Intelligence</span>
                </div>

                <h5 class="h6 mt-4">Platform Penelitian:</h5>
                <div class="d-flex gap-3 platform-links">
                    <a href="#" title="Google Scholar"><i class="fas fa-graduation-cap"></i></a>
                    <a href="#" title="SINTA"><i class="fas fa-book"></i></a>
                    <a href="#" title="GitHub"><i class="fab fa-github"></i></a>
                    <a href="#" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Panel Tab untuk Publikasi dan Proyek -->
    <div class="profile-card">
        <ul class="nav nav-tabs" id="dosenTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="publikasi-tab" data-bs-toggle="tab" data-bs-target="#publikasi" type="button" role="tab">
                    Publikasi Ilmiah
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="proyek-tab" data-bs-toggle="tab" data-bs-target="#proyek" type="button" role="tab">
                    Penelitian & Proyek
                </button>
            </li>
        </ul>

        <div class="tab-content pt-4" id="dosenTabContent">
            <!-- Konten Tab Publikasi Ilmiah -->
            <div class="tab-pane fade show active" id="publikasi" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Jenis</th>
                                <th>Tahun</th>
                                <th>Link</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>AI in Medical Imaging: A Review</td>
                                <td>Jurnal Internasional</td>
                                <td>2023</td>
                                <td><a href="#">DOI</a></td>
                            </tr>
                            <tr>
                                <td>A Novel Approach to IoT Security</td>
                                <td>Prosiding Konferensi</td>
                                <td>2023</td>
                                <td><a href="#">IEEE Xplore</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Konten Tab Penelitian & Proyek -->
            <div class="tab-pane fade" id="proyek" role="tabpanel">
                 <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama Proyek</th>
                                <th>Status</th>
                                <th>Sumber Dana</th>
                                <th>Periode</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Pengembangan AI untuk Analisis Citra Medis</td>
                                <td>Selesai</td>
                                <td>Hibah DIKTI</td>
                                <td>2022-2023</td>
                            </tr>
                            <tr>
                                <td>Sistem IoT untuk Smart Agriculture</td>
                                <td>Berjalan</td>
                                <td>Kolaborasi Industri</td>
                                <td>2023-2024</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
