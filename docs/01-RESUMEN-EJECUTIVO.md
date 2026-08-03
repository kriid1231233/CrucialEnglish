# Resumen Ejecutivo - CrucialEnglish

**Versión:** 1.0  
**Fecha:** 27 de julio de 2026  
**Estado:** Fase de Análisis y Diseño  

---

## 1. Introducción

**CrucialEnglish** es una plataforma web integral desarrollada a medida para un instituto de inglés, diseñada para unificar la presencia institucional, la operación académica, la gestión administrativa y la venta de productos educativos en un solo ecosistema digital.

A diferencia de soluciones CMS tradicionales (WordPress, Moodle), CrucialEnglish se construirá desde cero con **Laravel 13**, privilegiando control total sobre el modelo de datos, lógica de negocio compleja y escalabilidad a largo plazo.

---

## 2. Problema que Resuelve

### 2.1 Situación Actual
Los institutos de inglés frecuentemente operan con:
- Sitios web estáticos o desactualizados
- Procesos manuales para inscripciones y pagos
- Gestión académica fragmentada (Excel, WhatsApp, correos)
- Falta de trazabilidad del historial del estudiante
- Coordinación docente ineficiente
- Experiencia de usuario inconsistente

### 2.2 Oportunidad
El proyecto CrucialEnglish identifica la necesidad de:
- **Centralizar** toda la operación en una plataforma única
- **Automatizar** flujos de compra, acceso y notificaciones
- **Profesionalizar** la imagen digital del instituto
- **Mejorar** la experiencia de estudiantes, docentes y administradores
- **Escalar** el negocio con herramientas propias y mantenibles

---

## 3. Objetivos del Proyecto

### 3.1 Objetivo General
Crear una plataforma web escalable y mantenible que integre presencia institucional, venta de productos académicos y gestión operativa completa para estudiantes, docentes y administración del instituto CrucialEnglish.

### 3.2 Objetivos Específicos

#### Comercial
- Permitir venta online de clases individuales, grupales, materiales y suscripciones
- Automatizar habilitación de accesos tras confirmación de pago
- Soportar múltiples modalidades de cobro (mensual, por clase, paquetes, ofertas)
- Integrar pasarela de pago Webpay Plus (Transbank)

#### Académico
- Organizar cursos por niveles (A1, A2, B1, B2, C1, C2)
- Gestionar grupos de estudiantes con flexibilidad de reasignación
- Registrar asistencia, notas (escala 1.0-7.0) e historial académico
- Coordinar agenda de clases entre docentes y estudiantes

#### Operacional
- Proveer paneles diferenciados por rol (Estudiante, Docente, Administrador)
- Facilitar gestión docente (grupos, materiales, avisos, evaluaciones)
- Centralizar supervisión administrativa (usuarios, contenido, pagos, aprobaciones)
- Mantener comunicación interna y por correo electrónico

#### Técnico
- Construir una arquitectura escalable y mantenible
- Asegurar integridad de datos y trazabilidad completa
- Implementar control de accesos robusto basado en roles y permisos
- Garantizar operación en zona horaria de Chile (America/Santiago)

---

## 4. Alcance del Proyecto

### 4.1 Dentro del Alcance (MVP)

**Módulo Público**
- Sitio institucional con información del instituto
- Catálogo de productos y servicios
- Registro e inicio de sesión

**Módulo Estudiante**
- Compra de productos académicos
- Acceso a materiales y clases pregrabadas adquiridos
- Visualización de agenda, asistencia, notas e historial
- Recepción de notificaciones

**Módulo Docente**
- Gestión de grupos y estudiantes
- Carga de materiales y clases pregrabadas (sujeto a aprobación)
- Registro de asistencia y notas
- Envío de avisos y recordatorios

**Módulo Administrador**
- Gestión de usuarios y roles
- Control de productos, ofertas y precios
- Supervisión de pagos y accesos
- Aprobación/publicación de contenido
- Configuración general del sistema

**Módulo Académico**
- Niveles, grupos y asignaciones
- Agenda de clases
- Historial académico completo

**Módulo Comercial**
- Catálogo de productos
- Carrito de compras
- Integración con Webpay Plus
- Gestión de órdenes y pagos

### 4.2 Fuera del Alcance (Fase Inicial)
- Aplicación móvil nativa
- Sistema de videollamadas integrado
- Chat en tiempo real entre usuarios
- Integración con plataformas externas (Google Classroom, Zoom API)
- Sistema de certificaciones digitales con firma electrónica
- Reportería avanzada/Business Intelligence
- API pública para terceros

### 4.3 Futuras Fases (Roadmap Tentativo)
- **Fase 2:** Reportería avanzada y dashboard analítico
- **Fase 3:** Sistema de certificaciones digitales
- **Fase 4:** API RESTful para integraciones externas
- **Fase 5:** Aplicación móvil (React Native / Flutter)

---

## 5. Usuarios del Sistema

### 5.1 Roles Principales

| Rol | Descripción | Acceso Principal |
|-----|-------------|-----------------|
| **Invitado** | Usuario no autenticado | Sitio público, catálogo, registro |
| **Estudiante** | Alumno del instituto | Compras, materiales, agenda, historial |
| **Docente** | Profesor del instituto | Gestión de grupos, contenido, evaluaciones |
| **Administrador** | Personal administrativo | Control total del sistema |

### 5.2 Modelo de Roles
- Un usuario puede tener **múltiples roles** (ejemplo: una persona puede ser docente y estudiante)
- Al iniciar sesión con múltiples roles, se solicita **selección de contexto**
- Los perfiles de estudiante y docente se mantienen **separados** en la base de datos
- El sistema usa tabla intermedia `user_roles` para gestión flexible

---

## 6. Propuesta de Valor

### 6.1 Para el Instituto
- **Automatización** de procesos manuales repetitivos
- **Profesionalización** de la imagen digital
- **Control total** sobre datos y lógica de negocio
- **Escalabilidad** sin limitaciones de CMS
- **Trazabilidad** completa de operaciones académicas y comerciales

### 6.2 Para Estudiantes
- Compra y acceso **inmediato** a productos
- Visibilidad **centralizada** de su recorrido académico
- Comunicación **directa** con docentes y administración
- Experiencia de usuario **moderna** y profesional

### 6.3 Para Docentes
- Herramientas **centralizadas** para gestión de grupos
- Carga y organización **simplificada** de materiales
- Registro **eficiente** de asistencia y evaluaciones
- **Autonomía operativa** con supervisión administrativa

### 6.4 Para Administradores
- **Visibilidad total** de la operación
- Control **granular** de usuarios, contenido y permisos
- Supervisión **en tiempo real** de ventas y accesos
- **Trazabilidad** de decisiones y cambios

---

## 7. Stack Tecnológico

### 7.1 Backend
- **PHP 8.3+** (lenguaje)
- **Laravel 13** (framework)
- **Composer** (gestor de dependencias)

### 7.2 Frontend
- **Blade** (motor de plantillas de Laravel)
- **Bootstrap 5** (framework CSS)
- **JavaScript vanilla** o Alpine.js (interactividad ligera)

### 7.3 Base de Datos
- **MySQL 8.0+** (base de datos relacional)
- **XAMPP** (entorno de desarrollo local)
- **MySQL Workbench** (cliente visual opcional)

### 7.4 Herramientas de Desarrollo
- **Visual Studio Code** (editor de código)
- **Git + GitHub** (control de versiones)
- **Postman** o **Insomnia** (testing de APIs)
- **Laravel Debugbar** (debugging)

### 7.5 Integraciones
- **Webpay Plus** (Transbank) - Pasarela de pagos
- **SMTP** (correo electrónico) - PHPMailer / Laravel Mail

---

## 8. Métricas de Éxito

### 8.1 Métricas Técnicas
- ✅ Aplicación desplegada y operativa
- ✅ 0 errores críticos en producción
- ✅ Tiempo de respuesta < 2 segundos promedio
- ✅ 100% de transacciones de pago trazables
- ✅ Cobertura de testing > 70% en lógica crítica

### 8.2 Métricas de Negocio
- ✅ Automatización del 100% de habilitaciones de acceso post-pago
- ✅ Reducción del 80% en tareas administrativas manuales
- ✅ Incremento en conversión de visitantes a estudiantes
- ✅ Satisfacción de usuarios finales > 4.0/5.0

### 8.3 Métricas de Adopción
- ✅ 100% de docentes usando el panel en los primeros 3 meses
- ✅ 80% de estudiantes activos usando la plataforma mensualmente
- ✅ Reducción de consultas por canales externos (WhatsApp, email)

---

## 9. Riesgos Identificados

| Riesgo | Probabilidad | Impacto | Mitigación |
|--------|--------------|---------|------------|
| Problemas de integración con Webpay Plus | Media | Alto | Testear en ambiente de integración desde el inicio |
| Complejidad de coordinación docente-estudiante | Media | Medio | Priorizar MVP con flujo manual asistido |
| Escalabilidad de almacenamiento de videos | Baja | Alto | Evaluar almacenamiento externo (S3, Cloudinary) |
| Resistencia al cambio de usuarios internos | Media | Medio | Capacitación temprana y feedback continuo |
| Sobrecarga del alcance inicial | Alta | Alto | Definir MVP estricto y priorizar implacablemente |

---

## 10. Cronograma Estimado (Tentativo)

| Fase | Duración Estimada | Descripción |
|------|-------------------|-------------|
| **Fase 0: Análisis y Diseño** | 2-3 semanas | Definición de requerimientos, diseño de BD, arquitectura |
| **Fase 1: Setup y Base** | 1 semana | Instalación de Laravel, estructura de carpetas, migraciones base |
| **Fase 2: Módulo Identidad** | 2 semanas | Autenticación, roles, perfiles |
| **Fase 3: Módulo Catálogo** | 2 semanas | Productos, niveles, materiales |
| **Fase 4: Módulo Comercial** | 3 semanas | Carrito, checkout, Webpay Plus |
| **Fase 5: Módulo Académico** | 3 semanas | Grupos, agenda, asistencia, notas |
| **Fase 6: Paneles de Usuario** | 2 semanas | Vistas de estudiante, docente, administrador |
| **Fase 7: Comunicación** | 1 semana | Notificaciones, avisos |
| **Fase 8: Testing y Ajustes** | 2 semanas | QA, correcciones, refinamiento |
| **Fase 9: Despliegue MVP** | 1 semana | Configuración de producción, lanzamiento |

**Total estimado MVP:** 19-20 semanas (~4-5 meses)

> **Nota:** Este cronograma es tentativo y debe refinarse con base en la capacidad del equipo de desarrollo.

---

## 11. Equipo Necesario

### 11.1 Roles Mínimos
- **1 Desarrollador Full Stack** (Laravel + Frontend)
- **1 Product Owner / Analista Funcional** (puede ser el dueño del instituto)
- **1 QA / Tester** (puede ser interno o externo)
- **Soporte externo:** Integración de Webpay Plus (documentación de Transbank)

### 11.2 Roles Opcionales (según escala)
- Diseñador UX/UI (mejora la experiencia de usuario)
- DevOps (si se requiere infraestructura avanzada)
- Especialista en seguridad (auditoría pre-lanzamiento)

---

## 12. Próximos Pasos

1. ✅ **Revisar y validar este resumen ejecutivo**
2. ⏳ Definir módulos detallados del MVP
3. ⏳ Documentar requerimientos funcionales completos
4. ⏳ Diseñar modelo de base de datos (DER)
5. ⏳ Crear migraciones iniciales de Laravel
6. ⏳ Definir estructura de carpetas del proyecto
7. ⏳ Inicializar proyecto Laravel y dependencias
8. ⏳ Comenzar desarrollo iterativo por módulos

---

## 13. Conclusión

CrucialEnglish representa una oportunidad de **profesionalización digital** para el instituto, con una propuesta técnica sólida basada en Laravel, que privilegia **control, escalabilidad y mantenibilidad** sobre soluciones rápidas pero limitadas.

El proyecto está **bien fundamentado conceptualmente**, con reglas de negocio claras, roles definidos y una visión de producto completa. El siguiente paso crítico es **convertir esta visión en especificaciones técnicas ejecutables**: diccionario de datos, migraciones, modelos Eloquent y backlog de desarrollo.

Con disciplina en el alcance del MVP, metodología iterativa y foco en calidad de software, el proyecto tiene alta probabilidad de éxito técnico y adopción por parte de los usuarios finales.

---

**Documento preparado por:** Arquitecto de Software Senior  
**Revisión requerida por:** Product Owner (Dueño del Instituto)  
**Próxima entrega:** Módulos del MVP y Requerimientos Funcionales
