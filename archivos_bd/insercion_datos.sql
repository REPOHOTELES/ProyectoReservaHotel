/*
 * INSERCIÓN DE DATOS EN TABLAS
 * AUTOR: GRUPO 3 SW2
 * VERSIÓN: 1.0
 */

-- inserción de cargos

INSERT INTO cargos (nombre_cargo) VALUES 
('Director/a administrativo/a'),('Coordinador/a'),('Recepcionista'),('Camarero/a'),('Superusuario');

-- inserción tipos de habitaciones

INSERT INTO tipos_habitacion (nombre_tipo_habitacion) VALUES
('SENCILLA'),("PAREJA"),("DOBLE"),("TRIPLE"),("SUITE"),("TRIPLE");

-- inserción de habitaciones

INSERT INTO habitaciones (id_tipo_habitacion, numero_habitacion, fuera_de_servicio) VALUES
(1, 201, 0),
(2, 202, 0),
(1, 301, 0),
(1, 302, 0),
(1, 303, 0),
(3, 304, 0),
(1, 401, 0),
(1, 402, 0),
(1, 403, 0),
(3, 404, 0),
(1, 501, 0),
(1, 502, 0),
(1, 503, 0),
(3, 504, 0),
(1, 601, 0),
(1, 602, 0),
(4, 603, 0);


-- inserción tarifas de prueba

INSERT INTO tarifas (id_tarifa, id_tipo_habitacion, cantidad_huespedes, valor_ocupacion, predeterminado) VALUES 
('1', '1', 'S', '50000', '0'), 
('2', '2', 'P', '60000', '0');


-- inserción profesiones de prueba

INSERT INTO profesiones (nombre_profesion) VALUES 
('INGENIERO'), ('ECONOMINSTA'), ('ESTUDIANTE'), ('CONDUCTOR'), ('MECÁNICO'), ('MODISTA'), ('ESTILISTA'), ('PANADERO');

-- INSERCIÓN DE TIPOS DE PROYECTOS
INSERT INTO tipos_producto (nombre_tipo_producto) VALUES
('BEBIDAS ALCOHÓLICAS'),
('ASEO'),
('BEBIDAS GASEOSAS'),
('GALGUERIAS'),
('GALLETAS'),
('CHOCOLATINAS');

-- inserción usuarios administradores

INSERT INTO personas(id_lugar_nacimiento,id_lugar_expedicion,nombres_persona,apellidos_persona,
	tipo_documento,numero_documento,genero_persona,fecha_nacimiento,tipo_sangre_rh,
	telefono_persona,correo_persona, tipo_persona, id_cargo, nombre_usuario, contrasena_usuario) VALUES
(40040, 39828,'WILLIAM JULIAN','CASTANEDA RUIZ','CC','1000000000','M','2000-03-10','O+','3000000000',NULL, 'U',5,'william.castaneda',md5('admin')),
(40040, 39828,'EMERSON','VARGAS','CC','1111111111','M','1999-05-29','A+','3100000000',NULL, 'U',5,'emerson.vargas',md5('admin'));

-- INSERCIÓN DE PRODUCTOS
INSERT INTO productos (id_tipo_producto, nombre_producto, valor_producto) VALUES 
(1, 'CERVEZA ANDINA', 3600),
(1, 'CERVEZA CORONA', 7000),
(1, 'WHISKY PASSPORT', 60000),
(1, 'VINO DE LA SUIT', 70000),
(2, 'PAÑUELITOS FAMILIA', 2500),
(2, 'GEL FIJADOR EGO', 2000),
(2, 'CEPILLO DENTAL', 2500),
(2, 'MÁQUINA DE AFEITAR', 5000),
(2, 'CREMA DENTAL PEQUEÑA', 2500),
(2, 'CERA EGO', 2500),
(2, 'CREMA DE PEINAR', 2000),
(2, 'ALKASELTZER', 2000),
(2, 'ASPIRINA ULTRA', 2000),
(2, 'CURITAS', 200),
(2, 'DESODORANTE BALANCE CLINICAL', 2000),
(2, 'LISTERINE', 4000),
(2, 'PROTECTORES DIARIOS NOSOTRAS', 4500),
(2, 'CONDONES TODAY', 5500),
(2, 'SHAMPOO', 2000),
(2, 'SEDA DENTAL', 3000),
(2, 'APRONAX NAPROXENO', 2500),
(2, 'BONFIEST PLUS', 5300),
(2, 'TAMPONES NOSOTRAS', 2400),
(2, 'TOALLAS INVISIBLE', 1500),
(3, 'ENERGIZANTE RED BULL', 8500),
(3, 'BRETAÑA', 3000),
(3, 'AGUA GRANDE', 2000),
(3, 'GASEOSA POSTOBÓN', 3000),
(3, 'GASEOSA COCA COLA LATA', 3000),
(3, 'GASEOSA CANADA DRY', 3000),
(3, 'MR TEA X 500 ML', 3000),
(3, 'JUGOS CAJA HIT', 2000),
(3, 'GATORADE', 4000),
(3, 'JUGOS BOTELLA HIT', 3000),
(4, 'TODO RICO', 2500),
(4, 'GALLETAS MINICHIPS', 2000),
(4, 'PAPAS PRINGLES 40 GR', 5000),
(4, 'TROCIPOLLOS', 1500),
(4, 'CHICHARRÓN', 2500),
(4, 'TAJAMIEL MADURO Y VERDE', 2500),
(4, 'PAPAS SUPER RICAS 25 GR', 2500),
(4, 'PAPAS MARGARITA', 2500),
(4, 'PONQUÉ CHOCORRAMO', 2500),
(4, 'PONQUÉ GALA', 2000),
(4, 'MANÍ LA ESPECIAL SAL', 3000),
(4, 'MANÍ DE ARÁNDANOS', 3000),
(4, 'SALCHICHA ZENU', 5000),
(4, 'DELIMANI', 2000),
(5, 'MORENITAS NESTLÉ', 1200),
(5, 'COCOSETTE', 2000),
(5, 'TOSH', 2000),
(5, 'KIT KAT', 3500),
(5, 'MILO', 2000),
(5, 'WAFER JET', 1500),
(5, 'DEDITOS NESTLÉ', 1200),
(6, 'JUMBO MANÍ', 1200),
(6, 'JET X 12 GR', 1000),
(6, 'NUGGETS DE MILO', 2500);


-- INSERCIÓN DE SERVICIOS
INSERT INTO servicios (nombre_servicio, valor_servicio, tipo_servicio) VALUES
('LAVADO DE PANTALON', 3000, 'L'),
('LAVADO DE BUSO', 2000, 'L'),
('LAVADO DE SACO', 2000, 'L'),
('LAVADO DE BLAZER', 3500, 'L'),
('LAVADO DE CAMISA', 2000, 'L'),
('LAVADO DE BLUSA', 2000, 'L'),
('LAVADO DE ROPA INTERIOR', 1000, 'L'),
('LAVADO DE SUDADERA', 3000, 'L'),
('LAVADO DE PANTALONETA', 1000, 'L'),
('LAVADO DE MEDIAS', 1000, 'L'),
('LAVADO DE BUFANDA', 1000, 'L'),
('LAVADO DE VESTIDO', 4000, 'L'),
('LAVADO DE FALDA', 3000, 'L'),
('LAVADO DE ZAPATOS', 5000, 'L');
