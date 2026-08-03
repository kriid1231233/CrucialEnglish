# CrucialEnglish

> Plataforma web integral para instituto de inglés - Sistema de gestión académica y comercial

[![Laravel](https://img.shields.io/badge/Laravel-13.x-red)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3+-blue)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange)](https://www.mysql.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple)](https://getbootstrap.com)

---

## 📋 Descripción del Proyecto

**CrucialEnglish** es una plataforma web desarrollada a medida para un instituto de inglés, diseñada para unificar:

- ✅ Sitio público institucional
- ✅ Venta de productos académicos (clases, materiales, suscripciones)
- ✅ Gestión académica (grupos, asistencia, notas, progresión de niveles)
- ✅ Paneles diferenciados por rol (Estudiante, Docente, Administrador)
- ✅ Integración con pasarela de pagos Webpay Plus

**Objetivo:** Profesionalizar la presencia digital del instituto y automatizar su operación académica y comercial.

---

## 🎯 Características Principales

### Para Estudiantes
- Compra de clases individuales, grupales, materiales y suscripciones
- Acceso inmediato a contenido tras confirmación de pago
- Visualización de agenda de clases, asistencia y notas
- Historial académico completo
- Notificaciones internas y por correo

### Para Docentes
- Gestión de grupos de estudiantes
- Programación de clases y registro de asistencia
- Carga de materiales de apoyo y clases pregrabadas
- Registro de evaluaciones (escala 1.0 - 7.0)
- Envío de avisos a estudiantes

### Para Administradores
- Control total de usuarios, roles y permisos
- Gestión de productos, niveles y precios
- Aprobación/publicación de contenido docente
- Supervisión de pagos y transacciones
- Configuración general del sistema

---

## 🛠️ Stack Tecnológico

### Backend
- **PHP 8.3+**
- **Laravel 13.x**
- **MySQL 8.0+**

### Frontend
- **Blade** (motor de plantillas)
- **Bootstrap 5**
- **JavaScript / Alpine.js**

### Herramientas de Desarrollo
- **XAMPP** (servidor local)
- **Composer** (gestor de dependencias)
- **Git + GitHub** (control de versiones)
- **Visual Studio Code** (editor)

### Integraciones
- **Webpay Plus** (Transbank) - Pasarela de pagos
- **SMTP** - Envío de correos electrónicos

---

## 📚 Documentación

La documentación completa del proyecto está organizada en la carpeta [`docs/`](docs/):

| Documento | Descripción |
|-----------|-------------|
| [**00-INDICE-DOCUMENTACION.md**](docs/00-INDICE-DOCUMENTACION.md) | Índice general de toda la documentación |
| [**01-RESUMEN-EJECUTIVO.md**](docs/01-RESUMEN-EJECUTIVO.md) | Visión general del proyecto, objetivos, alcance |
| [**02-MODULOS-MVP.md**](docs/02-MODULOS-MVP.md) | Definición de módulos del MVP y arquitectura |
| [**03-REQUERIMIENTOS-FUNCIONALES.md**](docs/03-REQUERIMIENTOS-FUNCIONALES.md) | Requerimientos funcionales detallados por módulo |
| [**04-HERRAMIENTAS-DESARROLLO.md**](docs/04-HERRAMIENTAS-DESARROLLO.md) | Stack tecnológico y configuración del entorno |

**Próximos documentos (en desarrollo):**
- Modelo de Base de Datos (DER)
- Diccionario de Datos
- Plan de Migraciones
- Guía de Desarrollo por Módulo
- Manual de Despliegue

---

## 🚀 Estado del Proyecto

**Fase actual:** Análisis y Diseño  
**Versión:** 0.1.0 (Pre-MVP)

### Roadmap

- [x] **Fase 0:** Análisis y diseño funcional
- [x] Definición de requerimientos
- [x] Diseño de módulos del MVP
- [x] Documentación del stack tecnológico
- [ ] **Fase 1:** Diseño de base de datos
- [ ] Modelado de entidades (DER)
- [ ] Diccionario de datos
- [ ] Migraciones de Laravel
- [ ] **Fase 2:** Setup del proyecto
- [ ] Inicialización de Laravel
- [ ] Configuración de entorno local
- [ ] Estructura de carpetas
- [ ] **Fase 3:** Desarrollo del MVP (módulos)
- [ ] Módulo Público
- [ ] Módulo Identidad y Roles
- [ ] Módulo Catálogo
- [ ] Módulo Comercial
- [ ] Módulo Académico
- [ ] Módulo Contenido
- [ ] Módulo Paneles
- [ ] Módulo Notificaciones
- [ ] **Fase 4:** Testing y ajustes
- [ ] **Fase 5:** Despliegue en producción

---

## 📦 Instalación (Próximamente)

> Esta sección se completará cuando se inicialice el proyecto Laravel.

```bash
# Clonar repositorio
git clone https://github.com/usuario/crucial-english.git
cd crucial-english

# Instalar dependencias PHP
composer install

# Instalar dependencias JS
npm install

# Configurar entorno
cp .env.example .env
php artisan key:generate

# Configurar base de datos en .env
# Ejecutar migraciones
php artisan migrate --seed

# Iniciar servidor de desarrollo
php artisan serve
```

---

## 🧪 Testing (Próximamente)

```bash
# Ejecutar todos los tests
php artisan test

# Ejecutar tests con coverage
php artisan test --coverage
```

---

## 👥 Roles del Sistema

| Rol | Descripción |
|-----|-------------|
| **Invitado** | Usuario no autenticado (acceso al sitio público) |
| **Estudiante** | Alumno del instituto (compras, materiales, historial) |
| **Docente** | Profesor (gestión de grupos, contenido, evaluaciones) |
| **Administrador** | Personal administrativo (control total del sistema) |

---

## 🔐 Seguridad

- Autenticación mediante Laravel Breeze
- Autorización basada en roles y políticas (Laravel Policies)
- Protección contra CSRF, XSS, SQL Injection
- Validación de acceso a archivos privados
- HTTPS obligatorio en producción

---

## 📧 Contacto

**Proyecto:** CrucialEnglish  
**Repositorio:** [github.com/usuario/crucial-english](https://github.com/usuario/crucial-english)  
**Documentación:** Ver carpeta `docs/`

---

## 📄 Licencia

Este es un proyecto privado desarrollado a medida para un instituto de inglés específico.  
Todos los derechos reservados © 2026 CrucialEnglish

---

## 🙏 Agradecimientos

- **Laravel Community** por el excelente framework
- **Bootstrap Team** por el framework CSS
- **Transbank** por la documentación de Webpay Plus

---

**Última actualización:** 27 de julio de 2026  
**Estado:** En fase de análisis y diseño
