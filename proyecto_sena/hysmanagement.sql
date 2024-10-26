-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-09-2024 a las 18:20:07
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hysmanagement`
--
CREATE DATABASE IF NOT EXISTS `hysmanagement` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `hysmanagement`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `analisis`
--

CREATE TABLE `analisis` (
  `id_analisis` int(11) NOT NULL,
  `tipo_Analisis` varchar(30) DEFAULT NULL,
  `resultados` text DEFAULT NULL,
  `fecha_analisis` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `analisis`
--

INSERT INTO `analisis` (`id_analisis`, `tipo_Analisis`, `resultados`, `fecha_analisis`) VALUES
(1, 'Perfil epidico', 'Sin novedad', '2024-07-21 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autorizar_examenes`
--

CREATE TABLE `autorizar_examenes` (
  `id_Auto_Examenes` int(11) NOT NULL,
  `usuario` int(11) DEFAULT NULL,
  `examen_id` int(11) DEFAULT NULL,
  `verificar` tinyint(1) DEFAULT NULL,
  `confirmar` tinyint(1) DEFAULT NULL,
  `historial_medico` text DEFAULT NULL,
  `emitir_medico` tinyint(1) DEFAULT NULL,
  `fecha_hora` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autorizar_medicamento`
--

CREATE TABLE `autorizar_medicamento` (
  `Id_Auto_Medicamentos` int(11) NOT NULL,
  `usuario` int(11) DEFAULT NULL,
  `historia_medica` int(11) DEFAULT NULL,
  `receta_medica` varchar(255) DEFAULT NULL,
  `verificación_Medicamentos` varchar(255) DEFAULT NULL,
  `autorizar` tinyint(1) DEFAULT NULL,
  `fecha_hora` datetime DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `motivo` text DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canal_atencion`
--

CREATE TABLE `canal_atencion` (
  `id_Canal` int(11) NOT NULL,
  `videollamadas` tinyint(1) DEFAULT NULL,
  `llamadas` tinyint(1) DEFAULT NULL,
  `teleconsultas` tinyint(1) DEFAULT NULL,
  `mensajes` tinyint(1) DEFAULT NULL,
  `correo` tinyint(1) DEFAULT NULL,
  `teléfono` tinyint(1) DEFAULT NULL,
  `fecha_hora` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas_medicas`
--

CREATE TABLE `citas_medicas` (
  `Id_Citas` int(11) NOT NULL,
  `tipo_cita` int(11) DEFAULT NULL,
  `motivo` varchar(255) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `doctor_asignado` int(15) DEFAULT NULL,
  `id_especialidades` int(11) DEFAULT NULL,
  `fecha_hora` datetime DEFAULT NULL,
  `lugar_De_Atencion` varchar(255) DEFAULT NULL,
  `turno` int(11) DEFAULT NULL,
  `id_estado_citas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas_medicas`
--

INSERT INTO `citas_medicas` (`Id_Citas`, `tipo_cita`, `motivo`, `id_usuario`, `doctor_asignado`, `id_especialidades`, `fecha_hora`, `lugar_De_Atencion`, `turno`, `id_estado_citas`) VALUES
(2, 1, 'asdfghj', 8, 9, 14, '2024-08-26 14:50:00', 'hospital', 0, 5),
(4, 1, 'lkjhg', 8, 4, 1, '2024-09-06 17:00:00', 'hospital', 11, 13),
(5, 2, 'nbvfrde', 8, 9, 14, '2024-09-04 17:00:00', 'hospital', 21, 13),
(6, 1, 'derghjk', 8, 9, 1, '2024-08-26 13:20:00', 'hospital', 10, 5),
(9, 1, 'asdfghj', 10, 88, 14, '2024-09-01 03:10:00', 'hospital', 1, 5),
(11, 1, 'fghjkl', 10, 87, 14, '2024-09-01 17:20:00', 'hospital', 11, 13),
(52, 1, '.,mnbvc', 89, 4, 1, '2024-09-28 15:30:00', 'bogota', 10, 5),
(54, 1, 'edrctfvgybhunj', 89, 88, 1, '2024-09-16 07:10:00', 'bogota', NULL, 5),
(55, 1, 'cgvhbjknml,ñ', 89, 88, 1, '2024-09-17 07:10:00', 'bogota', NULL, 5),
(56, 1, 'fxcgvhbjknml', 89, 9, 14, '2024-09-19 08:10:00', 'bogota', NULL, 5),
(57, 1, 'ggjjytg', 89, 4, 1, '2024-09-17 08:20:00', 'bogota', NULL, 5),
(58, 1, 'Vomito y fiebre de 38 hace 2 dias ', 89, 88, 1, '2024-09-17 12:30:00', 'bogota', NULL, 5),
(59, 1, 'sdfghj', 89, 4, 1, '2024-09-18 12:30:00', 'bogota', NULL, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudad`
--

CREATE TABLE `ciudad` (
  `id_ciudad` int(11) NOT NULL,
  `Ciudades` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ciudad`
--

INSERT INTO `ciudad` (`id_ciudad`, `Ciudades`) VALUES
(1, 'Apartadó'),
(2, 'Arauca'),
(3, 'Armenia'),
(4, 'Barranquilla'),
(5, 'Bello'),
(6, 'Bogotá'),
(7, 'Buenaventura'),
(8, 'Bucaramanga'),
(9, 'Calarcá'),
(10, 'Cali'),
(11, 'Cartagena'),
(12, 'Cartago'),
(13, 'Ciénaga'),
(14, 'Cúcuta'),
(15, 'Duitama'),
(16, 'Dosquebradas'),
(17, 'Envigado'),
(18, 'Espinal'),
(19, 'Florencia'),
(20, 'Floridablanca'),
(21, 'Fusagasugá'),
(22, 'Girón'),
(23, 'Granada'),
(24, 'Ibagué'),
(25, 'Inírida'),
(26, 'Itagüí'),
(27, 'Leticia'),
(28, 'Maicao'),
(29, 'Magangué'),
(30, 'Malambo'),
(31, 'Manizales'),
(32, 'Medellín'),
(33, 'Mitú'),
(34, 'Mocoa'),
(35, 'Montería'),
(36, 'Neiva'),
(37, 'Ocaña'),
(38, 'Palmira'),
(39, 'Pasto'),
(40, 'Pereira'),
(41, 'Piedecuesta'),
(42, 'Pitalito'),
(43, 'Popayán'),
(44, 'Puerto Asís'),
(45, 'Puerto Carreño'),
(46, 'Quibdó'),
(47, 'Riohacha'),
(48, 'Rionegro'),
(49, 'San Andrés'),
(50, 'San José del Guaviare'),
(51, 'Santa Marta'),
(52, 'Sincelejo'),
(53, 'Soacha'),
(54, 'Sogamoso'),
(55, 'Soledad'),
(56, 'Tumaco'),
(57, 'Tunja'),
(58, 'Turbaco'),
(59, 'Tuluá'),
(60, 'Valledupar'),
(61, 'Villamaría'),
(62, 'Villavicencio'),
(63, 'Yopal'),
(64, 'Zipaquirá');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactenos`
--

CREATE TABLE `contactenos` (
  `id_contactenos` int(11) NOT NULL,
  `datos` varchar(100) DEFAULT NULL,
  `correoElectronico` varchar(70) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `asunto` varchar(20) DEFAULT NULL,
  `mensajes` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `crear_usuario`
--

CREATE TABLE `crear_usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(55) DEFAULT NULL,
  `apellido1` varchar(55) DEFAULT NULL,
  `apellido2` varchar(55) DEFAULT NULL,
  `rol` int(11) DEFAULT NULL,
  `contrasena` varchar(12) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `sexo` int(11) DEFAULT NULL,
  `RH` int(11) DEFAULT NULL,
  `altura` int(11) DEFAULT NULL,
  `peso` int(11) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `tipo_documento_id` int(11) DEFAULT NULL,
  `numero_documento` varchar(15) DEFAULT NULL,
  `correo` varchar(55) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `direccion` varchar(30) DEFAULT NULL,
  `discapacidad` text DEFAULT NULL,
  `sisben` int(11) DEFAULT NULL,
  `ciudad_id` int(11) DEFAULT NULL,
  `nacionalidad` varchar(30) DEFAULT NULL,
  `estado_civil` int(11) DEFAULT NULL,
  `estrato` int(11) DEFAULT NULL,
  `pais_id` int(11) DEFAULT NULL,
  `enfermedades` text DEFAULT NULL,
  `Ocupacion` int(11) DEFAULT NULL,
  `Eps` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `especialidad` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `crear_usuario`
--

INSERT INTO `crear_usuario` (`id_usuario`, `nombre`, `apellido1`, `apellido2`, `rol`, `contrasena`, `edad`, `sexo`, `RH`, `altura`, `peso`, `fecha_nacimiento`, `tipo_documento_id`, `numero_documento`, `correo`, `telefono`, `direccion`, `discapacidad`, `sisben`, `ciudad_id`, `nacionalidad`, `estado_civil`, `estrato`, `pais_id`, `enfermedades`, `Ocupacion`, `Eps`, `status`, `especialidad`) VALUES
(2, 'oscar david', 'Tabares', 'sanchez', 2, 'proyecto1234', 22, 1, 1, 172, 76, '2004-01-22', 1, '1076736126', 'davidtabares99@outlook.com', '3106735032', 'Carrera 11c este #43a-92s', 'ninguna', 1, NULL, 'colombiano', 1, 2, NULL, 'ninguna', 1, 2, 1, NULL),
(3, 'jose', 'eduardo', 'gomez', 2, 'proyecto1234', 22, 1, 1, 170, 76, '2004-01-22', 1, '1076736123', 'jose@sena.edu.co', '3106735033', 'Carrera 111c este #43a-92s', 'N/A', 1, NULL, 'colombiano', 1, 1, NULL, 'N/A', 2, 1, 1, NULL),
(4, 'janner jo', 'gonzales', 'marin', 1, 'Holajuandieg', 24, 1, 2, 176, 76, '2000-02-22', 1, '1076736124', 'harold.andrey10@gmail.com', '3106735033', 'Carrera 11c este #43a-92s', '3', 1, NULL, 'colombiano', 1, 1, NULL, 'N/A', 1, 2, 1, 1),
(7, 'josefina', 'miranda', 'velez', 3, 'proyecto1234', 24, 1, NULL, NULL, NULL, '2000-01-22', 1, '1276746126', 'josefina@sena.edu.co', '3114476900', 'bogota', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(8, 'maria', 'bermudez', 'velez', 5, 'proyecto1234', 24, 2, 5, 169, 68, '2000-02-22', 1, '1176736126', 'maria123@gmail.com', '31974878343', 'bogota', '9', 1, NULL, 'colombiano', 1, 1, NULL, 'ninguna', 33, 5, 1, NULL),
(9, 'ana maria', 'rojas', 'Miranda', 1, 'Ana12345', 33, 2, NULL, NULL, NULL, '1991-08-12', 1, '1234569', 'ana@comofue.com', '3215478963', 'calle 50 # 78-98', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 14),
(10, 'camilo', 'ramirez', 'cajamarca', 5, 'camilo1234', 19, 1, 1, 170, 80, '2005-01-22', 1, '39738519', 'davidtabares@gmail.com', '3114473800', 'avenida 1 # 84 -21', '9', 1, NULL, 'colombiano', 1, 2, NULL, 'N/A', 14, 3, 1, NULL),
(11, 'werty', 'rojas', 'cajamarca', 5, 'camilo1234', 27, 1, 4, 180, 80, '1996-11-29', 3, '55555555', 'CAMILO@comofue.com', '3125675441', 'calle 31 # 78-98', '3', 2, NULL, 'colombiano', 2, 2, NULL, 'N/A', 15, 2, 1, NULL),
(87, 'Gabriel', 'Cepeda', 'Castiblanco', 1, 'Gabriel1234', 25, 1, 2, 180, 80, '1998-12-21', 1, '10456879', 'Gabriel@comofue.com', '3125675441', 'calle 31 # 78-98', '9', 2, NULL, 'colombiano', 1, 2, NULL, 'N/A', 7, 2, 1, 14),
(88, 'Luiz', 'Diaz', 'Rojas', 1, 'Lucho1234', 25, 1, 2, 180, 80, '1999-04-11', 1, '2154876', 'lucho785@comofue.com', '3125675441', 'calle 80 # 21-54', '9', 2, NULL, 'colombiano', 2, 5, NULL, 'N/A', 56, 1, 1, 1),
(89, 'Harry ', 'Potter', '', 5, 'Harry1234', 28, 1, 6, 170, 80, '1996-02-14', 1, '213456', 'juandiiego15@gmail.com', '3125675441', 'calle 80 # 21-54', '9', 5, NULL, 'colombiano', 2, 4, NULL, 'N/A', 35, 4, 1, NULL),
(90, 'Leonor', 'Perez', '', 5, 'Leonor1234', 36, 1, 4, 180, 80, '1988-01-01', 1, '14785236', 'leonor@gmail.com', '3124569877', 'calle 31 # 78-98', '9', 5, NULL, 'colombiano', 4, 3, NULL, 'N/A', 11, 7, 1, NULL),
(91, 'Juan Manuel ', 'Torres', 'Perez', 5, 'juan1234', 29, 1, 2, 180, 80, '1995-05-21', 3, '852147', 'juan@gmail.com', '2254498711', 'calle 50 # 78-98', '9', 5, NULL, 'colombiano', 3, 5, NULL, 'N/A', 3, 5, 1, NULL),
(92, 'Ramiro', 'Salazar', 'Moreno', 5, 'Ramiro1234', 26, 1, 3, 178, 85, '1998-05-21', 1, '741258', 'Ramiro@gmail.com', '3214569874', 'calle 31 # 78-98', '9', 5, NULL, 'colombiano', 3, 4, NULL, 'N/A', 59, 2, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `discapacidades`
--

CREATE TABLE `discapacidades` (
  `id_discapacidad` int(11) NOT NULL,
  `discapacidad` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `discapacidades`
--

INSERT INTO `discapacidades` (`id_discapacidad`, `discapacidad`) VALUES
(1, 'Discapacidad física'),
(2, 'Discapacidad intelectual'),
(3, 'Discapacidad mental'),
(4, 'Discapacidad psicosocial'),
(5, 'Discapacidad múltiple'),
(6, 'Discapacidad sensorial'),
(7, 'Discapacidad auditiva'),
(8, 'Discapacidad visual'),
(9, 'Ninguna');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidades`
--

CREATE TABLE `especialidades` (
  `Id_especialidades` int(11) NOT NULL,
  `Tipo_especialidades` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `especialidades`
--

INSERT INTO `especialidades` (`Id_especialidades`, `Tipo_especialidades`) VALUES
(1, 'Medicina General'),
(2, 'Pediatría'),
(3, 'Laboratorio'),
(4, 'Ginecología'),
(5, 'Dermatología'),
(6, 'Cardiología'),
(7, 'Oftalmología'),
(8, 'Neurología'),
(9, 'Otorrinolaringología'),
(10, 'Endocrinología'),
(11, 'Urología'),
(12, 'Traumatología'),
(13, 'Nutrición'),
(14, 'Odontología'),
(15, 'Fisioterapia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_citas`
--

CREATE TABLE `estados_citas` (
  `id_estado_citas` int(11) NOT NULL,
  `Estado_cita` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados_citas`
--

INSERT INTO `estados_citas` (`id_estado_citas`, `Estado_cita`) VALUES
(1, 'aplazada'),
(2, 'cancelada'),
(3, 'asistida'),
(4, 'confirmada'),
(5, 'Asignada'),
(6, 'no asistida'),
(7, 'reprogramada'),
(8, 'en espera'),
(9, 'completada'),
(10, 'pendiente por confirmación'),
(11, 'confirmada por paciente'),
(12, 'confirmada por médico'),
(13, 'en proceso'),
(14, 'esperando confirmación');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_civiles`
--

CREATE TABLE `estados_civiles` (
  `id_estado_civil` int(11) NOT NULL,
  `Estado_Civil` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados_civiles`
--

INSERT INTO `estados_civiles` (`id_estado_civil`, `Estado_Civil`) VALUES
(1, 'Soltero/a'),
(2, 'Casado/a'),
(3, 'Union libre o Union de hecho'),
(4, 'Separado/a'),
(5, 'Divorciado/a'),
(6, 'Viudo/a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estratos`
--

CREATE TABLE `estratos` (
  `id_estrato` int(11) NOT NULL,
  `Estrato` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estratos`
--

INSERT INTO `estratos` (`id_estrato`, `Estrato`) VALUES
(1, 'Estrato 1'),
(2, 'Estrato 2'),
(3, 'Estrato 3'),
(4, 'Estrato 4'),
(5, 'Estrato 5'),
(6, 'Estrato 6');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examenes`
--

CREATE TABLE `examenes` (
  `id_Examenes` int(11) NOT NULL,
  `usuario` int(11) DEFAULT NULL,
  `pruebas` varchar(255) DEFAULT NULL,
  `tipo_De_Pruebas` int(11) DEFAULT NULL,
  `información_Paciente` text DEFAULT NULL,
  `resultados` text DEFAULT NULL,
  `fecha_hora` datetime DEFAULT NULL,
  `datos_Hospital` text DEFAULT NULL,
  `diagnostico` text DEFAULT NULL,
  `tratamiento` text DEFAULT NULL,
  `doctor_encargado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `examenes`
--

INSERT INTO `examenes` (`id_Examenes`, `usuario`, `pruebas`, `tipo_De_Pruebas`, `información_Paciente`, `resultados`, `fecha_hora`, `datos_Hospital`, `diagnostico`, `tratamiento`, `doctor_encargado`) VALUES
(1, 89, 'Glicemia', 3, 'Paciente con cuadro de anemia', '94ea69e3a25e3f140bcced5b4cdd0595.pdf', '2024-09-12 17:21:00', 'Hospital San Luis', 'Glicemia aguda', 'Tomar acetaminofen', 88),
(2, 89, 'Ecograf', 7, 'Paciente con dolor intenso en el abdomen', '94ea69e3a25e3f140bcced5b4cdd0595.pdf', '2024-09-14 14:20:14', 'Hospital San Luis', 'Dolor intenso abdominal', 'Cero comida alta en sal y grasas', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examenes_medicos`
--

CREATE TABLE `examenes_medicos` (
  `id_Examenes` int(11) NOT NULL,
  `Examen` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `examenes_medicos`
--

INSERT INTO `examenes_medicos` (`id_Examenes`, `Examen`) VALUES
(1, 'Hemograma'),
(2, 'Perfil lipídico'),
(3, 'Glicemia'),
(4, 'Pruebas de función hepática'),
(5, 'Pruebas de función renal'),
(6, 'Radiografía de tórax'),
(7, 'Ecografía'),
(8, 'Tomografía computarizada (TC)'),
(9, 'Resonancia magnética (RM)'),
(10, 'Electrocardiograma (EKG)'),
(11, 'Pruebas de esfuerzo'),
(12, 'Espirometría'),
(13, 'Exámenes preocupacionales'),
(14, 'Audiometría'),
(15, 'Visiometría'),
(16, 'Pruebas psicofísicas'),
(17, 'Prueba de antígeno para COVID-19'),
(18, 'PCR para COVID-19'),
(19, 'Mamografías'),
(20, 'Biopsias');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulas_medicas`
--

CREATE TABLE `formulas_medicas` (
  `id_formulas` int(11) NOT NULL,
  `usuario` int(11) DEFAULT NULL,
  `nombre_medicamento` varchar(70) DEFAULT NULL,
  `dosis` varchar(50) DEFAULT NULL,
  `instrucciones` text DEFAULT NULL,
  `fecha_Formulacion` date DEFAULT NULL,
  `fecha_Vencimiento` date DEFAULT NULL,
  `Doctor` int(10) DEFAULT NULL,
  `lugar_Entrega` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `formulas_medicas`
--

INSERT INTO `formulas_medicas` (`id_formulas`, `usuario`, `nombre_medicamento`, `dosis`, `instrucciones`, `fecha_Formulacion`, `fecha_Vencimiento`, `Doctor`, `lugar_Entrega`) VALUES
(1, 89, 'Ibuprofeno', '30', '1 cada 8 horas durante 10 dias', '2024-08-24', '2025-08-24', 4, 'hospital'),
(2, 89, 'Acetaminofen', '60 tbls', '1 cada 8 hrs por 15 dias', '2024-08-31', '2025-08-31', 4, 'Hospital'),
(3, 89, 'acetaminofen', '60 tbs', '1 cada 8 horas', '2024-08-31', '2025-08-31', 88, 'Hospital'),
(7, 89, 'Betametasona', '1 tubo', 'Aplicar en la zona afectada', '2024-09-15', '2025-09-15', 88, 'Bogota'),
(8, 89, 'Betametasona', '2 tubo', 'Aplicar en la zona afectada', '2024-09-25', '2025-09-25', 88, 'Bogota');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historia_medica`
--

CREATE TABLE `historia_medica` (
  `id_Historia_Medica` int(11) NOT NULL,
  `usuario` int(11) DEFAULT NULL,
  `pruebas_Realizada` text DEFAULT NULL,
  `cirugias` text DEFAULT NULL,
  `medicamentos_Recetados` text DEFAULT NULL,
  `análisis_Realizados` text DEFAULT NULL,
  `resultados_analisis` int(11) DEFAULT NULL,
  `tratamientos` text DEFAULT NULL,
  `procesos` text DEFAULT NULL,
  `diagnostico` text DEFAULT NULL,
  `Tratamientos_Quirurgicos` text DEFAULT NULL,
  `Hospitalizaciones` text DEFAULT NULL,
  `formulas` text DEFAULT NULL,
  `alergias` text DEFAULT NULL,
  `consumo_tabaco` tinyint(1) DEFAULT NULL,
  `consumo_alcohol` tinyint(1) DEFAULT NULL,
  `consumo_drogas` tinyint(1) DEFAULT NULL,
  `actividad_fisica` tinyint(1) DEFAULT NULL,
  `resultados_imagenes` int(11) DEFAULT NULL,
  `fecha_hora` datetime DEFAULT NULL,
  `lugar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historia_medica`
--

INSERT INTO `historia_medica` (`id_Historia_Medica`, `usuario`, `pruebas_Realizada`, `cirugias`, `medicamentos_Recetados`, `análisis_Realizados`, `resultados_analisis`, `tratamientos`, `procesos`, `diagnostico`, `Tratamientos_Quirurgicos`, `Hospitalizaciones`, `formulas`, `alergias`, `consumo_tabaco`, `consumo_alcohol`, `consumo_drogas`, `actividad_fisica`, `resultados_imagenes`, `fecha_hora`, `lugar`) VALUES
(15, 89, 'Muestra de sangre', '', 'Resberatrol 220gr', '', 1, '', '', '', '', '2', '2', 'ninguna', 0, 0, 0, 3, 1, '2024-07-21 00:00:00', 'Hospital Rose'),
(20, 89, '', '', 'Ibuprofena 100grs', '', 1, '', '', '', '', '', '15', '', 0, 0, 0, 0, 1, '2024-09-09 00:00:00', 'Hospital'),
(21, 89, 'Hemograma', 'N/A', 'Ibuprofeno', '9816e04f0de62aee8aa7fdbc16e15d20.pdf', NULL, 'asdfghjkl', 'swdefrgthju', 'wefsgrdthfmgf', 'asdfgnh', 'adsdfngh', '15', 'N/A', NULL, NULL, NULL, NULL, NULL, '2024-09-10 12:09:00', 'Hospital'),
(22, 89, 'Hemograma', 'N/A', 'Calcio', '27c855584cd0c91440f77b83d5e9ef15.pdf', NULL, 'N/A', 'N/A', 'Paciente con falta de calcio', 'N/A', '1', 'N/A', 'N/A', NULL, NULL, NULL, NULL, NULL, '2024-09-15 16:22:00', 'Bogota');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incapacidades`
--

CREATE TABLE `incapacidades` (
  `id_Incapacidad` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `motivos` varchar(2000) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `doctor_encargado` int(11) DEFAULT NULL,
  `recomendaciones_medicamentos` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `incapacidades`
--

INSERT INTO `incapacidades` (`id_Incapacidad`, `id_usuario`, `motivos`, `fecha_inicio`, `fecha_fin`, `doctor_encargado`, `recomendaciones_medicamentos`) VALUES
(1, 89, 'Problemas Gastricos Recurrentes ', '2024-09-10', '2024-09-13', 88, 'Permanecer en reposo cero comida grasosa '),
(2, 10, 'dolor de cabeza', '2024-09-12', '2025-09-12', 88, 'zwexrctvybunjikm'),
(3, 89, 'Migraña', '2024-08-30', '2025-08-30', 88, 'Tomar cada 8 horas'),
(4, 89, 'Mareo y tension arterial alta', '2024-09-15', '2024-09-17', 88, 'N/A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nombre_eps`
--

CREATE TABLE `nombre_eps` (
  `id` int(11) NOT NULL,
  `nombre` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `nombre_eps`
--

INSERT INTO `nombre_eps` (`id`, `nombre`) VALUES
(1, 'EPS Sura'),
(2, 'EPS Sanitas'),
(3, 'EPS Famisanar'),
(4, 'EPS Coomeva'),
(5, 'EPS Salud Total'),
(6, 'EPS Compensar'),
(7, 'EPS Nueva EPS'),
(8, 'EPS Aliansalud'),
(9, 'EPS Cajacopi'),
(10, 'EPS Comfenalco');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ocupaciones`
--

CREATE TABLE `ocupaciones` (
  `id_ocupacion` int(11) NOT NULL,
  `nombre_ocupacion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ocupaciones`
--

INSERT INTO `ocupaciones` (`id_ocupacion`, `nombre_ocupacion`) VALUES
(1, 'Ingeniero'),
(2, 'Médico'),
(3, 'Profesor de primaria'),
(4, 'Abogado'),
(5, 'Arquitecto'),
(6, 'Diseñador gráfico'),
(7, 'Programador'),
(8, 'Enfermero'),
(9, 'Chef'),
(10, 'Carpintero'),
(11, 'Electricista'),
(12, 'Plomero'),
(13, 'Farmacéutico'),
(14, 'Policía'),
(15, 'Bombero'),
(16, 'Actor'),
(17, 'Músico'),
(18, 'Artista plástico'),
(19, 'Periodista'),
(20, 'Ama de casa'),
(21, 'Consultor'),
(22, 'Economista'),
(23, 'Psicólogo/a'),
(24, 'Contador/a'),
(25, 'Astrónomo'),
(26, 'Geólogo/a'),
(27, 'Biólogo/a'),
(28, 'Piloto'),
(29, 'Conductor de autobús'),
(30, 'Conductor de Uber'),
(31, 'Conductor de Taxi'),
(32, 'Conductor de Transmilenio'),
(33, 'Conductor de Sitp'),
(34, 'Jardinero/a'),
(35, 'Científico/a'),
(36, 'Profesor Universitario'),
(37, 'Vendedor Informal'),
(38, 'Agente de ventas'),
(39, 'Perito Contador'),
(40, 'Inspector de Calidad'),
(41, 'Diseñador de Moda'),
(42, 'Terapeuta Ocupacional'),
(43, 'Analista de Datos'),
(44, 'Operador de Maquinaria Pesada'),
(45, 'Especialista en Seguridad Informática'),
(46, 'Asistente Social'),
(47, 'Gerente de Proyectos'),
(48, 'Arqueólogo'),
(49, 'Entrenador Personal'),
(50, 'Economista Ambiental'),
(51, 'Escultor'),
(52, 'Cineasta'),
(53, 'Analista de Créditos'),
(54, 'Técnico en Radiología'),
(55, 'Animador 3D'),
(56, 'Biocientífico'),
(57, 'Diseñador Industrial'),
(58, 'Genetista'),
(59, 'Peluquero canino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restaurar_contrasena`
--

CREATE TABLE `restaurar_contrasena` (
  `Id` int(11) NOT NULL,
  `usuario` int(11) DEFAULT NULL,
  `nueva_contrasena` varchar(255) DEFAULT NULL,
  `confirmar_contrasena` varchar(255) DEFAULT NULL,
  `fechayhora` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_img`
--

CREATE TABLE `resultados_img` (
  `id_imagenes` int(11) NOT NULL,
  `tipo_Analisis` varchar(30) DEFAULT NULL,
  `resultados` text DEFAULT NULL,
  `fecha_analisis` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resultados_img`
--

INSERT INTO `resultados_img` (`id_imagenes`, `tipo_Analisis`, `resultados`, `fecha_analisis`) VALUES
(1, 'Radiografia de rodilla', 'Rotura de ligamento anterior', '2024-05-21 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sexos`
--

CREATE TABLE `sexos` (
  `id_sexo` int(11) NOT NULL,
  `Sexo` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sexos`
--

INSERT INTO `sexos` (`id_sexo`, `Sexo`) VALUES
(1, 'Masculino'),
(2, 'Femenino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_roles`
--

CREATE TABLE `tabla_roles` (
  `id_tipo_Rol` int(11) NOT NULL,
  `Roles` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tabla_roles`
--

INSERT INTO `tabla_roles` (`id_tipo_Rol`, `Roles`) VALUES
(1, 'Doctor'),
(2, 'Administrador'),
(3, 'Recepcion'),
(4, 'Prescriptor Medico'),
(5, 'Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_de_cita`
--

CREATE TABLE `tipos_de_cita` (
  `id_tipo_cita` int(11) NOT NULL,
  `Descripcion` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos_de_cita`
--

INSERT INTO `tipos_de_cita` (`id_tipo_cita`, `Descripcion`) VALUES
(1, 'Presencial'),
(2, 'Virtual');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_rh`
--

CREATE TABLE `tipos_rh` (
  `id_RH` int(11) NOT NULL,
  `RH` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos_rh`
--

INSERT INTO `tipos_rh` (`id_RH`, `RH`) VALUES
(1, 'A+'),
(2, 'A-'),
(3, 'B+'),
(4, 'B-'),
(5, 'AB+'),
(6, 'AB-'),
(7, 'O+'),
(8, 'O-');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_sisben`
--

CREATE TABLE `tipos_sisben` (
  `id_sisben` int(11) NOT NULL,
  `Sisben` varchar(30) DEFAULT NULL,
  `Descripción` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos_sisben`
--

INSERT INTO `tipos_sisben` (`id_sisben`, `Sisben`, `Descripción`) VALUES
(1, 'A1 - A5 ', 'Desde A1 a A5'),
(2, 'B1 - B7', 'Desde B1 a B7'),
(3, 'C1 - C18', 'Desde C1 a C18'),
(4, 'D1 -D20', 'Desde D1 a D20'),
(5, 'No aplica', 'No me encuentro afiliado al sisben');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `id_tipo_documento` int(11) NOT NULL,
  `Documento` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`id_tipo_documento`, `Documento`) VALUES
(1, 'Cédula de Ciudadanía'),
(2, 'Cédula de Extranjería'),
(3, 'Pasaporte'),
(4, 'Tarjeta de Identidad'),
(5, 'NUIP'),
(6, 'Registro Civil');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `analisis`
--
ALTER TABLE `analisis`
  ADD PRIMARY KEY (`id_analisis`);

--
-- Indices de la tabla `autorizar_examenes`
--
ALTER TABLE `autorizar_examenes`
  ADD PRIMARY KEY (`id_Auto_Examenes`),
  ADD KEY `usuario` (`usuario`),
  ADD KEY `examen_id` (`examen_id`);

--
-- Indices de la tabla `autorizar_medicamento`
--
ALTER TABLE `autorizar_medicamento`
  ADD PRIMARY KEY (`Id_Auto_Medicamentos`),
  ADD KEY `usuario` (`usuario`),
  ADD KEY `historia_medica` (`historia_medica`);

--
-- Indices de la tabla `canal_atencion`
--
ALTER TABLE `canal_atencion`
  ADD PRIMARY KEY (`id_Canal`);

--
-- Indices de la tabla `citas_medicas`
--
ALTER TABLE `citas_medicas`
  ADD PRIMARY KEY (`Id_Citas`),
  ADD KEY `id_estado_citas` (`id_estado_citas`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_especialidades` (`id_especialidades`),
  ADD KEY `tipo_cita` (`tipo_cita`),
  ADD KEY `fk_doctor` (`doctor_asignado`);

--
-- Indices de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD PRIMARY KEY (`id_ciudad`);

--
-- Indices de la tabla `contactenos`
--
ALTER TABLE `contactenos`
  ADD PRIMARY KEY (`id_contactenos`);

--
-- Indices de la tabla `crear_usuario`
--
ALTER TABLE `crear_usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `tipo_documento_id` (`tipo_documento_id`),
  ADD KEY `ciudad_id` (`ciudad_id`),
  ADD KEY `sexo` (`sexo`),
  ADD KEY `estado_civil` (`estado_civil`),
  ADD KEY `estrato` (`estrato`),
  ADD KEY `RH` (`RH`),
  ADD KEY `sisben` (`sisben`),
  ADD KEY `rol` (`rol`),
  ADD KEY `ocupacion` (`Ocupacion`),
  ADD KEY `id` (`Eps`),
  ADD KEY `fk_especialidad` (`especialidad`);

--
-- Indices de la tabla `discapacidades`
--
ALTER TABLE `discapacidades`
  ADD PRIMARY KEY (`id_discapacidad`);

--
-- Indices de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  ADD PRIMARY KEY (`Id_especialidades`);

--
-- Indices de la tabla `estados_citas`
--
ALTER TABLE `estados_citas`
  ADD PRIMARY KEY (`id_estado_citas`);

--
-- Indices de la tabla `estados_civiles`
--
ALTER TABLE `estados_civiles`
  ADD PRIMARY KEY (`id_estado_civil`);

--
-- Indices de la tabla `estratos`
--
ALTER TABLE `estratos`
  ADD PRIMARY KEY (`id_estrato`);

--
-- Indices de la tabla `examenes`
--
ALTER TABLE `examenes`
  ADD PRIMARY KEY (`id_Examenes`),
  ADD KEY `usuario` (`usuario`),
  ADD KEY `tipo_De_Pruebas` (`tipo_De_Pruebas`),
  ADD KEY `fk_doctor_encargado` (`doctor_encargado`);

--
-- Indices de la tabla `examenes_medicos`
--
ALTER TABLE `examenes_medicos`
  ADD PRIMARY KEY (`id_Examenes`);

--
-- Indices de la tabla `formulas_medicas`
--
ALTER TABLE `formulas_medicas`
  ADD PRIMARY KEY (`id_formulas`),
  ADD KEY `usuario` (`usuario`),
  ADD KEY `fk_formulas_medicas` (`Doctor`);

--
-- Indices de la tabla `historia_medica`
--
ALTER TABLE `historia_medica`
  ADD PRIMARY KEY (`id_Historia_Medica`),
  ADD KEY `usuario` (`usuario`),
  ADD KEY `resultados_analisis` (`resultados_analisis`),
  ADD KEY `resultados_imagenes` (`resultados_imagenes`);

--
-- Indices de la tabla `incapacidades`
--
ALTER TABLE `incapacidades`
  ADD PRIMARY KEY (`id_Incapacidad`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `doctor_encargado` (`doctor_encargado`);

--
-- Indices de la tabla `nombre_eps`
--
ALTER TABLE `nombre_eps`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ocupaciones`
--
ALTER TABLE `ocupaciones`
  ADD PRIMARY KEY (`id_ocupacion`);

--
-- Indices de la tabla `restaurar_contrasena`
--
ALTER TABLE `restaurar_contrasena`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `usuario` (`usuario`);

--
-- Indices de la tabla `resultados_img`
--
ALTER TABLE `resultados_img`
  ADD PRIMARY KEY (`id_imagenes`);

--
-- Indices de la tabla `sexos`
--
ALTER TABLE `sexos`
  ADD PRIMARY KEY (`id_sexo`);

--
-- Indices de la tabla `tabla_roles`
--
ALTER TABLE `tabla_roles`
  ADD PRIMARY KEY (`id_tipo_Rol`);

--
-- Indices de la tabla `tipos_de_cita`
--
ALTER TABLE `tipos_de_cita`
  ADD PRIMARY KEY (`id_tipo_cita`);

--
-- Indices de la tabla `tipos_rh`
--
ALTER TABLE `tipos_rh`
  ADD PRIMARY KEY (`id_RH`);

--
-- Indices de la tabla `tipos_sisben`
--
ALTER TABLE `tipos_sisben`
  ADD PRIMARY KEY (`id_sisben`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`id_tipo_documento`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `analisis`
--
ALTER TABLE `analisis`
  MODIFY `id_analisis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `autorizar_examenes`
--
ALTER TABLE `autorizar_examenes`
  MODIFY `id_Auto_Examenes` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `autorizar_medicamento`
--
ALTER TABLE `autorizar_medicamento`
  MODIFY `Id_Auto_Medicamentos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `canal_atencion`
--
ALTER TABLE `canal_atencion`
  MODIFY `id_Canal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `citas_medicas`
--
ALTER TABLE `citas_medicas`
  MODIFY `Id_Citas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  MODIFY `id_ciudad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `contactenos`
--
ALTER TABLE `contactenos`
  MODIFY `id_contactenos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `crear_usuario`
--
ALTER TABLE `crear_usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT de la tabla `discapacidades`
--
ALTER TABLE `discapacidades`
  MODIFY `id_discapacidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  MODIFY `Id_especialidades` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `estados_citas`
--
ALTER TABLE `estados_citas`
  MODIFY `id_estado_citas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `estados_civiles`
--
ALTER TABLE `estados_civiles`
  MODIFY `id_estado_civil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `estratos`
--
ALTER TABLE `estratos`
  MODIFY `id_estrato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `examenes`
--
ALTER TABLE `examenes`
  MODIFY `id_Examenes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `examenes_medicos`
--
ALTER TABLE `examenes_medicos`
  MODIFY `id_Examenes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `formulas_medicas`
--
ALTER TABLE `formulas_medicas`
  MODIFY `id_formulas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `historia_medica`
--
ALTER TABLE `historia_medica`
  MODIFY `id_Historia_Medica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `incapacidades`
--
ALTER TABLE `incapacidades`
  MODIFY `id_Incapacidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `nombre_eps`
--
ALTER TABLE `nombre_eps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `ocupaciones`
--
ALTER TABLE `ocupaciones`
  MODIFY `id_ocupacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de la tabla `restaurar_contrasena`
--
ALTER TABLE `restaurar_contrasena`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `resultados_img`
--
ALTER TABLE `resultados_img`
  MODIFY `id_imagenes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `sexos`
--
ALTER TABLE `sexos`
  MODIFY `id_sexo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tabla_roles`
--
ALTER TABLE `tabla_roles`
  MODIFY `id_tipo_Rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipos_de_cita`
--
ALTER TABLE `tipos_de_cita`
  MODIFY `id_tipo_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipos_rh`
--
ALTER TABLE `tipos_rh`
  MODIFY `id_RH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tipos_sisben`
--
ALTER TABLE `tipos_sisben`
  MODIFY `id_sisben` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `id_tipo_documento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `autorizar_examenes`
--
ALTER TABLE `autorizar_examenes`
  ADD CONSTRAINT `autorizar_examenes_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `crear_usuario` (`id_usuario`),
  ADD CONSTRAINT `autorizar_examenes_ibfk_2` FOREIGN KEY (`examen_id`) REFERENCES `examenes_medicos` (`id_Examenes`);

--
-- Filtros para la tabla `autorizar_medicamento`
--
ALTER TABLE `autorizar_medicamento`
  ADD CONSTRAINT `autorizar_medicamento_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `crear_usuario` (`id_usuario`),
  ADD CONSTRAINT `autorizar_medicamento_ibfk_2` FOREIGN KEY (`historia_medica`) REFERENCES `historia_medica` (`id_Historia_Medica`);

--
-- Filtros para la tabla `citas_medicas`
--
ALTER TABLE `citas_medicas`
  ADD CONSTRAINT `citas_medicas_ibfk_1` FOREIGN KEY (`id_estado_citas`) REFERENCES `estados_citas` (`id_estado_citas`),
  ADD CONSTRAINT `citas_medicas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `crear_usuario` (`id_usuario`),
  ADD CONSTRAINT `citas_medicas_ibfk_3` FOREIGN KEY (`id_especialidades`) REFERENCES `especialidades` (`Id_especialidades`),
  ADD CONSTRAINT `citas_medicas_ibfk_4` FOREIGN KEY (`tipo_cita`) REFERENCES `tipos_de_cita` (`id_tipo_cita`),
  ADD CONSTRAINT `fk_doctor` FOREIGN KEY (`doctor_asignado`) REFERENCES `crear_usuario` (`id_usuario`);

--
-- Filtros para la tabla `crear_usuario`
--
ALTER TABLE `crear_usuario`
  ADD CONSTRAINT `crear_usuario_ibfk_1` FOREIGN KEY (`tipo_documento_id`) REFERENCES `tipo_documento` (`id_tipo_documento`),
  ADD CONSTRAINT `crear_usuario_ibfk_2` FOREIGN KEY (`ciudad_id`) REFERENCES `ciudad` (`id_ciudad`),
  ADD CONSTRAINT `crear_usuario_ibfk_3` FOREIGN KEY (`sexo`) REFERENCES `sexos` (`id_sexo`),
  ADD CONSTRAINT `crear_usuario_ibfk_4` FOREIGN KEY (`estado_civil`) REFERENCES `estados_civiles` (`id_estado_civil`),
  ADD CONSTRAINT `crear_usuario_ibfk_5` FOREIGN KEY (`estrato`) REFERENCES `estratos` (`id_estrato`),
  ADD CONSTRAINT `crear_usuario_ibfk_6` FOREIGN KEY (`RH`) REFERENCES `tipos_rh` (`id_RH`),
  ADD CONSTRAINT `crear_usuario_ibfk_7` FOREIGN KEY (`sisben`) REFERENCES `tipos_sisben` (`id_sisben`),
  ADD CONSTRAINT `crear_usuario_ibfk_8` FOREIGN KEY (`rol`) REFERENCES `tabla_roles` (`id_tipo_Rol`),
  ADD CONSTRAINT `fk_especialidad` FOREIGN KEY (`especialidad`) REFERENCES `especialidades` (`Id_especialidades`),
  ADD CONSTRAINT `id` FOREIGN KEY (`Eps`) REFERENCES `nombre_eps` (`id`),
  ADD CONSTRAINT `ocupacion` FOREIGN KEY (`Ocupacion`) REFERENCES `ocupaciones` (`id_ocupacion`);

--
-- Filtros para la tabla `examenes`
--
ALTER TABLE `examenes`
  ADD CONSTRAINT `examenes_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `crear_usuario` (`id_usuario`),
  ADD CONSTRAINT `examenes_ibfk_2` FOREIGN KEY (`tipo_De_Pruebas`) REFERENCES `examenes_medicos` (`id_Examenes`),
  ADD CONSTRAINT `fk_doctor_encargado` FOREIGN KEY (`doctor_encargado`) REFERENCES `crear_usuario` (`id_usuario`);

--
-- Filtros para la tabla `formulas_medicas`
--
ALTER TABLE `formulas_medicas`
  ADD CONSTRAINT `fk_formulas_medicas` FOREIGN KEY (`Doctor`) REFERENCES `crear_usuario` (`id_usuario`),
  ADD CONSTRAINT `formulas_medicas_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `crear_usuario` (`id_usuario`);

--
-- Filtros para la tabla `historia_medica`
--
ALTER TABLE `historia_medica`
  ADD CONSTRAINT `historia_medica_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `crear_usuario` (`id_usuario`),
  ADD CONSTRAINT `historia_medica_ibfk_2` FOREIGN KEY (`resultados_analisis`) REFERENCES `analisis` (`id_analisis`),
  ADD CONSTRAINT `historia_medica_ibfk_3` FOREIGN KEY (`resultados_imagenes`) REFERENCES `resultados_img` (`id_imagenes`);

--
-- Filtros para la tabla `incapacidades`
--
ALTER TABLE `incapacidades`
  ADD CONSTRAINT `incapacidades_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `crear_usuario` (`id_usuario`),
  ADD CONSTRAINT `incapacidades_ibfk_2` FOREIGN KEY (`doctor_encargado`) REFERENCES `crear_usuario` (`id_usuario`);

--
-- Filtros para la tabla `restaurar_contrasena`
--
ALTER TABLE `restaurar_contrasena`
  ADD CONSTRAINT `restaurar_contrasena_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `crear_usuario` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
