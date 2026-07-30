<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/datatables/css/dataTables.bootstrap5.min.css') ?>">

<div class="container my-5">

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


        
    <div class="card shadow-sm border-0 rounded-4">

    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-bold mb-0">Repositori Project Lab</h5>
            <small class="text-muted">Manajemen proyek & anggota laboratorium</small>
        </div>

        <button class="btn btn-primary rounded-pill"
                data-bs-toggle="modal"
                data-bs-target="#projectModal"
                onclick="prepareAdd()">
            <i class="fas fa-plus me-1"></i> Tambah Project
        </button>
    </div>

    <div class="card-body">
    <div class="table-responsive">
    <table id="repoTable" class="table table-hover align-middle">
    <thead class="bg-light">
    <tr>
        <th>ID Project</th>
        <th>Project</th>
        <th>Topik</th>
        <th>Deskripsi</th>
        <th>Teknologi</th>
        <th>Anggota</th>
        <th>Repository</th>
        <th>Deploy</th>
        <th>Mulai</th>
        <th>Selesai</th>
        <th>Status</th>
        <th>Created</th>
        <th>Updated</th>
        <th class="text-end">Aksi</th>
    </tr>
    </thead>

    <tbody>
    <?php foreach ($projects as $p): ?>
    <tr>

    <td class="text-center">
        <?= esc($p['id_project']) ?: '-' ?>
    </td>

    <td>
        <div class="fw-bold"><?= esc($p['judul']) ?></div>
        <small class="text-muted">Ketua: <?= esc($p['nama_ketua']) ?></small>
    </td>

    <td class="text-center">
        <?= esc($p['topik']) ?: '-' ?>
    </td>

    <td style="max-width:220px">
        <?= esc($p['deskripsi']) ?>
    </td>

    <td>
    <?php foreach (array_filter(explode(',', $p['teknologi'] ?? '')) as $t): ?>
        <span class="badge bg-light border text-dark"><?= esc(trim($t)) ?></span>
    <?php endforeach; ?>
    </td>

    <td>
    <?php if (!empty($p['members'])): ?>
    <ul class="list-unstyled mb-0">
    <?php foreach ($p['members'] as $m): ?>
        <li>
            <i class="fas fa-user text-secondary"></i>
            <?= esc($m['nama']) ?>
            <small class="text-muted">(<?= esc($m['role_project']) ?>)</small>
        </li>
    <?php endforeach; ?>
    </ul>
    <?php else: ?>
    <small class="text-muted">-</small>
    <?php endif; ?>
    </td>

    <td class="text-center">
    <?php if (!empty($p['link_repository'])): ?>
    <a href="<?= esc($p['link_repository']) ?>" target="_blank" class="btn btn-sm btn-dark">
        <i class="fab fa-github"></i>
    </a>
    <?php else: ?>
    -
    <?php endif; ?>
    </td>

    <td class="text-center">
    <?php if (!empty($p['link_deploy'])): ?>
    <a href="<?= esc($p['link_deploy']) ?>" target="_blank" class="btn btn-sm btn-primary">
        <i class="fas fa-globe"></i>
    </a>
    <?php else: ?>
    -
    <?php endif; ?>
    </td>

    <td class="text-center">
    <?= $p['tanggal_mulai'] ? date('d M Y', strtotime($p['tanggal_mulai'])) : '-' ?>
    </td>

    <td class="text-center">
    <?= $p['tanggal_selesai'] ? date('d M Y', strtotime($p['tanggal_selesai'])) : '-' ?>
    </td>

    <td class="text-center">
    <span class="badge bg-<?=
    $p['status']==='selesai'
    ? 'success'
    : ($p['status']==='sedang dilaksanakan' ? 'primary' : 'secondary')
    ?>">
    <?= esc($p['status']) ?>
    </span>
    </td>

    <td class="text-center">
    <?= $p['created_at'] ? date('d/m/Y', strtotime($p['created_at'])) : '-' ?>
    </td>

    <td class="text-center">
    <?= $p['updated_at'] ? date('d/m/Y', strtotime($p['updated_at'])) : '-' ?>
    </td>

    <td class="text-end">
    <button class="btn btn-sm btn-outline-secondary"
            data-bs-toggle="modal"
            data-bs-target="#projectModal"
            onclick='prepareEdit(<?= json_encode($p) ?>)'>
        <i class="fas fa-edit"></i>
    </button>

            <form action="<?= base_url('/project-lab/delete/'.$p['id_project']) ?>" 
            method="POST" 
            class="d-inline" 
            onsubmit="return confirm('Apakah Anda yakin ingin menghapus project ini beserta seluruh anggotanya?');">
            
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                <i class="fas fa-trash"></i>
            </button>
        </form>


    </td>

    </tr>
    <?php endforeach; ?>
    </tbody>

    </table>
    </div>
    </div>
    </div>

    <!-- ================= MODAL ================= -->
    <div class="modal fade" id="projectModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">

    <form id="projectForm" method="post">
    <?= csrf_field() ?>

    <div class="modal-header">
    <h5 class="modal-title" id="modalTitle"></h5>
    <button class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">

    <div class="row g-3">
    <div class="col-md-6">
    <label class="form-label">Judul Project</label>
    <input type="text" name="judul" id="judul" class="form-control" required>
    </div>

    <div class="col-md-6">
    <label class="form-label">Ketua Project</label>
    <select name="created_by" id="created_by" class="form-select">
    <?php foreach ($users as $u): ?>
    <option value="<?= $u['id'] ?>"><?= esc($u['nama']) ?></option>
    <?php endforeach; ?>
    </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Topik</label>
        <select name="topik" id="topik" class="form-select">
            <option value="">-- Pilih Topik --</option>
            <option value="machine learning">Machine Learning</option>
            <option value="data mining">Data Mining</option>
            <option value="deep learning">Deep Learning</option>
            <option value="artificial intelligence">Artificial Intelligence</option>
            <option value="expert system">Expert System</option>
            <option value="smart system">Smart System</option>
        </select>
    </div>

    <div class="col-md-6">
    <label class="form-label">Status</label>
    <select name="status" id="status" class="form-select">
    <option value="akan dilaksanakan">Akan Dilaksanakan</option>
    <option value="sedang dilaksanakan">Sedang Dilaksanakan</option>
    <option value="selesai">Selesai</option>
    </select>
    </div>

    <div class="col-12">
    <label class="form-label">Teknologi</label>
    <input type="text" name="teknologi" id="teknologi" class="form-control">
    </div>

    <div class="col-12">
    <label class="form-label">Deskripsi</label>
    <textarea name="deskripsi" id="deskripsi" class="form-control"></textarea>
    </div>
    </div>

    <hr>
    <h6 class="fw-bold"><i class="fas fa-users me-1"></i> Anggota Project</h6>
    <div id="memberContainer"></div>


    <!-- ===== LINK REPOSITORY ===== -->
<div class="col-md-6">
    <label class="form-label">Link Repository</label>
    <input type="url"
           name="link_repository"
           id="link_repository"
           class="form-control"
           placeholder="https://github.com/username/repo">
</div>

<!-- ===== LINK DEPLOY ===== -->
<div class="col-md-6">
    <label class="form-label">Link Deploy</label>
    <input type="url"
           name="link_deploy"
           id="link_deploy"
           class="form-control"
           placeholder="https://project-domain.com">
</div>

<!-- ===== TANGGAL MULAI ===== -->
<div class="col-md-6">
    <label class="form-label">Tanggal Mulai</label>
    <input type="date"
           name="tanggal_mulai"
           id="tanggal_mulai"
           class="form-control">
</div>

<!-- ===== TANGGAL SELESAI ===== -->
<div class="col-md-6">
    <label class="form-label">Tanggal Selesai</label>
    <input type="date"
           name="tanggal_selesai"
           id="tanggal_selesai"
           class="form-control">
</div>

    <button type="button" class="btn btn-sm btn-outline-primary mt-2"
            onclick="addMemberRow()">
    <i class="fas fa-user-plus"></i> Tambah Anggota
    </button>

    </div>

    <div class="modal-footer">
    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
    <button class="btn btn-primary">Simpan</button>
    </div>

    </form>
    </div>
    </div>
    </div>
    </div>
<!-- ================= JS ================= -->
 <!-- ================= DATATABLES JS ================= -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<!-- BUTTONS -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script>
let memberIndex = 0;

/* ===== ELEMENT ===== */
const modalTitle = document.getElementById('modalTitle');
const projectForm = document.getElementById('projectForm');
const memberContainer = document.getElementById('memberContainer');

const judul = document.getElementById('judul');
const topik = document.getElementById('topik');
const status = document.getElementById('status');
const teknologi = document.getElementById('teknologi');
const deskripsi = document.getElementById('deskripsi');
const created_by = document.getElementById('created_by');

const link_repository = document.getElementById('link_repository');
const link_deploy = document.getElementById('link_deploy');
const tanggal_mulai = document.getElementById('tanggal_mulai');
const tanggal_selesai = document.getElementById('tanggal_selesai');

/* ===== TAMBAH PROJECT ===== */
function prepareAdd() {
    modalTitle.innerText = 'Tambah Project';
    projectForm.action = '<?= base_url('/project-lab/create') ?>';

    projectForm.reset();
    memberContainer.innerHTML = '';
    memberIndex = 0;
}

/* ===== EDIT PROJECT ===== */
function prepareEdit(data) {
    modalTitle.innerText = 'Edit Project';
    projectForm.action = '<?= base_url('/project-lab/update') ?>/' + data.id_project;

    judul.value = data.judul ?? '';
    topik.value = data.topik ?? '';
    status.value = data.status ?? '';
    teknologi.value = data.teknologi ?? '';
    deskripsi.value = data.deskripsi ?? '';
    created_by.value = data.created_by ?? '';

    link_repository.value = data.link_repository ?? '';
    link_deploy.value     = data.link_deploy ?? '';
    tanggal_mulai.value   = data.tanggal_mulai ?? '';
    tanggal_selesai.value = data.tanggal_selesai ?? '';

    memberContainer.innerHTML = '';
    memberIndex = 0;

    if (Array.isArray(data.members)) {
        data.members.forEach(m => {
            addMemberRow(m.id_user, m.role_project);
        });
    }
}

/* ===== TAMBAH ANGGOTA ===== */
function addMemberRow(idUser = '', role = '') {
    memberIndex++;

    const html = `
    <div class="row g-2 mb-2 member-row">
        <div class="col-md-7">
            <select class="form-select member-user"
                    name="members[${memberIndex}][id_user]" required>
                <option value="">-- Pilih User --</option>
                <?php foreach ($users as $u): ?>
                    <option value="<?= $u['id'] ?>"><?= esc($u['nama']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-4">
            <input type="text"
                   class="form-control"
                   name="members[${memberIndex}][role_project]"
                   value="${role}">
        </div>

        <div class="col-md-1">
            <button type="button"
                    class="btn btn-danger btn-sm"
                    onclick="this.closest('.member-row').remove()">
                ×
            </button>
        </div>
    </div>
    `;

    memberContainer.insertAdjacentHTML('beforeend', html);

    const lastRow = memberContainer.lastElementChild;
    lastRow.querySelector('.member-user').value = idUser;
}
$(document).ready(function () {
    $('#repoTable').DataTable({
        responsive: true,

        /* ⏱️ SORT DATA */
        order: [[11, 'desc']], // kolom "Created" (index dimulai 0)

        /* 📄 JUMLAH DATA PER HALAMAN */
        lengthMenu: [
            [5, 10, 15],
            [5, 10, 15]
        ],
        pageLength: 5,

        /* 🔍 SEARCH */
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: {
                first: "Awal",
                last: "Akhir",
                next: "›",
                previous: "‹"
            }
        },

        /* 📤 EXPORT */
        dom: '<"d-flex justify-content-between mb-2"Bf>rtip',

        buttons: [
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> Export PDF',
                className: 'btn btn-danger btn-sm',
                title: 'Repositori Project Lab',
                orientation: 'landscape',
                pageSize: 'A4',
                exportOptions: {
                    columns: ':not(:last-child)' // kecuali kolom aksi
                }
            }
        ]
    });
});

// Show toast if flashdata exists
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
