<?php
$user = session('user');

// mapping role
$roles = [
    1 => 'Admin',
    2 => 'Asisten',
    3 => 'Dosen',
    4 => 'Mahasiswa'
];

$roleId   = $user['role_id'] ?? null;
$roleName = $roles[$roleId] ?? null;

$isAdmin   = ($roleName === 'Admin');
$isAsisten = ($roleName === 'Asisten');
$isDosen   = ($roleName === 'Dosen');
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Lab. SSIP' ?></title>
    

    <!-- Bootstrap CSS -->
    <link href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <!-- Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome/css/all.min.css') ?>"/>
    <!-- Custom CSS for new layout -->
    <style>
        body {
            background-color: #f4f7fa;
            overflow-x: hidden; /* Mencegah horizontal scroll */
        }
        
        /* Top Header (Navbar) */
        .top-header {
            background-color: #ffffff;
            padding: 0 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 8/0px;
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
            top: 0;
            left: -280px; /* Sembunyikan di luar layar secara default */
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 30px rgba(0,0,0,0.1);
            transition: left 0.3s ease-in-out;
            z-index: 1002;
            overflow-y: auto;
        }
        .sidebar.active {
            left: 0; /* Tampilkan sidebar */
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
        
        /* === STYLE BARU UNTUK DROPDOWN KE SAMPING === */
        .sidebar-nav .nav-item.dropdown {
            position: relative; /* Diperlukan untuk positioning submenu */
        }
        .sidebar-nav .dropdown-menu {
            position: absolute;
            top: 0;
            left: 100%; /* Muncul di sebelah kanan item induk */
            margin-left: 10px; /* Jarak dari sidebar */
            margin-top: 0;
            min-width: 200px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border: 1px solid #eee;
            border-radius: 8px;
        }
        .sidebar-nav .dropdown-item { padding: 8px 15px; color: #555; border-radius: 8px; }
        .sidebar-nav .dropdown-item:hover { background-color: #eef2f7; }
        /* === AKHIR STYLE BARU === */

        /* Overlay */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
            display: none; /* Sembunyikan secara default */
        }
        .overlay.active {
            display: block; /* Tampilkan saat sidebar aktif */
        }

        /* Main Content */
        .main-content {
            padding: 30px;
            margin-top: 70px; /* Beri jarak dari top header */
        }

        /* Style untuk slider dan footer */
        .hero-section {
            background-color: #334155; /* Warna biru keabu-abuan */
            color: white;
            padding: 100px 0;
            border-radius: 8px;
        }
        .footer {
            background-color: #002366; /* Biru tua */
            color: white;
            padding: 50px 0;
            margin-top: 30px;
        }
        .footer a {
            color: #adb5bd;
            text-decoration: none;
        }
        .footer a:hover {
            color: white;
        }
    </style>
</head>
<body>
<!-- Sidebar Navigation (Hidden by default) -->
<aside class="sidebar">
    <div class="sidebar-header">
        <span>Menu Utama</span>
    </div>

    <ul class="sidebar-nav">

        <!-- ===== MENU UMUM (SELALU TAMPIL, LOGIN / BELUM) ===== -->
        <li class="nav-item">
            <a class="nav-link" href="/penelitian-proyek">
                <i class="fas fa-project-diagram"></i>Penelitian & Proyek
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/publikasi-ilmiah">
                <i class="fas fa-book-open"></i>Publikasi Ilmiah
            </a>
        </li>

        <!-- === DROPDOWN PRAKTIKUM === -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="/jadwal" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-flask"></i>Praktikum
            </a>
            <ul class="dropdown-menu">
                
                <li><a class="dropdown-item" href="/jadwal">Jadwal</a></li>
                <li><a class="dropdown-item" href="/modul_praktikum">Modul</a></li>
                
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/berita">
                <i class="fas fa-newspaper"></i>Berita & Kegiatan
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/rekrutmen">
                <i class="fas fa-bullhorn"></i>Rekrutmen
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/galeri">
                <i class="fa-solid fa-images"></i>Galeri
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/project-lab">
                <i class="fa-solid fa-file-export"></i>Project Lab
            </a>
        </li>

        <!-- ===== DROPDOWN ADMIN (HANYA JIKA LOGIN) ===== -->
        <?php if ($user && ($isAdmin || $isDosen || $isAsisten)): ?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                <i class="fas fa-user-shield"></i> Admin
            </a>
            <ul class="dropdown-menu">

                <?php if ($isAdmin): ?>
                    <li><a class="dropdown-item" href="/asisten_admin">Kelola Users</a></li>
                    <li><a class="dropdown-item" href="/events_admin">Kelola Events</a></li>
                    <li><a class="dropdown-item" href="/rekrutmen_admin">Kelola Rekrutmen</a></li>
                    <li><a class="dropdown-item" href="/berita_admin">Kelola Berita</a></li>
                    <li><a class="dropdown-item" href="/penelitian-proyek_admin">Kelola Penelitian Proyek</a></li>
                    <li><a class="dropdown-item" href="/publikasi-ilmiah_admin">Kelola Publikasi Ilmiah</a></li>
                    <li><a class="dropdown-item" href="/galeri_admin">Kelola Galeri</a></li>
                    <li><a class="dropdown-item" href="/peserta-praktikum_admin">Kelola Nilai</a></li>
                    <li><a class="dropdown-item" href="/modul_praktikum_admin">Kelola Modul</a></li>
                    <li><a class="dropdown-item" href="/jadwal_admin">Kelola Jadwal</a></li>
                    <li><a class="dropdown-item" href="/project-lab_admin">Kelola Project Laboratorium</a></li>
                    <li><a class="dropdown-item" href="/visi-misi_admin">Kelola Content Visi Misi</a></li>

                <?php elseif ($isDosen): ?>
                    <li><a class="dropdown-item" href="/penelitian-proyek_admin">Kelola Penelitian Proyek</a></li>
                    <li><a class="dropdown-item" href="/publikasi-ilmiah_admin">Kelola Publikasi Ilmiah</a></li>
                    <li><a class="dropdown-item" href="/project-lab_admin">Kelola Project Laboratorium</a></li>

                <?php elseif ($isAsisten): ?>
                    <li><a class="dropdown-item" href="/jadwal_admin">Kelola Jadwal</a></li>
                <?php endif; ?>

            </ul>
        </li>
        <?php endif; ?>

    </ul>
</aside>


<!-- Overlay for when sidebar is open -->
<div class="overlay"></div>

<!-- Top Header Navigation -->
<header class="top-header">
    <div class="header-left">
        <i class="fas fa-bars menu-toggle"></i>
        <a class="navbar-brand ms-3 " href="/"">
            <img src="<?= base_url('assets/images/GambarLogo.jpg') ?>" alt="Logo Lab" style="height: 71px;">
        </a>
    </div>
    <ul class="navbar-nav flex-row">
        <li class="nav-item">
            <a class="nav-link" href="/"><i class="fas fa-home me-1"></i>Home</a>
        </li>
        <?php if ($user): ?>
        <li class="nav-item">
            <a class="nav-link" href="/profile"><i class="fas fa-user"></i>Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/logout" onclick="return confirm('Yakin ingin logout?')"><i class="fas fa-right-from-bracket me-1"></i>Logout</a>
        </li>
        <?php else: ?>
        <li class="nav-item">
            <a class="nav-link" href="/login"><i class="fas fa-sign-in-alt me-1"></i>Login</a>
        </li>
        <?php endif; ?>
        <li class="nav-item">
            <a class="nav-link" href="/asisten"><i class="fas fa-users me-1"></i>Anggota</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/contact"><i class="fas fa-address-book me-1"></i>Contact</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/organisasi"><i class="fas fa-address-book me-1"></i>Struktur Organisasi</a>
        </li>
    </ul>
</header>

<!-- Main Content Area -->
<div class="main-content">
    <!-- Konten dari setiap halaman akan dimulai di sini -->

<!-- Bootstrap JS (Path sudah diperbaiki) -->


<script>
document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.querySelector('.menu-toggle');
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.overlay');

    // Fungsi untuk membuka sidebar
    const openSidebar = () => {
        sidebar.classList.add('active');
        overlay.classList.add('active');
    };

    // Fungsi untuk menutup sidebar
    const closeSidebar = () => {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    };

    // Event listener untuk tombol menu
    menuToggle.addEventListener('click', openSidebar);

    // Event listener untuk overlay (menutup sidebar saat diklik)
    overlay.addEventListener('click', closeSidebar);
});
</script>
