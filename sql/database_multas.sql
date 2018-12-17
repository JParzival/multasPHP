SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `admins` (
  `credencial_admin` varchar(255) NOT NULL,
  `password_admin` varchar(255) NOT NULL,
  `nombre_admin` varchar(255) NOT NULL,
  `apellidos_admin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `coches` (
  `n_bastidor` varchar(50) NOT NULL,
  `matricula` varchar(10) NOT NULL,
  `year` int(11) NOT NULL,
  `color` varchar(50) NOT NULL,
  `potencia_cv` int(4) NOT NULL,
  `credencial` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `infractor` (
  `credencial` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `tlf` int(9) NOT NULL,
  `f_exp_carnet` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `multas` (
  `id` int(11) NOT NULL,
  `razon` varchar(255) NOT NULL,
  `fecha` date NOT NULL,
  `reclamada` tinyint(1) NOT NULL DEFAULT '0',
  `direccion` varchar(255) NOT NULL,
  `precio` float NOT NULL,
  `estado` int(1) NOT NULL,
  `n_bastidor` varchar(50) NOT NULL,
  `credencial` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `admins`
  ADD PRIMARY KEY (`credencial_admin`);

ALTER TABLE `coches`
  ADD PRIMARY KEY (`n_bastidor`),
  ADD KEY `credencial` (`credencial`);

ALTER TABLE `infractor`
  ADD PRIMARY KEY (`credencial`);

ALTER TABLE `multas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `n_bastidor` (`n_bastidor`),
  ADD KEY `credencial` (`credencial`);


ALTER TABLE `multas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;


ALTER TABLE `coches`
  ADD CONSTRAINT `coches_ibfk_1` FOREIGN KEY (`credencial`) REFERENCES `infractor` (`credencial`);

ALTER TABLE `multas`
  ADD CONSTRAINT `multas_ibfk_2` FOREIGN KEY (`credencial`) REFERENCES `infractor` (`credencial`),
  ADD CONSTRAINT `multas_ibfk_1` FOREIGN KEY (`n_bastidor`) REFERENCES `coches` (`n_bastidor`);
