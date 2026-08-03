# Configuración de Middleware - CrucialEnglish

**Fecha:** 3 de agosto de 2026

---

## 📋 Middleware Creados

### 1. RoleMiddleware
**Ubicación:** `app/Http/Middleware/RoleMiddleware.php`

**Propósito:** Verificar que el usuario autenticado tenga al menos uno de los roles requeridos.

**Uso:**
```php
Route::middleware(['auth', 'role:administrador'])->group(function () {
    // Rutas solo para administradores
});

Route::middleware(['auth', 'role:estudiante,docente'])->group(function () {
    // Rutas para estudiantes O docentes
});
```

### 2. EnsureUserIsActive
**Ubicación:** `app/Http/Middleware/EnsureUserIsActive.php`

**Propósito:** Verificar que la cuenta del usuario esté activa (campo `active = true`).

**Uso:**
```php
Route::middleware(['auth', 'active'])->group(function () {
    // Rutas que requieren cuenta activa
});
```

---

## ⚙️ Registro de Middleware

### Laravel 11+

Edita `bootstrap/app.php`:

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Middleware global para todas las rutas autenticadas
        $middleware->web(append: [
            \App\Http\Middleware\EnsureUserIsActive::class,
        ]);

        // Middleware de alias (para usar en rutas)
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'active' => \App\Http\Middleware\EnsureUserIsActive::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
```

### Laravel 10 (método anterior)

Edita `app/Http/Kernel.php`:

```php
<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's route middleware.
     *
     * @var array<string, class-string|string>
     */
    protected $middlewareAliases = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'precognitive' => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
        'signed' => \App\Http\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        
        // Middleware personalizados de CrucialEnglish
        'role' => \App\Http\Middleware\RoleMiddleware::class,
        'active' => \App\Http\Middleware\EnsureUserIsActive::class,
    ];
}
```

---

## 🛣️ Ejemplos de Uso en Rutas

### Archivo `routes/web.php`

```php
<?php

use App\Models\Role;
use Illuminate\Support\Facades\Route;

// ========================================
// 1. RUTAS PÚBLICAS (sin autenticación)
// ========================================
Route::get('/', [App\Http\Controllers\Public\HomeController::class, 'index'])
    ->name('home');

Route::get('/productos', [App\Http\Controllers\Public\ProductController::class, 'index'])
    ->name('products.index');

Route::get('/contacto', [App\Http\Controllers\Public\ContactController::class, 'create'])
    ->name('contact.create');

Route::post('/contacto', [App\Http\Controllers\Public\ContactController::class, 'store'])
    ->name('contact.store');


// ========================================
// 2. RUTAS DE AUTENTICACIÓN (Laravel Breeze)
// ========================================
require __DIR__.'/auth.php';


// ========================================
// 3. PANEL ADMINISTRADOR
// ========================================
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'active', 'role:'.Role::ADMIN])
    ->group(function () {
        
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
            ->name('dashboard');

        // Gestión de usuarios
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        
        // Gestión de productos
        Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
        
        // Gestión de grupos académicos
        Route::resource('academic-groups', App\Http\Controllers\Admin\AcademicGroupController::class);
        
        // Aprobación de materiales
        Route::get('/materials/pending', [App\Http\Controllers\Admin\MaterialController::class, 'pending'])
            ->name('materials.pending');
        Route::post('/materials/{material}/approve', [App\Http\Controllers\Admin\MaterialController::class, 'approve'])
            ->name('materials.approve');
        Route::post('/materials/{material}/reject', [App\Http\Controllers\Admin\MaterialController::class, 'reject'])
            ->name('materials.reject');
        
        // Aprobación de clases pregrabadas
        Route::get('/recorded-lessons/pending', [App\Http\Controllers\Admin\RecordedLessonController::class, 'pending'])
            ->name('recorded-lessons.pending');
        Route::post('/recorded-lessons/{recordedLesson}/approve', [App\Http\Controllers\Admin\RecordedLessonController::class, 'approve'])
            ->name('recorded-lessons.approve');
        Route::post('/recorded-lessons/{recordedLesson}/reject', [App\Http\Controllers\Admin\RecordedLessonController::class, 'reject'])
            ->name('recorded-lessons.reject');
    });


// ========================================
// 4. PANEL DOCENTE
// ========================================
Route::prefix('teacher')
    ->name('teacher.')
    ->middleware(['auth', 'active', 'role:'.Role::TEACHER])
    ->group(function () {
        
        Route::get('/dashboard', [App\Http\Controllers\Teacher\DashboardController::class, 'index'])
            ->name('dashboard');

        // Mis grupos
        Route::get('/my-groups', [App\Http\Controllers\Teacher\AcademicGroupController::class, 'index'])
            ->name('groups.index');
        Route::get('/my-groups/{academicGroup}', [App\Http\Controllers\Teacher\AcademicGroupController::class, 'show'])
            ->name('groups.show');
        
        // Sesiones de clase
        Route::resource('class-sessions', App\Http\Controllers\Teacher\ClassSessionController::class)
            ->only(['index', 'create', 'store', 'show', 'edit', 'update']);
        
        // Asistencia
        Route::get('/class-sessions/{classSession}/attendance', [App\Http\Controllers\Teacher\AttendanceController::class, 'edit'])
            ->name('attendance.edit');
        Route::put('/class-sessions/{classSession}/attendance', [App\Http\Controllers\Teacher\AttendanceController::class, 'update'])
            ->name('attendance.update');
        
        // Notas
        Route::resource('grades', App\Http\Controllers\Teacher\StudentGradeController::class);
        
        // Materiales (crear/editar propios)
        Route::resource('materials', App\Http\Controllers\Teacher\MaterialController::class);
        
        // Clases pregrabadas (crear/editar propias)
        Route::resource('recorded-lessons', App\Http\Controllers\Teacher\RecordedLessonController::class);
    });


// ========================================
// 5. PANEL ESTUDIANTE
// ========================================
Route::prefix('student')
    ->name('student.')
    ->middleware(['auth', 'active', 'role:'.Role::STUDENT])
    ->group(function () {
        
        Route::get('/dashboard', [App\Http\Controllers\Student\DashboardController::class, 'index'])
            ->name('dashboard');

        // Mis grupos
        Route::get('/my-groups', [App\Http\Controllers\Student\AcademicGroupController::class, 'index'])
            ->name('groups.index');
        Route::get('/my-groups/{academicGroup}', [App\Http\Controllers\Student\AcademicGroupController::class, 'show'])
            ->name('groups.show');
        
        // Mis notas
        Route::get('/grades', [App\Http\Controllers\Student\StudentGradeController::class, 'index'])
            ->name('grades.index');
        
        // Mi progreso académico
        Route::get('/progress', [App\Http\Controllers\Student\ProgressController::class, 'index'])
            ->name('progress.index');
        
        // Materiales disponibles
        Route::get('/materials', [App\Http\Controllers\Student\MaterialController::class, 'index'])
            ->name('materials.index');
        Route::get('/materials/{material}', [App\Http\Controllers\Student\MaterialController::class, 'show'])
            ->name('materials.show');
        Route::get('/materials/{material}/download', [App\Http\Controllers\Student\MaterialController::class, 'download'])
            ->name('materials.download');
        
        // Clases pregrabadas disponibles
        Route::get('/recorded-lessons', [App\Http\Controllers\Student\RecordedLessonController::class, 'index'])
            ->name('recorded-lessons.index');
        Route::get('/recorded-lessons/{recordedLesson}', [App\Http\Controllers\Student\RecordedLessonController::class, 'show'])
            ->name('recorded-lessons.show');
        
        // Carrito y compras
        Route::get('/cart', [App\Http\Controllers\Student\CartController::class, 'index'])
            ->name('cart.index');
        Route::post('/cart/add/{product}', [App\Http\Controllers\Student\CartController::class, 'add'])
            ->name('cart.add');
        Route::delete('/cart/remove/{product}', [App\Http\Controllers\Student\CartController::class, 'remove'])
            ->name('cart.remove');
        
        // Órdenes
        Route::get('/orders', [App\Http\Controllers\Student\OrderController::class, 'index'])
            ->name('orders.index');
        Route::post('/orders', [App\Http\Controllers\Student\OrderController::class, 'store'])
            ->name('orders.store');
        Route::get('/orders/{order}', [App\Http\Controllers\Student\OrderController::class, 'show'])
            ->name('orders.show');
        
        // Pago Webpay
        Route::post('/payments/webpay/init/{order}', [App\Http\Controllers\Student\PaymentController::class, 'initWebpay'])
            ->name('payments.webpay.init');
        Route::get('/payments/webpay/return', [App\Http\Controllers\Student\PaymentController::class, 'webpayReturn'])
            ->name('payments.webpay.return');
    });


// ========================================
// 6. RUTAS COMPARTIDAS (múltiples roles)
// ========================================
Route::middleware(['auth', 'active'])
    ->group(function () {
        
        // Perfil de usuario (todos los roles autenticados)
        Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])
            ->name('profile.edit');
        Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])
            ->name('profile.update');
        Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])
            ->name('profile.destroy');
        
        // Notificaciones
        Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])
            ->name('notifications.index');
        Route::post('/notifications/{notification}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])
            ->name('notifications.read');
    });
```

---

## 🔐 Lógica de Verificación

### Flujo de Autenticación y Autorización

1. **Usuario intenta acceder a una ruta protegida**
2. **Middleware `auth`** → Verifica si está autenticado
   - ❌ No autenticado → Redirige a `/login`
   - ✅ Autenticado → Continúa
3. **Middleware `active`** → Verifica si la cuenta está activa
   - ❌ Cuenta inactiva → Logout + redirige a login con mensaje
   - ✅ Cuenta activa → Continúa
4. **Middleware `role:xxx`** → Verifica si tiene el rol requerido
   - ❌ Sin permisos → Error 403
   - ✅ Con permisos → Acceso permitido

### Métodos Helper en User Model

```php
// Verificar un solo rol
$user->hasRole('administrador');           // bool

// Verificar cualquiera de varios roles
$user->hasAnyRole(['estudiante', 'docente']); // bool

// Verificar que tenga todos los roles
$user->hasAllRoles(['estudiante', 'docente']); // bool
```

---

## 🧪 Testing del Middleware

### Ejemplo de Test

```php
<?php

namespace Tests\Feature\Middleware;

use App\Models\User;
use App\Models\Role;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_admin_routes(): void
    {
        $admin = User::factory()->create();
        $adminRole = Role::factory()->create(['slug' => 'administrador']);
        $admin->roles()->attach($adminRole);

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
    }

    public function test_student_cannot_access_admin_routes(): void
    {
        $student = User::factory()->create();
        $studentRole = Role::factory()->create(['slug' => 'estudiante']);
        $student->roles()->attach($studentRole);

        $response = $this->actingAs($student)->get('/admin/dashboard');

        $response->assertStatus(403);
    }

    public function test_inactive_user_is_logged_out(): void
    {
        $user = User::factory()->create(['active' => false]);

        $response = $this->actingAs($user)->get('/student/dashboard');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}
```

---

## 📌 Notas Importantes

### Orden de Middleware
El orden de los middleware es importante:
```php
['auth', 'active', 'role:xxx']
```
1. Primero `auth` (verifica autenticación)
2. Luego `active` (verifica cuenta activa)
3. Finalmente `role` (verifica permisos)

### Múltiples Roles
Para permitir múltiples roles en una misma ruta:
```php
// Usando el middleware
->middleware('role:estudiante,docente')

// O usando Role constants
->middleware('role:'.Role::STUDENT.','.Role::TEACHER)
```

### Mensajes de Error Personalizados
Para personalizar los mensajes de error 403, edita `resources/views/errors/403.blade.php`.

### Redirecciones según Rol
Puedes crear un middleware adicional que redirija automáticamente según el rol activo:

```php
// app/Http/Middleware/RedirectByRole.php
public function handle(Request $request, Closure $next): Response
{
    if ($request->user()->hasRole(Role::ADMIN)) {
        return redirect()->route('admin.dashboard');
    }
    
    if ($request->user()->hasRole(Role::TEACHER)) {
        return redirect()->route('teacher.dashboard');
    }
    
    if ($request->user()->hasRole(Role::STUDENT)) {
        return redirect()->route('student.dashboard');
    }
    
    return $next($request);
}
```

---

## 🚀 Próximos Pasos

1. ✅ Middleware creados
2. ⏳ Registrar middleware en `bootstrap/app.php` (Laravel 11+) o `app/Http/Kernel.php` (Laravel 10)
3. ⏳ Definir rutas en `routes/web.php` con protección de roles
4. ⏳ Crear controladores correspondientes
5. ⏳ Implementar vistas personalizadas de error (403, 404, 500)
6. ⏳ Escribir tests para verificar autorización

---

**Última actualización:** 3 de agosto de 2026
