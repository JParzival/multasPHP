-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2018 at 10:35 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database_multas`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `credencial_admin` varchar(255) NOT NULL,
  `password_admin` varchar(255) NOT NULL,
  `nombre_admin` varchar(255) NOT NULL,
  `apellidos_admin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`credencial_admin`, `password_admin`, `nombre_admin`, `apellidos_admin`) VALUES
('123456789', '12345', 'ADMINITO1', 'BANEADOR1'),
('123456790', '12345', 'ADMINITO2', 'BANEADOR2');

-- --------------------------------------------------------

--
-- Table structure for table `coches`
--

CREATE TABLE `coches` (
  `n_bastidor` varchar(50) NOT NULL,
  `matricula` varchar(10) NOT NULL,
  `year` int(11) NOT NULL,
  `color` varchar(50) NOT NULL,
  `potencia_cv` int(4) NOT NULL,
  `credencial` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `coches`
--

INSERT INTO `coches` (`n_bastidor`, `matricula`, `year`, `color`, `potencia_cv`, `credencial`) VALUES
('123456789', '0000BBB', 2008, 'OCASO CREMOSO', 110, '12345678P'),
('987654321', '0001BBB', 2009, 'OCASO CREMTITA', 101, '12345679P'),
('135792468', '0002BBB', 2010, 'ROJO', 140, '12345678P');

-- --------------------------------------------------------

--
-- Table structure for table `infractor`
--

CREATE TABLE `infractor` (
  `credencial` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `tlf` int(9) NOT NULL,
  `f_exp_carnet` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `infractor`
--

INSERT INTO `infractor` (`credencial`, `password`, `nombre`, `apellidos`, `tlf`, `f_exp_carnet`) VALUES
('12345678P', 'PASSWORD', 'PRUEBA1', 'PRUEBAAPE1', 600000000, '1996-11-28'),
('12345679P', 'PASSWORD', 'PRUEBA2', 'PRUEBAAPE2', 600000001, '1996-11-29');

-- --------------------------------------------------------

--
-- Table structure for table `multas`
--

CREATE TABLE `multas` (
  `id` int(11) NOT NULL,
  `razon` varchar(255) NOT NULL,
  `fecha` date NOT NULL,
  `reclamada` tinyint(1) NOT NULL DEFAULT '0',
  `direccion` varchar(255) NOT NULL,
  `precio` float NOT NULL,
  `estado` int(1) NOT NULL,
  `n_bastidor` varchar(50) NOT NULL,
  `credencial` varchar(255) NOT NULL,
  `admin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `multas`
--

INSERT INTO `multas` (`id`, `razon`, `fecha`, `reclamada`, `direccion`, `precio`, `estado`, `n_bastidor`, `credencial`, `admin`) VALUES
(1, 'Velocidad', '2018-12-01', 0, 'Direccion', 20.3, 0, '123456789', '12345678P', '123456789'),
(2, 'Aparcamiento', '2018-11-04', 1, 'Direccion2', 10, 0, '987654321', '12345679P', '123456789'),
(3, 'Saltarse un semaforo', '2012-12-12', 1, 'Direccion3', 2000, 0, '123456789', '12345678P', '123456789'),
(4, 'Saltarse un stop', '2012-12-12', 1, 'Direccion4', 2000, 0, '987654321', '12345679P', '123456789'),
(5, 'Aparcamiento', '2012-11-01', 0, 'Direccion5', 213, 1, '123456789', '12345678P', '123456789');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`credencial_admin`);

--
-- Indexes for table `coches`
--
ALTER TABLE `coches`
  ADD PRIMARY KEY (`n_bastidor`),
  ADD KEY `credencial` (`credencial`);

--
-- Indexes for table `infractor`
--
ALTER TABLE `infractor`
  ADD PRIMARY KEY (`credencial`);

--
-- Indexes for table `multas`
--
ALTER TABLE `multas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `n_bastidor` (`n_bastidor`),
  ADD KEY `credencial` (`credencial`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `multas`
--
ALTER TABLE `multas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `coches`
--
ALTER TABLE `coches`
  ADD CONSTRAINT `coches_ibfk_1` FOREIGN KEY (`credencial`) REFERENCES `infractor` (`credencial`);

--
-- Constraints for table `multas`
--
ALTER TABLE `multas`
  ADD CONSTRAINT `multas_ibfk_1` FOREIGN KEY (`n_bastidor`) REFERENCES `coches` (`n_bastidor`),
  ADD CONSTRAINT `multas_ibfk_2` FOREIGN KEY (`credencial`) REFERENCES `infractor` (`credencial`),
  ADD CONSTRAINT `multas_ibfk_3` FOREIGN KEY (`admin`) REFERENCES `admins` (`credencial_admin`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
