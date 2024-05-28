-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 28 Bulan Mei 2024 pada 07.09
-- Versi server: 8.0.36-0ubuntu0.22.04.1
-- Versi PHP: 8.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci_restaurant`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `menus`
--

CREATE TABLE `menus` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` int UNSIGNED NOT NULL,
  `stock` int NOT NULL,
  `cost` varchar(255) NOT NULL,
  `sell` varchar(255) NOT NULL,
  `discount` int NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data untuk tabel `menus`
--

INSERT INTO `menus` (`id`, `name`, `category_id`, `stock`, `cost`, `sell`, `discount`, `image`, `created_at`, `updated_at`) VALUES
(2, 'Mie Aceh', 1, 95, '50000', '60000', 0, '1715088133_08bc519bd9599d762cd1.jpg', '2024-05-03 19:46:09', '2024-05-07 20:22:13'),
(5, 'Bika Ambon', 1, 40, '40000', '59999', 0, '1714747104_f5688f9549b38ec8c884.jpg', '2024-05-03 21:38:24', '2024-05-03 21:38:24'),
(7, 'Rendang', 1, 60, '60000', '70000', 0, '1714748426_625123fdc335e602023b.jpg', '2024-05-03 22:00:26', '2024-05-03 22:48:40'),
(8, 'Gulai Belacan', 1, 10, '30000', '39999', 0, '1714751395_1cf5d85b144f7c7ccbcd.jpeg', '2024-05-03 22:49:55', '2024-05-03 22:49:55'),
(9, 'Tempoyak Ikan Patin', 1, 40, '70000', '80000', 0, '1714751430_7c5daf479163b0196fa8.jpg', '2024-05-03 22:50:30', '2024-05-03 22:50:30'),
(10, 'Pempek', 1, 3, '20000', '25000', 0, '1714751466_55903e70a3aa69bceb1c.jpg', '2024-05-03 22:51:06', '2024-05-03 22:51:06'),
(11, 'Pendap', 1, 5, '70000', '75000', 0, '1714751502_09faabcbaed554861edf.jpg', '2024-05-03 22:51:42', '2024-05-03 22:51:42'),
(12, 'Seruit', 1, 30, '34000', '50000', 5, '1714751551_cffab29bb8666b70d7c4.jpg', '2024-05-03 22:52:31', '2024-05-03 22:52:31'),
(13, 'Mie Bangka', 1, 30, '30000', '40000', 5, '1714751590_d271ca1baa403c7bdee0.jpg', '2024-05-03 22:53:10', '2024-05-03 22:53:10'),
(14, 'Mie Lendir', 1, 30, '50000', '60000', 0, '1714751620_df9ea6974089dc65a098.jpg', '2024-05-03 22:53:40', '2024-05-03 22:53:40'),
(15, 'Kerak Telor', 1, 30, '40000', '50000', 10, '1714751660_eeae59b1fe76d2c8770c.jpg', '2024-05-03 22:54:20', '2024-05-03 22:54:20'),
(16, 'Lumpia', 1, 50, '24000', '30000', 1, '1714751708_f602c8a02272899ad5cb.jpg', '2024-05-03 22:55:08', '2024-05-03 22:55:08'),
(17, 'Nasi Gudeg', 1, 20, '30000', '35000', 0, '1714751737_e7cf89cafb151987ce87.jpg', '2024-05-03 22:55:37', '2024-05-03 22:55:37'),
(18, 'Rujak Cingur', 1, 20, '20000', '25000', 0, '1714751774_5989c18c15aa732fb797.jpg', '2024-05-03 22:56:14', '2024-05-03 22:56:14'),
(19, 'Sate Bandeng', 1, 30, '30000', '40000', 0, '1714751817_30a18984cc4ae3081eaf.jpg', '2024-05-03 22:56:57', '2024-05-03 22:56:57'),
(20, 'Wedang Angsle', 2, 10, '15000', '20000', 0, '1714751946_cef7f65a895f1e43bb84.jpeg', '2024-05-03 22:59:06', '2024-05-03 22:59:06'),
(21, 'Es Dawet Siwalan', 2, 40, '12000', '15000', 0, '1714751997_e08aa2177c0b73ac1248.jpeg', '2024-05-03 22:59:57', '2024-05-03 22:59:57'),
(22, 'Wedang Secang', 2, 20, '10000', '15000', 0, '1714752034_e8be879fd311b8b7c040.jpeg', '2024-05-03 23:00:35', '2024-05-03 23:00:35'),
(23, 'Es Pleret', 2, 40, '20000', '25000', 0, '1714752064_6fd0e9c8c6028c1de231.jpeg', '2024-05-03 23:01:04', '2024-05-03 23:01:04'),
(24, 'Wedang Cemue', 2, 40, '12000', '25000', 10, '1714752122_212e554dd24a91e91dbf.jpg', '2024-05-03 23:02:02', '2024-05-03 23:02:12'),
(25, 'Es Buto Ijo', 2, 10, '12000', '15000', 0, '1714752171_7fa4ed2ef09c395bbc53.jpg', '2024-05-03 23:02:51', '2024-05-03 23:02:51'),
(26, 'Lumpia Khas Semarang', 4, 10, '12000', '15000', 0, '1714752314_19f4c8342d340b9a77b3.png', '2024-05-03 23:05:14', '2024-05-03 23:05:14'),
(27, 'Getuk Khas Magelang', 4, 20, '10000', '12000', 0, '1714752346_75584a6e2079bfb59355.jpg', '2024-05-03 23:05:46', '2024-05-03 23:05:46'),
(28, 'Arem Arem Khas Semarang', 4, 40, '12000', '15000', 0, '1714752378_2e85f62b69916b08d222.jpg', '2024-05-03 23:06:18', '2024-05-03 23:06:18'),
(29, 'Ayam Goreng Khas Solo', 4, 50, '25000', '35000', 5, '1714752415_fcd65e5cc238f874c442.png', '2024-05-03 23:06:55', '2024-05-03 23:06:55'),
(30, 'Wajik Khas Magelang', 4, 30, '20000', '30000', 2, '1714752448_391ba98b0cdc10ae1640.jpg', '2024-05-03 23:07:28', '2024-05-03 23:07:28'),
(31, 'Jamu Khas Purwokerto', 4, 40, '11000', '13000', 0, '1714752488_964895b1869c4dc4ebc0.jpg', '2024-05-03 23:08:08', '2024-05-03 23:08:08'),
(32, 'Aneka Menu dari Kuliner Soloo', 4, 40, '10000', '25000', 10, '1714752533_5f461f6ba243f2d1f1a0.jpeg', '2024-05-03 23:08:53', '2024-05-03 23:08:53'),
(35, 'cobada', 2, 10, '1000', '1500', 0, '1716735587_2e3953c6824cd0779443.png', '2024-05-26 21:59:47', '2024-05-26 22:26:14');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menus_category_id_foreign` (`category_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
