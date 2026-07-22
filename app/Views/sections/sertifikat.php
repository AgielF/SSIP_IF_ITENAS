<?php 
    // Set default status jika variabel tidak terlempar dari controller
    $status_tugas = $status_tugas ?? 'belum selesai'; 
?>

<section id="sertifikat-asisten-section" class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    
                    <!-- Header Card -->
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0 text-center">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle mb-3" style="width: 70px; height: 70px;">
                            <i class="fas fa-award fa-2x"></i>
                        </div>
                        <h4 class="mb-1 text-dark">Sertifikat Apresiasi Asisten</h4>
                        <p class="text-muted mb-0">Laboratorium Smart System and Information Processing (SSIP)</p>
                    </div>

                    <div class="card-body p-4 text-center">
                        <?php if ($status_tugas === 'selesai') : ?>
                            <!-- Tampilan Jika Sudah Selesai -->
                            <div class="alert alert-success border-0 bg-success bg-opacity-10 py-4 px-3 mb-4">
                                <h5 class="text-success fw-bold mb-2">Selamat! Tugas Anda Telah Selesai</h5>
                                <p class="mb-0 text-dark">Terima kasih atas dedikasi dan kontribusi Anda sebagai Asisten Praktikum di Laboratorium SSIP ITENAS. Sertifikat apresiasi Anda telah diterbitkan.</p>
                            </div>

                            <!-- PRATINJAU GAMBAR SERTIFIKAT LANGSUNG DI WEB -->
                            <div class="mb-4">
                                <h6 class="text-muted mb-2 font-monospace small">Pratinjau Sertifikat:</h6>
                                <div class="p-2 bg-light border rounded shadow-sm d-inline-block w-100" style="max-width: 850px;">
                                    <img src="<?= site_url('sertifikat/preview-asisten') ?>" 
                                         alt="Pratinjau Sertifikat Asisten" 
                                         class="img-fluid rounded border w-100">
                                </div>
                            </div>
                                
                            <!-- Tombol Aksi Unduh -->
                            <div>
                                <a href="<?= site_url('sertifikat/generate') ?>" class="btn btn-success btn-lg px-4 shadow-sm" target="_blank">
                                    <i class="fas fa-download me-2"></i> Unduh Sertifikat (JPG)
                                </a>
                            </div>

                        <?php else : ?>
                            <!-- Tampilan Jika Belum Selesai -->
                            <div class="alert alert-secondary border-0 bg-light py-4 px-3 mb-3">
                                <h5 class="text-secondary fw-bold mb-2">Status Tugas: Masih Berjalan</h5>
                                <p class="mb-0 text-muted">Sertifikat apresiasi akan tersedia secara otomatis di halaman ini setelah Kepala Laboratorium memvalidasi status penyelesaian masa tugas Anda.</p>
                            </div>
                            <div>
                                <button class="btn btn-outline-secondary disabled mt-2">
                                    <i class="fas fa-lock me-2"></i> Unduhan Terkunci
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>