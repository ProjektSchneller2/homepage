-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 10. Mrz 2015 um 15:47
-- Server Version: 5.6.21
-- PHP-Version: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `dhbw_ca_prod`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cert`
--

CREATE TABLE IF NOT EXISTS `cert` (
`id` int(8) unsigned NOT NULL,
  `user` varchar(150) NOT NULL,
  `csr_pfad` varchar(150) NOT NULL,
  `crt_pfad` varchar(150) DEFAULT NULL,
  `laufzeit` varchar(150) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `csr_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `crt_timestamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `login`
--

CREATE TABLE IF NOT EXISTS `login` (
`id` int(8) unsigned NOT NULL,
  `username` varchar(150) NOT NULL,
  `passwort` varchar(32) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `login`
--

INSERT INTO `login` (`id`, `username`, `passwort`) VALUES
(1, 'test', '098f6bcd4621d373cade4e832627b4f6');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `cert`
--
ALTER TABLE `cert`
 ADD PRIMARY KEY (`id`), ADD KEY `user` (`user`), ADD KEY `user_2` (`user`);

--
-- Indizes für die Tabelle `login`
--
ALTER TABLE `login`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `cert`
--
ALTER TABLE `cert`
MODIFY `id` int(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `login`
--
ALTER TABLE `login`
MODIFY `id` int(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
