<!-- Konten halaman berakhir di sini -->

<!-- Footer -->
<footer class="footer pt-5 pb-4">
    <div class="container">
        <div class="row">
            <!-- Kolom 1: Info Lab -->
            <div class="col-md-4 mb-4">
                <h5>LAB SSIP</h5>
                <p class="mb-3">
                    2025 © copyright by Laboratorium SSIP ITENAS. All rights reserved.
                </p>
            </div>
            <!-- Kolom 2: Menu Utama -->
            <div class="col-md-2 mb-4">
                <h5 class="mb-3">Menu Utama</h5>
                <ul class="list-unstyled">
                    <li><a href="/">Home</a></li>
                    <li><a href="/asisten">Anggota</a></li>
                    <li><a href="/galeri">Gallery</a></li>
                    <li><a href="/rekrutmen">Rekrutmen</a></li>
                </ul>
            </div>
            <!-- Kolom 3: Akademik -->
            <div class="col-md-3 mb-4">
                <h5 class="mb-3">Akademik</h5>
                <ul class="list-unstyled">
                    <li><a href="/jadwal">Jadwal Praktikum</a></li>
                    <li><a href="/peserta-praktikum">Nilai Praktikum</a></li>
                    <li><a href="#">Kelompok Praktikum</a></li>
                    <li><a href="/berita">Agenda</a></li>
                    <li><a href="/modul_praktikum">Modul Praktikum</a></li>
                </ul>
            </div>
            <!-- Kolom 4: Hubungi Kami -->
            <div class="col-md-3 mb-4">
                <h5 class="mb-3">Hubungi Kami</h5>
                <p class="small">
                    <strong>Alamat:</strong><br>
                    Gedung 2, Jl. PH.H. Mustofa No.23, Bandung
                </p>
                <p class="small">
                    <strong>Email:</strong><br>
                    labSSIP@itenas.ac.id
                </p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

<!-- Global PDF & Excel Helpers for Data Tables -->
<script>
function printTableOnly(tableId, title = 'Data Export') {
    const table = document.getElementById(tableId);
    if (!table) return;

    // Clone the table
    const clone = table.cloneNode(true);

    // Remove non-printable elements
    const nonPrintables = clone.querySelectorAll('.non-printable');
    nonPrintables.forEach(el => el.remove());

    // Open a new window
    const printWindow = window.open('', '', 'height=600,width=800');
    printWindow.document.write('<html><head><title>' + title + '</title>');
    
    // Add basic Bootstrap table styling
    printWindow.document.write(`
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body { font-family: sans-serif; padding: 20px; background-color: #fff; color: #000; }
            h2 { margin-bottom: 20px; text-align: center; font-size: 1.5rem; font-weight: bold; }
            table { width: 100%; border-collapse: collapse; margin-top: 10px; }
            th, td { padding: 8px; border: 1px solid #dee2e6; text-align: left; vertical-align: middle; }
            th { background-color: #f8f9fa !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .text-center { text-align: center; }
            @media print {
                @page { margin: 1.5cm; }
                body { padding: 0; }
            }
        </style>
    `);
    
    printWindow.document.write('</head><body>');
    printWindow.document.write('<h2>' + title + '</h2>');
    printWindow.document.write(clone.outerHTML);
    printWindow.document.write('</body></html>');
    
    printWindow.document.close();
    printWindow.focus();
    
    setTimeout(() => {
        printWindow.print();
        printWindow.close();
    }, 500);
}

function exportTableToExcel(tableId, filename = '') {
    const table = document.getElementById(tableId);
    if (!table) return;

    const clone = table.cloneNode(true);
    const nonPrintables = clone.querySelectorAll('.non-printable');
    nonPrintables.forEach(el => el.remove());

    const html = `
        <html xmlns:o="urn:schemas-microsoft-com:office:office" 
              xmlns:x="urn:schemas-microsoft-com:office:excel" 
              xmlns="http://www.w3.org/TR/REC-html40">
        <head>
            <meta charset="UTF-8" />
        </head>
        <body>
            ${clone.outerHTML}
        </body>
        </html>`;

    const blob = new Blob([html], { type: 'application/vnd.ms-excel' });
    const link = document.createElement('a');
    if (link.download !== undefined) {
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', (filename || 'export') + '.xls');
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);
    }
}
</script>
</body>
</html>
