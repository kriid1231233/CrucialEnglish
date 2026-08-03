# Módulos del MVP - CrucialEnglish

**Versión:** 1.0  
**Fecha:** 27 de julio de 2026  
**Prioridad:** MVP (Minimum Viable Product)

---

## 1. Introducción

Este documento define los **módulos funcionales del MVP** de CrucialEnglish, estableciendo el alcance mínimo necesario para lanzar una plataforma operativa que entregue valor real a estudiantes, docentes y administradores.

### 1.1 Criterios de Priorización MVP

Un módulo o funcionalidad se incluye en el MVP si cumple **al menos uno** de estos criterios:

1. **Crítico para el flujo de negocio básico** (compra → pago → acceso)
2. **Indispensable para operación académica mínima** (grupos, agenda, notas)
3. **Requerido por seguridad o integridad de datos** (autenticación, roles, trazabilidad)
4. **Fundamental para experiencia de usuario aceptable** (navegación, notificaciones básicas)

### 1.2 Fuera del MVP (Fase 2+)

Las siguientes funcionalidades NO están en el MVP:

- Reportería avanzada / dashboards analíticos
- Sistema de certificaciones digitales
- Chat en tiempo real
- API pública para terceros
- Aplicación móvil nativa
- Integración con herramientas externas (Zoom API, Google Classroom)
- Sistema de evaluaciones online automáticas
- Gamificación / badges

---

## 2. Arquitectura de Módulos

### 2.1 Diagrama de Contexto

```
┌─────────────────────────────────────────────────────────────┐
│                      CRUCIALENGLISH MVP                      │
├─────────────────────────────────────────────────────────────┤
│                                                               │
│  ┌───────────┐  ┌───────────┐  ┌───────────┐  ┌──────────┐ │
│  │  Módulo   │  │  Módulo   │  │  Módulo   │  │ Módulo   │ │
│  │  Público  │  │ Identidad │  │ Catálogo  │  │Comercial │ │
│  └───────────┘  └───────────┘  └───────────┘  └──────────┘ │
│                                                               │
│  ┌───────────┐  ┌───────────┐  ┌───────────┐  ┌──────────┐ │
│  │  Módulo   │  │  Módulo   │  │  Módulo   │  │ Módulo   │ │
│  │Académico  │  │Contenido  │  │  Paneles  │  │Notific.  │ │
│  └───────────┘  └───────────┘  └───────────┘  └──────────┘ │
│                                                               │
└─────────────────────────────────────────────────────────────┘
         ▲                    ▲                    ▲
         │                    │                    │
    Estudiante             Docente            Administrador
```

### 2.2 Tabla de Módulos MVP

| # | Módulo | Prioridad | Complejidad | Dependencias |
|---|--------|-----------|-------------|--------------|
| 1 | **Público** | Alta | Baja | Ninguna |
| 2 | **Identidad y Roles** | Crítica | Media | Ninguna |
| 3 | **Catálogo de Productos** | Alta | Media | Identidad |
| 4 | **Comercial (Ventas)** | Crítica | Alta | Identidad, Catálogo |
| 5 | **Académico** | Crítica | Alta | Identidad, Comercial |
| 6 | **Gestión de Contenido** | Alta | Media | Identidad, Académico |
| 7 | **Paneles de Usuario** | Alta | Media | Todos los anteriores |
| 8 | **Notificaciones** | Media | Baja | Identidad |

---

## 3. Módulo 1: Público

### 3.1 Propósito
Proveer el sitio web institucional visible para cualquier visitante (invitados no autenticados), con información del instituto, catálogo de productos y formulario de registro.

### 3.2 Funcionalidades MVP

#### 3.2.1 Página de Inicio
- Hero section con mensaje institucional
- Resumen de servicios ofrecidos
- Llamados a la acción (CTA): Registro, Ver Cursos

#### 3.2.2 Acerca del Instituto
- Misión, visión y valores
- Metodología de enseñanza
- Equipo docente (opcional: fotos y biografías breves)

#### 3.2.3 Catálogo Público de Productos
- Listado de productos disponibles (clases individuales, grupales, materiales, suscripciones)
- Filtros básicos: por tipo, nivel
- Información de cada producto: descripción, precio, nivel
- **Sin compra directa** (requiere inicio de sesión)

#### 3.2.4 Información de Contacto
- Formulario de contacto básico
- Datos de contacto (email, teléfono, dirección)
- Opcional: mapa de ubicación

#### 3.2.5 Registro e Inicio de Sesión
- Formulario de registro de nueva cuenta (estudiante)
- Formulario de inicio de sesión
- Enlace a recuperación de contraseña

### 3.3 Entidades Principales
- Ninguna específica (usa datos de otros módulos)

### 3.4 Rutas Principales
```
GET  /                      # Home
GET  /about                 # Acerca de
GET  /products              # Catálogo público
GET  /product/{id}          # Detalle de producto
GET  /contact               # Contacto
POST /contact               # Envío de formulario
GET  /login                 # Login
POST /login                 # Autenticación
GET  /register              # Registro
POST /register              # Crear cuenta
```

### 3.5 Notas Técnicas
- Las vistas usan Blade + Bootstrap 5
- El catálogo público solo **muestra** productos, no permite compra sin login
- SEO básico: titles, meta descriptions
- Responsive design obligatorio

---

## 4. Módulo 2: Identidad y Roles

### 4.1 Propósito
Gestionar autenticación, autorización, perfiles de usuario y asignación de roles con lógica multirol.

### 4.2 Funcionalidades MVP

#### 4.2.1 Autenticación
- Registro de nuevos usuarios (automáticamente rol "Estudiante")
- Inicio de sesión con email y contraseña
- Recuperación de contraseña por correo
- Cierre de sesión
- Protección de rutas por middleware (`auth`)

#### 4.2.2 Gestión de Roles
- Tabla `users` (usuario base)
- Tabla `roles` (catálogo de roles: Estudiante, Docente, Administrador)
- Tabla `user_roles` (relación muchos a muchos)
- Al iniciar sesión con múltiples roles, se presenta selector de contexto
- Cambio de rol sin cerrar sesión (dropdown en navbar)

#### 4.2.3 Perfiles Diferenciados
- **Perfil de Estudiante** (`student_profiles`):
  - Nombre completo, teléfono, fecha de nacimiento
  - Preferencias de contacto
  - Disponibilidad horaria (opcional)
- **Perfil de Docente** (`teacher_profiles`):
  - Nombre completo, especialidad
  - Biografía breve
  - Horarios de disponibilidad

#### 4.2.4 Gestión de Usuarios (Administrador)
- Listar todos los usuarios
- Asignar/revocar roles
- Activar/desactivar cuentas
- Resetear contraseñas

### 4.3 Entidades Principales

#### 4.3.1 `users`
```
id, name, email, password, email_verified_at, active, 
created_at, updated_at
```

#### 4.3.2 `roles`
```
id, name, slug, description, created_at, updated_at
```

#### 4.3.3 `user_roles`
```
id, user_id, role_id, assigned_at, assigned_by
```

#### 4.3.4 `student_profiles`
```
id, user_id, phone, birth_date, contact_preferences, 
availability_notes, created_at, updated_at
```

#### 4.3.5 `teacher_profiles`
```
id, user_id, specialization, bio, availability_schedule,
created_at, updated_at
```

### 4.4 Rutas Principales
```
# Autenticación (Laravel Breeze/Jetstream o manual)
GET  /login
POST /login
POST /logout
GET  /register
POST /register
GET  /forgot-password
POST /forgot-password
GET  /reset-password/{token}
POST /reset-password

# Selección de rol (si tiene múltiples)
GET  /select-role
POST /switch-role

# Administración de usuarios
GET  /admin/users              # Listar usuarios
GET  /admin/users/{id}/edit    # Editar usuario
PUT  /admin/users/{id}         # Actualizar usuario
POST /admin/users/{id}/roles   # Asignar/revocar rol
```

### 4.5 Políticas de Acceso (Policies/Gates)
- Solo Administrador puede gestionar usuarios y roles
- Un usuario solo puede editar su propio perfil (excepto Admin)
- Docente puede ver perfiles de estudiantes asignados a sus grupos

### 4.6 Notas Técnicas
- Usar **Laravel Breeze** o **Laravel Jetstream** para scaffold rápido de autenticación
- Implementar middleware personalizado `role:estudiante` para proteger rutas
- Almacenar el rol activo en sesión tras login multirol
- Validar emails únicos en registro

---

## 5. Módulo 3: Catálogo de Productos

### 5.1 Propósito
Gestionar la definición de productos académicos, niveles, tipos de producto, precios y ofertas.

### 5.2 Funcionalidades MVP

#### 5.2.1 Niveles Académicos
- CRUD de niveles: A1, A2, B1, B2, C1, C2
- Cada nivel tiene nombre, descripción y orden de progresión

#### 5.2.2 Tipos de Producto
- Definición de tipos:
  - Clase Individual
  - Clase Grupal
  - Material de Apoyo
  - Suscripción a Clases Pregrabadas

#### 5.2.3 Productos
- CRUD de productos (solo Administrador)
- Atributos:
  - Nombre, descripción
  - Tipo de producto
  - Nivel asociado (si aplica)
  - Precio base
  - Estado (activo/inactivo)
  - Modalidad de cobro (único, mensual, por paquete)
  
#### 5.2.4 Ofertas y Promociones (Opcional en MVP)
- Producto puede tener precio especial por tiempo limitado
- Tabla `product_offers` con fecha de inicio/fin

### 5.3 Entidades Principales

#### 5.3.1 `levels`
```
id, code (A1, A2...), name, description, order, 
created_at, updated_at
```

#### 5.3.2 `product_types`
```
id, name, slug, description, created_at, updated_at
```

#### 5.3.3 `products`
```
id, product_type_id, level_id, name, description, 
base_price, billing_mode (one_time, monthly, package),
is_active, created_at, updated_at
```

#### 5.3.4 `product_offers` (Opcional MVP)
```
id, product_id, discount_price, valid_from, valid_until,
created_at, updated_at
```

### 5.4 Rutas Principales
```
# Administración de niveles
GET  /admin/levels
POST /admin/levels
GET  /admin/levels/{id}/edit
PUT  /admin/levels/{id}
DELETE /admin/levels/{id}

# Administración de productos
GET  /admin/products
POST /admin/products
GET  /admin/products/{id}/edit
PUT  /admin/products/{id}
DELETE /admin/products/{id}
```

### 5.5 Reglas de Negocio
- Un producto puede no tener nivel asociado (ejemplo: material transversal)
- Un producto inactivo no se muestra en catálogo público ni se puede comprar
- El precio efectivo es `product_offers.discount_price` si existe oferta vigente, si no, `products.base_price`

### 5.6 Notas Técnicas
- Los niveles tienen un campo `order` para mantener secuencia lógica
- Los slugs de `product_types` facilitan validaciones de lógica de negocio
- Considerar soft deletes en `products` para mantener historial de compras

---

## 6. Módulo 4: Comercial (Ventas y Pagos)

### 6.1 Propósito
Gestionar el flujo de compra, carrito, checkout, integración con Webpay Plus, órdenes de compra y habilitación automática de accesos.

### 6.2 Funcionalidades MVP

#### 6.2.1 Carrito de Compras
- Agregar productos al carrito (solo usuarios autenticados como estudiante)
- Ver carrito con detalle de productos
- Actualizar cantidades (si aplica)
- Eliminar productos del carrito
- Calcular total con precio vigente (aplicando ofertas)

#### 6.2.2 Proceso de Checkout
- Revisión de orden antes de pagar
- Selección de método de pago (Webpay Plus)
- Captura de información adicional:
  - Para clases individuales/grupales: preferencia de horario, días disponibles
  - Para materiales y suscripciones: confirmación inmediata

#### 6.2.3 Integración con Webpay Plus
- Redirección a Transbank para pago
- Validación de respuesta de pago (commit/rollback)
- Manejo de estados: pendiente, pagado, rechazado, anulado
- Webhook o callback para confirmación asíncrona (si es necesario)

#### 6.2.4 Órdenes de Compra
- Creación de orden al iniciar checkout
- Almacenamiento de items de la orden
- Estados de orden: `pending`, `paid`, `failed`, `cancelled`
- Trazabilidad completa: fecha, monto, estado, referencia Transbank

#### 6.2.5 Registro de Pagos
- Tabla `payments` independiente de órdenes (una orden puede tener varios intentos)
- Registro de transaction_id, token de Transbank, monto, estado
- Asociación payment ↔ order

#### 6.2.6 Habilitación Automática de Accesos
- Tras confirmación de pago exitoso, ejecutar lógica:
  - **Material de apoyo / Clases pregrabadas:** Crear registro en `student_accesses`
  - **Suscripción:** Crear registro en `subscriptions` con fecha de inicio y fin
  - **Clases individuales/grupales:** Marcar producto como "adquirido, pendiente de coordinación"

#### 6.2.7 Historial de Compras (Estudiante)
- Ver listado de órdenes propias
- Detalle de cada orden: productos, monto, fecha, estado
- Descarga de comprobante (opcional en MVP)

### 6.3 Entidades Principales

#### 6.3.1 `orders`
```
id, student_id (user_id), total_amount, status 
(pending, paid, failed, cancelled), 
created_at, updated_at
```

#### 6.3.2 `order_items`
```
id, order_id, product_id, quantity, unit_price, subtotal,
created_at, updated_at
```

#### 6.3.3 `payments`
```
id, order_id, transaction_id (Transbank), amount, status 
(pending, approved, rejected), payment_method, 
payment_date, created_at, updated_at
```

#### 6.3.4 `student_accesses`
```
id, student_id, product_id, access_type (material, recorded_lesson),
granted_at, expires_at, is_active, created_at, updated_at
```

#### 6.3.5 `subscriptions`
```
id, student_id, product_id, starts_at, ends_at, 
status (active, expired, cancelled), 
created_at, updated_at
```

### 6.4 Flujo de Compra (Diagrama Simplificado)

```
1. Estudiante agrega productos al carrito
2. Estudiante revisa carrito y procede a checkout
3. Sistema crea orden con estado "pending"
4. Sistema redirige a Webpay Plus con datos de la orden
5. Usuario paga en Transbank
6. Transbank redirige de vuelta con resultado
7. Sistema valida resultado y actualiza orden:
   - Si pago OK → orden "paid", crear accesos automáticos
   - Si pago falla → orden "failed", mostrar error
8. Usuario ve confirmación y accesos habilitados
```

### 6.5 Rutas Principales
```
# Carrito
GET  /cart                    # Ver carrito
POST /cart/add/{product_id}   # Agregar producto
PUT  /cart/update/{item_id}   # Actualizar cantidad
DELETE /cart/remove/{item_id} # Eliminar producto

# Checkout
GET  /checkout                # Página de checkout
POST /checkout/process        # Crear orden y redirigir a Webpay

# Callbacks Webpay
GET  /payment/return          # Return URL (usuario vuelve)
POST /payment/notify          # Webhook Transbank (notificación)

# Historial de compras
GET  /student/orders          # Mis órdenes
GET  /student/orders/{id}     # Detalle de orden
```

### 6.6 Reglas de Negocio
- Solo usuarios con rol **Estudiante** pueden comprar
- No se puede comprar un producto inactivo
- Al pagar, se congela el precio del momento (guardado en `order_items.unit_price`)
- Accesos a materiales y suscripciones se habilitan inmediatamente tras pago
- Clases individuales/grupales requieren coordinación posterior (no se agenda automáticamente en MVP)

### 6.7 Consideraciones de Seguridad
- Validar integridad de datos en callback de Webpay (firma, token)
- No confiar en datos del frontend para precios (recalcular en servidor)
- Proteger rutas de checkout con middleware `auth` y `role:estudiante`
- Registrar todos los intentos de pago para auditoría

### 6.8 Notas Técnicas
- Usar **SDK oficial de Transbank para PHP** (composer package)
- Ambiente de integración de Webpay para desarrollo, producción al lanzar
- Implementar **jobs en cola** (Laravel Queue) para tareas post-pago (envío de emails, logs)
- Considerar **transacciones de base de datos** al crear orden + items + payment

---

## 7. Módulo 5: Académico

### 7.1 Propósito
Gestionar la operación académica del instituto: grupos de estudiantes, asignación de docentes, programación de clases, registro de asistencia, evaluaciones y progresión de niveles.

### 7.2 Funcionalidades MVP

#### 7.2.1 Gestión de Grupos
- CRUD de grupos (Administrador y Docente)
- Atributos:
  - Nombre del grupo
  - Nivel asociado
  - Docente asignado
  - Horario general (descripción textual)
  - Estado (activo/inactivo)
  
#### 7.2.2 Asignación de Estudiantes a Grupos
- Agregar estudiante a uno o más grupos (relación muchos a muchos)
- Registrar fecha de ingreso al grupo
- Permitir reasignaciones temporales (un estudiante puede estar en varios grupos simultáneamente)
- Historial de pertenencia a grupos

#### 7.2.3 Agenda de Clases (Class Sessions)
- Programar sesiones de clase para cada grupo
- Atributos:
  - Grupo
  - Fecha y hora
  - Duración
  - Tema/descripción
  - Estado (programada, realizada, cancelada)

#### 7.2.4 Registro de Asistencia
- Marcar asistencia por cada estudiante en cada sesión de clase
- Estados: presente, ausente, tardanza, justificado
- Solo docente asignado o administrador puede registrar asistencia

#### 7.2.5 Evaluaciones y Notas
- Registro de notas por estudiante
- Escala: 1.0 a 7.0 con decimales
- Asociación a nivel o grupo
- Tipo de evaluación (prueba, tarea, oral, final)
- Fecha de evaluación

#### 7.2.6 Historial Académico del Estudiante
- Vista consolidada de:
  - Grupos a los que ha pertenecido
  - Asistencia histórica
  - Notas obtenidas
  - Progresión de niveles

#### 7.2.7 Progresión de Niveles
- Al finalizar un nivel, el docente/administrador evalúa si el estudiante avanza al siguiente
- Criterio: promedio de notas >= umbral definido (ejemplo: 5.0)
- Registro de fecha de avance de nivel

### 7.3 Entidades Principales

#### 7.3.1 `groups`
```
id, name, level_id, teacher_id (user con rol docente), 
schedule_description, is_active, 
created_at, updated_at
```

#### 7.3.2 `group_students` (Pivot con metadata)
```
id, group_id, student_id, joined_at, left_at, 
is_active, created_at, updated_at
```

#### 7.3.3 `class_sessions`
```
id, group_id, session_date, start_time, duration_minutes,
topic, status (scheduled, completed, cancelled),
created_at, updated_at
```

#### 7.3.4 `class_session_students` (Asistencia)
```
id, class_session_id, student_id, 
attendance_status (present, absent, late, justified),
notes, created_at, updated_at
```

#### 7.3.5 `student_grades`
```
id, student_id, level_id, group_id, evaluation_type,
grade (decimal), evaluation_date, comments,
created_at, updated_at
```

#### 7.3.6 `student_records` (Historial de progresión)
```
id, student_id, level_id, completed_at, 
average_grade, passed (boolean), 
created_at, updated_at
```

### 7.4 Rutas Principales
```
# Gestión de grupos (Docente / Admin)
GET  /teacher/groups
POST /teacher/groups
GET  /teacher/groups/{id}/edit
PUT  /teacher/groups/{id}
DELETE /teacher/groups/{id}

# Estudiantes en grupo
GET  /teacher/groups/{id}/students          # Ver estudiantes
POST /teacher/groups/{id}/students          # Agregar estudiante
DELETE /teacher/groups/{id}/students/{sid}  # Quitar estudiante

# Agenda de clases
GET  /teacher/groups/{id}/sessions
POST /teacher/groups/{id}/sessions
GET  /teacher/sessions/{id}/edit
PUT  /teacher/sessions/{id}
DELETE /teacher/sessions/{id}

# Asistencia
GET  /teacher/sessions/{id}/attendance       # Ver asistencia
POST /teacher/sessions/{id}/attendance       # Registrar asistencia

# Notas
GET  /teacher/students/{id}/grades           # Ver notas de estudiante
POST /teacher/students/{id}/grades           # Registrar nota
PUT  /teacher/grades/{id}                    # Editar nota
DELETE /teacher/grades/{id}                  # Eliminar nota

# Historial académico (Estudiante)
GET  /student/academic-history               # Mi historial
GET  /student/groups                         # Mis grupos
GET  /student/grades                         # Mis notas
GET  /student/attendance                     # Mi asistencia
```

### 7.5 Reglas de Negocio
- Un grupo pertenece a un solo nivel
- Un estudiante puede pertenecer a varios grupos (reasignaciones, reposiciones)
- Solo el docente asignado al grupo (o admin) puede registrar asistencia y notas
- Una sesión de clase solo puede realizarse si el grupo está activo
- Las notas válidas están entre 1.0 y 7.0 con un decimal (validación)
- Un estudiante avanza de nivel si su promedio en `student_records` es >= 5.0 (criterio ajustable)

### 7.6 Coordinación Académica (Post-Compra)
- Cuando un estudiante compra una clase individual o grupal, el sistema NO agenda automáticamente la clase
- El administrador o docente debe contactar al estudiante (usando datos de `student_profiles.availability_notes`)
- Luego, se crea manualmente el grupo (si es clase grupal) o se programa la sesión individual
- Este flujo manual se prioriza en MVP; futuras fases pueden automatizar con reserva de horarios

### 7.7 Notas Técnicas
- Usar relaciones Eloquent: `Group belongsTo Level`, `Group belongsTo Teacher`, `Group belongsToMany Student`
- Implementar **soft deletes** en `groups` para mantener historial
- Las sesiones de clase deben ordenarse por fecha/hora
- Considerar índices en `class_session_students.class_session_id` y `student_id` para optimizar consultas

---

## 8. Módulo 6: Gestión de Contenido

### 8.1 Propósito
Gestionar materiales de apoyo y clases pregrabadas que los docentes suben y el administrador aprueba para publicación.

### 8.2 Funcionalidades MVP

#### 8.2.1 Materiales de Apoyo
- CRUD de materiales (Docente crea, Admin aprueba)
- Atributos:
  - Título, descripción
  - Nivel asociado
  - Tipo de archivo (PDF, Word, imagen, etc.)
  - Archivo subido o enlace externo
  - Estado (pendiente, aprobado, rechazado)
  - Autor (docente que lo subió)

#### 8.2.2 Clases Pregrabadas
- CRUD de clases pregrabadas (Docente crea, Admin aprueba)
- Atributos:
  - Título, descripción
  - Nivel asociado
  - Video subido o enlace externo (YouTube, Vimeo)
  - Duración
  - Estado (pendiente, aprobado, rechazado)
  - Autor (docente que lo subió)

#### 8.2.3 Flujo de Aprobación
- Docente sube contenido → estado "pendiente"
- Administrador revisa y decide:
  - Aprobar → estado "aprobado", visible para estudiantes con acceso
  - Rechazar → estado "rechazado", no visible
- Notificación al docente del resultado

#### 8.2.4 Acceso a Contenido (Estudiante)
- Listar materiales de apoyo accesibles (según `student_accesses` o suscripción activa)
- Listar clases pregrabadas accesibles (según `student_accesses` o suscripción activa)
- Descargar material o reproducir video
- Historial de materiales consumidos (opcional en MVP)

### 8.3 Entidades Principales

#### 8.3.1 `materials`
```
id, title, description, level_id, file_type, 
file_path, external_link, 
status (pending, approved, rejected),
author_id (teacher), reviewed_by (admin), reviewed_at,
created_at, updated_at
```

#### 8.3.2 `recorded_lessons`
```
id, title, description, level_id, duration_minutes,
video_path, external_link,
status (pending, approved, rejected),
author_id (teacher), reviewed_by (admin), reviewed_at,
created_at, updated_at
```

### 8.4 Rutas Principales
```
# Docente: Gestión de materiales
GET  /teacher/materials
POST /teacher/materials
GET  /teacher/materials/{id}/edit
PUT  /teacher/materials/{id}
DELETE /teacher/materials/{id}

# Docente: Gestión de clases pregrabadas
GET  /teacher/recorded-lessons
POST /teacher/recorded-lessons
GET  /teacher/recorded-lessons/{id}/edit
PUT  /teacher/recorded-lessons/{id}
DELETE /teacher/recorded-lessons/{id}

# Admin: Aprobación de contenido
GET  /admin/materials/pending           # Materiales pendientes
PUT  /admin/materials/{id}/approve
PUT  /admin/materials/{id}/reject
GET  /admin/recorded-lessons/pending    # Clases pendientes
PUT  /admin/recorded-lessons/{id}/approve
PUT  /admin/recorded-lessons/{id}/reject

# Estudiante: Acceso a contenido
GET  /student/materials                 # Mis materiales
GET  /student/materials/{id}            # Ver/descargar material
GET  /student/recorded-lessons          # Mis clases pregrabadas
GET  /student/recorded-lessons/{id}     # Ver clase pregrabada
```

### 8.5 Reglas de Negocio
- Solo contenido con estado "aprobado" es visible para estudiantes
- Un estudiante solo puede acceder a contenido si:
  - Tiene un registro en `student_accesses` para ese producto, o
  - Tiene una suscripción activa que incluye ese nivel/contenido
- Al expirar una suscripción, el acceso se deshabilita pero el historial se mantiene
- Los archivos subidos deben almacenarse fuera de la carpeta pública (usar `storage/app/private`)
- El administrador puede rechazar contenido con comentario al docente

### 8.6 Almacenamiento de Archivos
- **Videos:** Considerar almacenamiento externo (Cloudinary, AWS S3, Vimeo) para evitar sobrecarga del servidor
  - MVP puede empezar con enlaces externos (YouTube, Vimeo)
  - Fase 2: subida directa con almacenamiento externo
- **Materiales (PDF, documentos):** Almacenar en `storage/app/private/materials/`
  - Servir con `response()->download()` o `Storage::download()` tras validar acceso

### 8.7 Notas Técnicas
- Usar **Laravel Storage** con discos configurados (local, s3, etc.)
- Implementar **middleware personalizado** para validar acceso antes de servir archivo
- Considerar límite de tamaño de archivo en upload (configurar en `php.ini` y Laravel)
- Notificar al docente por correo cuando su contenido es aprobado/rechazado (Módulo 8)

---

## 9. Módulo 7: Paneles de Usuario

### 9.1 Propósito
Proveer interfaces diferenciadas (dashboards) para cada rol, con acceso rápido a funcionalidades clave y navegación contextual.

### 9.2 Funcionalidades MVP

#### 9.2.1 Panel del Estudiante
- **Dashboard principal:**
  - Resumen de grupos actuales
  - Próximas clases en la agenda
  - Materiales recientes disponibles
  - Notificaciones pendientes
- **Navegación:**
  - Mis grupos
  - Mi agenda
  - Mis materiales
  - Mis clases pregrabadas
  - Mi historial académico
  - Mis compras
  - Mi perfil

#### 9.2.2 Panel del Docente
- **Dashboard principal:**
  - Grupos asignados
  - Próximas clases
  - Materiales pendientes de aprobación
  - Notificaciones
- **Navegación:**
  - Mis grupos
  - Agenda de clases
  - Mis materiales
  - Mis clases pregrabadas
  - Gestión de asistencia
  - Gestión de notas
  - Mi perfil

#### 9.2.3 Panel del Administrador
- **Dashboard principal:**
  - Estadísticas generales (usuarios, grupos, productos)
  - Órdenes recientes
  - Contenido pendiente de aprobación
  - Notificaciones del sistema
- **Navegación:**
  - Gestión de usuarios
  - Gestión de roles
  - Gestión de productos
  - Gestión de niveles
  - Gestión de grupos
  - Aprobación de contenido
  - Supervisión de pagos
  - Configuración del sistema

### 9.3 Notas Técnicas
- Cada panel tiene su **layout Blade** específico con navbar contextual
- Usar **Blade components** para widgets reutilizables (cards, estadísticas)
- Los dashboards deben cargar **solo información relevante** (no hacer queries pesados)
- Implementar **breadcrumbs** para facilitar navegación

---

## 10. Módulo 8: Notificaciones y Comunicación

### 10.1 Propósito
Gestionar comunicación interna (notificaciones en plataforma) y externa (correos electrónicos) entre usuarios del sistema.

### 10.2 Funcionalidades MVP

#### 10.2.1 Notificaciones en Plataforma
- Usar tabla `notifications` de Laravel
- Tipos de notificación:
  - Confirmación de compra
  - Aprobación/rechazo de contenido (para docentes)
  - Nuevo material disponible (para estudiantes)
  - Clase programada o reprogramada
  - Aviso general del administrador
- Badge con contador de notificaciones no leídas en navbar
- Vista de listado de notificaciones
- Marcar como leída

#### 10.2.2 Correos Electrónicos
- Envío automático en eventos clave:
  - Registro de nueva cuenta (bienvenida)
  - Confirmación de pago exitoso
  - Clase programada con detalle de horario
  - Recordatorio de clase (opcional en MVP)
  - Aprobación/rechazo de contenido subido
- Usar **Laravel Mail** con plantillas Blade para emails

#### 10.2.3 Avisos y Anuncios (Administrador/Docente)
- CRUD de avisos (tabla `announcements`)
- Atributos:
  - Título, contenido
  - Autor (admin o docente)
  - Audiencia: todos, estudiantes de un grupo, nivel específico
  - Fecha de publicación
  - Estado (publicado/borrador)
- Los avisos publicados se muestran en dashboard de destinatarios
- Opcional: Enviar también por correo

### 10.3 Entidades Principales

#### 10.3.1 `notifications` (tabla de Laravel)
```
id, type, notifiable_type, notifiable_id, data (JSON),
read_at, created_at, updated_at
```

#### 10.3.2 `announcements`
```
id, title, content, author_id, audience_type 
(all, group, level), audience_id, 
status (draft, published), published_at,
created_at, updated_at
```

### 10.4 Rutas Principales
```
# Notificaciones
GET  /notifications                # Listar notificaciones
POST /notifications/{id}/read      # Marcar como leída

# Avisos (Admin/Docente)
GET  /admin/announcements
POST /admin/announcements
GET  /admin/announcements/{id}/edit
PUT  /admin/announcements/{id}
DELETE /admin/announcements/{id}

# Avisos (Estudiante)
GET  /student/announcements        # Ver avisos dirigidos a mí
```

### 10.5 Eventos y Listeners
- **Event:** `OrderPaid` → **Listener:** Enviar correo de confirmación, crear notificación
- **Event:** `MaterialApproved` → **Listener:** Notificar al docente, enviar correo
- **Event:** `ClassScheduled` → **Listener:** Notificar a estudiantes del grupo
- Usar **Laravel Events** y **Listeners** para desacoplar lógica

### 10.6 Notas Técnicas
- Configurar **SMTP** en `.env` (usar Mailtrap para desarrollo, Gmail/SendGrid para producción)
- Usar **Laravel Notifications** para envío multicanal (database + email)
- Implementar **colas (queues)** para envío de correos en background (Laravel Queue con Redis o base de datos)
- Los correos deben tener diseño responsive (usar plantillas HTML con Blade)

---

## 11. Resumen de Priorización MVP

| Módulo | ¿En MVP? | Prioridad | Justificación |
|--------|----------|-----------|---------------|
| Público | ✅ Sí | Alta | Primera impresión, captación de usuarios |
| Identidad y Roles | ✅ Sí | Crítica | Base de seguridad y permisos |
| Catálogo | ✅ Sí | Alta | Sin productos definidos, no hay qué vender |
| Comercial | ✅ Sí | Crítica | Flujo de monetización principal |
| Académico | ✅ Sí | Crítica | Operación core del instituto |
| Contenido | ✅ Sí | Alta | Valor académico diferenciador |
| Paneles | ✅ Sí | Alta | Experiencia de usuario contextual |
| Notificaciones | ✅ Sí | Media | Comunicación básica necesaria |
| Reportería Avanzada | ❌ No | Baja | Puede agregarse en Fase 2 |
| Certificaciones | ❌ No | Baja | No crítico para operación inicial |
| Chat en Tiempo Real | ❌ No | Baja | Se puede usar email/WhatsApp temporalmente |
| API Pública | ❌ No | Baja | Sin necesidad inmediata |

---

## 12. Dependencias entre Módulos

```
Módulo Público
  └─ No depende de otros

Módulo Identidad y Roles
  └─ No depende de otros (base del sistema)

Módulo Catálogo
  └─ Depende de: Identidad (usuarios admin crean productos)

Módulo Comercial
  └─ Depende de: Identidad (estudiantes compran), Catálogo (productos)

Módulo Académico
  └─ Depende de: Identidad (docentes, estudiantes), Catálogo (niveles)
  └─ Depende de: Comercial (estudiante debe comprar para estar en grupo)

Módulo Contenido
  └─ Depende de: Identidad (docentes suben, admin aprueba), Catálogo (niveles)
  └─ Depende de: Comercial (accesos basados en compras)

Módulo Paneles
  └─ Depende de: Todos los módulos anteriores (consolidación visual)

Módulo Notificaciones
  └─ Depende de: Identidad (usuarios reciben notificaciones)
  └─ Se integra con: Comercial, Académico, Contenido (eventos)
```

---

## 13. Estimación de Esfuerzo por Módulo

| Módulo | Complejidad | Días Estimados | Notas |
|--------|-------------|----------------|-------|
| Público | Baja | 3-4 | Principalmente vistas y contenido estático |
| Identidad y Roles | Media | 8-10 | Autenticación, roles multiusuario, perfiles |
| Catálogo | Media | 5-6 | CRUD de niveles, productos, tipos |
| Comercial | Alta | 12-15 | Carrito, checkout, Webpay Plus, accesos automáticos |
| Académico | Alta | 12-14 | Grupos, sesiones, asistencia, notas, progresión |
| Contenido | Media | 6-8 | Upload de archivos, aprobación, acceso controlado |
| Paneles | Media | 6-7 | Dashboards diferenciados, widgets |
| Notificaciones | Baja | 4-5 | Notificaciones Laravel, envío de correos |
| **TOTAL MVP** | - | **56-69 días** | ~12-14 semanas (3-3.5 meses) con 1 dev |

> **Nota:** Estas estimaciones asumen un desarrollador full stack con experiencia en Laravel. Agregar tiempo de QA, ajustes y deploy (30-40% adicional).

---

## 14. Criterios de Aceptación del MVP

El MVP estará listo cuando:

1. ✅ Un visitante puede navegar el sitio público y registrarse como estudiante
2. ✅ Un estudiante puede iniciar sesión, ver el catálogo, agregar productos al carrito y completar la compra con Webpay Plus
3. ✅ Tras pago exitoso, el estudiante tiene acceso inmediato a materiales/suscripciones comprados
4. ✅ Un administrador puede crear usuarios, asignar roles, gestionar productos y niveles
5. ✅ Un docente puede crear grupos, asignar estudiantes, programar clases, registrar asistencia y notas
6. ✅ Un docente puede subir materiales y clases pregrabadas, y un administrador puede aprobarlos
7. ✅ Los estudiantes pueden ver su historial académico, asistencia y notas
8. ✅ El sistema envía notificaciones internas y correos en eventos clave
9. ✅ Cada rol tiene un panel contextual funcional
10. ✅ El sistema opera correctamente en zona horaria de Chile

---

## 15. Próximos Pasos

1. ✅ **Revisar y validar estos módulos con el Product Owner**
2. ⏳ Documentar requerimientos funcionales detallados por módulo
3. ⏳ Diseñar modelo de base de datos completo (DER)
4. ⏳ Crear migraciones de Laravel para todas las entidades
5. ⏳ Definir estructura de carpetas y arquitectura de código
6. ⏳ Inicializar proyecto Laravel y configurar entorno de desarrollo
7. ⏳ Comenzar implementación iterativa, módulo por módulo

---

**Documento preparado por:** Arquitecto de Software Senior  
**Revisión requerida por:** Product Owner y Equipo de Desarrollo  
**Próxima entrega:** Requerimientos Funcionales Detallados
