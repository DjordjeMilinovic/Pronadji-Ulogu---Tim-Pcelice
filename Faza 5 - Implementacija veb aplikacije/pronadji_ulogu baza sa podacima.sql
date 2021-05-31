-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 31, 2021 at 02:13 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pronadji_ulogu`
--
CREATE DATABASE IF NOT EXISTS `pronadji_ulogu` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `pronadji_ulogu`;

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

DROP TABLE IF EXISTS `administrator`;
CREATE TABLE IF NOT EXISTS `administrator` (
  `KorisnickoIme` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`KorisnickoIme`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`KorisnickoIme`) VALUES
('djoxon');

-- --------------------------------------------------------

--
-- Table structure for table `kasting`
--

DROP TABLE IF EXISTS `kasting`;
CREATE TABLE IF NOT EXISTS `kasting` (
  `KorisnickoIme` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `IdKasting` int(11) NOT NULL AUTO_INCREMENT,
  `Naziv` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `Opis` text COLLATE utf8_unicode_ci NOT NULL,
  `BrojGlumaca` int(11) NOT NULL,
  `BrojStatista` int(11) NOT NULL,
  `Kategorija` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Na cekanju',
  PRIMARY KEY (`IdKasting`),
  KEY `KorisnickoIme` (`KorisnickoIme`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `kasting`
--

INSERT INTO `kasting` (`KorisnickoIme`, `IdKasting`, `Naziv`, `Opis`, `BrojGlumaca`, `BrojStatista`, `Kategorija`, `Status`) VALUES
('mixusmaxus', 17, 'Kasting za predstavu Nečista krv', 'Nečista krv je jedno od najpoznatijih dela srpskog pisca epohe moderne Borisava „Bore“ Stankovića. Glavni lik je Sofka, poslednji potomak nekada ugledne vranjske porodice. Govoreći o njoj, Bora zapravo govori o uzdizanju, degeneraciji i gašenju jedne porodice, o moralnom izopačenju njenih članova, nesreći koja pada na Sofkina leđa i prenosi se na njene potomke.', 20, 0, 'Pozorište', 'Prihvacen'),
('mixusmaxus', 18, 'Južni vetar 3', 'Južni vetar 3 je predstojeći srpski film iz 2025. godine. Predstavlja nastavak filma Južni Vetar iz 2021. i istoimene TV serije.', 0, 0, 'Film', 'Odbijen'),
('mixusmaxus', 19, 'Južni vetar 3', 'Južni vetar 3 je predstojeći srpski film iz 2025. godine. Predstavlja nastavak filma Južni Vetar iz 2021. i istoimene TV serije.', 30, 10, 'Film', 'Prihvacen'),
('mixusmaxus', 20, 'Kasting za film Titanik', 'Tema filma je romantična priča o bogatoj devojci i siromašnom momku koji se susreću i zaljubljuju na „nepotopivom brodu“, dok posada broda žuri da obori dotadašnji rekord u putovanju preko Atlantika.', 0, 40, 'Film', 'Prihvacen');

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

DROP TABLE IF EXISTS `komentar`;
CREATE TABLE IF NOT EXISTS `komentar` (
  `IdKom` int(11) NOT NULL AUTO_INCREMENT,
  `IdTema` int(11) NOT NULL,
  `KorisnickoIme` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Tekst` text COLLATE utf8_unicode_ci NOT NULL,
  `Datum` date NOT NULL,
  PRIMARY KEY (`IdKom`),
  KEY `IdTema` (`IdTema`),
  KEY `KorisnickoIme` (`KorisnickoIme`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

DROP TABLE IF EXISTS `korisnik`;
CREATE TABLE IF NOT EXISTS `korisnik` (
  `KorisnickoIme` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Lozinka` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `DatumRodjenja` date NOT NULL,
  `Ime` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Prezime` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`KorisnickoIme`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`KorisnickoIme`, `Lozinka`, `DatumRodjenja`, `Ime`, `Prezime`, `Email`) VALUES
('djoxon', '123', '2000-01-14', 'Đorđe', 'Milinović', 'md180334@student.etf.bg.ac.rs'),
('mixusmaxus', '123', '1999-11-02', 'Mihajlo', 'Nikitović', 'nm180164d@student.etf.bg.ac.rs'),
('pance', '123', '1999-05-26', 'Jelena', 'Pančevski', 'pj180123d@student.etf.bg.ac.rs'),
('visnja', '123', '1999-04-21', 'Aleksa', 'Višnjić', 'va180341d@student.etf.bg.ac.rs');

-- --------------------------------------------------------

--
-- Table structure for table `monolog`
--

DROP TABLE IF EXISTS `monolog`;
CREATE TABLE IF NOT EXISTS `monolog` (
  `IdSadrzaj` int(11) NOT NULL,
  `Autor` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Delo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Vrsta` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`IdSadrzaj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesma`
--

DROP TABLE IF EXISTS `pesma`;
CREATE TABLE IF NOT EXISTS `pesma` (
  `Naziv` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Autor` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `IdSadrzaj` int(11) NOT NULL,
  `Vrsta` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`IdSadrzaj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pesma`
--

INSERT INTO `pesma` (`Naziv`, `Autor`, `IdSadrzaj`, `Vrsta`) VALUES
('Cherry', 'LanaDel Rey', 69, 'Lirika');

-- --------------------------------------------------------

--
-- Table structure for table `prijava`
--

DROP TABLE IF EXISTS `prijava`;
CREATE TABLE IF NOT EXISTS `prijava` (
  `KorisnickoIme` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `IdKasting` int(11) NOT NULL,
  `Status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Na cekanju',
  PRIMARY KEY (`KorisnickoIme`,`IdKasting`),
  KEY `IdKasting` (`IdKasting`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `prijava`
--

INSERT INTO `prijava` (`KorisnickoIme`, `IdKasting`, `Status`) VALUES
('pance', 17, 'Na cekanju');

-- --------------------------------------------------------

--
-- Table structure for table `reditelj`
--

DROP TABLE IF EXISTS `reditelj`;
CREATE TABLE IF NOT EXISTS `reditelj` (
  `KorisnickoIme` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Na cekanju',
  PRIMARY KEY (`KorisnickoIme`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `reditelj`
--

INSERT INTO `reditelj` (`KorisnickoIme`, `Status`) VALUES
('mixusmaxus', 'Prihvacen');

-- --------------------------------------------------------

--
-- Table structure for table `registrovanikorisnik`
--

DROP TABLE IF EXISTS `registrovanikorisnik`;
CREATE TABLE IF NOT EXISTS `registrovanikorisnik` (
  `KorisnickoIme` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`KorisnickoIme`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `registrovanikorisnik`
--

INSERT INTO `registrovanikorisnik` (`KorisnickoIme`) VALUES
('pance'),
('visnja');

-- --------------------------------------------------------

--
-- Table structure for table `sadrzaj`
--

DROP TABLE IF EXISTS `sadrzaj`;
CREATE TABLE IF NOT EXISTS `sadrzaj` (
  `IdSadrzaj` int(11) NOT NULL AUTO_INCREMENT,
  `KorisnickoIme` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`IdSadrzaj`),
  KEY `KorisnickoIme` (`KorisnickoIme`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sadrzaj`
--

INSERT INTO `sadrzaj` (`IdSadrzaj`, `KorisnickoIme`) VALUES
(69, 'pance');

-- --------------------------------------------------------

--
-- Table structure for table `tema`
--

DROP TABLE IF EXISTS `tema`;
CREATE TABLE IF NOT EXISTS `tema` (
  `IdTema` int(11) NOT NULL AUTO_INCREMENT,
  `Naslov` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `KorisnickoIme` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `KratakOpis` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `Tekst` text COLLATE utf8_unicode_ci NOT NULL,
  `Datum` date NOT NULL,
  PRIMARY KEY (`IdTema`),
  KEY `KorisnickoIme` (`KorisnickoIme`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tema`
--

INSERT INTO `tema` (`IdTema`, `Naslov`, `KorisnickoIme`, `KratakOpis`, `Tekst`, `Datum`) VALUES
(7, 'Knez Miškin oličenje dobrote', 'pance', 'Esej o romanu \"Idiot\" Fjodora Dostojevskog', 'Idiot,reč grčkog porekla,izvorno je opisivala privatnika,čoveka koji se nije interesovao u javne poslove.Danas ta reč ima posve drugo, veoma pogrdno značenje.\r\n\r\nČitajući dela naročito ruske književnosti,primetno je da je oduvek postojala bojazan od mišljenja društva.\r\nPored raznih tema kojih se dotiče Dostojevski u svom romanu \"Idiot\",jedna od njih upravo i jeste čovekova težnja da bude prihvaćen u društvu.\r\nNastasja Filipovna,inteligentna žena izuzetne \r\nlepote,želeći da se osveti društvu koje ju je odbacilo zbog \"sramote\" koja ju je zadesila, počinje da gubi razum.Ona samu sebe ubeđuje u to da je grešna.Patnja je prožima,a kako vreme prolazi ona sve više pada u bezumlje.\r\nS druge strane tu je glavni lik romana knez Miškin.Premda je imao zdravstvenih problema,on predstavlja smisao čovečnosti.\r\nSiromašni vitez,kako je posredno opisan u romanu,bio je oličenje iskrenosti,otvorenosti,dobrote i prostodušnosti.\r\nIako su ga ljudi mahom voleli, oni nisu mogli da razumeju njegov neiskvaren način razmišljanja i ponašanja pa su to pripisivali njegovom mentalnom stanju.\r\nKako vreme prolazi,čitalac uviđa da zapravo problem ne leži u samom \"idiotu\" već u pojedincima koji ga okružuju. Kao da gleda pozorišni komad u kojem se svi akteri osim glavnog bore s svojim unutrašnjim problemima a pritom preispituju mentalno stanje glavnog aktera. \r\nKnez Miškin za razliku od drugih u stanju je da prašta.On oseća bol Nastasje Filipovne koja ga poražava.Nikoga ne osuđuje pa čak ni  Rogožina,čoveka koji je iz ljubomore potegnuo nož na njega.Druge stavlja ispred sebe i teži da pomogne svakome.Uprkos tome što je zaljubljen u Aglaju Ivanovnu,on odlučuje da se venča za Nastasju Filipovnu jer smatra da je njoj potrebniji.\r\nI pored toga što knez Miškin nije razmišljao o tome da li će biti prihvaćen u društvu niti mu je bilo do toga stalo, samo društvo presudno je uticalo na njegovo zdravlje.\r\nPoput neiskvarenog deteta on dolazi iz Švajcarske u Rusiju dok se po završetku povesti  vraća u gorem  zdravstvenom stanju nego ikad. \r\nNaizgled idilično ali zapravo mračno petrogradsko društvo I nedaće ljudi uticale su na kneza da potpuno izgubi razum.On se žrtvovao u  želji da oplemeni ljude i pomogne im da reše svoje probleme. \r\nPitanje je da li je zaista neophodno da se čovek uklopi u uske kalupe društva I bude prihvaćen. Koliko je zapravo to društvo idealno i da li je vredno menjati sebe radi opšte prihvatljivosti?\r\n\r\nOno što možemo sa sigurnošću reći jeste da kada bi svaka osoba na svetu posedovala bar jedan atom Lava Nikolajeviča Miškina,svet bi zasigurno bio plemenitije i lepše mesto za život, jer kao što je i sam knez rekao \"lepota će spasiti svet\".', '2021-05-31');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrator`
--
ALTER TABLE `administrator`
  ADD CONSTRAINT `administrator_ibfk_1` FOREIGN KEY (`KorisnickoIme`) REFERENCES `korisnik` (`KorisnickoIme`) ON DELETE CASCADE;

--
-- Constraints for table `kasting`
--
ALTER TABLE `kasting`
  ADD CONSTRAINT `kasting_ibfk_1` FOREIGN KEY (`KorisnickoIme`) REFERENCES `reditelj` (`KorisnickoIme`) ON DELETE CASCADE;

--
-- Constraints for table `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `komentar_ibfk_1` FOREIGN KEY (`IdTema`) REFERENCES `tema` (`IdTema`),
  ADD CONSTRAINT `komentar_ibfk_2` FOREIGN KEY (`KorisnickoIme`) REFERENCES `korisnik` (`KorisnickoIme`) ON DELETE CASCADE;

--
-- Constraints for table `monolog`
--
ALTER TABLE `monolog`
  ADD CONSTRAINT `monolog_ibfk_1` FOREIGN KEY (`IdSadrzaj`) REFERENCES `sadrzaj` (`IdSadrzaj`) ON DELETE CASCADE;

--
-- Constraints for table `pesma`
--
ALTER TABLE `pesma`
  ADD CONSTRAINT `pesma_ibfk_1` FOREIGN KEY (`IdSadrzaj`) REFERENCES `sadrzaj` (`IdSadrzaj`) ON DELETE CASCADE;

--
-- Constraints for table `prijava`
--
ALTER TABLE `prijava`
  ADD CONSTRAINT `prijava_ibfk_1` FOREIGN KEY (`KorisnickoIme`) REFERENCES `registrovanikorisnik` (`KorisnickoIme`) ON DELETE CASCADE,
  ADD CONSTRAINT `prijava_ibfk_2` FOREIGN KEY (`IdKasting`) REFERENCES `kasting` (`IdKasting`) ON DELETE CASCADE;

--
-- Constraints for table `reditelj`
--
ALTER TABLE `reditelj`
  ADD CONSTRAINT `reditelj_ibfk_1` FOREIGN KEY (`KorisnickoIme`) REFERENCES `korisnik` (`KorisnickoIme`) ON DELETE CASCADE;

--
-- Constraints for table `registrovanikorisnik`
--
ALTER TABLE `registrovanikorisnik`
  ADD CONSTRAINT `registrovanikorisnik_ibfk_1` FOREIGN KEY (`KorisnickoIme`) REFERENCES `korisnik` (`KorisnickoIme`);

--
-- Constraints for table `sadrzaj`
--
ALTER TABLE `sadrzaj`
  ADD CONSTRAINT `sadrzaj_ibfk_1` FOREIGN KEY (`KorisnickoIme`) REFERENCES `registrovanikorisnik` (`KorisnickoIme`) ON DELETE CASCADE;

--
-- Constraints for table `tema`
--
ALTER TABLE `tema`
  ADD CONSTRAINT `tema_ibfk_1` FOREIGN KEY (`KorisnickoIme`) REFERENCES `korisnik` (`KorisnickoIme`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
