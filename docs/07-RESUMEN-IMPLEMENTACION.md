# Resumen de Implementación - Fase Autorización y Validación

**Fecha:** 3 de agosto de 2026  
**Estado:** ✅ Completado

---

## 📦 Resumen Ejecutivo

Se han creado exitosamente **todos los componentes de autorización, validación, datos iniciales y middleware** para el proyecto CrucialEnglish, implementando las mejores prácticas de Laravel y separación de responsabilidades.

### Totales Creados
- **7 Policies** de autorización
- **10 Form Requests** de validación
- **5 Seeders** con datos iniciales
- **2 Middleware** personalizados
- **3 Archivos de documentación** técnica

---

## 1️⃣ Policies de Autorización (7 archivos)

### ✅ UserPolicy
**Ubicación:** `app/Policies/UserPolicy.php`

**Métodos implementados:**
- `viewAny()` → Solo admin ve listado de usuarios
- `view()` → Admin ve todos, usuarios ven su propio perfil
- `create()` → Solo admin crea usuarios
- `update()` → Admin edita todos, usuarios editan su perfil
- `delete()` → Solo admin elimina (no puede eliminarse a sí mismo)
- `restore()` / `forceDelete()` → Solo admin
- `assignRoles()` → Solo admin asigna roles

---

### ✅ AcademicGroupPolicy
**Ubicación:** `app/Policies/AcademicGroupPolicy.php`

**Métodos implementados:**
- `viewAny()` → Admin, docentes y estudiantes pueden ver grupos
- `view()` → Admin ve todos, docente ve sus grupos, estudiante ve donde está inscrito
- `create()` → Solo admin crea grupos
- `update()` → Admin edita todos, docente asignado edita su grupo
- `delete()` / `restore()` / `forceDelete()` → Solo admin
- `manageStudents()` → Admin y docente asignado gestionan estudiantes del grupo

**Lógica especial:**
- Docentes solo gestionan grupos donde `teacher_id === user.id`
- Estudiantes solo ven grupos donde están inscritos (tabla `group_students`)

---

### ✅ ProductPolicy
**Ubicación:** `app/Policies/ProductPolicy.php`

**Métodos implementados:**
- `viewAny()` → Público (sin autenticación)
- `view()` → Productos activos públicos, inactivos solo admin
- `create()` / `update()` / `delete()` → Solo admin
- `restore()` / `forceDelete()` → Solo admin
- `manageOffers()` → Solo admin gestiona ofertas

**Características:**
- Productos activos son públicos sin autenticación
- Productos inactivos requieren ser admin

---

### ✅ MaterialPolicy
**Ubicación:** `app/Policies/MaterialPolicy.php`

**Métodos implementados:**
- `viewAny()` → Admin, docentes y estudiantes
- `view()` → Admin/docentes ven todos, estudiantes solo aprobados con acceso válido
- `create()` → Docentes y admin
- `update()` → Admin edita todos, docente autor edita mientras esté pendiente
- `delete()` → Admin elimina todos, docente autor elimina mientras esté pendiente
- `review()` → Solo admin aprueba/rechaza
- `download()` → Misma lógica que `view()`

**Lógica de acceso para estudiantes:**
```php
// Verifica acceso válido en tabla student_accesses
$user->accesses()
    ->where('product_id', $material->id)
    ->where('access_type', 'material')
    ->where('is_active', true)
    ->where(function ($query) {
        $query->whereNull('expires_at')
            ->orWhere('expires_at', '>', now());
    })
    ->exists();
```

---

### ✅ RecordedLessonPolicy
**Ubicación:** `app/Policies/RecordedLessonPolicy.php`

**Métodos implementados:**
- `viewAny()` → Admin, docentes y estudiantes
- `view()` → Admin/docentes ven todas, estudiantes solo aprobadas con acceso válido
- `create()` → Docentes y admin
- `update()` → Admin edita todas, docente autor edita mientras esté pendiente
- `delete()` → Admin elimina todas, docente autor elimina mientras esté pendiente
- `review()` → Solo admin aprueba/rechaza
- `watch()` → Misma lógica que `view()`

**Lógica idéntica a MaterialPolicy** pero para clases pregrabadas.

---

### ✅ StudentGradePolicy
**Ubicación:** `app/Policies/StudentGradePolicy.php`

**Métodos implementados:**
- `viewAny()` → Admin, docentes y estudiantes
- `view()` → Admin ve todas, docente del grupo ve notas de su grupo, estudiante ve sus notas
- `create()` → Admin y docentes
- `update()` → Admin edita todas, docente del grupo edita notas de su grupo
- `delete()` → Admin elimina todas, docente del grupo elimina notas de su grupo

**Lógica especial:**
- Docentes solo gestionan notas de grupos donde `group.teacher_id === user.id`
- Estudiantes solo ven sus propias notas (`student_id === user.id`)

---

### ✅ OrderPolicy
**Ubicación:** `app/Policies/OrderPolicy.php`

**Métodos implementados:**
- `viewAny()` → Admin y estudiantes
- `view()` → Admin ve todas, estudiante ve solo sus órdenes
- `create()` → Solo estudiantes (comprar)
- `update()` → Admin edita todas, estudiante edita sus órdenes pendientes
- `cancel()` → Admin cancela cualquiera, estudiante cancela sus pendientes
- `delete()` → Solo admin

**Lógica de órdenes:**
- Estudiantes solo editan/cancelan órdenes con `status === 'pending'`
- Admin tiene control total

---

## 2️⃣ Form Requests de Validación (10 archivos)

### ✅ StoreProductRequest / UpdateProductRequest
**Ubicación:** `app/Http/Requests/StoreProductRequest.php` y `UpdateProductRequest.php`

**Validaciones:**
```php
'product_type_id' => 'required|exists:product_types,id'
'level_id' => 'nullable|exists:levels,id'
'name' => 'required|string|max:255|unique:products'
'description' => 'required|string'
'base_price' => 'required|numeric|min:0|max:9999999.99'
'billing_mode' => 'required|in:one_time,monthly,package'
'is_active' => 'boolean'
```

**Mensajes personalizados:**
- Precio no puede ser negativo
- Precio máximo 9,999,999.99
- Nombre único

---

### ✅ StoreStudentGradeRequest / UpdateStudentGradeRequest
**Ubicación:** `app/Http/Requests/StoreStudentGradeRequest.php` y `UpdateStudentGradeRequest.php`

**Validaciones:**
```php
'student_id' => 'required|exists:users,id'
'level_id' => 'required|exists:levels,id'
'group_id' => 'nullable|exists:academic_groups,id'
'evaluation_type' => 'required|in:prueba,tarea,oral,final'
'grade' => 'required|numeric|min:1.0|max:7.0'  // Escala chilena
'evaluation_date' => 'required|date|before_or_equal:today'
'comments' => 'nullable|string|max:1000'
```

**Validaciones clave:**
- Nota entre 1.0 y 7.0 (escala chilena)
- Fecha de evaluación no puede ser futura

---

### ✅ StoreAcademicGroupRequest / UpdateAcademicGroupRequest
**Ubicación:** `app/Http/Requests/StoreAcademicGroupRequest.php` y `UpdateAcademicGroupRequest.php`

**Validaciones:**
```php
'name' => 'required|string|max:255'
'level_id' => 'required|exists:levels,id'
'teacher_id' => 'required|exists:users,id'
'schedule_description' => 'nullable|string|max:500'
'is_active' => 'boolean'
```

---

### ✅ StoreMaterialRequest / UpdateMaterialRequest
**Ubicación:** `app/Http/Requests/StoreMaterialRequest.php` y `UpdateMaterialRequest.php`

**Validaciones:**
```php
'title' => 'required|string|max:255'
'description' => 'nullable|string'
'level_id' => 'required|exists:levels,id'
'file_type' => 'required|string|max:50'
'file_path' => 'nullable|string|max:500'
'external_link' => 'nullable|url|max:500'
'status' => 'sometimes|in:pending,approved,rejected'
```

**Método `prepareForValidation()`:**
- Status por defecto: `pending`
- Author_id automático: `auth()->user()->id`

---

### ✅ StoreRecordedLessonRequest / UpdateRecordedLessonRequest
**Ubicación:** `app/Http/Requests/StoreRecordedLessonRequest.php` y `UpdateRecordedLessonRequest.php`

**Validaciones:**
```php
'title' => 'required|string|max:255'
'description' => 'nullable|string'
'level_id' => 'required|exists:levels,id'
'duration_minutes' => 'required|integer|min:1|max:300'  // Max 5 horas
'video_path' => 'nullable|string|max:500'
'external_link' => 'nullable|url|max:500'
'status' => 'sometimes|in:pending,approved,rejected'
```

**Validaciones clave:**
- Duración entre 1 y 300 minutos (5 horas máximo)
- Status por defecto: `pending`

---

## 3️⃣ Seeders con Datos Iniciales (5 archivos)

### ✅ RoleSeeder
**Ubicación:** `database/seeders/RoleSeeder.php`

**Datos creados:**
```
┌─────────────────┬─────────────────┬──────────────────────────────────────┐
│ name            │ slug            │ description                          │
├─────────────────┼─────────────────┼──────────────────────────────────────┤
│ Estudiante      │ estudiante      │ Accede a clases y materiales         │
│ Docente         │ docente         │ Gestiona grupos y evalúa estudiantes │
│ Administrador   │ administrador   │ Acceso completo al sistema           │
└─────────────────┴─────────────────┴──────────────────────────────────────┘
```

---

### ✅ LevelSeeder
**Ubicación:** `database/seeders/LevelSeeder.php`

**Datos creados:**
```
┌──────┬────────────────────────┬───────┬─────────────────────────────────────────┐
│ code │ name                   │ order │ description (resumen)                   │
├──────┼────────────────────────┼───────┼─────────────────────────────────────────┤
│ A1   │ Principiante (A1)      │ 1     │ Comprende expresiones cotidianas...     │
│ A2   │ Elemental (A2)         │ 2     │ Comprende frases de uso frecuente...   │
│ B1   │ Intermedio (B1)        │ 3     │ Comprende textos claros sobre trabajo..│
│ B2   │ Intermedio Alto (B2)   │ 4     │ Entiende textos complejos...            │
│ C1   │ Avanzado (C1)          │ 5     │ Comprende textos largos y complejos...  │
│ C2   │ Dominio (C2)           │ 6     │ Comprende prácticamente todo...         │
└──────┴────────────────────────┴───────┴─────────────────────────────────────────┘
```

---

### ✅ ProductTypeSeeder
**Ubicación:** `database/seeders/ProductTypeSeeder.php`

**Datos creados:**
```
┌──────────────────────┬───────────────────────┬─────────────────────────────────────┐
│ name                 │ slug                  │ description (resumen)               │
├──────────────────────┼───────────────────────┼─────────────────────────────────────┤
│ Clase Individual     │ clase-individual      │ Clases 1-1 personalizadas          │
│ Clase Grupal         │ clase-grupal          │ Clases en grupo reducido           │
│ Material de Apoyo    │ material-apoyo        │ PDFs, ejercicios, guías digitales  │
│ Suscripción          │ suscripcion           │ Acceso ilimitado a contenido       │
└──────────────────────┴───────────────────────┴─────────────────────────────────────┘
```

---

### ✅ AdminUserSeeder
**Ubicación:** `database/seeders/AdminUserSeeder.php`

**Usuario creado:**
```
Email:    admin@crucialenglish.com
Password: Admin123!
Role:     Administrador
Active:   true
```

⚠️ **IMPORTANTE:** Cambiar esta contraseña en producción.

---

### ✅ DatabaseSeeder (actualizado)
**Ubicación:** `database/seeders/DatabaseSeeder.php`

**Orden de ejecución:**
1. RoleSeeder
2. LevelSeeder
3. ProductTypeSeeder
4. AdminUserSeeder

**Comando para ejecutar:**
```bash
php artisan db:seed
```

---

## 4️⃣ Middleware Personalizados (2 archivos)

### ✅ RoleMiddleware
**Ubicación:** `app/Http/Middleware/RoleMiddleware.php`

**Funcionalidad:**
- Verifica que el usuario tenga al menos uno de los roles requeridos
- Acepta múltiples roles: `role:estudiante,docente`
- Usa el método helper `$user->hasAnyRole($roles)`

**Uso en rutas:**
```php
Route::middleware(['auth', 'role:administrador'])->group(function () {
    // Solo administradores
});

Route::middleware(['auth', 'role:estudiante,docente'])->group(function () {
    // Estudiantes O docentes
});
```

---

### ✅ EnsureUserIsActive
**Ubicación:** `app/Http/Middleware/EnsureUserIsActive.php`

**Funcionalidad:**
- Verifica que el campo `active` del usuario sea `true`
- Si está inactivo: logout automático + redirección a login
- Mensaje: "Tu cuenta está inactiva. Contacta al administrador."

**Uso en rutas:**
```php
Route::middleware(['auth', 'active'])->group(function () {
    // Solo usuarios con cuenta activa
});
```

---

## 5️⃣ Documentación Técnica (3 archivos)

### ✅ 05-MODELOS-ELOQUENT.md
**Ubicación:** `docs/05-MODELOS-ELOQUENT.md`

**Contenido:**
- Índice de 21 modelos organizados por dominio
- Diagramas de relaciones principales
- Listado de campos y casteos
- Métodos auxiliares
- Constantes definidas
- Notas sobre SoftDeletes y convenciones

---

### ✅ 06-CONFIGURACION-MIDDLEWARE.md
**Ubicación:** `docs/06-CONFIGURACION-MIDDLEWARE.md`

**Contenido:**
- Descripción de middleware creados
- Instrucciones de registro en `bootstrap/app.php` (Laravel 11+)
- Instrucciones de registro en `app/Http/Kernel.php` (Laravel 10)
- Ejemplos completos de rutas organizadas por rol
- Flujo de autenticación y autorización
- Ejemplos de tests
- Mejores prácticas

**Rutas de ejemplo incluidas:**
- Públicas (home, productos, contacto)
- Panel Admin (dashboard, usuarios, productos, grupos, aprobaciones)
- Panel Docente (grupos, sesiones, asistencia, notas, materiales)
- Panel Estudiante (grupos, notas, progreso, compras, pagos)
- Compartidas (perfil, notificaciones)

---

### ✅ 07-RESUMEN-IMPLEMENTACION.md (este archivo)
**Ubicación:** `docs/07-RESUMEN-IMPLEMENTACION.md`

Resumen completo de todos los componentes creados en esta fase.

---

## 📊 Estadísticas de Implementación

| Componente          | Cantidad | Ubicación                   |
|---------------------|----------|-----------------------------|
| Policies            | 7        | `app/Policies/`             |
| Form Requests       | 10       | `app/Http/Requests/`        |
| Seeders             | 5        | `database/seeders/`         |
| Middleware          | 2        | `app/Http/Middleware/`      |
| Documentación       | 3        | `docs/`                     |
| **TOTAL ARCHIVOS**  | **27**   | —                           |

---

## 🎯 Arquitectura de Seguridad Implementada

### Capas de Protección

```
┌─────────────────────────────────────────────────────────┐
│                    USUARIO HACE REQUEST                  │
└───────────────────────┬─────────────────────────────────┘
                        │
                        ▼
┌─────────────────────────────────────────────────────────┐
│  1. MIDDLEWARE auth                                      │
│     ¿Usuario autenticado?                                │
│     ❌ NO → Redirige a /login                            │
│     ✅ SÍ → Continúa                                      │
└───────────────────────┬─────────────────────────────────┘
                        │
                        ▼
┌─────────────────────────────────────────────────────────┐
│  2. MIDDLEWARE active (EnsureUserIsActive)               │
│     ¿Cuenta activa?                                      │
│     ❌ NO → Logout + Redirige a /login                   │
│     ✅ SÍ → Continúa                                      │
└───────────────────────┬─────────────────────────────────┘
                        │
                        ▼
┌─────────────────────────────────────────────────────────┐
│  3. MIDDLEWARE role (RoleMiddleware)                     │
│     ¿Tiene rol requerido?                                │
│     ❌ NO → Error 403                                     │
│     ✅ SÍ → Continúa                                      │
└───────────────────────┬─────────────────────────────────┘
                        │
                        ▼
┌─────────────────────────────────────────────────────────┐
│  4. CONTROLLER recibe request                            │
│     Ejecuta Form Request de validación                   │
└───────────────────────┬─────────────────────────────────┘
                        │
                        ▼
┌─────────────────────────────────────────────────────────┐
│  5. FORM REQUEST (autorización + validación)             │
│     authorize() → Verifica Policy                        │
│     rules() → Valida datos                               │
│     ❌ Falla → Error 403 o 422                            │
│     ✅ Pasa → Continúa                                     │
└───────────────────────┬─────────────────────────────────┘
                        │
                        ▼
┌─────────────────────────────────────────────────────────┐
│  6. POLICY verifica autorización granular                │
│     ¿Usuario puede realizar esta acción?                 │
│     - ¿Es el docente del grupo?                          │
│     - ¿Es el autor del material?                         │
│     - ¿Tiene acceso válido al contenido?                 │
│     ❌ NO → Error 403                                     │
│     ✅ SÍ → Continúa                                      │
└───────────────────────┬─────────────────────────────────┘
                        │
                        ▼
┌─────────────────────────────────────────────────────────┐
│  7. MODELO ejecuta la lógica de negocio                  │
│     - Usa Query Builder / Eloquent                       │
│     - No contiene validaciones                           │
│     - Usa casts, relaciones, métodos helper              │
└───────────────────────┬─────────────────────────────────┘
                        │
                        ▼
┌─────────────────────────────────────────────────────────┐
│               RESPONSE EXITOSO AL USUARIO                │
└─────────────────────────────────────────────────────────┘
```

---

## ✅ Validación de Cumplimiento

### Convenciones de Código ✅
- ✅ Nombres de clases en PascalCase
- ✅ Métodos en camelCase
- ✅ Validaciones en Form Requests (no en modelos)
- ✅ Autorización en Policies
- ✅ Mensajes en español
- ✅ Constantes definidas en modelos

### Lógica de Negocio ✅
- ✅ Notas entre 1.0 y 7.0 (escala chilena)
- ✅ Precios > 0
- ✅ Fechas de evaluación no futuras
- ✅ Duración de videos máximo 5 horas
- ✅ Materiales/clases con flujo de aprobación (pending → approved/rejected)
- ✅ Solo admin aprueba contenido
- ✅ Docentes solo gestionan sus grupos
- ✅ Estudiantes solo ven contenido con acceso válido

### Seguridad ✅
- ✅ Admin no puede eliminarse a sí mismo
- ✅ Usuarios inactivos son deslogueados automáticamente
- ✅ Múltiples capas de autorización (middleware + policies)
- ✅ Validación de accesos a contenido con verificación de expiración
- ✅ Protección contra inyección SQL (Eloquent)
- ✅ Contraseña de admin debe cambiarse en producción

---

## 🚀 Comandos de Instalación

### 1. Ejecutar Seeders
```bash
# Ejecutar todos los seeders
php artisan db:seed

# O ejecutar uno específico
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=LevelSeeder
php artisan db:seed --class=ProductTypeSeeder
php artisan db:seed --class=AdminUserSeeder
```

### 2. Verificar Datos Creados
```bash
# Conectar a MySQL
mysql -u root -p

# Ver roles
SELECT * FROM roles;

# Ver niveles
SELECT * FROM levels ORDER BY `order`;

# Ver tipos de producto
SELECT * FROM product_types;

# Ver usuario admin
SELECT u.id, u.name, u.email, r.name as role
FROM users u
JOIN user_roles ur ON u.id = ur.user_id
JOIN roles r ON ur.role_id = r.id
WHERE u.email = 'admin@crucialenglish.com';
```

### 3. Registrar Middleware (Laravel 11+)
Editar `bootstrap/app.php`:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'role' => \App\Http\Middleware\RoleMiddleware::class,
        'active' => \App\Http\Middleware\EnsureUserIsActive::class,
    ]);
})
```

### 4. Verificar Policies Registradas
Las Policies se autodescubren automáticamente en Laravel si siguen la convención de nombres.

Verificar en `app/Providers/AuthServiceProvider.php` (si existe):
```php
protected $policies = [
    User::class => UserPolicy::class,
    AcademicGroup::class => AcademicGroupPolicy::class,
    Product::class => ProductPolicy::class,
    Material::class => MaterialPolicy::class,
    RecordedLesson::class => RecordedLessonPolicy::class,
    StudentGrade::class => StudentGradePolicy::class,
    Order::class => OrderPolicy::class,
];
```

---

## 📋 Checklist de Verificación

### Policies
- [x] UserPolicy creada
- [x] AcademicGroupPolicy creada
- [x] ProductPolicy creada
- [x] MaterialPolicy creada
- [x] RecordedLessonPolicy creada
- [x] StudentGradePolicy creada
- [x] OrderPolicy creada

### Form Requests
- [x] StoreProductRequest / UpdateProductRequest
- [x] StoreStudentGradeRequest / UpdateStudentGradeRequest
- [x] StoreAcademicGroupRequest / UpdateAcademicGroupRequest
- [x] StoreMaterialRequest / UpdateMaterialRequest
- [x] StoreRecordedLessonRequest / UpdateRecordedLessonRequest

### Seeders
- [x] RoleSeeder creado
- [x] LevelSeeder creado
- [x] ProductTypeSeeder creado
- [x] AdminUserSeeder creado
- [x] DatabaseSeeder actualizado

### Middleware
- [x] RoleMiddleware creado
- [x] EnsureUserIsActive creado

### Documentación
- [x] 05-MODELOS-ELOQUENT.md
- [x] 06-CONFIGURACION-MIDDLEWARE.md
- [x] 07-RESUMEN-IMPLEMENTACION.md

### Pendientes
- [ ] Registrar middleware en `bootstrap/app.php`
- [ ] Definir rutas en `routes/web.php`
- [ ] Crear controladores correspondientes
- [ ] Crear vistas Blade
- [ ] Escribir tests unitarios
- [ ] Configurar Policies en `AuthServiceProvider.php` (si es necesario)

---

## 🎓 Próximos Pasos Recomendados

### Prioridad Alta
1. **Registrar middleware** en `bootstrap/app.php` o `app/Http/Kernel.php`
2. **Ejecutar seeders** para tener datos iniciales
3. **Definir rutas** en `routes/web.php` usando los ejemplos de la documentación
4. **Crear controladores** base para cada rol:
   - `Admin\DashboardController`
   - `Teacher\DashboardController`
   - `Student\DashboardController`

### Prioridad Media
5. **Crear vistas Blade** base:
   - Layouts (admin, teacher, student)
   - Dashboards
   - Vistas de error (403, 404, 500)
6. **Implementar autenticación** (Laravel Breeze ya configurado)
7. **Crear factories** para testing
8. **Escribir tests** de autorización

### Prioridad Baja
9. **Implementar módulo de compras** (carrito, Webpay)
10. **Crear sistema de notificaciones**
11. **Implementar exportación de reportes** (notas, asistencia)
12. **Optimizar consultas** (eager loading, caching)

---

## 📚 Referencias Técnicas

### Laravel Documentation
- [Authorization (Policies)](https://laravel.com/docs/11.x/authorization)
- [Form Requests](https://laravel.com/docs/11.x/validation#form-request-validation)
- [Middleware](https://laravel.com/docs/11.x/middleware)
- [Database Seeding](https://laravel.com/docs/11.x/seeding)

### Convenciones del Proyecto
- [.github/copilot-instructions.md](/.github/copilot-instructions.md) → Contexto completo del proyecto
- [docs/01-RESUMEN-EJECUTIVO.md](/docs/01-RESUMEN-EJECUTIVO.md) → Visión general
- [docs/02-MODULOS-MVP.md](/docs/02-MODULOS-MVP.md) → Módulos del MVP
- [docs/03-REQUERIMIENTOS-FUNCIONALES.md](/docs/03-REQUERIMIENTOS-FUNCIONALES.md) → 48 requerimientos funcionales
- [docs/05-MODELOS-ELOQUENT.md](/docs/05-MODELOS-ELOQUENT.md) → 21 modelos creados

---

## 🔐 Notas de Seguridad

### Contraseñas
⚠️ **CRÍTICO:** La contraseña del usuario administrador creado por el seeder es `Admin123!`  
**DEBES** cambiarla inmediatamente en producción.

### Zona Horaria
Todas las fechas se guardan en **UTC** en la base de datos.  
Al mostrar fechas, convertir a **America/Santiago** (Chile).

```php
// En config/app.php
'timezone' => 'America/Santiago',
```

### Middleware de Seguridad
Asegúrate de aplicar el middleware en este orden:
1. `auth` → Autenticación
2. `active` → Cuenta activa
3. `role:xxx` → Verificación de rol

### Validación de Accesos
Los estudiantes deben tener registros válidos en `student_accesses` para ver contenido:
- Campo `is_active` debe ser `true`
- Campo `expires_at` debe ser `null` o fecha futura

---

**Última actualización:** 3 de agosto de 2026  
**Estado del proyecto:** Fase de autorización y validación completada ✅  
**Total de archivos:** 27 (Policies, Form Requests, Seeders, Middleware, Docs)
