-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2024 at 06:30 PM
-- Server version: 8.0.36
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projekt`
--

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id` int NOT NULL,
  `ime` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_croatian_ci NOT NULL,
  `prezime` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_croatian_ci NOT NULL,
  `korisnicko_ime` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_croatian_ci NOT NULL,
  `lozinka` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_croatian_ci NOT NULL,
  `razina` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `ime`, `prezime`, `korisnicko_ime`, `lozinka`, `razina`) VALUES
(7, 'admin', 'admin', 'admin', '$2y$10$lxQKGGwjtRX6aGOya.C/PuEDxhfuJZNF2m9/jqAIB9sEHtql6yFqi', 1),
(8, 'user', 'user', 'user', '$2y$10$tJ.tPGauj/WNNjKSjEGdk.khKlz9X2ZgnMaTYI6p1dLQbZRu7g7vm', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vijesti`
--

CREATE TABLE `vijesti` (
  `id` int NOT NULL,
  `datum` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_croatian_ci NOT NULL,
  `naslov` varchar(64) CHARACTER SET latin2 COLLATE latin2_croatian_ci NOT NULL,
  `sazetak` text CHARACTER SET latin2 COLLATE latin2_croatian_ci NOT NULL,
  `tekst` text CHARACTER SET latin2 COLLATE latin2_croatian_ci NOT NULL,
  `slika` varchar(64) CHARACTER SET latin2 COLLATE latin2_croatian_ci NOT NULL,
  `kategorija` varchar(64) CHARACTER SET latin2 COLLATE latin2_croatian_ci NOT NULL,
  `arhiva` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `vijesti`
--

INSERT INTO `vijesti` (`id`, `datum`, `naslov`, `sazetak`, `tekst`, `slika`, `kategorija`, `arhiva`) VALUES
(24, '12.06.2024.', 'General election', 'A Tory social media campaign suggests the party fears a Labour landslide in the upcoming \r\n', 'The Conservatives latest advertising campaign appears to target potential Reform voters, warning them that the Tories could be reduced to just 57 seats in the next parliament, even if Reform picked up no seats.', 'img/election.jpg', 'us', 0),
(25, '12.06.2024.', 'Greece: Athens ', 'An excessive heat warning has been issued by Greeces weather service from Wednesday morning ', 'Temperatures were tipped to hit highs up 43C (109F) on Wednesday and Thursday in parts of the Mediterranean country.\r\n\r\nMeteorologists say the high temperatures is being driven by southerly winds bringing hot air and dust from North Africa.\r\n\r\nAs a result, the Acropolis, the archaeological site which saw four million visitors last year, was closed between 9am and 2pm (GMT) on Wednesday over the life-threatening temperatures.', 'img/greece.jpg', 'world', 0),
(31, '12.06.2024.', 'Pope Francis accusedd', 'The Pope reportedly used a derogatory term about gay men', 'According to ANSA news agency, the Pope repeated the term on Tuesday while meeting Roman priests, saying there is an air of', 'img/skynews-pope-francis-vatican_6579361.jpg', 'world', 0),
(32, '12.06.2024.', 'Elon Musk faces fressh insider', 'Fresh from his threat to ban Apple devices at his companies if th', 'Elon Musk has moved to drop a lawsuit he filed against ChatGPT maker OpenAI and learned he is facing a fresh investor claim relating to his sale of Tesla shares.', 'img/musk.jpg', 'us', 0),
(36, '12.06.2024.', 'Anne test', 'Anne Sacoolas said she', 'The US State Department employee told Northamptonshire Police in ', 'img/e7abd7768398c87eae6782ed8aac88e2.png', 'us', 0),
(37, '12.06.2024.', 'Ferrari', 'Lorem ipsum dorem Lorem ipsum dorem Lorem ipsum dorem Lorem ipsum dorem Lorem ipsum dorem ', 'Lorem ipsum dorem Lorem ipsum dorem Lorem ipsum dorem Lorem ipsum dorem Lorem ipsum dorem ', 'img/sadd.jpg', 'us', 0),
(41, '12.06.2024.', 'testna v', 'fsdad', 'sfasdad', 'img/1716b0eb0c12e6d833649d67822cee13.jpg', 'us', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `korisnicko_ime` (`korisnicko_ime`);

--
-- Indexes for table `vijesti`
--
ALTER TABLE `vijesti`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `vijesti`
--
ALTER TABLE `vijesti`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
