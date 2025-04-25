-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2024 at 03:00 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `kurssikirjautumiset`
--

CREATE TABLE `kurssikirjautumiset` (
  `id` int(11) NOT NULL,
  `opiskelija_id` int(11) NOT NULL,
  `kurssi_id` int(11) NOT NULL,
  `kirjautumispaiva` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kurssikirjautumiset`
--

INSERT INTO `kurssikirjautumiset` (`id`, `opiskelija_id`, `kurssi_id`, `kirjautumispaiva`) VALUES
(1, 1, 1, '2024-01-01 10:00:00'),
(2, 2, 2, '2024-01-01 11:00:00'),
(3, 3, 3, '2024-01-01 12:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `kurssit`
--

CREATE TABLE `kurssit` (
  `id` int(11) NOT NULL,
  `tunnus` varchar(10) NOT NULL,
  `nimi` varchar(100) NOT NULL,
  `kuvaus` text DEFAULT NULL,
  `alkupaiva` date NOT NULL,
  `loppupaiva` date NOT NULL,
  `opettaja_id` int(11) NOT NULL,
  `tila_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kurssit`
--

INSERT INTO `kurssit` (`id`, `tunnus`, `nimi`, `kuvaus`, `alkupaiva`, `loppupaiva`, `opettaja_id`, `tila_id`) VALUES
(1, 'KURS001', 'Kemian perusteet', 'Peruskurssi Kemiasta', '2024-02-15', '2024-05-30', 1, 1),
(2, 'KURS002', 'Historian perusteet', 'Peruskurssi Historiasta', '2024-02-15', '2024-05-25', 2, 2),
(3, 'KURS003', 'Ohjelmointi 1', 'Ohjelmoinnin perusteet', '2024-02-15', '2024-05-27', 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `opettajat`
--

CREATE TABLE `opettajat` (
  `id` int(11) NOT NULL,
  `tunnusnumero` varchar(10) NOT NULL,
  `etunimi` varchar(50) NOT NULL,
  `sukunimi` varchar(50) NOT NULL,
  `aine` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `opettajat`
--

INSERT INTO `opettajat` (`id`, `tunnusnumero`, `etunimi`, `sukunimi`, `aine`) VALUES
(1, 'OPE001', 'Julia', 'Ahokas', 'Kemia'),
(2, 'OPE002', 'Markus', 'Järvinen', 'Historia'),
(3, 'OPE003', 'Maria', 'Toivo', 'Ohjelmointi');

-- --------------------------------------------------------

--
-- Table structure for table `opiskelijat`
--

CREATE TABLE `opiskelijat` (
  `id` int(11) NOT NULL,
  `opiskelijanumero` varchar(10) NOT NULL,
  `etunimi` varchar(50) NOT NULL,
  `sukunimi` varchar(50) NOT NULL,
  `syntymapaiva` date NOT NULL,
  `vuosikurssi` int(11) NOT NULL CHECK (`vuosikurssi` between 1 and 3)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `opiskelijat`
--

INSERT INTO `opiskelijat` (`id`, `opiskelijanumero`, `etunimi`, `sukunimi`, `syntymapaiva`, `vuosikurssi`) VALUES
(1, 'OPI001', 'Kimi', 'Räikkönen', '2000-01-01', 1),
(2, 'OPI002', 'Simo', 'Pertti', '1998-05-15', 2),
(3, 'OPI003', 'Hirvea', 'Henri', '2001-03-20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tilat`
--

CREATE TABLE `tilat` (
  `id` int(11) NOT NULL,
  `tunnus` varchar(10) NOT NULL,
  `nimi` varchar(100) NOT NULL,
  `kapasiteetti` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tilat`
--

INSERT INTO `tilat` (`id`, `tunnus`, `nimi`, `kapasiteetti`) VALUES
(1, 'TILA101', 'Luokka 101', 30),
(2, 'TILA102', 'Luokka 102', 25),
(3, 'TILA103', 'ATK-luokka', 20);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kurssikirjautumiset`
--
ALTER TABLE `kurssikirjautumiset`
  ADD PRIMARY KEY (`id`),
  ADD KEY `opiskelija_id` (`opiskelija_id`),
  ADD KEY `kurssi_id` (`kurssi_id`);

--
-- Indexes for table `kurssit`
--
ALTER TABLE `kurssit`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tunnus` (`tunnus`),
  ADD KEY `opettaja_id` (`opettaja_id`),
  ADD KEY `tila_id` (`tila_id`);

--
-- Indexes for table `opettajat`
--
ALTER TABLE `opettajat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tunnusnumero` (`tunnusnumero`);

--
-- Indexes for table `opiskelijat`
--
ALTER TABLE `opiskelijat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `opiskelijanumero` (`opiskelijanumero`);

--
-- Indexes for table `tilat`
--
ALTER TABLE `tilat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tunnus` (`tunnus`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kurssikirjautumiset`
--
ALTER TABLE `kurssikirjautumiset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kurssit`
--
ALTER TABLE `kurssit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `opettajat`
--
ALTER TABLE `opettajat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `opiskelijat`
--
ALTER TABLE `opiskelijat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tilat`
--
ALTER TABLE `tilat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kurssikirjautumiset`
--
ALTER TABLE `kurssikirjautumiset`
  ADD CONSTRAINT `kurssikirjautumiset_ibfk_1` FOREIGN KEY (`opiskelija_id`) REFERENCES `opiskelijat` (`id`),
  ADD CONSTRAINT `kurssikirjautumiset_ibfk_2` FOREIGN KEY (`kurssi_id`) REFERENCES `kurssit` (`id`);

--
-- Constraints for table `kurssit`
--
ALTER TABLE `kurssit`
  ADD CONSTRAINT `kurssit_ibfk_1` FOREIGN KEY (`opettaja_id`) REFERENCES `opettajat` (`id`),
  ADD CONSTRAINT `kurssit_ibfk_2` FOREIGN KEY (`tila_id`) REFERENCES `tilat` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
