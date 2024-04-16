-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 16 apr 2024 kl 10:21
-- Serverversion: 10.4.28-MariaDB
-- PHP-version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `2024_dyn_uppg7_carpage`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `table_body_style`
--

CREATE TABLE `table_body_style` (
  `body_style_id` int(11) NOT NULL,
  `body_style_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `table_body_style`
--

INSERT INTO `table_body_style` (`body_style_id`, `body_style_name`) VALUES
(1, 'Sedan'),
(2, 'Kombi'),
(3, 'Halvkombi'),
(4, 'Stadsjeep'),
(5, 'Kupé'),
(6, 'Cabriolet'),
(7, 'Minibuss');

-- --------------------------------------------------------

--
-- Tabellstruktur `table_cars`
--

CREATE TABLE `table_cars` (
  `cars_id` int(11) NOT NULL,
  `cars_model` varchar(255) NOT NULL,
  `cars_brand` varchar(255) NOT NULL,
  `cars_mileage` int(11) NOT NULL,
  `cars_model_year` year(4) NOT NULL,
  `cars_price` decimal(10,2) NOT NULL,
  `cars_hp` int(11) NOT NULL,
  `cars_displacement` decimal(4,2) NOT NULL,
  `cars_license` varchar(255) NOT NULL,
  `cars_inspection_date` date NOT NULL,
  `cars_consumption` decimal(3,1) NOT NULL,
  `cars_emissions` int(11) NOT NULL,
  `cars_weight` int(11) NOT NULL,
  `cars_description` text NOT NULL,
  `cars_img` varchar(1000) NOT NULL,
  `cars_owner_fk` int(11) NOT NULL,
  `cars_drivetype_fk` int(11) NOT NULL,
  `cars_fueltype_fk` int(11) NOT NULL,
  `cars_transtype_fk` int(11) NOT NULL,
  `cars_body_style_fk` int(11) NOT NULL,
  `cars_sale_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `table_cars`
--

INSERT INTO `table_cars` (`cars_id`, `cars_model`, `cars_brand`, `cars_mileage`, `cars_model_year`, `cars_price`, `cars_hp`, `cars_displacement`, `cars_license`, `cars_inspection_date`, `cars_consumption`, `cars_emissions`, `cars_weight`, `cars_description`, `cars_img`, `cars_owner_fk`, `cars_drivetype_fk`, `cars_fueltype_fk`, `cars_transtype_fk`, `cars_body_style_fk`, `cars_sale_status`) VALUES
(1, 'Carolla', 'Toyota', 50000, '2020', 30000.00, 0, 0.00, 'CVB-453', '2024-02-14', 0.0, 0, 0, 'Bil :)', '', 1, 1, 1, 1, 3, 0),
(2, 'Civic', 'Honda', 40000, '2014', 20000.00, 0, 0.00, 'DVU-028', '0000-00-00', 0.0, 0, 0, '', 'honda_civic.jpg', 3, 2, 2, 2, 3, 0),
(3, 'Optima GT', 'Kia', 15000, '2016', 26000.00, 241, 2.00, 'BTV-721', '2024-02-15', 8.5, 35, 2120, '', 'Kia_Optima_GT.jpg', 2, 1, 1, 2, 1, 0);

-- --------------------------------------------------------

--
-- Tabellstruktur `table_drive_type`
--

CREATE TABLE `table_drive_type` (
  `drive_type_id` int(11) NOT NULL,
  `drive_type_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `table_drive_type`
--

INSERT INTO `table_drive_type` (`drive_type_id`, `drive_type_name`) VALUES
(1, 'Framhjulsdrift'),
(2, 'Fyrhjulsdrift'),
(3, 'Bakhjulsdrift');

-- --------------------------------------------------------

--
-- Tabellstruktur `table_fuel_type`
--

CREATE TABLE `table_fuel_type` (
  `fuel_type_id` int(11) NOT NULL,
  `fuel_type_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `table_fuel_type`
--

INSERT INTO `table_fuel_type` (`fuel_type_id`, `fuel_type_name`) VALUES
(1, 'Bensin'),
(2, 'Diesel'),
(3, 'Hybrid'),
(4, 'Gas'),
(5, 'El');

-- --------------------------------------------------------

--
-- Tabellstruktur `table_owner`
--

CREATE TABLE `table_owner` (
  `owner_id` int(11) NOT NULL,
  `owner_fname` varchar(255) NOT NULL,
  `owner_lname` varchar(255) NOT NULL,
  `owner_address` varchar(255) NOT NULL,
  `owner_zip` varchar(255) NOT NULL,
  `owner_city` varchar(255) NOT NULL,
  `owner_phone` varchar(255) NOT NULL,
  `owner_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `table_owner`
--

INSERT INTO `table_owner` (`owner_id`, `owner_fname`, `owner_lname`, `owner_address`, `owner_zip`, `owner_city`, `owner_phone`, `owner_email`) VALUES
(1, 'Jon', 'Doe', 'Streetname 7', '10700', 'Citytropolis', '0990000000', 'jon.doe@hotmail.com'),
(2, 'Max', 'Value', 'Great Deal Street 2', '02092', 'Market City', '0790000000', 'max.value@market.com'),
(3, 'Mark', 'Cubic', '', '', '', '', ''),
(4, 'Erik', 'Blomqvist', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Tabellstruktur `table_trans_type`
--

CREATE TABLE `table_trans_type` (
  `trans_type_id` int(11) NOT NULL,
  `trans_type_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `table_trans_type`
--

INSERT INTO `table_trans_type` (`trans_type_id`, `trans_type_name`) VALUES
(1, 'Automat'),
(2, 'Manuell');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `table_body_style`
--
ALTER TABLE `table_body_style`
  ADD PRIMARY KEY (`body_style_id`);

--
-- Index för tabell `table_cars`
--
ALTER TABLE `table_cars`
  ADD PRIMARY KEY (`cars_id`),
  ADD KEY `cars_owner_fk` (`cars_owner_fk`,`cars_drivetype_fk`,`cars_fueltype_fk`,`cars_transtype_fk`,`cars_body_style_fk`),
  ADD KEY `cars_drivetype_fk` (`cars_drivetype_fk`),
  ADD KEY `cars_fueltype_fk` (`cars_fueltype_fk`),
  ADD KEY `cars_transtype_fk` (`cars_transtype_fk`),
  ADD KEY `cars_body_style_fk` (`cars_body_style_fk`);

--
-- Index för tabell `table_drive_type`
--
ALTER TABLE `table_drive_type`
  ADD PRIMARY KEY (`drive_type_id`);

--
-- Index för tabell `table_fuel_type`
--
ALTER TABLE `table_fuel_type`
  ADD PRIMARY KEY (`fuel_type_id`);

--
-- Index för tabell `table_owner`
--
ALTER TABLE `table_owner`
  ADD PRIMARY KEY (`owner_id`);

--
-- Index för tabell `table_trans_type`
--
ALTER TABLE `table_trans_type`
  ADD PRIMARY KEY (`trans_type_id`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `table_body_style`
--
ALTER TABLE `table_body_style`
  MODIFY `body_style_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT för tabell `table_cars`
--
ALTER TABLE `table_cars`
  MODIFY `cars_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT för tabell `table_drive_type`
--
ALTER TABLE `table_drive_type`
  MODIFY `drive_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT för tabell `table_fuel_type`
--
ALTER TABLE `table_fuel_type`
  MODIFY `fuel_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT för tabell `table_owner`
--
ALTER TABLE `table_owner`
  MODIFY `owner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT för tabell `table_trans_type`
--
ALTER TABLE `table_trans_type`
  MODIFY `trans_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `table_cars`
--
ALTER TABLE `table_cars`
  ADD CONSTRAINT `table_cars_ibfk_1` FOREIGN KEY (`cars_owner_fk`) REFERENCES `table_owner` (`owner_id`),
  ADD CONSTRAINT `table_cars_ibfk_2` FOREIGN KEY (`cars_drivetype_fk`) REFERENCES `table_drive_type` (`drive_type_id`),
  ADD CONSTRAINT `table_cars_ibfk_3` FOREIGN KEY (`cars_fueltype_fk`) REFERENCES `table_fuel_type` (`fuel_type_id`),
  ADD CONSTRAINT `table_cars_ibfk_4` FOREIGN KEY (`cars_transtype_fk`) REFERENCES `table_trans_type` (`trans_type_id`),
  ADD CONSTRAINT `table_cars_ibfk_5` FOREIGN KEY (`cars_body_style_fk`) REFERENCES `table_body_style` (`body_style_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
