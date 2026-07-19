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

-- Tambahan eksplisit agar phpMyAdmin di hosting tidak melakukan pengecekan Foreign Key
SET FOREIGN_KEY_CHECKS=0;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ssip.asisten_jadwal: ~0 rows (approximately)

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
	(1, 6, 4, 'Asisten Praktikum', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(2, 7, 4, 'Asisten Praktikum', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(3, 8, 4, 'Asisten Praktikum', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(4, 9, 4, 'Asisten Praktikum', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(5, 10, 4, 'Asisten Praktikum', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(6, 11, 4, 'Asisten Praktikum', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(7, 12, 4, 'Asisten Praktikum', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(8, 13, 4, 'Asisten Praktikum', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(9, 14, 4, 'Asisten Praktikum', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(10, 15, 4, 'Asisten Praktikum', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(11, 16, 4, 'Asisten Praktikum', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(12, 17, 4, 'Asisten Praktikum', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(13, 18, 4, 'Asisten Praktikum', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(14, 19, 4, 'Asisten Praktikum', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(15, 20, 4, 'Asisten Praktikum', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(16, 21, 4, 'Asisten Praktikum', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(17, 22, 4, 'Asisten Praktikum', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(18, 23, 4, 'Asisten Praktikum', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(19, 24, 4, 'Asisten Praktikum', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(20, 25, 4, 'Asisten Praktikum', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(21, 26, 4, 'Asisten Praktikum', '2026-04-30 01:43:12', '2026-04-30 01:43:12');

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
	(1, 'Workshop Pengembangan Aplikasi Web Modern', 'Jurusan Informatika akan mengadakan workshop pengembangan aplikasi web modern menggunakan teknologi terbaru. Workshop ini akan diadakan pada tanggal 15 Desember 2024.', 'workshop', '2024-12-15', 1, '2026-04-30 01:43:11', '2026-04-30 01:43:11'),
	(2, 'Seminar Nasional Teknologi Informasi 2024', 'Seminar nasional akan menghadirkan pembicara dari berbagai perusahaan teknologi terkemuka. Acara ini terbuka untuk mahasiswa dan dosen.', 'seminar', '2024-11-20', 1, '2026-04-30 01:43:11', '2026-04-30 01:43:11'),
	(3, 'Pengumuman Jadwal Ujian Akhir Semester', 'Jadwal ujian akhir semester ganjil tahun akademik 2024/2025 telah diumumkan. Mahasiswa diharapkan memeriksa jadwal masing-masing.', 'pengumuman', '2024-12-01', 1, '2026-04-30 01:43:11', '2026-04-30 01:43:11'),
	(4, 'Kegiatan Internal: Rapat Koordinasi Dosen', 'Rapat koordinasi dosen akan diadakan untuk membahas kurikulum dan program kerja semester depan.', 'internal', '2024-12-10', 1, '2026-04-30 01:43:11', '2026-04-30 01:43:11');

-- Dumping structure for table ssip.content_visi_misi
CREATE TABLE IF NOT EXISTS `content_visi_misi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `isi` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ssip.content_visi_misi: ~2 rows (approximately)
INSERT INTO `content_visi_misi` (`id`, `judul`, `isi`, `created_at`, `updated_at`) VALUES
	(1, 'Visi', 'To become a center of excellence in the development of smart systems and information processing technology that is innovative, adaptive, and applicable to the needs of society and data-based industry.', NULL, '2026-04-30 01:43:11'),
	(2, 'Misi', '1. Organizing educational and practical activities based on smart systems and information processing.\n2. Carrying out innovative research in the fields of AI, machine learning, deep learning, data mining, IR, NLP, and expert systems.\n3. Providing a collaborative platform for lecturers, students, and industry to develop smart data-based solutions.\n4. Encourage scientific publications, research products, and patents based on exploration results in the field of smart systems and data processing.\n5. Building a project-based learning ecosystem that is relevant to the needs of the global workplace and research world.', NULL, '2026-04-30 01:43:11');

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
	(1, 'Praktikum Machine Learning', 'Praktikum supervised & unsupervised learning algorithms', 'praktikum', 1, '2026-04-30 01:41:57', '2026-04-30 01:41:57'),
	(2, 'Deep Learning', 'Praktikum neural networks dan deep learning architectures', 'praktikum', 1, '2026-04-30 01:41:57', '2026-04-30 01:41:57'),
	(3, 'Expert Systems', 'Praktikum sistem pakar berbasis rule dan inference engine', 'praktikum', 1, '2026-04-30 01:41:57', '2026-04-30 01:41:57'),
	(4, 'Artificial Intelligence', 'Praktikum konsep dasar dan aplikasi artificial intelligence', 'praktikum', 1, '2026-04-30 01:41:57', '2026-04-30 01:41:57'),
	(5, 'Smart Systems', 'Praktikum sistem cerdas untuk IoT dan automation', 'praktikum', 1, '2026-04-30 01:41:57', '2026-04-30 01:41:57'),
	(6, 'Data Mining', 'Praktikum clustering, classification, dan association rules', 'praktikum', 1, '2026-04-30 01:41:57', '2026-04-30 01:41:57');

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
  `ruangan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `kelas` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_jadwal`),
  KEY `jadwal_id_event_foreign` (`id_event`),
  CONSTRAINT `jadwal_id_event_foreign` FOREIGN KEY (`id_event`) REFERENCES `events` (`id_event`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ssip.jadwal: ~12 rows (approximately)
INSERT INTO `jadwal` (`id_jadwal`, `id_event`, `tanggal`, `waktu_mulai`, `waktu_selesai`, `ruangan`, `kelas`, `created_at`, `updated_at`) VALUES
	(1, 1, '2025-12-02', '08:00:00', '10:00:00', 'Lab Komputer 1', 'A', '2026-04-30 01:41:57', '2026-04-30 01:41:57'),
	(2, 1, '2025-12-09', '13:00:00', '15:00:00', 'Lab Komputer 1', 'B', '2026-04-30 01:41:57', '2026-04-30 01:41:57'),
	(3, 2, '2025-12-03', '09:00:00', '11:00:00', 'Lab Komputer 2', 'A', '2026-04-30 01:41:57', '2026-04-30 01:41:57'),
	(4, 2, '2025-12-10', '14:00:00', '16:00:00', 'Lab Komputer 2', 'B', '2026-04-30 01:41:57', '2026-04-30 01:41:57'),
	(5, 3, '2025-12-04', '10:00:00', '12:00:00', 'Lab Komputer 3', 'A', '2026-04-30 01:41:57', '2026-04-30 01:41:57'),
	(6, 3, '2025-12-11', '13:30:00', '15:30:00', 'Lab Komputer 3', 'B', '2026-04-30 01:41:57', '2026-04-30 01:41:57'),
	(7, 4, '2025-12-05', '08:30:00', '10:30:00', 'Lab Komputer 4', 'A', '2026-04-30 01:41:57', '2026-04-30 01:41:57'),
	(8, 4, '2025-12-12', '14:30:00', '16:30:00', 'Lab Komputer 4', 'B', '2026-04-30 01:41:57', '2026-04-30 01:41:57'),
	(9, 5, '2025-12-06', '09:30:00', '11:30:00', 'Lab Sistem Cerdas', 'A', '2026-04-30 01:41:57', '2026-04-30 01:41:57'),
	(10, 5, '2025-12-13', '13:00:00', '15:00:00', 'Lab Sistem Cerdas', 'B', '2026-04-30 01:41:57', '2026-04-30 01:41:57'),
	(11, 6, '2025-12-07', '10:30:00', '12:30:00', 'Lab Data Mining', 'A', '2026-04-30 01:41:57', '2026-04-30 01:41:57'),
	(12, 6, '2025-12-14', '14:00:00', '16:00:00', 'Lab Data Mining', 'B', '2026-04-30 01:41:57', '2026-04-30 01:41:57');

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ssip.migrations: ~0 rows (approximately)
INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
	(1, '2025-07-24-193451', 'App\\Database\\Migrations\\CreateRolesTable', 'default', 'App', 1777513300, 1),
	(2, '2025-07-24-193452', 'App\\Database\\Migrations\\CreateUsersTable', 'default', 'App', 1777513300, 1),
	(3, '2025-07-24-193453', 'App\\Database\\Migrations\\CreateEventsTable', 'default', 'App', 1777513300, 1),
	(4, '2025-07-24-193454', 'App\\Database\\Migrations\\CreateJadwalTable', 'default', 'App', 1777513300, 1),
	(5, '2025-07-24-193455', 'App\\Database\\Migrations\\CreateAsistenJadwalTable', 'default', 'App', 1777513300, 1),
	(6, '2025-07-24-193456', 'App\\Database\\Migrations\\CreatePublikasiTable', 'default', 'App', 1777513301, 1),
	(7, '2025-07-24-193457', 'App\\Database\\Migrations\\CreatePraktikumTable', 'default', 'App', 1777513301, 1),
	(8, '2025-07-24-193458', 'App\\Database\\Migrations\\CreateRekrutTable', 'default', 'App', 1777513301, 1),
	(9, '2025-07-24-193459', 'App\\Database\\Migrations\\CreateProyekRisetTable', 'default', 'App', 1777513301, 1),
	(10, '2025-07-24-193460', 'App\\Database\\Migrations\\CreateBeritaTable', 'default', 'App', 1777513301, 1),
	(11, '2025-07-24-193461', 'App\\Database\\Migrations\\CreateGaleriUmumTable', 'default', 'App', 1777513301, 1),
	(12, '2025-07-24-193462', 'App\\Database\\Migrations\\CreateModulPraktikumTable', 'default', 'App', 1777513301, 1),
	(13, '2025-07-24-193463', 'App\\Database\\Migrations\\CreatePesertaPraktikumTable', 'default', 'App', 1777513301, 1),
	(14, '2025-07-24-193464', 'App\\Database\\Migrations\\CreateContentVisiMisiTable', 'default', 'App', 1777513301, 1),
	(15, '2025_10_03_000000', 'App\\Database\\Migrations\\HashExistingPasswords', 'default', 'App', 1777513301, 1),
	(16, '2026-01-23-193465', 'App\\Database\\Migrations\\CreateProjectLabTables', 'default', 'App', 1777513301, 1),
	(17, '2026-04-28-193466', 'App\\Database\\Migrations\\CreatePeriodeTables', 'default', 'App', 1777513301, 1);

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
	(1, 'Modul Praktikum Algoritma dan Pemrograman', 'Modul praktikum untuk mata kuliah Algoritma dan Pemrograman semester 1', '/uploads/modul/modul_algoritma.pdf', 1, '2026-04-30 01:43:11'),
	(2, 'Modul Praktikum Struktur Data', 'Modul praktikum untuk mata kuliah Struktur Data semester 2', '/uploads/modul/modul_struktur_data.pdf', 2, '2026-04-30 01:43:11'),
	(3, 'Modul Praktikum Basis Data', 'Modul praktikum untuk mata kuliah Basis Data semester 3', '/uploads/modul/modul_basis_data.pdf', 3, '2026-04-30 01:43:11'),
	(4, 'Modul Praktikum Pemrograman Web', 'Modul praktikum untuk mata kuliah Pemrograman Web semester 4', '/uploads/modul/modul_web.pdf', 4, '2026-04-30 01:43:11');

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
	(1, '2022/2023', '2022', 'tidak aktif', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(2, '2023/2024', '2023', 'tidak aktif', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(3, '2024/2025', '2024', 'tidak aktif', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(4, '2025/2026', '2025', 'tidak aktif', '2026-04-30 01:43:12', '2026-04-30 01:43:12');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ssip.praktikum: ~4 rows (approximately)
INSERT INTO `praktikum` (`id_prak`, `id_user`, `id_jadwal`, `galeri_prak`, `desc_aturan`, `created_at`, `updated_at`) VALUES
	(2, 2, 1, NULL, 'Praktikum Algoritma dan Pemrograman - Dilarang menggunakan AI untuk coding', '2026-04-30 01:43:11', '2026-04-30 01:43:11'),
	(3, 3, 2, NULL, 'Praktikum Struktur Data - Wajib mengumpulkan laporan dalam format PDF', '2026-04-30 01:43:11', '2026-04-30 01:43:11'),
	(4, 4, 2, NULL, 'Praktikum Struktur Data - Wajib mengumpulkan laporan dalam format PDF', '2026-04-30 01:43:11', '2026-04-30 01:43:11'),
	(5, 5, 3, NULL, 'Praktikum Basis Data - Menggunakan MySQL dan phpMyAdmin', '2026-04-30 01:43:11', '2026-04-30 01:43:11');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ssip.project_lab: ~2 rows (approximately)
INSERT INTO `project_lab` (`id_project`, `judul`, `deskripsi`, `topik`, `status`, `teknologi`, `link_repository`, `link_deploy`, `tanggal_mulai`, `tanggal_selesai`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'Sistem Deteksi Hama Tanaman dengan CNN', 'Mengembangkan aplikasi mobile berbasis AI untuk mendeteksi jenis hama pada tanaman padi menggunakan metode Convolutional Neural Network.', 'deep learning', 'sedang dilaksanakan', 'Python, TensorFlow, Flutter', 'https://github.com/lab-ti/deteksi-hama', NULL, '2023-10-01', NULL, 1, '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(2, 'Smart Dashboard Monitoring Server Lab', 'Dashboard real-time untuk memantau suhu dan load server laboratorium menggunakan ESP32.', 'smart system', 'selesai', 'Laravel, VueJS, MQTT, C++', 'https://github.com/lab-ti/smart-server', 'https://dashboard.lab-ti.ac.id', '2023-01-15', '2023-06-20', 1, '2026-04-30 01:43:12', '2026-04-30 01:43:12');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ssip.project_lab_members: ~3 rows (approximately)
INSERT INTO `project_lab_members` (`id`, `id_project`, `id_user`, `role_project`, `joined_at`) VALUES
	(1, 1, 2, 'AI Engineer', '2026-04-30 01:43:12'),
	(2, 1, 3, 'Mobile Developer', '2026-04-30 01:43:12'),
	(3, 2, 2, 'Fullstack Dev', '2023-01-20 08:00:00');

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
	(1, 'Pengembangan Sistem Informasi Akademik Berbasis Web', 'smart system', 'Penelitian untuk mengembangkan sistem informasi akademik...', 'Universitas Indonesia', 'DIKTI', '2024', '2026', 'sedang dilaksanakan', 1, '2026-04-30 01:43:11', '2026-04-30 01:43:11'),
	(2, 'Implementasi Machine Learning untuk Prediksi Kelulusan Mahasiswa', 'machine learning', 'Penelitian menggunakan algoritma machine learning...', 'Institut Teknologi Bandung', 'LPDP', '2023', '2025', 'akan dilaksanakan', 2, '2026-04-30 01:43:11', '2026-04-30 01:43:11'),
	(3, 'Pengembangan Aplikasi Mobile untuk Monitoring Kesehatan', 'expert system', 'Penelitian pengembangan aplikasi mobile...', 'Rumah Sakit Umum Daerah', 'DIKTI', '2024', '2027', 'sedang dilaksanakan', 4, '2026-04-30 01:43:11', '2026-04-30 01:43:11');

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
	(1, 'jurnal', NULL, 'https://doi.org/10.1000/example1', 'Jurnal Nasional', 'machine learning', '2024-01-15', 'Dr. Budi Santoso, M.Kom', '15', '3', '2024', 'https://doi.org/10.1000/example1', 'https://drive.google.com/file/example1', NULL, 'Penelitian ini membahas penerapan teknologi informasi...', 1, '2026-04-30 01:43:11', '2026-04-30 01:43:11'),
	(2, 'prosiding', NULL, 'https://ieeexplore.ieee.org/example2', 'Konferensi Internasional', 'deep learning', '2024-03-20', 'Dr. Siti Nurhaliza, S.T., M.T.', NULL, NULL, '2024', 'https://doi.org/10.1109/ICCSAT2024.123456', 'https://drive.google.com/file/example2', 'ICCSAT 2024', 'Makalah ini mempresentasikan hasil penelitian...', 2, '2026-04-30 01:43:11', '2026-04-30 01:43:11'),
	(3, 'paten', NULL, 'https://patents.google.com/example3', 'Paten Sederhana', 'smart system', '2024-06-10', 'Prof. Ahmad Rizki, Ph.D.', NULL, NULL, '2024', 'https://doi.org/10.1000/paten123', 'https://drive.google.com/file/example3', NULL, 'Paten ini menjelaskan sistem inovatif...', 3, '2026-04-30 01:43:11', '2026-04-30 01:43:11');

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
	(1, 1, 1, 'Rekrutmen Asisten Praktikum Algoritma dan Pemrograman', 'dibuka', 'Minimal IPK 3.5, Lulus mata kuliah Algoritma dan Pemrograman dengan nilai minimal B', 'https://forms.google.com/your-form-link-here', '2026-04-30 01:43:11', '2026-04-30 01:43:11'),
	(2, 1, 2, 'Rekrutmen Asisten Praktikum Struktur Data', 'dibuka', 'Minimal IPK 3.3, Lulus mata kuliah Struktur Data dengan nilai minimal B+', 'https://forms.google.com/your-form-link-here', '2026-04-30 01:43:11', '2026-04-30 01:43:11'),
	(3, 1, 3, 'Rekrutmen Asisten Praktikum Basis Data', 'ditutup', 'Minimal IPK 3.0, Lulus mata kuliah Basis Data dengan nilai minimal B', 'https://forms.google.com/your-form-link-here', '2026-04-30 01:43:11', '2026-04-30 01:43:11');

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
	(1, '152022001', 'Jasman Pardede', '081234567890', 'Informatika', 1, '$2y$10$nsdZ7QNtatpHS41zFM3V1.UBS6fB58CoD8ajSgNtSb5ec8ry5FFGK', NULL, '2026-04-30 01:41:57', '2026-04-30 01:43:10'),
	(2, '152022005', 'Dr. Eko Prasetyo, Ph.D', '081234567894', 'Informatika', 3, '$2y$10$zjXz1raDIeTGStbhB85GX.TDhd97Jd1zBtw3yhvb8uMalK.k2kaAW', NULL, '2026-04-30 01:43:10', '2026-04-30 01:43:10'),
	(3, '152022002', 'Prof. Siti Nurhaliza, Ph.D', '081234567891', 'Informatika', 3, '$2y$10$q2dRW3j8haXDW8hDFnK4y.XXG1jtgOxfhb4Jisei5vnCOGqBv/5xW', NULL, '2026-04-30 01:43:11', '2026-04-30 01:43:11'),
	(4, '152022003', 'Dr. Budi Santoso, M.T', '081234567892', 'Informatika', 3, '$2y$10$WT0AEI1cp/F3TZi/AdbKWOjTkyvBjNujaGRJUaNrHy3hhCENQgZiO', NULL, '2026-04-30 01:43:11', '2026-04-30 01:43:11'),
	(5, '152022004', 'Dr. Rina Sari, M.Kom', '081234567893', 'Informatika', 3, '$2y$10$gQuT2yQJEDDb.DkQfcLxVOjuGG.t/hr6FswNndYJ1CLdWNd.kauQG', NULL, '2026-04-30 01:43:11', '2026-04-30 01:43:11'),
	(6, '152022006', 'Aditya Budi Septiawan', '08123456790', 'Informatika', 2, '$2y$10$XGxzFiB..Y/hYL.mj4NXs.MQFjixu/Y1pdiBVL3qS91myI578n.bS', 'uploads/photos/AdityaBudiSeptiawan.jpg', '2026-04-30 01:43:11', '2026-04-30 01:43:11'),
	(7, '152022007', 'Aliyya Rahmawati Putri', '08123456791', 'Informatika', 2, '$2y$10$mxGlS2OrXzXnbN3O/5w1WebihiBVd47.hAoB1oGPUvdbeXIlCoJym', 'uploads/photos/AliyyaRahmawatiPutri.jpg', '2026-04-30 01:43:11', '2026-04-30 01:43:11'),
	(8, '152022008', 'Delisya Pramesti Fitriya', '08123456792', 'Informatika', 2, '$2y$10$vniXuK2uneqVCkDuEy2aM.Qo/56xh3klMKktfAiaD0orXYi15VkyS', 'uploads/photos/DelisyaPramestiFitriya.jpg', '2026-04-30 01:43:11', '2026-04-30 01:43:11'),
	(9, '152022009', 'Dindin Imanudin', '08123456793', 'Informatika', 2, '$2y$10$AEp5RNiXQMTBnSFz79WsS.MtQXY98X4vfXeMl0pmdt9Ls9ElKUWJq', 'uploads/photos/DindinImanudin.jpg', '2026-04-30 01:43:11', '2026-04-30 01:43:11'),
	(10, '152022010', 'Fathurrahman Pratama Putra', '08123456794', 'Informatika', 2, '$2y$10$GXMzJf3FvfazQzP3/pDf/O/7J1iggtBfXOAKeMBNacPApVMz1nsxi', 'uploads/photos/FathurrahmanPratamaPutra.jpg', '2026-04-30 01:43:11', '2026-04-30 01:43:11'),
	(11, '152022011', 'Felix Angga Resky', '08123456795', 'Informatika', 2, '$2y$10$3OmSbrK28hkDwv5NiZiovOUDQ2ONOB/jsiE4O/AxXKLdUDCqaf74K', 'uploads/photos/FelixAnggaResky.jpg', '2026-04-30 01:43:11', '2026-04-30 01:43:11'),
	(12, '152022012', 'Ghinova Klarisa Irawadi', '08123456796', 'Informatika', 2, '$2y$10$ROFwekDSOOoCER1skOEo5urFOSknyz3JAmMH3sVUsoyQVMJZWAE9y', 'uploads/photos/GhinovaKlarisaIrawadi.jpg', '2026-04-30 01:43:11', '2026-04-30 01:43:11'),
	(13, '152022013', 'Hikam Hikmatul Huda', '08123456797', 'Informatika', 2, '$2y$10$mBxGSkccD.KAdVTZCC9ib.0S5/jAcECV36/NNtrgjEbkHsnvchuGi', 'uploads/photos/HikamHikmatulHuda.jpg', '2026-04-30 01:43:11', '2026-04-30 01:43:11'),
	(14, '152022014', 'Moh Ilyas', '08123456798', 'Informatika', 2, '$2y$10$TtEW6ONF.w6YNnX77PO1Xepg.exnlAX8Ky8RM4JyE4xTz7KbzSdHK', 'uploads/photos/MohIlyas.jpg', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(15, '152022015', 'Muhamad Rizky', '08123456799', 'Informatika', 2, '$2y$10$D/vKKyM4Fg34X0BUeZGpduQOZQWKXHzenO4GDscgBsMKwZK91Liay', 'uploads/photos/MuhamadRizky.jpg', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(16, '152022016', 'Muhammad Hasby As-shiddiqy', '08123456800', 'Informatika', 2, '$2y$10$.2FHi35Q9bcNwBZPgglB3Of42xm9UH6gbk3ie3ofNn9EXiH6593WW', 'uploads/photos/MuhammadHasbyAs-shiddiqy.jpg', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(17, '152022017', 'Muhammad Rifqi Yusufi', '08123456801', 'Informatika', 2, '$2y$10$Jn2Nl2szQBx.47YBcGRel.todL998yXWIQuI99beEmzeexVaf9MQC', 'uploads/photos/MuhammadRifqiYusufi.jpg', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(18, '152022018', 'Nakhwa Ghinayah Rahadatul Aisy', '08123456802', 'Informatika', 2, '$2y$10$zvMLbwo4DQwzy8Se/rGHdeLSNrNXw/oOyWx48JLL75rJcycQbCN1m', 'uploads/photos/NakhwaGhinayahRahadatulAisy.jpg', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(19, '152022019', 'Nasywa Adita Zain', '08123456803', 'Informatika', 2, '$2y$10$QrhmLoVZ3CKxW8t2LJ6zuuvZOUUe4VUOxNPFr9tTzo.ztyRDSsLLa', 'uploads/photos/NasywaAditaZain.jpg', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(20, '152022020', 'Nazwa Nur Salsa Bella', '08123456804', 'Informatika', 2, '$2y$10$LHWxLxyUSznZb2egsMobfOlr3DNanlUlUU.JRDuk2xMQZezHSY7ky', 'uploads/photos/NazwaNurSalsaBella.jpg', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(21, '152022021', 'Nizar Abdul Malik', '08123456805', 'Informatika', 2, '$2y$10$QREASyOSFB50c0ItGDw./Osp1JwgI5ZdqJdryjzGS.XKQVxxhdXE6', 'uploads/photos/NizarAbdulMalik.jpg', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(22, '152022022', 'Raden Muhammad Ariil Al Hafizh', '08123456806', 'Informatika', 2, '$2y$10$jqMFuPuvUDNU/CDTLejHtOpnmnUqTdlZgj9LeS5br5ts6pYbNou6e', 'uploads/photos/RadenMuhammadAriilAlHafizh.jpg', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(23, '152022023', 'Rizki Saepul Aziz', '08123456807', 'Informatika', 2, '$2y$10$JgJiEOejW6ojFXGXZ..aLOOnhrnyh8pPxvc9ktR5taKm.WCrdUE3O', 'uploads/photos/RizkiSaepulAziz.jpg', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(24, '152022024', 'Sintia Wati', '08123456808', 'Informatika', 2, '$2y$10$Yqx4rVKB1PsyTKPTTM8IkezXdrKI797bo6z0bZ4Kby5TVH1H2kaq2', 'uploads/photos/SintiaWati.jpg', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(25, '152022025', 'Taras Al Fariz', '08123456809', 'Informatika', 2, '$2y$10$xYx28d/C0ZBmjHjteoNaWej4VaQxxbTOKWqZoFgiELifxrn9.7kQW', 'uploads/photos/TarasAlFariz.jpg', '2026-04-30 01:43:12', '2026-04-30 01:43:12'),
	(26, '152022026', 'Tedy Sukma Permana', '08123456810', 'Informatika', 2, '$2y$10$utz67ADox3eUaIqrXgHiDOB8FyYfPdkVmhaYOP2Ct2Vw.C1Emqh/u', 'uploads/photos/TedySukmaPermana.jpg', '2026-04-30 01:43:12', '2026-04-30 01:43:12');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

SET FOREIGN_KEY_CHECKS=1;
