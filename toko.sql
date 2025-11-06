-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2025 at 01:51 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','kasir') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id`, `username`, `password`, `role`) VALUES
(2, 'admin', 'admin99', 'admin'),
(3, 'kasir', 'kasir99', 'kasir');

-- --------------------------------------------------------

--
-- Table structure for table `tb_detailpes`
--

CREATE TABLE `tb_detailpes` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` varchar(255) NOT NULL,
  `id` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `subtotal` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_detailpes`
--

INSERT INTO `tb_detailpes` (`id_detail`, `id_pesanan`, `id`, `nama_produk`, `jumlah`, `harga`, `subtotal`) VALUES
(1, 'P0002', 66, 'Donat Bomboloni', 2, 7000, 14000),
(2, 'P0005', 44, 'Rainbow Cake', 1, 160000, 160000),
(3, 'P0005', 32, 'Red Velvet Cookies', 2, 13000, 26000),
(4, 'P0005', 67, 'Donat Oreo', 1, 6000, 6000),
(5, 'P0005', 78, ' Meringue', 1, 10000, 10000),
(6, 'P0005', 77, 'Madeleine', 1, 15000, 15000),
(7, 'P0005', 87, 'Roti Isi Abon', 1, 13000, 13000),
(8, 'P0006', 4, 'Cappucino Bread', 1, 7000, 7000),
(9, 'P0006', 9, 'Croissant', 2, 35000, 70000),
(10, 'P0006', 67, 'Donat Oreo', 3, 6000, 18000),
(11, 'P0006', 32, 'Red Velvet Cookies', 1, 13000, 13000),
(12, 'P0006', 11, 'Brownies Panggang', 1, 25000, 25000),
(13, 'P0007', 51, 'Pain au Chocolat', 2, 22000, 44000),
(14, 'P0008', 52, 'Strawberry Cream Cheese Puff', 2, 21500, 43000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pembayaran`
--

CREATE TABLE `tb_pembayaran` (
  `id_pesanan` varchar(50) NOT NULL,
  `metode_pembayaran` enum('Tunai') NOT NULL,
  `jumlah_bayar` decimal(10,0) NOT NULL,
  `kembalian` decimal(10,0) NOT NULL,
  `status_pembayaran` enum('Belum Dibayar','Lunas','Dibatalkan') NOT NULL,
  `tanggal_pembayaran` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_pembayaran`
--

INSERT INTO `tb_pembayaran` (`id_pesanan`, `metode_pembayaran`, `jumlah_bayar`, `kembalian`, `status_pembayaran`, `tanggal_pembayaran`) VALUES
('P0002', 'Tunai', 20000, 6000, 'Lunas', '2025-10-26 11:12:43'),
('P0005', 'Tunai', 250000, 20000, 'Lunas', '2025-10-28 06:37:01'),
('P0006', 'Tunai', 200000, 67000, 'Lunas', '2025-11-05 12:28:34'),
('P0007', 'Tunai', 50000, 6000, 'Lunas', '2025-11-05 12:39:34'),
('P0008', 'Tunai', 50000, 7000, 'Lunas', '2025-11-05 12:44:28');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pesanan`
--

CREATE TABLE `tb_pesanan` (
  `id_pesanan` varchar(10) NOT NULL,
  `no_antrian` int(11) NOT NULL,
  `nama_pelanggan` varchar(50) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total_harga` decimal(10,0) NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `qr_path` varchar(255) DEFAULT NULL,
  `status_pesanan` enum('Pending','Lunas') NOT NULL,
  `tanggal_pemesanan` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_pesanan`
--

INSERT INTO `tb_pesanan` (`id_pesanan`, `no_antrian`, `nama_pelanggan`, `nama_produk`, `jumlah`, `total_harga`, `metode_pembayaran`, `qr_path`, `status_pesanan`, `tanggal_pemesanan`) VALUES
('P0002', 2, 'Suci Alfia', 'Donat Bomboloni', 2, 14000, 'Tunai', 'qrcodes/qr_P0002.png', 'Lunas', '2025-10-26 11:09:50'),
('P0005', 5, 'Arrohmah', 'Rainbow Cake, Red Velvet Cookies, Donat Oreo,  Meringue, Madeleine, Roti Isi Abon', 7, 230000, 'Tunai', 'qrcodes/qr_P0005.png', 'Lunas', '2025-10-28 07:34:02'),
('P0006', 6, 'Aro', 'Cappucino Bread, Croissant, Donat Oreo, Red Velvet Cookies, Brownies Panggang', 8, 133000, 'Tunai', 'qrcodes/qr_P0006.png', 'Lunas', '2025-11-05 13:26:53'),
('P0007', 7, 'ciko', 'Pain au Chocolat', 2, 44000, 'Tunai', 'qrcodes/qr_P0007.png', 'Lunas', '2025-11-05 13:39:15'),
('P0008', 8, 'Dela', 'Strawberry Cream Cheese Puff', 2, 43000, 'Tunai', 'qrcodes/qr_P0008.png', 'Lunas', '2025-11-05 13:42:40');

-- --------------------------------------------------------

--
-- Table structure for table `tb_produk`
--

CREATE TABLE `tb_produk` (
  `id` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `stok` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `crated_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_produk`
--

INSERT INTO `tb_produk` (`id`, `nama_produk`, `deskripsi`, `harga`, `stok`, `gambar`, `kategori`, `crated_at`) VALUES
(1, 'Roti Coklat Keju', 'Roti dengan isian coklat dan keju yang lembut, cocok untuk sarapan atau cemilan.', 15000, 30, 'Roti Coklat Keju.jpg', 'Roti', '2025-10-23 05:26:32.015852'),
(2, 'Roti Manis Kismis', 'Roti manis dengan tambahan kismis di atasnya, memberikan rasa manis yang pas.', 19500, 23, 'Roti Manis Kismis.jpg', 'Roti', '2025-10-23 05:26:32.019164'),
(4, 'Cappucino Bread', 'Roti yang lembut dan aroma khas kopi dengan dipadukan cream mocha di atasnya.', 7000, 31, 'Cappucino Bread.jpg', 'Roti', '2025-11-05 12:26:54.003298'),
(5, 'Choco Beetle', 'Roti yang lembut dengan toping kacang yang gurih.', 7000, 20, 'Choco Beetle.jpg', 'Roti', '2025-10-23 05:26:32.022996'),
(7, 'Brioche ', 'Brioche adalah roti lembut, sedikit manis, dan kaya rasa yang berasal dari Prancis. Brioche memiliki kulit gelap, emas, dan rapuh.', 21000, 20, 'Brioche.jpg', 'Roti', '2025-10-23 05:26:32.024528'),
(8, 'Ciabatta', 'Roti ciabatta adalah jenis roti asal Itali yang memiliki ciri khas kulit yang renyah, bagian dalam yang lembut dan salah satu roti yang populer dan memiliki karakteristik yang unik.', 17000, 30, 'Ciabatta.jpg', 'Roti', '2025-10-23 05:26:32.026109'),
(9, 'Croissant', 'Roti croissant adalah kue kering yang berbentuk bulan sabit dan memiliki tekstur berlapis. Croissant terkenal karena rasa gurih dan renyah diluar, serta lembut didalam.', 35000, 21, 'Croissant.jpg', 'pastry', '2025-11-05 12:26:54.023619'),
(10, 'Roti Bagel', 'Roti bagel memiliki tekstur padat dan kenyal didalam, serta kulit luarnya yang garing dan berwarna coklat muda.', 17000, 20, 'Bagel.jpg', 'Roti', '2025-10-23 05:24:54.047885'),
(11, 'Brownies Panggang', 'Brownies adalah kue coklat yang dipanggang dengan oven dan memiliki tekstur yang lembut didalam dan garing diluar.', 25000, 23, 'Brownies.jpg', 'cake', '2025-11-05 12:26:54.026612'),
(12, 'Cheese cream Cake', 'Empuknya cake dipadu dengan gurihnya keju dipadu dengan lembutnya cream. ', 45000, 12, 'Cheese Cream Cake.jpg', 'cake', '2025-10-23 05:26:32.033273'),
(13, 'Coco Cake', 'Coco Cake hadir dengan ragam olahan cokelat yang melimpah. Lapisan buttercream coklat menyelimuti kelembutan kue spons cokelat yang moist di mulut.', 59000, 18, 'Coco Cake.jpeg', 'cake', '2025-10-23 12:10:44.152119'),
(14, 'Roti Canai', 'Roti canai adalah roti pipih yang berlapis-lapis, lembut didalam, dan renyah diluar. Roti canai merupakan makanan khas Malaysia yang populer.', 15000, 10, 'Canai.jpeg', 'Roti', '2025-10-23 05:28:42.292721'),
(15, 'Classic Opera', 'Classic opera adalah kue bolu almond yang rumit dengan isian dan lapisan gula kopi dan cokelat.', 120000, 19, 'Opera.jpeg', 'cake', '2025-10-23 05:28:42.296379'),
(16, 'Mango Cheesecake', 'Mango cheesecake adalah cheesecake yang dicampur dengan buah mangga segar ini diberi lapisan cookies crumble homemade dibagian pinggirnya.', 56000, 12, 'Mango Cheesecake.jpeg', 'cake', '2025-10-23 05:28:42.298604'),
(17, 'Roti Sobek', 'Roti lembut berbentuk potongan yang bisa disobek, biasanya polos.', 16000, 10, 'Sobek.jpeg', 'Roti', '2025-10-23 05:28:42.300215'),
(18, 'Focaccia', 'Roti datar khas Italia dengan toping minyak zaitun dan rempah.', 22000, 19, 'Focaccia.jpeg', 'Roti', '2025-10-23 05:28:42.302121'),
(19, 'Donat', 'Satu kotak berisi 6 donat lembut dengan beragam topping.', 25000, 14, 'Donat.jpeg', 'Donut', '2025-10-23 05:28:42.304981'),
(20, 'Roti Kukus Thailand', 'Roti kukus Thailand adalah kudapan yang memiliki tektur yang lembut dan empuk, disajikan dalam keadaan hangat dengan berbagai macam topping manis dan gurih.', 32000, 19, 'Roti Kukus.jpg', 'Roti', '2025-10-23 05:28:42.306579'),
(21, 'Roti Gambang', 'Roti gambang adalah roti berwarna coklat dengan teksturnya agak padat. Terus, beraroma rempah, seperti kayu manis, biji pala.', 15000, 18, 'Gambang.jpg', 'Roti', '2025-10-23 05:28:42.308535'),
(22, 'Roti Pumperckel', 'Roti pumpernickel adalah roti tradisional jepang yang terbuat dari tepung gamdum hitam yang digiling kasar. Roti ini memiliki tekstur padat dan kasar berwarna coklat tua, dan terkadang hampir hitam.', 35000, 21, 'Roti Pumpernickel.jpg', 'Roti', '2025-10-23 05:28:42.310392'),
(23, 'Chocolate Chip Cookies', 'Cookies klasik dengan potongan cokelat hitam yang meleleh di mulut.', 9000, 16, 'Chocolate Chip Cookies.jpeg', 'Cookies', '2025-11-05 12:43:28.467090'),
(24, 'Butter Cookies', 'Kue kering renyah berbahan dasar mentega premium dengan rasa lembut.', 8000, 23, 'Butter Cookies.jpeg', 'Cookies', '2025-10-23 05:28:42.314322'),
(25, 'Oatmeal Raisin Cookies', 'Perpaduan gamdum utuh dan kismis manis, cocok untuk cemilan sehat.', 11000, 10, 'Oatmeal Raisin Cookies.jpeg', 'Cookies', '2025-10-20 14:59:35.812569'),
(26, 'Peanut Butter Cookies', 'Cookies gurih dan manis dengan rasa khas selai kacang.', 11000, 26, 'Panut Butter Cookies.jpeg', 'Cookies', '2025-10-23 05:28:42.316957'),
(27, 'Matcha Cookies', 'Cookies dengan rasa matcha Jepang yang khas dan aroma teh hijau.', 13000, 26, 'Matcha Cookies.jpeg', 'Cookies', '2025-10-23 05:28:42.318554'),
(28, 'Almond Crunch Cookies', 'Kue kering dengan taburan kacang almond renyah di setiap gigitan.', 14000, 28, 'Almong Crunch Cookies.jpeg', 'Cookies', '2025-10-23 05:33:45.177825'),
(29, 'Double Chocolate Cookies', 'Cookies coklat dengan tambahan choco chip ekstra untuk pecinta coklat.', 13000, 26, 'Double Chocotate Cookies.jpeg', 'Cookies', '2025-10-23 05:33:45.181691'),
(30, 'Cornflakes Cookies', 'Cookies renyah dilapisi cornflakes, cocok untuk teman teh atau kopi.', 10000, 27, 'Cornflakes Cookies.jpeg', 'Cookies', '2025-10-23 05:33:45.183665'),
(31, 'Cheese Cookies', 'Perpaduan rasa manis dan asin dari keju cheddar yang dipanggang renyah.', 9000, 29, 'Cheese Cookies.jpeg', 'Cookies', '2025-10-23 05:33:45.185918'),
(32, 'Red Velvet Cookies', 'Kue berwarna merah elegan dengan isian coklat putih di tengahnya.', 13000, 23, 'Red Velvet Cookies.jpeg', 'Cookies', '2025-11-05 12:26:54.025801'),
(33, 'Choco Mint Cookies', 'Cookies coklat dengan sensasi segar mint, cocok untuk pecinta rasa unik.', 13000, 30, 'Choco Mint Cookies.jpeg', 'Cookies', '2025-10-23 05:33:45.189985'),
(34, 'Caramel Cashew Cookies', 'Cookies manis dengan lapisan karamel dan kacang mete panggang.', 10000, 32, 'Caramel Cashew Cookies.jpeg', 'Cookies', '2025-10-23 05:33:45.192295'),
(35, 'Mocha Coffee Cookies', 'Kue kering beraroma kopi dengan sentuhan cokelat, pas untuk pecinta kopi.', 13000, 28, 'Mocha Coffee Cookies.jpeg', 'Cookies', '2025-10-23 05:33:45.194582'),
(36, 'Cinnamon Sugar Cookies ', 'Cookies renyah dengan taburan gula dan kayu manis yang harum dan manis.', 11000, 31, 'Cinnamon Sugar Cookies.jpg', 'Cookies', '2025-10-23 05:33:45.196969'),
(37, 'Rainbow Spinkle Cookies', 'Cookies warna-warni dengan topping sprinkle ceria, disukai anak-anak.', 12000, 0, 'Rainbow Sprinkle Cookies.jpeg', 'Cookies', '2025-10-20 15:01:54.435196'),
(38, 'Donat Cokelat Glaze', 'Donat empuk dengan lpisan coklat leleh di atasnya.', 6000, 0, 'Donat Coklat Glaze.jpeg', 'Donut', '2025-10-20 15:14:57.634396'),
(39, 'Donat Gula Halus', 'Donat klasik yang dilapisi gula halus, favorit sepanjang masa.', 4000, 17, 'Donat Gula Halus.jpeg', 'Donut', '2025-10-23 05:33:45.198984'),
(40, 'Chocolate Fudge Cake', 'Kue coklat lembut dengan lapisan fudge dan topping coklat leleh.', 180000, 10, 'Chocolate Fudge Cake.jpeg', 'Cake', '2025-10-23 05:33:45.200527'),
(41, 'Red Velvet Cake', 'Kue merah dengan cream cheese frosting, lembut dan manis.', 200000, 23, 'Red Velvet Cake.jpeg', 'Cake', '2025-10-23 05:33:45.202312'),
(42, 'Black Forest', 'Kue coklat dengan krim, ceri, dan taburan coklat parut.', 170000, 5, 'Black Forest.jpeg', 'Cake', '2025-10-23 05:33:45.204139'),
(43, 'Tiramisu Cake', 'Kue kopi da krim mascarpone berlapis, dilapisi cocoa powder.', 190000, 0, 'Tiramisu Cake.jpeg', 'Cake', '2025-09-01 03:19:33.049226'),
(44, 'Rainbow Cake', 'Kue berlapis warna-warni dengan krim vanila yang lembut.', 160000, 5, 'Rainbow Cake.jpeg', 'Cake', '2025-10-28 06:34:02.151794'),
(45, 'Cheese Cake', 'Kue keju creamy dengan dasar biskuit, bisa topping buah.', 175000, 6, 'Cheese Cake.jpg', 'Cake', '2025-10-23 05:33:45.209527'),
(46, 'Pandan Layer Cake', 'Kue lapis pandan dengan krim santan lembut khas Indonesia.', 160000, 0, 'Pandan Layer Cake.jpeg', 'Cake', '2025-09-01 03:19:23.673121'),
(47, 'Carrot Cake', 'Kue wortel dengan taburan kacang dan krim keju di atasnya.', 178000, 8, 'Carrot Cake.jpeg', 'Cake', '2025-10-23 05:33:45.211122'),
(48, 'Strawberry Shortcake', 'Kue vanila dengan whipped cream dan potongan stroberi segar.', 1880000, 5, 'Strawberry Short Cake.jpg', 'Cake', '2025-10-23 05:33:45.213485'),
(49, 'Mille Feuille', 'Lapis-lapis pastry renyah dengan krim vanila dan taburan gula halus.', 69000, 0, 'Mille Feuille.jpeg', 'pastry', '2025-09-01 03:21:09.305292'),
(50, 'Danish Blueberry', 'Roti lapis asal Prancis dengan tekstur renyah di luar dan lembut di dalam.', 20000, 0, 'DanishBlue.jpeg', 'Pastry', '2025-09-01 03:20:59.121466'),
(51, 'Pain au Chocolat', 'Pastry isi coklat batang khas prancis.', 22000, 3, 'Painau.jpeg', 'Pastry', '2025-11-05 12:39:15.571026'),
(52, 'Strawberry Cream Cheese Puff', 'Pastry berisi krim keju dan potongan stroberi segar.', 21500, 0, 'StrawberryCream.jpeg', 'Pastry', '2025-11-05 12:42:40.862791'),
(53, 'Apple Turnover', 'Pastry segitiga berisi apel manis dengan kayu manis dan gula.', 19000, 7, 'ApleTurnover.jpeg', 'Pastry', '2025-10-23 05:37:28.401795'),
(55, 'Cinnamon Roll', 'Roti gulung berisi kayu manis dan gula merah, diberi lapisan gula.', 18500, 16, 'CinnamonRoll.jpeg', 'Pastry', '2025-10-23 05:37:28.415562'),
(56, 'Lemon Tart', 'Tart kecil berisi custard lemon asam manis dengan crust renyah.', 20000, 0, 'LemonTart.jpeg', 'Pastry', '2025-09-01 03:21:19.123496'),
(66, 'Donat Bomboloni', 'Donat bomboloni dengan adonan lembut, diisi dengan selai cokelat leleh.', 7000, 17, 'Donat Bomboloni.jpeg', 'Donut', '2025-10-26 10:09:50.698823'),
(67, 'Donat Oreo', 'Donar dengan adonan rasa vanila, dilapisi dengan lapisan oreo dan taburan potongan oreo.', 6000, 22, 'Donat Oreo.jpeg', 'Donut', '2025-11-05 12:26:54.025000'),
(68, 'Donat Bomboloni Keju', 'Donat Bomboloni dengan adonan lembut, diisi dengan selai keju leleh.', 6000, 29, 'Donat Bomboloni Keju.jpeg', 'Donut', '2025-10-23 05:37:28.420682'),
(69, 'Donat Tiramisu', 'Donat dengan toping tiramisu dan taburan cokelat bubuk.', 7000, 29, 'Donat Tiramisu.jpeg', 'Donut', '2025-10-23 05:37:28.422627'),
(70, 'Pain Suisse ', 'Pastry asal Prancis ini serupa croissant, namun bisa diisi berbagai isian manis (cokelat, selai) atau asin (jamur).', 17000, 0, 'Pain Suisse.jpeg', 'Pastry', '2025-09-01 03:21:36.406492'),
(71, 'Kouign Amann', 'Pastry manis dan renyah asal Prancis, kaya mentega, dengan rasa manis yang khas.', 18000, 27, 'Kouign Amann.jpeg', 'Pastry', '2025-10-23 05:37:28.423927'),
(72, 'Flaky Pastry', 'Adonan pastry yang paling sederhana, mudah dibuat dan bisa diisi berbagai macam, cocok untuk eksperimen rasa.', 20000, 26, 'Flaky Pastry.jpeg', 'Pastry', '2025-10-23 05:37:28.425272'),
(73, 'Shortcrust Pastry', 'Adonan yang mudah dibuat dan tahan banting, sering digunakan untuk dasar pie atau tart.', 18000, 27, 'Shortcrust Pastry.jpeg', 'Pastry', '2025-10-23 05:37:28.426776'),
(74, 'Rough Puff Pastry', 'Perpaduan antara kue kering dan puff pastry, memberikan tekstur renyah dan gurih.', 20000, 25, 'Rough Puff Pastry.jpeg', 'Pastry', '2025-10-23 05:37:28.428518'),
(75, 'Phyllo Pastry', 'Pastry yang sangat tipis dan menyerupai kertas, bisa digunakan untuk berbagai macam hidangan, baik manis maupun asin.', 23000, 23, 'Phyllo Pastry.jpeg', 'Pastry', '2025-10-23 05:37:28.430271'),
(76, 'Beignet', 'Kue goreng lembut yang ditutupi gula halus, bisa disajikan dengan berbagai isian atau selai.', 15000, 27, 'Beignet.jpeg', 'Pastry', '2025-10-23 05:37:28.432814'),
(77, 'Madeleine', 'Kue sponge kecil yang khas dengan bentuk cangkang, cocok untuk hidangan penutup.', 15000, 27, 'Madeleine.jpeg', 'Pastry', '2025-10-28 06:34:02.158857'),
(78, ' Meringue', 'Kue kering yang dibuat dari putih telur dan gula, rasanya ringan dan manis.', 10000, 27, 'Meringue.jpeg', 'Pastry', '2025-10-28 06:34:02.157472'),
(79, 'Choux Pastry', 'Choux pastry adalah salah satu jenis pastry yang sudah sering kita jumpai dengan nama kue sus.', 10000, 28, 'Choux Pastry.jpeg', 'Pastry', '2025-10-23 05:37:28.438767'),
(80, 'Donat Ubi', 'Donat yang menggunakan adonan ubi ungu atau jala, memberikan rasa manis yang khas.', 4000, 28, 'Donat Ubi.jpeg', 'Donut', '2025-10-23 05:37:28.440192'),
(81, 'Donat Tape', 'Donat Tape dengan bahan berkualitas dan tentunya dengan tambahan tape yang bikin lembut sekali saat di gigit.', 4000, 20, 'Donat Tape.jpeg', 'Donut', '2025-10-23 05:37:28.441525'),
(82, 'Donat Crispy', 'Donat crispy adalah jenis donat yang memiliki tekstur renyah pada bagian luarnya, berbeda dengan donat biasa yang lebih lembut.', 5000, 31, 'Donat Crispy.jpeg', 'Donut', '2025-10-23 05:37:28.443094'),
(83, 'Roti Tawar Putih', 'Roti dasar yang banyak disukai, cocok untuk sandwich atau dioleskan selai.', 13000, 14, 'Roti Tawar.jpeg', 'Roti', '2025-10-23 05:37:28.445100'),
(84, 'Roti Gandum', 'Roti gandum lebih kaya serat dan gizi, cocok untuk sarapan sehat.', 13000, 12, 'Roti Gandum.jpeg', 'Roti', '2025-10-23 05:37:28.446746'),
(85, 'Roti Isi Cokelat', 'Roti lembut dengan isian cokelat leleh yang manis. ', 10000, 19, 'Roti Isi Coklat.jpeg', 'Roti', '2025-10-23 05:37:28.448470'),
(86, 'Roti Isi Keju', ' Roti dengan isian keju yang gurih dan lezat.', 12000, 13, 'Roti Isi Keju.jpeg', 'Roti', '2025-10-23 05:37:28.450568'),
(87, 'Roti Isi Abon', 'Roti dengan isian abon sapi yang gurih dan asin.', 13000, 11, 'Roti Isi Abon.jpeg', 'Roti', '2025-10-28 06:34:02.161492'),
(88, 'Roti Isi Kacang', ' Roti dengan isian kacang yang manis dan renyah. ', 12000, 13, 'Roti Isi Kacang.jpeg', 'Roti', '2025-10-23 05:38:22.646186'),
(89, 'Roti Srikaya', 'Roti manis dengan isian srikaya khas.', 21000, 12, 'Roti Srikaya.jpeg', 'Roti', '2025-10-23 05:38:22.648382'),
(90, 'Roti Susu', 'Roti yang empuk dan lembut, cocok untuk sarapan atau camilan. ', 12000, 14, 'Roti Susu.jpeg', 'Roti', '2025-10-23 05:38:22.651401'),
(91, 'Roti Isi Pisang', 'Roti dengan isian pisang yang manis dan lembut.', 14000, 12, 'Roti Isi Pisang.jpeg', 'Roti', '2025-10-23 05:38:22.653203'),
(92, 'Roti Isi Singkong', 'Roti dengan isian singkong yang manis dan gurih.', 13000, 14, 'Roti Isi Singkong.jpeg', 'Roti', '2025-10-23 05:38:22.654628'),
(93, 'Roti Bakar', 'Roti yang dipanggang dengan topping cokelat meleleh.', 17500, 12, 'Roti Bakar.jpeg', 'Roti', '2025-10-23 05:38:22.655831');

-- --------------------------------------------------------

--
-- Table structure for table `tb_review`
--

CREATE TABLE `tb_review` (
  `id_review` int(11) NOT NULL,
  `id_pesanan` varchar(20) NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `id` int(11) NOT NULL,
  `nama_produk` varchar(50) NOT NULL,
  `rating` int(11) NOT NULL,
  `komentar` text NOT NULL,
  `waktu_review` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_review`
--

INSERT INTO `tb_review` (`id_review`, `id_pesanan`, `nama_pelanggan`, `id`, `nama_produk`, `rating`, `komentar`, `waktu_review`) VALUES
(1, '0', 'Suci Alfia', 66, 'Donat Bomboloni', 4, 'Enak🥯', '2025-10-26 18:16:04');

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `id_pesanan` varchar(255) NOT NULL,
  `no_antrian` int(11) NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id_pesanan`, `no_antrian`, `nama_pelanggan`) VALUES
('P0001', 1, 'Putri '),
('P0002', 2, 'Suci Alfia'),
('P0003', 3, 'Abimayu'),
('P0004', 4, 'Dewi Asih'),
('P0005', 5, 'Arrohmah'),
('P0006', 6, 'Aro'),
('P0007', 7, 'ciko'),
('P0008', 8, 'Dela'),
('P0009', 9, 'Arta'),
('P0010', 10, 'Sonia');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_detailpes`
--
ALTER TABLE `tb_detailpes`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `tb_produk`
--
ALTER TABLE `tb_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_review`
--
ALTER TABLE `tb_review`
  ADD PRIMARY KEY (`id_review`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`no_antrian`,`id_pesanan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_detailpes`
--
ALTER TABLE `tb_detailpes`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tb_produk`
--
ALTER TABLE `tb_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `tb_review`
--
ALTER TABLE `tb_review`
  MODIFY `id_review` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `no_antrian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
