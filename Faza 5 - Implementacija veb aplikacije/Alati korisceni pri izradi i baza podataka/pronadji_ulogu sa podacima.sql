-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 10, 2021 at 07:17 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `kasting`
--

INSERT INTO `kasting` (`KorisnickoIme`, `IdKasting`, `Naziv`, `Opis`, `BrojGlumaca`, `BrojStatista`, `Kategorija`, `Status`) VALUES
('mixusmaxus', 17, 'Kasting za predstavu Ne??ista krv', 'Ne??ista krv je jedno od najpoznatijih dela srpskog pisca epohe moderne Borisava ???Bore??? Stankovi??a. Glavni lik je Sofka, poslednji potomak nekada ugledne vranjske porodice. Govore??i o njoj, Bora zapravo govori o uzdizanju, degeneraciji i ga??enju jedne porodice, o moralnom izopa??enju njenih ??lanova, nesre??i koja pada na Sofkina le??a i prenosi se na njene potomke.', 20, 0, 'Pozori??te', 'Prihvacen'),
('mixusmaxus', 18, 'Ju??ni vetar 3', 'Ju??ni vetar 3 je predstoje??i srpski film iz 2025. godine. Predstavlja nastavak filma Ju??ni Vetar iz 2021. i istoimene TV serije.', 0, 0, 'Film', 'Odbijen'),
('mixusmaxus', 19, 'Ju??ni vetar 3', 'Ju??ni vetar 3 je predstoje??i srpski film iz 2025. godine. Predstavlja nastavak filma Ju??ni Vetar iz 2021. i istoimene TV serije.', 30, 10, 'Film', 'Prihvacen'),
('mixusmaxus', 20, 'Kasting za film Titanik', 'Tema filma je romanti??na pri??a o bogatoj devojci i siroma??nom momku koji se susre??u i zaljubljuju na ???nepotopivom brodu???, dok posada broda ??uri da obori dotada??nji rekord u putovanju preko Atlantika.', 0, 40, 'Film', 'Prihvacen'),
('mixusmaxus', 23, 'Evlis Presley- King of Rock', 'Film baziran na biografiji Evlis-a Presley-a.', 10, 26, 'Film', 'Na cekanju'),
('mixusmaxus', 24, 'Supermen', 'Novi Supermen sa novom pri??om kao nikada do sad. Snimanje planirano da po??ne 2022. godine. ', 8, 32, 'Film', 'Na cekanju');

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `komentar`
--

INSERT INTO `komentar` (`IdKom`, `IdTema`, `KorisnickoIme`, `Tekst`, `Datum`) VALUES
(7, 7, 'djoxon', 'Koleginice, zaista divno napisano, zbog Vas sam dobio ??elju da pro??itam roman! :)', '2021-06-06'),
(8, 10, 'pance', 'Veoma nekorektno sa njegove strane. Da sam na tvom mestu ne bih se prijavljivala!', '2021-06-06'),
(9, 10, 'mixusmaxus', 'Postoje i drugi reditelji na ovom sajtu, slobodno pogledaj preostale oka??ene kastinge ;)', '2021-06-06');

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
('djoxon', 'lozinka123', '2000-01-14', '??or??e', 'Milinovi??', 'md180334@student.etf.bg.ac.rs'),
('mixusmaxus', 'lozinka123', '1999-11-02', 'Mihajlo', 'Nikitovi??', 'nm180164d@student.etf.bg.ac.rs'),
('pance', 'lozinka123', '1999-05-26', 'Jelena', 'Pan??evski', 'pj180123d@student.etf.bg.ac.rs'),
('petarp', 'lozinka123', '2000-02-04', 'Petar', 'Petrovic', 'petarp@gmail.com'),
('viktorv', 'lozinka123', '1999-03-06', 'Viktor', 'Viktoric', 'viktorv@gmail.com'),
('visnja', 'lozinka123', '1999-04-21', 'Aleksa', 'Vi??nji??', 'va180341d@student.etf.bg.ac.rs');

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

--
-- Dumping data for table `monolog`
--

INSERT INTO `monolog` (`IdSadrzaj`, `Autor`, `Delo`, `Vrsta`) VALUES
(73, 'Vilijem Sekspir', 'Hamlet', 'Drama');

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
('Cherry', 'Lana Del Rey', 69, 'Lirika'),
('New Song', 'Maneskin', 72, 'Epika');

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
('pance', 17, 'Na cekanju'),
('visnja', 17, 'Na cekanju');

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
('mixusmaxus', 'Prihvacen'),
('petarp', 'Na cekanju'),
('viktorv', 'Na cekanju');

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
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sadrzaj`
--

INSERT INTO `sadrzaj` (`IdSadrzaj`, `KorisnickoIme`) VALUES
(69, 'pance'),
(72, 'pance'),
(73, 'visnja');

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tema`
--

INSERT INTO `tema` (`IdTema`, `Naslov`, `KorisnickoIme`, `KratakOpis`, `Tekst`, `Datum`) VALUES
(7, 'Knez Mi??kin oli??enje dobrote', 'pance', 'Esej o romanu \"Idiot\" Fjodora Dostojevskog', 'Idiot,re?? gr??kog porekla,izvorno je opisivala privatnika,??oveka koji se nije interesovao u javne poslove.Danas ta re?? ima posve drugo, veoma pogrdno zna??enje.\r\n\r\n??itaju??i dela naro??ito ruske knji??evnosti,primetno je da je oduvek postojala bojazan od mi??ljenja dru??tva.\r\nPored raznih tema kojih se doti??e Dostojevski u svom romanu \"Idiot\",jedna od njih upravo i jeste ??ovekova te??nja da bude prihva??en u dru??tvu.\r\nNastasja Filipovna,inteligentna ??ena izuzetne \r\nlepote,??ele??i da se osveti dru??tvu koje ju je odbacilo zbog \"sramote\" koja ju je zadesila, po??inje da gubi razum.Ona samu sebe ube??uje u to da je gre??na.Patnja je pro??ima,a kako vreme prolazi ona sve vi??e pada u bezumlje.\r\nS druge strane tu je glavni lik romana knez Mi??kin.Premda je imao zdravstvenih problema,on predstavlja smisao ??ove??nosti.\r\nSiroma??ni vitez,kako je posredno opisan u romanu,bio je oli??enje iskrenosti,otvorenosti,dobrote i prostodu??nosti.\r\nIako su ga ljudi mahom voleli, oni nisu mogli da razumeju njegov neiskvaren na??in razmi??ljanja i pona??anja pa su to pripisivali njegovom mentalnom stanju.\r\nKako vreme prolazi,??italac uvi??a da zapravo problem ne le??i u samom \"idiotu\" ve?? u pojedincima koji ga okru??uju. Kao da gleda pozori??ni komad u kojem se svi akteri osim glavnog bore s svojim unutra??njim problemima a pritom preispituju mentalno stanje glavnog aktera. \r\nKnez Mi??kin za razliku od drugih u stanju je da pra??ta.On ose??a bol Nastasje Filipovne koja ga pora??ava.Nikoga ne osu??uje pa ??ak ni  Rogo??ina,??oveka koji je iz ljubomore potegnuo no?? na njega.Druge stavlja ispred sebe i te??i da pomogne svakome.Uprkos tome ??to je zaljubljen u Aglaju Ivanovnu,on odlu??uje da se ven??a za Nastasju Filipovnu jer smatra da je njoj potrebniji.\r\nI pored toga ??to knez Mi??kin nije razmi??ljao o tome da li ??e biti prihva??en u dru??tvu niti mu je bilo do toga stalo, samo dru??tvo presudno je uticalo na njegovo zdravlje.\r\nPoput neiskvarenog deteta on dolazi iz ??vajcarske u Rusiju dok se po zavr??etku povesti  vra??a u gorem  zdravstvenom stanju nego ikad. \r\nNaizgled idili??no ali zapravo mra??no petrogradsko dru??tvo I neda??e ljudi uticale su na kneza da potpuno izgubi razum.On se ??rtvovao u  ??elji da oplemeni ljude i pomogne im da re??e svoje probleme. \r\nPitanje je da li je zaista neophodno da se ??ovek uklopi u uske kalupe dru??tva I bude prihva??en. Koliko je zapravo to dru??tvo idealno i da li je vredno menjati sebe radi op??te prihvatljivosti?\r\n\r\nOno ??to mo??emo sa sigurno????u re??i jeste da kada bi svaka osoba na svetu posedovala bar jedan atom Lava Nikolajevi??a Mi??kina,svet bi zasigurno bio plemenitije i lep??e mesto za ??ivot, jer kao ??to je i sam knez rekao \"lepota ??e spasiti svet\".', '2021-05-31'),
(10, 'Reziser nije platio honorare', 'visnja', 'polemika oko filma ,,12 Ljutih gusara??????', 'Pre 10 dana pu??ten je u promet film ,,12 Ljutih gusara?????? u re??iji Nikole Nikoli??a. Film je za veoma kratko vreme pogledao veliki broj ljudi, bioskopske sale su pune, karte je veoma te??ko na??i usled popularnosti ovog filma. Pre neki dan sam i sam oti??ao da ga pogledam i veoma mi se svideo. Radnja, muzika, glumci, efekti ??? sve je savr??eno na mestu. Me??utim, doznah od nekih svojih prijatelja da veliki broj glumaca i dalje nije pla??eno za svoje uloge i da re??iseru filma ne pada na pamet da ih isplati, ve?? da je on jedan veliki ,,prevarant??????. S??? obzirom na to da je objavio nekoliko kastinga na ovom sajtu, i da sam i sam razmi??ljao da se prijavim za neke od njih, zanima me da li mo??da neko zna ne??to vi??e o tome?', '2021-06-06');

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
