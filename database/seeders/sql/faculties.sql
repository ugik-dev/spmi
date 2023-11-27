-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2023 at 12:10 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app_spmi_live`
--

--
-- Dumping data for table `faculties`
--

INSERT INTO `faculties` (`id`, `name`, `abbr`, `created_at`, `updated_at`, `description`, `mission`, `image`) VALUES
(1, 'Syariah & Ekonomi Islam', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Pasca', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Tarbiyah', NULL, NULL, NULL, '<p>Fakultas Tarbiyah IAIN Syaikh Abdurrahman Siddik Babel berupaya mengintegrasi antara pendidikan akademik sebagai bentuk&nbsp;<em>transfer of knowledge</em>&nbsp;dengan kurikulum yang terstruktur dengan ilmu pengetahuan ke-Islaman yang mampu merespon isu-isu kontemporer dan lokalitas. Atas dasar ini, arah kebijakan pengembangan manajemen akademik meliputi beberapa hal sebagai berikut:</p>\r\n\r\n<p>1. Peningkatan kualitas pembelajaran;<br />\r\n2. Revitalisasi paradigma keilmuan keislaman FTAR IAIN SAS Babel;<br />\r\n3. Peningkatan jaminan mutu;<br />\r\n4. Pemberdayaan Sumber Daya Manusia;<br />\r\n5. Penguatan budaya kerja dan agenda penataan struktur formal;<br />\r\n6. Pemanfaatan layanan IT untuk pengembangan pembelajaran dan inovasi<br />\r\nprogram, menuju Pendidikan Tinggi berbasis&nbsp;<em>global network</em>;<br />\r\n7. Pemberdayaan dan fungsionalisasi perpustakaan sebagai pusat<br />\r\npembelajaran dan penelitian;<br />\r\n8. Peningkatan kerjasama sinergis dan perluasan jejaring (<em>networking</em>).</p>', '<ol>\r\n	<li>Menyelenggarakan pendidikan dan pengajaran di bidang syariah dan ekonomi islam yang unggul dan bermoral;</li>\r\n	<li>Menciptakan lulusan yang unggul, bermoral dan professional dengan memiliki pengetahuan dan ketrampilan sesuai bidang keahlian dan kemuliaan akhlak serta wawasan internasional</li>\r\n</ol>', NULL),
(4, 'Dakwah', 'dkw', NULL, NULL, '<p>Fakultas Dakwah dan Komunikasi Islam IAIN Syaikh Abdurrahman Siddik Babel berupaya mengintegrasi antara pendidikan akademik sebagai bentuk&nbsp;<em>transfer of knowledge</em>&nbsp;dengan kurikulum yang terstruktur dengan ilmu pengetahuan ke-Islaman yang mampu merespon isu-isu kontemporer dan lokalitas. Atas dasar ini, arah kebijakan pengembangan manajemen akademik meliputi beberapa hal sebagai berikut:</p>\r\n\r\n<p>1. Peningkatan kualitas pembelajaran;<br />\r\n2. Revitalisasi paradigma keilmuan keislaman FDKI IAIN SAS Babel;<br />\r\n3. Peningkatan jaminan mutu;<br />\r\n4. Pemberdayaan Sumber Daya Manusia;<br />\r\n5. Penguatan budaya kerja dan agenda penataan struktur formal;<br />\r\n6. Pemanfaatan layanan IT untuk pengembangan pembelajaran dan inovasi<br />\r\nprogram, menuju Pendidikan Tinggi berbasis&nbsp;<em>global network</em>;<br />\r\n7. Pemberdayaan dan fungsionalisasi perpustakaan sebagai pusat<br />\r\npembelajaran dan penelitian;<br />\r\n8. Peningkatan kerjasama sinergis dan perluasan jejaring (<em>networking</em>).</p>', '<ol>\r\n	<li>Menyelenggarakan pendidikan dan pengajaran di bidang syariah dan ekonomi islam yang unggul dan bermoral;</li>\r\n	<li>Menciptakan lulusan yang unggul, bermoral dan professional dengan memiliki pengetahuan dan ketrampilan sesuai bidang keahlian dan kemuliaan akhlak serta wawasan internasional</li>\r\n</ol>', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
