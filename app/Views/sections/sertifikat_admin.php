<section id="sertifikat-admin-section" class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                
                <!-- KOTAK PRATINJAU (Muncul otomatis jika konfigurasi gambar sudah ada) -->
                <?php if(!empty($config['template_gambar'])): ?>
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-3 pb-2 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-success"><i class="fas fa-eye me-2"></i> Pratinjau Sertifikat (Contoh)</h5>
                        <span class="badge bg-secondary">Live Render</span>
                    </div>
                    <div class="card-body p-4 text-center bg-light">
                        <!-- Memanggil fungsi preview dari Controller -->
                        <img src="<?= site_url('sertifikat/preview') ?>?t=<?= time() ?>" class="img-fluid border shadow-sm rounded" alt="Preview Sertifikat" style="max-height: 500px; object-fit: contain;">
                        <p class="mt-3 text-muted small mb-0"><i class="fas fa-info-circle me-1"></i> Ini adalah simulasi tata letak dengan data dummy "NAMA ASISTEN CONTOH" dan "152022032".</p>
                    </div>
                </div>
                <?php endif; ?>

                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4">
                        <h4 class="mb-0 text-primary"><i class="fas fa-cog me-2"></i> Konfigurasi Data Sertifikat</h4>
                        <p class="text-muted small mb-0 mt-1">Atur templat gambar polos, tanda tangan, dan teks yang akan dicetak secara dinamis ke dalam sertifikat asisten.</p>
                    </div>
                    <div class="card-body p-4">
                        
                        <!-- Notifikasi -->
                        <?php if (session()->getFlashdata('success')) : ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i><?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Form Konfigurasi -->
                        <form action="<?= site_url('sertifikat/config') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            
                            <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">Pengaturan Teks Utama</h6>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">Judul Sertifikat</label>
                                    <input type="text" name="judul" class="form-control" value="<?= esc($config['judul'] ?? 'SERTIFIKAT APRESIASI') ?>" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Deskripsi Dedikasi</label>
                                <textarea name="deskripsi_template" class="form-control" rows="3" required placeholder="Contoh: Telah Berdedikasi sebagai Asisten Praktikum Pemrograman IOT selama periode Oktober 2025 - Januari 2026"><?= esc($config['deskripsi_template'] ?? '') ?></textarea>
                            </div>

                            <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">Pengaturan Pejabat Penandatangan</h6>
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Nama Kepala Laboratorium</label>
                                    <input type="text" name="nama_kepala_lab" class="form-control" value="<?= esc($config['nama_kepala_lab'] ?? 'Galih Ashari R., S.Si., MT.') ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Nama Ketua Prodi</label>
                                    <input type="text" name="nama_ketua_prodi" class="form-control" value="<?= esc($config['nama_ketua_prodi'] ?? 'Dr. sc. Lisa Kristiana, ST., MT.') ?>" required>
                                </div>
                            </div>

                            <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">Aset Gambar <span class="text-muted fw-normal fs-6">(Abaikan jika tidak ingin mengubah)</span></h6>
                            
                            <div class="mb-3 bg-light p-3 rounded border">
                                <label class="form-label fw-semibold">Template Background (Gambar Polos Lanskap)</label>
                                <input type="file" name="template_gambar" class="form-control" accept="image/jpeg, image/png">
                                <?php if(!empty($config['template_gambar'])): ?>
                                    <div class="mt-2 text-success small"><i class="fas fa-check-circle"></i> Template background saat ini sudah terpasang.</div>
                                <?php else: ?>
                                    <div class="mt-2 text-danger small"><i class="fas fa-times-circle"></i> Belum ada template terpasang!</div>
                                <?php endif; ?>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="bg-light p-3 rounded border h-100">
                                        <label class="form-label fw-semibold">Tanda Tangan Kepala Lab (PNG Transparan)</label>
                                        <input type="file" name="ttd_kepala_lab" class="form-control" accept="image/png">
                                        <?php if(!empty($config['ttd_kepala_lab'])): ?>
                                            <div class="mt-2 text-success small"><i class="fas fa-check-circle"></i> TTD Kepala Lab terpasang.</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="bg-light p-3 rounded border h-100">
                                        <label class="form-label fw-semibold">Tanda Tangan Ketua Prodi (PNG Transparan)</label>
                                        <input type="file" name="ttd_ketua_prodi" class="form-control" accept="image/png">
                                        <?php if(!empty($config['ttd_ketua_prodi'])): ?>
                                            <div class="mt-2 text-success small"><i class="fas fa-check-circle"></i> TTD Ketua Prodi terpasang.</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Area Tombol Aksi -->
                            <div class="mt-4 d-flex justify-content-end gap-2">
                                <?php if(!empty($config)): ?>
                                    <button type="button" class="btn btn-danger px-4" data-bs-toggle="modal" data-bs-target="#deleteConfigModal">
                                        <i class="fas fa-trash me-1"></i> Hapus Konfigurasi
                                    </button>
                                <?php endif; ?>
                                
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-1"></i> Simpan Konfigurasi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Hapus Konfigurasi -->
<?php if(!empty($config)): ?>
<div class="modal fade" id="deleteConfigModal" tabindex="-1" aria-labelledby="deleteConfigModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <form action="<?= site_url('sertifikat/delete-config') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteConfigModalLabel"><i class="fas fa-exclamation-triangle me-2"></i> Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="mb-0">Apakah Anda yakin ingin menghapus seluruh konfigurasi sertifikat ini? <strong>Teks dan semua aset gambar (Template & Tanda Tangan) akan dihapus secara permanen dari server.</strong></p>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>