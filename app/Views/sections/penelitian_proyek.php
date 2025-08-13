<?php
// Data dummy untuk setiap kategori. Seharusnya ini diambil dari database.
$data = [
    'riset' => [
        'headers' => ['Nama Proyek', 'Ketua Peneliti', 'Status', 'Tahun'],
        'rows' => [
            ['Pengembangan AI untuk Analisis Citra Medis', 'Dr. Smith', 'Selesai', '2023'],
            ['Sistem IoT untuk Smart Agriculture', 'Prof. Johnson', 'Berjalan', '2024'],
            ['Analisis Big Data untuk Prediksi Pasar Saham', 'Dr. Williams', 'Selesai', '2022'],
        ]
    ],
    'kolaborasi' => [
        'headers' => ['Nama Mitra', 'Jenis Kolaborasi', 'Proyek Terkait', 'Durasi'],
        'rows' => [
            ['PT. Teknologi Maju', 'Riset Bersama', 'Sistem IoT', '2023-2025'],
            ['Universitas Sebelah', 'Pertukaran Peneliti', 'AI Medis', '2024'],
            ['GovTech Indonesia', 'Pengembangan Produk', 'Aplikasi Layanan Publik', '2023-2024'],
        ]
    ],
    'pendanaan' => [
        'headers' => ['Sumber Dana', 'Nama Hibah', 'Jumlah', 'Periode'],
        'rows' => [
            ['DIKTI', 'Hibah Penelitian Dasar', 'Rp 150.000.000', '2023'],
            ['LPDP', 'Riset Inovatif Produktif (RISPRO)', 'Rp 300.000.000', '2024-2026'],
            ['Industri XYZ', 'Dana Riset Terapan', 'Rp 75.000.000', '2023'],
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
    <ul class="nav nav-tabs" id="project-nav">
        <li class="nav-item">
            <a class="nav-link active" href="#" data-content="riset">Daftar Proyek Riset</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" data-content="kolaborasi">Kolaborasi Mitra</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" data-content="pendanaan">Pendanaan Riset</a>
        </li>
    </ul>

    <!-- Konten Utama (Tabel Dinamis) -->
    <main class="fm-content card rounded-0 rounded-bottom border-top-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-0" id="content-title">Daftar Proyek Riset</h4>
                    <p class="text-muted small" id="content-subtitle">Daftar proyek riset yang sedang/telah dilakukan</p>
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
    const projectData = <?= json_encode($data) ?>;

    const navLinks = document.querySelectorAll('#project-nav .nav-link');
    const contentTitle = document.getElementById('content-title');
    const contentSubtitle = document.getElementById('content-subtitle');
    const tableHeader = document.getElementById('table-header');
    const tableBody = document.getElementById('table-body');

    // Fungsi untuk merender tabel berdasarkan kategori yang dipilih
    function renderTable(category) {
        const data = projectData[category];
        if (!data) return;

        // Update judul
        const linkText = document.querySelector(`.nav-link[data-content="${category}"]`).textContent;
        contentTitle.textContent = linkText;
        contentSubtitle.textContent = `Data terkait ${linkText}`;

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
    renderTable('riset');
});
</script>
