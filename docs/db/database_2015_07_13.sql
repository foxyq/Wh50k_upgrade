-- phpMyAdmin SQL Dump
-- version 4.2.0
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vytvořeno: Pon 13. čec 2015, 15:04
-- Verze serveru: 5.6.24
-- Verze PHP: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `database`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `dodavatelia`
--

CREATE TABLE IF NOT EXISTS `dodavatelia` (
`dodavatelia_id` mediumint(8) unsigned NOT NULL,
  `meno` varchar(45) DEFAULT NULL,
  `nazov_spolocnosti` varchar(45) DEFAULT NULL,
  `ico` varchar(10) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Vypisuji data pro tabulku `dodavatelia`
--

INSERT INTO `dodavatelia` (`dodavatelia_id`, `meno`, `nazov_spolocnosti`, `ico`) VALUES
(1, 'UNIFORST', 'Alfa', '666'),
(2, 'PRENO', 'Beta', '777'),
(3, 'D&L', 'Cetta', '888');

-- --------------------------------------------------------

--
-- Struktura tabulky `doklady_typy`
--

CREATE TABLE IF NOT EXISTS `doklady_typy` (
`doklady_typy_id` tinyint(3) unsigned NOT NULL,
  `kod` varchar(5) DEFAULT NULL,
  `nazov` varchar(45) DEFAULT NULL,
  `popis` mediumtext
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Vypisuji data pro tabulku `doklady_typy`
--

INSERT INTO `doklady_typy` (`doklady_typy_id`, `kod`, `nazov`, `popis`) VALUES
(1, 'VL', 'vážny lístok', 'vážny lístok nesie informácie o skutočnom pohybe materiálu'),
(2, 'DL', 'dodací list', 'potvrdenie o dodávke a jej obsahu');

-- --------------------------------------------------------

--
-- Struktura tabulky `materialy_druhy`
--

CREATE TABLE IF NOT EXISTS `materialy_druhy` (
`materialy_druhy_id` mediumint(8) unsigned NOT NULL,
  `skratka` varchar(5) DEFAULT NULL,
  `nazov` varchar(45) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Vypisuji data pro tabulku `materialy_druhy`
--

INSERT INTO `materialy_druhy` (`materialy_druhy_id`, `skratka`, `nazov`) VALUES
(1, 'b1', 'buk'),
(2, 'd1', 'dub'),
(3, 'b2', 'breza'),
(4, 'stp1', 'stiepka 1');

-- --------------------------------------------------------

--
-- Struktura tabulky `materialy_typy`
--

CREATE TABLE IF NOT EXISTS `materialy_typy` (
`materialy_typy_id` tinyint(3) unsigned NOT NULL,
  `skratka` varchar(5) DEFAULT NULL,
  `nazov` varchar(45) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Vypisuji data pro tabulku `materialy_typy`
--

INSERT INTO `materialy_typy` (`materialy_typy_id`, `skratka`, `nazov`) VALUES
(1, 'vlak', 'vlaknina'),
(2, 'odrez', 'odrezky'),
(3, 'stiep', 'stiepka');

-- --------------------------------------------------------

--
-- Struktura tabulky `merne_jednotky`
--

CREATE TABLE IF NOT EXISTS `merne_jednotky` (
`merne_jednotky_id` tinyint(3) unsigned NOT NULL,
  `nazov` varchar(20) DEFAULT NULL,
  `skratka` varchar(10) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Vypisuji data pro tabulku `merne_jednotky`
--

INSERT INTO `merne_jednotky` (`merne_jednotky_id`, `nazov`, `skratka`) VALUES
(1, 'tona', 't'),
(2, 'priestorový meter', 'PRM'),
(3, 'meter kubický', 'm3');

-- --------------------------------------------------------

--
-- Struktura tabulky `mesta`
--

CREATE TABLE IF NOT EXISTS `mesta` (
`mesta_id` int(10) unsigned NOT NULL,
  `nazov_mesta` varchar(120) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Vypisuji data pro tabulku `mesta`
--

INSERT INTO `mesta` (`mesta_id`, `nazov_mesta`) VALUES
(1, 'Zvolen'),
(2, 'Hronská Breznica'),
(3, 'Prešov');

-- --------------------------------------------------------

--
-- Struktura tabulky `podsklady`
--

CREATE TABLE IF NOT EXISTS `podsklady` (
`podsklady_id` tinyint(3) unsigned NOT NULL,
  `kod_podskladu` varchar(5) DEFAULT NULL,
  `nazov_podskladu` varchar(50) DEFAULT NULL,
  `mesto_enum` int(10) unsigned DEFAULT NULL,
  `merna_jednotka_enum` tinyint(3) unsigned DEFAULT NULL,
  `adresa` varchar(100) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Vypisuji data pro tabulku `podsklady`
--

INSERT INTO `podsklady` (`podsklady_id`, `kod_podskladu`, `nazov_podskladu`, `mesto_enum`, `merna_jednotka_enum`, `adresa`) VALUES
(1, 'pskd1', 'Lipsuch', 1, 1, NULL),
(2, 'pskd2', 'Renovia', 1, 1, NULL),
(3, 'mt1', 'Motova', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Struktura tabulky `prepravci`
--

CREATE TABLE IF NOT EXISTS `prepravci` (
`prepravci_id` mediumint(8) unsigned NOT NULL,
  `kod` varchar(5) DEFAULT NULL,
  `meno` varchar(45) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Vypisuji data pro tabulku `prepravci`
--

INSERT INTO `prepravci` (`prepravci_id`, `kod`, `meno`) VALUES
(1, 'prp1', 'INVESTEX'),
(2, 'prp2', 'KOMO');

-- --------------------------------------------------------

--
-- Struktura tabulky `sklady`
--

CREATE TABLE IF NOT EXISTS `sklady` (
`sklady_id` tinyint(3) unsigned NOT NULL,
  `kod_skladu` varchar(5) DEFAULT NULL,
  `nazov_skladu` varchar(20) DEFAULT NULL,
  `mesto_enum` int(10) unsigned DEFAULT NULL,
  `merna_jednotka_enum` tinyint(3) unsigned DEFAULT NULL,
  `adresa` varchar(100) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Vypisuji data pro tabulku `sklady`
--

INSERT INTO `sklady` (`sklady_id`, `kod_skladu`, `nazov_skladu`, `mesto_enum`, `merna_jednotka_enum`, `adresa`) VALUES
(1, 'zv1', 'Zvolen', 1, 1, NULL),
(2, 'hb1', 'Breznica', 2, 1, NULL),
(3, 'ba1', 'Bratislava', 3, 1, NULL);

-- --------------------------------------------------------

--
-- Struktura tabulky `stroje`
--

CREATE TABLE IF NOT EXISTS `stroje` (
`stroje_id` tinyint(3) unsigned NOT NULL,
  `nazov_stroja` varchar(45) DEFAULT NULL,
  `typ_stroja` tinyint(3) unsigned DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Vypisuji data pro tabulku `stroje`
--

INSERT INTO `stroje` (`stroje_id`, `nazov_stroja`, `typ_stroja`) VALUES
(1, 'Shredder 600', 1),
(2, 'Crusher 400K', 2);

-- --------------------------------------------------------

--
-- Struktura tabulky `stroje_typy`
--

CREATE TABLE IF NOT EXISTS `stroje_typy` (
`stroje_typy_id` tinyint(3) unsigned NOT NULL,
  `nazov_kategorie` varchar(45) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Vypisuji data pro tabulku `stroje_typy`
--

INSERT INTO `stroje_typy` (`stroje_typy_id`, `nazov_kategorie`) VALUES
(1, 'štiepkovače'),
(2, 'drviče');

-- --------------------------------------------------------

--
-- Struktura tabulky `transkacie_stavy`
--

CREATE TABLE IF NOT EXISTS `transkacie_stavy` (
`transakcie_stavy_id` tinyint(3) unsigned NOT NULL,
  `nazov` varchar(45) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Vypisuji data pro tabulku `transkacie_stavy`
--

INSERT INTO `transkacie_stavy` (`transakcie_stavy_id`, `nazov`) VALUES
(1, 'caka na schvalenie'),
(2, 'schvalene'),
(3, 'zrusene');

-- --------------------------------------------------------

--
-- Struktura tabulky `ts_prijmy`
--

CREATE TABLE IF NOT EXISTS `ts_prijmy` (
`ts_prijmy_id` int(10) unsigned NOT NULL,
  `vznik_zaznamu_dtm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'change to timestamp',
  `vytvoril_u` tinyint(3) unsigned NOT NULL,
  `posledna_uprava_dtm` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'change to timestamp',
  `posledna_uprava_u` tinyint(3) unsigned NOT NULL,
  `datum_prijmu_d` date DEFAULT NULL,
  `sklad_enum` tinyint(3) unsigned DEFAULT NULL,
  `podsklad_enum` tinyint(3) unsigned DEFAULT NULL,
  `dodavatel_enum` mediumint(8) unsigned NOT NULL,
  `prepravca_enum` mediumint(8) unsigned DEFAULT NULL,
  `prepravca_spz` varchar(10) DEFAULT NULL,
  `q_tony_merane_brutto` decimal(5,2) unsigned DEFAULT NULL,
  `q_tony_merane_tara` decimal(5,2) unsigned DEFAULT NULL,
  `q_tony_merane` decimal(5,2) unsigned DEFAULT NULL,
  `q_tony_nadrozmer` decimal(5,2) unsigned DEFAULT NULL,
  `q_tony_vypocet` decimal(5,2) unsigned DEFAULT NULL,
  `q_m3_merane` decimal(5,2) unsigned DEFAULT NULL,
  `q_m3_vypocet` decimal(5,2) unsigned DEFAULT NULL,
  `q_prm_merane` decimal(5,2) unsigned DEFAULT NULL,
  `q_prm_vypocet` decimal(5,2) unsigned DEFAULT NULL,
  `doklad_cislo` varchar(12) DEFAULT NULL,
  `doklad_typ_enum` tinyint(3) unsigned DEFAULT NULL,
  `material_typ_enum` tinyint(3) unsigned DEFAULT NULL,
  `material_druh_enum` mediumint(8) unsigned DEFAULT NULL,
  `poznamka` varchar(150) DEFAULT NULL,
  `chyba` tinyint(1) DEFAULT NULL,
  `stav_transakcie` tinyint(3) unsigned DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

--
-- Vypisuji data pro tabulku `ts_prijmy`
--

INSERT INTO `ts_prijmy` (`ts_prijmy_id`, `vznik_zaznamu_dtm`, `vytvoril_u`, `posledna_uprava_dtm`, `posledna_uprava_u`, `datum_prijmu_d`, `sklad_enum`, `podsklad_enum`, `dodavatel_enum`, `prepravca_enum`, `prepravca_spz`, `q_tony_merane_brutto`, `q_tony_merane_tara`, `q_tony_merane`, `q_tony_nadrozmer`, `q_tony_vypocet`, `q_m3_merane`, `q_m3_vypocet`, `q_prm_merane`, `q_prm_vypocet`, `doklad_cislo`, `doklad_typ_enum`, `material_typ_enum`, `material_druh_enum`, `poznamka`, `chyba`, `stav_transakcie`) VALUES
(1, '0000-00-00 00:00:00', 1, '2015-07-11 21:24:51', 1, '2015-06-01', 1, 1, 1, 1, 'asd', '0.00', '0.00', '20.00', '89.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'SP150601-001', 1, 3, 4, '', 0, 2),
(3, '0000-00-00 00:00:00', 1, '2015-07-11 21:25:09', 1, '2015-06-01', 3, 1, 1, 1, 'asd', '0.00', '0.00', '24.00', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', 'SP150601-003', 1, 1, 2, '', 0, 2),
(4, '0000-00-00 00:00:00', 1, '2015-07-11 21:25:38', 1, '2015-06-01', 3, 1, 1, 1, 'asd', '0.00', '0.00', '10.00', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', 'SP150601-004', 1, 1, 1, '', 1, 1),
(5, '0000-00-00 00:00:00', 1, '2015-07-11 21:26:44', 1, '2015-06-01', 3, 1, 1, 1, 'asd', '0.00', '0.00', '20.00', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', 'SP150601-005', 1, 1, 1, '', 1, 3),
(6, '0000-00-00 00:00:00', 1, '2015-07-11 21:26:44', 1, '2015-06-01', 3, 1, 1, 1, 'Gucci', '0.00', '0.00', '10.00', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', 'SP150601-006', 1, 1, 1, '', 1, 2),
(7, '0000-00-00 00:00:00', 1, '2015-07-11 21:26:44', 1, '2015-06-01', 3, 1, 1, 1, 'asd', '0.00', '0.00', '30.00', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', 'SP150601-007', 1, 1, 1, '', 1, 2),
(8, '0000-00-00 00:00:00', 1, '2015-07-11 21:28:25', 1, '2015-06-01', 3, 1, 1, 1, 'asd', '0.00', '0.00', '10.00', NULL, '0.00', '0.00', '0.00', '10.00', '0.00', 'SP150601-008', 1, 1, 1, '', 1, 2),
(9, '0000-00-00 00:00:00', 1, '2015-07-11 21:28:25', 1, '2015-06-01', 1, 2, 2, 2, 'asd', '0.00', '0.00', '20.00', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', 'SP150601-009', 1, 1, 1, '', 1, 1),
(10, '0000-00-00 00:00:00', 1, '2015-07-11 21:27:37', 1, '2015-06-02', 3, 1, 1, 1, 'asd', '0.00', '0.00', '10.00', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', 'SP150602-001', 1, 1, 1, '', 0, 1),
(11, '0000-00-00 00:00:00', 1, '2015-07-11 21:29:10', 1, '2015-06-02', 3, 1, 1, 1, 'asd', '0.00', '20.00', '10.00', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', 'SP150602-002', 1, 1, 1, '', 1, 1),
(12, '0000-00-00 00:00:00', 1, '2015-07-11 21:27:37', 1, '2015-06-07', 3, 1, 1, 1, 'asd', '0.00', '0.00', '15.00', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', 'SP150602-003', 1, 1, 1, '', 1, 2),
(34, '2015-07-09 23:42:48', 1, '2015-07-11 09:36:12', 1, '2015-09-09', 2, 1, 1, 1, 'ZV543BU', '0.00', NULL, '45.00', '0.00', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 'skuska 1', 0, 2),
(51, '2015-07-11 09:43:38', 1, '2015-07-11 21:29:10', 1, '0000-00-00', 1, 1, 1, 1, 'zuk', '0.00', NULL, '20.00', '0.00', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, '', 0, 1),
(52, '2015-07-11 09:45:57', 1, '2015-07-11 09:52:16', 1, '2015-08-08', 2, 2, 1, 2, 'ZV789BU', NULL, NULL, '26.50', '3.50', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 'mokre drevo', 0, 1),
(53, '2015-07-11 09:51:01', 1, '2015-07-11 21:29:10', 1, '0000-00-00', 2, 1, 1, 2, 'asd', NULL, NULL, '30.00', '0.00', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, '', 0, 1),
(54, '2015-07-12 08:11:48', 1, '2015-07-12 08:11:48', 1, '0000-00-00', 1, 1, 1, 1, 'asd', NULL, NULL, '15.00', '0.00', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, '', 0, 1),
(55, '2015-07-12 20:06:02', 1, '2015-07-12 20:06:13', 1, '0000-00-00', 1, 1, 1, 1, '.kajsdlkjh', NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, 1, '', 0, 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `ts_ubytky_hmotnosti`
--

CREATE TABLE IF NOT EXISTS `ts_ubytky_hmotnosti` (
`ts_ubytky_hmotnosti_id` int(10) unsigned NOT NULL,
  `vznik_zaznamu_dtm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `posledna_uprava_dtm` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `datum_ubytku_dt` date NOT NULL,
  `sklad_enum` tinyint(3) unsigned NOT NULL,
  `q_rano_tony` double DEFAULT NULL,
  `q_vecer_tony` double DEFAULT NULL,
  `q_cely_den_tony` double DEFAULT NULL,
  `q_ubytok_tony` double DEFAULT NULL,
  `q_konecny_stav_tony` double DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Vypisuji data pro tabulku `ts_ubytky_hmotnosti`
--

INSERT INTO `ts_ubytky_hmotnosti` (`ts_ubytky_hmotnosti_id`, `vznik_zaznamu_dtm`, `posledna_uprava_dtm`, `datum_ubytku_dt`, `sklad_enum`, `q_rano_tony`, `q_vecer_tony`, `q_cely_den_tony`, `q_ubytok_tony`, `q_konecny_stav_tony`) VALUES
(1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-06-01', 1, 0, 240.7, 0, 0, 240.7),
(2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-06-02', 1, 240.7, 316.6, 240.7, 2.407, 314.193),
(3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-06-03', 1, 314.193, 314.193, 314.193, 3.142, 311.051),
(4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-06-04', 1, 311.051, 261.151, 261.151, 2.612, 258.54),
(5, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-06-05', 1, 258.54, 235.24, 235.24, 2.352, 232.887),
(6, '2015-07-13 13:16:11', '2015-07-13 13:16:35', '2015-07-14', 2, 10, 20, 10, 0.0001, 19.9999);

-- --------------------------------------------------------

--
-- Struktura tabulky `ts_vydaje`
--

CREATE TABLE IF NOT EXISTS `ts_vydaje` (
`ts_vydaje_id` int(10) unsigned NOT NULL,
  `vznik_zaznamu_dtm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `vytvoril_u` tinyint(3) unsigned NOT NULL,
  `posledna_uprava_dtm` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `posledna_uprava_u` tinyint(3) unsigned NOT NULL,
  `datum_vydaju_d` date DEFAULT NULL,
  `sklad_enum` tinyint(3) unsigned DEFAULT NULL,
  `podsklad_enum` tinyint(3) unsigned DEFAULT NULL,
  `zakaznik_enum` mediumint(8) unsigned DEFAULT NULL,
  `prepravca_enum` mediumint(8) unsigned DEFAULT NULL,
  `prepravca_spz` varchar(10) DEFAULT NULL,
  `stroj_enum` tinyint(3) unsigned DEFAULT NULL,
  `q_tony_merane_brutto` decimal(5,2) unsigned DEFAULT NULL,
  `q_tony_merane_tara` decimal(5,2) unsigned DEFAULT NULL,
  `q_tony_merane` decimal(5,2) unsigned DEFAULT NULL,
  `q_tony_vypocet` decimal(5,2) unsigned DEFAULT NULL,
  `q_m3_merane` decimal(5,2) unsigned DEFAULT NULL,
  `q_m3_vypocet` decimal(5,2) unsigned DEFAULT NULL,
  `q_prm_merane` decimal(5,2) unsigned DEFAULT NULL,
  `q_prm_vypocet` decimal(5,2) unsigned DEFAULT NULL,
  `doklad_cislo` int(10) unsigned DEFAULT NULL,
  `doklad_typ_enum` tinyint(3) unsigned DEFAULT NULL,
  `material_typ_enum` tinyint(3) unsigned DEFAULT NULL,
  `material_druh_enum` mediumint(8) unsigned NOT NULL,
  `poznamka` varchar(150) DEFAULT NULL,
  `chyba` tinyint(1) DEFAULT NULL,
  `stav_transakcie` tinyint(3) unsigned DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Vypisuji data pro tabulku `ts_vydaje`
--

INSERT INTO `ts_vydaje` (`ts_vydaje_id`, `vznik_zaznamu_dtm`, `vytvoril_u`, `posledna_uprava_dtm`, `posledna_uprava_u`, `datum_vydaju_d`, `sklad_enum`, `podsklad_enum`, `zakaznik_enum`, `prepravca_enum`, `prepravca_spz`, `stroj_enum`, `q_tony_merane_brutto`, `q_tony_merane_tara`, `q_tony_merane`, `q_tony_vypocet`, `q_m3_merane`, `q_m3_vypocet`, `q_prm_merane`, `q_prm_vypocet`, `doklad_cislo`, `doklad_typ_enum`, `material_typ_enum`, `material_druh_enum`, `poznamka`, `chyba`, `stav_transakcie`) VALUES
(1, '0000-00-00 00:00:00', 1, '2015-06-15 12:22:50', 1, '2015-06-02', 1, 1, 1, 1, 'ZV123BU', 1, '0.00', '0.00', '26.30', '0.00', '0.00', '0.00', '0.00', '0.00', 0, 1, 3, 4, '', 0, 2),
(2, '0000-00-00 00:00:00', 1, '2015-06-15 12:22:50', 1, '2015-06-04', 1, 1, 2, 1, 'KE222KL', 1, '0.00', '0.00', '23.40', '0.00', '0.00', '0.00', '0.00', '0.00', 0, 1, 3, 4, '', 0, 2),
(3, '0000-00-00 00:00:00', 1, '2015-06-15 12:22:50', 1, '2015-06-04', 1, 1, 1, 1, 'KE222KL', 1, '0.00', '0.00', '29.30', '0.00', '0.00', '0.00', '0.00', '0.00', 0, 1, 3, 4, 'ZZZ', 0, 2),
(4, '0000-00-00 00:00:00', 1, '2015-07-12 09:35:25', 1, '2015-06-04', 2, 1, 1, 1, 'KE222KL', 2, '0.00', '0.00', '23.40', '0.00', '0.00', '0.00', '0.00', '0.00', 0, 1, 3, 4, '', 0, 2),
(5, '0000-00-00 00:00:00', 1, '2015-06-15 12:23:51', 1, '2015-06-05', 1, 1, 1, 1, 'KE222KL', 1, '0.00', '0.00', '26.40', '0.00', '0.00', '0.00', '0.00', '0.00', 0, 1, 3, 4, '', 0, 2),
(6, '0000-00-00 00:00:00', 1, '2015-06-15 12:23:51', 1, '2015-06-05', 1, 1, 2, 1, 'KE222KL', 1, '0.00', '0.00', '21.90', '0.00', '0.00', '0.00', '0.00', '0.00', 0, 1, 3, 4, '', 0, 2);

-- --------------------------------------------------------

--
-- Struktura tabulky `ubytky_parametre`
--

CREATE TABLE IF NOT EXISTS `ubytky_parametre` (
  `ubytky_parametre_id` int(10) unsigned NOT NULL,
  `mesiac` int(10) unsigned NOT NULL,
  `den` int(10) unsigned NOT NULL,
  `percento` float NOT NULL,
  `vaha` float NOT NULL,
  `ubytok_percento` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovak_ci;

--
-- Vypisuji data pro tabulku `ubytky_parametre`
--

INSERT INTO `ubytky_parametre` (`ubytky_parametre_id`, `mesiac`, `den`, `percento`, `vaha`, `ubytok_percento`) VALUES
(1, 1, 1, 0.000191257, 0.5, 0.0000956284),
(2, 1, 2, 0.000191257, 0.505525, 0.0000966851),
(3, 1, 3, 0.000191257, 0.51105, 0.0000977418),
(4, 1, 4, 0.000191257, 0.516575, 0.0000987984),
(5, 1, 5, 0.000191257, 0.522099, 0.0000998551),
(6, 1, 6, 0.000191257, 0.527624, 0.000100912),
(7, 1, 7, 0.000191257, 0.533149, 0.000101968),
(8, 1, 8, 0.000191257, 0.538674, 0.000103025),
(9, 1, 9, 0.000191257, 0.544199, 0.000104082),
(10, 1, 10, 0.000191257, 0.549724, 0.000105138),
(11, 1, 11, 0.000191257, 0.555249, 0.000106195),
(12, 1, 12, 0.000191257, 0.560773, 0.000107252),
(13, 1, 13, 0.000191257, 0.566298, 0.000108308),
(14, 1, 14, 0.000191257, 0.571823, 0.000109365),
(15, 1, 15, 0.000191257, 0.577348, 0.000110422),
(16, 1, 16, 0.000191257, 0.582873, 0.000111478),
(17, 1, 17, 0.000191257, 0.588398, 0.000112535),
(18, 1, 18, 0.000191257, 0.593923, 0.000113592),
(19, 1, 19, 0.000191257, 0.599447, 0.000114648),
(20, 1, 20, 0.000191257, 0.604972, 0.000115705),
(21, 1, 21, 0.000191257, 0.610497, 0.000116762),
(22, 1, 22, 0.000191257, 0.616022, 0.000117818),
(23, 1, 23, 0.000191257, 0.621547, 0.000118875),
(24, 1, 24, 0.000191257, 0.627072, 0.000119932),
(25, 1, 25, 0.000191257, 0.632597, 0.000120988),
(26, 1, 26, 0.000191257, 0.638122, 0.000122045),
(27, 1, 27, 0.000191257, 0.643646, 0.000123102),
(28, 1, 28, 0.000191257, 0.649171, 0.000124158),
(29, 1, 29, 0.000191257, 0.654696, 0.000125215),
(30, 1, 30, 0.000191257, 0.660221, 0.000126272),
(31, 1, 31, 0.000191257, 0.665746, 0.000127328),
(32, 2, 1, 0.000191257, 0.671271, 0.000128385),
(33, 2, 2, 0.000191257, 0.676796, 0.000129442),
(34, 2, 3, 0.000191257, 0.68232, 0.000130498),
(35, 2, 4, 0.000191257, 0.687845, 0.000131555),
(36, 2, 5, 0.000191257, 0.69337, 0.000132612),
(37, 2, 6, 0.000191257, 0.698895, 0.000133668),
(38, 2, 7, 0.000191257, 0.70442, 0.000134725),
(39, 2, 8, 0.000191257, 0.709945, 0.000135782),
(40, 2, 9, 0.000191257, 0.71547, 0.000136838),
(41, 2, 10, 0.000191257, 0.720994, 0.000137895),
(42, 2, 11, 0.000191257, 0.726519, 0.000138952),
(43, 2, 12, 0.000191257, 0.732044, 0.000140009),
(44, 2, 13, 0.000191257, 0.737569, 0.000141065),
(45, 2, 14, 0.000191257, 0.743094, 0.000142122),
(46, 2, 15, 0.000191257, 0.748619, 0.000143179),
(47, 2, 16, 0.000191257, 0.754144, 0.000144235),
(48, 2, 17, 0.000191257, 0.759669, 0.000145292),
(49, 2, 18, 0.000191257, 0.765193, 0.000146348),
(50, 2, 19, 0.000191257, 0.770718, 0.000147405),
(51, 2, 20, 0.000191257, 0.776243, 0.000148462),
(52, 2, 21, 0.000191257, 0.781768, 0.000149518),
(53, 2, 22, 0.000191257, 0.787293, 0.000150575),
(54, 2, 23, 0.000191257, 0.792818, 0.000151632),
(55, 2, 24, 0.000191257, 0.798343, 0.000152689),
(56, 2, 25, 0.000191257, 0.803867, 0.000153745),
(57, 2, 26, 0.000191257, 0.809392, 0.000154802),
(58, 2, 27, 0.000191257, 0.814917, 0.000155859),
(59, 2, 28, 0.000191257, 0.820442, 0.000156915),
(60, 2, 29, 0.000191257, 0.825967, 0.000157972),
(61, 3, 1, 0.000191257, 0.831492, 0.000159028),
(62, 3, 2, 0.000191257, 0.837017, 0.000160085),
(63, 3, 3, 0.000191257, 0.842541, 0.000161142),
(64, 3, 4, 0.000191257, 0.848066, 0.000162198),
(65, 3, 5, 0.000191257, 0.853591, 0.000163255),
(66, 3, 6, 0.000191257, 0.859116, 0.000164312),
(67, 3, 7, 0.000191257, 0.864641, 0.000165369),
(68, 3, 8, 0.000191257, 0.870166, 0.000166425),
(69, 3, 9, 0.000191257, 0.875691, 0.000167482),
(70, 3, 10, 0.000191257, 0.881215, 0.000168539),
(71, 3, 11, 0.000191257, 0.88674, 0.000169595),
(72, 3, 12, 0.000191257, 0.892265, 0.000170652),
(73, 3, 13, 0.000191257, 0.89779, 0.000171708),
(74, 3, 14, 0.000191257, 0.903315, 0.000172765),
(75, 3, 15, 0.000191257, 0.90884, 0.000173822),
(76, 3, 16, 0.000191257, 0.914365, 0.000174878),
(77, 3, 17, 0.000191257, 0.91989, 0.000175935),
(78, 3, 18, 0.000191257, 0.925414, 0.000176992),
(79, 3, 19, 0.000191257, 0.930939, 0.000178049),
(80, 3, 20, 0.000191257, 0.936464, 0.000179105),
(81, 3, 21, 0.000191257, 0.941989, 0.000180162),
(82, 3, 22, 0.000191257, 0.947514, 0.000181218),
(83, 3, 23, 0.000191257, 0.953039, 0.000182275),
(84, 3, 24, 0.000191257, 0.958564, 0.000183332),
(85, 3, 25, 0.000191257, 0.964088, 0.000184388),
(86, 3, 26, 0.000191257, 0.969613, 0.000185445),
(87, 3, 27, 0.000191257, 0.975138, 0.000186502),
(88, 3, 28, 0.000191257, 0.980663, 0.000187559),
(89, 3, 29, 0.000191257, 0.986188, 0.000188615),
(90, 3, 30, 0.000191257, 0.991713, 0.000189672),
(91, 3, 31, 0.000191257, 0.997238, 0.000190729),
(92, 4, 1, 0.000191257, 1.00276, 0.000191785),
(93, 4, 2, 0.000191257, 1.00829, 0.000192842),
(94, 4, 3, 0.000191257, 1.01381, 0.000193898),
(95, 4, 4, 0.000191257, 1.01934, 0.000194955),
(96, 4, 5, 0.000191257, 1.02486, 0.000196012),
(97, 4, 6, 0.000191257, 1.03039, 0.000197068),
(98, 4, 7, 0.000191257, 1.03591, 0.000198125),
(99, 4, 8, 0.000191257, 1.04144, 0.000199182),
(100, 4, 9, 0.000191257, 1.04696, 0.000200239),
(101, 4, 10, 0.000191257, 1.05249, 0.000201295),
(102, 4, 11, 0.000191257, 1.05801, 0.000202352),
(103, 4, 12, 0.000191257, 1.06354, 0.000203409),
(104, 4, 13, 0.000191257, 1.06906, 0.000204465),
(105, 4, 14, 0.000191257, 1.07459, 0.000205522),
(106, 4, 15, 0.000191257, 1.08011, 0.000206578),
(107, 4, 16, 0.000191257, 1.08564, 0.000207635),
(108, 4, 17, 0.000191257, 1.09116, 0.000208692),
(109, 4, 18, 0.000191257, 1.09669, 0.000209748),
(110, 4, 19, 0.000191257, 1.10221, 0.000210805),
(111, 4, 20, 0.000191257, 1.10773, 0.000211862),
(112, 4, 21, 0.000191257, 1.11326, 0.000212919),
(113, 4, 22, 0.000191257, 1.11878, 0.000213975),
(114, 4, 23, 0.000191257, 1.12431, 0.000215032),
(115, 4, 24, 0.000191257, 1.12983, 0.000216089),
(116, 4, 25, 0.000191257, 1.13536, 0.000217145),
(117, 4, 26, 0.000191257, 1.14088, 0.000218202),
(118, 4, 27, 0.000191257, 1.14641, 0.000219258),
(119, 4, 28, 0.000191257, 1.15193, 0.000220315),
(120, 4, 29, 0.000191257, 1.15746, 0.000221372),
(121, 4, 30, 0.000191257, 1.16298, 0.000222428),
(122, 5, 1, 0.000191257, 1.16851, 0.000223485),
(123, 5, 2, 0.000191257, 1.17403, 0.000224542),
(124, 5, 3, 0.000191257, 1.17956, 0.000225599),
(125, 5, 4, 0.000191257, 1.18508, 0.000226655),
(126, 5, 5, 0.000191257, 1.19061, 0.000227712),
(127, 5, 6, 0.000191257, 1.19613, 0.000228769),
(128, 5, 7, 0.000191257, 1.20166, 0.000229825),
(129, 5, 8, 0.000191257, 1.20718, 0.000230882),
(130, 5, 9, 0.000191257, 1.21271, 0.000231938),
(131, 5, 10, 0.000191257, 1.21823, 0.000232995),
(132, 5, 11, 0.000191257, 1.22376, 0.000234052),
(133, 5, 12, 0.000191257, 1.22928, 0.000235108),
(134, 5, 13, 0.000191257, 1.23481, 0.000236165),
(135, 5, 14, 0.000191257, 1.24033, 0.000237222),
(136, 5, 15, 0.000191257, 1.24586, 0.000238279),
(137, 5, 16, 0.000191257, 1.25138, 0.000239335),
(138, 5, 17, 0.000191257, 1.25691, 0.000240392),
(139, 5, 18, 0.000191257, 1.26243, 0.000241449),
(140, 5, 19, 0.000191257, 1.26796, 0.000242505),
(141, 5, 20, 0.000191257, 1.27348, 0.000243562),
(142, 5, 21, 0.000191257, 1.27901, 0.000244619),
(143, 5, 22, 0.000191257, 1.28453, 0.000245675),
(144, 5, 23, 0.000191257, 1.29006, 0.000246732),
(145, 5, 24, 0.000191257, 1.29558, 0.000247788),
(146, 5, 25, 0.000191257, 1.30111, 0.000248845),
(147, 5, 26, 0.000191257, 1.30663, 0.000249902),
(148, 5, 27, 0.000191257, 1.31215, 0.000250958),
(149, 5, 28, 0.000191257, 1.31768, 0.000252015),
(150, 5, 29, 0.000191257, 1.3232, 0.000253072),
(151, 5, 30, 0.000191257, 1.32873, 0.000254129),
(152, 5, 31, 0.000191257, 1.33425, 0.000255185),
(153, 6, 1, 0.000191257, 1.33978, 0.000256242),
(154, 6, 2, 0.000191257, 1.3453, 0.000257299),
(155, 6, 3, 0.000191257, 1.35083, 0.000258355),
(156, 6, 4, 0.000191257, 1.35635, 0.000259412),
(157, 6, 5, 0.000191257, 1.36188, 0.000260469),
(158, 6, 6, 0.000191257, 1.3674, 0.000261525),
(159, 6, 7, 0.000191257, 1.37293, 0.000262582),
(160, 6, 8, 0.000191257, 1.37845, 0.000263639),
(161, 6, 9, 0.000191257, 1.38398, 0.000264695),
(162, 6, 10, 0.000191257, 1.3895, 0.000265752),
(163, 6, 11, 0.000191257, 1.39503, 0.000266809),
(164, 6, 12, 0.000191257, 1.40055, 0.000267865),
(165, 6, 13, 0.000191257, 1.40608, 0.000268922),
(166, 6, 14, 0.000191257, 1.4116, 0.000269979),
(167, 6, 15, 0.000191257, 1.41713, 0.000271035),
(168, 6, 16, 0.000191257, 1.42265, 0.000272092),
(169, 6, 17, 0.000191257, 1.42818, 0.000273149),
(170, 6, 18, 0.000191257, 1.4337, 0.000274205),
(171, 6, 19, 0.000191257, 1.43923, 0.000275262),
(172, 6, 20, 0.000191257, 1.44475, 0.000276319),
(173, 6, 21, 0.000191257, 1.45028, 0.000277375),
(174, 6, 22, 0.000191257, 1.4558, 0.000278432),
(175, 6, 23, 0.000191257, 1.46133, 0.000279489),
(176, 6, 24, 0.000191257, 1.46685, 0.000280545),
(177, 6, 25, 0.000191257, 1.47238, 0.000281602),
(178, 6, 26, 0.000191257, 1.4779, 0.000282659),
(179, 6, 27, 0.000191257, 1.48343, 0.000283715),
(180, 6, 28, 0.000191257, 1.48895, 0.000284772),
(181, 6, 29, 0.000191257, 1.49448, 0.000285829),
(182, 6, 30, 0.000191257, 1.5, 0.000286885),
(183, 7, 1, 0.000191257, 1.5, 0.000286885),
(184, 7, 2, 0.000191257, 1.5, 0.000286885),
(185, 7, 3, 0.000191257, 1.49448, 0.000285829),
(186, 7, 4, 0.000191257, 1.48895, 0.000284772),
(187, 7, 5, 0.000191257, 1.48343, 0.000283715),
(188, 7, 6, 0.000191257, 1.4779, 0.000282659),
(189, 7, 7, 0.000191257, 1.47238, 0.000281602),
(190, 7, 8, 0.000191257, 1.46685, 0.000280545),
(191, 7, 9, 0.000191257, 1.46133, 0.000279489),
(192, 7, 10, 0.000191257, 1.4558, 0.000278432),
(193, 7, 11, 0.000191257, 1.45028, 0.000277375),
(194, 7, 12, 0.000191257, 1.44475, 0.000276319),
(195, 7, 13, 0.000191257, 1.43923, 0.000275262),
(196, 7, 14, 0.000191257, 1.4337, 0.000274205),
(197, 7, 15, 0.000191257, 1.42818, 0.000273149),
(198, 7, 16, 0.000191257, 1.42265, 0.000272092),
(199, 7, 17, 0.000191257, 1.41713, 0.000271035),
(200, 7, 18, 0.000191257, 1.4116, 0.000269979),
(201, 7, 19, 0.000191257, 1.40608, 0.000268922),
(202, 7, 20, 0.000191257, 1.40055, 0.000267865),
(203, 7, 21, 0.000191257, 1.39503, 0.000266809),
(204, 7, 22, 0.000191257, 1.3895, 0.000265752),
(205, 7, 23, 0.000191257, 1.38398, 0.000264695),
(206, 7, 24, 0.000191257, 1.37845, 0.000263639),
(207, 7, 25, 0.000191257, 1.37293, 0.000262582),
(208, 7, 26, 0.000191257, 1.3674, 0.000261525),
(209, 7, 27, 0.000191257, 1.36188, 0.000260469),
(210, 7, 28, 0.000191257, 1.35635, 0.000259412),
(211, 7, 29, 0.000191257, 1.35083, 0.000258355),
(212, 7, 30, 0.000191257, 1.3453, 0.000257299),
(213, 7, 31, 0.000191257, 1.33978, 0.000256242),
(214, 8, 1, 0.000191257, 1.33425, 0.000255185),
(215, 8, 2, 0.000191257, 1.32873, 0.000254129),
(216, 8, 3, 0.000191257, 1.3232, 0.000253072),
(217, 8, 4, 0.000191257, 1.31768, 0.000252015),
(218, 8, 5, 0.000191257, 1.31215, 0.000250958),
(219, 8, 6, 0.000191257, 1.30663, 0.000249902),
(220, 8, 7, 0.000191257, 1.30111, 0.000248845),
(221, 8, 8, 0.000191257, 1.29558, 0.000247788),
(222, 8, 9, 0.000191257, 1.29006, 0.000246732),
(223, 8, 10, 0.000191257, 1.28453, 0.000245675),
(224, 8, 11, 0.000191257, 1.27901, 0.000244619),
(225, 8, 12, 0.000191257, 1.27348, 0.000243562),
(226, 8, 13, 0.000191257, 1.26796, 0.000242505),
(227, 8, 14, 0.000191257, 1.26243, 0.000241449),
(228, 8, 15, 0.000191257, 1.25691, 0.000240392),
(229, 8, 16, 0.000191257, 1.25138, 0.000239335),
(230, 8, 17, 0.000191257, 1.24586, 0.000238279),
(231, 8, 18, 0.000191257, 1.24033, 0.000237222),
(232, 8, 19, 0.000191257, 1.23481, 0.000236165),
(233, 8, 20, 0.000191257, 1.22928, 0.000235108),
(234, 8, 21, 0.000191257, 1.22376, 0.000234052),
(235, 8, 22, 0.000191257, 1.21823, 0.000232995),
(236, 8, 23, 0.000191257, 1.21271, 0.000231938),
(237, 8, 24, 0.000191257, 1.20718, 0.000230882),
(238, 8, 25, 0.000191257, 1.20166, 0.000229825),
(239, 8, 26, 0.000191257, 1.19613, 0.000228769),
(240, 8, 27, 0.000191257, 1.19061, 0.000227712),
(241, 8, 28, 0.000191257, 1.18508, 0.000226655),
(242, 8, 29, 0.000191257, 1.17956, 0.000225599),
(243, 8, 30, 0.000191257, 1.17403, 0.000224542),
(244, 8, 31, 0.000191257, 1.16851, 0.000223485),
(245, 9, 1, 0.000191257, 1.16298, 0.000222428),
(246, 9, 2, 0.000191257, 1.15746, 0.000221372),
(247, 9, 3, 0.000191257, 1.15193, 0.000220315),
(248, 9, 4, 0.000191257, 1.14641, 0.000219258),
(249, 9, 5, 0.000191257, 1.14088, 0.000218202),
(250, 9, 6, 0.000191257, 1.13536, 0.000217145),
(251, 9, 7, 0.000191257, 1.12983, 0.000216089),
(252, 9, 8, 0.000191257, 1.12431, 0.000215032),
(253, 9, 9, 0.000191257, 1.11878, 0.000213975),
(254, 9, 10, 0.000191257, 1.11326, 0.000212919),
(255, 9, 11, 0.000191257, 1.10773, 0.000211862),
(256, 9, 12, 0.000191257, 1.10221, 0.000210805),
(257, 9, 13, 0.000191257, 1.09669, 0.000209748),
(258, 9, 14, 0.000191257, 1.09116, 0.000208692),
(259, 9, 15, 0.000191257, 1.08564, 0.000207635),
(260, 9, 16, 0.000191257, 1.08011, 0.000206578),
(261, 9, 17, 0.000191257, 1.07459, 0.000205522),
(262, 9, 18, 0.000191257, 1.06906, 0.000204465),
(263, 9, 19, 0.000191257, 1.06354, 0.000203409),
(264, 9, 20, 0.000191257, 1.05801, 0.000202352),
(265, 9, 21, 0.000191257, 1.05249, 0.000201295),
(266, 9, 22, 0.000191257, 1.04696, 0.000200239),
(267, 9, 23, 0.000191257, 1.04144, 0.000199182),
(268, 9, 24, 0.000191257, 1.03591, 0.000198125),
(269, 9, 25, 0.000191257, 1.03039, 0.000197068),
(270, 9, 26, 0.000191257, 1.02486, 0.000196012),
(271, 9, 27, 0.000191257, 1.01934, 0.000194955),
(272, 9, 28, 0.000191257, 1.01381, 0.000193898),
(273, 9, 29, 0.000191257, 1.00829, 0.000192842),
(274, 9, 30, 0.000191257, 1.00276, 0.000191785),
(275, 10, 1, 0.000191257, 0.997238, 0.000190729),
(276, 10, 2, 0.000191257, 0.991713, 0.000189672),
(277, 10, 3, 0.000191257, 0.986188, 0.000188615),
(278, 10, 4, 0.000191257, 0.980663, 0.000187559),
(279, 10, 5, 0.000191257, 0.975138, 0.000186502),
(280, 10, 6, 0.000191257, 0.969613, 0.000185445),
(281, 10, 7, 0.000191257, 0.964088, 0.000184388),
(282, 10, 8, 0.000191257, 0.958564, 0.000183332),
(283, 10, 9, 0.000191257, 0.953039, 0.000182275),
(284, 10, 10, 0.000191257, 0.947514, 0.000181218),
(285, 10, 11, 0.000191257, 0.941989, 0.000180162),
(286, 10, 12, 0.000191257, 0.936464, 0.000179105),
(287, 10, 13, 0.000191257, 0.930939, 0.000178049),
(288, 10, 14, 0.000191257, 0.925414, 0.000176992),
(289, 10, 15, 0.000191257, 0.91989, 0.000175935),
(290, 10, 16, 0.000191257, 0.914365, 0.000174878),
(291, 10, 17, 0.000191257, 0.90884, 0.000173822),
(292, 10, 18, 0.000191257, 0.903315, 0.000172765),
(293, 10, 19, 0.000191257, 0.89779, 0.000171708),
(294, 10, 20, 0.000191257, 0.892265, 0.000170652),
(295, 10, 21, 0.000191257, 0.88674, 0.000169595),
(296, 10, 22, 0.000191257, 0.881215, 0.000168539),
(297, 10, 23, 0.000191257, 0.875691, 0.000167482),
(298, 10, 24, 0.000191257, 0.870166, 0.000166425),
(299, 10, 25, 0.000191257, 0.864641, 0.000165369),
(300, 10, 26, 0.000191257, 0.859116, 0.000164312),
(301, 10, 27, 0.000191257, 0.853591, 0.000163255),
(302, 10, 28, 0.000191257, 0.848066, 0.000162198),
(303, 10, 29, 0.000191257, 0.842541, 0.000161142),
(304, 10, 30, 0.000191257, 0.837017, 0.000160085),
(305, 10, 31, 0.000191257, 0.831492, 0.000159028),
(306, 11, 1, 0.000191257, 0.825967, 0.000157972),
(307, 11, 2, 0.000191257, 0.820442, 0.000156915),
(308, 11, 3, 0.000191257, 0.814917, 0.000155859),
(309, 11, 4, 0.000191257, 0.809392, 0.000154802),
(310, 11, 5, 0.000191257, 0.803867, 0.000153745),
(311, 11, 6, 0.000191257, 0.798343, 0.000152689),
(312, 11, 7, 0.000191257, 0.792818, 0.000151632),
(313, 11, 8, 0.000191257, 0.787293, 0.000150575),
(314, 11, 9, 0.000191257, 0.781768, 0.000149518),
(315, 11, 10, 0.000191257, 0.776243, 0.000148462),
(316, 11, 11, 0.000191257, 0.770718, 0.000147405),
(317, 11, 12, 0.000191257, 0.765193, 0.000146348),
(318, 11, 13, 0.000191257, 0.759669, 0.000145292),
(319, 11, 14, 0.000191257, 0.754144, 0.000144235),
(320, 11, 15, 0.000191257, 0.748619, 0.000143179),
(321, 11, 16, 0.000191257, 0.743094, 0.000142122),
(322, 11, 17, 0.000191257, 0.737569, 0.000141065),
(323, 11, 18, 0.000191257, 0.732044, 0.000140009),
(324, 11, 19, 0.000191257, 0.726519, 0.000138952),
(325, 11, 20, 0.000191257, 0.720994, 0.000137895),
(326, 11, 21, 0.000191257, 0.71547, 0.000136838),
(327, 11, 22, 0.000191257, 0.709945, 0.000135782),
(328, 11, 23, 0.000191257, 0.70442, 0.000134725),
(329, 11, 24, 0.000191257, 0.698895, 0.000133668),
(330, 11, 25, 0.000191257, 0.69337, 0.000132612),
(331, 11, 26, 0.000191257, 0.687845, 0.000131555),
(332, 11, 27, 0.000191257, 0.68232, 0.000130498),
(333, 11, 28, 0.000191257, 0.676796, 0.000129442),
(334, 11, 29, 0.000191257, 0.671271, 0.000128385),
(335, 11, 30, 0.000191257, 0.665746, 0.000127328),
(336, 12, 1, 0.000191257, 0.660221, 0.000126272),
(337, 12, 2, 0.000191257, 0.654696, 0.000125215),
(338, 12, 3, 0.000191257, 0.649171, 0.000124158),
(339, 12, 4, 0.000191257, 0.643646, 0.000123102),
(340, 12, 5, 0.000191257, 0.638122, 0.000122045),
(341, 12, 6, 0.000191257, 0.632597, 0.000120988),
(342, 12, 7, 0.000191257, 0.627072, 0.000119932),
(343, 12, 8, 0.000191257, 0.621547, 0.000118875),
(344, 12, 9, 0.000191257, 0.616022, 0.000117818),
(345, 12, 10, 0.000191257, 0.610497, 0.000116762),
(346, 12, 11, 0.000191257, 0.604972, 0.000115705),
(347, 12, 12, 0.000191257, 0.599447, 0.000114648),
(348, 12, 13, 0.000191257, 0.593923, 0.000113592),
(349, 12, 14, 0.000191257, 0.588398, 0.000112535),
(350, 12, 15, 0.000191257, 0.582873, 0.000111478),
(351, 12, 16, 0.000191257, 0.577348, 0.000110422),
(352, 12, 17, 0.000191257, 0.571823, 0.000109365),
(353, 12, 18, 0.000191257, 0.566298, 0.000108308),
(354, 12, 19, 0.000191257, 0.560773, 0.000107252),
(355, 12, 20, 0.000191257, 0.555249, 0.000106195),
(356, 12, 21, 0.000191257, 0.549724, 0.000105138),
(357, 12, 22, 0.000191257, 0.544199, 0.000104082),
(358, 12, 23, 0.000191257, 0.538674, 0.000103025),
(359, 12, 24, 0.000191257, 0.533149, 0.000101968),
(360, 12, 25, 0.000191257, 0.527624, 0.000100912),
(361, 12, 26, 0.000191257, 0.522099, 0.0000998551),
(362, 12, 27, 0.000191257, 0.516575, 0.0000987984),
(363, 12, 28, 0.000191257, 0.51105, 0.0000977418),
(364, 12, 29, 0.000191257, 0.505525, 0.0000966851),
(365, 12, 30, 0.000191257, 0.5, 0.0000956284),
(366, 12, 31, 0.000191257, 0.5, 0.0000956284);

-- --------------------------------------------------------

--
-- Struktura tabulky `uzivatelia`
--

CREATE TABLE IF NOT EXISTS `uzivatelia` (
`uzivatelia_id` tinyint(3) unsigned NOT NULL,
  `meno` varchar(20) DEFAULT NULL,
  `priezvisko` varchar(30) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `heslo` varchar(45) DEFAULT NULL,
  `tel_cislo` varchar(45) DEFAULT NULL,
  `uzivatel_typ` tinyint(3) unsigned DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Vypisuji data pro tabulku `uzivatelia`
--

INSERT INTO `uzivatelia` (`uzivatelia_id`, `meno`, `priezvisko`, `email`, `heslo`, `tel_cislo`, `uzivatel_typ`) VALUES
(1, 'Tomáš', 'Polák', 'polak@3t.com', 'heslo', '666666777', 1),
(2, 'Igor', 'Packo', 'packo@foxy.com', 'heslo', '666666888', 3);

-- --------------------------------------------------------

--
-- Struktura tabulky `uzivatelia_typy`
--

CREATE TABLE IF NOT EXISTS `uzivatelia_typy` (
`uzivatelia_typy_id` tinyint(3) unsigned NOT NULL,
  `nazov_role` varchar(45) DEFAULT NULL,
  `popis` longtext
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Vypisuji data pro tabulku `uzivatelia_typy`
--

INSERT INTO `uzivatelia_typy` (`uzivatelia_typy_id`, `nazov_role`, `popis`) VALUES
(1, 'skladník', NULL),
(2, 'vedúci obchodu', NULL),
(3, 'admin', NULL);

-- --------------------------------------------------------

--
-- Struktura tabulky `zakaznici`
--

CREATE TABLE IF NOT EXISTS `zakaznici` (
`zakaznici_id` mediumint(8) unsigned NOT NULL,
  `meno` varchar(45) DEFAULT NULL,
  `nazov_spolocnosti` varchar(45) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Vypisuji data pro tabulku `zakaznici`
--

INSERT INTO `zakaznici` (`zakaznici_id`, `meno`, `nazov_spolocnosti`) VALUES
(1, 'Cigánka', 'GAMMA'),
(2, 'Zákazník 2', 'KATANA'),
(3, 'Zákazník 3', 'RAIDEN'),
(4, 'pampalÃ­ny', 'kokotnÃ¡ sro');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `dodavatelia`
--
ALTER TABLE `dodavatelia`
 ADD PRIMARY KEY (`dodavatelia_id`);

--
-- Klíče pro tabulku `doklady_typy`
--
ALTER TABLE `doklady_typy`
 ADD PRIMARY KEY (`doklady_typy_id`);

--
-- Klíče pro tabulku `materialy_druhy`
--
ALTER TABLE `materialy_druhy`
 ADD PRIMARY KEY (`materialy_druhy_id`);

--
-- Klíče pro tabulku `materialy_typy`
--
ALTER TABLE `materialy_typy`
 ADD PRIMARY KEY (`materialy_typy_id`);

--
-- Klíče pro tabulku `merne_jednotky`
--
ALTER TABLE `merne_jednotky`
 ADD PRIMARY KEY (`merne_jednotky_id`);

--
-- Klíče pro tabulku `mesta`
--
ALTER TABLE `mesta`
 ADD PRIMARY KEY (`mesta_id`);

--
-- Klíče pro tabulku `podsklady`
--
ALTER TABLE `podsklady`
 ADD PRIMARY KEY (`podsklady_id`);

--
-- Klíče pro tabulku `prepravci`
--
ALTER TABLE `prepravci`
 ADD PRIMARY KEY (`prepravci_id`);

--
-- Klíče pro tabulku `sklady`
--
ALTER TABLE `sklady`
 ADD PRIMARY KEY (`sklady_id`), ADD KEY `fk_sklady_merne_jednotky1_idx` (`merna_jednotka_enum`), ADD KEY `fk_sklady_mesta1_idx` (`mesto_enum`);

--
-- Klíče pro tabulku `stroje`
--
ALTER TABLE `stroje`
 ADD PRIMARY KEY (`stroje_id`), ADD KEY `fk_stroje_stroje_typy1_idx` (`typ_stroja`);

--
-- Klíče pro tabulku `stroje_typy`
--
ALTER TABLE `stroje_typy`
 ADD PRIMARY KEY (`stroje_typy_id`);

--
-- Klíče pro tabulku `transkacie_stavy`
--
ALTER TABLE `transkacie_stavy`
 ADD PRIMARY KEY (`transakcie_stavy_id`);

--
-- Klíče pro tabulku `ts_prijmy`
--
ALTER TABLE `ts_prijmy`
 ADD PRIMARY KEY (`ts_prijmy_id`), ADD KEY `fk_ts_prijmy_uzivatelia1_idx` (`vytvoril_u`), ADD KEY `fk_ts_prijmy_uzivatelia2_idx` (`posledna_uprava_u`), ADD KEY `fk_ts_prijmy_sklady1_idx` (`sklad_enum`), ADD KEY `fk_ts_prijmy_podsklady1_idx` (`podsklad_enum`), ADD KEY `fk_ts_prijmy_dodavatelia1_idx` (`dodavatel_enum`), ADD KEY `fk_ts_prijmy_doklady_typy1_idx` (`doklad_typ_enum`), ADD KEY `fk_ts_prijmy_materialy_typy1_idx` (`material_typ_enum`), ADD KEY `fk_ts_prijmy_materialy_druhy1_idx` (`material_druh_enum`), ADD KEY `fk_ts_prijmy_transkacie_stavy1_idx` (`stav_transakcie`), ADD KEY `fk_ts_prijmy_prepravci1_idx` (`prepravca_enum`);

--
-- Klíče pro tabulku `ts_ubytky_hmotnosti`
--
ALTER TABLE `ts_ubytky_hmotnosti`
 ADD PRIMARY KEY (`ts_ubytky_hmotnosti_id`), ADD KEY `fk_ts_ubytky_hmotnosti_sklady1_idx` (`sklad_enum`);

--
-- Klíče pro tabulku `ts_vydaje`
--
ALTER TABLE `ts_vydaje`
 ADD PRIMARY KEY (`ts_vydaje_id`), ADD KEY `fk_ts_vydaje_uzivatelia_idx` (`vytvoril_u`), ADD KEY `fk_ts_vydaje_uzivatelia1_idx` (`posledna_uprava_u`), ADD KEY `fk_ts_vydaje_sklady1_idx` (`sklad_enum`), ADD KEY `fk_ts_vydaje_podsklady1_idx` (`podsklad_enum`), ADD KEY `fk_ts_vydaje_doklady_typy1_idx` (`doklad_typ_enum`), ADD KEY `fk_ts_vydaje_materialy_typy1_idx` (`material_typ_enum`), ADD KEY `fk_ts_vydaje_materialy_druhy1_idx` (`material_druh_enum`), ADD KEY `fk_ts_vydaje_zakaznici1_idx` (`zakaznik_enum`), ADD KEY `fk_ts_vydaje_prepravci1_idx` (`prepravca_enum`), ADD KEY `fk_ts_vydaje_stroje1_idx` (`stroj_enum`), ADD KEY `fk_ts_vydaje_transkacie_stavy1_idx` (`stav_transakcie`);

--
-- Klíče pro tabulku `ubytky_parametre`
--
ALTER TABLE `ubytky_parametre`
 ADD PRIMARY KEY (`ubytky_parametre_id`);

--
-- Klíče pro tabulku `uzivatelia`
--
ALTER TABLE `uzivatelia`
 ADD PRIMARY KEY (`uzivatelia_id`), ADD KEY `fk_uzivatelia_uzivatelia_typy1_idx` (`uzivatel_typ`);

--
-- Klíče pro tabulku `uzivatelia_typy`
--
ALTER TABLE `uzivatelia_typy`
 ADD PRIMARY KEY (`uzivatelia_typy_id`);

--
-- Klíče pro tabulku `zakaznici`
--
ALTER TABLE `zakaznici`
 ADD PRIMARY KEY (`zakaznici_id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `dodavatelia`
--
ALTER TABLE `dodavatelia`
MODIFY `dodavatelia_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pro tabulku `doklady_typy`
--
ALTER TABLE `doklady_typy`
MODIFY `doklady_typy_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pro tabulku `materialy_druhy`
--
ALTER TABLE `materialy_druhy`
MODIFY `materialy_druhy_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pro tabulku `materialy_typy`
--
ALTER TABLE `materialy_typy`
MODIFY `materialy_typy_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pro tabulku `merne_jednotky`
--
ALTER TABLE `merne_jednotky`
MODIFY `merne_jednotky_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pro tabulku `mesta`
--
ALTER TABLE `mesta`
MODIFY `mesta_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pro tabulku `podsklady`
--
ALTER TABLE `podsklady`
MODIFY `podsklady_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pro tabulku `prepravci`
--
ALTER TABLE `prepravci`
MODIFY `prepravci_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pro tabulku `sklady`
--
ALTER TABLE `sklady`
MODIFY `sklady_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pro tabulku `stroje`
--
ALTER TABLE `stroje`
MODIFY `stroje_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pro tabulku `stroje_typy`
--
ALTER TABLE `stroje_typy`
MODIFY `stroje_typy_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pro tabulku `transkacie_stavy`
--
ALTER TABLE `transkacie_stavy`
MODIFY `transakcie_stavy_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pro tabulku `ts_prijmy`
--
ALTER TABLE `ts_prijmy`
MODIFY `ts_prijmy_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT pro tabulku `ts_ubytky_hmotnosti`
--
ALTER TABLE `ts_ubytky_hmotnosti`
MODIFY `ts_ubytky_hmotnosti_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pro tabulku `ts_vydaje`
--
ALTER TABLE `ts_vydaje`
MODIFY `ts_vydaje_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pro tabulku `uzivatelia`
--
ALTER TABLE `uzivatelia`
MODIFY `uzivatelia_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pro tabulku `uzivatelia_typy`
--
ALTER TABLE `uzivatelia_typy`
MODIFY `uzivatelia_typy_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pro tabulku `zakaznici`
--
ALTER TABLE `zakaznici`
MODIFY `zakaznici_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `sklady`
--
ALTER TABLE `sklady`
ADD CONSTRAINT `fk_sklady_merne_jednotky1` FOREIGN KEY (`merna_jednotka_enum`) REFERENCES `merne_jednotky` (`merne_jednotky_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_sklady_mesta1` FOREIGN KEY (`mesto_enum`) REFERENCES `mesta` (`mesta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `stroje`
--
ALTER TABLE `stroje`
ADD CONSTRAINT `fk_stroje_stroje_typy1` FOREIGN KEY (`typ_stroja`) REFERENCES `stroje_typy` (`stroje_typy_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `ts_prijmy`
--
ALTER TABLE `ts_prijmy`
ADD CONSTRAINT `fk_ts_prijmy_dodavatelia1` FOREIGN KEY (`dodavatel_enum`) REFERENCES `dodavatelia` (`dodavatelia_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ts_prijmy_doklady_typy1` FOREIGN KEY (`doklad_typ_enum`) REFERENCES `doklady_typy` (`doklady_typy_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ts_prijmy_materialy_druhy1` FOREIGN KEY (`material_druh_enum`) REFERENCES `materialy_druhy` (`materialy_druhy_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ts_prijmy_materialy_typy1` FOREIGN KEY (`material_typ_enum`) REFERENCES `materialy_typy` (`materialy_typy_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ts_prijmy_podsklady1` FOREIGN KEY (`podsklad_enum`) REFERENCES `podsklady` (`podsklady_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ts_prijmy_prepravci1` FOREIGN KEY (`prepravca_enum`) REFERENCES `prepravci` (`prepravci_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ts_prijmy_sklady1` FOREIGN KEY (`sklad_enum`) REFERENCES `sklady` (`sklady_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ts_prijmy_transkacie_stavy1` FOREIGN KEY (`stav_transakcie`) REFERENCES `transkacie_stavy` (`transakcie_stavy_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ts_prijmy_uzivatelia1` FOREIGN KEY (`vytvoril_u`) REFERENCES `uzivatelia` (`uzivatelia_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ts_prijmy_uzivatelia2` FOREIGN KEY (`posledna_uprava_u`) REFERENCES `uzivatelia` (`uzivatelia_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `ts_ubytky_hmotnosti`
--
ALTER TABLE `ts_ubytky_hmotnosti`
ADD CONSTRAINT `fk_ts_ubytky_hmotnosti_sklady1` FOREIGN KEY (`sklad_enum`) REFERENCES `sklady` (`sklady_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `ts_vydaje`
--
ALTER TABLE `ts_vydaje`
ADD CONSTRAINT `fk_ts_vydaje_doklady_typy1` FOREIGN KEY (`doklad_typ_enum`) REFERENCES `doklady_typy` (`doklady_typy_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ts_vydaje_materialy_druhy1` FOREIGN KEY (`material_druh_enum`) REFERENCES `materialy_druhy` (`materialy_druhy_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ts_vydaje_materialy_typy1` FOREIGN KEY (`material_typ_enum`) REFERENCES `materialy_typy` (`materialy_typy_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ts_vydaje_podsklady1` FOREIGN KEY (`podsklad_enum`) REFERENCES `podsklady` (`podsklady_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ts_vydaje_prepravci1` FOREIGN KEY (`prepravca_enum`) REFERENCES `prepravci` (`prepravci_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ts_vydaje_sklady1` FOREIGN KEY (`sklad_enum`) REFERENCES `sklady` (`sklady_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ts_vydaje_stroje1` FOREIGN KEY (`stroj_enum`) REFERENCES `stroje` (`stroje_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ts_vydaje_transkacie_stavy1` FOREIGN KEY (`stav_transakcie`) REFERENCES `transkacie_stavy` (`transakcie_stavy_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ts_vydaje_uzivatelia` FOREIGN KEY (`vytvoril_u`) REFERENCES `uzivatelia` (`uzivatelia_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ts_vydaje_uzivatelia1` FOREIGN KEY (`posledna_uprava_u`) REFERENCES `uzivatelia` (`uzivatelia_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ts_vydaje_zakaznici1` FOREIGN KEY (`zakaznik_enum`) REFERENCES `zakaznici` (`zakaznici_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `uzivatelia`
--
ALTER TABLE `uzivatelia`
ADD CONSTRAINT `fk_uzivatelia_uzivatelia_typy1` FOREIGN KEY (`uzivatel_typ`) REFERENCES `uzivatelia_typy` (`uzivatelia_typy_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
