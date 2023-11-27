
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


INSERT INTO `institutions` (`id`, `name`, `name_long`, `created_at`, `updated_at`) VALUES
(1, 'BAN-PT', 'Badan Akreditasi Nasional Perguruan Tinggi', NULL, NULL),
(2, 'LAM-DIK', 'Lembaga Akreditasi Mandiri Kependidikan', NULL, NULL),
(3, 'LAM-EMBA', 'Lembaga Akreditasi Mandiri Ekonomi Manajemen Bisnis dan Akuntansi', NULL, NULL);

INSERT INTO `degrees` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Strata Satu', 'S1', '2023-11-25 22:37:11', '2023-11-25 22:37:11'),
(4, 'Magister', 'S2', '2023-11-25 22:37:11', '2023-11-25 22:37:11');

COMMIT;

