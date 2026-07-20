-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table ssip.asisten_jadwal
CREATE TABLE IF NOT EXISTS `asisten_jadwal` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_jadwal` int unsigned NOT NULL,
  `id_user` int unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `asisten_jadwal_id_jadwal_foreign` (`id_jadwal`),
  KEY `asisten_jadwal_id_user_foreign` (`id_user`),
  CONSTRAINT `asisten_jadwal_id_jadwal_foreign` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal` (`id_jadwal`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `asisten_jadwal_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ssip.asisten_jadwal: ~12 rows (approximately)
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

-- Dumping structure for table ssip.asisten_periode
CREATE TABLE IF NOT EXISTS `asisten_periode` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int unsigned NOT NULL,
  `id_periode` int unsigned NOT NULL,
  `jabatan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Asisten Praktikum',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `asisten_periode_id_user_foreign` (`id_user`),
  KEY `asisten_periode_id_periode_foreign` (`id_periode`),
  CONSTRAINT `asisten_periode_id_periode_foreign` FOREIGN KEY (`id_periode`) REFERENCES `periode` (`id_periode`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `asisten_periode_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ssip.asisten_periode: ~21 rows (approximately)
INSERT INTO `asisten_periode` (`id`, `id_user`, `id_periode`, `jabatan`, `created_at`, `updated_at`) VALUES
	(1, 6, 4, 'Asisten Praktikum', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
	(2, 7, 4, 'Asisten Praktikum', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
	(3, 8, 4, 'Asisten Praktikum', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
	(4, 9, 4, 'Asisten Praktikum', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
	(5, 10, 4, 'Asisten Praktikum', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
	(6, 11, 4, 'Asisten Praktikum', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
	(7, 12, 4, 'Asisten Praktikum', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
	(8, 13, 4, 'Asisten Praktikum', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
	(9, 14, 4, 'Asisten Praktikum', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
	(10, 15, 4, 'Asisten Praktikum', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
	(11, 16, 4, 'Asisten Praktikum', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
	(12, 17, 4, 'Asisten Praktikum', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
	(13, 18, 4, 'Asisten Praktikum', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
	(14, 19, 4, 'Asisten Praktikum', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
	(15, 20, 4, 'Asisten Praktikum', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
	(16, 21, 4, 'Asisten Praktikum', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
	(17, 22, 4, 'Asisten Praktikum', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
	(18, 23, 4, 'Asisten Praktikum', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
	(19, 24, 4, 'Asisten Praktikum', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
	(20, 25, 4, 'Asisten Praktikum', '2026-06-23 13:29:43', '2026-06-23 13:29:43'),
	(21, 26, 4, 'Asisten Praktikum', '2026-06-23 13:29:43', '2026-06-23 13:29:43');

-- Dumping structure for table ssip.berita
CREATE TABLE IF NOT EXISTS `berita` (
  `id_berita` int unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `konten` text COLLATE utf8mb4_general_ci NOT NULL,
  `kategori` enum('seminar','workshop','internal','pengumuman') COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal` date NOT NULL,
  `id_user` int unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_berita`),
  KEY `berita_id_user_foreign` (`id_user`),
  CONSTRAINT `berita_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ssip.berita: ~4 rows (approximately)
INSERT INTO `berita` (`id_berita`, `judul`, `konten`, `kategori`, `tanggal`, `id_user`, `created_at`, `updated_at`) VALUES
	(1, 'Workshop Pengembangan Aplikasi Web Modern', 'Jurusan Informatika akan mengadakan workshop pengembangan aplikasi web modern menggunakan teknologi terbaru. Workshop ini akan diadakan pada tanggal 15 Desember 2024.', 'workshop', '2024-12-15', 1, '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
	(2, 'Seminar Nasional Teknologi Informasi 2024', 'Seminar nasional akan menghadirkan pembicara dari berbagai perusahaan teknologi terkemuka. Acara ini terbuka untuk mahasiswa dan dosen.', 'seminar', '2024-11-20', 1, '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
	(3, 'Pengumuman Jadwal Ujian Akhir Semester', 'Jadwal ujian akhir semester ganjil tahun akademik 2024/2025 telah diumumkan. Mahasiswa diharapkan memeriksa jadwal masing-masing.', 'pengumuman', '2024-12-01', 1, '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
	(4, 'Kegiatan Internal: Rapat Koordinasi Dosen', 'Rapat koordinasi dosen akan diadakan untuk membahas kurikulum dan program kerja semester depan.', 'internal', '2024-12-10', 1, '2026-06-23 13:29:40', '2026-06-23 13:29:40');

-- Dumping structure for table ssip.content_visi_misi
CREATE TABLE IF NOT EXISTS `content_visi_misi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `isi` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ssip.content_visi_misi: ~4 rows (approximately)
INSERT INTO `content_visi_misi` (`id`, `judul`, `isi`, `created_at`, `updated_at`) VALUES
	(1, 'Visi', 'To become a center of excellence in the development of smart systems and information processing technology that is innovative, adaptive, and applicable to the needs of society and data-based industry.', NULL, '2026-06-23 13:29:40'),
	(2, 'Misi', '1. Organizing educational and practical activities based on smart systems and information processing.\n2. Carrying out innovative research in the fields of AI, machine learning, deep learning, data mining, IR, NLP, and expert systems.\n3. Providing a collaborative platform for lecturers, students, and industry to develop smart data-based solutions.\n4. Encourage scientific publications, research products, and patents based on exploration results in the field of smart systems and data processing.\n5. Building a project-based learning ecosystem that is relevant to the needs of the global workplace and research world.', NULL, '2026-06-23 13:29:40'),
	(3, 'Visi', 'To become a center of excellence in the development of smart systems and information processing technology that is innovative, adaptive, and applicable to the needs of society and data-based industry.', NULL, '2026-06-23 14:28:34'),
	(4, 'Misi', '1. Organizing educational and practical activities based on smart systems and information processing.\n2. Carrying out innovative research in the fields of AI, machine learning, deep learning, data mining, IR, NLP, and expert systems.\n3. Providing a collaborative platform for lecturers, students, and industry to develop smart data-based solutions.\n4. Encourage scientific publications, research products, and patents based on exploration results in the field of smart systems and data processing.\n5. Building a project-based learning ecosystem that is relevant to the needs of the global workplace and research world.', NULL, '2026-06-23 14:28:34');

-- Dumping structure for table ssip.events
CREATE TABLE IF NOT EXISTS `events` (
  `id_event` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_event` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci NOT NULL,
  `jenis` enum('praktikum','seminar','lomba','rapat') COLLATE utf8mb4_general_ci NOT NULL,
  `created_by` int unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_event`),
  KEY `events_created_by_foreign` (`created_by`),
  CONSTRAINT `events_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ssip.events: ~6 rows (approximately)
INSERT INTO `events` (`id_event`, `nama_event`, `deskripsi`, `jenis`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'Praktikum Machine Learning', 'Praktikum supervised & unsupervised learning algorithms', 'praktikum', 1, '2026-06-23 13:25:35', '2026-06-23 13:25:35'),
	(2, 'Deep Learning', 'Praktikum neural networks dan deep learning architectures', 'praktikum', 1, '2026-06-23 13:25:35', '2026-06-23 13:25:35'),
	(3, 'Expert Systems', 'Praktikum sistem pakar berbasis rule dan inference engine', 'praktikum', 1, '2026-06-23 13:25:35', '2026-06-23 13:25:35'),
	(4, 'Artificial Intelligence', 'Praktikum konsep dasar dan aplikasi artificial intelligence', 'praktikum', 1, '2026-06-23 13:25:35', '2026-06-23 13:25:35'),
	(5, 'Smart Systems', 'Praktikum sistem cerdas untuk IoT dan automation', 'praktikum', 1, '2026-06-23 13:25:35', '2026-06-23 13:25:35'),
	(6, 'Data Mining', 'Praktikum clustering, classification, dan association rules', 'praktikum', 1, '2026-06-23 13:25:35', '2026-06-23 13:25:35');

-- Dumping structure for table ssip.galeri_umum
CREATE TABLE IF NOT EXISTS `galeri_umum` (
  `id_galeri` int unsigned NOT NULL AUTO_INCREMENT,
  `kategori` enum('foto','video') COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci NOT NULL,
  `file_url` text COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_upload` date NOT NULL,
  `id_user` int unsigned NOT NULL,
  PRIMARY KEY (`id_galeri`),
  KEY `galeri_umum_id_user_foreign` (`id_user`),
  CONSTRAINT `galeri_umum_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ssip.galeri_umum: ~4 rows (approximately)
INSERT INTO `galeri_umum` (`id_galeri`, `kategori`, `keterangan`, `file_url`, `tanggal_upload`, `id_user`) VALUES
	(1, 'foto', 'Foto kegiatan praktikum di laboratorium komputer', '/uploads/galeri/praktikum_lab.jpg', '2024-12-01', 1),
	(2, 'video', 'Video dokumentasi seminar teknologi informasi', '/uploads/galeri/seminar_tech.mp4', '2024-11-20', 1),
	(3, 'foto', 'Foto kegiatan workshop coding', '/uploads/galeri/workshop_coding.jpg', '2024-12-05', 2),
	(4, 'foto', 'Foto kegiatan lomba programming', '/uploads/galeri/lomba_programming.jpg', '2024-11-15', 4);

-- Dumping structure for table ssip.jadwal
CREATE TABLE IF NOT EXISTS `jadwal` (
  `id_jadwal` int unsigned NOT NULL AUTO_INCREMENT,
  `id_event` int unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `id_ruangan` int unsigned DEFAULT NULL,
  `kelas` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_jadwal`),
  KEY `jadwal_id_event_foreign` (`id_event`),
  KEY `jadwal_id_ruangan_foreign` (`id_ruangan`),
  CONSTRAINT `jadwal_id_event_foreign` FOREIGN KEY (`id_event`) REFERENCES `events` (`id_event`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `jadwal_id_ruangan_foreign` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangan` (`id_ruangan`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ssip.jadwal: ~12 rows (approximately)
INSERT INTO `jadwal` (`id_jadwal`, `id_event`, `tanggal`, `waktu_mulai`, `waktu_selesai`, `id_ruangan`, `kelas`, `created_at`, `updated_at`) VALUES
	(1, 1, '2025-12-02', '08:00:00', '10:00:00', 1, 'A', '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
	(2, 1, '2025-12-09', '13:00:00', '15:00:00', 1, 'B', '2026-06-23 13:29:40', '2026-06-23 14:41:24'),
	(3, 2, '2025-12-03', '09:00:00', '11:00:00', 2, 'A', '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
	(4, 2, '2025-12-10', '14:00:00', '16:00:00', 2, 'B', '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
	(5, 3, '2025-12-04', '10:00:00', '12:00:00', 3, 'A', '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
	(6, 3, '2025-12-11', '13:30:00', '15:30:00', 3, 'B', '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
	(7, 4, '2025-12-05', '08:30:00', '10:30:00', 4, 'A', '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
	(8, 4, '2025-12-12', '14:30:00', '16:30:00', 4, 'B', '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
	(9, 5, '2025-12-06', '09:30:00', '11:30:00', 5, 'A', '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
	(10, 5, '2025-12-13', '13:00:00', '15:00:00', 5, 'B', '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
	(11, 6, '2025-12-07', '10:30:00', '12:30:00', 20, 'A', '2026-06-23 13:29:40', '2026-06-23 14:53:03'),
	(12, 6, '2025-12-14', '14:00:00', '16:00:00', 6, 'B', '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
	(13, 1, '2025-12-14', '14:00:00', '16:00:00', 3, '', '2026-07-15 18:25:24', '2026-07-15 18:25:24');

-- Dumping structure for table ssip.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ssip.migrations: ~14 rows (approximately)
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
	(35, '2026-04-28-193466', 'App\\Database\\Migrations\\CreatePeriodeTables', 'default', 'App', 1782219818, 1);

-- Dumping structure for table ssip.modul_praktikum
CREATE TABLE IF NOT EXISTS `modul_praktikum` (
  `id_modul` int unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci NOT NULL,
  `file_url` text COLLATE utf8mb4_general_ci NOT NULL,
  `id_jadwal` int unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_modul`),
  KEY `modul_praktikum_id_jadwal_foreign` (`id_jadwal`),
  CONSTRAINT `modul_praktikum_id_jadwal_foreign` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal` (`id_jadwal`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ssip.modul_praktikum: ~4 rows (approximately)
INSERT INTO `modul_praktikum` (`id_modul`, `judul`, `deskripsi`, `file_url`, `id_jadwal`, `created_at`) VALUES
	(1, 'Modul Praktikum Algoritma dan Pemrograman', 'Modul praktikum untuk mata kuliah Algoritma dan Pemrograman semester 1', '/uploads/modul/modul_algoritma.pdf', 1, '2026-06-23 13:29:40'),
	(2, 'Modul Praktikum Struktur Data', 'Modul praktikum untuk mata kuliah Struktur Data semester 2', '/uploads/modul/modul_struktur_data.pdf', 2, '2026-06-23 13:29:40'),
	(3, 'Modul Praktikum Basis Data', 'Modul praktikum untuk mata kuliah Basis Data semester 3', '/uploads/modul/modul_basis_data.pdf', 3, '2026-06-23 13:29:40'),
	(4, 'Modul Praktikum Pemrograman Web', 'Modul praktikum untuk mata kuliah Pemrograman Web semester 4', '/uploads/modul/modul_web.pdf', 4, '2026-06-23 13:29:40');

-- Dumping structure for table ssip.periode
CREATE TABLE IF NOT EXISTS `periode` (
  `id_periode` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_periode` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `tahun` year NOT NULL,
  `status_aktif` enum('aktif','tidak aktif') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'tidak aktif',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_periode`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ssip.periode: ~4 rows (approximately)
INSERT INTO `periode` (`id_periode`, `nama_periode`, `tahun`, `status_aktif`, `created_at`, `updated_at`) VALUES
	(1, '2022/2023', '2022', 'tidak aktif', '2026-06-23 13:25:35', '2026-06-23 13:25:35'),
	(2, '2023/2024', '2023', 'tidak aktif', '2026-06-23 13:25:35', '2026-06-23 13:25:35'),
	(3, '2024/2025', '2024', 'tidak aktif', '2026-06-23 13:25:35', '2026-06-23 13:25:35'),
	(4, '2025/2026', '2025', 'tidak aktif', '2026-06-23 13:25:35', '2026-06-23 13:25:35');

-- Dumping structure for table ssip.peserta_praktikum
CREATE TABLE IF NOT EXISTS `peserta_praktikum` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int unsigned NOT NULL,
  `id_jadwal` int unsigned NOT NULL,
  `status` enum('terdaftar','lulus','tidak lulus') COLLATE utf8mb4_general_ci NOT NULL,
  `nilai` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `peserta_praktikum_id_user_foreign` (`id_user`),
  KEY `peserta_praktikum_id_jadwal_foreign` (`id_jadwal`),
  CONSTRAINT `peserta_praktikum_id_jadwal_foreign` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal` (`id_jadwal`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `peserta_praktikum_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ssip.peserta_praktikum: ~0 rows (approximately)

-- Dumping structure for table ssip.praktikum
CREATE TABLE IF NOT EXISTS `praktikum` (
  `id_prak` int unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int unsigned NOT NULL,
  `id_jadwal` int unsigned NOT NULL,
  `galeri_prak` blob,
  `desc_aturan` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_prak`),
  KEY `praktikum_id_user_foreign` (`id_user`),
  KEY `praktikum_id_jadwal_foreign` (`id_jadwal`),
  CONSTRAINT `praktikum_id_jadwal_foreign` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal` (`id_jadwal`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `praktikum_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ssip.praktikum: ~4 rows (approximately)
INSERT INTO `praktikum` (`id_prak`, `id_user`, `id_jadwal`, `galeri_prak`, `desc_aturan`, `created_at`, `updated_at`) VALUES
	(1, 2, 1, NULL, 'Praktikum Algoritma dan Pemrograman - Dilarang menggunakan AI untuk coding', '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
	(2, 3, 2, NULL, 'Praktikum Struktur Data - Wajib mengumpulkan laporan dalam format PDF', '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
	(3, 4, 2, NULL, 'Praktikum Struktur Data - Wajib mengumpulkan laporan dalam format PDF', '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
	(4, 5, 3, NULL, 'Praktikum Basis Data - Menggunakan MySQL dan phpMyAdmin', '2026-06-23 13:29:40', '2026-06-23 13:29:40');

-- Dumping structure for table ssip.project_lab
CREATE TABLE IF NOT EXISTS `project_lab` (
  `id_project` int unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci NOT NULL,
  `topik` enum('machine learning','data mining','deep learning','artificial intelligence','expert system','smart system') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('akan dilaksanakan','sedang dilaksanakan','selesai') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'akan dilaksanakan',
  `teknologi` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Contoh: Python, TensorFlow, IoT',
  `link_repository` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `link_deploy` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `created_by` int unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_project`),
  KEY `project_lab_created_by_foreign` (`created_by`),
  CONSTRAINT `project_lab_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ssip.project_lab: ~4 rows (approximately)
INSERT INTO `project_lab` (`id_project`, `judul`, `deskripsi`, `topik`, `status`, `teknologi`, `link_repository`, `link_deploy`, `tanggal_mulai`, `tanggal_selesai`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'Sistem Deteksi Hama Tanaman dengan CNN', 'Mengembangkan aplikasi mobile berbasis AI untuk mendeteksi jenis hama pada tanaman padi menggunakan metode Convolutional Neural Network.', 'deep learning', 'sedang dilaksanakan', 'Python, TensorFlow, Flutter', 'https://github.com/lab-ti/deteksi-hama', NULL, '2023-10-01', NULL, 1, '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
	(2, 'Smart Dashboard Monitoring Server Lab', 'Dashboard real-time untuk memantau suhu dan load server laboratorium menggunakan ESP32.', 'smart system', 'selesai', 'Laravel, VueJS, MQTT, C++', 'https://github.com/lab-ti/smart-server', 'https://dashboard.lab-ti.ac.id', '2023-01-15', '2023-06-20', 1, '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
	(3, 'Sistem Deteksi Hama Tanaman dengan CNN', 'Mengembangkan aplikasi mobile berbasis AI untuk mendeteksi jenis hama pada tanaman padi menggunakan metode Convolutional Neural Network.', 'deep learning', 'sedang dilaksanakan', 'Python, TensorFlow, Flutter', 'https://github.com/lab-ti/deteksi-hama', NULL, '2023-10-01', NULL, 1, '2026-06-23 14:28:34', '2026-06-23 14:28:34'),
	(4, 'Smart Dashboard Monitoring Server Lab', 'Dashboard real-time untuk memantau suhu dan load server laboratorium menggunakan ESP32.', 'smart system', 'selesai', 'Laravel, VueJS, MQTT, C++', 'https://github.com/lab-ti/smart-server', 'https://dashboard.lab-ti.ac.id', '2023-01-15', '2023-06-20', 1, '2026-06-23 14:28:34', '2026-06-23 14:28:34');

-- Dumping structure for table ssip.project_lab_members
CREATE TABLE IF NOT EXISTS `project_lab_members` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_project` int unsigned NOT NULL,
  `id_user` int unsigned NOT NULL,
  `role_project` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'member' COMMENT 'Role spesifik di project: Frontend, Backend, dll',
  `joined_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `project_lab_members_id_project_foreign` (`id_project`),
  KEY `project_lab_members_id_user_foreign` (`id_user`),
  CONSTRAINT `project_lab_members_id_project_foreign` FOREIGN KEY (`id_project`) REFERENCES `project_lab` (`id_project`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `project_lab_members_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ssip.project_lab_members: ~6 rows (approximately)
INSERT INTO `project_lab_members` (`id`, `id_project`, `id_user`, `role_project`, `joined_at`) VALUES
	(1, 1, 2, 'AI Engineer', '2026-06-23 13:29:40'),
	(2, 1, 3, 'Mobile Developer', '2026-06-23 13:29:40'),
	(3, 2, 2, 'Fullstack Dev', '2023-01-20 08:00:00'),
	(4, 1, 2, 'AI Engineer', '2026-06-23 14:28:34'),
	(5, 1, 3, 'Mobile Developer', '2026-06-23 14:28:34'),
	(6, 2, 2, 'Fullstack Dev', '2023-01-20 08:00:00');

-- Dumping structure for table ssip.proyek_riset
CREATE TABLE IF NOT EXISTS `proyek_riset` (
  `id_proyek` int unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `topik` enum('machine learning','data mining','deep learning','artificial intelligence','expert system','smart system') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci NOT NULL,
  `mitra` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `sumber_dana` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tahun_mulai` year NOT NULL,
  `tahun_selesai` year NOT NULL,
  `status` enum('akan dilaksanakan','sedang dilaksanakan','selesai') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'akan dilaksanakan',
  `id_user` int unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_proyek`),
  KEY `proyek_riset_id_user_foreign` (`id_user`),
  CONSTRAINT `proyek_riset_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ssip.proyek_riset: ~3 rows (approximately)
INSERT INTO `proyek_riset` (`id_proyek`, `judul`, `topik`, `deskripsi`, `mitra`, `sumber_dana`, `tahun_mulai`, `tahun_selesai`, `status`, `id_user`, `created_at`, `updated_at`) VALUES
	(1, 'Pengembangan Sistem Informasi Akademik Berbasis Web', 'smart system', 'Penelitian untuk mengembangkan sistem informasi akademik...', 'Universitas Indonesia', 'DIKTI', '2024', '2026', 'sedang dilaksanakan', 1, '2026-06-23 14:28:34', '2026-06-23 14:28:34'),
	(2, 'Implementasi Machine Learning untuk Prediksi Kelulusan Mahasiswa', 'machine learning', 'Penelitian menggunakan algoritma machine learning...', 'Institut Teknologi Bandung', 'LPDP', '2023', '2025', 'akan dilaksanakan', 2, '2026-06-23 14:28:34', '2026-06-23 14:28:34'),
	(3, 'Pengembangan Aplikasi Mobile untuk Monitoring Kesehatan', 'expert system', 'Penelitian pengembangan aplikasi mobile...', 'Rumah Sakit Umum Daerah', 'DIKTI', '2024', '2027', 'sedang dilaksanakan', 4, '2026-06-23 14:28:34', '2026-06-23 14:28:34');

-- Dumping structure for table ssip.publikasi
CREATE TABLE IF NOT EXISTS `publikasi` (
  `id_publikasi` int unsigned NOT NULL AUTO_INCREMENT,
  `jenis_publikasi` enum('jurnal','prosiding','paten') COLLATE utf8mb4_general_ci NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `link_publikasi` text COLLATE utf8mb4_general_ci NOT NULL,
  `kategori` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `topik` enum('machine learning','data mining','deep learning','artificial intelligence','expert system','smart system') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_publikasi` date NOT NULL,
  `penulis_pendamping` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `volume` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nomor` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tahun` year DEFAULT NULL,
  `link_doi` text COLLATE utf8mb4_general_ci,
  `link_gdrive` text COLLATE utf8mb4_general_ci,
  `conference` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci,
  `id_user` int unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_publikasi`),
  KEY `publikasi_id_user_foreign` (`id_user`),
  CONSTRAINT `publikasi_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ssip.publikasi: ~3 rows (approximately)
INSERT INTO `publikasi` (`id_publikasi`, `jenis_publikasi`, `judul`, `link_publikasi`, `kategori`, `topik`, `tanggal_publikasi`, `penulis_pendamping`, `volume`, `nomor`, `tahun`, `link_doi`, `link_gdrive`, `conference`, `deskripsi`, `id_user`, `created_at`, `updated_at`) VALUES
	(1, 'jurnal', NULL, 'https://doi.org/10.1000/example1', 'Jurnal Nasional', 'machine learning', '2024-01-15', 'Dr. Budi Santoso, M.Kom', '15', '3', '2024', 'https://doi.org/10.1000/example1', 'https://drive.google.com/file/example1', NULL, 'Penelitian ini membahas penerapan teknologi informasi...', 1, '2026-06-23 14:28:34', '2026-06-23 14:28:34'),
	(2, 'prosiding', NULL, 'https://ieeexplore.ieee.org/example2', 'Konferensi Internasional', 'deep learning', '2024-03-20', 'Dr. Siti Nurhaliza, S.T., M.T.', NULL, NULL, '2024', 'https://doi.org/10.1109/ICCSAT2024.123456', 'https://drive.google.com/file/example2', 'ICCSAT 2024', 'Makalah ini mempresentasikan hasil penelitian...', 2, '2026-06-23 14:28:34', '2026-06-23 14:28:34'),
	(3, 'paten', NULL, 'https://patents.google.com/example3', 'Paten Sederhana', 'smart system', '2024-06-10', 'Prof. Ahmad Rizki, Ph.D.', NULL, NULL, '2024', 'https://doi.org/10.1000/paten123', 'https://drive.google.com/file/example3', NULL, 'Paten ini menjelaskan sistem inovatif...', 3, '2026-06-23 14:28:34', '2026-06-23 14:28:34');

-- Dumping structure for table ssip.rekrut
CREATE TABLE IF NOT EXISTS `rekrut` (
  `id_rekrut` int unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int unsigned NOT NULL,
  `id_jadwal` int unsigned NOT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('dibuka','ditutup') COLLATE utf8mb4_general_ci NOT NULL,
  `syarat` text COLLATE utf8mb4_general_ci NOT NULL,
  `link_gform` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_rekrut`),
  KEY `rekrut_id_user_foreign` (`id_user`),
  KEY `rekrut_id_jadwal_foreign` (`id_jadwal`),
  CONSTRAINT `rekrut_id_jadwal_foreign` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal` (`id_jadwal`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rekrut_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ssip.rekrut: ~3 rows (approximately)
INSERT INTO `rekrut` (`id_rekrut`, `id_user`, `id_jadwal`, `deskripsi`, `status`, `syarat`, `link_gform`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 'Rekrutmen Asisten Praktikum Algoritma dan Pemrograman', 'dibuka', 'Minimal IPK 3.5, Lulus mata kuliah Algoritma dan Pemrograman dengan nilai minimal B', 'https://forms.google.com/your-form-link-here', '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
	(2, 1, 2, 'Rekrutmen Asisten Praktikum Struktur Data', 'dibuka', 'Minimal IPK 3.3, Lulus mata kuliah Struktur Data dengan nilai minimal B+', 'https://forms.google.com/your-form-link-here', '2026-06-23 13:29:40', '2026-06-23 13:29:40'),
	(3, 1, 3, 'Rekrutmen Asisten Praktikum Basis Data', 'ditutup', 'Minimal IPK 3.0, Lulus mata kuliah Basis Data dengan nilai minimal B', 'https://forms.google.com/your-form-link-here', '2026-06-23 13:29:40', '2026-06-23 13:29:40');

-- Dumping structure for table ssip.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_name` (`role_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ssip.roles: ~4 rows (approximately)
INSERT INTO `roles` (`id`, `role_name`, `created_at`, `updated_at`) VALUES
	(1, 'admin', NULL, NULL),
	(2, 'asisten', NULL, NULL),
	(3, 'dosen', NULL, NULL),
	(4, 'praktikan', NULL, NULL);

-- Dumping structure for table ssip.ruangan
CREATE TABLE IF NOT EXISTS `ruangan` (
  `id_ruangan` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_ruangan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `kapasitas` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_ruangan`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ssip.ruangan: ~15 rows (approximately)
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

-- Dumping structure for table ssip.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nomor` varchar(9) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `no_telp` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `jurusan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `role_id` int unsigned NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nomor` (`nomor`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ssip.users: ~26 rows (approximately)
INSERT INTO `users` (`id`, `nomor`, `nama`, `no_telp`, `jurusan`, `role_id`, `password`, `foto`, `created_at`, `updated_at`) VALUES
	(1, '152022001', 'Jasman Pardede', '081234567890', 'Informatika', 1, '$2y$10$TODkqd.59cu4sO9nN7nv6uYR/bv.EcRdJl/xqJGFnSlYj3oWT/PFW', NULL, '2026-06-23 13:25:35', '2026-06-23 14:28:34'),
	(2, '152022002', 'Prof. Siti Nurhaliza, Ph.D', '081234567891', 'Informatika', 3, '$2y$10$bHuEZ1aawzfS5aqm6eSpZeaOtZKc7cu.8JzIgGZ45PcBfWTNj3yTu', NULL, '2026-06-23 13:25:35', '2026-06-23 14:28:34'),
	(3, '152022003', 'Dr. Budi Santoso, M.T', '081234567892', 'Informatika', 3, '$2y$10$Kr5wykkM2wMGxW.4ZeI6B.rwqTdB6U38VSi2RYqFzU1mQjw3bgbe.', NULL, '2026-06-23 13:25:35', '2026-06-23 14:28:34'),
	(4, '152022004', 'Dr. Rina Sari, M.Kom', '081234567893', 'Informatika', 3, '$2y$10$/9L2nLUjJNzSqt.mNMj9JO4sbtNiOk/Ig6ELtRZshe0/wl4weCvBC', NULL, '2026-06-23 13:25:35', '2026-06-23 14:28:34'),
	(5, '152022005', 'Dr. Eko Prasetyo, Ph.D', '081234567894', 'Informatika', 3, '$2y$10$VsVSv.Dj02soLpM.L9CCvOlsrauwrX9SWJ.TkQavYYAdZ4AoP/7kS', NULL, '2026-06-23 13:25:35', '2026-06-23 14:28:34'),
	(6, '152022006', 'Aditya Budi Septiawan', '08123456790', 'Informatika', 2, '$2y$10$jt2Y/4Vgajp4ux8eJgv9g.K9yLboOBa0pMu4tRl9Brojg1KSMNyhC', 'uploads/photos/AdityaBudiSeptiawan.jpg', '2026-06-23 13:29:40', '2026-06-23 14:28:34'),
	(7, '152022007', 'Aliyya Rahmawati Putri', '08123456791', 'Informatika', 2, '$2y$10$DPZHUEhCK1HYBx0ZH6/WR./12h9taRysAb3KJhLb4Wp/u4aYMo/sa', 'uploads/photos/AliyyaRahmawatiPutri.jpg', '2026-06-23 13:29:40', '2026-06-23 14:28:34'),
	(8, '152022008', 'Delisya Pramesti Fitriya', '08123456792', 'Informatika', 2, '$2y$10$3UFbFuw.LGZJa7y7bWQKBewWxDLZSqECM92BIjG0OqJSkNQFEo0/O', 'uploads/photos/DelisyaPramestiFitriya.jpg', '2026-06-23 13:29:40', '2026-06-23 14:28:34'),
	(9, '152022009', 'Dindin Imanudin', '08123456793', 'Informatika', 2, '$2y$10$Mg85FH32mv0bSMQcA3SEI.s3g3torPBevUm0Voced7raRzuvx.R8y', 'uploads/photos/DindinImanudin.jpg', '2026-06-23 13:29:41', '2026-06-23 14:28:34'),
	(10, '152022010', 'Fathurrahman Pratama Putra', '08123456794', 'Informatika', 2, '$2y$10$ofhbTFl3pw5/aSAyeyNIqenrLrL1ovbaPUPY3t0TcQ3iPsz.3H3qi', 'uploads/photos/FathurrahmanPratamaPutra.jpg', '2026-06-23 13:29:41', '2026-06-23 14:28:34'),
	(11, '152022011', 'Felix Angga Resky', '08123456795', 'Informatika', 2, '$2y$10$XkxWEyPGQXryNeNsGdoujOLcwDwZDT7AQaCJdUDwiFgOod75wcuNC', 'uploads/photos/FelixAnggaResky.jpg', '2026-06-23 13:29:41', '2026-06-23 14:28:34'),
	(12, '152022012', 'Ghinova Klarisa Irawadi', '08123456796', 'Informatika', 2, '$2y$10$s0HB1gxXBPI2Rf05xVnsw.ePu12uTd9JDu6dqnW/bamM78JjuFCZ2', 'uploads/photos/GhinovaKlarisaIrawadi.jpg', '2026-06-23 13:29:41', '2026-06-23 14:28:34'),
	(13, '152022013', 'Hikam Hikmatul Huda', '08123456797', 'Informatika', 2, '$2y$10$znc0MPBVjfhdjT5e07BO4.F07MhCS/z3Ks2BYcLklCkOh87u168d6', 'uploads/photos/HikamHikmatulHuda.jpg', '2026-06-23 13:29:41', '2026-06-23 14:28:34'),
	(14, '152022014', 'Moh Ilyas', '08123456798', 'Informatika', 2, '$2y$10$jnyk9kiiX9NX0EoAfCHFl.pGeCZaNKFRibgbzUL40ylFAjRRubN7m', 'uploads/photos/MohIlyas.jpg', '2026-06-23 13:29:41', '2026-06-23 14:28:34'),
	(15, '152022015', 'Muhamad Rizky', '08123456799', 'Informatika', 2, '$2y$10$3SFfxvpT3yjGNi3la1DsOe090XBp4Ga182G0OZmIkZEdjeLEovx3q', 'uploads/photos/MuhamadRizky.jpg', '2026-06-23 13:29:41', '2026-06-23 14:28:34'),
	(16, '152022016', 'Muhammad Hasby As-shiddiqy', '08123456800', 'Informatika', 2, '$2y$10$wIuTQIbVr5b2qiUXLl3ZfOnHZLK4hlSduNKD84CXULs4gZ9Q2/fXu', 'uploads/photos/MuhammadHasbyAs-shiddiqy.jpg', '2026-06-23 13:29:41', '2026-06-23 14:28:34'),
	(17, '152022017', 'Muhammad Rifqi Yusufi', '08123456801', 'Informatika', 2, '$2y$10$HeauJ8Uruz.bIyur/BdoIOC6LBFyGH/6sZBUVowusbZ31/uykSzza', 'uploads/photos/MuhammadRifqiYusufi.jpg', '2026-06-23 13:29:41', '2026-06-23 14:28:34'),
	(18, '152022018', 'Nakhwa Ghinayah Rahadatul Aisy', '08123456802', 'Informatika', 2, '$2y$10$XYfTHojhS4QYIe0l5qJcFuMGQHY33IiiAJFsB/pzLNJzI477DrojC', 'uploads/photos/NakhwaGhinayahRahadatulAisy.jpg', '2026-06-23 13:29:42', '2026-06-23 14:28:34'),
	(19, '152022019', 'Nasywa Adita Zain', '08123456803', 'Informatika', 2, '$2y$10$LzG9xiaCBAEOIokHo6Vi9uCbTKGd5sCFTjHpL9ijToqUzvEVDC3h6', 'uploads/photos/NasywaAditaZain.jpg', '2026-06-23 13:29:42', '2026-06-23 14:28:34'),
	(20, '152022020', 'Nazwa Nur Salsa Bella', '08123456804', 'Informatika', 2, '$2y$10$YICmBTArseKA7N41Z5zSGeZhRgjcshDHLELxpU/Cug.A.C9NGpwQi', 'uploads/photos/NazwaNurSalsaBella.jpg', '2026-06-23 13:29:42', '2026-06-23 14:28:34'),
	(21, '152022021', 'Nizar Abdul Malik', '08123456805', 'Informatika', 2, '$2y$10$0GLCa/nb72ak3yvX8YWPU.46gak6FuhZVlp611MTPTH8Hizh46R.e', 'uploads/photos/NizarAbdulMalik.jpg', '2026-06-23 13:29:42', '2026-06-23 14:28:34'),
	(22, '152022022', 'Raden Muhammad Ariil Al Hafizh', '08123456806', 'Informatika', 2, '$2y$10$feMTn6SaXAunzGnWEhdhG.d2ylFbWs1dFLxPdWuIcJmFyoBh4b2ry', 'uploads/photos/RadenMuhammadAriilAlHafizh.jpg', '2026-06-23 13:29:42', '2026-06-23 14:28:34'),
	(23, '152022023', 'Rizki Saepul Aziz', '08123456807', 'Informatika', 2, '$2y$10$8rtnBheCTorc5ZtLsUmqxOfbFOnMkDohMzDlW6/RGNA1xPJlUYs0y', 'uploads/photos/RizkiSaepulAziz.jpg', '2026-06-23 13:29:42', '2026-06-23 14:28:34'),
	(24, '152022024', 'Sintia Wati', '08123456808', 'Informatika', 2, '$2y$10$smxe.fqky99uLjoE8bHa5.A7Oeb5j5cBds8sadnD9UpmFLSbk6G0C', 'uploads/photos/SintiaWati.jpg', '2026-06-23 13:29:42', '2026-06-23 14:28:34'),
	(25, '152022025', 'Taras Al Fariz', '08123456809', 'Informatika', 2, '$2y$10$mkWnC41YuyeWM3txg0iidusuLHhb/O0hgOzUB8ILNZuTcAI5ym50u', 'uploads/photos/TarasAlFariz.jpg', '2026-06-23 13:29:42', '2026-06-23 14:28:34'),
	(26, '152022026', 'Tedy Sukma Permana', '08123456810', 'Informatika', 2, '$2y$10$Rtv8JpjS3rnnUxpIBCKKgudMAbpsTyAaI90LxGXu/XwdPYswAfmby', 'uploads/photos/TedySukmaPermana.jpg', '2026-06-23 13:29:43', '2026-06-23 14:28:34');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
