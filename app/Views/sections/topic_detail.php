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
    padding: 1rem 0;
    border-bottom: 1px solid #f0f2f5;
}
</style>

<div class="container my-5">
<div class="row g-4">

<!-- ================= LEFT COLUMN ================= -->
<div class="col-lg-5">
    <div class="content-card h-100">
        <h3>Field of Study and Topic Coverage</h3>
        <h4><?= esc($field['title']) ?></h4>
        <p class="text-muted"><?= esc($field['description']) ?></p>
    </div>
</div>

<!-- ================= RIGHT COLUMN ================= -->
<div class="col-lg-7">
<div class="content-card h-100">

<!-- Tabs -->
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
    <strong><?= esc($pub['judul'] ?? 'Tanpa Judul') ?></strong>
    <p class="small text-muted mb-1">
        <?= esc($pub['kategori']) ?> • <?= esc($pub['tanggal_publikasi']) ?>
    </p>
    <p class="mb-1"><?= esc($pub['deskripsi']) ?></p>
    <span class="badge bg-secondary">
        <?= esc($pub['jenis_publikasi']) ?>
    </span>
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
    <strong><?= esc($pr['judul']) ?></strong>
    <p class="small text-muted mb-1">
        <?= esc($pr['tahun_mulai']) ?> – <?= esc($pr['tahun_selesai']) ?>
        • <?= esc($pr['status']) ?>
    </p>
    <p><?= esc($pr['deskripsi']) ?></p>
    <span class="badge bg-info">
        <?= esc($pr['mitra']) ?>
    </span>
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
