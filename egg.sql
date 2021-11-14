-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 14, 2021 at 09:34 AM
-- Server version: 8.0.18
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


--
-- Database: `egg`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `userID` int(11) NOT NULL,
  `gameID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `developer`
--

CREATE TABLE `developer` (
  `developerID` int(11) NOT NULL,
  `revenue` double NOT NULL,
  `verified` int(1) NOT NULL DEFAULT '0',
  `companySSN` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `developer`
--

INSERT INTO `developer` (`developerID`, `revenue`, `verified`, `companySSN`) VALUES
(1, 0, 1, 'COMPANY1'),
(2, 22.22, 1, 'COMPANY2'),
(3, 333.33, 1, 'COMPANY3'),
(4, 4444.44, 1, 'COMPANY4'),
(5, 55555.55, 1, 'COMPANY5'),
(6, 666666.66, 1, 'COMPANY6'),
(7, 7777777.77, 1, 'COMPANY7');

-- --------------------------------------------------------

--
-- Table structure for table `gamer`
--

CREATE TABLE `gamer` (
  `userID` int(11) NOT NULL,
  `currency` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gamer`
--

INSERT INTO `gamer` (`userID`, `currency`) VALUES
(8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `gameID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `ageRating` varchar(20) NOT NULL,
  `price` double(6,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `min_requirements` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `rec_requirements` text NOT NULL,
  `developerID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`gameID`, `name`, `description`, `ageRating`, `price`, `image`, `min_requirements`, `rec_requirements`, `developerID`) VALUES
(1, 'Test', 'Test Description', 'PEGI 17', 69.69, 'resources\\games\\test.jpg', 'RAM:8GB RAM\r\nProcessor:i5 XXX', 'RAM:16GB RAM\r\nProcessor:i9 YYY', 1),
(2, 'Fallout 4', 'Bethesda Game Studios, the award-winning creators of Fallout 3 and The Elder Scrolls V: Skyrim, welcome you to the world of Fallout 4 – their most ambitious game ever, and the next generation of open-world gaming.', 'PEGI 18', 83.73, 'resources\\games\\fallout_4.jpg', 'OS:\r\nWindows 7/8/10 (64-bit OS required)\r\nProcessor:\r\nIntel Core i5-2300 2.8 GHz/AMD Phenom II X4 945 3.0 GHz or equivalent\r\nMemory:\r\n8 GB RAM\r\nGraphics:\r\nNVIDIA GTX 550 Ti 2GB/AMD Radeon HD 7870 2GB or equivalent\r\nStorage:\r\n30 GB available space', 'OS:\r\nWindows 7/8/10 (64-bit OS required)\r\nProcessor:\r\nIntel Core i7 4790 3.6 GHz/AMD FX-9590 4.7 GHz or equivalent\r\nMemory:\r\n8 GB RAM\r\nGraphics:\r\nNVIDIA GTX 780 3GB/AMD Radeon R9 290X 4GB or equivalent\r\nStorage:\r\n30 GB available space', 2),
(3, 'Fallout 76', 'Fallout Worlds brings unique adventures in Appalachia with rotating Public Worlds and grants players the tools to build their own player-created Custom Worlds.', 'PEGI 18', 158.00, 'resources\\games\\fallout_76.jpg', 'OS:\r\nWindows 7/8.1/10 (64-bit versions)\r\nProcessor: \r\nIntel Core i5-6600k 3.5 GHz /AMD Ryzen 3 1300X 3.5 GHz or equivalent\r\nMemory: \r\n8 GB RAM\r\nGraphics: \r\nNVIDIA GTX 780 3GB /AMD Radeon R9 285 2GB or equivalent\r\nNetwork: \r\nBroadband Internet connection\r\nStorage: \r\n80 GB available space', 'OS: \r\nWindows 7/8.1/10 (64-bit versions)\r\nProcessor: \r\nIntel Core i7-4790 3.6 GHz /AMD Ryzen 5 1500X 3.5 GHz\r\nMemory: \r\n8 GB RAM\r\nGraphics: \r\nNVIDIA GTX 970 4GB /AMD R9 290X 4GB\r\nNetwork: \r\nBroadband Internet connection\r\nStorage: \r\n80 GB available space', 2),
(4, 'Forza Horizon 5', 'Your Ultimate Horizon Adventure awaits! Explore the vibrant and ever-evolving open world landscapes of Mexico with limitless, fun driving action in hundreds of the world’s greatest cars. Begin Your Horizon Adventure today and add to your Wishlist!', 'PEGI 12', 199.00, 'resources\\games\\forza_horizon_5.jpg', 'OS: \r\nWindows 10 version 15063.0 or higher\r\nProcessor: \r\nIntel i5-4460 or AMD Ryzen 3 1200\r\nMemory:\r\n8 GB RAM\r\nGraphics: \r\nNVidia GTX 970 OR AMD RX 470\r\nDirectX: \r\nVersion 12\r\nNetwork: \r\nBroadband Internet connection\r\nStorage: \r\n110 GB available space', 'OS: \r\nWindows 10 version 15063.0 or higher\r\nProcessor: \r\nIntel i5-8400 or AMD Ryzen 5 1500X\r\nMemory: \r\n16 GB RAM\r\nGraphics: \r\nNVidia GTX 1070 OR AMD RX 590\r\nDirectX: \r\nVersion 12\r\nNetwork: \r\nBroadband Internet connection\r\nStorage: \r\n110 GB available space', 3),
(5, 'Horizon Zero Dawn™ Complete Edition', 'Experience Aloy’s legendary quest to unravel the mysteries of a future Earth ruled by Machines. Use devastating tactical attacks against your prey and explore a majestic open world in this award-winning action RPG!', 'PEGI 16', 80.00, 'resources\\games\\horizon_zero_dawn.jpg', 'OS:\r\nWindows 10 64-bits\r\nProcessor:\r\nIntel Core i5-2500K@3.3GHz or AMD FX 6300@3.5GHz\r\nMemory:\r\n8 GB RAM\r\nGraphics:\r\nNvidia GeForce GTX 780 (3 GB) or AMD Radeon R9 290 (4GB)\r\nDirectX:\r\nVersion 12\r\nStorage:\r\n100 GB available space', 'OS:\r\nWindows 10 64-bits\r\nProcessor:\r\nIntel Core i7-4770K@3.5GHz or Ryzen 5 1500X@3.5GHz\r\nMemory:\r\n16 GB RAM\r\nGraphics:\r\nNvidia GeForce GTX 1060 (6 GB) or AMD Radeon RX 580 (8GB)\r\nDirectX:\r\nVersion 12\r\nStorage:\r\n100 GB available space', 4),
(6, 'Minecraft', 'The original version of Minecraft! Java Edition has cross-platform play between Windows, Linux and macOS, and also supports user-created skins and mods.', 'PEGI 7', 112.01, 'resources\\games\\minecraft.jpg', 'OS:\r\nWindows 7 and above\r\nProcessor:\r\nIntel Core i3-3210 3.2 GHz/ AMD A8-7600 APU 3.1 GHz\r\nMemory:\r\n4 GB RAM\r\nGraphics:\r\nIntel HD 4000 / AMD Radeon R5 / GeForce 400 Series / AMD Radeon HD 7000 with OpenGL 4.4*\r\nStorage:\r\n1 GB available space (for game core, maps and other files)\r\n\r\nInternet connectivity is required for downloading Minecraft files, afterwards offline play is possible', 'OS:\r\nWindows 10\r\nProcessor:\r\nIntel Core i5-4690 3.5GHz / AMD A10-7800 APU 3.5 GHz\r\nMemory:\r\n8 GB RAM\r\nGraphics:\r\nGeForce 700 Series or AMD Radeon RX 200 Series (excluding integrated chipsets) with OpenGL 4.5\r\nStorage:\r\n4 GB available space (SSD is recommended)', 5),
(7, 'State of Decay: Year One Survival Edition', 'Make your stand against the collapse of society in the ultimate zombie survival-fantasy game. Explore an open world full of dangers and opportunities that respond to your every decision. Recruit a community of playable survivors, each with their own unique skills and talents.', 'PEGI 18', 39.00, 'resources\\games\\state_of_decay_yose.jpg', 'OS: \r\nWindows 7\r\nProcessor: \r\nIntel Core 2 Duo E6600 / Athlon X64 3400\r\nMemory: \r\n4 GB RAM\r\nGraphics: \r\nGeForce GTX 470 / Radeon HD 5850 / Intel HD 4600\r\nDirectX: \r\nVersion 11\r\nStorage: \r\n4158 MB available space', 'OS:\r\nWindows 7 / Windows 8\r\nProcessor:\r\nIntel Core i5-750 / AMD Athlon X4 760K\r\nMemory:\r\n8 GB RAM\r\nGraphics:\r\nGeForce GTX 560 / Radeon HD 7770\r\nDirectX:\r\nVersion 11\r\nStorage:\r\n4200 MB available space', 6),
(8, 'State of Decay 2: Juggernaut Edition', 'The dead have risen and civilization has fallen. Now it\'s up to you to gather survivors, scavenge for resources and build a community in a post-apocalyptic world – a world where you define what it means to survive in this ultimate zombie survival simulation. ', 'PEGI 18', 71.00, 'resources\\games\\state_of_decay_2.jpg', 'OS:\r\nWindows 10 64-bit\r\nProcessor:\r\nIntel i5-2500 @2.7Ghz / AMD FX-6300\r\nMemory:\r\n8 GB RAM\r\nGraphics:\r\nNVIDIA GeForce GTX 760 2GB / AMD Radeon HD 7870\r\nDirectX:\r\nVersion 11\r\nStorage:\r\n30 GB available space\r\n\r\nAdditional Notes: Internet connection required for initial sign-in. Free Xbox Live account required to play.', 'OS:\r\nWindows 10 64-bit\r\nProcessor:\r\nIntel i5 4570 @ 3.2Ghz / AMD FX-8350\r\nMemory:\r\n16 GB RAM\r\nGraphics:\r\nNVIDIA GeForce GTX 1650 4GB / AMD Radeon R9 380\r\nDirectX:\r\nVersion 11\r\nStorage:\r\n30 GB available space', 6),
(9, 'The Witcher® 3: Wild Hunt', 'As war rages on throughout the Northern Realms, you take on the greatest contract of your life — tracking down the Child of Prophecy, a living weapon that can alter the shape of the world. ', 'PEGI 18', 103.99, 'resources\\games\\the_witcher_3_wild_hunt.jpg', 'OS:\r\n64-bit Windows 7, 64-bit Windows 8 (8.1) or 64-bit Windows 10\r\nProcessor:\r\nIntel CPU Core i5-2500K 3.3GHz / AMD CPU Phenom II X4 940\r\nMemory:\r\n6 GB RAM\r\nGraphics:\r\nNvidia GPU GeForce GTX 660 / AMD GPU Radeon HD 7870\r\nStorage:\r\n35 GB available space', 'OS:\r\n64-bit Windows 7, 64-bit Windows 8 (8.1) or 64-bit Windows 10\r\nProcessor:\r\nIntel CPU Core i7 3770 3.4 GHz / AMD CPU AMD FX-8350 4 GHz\r\nMemory:\r\n8 GB RAM\r\nGraphics:\r\nNvidia GPU GeForce GTX 770 / AMD GPU Radeon R9 290\r\nStorage:\r\n35 GB available space', 7);

-- --------------------------------------------------------

--
-- Table structure for table `library`
--

CREATE TABLE `library` (
  `userID` int(11) NOT NULL,
  `gameID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(30) NOT NULL,
  `userType` enum('Gamer','Developer','Admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `email`, `password`, `name`, `userType`) VALUES
(1, 'test@test.com', '$2y$10$oWhZt8Iks6uoi9pwfUXPZuqUXoBfdosLrZmFzkLQvW.QWTPxwPlAi', 'Test Developer', 'Developer'),
(2, 'bethesda@test.com', '$2y$10$IwzG4VPYY.QFvHNW701/7OsY1d.Ey5O/Pp2JG3bYsV5AsgailZFyi', 'Bethesda Game Studios', 'Developer'),
(3, 'playground@test.com', '$2y$10$iSQnHmjVSZPgN46dTMzDZORGKbKZmIVK4JW7CLPrJWLjIcaMMwY2K', 'Playground Games', 'Developer'),
(4, 'guerrilla@test.com', '$2y$10$EHKx9wXb/8w2CsRNy5o0v.3Iu7noMVBuDcaoT7kdlJ8pibQKJqz3K', 'Guerrilla', 'Developer'),
(5, 'mojang@test.com', '$2y$10$JiTqypQxzdN8vO3Vqv/tjO77DXndWOWveOKWSObbOV8FmQkygm8fq', 'Mojang', 'Developer'),
(6, 'undead_labs@test.com', '$2y$10$05u/8ygiw/No9BG.3r6J9.v5z/yozR.lIzJBFGDiqhA0XhH0RNw7S', 'Undead Labs', 'Developer'),
(7, 'cd@test.com', '$2y$10$2N0X9K0T0GoO2oir0Z/Zz.KQOYmXqTjtNl2XJ1YhozW3DUKZ/9VuW', 'CD PROJEKT RED', 'Developer'),
(8, 'testuser@user.com', '$2y$10$QOSw/Uhz8qWe2zOPDHkE3OCQuKf95jRULluftZuJ9K72Esm/TKd.W', 'Test User', 'Gamer'),
(9, 'admin@admin.com', '$2y$10$8S8VR9qymLRlWU9vu6F8hO0xsq0cTWgmwuDYLRPVEcNSV1lui/jYm', 'Test Admin', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`userID`,`gameID`),
  ADD KEY `cart_ibfk_2` (`gameID`);

--
-- Indexes for table `developer`
--
ALTER TABLE `developer`
  ADD PRIMARY KEY (`developerID`,`revenue`),
  ADD UNIQUE KEY `developerID` (`developerID`);

--
-- Indexes for table `gamer`
--
ALTER TABLE `gamer`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`gameID`),
  ADD UNIQUE KEY `gameID` (`gameID`),
  ADD KEY `developerID` (`developerID`);

--
-- Indexes for table `library`
--
ALTER TABLE `library`
  ADD PRIMARY KEY (`userID`,`gameID`),
  ADD KEY `library_ibfk_2` (`gameID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `gameID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`gameID`) REFERENCES `games` (`gameID`);

--
-- Constraints for table `developer`
--
ALTER TABLE `developer`
  ADD CONSTRAINT `developer_ibfk_1` FOREIGN KEY (`developerID`) REFERENCES `user` (`userID`);

--
-- Constraints for table `gamer`
--
ALTER TABLE `gamer`
  ADD CONSTRAINT `gamer_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);

--
-- Constraints for table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_ibfk_1` FOREIGN KEY (`developerID`) REFERENCES `developer` (`developerID`);

--
-- Constraints for table `library`
--
ALTER TABLE `library`
  ADD CONSTRAINT `library_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `library_ibfk_2` FOREIGN KEY (`gameID`) REFERENCES `games` (`gameID`);
COMMIT;
