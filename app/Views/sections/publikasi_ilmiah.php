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

// Get pagination data if available
$pagination = isset($pagination) ? $pagination : null;
?>
<!-- Debug information - you can remove this after testing -->
<pre>
<?php
echo "Publication data debug:\n";
echo "Jurnal count: " . count($data['jurnal']['rows']) . "\n";
echo "Prosiding count: " . count($data['prosiding']['rows']) . "\n";
echo "Paten count: " . count($data['paten']['rows']) . "\n";
if (isset($pagination)) {
    echo "Pagination info:\n";
    echo "  Page: " . $pagination['page'] . "\n";
    echo "  Limit: " . $pagination['limit'] . "\n";
    echo "  Total: " . $pagination['total'] . "\n";
    echo "  Pages: " . $pagination['pages'] . "\n";
}
?>
</pre>
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
    
    <?php if ($pagination && $pagination['pages'] > 1): ?>
    <!-- Pagination Controls -->
    <nav aria-label="Navigasi halaman publikasi" class="mt-4">
        <ul class="pagination justify-content-center">
            <!-- Previous Button -->
            <?php if ($pagination['page'] > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $pagination['page'] - 1 ?>&limit=<?= $pagination['limit'] ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php else: ?>
                <li class="page-item disabled">
                    <span class="page-link">&laquo;</span>
                </li>
            <?php endif; ?>

            <!-- Page Numbers -->
            <?php
            $start = max(1, $pagination['page'] - 2);
            $end = min($pagination['pages'], $start + 4);
            $start = max(1, $end - 4);
            
            for ($i = $start; $i <= $end; $i++):
            ?>
                <?php if ($i == $pagination['page']): ?>
                    <li class="page-item active">
                        <span class="page-link"><?= $i ?></span>
                    </li>
                <?php else: ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $i ?>&limit=<?= $pagination['limit'] ?>"><?= $i ?></a>
                    </li>
                <?php endif; ?>
            <?php endfor; ?>

            <!-- Next Button -->
            <?php if ($pagination['page'] < $pagination['pages']): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $pagination['page'] + 1 ?>&limit=<?= $pagination['limit'] ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php else: ?>
                <li class="page-item disabled">
                    <span class="page-link">&raquo;</span>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
    
    <!-- Display current page info -->
    <div class="text-center text-muted small mt-2">
        Halaman <?= $pagination['page'] ?> dari <?= $pagination['pages'] ?>
        (Total <?= $pagination['total'] ?> publikasi)
    </div>
    <?php endif; ?>
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
