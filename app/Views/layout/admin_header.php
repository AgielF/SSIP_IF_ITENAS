<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Admin Panel' ?></title>
    <!-- Favicon Logo Lab -->
    <link rel="icon" type="image/jpeg" href="<?= base_url('assets/images/GambarLogo.jpg') ?>">
    
    <!-- Bootstrap CSS -->
    <link href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <!-- Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/fontawesome/css/all.min.css') ?>"/>

    <!-- Custom CSS for admin layout -->
    <style>
        body {
            background-color: #f4f7fa;
            overflow-x: hidden;
        }
        
        /* Top Header (Navbar) */
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
        .header-left {
            display: flex;
            align-items: center;
        }
        .menu-toggle {
            font-size: 1.5rem;
            color: #333;
            cursor: pointer;
            margin-right: 20px;
        }
        .top-header .navbar-brand img {
            height: 40px;
        }
        .top-header .navbar-nav .nav-link {
            color: #555;
            font-weight: 500;
            margin-left: 20px;
        }
        .top-header .navbar-nav .nav-link:hover {
            color: #0d6efd;
        }

        /* Sidebar (Off-canvas) */
        .sidebar {
            width: 280px;
            height: 100%;
            position: fixed;
            top: 70px; /* Start below top header */
            left: 0;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease-in-out;
            z-index: 1000;
            overflow-y: auto;
        }
        .sidebar.collapsed {
            left: -280px; /* Hide sidebar when collapsed */
        }
        .sidebar-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            font-size: 1.2rem;
            font-weight: 600;
        }
        .sidebar-nav { list-style: none; padding-left: 0; }
        .sidebar-nav .nav-item { margin-bottom: 5px; }
        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: #555;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
        }
        .sidebar-nav .nav-link:hover, .sidebar-nav .nav-link.active {
            background-color: #eef2f7;
            color: #0d6efd;
        }
        .sidebar-nav .nav-link i { width: 20px; margin-right: 15px; text-align: center; }
        
        /* Main Content */
        .main-content {
            padding: 30px;
            margin-top: 70px; /* Space for top header */
            margin-left: 280px; /* Space for sidebar */
            transition: margin-left 0.3s ease-in-out;
        }
        .main-content.full-width {
            margin-left: 0; /* Full width when sidebar is collapsed */
        }

        /* Dashboard cards */
        .card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .card .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
            font-weight: 600;
        }
        
        /* Stats cards */
        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }
        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }
        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }
        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }
    </style>
</head>
<body>

<!-- Sidebar Navigation -->
<aside class="sidebar">
    <div class="sidebar-header">
        <span>Admin Menu</span>
    </div>
    <ul class="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link <?= (uri_string() == 'admin') ? 'active' : '' ?>" href="/admin">
                <i class="fas fa-tachometer-alt"></i>Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= (strpos(uri_string(), 'admin/rekrut') !== false) ? 'active' : '' ?>" href="/admin/rekrut">
                <i class="fas fa-user-plus"></i>Rekrutmen
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= (strpos(uri_string(), 'admin/proyek-riset') !== false) ? 'active' : '' ?>" href="/admin/proyek-riset">
                <i class="fas fa-project-diagram"></i>Proyek Riset
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= (strpos(uri_string(), 'admin/berita') !== false) ? 'active' : '' ?>" href="/admin/berita">
                <i class="fas fa-newspaper"></i>Berita
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= (strpos(uri_string(), 'admin/users') !== false) ? 'active' : '' ?>" href="/admin/users">
                <i class="fas fa-users"></i>Users
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= (strpos(uri_string(), 'admin/roles') !== false) ? 'active' : '' ?>" href="/admin/roles">
                <i class="fas fa-user-tag"></i>Roles
            </a>
        </li>
    </ul>
</aside>

<!-- Top Header Navigation -->
<header class="top-header">
    <div class="header-left">
        <i class="fas fa-bars menu-toggle" id="sidebarToggle"></i>
        <a class="navbar-brand ms-3" href="/admin">
            Admin Panel
        </a>
    </div>
    <ul class="navbar-nav flex-row">
        <li class="nav-item">
            <a class="nav-link" href="/"><i class="fas fa-home me-1"></i>Frontend</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"><i class="fas fa-user me-1"></i>Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"><i class="fas fa-sign-out-alt me-1"></i>Logout</a>
        </li>
    </ul>
</header>

<!-- Main Content Area -->
<div class="main-content" id="mainContent">
    <?= $this->renderSection('content') ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.getElementById('mainContent');

    // Toggle sidebar
    sidebarToggle.addEventListener('click', function () {
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('full-width');
    });
});
</script>
</body>
</html>