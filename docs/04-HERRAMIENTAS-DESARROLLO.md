# Herramientas de Desarrollo - CrucialEnglish

**Versión:** 1.0  
**Fecha:** 27 de julio de 2026  
**Objetivo:** Definir el entorno de desarrollo, herramientas y configuraciones necesarias para el proyecto

---

## 1. Introducción

Este documento define el **stack tecnológico completo**, las **herramientas de desarrollo** y las **configuraciones de entorno** necesarias para implementar CrucialEnglish de manera profesional, escalable y mantenible.

---

## 2. Stack Tecnológico

### 2.1 Backend

| Tecnología | Versión | Propósito |
|------------|---------|-----------|
| **PHP** | 8.3+ | Lenguaje de programación principal |
| **Laravel** | 13.x | Framework web MVC |
| **Composer** | 2.x | Gestor de dependencias PHP |

**¿Por qué Laravel?**
- **Ecosistema maduro:** Autenticación, autorización, ORM, migraciones, testing
- **Eloquent ORM:** Mapeo objeto-relacional intuitivo y potente
- **Blade:** Motor de plantillas elegante y eficiente
- **Laravel Mix/Vite:** Compilación de assets frontend
- **Laravel Queues:** Procesamiento de tareas en background
- **Laravel Notifications:** Sistema multicanal (database, email)
- **Comunidad activa:** Documentación excelente, paquetes abundantes
- **Seguridad:** Protección contra CSRF, XSS, SQL Injection por defecto

---

### 2.2 Frontend

| Tecnología | Versión | Propósito |
|------------|---------|-----------|
| **Blade** | (Laravel) | Motor de plantillas del backend |
| **Bootstrap** | 5.3+ | Framework CSS responsive |
| **JavaScript** | ES6+ | Interactividad del lado del cliente |
| **Alpine.js** | 3.x (opcional) | Framework JS ligero para interacciones reactivas |

**¿Por qué Blade + Bootstrap?**
- **Simplicidad:** No requiere framework JS pesado (React, Vue) para el MVP
- **Productividad:** Blade se integra nativamente con Laravel
- **Responsive:** Bootstrap 5 ofrece componentes listos para móvil
- **Escalabilidad futura:** Si se requiere SPA, se puede migrar a Vue/React manteniendo Laravel como API

**Alpine.js (Opcional):**
- Para interacciones ligeras sin jQuery (dropdowns, modales, validaciones)
- Sintaxis declarativa similar a Vue.js
- Solo ~15 KB gzipped

---

### 2.3 Base de Datos

| Tecnología | Versión | Propósito |
|------------|---------|-----------|
| **MySQL** | 8.0+ | Base de datos relacional |
| **XAMPP** | 8.2+ | Servidor local (Apache, PHP, MySQL) |
| **MySQL Workbench** | 8.0+ | Cliente visual para modelado y consultas |

**¿Por qué MySQL?**
- **Madurez:** Base de datos relacional estable y probada
- **Compatibilidad:** Excelente soporte en Laravel
- **Hosting:** Amplia disponibilidad en proveedores de hosting
- **Gratuito:** Open source y sin costo de licencia

**XAMPP vs Laravel Valet/Herd:**
- **XAMPP:** Fácil de instalar en Windows, todo en uno (Apache, PHP, MySQL)
- **Laravel Herd:** Alternativa moderna y ligera (solo Windows/macOS)
- Para este proyecto: XAMPP es suficiente y más accesible

---

### 2.4 Control de Versiones

| Herramienta | Propósito |
|-------------|-----------|
| **Git** | Control de versiones distribuido |
| **GitHub** | Repositorio remoto, colaboración, CI/CD |

**Estrategia de Branching (Recomendada):**
- **`main`:** Código en producción (protegida)
- **`develop`:** Rama de integración principal
- **`feature/nombre-funcionalidad`:** Ramas para cada funcionalidad
- **`hotfix/nombre-issue`:** Para correcciones urgentes en producción

**Commits:**
- Mensajes descriptivos en español
- Formato: `tipo: descripción` (ej. `feat: agregar carrito de compras`)
- Tipos: `feat`, `fix`, `docs`, `refactor`, `test`

---

## 3. Entorno de Desarrollo Local

### 3.1 Requisitos del Sistema

**Windows 10/11:**
- Procesador de 64 bits
- 4 GB RAM mínimo (8 GB recomendado)
- 10 GB de espacio en disco

---

### 3.2 Instalación de Herramientas Base

#### 3.2.1 XAMPP
1. Descargar desde: https://www.apachefriends.org/
2. Versión recomendada: PHP 8.3+
3. Instalar en `C:\xampp`
4. Iniciar Apache y MySQL desde el panel de control de XAMPP

**Configuración de PHP:**
- Editar `C:\xampp\php\php.ini`
- Habilitar extensiones necesarias:
  ```ini
  extension=fileinfo
  extension=gd
  extension=mbstring
  extension=openssl
  extension=pdo_mysql
  extension=curl
  extension=zip
  ```
- Ajustar límites de upload:
  ```ini
  upload_max_filesize = 20M
  post_max_size = 20M
  max_execution_time = 300
  memory_limit = 256M
  ```

---

#### 3.2.2 Composer
1. Descargar desde: https://getcomposer.org/download/
2. Ejecutar el instalador (seleccionar PHP de XAMPP: `C:\xampp\php\php.exe`)
3. Verificar instalación:
   ```bash
   composer --version
   ```

---

#### 3.2.3 Git
1. Descargar desde: https://git-scm.com/download/win
2. Instalar con opciones por defecto
3. Configurar usuario global:
   ```bash
   git config --global user.name "Tu Nombre"
   git config --global user.email "tu@email.com"
   ```

---

#### 3.2.4 Visual Studio Code
1. Descargar desde: https://code.visualstudio.com/
2. Instalar extensiones recomendadas:
   - **PHP Intelephense** (autocompletado PHP)
   - **Laravel Extension Pack** (snippets, blade syntax)
   - **GitLens** (visualización avanzada de Git)
   - **ESLint** (linting de JavaScript)
   - **Prettier** (formateo de código)
   - **Thunder Client** (testing de APIs, alternativa a Postman)
   - **MySQL** (cliente MySQL integrado)

**Configuración recomendada (`settings.json`):**
```json
{
  "editor.formatOnSave": true,
  "editor.tabSize": 4,
  "php.suggest.basic": false,
  "intelephense.format.braces": "k&r",
  "[blade]": {
    "editor.defaultFormatter": "shufo.vscode-blade-formatter"
  },
  "files.associations": {
    "*.blade.php": "blade"
  }
}
```

---

#### 3.2.5 MySQL Workbench (Opcional)
1. Descargar desde: https://dev.mysql.com/downloads/workbench/
2. Conectar a servidor local:
   - Host: `localhost` o `127.0.0.1`
   - Puerto: `3306`
   - Usuario: `root`
   - Contraseña: (vacía en XAMPP por defecto)

**Uso recomendado:**
- Diseño visual del modelo de datos (DER)
- Ejecución de consultas SQL complejas
- Exportación/importación de bases de datos

---

### 3.3 Inicialización del Proyecto Laravel

#### 3.3.1 Crear Proyecto
```bash
cd C:\xampp\htdocs
composer create-project laravel/laravel crucial-english
cd crucial-english
```

#### 3.3.2 Configurar Base de Datos
1. Crear base de datos en MySQL:
   ```sql
   CREATE DATABASE crucial_english CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

2. Configurar archivo `.env`:
   ```env
   APP_NAME=CrucialEnglish
   APP_ENV=local
   APP_DEBUG=true
   APP_URL=http://localhost/crucial-english/public
   APP_TIMEZONE=America/Santiago

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=crucial_english
   DB_USERNAME=root
   DB_PASSWORD=
   ```

#### 3.3.3 Generar Application Key
```bash
php artisan key:generate
```

#### 3.3.4 Verificar Instalación
```bash
php artisan serve
```
Abrir navegador en: http://localhost:8000

---

## 4. Dependencias del Proyecto

### 4.1 Paquetes de Composer (Backend)

#### 4.1.1 Autenticación
```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
php artisan migrate
npm install && npm run dev
```

**¿Por qué Breeze?**
- Scaffold de autenticación ligero y personalizable
- Alternativas: Laravel Jetstream (más complejo), Laravel UI (legacy)

---

#### 4.1.2 Autorización (Opcional: Spatie Permission)
```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

**¿Por qué Spatie Permission?**
- Gestión avanzada de roles y permisos
- Para MVP: puede manejarse con Policies de Laravel
- Recomendado si se necesita flexibilidad futura

---

#### 4.1.3 Integración con Webpay Plus
```bash
composer require transbank/transbank-sdk
```

**Documentación:**
- https://github.com/TransbankDevelopers/transbank-sdk-php
- Ambiente de integración (desarrollo): https://www.transbankdevelopers.cl/
- Requiere credenciales de comercio (obtener en producción)

---

#### 4.1.4 Generación de PDFs (Opcional)
```bash
composer require barryvdh/laravel-dompdf
```

**Uso:** Comprobantes de pago, certificados (Fase 2+)

---

#### 4.1.5 Debugging
```bash
composer require barryvdh/laravel-debugbar --dev
```

**Uso:** Barra de debugging con queries SQL, logs, variables de sesión

---

### 4.2 Paquetes de NPM (Frontend)

#### 4.2.1 Bootstrap 5
```bash
npm install bootstrap @popperjs/core
```

#### 4.2.2 Alpine.js (Opcional)
```bash
npm install alpinejs
```

#### 4.2.3 Configuración de Vite
Editar `resources/js/app.js`:
```javascript
import './bootstrap';
import 'bootstrap';
// Si usas Alpine.js:
// import Alpine from 'alpinejs';
// window.Alpine = Alpine;
// Alpine.start();
```

Editar `resources/css/app.css`:
```css
@import 'bootstrap/dist/css/bootstrap.min.css';
```

Compilar assets:
```bash
npm run dev
```

---

## 5. Estructura de Carpetas del Proyecto

```
crucial-english/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/              # Autenticación (Breeze)
│   │   │   ├── Admin/             # Controladores del administrador
│   │   │   ├── Teacher/           # Controladores del docente
│   │   │   ├── Student/           # Controladores del estudiante
│   │   │   └── PublicController.php
│   │   ├── Middleware/
│   │   │   └── RoleMiddleware.php # Middleware personalizado de roles
│   │   └── Requests/              # Form Requests para validación
│   ├── Models/
│   │   ├── User.php
│   │   ├── Role.php
│   │   ├── StudentProfile.php
│   │   ├── TeacherProfile.php
│   │   ├── Level.php
│   │   ├── Product.php
│   │   ├── Order.php
│   │   ├── Group.php
│   │   ├── Material.php
│   │   └── ...
│   ├── Policies/                  # Políticas de autorización
│   ├── Notifications/             # Notificaciones personalizadas
│   ├── Events/                    # Eventos del sistema
│   └── Listeners/                 # Listeners de eventos
├── database/
│   ├── migrations/                # Migraciones de BD
│   ├── seeders/                   # Datos de prueba
│   └── factories/                 # Factories para testing
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php     # Layout base
│   │   │   ├── student.blade.php # Layout estudiante
│   │   │   ├── teacher.blade.php # Layout docente
│   │   │   └── admin.blade.php   # Layout admin
│   │   ├── auth/                  # Vistas de autenticación
│   │   ├── public/                # Vistas públicas
│   │   ├── student/               # Vistas del estudiante
│   │   ├── teacher/               # Vistas del docente
│   │   └── admin/                 # Vistas del administrador
│   ├── js/
│   │   └── app.js
│   └── css/
│       └── app.css
├── routes/
│   ├── web.php                    # Rutas web principales
│   ├── auth.php                   # Rutas de autenticación (Breeze)
│   └── api.php                    # Rutas API (futuro)
├── storage/
│   └── app/
│       └── private/
│           ├── materials/         # Materiales de apoyo
│           └── videos/            # Videos (si se suben localmente)
├── public/
│   ├── index.php
│   └── assets/                    # Assets públicos (imágenes institucionales)
├── tests/
│   ├── Feature/                   # Tests de integración
│   └── Unit/                      # Tests unitarios
├── .env                           # Configuración de entorno
├── composer.json
├── package.json
└── README.md
```

---

## 6. Configuración de Testing

### 6.1 PHPUnit (Testing en Laravel)

**Configuración básica (`phpunit.xml`):**
```xml
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
```

**Ejecutar tests:**
```bash
php artisan test
```

**Estructura de tests:**
- **Feature:** Testing de rutas, controladores, integración
- **Unit:** Testing de métodos individuales, lógica de negocio

**Ejemplo de test básico:**
```php
// tests/Feature/ProductTest.php
public function test_estudiante_puede_ver_catalogo()
{
    $response = $this->actingAs($estudiante)->get('/products');
    $response->assertStatus(200);
    $response->assertSee('Catálogo de Productos');
}
```

---

### 6.2 Laravel Dusk (Testing de Navegador - Opcional)
```bash
composer require --dev laravel/dusk
php artisan dusk:install
```

**Uso:** Testing end-to-end con navegador real (Chrome)

---

## 7. Herramientas Adicionales

### 7.1 Postman / Thunder Client
- **Postman:** https://www.postman.com/downloads/
- **Thunder Client:** Extensión de VS Code (más ligero)

**Uso:** Testing de endpoints API (futuro), validación de integraciones (Webpay Plus)

---

### 7.2 Mailtrap (Testing de Correos en Desarrollo)
1. Crear cuenta en: https://mailtrap.io/
2. Configurar `.env`:
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=sandbox.smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=tu_username
   MAIL_PASSWORD=tu_password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=noreply@crucialenglish.cl
   MAIL_FROM_NAME="${APP_NAME}"
   ```

**Ventaja:** Captura correos sin enviarlos realmente (ideal para desarrollo)

---

### 7.3 Laravel Telescope (Monitoring - Opcional)
```bash
composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate
```

**Acceso:** http://localhost:8000/telescope

**Uso:** Monitoreo de requests, queries, jobs, notificaciones en desarrollo

---

## 8. Flujo de Trabajo Recomendado

### 8.1 Inicio de Sesión de Desarrollo
1. Iniciar XAMPP (Apache y MySQL)
2. Abrir VS Code con el proyecto
3. Abrir terminal integrada
4. Ejecutar servidor de desarrollo:
   ```bash
   php artisan serve
   ```
5. En otra terminal, compilar assets en watch mode:
   ```bash
   npm run dev
   ```
6. Abrir navegador en: http://localhost:8000

---

### 8.2 Crear Nueva Funcionalidad
1. Crear rama de feature:
   ```bash
   git checkout -b feature/nombre-funcionalidad
   ```
2. Crear migración si es necesario:
   ```bash
   php artisan make:migration create_tabla_table
   php artisan migrate
   ```
3. Crear modelo:
   ```bash
   php artisan make:model NombreModelo
   ```
4. Crear controlador:
   ```bash
   php artisan make:controller NombreController
   ```
5. Implementar lógica, vistas, rutas
6. Crear tests:
   ```bash
   php artisan make:test NombreFuncionalidadTest
   ```
7. Ejecutar tests:
   ```bash
   php artisan test
   ```
8. Commit y push:
   ```bash
   git add .
   git commit -m "feat: agregar funcionalidad de X"
   git push origin feature/nombre-funcionalidad
   ```
9. Crear Pull Request en GitHub
10. Revisar, aprobar y mergear a `develop`

---

## 9. Comandos Útiles de Laravel

| Comando | Descripción |
|---------|-------------|
| `php artisan serve` | Iniciar servidor de desarrollo |
| `php artisan migrate` | Ejecutar migraciones pendientes |
| `php artisan migrate:rollback` | Revertir última migración |
| `php artisan migrate:fresh --seed` | Resetear BD y ejecutar seeders |
| `php artisan make:model NombreModelo -m` | Crear modelo + migración |
| `php artisan make:controller NombreController` | Crear controlador |
| `php artisan route:list` | Listar todas las rutas |
| `php artisan tinker` | REPL para interactuar con el código |
| `php artisan queue:work` | Procesar jobs en cola |
| `php artisan schedule:run` | Ejecutar tareas programadas (cron) |
| `php artisan test` | Ejecutar tests |
| `php artisan optimize:clear` | Limpiar cachés (config, rutas, vistas) |

---

## 10. Configuración de Colas (Laravel Queue)

**Para procesamiento de tareas en background (correos, notificaciones):**

1. Configurar `.env`:
   ```env
   QUEUE_CONNECTION=database
   ```

2. Crear tabla de jobs:
   ```bash
   php artisan queue:table
   php artisan migrate
   ```

3. Ejecutar worker:
   ```bash
   php artisan queue:work
   ```

**En producción:** Usar supervisor o similar para mantener worker corriendo

---

## 11. Seguridad

### 11.1 Variables de Entorno
- **NUNCA** subir `.env` a Git
- Usar `.env.example` como plantilla
- Regenerar `APP_KEY` en producción:
  ```bash
  php artisan key:generate
  ```

### 11.2 HTTPS en Producción
- Certificado SSL obligatorio (Let's Encrypt gratuito)
- Configurar `APP_URL` con `https://`

### 11.3 Validación de Datos
- Usar **Form Requests** en todos los controladores
- Nunca confiar en datos del cliente
- Sanitizar inputs con `strip_tags()` o `htmlspecialchars()` cuando sea necesario

---

## 12. Deployment (Producción)

### 12.1 Hosting Recomendado
- **Heroku** (fácil, con plan gratuito limitado)
- **DigitalOcean** (VPS con mayor control)
- **Laravel Forge** (automatización de deployment para Laravel)
- **Hostinger / SiteGround** (hosting compartido económico con soporte PHP)

### 12.2 Checklist de Deployment
- [ ] Configurar `.env` de producción
- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] Ejecutar `php artisan migrate --force`
- [ ] Ejecutar `php artisan optimize`
- [ ] Configurar cron para Laravel Scheduler:
  ```bash
  * * * * * cd /path-to-app && php artisan schedule:run >> /dev/null 2>&1
  ```
- [ ] Configurar supervisor para Laravel Queue
- [ ] Configurar SMTP de producción (SendGrid, Mailgun)
- [ ] Activar credenciales de producción de Webpay Plus
- [ ] Configurar backups automáticos de base de datos

---

## 13. Próximos Pasos

1. ✅ **Revisar y validar estas herramientas con el equipo de desarrollo**
2. ⏳ Instalar todas las herramientas en el entorno local
3. ⏳ Inicializar proyecto Laravel
4. ⏳ Crear repositorio en GitHub
5. ⏳ Configurar base de datos local
6. ⏳ Crear primeras migraciones
7. ⏳ Comenzar implementación del MVP

---

**Documento preparado por:** Arquitecto de Software Senior  
**Revisión requerida por:** Equipo de Desarrollo  
**Próxima entrega:** Modelo de Base de Datos (DER) y Plan de Migraciones
