-- phpMyAdmin SQL Dump
-- version 4.2.0
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vytvořeno: Stř 17. čen 2015, 22:35
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
(1, 'vlak', 'vláknina'),
(2, 'odrez', 'odrezky'),
(3, 'stiep', 'štiepka');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Vypisuji data pro tabulku `podsklady`
--

INSERT INTO `podsklady` (`podsklady_id`, `kod_podskladu`, `nazov_podskladu`, `mesto_enum`, `merna_jednotka_enum`, `adresa`) VALUES
(1, 'pskd1', 'Lipsuch', 1, 1, NULL),
(2, 'pskd2', 'Renovia', 1, 1, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Vypisuji data pro tabulku `sklady`
--

INSERT INTO `sklady` (`sklady_id`, `kod_skladu`, `nazov_skladu`, `mesto_enum`, `merna_jednotka_enum`, `adresa`) VALUES
(1, 'zv1', 'Zvolen', 1, 1, NULL),
(2, 'hb1', 'Breznica', 2, 1, NULL);

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
  `nazov_stavu` varchar(45) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Vypisuji data pro tabulku `transkacie_stavy`
--

INSERT INTO `transkacie_stavy` (`transakcie_stavy_id`, `nazov_stavu`) VALUES
(1, 'čaká na schválenie'),
(2, 'schválené'),
(3, 'zrušené');

-- --------------------------------------------------------

--
-- Struktura tabulky `ts_prijmy`
--

CREATE TABLE IF NOT EXISTS `ts_prijmy` (
`ts_prijmy_id` int(10) unsigned NOT NULL,
  `vznik_zaznamu_dtm` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'change to timestamp',
  `vytvoril_u` tinyint(3) unsigned NOT NULL,
  `posledna_uprava_dtm` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'change to timestamp',
  `posledna_uprava_u` tinyint(3) unsigned NOT NULL,
  `datum_prijmu_d` date DEFAULT NULL,
  `sklad_enum` tinyint(3) unsigned DEFAULT NULL,
  `podsklad_enum` tinyint(3) unsigned DEFAULT NULL,
  `dodavatel_enum` mediumint(8) unsigned NOT NULL,
  `prepravca_enum` mediumint(8) unsigned DEFAULT NULL,
  `prepravca_spz` varchar(10) DEFAULT NULL,
  `q_tony_merane_tara` decimal(5,2) unsigned DEFAULT NULL,
  `q_tony_merane` decimal(5,2) unsigned DEFAULT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Vypisuji data pro tabulku `ts_prijmy`
--

INSERT INTO `ts_prijmy` (`ts_prijmy_id`, `vznik_zaznamu_dtm`, `vytvoril_u`, `posledna_uprava_dtm`, `posledna_uprava_u`, `datum_prijmu_d`, `sklad_enum`, `podsklad_enum`, `dodavatel_enum`, `prepravca_enum`, `prepravca_spz`, `q_tony_merane_tara`, `q_tony_merane`, `q_tony_vypocet`, `q_m3_merane`, `q_m3_vypocet`, `q_prm_merane`, `q_prm_vypocet`, `doklad_cislo`, `doklad_typ_enum`, `material_typ_enum`, `material_druh_enum`, `poznamka`, `chyba`, `stav_transakcie`) VALUES
(1, '0000-00-00 00:00:00', 1, '2015-06-16 13:44:45', 1, '2015-06-01', 1, 1, 1, 1, 'ZV123BU', '0.00', '25.50', '0.00', '0.00', '0.00', '0.00', '0.00', 'SP150601-001', 1, 1, 1, '', 1, 1),
(2, '0000-00-00 00:00:00', 1, '2015-06-16 18:36:14', 1, '2015-06-01', 2, 1, 1, 1, 'ZV123BU', '0.00', '28.70', '0.00', '0.00', '0.00', '0.00', '0.00', 'SP150601-002', 1, 1, 1, '', 1, 1),
(3, '0000-00-00 00:00:00', 1, '2015-06-16 13:45:29', 1, '2015-06-01', 1, 1, 1, 1, 'ZV123BU', '0.00', '23.40', '0.00', '0.00', '0.00', '0.00', '0.00', 'SP150601-003', 1, 1, 1, 'poznamka 3', 1, 1),
(4, '0000-00-00 00:00:00', 1, '2015-06-16 13:45:48', 1, '2015-06-01', 1, 1, 1, 1, 'ZV123BU', '0.00', '26.20', '0.00', '0.00', '0.00', '0.00', '0.00', 'SP150601-004', 1, 1, 1, '', 1, 1),
(5, '0000-00-00 00:00:00', 1, '2015-06-16 17:12:12', 1, '2015-06-01', 1, 1, 2, 1, 'KE222KL', '0.00', '29.30', '0.00', '0.00', '0.00', '0.00', '0.00', 'SP150601-005', 1, 1, 1, '', 0, 1),
(6, '0000-00-00 00:00:00', 1, '2015-06-16 13:46:20', 2, '2015-06-01', 1, 1, 2, 1, 'KE222KL', '0.00', '28.70', '0.00', '0.00', '0.00', '0.00', '0.00', 'SP150601-006', 1, 1, 1, '', 1, 1),
(7, '0000-00-00 00:00:00', 1, '2015-06-16 13:47:14', 2, '2015-06-01', 1, 1, 2, 1, 'KE222KL', '0.00', '23.40', '0.00', '0.00', '0.00', '0.00', '0.00', 'SP150601-007', 1, 1, 2, '', 1, 1),
(8, '0000-00-00 00:00:00', 1, '2015-06-16 13:47:14', 2, '2015-06-01', 1, 1, 2, 1, 'KE222KL', '0.00', '26.20', '0.00', '0.00', '0.00', '0.00', '0.00', 'SP150601-008', 1, 1, 2, '', 1, 1),
(9, '0000-00-00 00:00:00', 1, '2015-06-16 13:47:14', 1, '2015-06-01', 1, 1, 1, 1, 'KE222KL', '0.00', '29.30', '0.00', '0.00', '0.00', '0.00', '0.00', 'SP150601-009', 1, 1, 2, '', 1, 1),
(10, '0000-00-00 00:00:00', 1, '2015-06-16 13:48:06', 1, '2015-06-02', 1, 1, 1, 2, 'ZV123BU', '0.00', '22.60', '0.00', '0.00', '0.00', '0.00', '0.00', 'SP150602-001', 1, 1, 2, 'poznamka 10', 1, 1),
(11, '0000-00-00 00:00:00', 1, '2015-06-16 13:48:06', 1, '2015-06-02', 1, 1, 1, 2, 'ZV123BU', '0.00', '25.40', '0.00', '0.00', '0.00', '0.00', '0.00', 'SP150602-002', 1, 1, 2, '', 1, 1),
(12, '0000-00-00 00:00:00', 1, '2015-06-16 13:48:06', 2, '2015-06-02', 1, 1, 3, 2, 'ZV123BU', '0.00', '26.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'SP150602-003', 1, 2, 2, '', 1, 1),
(13, '0000-00-00 00:00:00', 1, '2015-06-16 13:49:31', 2, '2015-06-02', 1, 1, 3, 2, 'ZV123BU', '0.00', '28.20', '0.00', '0.00', '0.00', '0.00', '0.00', 'SP150602-004', 1, 2, 1, '', 1, 1),
(14, '0000-00-00 00:00:00', 1, '2015-06-16 13:48:51', 1, '2015-06-04', 1, 1, 3, 2, 'KE222KL', '0.00', '26.20', '0.00', '0.00', '0.00', '0.00', '0.00', 'SP150604-001', 1, 2, 1, 'secret', 1, 1),
(15, '0000-00-00 00:00:00', 1, '2015-06-16 13:48:51', 1, '2015-06-05', 1, 1, 3, 2, 'KE222KL', '0.00', '22.20', '0.00', '0.00', '0.00', '0.00', '0.00', 'SP150605-001', 1, 2, 1, '', 1, 1),
(16, '0000-00-00 00:00:00', 1, '2015-06-16 13:48:51', 1, '2015-06-05', 1, 1, 1, 2, 'KE222KL', '0.00', '28.90', '0.00', '0.00', '0.00', '0.00', '0.00', 'SP150605-002', 1, 2, 1, '', 1, 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `ts_ubytky_hmotnosti`
--

CREATE TABLE IF NOT EXISTS `ts_ubytky_hmotnosti` (
`ts_ubytky_hmotnosti_id` int(10) unsigned NOT NULL,
  `vznik_zaznamu_dtm` date NOT NULL COMMENT 'change to timestamp',
  `datum_ubytku_dt` date NOT NULL,
  `sklad_enum` tinyint(3) unsigned NOT NULL,
  `q_rano_tony` double DEFAULT NULL,
  `q_vecer_tony` double DEFAULT NULL,
  `q_cely_den_tony` double DEFAULT NULL,
  `q_ubytok_tony` double DEFAULT NULL,
  `q_konecny_stav_tony` double DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Vypisuji data pro tabulku `ts_ubytky_hmotnosti`
--

INSERT INTO `ts_ubytky_hmotnosti` (`ts_ubytky_hmotnosti_id`, `vznik_zaznamu_dtm`, `datum_ubytku_dt`, `sklad_enum`, `q_rano_tony`, `q_vecer_tony`, `q_cely_den_tony`, `q_ubytok_tony`, `q_konecny_stav_tony`) VALUES
(1, '0000-00-00', '2015-06-01', 1, 0, 240.7, 0, 0, 240.7),
(2, '0000-00-00', '2015-06-02', 1, 240.7, 316.6, 240.7, 2.407, 314.193),
(3, '0000-00-00', '2015-06-03', 1, 314.193, 314.193, 314.193, 3.142, 311.051),
(4, '0000-00-00', '2015-06-04', 1, 311.051, 261.151, 261.151, 2.612, 258.54),
(5, '0000-00-00', '2015-06-05', 1, 258.54, 235.24, 235.24, 2.352, 232.887);

-- --------------------------------------------------------

--
-- Struktura tabulky `ts_vydaje`
--

CREATE TABLE IF NOT EXISTS `ts_vydaje` (
`ts_vydaje_id` int(10) unsigned NOT NULL,
  `vznik_zaznamu_dtm` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'change to timestamp',
  `vytvoril_u` tinyint(3) unsigned NOT NULL,
  `posledna_uprava_dtm` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'change to timestamp',
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Vypisuji data pro tabulku `ts_vydaje`
--

INSERT INTO `ts_vydaje` (`ts_vydaje_id`, `vznik_zaznamu_dtm`, `vytvoril_u`, `posledna_uprava_dtm`, `posledna_uprava_u`, `datum_vydaju_d`, `sklad_enum`, `podsklad_enum`, `zakaznik_enum`, `prepravca_enum`, `prepravca_spz`, `stroj_enum`, `q_tony_merane_brutto`, `q_tony_merane_tara`, `q_tony_merane`, `q_tony_vypocet`, `q_m3_merane`, `q_m3_vypocet`, `q_prm_merane`, `q_prm_vypocet`, `doklad_cislo`, `doklad_typ_enum`, `material_typ_enum`, `material_druh_enum`, `poznamka`, `chyba`, `stav_transakcie`) VALUES
(1, '0000-00-00 00:00:00', 1, '2015-06-15 12:22:50', 1, '2015-06-02', 1, 1, 1, 1, 'ZV123BU', 1, '0.00', '0.00', '26.30', '0.00', '0.00', '0.00', '0.00', '0.00', 0, 1, 3, 4, '', 0, 2),
(2, '0000-00-00 00:00:00', 1, '2015-06-15 12:22:50', 1, '2015-06-04', 1, 1, 2, 1, 'KE222KL', 1, '0.00', '0.00', '23.40', '0.00', '0.00', '0.00', '0.00', '0.00', 0, 1, 3, 4, '', 0, 2),
(3, '0000-00-00 00:00:00', 1, '2015-06-15 12:22:50', 1, '2015-06-04', 1, 1, 1, 1, 'KE222KL', 1, '0.00', '0.00', '29.30', '0.00', '0.00', '0.00', '0.00', '0.00', 0, 1, 3, 4, 'ZZZ', 0, 2),
(4, '0000-00-00 00:00:00', 1, '2015-06-15 12:22:50', 1, '2015-06-04', 1, 1, 1, 1, 'KE222KL', 2, '0.00', '0.00', '23.40', '0.00', '0.00', '0.00', '0.00', '0.00', 0, 1, 3, 4, '', 0, 2),
(5, '0000-00-00 00:00:00', 1, '2015-06-15 12:23:51', 1, '2015-06-05', 1, 1, 1, 1, 'KE222KL', 1, '0.00', '0.00', '26.40', '0.00', '0.00', '0.00', '0.00', '0.00', 0, 1, 3, 4, '', 0, 2),
(6, '0000-00-00 00:00:00', 1, '2015-06-15 12:23:51', 1, '2015-06-05', 1, 1, 2, 1, 'KE222KL', 1, '0.00', '0.00', '21.90', '0.00', '0.00', '0.00', '0.00', '0.00', 0, 1, 3, 4, '', 0, 2),
(7, '0000-00-00 00:00:00', 1, '2015-06-15 12:23:51', 1, '2015-06-05', 1, 1, 1, 2, 'ZV123BU', 2, '0.00', '0.00', '25.80', '0.00', '0.00', '0.00', '0.00', '0.00', 0, 1, 3, 4, '', 0, 2);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Vypisuji data pro tabulku `zakaznici`
--

INSERT INTO `zakaznici` (`zakaznici_id`, `meno`, `nazov_spolocnosti`) VALUES
(1, 'Zákazník 1', 'GAMMA'),
(2, 'Zákazník 2', 'KATANA'),
(3, 'Zákazník 3', 'RAIDEN');

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
MODIFY `podsklady_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pro tabulku `prepravci`
--
ALTER TABLE `prepravci`
MODIFY `prepravci_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pro tabulku `sklady`
--
ALTER TABLE `sklady`
MODIFY `sklady_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
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
MODIFY `ts_prijmy_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pro tabulku `ts_ubytky_hmotnosti`
--
ALTER TABLE `ts_ubytky_hmotnosti`
MODIFY `ts_ubytky_hmotnosti_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pro tabulku `ts_vydaje`
--
ALTER TABLE `ts_vydaje`
MODIFY `ts_vydaje_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
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
MODIFY `zakaznici_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
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
