<?php
$data = isset($publicationData) ? $publicationData : [
    'jurnal' => [
        'headers' => ['Judul Artikel', 'Penulis Utama', 'Penulis Pendamping', 'Nama Jurnal', 'Tahun', 'DOI', 'Link'],
        'rows' => []
    ],
    'prosiding' => [
        'headers' => ['Judul Makalah', 'Konferensi', 'Kategori', 'Tahun', 'Link'],
        'rows' => []
    ],
    'paten' => [
        'headers' => ['Judul Invensi', 'Nomor Paten', 'Inventor Utama', 'Tanggal Diberikan', 'Link'],
        'rows' => []
    ]
];
?>
<style>
    .fm-content {
        padding: 30px;
        background-color: #ffffff;
    }
    .fm-table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
    }
    .fm-table tbody tr:hover {
        background-color: #f8f9fa;
    }
    .nav-tabs .nav-link {
        color: #555;
        font-weight: 500;
    }
    .nav-tabs .nav-link.active {
        color: #0d6efd;
        border-color: #dee2e6 #dee2e6 #fff;
    }
</style>

<div class="container my-5">
    <!-- Navigasi Tab di Atas -->
    <ul class="nav nav-tabs" id="publication-nav">
        <li class="nav-item">
            <a class="nav-link active" href="#" data-content="jurnal">Jurnal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" data-content="prosiding">Prosiding</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" data-content="paten">Paten</a>
        </li>
    </ul>

    <!-- Konten Utama (Tabel Dinamis) -->
    <main class="fm-content card rounded-0 rounded-bottom border-top-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-0" id="content-title">Jurnal</h4>
                    <p class="text-muted small" id="content-subtitle">Daftar jurnal yang telah dipublikasikan</p>
                </div>
                 <div class="d-flex align-items-center">
                    <input type="text" id="searchInput" class="form-control me-2" placeholder="Cari...">
                    <button class="btn btn-primary">Tambah Publikasi</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table fm-table table-hover">
                    <thead id="table-header">
                        <!-- Header tabel akan dirender oleh JavaScript -->
                    </thead>
                    <tbody id="table-body">
                        <!-- Isi tabel akan dirender oleh JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mengambil data PHP dan menyimpannya di variabel JavaScript
    const publicationData = <?= json_encode($data) ?>;

    const navLinks = document.querySelectorAll('#publication-nav .nav-link');
    const contentTitle = document.getElementById('content-title');
    const contentSubtitle = document.getElementById('content-subtitle');
    const tableHeader = document.getElementById('table-header');
    const tableBody = document.getElementById('table-body');
    const searchInput = document.getElementById('searchInput');

    // Fungsi untuk merender tabel berdasarkan kategori yang dipilih
    function renderTable(category) {
        const data = publicationData[category];
        if (!data) return;

        // Update judul
        const linkText = document.querySelector(`.nav-link[data-content="${category}"]`).textContent;
        contentTitle.textContent = linkText;
        contentSubtitle.textContent = `Daftar ${linkText.toLowerCase()} yang telah dipublikasikan`;

        // Render header tabel, tambahkan kolom Aksi
        let headerHtml = '<tr>';
        data.headers.forEach(header => {
            headerHtml += `<th>${header}</th>`;
        });
        headerHtml += '<th>Aksi</th></tr>'; // Tambah header Aksi
        tableHeader.innerHTML = headerHtml;

        // Render isi tabel, tambahkan tombol Aksi
        let bodyHtml = '';
        data.rows.forEach(row => {
            bodyHtml += '<tr>';
            row.forEach(cell => {
                bodyHtml += `<td>${cell}</td>`;
            });
            // Tambah tombol Edit dan Hapus
            bodyHtml += `
                <td>
                    <a href="#" class="btn btn-sm btn-outline-secondary me-1" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="fas fa-trash-alt"></i></a>
                </td>
            `;
            bodyHtml += '</tr>';
        });
        tableBody.innerHTML = bodyHtml;
    }

    // Fungsi untuk filter pencarian
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const rows = tableBody.querySelectorAll('tr');
        rows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            if (rowText.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Event listener untuk setiap link di navigasi tab
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            navLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            const category = this.getAttribute('data-content');
            renderTable(category);
            filterTable(); // Terapkan filter saat tab diganti
        });
    });

    // Event listener untuk input pencarian
    searchInput.addEventListener('keyup', filterTable);

    // Render tabel awal saat halaman dimuat
    renderTable('jurnal');
});
</script>
