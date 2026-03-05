<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= esc($title ?? 'Galeri & Media') ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
  <style>
    /* Menjaga rasio gambar dan video tetap 16:9 agar rapi */
    .gallery-card .card-img-top { 
        aspect-ratio: 16/9; 
        object-fit: cover; 
    }
    .video-container { 
        position: relative; 
        padding-bottom: 56.25%; /* Rasio 16:9 */
        height: 0; 
        overflow: hidden; 
    }
    .video-container iframe { 
        position: absolute; 
        top: 0; 
        left: 0; 
        width: 100%; 
        height: 100%; 
    }
    .gallery-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .gallery-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
  </style>
</head>
<body class="bg-light">

<div class="container my-5">
  <div class="mb-4 text-center text-md-start">
      <h2 class="h3 fw-bold text-dark"><i class="fas fa-images text-primary me-2"></i><?= esc($title ?? 'Galeri & Media') ?></h2>
      <p class="text-muted">Dokumentasi kegiatan dan hasil karya laboratorium.</p>
  </div>

  <div class="card shadow-sm border-0 rounded-4 mb-4">
    <div class="card-body d-flex flex-column flex-md-row justify-content-md-between align-items-start align-items-md-center gap-3">
      
      <div class="gallery-filter-controls btn-group btn-group-sm" role="group">
        <button type="button" class="btn btn-outline-primary active" data-filter="semua">Semua</button>
        <button type="button" class="btn btn-outline-primary" data-filter="foto">Foto</button>
        <button type="button" class="btn btn-outline-primary" data-filter="video">Video</button>
      </div>

      <div class="d-flex align-items-center">
        <label for="gallery-sort-filter" class="form-label me-2 mb-0 small text-nowrap fw-semibold">Urutkan:</label>
        <select class="form-select form-select-sm" id="gallery-sort-filter" style="width: auto;">
          <option value="newest">Terbaru</option>
          <option value="oldest">Terlama</option>
        </select>
      </div>

    </div>
  </div>

  <div class="row g-4" id="gallery-items-container">
    <?php if (!empty($gallery_items)): ?>
      <?php foreach ($gallery_items as $item): ?>
        
        <div class="col-md-6 col-lg-4 gallery-item"
             data-type="<?= esc(strtolower($item['kategori'])) ?>"
             data-date="<?= esc($item['tanggal_upload']) ?>">
          <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden gallery-card">
            
            <?php if (strtolower($item['kategori']) === 'video'): ?>
              <div class="video-container bg-dark">
                <?php
                    $urlVideo = $item['file_url'];
                    
                    // 1. Deteksi & Convert Link YouTube
                    if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $urlVideo, $ytMatch)) {
                        $urlVideo = 'https://www.youtube.com/embed/' . $ytMatch[1];
                    } 
                    // 2. Deteksi & Convert Link Google Drive
                    elseif (preg_match('/drive\.google\.com\/file\/d\/([a-zA-Z0-9_-]+)/i', $urlVideo, $gdMatch)) {
                        // Mengambil ID Google Drive dan memaksanya menjadi link preview
                        $urlVideo = 'https://drive.google.com/file/d/' . $gdMatch[1] . '/preview';
                    }
                ?>
                <iframe src="<?= esc($urlVideo) ?>" title="<?= esc($item['keterangan']) ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
              </div>
            <?php else: ?>
              <img src="<?= base_url('uploads/galeri/' . esc($item['file_url'])) ?>" 
                   class="card-img-top" 
                   alt="<?= esc($item['keterangan']) ?>"
                   onerror="this.src='https://placehold.co/800x450/E2E8F0/334155?text=Gambar+Tidak+Tersedia'">
            <?php endif; ?>
            
            <div class="card-body">
              <h5 class="card-title fs-6 fw-bold mb-3"><?= esc($item['keterangan']) ?></h5>
              <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                <small class="text-muted"><i class="fas fa-user-circle me-1"></i> <?= esc($item['nama_user'] ?? 'Admin') ?></small>
                <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> <?= date('d M Y', strtotime($item['tanggal_upload'])) ?></small>
              </div>
            </div>

          </div>
        </div>

      <?php endforeach; ?>
    <?php else: ?>
      <div class="col-12">
        <div class="alert alert-light text-center border py-5 text-muted rounded-4">
            <i class="fas fa-images fs-1 mb-3 text-secondary"></i><br>
            Belum ada dokumentasi galeri saat ini.
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const galleryFilterButtons = document.querySelectorAll('.gallery-filter-controls button');
  const gallerySortSelect = document.getElementById('gallery-sort-filter');
  const galleryContainer = document.getElementById('gallery-items-container');
  // Ambil semua item saat halaman pertama kali dimuat
  const galleryItems = Array.from(galleryContainer.querySelectorAll('.gallery-item'));

  function updateGalleryView() {
    // Cari filter yang sedang aktif
    const currentFilter = document.querySelector('.gallery-filter-controls button.active').getAttribute('data-filter');
    const currentSort = gallerySortSelect.value;

    // Saring item berdasarkan kategori (foto/video/semua)
    const filteredItems = galleryItems.filter(item => {
      const itemType = item.getAttribute('data-type').toLowerCase();
      return currentFilter === 'semua' || itemType === currentFilter;
    });

    // Urutkan item berdasarkan tanggal
    filteredItems.sort((a, b) => {
      const dateA = new Date(a.getAttribute('data-date'));
      const dateB = new Date(b.getAttribute('data-date'));
      return currentSort === 'newest' ? dateB - dateA : dateA - dateB;
    });

    // Kosongkan container dan isi dengan item yang sudah difilter/disortir
    galleryContainer.innerHTML = '';
    if (filteredItems.length > 0) {
      filteredItems.forEach(item => galleryContainer.appendChild(item));
    } else {
      galleryContainer.innerHTML = `
        <div class="col-12">
            <div class="alert alert-light text-center border py-4 text-muted rounded-4">
                <i class="fas fa-search fs-2 mb-2 text-secondary"></i><br>
                Tidak ada media yang cocok dengan filter.
            </div>
        </div>`;
    }
  }

  // Event Listener untuk Tombol Filter
  galleryFilterButtons.forEach(button => {
    button.addEventListener('click', function() {
      galleryFilterButtons.forEach(btn => btn.classList.remove('active'));
      this.classList.add('active');
      updateGalleryView();
    });
  });

  // Event Listener untuk Dropdown Sort
  gallerySortSelect.addEventListener('change', updateGalleryView);
});
</script>
</body>
</html>