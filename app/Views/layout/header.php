<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Lab. Fisika Dasar' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

    <!-- Custom CSS -->
    <style>
        .navbar-brand img {
            height: 40px;
        }
        /* --- KODE BARU (dengan warna solid) --- */
        .hero-section {
          background-color: #334155; /* Warna biru keabu-abuan */
          background-size: cover;
          color: white;
          padding: 100px 0;
}
        .footer {
            background-color: #002366; /* Biru tua */
            color: white;
        }
        .footer a {
            color: #adb5bd;
            text-decoration: none;
        }
        .footer a:hover {
            color: white;
        }
        .social-icons a {
            color: white;
            margin-right: 15px;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="#">
        <!-- Ganti dengan URL logo Anda -->
        <img src="https://placehold.co/150x50/FFFFFF/000000?text=Logo+Lab" alt="Logo Lab. Fisika Dasar">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Asisten</a>
        </li>
          
        <!-- === MULAI BLOK KODE DROPDOWN === -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="praktikumDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-flask"></i> Praktikum
          </a>
          <ul class="dropdown-menu" aria-labelledby="praktikumDropdown">
            <li><a class="dropdown-item" href="#">Peraturan Praktikum</a></li>
            <li><a class="dropdown-item" href="#">Kelompok Praktikum</a></li>
            <li><a class="dropdown-item" href="#">Jadwal Praktikum</a></li>
            <li><a class="dropdown-item" href="#">Nilai Praktikum</a></li>
            <li><a class="dropdown-item" href="#">Modul Praktikum</a></li>
            <li><a class="dropdown-item" href="#">Perizinan Praktikum</a></li>
          </ul>
        </li>
        <!-- === AKHIR BLOK KODE DROPDOWN === -->

        <li class="nav-item">
          <a class="nav-link" href="#">Blog</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Pengumuman</a>
        </li>
        <!-- <li class="nav-item">
          <a class="nav-link" href="#">Download</a>
        </li> -->
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Konten halaman akan dimulai di sini -->
