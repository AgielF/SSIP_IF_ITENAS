-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 05, 2026 at 04:45 AM
-- Server version: 11.8.8-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u203366347_ssip_Itenas`
--

-- --------------------------------------------------------

--
-- Table structure for table `asisten_jadwal`
--

CREATE TABLE `asisten_jadwal` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_jadwal` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `asisten_jadwal`
--

INSERT INTO `asisten_jadwal` (`id`, `id_jadwal`, `id_user`, `created_at`, `updated_at`) VALUES
(1, 1, 6, '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(2, 2, 7, '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(3, 3, 8, '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(4, 4, 9, '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(5, 5, 10, '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(6, 6, 11, '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(7, 7, 12, '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(8, 8, 13, '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(9, 9, 14, '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(10, 10, 15, '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(11, 11, 16, '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(12, 12, 17, '2026-06-23 13:29:43', '2026-06-23 13:29:43');

-- --------------------------------------------------------

--
-- Table structure for table `asisten_periode`
--

CREATE TABLE `asisten_periode` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `id_periode` int(10) UNSIGNED NOT NULL,
  `jabatan` varchar(100) NOT NULL DEFAULT 'Asisten Praktikum',
  `status_tugas` enum('belum selesai','selesai') DEFAULT 'belum selesai',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `asisten_periode`
--

INSERT INTO `asisten_periode` (`id`, `id_user`, `id_periode`, `jabatan`, `status_tugas`, `created_at`, `updated_at`) VALUES
(1, 6, 4, 'Asisten Praktikum', 'belum selesai', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(2, 7, 4, 'Asisten Praktikum', 'belum selesai', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(3, 8, 4, 'Asisten Praktikum', 'belum selesai', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(4, 9, 4, 'Asisten Praktikum', 'belum selesai', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(5, 10, 4, 'Asisten Praktikum', 'belum selesai', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(6, 11, 4, 'Asisten Praktikum', 'belum selesai', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(7, 12, 4, 'Asisten Praktikum', 'belum selesai', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(8, 13, 4, 'Asisten Praktikum', 'belum selesai', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(9, 14, 4, 'Asisten Praktikum', 'belum selesai', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(10, 15, 4, 'Asisten Praktikum', 'belum selesai', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(11, 16, 4, 'Asisten Praktikum', 'belum selesai', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(12, 17, 4, 'Asisten Praktikum', 'belum selesai', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(13, 18, 4, 'Asisten Praktikum', 'belum selesai', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(14, 19, 4, 'Asisten Praktikum', 'belum selesai', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(15, 20, 4, 'Asisten Praktikum', 'belum selesai', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(16, 21, 4, 'Asisten Praktikum', 'belum selesai', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(17, 22, 4, 'Asisten Praktikum', 'belum selesai', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(18, 23, 4, 'Asisten Praktikum', 'belum selesai', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(19, 24, 4, 'Asisten Praktikum', 'belum selesai', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(20, 25, 4, 'Asisten Praktikum', 'belum selesai', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(21, 26, 4, 'Asisten Praktikum', 'belum selesai', '2026-06-23 13:29:43', '2026-06-23 13:29:43');

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id_berita` int(10) UNSIGNED NOT NULL,
  `judul` varchar(100) NOT NULL,
  `konten` text NOT NULL,
  `kategori` enum('seminar','workshop','internal','pengumuman') NOT NULL,
  `tanggal` date NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id_berita`, `judul`, `konten`, `kategori`, `tanggal`, `id_user`, `created_at`, `updated_at`) VALUES
(1, 'Workshop Pengembangan Aplikasi Web Modern', 'Jurusan Informatika akan mengadakan workshop pengembangan aplikasi web modern menggunakan teknologi terbaru. Workshop ini akan diadakan pada tanggal 15 Desember 2024.', 'workshop', '2024-12-15', 1, '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
(2, 'Seminar Nasional Teknologi Informasi 2024', 'Seminar nasional akan menghadirkan pembicara dari berbagai perusahaan teknologi terkemuka. Acara ini terbuka untuk mahasiswa dan dosen.', 'seminar', '2024-11-20', 1, '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
(3, 'Pengumuman Jadwal Ujian Akhir Semester', 'Jadwal ujian akhir semester ganjil tahun akademik 2024/2025 telah diumumkan. Mahasiswa diharapkan memeriksa jadwal masing-masing.', 'pengumuman', '2024-12-01', 1, '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
(4, 'Kegiatan Internal: Rapat Koordinasi Dosen', 'Rapat koordinasi dosen akan diadakan untuk membahas kurikulum dan program kerja semester depan.', 'internal', '2024-12-10', 1, '2026-06-23 13:29:40', '2026-06-23 13:29:40');

-- --------------------------------------------------------

--
-- Table structure for table `config_sertifikat`
--

CREATE TABLE `config_sertifikat` (
  `id` int(11) UNSIGNED NOT NULL,
  `template_gambar` varchar(255) DEFAULT NULL COMMENT 'Path relatif file background sertifikat (JPG/PNG)',
  `judul` varchar(100) DEFAULT NULL,
  `deskripsi_template` text DEFAULT NULL,
  `nama_kepala_lab` varchar(100) DEFAULT NULL,
  `ttd_kepala_lab` varchar(255) DEFAULT NULL COMMENT 'Path relatif file PNG tanda tangan Kepala Lab',
  `nama_ketua_prodi` varchar(100) DEFAULT NULL,
  `ttd_ketua_prodi` varchar(255) DEFAULT NULL COMMENT 'Path relatif file PNG tanda tangan Ketua Prodi',
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `content_visi_misi`
--

CREATE TABLE `content_visi_misi` (
  `id` int(10) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content_visi_misi`
--

INSERT INTO `content_visi_misi` (`id`, `judul`, `isi`, `created_at`, `updated_at`) VALUES
(1, 'Visi', 'To become a center of excellence in the development of smart systems and information processing technology that is innovative, adaptive, and applicable to the needs of society and data-based industry.', NULL, '2026-06-23 13:29:40'),
(2, 'Misi', '1. Organizing educational and practical activities based on smart systems and information processing.\n2. Carrying out innovative research in the fields of AI, machine learning, deep learning, data mining, IR, NLP, and expert systems.\n3. Providing a collaborative platform for lecturers, students, and industry to develop smart data-based solutions.\n4. Encourage scientific publications, research products, and patents based on exploration results in the field of smart systems and data processing.\n5. Building a project-based learning ecosystem that is relevant to the needs of the global workplace and research world.', NULL, '2026-06-23 13:29:40'),
(3, 'Visi', 'To become a center of excellence in the development of smart systems and information processing technology that is innovative, adaptive, and applicable to the needs of society and data-based industry.', NULL, '2026-06-23 14:28:34'),
(4, 'Misi', '1. Organizing educational and practical activities based on smart systems and information processing.\n2. Carrying out innovative research in the fields of AI, machine learning, deep learning, data mining, IR, NLP, and expert systems.\n3. Providing a collaborative platform for lecturers, students, and industry to develop smart data-based solutions.\n4. Encourage scientific publications, research products, and patents based on exploration results in the field of smart systems and data processing.\n5. Building a project-based learning ecosystem that is relevant to the needs of the global workplace and research world.', NULL, '2026-06-23 14:28:34');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id_event` int(10) UNSIGNED NOT NULL,
  `nama_event` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `jenis` enum('praktikum','seminar','lomba','rapat') NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id_event`, `nama_event`, `deskripsi`, `jenis`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Praktikum Machine Learning', 'Praktikum supervised & unsupervised learning algorithms', 'praktikum', 1, '2026-06-23 13:25:35', '2026-06-23 13:25:35'),
(2, 'Deep Learning', 'Praktikum neural networks dan deep learning architectures', 'praktikum', 1, '2026-06-23 13:25:35', '2026-06-23 13:25:35'),
(3, 'Expert Systems', 'Praktikum sistem pakar berbasis rule dan inference engine', 'praktikum', 1, '2026-06-23 13:25:35', '2026-06-23 13:25:35'),
(4, 'Artificial Intelligence', 'Praktikum konsep dasar dan aplikasi artificial intelligence', 'praktikum', 1, '2026-06-23 13:25:35', '2026-06-23 13:25:35'),
(5, 'Smart Systems', 'Praktikum sistem cerdas untuk IoT dan automation', 'praktikum', 1, '2026-06-23 13:25:35', '2026-06-23 13:25:35'),
(6, 'Data Mining', 'Praktikum clustering, classification, dan association rules', 'praktikum', 1, '2026-06-23 13:25:35', '2026-06-23 13:25:35');

-- --------------------------------------------------------

--
-- Table structure for table `galeri_umum`
--

CREATE TABLE `galeri_umum` (
  `id_galeri` int(10) UNSIGNED NOT NULL,
  `kategori` enum('foto','video') NOT NULL,
  `keterangan` text NOT NULL,
  `file_url` text NOT NULL,
  `tanggal_upload` date NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `galeri_umum`
--

INSERT INTO `galeri_umum` (`id_galeri`, `kategori`, `keterangan`, `file_url`, `tanggal_upload`, `id_user`) VALUES
(1, 'video', 'UAV Imagery-Based Potential Forest Fire Detection Using YOLOv10', 'https://www.youtube.com/shorts/jlIaY9cB1Zo', '2026-07-29', 1),
(2, 'video', 'Optimoasi Mikroemulsi sebagai Nanoreaktor untuk Sintesis Nanopartikel (Prediksi Fasa Mikroemulsi)', 'https://youtu.be/qG5TrxC59TQ?si=zxY3SMKa6L6KN6Pc', '2026-07-29', 1),
(3, 'video', 'Aplikasi Prediksi Berat  Buat Tomat Berbasis Deteksi Objek dan Regresi', 'https://youtu.be/hT2O6N_Dq64', '2026-07-29', 1),
(4, 'video', 'Aplikasi Prediksi Penyakit Bronkopneumonia Berbasis Citra X-Ray Menggunakan SVM', 'https://youtu.be/LMLXmEEQXG4', '2026-07-29', 1),
(5, 'video', 'Aplikasi Estimasi Berat Telur Berbasis XGBoost dengan Ekstraksi Fitur Mask R-CNN, HSV, dan RGB', 'https://youtu.be/9PzRqiT_HtQ', '2026-07-29', 1),
(7, 'foto', 'Rapat Koordinasi Pengambilan Sample Perintah Drone', '1785376517_43856a7bb48163886286.jpeg', '2026-07-30', 1),
(8, 'video', 'Aplikasi Hayu-IT (HSAL analysis on YouTube Indonesian Transcripts)', 'https://youtu.be/BCrsZP6ZOLE', '2026-07-30', 1),
(9, 'video', 'The Chair', 'https://youtu.be/4eMc8ab4aLc', '2026-07-30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int(10) UNSIGNED NOT NULL,
  `id_event` int(10) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `id_ruangan` int(10) UNSIGNED DEFAULT NULL,
  `kelas` varchar(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `id_event`, `tanggal`, `waktu_mulai`, `waktu_selesai`, `id_ruangan`, `kelas`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-12-02', '08:00:00', '10:00:00', 1, 'A', '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
(2, 1, '2025-12-09', '13:00:00', '15:00:00', 1, 'B', '2026-06-23 13:29:40', '2026-06-23 14:41:24'),
(3, 2, '2025-12-03', '09:00:00', '11:00:00', 2, 'A', '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
(4, 2, '2025-12-10', '14:00:00', '16:00:00', 2, 'B', '2026-06-23 13:29:40', '2026-07-28 04:02:56'),
(5, 3, '2025-12-04', '10:00:00', '12:00:00', 3, 'A', '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
(6, 3, '2025-12-11', '13:30:00', '15:30:00', 3, 'B', '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
(7, 4, '2025-12-05', '08:30:00', '10:30:00', 4, 'A', '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
(8, 4, '2025-12-12', '14:30:00', '16:30:00', 4, 'B', '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
(9, 5, '2025-12-06', '09:30:00', '11:30:00', 5, 'A', '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
(10, 5, '2025-12-13', '13:00:00', '15:00:00', 5, 'B', '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
(11, 6, '2025-12-07', '10:30:00', '12:30:00', 20, 'A', '2026-06-23 13:29:40', '2026-06-23 14:53:03'),
(12, 6, '2025-12-14', '14:00:00', '16:00:00', 6, 'B', '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
(13, 1, '2025-12-14', '14:00:00', '16:00:00', 3, '', '2026-07-15 18:25:24', '2026-07-15 18:25:24');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(18, '2025-07-24-193450', 'App\\Database\\Migrations\\CreateTableRuangan', 'default', 'App', 1782219818, 1),
(19, '2025-07-24-193451', 'App\\Database\\Migrations\\CreateRolesTable', 'default', 'App', 1782219818, 1),
(20, '2025-07-24-193452', 'App\\Database\\Migrations\\CreateUsersTable', 'default', 'App', 1782219818, 1),
(21, '2025-07-24-193453', 'App\\Database\\Migrations\\CreateEventsTable', 'default', 'App', 1782219818, 1),
(22, '2025-07-24-193454', 'App\\Database\\Migrations\\CreateJadwalTable', 'default', 'App', 1782219818, 1),
(23, '2025-07-24-193455', 'App\\Database\\Migrations\\CreateAsistenJadwalTable', 'default', 'App', 1782219818, 1),
(24, '2025-07-24-193456', 'App\\Database\\Migrations\\CreatePublikasiTable', 'default', 'App', 1782219818, 1),
(25, '2025-07-24-193457', 'App\\Database\\Migrations\\CreatePraktikumTable', 'default', 'App', 1782219818, 1),
(26, '2025-07-24-193458', 'App\\Database\\Migrations\\CreateRekrutTable', 'default', 'App', 1782219818, 1),
(27, '2025-07-24-193459', 'App\\Database\\Migrations\\CreateProyekRisetTable', 'default', 'App', 1782219818, 1),
(28, '2025-07-24-193460', 'App\\Database\\Migrations\\CreateBeritaTable', 'default', 'App', 1782219818, 1),
(29, '2025-07-24-193461', 'App\\Database\\Migrations\\CreateGaleriUmumTable', 'default', 'App', 1782219818, 1),
(30, '2025-07-24-193462', 'App\\Database\\Migrations\\CreateModulPraktikumTable', 'default', 'App', 1782219818, 1),
(31, '2025-07-24-193463', 'App\\Database\\Migrations\\CreatePesertaPraktikumTable', 'default', 'App', 1782219818, 1),
(32, '2025-07-24-193464', 'App\\Database\\Migrations\\CreateContentVisiMisiTable', 'default', 'App', 1782219818, 1),
(33, '2025_10_03_000000', 'App\\Database\\Migrations\\HashExistingPasswords', 'default', 'App', 1782219818, 1),
(34, '2026-01-23-193465', 'App\\Database\\Migrations\\CreateProjectLabTables', 'default', 'App', 1782219818, 1),
(35, '2026-04-28-193466', 'App\\Database\\Migrations\\CreatePeriodeTables', 'default', 'App', 1782219818, 1),
(36, '2026-07-21-143000', 'App\\Database\\Migrations\\AddIndexesForPerformance', 'default', 'App', 1785698800, 2),
(37, '2026-07-22-000205', 'App\\Database\\Migrations\\AddSertifikatFeature', 'default', 'App', 1785698800, 2),
(38, '2026-07-29-045836', 'App\\Database\\Migrations\\AddResearchPlatformsToUsers', 'default', 'App', 1785698800, 2),
(39, '2026-07-29-053533', 'App\\Database\\Migrations\\AddUpdatedAtToModulPraktikum', 'default', 'App', 1785698800, 2),
(40, '2026-07-30-043359', 'App\\Database\\Migrations\\RolePermissions', 'default', 'App', 1785698800, 2),
(41, '2026-07-31-081550', 'App\\Database\\Migrations\\AddFieldsToPublikasi', 'default', 'App', 1785698800, 2);

-- --------------------------------------------------------

--
-- Table structure for table `modul_praktikum`
--

CREATE TABLE `modul_praktikum` (
  `id_modul` int(10) UNSIGNED NOT NULL,
  `judul` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `file_url` text NOT NULL,
  `id_jadwal` int(10) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modul_praktikum`
--

INSERT INTO `modul_praktikum` (`id_modul`, `judul`, `deskripsi`, `file_url`, `id_jadwal`, `created_at`, `updated_at`) VALUES
(1, 'Modul Praktikum Algoritma dan Pemrograman', 'Modul praktikum untuk mata kuliah Algoritma dan Pemrograman semester 1', '/uploads/modul/modul_algoritma.pdf', 1, '2026-06-23 13:29:40', NULL),
(2, 'Modul Praktikum Struktur Data', 'Modul praktikum untuk mata kuliah Struktur Data semester 2', '/uploads/modul/modul_struktur_data.pdf', 2, '2026-06-23 13:29:40', NULL),
(3, 'Modul Praktikum Basis Data', 'Modul praktikum untuk mata kuliah Basis Data semester 3', '/uploads/modul/modul_basis_data.pdf', 3, '2026-06-23 13:29:40', NULL),
(4, 'Modul Praktikum Pemrograman Web', 'Modul praktikum untuk mata kuliah Pemrograman Web semester 4', '/uploads/modul/modul_web.pdf', 4, '2026-06-23 13:29:40', NULL),
(5, 'Test Upload', 'Deskripsi modul', '1785388154_3802d12ec088bae883b4.pdf', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `periode`
--

CREATE TABLE `periode` (
  `id_periode` int(10) UNSIGNED NOT NULL,
  `nama_periode` varchar(50) NOT NULL,
  `tahun` year(4) NOT NULL,
  `status_aktif` enum('aktif','tidak aktif') NOT NULL DEFAULT 'tidak aktif',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `periode`
--

INSERT INTO `periode` (`id_periode`, `nama_periode`, `tahun`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, '2022/2023', '2022', 'tidak aktif', '2026-06-23 13:25:35', '2026-06-23 13:25:35'),
(2, '2023/2024', '2023', 'tidak aktif', '2026-06-23 13:25:35', '2026-06-23 13:25:35'),
(3, '2024/2025', '2024', 'tidak aktif', '2026-06-23 13:25:35', '2026-06-23 13:25:35'),
(4, '2025/2026', '2025', 'tidak aktif', '2026-06-23 13:25:35', '2026-06-23 13:25:35');

-- --------------------------------------------------------

--
-- Table structure for table `peserta_praktikum`
--

CREATE TABLE `peserta_praktikum` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `id_jadwal` int(10) UNSIGNED NOT NULL,
  `status` enum('terdaftar','lulus','tidak lulus') NOT NULL,
  `nilai` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `praktikum`
--

CREATE TABLE `praktikum` (
  `id_prak` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `id_jadwal` int(10) UNSIGNED NOT NULL,
  `galeri_prak` blob DEFAULT NULL,
  `desc_aturan` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_lab`
--

CREATE TABLE `project_lab` (
  `id_project` int(10) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `topik` enum('machine learning','data mining','deep learning','artificial intelligence','expert system','smart system') DEFAULT NULL,
  `status` enum('akan dilaksanakan','sedang dilaksanakan','selesai') NOT NULL DEFAULT 'akan dilaksanakan',
  `teknologi` varchar(255) NOT NULL COMMENT 'Contoh: Python, TensorFlow, IoT',
  `link_repository` varchar(255) DEFAULT NULL,
  `link_deploy` varchar(255) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_lab`
--

INSERT INTO `project_lab` (`id_project`, `judul`, `deskripsi`, `topik`, `status`, `teknologi`, `link_repository`, `link_deploy`, `tanggal_mulai`, `tanggal_selesai`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Sistem Deteksi Hama Tanaman dengan CNN', 'Mengembangkan aplikasi mobile berbasis AI untuk mendeteksi jenis hama pada tanaman padi menggunakan metode Convolutional Neural Network.', 'deep learning', 'sedang dilaksanakan', 'Python, TensorFlow, Flutter', 'https://github.com/lab-ti/deteksi-hama', NULL, '2023-10-01', NULL, 1, '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
(2, 'Smart Dashboard Monitoring Server Lab', 'Dashboard real-time untuk memantau suhu dan load server laboratorium menggunakan ESP32.', 'smart system', 'selesai', 'Laravel, VueJS, MQTT, C++', 'https://github.com/lab-ti/smart-server', 'https://dashboard.lab-ti.ac.id', '2023-01-15', '2023-06-20', 1, '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
(3, 'Sistem Deteksi Hama Tanaman dengan CNN', 'Mengembangkan aplikasi mobile berbasis AI untuk mendeteksi jenis hama pada tanaman padi menggunakan metode Convolutional Neural Network.', 'deep learning', 'sedang dilaksanakan', 'Python, TensorFlow, Flutter', 'https://github.com/lab-ti/deteksi-hama', NULL, '2023-10-01', NULL, 1, '2026-06-23 14:28:34', '2026-06-23 14:28:34'),
(4, 'Smart Dashboard Monitoring Server Lab', 'Dashboard real-time untuk memantau suhu dan load server laboratorium menggunakan ESP32.', 'smart system', 'selesai', 'Laravel, VueJS, MQTT, C++', 'https://github.com/lab-ti/smart-server', 'https://dashboard.lab-ti.ac.id', '2023-01-15', '2023-06-20', 1, '2026-06-23 14:28:34', '2026-06-23 14:28:34');

-- --------------------------------------------------------

--
-- Table structure for table `project_lab_members`
--

CREATE TABLE `project_lab_members` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_project` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `role_project` varchar(50) NOT NULL DEFAULT 'member' COMMENT 'Role spesifik di project: Frontend, Backend, dll',
  `joined_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `proyek_riset`
--

CREATE TABLE `proyek_riset` (
  `id_proyek` int(10) UNSIGNED NOT NULL,
  `judul` varchar(100) NOT NULL,
  `topik` enum('machine learning','data mining','deep learning','artificial intelligence','expert system','smart system') DEFAULT NULL,
  `deskripsi` text NOT NULL,
  `mitra` varchar(100) NOT NULL,
  `sumber_dana` varchar(100) NOT NULL,
  `tahun_mulai` year(4) NOT NULL,
  `tahun_selesai` year(4) NOT NULL,
  `status` enum('akan dilaksanakan','sedang dilaksanakan','selesai') NOT NULL DEFAULT 'akan dilaksanakan',
  `id_user` int(10) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `proyek_riset`
--

INSERT INTO `proyek_riset` (`id_proyek`, `judul`, `topik`, `deskripsi`, `mitra`, `sumber_dana`, `tahun_mulai`, `tahun_selesai`, `status`, `id_user`, `created_at`, `updated_at`) VALUES
(1, 'Smart Access by Face Recognition', 'smart system', 'Penelitian ini mengembangkan sistem buka pintu otomatis menggunakan sistem pengenalan wajah.', '', '', '2024', '2026', 'sedang dilaksanakan', 1, '2026-06-23 14:28:34', '2026-06-23 14:28:34'),
(2, 'Otomatisasi Klasifikasi Kematangan Buah Berdasarkan Semantic Template Warna, Tekstur, dan Shape deng', 'machine learning', 'In this study, we have created a fruit ripeness dataset for 8 categories, namely Ripe Mango, Ripe Tomato, Ripe Orange, Ripe Apple, Unripe Mango, Unripe Tomato, Unripe Orange, and Unripe Apple. Based on the fruit ripeness dataset, we build a classification model of fruit ripeness using the SVM algorithm. Color feature extraction implemented in this study is RGB, HSV, HSL, and L * a * b *. To determine fruit ripeness, we done by predict image input to the model generated. Based on the experiment result, we have found that the best SVM model in determining fruit ripeness is the 6thdegree polynomial kernel and by extracting HSV color features. We evaluated the model generated based on the value of accuracy, precision, recall, and F-Measure. The best performance of our system for accuracy, precision, recall, and F-Measures are 0.76, 0.80, 0.76, and 0.78, respectively.', '', 'Skema: Penelitian Dasar - Dikti', '2018', '2019', 'selesai', 1, '2026-07-30 01:01:15', NULL),
(3, 'Optimasi Mikroemulsi sebagai Nanoreaktor untuk Sintesis Nanopartikel: Pendekatan Machine Learning da', 'machine learning', 'Microemulsion is a stable nanoreactor system, where the type of phase formed is strongly influenced by the composition of oil, surfactant, and metal used. Determination of the microemulsion phase class is generally carried out by laboratory tests, thus requiring large materials and costs as well as a long time. The type of microemulsion phase is very important in the ideal nanoparticle synthesis process. The type of microemulsion phase plays a very important role in producing the size and morphology of nanoparticles. This study aims to predict the phase of microemulsion formation based on the composition of the given emulsion compound. This study proposes 4 (four) methods in predicting the prediction of microemulsion phase formation, namely: K-Nearest Neighbors (KNN), Naive Bayes (NB), Decision Tree (DT), and Support Vector Machine (SVM). In SVM, 4 (four) kernels are proposed, namely: linear, sigmoid, rbf, and poly. To determine the best features of microemulsion phase formation, 3 (three) types of feature selection are used, namely: mutual information (MI), selection feature, and SHAP. To ensure the stability and consistency of the model, 5-fold cross validation is proposed. The dataset used in this study is a primary dataset from experimental results collected directly from various types and amounts of emultant compound compositions for microemulsion phase formation. There are 8 emultant compound features with a total of 162 data. The best model for predicting the microemulsion phase is the SVM kernel poly. The accuracy, precision, recall, and f1-score of the best SVM poly model are each valued at 1.0. Three important features that influence the formation of the microemulsion phase based on MI are surfactant, co-surfactant, and metal. Three important features of microemulsion phase formation based on feature selection are co-surfactant, metal, and oil. Meanwhile, three important features of microemulsion phase formation based on SHAP model SVM poly are surfactant, co-surfactant, and oil. All features used significantly influence the prediction of the microemulsion phase. This is shown in the SVM poly model, where reducing the number of features in microemulsion phase prediction results in decreased model performance.', '', 'Skema: Penelitian Fundamental - Reguler Kemdiktisaintek', '2025', '2025', 'selesai', 1, '2026-07-30 01:03:00', NULL),
(4, 'Pengontrolan Pergerakan Robot Mobil Berbasis EEG P300 dengan Klasifikasi Metode Anfis', 'expert system', '-', '', 'Dikti', '2015', '2015', 'selesai', 1, '2026-07-30 01:04:03', NULL),
(8, 'Optimasi Sistem Kendali Drone Berbasis EEG dengan Machine Learning untuk Aplikasi Pertahanan', 'machine learning', 'Penelitian ini bertujuan untuk mengembangkan sistem kendali drone berbasis Brain-Computer Interface dengan pemanfaatan sinyal EEG dan algoritma Machine Learning guna meningkatkan efektivitas dan efisiensi operasional dalam aplikasi pertahanan. Sistem ini dirancang untuk menginterpretasikan pola aktivitas otak dan menerjemahkannya menjadi perintah kendali drone secara real-time. Tahapan penelitian mencakup pengumpulan dan pemrosesan sinyal EEG, preprocessing sinyal, ekstraksi fitur, serta pengembangan model klasifikasi berbasis Machine Learning, seperti Support Vector Machine (SVM), Random Forest, CNN, GRU, LSTM, Transformer, dan metode lainnya. Model yang telah dilatih diuji dalam lingkungan simulasi kendali drone berbasis pemograman python sebelum diterapkan pada perangkat keras. Untuk meningkatkan portabilitas dan efisiensi kendali real-time, sistem ini diintegrasikan dengan Lab Streaming Layer (LSL) dan Raspberry Pi, memungkinkan pemindahan proses komputasi dari komputer ke perangkat embedded. Evaluasi kinerja dilakukan dengan membandingkan hasil simulasi dan eksperimen nyata, guna mengukur keandalan sistem dalam kondisi operasional yang sebenarnya. Dengan penelitian ini, diharapkan pengembangan sistem kendali drone berbasis EEG dapat memberikan solusi inovatif dalam meningkatkan efektivitas operasi taktis di bidang pertahanan. Hasil penelitian juga berkontribusi dalam pengembangan teknologi BCI yang dapat diterapkan pada berbagai sektor, termasuk sistem kontrol nirkabel dan interaksi manusia-mesin.', 'BRIN - Universitas Mandiri - Mabes TNI Sesko-AU', '', '2026', '2027', 'sedang dilaksanakan', 1, '2026-07-30 01:07:56', NULL),
(9, 'IntelliMart', 'smart system', 'IntelliMart adalah sistem Point of Sale (POS) dan Retail Management System berbasis cloud yang dirancang untuk membantu bisnis ritel, grosir, minimarket, toko kelontong, apotek, dan berbagai jenis usaha lainnya dalam mengelola operasional secara terintegrasi. IntelliMart menggabungkan proses penjualan, pengelolaan inventori, pembelian, pelanggan, pemasok, hingga analisis bisnis dalam satu platform yang mudah digunakan dan dapat diakses secara real-time. Sistem POS modern umumnya mengintegrasikan transaksi, inventaris, pelaporan, dan manajemen pelanggan untuk meningkatkan efisiensi operasional.', '', '', '2026', '2028', 'sedang dilaksanakan', 1, '2026-07-30 01:24:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `publikasi`
--

CREATE TABLE `publikasi` (
  `id_publikasi` int(10) UNSIGNED NOT NULL,
  `jenis_publikasi` enum('jurnal','prosiding','paten') NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `link_publikasi` text NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `topik` enum('machine learning','data mining','deep learning','artificial intelligence','expert system','smart system') DEFAULT NULL,
  `tanggal_publikasi` date NOT NULL,
  `penulis_pendamping` varchar(255) DEFAULT NULL,
  `volume` varchar(50) DEFAULT NULL,
  `nomor` varchar(50) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `link_doi` text DEFAULT NULL,
  `link_gdrive` text DEFAULT NULL,
  `conference` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `lokasi_conference` varchar(255) DEFAULT NULL,
  `publisher_jurnal` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `publikasi`
--

INSERT INTO `publikasi` (`id_publikasi`, `jenis_publikasi`, `judul`, `link_publikasi`, `kategori`, `topik`, `tanggal_publikasi`, `penulis_pendamping`, `volume`, `nomor`, `tahun`, `link_doi`, `link_gdrive`, `conference`, `deskripsi`, `id_user`, `created_at`, `updated_at`, `lokasi_conference`, `publisher_jurnal`) VALUES
(1, 'jurnal', 'Improving multilabel classification of hate speech and abusive language in Indonesian using MAML', 'https://telkomnika.uad.ac.id/index.php/TELKOMNIKA/article/view/27332', 'Jurnal Nasional', 'machine learning', '2026-04-01', 'Rizka Milandga Milenio S.Si., M.T.', '24', '2', '2026', 'http://doi.org/10.12928/telkomnika.v24i2.27332', 'https://drive.google.com/file/d/1tIXlfLJKb9s4rQDamoUuJMuTzLBbc0qX/view', 'TELKOMNIKA (Telecommunication Computing Electronics and Control)', 'Penelitian ini mengkaji deteksi otomatis *multi-label* terhadap ujaran kebencian dan bahasa kasar (HSAL) di media sosial Indonesia, dengan menangani tantangan ketidakseimbangan data, khususnya pada label minoritas.', 1, '2026-06-23 14:28:34', '2026-07-30 01:35:42', NULL, NULL),
(2, 'prosiding', 'Influence of Minimum Support on the Performance of the Apriori Algorithm', 'https://xplorestaging.ieee.org/document/10957599', '', 'machine learning', '2024-10-24', NULL, '1', '1', '2024', '10.1109/ICIC64337.2024.10957599', 'https://drive.google.com/file/d/17z_8VSGe9ysOYZ5CSpTBtVi3I03PuN-b/view?usp=sharing', ' 2024 Ninth International Conference on Informatics and Computing (ICIC)', 'Memahami pola perilaku konsumen merupakan hal yang sangat penting untuk dipertimbangkan guna meningkatkan penjualan. Metode yang sering digunakan untuk menganalisis pola pembelian konsumen adalah metode asosiasi atau *association rule mining*.', 1, '2026-07-30 08:46:35', '2026-07-30 08:46:35', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rekrut`
--

CREATE TABLE `rekrut` (
  `id_rekrut` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `id_jadwal` int(10) UNSIGNED NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `status` enum('dibuka','ditutup') NOT NULL,
  `syarat` text NOT NULL,
  `link_gform` varchar(500) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rekrut`
--

INSERT INTO `rekrut` (`id_rekrut`, `id_user`, `id_jadwal`, `deskripsi`, `status`, `syarat`, `link_gform`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Rekrutmen Asisten Praktikum Algoritma dan Pemrograman', 'dibuka', 'Minimal IPK 3.5, Lulus mata kuliah Algoritma dan Pemrograman dengan nilai minimal B', 'https://forms.google.com/your-form-link-here', '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
(2, 1, 2, 'Rekrutmen Asisten Praktikum Struktur Data', 'dibuka', 'Minimal IPK 3.3, Lulus mata kuliah Struktur Data dengan nilai minimal B+', 'https://forms.google.com/your-form-link-here', '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
(3, 1, 3, 'Rekrutmen Asisten Praktikum Basis Data', 'ditutup', 'Minimal IPK 3.0, Lulus mata kuliah Basis Data dengan nilai minimal B', 'https://forms.google.com/your-form-link-here', '2026-06-23 13:29:40', '2026-06-23 13:29:40');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', NULL, NULL),
(2, 'asisten', NULL, NULL),
(3, 'dosen', NULL, NULL),
(4, 'praktikan', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` int(11) UNSIGNED NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_key` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role_id`, `menu_key`) VALUES
(2, 2, 'jadwal_admin'),
(1, 2, 'jadwal_saya'),
(3, 2, 'sertifikat_klaim'),
(5, 3, 'penelitian_proyek_admin'),
(4, 3, 'project_lab_admin'),
(6, 3, 'publikasi_ilmiah_admin');

-- --------------------------------------------------------

--
-- Table structure for table `ruangan`
--

CREATE TABLE `ruangan` (
  `id_ruangan` int(10) UNSIGNED NOT NULL,
  `nama_ruangan` varchar(100) NOT NULL,
  `kapasitas` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ruangan`
--

INSERT INTO `ruangan` (`id_ruangan`, `nama_ruangan`, `kapasitas`, `created_at`, `updated_at`) VALUES
(1, '2101', 40, '2026-06-23 13:16:45', '2026-06-23 13:16:45'),
(2, '2102', 40, '2026-06-23 13:16:45', '2026-06-23 13:16:45'),
(3, '2103', 40, '2026-06-23 13:16:45', '2026-06-23 13:16:45'),
(4, '2301', 40, '2026-06-23 13:16:45', '2026-06-23 13:16:45'),
(5, '2302', 30, '2026-06-23 13:16:45', '2026-06-23 13:16:45'),
(6, '2303', 30, '2026-06-23 13:16:45', '2026-06-23 13:16:45'),
(7, '2304', 40, '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(8, '2401', 40, '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(9, '2402', 40, '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(10, 'Lab Komputer 4', 40, '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(11, 'Lab Sistem Cerdas', 30, '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(12, 'Lab Data Mining', 30, '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
(15, 'Lab Komputer 3', 40, '2026-06-23 14:28:34', '2026-06-23 14:28:34'),
(19, 'Lab Komputer 5', 35, '2026-06-23 14:44:08', '2026-06-23 14:44:52'),
(20, '4101', 20, '2026-06-23 14:51:43', '2026-06-23 14:51:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `nomor` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `jurusan` varchar(100) NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `sinta_url` varchar(255) DEFAULT NULL,
  `scopus_url` varchar(255) DEFAULT NULL,
  `scholar_url` varchar(255) DEFAULT NULL,
  `orcid_url` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `google_scholar` varchar(255) DEFAULT NULL,
  `sinta` varchar(255) DEFAULT NULL,
  `orcid` varchar(255) DEFAULT NULL,
  `scopus` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nomor`, `nama`, `no_telp`, `jurusan`, `role_id`, `password`, `foto`, `sinta_url`, `scopus_url`, `scholar_url`, `orcid_url`, `created_at`, `updated_at`, `google_scholar`, `sinta`, `orcid`, `scopus`) VALUES
(1, '042609780', 'Dr. Jasman Pardede, S.Si., M.T.', '081234567890', 'Informatika', 1, '$2y$10$TODkqd.59cu4sO9nN7nv6uYR/bv.EcRdJl/xqJGFnSlYj3oWT/PFW', 'uploads/photos/1/1785214217_c4df3751b348d3f77f43.png', 'https://sinta.kemdiktisaintek.go.id/authors/profile/6007088', 'https://www.scopus.com/pages/authors/56532518500', 'https://scholar.google.com/citations?user=tAYtAPoAAAAJ&hl=id&oi=ao', 'https://orcid.org/0000-0001-7773-0296', '2026-06-23 13:25:35', '2026-06-23 14:28:34', NULL, NULL, NULL, NULL),
(6, '152022006', 'Aditya Budi Septiawan', '08123456790', 'Informatika', 2, '$2y$10$jt2Y/4Vgajp4ux8eJgv9g.K9yLboOBa0pMu4tRl9Brojg1KSMNyhC', 'uploads/photos/AdityaBudiSeptiawan.jpg', NULL, NULL, NULL, NULL, '2026-06-23 13:29:40', '2026-06-23 14:28:34', NULL, NULL, NULL, NULL),
(7, '152022007', 'Aliyya Rahmawati Putri', '08123456791', 'Informatika', 2, '$2y$10$DPZHUEhCK1HYBx0ZH6/WR./12h9taRysAb3KJhLb4Wp/u4aYMo/sa', 'uploads/photos/AliyyaRahmawatiPutri.jpg', NULL, NULL, NULL, NULL, '2026-06-23 13:29:40', '2026-06-23 14:28:34', NULL, NULL, NULL, NULL),
(8, '152022008', 'Delisya Pramesti Fitriya', '08123456792', 'Informatika', 2, '$2y$10$3UFbFuw.LGZJa7y7bWQKBewWxDLZSqECM92BIjG0OqJSkNQFEo0/O', 'uploads/photos/DelisyaPramestiFitriya.jpg', NULL, NULL, NULL, NULL, '2026-06-23 13:29:40', '2026-06-23 14:28:34', NULL, NULL, NULL, NULL),
(9, '152022009', 'Dindin Imanudin', '08123456793', 'Informatika', 2, '$2y$10$Mg85FH32mv0bSMQcA3SEI.s3g3torPBevUm0Voced7raRzuvx.R8y', 'uploads/photos/DindinImanudin.jpg', NULL, NULL, NULL, NULL, '2026-06-23 13:29:41', '2026-06-23 14:28:34', NULL, NULL, NULL, NULL),
(10, '152022010', 'Fathurrahman Pratama Putra', '08123456794', 'Informatika', 2, '$2y$10$ofhbTFl3pw5/aSAyeyNIqenrLrL1ovbaPUPY3t0TcQ3iPsz.3H3qi', 'uploads/photos/FathurrahmanPratamaPutra.jpg', NULL, NULL, NULL, NULL, '2026-06-23 13:29:41', '2026-06-23 14:28:34', NULL, NULL, NULL, NULL),
(11, '152022011', 'Felix Angga Resky', '08123456795', 'Informatika', 2, '$2y$10$XkxWEyPGQXryNeNsGdoujOLcwDwZDT7AQaCJdUDwiFgOod75wcuNC', 'uploads/photos/FelixAnggaResky.jpg', NULL, NULL, NULL, NULL, '2026-06-23 13:29:41', '2026-06-23 14:28:34', NULL, NULL, NULL, NULL),
(12, '152022012', 'Ghinova Klarisa Irawadi', '08123456796', 'Informatika', 2, '$2y$10$s0HB1gxXBPI2Rf05xVnsw.ePu12uTd9JDu6dqnW/bamM78JjuFCZ2', 'uploads/photos/GhinovaKlarisaIrawadi.jpg', NULL, NULL, NULL, NULL, '2026-06-23 13:29:41', '2026-06-23 14:28:34', NULL, NULL, NULL, NULL),
(13, '152022013', 'Hikam Hikmatul Huda', '08123456797', 'Informatika', 2, '$2y$10$znc0MPBVjfhdjT5e07BO4.F07MhCS/z3Ks2BYcLklCkOh87u168d6', 'uploads/photos/HikamHikmatulHuda.jpg', NULL, NULL, NULL, NULL, '2026-06-23 13:29:41', '2026-06-23 14:28:34', NULL, NULL, NULL, NULL),
(14, '152022014', 'Moh Ilyas', '08123456798', 'Informatika', 2, '$2y$10$jnyk9kiiX9NX0EoAfCHFl.pGeCZaNKFRibgbzUL40ylFAjRRubN7m', 'uploads/photos/MohIlyas.jpg', NULL, NULL, NULL, NULL, '2026-06-23 13:29:41', '2026-06-23 14:28:34', NULL, NULL, NULL, NULL),
(15, '152022015', 'Muhamad Rizky', '08123456799', 'Informatika', 2, '$2y$10$3SFfxvpT3yjGNi3la1DsOe090XBp4Ga182G0OZmIkZEdjeLEovx3q', 'uploads/photos/MuhamadRizky.jpg', NULL, NULL, NULL, NULL, '2026-06-23 13:29:41', '2026-06-23 14:28:34', NULL, NULL, NULL, NULL),
(16, '152022016', 'Muhammad Hasby As-shiddiqy', '08123456800', 'Informatika', 2, '$2y$10$wIuTQIbVr5b2qiUXLl3ZfOnHZLK4hlSduNKD84CXULs4gZ9Q2/fXu', 'uploads/photos/MuhammadHasbyAs-shiddiqy.jpg', NULL, NULL, NULL, NULL, '2026-06-23 13:29:41', '2026-06-23 14:28:34', NULL, NULL, NULL, NULL),
(17, '152022017', 'Muhammad Rifqi Yusufi', '08123456801', 'Informatika', 2, '$2y$10$HeauJ8Uruz.bIyur/BdoIOC6LBFyGH/6sZBUVowusbZ31/uykSzza', 'uploads/photos/MuhammadRifqiYusufi.jpg', NULL, NULL, NULL, NULL, '2026-06-23 13:29:41', '2026-06-23 14:28:34', NULL, NULL, NULL, NULL),
(18, '152022018', 'Nakhwa Ghinayah Rahadatul Aisy', '08123456802', 'Informatika', 2, '$2y$10$XYfTHojhS4QYIe0l5qJcFuMGQHY33IiiAJFsB/pzLNJzI477DrojC', 'uploads/photos/NakhwaGhinayahRahadatulAisy.jpg', NULL, NULL, NULL, NULL, '2026-06-23 13:29:42', '2026-06-23 14:28:34', NULL, NULL, NULL, NULL),
(19, '152022019', 'Nasywa Adita Zain', '08123456803', 'Informatika', 2, '$2y$10$LzG9xiaCBAEOIokHo6Vi9uCbTKGd5sCFTjHpL9ijToqUzvEVDC3h6', 'uploads/photos/NasywaAditaZain.jpg', NULL, NULL, NULL, NULL, '2026-06-23 13:29:42', '2026-06-23 14:28:34', NULL, NULL, NULL, NULL),
(20, '152022020', 'Nazwa Nur Salsa Bella', '08123456804', 'Informatika', 2, '$2y$10$YICmBTArseKA7N41Z5zSGeZhRgjcshDHLELxpU/Cug.A.C9NGpwQi', 'uploads/photos/NazwaNurSalsaBella.jpg', NULL, NULL, NULL, NULL, '2026-06-23 13:29:42', '2026-06-23 14:28:34', NULL, NULL, NULL, NULL),
(21, '152022021', 'Nizar Abdul Malik', '08123456805', 'Informatika', 2, '$2y$10$0GLCa/nb72ak3yvX8YWPU.46gak6FuhZVlp611MTPTH8Hizh46R.e', 'uploads/photos/NizarAbdulMalik.jpg', NULL, NULL, NULL, NULL, '2026-06-23 13:29:42', '2026-06-23 14:28:34', NULL, NULL, NULL, NULL),
(22, '152022022', 'Raden Muhammad Ariil Al Hafizh', '08123456806', 'Informatika', 2, '$2y$10$feMTn6SaXAunzGnWEhdhG.d2ylFbWs1dFLxPdWuIcJmFyoBh4b2ry', 'uploads/photos/RadenMuhammadAriilAlHafizh.jpg', NULL, NULL, NULL, NULL, '2026-06-23 13:29:42', '2026-06-23 14:28:34', NULL, NULL, NULL, NULL),
(23, '152022023', 'Rizki Saepul Aziz', '08123456807', 'Informatika', 2, '$2y$10$8rtnBheCTorc5ZtLsUmqxOfbFOnMkDohMzDlW6/RGNA1xPJlUYs0y', 'uploads/photos/RizkiSaepulAziz.jpg', NULL, NULL, NULL, NULL, '2026-06-23 13:29:42', '2026-06-23 14:28:34', NULL, NULL, NULL, NULL),
(24, '152022024', 'Sintia Wati', '08123456808', 'Informatika', 2, '$2y$10$smxe.fqky99uLjoE8bHa5.A7Oeb5j5cBds8sadnD9UpmFLSbk6G0C', 'uploads/photos/SintiaWati.jpg', NULL, NULL, NULL, NULL, '2026-06-23 13:29:42', '2026-06-23 14:28:34', NULL, NULL, NULL, NULL),
(25, '152022025', 'Taras Al Fariz', '08123456809', 'Informatika', 2, '$2y$10$mkWnC41YuyeWM3txg0iidusuLHhb/O0hgOzUB8ILNZuTcAI5ym50u', 'uploads/photos/TarasAlFariz.jpg', NULL, NULL, NULL, NULL, '2026-06-23 13:29:42', '2026-06-23 14:28:34', NULL, NULL, NULL, NULL),
(26, '152022026', 'Tedy Sukma Permana', '08123456810', 'Informatika', 2, '$2y$10$Rtv8JpjS3rnnUxpIBCKKgudMAbpsTyAaI90LxGXu/XwdPYswAfmby', 'uploads/photos/TedySukmaPermana.jpg', NULL, NULL, NULL, NULL, '2026-06-23 13:29:43', '2026-06-23 14:28:34', NULL, NULL, NULL, NULL),
(33, '152022101', 'Jeffry', '081234567899', 'Informatika', 1, '$2y$10$TODkqd.59cu4sO9nN7nv6uYR/bv.EcRdJl/xqJGFnSlYj3oWT/PFW', 'uploads/photos/33/1785389974_9444355ca1ececc65e5d.png', '', '', '', '', '2026-07-28 04:25:09', '2026-07-28 04:25:09', NULL, NULL, NULL, NULL),
(34, '041707820', 'Marisa Premitasari S.T., M.T', '', 'informatika', 3, '$2y$12$RcY4Bl0QrxVqBlzdGqKzZe/2sh2ATh/bVq.igcDy2QGSWPcBAT5aK', 'uploads/photos/34/1785213710_4cb02882faee9606e2d7.png', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(35, '042211660', 'Asep Nana Hermana S.T., M.T', '', 'informatika', 3, '$2y$12$M3/ixEe4NLSMdCE79.TSQeLf/Q7N3bu0yPtpjHBfjHtXTJqqjFTxy', 'uploads/photos/35/1785213847_1df71052b6404b1571b5.png', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(36, '965577867', 'Rizka Milandga Milenio S.Si., M.T.', '', 'informatika', 3, '$2y$12$HhO3WUuSxhtlQlHtHCenSu0/j.PB2kRwV8VXUNZZ6cs2hCsW4BFzW', 'uploads/photos/36/1785216167_43796ad6ccfc2237db62.jpeg', 'https://sinta.kemdiktisaintek.go.id/authors/profile/6979154', 'https://www.scopus.com/authid/detail.uri?authorId=60139843300', 'https://scholar.google.com/citations?user=D3rOW7wAAAAJ&hl=en&authuser=2&oi=ao', 'https://orcid.org/0009-0003-0860-5557', NULL, NULL, NULL, NULL, NULL, NULL),
(37, '11837', 'Anisa Putri Setyaningrum S.Kom., M.T.', '', 'informatika', 3, '$2y$12$anqvgngIYVAipPbhvKV0G.z6OUSI2M2zoq2iKM1DCNPlvZPfn2Z2q', 'uploads/photos/37/1785216681_71a56907746a677d79f9.jpeg', 'https://sinta.kemdiktisaintek.go.id/authors/profile/6941557', 'https://www.scopus.com/pages/authors/59703254600', 'https://scholar.google.com/citations?user=XHixseoAAAAJ&hl=id', 'http://orcid.org/0009-0002-1640-5507', NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asisten_jadwal`
--
ALTER TABLE `asisten_jadwal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asisten_jadwal_id_jadwal_foreign` (`id_jadwal`),
  ADD KEY `asisten_jadwal_id_user_foreign` (`id_user`),
  ADD KEY `idx_asisten_jadwal_id_jadwal` (`id_jadwal`),
  ADD KEY `idx_asisten_jadwal_id_user` (`id_user`);

--
-- Indexes for table `asisten_periode`
--
ALTER TABLE `asisten_periode`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asisten_periode_id_user_foreign` (`id_user`),
  ADD KEY `asisten_periode_id_periode_foreign` (`id_periode`),
  ADD KEY `idx_asisten_periode_id_user` (`id_user`),
  ADD KEY `idx_asisten_periode_id_periode` (`id_periode`);

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id_berita`),
  ADD KEY `berita_id_user_foreign` (`id_user`),
  ADD KEY
<truncated 12001 bytes>

NOTE: The output was truncated because it was too long. Use a more targeted query or a smaller range to get the information you need.