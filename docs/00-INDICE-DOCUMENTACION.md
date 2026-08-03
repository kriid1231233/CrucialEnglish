# Índice General de Documentación - CrucialEnglish

**Versión:** 1.0  
**Fecha:** 27 de julio de 2026  
**Estado:** Documentación en construcción

---

## 📖 Cómo Usar Esta Documentación

Este índice organiza toda la documentación del proyecto **CrucialEnglish** por fases y categorías. Los documentos están diseñados para leerse en orden secuencial, pero también permiten consultas específicas.

**Leyenda de Estados:**
- ✅ **Completado y revisado**
- 🔄 **En progreso**
- ⏳ **Pendiente**

---

## 1. Documentación de Análisis y Diseño

### 1.1 Documentos Principales

| # | Documento | Estado | Descripción |
|---|-----------|--------|-------------|
| 01 | [**Resumen Ejecutivo**](01-RESUMEN-EJECUTIVO.md) | ✅ | Visión general del proyecto, objetivos, alcance, stack tecnológico, métricas de éxito |
| 02 | [**Módulos del MVP**](02-MODULOS-MVP.md) | ✅ | Definición de los 8 módulos funcionales del MVP, dependencias, estimaciones |
| 03 | [**Requerimientos Funcionales**](03-REQUERIMIENTOS-FUNCIONALES.md) | ✅ | 48 requerimientos funcionales detallados con criterios de aceptación |
| 04 | [**Herramientas de Desarrollo**](04-HERRAMIENTAS-DESARROLLO.md) | ✅ | Stack tecnológico completo, instalación, configuración del entorno |
| 05 | [**Modelos Eloquent**](05-MODELOS-ELOQUENT.md) | ✅ | Documentación de los 21 modelos Eloquent con relaciones, casts y métodos |
| 06 | [**Configuración de Middleware**](06-CONFIGURACION-MIDDLEWARE.md) | ✅ | Middleware de roles y usuario activo, ejemplos de rutas por rol |
| 07 | [**Resumen de Implementación**](07-RESUMEN-IMPLEMENTACION.md) | ✅ | Resumen completo de Policies, Form Requests, Seeders y Middleware creados |

### 1.2 Documentos Técnicos (Próximamente)

| # | Documento | Estado | Descripción |
|---|-----------|--------|-------------|
| 08 | **Modelo de Base de Datos (DER)** | ⏳ | Diagrama Entidad-Relación completo, relaciones, cardinalidades |
| 09 | **Diccionario de Datos** | ⏳ | Definición detallada de todas las tablas, campos, tipos de datos |
| 10 | **Plan de Migraciones** | ⏳ | Orden de ejecución de migraciones, dependencias |
| 11 | **Arquitectura de Código** | ⏳ | Estructura de carpetas, namespaces, convenciones de código |

---

## 2. Documentación por Módulo

### 2.1 Módulo Público

| # | Documento | Estado | Descripción |
|---|-----------|--------|-------------|
| 12 | **Módulo Público - Especificación** | ⏳ | Detalle de vistas, rutas, controladores |
| 13 | **Módulo Público - Diseño UI/UX** | ⏳ | Wireframes, mockups, flujo de usuario |

### 2.2 Módulo Identidad y Roles

| # | Documento | Estado | Descripción |
|---|-----------|--------|-------------|
| 14 | **Módulo Identidad - Especificación** | ⏳ | Autenticación, roles multiusuario, perfiles |
| 15 | **Módulo Identidad - Políticas de Acceso** | ⏳ | Definición de Policies, Gates, Middleware |

### 2.3 Módulo Catálogo

| # | Documento | Estado | Descripción |
|---|-----------|--------|-------------|
| 16 | **Módulo Catálogo - Especificación** | ⏳ | Productos, niveles, ofertas |
| 17 | **Módulo Catálogo - Reglas de Negocio** | ⏳ | Lógica de precios, estados de producto |

### 2.4 Módulo Comercial

| # | Documento | Estado | Descripción |
|---|-----------|--------|-------------|
| 18 | **Módulo Comercial - Especificación** | ⏳ | Carrito, checkout, órdenes, pagos |
| 19 | **Integración con Webpay Plus** | ⏳ | Flujo de pago, validaciones, manejo de errores |
| 20 | **Lógica de Habilitación de Accesos** | ⏳ | Automatización post-pago, reglas de acceso |

### 2.5 Módulo Académico

| # | Documento | Estado | Descripción |
|---|-----------|--------|-------------|
| 21 | **Módulo Académico - Especificación** | ⏳ | Grupos, sesiones, asistencia, notas |
| 22 | **Módulo Académico - Reglas de Progresión** | ⏳ | Criterios de aprobación, avance de niveles |

### 2.6 Módulo Gestión de Contenido

| # | Documento | Estado | Descripción |
|---|-----------|--------|-------------|
| 23 | **Módulo Contenido - Especificación** | ⏳ | Materiales, clases pregrabadas, aprobaciones |
| 24 | **Gestión de Archivos** | ⏳ | Almacenamiento, seguridad, límites de tamaño |

### 2.7 Módulo Paneles de Usuario

| # | Documento | Estado | Descripción |
|---|-----------|--------|-------------|
| 25 | **Módulo Paneles - Especificación** | ⏳ | Dashboards por rol, widgets, navegación |

### 2.8 Módulo Notificaciones

| # | Documento | Estado | Descripción |
|---|-----------|--------|-------------|
| 26 | **Módulo Notificaciones - Especificación** | ⏳ | Notificaciones internas, correos, avisos |
| 27 | **Plantillas de Correo** | ⏳ | Diseño de emails, triggers, configuración SMTP |

---

## 3. Guías de Desarrollo

### 3.1 Setup y Configuración

| # | Documento | Estado | Descripción |
|---|-----------|--------|-------------|
| 28 | **Guía de Instalación Local** | ⏳ | Paso a paso para configurar entorno de desarrollo |
| 29 | **Guía de Configuración de Git** | ⏳ | Estrategia de branching, commits, pull requests |

### 3.2 Desarrollo por Módulo

| # | Documento | Estado | Descripción |
|---|-----------|--------|-------------|
| 30 | **Guía: Crear Nueva Migración** | ⏳ | Convenciones, orden, relaciones |
| 31 | **Guía: Crear Nuevo Controlador** | ⏳ | Estructura, validaciones, respuestas |
| 32 | **Guía: Crear Nueva Vista Blade** | ⏳ | Layouts, componentes, helpers |
| 33 | **Guía: Implementar Política de Acceso** | ⏳ | Policies, Gates, Middleware |

### 3.3 Testing

| # | Documento | Estado | Descripción |
|---|-----------|--------|-------------|
| 34 | **Guía de Testing** | ⏳ | PHPUnit, Feature Tests, Unit Tests |
| 35 | **Plan de Casos de Prueba** | ⏳ | Casos de prueba por requerimiento |

---

## 4. Documentación de Despliegue

| # | Documento | Estado | Descripción |
|---|-----------|--------|-------------|
| 36 | **Manual de Despliegue en Producción** | ⏳ | Checklist, configuración de servidor, deployment |
| 37 | **Configuración de Cron y Queues** | ⏳ | Laravel Scheduler, Laravel Queue, Supervisor |
| 38 | **Plan de Backups** | ⏳ | Estrategia de respaldo de base de datos |
| 39 | **Monitoreo y Logs** | ⏳ | Configuración de logs, alertas, debugging |

---

## 5. Documentación de Usuario Final

| # | Documento | Estado | Descripción |
|---|-----------|--------|-------------|
| 40 | **Manual del Estudiante** | ⏳ | Guía de uso para estudiantes |
| 41 | **Manual del Docente** | ⏳ | Guía de uso para docentes |
| 42 | **Manual del Administrador** | ⏳ | Guía de uso para administradores |
| 43 | **FAQ (Preguntas Frecuentes)** | ⏳ | Dudas comunes y soluciones |

---

## 6. Documentación Complementaria

### 6.1 Decisiones de Arquitectura

| # | Documento | Estado | Descripción |
|---|-----------|--------|-------------|
| 44 | **ADR-001: Elección de Laravel vs WordPress** | ⏳ | Justificación técnica de la elección |
| 45 | **ADR-002: Estrategia de Roles Multiusuario** | ⏳ | Decisión de usar tabla `user_roles` |
| 46 | **ADR-003: Almacenamiento de Archivos** | ⏳ | Local vs Cloud Storage |

### 6.2 Diagramas

| # | Documento | Estado | Descripción |
|---|-----------|--------|-------------|
| 47 | **Diagrama de Arquitectura del Sistema** | ⏳ | Visión general de capas y componentes |
| 48 | **Diagrama de Flujo de Compra** | ⏳ | Flujo completo desde carrito hasta acceso |
| 49 | **Diagrama de Casos de Uso** | ⏳ | Interacciones por rol |
| 50 | **Diagrama de Secuencia: Pago con Webpay** | ⏳ | Interacción con pasarela de pagos |

---

## 7. Gestión del Proyecto

| # | Documento | Estado | Descripción |
|---|-----------|--------|-------------|
| 51 | **Plan de Proyecto** | ⏳ | Cronograma, hitos, entregables |
| 52 | **Matriz de Riesgos** | ⏳ | Identificación y mitigación de riesgos |
| 53 | **Actas de Reuniones** | ⏳ | Registro de decisiones y acuerdos |

---

## 📌 Orden de Lectura Recomendado

### Para Comprender el Proyecto (Primera Lectura)
1. [Resumen Ejecutivo](01-RESUMEN-EJECUTIVO.md)
2. [Módulos del MVP](02-MODULOS-MVP.md)
3. [Requerimientos Funcionales](03-REQUERIMIENTOS-FUNCIONALES.md)

### Para Configurar el Entorno de Desarrollo
1. [Herramientas de Desarrollo](04-HERRAMIENTAS-DESARROLLO.md)
2. [Modelos Eloquent](05-MODELOS-ELOQUENT.md)
3. [Configuración de Middleware](06-CONFIGURACION-MIDDLEWARE.md)
4. [Resumen de Implementación](07-RESUMEN-IMPLEMENTACION.md)
5. Guía de Instalación Local (Próximamente)
6. Guía de Configuración de Git (Próximamente)

### Para Desarrollar
1. Modelo de Base de Datos (DER) (Próximamente)
2. Diccionario de Datos (Próximamente)
3. Arquitectura de Código (Próximamente)
4. Guías de Desarrollo por Módulo (Próximamente)

### Para Desplegar
1. Manual de Despliegue en Producción (Próximamente)
2. Configuración de Cron y Queues (Próximamente)
3. Plan de Backups (Próximamente)

---

## 🔄 Convenciones de Documentación

### Formato de Documentos
- **Markdown (.md)** para todos los documentos técnicos
- **PlantUML (.puml)** para diagramas (próximamente)
- **Mermaid** para diagramas simples embebidos en Markdown

### Estructura de Cada Documento
1. **Encabezado:** Título, versión, fecha, estado
2. **Introducción:** Contexto y propósito del documento
3. **Contenido principal:** Secciones numeradas
4. **Próximos pasos:** Qué sigue después de este documento
5. **Pie de página:** Autor, revisores, próximas entregas

### Versionado de Documentos
- **1.0:** Primera versión completa y revisada
- **1.1:** Revisión menor (correcciones, clarificaciones)
- **2.0:** Cambio significativo de contenido

---

## 📝 Contribuir a la Documentación

Si necesitas actualizar o agregar documentación:

1. Crear rama `docs/nombre-documento`
2. Editar o crear documento en carpeta `docs/`
3. Seguir las convenciones de formato
4. Actualizar este índice si se agrega nuevo documento
5. Commit: `docs: agregar/actualizar nombre-documento`
6. Pull Request para revisión

---

## 🔗 Enlaces Útiles

- [README principal del proyecto](../README.md)
- [Documentación oficial de Laravel](https://laravel.com/docs)
- [Documentación de Bootstrap 5](https://getbootstrap.com/docs/5.3/)
- [Documentación de Webpay Plus](https://www.transbankdevelopers.cl/documentacion/webpay-plus)

---

**Última actualización:** 3 de agosto de 2026  
**Mantenido por:** Equipo de Desarrollo CrucialEnglish  
**Próxima revisión programada:** Fase de Controladores y Rutas
