-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 29, 2024 at 04:19 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cours_symfony`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `purchase_date` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `status`, `created_at`, `purchase_date`) VALUES
(1, 3, 1, '2024-12-25 14:54:21', '2024-12-25 15:55:35'),
(2, 3, 0, '2024-12-29 13:37:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cart_item`
--

CREATE TABLE `cart_item` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `cart_id` int NOT NULL,
  `quantity` int NOT NULL,
  `added_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_item`
--

INSERT INTO `cart_item` (`id`, `product_id`, `cart_id`, `quantity`, `added_at`) VALUES
(1, 3, 1, 1, '2024-12-25 14:54:21'),
(2, 8, 2, 1, '2024-12-29 13:37:29'),
(4, 10, 2, 1, '2024-12-29 15:46:48');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Aggressive Inline'),
(2, 'Inline Skates'),
(3, 'Quad Skates'),
(4, 'Ice Skates'),
(5, 'Aggressive Quad');

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20241202112351', '2024-12-13 18:46:11', 90),
('DoctrineMigrations\\Version20241202113812', '2024-12-13 18:46:11', 120),
('DoctrineMigrations\\Version20241204093648', '2024-12-13 18:46:11', 20),
('DoctrineMigrations\\Version20241213191959', '2024-12-13 19:20:14', 91),
('DoctrineMigrations\\Version20241214134840', '2024-12-14 13:48:52', 155),
('DoctrineMigrations\\Version20241214135202', '2024-12-14 13:52:09', 232),
('DoctrineMigrations\\Version20241214170539', '2024-12-14 17:05:46', 81),
('DoctrineMigrations\\Version20241225145311', '2024-12-25 14:53:24', 239),
('DoctrineMigrations\\Version20241225155505', '2024-12-25 15:55:15', 70),
('DoctrineMigrations\\Version20241227161149', '2024-12-27 16:12:13', 78);

-- --------------------------------------------------------

--
-- Table structure for table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int NOT NULL,
  `category_id` int NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `stock` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category_id`, `nom`, `photo`, `description`, `prix`, `stock`) VALUES
(1, 1, 'FIFTH ELEMENT DEEP PURPLE', 'https://www.roces.com/media/catalog/product/cache/d878eb7081a6250ade61b776bc33f4b1/c/o/comp_crop.jpg', 'Shell: Bio-based high Grade Polyurethane boot\nCuff: Low cuff\nClosure: Aluminum memory buckle\nLiner: Recycled liner padding\nLining: Recycled lining\nFrame: Glass fiber reinforced polyamide UFS frame\nWheels: Roces 58mm 90A wheels\nBearings: ABEC 5 bearings\nSpacers: Aluminium spacers\nAxles: Hot Rod S axles', 329.99, 50),
(2, 2, 'RADON TIF black-brilliant blue', 'https://www.roces.com/media/catalog/product/cache/d878eb7081a6250ade61b776bc33f4b1/r/a/radon_tif_001small.jpg', 'The inline skate RADON TIF features an easy closure system, fast and precise thanks to the Memory Buckle and Fast Lacing system B. The frame in Extruded Aluminium is able to host 4 wheels of 90 mm-82A. Finally, the bearing ABEC 7 is very important to allow very good performances.\n\nTECHNICAL DATA:\n\nShell: Glass Fiber Reinforced HQ Polypropylene\nClosure: Memory Buckle, Power Strap, Fast Lacing System B\nBoot: EES Easy Entry System, PAP Progressive Anatomical Padding\nVentilation: “Cool Breath” Mesh & Jet Intakes\nFootbed: RAF - Roces Anatomical Footbed\nFrame: LiteDesign Extruded Aluminium\nWheels: Roces 90 mm 82A\nBearing: ABEC 7\nSpacers: Aluminium', 179.99, 0),
(3, 4, 'RH1 HOCKEY ADJUSTABLE', 'https://www.roces.com/media/catalog/product/cache/d878eb7081a6250ade61b776bc33f4b1/r/h/rh_1_001_1.jpg', 'Shell: Reynforced nylon upper\nClosure: Anatomical padding\nLiner: Warm velvet lining\nLiner: Felt tongue\nClosure: Anatomic footbed\nFrame: Stainless steel hockey blade\nWheels: Recyclable and recycled steel blade', 85.00, 100),
(4, 3, 'KOLOSSAL black-grey-yellow', 'https://www.roces.com/media/catalog/product/cache/d878eb7081a6250ade61b776bc33f4b1/k/o/kolossal_550041_004.jpg', 'The roller skate KOLOSSAL thanks to the coloured lining is the inline skate that combines design with comfort, performance with technical solutions but above all able to breath new life into the evergreen roller universe.\n\nDETAILS:\n\nUpper: PVC\nSole: Injected PVC\nFootbed: Anatomical EVA and fabric\nClosure: Laces\nFrame: PP\nTruck: Aluminium alloy\nStopper: Casted PU\nWheels: Casted PU, 58x32mm\nBearings: ABEC 7', 99.99, 45),
(5, 3, 'RC2 ROCES CLASSIC ROLLER white', 'https://www.roces.com/media/catalog/product/cache/d878eb7081a6250ade61b776bc33f4b1/r/c/rc2_001.jpg', 'The roller skate RC2 thanks to the white lining is the ideal skate for those who want to relive the trend of the Seventies.\n\nTECHNICAL DATA\n\nUpper: ECO leather\nOutsole: PVC\nInsole: Anatomic\nClosure: Flat laces and top closures\nFrame: Aluminum alloy\nTruck: Aluminum alloy\nHeel cap: PU\nWheels: PU 54x32 mm/85A\nBearings: ABEC 5', 109.99, 39),
(6, 4, 'WELKIN black', 'https://www.roces.com/media/catalog/product/cache/d878eb7081a6250ade61b776bc33f4b1/4/5/450638_002.jpg', 'The ice skate WELKIN features leather upper and PVC sole. The closure is fast and precise thanks to the smooth lace closure system. Carbon steel figure blade and tongue antitorsion system are very important to allow perfect performances. The anatomical footbed and the ACP system ensure great comfort. Really comfortable and very secure to wear, these skates are the right choice for those who love the classical style.\n\nTECHNICAL DATA\n\nLeather upper\nLeather tongue\nTongue Antitorsion System\nACP Antitendinitis Collar Padding\nAnatomical footbed\nLLH Long Lasting Hooks\nPVC sole\nSmooth lace closure system\nCarbon steel figure blade\nStiffness rating: 30', 169.99, 41),
(7, 1, 'M12 LO JANSONS STORM', 'https://www.roces.com/media/catalog/product/cache/d878eb7081a6250ade61b776bc33f4b1/n/i/nils_storm_m12.jpg', 'TECHNICAL DATA:\n\nShell: High Grade Polyurethane, Low cuff\nClosure: Aluminium Memory buckle, Laces\nBoot: Anatomical padding, Slo Memory foam, Anatomical\nFrame: UFS, Glass fiber reinforced polyamide\nWheels: 2 pcs Roces 60mm 92A, 2 pcs central grinding wheels\nBearings: ABEC 5\nSpacers: Aluminium\nAxles: Hot Rod S', 219.99, 0),
(8, 1, 'FIFTH ELEMENT ASAYAKE BLUE', 'https://www.roces.com/media/catalog/product/cache/d878eb7081a6250ade61b776bc33f4b1/r/o/roces_fifth_element_goto.jpg', 'Shell: Bio-based high Grade Polyurethane boot\nCuff: Low cuff\nClosure: Aluminum memory buckle\nLiner: Recycled liner padding\nLining: Recycled\nFrame: Glass fiber reinforced polyamide UFS frame\nWheels: Roces 60mm 93A wheels + central grinding wheels\nBearings: ABEC 5 bearings\nSpacers: Aluminium spacers\nAxles: Hot Rod S axles', 260.99, 14),
(9, 2, 'THREAD salt-n-pepa', 'https://www.roces.com/media/catalog/product/cache/d878eb7081a6250ade61b776bc33f4b1/4/0/400860_002.jpg', 'TECHNICAL DATA:\n\nShell and cuff: Glass fiber reinforced High Quality polypropylene\nClosure: Memory buckle, Power strap,Fast lacing system\nBoot: «Thread» construction, EES Easy Entry System, PAP Progressive anatomical padding, Cool breath mesh, Jet air intakes\nFootbed: Anatomical\nFrame: Extruded aluminium\nWheels: Roces 90mm 82A\nBearings: ABEC 9\nSpacers: Aluminium\nRocker Washers: Aluminium\nAxles: Hot RodF\nStopper: Supplied with brake', 179.99, 27),
(10, 2, 'PIC TIF black-air blue', 'https://www.roces.com/media/catalog/product/cache/d878eb7081a6250ade61b776bc33f4b1/p/i/pic_tif.jpg', 'Shell and cuff Glass fiber reinforced High Quality polypropylene\nClosure Memory buckle, Power strap, Fast lacing system\nBoot EES Easy Entry System, PAP Progressive anatomical padding, Cool breath mesh\nFootbed Anatomical, Comfootbed\nFrame Extruded aluminium\nWheels Roces 80mm 82A\nBearings ABEC 5\nSpacers Aluminium\nRocker Washers Aluminium\nAxles Hot Rod F\nStopper Supplied with brake', 119.99, 5),
(11, 3, '52 STAR black-red', 'https://www.roces.com/media/catalog/product/cache/d878eb7081a6250ade61b776bc33f4b1/5/2/52star_004ombra.jpg', '52 STAR is the ideal skate for rolling down a neighborhood lane with the pal next door, feeling derby on a loop with your girl or friends. Finally this is the ideal skate for guys who wants to show their personal touch in skating and having many hours of memorable fun.\n\nTECHNICAL DATA\n\nUpper: ECOmesh\nSole: PVC\nFootbed: Anatomical\nClosure: Flat laces and upper hooks\nFrame: PP\nTruck: PE\nStopper: PU\nWheels: PVC, 54x32mm/85A\nBearings: 608Z Bearing', 39.99, 15),
(12, 3, 'MOVIDA UP black-silver', 'https://www.roces.com/media/catalog/product/cache/d878eb7081a6250ade61b776bc33f4b1/m/o/movida_up_550071-001.jpg', 'The roller skate MOVIDA UP thanks to the white lining is the ideal skate for those who want to relive the trend of the Seventies.\n\nDETAILS:\n\nUpper: ECOleather\nSole: PVC\nFootbed: Anatomical \nClosure: Tubular laces and Power Strap\nFrame: PP\nTruck: Aluminium alloy\nStopper: PU\nWheels: PU 54x32mm/85A\nBearings: ABEC 7', 89.99, 23),
(13, 1, 'M12 LO GOTO NAMIKAZE', 'https://www.roces.com/media/catalog/product/cache/d878eb7081a6250ade61b776bc33f4b1/t/a/tagliata_yuto_complete.jpg', 'Shell: Bio-based high Grade Polyurethane boot\nCuff: Low cuff\nClosure: Aluminum memory buckle\nLiner: Recycled liner padding\nLining: Recycled lining\nFrame: Glass fiber reinforced polyamide UFS frame\nWheels: Roces 60mm 93A wheels + central grinding wheels\nBearings: ABEC 5 bearings\nSpacers: Aluminium spacers\nAxles: Hot Rod S axles', 269.99, 23),
(14, 1, 'M12 LO UFS TEAM POMEGRANATE', 'https://www.roces.com/media/catalog/product/cache/d878eb7081a6250ade61b776bc33f4b1/r/o/roces_m12_lo_ufs_pomegranate.jpg', 'Shell: Bio-based high Grade Polyurethane boot\nCuff: Low cuff\nClosure: Aluminum memory buckle\nLiner: Recycled liner padding\nLining: Recycled lining\nFrame: Glass fiber reinforced polyamide UFS frame\nWheels: Roces 58mm 88A wheels + central grinding wheels\nBearings: ABEC 5 bearings\nSpacers: Aluminium spacers\nAxles: Hot Rod S axles', 202.49, 0),
(15, 4, 'RFG 1 RECYCLE cold grey', 'https://www.roces.com/media/catalog/product/cache/d878eb7081a6250ade61b776bc33f4b1/4/5/450714_001.jpg', 'TECHNICAL DATA:\n\nUpper and tongue in recycled PET\nAnatomical padding in recycled PU\nLining in recycled PET and recycled PU fibers\nLace closure system\nRecycled&Recyclable PVC sole\nAnatomical footbed\nStainless Steel figure blade', 99.99, 13),
(16, 4, 'M12 ICE', 'https://www.roces.com/media/catalog/product/cache/d878eb7081a6250ade61b776bc33f4b1/m/1/m12ice-web.jpg', 'Shell and cuff: 97% recycled polyurethane; 3% black colour masterbatch\n\nLinerpadding: 100% recycled polyurethane\n\nClosure: Aluminium Memory buckle, Laces\n\nCarbon steel hockey blade', 199.99, 32);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--


--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_BA388B7A76ED395` (`user_id`);

--
-- Indexes for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F0FE25274584665A` (`product_id`),
  ADD KEY `IDX_F0FE25271AD5CDBF` (`cart_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D34A04AD12469DE2` (`category_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `FK_BA388B7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD CONSTRAINT `FK_F0FE25271AD5CDBF` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`),
  ADD CONSTRAINT `FK_F0FE25274584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04AD12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
