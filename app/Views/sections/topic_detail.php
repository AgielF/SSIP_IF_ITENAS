<style>
    .content-card {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    .content-card h3 {
        border-bottom: 2px solid #f0f2f5;
        padding-bottom: 1rem;
        margin-bottom: 1.5rem;
    }
    .nav-tabs .nav-link {
        color: #6c757d;
        font-weight: 500;
    }
    .nav-tabs .nav-link.active {
        color: #0d6efd;
        background-color: #f8f9fa;
        border-color: #dee2e6 #dee2e6 #f8f9fa;
    }
    .publication-list {
        list-style: none;
        padding-left: 0;
    }
    .publication-list li {
        padding: 1rem 0;
        border-bottom: 1px solid #f0f2f5;
    }
    .publication-list li:last-child {
        border-bottom: none;
    }
</style>

<div class="container my-5">
    <div class="row g-4">
        <!-- Kolom Kiri: Field of Study (DINAMIS) -->
        <div class="col-lg-5">
            <div class="content-card h-100">
                <h3>Field of Study and Topic Coverage</h3>
                <!-- Menampilkan judul dari data yang dikirim Controller -->
                <h4><?= esc($field['title']) ?></h4>
                <!-- Menampilkan deskripsi dari data yang dikirim Controller -->
                <p class="text-muted">
                   <?= esc($field['description']) ?>
                </p>
            </div>
        </div>

        <!-- Kolom Kanan: Panel Tab (DINAMIS) -->
        <div class="col-lg-7">
            <div class="content-card h-100">
                <!-- Navigasi Tab -->
                <ul class="nav nav-tabs" id="mainTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="publikasi-tab" data-bs-toggle="tab" data-bs-target="#publikasi" type="button" role="tab">Publikasi Ilmiah</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="proyek-tab" data-bs-toggle="tab" data-bs-target="#proyek" type="button" role="tab">Proyek</button>
                    </li>
                     <li class="nav-item" role="presentation">
                        <button class="nav-link" id="anggota-tab" data-bs-toggle="tab" data-bs-target="#anggota" type="button" role="tab">Anggota</button>
                    </li>
                </ul>

                <!-- Konten Tab -->
                <div class="tab-content pt-4" id="mainTabContent">
                    <!-- Konten Tab Publikasi Ilmiah (DINAMIS) -->
                    <div class="tab-pane fade show active" id="publikasi" role="tabpanel">
                        <ul class="publication-list">
                            <?php if (!empty($publications)): ?>
                                <?php foreach ($publications as $pub): ?>
                                    <li>
                                        <strong><?= esc($pub['title']) ?></strong>
                                        <p class="small text-muted mb-0"><?= esc($pub['details']) ?></p>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li>Tidak ada publikasi terkait.</li>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <!-- Konten Tab Proyek -->
                    <div class="tab-pane fade" id="proyek" role="tabpanel">
                        <p>Konten untuk Proyek akan ditampilkan di sini.</p>
                    </div>
                    
                    <!-- Konten Tab Anggota -->
                    <div class="tab-pane fade" id="anggota" role="tabpanel">
                        <p>Konten untuk Anggota akan ditampilkan di sini.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
