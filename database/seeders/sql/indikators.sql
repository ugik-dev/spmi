-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2023 at 12:08 AM
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
-- Dumping data for table `indikators`
--

INSERT INTO `indikators` (`id`, `dec`, `bobot`, `l1_id`, `l2_id`, `l3_id`, `l4_id`, `created_at`, `updated_at`) VALUES
(3, 'Konsistensi dengan hasil analisis SWOT dan/atau analisis lain serta rencana pengembangan ke depan.', '3.00', 1, NULL, NULL, NULL, NULL, NULL),
(4, 'Keserbacakupan informasi dalam profil dan konsistensi antara profil dengan data dan informasi yang disampaikan pada masing-masing kriteria, serta menunjukkan iklim yang kondusif untuk pengembangan dan reputasi sebagai rujukan di bidang keilmuannya.', '0.98', 2, NULL, NULL, NULL, NULL, NULL),
(5, 'Kesesuaian Visi, Misi, Tujuan dan Strategi (VMTS) Unit Pengelola Program Studi (UPPS) terhadap VMTS Perguruan Tinggi (PT) dan visi keilmuan Program Studi (PS) yang dikelolanya.', '0.50', 3, 4, 5, NULL, NULL, NULL),
(6, 'Mekanisme dan keterlibatan pemangku kepentingan dalam penyusunan VMTS UPPS.', '0.00', 3, 4, 5, NULL, NULL, NULL),
(7, 'Strategi pencapaian tujuan disusun berdasarkan analisis yang sistematis, serta pada pelaksanaannya dilakukan pemantauan dan evaluasi yang ditindaklanjuti.', '0.00', 3, 4, 5, NULL, NULL, NULL),
(8, 'A. Kelengkapan struktur organisasi dan keefektifan penyelenggaraan organisasi.', '0.00', 3, 6, 7, 8, NULL, NULL),
(9, 'B. Perwujudan good governance dan pemenuhan lima pilar sistem tata pamong, yang mencakup: \r\n1) Kredibel, \r\n2) Transparan, \r\n3) Akuntabel, \r\n4) Bertanggung jawab, \r\n5) Adil.', '0.00', 3, 6, 7, 8, NULL, NULL),
(10, 'A. Komitmen pimpinan UPPS.', '0.00', 3, 6, 7, 9, NULL, NULL),
(11, 'B. Kapabilitas pimpinan UPPS, mencakup aspek: 1) perencanaan, 2) pengorganisasian, 3) penempatan personel, 4) pelaksanaan, 5) pengendalian dan pengawasan, dan 6) pelaporan yang menjadi dasar tindak lanjut.', '0.00', 3, 6, 7, 9, NULL, NULL),
(12, 'Mutu, manfaat, kepuasan dan keberlanjutan kerjasama pendidikan, penelitian dan PkM yang relevan dengan program studi. UPPS memiliki bukti yang sahih terkait kerjasama yang ada telah memenuhi 3 aspek berikut: 1) memberikan manfaat bagi program studi dalam pemenuhan proses pembelajaran, penelitian, PkM. 2) memberikan peningkatan kinerja tridharma dan fasilitas pendukung program studi. 3) memberikan kepuasan kepada mitra industri dan mitra kerjasama lainnya, serta menjamin keberlanjutan kerjasama dan hasilnya.', '0.00', 3, 6, 7, 10, NULL, NULL),
(13, 'A. Kerjasama pendidikan, penelitian, dan PkM yang relevan dengan program studi dan dikelola oleh UPPS dalam 3 tahun terakhir.', '0.00', 3, 6, 7, 10, NULL, NULL),
(14, 'B. Kerjasama tingkat internasional, nasional, wilayah/lokal yang relevan dengan program studi dan dikelola oleh UPPS dalam 3 tahun terakhir.', '0.00', 3, 6, 7, 10, NULL, NULL),
(15, 'Pelampauan SN-DIKTI yang ditetapkan dengan indikator kinerja tambahan yang berlaku di UPPS berdasarkan standar pendidikan tinggi yang ditetapkan perguruan tinggi pada tiap kriteria.', '0.00', 3, 6, 11, NULL, NULL, NULL),
(16, 'Analisis keberhasilan dan/atau ketidakberhasilan pencapaian kinerja UPPS yang telah ditetapkan di tiap kriteria memenuhi 2 aspek sebagai berikut: 1) capaian kinerja diukur dengan metoda yang tepat, dan hasilnya dianalisis serta dievaluasi, dan 2) analisis terhadap capaian kinerja mencakup identifikasi akar masalah, faktor pendukung keberhasilan dan faktor penghambat ketercapaian standard, dan deskripsi singkat tindak lanjut yang akan dilakukan.', '0.00', 3, 6, 12, NULL, NULL, NULL),
(17, 'Keterlaksanaan Sistem Penjaminan Mutu Internal (akademik dan nonakademik) yang dibuktikan dengan keberadaan 5 aspek: 1) dokumen legal pembentukan unsur pelaksana penjaminan mutu. 2) ketersediaan dokumen mutu: kebijakan SPMI, manual SPMI, standar SPMI, dan formulir SPMI. 3) terlaksananya siklus penjaminan mutu (siklus PPEPP) 4) bukti sahih efektivitas pelaksanaan penjaminan mutu. 5) memiliki external benchmarking dalam peningkatan mutu.', '0.00', 3, 6, 13, NULL, NULL, NULL),
(18, 'Pengukuran kepuasan para pemangku kepentingan (mahasiswa, dosen, tenaga kependidikan, lulusan, pengguna, mitra industri, dan mitra lainnya) terhadap layanan manajemen, yang memenuhi aspek aspek berikut: 1) menggunakan instrumen kepuasan yang sahih, andal, mudah digunakan, 2) dilaksanakan secara berkala, serta datanya terekam secara komprehensif, 3) dianalisis dengan metode yang tepat serta bermanfaat untuk pengambilan keputusan, 4) tingkat kepuasan dan umpan balik ditindaklanjuti untuk perbaikan dan peningkatan mutu luaran secara berkala dan tersistem. 5) dilakukan review terhadap pelaksanaan pengukuran kepuasan dosen dan mahasiswa, serta 6) hasilnya dipublikasikan dan mudah diakses oleh dosen dan mahasiswa.', '0.00', 3, 6, 14, NULL, NULL, NULL),
(19, 'Metoda rekrutmen dan keketatan seleksi.', '0.00', 3, 15, 16, 17, NULL, NULL),
(20, 'A. Peningkatan animo calon mahasiswa.', '0.00', 3, 15, 16, 18, NULL, NULL),
(21, 'B. Mahasiswa asing.', '0.00', 3, 15, 16, 18, NULL, NULL),
(22, 'A. Ketersediaan layanan kemahasiswaan di bidang: 1) penalaran, minat dan bakat, 2) kesejahteraan (bimbingan dan konseling, layanan beasiswa, dan layanan kesehatan), dan 3) bimbingan karir dan kewirausahaan.', '0.00', 3, 15, 16, 19, NULL, NULL),
(23, 'B. Akses dan mutu layanan kemahasiswaan.', '0.00', 3, 15, 16, 19, NULL, NULL),
(24, 'Kecukupan jumlah DTPS.', '0.00', 3, 20, 21, 22, NULL, NULL),
(25, 'Kualifikasi akademik DTPS.', '0.00', 3, 20, 21, 22, NULL, NULL),
(26, 'Jabatan akademik DTPS.', '0.00', 3, 20, 21, 22, NULL, NULL),
(27, 'Rasio jumlah mahasiswa program studi terhadap jumlah DTPS.', '0.00', 3, 20, 21, 22, NULL, NULL),
(28, 'Penugasan DTPS sebagai pembimbing utama tugas akhir mahasiswa.', '0.00', 3, 20, 21, 22, NULL, NULL),
(29, 'Ekuivalensi Waktu Mengajar Penuh DTPS.', '0.00', 3, 20, 21, 22, NULL, NULL),
(30, 'Dosen tidak tetap.', '0.00', 3, 20, 21, 22, NULL, NULL),
(31, 'Pengakuan/rekognisi atas kepakaran/prestasi/kinerja DTPS.', '0.00', 3, 20, 21, 23, NULL, NULL),
(32, 'Kegiatan penelitian DTPS yang relevan dengan bidang program studi dalam 3 tahun terakhir.', '0.00', 3, 20, 21, 23, NULL, NULL),
(33, 'Kegiatan PkM DTPS yang relevan dengan bidang program studi dalam 3 tahun terakhir.', '0.00', 3, 20, 21, 23, NULL, NULL),
(34, 'Publikasi ilmiah dengan tema yang relevan dengan bidang program studi yang dihasilkan DTPS dalam 3 tahun terakhir.', '0.00', 3, 20, 21, 23, NULL, NULL),
(35, 'Artikel karya ilmiah DTPS yang disitasi dalam 3 tahun terakhir.', '0.00', 3, 20, 21, 23, NULL, NULL),
(36, 'Luaran penelitian dan PkM yang dihasilkan DTPS dalam 3 tahun terakhir.', '0.00', 3, 20, 21, 23, NULL, NULL),
(37, 'Upaya pengembangan dosen.', '0.00', 3, 20, 21, 24, NULL, NULL),
(38, 'A. Kualifikasi dan kecukupan tenaga kependidikan berdasarkan jenis pekerjaannya (administrasi, pustakawan, teknisi, dll.)', '0.00', 3, 20, 21, 25, NULL, NULL),
(39, 'B. Kualifikasi dan kecukupan laboran untuk mendukung proses pembelajaran sesuai dengan kebutuhan program studi.', '0.00', 3, 20, 21, 25, NULL, NULL),
(40, 'Biaya operasional pendidikan.', '0.00', 3, 26, 27, 28, NULL, NULL),
(41, 'Dana penelitian DTPS.', '0.00', 3, 26, 27, 28, NULL, NULL),
(42, 'Dana pengabdian kepada masyarakat DTPS.', '0.00', 3, 26, 27, 28, NULL, NULL),
(43, 'Realisasi investasi (SDM, sarana dan prasarana) yang mendukung penyelenggaraan tridharma.', '0.00', 3, 26, 27, 28, NULL, NULL),
(44, 'Kecukupan dana untuk menjamin pencapaian capaian pembelajaran.', '0.00', 3, 26, 27, 28, NULL, NULL),
(45, 'Kecukupan, aksesibilitas dan mutu sarana dan prasarana untuk menjamin pencapaian capaian pembelajaran dan meningkatkan suasana akademik.', '0.00', 3, 26, 27, 29, NULL, NULL),
(46, 'A. Keterlibatan pemangku kepentingan dalam proses evaluasi dan pemutakhiran kurikulum.', '0.00', 3, 30, 31, 32, NULL, NULL),
(47, 'B. Kesesuaian capaian pembelajaran dengan profil lulusan dan jenjang KKNI/SKKNI.', '0.00', 3, 30, 31, 32, NULL, NULL),
(48, 'C. Ketepatan struktur kurikulum dalam pembentukan capaian pembelajaran.', '0.00', 3, 30, 31, 32, NULL, NULL),
(49, 'Pemenuhan karakteristik proses pembelajaran, yang terdiri atas sifat: 1) interaktif, 2) holistik, 3) integratif, 4) saintifik, 5) kontekstual, 6) tematik, 7) efektif, 8) kolaboratif, dan 9) berpusat pada mahasiswa.', '0.00', 3, 30, 31, 33, NULL, NULL),
(50, 'A. Ketersediaan dan kelengkapan dokumen rencana pembelajaran semester (RPS).', '0.00', 3, 30, 31, 34, NULL, NULL),
(51, 'B. Kedalaman dan keluasan RPS sesuai dengan capaian pembelajaran lulusan.', '0.00', 3, 30, 31, 34, NULL, NULL),
(52, 'A. Bentuk interaksi antara dosen, mahasiswa dan sumber belajar.', '0.00', 3, 30, 31, 35, NULL, NULL),
(53, 'B. Pemantauan kesesuaian proses terhadap rencana pembelajaran.', '0.00', 3, 30, 31, 35, NULL, NULL),
(54, 'C. Proses pembelajaran yang terkait dengan penelitian harus mengacu SN Dikti Penelitian: 1) hasil penelitian: harus memenuhi pengembangan IPTEKS, meningkatkan kesejahteraan masyarakat, dan daya saing bangsa. 2) isi penelitian: memenuhi kedalaman dan keluasan materi penelitian sesuai capaian pembelajaran. 3) proses penelitian: mencakup perencanaan, pelaksanaan, dan pelaporan. 4) penilaian penelitian memenuhi unsur edukatif, obyektif, akuntabel, dan transparan.', '0.00', 3, 30, 31, 35, NULL, NULL),
(55, 'D. Proses pembelajaran yang terkait dengan PkM harus mengacu SN Dikti PkM: 1) hasil PkM: harus memenuhi pengembangan IPTEKS, meningkatkan kesejahteraan masyarakat, dan daya saing bangsa. 2) isi PkM: memenuhi kedalaman dan keluasan materi PkM sesuai capaian pembelajaran. 3) proses PkM: mencakup perencanaan, pelaksanaan, dan pelaporan. 4) penilaian PkM memenuhi unsur edukatif, obyektif, akuntabel, dan transparan.', '0.00', 3, 30, 31, 35, NULL, NULL),
(56, 'E. Kesesuaian metode pembelajaran dengan capaian pembelajaran. Contoh: RBE (Research Based Education), IBE (Industry Based Education), teaching factory/teaching industry, dll.', '0.00', 3, 30, 31, 35, NULL, NULL),
(57, 'Pembelajaran yang dilaksanakan dalam bentuk praktikum, praktik studio, praktik bengkel, atau praktik lapangan.', '0.00', 3, 30, 31, 35, NULL, NULL),
(58, 'Monitoring dan evaluasi pelaksanaan proses pembelajaran mencakup karakteristik, perencanaan, pelaksanaan, proses pembelajaran dan beban belajar mahasiswa untuk memperoleh capaian pembelajaran lulusan.', '0.00', 3, 30, 31, 36, NULL, NULL),
(59, 'A. Mutu pelaksanaan penilaian pembelajaran (proses dan hasil belajar mahasiswa) untuk mengukur ketercapaian capaian pembelajaran berdasarkan prinsip penilaian yang mencakup: 1) edukatif, 2) otentik, 3) objektif, 4) akuntabel, dan 5) transparan, yang dilakukan secara terintegrasi.', '0.00', 3, 30, 31, 37, NULL, NULL),
(60, 'B. Pelaksanaan penilaian terdiri atas teknik dan instrumen penilaian. Teknik penilaian terdiri dari: 1) observasi, 2) partisipasi, 3) unjuk kerja, 4) test tertulis, 5) test lisan, dan 6) angket. Instrumen penilaian terdiri dari: 1) penilaian proses dalam bentuk rubrik, dan/ atau; 2) penilaian hasil dalam bentuk portofolio, atau 3) karya disain.', '0.00', 3, 30, 31, 37, NULL, NULL),
(61, 'C. Pelaksanaan penilaian memuat unsur unsur sebagai berikut: 1) mempunyai kontrak rencana penilaian, 2) melaksanakan penilaian sesuai kontrak atau kesepakatan, 3) memberikan umpan balik dan memberi kesempatan untuk mempertanyakan hasil kepada mahasiswa, 4) mempunyai dokumentasi penilaian proses dan hasil belajar mahasiswa, 5) mempunyai prosedur yang mencakup tahap perencanaan, kegiatan pemberian tugas atau soal, observasi kinerja, pengembalian hasil observasi, dan pemberian nilai akhir, 6) pelaporan penilaian berupa kualifikasi keberhasilan mahasiswa dalam menempuh suatu mata kuliah dalam bentuk huruf dan angka, 7) mempunyai bukti bukti rencana dan telah melakukan proses perbaikan berdasar hasil monev penilaian.', '0.00', 3, 30, 31, 37, NULL, NULL),
(62, 'Integrasi kegiatan penelitian dan PkM dalam pembelajaran oleh DTPS dalam 3 tahun terakhir.', '0.00', 3, 30, 31, 38, NULL, NULL),
(63, 'Keterlaksanaan dan keberkalaan program dan kegiatan diluar kegiatan pembelajaran terstruktur untuk meningkatkan suasana akademik. Contoh: kegiatan himpunan mahasiswa, kuliah umum/stadium generale, seminar ilmiah, bedah buku.', '0.00', 3, 30, 31, 39, NULL, NULL),
(64, 'A. Tingkat kepuasan mahasiswa terhadap proses pendidikan.', '0.00', 3, 30, 31, 40, NULL, NULL),
(65, 'B. Analisis dan tindak lanjut dari hasil pengukuran kepuasan mahasiswa.', '0.00', 3, 30, 31, 40, NULL, NULL),
(66, 'Relevansi penelitian pada UPPS mencakup unsur-unsur sebagai berikut: 1) memiliki peta jalan yang memayungi tema penelitian dosen dan mahasiswa, 2) dosen dan mahasiswa melaksanakan penelitian sesuai dengan agenda penelitian dosen yang merujuk kepada peta jalan penelitian. 3) melakukan evaluasi kesesuaian penelitian dosen dan mahasiswa dengan peta jalan, dan 4) menggunakan hasil evaluasi untuk perbaikan relevansi penelitian dan pengembangan keilmuan program studi.', '0.00', 3, 41, 42, 43, NULL, NULL),
(67, 'Penelitian DTPS yang dalam pelaksanaannya melibatkan mahasiswa program studi dalam 3 tahun terakhir.', '0.00', 3, 41, 42, 44, NULL, NULL),
(68, 'Relevansi PkM pada UPPS mencakup unsur unsur sebagai berikut: 1) memiliki peta jalan yang memayungi tema PkM dosen dan mahasiswa serta hilirisasi/penerapan keilmuan program studi, 2) dosen dan mahasiswa melaksanakan PkM sesuai dengan peta jalan PkM. 3) melakukan evaluasi kesesuaian PkM dosen dan mahasiswa dengan peta jalan, dan 4) menggunakan hasil evaluasi untuk perbaikan relevansi PkM dan pengembangan keilmuan program studi.', '0.00', 3, 45, 46, 47, NULL, NULL),
(69, 'PkM DTPS yang dalam pelaksanaannya melibatkan mahasiswa program studi dalam 3 tahun terakhir.', '0.00', 3, 45, 46, 48, NULL, NULL),
(70, 'Analisis pemenuhan capaian pembelajaran lulusan (CPL) yang diukur dengan metoda yang sahih dan relevan, mencakup aspek: 1) keserbacakupan, 2) kedalaman, dan 3) kebermanfaatan analisis yang ditunjukkan dengan peningkatan CPL dari waktu ke waktu dalam 3 tahun terakhir.', '0.00', 3, 49, 50, 51, NULL, NULL),
(71, 'IPK lulusan. RIPK = Rata-rata IPK lulusan dalam 3 tahun terakhir.', '0.00', 3, 49, 50, 51, NULL, NULL),
(72, 'Prestasi mahasiswa di bidang akademik dalam 3 tahun terakhir.', '0.00', 3, 49, 50, 51, NULL, NULL),
(73, 'Prestasi mahasiswa di bidang nonakademik dalam 3 tahun terakhir.', '0.00', 3, 49, 50, 51, NULL, NULL),
(74, 'Masa studi. MS = Rata-rata masa studi lulusan (tahun).', '0.00', 3, 49, 50, 51, NULL, NULL),
(75, 'Kelulusan tepat waktu. PTW = Persentase kelulusan tepat waktu.', '0.00', 3, 49, 50, 51, NULL, NULL),
(76, 'Keberhasilan studi. PPS = Persentase keberhasilan studi.', '0.00', 3, 49, 50, 51, NULL, NULL),
(77, 'Pelaksanaan tracer study yang mencakup 5 aspek sebagai berikut: 1) pelaksanaan tracer study terkoordinasi di tingkat PT, 2) kegiatan tracer study dilakukan secara reguler setiap tahun dan terdokumentasi, 3) isi kuesioner mencakup seluruh pertanyaan inti tracer study DIKTI. 4) ditargetkan pada seluruh populasi (lulusan TS-4 s.d. TS-2), 5) hasilnya disosialisasikan dan digunakan untuk pengembangan kurikulum dan pembelajaran.', '0.00', 3, 49, 50, 51, NULL, NULL),
(78, 'Waktu tunggu. WT = waktu tunggu lulusan untuk mendapatkan pekerjaan pertama dalam 3 tahun, mulai TS-4 s.d. TS-2.', '0.00', 3, 49, 50, 51, NULL, NULL),
(79, 'Kesesuaian bidang kerja. PBS = Kesesuaian bidang kerja lulusan saat mendapatkan pekerjaan pertama dalam 3 tahun, mulai TS-4 s.d. TS-2.', '0.00', 3, 49, 50, 51, NULL, NULL),
(80, 'Tingkat dan ukuran tempat kerja lulusan.', '0.00', 3, 49, 50, 51, NULL, NULL),
(81, 'Tingkat kepuasan pengguna lulusan.', '0.00', 3, 49, 50, 51, NULL, NULL),
(82, 'Publikasi ilmiah mahasiswa, yang dihasilkan secara mandiri atau bersama DTPS, dengan judul yang relevan dengan bidang program studi dalam 3 tahun terakhir.', '0.00', 3, 49, 50, 52, NULL, NULL),
(83, 'Luaran penelitian dan PkM yang dihasilkan mahasiswa, baik secara mandiri atau bersama DTPS dalam 3 tahun terakhir.', '0.00', 3, 49, 50, 52, NULL, NULL),
(84, 'Keserbacakupan (kelengkapan, keluasan, dan kedalaman), ketepatan, ketajaman, dan kesesuaian analisis capaian kinerja serta konsistensi dengan setiap kriteria.', '0.00', 53, 54, NULL, NULL, NULL, NULL),
(85, 'Ketepatan analisis SWOT atau analisis yang relevan di dalam mengembangkan strategi.', '0.00', 53, 55, NULL, NULL, NULL, NULL),
(86, 'Ketepatan di dalam menetapkan prioritas program pengembangan.', '0.00', 53, 56, NULL, NULL, NULL, NULL),
(87, 'UPPS memiliki kebijakan, ketersediaan sumberdaya, kemampuan melaksanakan, dan kerealistikan program.', '0.00', 53, 57, NULL, NULL, NULL, NULL),
(88, 'Konsistensi dengan hasil analisis SWOT dan/atau analisis lain serta rencana pengembangan ke depan.', '0.00', 58, NULL, NULL, NULL, NULL, NULL),
(89, 'Keserbacakupan informasi dalam profil dan konsistensi antara profil dengan data dan informasi yang disampaikan pada masing-masing kriteria, serta menunjukkan iklim yang kondusif untuk pengembangan dan reputasi sebagai rujukan di bidang keilmuannya.', '0.00', 59, NULL, NULL, NULL, NULL, NULL),
(90, 'Kesesuaian Visi, Misi, Tujuan dan Strategi (VMTS) Unit Pengelola Program Studi (UPPS) terhadap VMTS Perguruan Tinggi (PT) dan visi keilmuan Program Studi (PS) yang dikelolanya.', '0.00', 60, 61, 62, NULL, NULL, NULL),
(91, 'Mekanisme dan keterlibatan pemangku kepentingan dalam penyusunan VMTS UPPS.', '0.00', 60, 61, 62, NULL, NULL, NULL),
(92, 'Strategi pencapaian tujuan disusun berdasarkan analisis yang sistematis, serta pada pelaksanaannya dilakukan pemantauan dan evaluasi yang ditindaklanjuti.', '0.00', 60, 61, 62, NULL, NULL, NULL),
(93, 'A. Kelengkapan struktur organisasi dan keefektifan penyelenggaraan organisasi.', '0.00', 60, 63, 64, 65, NULL, NULL),
(94, 'B. Perwujudan good governance dan pemenuhan lima pilar sistem tata pamong, yang mencakup: 1) Kredibel, 2) Transparan, 3) Akuntabel, 4) Bertanggung jawab, 5) Adil.', '0.00', 60, 63, 64, 65, NULL, NULL),
(95, 'A. Komitmen pimpinan UPPS.', '0.00', 60, 63, 64, 66, NULL, NULL),
(96, 'B. Kapabilitas pimpinan UPPS, mencakup aspek: 1) perencanaan, 2) pengorganisasian, 3) penempatan personel, 4) pelaksanaan, 5) pengendalian dan pengawasan, dan 6) pelaporan yang menjadi dasar tindak lanjut.', '0.00', 60, 63, 64, 66, NULL, NULL),
(97, 'Mutu, manfaat, kepuasan dan keberlanjutan kerjasama pendidikan, penelitian dan PkM yang relevan dengan program studi. UPPS memiliki bukti yang sahih terkait kerjasama yang ada telah memenuhi 3 aspek berikut: 1) memberikan manfaat bagi program studi dalam pemenuhan proses pembelajaran, penelitian, PkM. 2) memberikan peningkatan kinerja tridharma dan fasilitas pendukung program studi. 3) memberikan kepuasan kepada mitra industri dan mitra kerjasama lainnya, serta menjamin keberlanjutan kerjasama dan hasilnya.', '0.00', 60, 63, 64, 67, NULL, NULL),
(98, 'A. Kerjasama pendidikan, penelitian, dan PkM yang relevan dengan program studi dan dikelola oleh UPPS dalam 3 tahun terakhir.', '0.00', 60, 63, 64, 67, NULL, NULL),
(99, 'B. Kerjasama tingkat internasional, nasional, wilayah/lokal yang relevan dengan program studi dan dikelola oleh UPPS dalam 3 tahun terakhir.', '0.00', 60, 63, 64, 67, NULL, NULL),
(100, 'Pelampauan SN-DIKTI yang ditetapkan dengan indikator kinerja tambahan yang berlaku di UPPS berdasarkan standar pendidikan tinggi yang ditetapkan perguruan tinggi pada tiap kriteria.', '0.00', 60, 63, 68, NULL, NULL, NULL),
(101, 'Analisis keberhasilan dan/atau ketidakberhasilan pencapaian kinerja UPPS yang telah ditetapkan di tiap kriteria memenuhi 2 aspek sebagai berikut: 1) capaian kinerja diukur dengan metoda yang tepat, dan hasilnya dianalisis serta dievaluasi, dan 2) analisis terhadap capaian kinerja mencakup identifikasi akar masalah, faktor pendukung keberhasilan dan faktor penghambat ketercapaian standard, dan deskripsi singkat tindak lanjut yang akan dilakukan.', '0.00', 60, 63, 69, NULL, NULL, NULL),
(102, 'Keterlaksanaan Sistem Penjaminan Mutu Internal (akademik dan nonakademik) yang dibuktikan dengan keberadaan 5 aspek: 1) dokumen legal pembentukan unsur pelaksana penjaminan mutu. 2) ketersediaan dokumen mutu: kebijakan SPMI, manual SPMI, standar SPMI, dan formulir SPMI. 3) terlaksananya siklus penjaminan mutu (siklus PPEPP) 4) bukti sahih efektivitas pelaksanaan penjaminan mutu. 5) memiliki external benchmarking dalam peningkatan mutu.', '0.00', 60, 63, 70, NULL, NULL, NULL),
(103, 'Pengukuran kepuasan para pemangku kepentingan (mahasiswa, dosen, tenaga kependidikan, lulusan, pengguna, mitra industri, dan mitra lainnya) terhadap layanan manajemen, yang memenuhi aspekaspek berikut: \r\n1) menggunakan instrumen kepuasan yang sahih, andal, mudah digunakan, \r\n2) dilaksanakan secara berkala, serta datanya terekam secara komprehensif, \r\n3) dianalisis dengan metode yang tepat serta bermanfaat untuk pengambilan keputusan, \r\n4) tingkat kepuasan dan umpan balik ditindaklanjuti untuk perbaikan dan peningkatan mutu luaran secara berkala dan tersistem. \r\n5) dilakukan review terhadap pelaksanaan pengukuran kepuasan dosen dan mahasiswa, serta 6) hasilnya dipublikasikan dan mudah diakses oleh dosen dan mahasiswa.', '0.00', 60, 63, 71, NULL, NULL, NULL),
(104, 'A. Metoda rekrutmen dan sistem seleksi.', '0.00', 60, 72, 73, 74, NULL, NULL),
(105, 'B. Kriteria penerimaan mahasiswa.', '0.00', 60, 72, 73, 74, NULL, NULL),
(106, 'C. Proses seleksi.', '0.00', 60, 72, 73, 74, NULL, NULL),
(107, 'A. Peningkatan animo calon mahasiswa.', '0.00', 60, 72, 73, 75, NULL, NULL),
(108, 'B. Mahasiswa asing', '0.00', 60, 72, 73, 75, NULL, NULL),
(109, 'A. Ketersediaan layanan kemahasiswaan dalam bentuk: 1) bimbingan dan konseling, 2) layanan beasiswa, dan 3) layanan kesehatan.', '0.00', 60, 72, 73, 76, NULL, NULL),
(110, 'B. Akses dan mutu layanan kemahasiswaan.', '0.00', 60, 72, 73, 76, NULL, NULL),
(111, 'Kecukupan jumlah DTPS.', '0.00', 60, 77, 78, 79, NULL, NULL),
(112, 'Jabatan akademik DTPS.', '0.00', 60, 77, 78, 79, NULL, NULL),
(113, 'Penugasan DTPS sebagai pembimbing utama tugas akhir mahasiswa.', '0.00', 60, 77, 78, 79, NULL, NULL),
(114, 'Ekuivalensi Waktu Mengajar Penuh DTPS.', '0.00', 60, 77, 78, 79, NULL, NULL),
(115, 'Dosen tidak tetap.', '0.00', 60, 77, 78, 79, NULL, NULL),
(116, 'Pengakuan/rekognisi atas kepakaran/prestasi/kiner ja DTPS.', '0.00', 60, 77, 78, 80, NULL, NULL),
(117, 'Kegiatan penelitian DTPS yang relevan dengan bidang program studi dalam 3 tahun terakhir.', '0.00', 60, 77, 78, 80, NULL, NULL),
(118, 'Kegiatan PkM DTPS yang relevan dengan bidang program studi dalam 3 tahun terakhir.', '0.00', 60, 77, 78, 80, NULL, NULL),
(119, 'Publikasi ilmiah dengan tema yang relevan dengan bidang program studi yang dihasilkan DTPS dalam 3 tahun terakhir.', '0.00', 60, 77, 78, 80, NULL, NULL),
(120, 'Artikel karya ilmiah DTPS yang disitasi dalam 3 tahun terakhir.', '0.00', 60, 77, 78, 80, NULL, NULL),
(121, 'Luaran penelitian dan PkM yang dihasilkan DTPS dalam 3 tahun terakhir.', '0.00', 60, 77, 78, 80, NULL, NULL),
(122, 'Upaya pengembangan dosen.', '0.00', 60, 77, 78, 81, NULL, NULL),
(123, 'A. Kualifikasi dan kecukupan tenaga kependidikan berdasarkan jenis pekerjaannya (administrasi, pustakawan, teknisi, dll.)', '0.00', 60, 77, 78, 82, NULL, NULL),
(124, 'B. Kualifikasi dan kecukupan laboran untuk mendukung proses pembelajaran sesuai dengan kebutuhan program studi.', '0.00', 60, 77, 78, 82, NULL, NULL),
(125, 'Biaya operasional pendidikan.', '0.00', 60, 83, 84, 85, NULL, NULL),
(126, 'Dana penelitian DTPS.', '0.00', 60, 83, 84, 85, NULL, NULL),
(127, 'Dana pengabdian kepada masyarakat DTPS.', '0.00', 60, 83, 84, 85, NULL, NULL),
(128, 'Realisasi investasi (SDM, sarana dan prasarana) yang mendukung penyelenggaraan tridharma.', '0.00', 60, 83, 84, 85, NULL, NULL),
(129, 'Kecukupan dana untuk menjamin pencapaian capaian pembelajaran.', '0.00', 60, 83, 84, 85, NULL, NULL),
(130, 'Kecukupan, aksesibilitas dan mutu sarana dan prasarana untuk menjamin pencapaian capaian pembelajaran dan meningkatkan suasana akademik.', '0.00', 60, 83, 84, 86, NULL, NULL),
(131, 'A. Keterlibatan pemangku kepentingan dalam proses evaluasi dan pemutakhiran kurikulum.', '0.00', 60, 87, 88, 89, NULL, NULL),
(132, 'B. Kesesuaian capaian pembelajaran dengan profil lulusan dan jenjang KKNI/SKKNI.', '0.00', 60, 87, 88, 89, NULL, NULL),
(133, 'C. Ketepatan struktur kurikulum dalam pembentukan capaian pembelajaran.', '0.00', 60, 87, 88, 89, NULL, NULL),
(134, 'Pemenuhan karakteristik proses pembelajaran, yang terdiri atas sifat: 1) interaktif, 2) holistik, 3) integratif, 4) saintifik, 5) kontekstual, 6) tematik, 7) efektif, 8) kolaboratif, dan 9) berpusat pada mahasiswa.', '0.00', 60, 87, 88, 90, NULL, NULL),
(135, 'A. Ketersediaan dan kelengkapan dokumen rencana pembelajaran semester (RPS)', '0.00', 60, 87, 88, 91, NULL, NULL),
(136, 'B. Kedalaman dan keluasan RPS sesuai dengan capaian pembelajaran lulusan.', '0.00', 60, 87, 88, 91, NULL, NULL),
(137, 'A. Bentuk interaksi antara dosen, mahasiswa dan sumber belajar', '0.00', 60, 87, 88, 92, NULL, NULL),
(138, 'B. Pemantauan kesesuaian proses terhadap rencana pembelajaran', '0.00', 60, 87, 88, 92, NULL, NULL),
(139, 'C. Proses pembelajaran yang terkait dengan penelitian harus mengacu SN Dikti Penelitian: 1) hasil penelitian: harus memenuhi pengembangan IPTEKS, meningkatkan kesejahteraan masyarakat, dan daya saing bangsa. 2) isi penelitian: memenuhi kedalaman dan keluasan materi penelitian sesuai capaian pembelajaran. 3) proses penelitian: mencakup perencanaan, pelaksanaan, dan pelaporan. 4) penilaian penelitian memenuhi unsur edukatif, obyektif, akuntabel, dan transparan.', '0.00', 60, 87, 88, 92, NULL, NULL),
(140, 'D. Proses pembelajaran yang terkait dengan PkM harus mengacu SN Dikti PkM: 1) hasil PkM: harus memenuhi pengembangan IPTEKS, meningkatkan kesejahteraan masyarakat, dan daya saing bangsa. 2) isi PkM: memenuhi kedalaman dan keluasan materi PkM sesuai capaian pembelajaran. 3) proses PkM: mencakup perencanaan, pelaksanaan, dan pelaporan. 4) penilaian PkM memenuhi unsur edukatif, obyektif, akuntabel, dan transparan.', '0.00', 60, 87, 88, 92, NULL, NULL),
(141, 'E. Kesesuaian metode pembelajaran dengan capaian pembelajaran. Contoh: RBE (research based education), IBE (industry based education), teaching factory/teaching industry, dll.', '0.00', 60, 87, 88, 92, NULL, NULL),
(142, 'Monitoring dan evaluasi pelaksanaan proses pembelajaran mencakup karakteristik, perencanaan, pelaksanaan, proses pembelajaran dan beban belajar mahasiswa untuk memperoleh capaian pembelajaran lulusan.', '0.00', 60, 87, 88, 93, NULL, NULL),
(143, 'A. Mutu pelaksanaan penilaian pembelajaran (proses dan hasil belajar mahasiswa) untuk mengukur ketercapaian capaian pembelajaran berdasarkan prinsip penilaian yang mencakup: 1) edukatif, 2) otentik, 3) objektif, 4) akuntabel, dan 5) transparan, yang dilakukan secara terintegrasi.', '0.00', 60, 87, 88, 94, NULL, NULL),
(144, 'B. Pelaksanaan penilaian terdiri atas teknik dan instrumen penilaian. Teknik penilaian terdiri dari: 1) observasi, 2) partisipasi, 3) unjuk kerja, 4) test tertulis, 5) test lisan, dan 6) angket. Instrumen penilaian terdiri dari: 1) penilaian proses dalam bentuk rubrik, dan/ atau; 2) penilaian hasil dalam bentuk portofolio, atau 3) karya disain.', '0.00', 60, 87, 88, 94, NULL, NULL),
(145, 'C. Pelaksanaan penilaian memuat unsurunsur sebagai berikut: 1) mempunyai kontrak rencana penilaian, 2) melaksanakan penilaian sesuai kontrak atau kesepakatan, 3) memberikan umpan balik dan memberi kesempatan untuk mempertanyakan hasil kepada mahasiswa, 4) mempunyai dokumentasi penilaian proses dan hasil belajar mahasiswa, 5) mempunyai prosedur yang mencakup tahap perencanaan, kegiatan pemberian tugas atau soal, observasi kinerja, pengembalian hasil observasi, dan pemberian nilai akhir, 6) pelaporan penilaian berupa kualifikasi keberhasilan mahasiswa dalam menempuh suatu mata kuliah dalam bentuk huruf dan angka, 7) mempunyai buktibukti rencana dan telah melakukan proses perbaikan berdasar hasil monev penilaian.', '0.00', 60, 87, 88, 94, NULL, NULL),
(146, 'Integrasi kegiatan penelitian dan PkM dalam pembelajaran oleh DTPS dalam 3 tahun terakhir.', '0.00', 60, 87, 88, 95, NULL, NULL),
(147, 'Keterlaksanaan dan keberkalaan program dan kegiatan diluar kegiatan pembelajaran terstruktur untuk meningkatkan suasana akademik. Contoh: kegiatan himpunan asosiasi profesi bidang ilmu, kuliah umum/studium generale, seminar ilmiah, bedah buku.', '0.00', 60, 87, 88, 96, NULL, NULL),
(148, 'A. Tingkat kepuasan mahasiswa terhadap proses pendidikan.', '0.00', 60, 87, 88, 97, NULL, NULL),
(149, 'B. Analisis dan tindak lanjut dari hasil pengukuran kepuasan mahasiswa.', '0.00', 60, 87, 88, 97, NULL, NULL),
(150, 'Relevansi penelitian pada UPPS mencakup unsur-unsur sebagai berikut: 1) memiliki peta jalan yang memayungi tema penelitian dosen dan mahasiswa serta pengembangan keilmuan program studi, 2) dosen dan mahasiswa melaksanakan penelitian sesuai dengan agenda penelitian dosen yang merujuk kepada peta jalan penelitian, 3) melakukan evaluasi kesesuaian penelitian dosen dan mahasiswa dengan peta jalan, dan 4) menggunakan hasil evaluasi untuk perbaikan relevansi penelitian dan pengembangan keilmuan program studi.', '0.00', 60, 98, 99, 100, NULL, NULL),
(151, 'Penelitian DTPS yang dalam pelaksanaannya melibatkan mahasiswa program studi dalam 3 tahun terakhir.', '0.00', 60, 98, 99, 101, NULL, NULL),
(152, 'Penelitian DTPS yang menjadi rujukan tema tesis/disertasi mahasiswa program studi dalam 3 tahun terakhir.', '0.00', 60, 98, 99, 101, NULL, NULL),
(153, 'Relevansi PkM pada UPPS mencakup unsurunsur sebagai berikut: 1) memiliki peta jalan yang memayungi tema PkM dosen dan mahasiswa serta hilirisasi/penerapan keilmuan program studi, 2) dosen dan mahasiswa melaksanakan PkM sesuai dengan peta jalan PkM. 3) melakukan evaluasi kesesuaian PkM dosen dan mahasiswa dengan peta jalan, dan 4) menggunakan hasil evaluasi untuk perbaikan relevansi PkM dan pengembangan keilmuan program studi.', '0.00', 60, 102, 103, 104, NULL, NULL),
(154, 'Analisis pemenuhan capaian pembelajaran lulusan (CPL) yang diukur dengan metoda yang sahih dan relevan, mencakup aspek: 1) keserbacakupan, 2) kedalaman, dan 3) kebermanfaatan analisis yang ditunjukkan dengan peningkatan CPL dari waktu ke waktu dalam 3 tahun terakhir.', '0.00', 60, 105, 106, 107, NULL, NULL),
(155, 'IPK lulusan. RIPK = Rata-rata IPK lulusan dalam 3 tahun terakhir.', '0.00', 60, 105, 106, 107, NULL, NULL),
(156, 'Prestasi mahasiswa di bidang akademik dalam 3 tahun terakhir.', '0.00', 60, 105, 106, 107, NULL, NULL),
(157, 'Masa studi. MS = Rata-rata masa studi lulusan (tahun).', '0.00', 60, 105, 106, 107, NULL, NULL),
(158, 'Kelulusan tepat waktu. PTW = Persentase kelulusan tepat waktu.', '0.00', 60, 105, 106, 107, NULL, NULL),
(159, 'Keberhasilan studi. PPS = Persentase keberhasilan studi.', '0.00', 60, 105, 106, 107, NULL, NULL),
(160, 'Pelaksanaan tracer study yang mencakup 5 aspek sebagai berikut: 1) pelaksanaan tracer study terkoordinasi di tingkat PT, 2) kegiatan tracer study dilakukan secara reguler setiap tahun dan terdokumentasi, 3) isi kuesioner mencakup seluruh pertanyaan inti tracer study DIKTI. 4) ditargetkan pada seluruh populasi (lulusan TS-4 s.d. TS-2), 5) hasilnya disosialisasikan dan digunakan untuk pengembangan kurikulum dan pembelajaran.', '0.00', 60, 105, 106, 107, NULL, NULL),
(161, 'Kesesuaian bidang kerja. PBS = Kesesuaian bidang kerja lulusan saat mendapatkan pekerjaan pertama dalam 3 tahun, mulai TS-4 s.d. TS-2.', '0.00', 60, 105, 106, 107, NULL, NULL),
(162, 'Tingkat kepuasan pengguna lulusan.', '0.00', 60, 105, 106, 107, NULL, NULL),
(163, 'Publikasi ilmiah mahasiswa, yang dihasilkan secara mandiri atau bersama DTPS, dengan judul yang relevan dengan bidang program studi dalam 3 tahun terakhir.', '0.00', 60, 105, 106, 108, NULL, NULL),
(164, 'Artikel karya ilmiah mahasiswa, yang dihasilkan secara mandiri atau bersama DTPS, yang disitasi dalam 3 tahun terakhir.', '0.00', 60, 105, 106, 108, NULL, NULL),
(165, 'Luaran penelitian dan PkM yang dihasilkan mahasiswa, baik secara mandiri atau bersama DTPS dalam 3 tahun terakhir.', '0.00', 60, 105, 106, 108, NULL, NULL),
(166, 'Keserbacakupan (kelengkapan, keluasan, dan kedalaman), ketepatan, ketajaman, dan kesesuaian analisis capaian kinerja serta konsistensi dengan setiap kriteria.', '0.00', 109, 110, NULL, NULL, NULL, NULL),
(167, 'Ketepatan analisis SWOT atau analisis yang relevan di dalam mengembangkan strategi.', '0.00', 109, 111, NULL, NULL, NULL, NULL),
(168, 'Ketepatan di dalam menetapkan prioritas program pengembangan.', '0.00', 109, 112, NULL, NULL, NULL, NULL),
(169, 'UPPS memiliki kebijakan, ketersediaan sumberdaya, kemampuan melaksanakan, dan kerealistikan program.', '0.00', 109, 113, NULL, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
