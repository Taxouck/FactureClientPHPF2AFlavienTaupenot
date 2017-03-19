-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2017 at 11:03 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mdpdtb`
--

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `NumClient` int(6) NOT NULL,
  `NomClient` tinytext COLLATE utf8_bin NOT NULL,
  `PrenomClient` tinytext COLLATE utf8_bin,
  `AdresseClient` tinytext COLLATE utf8_bin NOT NULL,
  `VilleClient` tinytext COLLATE utf8_bin NOT NULL,
  `CodePostalClient` int(5) NOT NULL,
  `PaysClient` tinytext COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`NumClient`, `NomClient`, `PrenomClient`, `AdresseClient`, `VilleClient`, `CodePostalClient`, `PaysClient`) VALUES
(100042, 'Smith', 'Jules', 'rue du grand dÃ©dÃ©', 'Bruxelles', 52555, 'Belgique'),
(100689, 'Taupenot', 'Flavien', '2406 Kleber', 'Strasbourg', 67000, 'France'),
(100723, 'Mouilleron', 'Martin', '5 avenue Foch', 'Saint Martin', 89000, 'France');

-- --------------------------------------------------------

--
-- Table structure for table `detailfacture`
--

CREATE TABLE `detailfacture` (
  `NumFacture` int(10) NOT NULL,
  `CodeProduit` int(6) NOT NULL,
  `QProduit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `detailfacture`
--

INSERT INTO `detailfacture` (`NumFacture`, `CodeProduit`, `QProduit`) VALUES
(100069, 100004, 84654),
(100333, 100001, 100),
(100333, 100003, 65),
(100654, 100001, 18);

-- --------------------------------------------------------

--
-- Table structure for table `facture`
--

CREATE TABLE `facture` (
  `NumFacture` int(10) NOT NULL,
  `NumClient` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `facture`
--

INSERT INTO `facture` (`NumFacture`, `NumClient`) VALUES
(100069, 100042),
(100333, 100723),
(100654, 100723);

-- --------------------------------------------------------

--
-- Table structure for table `produits`
--

CREATE TABLE `produits` (
  `CodeProduit` int(6) NOT NULL,
  `NomProduit` tinytext COLLATE utf8_bin NOT NULL,
  `DescProduit` text COLLATE utf8_bin,
  `PrixUTT` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `produits`
--

INSERT INTO `produits` (`CodeProduit`, `NomProduit`, `DescProduit`, `PrixUTT`) VALUES
(100001, 'Produit1', NULL, '300'),
(100002, 'Produit2', NULL, '560'),
(100003, 'Produit3', NULL, '25'),
(100004, 'Produit4', NULL, '897982');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserName` char(30) COLLATE utf8_bin NOT NULL,
  `Password` char(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserName`, `Password`) VALUES
('taxouck', '$2y$10$JGVyczc4ISF6ZW9wbXM5ZeUu2IMn0/KUesQhNd3xDmJw3c6pyYOGi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`NumClient`);

--
-- Indexes for table `detailfacture`
--
ALTER TABLE `detailfacture`
  ADD PRIMARY KEY (`NumFacture`,`CodeProduit`),
  ADD KEY `CodeProduit` (`CodeProduit`);

--
-- Indexes for table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`NumFacture`),
  ADD KEY `NumClient` (`NumClient`);

--
-- Indexes for table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`CodeProduit`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserName`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detailfacture`
--
ALTER TABLE `detailfacture`
  ADD CONSTRAINT `detailfacture_ibfk_1` FOREIGN KEY (`NumFacture`) REFERENCES `facture` (`NumFacture`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detailfacture_ibfk_2` FOREIGN KEY (`CodeProduit`) REFERENCES `produits` (`CodeProduit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `facture_ibfk_1` FOREIGN KEY (`NumClient`) REFERENCES `client` (`NumClient`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
