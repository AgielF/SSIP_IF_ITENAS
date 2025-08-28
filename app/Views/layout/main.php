<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Lab. Fisika Dasar' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <!-- Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome/css/all.min.css') ?>"/>

    <!-- Custom CSS for layout -->
    <style>
        body {
            background-color: #f4f7fa;
            overflow-x: hidden;
        }
        .top-header {
            background-color: #ffffff;
            padding: 0 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1001;
        }
        .header-left { display: flex; align-items: center; }
        .menu-toggle { font-size: 1.5rem; color: #333; cursor: pointer; margin-right: 20px; }
        .top-header .navbar-brand img { height: 40px; }
        .sidebar {
            width: 280px;
            height: 100%;
            position: fixed;
            top: 0;
            left: -280px;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 30px rgba(0,0,0,0.1);
            transition: left 0.3s ease-in-out;
            z-index: 1002;
            overflow-y: auto;
        }
        .sidebar.active { left: 0; }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
            display: none;
        }
        .overlay.active { display: block; }
        .main-content {
            padding: 30px;
            margin-top: 70px; /* Jarak dari top header */
        }
    </style>
</head>
<body>

<!-- Memuat komponen header (sidebar & navbar atas) -->
<?= $this->include('layout/header') ?>
<?= $this->include('sections/slider') ?>
<!-- Area Konten Utama -->
<div class="main-content">
    <!-- Di sinilah konten dari setiap halaman akan dimuat -->
    <?= $this->renderSection('content') ?>
</div>

<!-- Memuat komponen footer -->
<?= $this->include('layout/footer') ?>

<!-- Bootstrap JS -->
<script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<!-- Script untuk toggle sidebar -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.querySelector('.menu-toggle');
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.overlay');
    if (menuToggle && sidebar && overlay) {
        const openSidebar = () => {
            sidebar.classList.add('active');
            overlay.classList.add('active');
        };
        const closeSidebar = () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        };
        menuToggle.addEventListener('click', openSidebar);
        overlay.addEventListener('click', closeSidebar);
    }
});
</script>
</body>
</html>
