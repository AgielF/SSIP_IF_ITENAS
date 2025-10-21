<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= esc($title ?? 'Daftar Event') ?></title>

 
  <!-- Bootstrap CSS -->
  <link href="<?= base_url('css/bootstrap.min.css') ?>" rel="stylesheet">

  <!-- Font Awesome -->
  <link href="<?= base_url('css/all.min.css') ?>" rel="stylesheet">

  <style>
    .event-list-item { border-bottom: 1px solid #e0e0e0; }
    .date-box {
      width: 80px; flex-shrink: 0; text-align: center;
      background-color: #f8f9fa; border: 1px solid #dee2e6;
      border-radius: 0.375rem; padding: 10px 5px;
    }
    .date-box .day { font-size: 0.8rem; color: #6c757d; }
    .date-box .date { font-size: 2rem; font-weight: bold; color: #343a40; }
    .date-box .month { font-size: 0.9rem; font-weight: 500; }
    .filter-buttons .btn.active { background-color: #0d6efd; color: white; }
  </style>
</head>
<body>

<div class="container my-5">
  <!-- Header dan Filter -->
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <h2 class="h3">Agenda & Acara</h2>
    <div class="d-flex gap-2">
      <!-- Filter Jenis -->
      <div class="filter-buttons btn-group" role="group">
        <?php $kategoriList = ['semua', 'seminar', 'lomba', 'praktikum']; ?>
        <?php foreach ($kategoriList as $kat): ?>
          <button type="button" 
                  class="btn btn-outline-primary filter-btn <?= $kat === 'semua' ? 'active' : '' ?>" 
                  data-filter="<?= strtolower($kat) ?>">
            <?= ucfirst($kat) ?>
          </button>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- Daftar Event -->
  <div class="event-list">
    <?php if (!empty($events)): ?>
      <?php foreach ($events as $row): ?>
        <?php
          $dateObj = DateTime::createFromFormat('Y-m-d H:i:s', $row['created_at']);
          $tanggal = $dateObj ? $dateObj->format('d') : '';
          $bulan   = $dateObj ? strtoupper($dateObj->format('M')) : '';
          $hari    = $dateObj ? strtoupper($dateObj->format('D')) : '';
          $jenis   = strtolower(trim($row['jenis']));
        ?>
        <div class="event-list-item d-flex align-items-start p-3" 
             data-kategori="<?= esc($jenis) ?>"
             data-tanggal="<?= esc($row['created_at']) ?>">
          <div class="date-box me-4">
            <div class="day"><?= esc($hari) ?></div>
            <div class="date"><?= esc($tanggal) ?></div>
            <div class="month"><?= esc($bulan) ?></div>
          </div>
          <div>
            <h5 class="mb-1"><?= esc($row['nama_event']) ?></h5>
            
            <p>
              <strong>Jenis:</strong> <?= esc($row['jenis']) ?><br>
              <strong>Dibuat oleh:</strong> <?= esc($row['creator']) ?><br>
              <small><?= esc(substr(strip_tags($row['deskripsi']), 0, 100)) ?>...</small>
            </p>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-center">Tidak ada event tersedia.</p>
    <?php endif; ?>
  </div>
</div>

<!-- Bootstrap & Custom JS -->
<script src="<?= base_url('js/bootstrap.bundle.min.js') ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const filterButtons = document.querySelectorAll('.filter-btn');
  const eventItems    = document.querySelectorAll('.event-list-item');

  filterButtons.forEach(button => {
    button.addEventListener('click', function() {
      filterButtons.forEach(btn => btn.classList.remove('active'));
      this.classList.add('active');

      const filter = this.dataset.filter.toLowerCase().trim();

      eventItems.forEach(item => {
        const kategori = item.dataset.kategori.toLowerCase().trim();
        if (filter === 'semua' || kategori === filter) {
          item.classList.remove('d-none');
          item.classList.add('d-flex');
        } else {
          item.classList.remove('d-flex');
          item.classList.add('d-none');
        }
      });
    });
  });
});
</script>

</body>
</html>
