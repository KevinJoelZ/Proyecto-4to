# README COMPLETO - PROYECTO DEPORTEFIT

## 📋 Descripción General

**DeporteFit** es una plataforma web completa para la gestión y seguimiento de entrenamientos deportivos. Desarrollada con PHP, MySQL y tecnologías web modernas, ofrece una experiencia integral para usuarios que buscan mejorar su condición física a través de rutinas personalizadas, seguimiento de progresos y servicios profesionales.

### 🎯 Objetivo del Proyecto
Crear una aplicación web que permita a los usuarios:
- Gestionar rutinas de entrenamiento personalizadas
- Registrar y visualizar progresos físicos (peso, medidas corporales)
- Acceder a servicios de entrenadores profesionales
- Interactuar con un panel de administración para gestión de contenido
- Mantener comunicación directa a través de formularios de contacto

### 📊 Metodología de Desarrollo
El proyecto **DeporteFit** se desarrolló siguiendo una **metodología ágil incremental** (inspirada en Scrum), adaptada al contexto educativo y de desarrollo individual.

**Fases principales:**
1. **Planificación Inicial**: Definición de requisitos funcionales y no funcionales, diseño de arquitectura POO y esquema de base de datos.
2. **Desarrollo Iterativo**: Implementación por módulos (autenticación, rutinas, progresos, admin), con ciclos de desarrollo-prueba-refactorización.
3. **Testing Continuo**: Pruebas manuales en carpetas como `Pruebasf/`, `Procesamientof/`, y archivos de test específicos.
4. **Integración y Validación**: Verificación de integración entre frontend, API y base de datos.
5. **Documentación**: Creación de READMEs detallados y guías de uso.

**Ventajas de esta metodología:**
- **Flexibilidad**: Permitió adaptar el proyecto según hallazgos durante el desarrollo.
- **Entrega Incremental**: Funcionalidades completas en cada iteración (login, rutinas, admin).
- **Feedback Rápido**: Testing continuo identificó errores temprano.
- **Escalabilidad**: Arquitectura modular facilita futuras expansiones.

Esta aproximación resultó efectiva para un proyecto educativo, permitiendo aprendizaje práctico mientras se mantenía la calidad del código.

## 🛠️ Tecnologías Utilizadas

### Backend
- **PHP 7.4+**: Lenguaje principal del servidor
- **MySQL**: Base de datos relacional
- **Arquitectura POO**: Implementación orientada a objetos en modelos y controladores

### Frontend
- **HTML5**: Estructura de páginas
- **CSS3**: Estilos y diseño responsivo
- **JavaScript (ES6+)**: Interactividad y AJAX
- **Font Awesome**: Iconografía
- **Particles.js**: Efectos visuales en la página principal

### Autenticación y Servicios Externos
- **Firebase Authentication**: Sistema de login/registro seguro
- **InfinityFree**: Hosting alternativo para pruebas

### Herramientas de Desarrollo
- **XAMPP**: Entorno de desarrollo local (Apache + MySQL + PHP)
- **phpMyAdmin**: Gestión de base de datos
- **VS Code**: Editor de código

## 📁 Estructura del Proyecto

```
Pagina_deportiva1/
├── 📄 index.php                 # Página principal con login
├── 📄 admin.php                 # Panel de administración
├── 📄 cliente.php               # Dashboard del cliente
├── 📄 avance.php                # Módulo de rutinas y ejercicios
├── 📄 entrenadores.html         # Página de entrenadores
├── 📄 planes.html               # Página de planes
├── 📄 servicios.html            # Página de servicios
├── 📄 contacto.html             # Página de contacto
├── 📄 auth.php                  # Procesamiento de autenticación
├── 📄 logout.php                # Cierre de sesión
├── 📁 admin_api/                # API REST para operaciones backend
│   ├── 📄 Database.php          # Clase de conexión a BD (Singleton)
│   ├── 📄 ModeloBase.php        # Clase base para modelos POO
│   ├── 📄 Rutina.php            # Modelo de rutinas
│   ├── 📄 Progreso.php          # Modelo de progresos
│   ├── 📄 Estadistica.php       # Modelo de estadísticas
│   ├── 📄 rutinas.php           # API de rutinas (CRUD)
│   ├── 📄 progresos.php         # API de progresos
│   ├── 📄 users.php             # API de usuarios
│   ├── 📄 faqs.php              # API de FAQs
│   ├── 📄 forms.php             # API de formularios
│   └── 📄 stats.php             # API de estadísticas
├── 📁 BD/                       # Scripts de base de datos
│   ├── 📄 base_datos_completa.sql
│   ├── 📄 crear_tabla_usuarios.sql
│   └── 📄 Tablas.sql
├── 📁 css/                      # Hojas de estilo
│   ├── 📄 styleindex.css        # Estilos página principal
│   ├── 📄 admin.css             # Estilos panel admin
│   ├── 📄 estilos.css           # Estilos generales
│   └── 📄 avance.css            # Estilos módulo avance
├── 📁 imagenes/                 # Recursos gráficos
├── 📁 login/                    # Archivos relacionados con login
├── 📁 template/                 # Plantillas HTML reutilizables
├── 📁 Procesamientof/           # Scripts de procesamiento
├── 📁 Pruebasf/                 # Archivos de prueba
├── 📁 Crudadmin/                # CRUD para administración
├── 📁 Scriptsindex/             # Scripts de la página principal
└── 📁 Guías_de_uso/             # Documentación
```

## 🗄️ Base de Datos

### Configuración Principal
- **Nombre**: `guardarbd`
- **Motor**: InnoDB
- **Charset**: utf8mb4_unicode_ci
- **Host**: localhost (XAMPP)
- **Usuario**: root
- **Contraseña**: (vacía en desarrollo local)

### Tablas Principales

#### 👥 Usuarios (`usuarios`)
- Gestión de usuarios con integración Firebase
- Roles: admin, cliente, entrenador
- Campos: uid, nombre, email, foto_perfil, email_verificado, rol, estado

#### 📝 Contactos (`contactos`)
- Formulario de contacto general
- Estados: pendiente, respondido, archivado
- Motivos: información, soporte, entrenadores, otros

#### 🏋️ Rutinas (`rutinas`)
- Creación y gestión de rutinas de entrenamiento
- Tipos: fuerza, cardio, flexibilidad, técnica, resistencia
- Dificultades: principiante, intermedio, avanzado

#### 💪 Ejercicios (`ejercicios`)
- Ejercicios asociados a rutinas
- Campos: series, repeticiones, peso, descanso, orden

#### 📊 Progresos Peso (`progresos_peso`)
- Registro histórico de peso corporal
- Seguimiento temporal con notas

#### 📏 Medidas Corporales (`medidas_corporales`)
- Registro de medidas: pecho, cintura, cadera, bíceps, pierna
- Histórico por fechas

#### 🏃 Entrenamientos Realizados (`entrenamientos_realizados`)
- Registro de sesiones completadas
- Métricas: intensidad, sensación, duración, calorías

#### 🎯 Objetivos (`objetivos`)
- Metas personalizadas: peso, cintura, entrenamientos/semana
- Estados: activo, completado, cancelado

#### 📋 Solicitudes
- `solicitudes_info`: Información general
- `solicitudes_entrenadores`: Contacto con entrenadores
- `solicitudes_planes`: Información de planes
- `solicitudes_servicios`: Servicios específicos

## 🔧 Funcionalidades Principales

### 1. 🔐 Sistema de Autenticación
- **Login/Registro**: Integración con Firebase Authentication
- **Roles de Usuario**: Cliente, Administrador, Entrenador
- **Sesiones Seguras**: Gestión de sesiones PHP
- **Verificación de Email**: Validación de cuentas

### 2. 👨‍💼 Panel de Administración
- **Gestión de Usuarios**: CRUD completo de usuarios
- **FAQs**: Creación y edición de preguntas frecuentes
- **Estadísticas**: Dashboard con métricas del sistema
- **Formularios**: Gestión de solicitudes y contactos

### 3. 🏋️‍♂️ Módulo de Avance (Rutinas)
- **Creación de Rutinas**: Formularios dinámicos para rutinas personalizadas
- **Gestión de Ejercicios**: Agregar ejercicios a rutinas existentes
- **Tipos de Entrenamiento**: Fuerza, cardio, flexibilidad, etc.
- **Persistencia POO**: Arquitectura orientada a objetos

### 4. 📈 Seguimiento de Progresos
- **Registro de Peso**: Histórico de peso corporal
- **Medidas Corporales**: Seguimiento de cambios físicos
- **Entrenamientos Realizados**: Registro de sesiones
- **Objetivos**: Metas personalizadas con progreso

### 5. 📞 Formularios de Contacto
- **Contacto General**: Información y soporte
- **Solicitudes de Servicios**: Entrenadores, planes, servicios
- **Estados de Solicitudes**: Pendiente, respondido, archivado

### 6. 📱 Interfaz de Usuario
- **Diseño Responsivo**: Adaptable a móviles y desktop
- **Navegación Intuitiva**: Menús claros y accesibles
- **Notificaciones**: Sistema de toast para feedback
- **Iconografía**: Font Awesome para mejor UX

## 🏗️ Arquitectura POO Implementada

### Patrón Singleton (`Database.php`)
```php
class Database {
    private static $instance = null;
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new PDO(...);
        }
        return self::$instance;
    }
}
```

### Clase Base Abstracta (`ModeloBase.php`)
- Métodos CRUD genéricos: `all()`, `find()`, `create()`, `update()`, `delete()`
- Herencia para modelos específicos

### Modelos de Dominio
- **`Rutina`**: Gestión de rutinas y ejercicios
- **`Progreso`**: Manejo de métricas de progreso
- **`Estadistica`**: Cálculos y análisis de datos

### API REST
- Endpoints en `admin_api/` para operaciones CRUD
- Respuestas JSON para frontend
- Manejo de errores y validaciones

## 🚀 Instalación y Configuración

### Prerrequisitos
- **XAMPP** (o similar con Apache, MySQL, PHP)
- **PHP 7.4+** con extensiones PDO y MySQLi
- **MySQL 5.7+**
- **Navegador web moderno**

### Pasos de Instalación

1. **Clonar/Descargar el proyecto**
   ```bash
   # Colocar en htdocs de XAMPP
   C:\xampp\htdocs\Pagina_deportiva1\
   ```

2. **Configurar Base de Datos**
   - Iniciar XAMPP (Apache + MySQL)
   - Acceder a phpMyAdmin: `http://localhost/phpmyadmin`
   - Crear base de datos: `guardarbd`
   - Importar: `BD/base_datos_completa.sql`

3. **Configurar Conexión**
   - Verificar `conexion.php` o `conexión.php`
   - Ajustar credenciales si es necesario

4. **Configurar Firebase** (opcional para autenticación completa)
   - Crear proyecto en Firebase Console
   - Configurar Authentication
   - Actualizar configuración en archivos de login

5. **Acceder a la aplicación**
   - URL principal: `http://localhost/Pagina_deportiva1/`
   - Panel admin: `http://localhost/Pagina_deportiva1/admin.php`

## 📖 Uso de la Aplicación

### Para Usuarios (Clientes)
1. **Registro/Login**: Usar credenciales de Firebase
2. **Dashboard**: Acceder a módulos desde `cliente.php`
3. **Crear Rutinas**: En `avance.php`, crear rutinas personalizadas
4. **Registrar Progresos**: Peso, medidas, entrenamientos
5. **Contactar Servicios**: Usar formularios de contacto

### Para Administradores
1. **Login**: Usar cuenta admin
2. **Panel Admin**: Gestionar usuarios, FAQs, estadísticas
3. **Revisar Formularios**: Responder solicitudes de contacto
4. **Monitorear Sistema**: Ver métricas y estadísticas

## 🔍 Partes Clave del Proyecto

### 1. **Sistema de Autenticación Seguro**
- Integración Firebase para seguridad
- Sesiones PHP para estado del usuario
- Roles y permisos granulares

### 2. **Arquitectura POO Robusta**
- Separación clara de responsabilidades
- Reutilización de código con herencia
- Mantenibilidad y escalabilidad

### 3. **Base de Datos Normalizada**
- Relaciones consistentes
- Índices optimizados
- Datos de ejemplo incluidos

### 4. **API REST Moderna**
- Endpoints para operaciones CRUD
- Respuestas JSON estructuradas
- Manejo de errores apropiado

### 5. **Interfaz de Usuario Intuitiva**
- Diseño moderno y responsivo
- Feedback visual con notificaciones
- Navegación fluida entre módulos

### 6. **Sistema de Seguimiento Completo**
- Múltiples métricas de progreso
- Visualización histórica
- Objetivos personalizables

## 🐛 Solución de Problemas Comunes

### Error de Conexión a BD
- Verificar que MySQL esté ejecutándose en XAMPP
- Comprobar credenciales en `conexion.php`
- Asegurar que la BD `guardarbd` existe

### Problemas de Autenticación
- Verificar configuración de Firebase
- Comprobar sesiones PHP
- Revisar permisos de archivos

### Errores en Formularios
- Validar campos requeridos
- Verificar tipos de datos
- Comprobar logs de errores PHP

## 📈 Estadísticas y Métricas

El proyecto incluye un sistema completo de estadísticas:
- **Usuarios Activos**: Conteo por roles
- **Solicitudes**: Por tipo y estado
- **Progresos**: Análisis de datos de usuarios
- **Uso del Sistema**: Métricas de engagement

## 🔮 Mejoras Futuras

### Funcionalidades
- **App Móvil**: Versión nativa para iOS/Android
- **IA Personalizada**: Recomendaciones basadas en datos
- **Integración Wearables**: Conexión con dispositivos fitness
- **Sistema de Notificaciones**: Push notifications

### Técnicas
- **Framework PHP**: Migración a Laravel o Symfony
- **API GraphQL**: Reemplazo de REST
- **Microservicios**: Arquitectura distribuida
- **Tests Automatizados**: Cobertura completa

### Seguridad
- **OAuth 2.0**: Autenticación más robusta
- **Encriptación**: Datos sensibles
- **Auditoría**: Logs de seguridad
- **Backup Automático**: Estrategias de respaldo

## 👥 Equipo de Desarrollo

- **Desarrollador Principal**: Kevin Joel Zapata
- **Proyecto**: DeporteFit - Plataforma Deportiva
- **Fecha**: Abril 2026
- **Versión**: 1.0.0

## 📄 Licencia

Este proyecto es de uso educativo y personal. Para uso comercial, contactar al desarrollador.

## 📞 Contacto

- **Email**: kevinjoelzapata1999@gmail.com
- **GitHub**: [KevinJoelZ](https://github.com/KevinJoelZ)
- **Proyecto**: [Proyecto-4to](https://github.com/KevinJoelZ/Proyecto-4to)

---

**DeporteFit** - Tu compañero en el camino hacia una vida más saludable y activa. 💪🏃‍♂️

*Documento generado automáticamente para el proyecto completo.*</content>
<parameter name="filePath">c:\xampp\htdocs\Pagina_deportiva1\README_PROYECTO_COMPLETO.md