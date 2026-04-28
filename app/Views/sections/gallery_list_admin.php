<style>
    .fm-content { padding: 30px; background-color: #ffffff; }
    .fm-table thead th { background-color: #f8f9fa; border-bottom: 2px solid #dee2e6; font-weight: 600; }
    .fm-table tbody tr:hover { background-color: #f8f9fa; }
    .nav-tabs .nav-link { color: #555; font-weight: 500; }
    .nav-tabs .nav-link.active { color: #0d6efd; border-color: #dee2e6 #dee2e6 #fff; }
    .img-thumbnail-table { width: 80px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid #ddd; }
    @media print {
        body * { visibility: hidden; }
        #printable-area, #printable-area * { visibility: visible; }
        #printable-area { position: absolute; left: 0; top: 0; width: 100%; }
        .btn, .nav-tabs, #search-input, #sort-filter, #items-per-page-filter,
        #pagination-controls, label, #record-info, .non-printable { display: none !important; }
    }
</style>

<div class="container my-5">
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
        <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"><i class="fas fa-check-circle me-2"></i><span id="successMessage"></span></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <div id="errorToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"><i class="fas fa-exclamation-triangle me-2"></i><span id="errorMessage"></span></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs" id="project-nav">
        <li class="nav-item">
            <a class="nav-link active" href="#">Daftar Kelola Galeri</a>
        </li>
    </ul>

    <main class="fm-content card rounded-0 rounded-bottom border-top-0 shadow-sm">
        <div class="card-body">
            <div id="printable-area">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                    <h4 class="mb-0 fw-bold"><i class="fas fa-images text-primary me-2"></i>Kelola Galeri Lab</h4>
                    
                    <div class="d-flex align-items-center gap-2 flex-wrap non-printable">
                        <input type="text" id="search-input" class="form-control form-control-sm" placeholder="Cari keterangan..." style="width: auto;">
                        
                        <div class="d-flex align-items-center">
                            <label for="sort-filter" class="form-label me-2 mb-0 small text-nowrap">Urutkan:</label>
                            <select id="sort-filter" class="form-select form-select-sm" onchange="location.href='?sort=' + this.value">
                                <option value="DESC" <?= ($sort === 'DESC') ? 'selected' : '' ?>>Terbaru</option>
                                <option value="ASC" <?= ($sort === 'ASC') ? 'selected' : '' ?>>Terlama</option>
                            </select>
                        </div>

                        <div class="d-flex align-items-center">
                            <label for="items-per-page-filter" class="form-label me-2 mb-0 small text-nowrap">Tampilkan:</label>
                            <select class="form-select form-select-sm" id="items-per-page-filter">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="all">Semua</option>
                            </select>
                        </div>

                        <button id="export-pdf-btn" class="btn btn-sm btn-danger">
                            <i class="fas fa-file-pdf me-1"></i> PDF
                        </button>

                        <button id="add-data-btn" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addDataModal">
                            <i class="fas fa-plus me-1"></i> Tambah Media
                        </button>
                    </div>
                </div>

                <p class="text-muted small mb-3" id="record-info">Menampilkan data...</p>

                <div class="table-responsive border rounded">
                    <table class="table fm-table table-hover align-middle mb-0" id="galeri-table">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Pengunggah</th>
                                <th>Kategori</th>
                                <th>Keterangan</th>
                                <th>Pratinjau / File URL</th>
                                <th>Tgl Upload</th>
                                <th class="text-center non-printable">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($media_items['rows'])) : ?>
                                <?php foreach ($media_items['rows'] as $idx => $row) : ?>
                                    <tr>
                                        <td><?= esc($idx + 1) ?></td>
                                        <td><?= esc($row[1] ?? 'Admin') ?></td>
                                        <td>
                                            <span class="badge bg-<?= strtolower($row[2]) === 'video' ? 'danger' : 'info' ?>">
                                                <?= esc(strtoupper($row[2])) ?>
                                            </span>
                                        </td>
                                        <td><?= esc($row[3]) ?></td>
                                        <td>
                                            <?php if (strtolower($row[2]) === 'video'): ?>
                                                <a href="<?= esc($row[4]) ?>" target="_blank" class="text-primary small text-decoration-none">
                                                    <i class="fab fa-youtube me-1"></i> Link Video
                                                </a>
                                            <?php else: ?>
                                                <a href="<?= base_url('uploads/galeri/' . $row[4]) ?>" target="_blank">
                                                    <img src="<?= base_url('uploads/galeri/' . $row[4]) ?>" 
                                                         alt="Galeri" 
                                                         class="img-thumbnail-table"
                                                         onerror="this.src='https://placehold.co/80x50/E2E8F0/334155?text=Img'">
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('d/m/Y', strtotime($row[5])) ?></td>
                                        <td class="text-center non-printable">
                                            <button class="btn btn-sm btn-outline-secondary me-1 btn-edit"
                                                    data-id="<?= $row[0] ?>"
                                                    data-kategori="<?= esc(strtolower($row[2])) ?>"
                                                    data-keterangan="<?= esc($row[3]) ?>"
                                                    data-file="<?= esc($row[4]) ?>">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <a href="<?= site_url('galeri_admin/delete/'.$row[0]) ?>"
                                               class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus media ini secara permanen?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-folder-open mb-2 fs-3 text-secondary"></i><br>
                                        Belum ada data galeri.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <nav class="mt-4">
                <ul class="pagination pagination-sm justify-content-end" id="pagination-controls"></ul>
            </nav>
        </div>
    </main>
</div>

<div class="modal fade" id="addDataModal" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" action="<?= site_url('galeri_admin/create') ?>" method="post" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Media Galeri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Pilih Tipe Media</label>
                    <select name="kategori" id="addKategori" class="form-select" required>
                        <option value="foto">Upload Foto</option>
                        <option value="video">Embed Video (YouTube)</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-semibold">Judul / Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="2" placeholder="Masukkan keterangan kegiatan..." required></textarea>
                </div>

                <div class="mb-3" id="addAreaFoto">
                    <label class="form-label fw-semibold">Upload Gambar</label>
                    <input type="file" name="gambar" id="addInputFoto" class="form-control" accept="image/*" required>
                    <small class="text-muted d-block mt-1">Format: JPG, PNG, JPEG. (Otomatis di-crop 16:9)</small>
                </div>

                <div class="mb-3" id="addAreaVideo" style="display: none;">
                    <label class="form-label fw-semibold">Link Embed Video</label>
                    <input type="url" name="link_video" id="addInputVideo" class="form-control" placeholder="https://www.youtube.com/embed/xxxxxx">
                    <small class="text-muted d-block mt-1">Gunakan link embed. Contoh: https://www.youtube.com/embed/dQw4w9WgXcQ</small>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Media</button>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="editDataModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" id="editForm" class="modal-content" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title">Edit Media Galeri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_galeri" id="edit-id">
                
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tipe Media</label>
                    <select name="kategori" id="editKategori" class="form-select" required>
                        <option value="foto">Foto</option>
                        <option value="video">Video (YouTube)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Judul / Keterangan</label>
                    <textarea name="keterangan" id="edit-keterangan" class="form-control" rows="2" required></textarea>
                </div>

                <div class="mb-3" id="editAreaFoto">
                    <label class="form-label fw-semibold">Ganti Gambar Baru</label>
                    <input type="file" name="gambar" id="editInputFoto" class="form-control" accept="image/*">
                    <small class="text-muted d-block mt-1">Biarkan kosong jika tidak ingin mengganti gambar.</small>
                    <div id="current-image-info" class="mt-2 text-primary small"></div>
                </div>

                <div class="mb-3" id="editAreaVideo" style="display: none;">
                    <label class="form-label fw-semibold">Ubah Link Embed Video</label>
                    <input type="url" name="link_video" id="editInputVideo" class="form-control">
                    <small class="text-muted d-block mt-1">Masukkan URL Embed YouTube yang baru.</small>
                </div>

            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // --- 1. HANDLING TOAST NOTIFICATION ---
    <?php if (session()->getFlashdata('success')): ?>
        const successToast = new bootstrap.Toast(document.getElementById('successToast'));
        document.getElementById('successMessage').textContent = '<?= session()->getFlashdata('success') ?>';
        successToast.show();
        setTimeout(() => successToast.hide(), 4000);
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        const errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
        document.getElementById('errorMessage').textContent = '<?= session()->getFlashdata('error') ?>';
        errorToast.show();
        setTimeout(() => errorToast.hide(), 4000);
    <?php endif; ?>


    // --- 2. LOGIKA DYNAMIC FORM (FOTO VS VIDEO) ---
    function toggleFormFields(kategori, areaFoto, areaVideo, inputFoto, inputVideo) {
        if (kategori === 'video') {
            areaFoto.style.display = 'none';
            areaVideo.style.display = 'block';
            inputFoto.removeAttribute('required');  
            inputVideo.setAttribute('required', 'required'); 
        } else {
            areaFoto.style.display = 'block';
            areaVideo.style.display = 'none';
            inputVideo.removeAttribute('required'); 
            // Kita tidak force inputFoto 'required' saat Edit (karena user mungkin gak mau ganti foto)
            // Khusus modal Tambah baru diatur di bawah.
        }
    }

    // Event untuk Modal Tambah
    const addKategori = document.getElementById('addKategori');
    addKategori.addEventListener('change', function() {
        toggleFormFields(this.value, 
            document.getElementById('addAreaFoto'), 
            document.getElementById('addAreaVideo'), 
            document.getElementById('addInputFoto'), 
            document.getElementById('addInputVideo')
        );
        // Khusus saat nambah data foto, input file WAJIB diisi
        if(this.value === 'foto') {
            document.getElementById('addInputFoto').setAttribute('required', 'required');
        }
    });

    // Event untuk Modal Edit (Menyesuaikan saat kategori diubah)
    const editKategori = document.getElementById('editKategori');
    editKategori.addEventListener('change', function() {
        toggleFormFields(this.value, 
            document.getElementById('editAreaFoto'), 
            document.getElementById('editAreaVideo'), 
            document.getElementById('editInputFoto'), 
            document.getElementById('editInputVideo')
        );
    });


    // --- 3. FILTER, SORT & PAGINATION TABLE ---
    const searchInput = document.getElementById('search-input');
    const table = document.getElementById('galeri-table');
    const tableRows = Array.from(table.querySelectorAll('tbody tr')).filter(row => !row.innerText.includes('Belum ada data'));
    const sortFilter = document.getElementById('sort-filter');
    const itemsPerPageFilter = document.getElementById('items-per-page-filter');
    const recordInfo = document.getElementById('record-info');
    const paginationControls = document.getElementById('pagination-controls');
    let currentPage = 1;

    function updateTable() {
        let rows = [...tableRows];
        const searchTerm = searchInput.value.toLowerCase();

        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(searchTerm) ? '' : 'none';
        });
        rows = rows.filter(row => row.style.display !== 'none');

        const perPage = itemsPerPageFilter.value === 'all' ? rows.length : parseInt(itemsPerPageFilter.value, 10);
        const totalRows = rows.length;
        const totalPages = Math.ceil(totalRows / perPage) || 1;
        if (currentPage > totalPages) currentPage = 1;
        
        const startIndex = (currentPage - 1) * perPage;
        const endIndex = startIndex + perPage;

        rows.forEach((row, i) => {
            row.style.display = (i >= startIndex && i < endIndex) ? '' : 'none';
        });

        recordInfo.textContent = totalRows === 0 
            ? "Tidak ada data ditemukan." 
            : `Menampilkan ${startIndex + 1}-${Math.min(endIndex, totalRows)} dari ${totalRows} data.`;

        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        paginationControls.innerHTML = '';
        if (totalPages <= 1) return;

        const createPageItem = (label, page, disabled = false, active = false) => {
            const li = document.createElement('li');
            li.className = `page-item ${disabled ? 'disabled' : ''} ${active ? 'active' : ''}`;
            li.innerHTML = `<a class="page-link" href="#">${label}</a>`;
            li.addEventListener('click', e => {
                e.preventDefault();
                if (!disabled) {
                    currentPage = page;
                    updateTable();
                }
            });
            return li;
        };

        paginationControls.appendChild(createPageItem("«", currentPage - 1, currentPage === 1));
        for (let i = 1; i <= totalPages; i++) {
            paginationControls.appendChild(createPageItem(i, i, false, i === currentPage));
        }
        paginationControls.appendChild(createPageItem("»", currentPage + 1, currentPage === totalPages));
    }

    searchInput.addEventListener('keyup', () => { currentPage = 1; updateTable(); });
    itemsPerPageFilter.addEventListener('change', () => { currentPage = 1; updateTable(); });
    document.getElementById('export-pdf-btn').addEventListener('click', () => window.print());

    updateTable(); // Init pagination


    // --- 4. ISI DATA KE MODAL EDIT ---
    const editButtons = document.querySelectorAll(".btn-edit");
    const editModal = new bootstrap.Modal(document.getElementById("editDataModal"));
    const editForm = document.getElementById("editForm");
    const currentImageInfo = document.getElementById("current-image-info");

    editButtons.forEach(btn => {
        btn.addEventListener("click", function () {
            const id = this.dataset.id;
            const kategori = this.dataset.kategori; // foto atau video
            const keterangan = this.dataset.keterangan;
            const fileData = this.dataset.file; // berisi url youtube ATAU nama file .jpg

            document.getElementById("edit-id").value = id;
            document.getElementById("editKategori").value = kategori;
            document.getElementById("edit-keterangan").value = keterangan;
            
            // Trigger perubahan form UI (Foto vs Video)
            editKategori.dispatchEvent(new Event('change'));

            // Mengisi data lama ke input
            if (kategori === 'video') {
                document.getElementById('editInputVideo').value = fileData;
                currentImageInfo.innerHTML = ''; 
            } else {
                document.getElementById('editInputVideo').value = '';
                if (fileData) {
                    currentImageInfo.innerHTML = `<i class="fas fa-image me-1"></i> File saat ini: <b><a href="<?= base_url('uploads/galeri/') ?>${fileData}" target="_blank">${fileData}</a></b>`;
                } else {
                    currentImageInfo.innerHTML = '';
                }
            }

            editForm.action = "<?= site_url('galeri_admin/update/') ?>" + id;
            editModal.show();
        });
    });

});
</script>