-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 17, 2025 at 10:21 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aerolinea`
--

-- --------------------------------------------------------

--
-- Table structure for table `alojamientos`
--

CREATE TABLE `alojamientos` (
  `id_alojamiento` int NOT NULL,
  `nombre_alojamiento` varchar(100) NOT NULL,
  `descripcion` text,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `alojamientos`
--

INSERT INTO `alojamientos` (`id_alojamiento`, `nombre_alojamiento`, `descripcion`, `precio`, `imagen`) VALUES
(3, 'Hotel de Tailandia', 'Resorts tropicales frente al mar con lujo y spas tradicionales tailandeses.', '200.00', '684e3b33c4ea9-tailandia.jpg'),
(4, 'Hotel de Japon', 'Hoteles modernos y cápsulas futuristas, o ryokans tradicionales con baños onsen.', '250.00', '684e3b94c84ec-japon.jpg'),
(5, 'Hotel de Sudafrica', 'Lodos de safari en la sabana, con vistas a la fauna salvaje y diseño rústico elegante.', '400.00', '684e3c16d8b52-sudafrica.jpg'),
(6, 'Hotel de Nueva York', 'Rascacielos con vistas a Manhattan, estilo contemporáneo y servicios de alto nivel.', '600.00', '684e3c3908d89-newyork.jpg'),
(7, 'Hotel de Brasil', 'Hoteles vibrantes cerca de playas o selvas, con decoración colorida y ambiente relajado.', '300.00', '684e3c5d9ab54-brasil.jpg'),
(8, 'Hotel de Corea del Sur', 'Hoteles tecnológicos en Seúl, con habitaciones inteligentes y diseño minimalista.', '450.00', '684e3c94e5c15-coreadelsur.jpg'),
(9, 'Hotel de Londres', 'Hoteles clásicos con encanto victoriano o modernos con vista al Támesis.', '500.00', '684e3cbed3022-londres.jpg'),
(10, 'Hotel de Rusia', 'Hoteles majestuosos en Moscú o San Petersburgo, con arquitectura imperial y lujo europeo.', '350.00', '684e3ce5c3478-rusia.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `autos`
--

CREATE TABLE `autos` (
  `id_auto` int NOT NULL,
  `nombre_auto` varchar(100) NOT NULL,
  `descripcion` text,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `autos`
--

INSERT INTO `autos` (`id_auto`, `nombre_auto`, `descripcion`, `precio`, `imagen`) VALUES
(1, 'Auto Lujoso', 'Confort y elegancia. Para una experiencia premium.', '200.00', '684e8480bd11f-autolujoso.jpg'),
(2, 'Auto Compacto', 'Ágil y cómodo para ciudad o escapadas.', '100.00', '684e84d6e4dff-autocompacto.jpg'),
(3, 'Auto Mediano', 'Espacioso y cómodo. Ideal para grupos.', '180.00', '684e850780e45-automediano.jpg'),
(4, 'Auto Económico', 'Eficiente y confiable. Ideal para ahorrar.', '80.00', '684e8525a6489-autoeconomico.jpg'),
(5, 'Auto Lujoso Gris', 'Lujo discreto y moderno, ideal para quienes valoran estilo y confort.\r\n\r\n', '200.00', '684e85477d194-autolujosogris.jpg'),
(6, 'Auto Compacto Gris', 'Compacto y práctico, perfecto para ciudad con estilo moderno.', '100.00', '684e856e7537b-autocompactogris.jpg'),
(7, 'Auto Mediano Gris', 'Comodidad y espacio en un diseño profesional y equilibrado.', '180.00', '684e8591a47a0-automedianogris.jpg'),
(8, 'Auto Económico Gris', 'Eficiente y accesible, ideal para moverse sin gastar de más.\r\n\r\n', '80.00', '684e85b215bdc-autoeconomicogris.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `carrito`
--

CREATE TABLE `carrito` (
  `id_carrito` int NOT NULL,
  `id_usuario` int NOT NULL,
  `tipo_item` enum('vuelo','paquete','alojamiento','auto') NOT NULL,
  `id_item` int NOT NULL,
  `cantidad` int NOT NULL DEFAULT '1',
  `fecha_agregado` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `pagos`
--

CREATE TABLE `pagos` (
  `id_pago` int NOT NULL,
  `id_reserva` int NOT NULL,
  `metodo` enum('tarjeta','transferencia','paypal') NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `estado` enum('pendiente','completado','fallido','reembolsado') NOT NULL DEFAULT 'pendiente',
  `fecha_pago` datetime DEFAULT NULL,
  `datos` text,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_usuario` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `paquetes`
--

CREATE TABLE `paquetes` (
  `id_paquete` int NOT NULL,
  `nombre_paquete` varchar(100) NOT NULL,
  `descripcion` text,
  `destino` varchar(100) NOT NULL,
  `fecha_salida` date NOT NULL,
  `fecha_regreso` date DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `en_oferta` tinyint(1) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `paquetes`
--

INSERT INTO `paquetes` (`id_paquete`, `nombre_paquete`, `descripcion`, `destino`, `fecha_salida`, `fecha_regreso`, `precio`, `en_oferta`, `imagen`) VALUES
(7, 'Paquete a Disney - EE.UU.', 'Hotel + Vuelo + Entradas', 'Disney', '2025-09-12', '2025-09-19', '230.00', 0, '684e62a6509cb-orlando.jpg'),
(8, 'Paquete a Bali', 'Hotel + Vuelo + Traslados', 'Bali', '2025-07-14', '2025-07-26', '215.00', 0, '684e6464cd681-bali.jpg'),
(9, 'Paquete a Madrid', 'Hotel + Vuelo', 'Madrid', '2025-12-03', '2025-12-10', '199.00', 0, '684e64b8cf9ff-madrid.jpg'),
(10, 'Paquete a Tierra del Fuego', 'Hotel + Vuelo', 'Tierra del Fuego', '2025-06-21', '2025-06-28', '399.00', 0, '684e64f9c42dd-tierradelfuego.jpg'),
(11, 'Paquete a Punta Cana', 'Hotel + Vuelo', 'Punta Cana', '2025-10-16', '2025-10-30', '175.00', 0, '684e65380b08e-puntacana.jpg'),
(12, 'Paquete a República Dominicana', 'Hotel + Vuelo', 'República Dominicana', '2025-08-21', '2025-06-29', '125.00', 0, '684e657405a31-republicadominicana.jpg'),
(14, 'Miami - Pack Verano', '.', 'Miami', '2025-07-12', '2025-06-19', '789.00', 1, '684e73725678f-miami.jpg'),
(15, 'Europa Clásica', '.', 'Europa', '2026-01-14', '2026-01-28', '899.00', 1, '684e73c64338f-europa.jpg'),
(16, 'Caribe Soñado', '.', 'Caribe', '2026-02-04', '2026-02-14', '999.00', 1, '684e7402002b0-caribe.jpg'),
(17, 'Descubrí Japón Increíble', 'Templos en Kioto y Osaka\r\nLuces de Tokio y cultura manga\r\nCerezos, sushi y tradiciones únicas', 'Japón', '2025-09-01', '2025-09-15', '999.00', 1, '684e7885e66d1-japon1.jpg'),
(18, 'Safari y Lujo en Sudáfrica', 'Resorts con vista a la sabana\r\nExcursiones 4x4 y guías expertos\r\nCenas gourmet y vinos africanos', 'Sudáfrica', '2025-06-24', '2025-07-08', '678.00', 1, '684e78f0ad6ea-sudafrica1.jpg'),
(19, ' Tailandia Exótica te espera', 'Playas de Phuket y Phi Phi\r\nMercados flotantes y templos\r\nMasajes, gastronomía y aventura', 'Tailandia', '2025-07-19', '2025-07-26', '567.00', 1, '684e794bbfcc9-tailandia1.jpg'),
(20, 'Haití: Ritmo, historia y paisajes', 'Playas paradisíacas y montañas\r\nCiudadela Laferrière y arte vudú\r\nCultura afrocaribeña única', 'Haití', '2025-07-09', '2025-07-16', '843.00', 1, '684e797de40ef-haiti1.jpg'),
(21, 'Cataratas del Iguazú: Maravilla Natural', 'Pasarelas sobre la selva misionera\r\nGarganta del Diablo y fauna local\r\nVisita a comunidades guaraníes', 'Cataratas del Iguazú', '2025-08-01', '2025-08-16', '912.00', 1, '684e79b621d11-iguazu1.jpg'),
(22, 'Las Vegas te están esperando!', 'Las Vegas', 'Las Vegas', '2025-10-21', '2025-10-28', '911.00', 1, '684e7a7726d8e-tierradelfuego.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reservas`
--

CREATE TABLE `reservas` (
  `id_reserva` int NOT NULL,
  `id_usuario` int NOT NULL,
  `fecha_reserva` datetime NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `estado` enum('pendiente','confirmada','cancelada') NOT NULL DEFAULT 'pendiente',
  `metodo_pago` enum('tarjeta','transferencia','paypal') NOT NULL,
  `email_cliente` varchar(100) NOT NULL,
  `datos_pago` text,
  `id_alojamiento` int DEFAULT NULL,
  `id_paquete` int DEFAULT NULL,
  `id_auto` int DEFAULT NULL,
  `id_vuelo` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `reserva_detalles`
--

CREATE TABLE `reserva_detalles` (
  `id_detalle` int NOT NULL,
  `id_reserva` int NOT NULL,
  `tipo_servicio` enum('vuelo','hotel','auto','paquete') NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `cantidad` int NOT NULL DEFAULT '1',
  `precio` decimal(10,2) NOT NULL,
  `detalles` text,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `email`, `contraseña`, `telefono`, `direccion`) VALUES
(1, 'Nombre', 'Apellido', 'usuario@ejemplo.com', 'contraseña_segura', NULL, NULL),
(2, 'Agus', 'Montiel', 'agusmontiel2021@gmail.com', '$2y$10$z79eMUpWQqPX6b1tqygMVOGCon19qwOPnV6Kj5il5krB/gDurpBqW', '3775 506083', '');

-- --------------------------------------------------------

--
-- Table structure for table `vuelos`
--

CREATE TABLE `vuelos` (
  `id_vuelo` int NOT NULL,
  `nombre_vuelo` varchar(100) NOT NULL,
  `descripcion` text,
  `destino` varchar(100) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `vuelos`
--

INSERT INTO `vuelos` (`id_vuelo`, `nombre_vuelo`, `descripcion`, `destino`, `precio`, `imagen`) VALUES
(33, '¡Descubrí Nueva York!', 'Times Square y Broadway\r\nVistas desde el Empire State\r\nCentral Park, MoMA y MET', 'Nueva York', '499.00', '684e57918e816-newyork1.jpg'),
(34, '¡Viví la magia de Brasil!', 'Copacabana, Ipanema y Cristo Redentor\r\nSamba en Lapa y sabores brasileños\r\nSelva Amazónica y Bahía', 'Brasil', '420.00', '684e50dbe7c90-brasil11.jpg'),
(35, '¡Descubrí Corea del Sur!', 'Palacios tradicionales y modernos rascacielos\r\nCultura pop, K-Pop y gastronomía única\r\nTemplos y paisajes naturales impresionantes\r\n', 'Corea del Sur', '599.00', '684e5133b2c8c-coreadelsur11.jpg'),
(36, 'Conocé Londres', 'Big Ben, London Eye y el Palacio de Buckingham\r\nMusicales en el West End y cultura en el British Museum\r\nMercados, té inglés y paseos por el Támesis', 'Londres', '699.00', '684e51c0e78f2-londres11.jpg'),
(37, 'Explorá Roma', 'Coliseo, Foro Romano y Vaticano\r\nFontana di Trevi y Plaza España\r\nAuténtica comida italiana y cafés únicos', 'Roma', '649.00', '684e51ee0fea5-roma.jpg'),
(38, 'Descubrí Rusia', 'Moscú: Kremlin, Plaza Roja y Catedral de San Basilio\r\nSan Petersburgo y sus canales\r\nArquitectura imperial y cultura única', 'Rusia', '726.00', '684e52295dd0a-rusia11.jpg'),
(39, 'Viví la aventura en Chile', 'Santiago, Viña del Mar y Valparaíso\r\nCordillera de los Andes y viñedos\r\nGastronomía y paisajes inolvidables', 'Chile', '399.00', '684e526411f91-chile.jpg'),
(40, 'Viajá a México', 'Cancún, CDMX y Riviera Maya\r\nRuinas mayas y playas paradisíacas\r\nComida tradicional y cultura vibrante', 'México', '550.00', '684e52a17f15b-mexico.jpg'),
(41, ' ¡Escapate a Uruguay!', 'Montevideo, Punta del Este y Colonia\r\nPlayas, historia y relax\r\nGastronomía rioplatense y cultura cálida', 'Uruguay', '289.00', '684e52e17a80c-uruguay.jpg'),
(42, '¡Descubrí Bariloche!', 'Circuito Chico y Cerro Catedral\r\nLagos cristalinos y paisajes patagónicos\r\nChocolate artesanal y aventura todo el año', 'Bariloche', '319.00', '684e53862b206-bariloche.jpg'),
(43, '¡Explorá Canadá como nunca antes!', 'Toronto, Montreal y Cataratas del Niágara\r\nCiudades modernas y naturaleza salvaje\r\nCultura diversa y paisajes espectaculares', 'Canadá', '799.00', '684e53bd42023-canada.jpg'),
(44, '¡Descubrí lo mejor de España!', 'Madrid, Barcelona y Sevilla\r\nHistoria, arquitectura y playas\r\nTapas, flamenco y vida nocturna', 'España', '699.00', '684e53f4620c1-españa.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alojamientos`
--
ALTER TABLE `alojamientos`
  ADD PRIMARY KEY (`id_alojamiento`);

--
-- Indexes for table `autos`
--
ALTER TABLE `autos`
  ADD PRIMARY KEY (`id_auto`);

--
-- Indexes for table `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id_carrito`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `id_reserva` (`id_reserva`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `paquetes`
--
ALTER TABLE `paquetes`
  ADD PRIMARY KEY (`id_paquete`);

--
-- Indexes for table `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `fk_reservas_usuarios` (`id_usuario`),
  ADD KEY `id_alojamiento` (`id_alojamiento`),
  ADD KEY `id_paquete` (`id_paquete`),
  ADD KEY `id_auto` (`id_auto`),
  ADD KEY `id_vuelo` (`id_vuelo`);

--
-- Indexes for table `reserva_detalles`
--
ALTER TABLE `reserva_detalles`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_reserva` (`id_reserva`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_usuario_email` (`email`);

--
-- Indexes for table `vuelos`
--
ALTER TABLE `vuelos`
  ADD PRIMARY KEY (`id_vuelo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alojamientos`
--
ALTER TABLE `alojamientos`
  MODIFY `id_alojamiento` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `autos`
--
ALTER TABLE `autos`
  MODIFY `id_auto` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id_carrito` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id_pago` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paquetes`
--
ALTER TABLE `paquetes`
  MODIFY `id_paquete` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reserva_detalles`
--
ALTER TABLE `reserva_detalles`
  MODIFY `id_detalle` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vuelos`
--
ALTER TABLE `vuelos`
  MODIFY `id_vuelo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Constraints for table `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`id_reserva`) REFERENCES `reservas` (`id_reserva`),
  ADD CONSTRAINT `pagos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Constraints for table `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `fk_reservas_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`id_alojamiento`) REFERENCES `alojamientos` (`id_alojamiento`),
  ADD CONSTRAINT `reservas_ibfk_3` FOREIGN KEY (`id_paquete`) REFERENCES `paquetes` (`id_paquete`),
  ADD CONSTRAINT `reservas_ibfk_4` FOREIGN KEY (`id_auto`) REFERENCES `autos` (`id_auto`),
  ADD CONSTRAINT `reservas_ibfk_5` FOREIGN KEY (`id_vuelo`) REFERENCES `vuelos` (`id_vuelo`);

--
-- Constraints for table `reserva_detalles`
--
ALTER TABLE `reserva_detalles`
  ADD CONSTRAINT `reserva_detalles_ibfk_1` FOREIGN KEY (`id_reserva`) REFERENCES `reservas` (`id_reserva`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
