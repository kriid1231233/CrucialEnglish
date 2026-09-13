-- CrucialEnglish - Esquema completo en español (con datos reales migrados)
-- Generado para reemplazar la base de datos `crucial_english`.
-- Las tablas internas de Laravel (cache, cache_locks, jobs, job_batches,
-- failed_jobs, migrations, notifications, password_reset_tokens, sessions)
-- se mantienen en inglés porque sus nombres de columna están codificados
-- dentro del framework (sesiones, cache, colas, verificación de contraseñas)
-- y traducirlas rompería esas funcionalidades sin ningún beneficio real.

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET FOREIGN_KEY_CHECKS = 0;
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

-- --------------------------------------------------------
-- Limpieza de tablas existentes (si se reimporta este script)
-- --------------------------------------------------------
DROP TABLE IF EXISTS `roles_usuario`;
DROP TABLE IF EXISTS `perfiles_estudiante`;
DROP TABLE IF EXISTS `perfiles_docente`;
DROP TABLE IF EXISTS `estudiantes_grupo`;
DROP TABLE IF EXISTS `asistencia_sesion`;
DROP TABLE IF EXISTS `notas_estudiante`;
DROP TABLE IF EXISTS `registros_estudiante`;
DROP TABLE IF EXISTS `sesiones_clase`;
DROP TABLE IF EXISTS `grupos_academicos`;
DROP TABLE IF EXISTS `materiales`;
DROP TABLE IF EXISTS `clases_grabadas`;
DROP TABLE IF EXISTS `anuncios`;
DROP TABLE IF EXISTS `mensajes_contacto`;
DROP TABLE IF EXISTS `accesos_estudiante`;
DROP TABLE IF EXISTS `suscripciones`;
DROP TABLE IF EXISTS `pagos`;
DROP TABLE IF EXISTS `items_pedido`;
DROP TABLE IF EXISTS `pedidos`;
DROP TABLE IF EXISTS `ofertas_producto`;
DROP TABLE IF EXISTS `productos`;
DROP TABLE IF EXISTS `tipos_producto`;
DROP TABLE IF EXISTS `niveles`;
DROP TABLE IF EXISTS `roles`;
DROP TABLE IF EXISTS `usuarios`;
DROP TABLE IF EXISTS `cache`;
DROP TABLE IF EXISTS `cache_locks`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `job_batches`;
DROP TABLE IF EXISTS `failed_jobs`;
DROP TABLE IF EXISTS `notifications`;
DROP TABLE IF EXISTS `password_reset_tokens`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `migrations`;

-- --------------------------------------------------------
-- Identidad y roles
-- --------------------------------------------------------

CREATE TABLE `usuarios` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `eliminado_en` timestamp NULL DEFAULT NULL,
  `creado_en` timestamp NULL DEFAULT current_timestamp(),
  `actualizado_en` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuarios_email_unique` (`email`),
  KEY `idx_usuarios_activo` (`activo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `email_verified_at`, `activo`, `remember_token`, `eliminado_en`, `creado_en`, `actualizado_en`) VALUES
(2, 'gabriel galvez silva', 'galvezgabriel8@gmail.com', '$2y$12$hfDFsYdRHo1KtbByQ1EL8.RPu8aKWq7mrwV9mUx57iapPhbHGjT7e', '2026-08-04 08:01:06', 1, NULL, NULL, '2026-08-04 08:01:06', '2026-08-23 07:01:35'),
(3, 'Administrador', 'admin@crucialenglish.com', '$2y$12$aNTtdPPk/wFfHVW/HSQ9ceS7asRi07Rt3kJD8MvXuaesD/pVV44GW', '2026-09-13 19:26:16', 1, NULL, NULL, '2026-09-13 19:26:16', '2026-09-13 19:26:16');

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `identificador` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `creado_en` timestamp NULL DEFAULT current_timestamp(),
  `actualizado_en` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_identificador_unique` (`identificador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `roles` (`id`, `nombre`, `identificador`, `descripcion`, `creado_en`, `actualizado_en`) VALUES
(1, 'Estudiante', 'estudiante', 'Usuario que accede a clases, materiales y contenido educativo', '2026-08-04 07:59:15', '2026-08-04 07:59:15'),
(2, 'Docente', 'docente', 'Usuario que gestiona grupos, registra asistencia, crea materiales y evalúa estudiantes', '2026-08-04 07:59:15', '2026-08-04 07:59:15'),
(3, 'Administrador', 'administrador', 'Usuario con acceso completo al sistema, gestiona productos, usuarios y aprueba contenido', '2026-08-04 07:59:15', '2026-08-04 07:59:15');

CREATE TABLE `roles_usuario` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `rol_id` bigint(20) UNSIGNED NOT NULL,
  `asignado_en` timestamp NULL DEFAULT current_timestamp(),
  `asignado_por` bigint(20) UNSIGNED DEFAULT NULL,
  `creado_en` timestamp NULL DEFAULT current_timestamp(),
  `actualizado_en` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_roles_usuario` (`usuario_id`,`rol_id`),
  KEY `fk_roles_usuario_rol` (`rol_id`),
  KEY `fk_roles_usuario_asignado_por` (`asignado_por`),
  CONSTRAINT `fk_roles_usuario_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_roles_usuario_rol` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_roles_usuario_asignado_por` FOREIGN KEY (`asignado_por`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `roles_usuario` (`id`, `usuario_id`, `rol_id`, `asignado_en`, `asignado_por`, `creado_en`, `actualizado_en`) VALUES
(1, 2, 1, '2026-08-04 08:01:06', NULL, '2026-08-04 08:01:06', '2026-08-04 08:01:06'),
(2, 3, 3, '2026-09-13 19:26:16', NULL, '2026-09-13 19:26:16', '2026-09-13 19:26:16');

CREATE TABLE `perfiles_estudiante` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `preferencias_contacto` varchar(255) DEFAULT NULL,
  `notas_disponibilidad` text DEFAULT NULL,
  `creado_en` timestamp NULL DEFAULT current_timestamp(),
  `actualizado_en` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `perfiles_estudiante_usuario_id_unique` (`usuario_id`),
  CONSTRAINT `fk_perfiles_estudiante_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `perfiles_estudiante` (`id`, `usuario_id`, `telefono`, `fecha_nacimiento`, `preferencias_contacto`, `notas_disponibilidad`, `creado_en`, `actualizado_en`) VALUES
(1, 2, NULL, NULL, NULL, NULL, '2026-08-04 08:01:06', '2026-08-04 08:01:06');

CREATE TABLE `perfiles_docente` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `especializacion` varchar(150) DEFAULT NULL,
  `biografia` varchar(500) DEFAULT NULL,
  `horario_disponibilidad` text DEFAULT NULL,
  `creado_en` timestamp NULL DEFAULT current_timestamp(),
  `actualizado_en` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `perfiles_docente_usuario_id_unique` (`usuario_id`),
  CONSTRAINT `fk_perfiles_docente_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Catálogo
-- --------------------------------------------------------

CREATE TABLE `niveles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` varchar(10) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT 0,
  `creado_en` timestamp NULL DEFAULT current_timestamp(),
  `actualizado_en` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `niveles_codigo_unique` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `niveles` (`id`, `codigo`, `nombre`, `descripcion`, `orden`, `creado_en`, `actualizado_en`) VALUES
(1, 'A1', 'Principiante (A1)', 'Comprende y utiliza expresiones cotidianas de uso muy frecuente. Puede presentarse a sí mismo y a otros.', 1, '2026-09-13 19:26:16', '2026-09-13 19:26:16'),
(2, 'A2', 'Elemental (A2)', 'Comprende frases y expresiones de uso frecuente relacionadas con áreas de experiencia relevantes.', 2, '2026-09-13 19:26:16', '2026-09-13 19:26:16'),
(3, 'B1', 'Intermedio (B1)', 'Comprende los puntos principales de textos claros en situaciones de trabajo, estudio y ocio.', 3, '2026-09-13 19:26:16', '2026-09-13 19:26:16'),
(4, 'B2', 'Intermedio Alto (B2)', 'Entiende las ideas principales de textos complejos. Puede relacionarse con hablantes nativos con fluidez.', 4, '2026-09-13 19:26:16', '2026-09-13 19:26:16'),
(5, 'C1', 'Avanzado (C1)', 'Comprende textos largos y complejos, reconociendo significados implícitos. Se expresa con fluidez y espontaneidad.', 5, '2026-09-13 19:26:16', '2026-09-13 19:26:16'),
(6, 'C2', 'Dominio (C2)', 'Comprende prácticamente todo lo que oye o lee. Puede expresarse con gran fluidez y precisión.', 6, '2026-09-13 19:26:16', '2026-09-13 19:26:16');

CREATE TABLE `tipos_producto` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `identificador` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `creado_en` timestamp NULL DEFAULT current_timestamp(),
  `actualizado_en` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `tipos_producto_identificador_unique` (`identificador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tipos_producto` (`id`, `nombre`, `identificador`, `descripcion`, `creado_en`, `actualizado_en`) VALUES
(1, 'Clase Individual', 'clase-individual', 'Clases personalizadas uno a uno con el docente, adaptadas a las necesidades específicas del estudiante.', '2026-09-13 19:22:55', '2026-09-13 19:26:16'),
(2, 'Clase Grupal', 'clase-grupal', 'Clases en grupo reducido, ideal para practicar conversación y aprender en comunidad.', '2026-09-13 19:26:16', '2026-09-13 19:26:16'),
(3, 'Material de Apoyo', 'material-apoyo', 'Recursos didácticos digitales: PDFs, ejercicios, guías de estudio y material complementario.', '2026-09-13 19:26:16', '2026-09-13 19:26:16'),
(4, 'Suscripción', 'suscripcion', 'Acceso ilimitado a clases pregrabadas, materiales y recursos educativos durante el período contratado.', '2026-09-13 19:26:16', '2026-09-13 19:26:16');

CREATE TABLE `productos` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tipo_producto_id` bigint(20) UNSIGNED NOT NULL,
  `nivel_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio_base` decimal(10,2) NOT NULL,
  `modalidad_cobro` enum('one_time','monthly','package') NOT NULL DEFAULT 'one_time',
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `eliminado_en` timestamp NULL DEFAULT NULL,
  `creado_en` timestamp NULL DEFAULT current_timestamp(),
  `actualizado_en` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_productos_tipo` (`tipo_producto_id`),
  KEY `fk_productos_nivel` (`nivel_id`),
  KEY `idx_productos_activo` (`activo`),
  CONSTRAINT `fk_productos_tipo` FOREIGN KEY (`tipo_producto_id`) REFERENCES `tipos_producto` (`id`),
  CONSTRAINT `fk_productos_nivel` FOREIGN KEY (`nivel_id`) REFERENCES `niveles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `productos` (`id`, `tipo_producto_id`, `nivel_id`, `nombre`, `descripcion`, `precio_base`, `modalidad_cobro`, `activo`, `eliminado_en`, `creado_en`, `actualizado_en`) VALUES
(2, 1, 1, 'Inglés Individual A1', 'Clases personalizadas uno a uno para comenzar desde cero con bases sólidas.', 45000.00, 'package', 1, NULL, '2026-09-13 19:26:46', '2026-09-13 19:26:46'),
(3, 1, 5, 'Preparación Business English C1', 'Clases individuales enfocadas en inglés de negocios para nivel avanzado.', 52000.00, 'package', 1, NULL, '2026-09-13 19:26:46', '2026-09-13 19:26:46'),
(4, 2, 3, 'Grupo Conversacional B1', 'Clases grupales para practicar conversación con estudiantes de tu mismo nivel.', 28000.00, 'monthly', 1, NULL, '2026-09-13 19:26:46', '2026-09-13 19:26:46'),
(5, 2, 4, 'Grupo Intensivo B2', 'Grupo reducido con ritmo intensivo para consolidar el nivel intermedio alto.', 32000.00, 'monthly', 1, NULL, '2026-09-13 19:26:46', '2026-09-13 19:26:46'),
(6, 3, NULL, 'Guía de Gramática Completa', 'Material de apoyo descargable con ejercicios prácticos para todos los niveles.', 12000.00, 'one_time', 1, NULL, '2026-09-13 19:26:46', '2026-09-13 19:26:46'),
(7, 4, NULL, 'Suscripción Mensual Premium', 'Acceso ilimitado a clases pregrabadas y materiales durante un mes.', 25000.00, 'monthly', 1, NULL, '2026-09-13 19:26:46', '2026-09-13 19:26:46');

CREATE TABLE `ofertas_producto` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `producto_id` bigint(20) UNSIGNED NOT NULL,
  `precio_oferta` decimal(10,2) NOT NULL,
  `vigente_desde` datetime NOT NULL,
  `vigente_hasta` datetime NOT NULL,
  `creado_en` timestamp NULL DEFAULT current_timestamp(),
  `actualizado_en` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_ofertas_producto_producto` (`producto_id`),
  CONSTRAINT `fk_ofertas_producto_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Comercial
-- --------------------------------------------------------

CREATE TABLE `pedidos` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `estudiante_id` bigint(20) UNSIGNED NOT NULL,
  `monto_total` decimal(10,2) NOT NULL,
  `estado` enum('pending','paid','failed','cancelled') NOT NULL DEFAULT 'pending',
  `creado_en` timestamp NULL DEFAULT current_timestamp(),
  `actualizado_en` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_pedidos_estado` (`estado`),
  KEY `idx_pedidos_estudiante` (`estudiante_id`),
  CONSTRAINT `fk_pedidos_estudiante` FOREIGN KEY (`estudiante_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `pedidos` (`id`, `estudiante_id`, `monto_total`, `estado`, `creado_en`, `actualizado_en`) VALUES
(3, 2, 32000.00, 'pending', '2026-09-13 19:28:58', '2026-09-13 19:28:58');

CREATE TABLE `items_pedido` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pedido_id` bigint(20) UNSIGNED NOT NULL,
  `producto_id` bigint(20) UNSIGNED NOT NULL,
  `cantidad` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `creado_en` timestamp NULL DEFAULT current_timestamp(),
  `actualizado_en` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_items_pedido_pedido` (`pedido_id`),
  KEY `fk_items_pedido_producto` (`producto_id`),
  CONSTRAINT `fk_items_pedido_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_items_pedido_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `items_pedido` (`id`, `pedido_id`, `producto_id`, `cantidad`, `precio_unitario`, `subtotal`, `creado_en`, `actualizado_en`) VALUES
(3, 3, 5, 1, 32000.00, 32000.00, '2026-09-13 19:28:58', '2026-09-13 19:28:58');

CREATE TABLE `pagos` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pedido_id` bigint(20) UNSIGNED NOT NULL,
  `id_transaccion` varchar(100) DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL,
  `estado` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `metodo_pago` varchar(50) DEFAULT 'webpay_plus',
  `fecha_pago` timestamp NULL DEFAULT NULL,
  `creado_en` timestamp NULL DEFAULT current_timestamp(),
  `actualizado_en` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_pagos_pedido` (`pedido_id`),
  KEY `idx_pagos_estado` (`estado`),
  KEY `idx_pagos_transaccion` (`id_transaccion`),
  CONSTRAINT `fk_pagos_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `accesos_estudiante` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `estudiante_id` bigint(20) UNSIGNED NOT NULL,
  `producto_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_acceso` enum('material','recorded_lesson') NOT NULL,
  `otorgado_en` timestamp NULL DEFAULT current_timestamp(),
  `expira_en` timestamp NULL DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `creado_en` timestamp NULL DEFAULT current_timestamp(),
  `actualizado_en` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_accesos_estudiante_estudiante` (`estudiante_id`),
  KEY `fk_accesos_estudiante_producto` (`producto_id`),
  KEY `idx_accesos_estudiante_activo` (`activo`),
  CONSTRAINT `fk_accesos_estudiante_estudiante` FOREIGN KEY (`estudiante_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_accesos_estudiante_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `suscripciones` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `estudiante_id` bigint(20) UNSIGNED NOT NULL,
  `producto_id` bigint(20) UNSIGNED NOT NULL,
  `inicia_en` date NOT NULL,
  `termina_en` date NOT NULL,
  `estado` enum('active','expired','cancelled') NOT NULL DEFAULT 'active',
  `creado_en` timestamp NULL DEFAULT current_timestamp(),
  `actualizado_en` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_suscripciones_estudiante` (`estudiante_id`),
  KEY `fk_suscripciones_producto` (`producto_id`),
  KEY `idx_suscripciones_estado` (`estado`),
  CONSTRAINT `fk_suscripciones_estudiante` FOREIGN KEY (`estudiante_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_suscripciones_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Académico
-- --------------------------------------------------------

CREATE TABLE `grupos_academicos` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `nivel_id` bigint(20) UNSIGNED NOT NULL,
  `docente_id` bigint(20) UNSIGNED DEFAULT NULL,
  `descripcion_horario` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `creado_en` timestamp NULL DEFAULT NULL,
  `actualizado_en` timestamp NULL DEFAULT NULL,
  `eliminado_en` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_grupos_academicos_nivel` (`nivel_id`),
  KEY `fk_grupos_academicos_docente` (`docente_id`),
  CONSTRAINT `fk_grupos_academicos_nivel` FOREIGN KEY (`nivel_id`) REFERENCES `niveles` (`id`),
  CONSTRAINT `fk_grupos_academicos_docente` FOREIGN KEY (`docente_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `estudiantes_grupo` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `grupo_id` bigint(20) UNSIGNED NOT NULL,
  `estudiante_id` bigint(20) UNSIGNED NOT NULL,
  `union_en` timestamp NULL DEFAULT NULL,
  `salida_en` timestamp NULL DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `creado_en` timestamp NULL DEFAULT NULL,
  `actualizado_en` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_estudiantes_grupo_grupo` (`grupo_id`),
  KEY `fk_estudiantes_grupo_estudiante` (`estudiante_id`),
  CONSTRAINT `fk_estudiantes_grupo_grupo` FOREIGN KEY (`grupo_id`) REFERENCES `grupos_academicos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_estudiantes_grupo_estudiante` FOREIGN KEY (`estudiante_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sesiones_clase` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `grupo_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_sesion` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `duracion_minutos` smallint(5) UNSIGNED NOT NULL DEFAULT 60,
  `tema` varchar(255) DEFAULT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'scheduled',
  `creado_en` timestamp NULL DEFAULT NULL,
  `actualizado_en` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sesiones_clase_grupo` (`grupo_id`),
  CONSTRAINT `fk_sesiones_clase_grupo` FOREIGN KEY (`grupo_id`) REFERENCES `grupos_academicos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `asistencia_sesion` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sesion_clase_id` bigint(20) UNSIGNED NOT NULL,
  `estudiante_id` bigint(20) UNSIGNED NOT NULL,
  `estado_asistencia` varchar(255) NOT NULL DEFAULT 'present',
  `notas` text DEFAULT NULL,
  `creado_en` timestamp NULL DEFAULT NULL,
  `actualizado_en` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_asistencia_sesion_sesion` (`sesion_clase_id`),
  KEY `fk_asistencia_sesion_estudiante` (`estudiante_id`),
  CONSTRAINT `fk_asistencia_sesion_sesion` FOREIGN KEY (`sesion_clase_id`) REFERENCES `sesiones_clase` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_asistencia_sesion_estudiante` FOREIGN KEY (`estudiante_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `notas_estudiante` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `estudiante_id` bigint(20) UNSIGNED NOT NULL,
  `nivel_id` bigint(20) UNSIGNED NOT NULL,
  `grupo_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tipo_evaluacion` varchar(255) NOT NULL,
  `nota` decimal(2,1) NOT NULL,
  `fecha_evaluacion` date NOT NULL,
  `comentarios` text DEFAULT NULL,
  `creado_en` timestamp NULL DEFAULT NULL,
  `actualizado_en` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_notas_estudiante_estudiante` (`estudiante_id`),
  KEY `fk_notas_estudiante_nivel` (`nivel_id`),
  KEY `fk_notas_estudiante_grupo` (`grupo_id`),
  CONSTRAINT `fk_notas_estudiante_estudiante` FOREIGN KEY (`estudiante_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_notas_estudiante_nivel` FOREIGN KEY (`nivel_id`) REFERENCES `niveles` (`id`),
  CONSTRAINT `fk_notas_estudiante_grupo` FOREIGN KEY (`grupo_id`) REFERENCES `grupos_academicos` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `registros_estudiante` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `estudiante_id` bigint(20) UNSIGNED NOT NULL,
  `nivel_id` bigint(20) UNSIGNED NOT NULL,
  `completado_en` date DEFAULT NULL,
  `promedio` decimal(2,1) DEFAULT NULL,
  `aprobado` tinyint(1) NOT NULL DEFAULT 0,
  `creado_en` timestamp NULL DEFAULT NULL,
  `actualizado_en` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_registros_estudiante_estudiante` (`estudiante_id`),
  KEY `fk_registros_estudiante_nivel` (`nivel_id`),
  CONSTRAINT `fk_registros_estudiante_estudiante` FOREIGN KEY (`estudiante_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_registros_estudiante_nivel` FOREIGN KEY (`nivel_id`) REFERENCES `niveles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Contenido
-- --------------------------------------------------------

CREATE TABLE `materiales` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `nivel_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_archivo` varchar(255) DEFAULT NULL,
  `ruta_archivo` varchar(255) DEFAULT NULL,
  `enlace_externo` varchar(255) DEFAULT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'pending',
  `autor_id` bigint(20) UNSIGNED NOT NULL,
  `revisado_por` bigint(20) UNSIGNED DEFAULT NULL,
  `revisado_en` timestamp NULL DEFAULT NULL,
  `creado_en` timestamp NULL DEFAULT NULL,
  `actualizado_en` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_materiales_nivel` (`nivel_id`),
  KEY `fk_materiales_autor` (`autor_id`),
  KEY `fk_materiales_revisor` (`revisado_por`),
  CONSTRAINT `fk_materiales_nivel` FOREIGN KEY (`nivel_id`) REFERENCES `niveles` (`id`),
  CONSTRAINT `fk_materiales_autor` FOREIGN KEY (`autor_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_materiales_revisor` FOREIGN KEY (`revisado_por`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `clases_grabadas` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `nivel_id` bigint(20) UNSIGNED NOT NULL,
  `duracion_minutos` smallint(5) UNSIGNED DEFAULT NULL,
  `ruta_video` varchar(255) DEFAULT NULL,
  `enlace_externo` varchar(255) DEFAULT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'pending',
  `autor_id` bigint(20) UNSIGNED NOT NULL,
  `revisado_por` bigint(20) UNSIGNED DEFAULT NULL,
  `revisado_en` timestamp NULL DEFAULT NULL,
  `creado_en` timestamp NULL DEFAULT NULL,
  `actualizado_en` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_clases_grabadas_nivel` (`nivel_id`),
  KEY `fk_clases_grabadas_autor` (`autor_id`),
  KEY `fk_clases_grabadas_revisor` (`revisado_por`),
  CONSTRAINT `fk_clases_grabadas_nivel` FOREIGN KEY (`nivel_id`) REFERENCES `niveles` (`id`),
  CONSTRAINT `fk_clases_grabadas_autor` FOREIGN KEY (`autor_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_clases_grabadas_revisor` FOREIGN KEY (`revisado_por`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Comunicación
-- --------------------------------------------------------

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `anuncios` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `contenido` text NOT NULL,
  `autor_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_audiencia` varchar(255) NOT NULL DEFAULT 'all',
  `audiencia_id` bigint(20) UNSIGNED DEFAULT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'draft',
  `publicado_en` timestamp NULL DEFAULT NULL,
  `creado_en` timestamp NULL DEFAULT NULL,
  `actualizado_en` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_anuncios_autor` (`autor_id`),
  CONSTRAINT `fk_anuncios_autor` FOREIGN KEY (`autor_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `mensajes_contacto` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `leido_en` timestamp NULL DEFAULT NULL,
  `creado_en` timestamp NULL DEFAULT NULL,
  `actualizado_en` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `mensajes_contacto` (`id`, `nombre`, `email`, `mensaje`, `leido_en`, `creado_en`, `actualizado_en`) VALUES
(3, 'Gabriel Galvez', 'galvezgabriel8@gmail.com', 'Solicitud de inscripción rápida desde la página principal. Nivel de interés: A1', NULL, '2026-09-13 18:36:14', '2026-09-13 18:36:14'),
(4, 'Gabriel Galvez', 'galvezgabriel8@gmail.com', 'Solicitud de inscripción rápida desde la página principal. Nivel de interés: B1', NULL, '2026-09-13 18:42:09', '2026-09-13 18:42:09');

-- --------------------------------------------------------
-- Tablas internas de Laravel (se mantienen en inglés)
-- --------------------------------------------------------

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2024_01_01_000001_create_password_reset_tokens_table', 1),
(2, '2024_01_01_000002_create_sessions_table', 1);

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
COMMIT;
