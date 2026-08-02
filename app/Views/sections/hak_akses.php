<div class="container my-5">
    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
        <?php if (session()->getFlashdata('success')): ?>
        <div id="successToast" class="toast align-items-center text-white bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <script>setTimeout(() => { let el = document.getElementById('successToast'); if(el) el.classList.remove('show'); }, 3000);</script>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
        <div id="errorToast" class="toast align-items-center text-white bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <script>setTimeout(() => { let el = document.getElementById('errorToast'); if(el) el.classList.remove('show'); }, 3000);</script>
        <?php endif; ?>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white p-4 border-bottom-0">
            <h5 class="fw-bold mb-0 text-primary"><i class="fas fa-user-shield me-2"></i> Kelola Hak Akses (RBAC CRUD)</h5>
            <small class="text-muted">Atur hak akses Create, Read, Update, dan Delete untuk masing-masing Role. Kepala Lab (Admin) memiliki hak akses penuh secara default.</small>
        </div>
        <div class="card-body p-4 pt-2">
            <form action="<?= base_url('/hak_akses_admin/update') ?>" method="post">
                <?= csrf_field() ?>
                
                <h6 class="fw-bold mb-3 text-secondary"><i class="fas fa-table me-2"></i> Matriks Hak Akses CRUD</h6>
                <div class="table-responsive border rounded-3 overflow-hidden mb-4">
                    <table class="table table-hover align-middle mb-0 text-center text-nowrap">
                        <thead class="table-light">
                            <tr>
                                <th rowspan="2" width="70" class="align-middle">No.</th>
                                <th rowspan="2" class="text-start align-middle">Nama Fitur / Menu</th>
                                <th colspan="4" class="border-bottom text-primary align-middle">Akses Asisten (Role 2)</th>
                                <th colspan="4" class="border-bottom text-success align-middle">Akses Dosen (Role 3)</th>
                            </tr>
                            <tr>
                                <!-- Asisten -->
                                <th width="75">View</th>
                                <th width="75">Create</th>
                                <th width="75">Edit</th>
                                <th width="75">Delete</th>
                                <!-- Dosen -->
                                <th width="75">View</th>
                                <th width="75">Create</th>
                                <th width="75">Edit</th>
                                <th width="75">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            foreach ($crudMenus as $key => $label): 
                            ?>
                            <tr>
                                <td class="fw-semibold text-muted"><?= $no++ ?></td>
                                <td class="text-start">
                                    <div class="fw-semibold text-dark"><?= esc($label) ?></div>
                                    <small class="text-muted font-monospace"><?= esc($key) ?></small>
                                </td>
                                
                                <!-- Asisten (Role 2) checkboxes -->
                                <?php foreach (['view', 'create', 'update', 'delete'] as $act): ?>
                                <td>
                                    <div class="form-check form-switch d-inline-block custom-switch">
                                        <input class="form-check-input" type="checkbox" name="permissions[2][]" value="<?= esc($key . '_' . $act) ?>" id="perm-2-<?= esc($key . '-' . $act) ?>" <?= in_array($key . '_' . $act, $currentPermissions[2] ?? []) ? 'checked' : '' ?>>
                                    </div>
                                </td>
                                <?php endforeach; ?>

                                <!-- Dosen (Role 3) checkboxes -->
                                <?php foreach (['view', 'create', 'update', 'delete'] as $act): ?>
                                <td>
                                    <div class="form-check form-switch d-inline-block custom-switch">
                                        <input class="form-check-input" type="checkbox" name="permissions[3][]" value="<?= esc($key . '_' . $act) ?>" id="perm-3-<?= esc($key . '-' . $act) ?>" <?= in_array($key . '_' . $act, $currentPermissions[3] ?? []) ? 'checked' : '' ?>>
                                    </div>
                                </td>
                                <?php endforeach; ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <h6 class="fw-bold mt-4 mb-3 text-secondary"><i class="fas fa-star me-2"></i> Akses Fitur Khusus (Aksi Tunggal)</h6>
                <div class="table-responsive border rounded-3 overflow-hidden mb-4">
                    <table class="table table-hover align-middle mb-0 text-center text-nowrap">
                        <thead class="table-light">
                            <tr>
                                <th width="70" class="align-middle">No.</th>
                                <th class="text-start align-middle">Nama Fitur Khusus</th>
                                <th width="200" class="align-middle">Akses Asisten (Role 2)</th>
                                <th width="200" class="align-middle">Akses Dosen (Role 3)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $noSpecial = 1;
                            foreach ($singleMenus as $key => $label): 
                            ?>
                            <tr>
                                <td class="fw-semibold text-muted"><?= $noSpecial++ ?></td>
                                <td class="text-start">
                                    <div class="fw-semibold text-dark"><?= esc($label) ?></div>
                                    <small class="text-muted font-monospace"><?= esc($key) ?></small>
                                </td>
                                <td>
                                    <div class="form-check form-switch d-inline-block custom-switch">
                                        <input class="form-check-input" type="checkbox" name="permissions[2][]" value="<?= esc($key) ?>" id="perm-2-<?= esc($key) ?>" <?= in_array($key, $currentPermissions[2] ?? []) ? 'checked' : '' ?>>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-switch d-inline-block custom-switch">
                                        <input class="form-check-input" type="checkbox" name="permissions[3][]" value="<?= esc($key) ?>" id="perm-3-<?= esc($key) ?>" <?= in_array($key, $currentPermissions[3] ?? []) ? 'checked' : '' ?>>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-semibold shadow-sm">
                        <i class="fas fa-save me-2"></i> Simpan Semua Hak Akses
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.custom-switch .form-check-input {
    width: 2.3em;
    height: 1.15em;
    cursor: pointer;
}
.custom-switch .form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}
.table th {
    font-weight: 600;
    color: #4a5568;
    background-color: #f7fafc !important;
    border-bottom: 1px solid #e2e8f0;
}
.table td {
    padding: 0.75rem;
}
</style>
