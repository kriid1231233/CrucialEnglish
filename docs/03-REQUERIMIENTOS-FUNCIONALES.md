# Requerimientos Funcionales - CrucialEnglish MVP

**Versión:** 1.0  
**Fecha:** 27 de julio de 2026  
**Alcance:** MVP (Minimum Viable Product)

---

## 1. Introducción

Este documento detalla los **requerimientos funcionales** del MVP de CrucialEnglish, organizados por módulo. Cada requerimiento tiene:

- **ID único** (RF-XXX)
- **Descripción** clara y específica
- **Actor(es)** que ejecutan la acción
- **Prioridad** (Crítica, Alta, Media, Baja)
- **Criterios de aceptación** verificables

---

## 2. Módulo Público

### RF-001: Visualización de Página de Inicio
**Prioridad:** Alta  
**Actor:** Invitado  
**Descripción:** El sistema debe mostrar una página de inicio institucional con mensaje de bienvenida, resumen de servicios y llamados a la acción (registrarse, ver cursos).

**Criterios de Aceptación:**
- La página carga en menos de 3 segundos
- Los botones de CTA son claramente visibles
- El diseño es responsive (funciona en móvil, tablet, desktop)

---

### RF-002: Visualización del Catálogo Público
**Prioridad:** Alta  
**Actor:** Invitado  
**Descripción:** El sistema debe mostrar el catálogo de productos académicos (clases individuales, grupales, materiales, suscripciones) con información básica (nombre, descripción, precio, nivel).

**Criterios de Aceptación:**
- Solo se muestran productos con estado "activo"
- Se puede filtrar por tipo de producto y nivel
- Cada producto tiene enlace a vista de detalle
- No se puede agregar al carrito sin iniciar sesión (botón deshabilitado o redirige a login)

---

### RF-003: Registro de Nueva Cuenta (Estudiante)
**Prioridad:** Crítica  
**Actor:** Invitado  
**Descripción:** El sistema debe permitir a un visitante registrarse como nuevo usuario (estudiante) proporcionando nombre, email y contraseña.

**Criterios de Aceptación:**
- Validación de email único (no permitir duplicados)
- Contraseña mínima de 8 caracteres
- Creación automática de perfil de estudiante (`student_profiles`)
- Asignación automática del rol "Estudiante" (`user_roles`)
- Envío de correo de bienvenida tras registro exitoso
- Redirección al panel de estudiante tras registro

---

### RF-004: Inicio de Sesión
**Prioridad:** Crítica  
**Actor:** Usuario registrado  
**Descripción:** El sistema debe permitir a un usuario registrado iniciar sesión con email y contraseña.

**Criterios de Aceptación:**
- Validación de credenciales correctas
- Bloqueo de cuentas inactivas (`active = false`)
- Si el usuario tiene múltiples roles, se presenta selector de contexto
- Si tiene un solo rol, redirección directa al panel correspondiente
- Sesión persistente (opción "Recordarme")
- Mensaje de error claro si las credenciales son incorrectas

---

### RF-005: Recuperación de Contraseña
**Prioridad:** Alta  
**Actor:** Usuario registrado  
**Descripción:** El sistema debe permitir a un usuario recuperar su contraseña a través de un enlace enviado a su correo electrónico.

**Criterios de Aceptación:**
- Envío de correo con enlace de recuperación (token con expiración)
- El token expira en 60 minutos
- El usuario puede establecer una nueva contraseña
- Invalidación del token tras usarse

---

### RF-006: Formulario de Contacto
**Prioridad:** Media  
**Actor:** Invitado  
**Descripción:** El sistema debe permitir a un visitante enviar un mensaje de contacto al instituto mediante un formulario.

**Criterios de Aceptación:**
- Campos obligatorios: nombre, email, mensaje
- Validación de formato de email
- Envío de correo al administrador con el mensaje
- Mensaje de confirmación al usuario tras envío exitoso
- Protección contra spam (captcha o rate limiting)

---

## 3. Módulo Identidad y Roles

### RF-007: Gestión de Roles
**Prioridad:** Crítica  
**Actor:** Administrador  
**Descripción:** El sistema debe permitir al administrador asignar y revocar roles a usuarios registrados.

**Criterios de Aceptación:**
- Solo el administrador puede gestionar roles
- Un usuario puede tener múltiples roles simultáneamente
- Se registra fecha y autor de la asignación (`assigned_at`, `assigned_by`)
- Trazabilidad completa de cambios de roles

---

### RF-008: Selección de Contexto de Rol (Multirol)
**Prioridad:** Alta  
**Actor:** Usuario con múltiples roles  
**Descripción:** Al iniciar sesión, si el usuario tiene más de un rol activo, el sistema debe presentar un selector para elegir con qué rol operar.

**Criterios de Aceptación:**
- Se muestra listado de roles disponibles para el usuario
- El usuario selecciona un rol y es redirigido al panel correspondiente
- El rol activo se almacena en sesión
- El usuario puede cambiar de rol sin cerrar sesión (dropdown en navbar)

---

### RF-009: Edición de Perfil de Estudiante
**Prioridad:** Media  
**Actor:** Estudiante  
**Descripción:** El sistema debe permitir al estudiante editar su perfil (nombre, teléfono, fecha de nacimiento, preferencias de contacto, disponibilidad horaria).

**Criterios de Aceptación:**
- Validación de datos (formato de teléfono, fecha válida)
- Campos opcionales: disponibilidad horaria (texto libre para indicar días/horas)
- Cambios guardados con confirmación visual
- No se puede cambiar el email desde aquí (requiere validación adicional)

---

### RF-010: Edición de Perfil de Docente
**Prioridad:** Media  
**Actor:** Docente  
**Descripción:** El sistema debe permitir al docente editar su perfil (nombre, especialidad, biografía, horarios de disponibilidad).

**Criterios de Aceptación:**
- Biografía limitada a 500 caracteres
- Horarios de disponibilidad en formato texto o JSON estructurado
- Cambios guardados con confirmación visual

---

### RF-011: Gestión de Usuarios (Administrador)
**Prioridad:** Alta  
**Actor:** Administrador  
**Descripción:** El sistema debe permitir al administrador listar, editar, activar/desactivar y eliminar usuarios.

**Criterios de Aceptación:**
- Listado paginado de usuarios con búsqueda por nombre o email
- Filtros por rol y estado (activo/inactivo)
- Activar/desactivar cuenta sin eliminar datos
- Soft delete recomendado para mantener historial
- Resetear contraseña de un usuario (envía correo)

---

## 4. Módulo Catálogo de Productos

### RF-012: Gestión de Niveles Académicos
**Prioridad:** Alta  
**Actor:** Administrador  
**Descripción:** El sistema debe permitir al administrador gestionar los niveles académicos (A1, A2, B1, B2, C1, C2).

**Criterios de Aceptación:**
- CRUD completo de niveles
- Campos: código, nombre, descripción, orden de progresión
- Validación de códigos únicos
- No se puede eliminar un nivel asociado a productos o grupos activos

---

### RF-013: Gestión de Tipos de Producto
**Prioridad:** Alta  
**Actor:** Administrador  
**Descripción:** El sistema debe permitir al administrador definir los tipos de producto (Clase Individual, Clase Grupal, Material de Apoyo, Suscripción).

**Criterios de Aceptación:**
- CRUD completo de tipos de producto
- Campos: nombre, slug (único), descripción
- Los slugs se usan para lógica de negocio (no modificables después de crear productos asociados)

---

### RF-014: Gestión de Productos
**Prioridad:** Crítica  
**Actor:** Administrador  
**Descripción:** El sistema debe permitir al administrador crear, editar, activar/desactivar y eliminar productos académicos.

**Criterios de Aceptación:**
- CRUD completo de productos
- Campos obligatorios: nombre, tipo, precio base, estado
- Campos opcionales: nivel asociado, descripción, modalidad de cobro
- Validación de precio base > 0
- Solo productos activos se muestran en catálogo público
- Soft delete recomendado para mantener historial de compras

---

### RF-015: Gestión de Ofertas y Promociones
**Prioridad:** Baja (Opcional en MVP)  
**Actor:** Administrador  
**Descripción:** El sistema debe permitir al administrador definir ofertas con precio especial y fecha de vigencia.

**Criterios de Aceptación:**
- Crear oferta asociada a un producto
- Campos: precio con descuento, fecha de inicio, fecha de fin
- Validación: fecha fin > fecha inicio
- El precio efectivo en catálogo y carrito es el de oferta si está vigente
- Al expirar la oferta, el producto vuelve a precio base automáticamente

---

## 5. Módulo Comercial (Ventas y Pagos)

### RF-016: Agregar Producto al Carrito
**Prioridad:** Crítica  
**Actor:** Estudiante  
**Descripción:** El sistema debe permitir al estudiante agregar productos al carrito de compras.

**Criterios de Aceptación:**
- Solo usuarios autenticados con rol "Estudiante" pueden agregar al carrito
- No se puede agregar un producto inactivo
- Se captura el precio vigente en el momento de agregar (precio base u oferta)
- Mensaje de confirmación visual tras agregar

---

### RF-017: Visualización y Gestión del Carrito
**Prioridad:** Crítica  
**Actor:** Estudiante  
**Descripción:** El sistema debe permitir al estudiante ver su carrito, actualizar cantidades (si aplica) y eliminar productos.

**Criterios de Aceptación:**
- Listado de productos en carrito con nombre, precio unitario, cantidad (si aplica), subtotal
- Cálculo automático del total
- Botón para eliminar producto del carrito
- Actualización de cantidades (solo si el tipo de producto lo permite, ej. paquetes)
- Si el carrito está vacío, mostrar mensaje y enlace al catálogo

---

### RF-018: Proceso de Checkout
**Prioridad:** Crítica  
**Actor:** Estudiante  
**Descripción:** El sistema debe permitir al estudiante revisar su orden, capturar información adicional si es necesario y proceder al pago.

**Criterios de Aceptación:**
- Revisión de productos, cantidades y total a pagar
- Para clases individuales/grupales: formulario de disponibilidad horaria (días, horas preferidas)
- Para materiales y suscripciones: confirmación directa
- Creación de orden con estado "pending"
- Redirección a Webpay Plus para pago

---

### RF-019: Integración con Webpay Plus
**Prioridad:** Crítica  
**Actor:** Sistema  
**Descripción:** El sistema debe integrarse con la pasarela de pagos Webpay Plus (Transbank) para procesar pagos con tarjetas de crédito y débito.

**Criterios de Aceptación:**
- Uso de SDK oficial de Transbank para PHP
- Ambiente de integración para desarrollo, ambiente de producción para lanzamiento
- Redirección del estudiante a Transbank con datos de la orden
- Validación de respuesta de pago (commit/rollback)
- Registro de transaction_id y estado del pago
- Manejo de estados: pendiente, aprobado, rechazado
- Trazabilidad completa de transacciones

---

### RF-020: Habilitación Automática de Accesos tras Pago
**Prioridad:** Crítica  
**Actor:** Sistema  
**Descripción:** Tras confirmación de pago exitoso, el sistema debe habilitar automáticamente los accesos correspondientes según el tipo de producto comprado.

**Criterios de Aceptación:**
- **Material de apoyo / Clases pregrabadas:** Crear registro en `student_accesses` con acceso inmediato
- **Suscripción:** Crear registro en `subscriptions` con fecha de inicio (hoy) y fin (según duración)
- **Clases individuales/grupales:** Marcar como "adquirido, pendiente de coordinación" (no se agenda automáticamente)
- Envío de correo de confirmación de compra con detalle de productos
- Creación de notificación interna para el estudiante

---

### RF-021: Historial de Compras del Estudiante
**Prioridad:** Alta  
**Actor:** Estudiante  
**Descripción:** El sistema debe permitir al estudiante ver su historial completo de compras.

**Criterios de Aceptación:**
- Listado de órdenes con fecha, total, estado
- Detalle de cada orden: productos, cantidades, precios
- Indicación visual de estado (pagado, pendiente, fallido, cancelado)
- Descarga de comprobante (opcional en MVP)

---

### RF-022: Supervisión de Pagos (Administrador)
**Prioridad:** Alta  
**Actor:** Administrador  
**Descripción:** El sistema debe permitir al administrador supervisar todas las órdenes y pagos realizados.

**Criterios de Aceptación:**
- Listado de todas las órdenes con búsqueda y filtros (por estudiante, estado, fecha)
- Detalle de cada orden y pago asociado
- Visualización de transaction_id de Transbank
- Trazabilidad de intentos de pago fallidos
- Exportación a CSV (opcional en MVP)

---

## 6. Módulo Académico

### RF-023: Gestión de Grupos
**Prioridad:** Crítica  
**Actor:** Docente, Administrador  
**Descripción:** El sistema debe permitir crear, editar, activar/desactivar y eliminar grupos de estudiantes.

**Criterios de Aceptación:**
- CRUD completo de grupos
- Campos: nombre, nivel, docente asignado, horario (descripción), estado
- Un grupo pertenece a un solo nivel
- Un grupo tiene un solo docente asignado
- Solo el docente asignado o administrador puede gestionar el grupo
- Soft delete recomendado para mantener historial

---

### RF-024: Asignación de Estudiantes a Grupos
**Prioridad:** Crítica  
**Actor:** Docente, Administrador  
**Descripción:** El sistema debe permitir agregar y quitar estudiantes de grupos.

**Criterios de Aceptación:**
- Agregar estudiante a grupo con fecha de ingreso
- Un estudiante puede pertenecer a varios grupos simultáneamente
- Registro de fecha de ingreso y salida del grupo
- Historial de pertenencia a grupos
- Validación: no duplicar estudiante activo en el mismo grupo

---

### RF-025: Programación de Clases (Class Sessions)
**Prioridad:** Crítica  
**Actor:** Docente, Administrador  
**Descripción:** El sistema debe permitir programar sesiones de clase para cada grupo.

**Criterios de Aceptación:**
- CRUD de sesiones de clase
- Campos: grupo, fecha, hora de inicio, duración, tema/descripción, estado
- Estados: programada, realizada, cancelada
- Validación: fecha y hora válidas, no solapar clases del mismo docente
- Solo el docente asignado al grupo o administrador puede programar clases

---

### RF-026: Registro de Asistencia
**Prioridad:** Crítica  
**Actor:** Docente, Administrador  
**Descripción:** El sistema debe permitir al docente registrar la asistencia de cada estudiante en cada sesión de clase.

**Criterios de Aceptación:**
- Listado de estudiantes del grupo en la sesión
- Estados de asistencia: presente, ausente, tardanza, justificado
- Campo opcional para notas/observaciones
- Solo el docente asignado o administrador puede registrar asistencia
- Una vez registrada, se puede editar (no es inmutable)

---

### RF-027: Registro de Notas
**Prioridad:** Crítica  
**Actor:** Docente, Administrador  
**Descripción:** El sistema debe permitir al docente registrar notas de evaluaciones para cada estudiante.

**Criterios de Aceptación:**
- Crear, editar y eliminar notas
- Campos: estudiante, nivel/grupo, tipo de evaluación, calificación (1.0 - 7.0), fecha, comentarios
- Validación: nota entre 1.0 y 7.0 con máximo un decimal
- Solo el docente asignado o administrador puede registrar notas
- Historial de notas completo por estudiante

---

### RF-028: Visualización de Historial Académico (Estudiante)
**Prioridad:** Alta  
**Actor:** Estudiante  
**Descripción:** El sistema debe permitir al estudiante ver su historial académico completo.

**Criterios de Aceptación:**
- Listado de grupos a los que ha pertenecido o pertenece
- Asistencia histórica (porcentaje de asistencia por grupo)
- Notas obtenidas (por nivel, tipo de evaluación)
- Progresión de niveles (qué niveles ha completado)
- El estudiante solo ve su propio historial

---

### RF-029: Progresión de Niveles
**Prioridad:** Media  
**Actor:** Docente, Administrador  
**Descripción:** Al finalizar un nivel, el sistema debe registrar si el estudiante lo aprobó y puede avanzar al siguiente.

**Criterios de Aceptación:**
- Registro en `student_records` con nivel completado, promedio de notas, estado (aprobado/reprobado)
- Criterio de aprobación: promedio >= 5.0 (ajustable por configuración)
- Fecha de completación del nivel
- Notificación al estudiante del resultado

---

### RF-030: Agenda del Estudiante
**Prioridad:** Alta  
**Actor:** Estudiante  
**Descripción:** El sistema debe permitir al estudiante ver su agenda de clases próximas.

**Criterios de Aceptación:**
- Listado de clases programadas para los grupos en los que está inscrito
- Ordenado por fecha/hora
- Información visible: grupo, nivel, docente, fecha, hora, tema
- Vista de calendario (opcional en MVP)

---

## 7. Módulo Gestión de Contenido

### RF-031: Carga de Materiales de Apoyo (Docente)
**Prioridad:** Alta  
**Actor:** Docente  
**Descripción:** El sistema debe permitir al docente subir materiales de apoyo (PDF, documentos, imágenes).

**Criterios de Aceptación:**
- Formulario de carga con campos: título, descripción, nivel, archivo o enlace externo
- Validación de tipo de archivo (PDF, DOC, DOCX, JPG, PNG)
- Límite de tamaño de archivo (ej. 10 MB)
- Estado inicial: "pendiente" (requiere aprobación)
- Confirmación visual tras subida exitosa

---

### RF-032: Carga de Clases Pregrabadas (Docente)
**Prioridad:** Alta  
**Actor:** Docente  
**Descripción:** El sistema debe permitir al docente subir clases pregrabadas (video subido o enlace externo).

**Criterios de Aceptación:**
- Formulario de carga con campos: título, descripción, nivel, duración, video o enlace externo
- Soporte para enlaces de YouTube, Vimeo u otras plataformas
- Si se sube video: validación de tamaño (recomendado: usar enlace externo en MVP)
- Estado inicial: "pendiente" (requiere aprobación)
- Confirmación visual tras subida exitosa

---

### RF-033: Aprobación de Contenido (Administrador)
**Prioridad:** Alta  
**Actor:** Administrador  
**Descripción:** El sistema debe permitir al administrador revisar y aprobar o rechazar materiales y clases pregrabadas subidos por docentes.

**Criterios de Aceptación:**
- Listado de contenido pendiente de aprobación
- Detalle de cada contenido: título, autor, nivel, archivo/enlace
- Opciones: aprobar, rechazar (con comentario opcional)
- Al aprobar: estado cambia a "aprobado", visible para estudiantes con acceso
- Al rechazar: estado cambia a "rechazado", no visible, notificación al docente
- Trazabilidad: quién aprobó/rechazó y cuándo

---

### RF-034: Acceso a Materiales de Apoyo (Estudiante)
**Prioridad:** Alta  
**Actor:** Estudiante  
**Descripción:** El sistema debe permitir al estudiante acceder a los materiales de apoyo que ha adquirido o a los que tiene acceso por suscripción activa.

**Criterios de Aceptación:**
- Listado de materiales accesibles (filtrado según `student_accesses` o `subscriptions` activas)
- Solo materiales con estado "aprobado" son visibles
- Botón de descarga o visualización según tipo de archivo
- Protección: validar acceso antes de servir archivo (middleware)
- Si no tiene acceso, mostrar mensaje y enlace para comprar

---

### RF-035: Acceso a Clases Pregrabadas (Estudiante)
**Prioridad:** Alta  
**Actor:** Estudiante  
**Descripción:** El sistema debe permitir al estudiante acceder a las clases pregrabadas que ha adquirido o a las que tiene acceso por suscripción activa.

**Criterios de Aceptación:**
- Listado de clases pregrabadas accesibles (filtrado según `student_accesses` o `subscriptions` activas)
- Solo clases con estado "aprobado" son visibles
- Reproductor de video embebido o enlace externo
- Protección: validar acceso antes de mostrar video
- Si no tiene acceso, mostrar mensaje y enlace para comprar

---

### RF-036: Expiración de Suscripciones
**Prioridad:** Alta  
**Actor:** Sistema  
**Descripción:** Al expirar una suscripción, el sistema debe deshabilitar el acceso a materiales y clases pregrabadas asociados, pero mantener el historial del estudiante.

**Criterios de Aceptación:**
- Tarea programada (cron job / Laravel Scheduler) que verifica diariamente suscripciones expiradas
- Cambio de estado de suscripción a "expired"
- El estudiante ya no puede acceder al contenido, pero el historial en `student_accesses` se mantiene
- Notificación al estudiante de expiración de suscripción
- Opción de renovar suscripción (nueva compra)

---

## 8. Módulo Paneles de Usuario

### RF-037: Dashboard del Estudiante
**Prioridad:** Alta  
**Actor:** Estudiante  
**Descripción:** El sistema debe mostrar un dashboard al estudiante con resumen de información relevante.

**Criterios de Aceptación:**
- Widgets: grupos actuales, próximas clases, materiales recientes, notificaciones pendientes
- Navegación rápida a secciones principales
- Mensaje de bienvenida personalizado

---

### RF-038: Dashboard del Docente
**Prioridad:** Alta  
**Actor:** Docente  
**Descripción:** El sistema debe mostrar un dashboard al docente con resumen de información relevante.

**Criterios de Aceptación:**
- Widgets: grupos asignados, próximas clases, contenido pendiente de aprobación, notificaciones
- Navegación rápida a gestión de grupos, asistencia, notas
- Mensaje de bienvenida personalizado

---

### RF-039: Dashboard del Administrador
**Prioridad:** Alta  
**Actor:** Administrador  
**Descripción:** El sistema debe mostrar un dashboard al administrador con resumen de información del sistema.

**Criterios de Aceptación:**
- Widgets: estadísticas generales (# usuarios, grupos, productos), órdenes recientes, contenido pendiente
- Navegación rápida a secciones administrativas
- Indicadores visuales de tareas pendientes

---

## 9. Módulo Notificaciones y Comunicación

### RF-040: Notificaciones en Plataforma
**Prioridad:** Media  
**Actor:** Todos los usuarios  
**Descripción:** El sistema debe mostrar notificaciones internas a los usuarios en eventos relevantes.

**Criterios de Aceptación:**
- Badge con contador de notificaciones no leídas en navbar
- Listado de notificaciones con fecha, tipo y mensaje
- Marcar notificación como leída al hacer clic
- Tipos de notificación: compra confirmada, clase programada, contenido aprobado/rechazado, aviso general

---

### RF-041: Envío de Correos Electrónicos
**Prioridad:** Media  
**Actor:** Sistema  
**Descripción:** El sistema debe enviar correos electrónicos automáticos en eventos clave.

**Criterios de Aceptación:**
- Correo de bienvenida tras registro
- Correo de confirmación de pago exitoso
- Correo de clase programada con detalle de horario
- Correo de aprobación/rechazo de contenido (para docentes)
- Plantillas HTML responsive con diseño institucional
- Envío en background mediante colas (Laravel Queue)

---

### RF-042: Gestión de Avisos (Administrador/Docente)
**Prioridad:** Baja (Opcional en MVP)  
**Actor:** Administrador, Docente  
**Descripción:** El sistema debe permitir crear avisos o anuncios dirigidos a grupos específicos de usuarios.

**Criterios de Aceptación:**
- CRUD de avisos
- Campos: título, contenido, audiencia (todos, grupo específico, nivel específico), estado (borrador/publicado)
- Los avisos publicados se muestran en dashboard de destinatarios
- Opcional: enviar también por correo electrónico

---

### RF-043: Visualización de Avisos (Estudiante)
**Prioridad:** Baja (Opcional en MVP)  
**Actor:** Estudiante  
**Descripción:** El sistema debe mostrar al estudiante los avisos dirigidos a él (por grupo o general).

**Criterios de Aceptación:**
- Listado de avisos recientes en dashboard
- Detalle de cada aviso al hacer clic
- Marcar aviso como leído (opcional)

---

## 10. Requerimientos Transversales

### RF-044: Zona Horaria de Chile
**Prioridad:** Alta  
**Actor:** Sistema  
**Descripción:** El sistema debe operar en la zona horaria de Chile (`America/Santiago`).

**Criterios de Aceptación:**
- Configuración de `timezone` en `config/app.php` de Laravel
- Todas las fechas y horas se almacenan en UTC en base de datos
- Al mostrar al usuario, se convierten a zona horaria de Chile
- Manejo correcto de cambios de horario (horario de verano/invierno)

---

### RF-045: Trazabilidad de Operaciones Críticas
**Prioridad:** Alta  
**Actor:** Sistema  
**Descripción:** El sistema debe registrar trazabilidad completa de operaciones críticas (compras, pagos, asignaciones de roles, aprobaciones de contenido).

**Criterios de Aceptación:**
- Campos `created_at`, `updated_at` en todas las tablas
- Campos `created_by`, `updated_by` donde sea relevante
- Registro de intentos de pago fallidos
- Logs de errores y excepciones (Laravel Log)
- Auditoría de cambios en datos sensibles (opcional: usar package de auditoría)

---

### RF-046: Seguridad y Control de Accesos
**Prioridad:** Crítica  
**Actor:** Sistema  
**Descripción:** El sistema debe proteger todas las rutas y funcionalidades según el rol del usuario autenticado.

**Criterios de Aceptación:**
- Middleware `auth` en todas las rutas protegidas
- Middleware de rol personalizado (`role:estudiante`, `role:docente`, `role:admin`)
- Laravel Policies para autorización granular (ej. solo docente asignado puede editar su grupo)
- Validación de acceso a archivos antes de servirlos
- Protección contra SQL injection, XSS, CSRF (validaciones de Laravel)

---

### RF-047: Responsive Design
**Prioridad:** Alta  
**Actor:** Sistema  
**Descripción:** El sistema debe ser completamente funcional en dispositivos móviles, tablets y desktops.

**Criterios de Aceptación:**
- Uso de Bootstrap 5 con grid responsivo
- Navegación adaptada a móvil (menú hamburguesa)
- Formularios y tablas legibles en pantallas pequeñas
- Testing en Chrome DevTools (móvil, tablet, desktop)

---

### RF-048: Validación de Datos
**Prioridad:** Crítica  
**Actor:** Sistema  
**Descripción:** El sistema debe validar todos los datos de entrada antes de procesarlos.

**Criterios de Aceptación:**
- Validaciones en backend (Laravel Form Requests)
- Validaciones en frontend (JavaScript básico o Alpine.js)
- Mensajes de error claros y específicos
- Validación de tipos de archivo en uploads
- Sanitización de inputs para prevenir XSS

---

## 11. Resumen de Requerimientos por Prioridad

| Prioridad | Cantidad | IDs |
|-----------|----------|-----|
| **Crítica** | 15 | RF-003, RF-004, RF-007, RF-014, RF-016, RF-017, RF-018, RF-019, RF-020, RF-023, RF-024, RF-025, RF-026, RF-027, RF-046, RF-048 |
| **Alta** | 20 | RF-001, RF-002, RF-005, RF-008, RF-011, RF-012, RF-013, RF-021, RF-022, RF-028, RF-030, RF-031, RF-032, RF-033, RF-034, RF-035, RF-036, RF-037, RF-038, RF-039, RF-044, RF-045, RF-047 |
| **Media** | 8 | RF-006, RF-009, RF-010, RF-029, RF-040, RF-041 |
| **Baja** | 5 | RF-015, RF-042, RF-043 |

**Total de Requerimientos:** 48

---

## 12. Matriz de Trazabilidad (Requerimiento → Módulo)

| Módulo | Requerimientos Asociados |
|--------|--------------------------|
| Público | RF-001, RF-002, RF-003, RF-004, RF-005, RF-006 |
| Identidad y Roles | RF-007, RF-008, RF-009, RF-010, RF-011 |
| Catálogo | RF-012, RF-013, RF-014, RF-015 |
| Comercial | RF-016, RF-017, RF-018, RF-019, RF-020, RF-021, RF-022 |
| Académico | RF-023, RF-024, RF-025, RF-026, RF-027, RF-028, RF-029, RF-030 |
| Contenido | RF-031, RF-032, RF-033, RF-034, RF-035, RF-036 |
| Paneles | RF-037, RF-038, RF-039 |
| Notificaciones | RF-040, RF-041, RF-042, RF-043 |
| Transversales | RF-044, RF-045, RF-046, RF-047, RF-048 |

---

## 13. Próximos Pasos

1. ✅ Revisar y validar estos requerimientos con el Product Owner
2. ⏳ Diseñar el modelo de base de datos (DER)
3. ⏳ Crear diccionario de datos completo
4. ⏳ Definir casos de uso detallados (diagramas UML)
5. ⏳ Crear migraciones de Laravel
6. ⏳ Inicializar proyecto Laravel y configurar entorno de desarrollo
7. ⏳ Comenzar implementación iterativa por módulo

---

**Documento preparado por:** Arquitecto de Software Senior  
**Revisión requerida por:** Product Owner, QA Lead  
**Próxima entrega:** Modelo de Base de Datos (DER) y Diccionario de Datos
