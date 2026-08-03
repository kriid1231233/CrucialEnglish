# Modelos Eloquent - CrucialEnglish

**Fecha de creación:** 2 de agosto de 2026  
**Total de modelos:** 21

---

## 📋 Índice de Modelos

### 1. Identidad y Roles (5 modelos)
- [User](#user) - Usuario base del sistema (usa SoftDeletes)
- [Role](#role) - Roles del sistema (Estudiante, Docente, Administrador)
- [StudentProfile](#studentprofile) - Perfil extendido de estudiante
- [TeacherProfile](#teacherprofile) - Perfil extendido de docente

### 2. Catálogo (4 modelos)
- [Level](#level) - Niveles académicos (A1, A2, B1, B2, C1, C2)
- [ProductType](#producttype) - Tipos de producto (clase individual, grupal, material, suscripción)
- [Product](#product) - Productos del catálogo (usa SoftDeletes)
- [ProductOffer](#productoffer) - Ofertas especiales con vigencia

### 3. Comercial (5 modelos)
- [Order](#order) - Órdenes de compra
- [OrderItem](#orderitem) - Items de cada orden
- [Payment](#payment) - Pagos y transacciones Webpay
- [StudentAccess](#studentaccess) - Accesos habilitados a contenido
- [Subscription](#subscription) - Suscripciones activas/expiradas

### 4. Académico (4 modelos)
- [AcademicGroup](#academicgroup) - Grupos de estudiantes (usa SoftDeletes, tabla: `academic_groups`)
- [ClassSession](#classsession) - Sesiones de clase programadas
- [StudentGrade](#studentgrade) - Notas de evaluaciones (escala 1.0-7.0)
- [StudentRecord](#studentrecord) - Historial de niveles completados

### 5. Contenido (2 modelos)
- [Material](#material) - Materiales de apoyo (PDF, documentos)
- [RecordedLesson](#recordedlesson) - Clases pregrabadas (videos)

### 6. Comunicación (2 modelos)
- [Announcement](#announcement) - Avisos y anuncios
- [ContactMessage](#contactmessage) - Mensajes de contacto del sitio público

---

## 📊 Relaciones Principales

### User (Usuario)
```php
// Relaciones de roles
belongsToMany(Role)                    → Roles asignados al usuario

// Perfiles
hasOne(StudentProfile)                 → Perfil de estudiante
hasOne(TeacherProfile)                 → Perfil de docente

// Como estudiante
hasMany(Order, 'student_id')           → Órdenes de compra
belongsToMany(AcademicGroup)           → Grupos en los que está inscrito
hasMany(StudentGrade)                  → Notas obtenidas
hasMany(StudentRecord)                 → Niveles completados
hasMany(StudentAccess)                 → Accesos a contenido
hasMany(Subscription)                  → Suscripciones

// Como docente
hasMany(AcademicGroup, 'teacher_id')   → Grupos que gestiona
hasMany(Material, 'author_id')         → Materiales creados
hasMany(RecordedLesson, 'author_id')   → Clases pregrabadas creadas

// Como administrador
hasMany(Material, 'reviewed_by')       → Materiales revisados
hasMany(RecordedLesson, 'reviewed_by') → Clases revisadas

// Comunicación
hasMany(Announcement)                  → Avisos creados
```

### AcademicGroup (Grupo Académico)
```php
belongsTo(Level)                       → Nivel del grupo
belongsTo(User, 'teacher_id')          → Docente asignado
belongsToMany(User, 'group_students')  → Estudiantes inscritos
hasMany(ClassSession)                  → Sesiones de clase
hasMany(StudentGrade)                  → Notas del grupo
```

### Product (Producto)
```php
belongsTo(ProductType)                 → Tipo de producto
belongsTo(Level)                       → Nivel asociado (nullable)
hasMany(ProductOffer)                  → Ofertas especiales
hasMany(OrderItem)                     → Items de orden
hasMany(StudentAccess)                 → Accesos generados
hasMany(Subscription)                  → Suscripciones
```

### Order (Orden de Compra)
```php
belongsTo(User, 'student_id')          → Estudiante que compró
hasMany(OrderItem)                     → Items de la orden
hasMany(Payment)                       → Pagos asociados
```

### ClassSession (Sesión de Clase)
```php
belongsTo(AcademicGroup, 'group_id')   → Grupo al que pertenece
belongsToMany(User, 'class_session_students') → Asistencia de estudiantes
```

---

## 🔑 Campos Clave y Casteos

### SoftDeletes (deleted_at)
- ✅ User
- ✅ Product
- ✅ AcademicGroup

### Booleanos (boolean)
- `active` → User
- `is_active` → Product, AcademicGroup, StudentAccess
- `passed` → StudentRecord

### Decimales
- `base_price, discount_price, unit_price, subtotal, total_amount, amount` → decimal:2
- `grade, average_grade` → decimal:1

### Fechas (datetime)
- `email_verified_at` → User
- `assigned_at` → user_roles pivot
- `joined_at, left_at` → group_students pivot
- `granted_at, expires_at` → StudentAccess
- `starts_at, ends_at` → Subscription
- `valid_from, valid_until` → ProductOffer
- `payment_date, reviewed_at, published_at` → Payment, Material, RecordedLesson, Announcement
- `session_date, start_time` → ClassSession
- `completed_at` → StudentRecord
- `evaluation_date` → StudentGrade

---

## 🎯 Métodos Auxiliares Incluidos

### User
- `hasRole(string $roleSlug): bool`
- `hasAnyRole(array $roleSlugs): bool`
- `hasAllRoles(array $roleSlugs): bool`

### Product
- `currentOffer()` → Obtiene oferta vigente
- `effectivePrice(): float` → Precio efectivo (con oferta o base)

### ProductOffer
- `isValid(): bool` → Verifica si la oferta está vigente

### Order
- `approvedPayment()` → Obtiene el pago aprobado

### StudentAccess
- `isValid(): bool` → Verifica si el acceso está vigente

### Subscription
- `isActive(): bool` → Verifica si la suscripción está activa

### ContactMessage
- `markAsRead(): bool` → Marca mensaje como leído
- `isRead(): bool` → Verifica si está leído

### AcademicGroup
- `activeStudents()` → Solo estudiantes activos del grupo

---

## 📝 Constantes Definidas

### Role
```php
Role::STUDENT       // 'estudiante'
Role::TEACHER       // 'docente'
Role::ADMIN         // 'administrador'
```

### Level
```php
Level::A1, Level::A2, Level::B1, Level::B2, Level::C1, Level::C2
```

### ProductType
```php
ProductType::INDIVIDUAL_CLASS    // 'clase-individual'
ProductType::GROUP_CLASS         // 'clase-grupal'
ProductType::SUPPORT_MATERIAL    // 'material-apoyo'
ProductType::SUBSCRIPTION        // 'suscripcion'
```

### Product
```php
Product::BILLING_ONE_TIME    // 'one_time'
Product::BILLING_MONTHLY     // 'monthly'
Product::BILLING_PACKAGE     // 'package'
```

### Order
```php
Order::STATUS_PENDING     // 'pending'
Order::STATUS_PAID        // 'paid'
Order::STATUS_FAILED      // 'failed'
Order::STATUS_CANCELLED   // 'cancelled'
```

### Payment
```php
Payment::STATUS_PENDING    // 'pending'
Payment::STATUS_APPROVED   // 'approved'
Payment::STATUS_REJECTED   // 'rejected'
Payment::METHOD_WEBPAY     // 'webpay_plus'
```

### StudentAccess
```php
StudentAccess::TYPE_MATERIAL         // 'material'
StudentAccess::TYPE_RECORDED_LESSON  // 'recorded_lesson'
```

### Subscription
```php
Subscription::STATUS_ACTIVE      // 'active'
Subscription::STATUS_EXPIRED     // 'expired'
Subscription::STATUS_CANCELLED   // 'cancelled'
```

### ClassSession
```php
ClassSession::STATUS_SCHEDULED   // 'scheduled'
ClassSession::STATUS_COMPLETED   // 'completed'
ClassSession::STATUS_CANCELLED   // 'cancelled'

// Estados de asistencia
ClassSession::ATTENDANCE_PRESENT    // 'present'
ClassSession::ATTENDANCE_ABSENT     // 'absent'
ClassSession::ATTENDANCE_LATE       // 'late'
ClassSession::ATTENDANCE_JUSTIFIED  // 'justified'
```

### StudentGrade
```php
StudentGrade::TYPE_TEST       // 'prueba'
StudentGrade::TYPE_HOMEWORK   // 'tarea'
StudentGrade::TYPE_ORAL       // 'oral'
StudentGrade::TYPE_FINAL      // 'final'
```

### Material / RecordedLesson
```php
Material::STATUS_PENDING    // 'pending'
Material::STATUS_APPROVED   // 'approved'
Material::STATUS_REJECTED   // 'rejected'
```

### Announcement
```php
Announcement::AUDIENCE_ALL    // 'all'
Announcement::AUDIENCE_GROUP  // 'group'
Announcement::AUDIENCE_LEVEL  // 'level'
Announcement::STATUS_DRAFT     // 'draft'
Announcement::STATUS_PUBLISHED // 'published'
```

---

## ⚠️ Notas Importantes

1. **Tabla `academic_groups`:** Nombre explícito definido con `protected $table` porque `groups` es palabra reservada en MySQL.

2. **Relaciones pivot con metadata:**
   - `user_roles`: `assigned_at`, `assigned_by`
   - `group_students`: `joined_at`, `left_at`, `is_active`
   - `class_session_students`: `attendance_status`, `notes`

3. **SoftDeletes:** Habilitado en User, Product y AcademicGroup para mantener historial.

4. **Notas:** Escala 1.0 a 7.0 con un decimal (casteo `decimal:1`).

5. **Zona horaria:** Todas las fechas se guardan en UTC en BD, se muestran en America/Santiago.

6. **Validaciones de negocio:** Implementar en Form Requests, no en modelos.

---

## 🚀 Próximos Pasos

1. ✅ Modelos creados
2. ⏳ Crear migraciones (si es necesario actualizar esquema)
3. ⏳ Crear Form Requests para validación
4. ⏳ Crear Policies para autorización granular
5. ⏳ Crear Seeders con datos de prueba
6. ⏳ Crear Factories para testing
7. ⏳ Implementar controladores por módulo
8. ⏳ Crear vistas Blade

---

**Última actualización:** 2 de agosto de 2026  
**Total de archivos creados:** 21 modelos  
**Ubicación:** `app/Models/`
