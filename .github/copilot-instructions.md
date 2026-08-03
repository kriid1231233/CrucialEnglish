# CrucialEnglish — Contexto para GitHub Copilot

## Qué hace la app
CrucialEnglish es una plataforma web a medida para un instituto de inglés que centraliza
sitio institucional, venta de productos académicos (clases individuales, grupales,
materiales, suscripciones a clases pregrabadas) y gestión académica (grupos, asistencia,
notas, progresión de niveles A1-C2) para tres roles: Estudiante, Docente y Administrador.

## Stack tecnológico
- PHP 8.3+, Laravel 13
- MySQL 8.0+ corriendo en XAMPP local (host 127.0.0.1, puerto 3306, db crucial_english)
- Blade + Bootstrap 5, JavaScript vanilla / Alpine.js opcional
- Autenticación con Laravel Breeze
- Composer, Git + GitHub
- SDK de Transbank para integración con Webpay Plus

## Convenciones de código
- Nombres de tablas en snake_case plural (ej. student_profiles, academic_groups)
- La tabla de grupos académicos se llama `academic_groups` (NO `groups`, es palabra reservada en MySQL)
- Modelos Eloquent en PascalCase singular (ej. AcademicGroup, StudentGrade)
- Usar `protected $table` explícito cuando el nombre de tabla no siga la convención automática de Laravel
- Roles gestionados vía tabla pivote `user_roles` (relación muchos a muchos entre users y roles)
- Un usuario puede tener múltiples roles simultáneos; el rol activo se guarda en sesión
- Perfiles de Estudiante y Docente están en tablas separadas (student_profiles, teacher_profiles)
- Validaciones de negocio: notas entre 1.0 y 7.0, precios de productos > 0, soft deletes en users/products/academic_groups
- Todas las fechas se guardan en UTC; se muestran en America/Santiago
- Usar Form Requests para validación en controladores, nunca validar solo en el modelo

## Estructura del proyecto
- app/Models: modelos Eloquent mapeados a las tablas ya existentes en MySQL
- app/Http/Controllers/{Public,Auth,Admin,Teacher,Student}: controladores por rol
- app/Http/Middleware: middleware personalizado de roles (role:estudiante, role:docente, role:administrador)
- app/Policies: autorización granular (ej. solo docente asignado edita su grupo)
- database/migrations: NO recrear tablas que ya existen en el script SQL base; solo agregar migraciones para cambios incrementales
- routes/web.php: rutas separadas por prefijo de rol

## Esquema de base de datos (21 tablas)
### Identidad y Roles
- `users`: id, name, email, password, email_verified_at, active, deleted_at, timestamps
- `roles`: id, name, slug, description, timestamps
- `user_roles`: id, user_id, role_id, assigned_at, assigned_by
- `student_profiles`: id, user_id, phone, birth_date, contact_preferences, availability_notes, timestamps
- `teacher_profiles`: id, user_id, specialization, bio, availability_schedule, timestamps

### Catálogo
- `levels`: id, code, name, description, order, timestamps
- `product_types`: id, name, slug, description, timestamps
- `products`: id, product_type_id, level_id, name, description, base_price, billing_mode, is_active, deleted_at, timestamps
- `product_offers`: id, product_id, discount_price, valid_from, valid_until, timestamps

### Comercial
- `orders`: id, student_id (user_id), total_amount, status, timestamps
- `order_items`: id, order_id, product_id, quantity, unit_price, subtotal, timestamps
- `payments`: id, order_id, transaction_id, amount, status, payment_method, payment_date, timestamps
- `student_accesses`: id, student_id (user_id), product_id, access_type, granted_at, expires_at, is_active, timestamps
- `subscriptions`: id, student_id (user_id), product_id, starts_at, ends_at, status, timestamps

### Académico
- `academic_groups`: id, name, level_id, teacher_id (user_id), schedule_description, is_active, deleted_at, timestamps
- `group_students`: id, group_id (academic_group), student_id (user_id), joined_at, left_at, is_active, timestamps
- `class_sessions`: id, group_id (academic_group), session_date, start_time, duration_minutes, topic, status, timestamps
- `class_session_students`: id, class_session_id, student_id (user_id), attendance_status, notes, timestamps
- `student_grades`: id, student_id (user_id), level_id, group_id (academic_group), evaluation_type, grade, evaluation_date, comments, timestamps
- `student_records`: id, student_id (user_id), level_id, completed_at, average_grade, passed, timestamps

### Contenido
- `materials`: id, title, description, level_id, file_type, file_path, external_link, status, author_id (teacher user_id), reviewed_by (admin user_id), reviewed_at, timestamps
- `recorded_lessons`: id, title, description, level_id, duration_minutes, video_path, external_link, status, author_id (teacher user_id), reviewed_by (admin user_id), reviewed_at, timestamps

### Comunicación
- `notifications`: tabla estándar de Laravel (type, notifiable_type, notifiable_id, data, read_at, timestamps)
- `announcements`: id, title, content, author_id (user_id), audience_type, audience_id, status, published_at, timestamps
- `contact_messages`: id, name, email, message, read_at, timestamps

## Herramientas disponibles
- La base de datos ya existe en XAMPP/MySQL con las 21 tablas y datos semilla (roles, niveles, tipos de producto)
- No ejecutar `php artisan migrate:fresh` sin confirmar, borraría los datos ya cargados
- Usar `php artisan make:model NombreModelo` sin `-m` porque las tablas ya existen
- PHP 8.3+ features disponibles: typed properties, constructor property promotion, enums

## Relaciones clave
- User ↔ Role: muchos a muchos (user_roles)
- User → StudentProfile: uno a uno
- User → TeacherProfile: uno a uno
- AcademicGroup → Level: muchos a uno
- AcademicGroup → User (teacher): muchos a uno
- AcademicGroup ↔ User (students): muchos a muchos (group_students)
- Product → ProductType: muchos a uno
- Product → Level: muchos a uno
- Order → User (student): muchos a uno
- ClassSession → AcademicGroup: muchos a uno
- ClassSession ↔ User (asistencia): muchos a muchos (class_session_students)
- StudentGrade → User (student): muchos a uno
- Material/RecordedLesson → User (author): muchos a uno
- Material/RecordedLesson → User (reviewer): muchos a uno
