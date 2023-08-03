-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 29 nov. 2022 à 16:32
-- Version du serveur : 10.4.25-MariaDB
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gtm_sf_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `agency`
--

CREATE TABLE `agency` (
  `id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `is_activited` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `agency`
--

INSERT INTO `agency` (`id`, `city_id`, `libelle`, `reference`, `created_at`, `updated_at`, `is_activited`, `is_deleted`) VALUES
(1, 14, 'PREMICES VOYAGES', '1', '2022-11-17 22:17:25', '2022-11-17 22:17:25', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `airline`
--

CREATE TABLE `airline` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `is_activited` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `image_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_size` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `airline`
--

INSERT INTO `airline` (`id`, `libelle`, `created_at`, `updated_at`, `is_activited`, `is_deleted`, `image_name`, `image_size`) VALUES
(2, 'Aegean Airlines\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(3, 'Aer Lingus\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(4, 'Aeroflot\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(5, 'Aerolineas Argentinas\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(6, 'Aeromexico\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(7, 'Air Arabia\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(8, 'Air Astana\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(9, 'Air Austral\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(10, 'Air Baltic\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(11, 'Air Belgium\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(12, 'Air Canada\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(13, 'Air Caraibes\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(14, 'Air China\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(15, 'Air Corsica\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(16, 'Air Dolomiti\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(17, 'Air Europa\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(18, 'Air France\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(19, 'Air India\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(20, 'Air India Express\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(21, 'Air Macau\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(22, 'Air Malta\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(23, 'Air Mauritius\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(24, 'Air Namibia\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(26, 'Air North\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(27, 'Air Seoul\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(28, 'Air Serbia\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(29, 'Air Tahiti Nui\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(30, 'Air Transat\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(31, 'Air Vanuatu\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(32, 'AirAsia\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(33, 'AirAsia X\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(34, 'Aircalin\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(36, 'Alitalia\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(37, 'Allegiant\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(38, 'American Airlines\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(39, 'ANA\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(40, 'Asiana\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(41, 'Austrian\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(42, 'Avianca\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(44, 'Azores Airlines\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(45, 'Azul\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(46, 'Bamboo Airways\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(47, 'Bangkok Airways\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(48, 'British Airways\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(49, 'Brussels Airlines\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(50, 'Caribbean Airlines\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(51, 'Cathay Dragon\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(52, 'Cathay Pacific\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(53, 'Cayman Airways\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(54, 'CEBU Pacific Air\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(55, 'China Airlines\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(56, 'China Eastern\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(57, 'China Southern\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(58, 'Condor\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(59, 'Copa Airlines\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(60, 'Croatia Airlines\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(61, 'Czech Airlines\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(62, 'Delta\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(63, 'easyJet\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(64, 'Edelweiss Air\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(65, 'Egyptair\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(66, 'EL AL\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(67, 'Emirates\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(68, 'Ethiopian Airlines\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(69, 'Etihad\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(70, 'Eurowings\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(71, 'EVA Air\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(72, 'Fiji Airways\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(73, 'Finnair\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(74, 'flydubai\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(75, 'FlyOne\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(76, 'French bee\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(77, 'Frontier\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(78, 'Garuda Indonesia\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(79, 'Gol\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(80, 'Gulf Air\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(81, 'Hainan Airlines\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(82, 'Hawaiian Airlines\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(83, 'Helvetic Airways\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(84, 'HK Express\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(85, 'Hong Kong Airlines\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(86, 'Iberia\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(88, 'IndiGo Airlines\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(89, 'InterJet\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(90, 'Japan Airlines\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(91, 'Jeju Air\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(92, 'Jet2\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(93, 'JetBlue\r', '2022-11-20 12:12:55', '2022-11-20 12:12:55', 0, 0, '', 0),
(94, 'Jetstar\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(95, 'Jin Air\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(96, 'Kenya Airways\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(97, 'KLM\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(98, 'Korean Air\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(100, 'La Compagnie\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(101, 'LATAM\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(102, 'Lion Airlines\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(103, 'LOT Polish Airlines\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(104, 'Lufthansa\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(105, 'Luxair\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(107, 'Mango\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(108, 'Middle East Airlines\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(109, 'Nok Air\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(110, 'Nordwind Airlines\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(111, 'Norwegian Air International\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(112, 'Norwegian Air Shuttle\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(113, 'Norwegian Air Sweden\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(114, 'Norwegian Air UK\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(115, 'Oman Air\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(116, 'Pakistan International Airlines\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(117, 'Peach\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(118, 'Pegasus Airlines\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(119, 'Philippine Airlines\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(120, 'Porter\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(121, 'Qantas\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(122, 'Qatar Airways\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(123, 'Regional Express\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(124, 'Rossiya - Russian Airlines\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(125, 'Royal Air Maroc', '2022-11-20 12:12:56', '2022-11-24 11:46:34', 1, 0, '386b5e2309e2728a45f79947bc53a649-xl-637f4b8a224e9825108428.jpg', 123216),
(126, 'Royal Brunei\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(127, 'Royal Jordanian\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(128, 'RwandAir\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(129, 'Ryanair\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(130, 'S7 Airlines\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(131, 'SAS\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(132, 'Saudia\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(133, 'Scoot Airlines\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(134, 'Shanghai Airlines\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(135, 'Silkair\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(136, 'Silver\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(137, 'Singapore Airlines\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(139, 'South African Airways\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(140, 'Southwest\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(141, 'SpiceJet\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(142, 'Spirit\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(143, 'Spring Airlines\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(144, 'Spring Japan\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(145, 'SriLankan Airlines\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(146, 'Sun Country\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(148, 'Sunwing\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(149, 'SWISS\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(150, 'Swoop\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(151, 'TAAG\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(152, 'TACA\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(153, 'TAP Portugal\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(154, 'THAI\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(155, 'tigerair Australia\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(156, 'Transavia Airlines\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(157, 'TUI UK\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(158, 'TUIfly\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(159, 'Tunis Air\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(160, 'Turkish Airlines', '2022-11-20 12:12:56', '2022-11-24 13:29:13', 1, 0, '587b50f844060909aa603a7e-637f6399aa615107194883.png', 21556),
(161, 'Ukraine International\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(162, 'United\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(163, 'Ural Airlines\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(164, 'UTair Aviation\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(165, 'Uzbekistan Airways\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(166, 'Vietnam Airlines\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(168, 'Virgin Australia\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(169, 'Vistara\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(170, 'Viva Aerobus\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(172, 'Volotea\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(173, 'Vueling Airlines\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(174, 'WestJet\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(175, 'Wizzair\r', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0),
(176, 'Xiamen Airlines', '2022-11-20 12:12:56', '2022-11-20 12:12:56', 0, 0, '', 0);

-- --------------------------------------------------------

--
-- Structure de la table `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `region_id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `is_activited` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `country_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `city`
--

INSERT INTO `city` (`id`, `region_id`, `libelle`, `created_at`, `updated_at`, `is_activited`, `is_deleted`, `country_id`) VALUES
(4, 3, 'AL HAJEB', '0000-00-00 00:00:00', '2022-11-17 22:29:07', 1, 0, 1),
(5, 9, 'AGADIR', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(6, 1, 'AL HOCEIMA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(7, 10, 'ASSA ZAG', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(8, 5, 'AZILAL', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(9, 5, 'BENI MELLAL', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(10, 6, 'BENSLIMANE', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(11, 11, 'BOUJDOUR', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(12, 3, 'BOULEMANE', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(13, 6, 'BERRECHID', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(14, 6, 'CASABLANCA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(15, 1, 'CHEFCHAOUEN', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(16, 9, 'CHTOUKA AIT BAHA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(17, 7, 'CHICHAOUA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(18, 6, 'EL JADIDA', '0000-00-00 00:00:00', '2022-11-29 15:03:35', 1, 0, 1),
(19, 7, 'EL KELAA DES SRAGHNAS', '0000-00-00 00:00:00', '2022-11-29 15:03:34', 1, 0, 1),
(20, 8, 'ERRACHIDIA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(21, 7, 'ESSAOUIRA', '0000-00-00 00:00:00', '2022-11-29 15:03:32', 1, 0, 1),
(22, 11, 'ES SEMARA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(23, 3, 'FES', '0000-00-00 00:00:00', '2022-11-29 15:03:30', 1, 0, 1),
(24, 2, 'FIGUIG', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(25, 10, 'GUELMIM', '0000-00-00 00:00:00', '2022-11-29 15:04:11', 1, 0, 1),
(26, 3, 'IFRANE', '0000-00-00 00:00:00', '2022-11-29 15:03:29', 1, 0, 1),
(27, 4, 'KENITRA', '0000-00-00 00:00:00', '2022-11-29 15:03:22', 1, 0, 1),
(28, 4, 'KHEMISSET', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(29, 5, 'KHENIFRA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(30, 5, 'KHOURIBGA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(31, 11, 'LAAYOUNE', '0000-00-00 00:00:00', '2022-11-29 15:04:08', 1, 0, 1),
(32, 1, 'LARACHE', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(33, 6, 'MOHAMMEDIA', '0000-00-00 00:00:00', '2022-11-29 15:03:14', 1, 0, 1),
(34, 7, 'MARRAKECH', '0000-00-00 00:00:00', '2022-11-29 15:03:15', 1, 0, 1),
(36, 2, 'NADOR', '0000-00-00 00:00:00', '2022-11-29 15:03:17', 1, 0, 1),
(37, 8, 'OUARZAZATE', '0000-00-00 00:00:00', '2022-11-29 15:03:18', 1, 0, 1),
(38, 2, 'OUJDA', '0000-00-00 00:00:00', '2022-11-29 15:04:06', 1, 0, 1),
(39, 12, 'OUED EDDAHAB', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(40, 4, 'RABAT', '0000-00-00 00:00:00', '2022-11-29 15:04:04', 1, 0, 1),
(41, 4, 'SALE', '0000-00-00 00:00:00', '2022-11-29 15:04:00', 1, 0, 1),
(42, 4, 'SKHIRAT TEMARA', '0000-00-00 00:00:00', '2022-11-29 15:04:00', 1, 0, 1),
(43, 3, 'SEFROU', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(44, 7, 'SAFI', '0000-00-00 00:00:00', '2022-11-29 15:03:58', 1, 0, 1),
(45, 6, 'SETTAT', '0000-00-00 00:00:00', '2022-11-29 15:03:56', 1, 0, 1),
(46, 4, 'SIDI KACEM', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(47, 1, 'TANGER', '0000-00-00 00:00:00', '2022-11-29 15:03:55', 1, 0, 1),
(48, 10, 'TAN TAN', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(49, 3, 'TAOUNAT', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(50, 9, 'TAROUDANNT', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(51, 9, 'TATA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(52, 3, 'TAZA', '0000-00-00 00:00:00', '2022-11-29 15:03:50', 1, 0, 1),
(53, 1, 'TETOUAN', '0000-00-00 00:00:00', '2022-11-29 15:03:49', 1, 0, 1),
(54, 9, 'TIZNIT', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(92, 6, 'AZEMMOUR', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(103, 8, 'Midelt', '0000-00-00 00:00:00', '2022-11-29 15:03:46', 1, 0, 1),
(104, 3, 'MEKNES', '0000-00-00 00:00:00', '2022-11-29 15:03:45', 1, 0, 1),
(111, 3, 'OUAZZANE', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1),
(112, 1, 'Driouch', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 27, 1),
(114, 1, 'BERKANE', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 14, 0, 1),
(115, 2, 'GUERCIF', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 14, 0, 1),
(116, 8, 'ERRACHIDIA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 14, 0, 1),
(117, 5, 'OUED ZEM', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 14, 0, 1),
(118, 8, 'ERFOUD', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 14, 0, 1),
(119, 4, 'SIDI SLIMANE', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 14, 0, 1),
(120, 8, 'Goulmima', '0000-00-00 00:00:00', '2022-11-29 15:02:57', 0, 0, 1),
(121, 1, 'KSAR EL KEBIR', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 20, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `is_activited` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `country`
--

INSERT INTO `country` (`id`, `libelle`, `created_at`, `updated_at`, `is_activited`, `is_deleted`) VALUES
(1, 'Maroc', '2022-11-17 11:07:06', '2022-11-17 11:07:06', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20221102085446', '2022-11-02 09:55:10', 260);

-- --------------------------------------------------------

--
-- Structure de la table `hook`
--

CREATE TABLE `hook` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `is_activited` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `hook`
--

INSERT INTO `hook` (`id`, `libelle`, `created_at`, `updated_at`, `is_activited`, `is_deleted`, `alias`) VALUES
(1, 'Entête', '2022-11-29 09:30:52', '2022-11-29 09:30:52', 1, 0, 'HEADER'),
(2, 'Page d\'accueil', '2022-11-29 09:31:14', '2022-11-29 09:31:14', 1, 0, 'HOME_PAGE');

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `messenger_messages`
--

INSERT INTO `messenger_messages` (`id`, `body`, `headers`, `queue_name`, `created_at`, `available_at`, `delivered_at`) VALUES
(1, 'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:39:\\\"Symfony\\\\Bridge\\\\Twig\\\\Mime\\\\TemplatedEmail\\\":4:{i:0;s:41:\\\"registration/confirmation_email.html.twig\\\";i:1;N;i:2;a:3:{s:9:\\\"signedUrl\\\";s:170:\\\"https://127.0.0.1:8000/verify/email?expires=1667382921&signature=1pSesPOx%2BtzS66Hjao%2BRECTkLHd7eNbMcAyS74dbi%2F8%3D&token=X1GwPMZIjKJhTOhK4GgEDlOxQ7ck7I0RxqVpjWqsE1Q%3D\\\";s:19:\\\"expiresAtMessageKey\\\";s:26:\\\"%count% hour|%count% hours\\\";s:20:\\\"expiresAtMessageData\\\";a:1:{s:7:\\\"%count%\\\";i:1;}}i:3;a:6:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:3:{s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:22:\\\"no-reply@lhotse.agency\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:22:\\\"LHOTSE AGENCY Mail Bot\\\";}}}}s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:17:\\\"87yahya@gmail.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:30:\\\"Veuillez confirmer votre email\\\";}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}', '[]', 'default', '2022-11-02 09:55:21', '2022-11-02 09:55:21', NULL),
(2, 'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:39:\\\"Symfony\\\\Bridge\\\\Twig\\\\Mime\\\\TemplatedEmail\\\":4:{i:0;s:41:\\\"registration/confirmation_email.html.twig\\\";i:1;N;i:2;a:3:{s:9:\\\"signedUrl\\\";s:172:\\\"https://127.0.0.1:8000/verify/email?expires=1667836957&signature=Y09K6%2BCe1LuMqQIJOv3zhlLMzAWIAbs9rUrMXCDolrQ%3D&token=4%2F%2BvlfKkgS6xyqC%2FdjbWEJ7EBvxMu4jZS2NtLMrtENg%3D\\\";s:19:\\\"expiresAtMessageKey\\\";s:26:\\\"%count% hour|%count% hours\\\";s:20:\\\"expiresAtMessageData\\\";a:1:{s:7:\\\"%count%\\\";i:1;}}i:3;a:6:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:3:{s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:22:\\\"no-reply@lhotse.agency\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:22:\\\"LHOTSE AGENCY Mail Bot\\\";}}}}s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:17:\\\"87yahya@gmail.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:30:\\\"Veuillez confirmer votre email\\\";}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}', '[]', 'default', '2022-11-07 16:02:37', '2022-11-07 16:02:37', NULL),
(3, 'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:39:\\\"Symfony\\\\Bridge\\\\Twig\\\\Mime\\\\TemplatedEmail\\\":4:{i:0;s:41:\\\"registration/confirmation_email.html.twig\\\";i:1;N;i:2;a:3:{s:9:\\\"signedUrl\\\";s:166:\\\"https://127.0.0.1:8000/verify/email?expires=1667837192&signature=KZ8vY0rXaOjHqaXNcipCpLVKds2tiD0fqQWZyeW1rzg%3D&token=%2BfVPNiTJhTU1A6c0YtjWtzBfKHJcFnKn9yC0dkmrQy8%3D\\\";s:19:\\\"expiresAtMessageKey\\\";s:26:\\\"%count% hour|%count% hours\\\";s:20:\\\"expiresAtMessageData\\\";a:1:{s:7:\\\"%count%\\\";i:1;}}i:3;a:6:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:3:{s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:22:\\\"no-reply@lhotse.agency\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:22:\\\"LHOTSE AGENCY Mail Bot\\\";}}}}s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:17:\\\"87yahya@gmail.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:30:\\\"Veuillez confirmer votre email\\\";}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}', '[]', 'default', '2022-11-07 16:06:32', '2022-11-07 16:06:32', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `module`
--

CREATE TABLE `module` (
  `id` int(11) NOT NULL,
  `name_in_db` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_parameter` tinyint(1) NOT NULL DEFAULT 0,
  `is_dictionnary` tinyint(1) NOT NULL DEFAULT 0,
  `is_module` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `is_activited` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `module`
--

INSERT INTO `module` (`id`, `name_in_db`, `libelle`, `icon`, `is_parameter`, `is_dictionnary`, `is_module`, `created_at`, `updated_at`, `is_activited`, `is_deleted`) VALUES
(1, 'city', 'Ville', 'la-city', 0, 1, 0, '2022-11-09 13:36:27', '2022-11-09 13:36:27', 1, 0),
(2, 'role', 'Rôle', 'la-user-cog', 1, 0, 0, '2022-11-09 13:41:44', '2022-11-19 23:26:25', 1, 0),
(3, 'region', 'Région', 'la-users-cog', 0, 1, 0, '2022-11-09 15:46:37', '2022-11-09 15:46:37', 1, 0),
(4, 'country', 'Pays', 'la-city', 0, 1, 0, '2022-11-17 10:57:49', '2022-11-17 10:57:49', 1, 0),
(5, 'agency', 'Agence', 'la-building', 0, 0, 1, '2022-11-17 11:40:06', '2022-11-20 09:32:29', 1, 0),
(6, 'airline', 'Companie aériene', 'la-plane', 0, 1, 0, '2022-11-19 23:18:26', '2022-11-19 23:18:26', 1, 0),
(7, 'parameter', 'Paramètre', 'la-cog', 1, 0, 0, '2022-11-20 09:37:26', '2022-11-20 09:37:26', 1, 0),
(8, 'program', 'Programme', 'la-file-alt', 0, 0, 1, '2022-11-24 13:37:33', '2022-11-24 13:37:33', 1, 0),
(9, 'segment', 'Segment', 'la-plane-departure', 0, 0, 1, '2022-11-24 15:02:39', '2022-11-24 15:05:05', 1, 0),
(10, 'travel_agent', 'Agent de voyage', 'la-user-astronaut', 0, 0, 1, '2022-11-25 14:59:35', '2022-11-25 16:16:42', 1, 0),
(11, 'hook', 'Emplacement', 'la-anchor', 0, 0, 0, '2022-11-28 16:26:52', '2022-11-29 11:02:19', 1, 0),
(12, 'widget', 'Widget', 'la-plug', 0, 0, 0, '2022-11-29 08:59:38', '2022-11-29 11:02:15', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `parameter`
--

CREATE TABLE `parameter` (
  `id` int(11) NOT NULL,
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `is_activited` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `parameter`
--

INSERT INTO `parameter` (`id`, `alias`, `value`, `created_at`, `updated_at`, `is_activited`, `is_deleted`) VALUES
(1, 'SEND_MAIL', '1', '2022-11-20 10:36:46', '2022-11-20 10:36:46', 1, 0),
(2, 'LOGIN_ATTEMPT', '5', '2022-11-20 10:36:59', '2022-11-20 10:36:59', 1, 0),
(3, 'MAINTENANCE', '0', '2022-11-20 10:37:16', '2022-11-20 10:37:16', 1, 0),
(4, 'AVIS_MAINTENANCE', 'Indisponibilité temporaire pour cause de maintenance. Veuillez revenir dans un instant', '2022-11-20 10:40:02', '2022-11-20 10:40:02', 1, 0),
(5, 'SORT_DAYCOUNT_LIMIT', '7', '2022-11-20 10:40:47', '2022-11-20 10:40:47', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `price_range`
--

CREATE TABLE `price_range` (
  `id` int(11) NOT NULL,
  `nb_of_seats` int(11) NOT NULL,
  `purchase_price` decimal(10,6) NOT NULL,
  `profit_margin` decimal(10,6) NOT NULL,
  `gain_threshold` int(11) NOT NULL,
  `apply_date` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `is_activited` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `is_activited` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `profile`
--

INSERT INTO `profile` (`id`, `libelle`, `created_at`, `updated_at`, `is_activited`, `is_deleted`) VALUES
(1, 'Super Administrateur', '2022-11-17 10:49:55', '2022-11-17 11:30:50', 1, 0),
(2, 'Administrateur', '2022-11-20 09:35:58', '2022-11-20 09:35:58', 1, 0),
(3, 'Chef Agence', '2022-11-20 09:36:32', '2022-11-20 09:36:32', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `programm`
--

CREATE TABLE `programm` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departure_date` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `return_date` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `over_view` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `is_activited` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `programm`
--

INSERT INTO `programm` (`id`, `libelle`, `departure_date`, `return_date`, `over_view`, `created_at`, `updated_at`, `is_activited`, `is_deleted`) VALUES
(1, 'test', '2022-11-24 12:00:00', '2022-11-26 07:30:00', '<p>hhhhhhhhhhhhh</p>', '2022-11-24 14:20:35', '2022-11-25 12:22:07', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `region`
--

CREATE TABLE `region` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `is_activited` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `region`
--

INSERT INTO `region` (`id`, `libelle`, `created_at`, `updated_at`, `is_activited`, `is_deleted`) VALUES
(1, 'Tanger-Tétouan-Al Hoceïma', '2022-11-16 16:20:49', '2022-11-16 16:20:49', 1, 0),
(2, 'L\'Oriental', '2022-11-16 16:20:49', '2022-11-16 16:20:49', 1, 0),
(3, 'Fès-Meknès', '2022-11-16 16:20:49', '2022-11-16 16:20:49', 1, 0),
(4, 'Rabat-Salé-Kénitra', '2022-11-16 16:20:49', '2022-11-16 16:20:49', 1, 0),
(5, 'Béni Mellal-Khénifra', '2022-11-16 16:20:49', '2022-11-16 16:20:49', 1, 0),
(6, 'Casablanca-Settat', '2022-11-16 16:20:49', '2022-11-16 16:20:49', 1, 0),
(7, 'Marrakech-Safi', '2022-11-16 16:20:49', '2022-11-16 16:20:49', 1, 0),
(8, 'Drâa-Tafilalet', '2022-11-16 16:20:49', '2022-11-16 16:20:49', 1, 0),
(9, 'Souss-Massa', '2022-11-16 16:20:49', '2022-11-16 16:20:49', 1, 0),
(10, 'Guelmim-Oued Noun', '2022-11-16 16:20:49', '2022-11-16 16:20:49', 1, 0),
(11, 'Laâyoune-Sakia El Hamra', '2022-11-16 16:20:49', '2022-11-16 16:20:49', 1, 0),
(12, 'Dakhla-Oued Ed Dahab', '2022-11-16 16:20:49', '2022-11-16 16:20:49', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `is_activited` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `libelle`, `alias`, `created_at`, `updated_at`, `is_activited`, `is_deleted`) VALUES
(1, 'Super Administrateur', 'ROLE_SUPER_ADMIN', '2022-11-28 11:32:16', '2022-11-28 11:32:16', 1, 0),
(2, 'Administrateur', 'ROLE_ADMIN', '2022-11-28 11:32:28', '2022-11-28 11:32:28', 1, 0),
(3, 'Chef Agence', 'ROLE_AGENCY_MANAGER', '2022-11-28 11:32:48', '2022-11-28 11:32:48', 1, 0),
(4, 'Utilisateur', 'ROLE_USER', '2022-11-28 11:33:05', '2022-11-28 15:39:03', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `segment`
--

CREATE TABLE `segment` (
  `id` int(11) NOT NULL,
  `programm_id` int(11) DEFAULT NULL,
  `airline_id` int(11) DEFAULT NULL,
  `plane` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departure_date` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `return_date` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `is_activited` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `traveller`
--

CREATE TABLE `traveller` (
  `id` int(11) NOT NULL,
  `city_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passport_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_issue` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `expiration_date` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `is_activited` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `travel_agent`
--

CREATE TABLE `travel_agent` (
  `id` int(11) NOT NULL,
  `id_user_id` int(11) DEFAULT NULL,
  `id_agency_id` int(11) DEFAULT NULL,
  `registration_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `is_activited` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_size` int(11) NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `is_activited` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `first_name`, `last_name`, `roles`, `email`, `phone`, `image_name`, `image_size`, `password`, `is_verified`, `created_at`, `updated_at`, `is_activited`, `is_deleted`) VALUES
(3, '87yahya', 'YAHYA', 'Ali', '[\"ROLE_SUPER_ADMIN\"]', '87yahya@gmail.com', '0613180160', '20191212-002050-6384cf08b8652900978962.jpg', 1752253, '$2y$13$y4cMHuabxy53CJMMxckuYeAtdkJShgicRYn/V5Uen5zXtxw0evoTW', 1, '2022-11-07 16:06:32', '2022-11-28 16:08:56', 1, 0),
(4, 'zineb', 'LACHGUER', 'Zineb', '[\"ROLE_AGENCY_MANAGER\"]', 'lachguerzineb76@gmail.com', NULL, '', 0, '$2y$13$iY3v9DVvp6Oge5SjSmEX1OWHYRtp9pvkWVH1mwytdWOCQlU5nJs3G', 0, '2022-11-28 14:41:50', '2022-11-28 15:36:17', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `widget`
--

CREATE TABLE `widget` (
  `id` int(11) NOT NULL,
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hook_id` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `icon_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bg_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `is_activited` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `widget`
--

INSERT INTO `widget` (`id`, `alias`, `hook_id`, `module_id`, `icon_color`, `bg_color`, `created_at`, `updated_at`, `is_activited`, `is_deleted`, `libelle`, `mode`) VALUES
(1, 'WebApp', 1, NULL, '', '', '2022-11-29 09:48:41', '2022-11-29 13:55:08', 1, 0, 'Web Apps', ''),
(2, 'MyCart', 1, NULL, '', '', '2022-11-29 10:58:19', '2022-11-29 13:55:20', 0, 0, 'Mon Panier', ''),
(3, 'Notifications', 1, NULL, '', '', '2022-11-29 10:59:00', '2022-11-29 13:55:23', 0, 0, 'Notifications', ''),
(4, 'FullScreenBtn', 1, NULL, '', '', '2022-11-29 10:59:35', '2022-11-29 13:55:27', 1, 0, 'Bouton Plein  écran', ''),
(5, 'LightDarkModeBtn', 1, NULL, '', '', '2022-11-29 11:00:46', '2022-11-29 14:01:45', 1, 0, 'Bouton Mode Jour/Nuit', ''),
(6, 'bloc1', 2, NULL, 'light', 'primary', '2022-11-29 13:09:24', '2022-11-29 15:10:00', 0, 0, 'TENDANCE GLOBALE', ''),
(7, 'bloc1', 2, 1, 'success', '', '2022-11-29 13:19:32', '2022-11-29 15:09:43', 1, 0, NULL, 'ed'),
(8, 'bloc1', 2, 6, 'info', 'light', '2022-11-29 16:30:52', '2022-11-29 16:30:52', 1, 0, NULL, 'ed');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `agency`
--
ALTER TABLE `agency`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_70C0C6E68BAC62AF` (`city_id`);

--
-- Index pour la table `airline`
--
ALTER TABLE `airline`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2D5B023498260155` (`region_id`),
  ADD KEY `IDX_2D5B0234F92F3E70` (`country_id`);

--
-- Index pour la table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `hook`
--
ALTER TABLE `hook`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `parameter`
--
ALTER TABLE `parameter`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `price_range`
--
ALTER TABLE `price_range`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `programm`
--
ALTER TABLE `programm`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `segment`
--
ALTER TABLE `segment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1881F565B75CCC90` (`programm_id`),
  ADD KEY `IDX_1881F565130D0C16` (`airline_id`);

--
-- Index pour la table `traveller`
--
ALTER TABLE `traveller`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_92E7B4278BAC62AF` (`city_id`),
  ADD KEY `IDX_92E7B427F92F3E70` (`country_id`);

--
-- Index pour la table `travel_agent`
--
ALTER TABLE `travel_agent`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8E271B2B79F37AE5` (`id_user_id`),
  ADD KEY `IDX_8E271B2B4DDF670D` (`id_agency_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`);

--
-- Index pour la table `widget`
--
ALTER TABLE `widget`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_85F91ED0B2D2ECCF` (`hook_id`),
  ADD KEY `IDX_85F91ED0AFC2B591` (`module_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `agency`
--
ALTER TABLE `agency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `airline`
--
ALTER TABLE `airline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;

--
-- AUTO_INCREMENT pour la table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT pour la table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `hook`
--
ALTER TABLE `hook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `module`
--
ALTER TABLE `module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `parameter`
--
ALTER TABLE `parameter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `price_range`
--
ALTER TABLE `price_range`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `programm`
--
ALTER TABLE `programm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `region`
--
ALTER TABLE `region`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `segment`
--
ALTER TABLE `segment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `traveller`
--
ALTER TABLE `traveller`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `travel_agent`
--
ALTER TABLE `travel_agent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `widget`
--
ALTER TABLE `widget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `agency`
--
ALTER TABLE `agency`
  ADD CONSTRAINT `FK_70C0C6E68BAC62AF` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`);

--
-- Contraintes pour la table `city`
--
ALTER TABLE `city`
  ADD CONSTRAINT `FK_2D5B023498260155` FOREIGN KEY (`region_id`) REFERENCES `region` (`id`),
  ADD CONSTRAINT `FK_2D5B0234F92F3E70` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`);

--
-- Contraintes pour la table `segment`
--
ALTER TABLE `segment`
  ADD CONSTRAINT `FK_1881F565130D0C16` FOREIGN KEY (`airline_id`) REFERENCES `airline` (`id`),
  ADD CONSTRAINT `FK_1881F565B75CCC90` FOREIGN KEY (`programm_id`) REFERENCES `programm` (`id`);

--
-- Contraintes pour la table `traveller`
--
ALTER TABLE `traveller`
  ADD CONSTRAINT `FK_92E7B4278BAC62AF` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`),
  ADD CONSTRAINT `FK_92E7B427F92F3E70` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`);

--
-- Contraintes pour la table `travel_agent`
--
ALTER TABLE `travel_agent`
  ADD CONSTRAINT `FK_8E271B2B4DDF670D` FOREIGN KEY (`id_agency_id`) REFERENCES `agency` (`id`),
  ADD CONSTRAINT `FK_8E271B2B79F37AE5` FOREIGN KEY (`id_user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `widget`
--
ALTER TABLE `widget`
  ADD CONSTRAINT `FK_85F91ED0AFC2B591` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`),
  ADD CONSTRAINT `FK_85F91ED0B2D2ECCF` FOREIGN KEY (`hook_id`) REFERENCES `hook` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
