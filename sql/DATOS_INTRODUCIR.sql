INSERT INTO `admins` (`credencial_admin`, `password_admin`, `nombre_admin`, `apellidos_admin`) VALUES
('123456789', '12345', 'ADMINITO1', 'BANEADOR1'),
('123456790', '12345', 'ADMINITO2', 'BANEADOR2');

INSERT INTO `infractor` (`credencial`, `password`, `nombre`, `apellidos`, `tlf`, `f_exp_carnet`) VALUES
('012345678P', 'PASSWORD', 'PRUEBA1', 'PRUEBAAPE1', 600000000, '1996-11-28'),
('012345679P', 'PASSWORD', 'PRUEBA2', 'PRUEBAAPE2', 600000001, '1996-11-29'),

INSERT INTO `coches` (`n_bastidor`, `matricula`, `year`, `color`, `potencia_cv`, `credencial`) VALUES
('PRUEBABASTIDOR1', '0000BBB', 2008, 'OCASO CREMOSO', 110, '012345678P'),
('PRUEBABASTIDOR2', '0001BBB', 2009, 'OCASO CREMTITA', 101, '012345679P'),
('PRUEBABASTIDOR3', '0002BBB', 2010, 'ROJO', 140, '012345678P');

INSERT INTO `multas` (`id`, `razon`, `fecha`, `reclamada`, `direccion`, `precio`, `estado`, `n_bastidor`, `credencial`) VALUES
(1, 'Velocidad', '2018-12-01', 0, 'Direccion', 20.3, 0, 'PRUEBABASTIDOR1', '012345678P'),
(2, 'Aparcamiento', '2018-11-04', 1, 'Direccion2', 10, 0, 'PRUEBABASTIDOR2', '012345679P'),
(3, 'Saltarse un semaforo', '2012-12-12', 1, 'Direccion3', 2000, 0, 'PRUEBABASTIDOR1', '012345678P'),
(4, 'Saltarse un stop', '2012-12-12', 1, 'Direccion4', 2000, 0, 'PRUEBABASTIDOR2', '012345679P'),
(5, 'Aparcamiento', '2012-11-01', 0, 'Direccion5', 213, 1, 'PRUEBABASTIDOR1', '012345678P');
