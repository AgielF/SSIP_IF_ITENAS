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
}
.publication-list {
    list-style: none;
    padding-left: 0;
}
.publication-list li {
    padding: 1.25rem 0;
    border-bottom: 1px dashed #e9ecef;
}
.publication-list li:last-child {
    border-bottom: none;
}
</style>

<div class="container my-5">
<div class="row g-4">

<!-- ================= LEFT COLUMN ================= -->
<div class="col-lg-5">
    <div class="content-card h-100">
        <h3>Field of Study</h3>

        <h4 class="fw-semibold mb-3">
            <?= esc($field['title']) ?>
        </h4>

        <p class="text-muted mb-4">
            <?= esc($field['description']) ?>
        </p>

        <div class="d-flex gap-3 small text-muted">
            <div>
                <strong><?= count($publications) ?></strong><br>
                Publikasi
            </div>
            <div>
                <strong><?= count($projects) ?></strong><br>
                Proyek Riset
            </div>
        </div>
    </div>
</div>

<!-- ================= RIGHT COLUMN ================= -->
<div class="col-lg-7">
<div class="content-card h-100">

<!-- ================= TABS ================= -->
<ul class="nav nav-tabs">
    <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#publikasi">
            Publikasi Ilmiah
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#proyek">
            Proyek Riset
        </button>
    </li>
</ul>

<div class="tab-content pt-4">

<!-- ================= TAB PUBLIKASI ================= -->
<div class="tab-pane fade show active" id="publikasi">
<ul class="publication-list">

<?php if (!empty($publications)): ?>
<?php foreach ($publications as $pub): ?>
<li>
    <h6 class="fw-semibold mb-1">
        <?= esc($pub['judul'] ?? 'Tanpa Judul') ?>
    </h6>

    <div class="small text-muted mb-2">
        <?= esc($pub['kategori'] ?? '-') ?>
        • <?= esc($pub['tanggal_publikasi'] ?? '-') ?>
    </div>

    <?php if (!empty($pub['deskripsi'])): ?>
    <p class="mb-2 text-secondary">
        <?= esc($pub['deskripsi']) ?>
    </p>
    <?php endif; ?>

    <div class="d-flex flex-wrap gap-2">
        <span class="badge bg-light text-dark border">
            <?= esc($pub['jenis_publikasi']) ?>
        </span>

        <?php if (!empty($pub['link_doi'])): ?>
        <a href="<?= esc($pub['link_doi'], 'attr') ?>" target="_blank"
           class="badge bg-primary text-decoration-none">
            DOI
        </a>
        <?php endif; ?>

        <?php if (!empty($pub['link_publikasi'])): ?>
        <a href="<?= esc($pub['link_publikasi'], 'attr') ?>" target="_blank"
           class="badge bg-success text-decoration-none">
            Publikasi
        </a>
        <?php endif; ?>
    </div>
</li>
<?php endforeach; ?>
<?php else: ?>
<li class="text-muted">Tidak ada publikasi untuk topik ini.</li>
<?php endif; ?>

</ul>
</div>

<!-- ================= TAB PROYEK ================= -->
<div class="tab-pane fade" id="proyek">
<ul class="publication-list">

<?php if (!empty($projects)): ?>
<?php foreach ($projects as $pr): ?>
<li>
    <h6 class="fw-semibold mb-1">
        <?= esc($pr['judul']) ?>
    </h6>

    <div class="small text-muted mb-2">
        <?= esc($pr['tahun_mulai']) ?>
        <?php if (!empty($pr['tahun_selesai'])): ?>
            – <?= esc($pr['tahun_selesai']) ?>
        <?php endif; ?>
    </div>

    <?php if (!empty($pr['deskripsi'])): ?>
    <p class="mb-2 text-secondary">
        <?= esc($pr['deskripsi']) ?>
    </p>
    <?php endif; ?>

    <div class="d-flex flex-wrap gap-2">

        <!-- STATUS -->
        <span class="badge
            <?=
                match ($pr['status']) {
                    'sedang dilaksanakan' => 'bg-warning text-dark',
                    'selesai' => 'bg-success',
                    default => 'bg-secondary'
                }
            ?>">
            <?= esc($pr['status']) ?>
        </span>

        <!-- MITRA -->
        <?php if (!empty($pr['mitra'])): ?>
        <span class="badge bg-light text-dark border">
            <?= esc($pr['mitra']) ?>
        </span>
        <?php endif; ?>

        <!-- SUMBER DANA -->
        <?php if (!empty($pr['sumber_dana'])): ?>
        <span class="badge bg-info text-dark">
            <?= esc($pr['sumber_dana']) ?>
        </span>
        <?php endif; ?>
    </div>
</li>
<?php endforeach; ?>
<?php else: ?>
<li class="text-muted">Tidak ada proyek riset untuk topik ini.</li>
<?php endif; ?>

</ul>
</div>

</div>
</div>
</div>

</div>
</div>
