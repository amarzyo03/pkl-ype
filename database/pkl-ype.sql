-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20261115.9ddcb164c3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 17, 2026 at 04:20 AM
-- Server version: 8.4.3
-- PHP Version: 8.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pkl-ype`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--
CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--
CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--
CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_09_10_162327_create_tb_users_table', 1),
(5, '2026_09_12_060817_create_tb_siswa_table', 1),
(6, '2026_09_12_180534_create_tb_jurusan_table', 1),
(7, '2026_09_14_122019_create_tb_kelas_table', 1),
(8, '2026_10_02_115113_create_tb_dudi_table', 1),
(9, '2026_10_03_131042_create_tb_guru_table', 1),
(10, '2026_10_13_170611_create_tb_pendaftaran_table', 1),
(11, '2026_10_20_032608_create_tb_tugas_table', 1),
(12, '2026_10_21_023303_create_tb_tugas_status_table', 1),
(13, '2026_10_22_070640_create_tb_jurnal_table', 1),
(14, '2026_10_23_031201_create_tb_absensi_table', 1),
(15, '2026_11_03_061339_add_user_identity_to_student_activities', 1),
(16, '2026_11_17_082000_normalize_empty_tb_guru_deleted_at', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('2KWViUL9gzSeVXkcaQ1B1hcY3eXMA2MJCBpq8Gsy', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiIxTnJ6VjBCcFZ5S3hacGF3d2FYWk1VeHZlTHQ0WDZNVnJCc21sU3VIIiwiX2ZsYXNoIjp7Im5ldyI6W10sIm9sZCI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvcGtsLXlwZS50ZXN0XC9pZFwvZ3VydVwvanVybmFsIiwicm91dGUiOiJ1c2VyR3VydS5qdXJuYWwifSwiYXV0aF9pZCI6MSwiYXV0aF91c2VybmFtZSI6Im1pa2FlbGEiLCJhdXRoX25hbWUiOiJtaWthZWxhIiwiYXV0aF9yb2xlIjoiYWRtaW4ifQ==', 1794889187);

-- --------------------------------------------------------

--
-- Table structure for table `tb_absensi`
--
CREATE TABLE `tb_absensi` (
  `id` bigint UNSIGNED NOT NULL,
  `id_siswa` int UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('hadir','sakit','izin','alpa','libur') COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_dudi`
--
CREATE TABLE `tb_dudi` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_jurusan` int UNSIGNED NOT NULL,
  `id_guru` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_guru`
--
CREATE TABLE `tb_guru` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_guru`
--

INSERT INTO `tb_guru` (`id`, `nama`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'mikaela, dev', NULL, NULL, NULL),
(2, 'martiti roniasih, s.pd', NULL, NULL, NULL),
(3, 'novianti nutriani, s.pd', NULL, NULL, NULL),
(4, 'neti yulianti, s.pd', NULL, NULL, NULL),
(5, 'panata testi w, s.pd', NULL, NULL, NULL),
(6, 'nurcahyani putri h, se', NULL, NULL, NULL),
(7, 'yuni afidah, s.pd', NULL, NULL, NULL),
(8, 'sri mulyani, s.pd', NULL, NULL, NULL),
(9, 'gentur hanif a, s.t, s.kom', NULL, NULL, NULL),
(10, 'widyaningrum, s.pd.ing', NULL, NULL, NULL),
(11, 'elly kusuma w, s.pd', NULL, NULL, NULL),
(12, 'fauzi alfadlili, s.kom', NULL, NULL, NULL),
(13, 'shelly nur afifah, s.pd', NULL, NULL, NULL),
(14, 'rudi prida I, s.pd, m.pd', NULL, NULL, NULL),
(15, 'wening trisna a, s.pd', NULL, NULL, NULL),
(16, 'syahdudin, s.pd.i', NULL, NULL, NULL),
(17, 'd. odhi rochman t, s.pd', NULL, NULL, NULL),
(18, 'fajar h, s.pd', NULL, NULL, NULL),
(19, 'faizal amri, s.pd', NULL, NULL, NULL),
(20, 'riza desi k, s.pd', NULL, NULL, NULL),
(21, 'anton hermawan, s.pd', NULL, NULL, NULL),
(22, 'primery chita p, s.pd', NULL, NULL, NULL),
(23, 'fidi setiawan, s.pd', NULL, NULL, NULL),
(24, 'karsih, s.kom', NULL, NULL, NULL),
(25, 'yazid afifudin a, s.pd', NULL, NULL, NULL),
(26, 'nugroho brianto, s.pd', NULL, NULL, NULL),
(27, 'ayu wiji lestari, s.pd', NULL, NULL, NULL),
(28, 'miftakhurrohman, s.t', NULL, NULL, NULL),
(29, 'hiri joko ottapa, s.pd', NULL, NULL, NULL),
(30, 'fuad surakhman, s.t', NULL, NULL, NULL),
(31, 'aji munandar, s.pd, m.pd', NULL, NULL, NULL),
(32, 'ani setianingsih, s.ak', NULL, NULL, NULL),
(33, 'refi idha a, s.pd', NULL, NULL, NULL),
(34, 'adis marbatri, s.kom', NULL, NULL, NULL),
(35, 'zainul muttaqin, s.pd', NULL, NULL, NULL),
(36, 'novita setyanti, s.pd', NULL, NULL, NULL),
(37, 'annisa ika m, s,pd', NULL, NULL, NULL),
(38, 'tiffani arum a, s.pd', NULL, NULL, NULL),
(39, 'suhartono, s.pd', NULL, NULL, NULL),
(40, 'lutfy reza, s.pd', NULL, NULL, NULL),
(41, 'annisa putri s, s.kom', NULL, NULL, NULL),
(42, 'arum wijayanti, s.pd', NULL, NULL, NULL),
(43, 'silfi pratiwi, s.pd', NULL, NULL, NULL),
(44, 'sugeng tri m, s.t', NULL, NULL, NULL),
(45, 'atika rohmawati, s.pd', NULL, NULL, NULL),
(46, 'maruf egie a, s.pd', NULL, NULL, NULL),
(47, 'nurmalita muflihah, s.pd', NULL, NULL, NULL),
(48, 'dwi angesti d.p, s.kom', NULL, NULL, NULL),
(49, 'm. ahsanul huluq, s.pd', NULL, NULL, NULL),
(50, 'ahmad ihsan syauqi', NULL, NULL, NULL),
(51, 'atib nurul a, s.pd', NULL, NULL, NULL),
(52, 'sugito, s.pd', NULL, NULL, NULL),
(53, 'anggraeni kartika sari, s.pd', NULL, NULL, NULL),
(54, 'ilham firdaus, s.snb', NULL, NULL, NULL),
(55, 'syifa labibah parmawati, s.pd', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_jurnal`
--
CREATE TABLE `tb_jurnal` (
  `id` bigint UNSIGNED NOT NULL,
  `id_siswa` int UNSIGNED NOT NULL,
  `tanggal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jurusan`
--
CREATE TABLE `tb_jurusan` (
  `id` bigint UNSIGNED NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_jurusan`
--

INSERT INTO `tb_jurusan` (`id`, `kode`, `nama`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'akt', 'akuntansi', NULL, NULL, NULL),
(2, 'mpk', 'manajemen perkantoran', NULL, NULL, NULL),
(3, 'bsr', 'bisnis retail / bisnis digital', NULL, NULL, NULL),
(4, 'tkj', 'teknik komputer dan jaringan', NULL, NULL, NULL),
(5, 'tkr', 'teknik kendaraan ringan', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_kelas`
--
CREATE TABLE `tb_kelas` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_jurusan` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_kelas`
--

INSERT INTO `tb_kelas` (`id`, `nama`, `id_jurusan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'xi akt', 1, NULL, NULL, NULL),
(2, 'xi mpk-1', 2, NULL, NULL, NULL),
(3, 'xi mpk-2', 2, NULL, NULL, NULL),
(4, 'xi mpk-3', 2, NULL, NULL, NULL),
(5, 'xi bsr-1', 3, NULL, NULL, NULL),
(6, 'xi bsr-2', 3, NULL, NULL, NULL),
(7, 'xi tkj-1', 4, NULL, NULL, NULL),
(8, 'xi tkj-2', 4, NULL, NULL, NULL),
(9, 'xi tkj-3', 4, NULL, NULL, NULL),
(10, 'xi tkr-1', 5, NULL, NULL, NULL),
(11, 'xi tkr-2', 5, NULL, NULL, NULL),
(12, 'xi tkr-3', 5, NULL, NULL, NULL),
(13, 'xi tkr-4', 5, NULL, NULL, NULL),
(14, 'xi tkr-5', 5, NULL, NULL, NULL),
(15, 'xi tkr-6', 5, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pendaftaran`
--
CREATE TABLE `tb_pendaftaran` (
  `id` bigint UNSIGNED NOT NULL,
  `id_siswa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_dudi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_siswa`
--
CREATE TABLE `tb_siswa` (
  `id` bigint UNSIGNED NOT NULL,
  `nis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nisn` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kelas` bigint UNSIGNED NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_siswa`
--

INSERT INTO `tb_siswa` (`id`, `nis`, `nisn`, `nama`, `id_kelas`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(100, '', '', 'AFIFAH ISTI RUSTRIANA', 1, 'active', NULL, NULL, NULL),
(101, '', '', 'AFRINIAR TYAS WENING', 1, 'active', NULL, NULL, NULL),
(102, '', '', 'AGNES SAPITRI', 1, 'active', NULL, NULL, NULL),
(103, '', '', 'AISYAH SYIFANI WIBOWO', 1, 'active', NULL, NULL, NULL),
(104, '', '', 'ALFINATU ZAHWA USWATUN SYARIFAH', 1, 'active', NULL, NULL, NULL),
(105, '', '', 'AMELIA RACHMADANI', 1, 'active', NULL, NULL, NULL),
(106, '', '', 'ANGGIA FELI AGUSTINA FEBRIYANTI', 1, 'active', NULL, NULL, NULL),
(107, '', '', 'ASSYIFA TOYIFATUN MUNAZAH', 1, 'active', NULL, NULL, NULL),
(108, '', '', 'AULIA NUR MELIYANA', 1, 'active', NULL, NULL, NULL),
(109, '', '', 'AURORA CANDRANINGTYAS PRAMODHA WARDHANI', 1, 'active', NULL, NULL, NULL),
(110, '', '', 'AZZAHRA MILATUL ULYA SUGIARTO', 1, 'active', NULL, NULL, NULL),
(111, '', '', 'BELLA ANIS MAULIDA', 1, 'active', NULL, NULL, NULL),
(112, '', '', 'DEA ANTA DWI PERTIWI', 1, 'active', NULL, NULL, NULL),
(113, '', '', 'DELLA RATMA KARUNIA', 1, 'active', NULL, NULL, NULL),
(114, '', '', 'DEWI ANGGY RAMADHINA', 1, 'active', NULL, NULL, NULL),
(115, '', '', 'DIVANA KARTIKA MEGA', 1, 'active', NULL, NULL, NULL),
(116, '', '', 'DIYAN TRIASIH', 1, 'active', NULL, NULL, NULL),
(117, '', '', 'FARA EKA ELMIANA', 1, 'active', NULL, NULL, NULL),
(118, '', '', 'FAWNIA LAILI WARISA', 1, 'active', NULL, NULL, NULL),
(119, '', '', 'HANIFA FITRI AULIA', 1, 'active', NULL, NULL, NULL),
(120, '', '', 'HANIN JASMINTIASARI', 1, 'active', NULL, NULL, NULL),
(121, '', '', 'HAWA RISKA KHOERUNNISA', 1, 'active', NULL, NULL, NULL),
(122, '', '', 'KAREN PUSPITA FEBRIANI', 1, 'active', NULL, NULL, NULL),
(123, '', '', 'KARISMA NIKEN PURI MAHARANI', 1, 'active', NULL, NULL, NULL),
(124, '', '', 'KHOLIFATU LATIFAH', 1, 'active', NULL, NULL, NULL),
(125, '', '', 'LUTFIANA EKA SAPUTRI', 1, 'active', NULL, NULL, NULL),
(126, '', '', 'MISZAHRA RAMADHAN HASANAH', 1, 'active', NULL, NULL, NULL),
(127, '', '', 'NUR FITRIYANI', 1, 'active', NULL, NULL, NULL),
(128, '', '', 'PRITI NABILA AURA KASIH', 1, 'active', NULL, NULL, NULL),
(129, '', '', 'QONITA NURUL IZZAH', 1, 'active', NULL, NULL, NULL),
(130, '', '', 'QURROTUL A\'YUNINA', 1, 'active', NULL, NULL, NULL),
(131, '', '', 'RANIM RAMDHANI', 1, 'active', NULL, NULL, NULL),
(132, '', '', 'RAYANI PUTRI', 1, 'active', NULL, NULL, NULL),
(133, '', '', 'REVI AULIA', 1, 'active', NULL, NULL, NULL),
(134, '', '', 'RISKA FEBRIANA', 1, 'active', NULL, NULL, NULL),
(135, '', '', 'SALSABILA DWI LARASATI', 1, 'active', NULL, NULL, NULL),
(136, '', '', 'SERLY AFRELIA', 1, 'active', NULL, NULL, NULL),
(137, '', '', 'SYAHLA NOOR HANIFAH', 1, 'active', NULL, NULL, NULL),
(138, '', '', 'TIARA AYU WULANDARI', 1, 'active', NULL, NULL, NULL),
(139, '', '', 'UMMU ZAHWATUL ULA', 1, 'active', NULL, NULL, NULL),
(140, '', '', 'VIVI RISKI MUHHAJIJAH', 1, 'active', NULL, NULL, NULL),
(141, '', '', 'WIDYA ANWAR', 1, 'active', NULL, NULL, NULL),
(142, '', '', 'YAYANG ZEBRINA ASMIRIFKAH', 1, 'active', NULL, NULL, NULL),
(143, '', '', 'ZASKIA AYUNITA PUTRI', 1, 'active', NULL, NULL, NULL),
(144, '', '', 'ZULFATUL AFIFA RAHMA', 1, 'active', NULL, NULL, NULL),
(145, '', '', '\'AINUN QIROM REGINA PUTRI', 2, 'active', NULL, NULL, NULL),
(146, '', '', 'ALEXSA ELVIAYU', 2, 'active', NULL, NULL, NULL),
(147, '', '', 'ALFIE RAYA NUR FADILLAH', 2, 'active', NULL, NULL, NULL),
(148, '', '', 'ALIFA NI\'MATUN HASANAH', 2, 'active', NULL, NULL, NULL),
(149, '', '', 'ALVITA DIYANTI', 2, 'active', NULL, NULL, NULL),
(150, '', '', 'ARMELIA RIZKI HABIBAH', 2, 'active', NULL, NULL, NULL),
(151, '', '', 'ASYIFA NUR ANDINI', 2, 'active', NULL, NULL, NULL),
(152, '', '', 'AZZAHRA CINDY SAPUTRY', 2, 'active', NULL, NULL, NULL),
(153, '', '', 'CANTI NUR RAYNA FADILAH PRASTYO', 2, 'active', NULL, NULL, NULL),
(154, '', '', 'DESI PUSPITASARI', 2, 'active', NULL, NULL, NULL),
(155, '', '', 'DEVIN PRASTYO NUGROHO', 2, 'active', NULL, NULL, NULL),
(156, '', '', 'ENDAH KUSUMAWARDANI', 2, 'active', NULL, NULL, NULL),
(157, '', '', 'ERIKA PUTRI', 2, 'active', NULL, NULL, NULL),
(158, '', '', 'EVI PRATIWI', 2, 'active', NULL, NULL, NULL),
(159, '', '', 'FATHYA AULIA RAYHANA', 2, 'active', NULL, NULL, NULL),
(160, '', '', 'GENDHIS FATHIYA SHAFA RAMADHANI', 2, 'active', NULL, NULL, NULL),
(161, '', '', 'HALIMAH TUSSADIYAH', 2, 'active', NULL, NULL, NULL),
(162, '', '', 'HENI FEBRIYANTI', 2, 'active', NULL, NULL, NULL),
(163, '', '', 'INTAN AULIA PUTRI', 2, 'active', NULL, NULL, NULL),
(164, '', '', 'INTAN PURNAMA SARI', 2, 'active', NULL, NULL, NULL),
(165, '', '', 'JESIKA AULIA NOVITA', 2, 'active', NULL, NULL, NULL),
(166, '', '', 'JIHAN ISNAENI', 2, 'active', NULL, NULL, NULL),
(167, '', '', 'JUANITA AFIFAH AZZAHRO', 2, 'active', NULL, NULL, NULL),
(168, '', '', 'JUNYANTIKA ARIANISA PUTRI', 2, 'active', NULL, NULL, NULL),
(169, '', '', 'KHESYAH NURIYAH AWALUDIN', 2, 'active', NULL, NULL, NULL),
(170, '', '', 'KUWAT BUDI HARTINI', 2, 'active', NULL, NULL, NULL),
(171, '', '', 'LATIEFAHTUL KHAERUNISA KHANIF', 2, 'active', NULL, NULL, NULL),
(172, '', '', 'LULU ATUN NAFISAH', 2, 'active', NULL, NULL, NULL),
(173, '', '', 'LUTFI AWLIYA KHAYA', 2, 'active', NULL, NULL, NULL),
(174, '', '', 'LUTHFITA NUR RIZKYANI PUTRI', 2, 'active', NULL, NULL, NULL),
(175, '', '', 'MARSYA ALLFIONA SETIANI', 2, 'active', NULL, NULL, NULL),
(176, '', '', 'MEISYA AYU AZIZAH', 2, 'active', NULL, NULL, NULL),
(177, '', '', 'NAILA KAMALIA', 2, 'active', NULL, NULL, NULL),
(178, '', '', 'NANDA ALENA PUTRI', 2, 'active', NULL, NULL, NULL),
(179, '', '', 'NANDA MAR\'ATUL KHUSNA', 2, 'active', NULL, NULL, NULL),
(180, '', '', 'NINA KARTIKA PUTRI', 2, 'active', NULL, NULL, NULL),
(181, '', '', 'RAFIKA DAMAYANTI', 2, 'active', NULL, NULL, NULL),
(182, '', '', 'SATRIA DIKA PERMANA', 2, 'active', NULL, NULL, NULL),
(183, '', '', 'SEFINA PUTRI KHASANAH', 2, 'active', NULL, NULL, NULL),
(184, '', '', 'SELFI RAMADANI', 2, 'active', NULL, NULL, NULL),
(185, '', '', 'SOFI OKTAFIANI', 2, 'active', NULL, NULL, NULL),
(186, '', '', 'SOLEKHA NUR ANDITI', 2, 'active', NULL, NULL, NULL),
(187, '', '', 'SYIFA AFRIL RIYANI', 2, 'active', NULL, NULL, NULL),
(188, '', '', 'WYLDA WILLADATUS SOLIHAH', 2, 'active', NULL, NULL, NULL),
(189, '', '', 'YUNI MAY SAROH', 2, 'active', NULL, NULL, NULL),
(190, '', '', 'ZAHRA AULIA FITRIYADI', 2, 'active', NULL, NULL, NULL),
(191, '', '', 'ZASQIA DINI HARIMUKTI', 2, 'active', NULL, NULL, NULL),
(192, '', '', 'ADILLA ZAHRA RAMADHANI ARTINA', 3, 'active', NULL, NULL, NULL),
(193, '', '', 'AFIFAH ATHALIA PUTRI', 3, 'active', NULL, NULL, NULL),
(194, '', '', 'AMIRA ZAHRA SALSABILA', 3, 'active', NULL, NULL, NULL),
(195, '', '', 'ANDINI MUTIARA PUTRI', 3, 'active', NULL, NULL, NULL),
(196, '', '', 'ANNISA LUTFIANA ZAHRA', 3, 'active', NULL, NULL, NULL),
(197, '', '', 'APRILIA ELMA SAPUTRI', 3, 'active', NULL, NULL, NULL),
(198, '', '', 'ARISTA NUR\'AINI', 3, 'active', NULL, NULL, NULL),
(199, '', '', 'AULIA ANGGITA SETIAWAN', 3, 'active', NULL, NULL, NULL),
(200, '', '', 'AVALITA AGUSTINA RAHMADANI', 3, 'active', NULL, NULL, NULL),
(201, '', '', 'AVRILLIA DEWI SUWANDARI', 3, 'active', NULL, NULL, NULL),
(202, '', '', 'CHELSEA NOVITA ANGGRAENI', 3, 'active', NULL, NULL, NULL),
(203, '', '', 'DEA SEPTIKHULFIAH', 3, 'active', NULL, NULL, NULL),
(204, '', '', 'DELLA ISTI IRAWAN', 3, 'active', NULL, NULL, NULL),
(205, '', '', 'DESTANIA INTAN PERMATA', 3, 'active', NULL, NULL, NULL),
(206, '', '', 'DEWI ANGGAR SARI', 3, 'active', NULL, NULL, NULL),
(207, '', '', 'DIANA FITRI', 3, 'active', NULL, NULL, NULL),
(208, '', '', 'ELIVIA IRVIANI', 3, 'active', NULL, NULL, NULL),
(209, '', '', 'FELYTA PUSPITASARI', 3, 'active', NULL, NULL, NULL),
(210, '', '', 'IKA APRILIA WIDATUL ULYA', 3, 'active', NULL, NULL, NULL),
(211, '', '', 'IKE ANESHA PUTRI', 3, 'active', NULL, NULL, NULL),
(212, '', '', 'INAYA AZMI NADHIFA', 3, 'active', NULL, NULL, NULL),
(213, '', '', 'LILIS NUR AISYAH', 3, 'active', NULL, NULL, NULL),
(214, '', '', 'MELIA DEWI SANTIKA', 3, 'active', NULL, NULL, NULL),
(215, '', '', 'MILIE NASUTION', 3, 'active', NULL, NULL, NULL),
(216, '', '', 'NAISYA RAHMADANI', 3, 'active', NULL, NULL, NULL),
(217, '', '', 'OKTA NUR AISYAH', 3, 'active', NULL, NULL, NULL),
(218, '', '', 'RAHMAH AULIA PUTRI', 3, 'active', NULL, NULL, NULL),
(219, '', '', 'RISKA DEWI SAPUTRI', 3, 'active', NULL, NULL, NULL),
(220, '', '', 'RITA SOPIATUN', 3, 'active', NULL, NULL, NULL),
(221, '', '', 'SEVIANA DEWI', 3, 'active', NULL, NULL, NULL),
(222, '', '', 'SEZA AMINATI', 3, 'active', NULL, NULL, NULL),
(223, '', '', 'SHAKILA KHANAZAH DARMAWAN', 3, 'active', NULL, NULL, NULL),
(224, '', '', 'SHOFI SEKAR WATI', 3, 'active', NULL, NULL, NULL),
(225, '', '', 'SULIS JULIANA SAFITRI', 3, 'active', NULL, NULL, NULL),
(226, '', '', 'SYAFA DITI FEBIANA', 3, 'active', NULL, NULL, NULL),
(227, '', '', 'SYAFA KEKE KIRANI', 3, 'active', NULL, NULL, NULL),
(228, '', '', 'SYAFIRA THALITA PUTRI', 3, 'active', NULL, NULL, NULL),
(229, '', '', 'TIA SRI MULYANTI', 3, 'active', NULL, NULL, NULL),
(230, '', '', 'TIARA BELLA', 3, 'active', NULL, NULL, NULL),
(231, '', '', 'TIARA JULIANA NINGRUM', 3, 'active', NULL, NULL, NULL),
(232, '', '', 'VAHRISA TIARA FITRI', 3, 'active', NULL, NULL, NULL),
(233, '', '', 'VIKA MA\'RIFATUL HASANAH', 3, 'active', NULL, NULL, NULL),
(234, '', '', 'YELI TRIYA NINGSIH', 3, 'active', NULL, NULL, NULL),
(235, '', '', 'ZAHROTUL AFIFAH', 3, 'active', NULL, NULL, NULL),
(236, '', '', 'ALLEN APRILIANA ARYANTI', 4, 'active', NULL, NULL, NULL),
(237, '', '', 'ALVIRA BUNGA FEBRIANA', 4, 'active', NULL, NULL, NULL),
(238, '', '', 'ANISA JUNIA PUTRI', 4, 'active', NULL, NULL, NULL),
(239, '', '', 'ANZAH MARCELINA', 4, 'active', NULL, NULL, NULL),
(240, '', '', 'APRI SETIA WATI', 4, 'active', NULL, NULL, NULL),
(241, '', '', 'APRILLIA LISTIANINGSIH', 4, 'active', NULL, NULL, NULL),
(242, '', '', 'ARINA SALSABILA', 4, 'active', NULL, NULL, NULL),
(243, '', '', 'AYU MAISYA PUTRI', 4, 'active', NULL, NULL, NULL),
(244, '', '', 'DEFI SULIA FATMAWATI', 4, 'active', NULL, NULL, NULL),
(245, '', '', 'DWI OLIVIA', 4, 'active', NULL, NULL, NULL),
(246, '', '', 'EKA RISTINA MELANI', 4, 'active', NULL, NULL, NULL),
(247, '', '', 'ESTI KOMARIA', 4, 'active', NULL, NULL, NULL),
(248, '', '', 'FIRDHAH PUTIGA', 4, 'active', NULL, NULL, NULL),
(249, '', '', 'FRISKA AURELIA PUTRI', 4, 'active', NULL, NULL, NULL),
(250, '', '', 'HAFIFAH NURAENI', 4, 'active', NULL, NULL, NULL),
(251, '', '', 'IKA MEI CAHYANI', 4, 'active', NULL, NULL, NULL),
(252, '', '', 'INA LESTARI', 4, 'active', NULL, NULL, NULL),
(253, '', '', 'ISMA TRI APRILIA', 4, 'active', NULL, NULL, NULL),
(254, '', '', 'KAYLA PUTRI', 4, 'active', NULL, NULL, NULL),
(255, '', '', 'LISNA JANATUL MA`WA', 4, 'active', NULL, NULL, NULL),
(256, '', '', 'MUFIDAH NUR IZZATI', 4, 'active', NULL, NULL, NULL),
(257, '', '', 'NABILA EKA PUTRI', 4, 'active', NULL, NULL, NULL),
(258, '', '', 'NI\'MATU SULISAH ROBINGAH', 4, 'active', NULL, NULL, NULL),
(259, '', '', 'NISA FELICIA PUTRI', 4, 'active', NULL, NULL, NULL),
(260, '', '', 'NISRIN NAYLA FATMA', 4, 'active', NULL, NULL, NULL),
(261, '', '', 'OPCY SALWA OKTAVIANA', 4, 'active', NULL, NULL, NULL),
(262, '', '', 'RAFELLINA RAMADANI', 4, 'active', NULL, NULL, NULL),
(263, '', '', 'REFIANA YANUARDIAH', 4, 'active', NULL, NULL, NULL),
(264, '', '', 'REVINKA RAMA GESVANI', 4, 'active', NULL, NULL, NULL),
(265, '', '', 'RISTIANI PUSPITA DEWI', 4, 'active', NULL, NULL, NULL),
(266, '', '', 'RIZKA WIDYA LESTARI', 4, 'active', NULL, NULL, NULL),
(267, '', '', 'SABRINA AZ ZAHRA', 4, 'active', NULL, NULL, NULL),
(268, '', '', 'SAFA ANJANI', 4, 'active', NULL, NULL, NULL),
(269, '', '', 'SALSABILA SYAFA\' AULIA', 4, 'active', NULL, NULL, NULL),
(270, '', '', 'SALSABILLA OKTAVIANA', 4, 'active', NULL, NULL, NULL),
(271, '', '', 'SEPTI AYU WULANDARI', 4, 'active', NULL, NULL, NULL),
(272, '', '', 'SILVIA WIDIA PUTRI', 4, 'active', NULL, NULL, NULL),
(273, '', '', 'SINAR ING JULIYA', 4, 'active', NULL, NULL, NULL),
(274, '', '', 'SYAFIYA NURUL LUTHFIANI', 4, 'active', NULL, NULL, NULL),
(275, '', '', 'SYIFA NUR HIDAYAH', 4, 'active', NULL, NULL, NULL),
(276, '', '', 'ULVA HASANAH', 4, 'active', NULL, NULL, NULL),
(277, '', '', 'VIANITA SAPUTRI', 4, 'active', NULL, NULL, NULL),
(278, '', '', 'VIENSKA WAHYU ANJANI', 4, 'active', NULL, NULL, NULL),
(279, '', '', 'VIVI PRIHANDINI', 4, 'active', NULL, NULL, NULL),
(280, '', '', 'WIDIA AGUSTINA SAFITRI', 4, 'active', NULL, NULL, NULL),
(281, '', '', 'WILDA JIHAN FAIZA', 4, 'active', NULL, NULL, NULL),
(282, '', '', 'YUNITA AUNI RAHAYU', 4, 'active', NULL, NULL, NULL),
(283, '', '', 'ADINDA MILA RAHAR DIANI', 5, 'active', NULL, NULL, NULL),
(284, '', '', 'AISAH PUTRI FEBIANTI', 5, 'active', NULL, NULL, NULL),
(285, '', '', 'AISYAH NABILA', 5, 'active', NULL, NULL, NULL),
(286, '', '', 'ALENTA NUR CHAYANTI', 5, 'active', NULL, NULL, NULL),
(287, '', '', 'AL-FARAHIZAH FILYATUL AGATIA', 5, 'active', NULL, NULL, NULL),
(288, '', '', 'ANISA NUR AINI', 5, 'active', NULL, NULL, NULL),
(289, '', '', 'ARVITA RAMADHANI', 5, 'active', NULL, NULL, NULL),
(290, '', '', 'AURA ETIKA ALDIN', 5, 'active', NULL, NULL, NULL),
(291, '', '', 'BILQIS ALIFAH', 5, 'active', NULL, NULL, NULL),
(292, '', '', 'CALLYSTA CALYA ALIFAH', 5, 'active', NULL, NULL, NULL),
(293, '', '', 'CHYNTIA AZZAHRA PUTRI', 5, 'active', NULL, NULL, NULL),
(294, '', '', 'DILA RAMADANI', 5, 'active', NULL, NULL, NULL),
(295, '', '', 'DWI CAHYA NUR AISYAH', 5, 'active', NULL, NULL, NULL),
(296, '', '', 'EKA RAMADHANI', 5, 'active', NULL, NULL, NULL),
(297, '', '', 'FAIZAH FRISKA PUTRI AS-ZAHRA', 5, 'active', NULL, NULL, NULL),
(298, '', '', 'GAYUH PUSPA LETIZA', 5, 'active', NULL, NULL, NULL),
(299, '', '', 'INTAN NUR AINI', 5, 'active', NULL, NULL, NULL),
(300, '', '', 'ISMA KAYLA OCTAVIA ALBANI', 5, 'active', NULL, NULL, NULL),
(301, '', '', 'ISMI AFFIFAH AHMAD', 5, 'active', NULL, NULL, NULL),
(302, '', '', 'KEYSHA DINDA MARETA', 5, 'active', NULL, NULL, NULL),
(303, '', '', 'LISA DWI RAMADANI', 5, 'active', NULL, NULL, NULL),
(304, '', '', 'MEILINA AFRIANI', 5, 'active', NULL, NULL, NULL),
(305, '', '', 'NAIELA LEYALI AZKYA', 5, 'active', NULL, NULL, NULL),
(306, '', '', 'NAZWA OKTOVIANI', 5, 'active', NULL, NULL, NULL),
(307, '', '', 'NOVITA DEWI AHDELIA', 5, 'active', NULL, NULL, NULL),
(308, '', '', 'NOVITA REGINA PUTRI', 5, 'active', NULL, NULL, NULL),
(309, '', '', 'PURWATININGTYAS', 5, 'active', NULL, NULL, NULL),
(310, '', '', 'RETNO SELLA SAHITA', 5, 'active', NULL, NULL, NULL),
(311, '', '', 'SALSABILA KHOERUN NISA', 5, 'active', NULL, NULL, NULL),
(312, '', '', 'SHELLY AZKA SEKAR KAMARDIKA', 5, 'active', NULL, NULL, NULL),
(313, '', '', 'SINDI PUSPITASARI', 5, 'active', NULL, NULL, NULL),
(314, '', '', 'SOHIBA NAZA VALENTINA', 5, 'active', NULL, NULL, NULL),
(315, '', '', 'WULAN SHYAFIFUJI MUNAWAROH', 5, 'active', NULL, NULL, NULL),
(316, '', '', 'YOSIKA LUTFIANA APRELA', 5, 'active', NULL, NULL, NULL),
(317, '', '', 'ZAKIYATUL FAAKHIROH', 5, 'active', NULL, NULL, NULL),
(318, '', '', 'ALYA ALSA ROHALI', 6, 'active', NULL, NULL, NULL),
(319, '', '', 'ALYA ENDAH PUTRI SUDIRO', 6, 'active', NULL, NULL, NULL),
(320, '', '', 'APDIAN PUTRI WINARSIH', 6, 'active', NULL, NULL, NULL),
(321, '', '', 'APRILIA BUNGA LESTARI', 6, 'active', NULL, NULL, NULL),
(322, '', '', 'DIAN AYU LESTARI', 6, 'active', NULL, NULL, NULL),
(323, '', '', 'DINA WAHIDATUN HIKMAH AFRILIA', 6, 'active', NULL, NULL, NULL),
(324, '', '', 'DWI RAHMA LUTHFITA', 6, 'active', NULL, NULL, NULL),
(325, '', '', 'ERIKA NOVATUL AFIFAH', 6, 'active', NULL, NULL, NULL),
(326, '', '', 'EVI APRILIANI', 6, 'active', NULL, NULL, NULL),
(327, '', '', 'INAYA TUSSOLIHAH', 6, 'active', NULL, NULL, NULL),
(328, '', '', 'KUUNII MARDLIYAH', 6, 'active', NULL, NULL, NULL),
(329, '', '', 'LULU NOVITA SARI', 6, 'active', NULL, NULL, NULL),
(330, '', '', 'MARCELLA CHRYSTIN STEFFANY', 6, 'active', NULL, NULL, NULL),
(331, '', '', 'MELIANA RIZKA AZAHRA', 6, 'active', NULL, NULL, NULL),
(332, '', '', 'NABILA APRILLIANI', 6, 'active', NULL, NULL, NULL),
(333, '', '', 'NAIYA RAHMADHANI', 6, 'active', NULL, NULL, NULL),
(334, '', '', 'NASYA AULIA FAUZIAH', 6, 'active', NULL, NULL, NULL),
(335, '', '', 'NOVIA RACHMAWATI', 6, 'active', NULL, NULL, NULL),
(336, '', '', 'NUR FAZURA BALGIS', 6, 'active', NULL, NULL, NULL),
(337, '', '', 'PUTRI AULIA PRISKA', 6, 'active', NULL, NULL, NULL),
(338, '', '', 'PUTRI CORNELIA', 6, 'active', NULL, NULL, NULL),
(339, '', '', 'RIFA FEBRIYANI', 6, 'active', NULL, NULL, NULL),
(340, '', '', 'RIZKY FEBRIANI', 6, 'active', NULL, NULL, NULL),
(341, '', '', 'ROSALINA NUR ARIFIAN', 6, 'active', NULL, NULL, NULL),
(342, '', '', 'SALSA SOFWATUL FAZRIYAH', 6, 'active', NULL, NULL, NULL),
(343, '', '', 'SARAH AMELIA SARI', 6, 'active', NULL, NULL, NULL),
(344, '', '', 'SASKIA LAILATUL SALMA', 6, 'active', NULL, NULL, NULL),
(345, '', '', 'SASKIA RISKI AMALIA', 6, 'active', NULL, NULL, NULL),
(346, '', '', 'SHANIA HARLIYANI', 6, 'active', NULL, NULL, NULL),
(347, '', '', 'SHERIN ALIFIA ISTIQOMAH', 6, 'active', NULL, NULL, NULL),
(348, '', '', 'SOVIE SEPTIANI PUTRI', 6, 'active', NULL, NULL, NULL),
(349, '', '', 'SYIFA MAHARANI', 6, 'active', NULL, NULL, NULL),
(350, '', '', 'VICA NIA NOFIANA', 6, 'active', NULL, NULL, NULL),
(351, '', '', 'YASMINE AULIA ZAHRA', 6, 'active', NULL, NULL, NULL),
(352, '', '', 'AFIFAH NUR SAYANG', 7, 'active', NULL, NULL, NULL),
(353, '', '', 'AINY FIANA PUTRI', 7, 'active', NULL, NULL, NULL),
(354, '', '', 'AKBAR SEPTIANPRATAMA', 7, 'active', NULL, NULL, NULL),
(355, '', '', 'AMANAH YOGI PRATAMA', 7, 'active', NULL, NULL, NULL),
(356, '', '', 'ANDIKA SYAH PUTRA', 7, 'active', NULL, NULL, NULL),
(357, '', '', 'AQILAH ZAHIR HANANIRA', 7, 'active', NULL, NULL, NULL),
(358, '', '', 'ARIFATU ZAHRA', 7, 'active', NULL, NULL, NULL),
(359, '', '', 'ASTY ANANTA', 7, 'active', NULL, NULL, NULL),
(360, '', '', 'AZIZAH SYACHMIRA PUTRI', 7, 'active', NULL, NULL, NULL),
(361, '', '', 'DAFFA ALDHIKA MIKOLA', 7, 'active', NULL, NULL, NULL),
(362, '', '', 'DESTI DWI LESTARI', 7, 'active', NULL, NULL, NULL),
(363, '', '', 'DHIVA FELIANA AYUNINGTYAS', 7, 'active', NULL, NULL, NULL),
(364, '', '', 'DZAAKA DHIANDRA PRADHITTYA', 7, 'active', NULL, NULL, NULL),
(365, '', '', 'FAIZAL RIDHO PRATAMA', 7, 'active', NULL, NULL, NULL),
(366, '', '', 'FAJAR NDARU BEKTI', 7, 'active', NULL, NULL, NULL),
(367, '', '', 'FALIKHAH AZALIA RAMADHANI', 7, 'active', NULL, NULL, NULL),
(368, '', '', 'FIRA DWI ELMIANA', 7, 'active', NULL, NULL, NULL),
(369, '', '', 'HESTIANA PUTRI NABILA', 7, 'active', NULL, NULL, NULL),
(370, '', '', 'JULIAN YUSUF AKBAR', 7, 'active', NULL, NULL, NULL),
(371, '', '', 'KARISMA KHUSWATUN CHASANAH', 7, 'active', NULL, NULL, NULL),
(372, '', '', 'KEZHA NURJANNAH', 7, 'active', NULL, NULL, NULL),
(373, '', '', 'KHAMDUN MAMLUKI', 7, 'active', NULL, NULL, NULL),
(374, '', '', 'LU\'LUA PUTRI AGHNIYYA', 7, 'active', NULL, NULL, NULL),
(375, '', '', 'LUTFIA NUR HIKMAH', 7, 'active', NULL, NULL, NULL),
(376, '', '', 'MEDINA FAHARANI PURWANTO', 7, 'active', NULL, NULL, NULL),
(377, '', '', 'MEI DWI WULANDARI', 7, 'active', NULL, NULL, NULL),
(378, '', '', 'MEILINA AYU WARSENI', 7, 'active', NULL, NULL, NULL),
(379, '', '', 'MUHAMAD JAMMIL FIRDAUS', 7, 'active', NULL, NULL, NULL),
(380, '', '', 'NGUSMAN ISA MAHENDRA', 7, 'active', NULL, NULL, NULL),
(381, '', '', 'RADITYA AKBAR SAPUTRA', 7, 'active', NULL, NULL, NULL),
(382, '', '', 'RIZKA KHUMAIROTUZZAKIYA', 7, 'active', NULL, NULL, NULL),
(383, '', '', 'SANDI NUR FADHILAH', 7, 'active', NULL, NULL, NULL),
(384, '', '', 'TIARA AJENG PRATIWI', 7, 'active', NULL, NULL, NULL),
(385, '', '', 'VELIKA HEFA SASHENKA', 7, 'active', NULL, NULL, NULL),
(386, '', '', 'WAHDATUL HUSNA AULIA SYIHAB', 7, 'active', NULL, NULL, NULL),
(387, '', '', 'WANDA PUTRI PRAMUDITA', 7, 'active', NULL, NULL, NULL),
(388, '', '', 'WILDAN ASHARI', 7, 'active', NULL, NULL, NULL),
(389, '', '', 'WINDA TRI HAPSARI', 7, 'active', NULL, NULL, NULL),
(390, '', '', 'AFRILIANA NURUL KHASANAH', 8, 'active', NULL, NULL, NULL),
(391, '', '', 'AJENG DWI WULANDARI', 8, 'active', NULL, NULL, NULL),
(392, '', '', 'ALIA WIDIASTUTI', 8, 'active', NULL, NULL, NULL),
(393, '', '', 'ARIFIN ILHAM', 8, 'active', NULL, NULL, NULL),
(394, '', '', 'AUREL FITRI NURUL AFIFAH', 8, 'active', NULL, NULL, NULL),
(395, '', '', 'AYU APRILIA RAHMAWATI', 8, 'active', NULL, NULL, NULL),
(396, '', '', 'BILQIIS TRIO BAIHAQI SAPUTRA', 8, 'active', NULL, NULL, NULL),
(397, '', '', 'FADILLA ADISTYA', 8, 'active', NULL, NULL, NULL),
(398, '', '', 'FALIH TIBYAN', 8, 'active', NULL, NULL, NULL),
(399, '', '', 'FERIKO YUSUF RAHARDI', 8, 'active', NULL, NULL, NULL),
(400, '', '', 'FERLITA MAYASARI', 8, 'active', NULL, NULL, NULL),
(401, '', '', 'MAYZENA JULIYANTI', 8, 'active', NULL, NULL, NULL),
(402, '', '', 'MIFTAH ADI SAPUTRA', 8, 'active', NULL, NULL, NULL),
(403, '', '', 'MIKA APRILIANI', 8, 'active', NULL, NULL, NULL),
(404, '', '', 'MUHAMAD CANDRA WIJAYA', 8, 'active', NULL, NULL, NULL),
(405, '', '', 'NAJWA DWI ALIKA', 8, 'active', NULL, NULL, NULL),
(406, '', '', 'NAUFAL HILMI TSAQIB', 8, 'active', NULL, NULL, NULL),
(407, '', '', 'NINDI NUR ASYIFA', 8, 'active', NULL, NULL, NULL),
(408, '', '', 'PRADITYA WIBOWO SAPUTRA', 8, 'active', NULL, NULL, NULL),
(409, '', '', 'PRASA KAFABILLAH', 8, 'active', NULL, NULL, NULL),
(410, '', '', 'PRISCA REVITA RAMADHANI', 8, 'active', NULL, NULL, NULL),
(411, '', '', 'RAFI NUR APRIYANTO', 8, 'active', NULL, NULL, NULL),
(412, '', '', 'RAFKA KIRANA', 8, 'active', NULL, NULL, NULL),
(413, '', '', 'RAHMA GRACEA MUTAKAMILLAH', 8, 'active', NULL, NULL, NULL),
(414, '', '', 'SHELA AMALIA SAHRA', 8, 'active', NULL, NULL, NULL),
(415, '', '', 'SYAFIQ DWIKY MAULANA', 8, 'active', NULL, NULL, NULL),
(416, '', '', 'SYIFA SALSABILA', 8, 'active', NULL, NULL, NULL),
(417, '', '', 'TALITA AGHNIA ULFIA', 8, 'active', NULL, NULL, NULL),
(418, '', '', 'TIARA NUR AIDA', 8, 'active', NULL, NULL, NULL),
(419, '', '', 'TIFANI LETISIA PUTRI', 8, 'active', NULL, NULL, NULL),
(420, '', '', 'UNZILA HASRI ALFAJRI', 8, 'active', NULL, NULL, NULL),
(421, '', '', 'VEREN RIZA ANIANSYAH', 8, 'active', NULL, NULL, NULL),
(422, '', '', 'VIKA AULLIA SAFITRI', 8, 'active', NULL, NULL, NULL),
(423, '', '', 'WULIDA ANINDITA', 8, 'active', NULL, NULL, NULL),
(424, '', '', 'ZAKI KADAVI', 8, 'active', NULL, NULL, NULL),
(425, '', '', 'ZHAKIRA INDAH SEPTIANA', 8, 'active', NULL, NULL, NULL),
(426, '', '', 'ADAM SUKRON MA\'MUN', 9, 'active', NULL, NULL, NULL),
(427, '', '', 'AKHADY WIRA SATRIAJI AL GHOZALI', 9, 'active', NULL, NULL, NULL),
(428, '', '', 'ALAM MUHAMMAD RIZKY', 9, 'active', NULL, NULL, NULL),
(429, '', '', 'ALIFIA DANNIS AZAHRA', 9, 'active', NULL, NULL, NULL),
(430, '', '', 'ANGGI DEVI LESTARI', 9, 'active', NULL, NULL, NULL),
(431, '', '', 'ARJUN AIDAM HAFID', 9, 'active', NULL, NULL, NULL),
(432, '', '', 'DANDI NANDA SAPUTRA', 9, 'active', NULL, NULL, NULL),
(433, '', '', 'DINA RESTI APRILIA', 9, 'active', NULL, NULL, NULL),
(434, '', '', 'FAIQ IKHSAN SAJIDAN', 9, 'active', NULL, NULL, NULL),
(435, '', '', 'HENNY NOVIA', 9, 'active', NULL, NULL, NULL),
(436, '', '', 'KEVIN ANDRIAN MAULANA', 9, 'active', NULL, NULL, NULL),
(437, '', '', 'KHARISMA APRODITHA PUTRI WIDYOWATI', 9, 'active', NULL, NULL, NULL),
(438, '', '', 'KINTAN ANGGRAENI', 9, 'active', NULL, NULL, NULL),
(439, '', '', 'LAITA AZALEA', 9, 'active', NULL, NULL, NULL),
(440, '', '', 'MALINDA EKA RAMADHANI', 9, 'active', NULL, NULL, NULL),
(441, '', '', 'MARIYAN', 9, 'active', NULL, NULL, NULL),
(442, '', '', 'MELLA FARDANI', 9, 'active', NULL, NULL, NULL),
(443, '', '', 'MUHAMMAD ARYA HAIDAR', 9, 'active', NULL, NULL, NULL),
(444, '', '', 'MUHAMMAD DIKI DARMAWAN', 9, 'active', NULL, NULL, NULL),
(445, '', '', 'NADYA ARIESYA', 9, 'active', NULL, NULL, NULL),
(446, '', '', 'NAFRAS ANGGA PERMANA', 9, 'active', NULL, NULL, NULL),
(447, '', '', 'NAILA ISTIRO\'AH', 9, 'active', NULL, NULL, NULL),
(448, '', '', 'NANDA NUR CHASANAH', 9, 'active', NULL, NULL, NULL),
(449, '', '', 'NAVA AULIA RAHMAWATI', 9, 'active', NULL, NULL, NULL),
(450, '', '', 'NAZWA AL KHOERUNNISA', 9, 'active', NULL, NULL, NULL),
(451, '', '', 'NOVIANA CAHYA ARIZKA', 9, 'active', NULL, NULL, NULL),
(452, '', '', 'QORI ZAHRAN WILLYANTO', 9, 'active', NULL, NULL, NULL),
(453, '', '', 'RADHITIYA LEVI WIJAYA', 9, 'active', NULL, NULL, NULL),
(454, '', '', 'RISKA OKTAFIANA', 9, 'active', NULL, NULL, NULL),
(455, '', '', 'SAKILA CAHYA PUTRI', 9, 'active', NULL, NULL, NULL),
(456, '', '', 'SHERLY ENJELINA PUTRI', 9, 'active', NULL, NULL, NULL),
(457, '', '', 'SHEYSA PUTRI', 9, 'active', NULL, NULL, NULL),
(458, '', '', 'SIFA ALFINA AMELIA MERDEKA', 9, 'active', NULL, NULL, NULL),
(459, '', '', 'SIFA SALSABILA', 9, 'active', NULL, NULL, NULL),
(460, '', '', 'SRI SULISTIANINGSIH', 9, 'active', NULL, NULL, NULL),
(461, '', '', 'AGUNG SETIAWAN', 10, 'active', NULL, NULL, NULL),
(462, '', '', 'AHMAD ASZRIL SAEFUDIN', 10, 'active', NULL, NULL, NULL),
(463, '', '', 'AHMAD IRFANSYAH', 10, 'active', NULL, NULL, NULL),
(464, '', '', 'AHMAD ZAENUL RAFLI', 10, 'active', NULL, NULL, NULL),
(465, '', '', 'ALFIANZAH', 10, 'active', NULL, NULL, NULL),
(466, '', '', 'ALIEF HIDAYAT', 10, 'active', NULL, NULL, NULL),
(467, '', '', 'ARKAAN RIZQI RIYADI', 10, 'active', NULL, NULL, NULL),
(468, '', '', 'ARREYANDI ARTONO', 10, 'active', NULL, NULL, NULL),
(469, '', '', 'DAVA RIFQI MUBAROK', 10, 'active', NULL, NULL, NULL),
(470, '', '', 'DERLY TRI KURNIAWAN', 10, 'active', NULL, NULL, NULL),
(471, '', '', 'DEVIN ALFARO AGUSTIAN PRATAMA', 10, 'active', NULL, NULL, NULL),
(472, '', '', 'DIKA VAINANDA PRATAMA', 10, 'active', NULL, NULL, NULL),
(473, '', '', 'EGY CHANDRA WARDANA', 10, 'active', NULL, NULL, NULL),
(474, '', '', 'FATHUR ROHMAN MUSTAQIM', 10, 'active', NULL, NULL, NULL),
(475, '', '', 'FEBRIAN DWI HARYANTO', 10, 'active', NULL, NULL, NULL),
(476, '', '', 'FIRMANSYAH', 10, 'active', NULL, NULL, NULL),
(477, '', '', 'FITO DESTYAN PUTRA', 10, 'active', NULL, NULL, NULL),
(478, '', '', 'FRENDA DELFIANO ANANZA', 10, 'active', NULL, NULL, NULL),
(479, '', '', 'IKHSAN SAPUTRA JEMIN', 10, 'active', NULL, NULL, NULL),
(480, '', '', 'ISNAN NUH ALAMSYAH', 10, 'active', NULL, NULL, NULL),
(481, '', '', 'ITMAM NOVA KURNIAWAN', 10, 'active', NULL, NULL, NULL),
(482, '', '', 'KURNIA DIKA PUTRA PRATAMA', 10, 'active', NULL, NULL, NULL),
(483, '', '', 'MALINDO SAPUTRA', 10, 'active', NULL, NULL, NULL),
(484, '', '', 'MUHAMMAD AINUL ADZKIYA', 10, 'active', NULL, NULL, NULL),
(485, '', '', 'MUHAMMAD FATHUR ROZIQ', 10, 'active', NULL, NULL, NULL),
(486, '', '', 'MUHAZDIBUL AS\'AD', 10, 'active', NULL, NULL, NULL),
(487, '', '', 'NAUFAL RADITYA PUTRA', 10, 'active', NULL, NULL, NULL),
(488, '', '', 'NAUFAL ZAKI AZZAUHARI', 10, 'active', NULL, NULL, NULL),
(489, '', '', 'NOVA RIANTO ARDIANSYAH PUTRA', 10, 'active', NULL, NULL, NULL),
(490, '', '', 'NUR RAHMAT HIDAYAT', 10, 'active', NULL, NULL, NULL),
(491, '', '', 'QHOERUL ANUAR', 10, 'active', NULL, NULL, NULL),
(492, '', '', 'RADITYA PRAMANSYAH ALBAR', 10, 'active', NULL, NULL, NULL),
(493, '', '', 'RAHMAN ISTIADI', 10, 'active', NULL, NULL, NULL),
(494, '', '', 'RASYA ARDIANZAH PRATAMA', 10, 'active', NULL, NULL, NULL),
(495, '', '', 'RAYHAN OKTAVIANSYAH', 10, 'active', NULL, NULL, NULL),
(496, '', '', 'RIFLIAN CAHYA PRATAMA', 10, 'active', NULL, NULL, NULL),
(497, '', '', 'RIZKY APRILIANTO', 10, 'active', NULL, NULL, NULL),
(498, '', '', 'SUJIROH RIZKI AL HIDAYAH', 10, 'active', NULL, NULL, NULL),
(499, '', '', 'TAFAZUL WAFIQ QOBILA', 10, 'active', NULL, NULL, NULL),
(500, '', '', 'WAHYU RIDHO ROCHMAN', 10, 'active', NULL, NULL, NULL),
(501, '', '', 'ZACKY RAHMAN', 10, 'active', NULL, NULL, NULL),
(502, '', '', 'ZAKI MUSYAFFA', 10, 'active', NULL, NULL, NULL),
(503, '', '', 'ZUHRUF TAUFIQ ZUBAIR', 10, 'active', NULL, NULL, NULL),
(504, '', '', 'ADITYA CANDRA WINATA', 11, 'active', NULL, NULL, NULL),
(505, '', '', 'ADITYA GALIH FRANDIKA', 11, 'active', NULL, NULL, NULL),
(506, '', '', 'AFDANI', 11, 'active', NULL, NULL, NULL),
(507, '', '', 'AFGAN DHIYA ULHAQ', 11, 'active', NULL, NULL, NULL),
(508, '', '', 'AFRIANSYAH ALBA MAULANA', 11, 'active', NULL, NULL, NULL),
(509, '', '', 'AHMAD FATAN FATHONI', 11, 'active', NULL, NULL, NULL),
(510, '', '', 'ALIF ZAQI MAULANA', 11, 'active', NULL, NULL, NULL),
(511, '', '', 'ANDIKA MAULANA', 11, 'active', NULL, NULL, NULL),
(512, '', '', 'ARIN SETIA FANU', 11, 'active', NULL, NULL, NULL),
(513, '', '', 'DIKA FARDIAN SAPUTRA', 11, 'active', NULL, NULL, NULL),
(514, '', '', 'DUWI PARMONO', 11, 'active', NULL, NULL, NULL),
(515, '', '', 'DWI APRIYANTO', 11, 'active', NULL, NULL, NULL),
(516, '', '', 'FAHRI ADITIYA', 11, 'active', NULL, NULL, NULL),
(517, '', '', 'FAREL FAHREZI', 11, 'active', NULL, NULL, NULL),
(518, '', '', 'FARID RAGIL PRAYOGI', 11, 'active', NULL, NULL, NULL),
(519, '', '', 'FIKRI ARDIANSYAH', 11, 'active', NULL, NULL, NULL),
(520, '', '', 'GALANG TYAS PRATAMA', 11, 'active', NULL, NULL, NULL),
(521, '', '', 'IHSAN FADHIL NURFARIS', 11, 'active', NULL, NULL, NULL),
(522, '', '', 'KHOERUL UMAM WAHID', 11, 'active', NULL, NULL, NULL),
(523, '', '', 'LUKMAN SAPUTRA', 11, 'active', NULL, NULL, NULL),
(524, '', '', 'MOHAMAD IMAM MAHFUD', 11, 'active', NULL, NULL, NULL),
(525, '', '', 'MOHAMMAD ZAKY ARNINO PRATAMA', 11, 'active', NULL, NULL, NULL),
(526, '', '', 'MU\'AD ABDUL KHAKIM', 11, 'active', NULL, NULL, NULL),
(527, '', '', 'MUHAMAD FADHIL FATHURROHMAN', 11, 'active', NULL, NULL, NULL),
(528, '', '', 'MUHAMAD RIZKI SAPUTRA', 11, 'active', NULL, NULL, NULL),
(529, '', '', 'MUHAMMAD FAIZAL HANAFI', 11, 'active', NULL, NULL, NULL),
(530, '', '', 'MUHAMMAD ILHAM MUBAROK', 11, 'active', NULL, NULL, NULL),
(531, '', '', 'RAFA JUNIANTO', 11, 'active', NULL, NULL, NULL),
(532, '', '', 'RAFFA DEUX ARYA JULIANTO', 11, 'active', NULL, NULL, NULL),
(533, '', '', 'RAHVA CATUR RADITIA', 11, 'active', NULL, NULL, NULL),
(534, '', '', 'RAIHAN DIAS SUBEKTI', 11, 'active', NULL, NULL, NULL),
(535, '', '', 'RAYHAN DWI PERMANA', 11, 'active', NULL, NULL, NULL),
(536, '', '', 'REVAN ARDIANSAH', 11, 'active', NULL, NULL, NULL),
(537, '', '', 'REVANO PUTRA ARDITYA', 11, 'active', NULL, NULL, NULL),
(538, '', '', 'REZA ANGGITA', 11, 'active', NULL, NULL, NULL),
(539, '', '', 'RIZQI ARGA EFFENDY', 11, 'active', NULL, NULL, NULL),
(540, '', '', 'SETYO ABDURRAHMAN ZAKI', 11, 'active', NULL, NULL, NULL),
(541, '', '', 'SHOFYAN RIZQI SETIAWAN', 11, 'active', NULL, NULL, NULL),
(542, '', '', 'SUKUR ARDIYANSAH', 11, 'active', NULL, NULL, NULL),
(543, '', '', 'SYAHRUL TAUFIK ILHAMI', 11, 'active', NULL, NULL, NULL),
(544, '', '', 'VRANKS BOYS', 11, 'active', NULL, NULL, NULL),
(545, '', '', 'WAHYU DWI ANDIKA', 11, 'active', NULL, NULL, NULL),
(546, '', '', 'YUDA BACHTIAR', 11, 'active', NULL, NULL, NULL),
(547, '', '', 'ZAYNAL ARIF', 11, 'active', NULL, NULL, NULL),
(548, '', '', 'ABDAN HAMIDA', 12, 'active', NULL, NULL, NULL),
(549, '', '', 'ADIL FATHUR RAHMAN', 12, 'active', NULL, NULL, NULL),
(550, '', '', 'ADITIA KHOIRUL', 12, 'active', NULL, NULL, NULL),
(551, '', '', 'ADITYA RIFKI', 12, 'active', NULL, NULL, NULL),
(552, '', '', 'ADRIAN ALVANZA', 12, 'active', NULL, NULL, NULL),
(553, '', '', 'AHMAD ADITIA PRATAMA', 12, 'active', NULL, NULL, NULL),
(554, '', '', 'AHMAD FORSA JULIAN PRATAMA', 12, 'active', NULL, NULL, NULL),
(555, '', '', 'AHMAD RIFKI SHOFIYURROHMAN', 12, 'active', NULL, NULL, NULL),
(556, '', '', 'AJANG KUMARA DEVA', 12, 'active', NULL, NULL, NULL),
(557, '', '', 'ALFATAH ROBIUL SAE', 12, 'active', NULL, NULL, NULL),
(558, '', '', 'ALVIAN RAHMAT JUNIANTO', 12, 'active', NULL, NULL, NULL),
(559, '', '', 'ALVIN FAUZAN PRATAMA', 12, 'active', NULL, NULL, NULL),
(560, '', '', 'ANGGA FAJAR AGUSTIAN', 12, 'active', NULL, NULL, NULL),
(561, '', '', 'ARGHANDA BAHARADI CAHYONO', 12, 'active', NULL, NULL, NULL),
(562, '', '', 'AZRIEL NABHAAN AL FAKHRI', 12, 'active', NULL, NULL, NULL),
(563, '', '', 'CHRISTIANO ANTONIUS', 12, 'active', NULL, NULL, NULL),
(564, '', '', 'DAVIT PANGESTU', 12, 'active', NULL, NULL, NULL),
(565, '', '', 'ERLANGGA AZRIL FAJAR PAMUNGKAS', 12, 'active', NULL, NULL, NULL),
(566, '', '', 'FAIQ ILHAM BAEHAQI', 12, 'active', NULL, NULL, NULL),
(567, '', '', 'FAIZAL ADI SAPUTRA', 12, 'active', NULL, NULL, NULL),
(568, '', '', 'FAUZI SAPUTRA', 12, 'active', NULL, NULL, NULL),
(569, '', '', 'GALEH PRAYOGI', 12, 'active', NULL, NULL, NULL),
(570, '', '', 'HABIBAH SYAIU ROHMAH', 12, 'active', NULL, NULL, NULL),
(571, '', '', 'HANAFI AL ZIKRI', 12, 'active', NULL, NULL, NULL),
(572, '', '', 'HARDI SEPTIYONO', 12, 'active', NULL, NULL, NULL),
(573, '', '', 'HASAN MAULANA', 12, 'active', NULL, NULL, NULL),
(574, '', '', 'IQBAL FERDIANSYAH', 12, 'active', NULL, NULL, NULL),
(575, '', '', 'LUCIJA SHIRA AZ ANAS', 12, 'active', NULL, NULL, NULL),
(576, '', '', 'MOH. IRFA DAROJAT', 12, 'active', NULL, NULL, NULL),
(577, '', '', 'MOHAMAD IRSYA FATURIZKI', 12, 'active', NULL, NULL, NULL),
(578, '', '', 'MUHAMAD LUKMAN DAVA AZHARI', 12, 'active', NULL, NULL, NULL),
(579, '', '', 'MUHAMMAD SARIFUDIN', 12, 'active', NULL, NULL, NULL),
(580, '', '', 'RAY FRIDAY ALFIANSYAH', 12, 'active', NULL, NULL, NULL),
(581, '', '', 'REFINA AZZAHRA', 12, 'active', NULL, NULL, NULL),
(582, '', '', 'REFINDO NUR ROHMAN', 12, 'active', NULL, NULL, NULL),
(583, '', '', 'RENDI NURROHIM', 12, 'active', NULL, NULL, NULL),
(584, '', '', 'RESTU AJI RAMA DHANI', 12, 'active', NULL, NULL, NULL),
(585, '', '', 'REVAN DWI SANTOSO', 12, 'active', NULL, NULL, NULL),
(586, '', '', 'REYLEN SAPUTRA', 12, 'active', NULL, NULL, NULL),
(587, '', '', 'RIFAI ABDUL SALIM', 12, 'active', NULL, NULL, NULL),
(588, '', '', 'RISKI FEBRIYANTO', 12, 'active', NULL, NULL, NULL),
(589, '', '', 'RIZKY MAULANA', 12, 'active', NULL, NULL, NULL),
(590, '', '', 'SAFIKA QURROTU AINI', 12, 'active', NULL, NULL, NULL),
(591, '', '', 'WIRANTO GALUH SAPUTRA', 12, 'active', NULL, NULL, NULL),
(592, '', '', 'ADE ZULKARNAEN', 13, 'active', NULL, NULL, NULL),
(593, '', '', 'AHMAD AGUSTIAN SAPUTRA', 13, 'active', NULL, NULL, NULL),
(594, '', '', 'AKMAL SAEFUL FAHRI', 13, 'active', NULL, NULL, NULL),
(595, '', '', 'ALFANSYAH MUTTAQIN', 13, 'active', NULL, NULL, NULL),
(596, '', '', 'ANNAS FIRMANSYAH', 13, 'active', NULL, NULL, NULL),
(597, '', '', 'AZIZ NUR FAUZI', 13, 'active', NULL, NULL, NULL),
(598, '', '', 'BAYU SAPUTRA', 13, 'active', NULL, NULL, NULL),
(599, '', '', 'BAYU ZIDAN ALRASID', 13, 'active', NULL, NULL, NULL),
(600, '', '', 'BINTANG FAIZAL', 13, 'active', NULL, NULL, NULL),
(601, '', '', 'DANI IRFANSYAH', 13, 'active', NULL, NULL, NULL),
(602, '', '', 'DANI YUDSTIRA', 13, 'active', NULL, NULL, NULL),
(603, '', '', 'DANY MUARIF', 13, 'active', NULL, NULL, NULL),
(604, '', '', 'EKO AJI SAPUTRA', 13, 'active', NULL, NULL, NULL),
(605, '', '', 'ERNEUS FIRDAUS', 13, 'active', NULL, NULL, NULL),
(606, '', '', 'FACHRI MAULANA', 13, 'active', NULL, NULL, NULL),
(607, '', '', 'FADHLI SYAHRUL HIDAYAT', 13, 'active', NULL, NULL, NULL),
(608, '', '', 'FAIZAL FEBRIANTO', 13, 'active', NULL, NULL, NULL),
(609, '', '', 'FAREL TRI SUBEKTI', 13, 'active', NULL, NULL, NULL),
(610, '', '', 'FARHAN ADITYA', 13, 'active', NULL, NULL, NULL),
(611, '', '', 'FENDI ARDHIAN PRATAMA', 13, 'active', NULL, NULL, NULL),
(612, '', '', 'FIKRI ARDIANZAH', 13, 'active', NULL, NULL, NULL),
(613, '', '', 'FIRMAN ARDIANSYAH', 13, 'active', NULL, NULL, NULL),
(614, '', '', 'GIGA PRANATA', 13, 'active', NULL, NULL, NULL),
(615, '', '', 'GILANG EKA RHAMADHAN', 13, 'active', NULL, NULL, NULL),
(616, '', '', 'ILHAM MAULANA', 13, 'active', NULL, NULL, NULL),
(617, '', '', 'ILHAM SUBKHAN ROMADHON', 13, 'active', NULL, NULL, NULL),
(618, '', '', 'IMRON ZAKARIYA', 13, 'active', NULL, NULL, NULL),
(619, '', '', 'JERRY ANWAR CANNAVARO', 13, 'active', NULL, NULL, NULL),
(620, '', '', 'KEANU BAKHTOOM KHALIM', 13, 'active', NULL, NULL, NULL),
(621, '', '', 'KEYFAN REFALDI', 13, 'active', NULL, NULL, NULL),
(622, '', '', 'KRISNA AKBAR MAOLANA', 13, 'active', NULL, NULL, NULL),
(623, '', '', 'MIFTAKHUL ULUM AL HUDA', 13, 'active', NULL, NULL, NULL),
(624, '', '', 'MUHAMAD NABIL', 13, 'active', NULL, NULL, NULL),
(625, '', '', 'MUHAMMAD NAUFAL', 13, 'active', NULL, NULL, NULL),
(626, '', '', 'NAUFAL DANISH ASSIDIQ', 13, 'active', NULL, NULL, NULL),
(627, '', '', 'PRADIKA PUJI SATRIA', 13, 'active', NULL, NULL, NULL),
(628, '', '', 'PUTRA ADLU RAMADHAN', 13, 'active', NULL, NULL, NULL),
(629, '', '', 'RAFI KURNIAWAN', 13, 'active', NULL, NULL, NULL),
(630, '', '', 'RICIE ARKIM SAH', 13, 'active', NULL, NULL, NULL),
(631, '', '', 'RIDHO HAMBALI SABILLAH', 13, 'active', NULL, NULL, NULL),
(632, '', '', 'RIZAL SUGIARTO', 13, 'active', NULL, NULL, NULL),
(633, '', '', 'RIZQI BUDI PRASETIYO', 13, 'active', NULL, NULL, NULL),
(634, '', '', 'RUDI SETIAWAN', 13, 'active', NULL, NULL, NULL),
(635, '', '', 'TAUFIK HIDAYAT', 13, 'active', NULL, NULL, NULL),
(636, '', '', 'VICTOR PRADANA', 13, 'active', NULL, NULL, NULL),
(637, '', '', 'ADRIAN PRATAMA', 14, 'active', NULL, NULL, NULL),
(638, '', '', 'AGUS NURCAHYONO', 14, 'active', NULL, NULL, NULL),
(639, '', '', 'AHMAD SOFIAN', 14, 'active', NULL, NULL, NULL),
(640, '', '', 'AKHMAL RIZIQ MAULANA', 14, 'active', NULL, NULL, NULL),
(641, '', '', 'ALFIN ADHITIYANTO', 14, 'active', NULL, NULL, NULL),
(642, '', '', 'ALVINO ADITYA PUTRA', 14, 'active', NULL, NULL, NULL),
(643, '', '', 'ANDRE FIRMANSYAH', 14, 'active', NULL, NULL, NULL),
(644, '', '', 'APRI ANDI SAPUTRA', 14, 'active', NULL, NULL, NULL),
(645, '', '', 'ARIFIN SURYA PRATAMA', 14, 'active', NULL, NULL, NULL),
(646, '', '', 'ARINYANSYA', 14, 'active', NULL, NULL, NULL),
(647, '', '', 'ARYA APRILIYANTO', 14, 'active', NULL, NULL, NULL),
(648, '', '', 'DANIEL ANDIKA WARDANA', 14, 'active', NULL, NULL, NULL),
(649, '', '', 'DWI RIZKY RAMADHANI', 14, 'active', NULL, NULL, NULL),
(650, '', '', 'EGY MAULANA', 14, 'active', NULL, NULL, NULL),
(651, '', '', 'ERFYAN SYACH RAMADHANI', 14, 'active', NULL, NULL, NULL),
(652, '', '', 'FAJAR FEBRIANTO', 14, 'active', NULL, NULL, NULL),
(653, '', '', 'FARDAN APRIANSYAH', 14, 'active', NULL, NULL, NULL),
(654, '', '', 'FARHAN ALAM SYAH', 14, 'active', NULL, NULL, NULL),
(655, '', '', 'FAUZAN ARIFIN ILHAM', 14, 'active', NULL, NULL, NULL),
(656, '', '', 'FAUZAN SISWO RIYADI', 14, 'active', NULL, NULL, NULL),
(657, '', '', 'GILANG FERNANDA', 14, 'active', NULL, NULL, NULL),
(658, '', '', 'ILHAM RASYA PRATAMA', 14, 'active', NULL, NULL, NULL),
(659, '', '', 'INDRA KUSUMA', 14, 'active', NULL, NULL, NULL),
(660, '', '', 'KAKA MAHENDRA', 14, 'active', NULL, NULL, NULL),
(661, '', '', 'KEVIN EDI PRATAMA', 14, 'active', NULL, NULL, NULL),
(662, '', '', 'KEVIN EKA SAPUTRA', 14, 'active', NULL, NULL, NULL),
(663, '', '', 'KEVIN SETIAWAN', 14, 'active', NULL, NULL, NULL),
(664, '', '', 'KHAERUDIN GALIH SUNYOTO', 14, 'active', NULL, NULL, NULL),
(665, '', '', 'MARVEL ADITYA SAPUTRA', 14, 'active', NULL, NULL, NULL),
(666, '', '', 'MOHAMAD RISKY NURMAULIDIN', 14, 'active', NULL, NULL, NULL),
(667, '', '', 'MUHAMAD ISNI FAIZAL', 14, 'active', NULL, NULL, NULL),
(668, '', '', 'NAJU MILIARTORO', 14, 'active', NULL, NULL, NULL),
(669, '', '', 'PRAMUDIKA BAYU FIRMANDAZA', 14, 'active', NULL, NULL, NULL),
(670, '', '', 'RAMADANI PUTRA ASTONO', 14, 'active', NULL, NULL, NULL),
(671, '', '', 'RIDHO MUKTI PAMUJI', 14, 'active', NULL, NULL, NULL),
(672, '', '', 'RIFQI ADITYA RIZQULLAH', 14, 'active', NULL, NULL, NULL),
(673, '', '', 'RIZKY INDRIANTORO', 14, 'active', NULL, NULL, NULL),
(674, '', '', 'SATRIA AGUNG PRATAMA', 14, 'active', NULL, NULL, NULL),
(675, '', '', 'SETO IDI PANGESTU', 14, 'active', NULL, NULL, NULL),
(676, '', '', 'SYARIF ANDHIKA PRATAMA', 14, 'active', NULL, NULL, NULL),
(677, '', '', 'TEGAR ANDREANSYAH', 14, 'active', NULL, NULL, NULL),
(678, '', '', 'WAHYU NUR FEBRIAN', 14, 'active', NULL, NULL, NULL),
(679, '', '', 'WILDAN FAZA KHOZANA', 14, 'active', NULL, NULL, NULL),
(680, '', '', 'ZAKIYY NUUR RAHMAAN', 14, 'active', NULL, NULL, NULL),
(681, '', '', 'ADIT ARDIYANSYAH', 15, 'active', NULL, NULL, NULL),
(682, '', '', 'ADRIAN HARRY FIRMANSYAH', 15, 'active', NULL, NULL, NULL),
(683, '', '', 'AGUS SETIAWAN', 15, 'active', NULL, NULL, NULL),
(684, '', '', 'AHMAD ZIKRI MAULANA', 15, 'active', NULL, NULL, NULL),
(685, '', '', 'AL ATHA MUGI PRASETYO', 15, 'active', NULL, NULL, NULL),
(686, '', '', 'ALWI ZAINUR ROHMAN', 15, 'active', NULL, NULL, NULL),
(687, '', '', 'ANANDA OKTAVIAN', 15, 'active', NULL, NULL, NULL),
(688, '', '', 'ANDIKA DWI JAYANTO', 15, 'active', NULL, NULL, NULL),
(689, '', '', 'ARDA ZAKARIA RISKI', 15, 'active', NULL, NULL, NULL),
(690, '', '', 'AVIAN EVAN RIFANO', 15, 'active', NULL, NULL, NULL),
(691, '', '', 'AZRIL YOGA PRAMUDITA', 15, 'active', NULL, NULL, NULL),
(692, '', '', 'BAGAS SAPUTRA', 15, 'active', NULL, NULL, NULL),
(693, '', '', 'BEKTI ADI KURNIAWAN', 15, 'active', NULL, NULL, NULL),
(694, '', '', 'DENI FAIZAL SUFIAN', 15, 'active', NULL, NULL, NULL),
(695, '', '', 'DANU ANDON ARWANGGA HASAN', 15, 'active', NULL, NULL, NULL),
(696, '', '', 'FADIL SURYA PRATAMA', 15, 'active', NULL, NULL, NULL),
(697, '', '', 'FAVIAN JUNIOR PRATAMA', 15, 'active', NULL, NULL, NULL),
(698, '', '', 'FENDI ARDIANTO', 15, 'active', NULL, NULL, NULL),
(699, '', '', 'FIRMAN ALDI SETIAWAN', 15, 'active', NULL, NULL, NULL),
(700, '', '', 'GIYAN TRI TOSO', 15, 'active', NULL, NULL, NULL),
(701, '', '', 'HAIKAL ADITIA FIRMANSYAH', 15, 'active', NULL, NULL, NULL),
(702, '', '', 'HANIF DWI SUSANTO', 15, 'active', NULL, NULL, NULL),
(703, '', '', 'HASTA ARYA GUTAMA', 15, 'active', NULL, NULL, NULL),
(704, '', '', 'IBNU NAWAWI', 15, 'active', NULL, NULL, NULL),
(705, '', '', 'ILHAM ZIHRIL RAMADHAN', 15, 'active', NULL, NULL, NULL),
(706, '', '', 'INDRA KURNIAWAN', 15, 'active', NULL, NULL, NULL),
(707, '', '', 'INDRA LUKMANUL HAKIM', 15, 'active', NULL, NULL, NULL),
(708, '', '', 'KURNIA TRIA NUGROHO', 15, 'active', NULL, NULL, NULL),
(709, '', '', 'MARYONO FAUZI', 15, 'active', NULL, NULL, NULL),
(710, '', '', 'MUHAMAD AL FATHUL MUINUDIN', 15, 'active', NULL, NULL, NULL),
(711, '', '', 'MUHAMMAD FATCHUN NI\'AM', 15, 'active', NULL, NULL, NULL),
(712, '', '', 'MUHAMAD NASIKH ULWAN', 15, 'active', NULL, NULL, NULL),
(713, '', '', 'MUHAMMAD ABDUL SALMAN ALFARIZI', 15, 'active', NULL, NULL, NULL),
(714, '', '', 'MUHAMMAD EKA FATKHUL KHOIR', 15, 'active', NULL, NULL, NULL),
(715, '', '', 'MUIZ MUSAHALI SAPUTRA', 15, 'active', NULL, NULL, NULL),
(716, '', '', 'PRASTIONO', 15, 'active', NULL, NULL, NULL),
(717, '', '', 'RENDY NURROCHMAN SUBEQTI', 15, 'active', NULL, NULL, NULL),
(718, '', '', 'REZA DIANANDIKA', 15, 'active', NULL, NULL, NULL),
(719, '', '', 'RIFKI DWI ALDIANSYAH', 15, 'active', NULL, NULL, NULL),
(720, '', '', 'RISKI ARDIANTO', 15, 'active', NULL, NULL, NULL),
(721, '', '', 'SUBHAN AHMAD NUR FATONI', 15, 'active', NULL, NULL, NULL),
(722, '', '', 'WILIAM MARSELO', 15, 'active', NULL, NULL, NULL),
(723, '', '', 'YONGKY SAPUTRA', 15, 'active', NULL, NULL, NULL),
(724, '', '', 'ZAKI RAMADAN', 15, 'active', NULL, NULL, NULL),
(725, '', '', 'ZULFA PRIANDITA', 15, 'active', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_tugas`
--
CREATE TABLE `tb_tugas` (
  `id` bigint UNSIGNED NOT NULL,
  `id_guru` int UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_tugas_status`
--
CREATE TABLE `tb_tugas_status` (
  `id` bigint UNSIGNED NOT NULL,
  `id_tugas` int UNSIGNED NOT NULL,
  `id_siswa` int UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--
CREATE TABLE `tb_users` (
  `id` bigint UNSIGNED NOT NULL,
  `id_user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','siswa','guru') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'siswa',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id`, `id_user`, `username`, `password`, `role`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1', 'mikaela', '$2y$12$Ci1kVZX5StANCQbjls8k8.dGsG3d.Oi960pTf1yYSv6j.TmQF3KBe', 'admin', 'active', NULL, NULL, NULL),
(2, '2', 'martiti-roniasih', '$2y$12$D0Fl5.nJonturDGvTbc/M.h5hAr2En8XL.UF9VFRWhZveTYGNHC0i', 'guru', 'active', NULL, NULL, NULL),
(3, '3', 'novianti-nutriani', '$2y$12$x1S/aD6QFtIrleTsOEqxhu9sqwGVJlWRlFj/SoWSBn89rF06gbmP6', 'guru', 'active', NULL, NULL, NULL),
(4, '4', 'neti-yulianti', '$2y$12$kf3DAcH8aa7sEPdjZ2IyLuO8eRVNl3ES5j7Pu7mYC0t6XmvClSL32', 'guru', 'active', NULL, NULL, NULL),
(5, '5', 'panata-testi', '$2y$12$WN4qpZqusUdqiq/ZLPnNUu32Vph1ALYPxThqjl3XJcUjuGrNFyb.i', 'guru', 'active', NULL, NULL, NULL),
(6, '6', 'nurcahyani-putri', '$2y$12$zNx1br1ZA/0C2KdjXeLe7u7ysJj1uSic171CNm.De90g1jYi98NJy', 'guru', 'active', NULL, NULL, NULL),
(7, '7', 'yuni-afidah', '$2y$12$nz0Vc5/HUnI/HwBCsm472u18fnhkFHOQYQ5Ety38bfc2GhUQpv2kO', 'admin', 'active', NULL, NULL, NULL),
(8, '8', 'sri-mulyani', '$2y$12$hn60Vkkk228bp06RJ51Ub.yiqtBVGtETTBeRltVG0fX85lXFGQj.O', 'guru', 'active', NULL, NULL, NULL),
(9, '9', 'gentur-hanif', '$2y$12$F9XxebnxgDXg8Vq8GHvQjOhQ5o8d9hKGk6C.0ZzDM5RLsbhpurNPq', 'guru', 'active', NULL, NULL, NULL),
(10, '10', 'widyaningrum', '$2y$12$aLZIpSsoHpPWFJl3Z3tIAuF.68tKazVk67ROgoQ.kCuXSufnKkbyG', 'guru', 'active', NULL, NULL, NULL),
(11, '11', 'elly-kusuma', '$2y$12$hWVg7DRPEfw5TvxyWG5Bme2VfFrB0/H2loltS7ifQu3zDM5mZts9K', 'guru', 'active', NULL, NULL, NULL),
(12, '12', 'fauzi-alfadlili', '$2y$12$aZhdKc0hAvPdwr16dVPW2O4CEstDtQdw/TFzX2vDVB.APUnkk11e6', 'guru', 'active', NULL, NULL, NULL),
(13, '13', 'shelly-nur-afifah', '$2y$12$R8sWEU33NgdIyuqObdBneOzjKjBsJEvqq8UPmRHYy/rpxTRwF08Oe', 'admin', 'active', NULL, NULL, NULL),
(14, '14', 'rudi-prida', '$2y$12$TSk2MA6N76.ScJQFnoxxXufjTs23k5ztwbN451TnX.FjxIa8NNa9e', 'guru', 'active', NULL, NULL, NULL),
(15, '15', 'wening-trisna', '$2y$12$5Pw5Nuu5OWHuh8CQ2TEuJuKF9NDJ3iFml9kChrXNSfqddnmWtZcq.', 'guru', 'active', NULL, NULL, NULL),
(16, '16', 'syahdudin', '$2y$12$UvxM2ltWCpFgHCl5KJ5xvuhmCJ6VgxsjvG1QlcA7j.1/R/gk/hfmy', 'guru', 'active', NULL, NULL, NULL),
(17, '17', 'odhi-rochman', '$2y$12$4KXIPeUzh3TIQpRYrDKqQ.ek3AiMpJ9GeuJ.7gX7HpKNfbUkH0fxe', 'admin', 'active', NULL, NULL, NULL),
(18, '18', 'fajar', '$2y$12$Sx8dFzYt08ad1Jm7vwyYhufe6RAj4TEXMyguOySf4neOn2UscAKrG', 'guru', 'active', NULL, NULL, NULL),
(19, '19', 'faizal-amri', '$2y$12$UbycJV/m8kd5Pl3rlgd/Qe9kpd9SJzMzEDRCGTAZKpxb6qJrhpk..', 'guru', 'active', NULL, NULL, NULL),
(20, '20', 'riza-desi', '$2y$12$JOHZs.ke9n/Ucc30r4dHh.gusi5L5Qe0Ce9E1vAY5qm5FY0SazLhW', 'guru', 'active', NULL, NULL, NULL),
(21, '21', 'anton-hermawan', '$2y$12$Gx2ynhn0poFkOi2svyKoCuABKBD3/wiZTd.0LUqTNTWuMm/jJBsRi', 'guru', 'active', NULL, NULL, NULL),
(22, '22', 'primery-chita', '$2y$12$.aNJbVU62oF91bGAeqaN7Odhb9tEm9834qB10y.S3d3q68SRY7HKG', 'guru', 'active', NULL, NULL, NULL),
(23, '23', 'fidi-setiawan', '$2y$12$B6OxV99LOeaKxGaIYzl8b.1yz3G7TphW9W0Nk1deawsPEg1tF1yAK', 'guru', 'active', NULL, NULL, NULL),
(24, '24', 'karsih', '$2y$12$eUbkdlB8bWP1VAK768IZqu808KNIdkZckhHaHuZyZVdpsNyY0cKke', 'guru', 'active', NULL, NULL, NULL),
(25, '25', 'yazid-afifudin', '$2y$12$jHct5EEZCuy3RAzm8qAcmeW0xWKtGnnawQXNOhqJEbDGeEa6UqVwm', 'admin', 'active', NULL, NULL, NULL),
(26, '26', 'nugroho-brianto', '$2y$12$p9g.FLR6GXd7BrNSworDqOJQane8Jn.qlnIm3.UUedoa4zbb9tUam', 'admin', 'active', NULL, NULL, NULL),
(27, '27', 'ayu-wiji-lestari', '$2y$12$srQYlgqxqTVRh/PhB6Dii.SRSdCrqQatsBQj.BRT3/M.XfqzT.7jO', 'admin', 'active', NULL, NULL, NULL),
(28, '28', 'miftakhurrohman', '$2y$12$opAaal0YRnMkvpwpideVxOby29J9t4J8hZrCECakZ2C/GH7t5q/qC', 'guru', 'active', NULL, NULL, NULL),
(29, '29', 'hiri-joko-ottapa', '$2y$12$7jivWhdDUf8nAKQRR0FKbeMSMUtKU88P90kUERHjJaFp7VjQv4HMW', 'guru', 'active', NULL, NULL, NULL),
(30, '30', 'fuad-surakhman', '$2y$12$cUIPyWKBS7w3771LTVa8DuUnMHyC0dFR2kRHNVZHMxZW.1O0RRqbm', 'guru', 'active', NULL, NULL, NULL),
(31, '31', 'aji-munandar', '$2y$12$Snt4J9HnYO6pPCofmi4l.OS90h8ArsFJ7bcjJZ0/pJqZwDHpgksrG', 'guru', 'active', NULL, NULL, NULL),
(32, '32', 'ani-setianingsih', '$2y$12$RoOUBN0WbuRYNeGIpSFAnOO8Xsc97I/dv2EkJVvNKVwRnPmnlH69a', 'guru', 'active', NULL, NULL, NULL),
(33, '33', 'refi-idha', '$2y$12$HtAoJv1cEISwefbbcc/d0Oyd9774bhNGiwWUyBD26pF0zspB5APNO', 'guru', 'active', NULL, NULL, NULL),
(34, '34', 'adis-marbatri', '$2y$12$M1qfJdhVnGfQJ3AxlLg4Oux8DdkIlvwC7SBoAV/YKcFPqWjKQ3w/e', 'guru', 'active', NULL, NULL, NULL),
(35, '35', 'zainul-muttaqin', '$2y$12$kYtQXitgjz6IqccVmmHDNOhuM49cGyAqZ2Vuy7wtKXLPs/bI8sd96', 'guru', 'active', NULL, NULL, NULL),
(36, '36', 'novita-setyanti', '$2y$12$OhwIe2dp61e3WY.3PCHB1.x/0adJOTpzcVj5aD16UXeua0spxrGti', 'guru', 'active', NULL, NULL, NULL),
(37, '37', 'annisa-ika', '$2y$12$N0lTygki0cTVrSjtksNnT.EiS8DSqqQAQTAU.gZkFmuoOYu6dc68S', 'guru', 'active', NULL, NULL, NULL),
(38, '38', 'tiffani-arum', '$2y$12$bsUU0LX7U7jRoSG/flCIJO5ZEEXHUPNcNImMiWbh8ZxB0Vp5lq79.', 'guru', 'active', NULL, NULL, NULL),
(39, '39', 'suhartono', '$2y$12$QOK42O8FZd5PLHm0tajrr.fAwTdM30qMBewt74/UnCqA3LiG10V.6', 'guru', 'active', NULL, NULL, NULL),
(40, '40', 'lutfy-reza', '$2y$12$I8jiiC.Dy6cU21iAwV89EOP4YjXXqDHOQ.4HDd7p7NDr9G/rYspve', 'guru', 'active', NULL, NULL, NULL),
(41, '41', 'annisa-putri', '$2y$12$MvzcIsONL5qeBvRF2LHDBueIrgc25DtcygESmHeCgHjGrgnEPgQbC', 'guru', 'active', NULL, NULL, NULL),
(42, '42', 'arum-wijayanti', '$2y$12$Jy8T84j9yAYbXmFjMD0pyOh7SC5VbXUxHOy5eGg7dgCKkavPSc/WG', 'guru', 'active', NULL, NULL, NULL),
(43, '43', 'silfi-pratiwi', '$2y$12$H9/yKCIoSHWGQtKT1W1EZ.Z3aUYKMBaiqjCNXk1.6krwn8r4V1tYK', 'guru', 'active', NULL, NULL, NULL),
(44, '44', 'sugeng-tri', '$2y$12$2YUuq8mT5iF3jLeLzK1hBeXQMe5mXdWm60QfNopCmIRcSqOYka7LW', 'guru', 'active', NULL, NULL, NULL),
(45, '45', 'atika-rohmawati', '$2y$12$nvTAqEUsEF.Uk9v9N/6w1.XGnkbccA995OxZGZlqIeu2d.SYocqma', 'guru', 'active', NULL, NULL, NULL),
(46, '46', 'maruf-egie', '$2y$12$4OUFlUvQxqqPNRu8o7hGJOWA2czX.DsLpwEyt0drzRmh7TCYkp6em', 'guru', 'active', NULL, NULL, NULL),
(47, '47', 'nurmalita-muflihah', '$2y$12$i3xpEZ6nmyunIXIyRokrouV93z.dBrs76cVipXgETQDKOzlpgcG6y', 'guru', 'active', NULL, NULL, NULL),
(48, '48', 'dwi-angesti', '$2y$12$bG1U.vtO3fJcqffvCfvf4O4l7u.MdU0wMDcJzagZU9qNenghRDzw.', 'guru', 'active', NULL, NULL, NULL),
(49, '49', 'ahsanul-huluq', '$2y$12$Q1h11zV4.acLJIpQBf.jWOAhwZYNQYJB6cY5QIIJPAGNKQVB7Vr3K', 'guru', 'active', NULL, NULL, NULL),
(50, '50', 'ahmad-ihsan-syauqi', '$2y$12$HWuvYCTS0Z6hVQ8ucB0FsuBEk7wZLVdgjxKoqyuK668QFs4hpAN1m', 'guru', 'active', NULL, NULL, NULL),
(51, '51', 'atib-nurul', '$2y$12$arp5vfzj/K6XqpAhXrqRtOpdFNbDaPAYE0ytdyobRzi6fI0i1nqFS', 'guru', 'active', NULL, NULL, NULL),
(52, '52', 'sugito', '$2y$12$ojGidPAPqjILy7fvpVEevuWPkhHG8Vxp0h2R2no5DRbgf0DOebyQq', 'guru', 'active', NULL, NULL, NULL),
(53, '53', 'anggraeni-kartika-sari', '$2y$12$Rvfj5UNdvhXqNrzqgJIo4.GCfAPBhTOyNdhV4xWQ0faE8q1KNjYOG', 'guru', 'active', NULL, NULL, NULL),
(54, '54', 'ilham-firdaus', '$2y$12$V.fNugwSRAiic.H0eKt9WuUbhluYzafoefJbbp5Z6VCeUxBaZmTLC', 'guru', 'active', NULL, NULL, NULL),
(55, '55', 'syifa-labibah-parmawati', '$2y$12$IDoqfmvjPcefLv8GxqjMnezl7A8y3sBi10g1YyjPkI67h9Tk7fGiG', 'guru', 'active', NULL, NULL, NULL),
(100, '100', 'afifah-isti-rustriana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(101, '101', 'afriniar-tyas-wening', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(102, '102', 'agnes-sapitri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(103, '103', 'aisyah-syifani-wibowo', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(104, '104', 'alfinatu-zahwa-uswatun-syarifah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(105, '105', 'amelia-rachmadani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(106, '106', 'anggia-feli-agustina-febriyanti', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(107, '107', 'assyifa-toyifatun-munazah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(108, '108', 'aulia-nur-meliyana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(109, '109', 'aurora-candraningtyas-pramodha-wardhani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(110, '110', 'azzahra-milatul-ulya-sugiarto', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(111, '111', 'bella-anis-maulida', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(112, '112', 'dea-anta-dwi-pertiwi', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(113, '113', 'della-ratma-karunia', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(114, '114', 'dewi-anggy-ramadhina', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(115, '115', 'divana-kartika-mega', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(116, '116', 'diyan-triasih', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(117, '117', 'fara-eka-elmiana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(118, '118', 'fawnia-laili-warisa', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(119, '119', 'hanifa-fitri-aulia', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(120, '120', 'hanin-jasmintiasari', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(121, '121', 'hawa-riska-khoerunnisa', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(122, '122', 'karen-puspita-febriani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(123, '123', 'karisma-niken-puri-maharani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(124, '124', 'kholifatu-latifah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(125, '125', 'lutfiana-eka-saputri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(126, '126', 'miszahra-ramadhan-hasanah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(127, '127', 'nur-fitriyani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(128, '128', 'priti-nabila-aura-kasih', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(129, '129', 'qonita-nurul-izzah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(130, '130', 'qurrotul-a\'yunina', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(131, '131', 'ranim-ramdhani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(132, '132', 'rayani-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(133, '133', 'revi-aulia', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(134, '134', 'riska-febriana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(135, '135', 'salsabila-dwi-larasati', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(136, '136', 'serly-afrelia', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(137, '137', 'syahla-noor-hanifah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(138, '138', 'tiara-ayu-wulandari', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(139, '139', 'ummu-zahwatul-ula', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(140, '140', 'vivi-riski-muhhajijah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(141, '141', 'widya-anwar', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(142, '142', 'yayang-zebrina-asmirifkah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(143, '143', 'zaskia-ayunita-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(144, '144', 'zulfatul-afifa-rahma', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(145, '145', '\'ainun-qirom-regina-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(146, '146', 'alexsa-elviayu', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(147, '147', 'alfie-raya-nur-fadillah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(148, '148', 'alifa-ni\'matun-hasanah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(149, '149', 'alvita-diyanti', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(150, '150', 'armelia-rizki-habibah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(151, '151', 'asyifa-nur-andini', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(152, '152', 'azzahra-cindy-saputry', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(153, '153', 'canti-nur-rayna-fadilah-prastyo', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(154, '154', 'desi-puspitasari', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(155, '155', 'devin-prastyo-nugroho', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(156, '156', 'endah-kusumawardani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(157, '157', 'erika-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(158, '158', 'evi-pratiwi', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(159, '159', 'fathya-aulia-rayhana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(160, '160', 'gendhis-fathiya-shafa-ramadhani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(161, '161', 'halimah-tussadiyah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(162, '162', 'heni-febriyanti', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(163, '163', 'intan-aulia-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(164, '164', 'intan-purnama-sari', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(165, '165', 'jesika-aulia-novita', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(166, '166', 'jihan-isnaeni', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(167, '167', 'juanita-afifah-azzahro', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(168, '168', 'junyantika-arianisa-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(169, '169', 'khesyah-nuriyah-awaludin', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(170, '170', 'kuwat-budi-hartini', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(171, '171', 'latiefahtul-khaerunisa-khanif', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(172, '172', 'lulu-atun-nafisah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(173, '173', 'lutfi-awliya-khaya', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(174, '174', 'luthfita-nur-rizkyani-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(175, '175', 'marsya-allfiona-setiani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(176, '176', 'meisya-ayu-azizah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(177, '177', 'naila-kamalia', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(178, '178', 'nanda-alena-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(179, '179', 'nanda-mar\'atul-khusna', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(180, '180', 'nina-kartika-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(181, '181', 'rafika-damayanti', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(182, '182', 'satria-dika-permana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(183, '183', 'sefina-putri-khasanah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(184, '184', 'selfi-ramadani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(185, '185', 'sofi-oktafiani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(186, '186', 'solekha-nur-anditi', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(187, '187', 'syifa-afril-riyani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(188, '188', 'wylda-willadatus-solihah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(189, '189', 'yuni-may-saroh', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(190, '190', 'zahra-aulia-fitriyadi', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(191, '191', 'zasqia-dini-harimukti', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(192, '192', 'adilla-zahra-ramadhani-artina', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(193, '193', 'afifah-athalia-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(194, '194', 'amira-zahra-salsabila', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(195, '195', 'andini-mutiara-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(196, '196', 'annisa-lutfiana-zahra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(197, '197', 'aprilia-elma-saputri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(198, '198', 'arista-nur\'aini', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(199, '199', 'aulia-anggita-setiawan', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(200, '200', 'avalita-agustina-rahmadani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(201, '201', 'avrillia-dewi-suwandari', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(202, '202', 'chelsea-novita-anggraeni', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(203, '203', 'dea-septikhulfiah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(204, '204', 'della-isti-irawan', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(205, '205', 'destania-intan-permata', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(206, '206', 'dewi-anggar-sari', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(207, '207', 'diana-fitri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(208, '208', 'elivia-irviani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(209, '209', 'felyta-puspitasari', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(210, '210', 'ika-aprilia-widatul-ulya', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(211, '211', 'ike-anesha-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(212, '212', 'inaya-azmi-nadhifa', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(213, '213', 'lilis-nur-aisyah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(214, '214', 'melia-dewi-santika', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(215, '215', 'milie-nasution', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(216, '216', 'naisya-rahmadani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(217, '217', 'okta-nur-aisyah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(218, '218', 'rahmah-aulia-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(219, '219', 'riska-dewi-saputri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(220, '220', 'rita-sopiatun', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(221, '221', 'seviana-dewi', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(222, '222', 'seza-aminati', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(223, '223', 'shakila-khanazah-darmawan', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(224, '224', 'shofi-sekar-wati', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(225, '225', 'sulis-juliana-safitri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(226, '226', 'syafa-diti-febiana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(227, '227', 'syafa-keke-kirani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(228, '228', 'syafira-thalita-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(229, '229', 'tia-sri-mulyanti', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(230, '230', 'tiara-bella', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(231, '231', 'tiara-juliana-ningrum', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(232, '232', 'vahrisa-tiara-fitri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(233, '233', 'vika-ma\'rifatul-hasanah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(234, '234', 'yeli-triya-ningsih', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(235, '235', 'zahrotul-afifah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(236, '236', 'allen-apriliana-aryanti', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(237, '237', 'alvira-bunga-febriana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(238, '238', 'anisa-junia-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(239, '239', 'anzah-marcelina', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(240, '240', 'apri-setia-wati', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(241, '241', 'aprillia-listianingsih', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(242, '242', 'arina-salsabila', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(243, '243', 'ayu-maisya-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(244, '244', 'defi-sulia-fatmawati', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(245, '245', 'dwi-olivia', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(246, '246', 'eka-ristina-melani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(247, '247', 'esti-komaria', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(248, '248', 'firdhah-putiga', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(249, '249', 'friska-aurelia-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(250, '250', 'hafifah-nuraeni', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(251, '251', 'ika-mei-cahyani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(252, '252', 'ina-lestari', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(253, '253', 'isma-tri-aprilia', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(254, '254', 'kayla-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(255, '255', 'lisna-janatul-ma`wa', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(256, '256', 'mufidah-nur-izzati', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(257, '257', 'nabila-eka-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(258, '258', 'ni\'matu-sulisah-robingah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(259, '259', 'nisa-felicia-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(260, '260', 'nisrin-nayla-fatma', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(261, '261', 'opcy-salwa-oktaviana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(262, '262', 'rafellina-ramadani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(263, '263', 'refiana-yanuardiah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(264, '264', 'revinka-rama-gesvani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(265, '265', 'ristiani-puspita-dewi', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(266, '266', 'rizka-widya-lestari', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(267, '267', 'sabrina-az-zahra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(268, '268', 'safa-anjani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(269, '269', 'salsabila-syafa\'-aulia', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(270, '270', 'salsabilla-oktaviana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(271, '271', 'septi-ayu-wulandari', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(272, '272', 'silvia-widia-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(273, '273', 'sinar-ing-juliya', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(274, '274', 'syafiya-nurul-luthfiani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(275, '275', 'syifa-nur-hidayah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(276, '276', 'ulva-hasanah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(277, '277', 'vianita-saputri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(278, '278', 'vienska-wahyu-anjani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(279, '279', 'vivi-prihandini', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(280, '280', 'widia-agustina-safitri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(281, '281', 'wilda-jihan-faiza', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(282, '282', 'yunita-auni-rahayu', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(283, '283', 'adinda-mila-rahar-diani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(284, '284', 'aisah-putri-febianti', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(285, '285', 'aisyah-nabila', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(286, '286', 'alenta-nur-chayanti', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(287, '287', 'al-farahizah-filyatul-agatia', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(288, '288', 'anisa-nur-aini', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(289, '289', 'arvita-ramadhani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(290, '290', 'aura-etika-aldin', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(291, '291', 'bilqis-alifah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(292, '292', 'callysta-calya-alifah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(293, '293', 'chyntia-azzahra-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(294, '294', 'dila-ramadani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(295, '295', 'dwi-cahya-nur-aisyah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(296, '296', 'eka-ramadhani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(297, '297', 'faizah-friska-putri-as-zahra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(298, '298', 'gayuh-puspa-letiza', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(299, '299', 'intan-nur-aini', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(300, '300', 'isma-kayla-octavia-albani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(301, '301', 'ismi-affifah-ahmad', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(302, '302', 'keysha-dinda-mareta', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(303, '303', 'lisa-dwi-ramadani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(304, '304', 'meilina-afriani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(305, '305', 'naiela-leyali-azkya', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(306, '306', 'nazwa-oktoviani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(307, '307', 'novita-dewi-ahdelia', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(308, '308', 'novita-regina-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(309, '309', 'purwatiningtyas', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(310, '310', 'retno-sella-sahita', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(311, '311', 'salsabila-khoerun-nisa', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(312, '312', 'shelly-azka-sekar-kamardika', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(313, '313', 'sindi-puspitasari', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(314, '314', 'sohiba-naza-valentina', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(315, '315', 'wulan-shyafifuji-munawaroh', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(316, '316', 'yosika-lutfiana-aprela', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(317, '317', 'zakiyatul-faakhiroh', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(318, '318', 'alya-alsa-rohali', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(319, '319', 'alya-endah-putri-sudiro', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(320, '320', 'apdian-putri-winarsih', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(321, '321', 'aprilia-bunga-lestari', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(322, '322', 'dian-ayu-lestari', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(323, '323', 'dina-wahidatun-hikmah-afrilia', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(324, '324', 'dwi-rahma-luthfita', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(325, '325', 'erika-novatul-afifah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(326, '326', 'evi-apriliani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(327, '327', 'inaya-tussolihah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(328, '328', 'kuunii-mardliyah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(329, '329', 'lulu-novita-sari', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(330, '330', 'marcella-chrystin-steffany', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(331, '331', 'meliana-rizka-azahra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(332, '332', 'nabila-aprilliani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(333, '333', 'naiya-rahmadhani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(334, '334', 'nasya-aulia-fauziah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(335, '335', 'novia-rachmawati', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(336, '336', 'nur-fazura-balgis', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(337, '337', 'putri-aulia-priska', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(338, '338', 'putri-cornelia', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(339, '339', 'rifa-febriyani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(340, '340', 'rizky-febriani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(341, '341', 'rosalina-nur-arifian', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(342, '342', 'salsa-sofwatul-fazriyah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(343, '343', 'sarah-amelia-sari', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(344, '344', 'saskia-lailatul-salma', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(345, '345', 'saskia-riski-amalia', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(346, '346', 'shania-harliyani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(347, '347', 'sherin-alifia-istiqomah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(348, '348', 'sovie-septiani-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(349, '349', 'syifa-maharani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(350, '350', 'vica-nia-nofiana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(351, '351', 'yasmine-aulia-zahra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(352, '352', 'afifah-nur-sayang', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(353, '353', 'ainy-fiana-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(354, '354', 'akbar-septianpratama', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(355, '355', 'amanah-yogi-pratama', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(356, '356', 'andika-syah-putra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(357, '357', 'aqilah-zahir-hananira', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(358, '358', 'arifatu-zahra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(359, '359', 'asty-ananta', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(360, '360', 'azizah-syachmira-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(361, '361', 'daffa-aldhika-mikola', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(362, '362', 'desti-dwi-lestari', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(363, '363', 'dhiva-feliana-ayuningtyas', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(364, '364', 'dzaaka-dhiandra-pradhittya', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(365, '365', 'faizal-ridho-pratama', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(366, '366', 'fajar-ndaru-bekti', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(367, '367', 'falikhah-azalia-ramadhani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(368, '368', 'fira-dwi-elmiana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(369, '369', 'hestiana-putri-nabila', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(370, '370', 'julian-yusuf-akbar', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(371, '371', 'karisma-khuswatun-chasanah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(372, '372', 'kezha-nurjannah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(373, '373', 'khamdun-mamluki', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(374, '374', 'lu\'lua-putri-aghniyya', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(375, '375', 'lutfia-nur-hikmah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(376, '376', 'medina-faharani-purwanto', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(377, '377', 'mei-dwi-wulandari', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(378, '378', 'meilina-ayu-warseni', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(379, '379', 'muhamad-jammil-firdaus', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(380, '380', 'ngusman-isa-mahendra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(381, '381', 'raditya-akbar-saputra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(382, '382', 'rizka-khumairotuzzakiya', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(383, '383', 'sandi-nur-fadhilah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(384, '384', 'tiara-ajeng-pratiwi', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(385, '385', 'velika-hefa-sashenka', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(386, '386', 'wahdatul-husna-aulia-syihab', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(387, '387', 'wanda-putri-pramudita', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(388, '388', 'wildan-ashari', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(389, '389', 'winda-tri-hapsari', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(390, '390', 'afriliana-nurul-khasanah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(391, '391', 'ajeng-dwi-wulandari', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(392, '392', 'alia-widiastuti', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(393, '393', 'arifin-ilham', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(394, '394', 'aurel-fitri-nurul-afifah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(395, '395', 'ayu-aprilia-rahmawati', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(396, '396', 'bilqiis-trio-baihaqi-saputra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(397, '397', 'fadilla-adistya', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(398, '398', 'falih-tibyan', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(399, '399', 'feriko-yusuf-rahardi', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(400, '400', 'ferlita-mayasari', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(401, '401', 'mayzena-juliyanti', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(402, '402', 'miftah-adi-saputra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(403, '403', 'mika-apriliani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(404, '404', 'muhamad-candra-wijaya', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(405, '405', 'najwa-dwi-alika', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(406, '406', 'naufal-hilmi-tsaqib', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(407, '407', 'nindi-nur-asyifa', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(408, '408', 'praditya-wibowo-saputra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(409, '409', 'prasa-kafabillah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(410, '410', 'prisca-revita-ramadhani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(411, '411', 'rafi-nur-apriyanto', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(412, '412', 'rafka-kirana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(413, '413', 'rahma-gracea-mutakamillah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(414, '414', 'shela-amalia-sahra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(415, '415', 'syafiq-dwiky-maulana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL);
INSERT INTO `tb_users` (`id`, `id_user`, `username`, `password`, `role`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(416, '416', 'syifa-salsabila', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(417, '417', 'talita-aghnia-ulfia', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(418, '418', 'tiara-nur-aida', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(419, '419', 'tifani-letisia-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(420, '420', 'unzila-hasri-alfajri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(421, '421', 'veren-riza-aniansyah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(422, '422', 'vika-aullia-safitri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(423, '423', 'wulida-anindita', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(424, '424', 'zaki-kadavi', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(425, '425', 'zhakira-indah-septiana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(426, '426', 'adam-sukron-ma\'mun', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(427, '427', 'akhady-wira-satriaji-al-ghozali', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(428, '428', 'alam-muhammad-rizky', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(429, '429', 'alifia-dannis-azahra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(430, '430', 'anggi-devi-lestari', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(431, '431', 'arjun-aidam-hafid', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(432, '432', 'dandi-nanda-saputra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(433, '433', 'dina-resti-aprilia', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(434, '434', 'faiq-ikhsan-sajidan', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(435, '435', 'henny-novia', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(436, '436', 'kevin-andrian-maulana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(437, '437', 'kharisma-aproditha-putri-widyowati', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(438, '438', 'kintan-anggraeni', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(439, '439', 'laita-azalea', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(440, '440', 'malinda-eka-ramadhani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(441, '441', 'mariyan', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(442, '442', 'mella-fardani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(443, '443', 'muhammad-arya-haidar', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(444, '444', 'muhammad-diki-darmawan', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(445, '445', 'nadya-ariesya', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(446, '446', 'nafras-angga-permana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(447, '447', 'naila-istiro\'ah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(448, '448', 'nanda-nur-chasanah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(449, '449', 'nava-aulia-rahmawati', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(450, '450', 'nazwa-al-khoerunnisa', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(451, '451', 'noviana-cahya-arizka', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(452, '452', 'qori-zahran-willyanto', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(453, '453', 'radhitiya-levi-wijaya', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(454, '454', 'riska-oktafiana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(455, '455', 'sakila-cahya-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(456, '456', 'sherly-enjelina-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(457, '457', 'sheysa-putri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(458, '458', 'sifa-alfina-amelia-merdeka', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(459, '459', 'sifa-salsabila', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(460, '460', 'sri-sulistianingsih', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(461, '461', 'agung-setiawan', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(462, '462', 'ahmad-aszril-saefudin', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(463, '463', 'ahmad-irfansyah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(464, '464', 'ahmad-zaenul-rafli', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(465, '465', 'alfianzah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(466, '466', 'alief-hidayat', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(467, '467', 'arkaan-rizqi-riyadi', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(468, '468', 'arreyandi-artono', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(469, '469', 'dava-rifqi-mubarok', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(470, '470', 'derly-tri-kurniawan', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(471, '471', 'devin-alfaro-agustian-pratama', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(472, '472', 'dika-vainanda-pratama', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(473, '473', 'egy-chandra-wardana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(474, '474', 'fathur-rohman-mustaqim', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(475, '475', 'febrian-dwi-haryanto', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(476, '476', 'firmansyah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(477, '477', 'fito-destyan-putra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(478, '478', 'frenda-delfiano-ananza', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(479, '479', 'ikhsan-saputra-jemin', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(480, '480', 'isnan-nuh-alamsyah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(481, '481', 'itmam-nova-kurniawan', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(482, '482', 'kurnia-dika-putra-pratama', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(483, '483', 'malindo-saputra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(484, '484', 'muhammad-ainul-adzkiya', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(485, '485', 'muhammad-fathur-roziq', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(486, '486', 'muhazdibul-as\'ad', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(487, '487', 'naufal-raditya-putra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(488, '488', 'naufal-zaki-azzauhari', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(489, '489', 'nova-rianto-ardiansyah-putra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(490, '490', 'nur-rahmat-hidayat', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(491, '491', 'qhoerul-anuar', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(492, '492', 'raditya-pramansyah-albar', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(493, '493', 'rahman-istiadi', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(494, '494', 'rasya-ardianzah-pratama', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(495, '495', 'rayhan-oktaviansyah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(496, '496', 'riflian-cahya-pratama', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(497, '497', 'rizky-aprilianto', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(498, '498', 'sujiroh-rizki-al-hidayah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(499, '499', 'tafazul-wafiq-qobila', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(500, '500', 'wahyu-ridho-rochman', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(501, '501', 'zacky-rahman', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(502, '502', 'zaki-musyaffa', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(503, '503', 'zuhruf-taufiq-zubair', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(504, '504', 'aditya-candra-winata', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(505, '505', 'aditya-galih-frandika', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(506, '506', 'afdani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(507, '507', 'afgan-dhiya-ulhaq', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(508, '508', 'afriansyah-alba-maulana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(509, '509', 'ahmad-fatan-fathoni', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(510, '510', 'alif-zaqi-maulana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(511, '511', 'andika-maulana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(512, '512', 'arin-setia-fanu', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(513, '513', 'dika-fardian-saputra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(514, '514', 'duwi-parmono', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(515, '515', 'dwi-apriyanto', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(516, '516', 'fahri-aditiya', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(517, '517', 'farel-fahrezi', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(518, '518', 'farid-ragil-prayogi', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(519, '519', 'fikri-ardiansyah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(520, '520', 'galang-tyas-pratama', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(521, '521', 'ihsan-fadhil-nurfaris', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(522, '522', 'khoerul-umam-wahid', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(523, '523', 'lukman-saputra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(524, '524', 'mohamad-imam-mahfud', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(525, '525', 'mohammad-zaky-arnino-pratama', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(526, '526', 'mu\'ad-abdul-khakim', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(527, '527', 'muhamad-fadhil-fathurrohman', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(528, '528', 'muhamad-rizki-saputra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(529, '529', 'muhammad-faizal-hanafi', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(530, '530', 'muhammad-ilham-mubarok', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(531, '531', 'rafa-junianto', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(532, '532', 'raffa-deux-arya-julianto', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(533, '533', 'rahva-catur-raditia', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(534, '534', 'raihan-dias-subekti', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(535, '535', 'rayhan-dwi-permana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(536, '536', 'revan-ardiansah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(537, '537', 'revano-putra-arditya', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(538, '538', 'reza-anggita', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(539, '539', 'rizqi-arga-effendy', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(540, '540', 'setyo-abdurrahman-zaki', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(541, '541', 'shofyan-rizqi-setiawan', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(542, '542', 'sukur-ardiyansah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(543, '543', 'syahrul-taufik-ilhami', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(544, '544', 'vranks-boys', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(545, '545', 'wahyu-dwi-andika', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(546, '546', 'yuda-bachtiar', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(547, '547', 'zaynal-arif', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(548, '548', 'abdan-hamida', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(549, '549', 'adil-fathur-rahman', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(550, '550', 'aditia-khoirul', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(551, '551', 'aditya-rifki', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(552, '552', 'adrian-alvanza', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(553, '553', 'ahmad-aditia-pratama', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(554, '554', 'ahmad-forsa-julian-pratama', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(555, '555', 'ahmad-rifki-shofiyurrohman', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(556, '556', 'ajang-kumara-deva', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(557, '557', 'alfatah-robiul-sae', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(558, '558', 'alvian-rahmat-junianto', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(559, '559', 'alvin-fauzan-pratama', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(560, '560', 'angga-fajar-agustian', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(561, '561', 'arghanda-baharadi-cahyono', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(562, '562', 'azriel-nabhaan-al-fakhri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(563, '563', 'christiano-antonius', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(564, '564', 'davit-pangestu', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(565, '565', 'erlangga-azril-fajar-pamungkas', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(566, '566', 'faiq-ilham-baehaqi', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(567, '567', 'faizal-adi-saputra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(568, '568', 'fauzi-saputra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(569, '569', 'galeh-prayogi', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(570, '570', 'habibah-syaiu-rohmah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(571, '571', 'hanafi-al-zikri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(572, '572', 'hardi-septiyono', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(573, '573', 'hasan-maulana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(574, '574', 'iqbal-ferdiansyah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(575, '575', 'lucija-shira-az-anas', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(576, '576', 'moh.-irfa-darojat', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(577, '577', 'mohamad-irsya-faturizki', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(578, '578', 'muhamad-lukman-dava-azhari', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(579, '579', 'muhammad-sarifudin', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(580, '580', 'ray-friday-alfiansyah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(581, '581', 'refina-azzahra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(582, '582', 'refindo-nur-rohman', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(583, '583', 'rendi-nurrohim', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(584, '584', 'restu-aji-rama-dhani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(585, '585', 'revan-dwi-santoso', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(586, '586', 'reylen-saputra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(587, '587', 'rifai-abdul-salim', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(588, '588', 'riski-febriyanto', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(589, '589', 'rizky-maulana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(590, '590', 'safika-qurrotu-aini', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(591, '591', 'wiranto-galuh-saputra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(592, '592', 'ade-zulkarnaen', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(593, '593', 'ahmad-agustian-saputra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(594, '594', 'akmal-saeful-fahri', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(595, '595', 'alfansyah-muttaqin', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(596, '596', 'annas-firmansyah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(597, '597', 'aziz-nur-fauzi', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(598, '598', 'bayu-saputra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(599, '599', 'bayu-zidan-alrasid', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(600, '600', 'bintang-faizal', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(601, '601', 'dani-irfansyah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(602, '602', 'dani-yudstira', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(603, '603', 'dany-muarif', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(604, '604', 'eko-aji-saputra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(605, '605', 'erneus-firdaus', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(606, '606', 'fachri-maulana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(607, '607', 'fadhli-syahrul-hidayat', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(608, '608', 'faizal-febrianto', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(609, '609', 'farel-tri-subekti', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(610, '610', 'farhan-aditya', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(611, '611', 'fendi-ardhian-pratama', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(612, '612', 'fikri-ardianzah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(613, '613', 'firman-ardiansyah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(614, '614', 'giga-pranata', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(615, '615', 'gilang-eka-rhamadhan', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(616, '616', 'ilham-maulana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(617, '617', 'ilham-subkhan-romadhon', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(618, '618', 'imron-zakariya', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(619, '619', 'jerry-anwar-cannavaro', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(620, '620', 'keanu-bakhtoom-khalim', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(621, '621', 'keyfan-refaldi', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(622, '622', 'krisna-akbar-maolana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(623, '623', 'miftakhul-ulum-al-huda', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(624, '624', 'muhamad-nabil', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(625, '625', 'muhammad-naufal', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(626, '626', 'naufal-danish-assidiq', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(627, '627', 'pradika-puji-satria', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(628, '628', 'putra-adlu-ramadhan', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(629, '629', 'rafi-kurniawan', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(630, '630', 'ricie-arkim-sah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(631, '631', 'ridho-hambali-sabillah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(632, '632', 'rizal-sugiarto', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(633, '633', 'rizqi-budi-prasetiyo', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(634, '634', 'rudi-setiawan', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(635, '635', 'taufik-hidayat', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(636, '636', 'victor-pradana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(637, '637', 'adrian-pratama', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(638, '638', 'agus-nurcahyono', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(639, '639', 'ahmad-sofian', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(640, '640', 'akhmal-riziq-maulana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(641, '641', 'alfin-adhitiyanto', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(642, '642', 'alvino-aditya-putra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(643, '643', 'andre-firmansyah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(644, '644', 'apri-andi-saputra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(645, '645', 'arifin-surya-pratama', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(646, '646', 'arinyansya', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(647, '647', 'arya-apriliyanto', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(648, '648', 'daniel-andika-wardana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(649, '649', 'dwi-rizky-ramadhani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(650, '650', 'egy-maulana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(651, '651', 'erfyan-syach-ramadhani', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(652, '652', 'fajar-febrianto', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(653, '653', 'fardan-apriansyah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(654, '654', 'farhan-alam-syah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(655, '655', 'fauzan-arifin-ilham', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(656, '656', 'fauzan-siswo-riyadi', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(657, '657', 'gilang-fernanda', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(658, '658', 'ilham-rasya-pratama', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(659, '659', 'indra-kusuma', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(660, '660', 'kaka-mahendra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(661, '661', 'kevin-edi-pratama', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(662, '662', 'kevin-eka-saputra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(663, '663', 'kevin-setiawan', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(664, '664', 'khaerudin-galih-sunyoto', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(665, '665', 'marvel-aditya-saputra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(666, '666', 'mohamad-risky-nurmaulidin', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(667, '667', 'muhamad-isni-faizal', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(668, '668', 'naju-miliartoro', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(669, '669', 'pramudika-bayu-firmandaza', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(670, '670', 'ramadani-putra-astono', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(671, '671', 'ridho-mukti-pamuji', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(672, '672', 'rifqi-aditya-rizqullah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(673, '673', 'rizky-indriantoro', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(674, '674', 'satria-agung-pratama', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(675, '675', 'seto-idi-pangestu', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(676, '676', 'syarif-andhika-pratama', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(677, '677', 'tegar-andreansyah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(678, '678', 'wahyu-nur-febrian', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(679, '679', 'wildan-faza-khozana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(680, '680', 'zakiyy-nuur-rahmaan', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(681, '681', 'adit-ardiyansyah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(682, '682', 'adrian-harry-firmansyah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(683, '683', 'agus-setiawan', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(684, '684', 'ahmad-zikri-maulana', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(685, '685', 'al-atha-mugi-prasetyo', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(686, '686', 'alwi-zainur-rohman', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(687, '687', 'ananda-oktavian', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(688, '688', 'andika-dwi-jayanto', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(689, '689', 'arda-zakaria-riski', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(690, '690', 'avian-evan-rifano', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(691, '691', 'azril-yoga-pramudita', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(692, '692', 'bagas-saputra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(693, '693', 'bekti-adi-kurniawan', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(694, '694', 'deni-faizal-sufian', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(695, '695', 'danu-andon-arwangga-hasan', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(696, '696', 'fadil-surya-pratama', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(697, '697', 'favian-junior-pratama', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(698, '698', 'fendi-ardianto', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(699, '699', 'firman-aldi-setiawan', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(700, '700', 'giyan-tri-toso', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(701, '701', 'haikal-aditia-firmansyah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(702, '702', 'hanif-dwi-susanto', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(703, '703', 'hasta-arya-gutama', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(704, '704', 'ibnu-nawawi', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(705, '705', 'ilham-zihril-ramadhan', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(706, '706', 'indra-kurniawan', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(707, '707', 'indra-lukmanul-hakim', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(708, '708', 'kurnia-tria-nugroho', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(709, '709', 'maryono-fauzi', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(710, '710', 'muhamad-al-fathul-muinudin', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(711, '711', 'muhammad-fatchun-ni\'am', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(712, '712', 'muhamad-nasikh-ulwan', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(713, '713', 'muhammad-abdul-salman-alfarizi', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(714, '714', 'muhammad-eka-fatkhul-khoir', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(715, '715', 'muiz-musahali-saputra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(716, '716', 'prastiono', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(717, '717', 'rendy-nurrochman-subeqti', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(718, '718', 'reza-dianandika', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(719, '719', 'rifki-dwi-aldiansyah', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(720, '720', 'riski-ardianto', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(721, '721', 'subhan-ahmad-nur-fatoni', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(722, '722', 'wiliam-marselo', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(723, '723', 'yongky-saputra', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(724, '724', 'zaki-ramadan', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL),
(725, '725', 'zulfa-priandita', '$2y$12$R1QtYVup6ealgBsAMHWaW.F.g8bq0PtnwUZ6obYtD8.4QV3ZlHtAW', 'siswa', 'active', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tb_absensi`
--
ALTER TABLE `tb_absensi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_dudi`
--
ALTER TABLE `tb_dudi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_guru`
--
ALTER TABLE `tb_guru`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_jurnal`
--
ALTER TABLE `tb_jurnal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_jurusan`
--
ALTER TABLE `tb_jurusan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tb_pendaftaran_id_siswa_unique` (`id_siswa`);

--
-- Indexes for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_tugas`
--
ALTER TABLE `tb_tugas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_tugas_status`
--
ALTER TABLE `tb_tugas_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tb_users_username_unique` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tb_absensi`
--
ALTER TABLE `tb_absensi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_dudi`
--
ALTER TABLE `tb_dudi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_guru`
--
ALTER TABLE `tb_guru`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `tb_jurnal`
--
ALTER TABLE `tb_jurnal`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_jurusan`
--
ALTER TABLE `tb_jurusan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=726;

--
-- AUTO_INCREMENT for table `tb_tugas`
--
ALTER TABLE `tb_tugas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_tugas_status`
--
ALTER TABLE `tb_tugas_status`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=726;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
