# Paso 1 - Instalación y Configuración de Autenticación

**Fecha:** 3 de agosto de 2026  
**Estado:** ✅ Completado

---

## 📦 Resumen de Implementación

Se ha implementado el sistema de autenticación completo adaptado a la estructura existente de CrucialEnglish, sin usar Laravel Breeze directamente pero siguiendo sus mejores prácticas.

### ✅ Archivos Creados

#### Migraciones (2)
- `database/migrations/2024_01_01_000001_create_password_reset_tokens_table.php`
- `database/migrations/2024_01_01_000002_create_sessions_table.php`

#### Controladores (5)
- `app/Http/Controllers/Auth/AuthenticatedSessionController.php` → Login/Logout
- `app/Http/Controllers/Auth/RegisteredUserController.php` → Registro
- `app/Http/Controllers/Auth/PasswordResetLinkController.php` → Solicitar reset
- `app/Http/Controllers/Auth/NewPasswordController.php` → Restablecer contraseña
- `app/Http/Controllers/Auth/RoleSelectorController.php` → Selector de rol multiusuario

#### Form Requests (1)
- `app/Http/Requests/Auth/LoginRequest.php` → Validación de login + verificación de cuenta activa

#### Vistas (6)
- `resources/views/layouts/guest.blade.php` → Layout para páginas de autenticación
- `resources/views/auth/login.blade.php` → Formulario de login
- `resources/views/auth/register.blade.php` → Formulario de registro
- `resources/views/auth/forgot-password.blade.php` → Solicitar recuperación
- `resources/views/auth/reset-password.blade.php` → Restablecer contraseña
- `resources/views/auth/select-role.blade.php` → Selector de contexto multirol

#### Rutas y Configuración (4)
- `routes/auth.php` → Rutas de autenticación
- `routes/web.php` → Rutas web principales
- `resources/views/welcome.blade.php` → Página de inicio
- `bootstrap/app.php` → Configuración de Laravel 11+ con middleware

---

## 🔑 Características Implementadas

### 1. Login con Validación de Cuenta Activa
- ✅ Valida credenciales (email + password)
- ✅ Rechaza login si `active = false` con mensaje claro
- ✅ Rate limiting (5 intentos por email/IP)
- ✅ Protección contra fuerza bruta

### 2. Registro de Usuario
- ✅ Crea usuario con `active = true` por defecto
- ✅ Validaciones: email único, contraseña mínima 8 caracteres
- ✅ Hash seguro de contraseña con bcrypt
- ✅ Mensajes en español

### 3. Recuperación de Contraseña
- ✅ Solicitud de enlace de recuperación
- ✅ Restablecimiento seguro con token temporal
- ✅ Validación de token y email

### 4. Selector de Contexto Multirol (Preparado)
- ✅ Si usuario tiene 1 solo rol → redirige directo a su panel
- ✅ Si usuario tiene múltiples roles → muestra selector con botones visuales
- ✅ Guarda rol activo en sesión: `session('active_role')`
- ✅ Validación que el usuario tenga el rol seleccionado

### 5. Middleware Configurados
- ✅ `role` → Verifica rol requerido
- ✅ `active` → Verifica cuenta activa
- ✅ Configurados en `bootstrap/app.php`

---

## 📋 Instrucciones de Instalación

### 1. Ejecutar Migraciones
```bash
cd c:\Users\galve\Documents\GitHub\CrucialEnglish
php artisan migrate
```

Esto creará las tablas:
- `password_reset_tokens` → Tokens de recuperación de contraseña
- `sessions` → Sesiones de usuarios (database driver)

### 2. Configurar Variables de Entorno

Editar `.env` para configurar la sesión y correo:

```env
# Configuración de sesión (usar database para sesiones persistentes)
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Configuración de correo (para recuperación de contraseña)
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hola@crucialenglish.com"
MAIL_FROM_NAME="${APP_NAME}"

# Timezone
APP_TIMEZONE=America/Santiago
```

### 3. Limpiar Cachés
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### 4. Generar App Key (si no existe)
```bash
php artisan key:generate
```

---

## 🧪 Pruebas Manuales

### Test 1: Registro de Nuevo Usuario
1. Ir a `http://localhost/register`
2. Completar formulario:
   - Nombre: "Juan Pérez"
   - Email: "juan@example.com"
   - Contraseña: "password123"
   - Confirmar contraseña: "password123"
3. Click en "Registrarse"
4. ✅ **Esperado:** Usuario creado con `active = true`, redirige a dashboard

### Test 2: Login con Credenciales Válidas
1. Ir a `http://localhost/login`
2. Email: "juan@example.com"
3. Contraseña: "password123"
4. Click "Iniciar Sesión"
5. ✅ **Esperado:** Login exitoso, redirige según rol

### Test 3: Login con Cuenta Inactiva
1. En BD, cambiar `active = false` para el usuario
2. Intentar login
3. ✅ **Esperado:** Error "Tu cuenta está inactiva. Contacta al administrador."

### Test 4: Login con Credenciales Incorrectas
1. Email: "juan@example.com"
2. Contraseña incorrecta
3. ✅ **Esperado:** Error "Las credenciales proporcionadas no coinciden"

### Test 5: Recuperación de Contraseña
1. Ir a `http://localhost/forgot-password`
2. Ingresar email registrado
3. ✅ **Esperado:** Mensaje "Enlace enviado" (revisar logs si no hay servidor SMTP)

### Test 6: Selector de Rol (Si usuario tiene múltiples roles)
1. En BD, asignar múltiples roles a un usuario en `user_roles`
2. Hacer login
3. ✅ **Esperado:** Muestra selector con tarjetas de roles disponibles
4. Seleccionar un rol
5. ✅ **Esperado:** Redirige al dashboard correspondiente

---

## ⚙️ Verificaciones en Base de Datos

### Verificar Migraciones Ejecutadas
```sql
SELECT * FROM migrations ORDER BY id DESC LIMIT 5;
```

### Verificar Usuario Creado
```sql
SELECT id, name, email, active, created_at FROM users WHERE email = 'juan@example.com';
```

### Verificar Sesiones Activas
```sql
SELECT * FROM sessions ORDER BY last_activity DESC;
```

---

## 🔧 Adaptaciones Realizadas

### 1. Tabla `users` Existente
✅ No se modificó la tabla `users` existente  
✅ Se respetaron columnas personalizadas: `active`, `deleted_at`

### 2. LoginRequest Personalizado
✅ Validación adicional de `active = true`  
✅ Logout automático si cuenta inactiva  
✅ Mensajes en español

### 3. RegisteredUserController Adaptado
✅ Establece `active = true` por defecto  
✅ Verifica email único en tabla `users`  
✅ Hash seguro con `Hash::make()`

### 4. Selector de Rol Implementado
✅ Lógica en `AuthenticatedSessionController::store()`  
✅ Controlador dedicado `RoleSelectorController`  
✅ Vista con botones visuales por rol  
✅ Guarda rol activo en sesión

---

## 🚨 Pendientes para Pasos Siguientes

### Paso 2 (Próximo)
- [ ] Modificar `RegisteredUserController::store()` para:
  - [ ] Crear `StudentProfile` en transacción
  - [ ] Asignar rol "Estudiante" automáticamente en `user_roles`
  - [ ] Enviar email de bienvenida
  
### Paso 3
- [ ] Implementar cambio de rol activo sin cerrar sesión (`POST /switch-role`)
- [ ] Agregar dropdown en navbar para cambiar rol

### Paso 4
- [ ] Crear `EnsureActiveRoleMatches` middleware
- [ ] Validar que `session('active_role')` coincida con roles reales en BD

---

## 📚 Referencias

- [Laravel 11 Authentication](https://laravel.com/docs/11.x/authentication)
- [Laravel 11 Middleware](https://laravel.com/docs/11.x/middleware)
- [Bootstrap 5](https://getbootstrap.com/docs/5.3/)

---

**Última actualización:** 3 de agosto de 2026  
**Estado:** Paso 1 completado ✅  
**Siguiente:** Paso 2 - Registro de Estudiante con Perfil y Rol
