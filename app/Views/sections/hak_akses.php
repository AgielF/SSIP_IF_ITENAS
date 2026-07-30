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
            <h5 class="fw-bold mb-0 text-primary"><i class="fas fa-user-shield me-2"></i> Kelola Hak Akses (RBAC)</h5>
            <small class="text-muted">Atur menu apa saja yang dapat diakses oleh masing-masing Role. Kepala Lab (Admin) memiliki hak akses penuh secara default.</small>
        </div>
        <div class="card-body p-4 pt-2">
            <div class="accordion" id="accordionRoles">
                <?php foreach ($rolesToManage as $roleId => $roleName): ?>
                <div class="accordion-item mb-3 border rounded-3 shadow-sm">
                    <h2 class="accordion-header" id="heading-<?= $roleId ?>">
                        <button class="accordion-button <?= $roleId == 3 ? '' : 'collapsed' ?> bg-light rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $roleId ?>" aria-expanded="<?= $roleId == 3 ? 'true' : 'false' ?>" aria-controls="collapse-<?= $roleId ?>">
                            <i class="fas fa-users-cog me-2 text-primary"></i> 
                            <strong>Hak Akses: <?= esc($roleName) ?></strong>
                        </button>
                    </h2>
                    <div id="collapse-<?= $roleId ?>" class="accordion-collapse collapse <?= $roleId == 3 ? 'show' : '' ?>" aria-labelledby="heading-<?= $roleId ?>" data-bs-parent="#accordionRoles">
                        <div class="accordion-body">
                            <form action="<?= base_url('/hak_akses_admin/update') ?>" method="post">
                                <?= csrf_field() ?>
                                <input type="hidden" name="role_id" value="<?= $roleId ?>">
                                
                                <div class="row g-3">
                                    <?php 
                                        $allowedMenus = $currentPermissions[$roleId] ?? []; 
                                    ?>
                                    <?php foreach ($availableMenus as $key => $label): ?>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="form-check form-switch custom-switch">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="<?= esc($key) ?>" id="perm-<?= $roleId ?>-<?= esc($key) ?>" <?= in_array($key, $allowedMenus) ? 'checked' : '' ?>>
                                            <label class="form-check-label user-select-none" for="perm-<?= $roleId ?>-<?= esc($key) ?>">
                                                <?= esc($label) ?>
                                            </label>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>

                                <hr class="mt-4 mb-3">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                                        <i class="fas fa-save me-1"></i> Simpan Perubahan <?= esc($roleName) ?>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<style>
.custom-switch .form-check-input {
    width: 2.5em;
    height: 1.25em;
    cursor: pointer;
}
.custom-switch .form-check-label {
    padding-top: 0.15em;
    padding-left: 0.5em;
    cursor: pointer;
}
</style>
