-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2015 at 01:44 PM
-- Server version: 5.5.43-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `etxebizitzak`
--

-- --------------------------------------------------------

--
-- Table structure for table `erabiltzaileak`
--

CREATE TABLE IF NOT EXISTS `erabiltzaileak` (
  `id` int(11) NOT NULL,
  `izena` varchar(50) DEFAULT NULL,
  `pasahitza` varchar(10) DEFAULT NULL,
  `telefonoa` varchar(9) DEFAULT NULL,
  `helbidea` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `erabiltzaileak`
--

INSERT INTO `erabiltzaileak` (`id`, `izena`, `pasahitza`, `telefonoa`, `helbidea`) VALUES
(1, 'j@j.eus', 'jj', '9090909', 'zubitxo kalea'),
(2, 'a@a.eus', 'aa', '22', ''),
(3, 'k@k.eus', 'kk', '8888', ''),
(4, 'o@o.eus', 'oo', '9999', '');

-- --------------------------------------------------------

--
-- Table structure for table `etxebizitzak`
--

CREATE TABLE IF NOT EXISTS `etxebizitzak` (
  `id` int(11) NOT NULL,
  `titulua` varchar(50) DEFAULT NULL,
  `deskribapena` varchar(100) DEFAULT NULL,
  `kategoria` varchar(50) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `argazkia` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `etxebizitzak`
--

INSERT INTO `etxebizitzak` (`id`, `titulua`, `deskribapena`, `kategoria`, `data`, `argazkia`) VALUES
(1, 'Kosta Ballena-n promozioa.', 'Golf inguruan, kalitate handikoak, lorategiaz inguratuta eta igerilekuarekin.\nZaintza zorrotza.', 'Kostaldea.', '2015-11-30', 'etxea1'),
(2, 'Juduen auzoan etxe berritua.', 'Bi solairu eta ganbara, 5 logela eta garaje handia. Kale lasaian kokatuta eta erdigunetik oso gertu.', 'Eskaintza.', '2015-11-30', 'etxea2'),
(3, 'Apartamentuak Jaizkibel begira.', 'Getariako hondartzan, lehenengo lerroan. Etxebizitzaberristuak eta erabat altzairuz hornituta.', 'Kostaldea.', '2015-11-30', 'etxea3'),
(4, 'Promozio berria Oiartzunen.', '1 eta 2 logelako apartamentuak, bista ederrak. Finantziazio baldintzak ezin hobeak.', 'Promozioa.', '2015-12-02', 'etxea4'),
(5, 'eee', 'eee', 'eee', '2015-02-12', 'etxea5'),
(6, 'rrr', 'eee', 'eee', '2016-01-02', '');

-- --------------------------------------------------------

--
-- Table structure for table `inkesta`
--

CREATE TABLE IF NOT EXISTS `inkesta` (
  `id` int(11) NOT NULL,
  `izena` varchar(50) NOT NULL,
  `Erantzuna` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inkesta`
--

INSERT INTO `inkesta` (`id`, `izena`, `Erantzuna`) VALUES
(1, 'j@j.eus', 1),
(2, 'a@a.eus', 0);
