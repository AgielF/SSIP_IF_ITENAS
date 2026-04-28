<style>
    .admin-container {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    #adminTable thead th {
        background-color: #f8f9fa;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        border-bottom: 2px solid #e9ecef;
    }
    #adminTable .btn-group .btn {
        border-radius: 6px;
    }
</style>

<div class="container my-5">
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="admin-container">
        <div id="controls-wrapper">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                <h4 class="mb-0">Kelola Periode Akademik</h4>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="fas fa-plus me-1"></i> Tambah Periode
                    </button>
                </div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table id="adminTable" class="table table-hover align-middle" style="width:100%">
                <thead>
                    <tr>
                        <th width="5%">No.</th>
                        <th>Nama Periode</th>
                        <th>Tahun</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($periode)): ?>
                        <?php $no = 1; foreach ($periode as $p): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($p['nama_periode']) ?></td>
                                <td><?= esc($p['tahun']) ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-light btn-sm" title="Edit" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $p['id_periode'] ?>">
                                            <i class="fas fa-pencil-alt text-warning"></i>
                                        </button>
                                        <a href="<?= base_url('periode_admin/delete/' . $p['id_periode']) ?>" class="btn btn-light btn-sm" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus periode ini? Data asisten yang terhubung ke periode ini juga akan kehilangan relasinya.')">
                                            <i class="fas fa-trash-alt text-danger"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="modalEdit<?= $p['id_periode'] ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="<?= base_url('periode_admin/update/' . $p['id_periode']) ?>" method="POST">
                                            <?= csrf_field() ?>
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Periode</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Periode <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="nama_periode" value="<?= esc($p['nama_periode']) ?>" placeholder="Contoh: Ganjil 2025/2026" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Tahun <span class="text-danger">*</span></label>
                                                    <input type="number" min="2000" max="2099" class="form-control" name="tahun" value="<?= esc($p['tahun']) ?>" placeholder="Contoh: 2025" required>
                                                </div>
                                    
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada data periode.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('periode_admin/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Periode Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Periode <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_periode" placeholder="Contoh: Ganjil 2025/2026" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tahun <span class="text-danger">*</span></label>
                        <input type="number" min="2000" max="2099" class="form-control" name="tahun" value="<?= date('Y') ?>" placeholder="Contoh: 2025" required>
                    </div>
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>