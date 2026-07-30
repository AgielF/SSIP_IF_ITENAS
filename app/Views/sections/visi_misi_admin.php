<section class="container mt-5 mb-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Kelola Visi & Misi</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahVisiMisi">
                + Tambah Data
            </button>
        </div>
        <div class="card-body">
            
            <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
                <!-- Success Toast -->
                <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas fa-check-circle me-2"></i>
                            <span id="successMessage">
                                <?php if (session()->getFlashdata('success')): ?>
                                    <?= session()->getFlashdata('success') ?>
                                <?php endif; ?>
                            </span>
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>

                <!-- Error Toast -->
                <div id="errorToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <span id="errorMessage">
                                <?php if (session()->getFlashdata('error')): ?>
                                    <?= session()->getFlashdata('error') ?>
                                <?php elseif (session()->getFlashdata('errors')): ?>
                                    <?= implode('<br>', session()->getFlashdata('errors')) ?>
                                <?php endif; ?>
                            </span>
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">ID</th>
                            <th width="20%">Judul</th>
                            <th width="45%">Isi</th>
                            <th width="15%">Updated At</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($visi_misi)): ?>
                            <?php foreach ($visi_misi as $item) : ?>
                                <tr>
                                    <td><?= esc($item['id']) ?></td>
                                    <td><?= esc($item['judul']) ?></td>
                                    <td><?= esc($item['isi']) ?></td>
                                    <td><?= esc($item['updated_at']) ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning mb-1" data-bs-toggle="modal" data-bs-target="#modalEditVisiMisi<?= $item['id'] ?>">
                                            Edit
                                        </button>
                                        
                                        <form action="<?= base_url('visi-misi_admin/delete/' . $item['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-danger mb-1">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <div class="modal fade" id="modalEditVisiMisi<?= $item['id'] ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Visi / Misi</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="<?= base_url('visi-misi_admin/update/' . $item['id']) ?>" method="post">
                                                <?= csrf_field() ?>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Judul</label>
                                                        <input type="text" class="form-control" name="judul" value="<?= esc($item['judul']) ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Isi</label>
                                                        <textarea class="form-control" name="isi" rows="4" required><?= esc($item['isi']) ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data Visi & Misi.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modalTambahVisiMisi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Visi / Misi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('visi-misi_admin/store') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" class="form-control" name="judul" placeholder="Contoh: Visi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Isi</label>
                        <textarea class="form-control" name="isi" rows="4" placeholder="Masukkan detail..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    <?php if (session()->getFlashdata('success')): ?>
        const successToast = new bootstrap.Toast(document.getElementById('successToast'));
        successToast.show();
        setTimeout(() => successToast.hide(), 3000);
    <?php endif; ?>

    <?php if (session()->getFlashdata('error') || session()->getFlashdata('errors')): ?>
        const errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
        errorToast.show();
        setTimeout(() => errorToast.hide(), 3000);
    <?php endif; ?>
});
</script>