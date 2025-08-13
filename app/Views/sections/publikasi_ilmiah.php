<?php
// Data dummy untuk setiap kategori. Seharusnya ini diambil dari database.
$data = [
    'jurnal' => [
        'headers' => ['Judul Artikel', 'Penulis Utama', 'Nama Jurnal', 'Tahun', 'Link/DOI'],
        'rows' => [
            ['AI in Medical Imaging: A Review', 'Dr. Smith', 'Journal of Medical Technology', '2023', '<a href="#">Link</a>'],
            ['IoT for Precision Agriculture', 'Prof. Johnson', 'IEEE Internet of Things Journal', '2024', '<a href="#">Link</a>'],
            ['Big Data for Stock Market Prediction', 'Dr. Williams', 'Journal of Finance and Data Science', '2022', '<a href="#">Link</a>'],
        ]
    ],
    'prosiding' => [
        'headers' => ['Judul Makalah', 'Konferensi', 'Lokasi', 'Tahun', 'Penerbit'],
        'rows' => [
            ['A Novel Approach to IoT Security', 'IEEE ICON-SONICS', 'Bandung, Indonesia', '2023', 'IEEE Xplore'],
            ['Deep Learning for NLP', 'International Conference on AI', 'Virtual', '2024', 'ACM Digital Library'],
        ]
    ],
    'paten' => [
        'headers' => ['Judul Invensi', 'Nomor Paten', 'Inventor Utama', 'Tanggal Diberikan'],
        'rows' => [
            ['Sistem Deteksi Dini Penyakit Tanaman', 'P00202300123', 'Prof. Johnson', '15/06/2023'],
            ['Alat Ukur Kualitas Udara Portabel', 'P00202200456', 'Dr. Williams', '21/11/2022'],
        ]
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

    // Fungsi untuk merender tabel berdasarkan kategori yang dipilih
    function renderTable(category) {
        const data = publicationData[category];
        if (!data) return;

        // Update judul
        const linkText = document.querySelector(`.nav-link[data-content="${category}"]`).textContent;
        contentTitle.textContent = linkText;
        contentSubtitle.textContent = `Daftar ${linkText.toLowerCase()} yang telah dipublikasikan`;

        // Render header tabel
        let headerHtml = '<tr>';
        data.headers.forEach(header => {
            headerHtml += `<th>${header}</th>`;
        });
        headerHtml += '</tr>';
        tableHeader.innerHTML = headerHtml;

        // Render isi tabel
        let bodyHtml = '';
        data.rows.forEach(row => {
            bodyHtml += '<tr>';
            row.forEach(cell => {
                bodyHtml += `<td>${cell}</td>`;
            });
            bodyHtml += '</tr>';
        });
        tableBody.innerHTML = bodyHtml;
    }

    // Event listener untuk setiap link di navigasi tab
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();

            // Hapus kelas 'active' dari semua link
            navLinks.forEach(l => l.classList.remove('active'));
            // Tambahkan kelas 'active' ke link yang diklik
            this.classList.add('active');

            const category = this.getAttribute('data-content');
            renderTable(category);
        });
    });

    // Render tabel awal saat halaman dimuat
    renderTable('jurnal');
});
</script>
