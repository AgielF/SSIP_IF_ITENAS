<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= esc($title) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
  <style>
    .gallery-card .card-img-top { aspect-ratio: 16/9; object-fit: cover; }
    .video-container { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; }
    .video-container iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
  </style>
</head>
<body>
<div class="container my-5">
  <h2 class="h3 mb-4"><?= esc($title) ?></h2>

  <!-- Filter & Sort -->
  <div class="card shadow-sm mb-4">
    <div class="card-body d-flex flex-column flex-md-row justify-content-md-between align-items-start align-items-md-center gap-3">
      <div class="gallery-filter-controls btn-group btn-group-sm" role="group">
        <button type="button" class="btn btn-outline-primary active" data-filter="semua">Semua</button>
        <button type="button" class="btn btn-outline-primary" data-filter="foto">Foto</button>
        <button type="button" class="btn btn-outline-primary" data-filter="video">Video</button>
      </div>
      <div class="d-flex align-items-center">
        <label for="gallery-sort-filter" class="form-label me-2 mb-0 small text-nowrap">Urutkan:</label>
        <select class="form-select form-select-sm" id="gallery-sort-filter">
          <option value="newest">Terbaru</option>
          <option value="oldest">Terlama</option>
        </select>
      </div>
    </div>
  </div>

  <div class="row g-4" id="gallery-items-container">
    <?php if (!empty($gallery_items)): ?>
      <?php foreach ($gallery_items as $item): ?>
        <div class="col-md-4 gallery-item"
             data-type="<?= esc($item['kategori']) ?>"
             data-date="<?= esc($item['tanggal_upload']) ?>">
          <div class="card h-100 shadow-sm gallery-card">
            <?php if ($item['kategori'] === 'video'): ?>
              <div class="video-container">
                <iframe src="<?= esc($item['file_url']) ?>" title="<?= esc($item['keterangan']) ?>" frameborder="0" allowfullscreen></iframe>
              </div>
            <?php else: ?>
              <img src="<?= esc($item['file_url']) ?>" class="card-img-top" alt="<?= esc($item['keterangan']) ?>">
            <?php endif; ?>
            <div class="card-body">
              <h5 class="card-title"><?= esc($item['keterangan']) ?></h5>
              <p class="card-text small text-muted">
                Upload oleh: <?= esc($item['nama_user'] ?? 'Anonim') ?><br>
                <?= date('d M Y', strtotime($item['tanggal_upload'])) ?>
              </p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-center text-muted">Belum ada data galeri.</p>
    <?php endif; ?>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const galleryFilterButtons = document.querySelectorAll('.gallery-filter-controls button');
  const gallerySortSelect = document.getElementById('gallery-sort-filter');
  const galleryContainer = document.getElementById('gallery-items-container');
  const galleryItems = Array.from(galleryContainer.querySelectorAll('.gallery-item'));

  function updateGalleryView() {
    const currentFilter = document.querySelector('.gallery-filter-controls button.active').getAttribute('data-filter');
    const currentSort = gallerySortSelect.value;

    const filteredItems = galleryItems.filter(item => {
      return currentFilter === 'semua' || item.getAttribute('data-type') === currentFilter;
    });

    filteredItems.sort((a, b) => {
      const dateA = new Date(a.getAttribute('data-date'));
      const dateB = new Date(b.getAttribute('data-date'));
      return currentSort === 'newest' ? dateB - dateA : dateA - dateB;
    });

    galleryContainer.innerHTML = '';
    if (filteredItems.length > 0) {
      filteredItems.forEach(item => galleryContainer.appendChild(item));
    } else {
      galleryContainer.innerHTML = '<p class="text-center text-muted col-12">Tidak ada media yang cocok dengan filter.</p>';
    }
  }

  galleryFilterButtons.forEach(button => {
    button.addEventListener('click', function() {
      galleryFilterButtons.forEach(btn => btn.classList.remove('active'));
      this.classList.add('active');
      updateGalleryView();
    });
  });

  gallerySortSelect.addEventListener('change', updateGalleryView);
});
</script>
</body>
</html>
