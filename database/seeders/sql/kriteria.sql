-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2023 at 12:07 AM
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
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id`, `name`, `code`, `level`, `kriteria_id`, `institution_id`, `degree_id`, `created_at`, `updated_at`) VALUES
(1, 'Kondisi Eksternal', 'A', 1, NULL, 1, 1, NULL, NULL),
(2, 'Profil Unit Pengelola Program Studi', 'B', 1, NULL, 1, 1, NULL, NULL),
(3, 'Kriteria', 'C', 1, NULL, 1, 1, NULL, NULL),
(4, 'Visi, Misi, Tujuan dan Strategi', '1', 2, 3, NULL, NULL, NULL, NULL),
(5, 'Indikator Kinerja Utama', '4', 3, 4, NULL, NULL, NULL, NULL),
(6, 'Tata Pamong, Tata Kelola dan Kerjasama', '2', 2, 3, NULL, NULL, NULL, NULL),
(7, 'Indikator Kinerja Utama', '4', 3, 6, NULL, NULL, NULL, NULL),
(8, 'Sistem Tata Pamong', 'a', 4, 7, NULL, NULL, NULL, NULL),
(9, 'Kepemimpinan dan Kemampuan Manajerial', 'b', 4, 7, NULL, NULL, NULL, NULL),
(10, 'Kerjasama', 'c', 4, 7, NULL, NULL, NULL, NULL),
(11, 'Indikator Kinerja Tambahan', '5', 3, 6, NULL, NULL, NULL, NULL),
(12, 'Evaluasi Capaian Kinerja', '6', 3, 6, NULL, NULL, NULL, NULL),
(13, 'Penjaminan Mutu', '7', 3, 6, NULL, NULL, NULL, NULL),
(14, 'Kepuasan Pemangku Kepentingan', '8', 3, 6, NULL, NULL, NULL, NULL),
(15, 'Mahasiswa', '3', 2, 3, NULL, NULL, NULL, NULL),
(16, 'Indikator Kinerja Utama', '4', 3, 15, NULL, NULL, NULL, NULL),
(17, 'Kualitas Input Mahasiswa', 'a', 4, 16, NULL, NULL, NULL, NULL),
(18, 'Daya Tarik Program Studi', 'b', 4, 16, NULL, NULL, NULL, NULL),
(19, 'Layanan Kemahasiswaan', 'c', 4, 16, NULL, NULL, NULL, NULL),
(20, 'Sumber Daya Manusia', '4', 2, 3, NULL, NULL, NULL, NULL),
(21, 'Indikator Kinerja Utama', '4', 3, 20, NULL, NULL, NULL, NULL),
(22, 'Profil Dosen', 'a', 4, 21, NULL, NULL, NULL, NULL),
(23, 'Kinerja Dosen', 'b', 4, 21, NULL, NULL, NULL, NULL),
(24, 'Pengembangan Dosen', 'c', 4, 21, NULL, NULL, NULL, NULL),
(25, 'Tenaga Kependidikan', 'd', 4, 21, NULL, NULL, NULL, NULL),
(26, 'Keuangan, Sarana dan Prasarana', '5', 2, 3, NULL, NULL, NULL, NULL),
(27, 'Indikator Kinerja Utama', '4', 3, 26, NULL, NULL, NULL, NULL),
(28, 'Keuangan', 'a', 4, 27, NULL, NULL, NULL, NULL),
(29, 'Sarana dan Prasarana', 'b', 4, 27, NULL, NULL, NULL, NULL),
(30, 'Pendidikan', '6', 2, 3, NULL, NULL, NULL, NULL),
(31, 'Indikator Kinerja Utama', '4', 3, 30, NULL, NULL, NULL, NULL),
(32, 'Kurikulum', 'a', 4, 31, NULL, NULL, NULL, NULL),
(33, 'Karakteristik Proses Pembelajaran', 'b', 4, 31, NULL, NULL, NULL, NULL),
(34, 'Rencana Proses Pembelajaran', 'c', 4, 31, NULL, NULL, NULL, NULL),
(35, 'Pelaksanaan Proses Pembelajaran', 'd', 4, 31, NULL, NULL, NULL, NULL),
(36, 'Monitoring dan Evaluasi Proses Pembelajaran', 'e', 4, 31, NULL, NULL, NULL, NULL),
(37, 'Penilaian Pembelajaran', 'f', 4, 31, NULL, NULL, NULL, NULL),
(38, 'Integrasi Kegiatan Penelitian dan PkM dalam Pembelajaran', 'g', 4, 31, NULL, NULL, NULL, NULL),
(39, 'Suasana Akademik', 'h', 4, 31, NULL, NULL, NULL, NULL),
(40, 'Kepuasan Mahasiswa', 'i', 4, 31, NULL, NULL, NULL, NULL),
(41, 'Penelitian', '7', 2, 3, NULL, NULL, NULL, NULL),
(42, 'Indikator Kinerja Utama', '4', 3, 41, NULL, NULL, NULL, NULL),
(43, 'Relevansi Penelitian', 'a', 4, 42, NULL, NULL, NULL, NULL),
(44, 'Penelitian Dosen dan Mahasiswa', 'b', 4, 42, NULL, NULL, NULL, NULL),
(45, 'Pengabdian kepada Masyarakat', '8', 2, 3, NULL, NULL, NULL, NULL),
(46, 'Indikator Kinerja Utama', '4', 3, 45, NULL, NULL, NULL, NULL),
(47, 'Relevansi PkM', 'a', 4, 46, NULL, NULL, NULL, NULL),
(48, 'PkM Dosen dan Mahasiswa', 'b', 4, 46, NULL, NULL, NULL, NULL),
(49, 'Luaran dan Capaian Tridharma', '9', 2, 3, NULL, NULL, NULL, NULL),
(50, 'Indikator Kinerja Utama', '4', 3, 49, NULL, NULL, NULL, NULL),
(51, 'Luaran Dharma Pendidikan', 'a', 4, 50, NULL, NULL, NULL, NULL),
(52, 'Luaran Dharma Penelitian dan PkM', 'b', 4, 50, NULL, NULL, NULL, NULL),
(53, 'Analisis dan Penetapan Program Pengembangan', 'D', 1, NULL, 1, 1, NULL, NULL),
(54, 'Analisis dan Capaian Kinerja', '1', 2, 53, NULL, NULL, NULL, NULL),
(55, 'Analisis SWOT atau Analisis Lain yang Relevan', '2', 2, 53, NULL, NULL, NULL, NULL),
(56, 'Program Pengembangan', '3', 2, 53, NULL, NULL, NULL, NULL),
(57, 'Program Keberlanjutan', '4', 2, 53, NULL, NULL, NULL, NULL),
(58, 'Kondisi Eksternal', 'A', 1, NULL, 1, 4, NULL, NULL),
(59, 'Profil Unit Pengelola Program Studi', 'B', 1, NULL, 1, 4, NULL, NULL),
(60, 'Kriteria', 'C', 1, NULL, 1, 4, NULL, NULL),
(61, 'Visi, Misi, Tujuan dan Strategi', '1', 2, 60, NULL, NULL, NULL, NULL),
(62, 'Indikator Kinerja Utama', '4', 3, 61, NULL, NULL, NULL, NULL),
(63, 'Tata Pamong, Tata Kelola dan Kerjasama', '2', 2, 60, NULL, NULL, NULL, NULL),
(64, 'Indikator Kinerja Utama', '4', 3, 63, NULL, NULL, NULL, NULL),
(65, 'Sistem Tata Pamong', 'a', 4, 64, NULL, NULL, NULL, NULL),
(66, 'Kepemimpinan dan Kemampuan Manajerial', 'b', 4, 64, NULL, NULL, NULL, NULL),
(67, 'Kerjasama', 'c', 4, 64, NULL, NULL, NULL, NULL),
(68, 'Indikator Kinerja Tambahan', '5', 3, 63, NULL, NULL, NULL, NULL),
(69, 'Evaluasi Capaian Kinerja', '6', 3, 63, NULL, NULL, NULL, NULL),
(70, 'Penjaminan Mutu', '7', 3, 63, NULL, NULL, NULL, NULL),
(71, 'Kepuasan Pemangku Kepentingan', '8', 3, 63, NULL, NULL, NULL, NULL),
(72, 'Mahasiswa', '3', 2, 60, NULL, NULL, NULL, NULL),
(73, 'Indikator Kinerja Utama', '4', 3, 72, NULL, NULL, NULL, NULL),
(74, 'Kualitas Input Mahasiswa', 'a', 4, 73, NULL, NULL, NULL, NULL),
(75, 'Daya Tarik Program Studi', 'b', 4, 73, NULL, NULL, NULL, NULL),
(76, 'Layanan Kemahasiswaan', 'c', 4, 73, NULL, NULL, NULL, NULL),
(77, 'Sumber Daya Manusia', '4', 2, 60, NULL, NULL, NULL, NULL),
(78, 'Indikator Kinerja Utama', '4', 3, 77, NULL, NULL, NULL, NULL),
(79, 'Profil Dosen', 'a', 4, 78, NULL, NULL, NULL, NULL),
(80, 'Kinerja Dosen', 'b', 4, 78, NULL, NULL, NULL, NULL),
(81, 'Pengembangan Dosen', 'c', 4, 78, NULL, NULL, NULL, NULL),
(82, 'Tenaga Kependidikan', 'd', 4, 78, NULL, NULL, NULL, NULL),
(83, 'Keuangan, Sarana dan Prasarana', '5', 2, 60, NULL, NULL, NULL, NULL),
(84, 'Indikator Kinerja Utama', '4', 3, 83, NULL, NULL, NULL, NULL),
(85, 'Keuangan', 'a', 4, 84, NULL, NULL, NULL, NULL),
(86, 'Sarana dan Prasarana', 'b', 4, 84, NULL, NULL, NULL, NULL),
(87, 'Pendidikan', '6', 2, 60, NULL, NULL, NULL, NULL),
(88, 'Indikator Kinerja Utama', '4', 3, 87, NULL, NULL, NULL, NULL),
(89, 'Kurikulum', 'a', 4, 88, NULL, NULL, NULL, NULL),
(90, 'Karakteristik Proses Pembelajaran', 'b', 4, 88, NULL, NULL, NULL, NULL),
(91, 'Rencana Proses Pembelajaran', 'c', 4, 88, NULL, NULL, NULL, NULL),
(92, 'Pelaksanaan Proses Pembelajaran', 'd', 4, 88, NULL, NULL, NULL, NULL),
(93, 'Monitoring dan Evaluasi Proses Pembelajaran', 'e', 4, 88, NULL, NULL, NULL, NULL),
(94, 'Penilaian Pembelajaran', 'f', 4, 88, NULL, NULL, NULL, NULL),
(95, 'Integrasi Kegiatan Penelitian dan PkM dalam Pembelajaran', 'g', 4, 88, NULL, NULL, NULL, NULL),
(96, 'Suasana Akademik', 'h', 4, 88, NULL, NULL, NULL, NULL),
(97, 'Kepuasan Mahasiswa', 'i', 4, 88, NULL, NULL, NULL, NULL),
(98, 'Penelitian', '7', 2, 60, NULL, NULL, NULL, NULL),
(99, 'Indikator Kinerja Utama', '4', 3, 98, NULL, NULL, NULL, NULL),
(100, 'Relevansi Penelitian', 'a', 4, 99, NULL, NULL, NULL, NULL),
(101, 'Penelitian Dosen dan Mahasiswa', 'b', 4, 99, NULL, NULL, NULL, NULL),
(102, 'Pengabdian Kepada Masyarakat', '8', 2, 60, NULL, NULL, NULL, NULL),
(103, 'Indikator Kinerja Utama', '4', 3, 102, NULL, NULL, NULL, NULL),
(104, 'Relevansi PkM', 'a', 4, 103, NULL, NULL, NULL, NULL),
(105, 'Luaran dan Capaian Tridharma', '9', 2, 60, NULL, NULL, NULL, NULL),
(106, 'Indikator Kinerja Utama', '4', 3, 105, NULL, NULL, NULL, NULL),
(107, 'Luaran Dharma Pendidikan', 'a', 4, 106, NULL, NULL, NULL, NULL),
(108, 'Luaran Dharma Penelitian dan PkM', 'b', 4, 106, NULL, NULL, NULL, NULL),
(109, 'Analisis dan Penetapan Program Pengembangan', 'D', 1, NULL, 1, 4, NULL, NULL),
(110, 'Analisis dan Capaian Kinerja', '1', 2, 109, NULL, NULL, NULL, NULL),
(111, 'Analisis SWOT atau Analisis Lain yang Relevan', '2', 2, 109, NULL, NULL, NULL, NULL),
(112, 'Program Pengembangan', '3', 2, 109, NULL, NULL, NULL, NULL),
(113, 'Program Keberlanjutan', '4', 2, 109, NULL, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
