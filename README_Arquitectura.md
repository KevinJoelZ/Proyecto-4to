# Arquitectura de Software - DeporteFit

## 📋 Descripción General

**DeporteFit** es una plataforma web para la gestión y seguimiento de entrenamientos deportivos, desarrollada con un enfoque en la Programación Orientada a Objetos (POO). Este documento se centra en la arquitectura de software, con énfasis en la implementación POO y la funcionalidad de la página **Avance**, que permite a los usuarios crear y gestionar rutinas de entrenamiento personalizadas.

## 🏗️ Arquitectura General

El proyecto sigue una arquitectura **MVC-like** (Modelo-Vista-Controlador) adaptada para aplicaciones web PHP, con separación clara de responsabilidades:

- **Vista (Frontend)**: Páginas HTML con CSS y JavaScript para la interfaz de usuario.
- **Controlador (API)**: Endpoints PHP en la carpeta `admin_api/` que manejan las solicitudes HTTP.
- **Modelo (Backend POO)**: Clases que representan la lógica de negocio y la interacción con la base de datos.

Esta arquitectura facilita la mantenibilidad, reutilización de código y escalabilidad del proyecto.

## 🔧 Implementación de Programación Orientada a Objetos (POO)

La implementación POO es el núcleo de la arquitectura backend, utilizando principios como encapsulación, herencia, polimorfismo y abstracción.

### Patrón Singleton en `Database.php`

La clase `Database` implementa el patrón **Singleton** para garantizar una única instancia de conexión a la base de datos MySQL.

```php
class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        // Configuración de conexión
        $this->connection = new mysqli('localhost', 'root', '', 'guardarbd');
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Métodos para ejecutar consultas
    public function query($sql) { /* ... */ }
    public function execute($sql, $params = []) { /* ... */ }
}
```

**Beneficios**:
- Evita múltiples conexiones innecesarias.
- Centraliza la configuración de la base de datos.
- Facilita el manejo de transacciones.

### Clase Abstracta `ModeloBase.php`

`ModeloBase` es una clase abstracta que proporciona operaciones CRUD genéricas para todos los modelos.

```php
abstract class ModeloBase {
    protected $db;
    protected $table;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function all() { /* SELECT * FROM table */ }
    public function find($id) { /* SELECT * FROM table WHERE id = ? */ }
    public function create($data) { /* INSERT INTO table */ }
    public function update($id, $data) { /* UPDATE table */ }
    public function delete($id) { /* DELETE FROM table */ }
    public function getByUsuario($usuarioId) { /* SELECT * FROM table WHERE usuario_id = ? */ }
}
```

**Beneficios**:
- **Herencia**: Los modelos específicos heredan métodos comunes.
- **Reutilización**: Evita código duplicado en operaciones CRUD.
- **Abstracción**: Separa la lógica de negocio de la persistencia de datos.

### Modelos Específicos

#### `Rutina.php`
Modelo para gestionar rutinas de entrenamiento.

**Métodos clave**:
- `getWithEjercicios($usuarioId)`: Obtiene rutinas con sus ejercicios asociados.
- `createWithEjercicios($data, $ejercicios)`: Crea una rutina y sus ejercicios en una transacción.
- `addEjercicio($rutinaId, $data)`: Agrega un ejercicio a una rutina existente.
- `deleteWithEjercicios($id)`: Elimina una rutina y todos sus ejercicios.

#### `Progreso.php`
Modelo para el seguimiento de progresos físicos.

**Funcionalidades**:
- Registro de peso corporal.
- Medidas corporales.
- Historial de entrenamientos.
- Cálculos de estadísticas.

#### `Estadistica.php`
Modelo para cálculos y análisis de datos.

**Funcionalidades**:
- Cálculos agregados de progresos.
- Generación de estadísticas.
- Análisis de tendencias.

## 📈 Página Avance: Implementación Detallada

La página **Avance** (`avance.php`) es el módulo principal para la creación y gestión de rutinas de entrenamiento, implementando POO de manera integral.

### Flujo de Usuario

1. **Acceso**: El usuario accede a `avance.php` desde el dashboard del cliente.
2. **Visualización**: Se muestran rutinas existentes del usuario.
3. **Creación**: El usuario llena un formulario para crear una nueva rutina con ejercicios.
4. **Persistencia**: Los datos se envían vía AJAX a la API.
5. **Feedback**: Se muestra una notificación de éxito o error.

### Arquitectura de la Página Avance

#### Vista (`avance.php`)
- **Frontend**: HTML con formularios para crear rutinas y ejercicios.
- **JavaScript**: Manejo de eventos, validaciones y llamadas AJAX.
- **CSS**: Estilos responsivos en `css/avance.css`.

#### Controlador API (`admin_api/rutinas.php`)
Endpoints REST para operaciones CRUD:

- `GET /admin_api/rutinas.php?usuario_id=X`: Listar rutinas del usuario.
- `POST /admin_api/rutinas.php`: Crear nueva rutina.
- `POST /admin_api/rutinas.php?accion=agregar_ejercicio`: Agregar ejercicio a rutina existente.
- `PUT /admin_api/rutinas.php`: Actualizar rutina.
- `DELETE /admin_api/rutinas.php?id=X`: Eliminar rutina.

#### Modelo (`Rutina.php`)
Lógica de negocio para rutinas:

```php
class Rutina extends ModeloBase {
    protected $table = 'rutinas';

    public function createWithEjercicios($data, $ejercicios) {
        $this->db->beginTransaction();
        try {
            // Crear rutina
            $rutinaId = $this->create($data);
            
            // Crear ejercicios asociados
            foreach ($ejercicios as $ejercicio) {
                $ejercicio['rutina_id'] = $rutinaId;
                $this->createEjercicio($ejercicio);
            }
            
            $this->db->commit();
            return $rutinaId;
        } catch (Exception $e) {
            $this->db->rollback();
            throw $e;
        }
    }
}
```

### Persistencia de Datos

- **Base de Datos**: MySQL con tablas `rutinas`, `ejercicios`, `progresos`, etc.
- **Transacciones**: Operaciones complejas (crear rutina con ejercicios) usan transacciones para mantener consistencia.
- **Relaciones**: Las rutinas tienen una relación uno-a-muchos con ejercicios.

## 🛠️ Tecnologías Utilizadas

- **Backend**: PHP 7.4+ con POO
- **Base de Datos**: MySQL
- **Frontend**: HTML5, CSS3, JavaScript ES6+
- **Arquitectura**: MVC-like con separación de capas
- **Patrones**: Singleton, Abstract Factory (ModeloBase), Repository (modelos específicos)

## 📁 Estructura de Archivos Relevante

```
admin_api/
├── Database.php          # Conexión BD (Singleton)
├── ModeloBase.php        # Clase base abstracta
├── Rutina.php            # Modelo de rutinas
├── Progreso.php          # Modelo de progresos
├── Estadistica.php       # Modelo de estadísticas
├── rutinas.php           # API de rutinas
└── progresos.php         # API de progresos

avance.php                # Página principal de avance
css/avance.css            # Estilos de la página avance
```

## 🚀 Beneficios de la Arquitectura POO

- **Modularidad**: Cada clase tiene responsabilidades claras.
- **Reutilización**: `ModeloBase` evita código duplicado.
- **Mantenibilidad**: Cambios en la lógica de negocio se concentran en los modelos.
- **Escalabilidad**: Fácil agregar nuevas funcionalidades siguiendo el patrón establecido.
- **Testabilidad**: Clases independientes facilitan las pruebas unitarias.

Esta arquitectura POO ha permitido desarrollar una aplicación robusta y extensible, centrada en la experiencia del usuario para el seguimiento de entrenamientos deportivos.</content>
<parameter name="filePath">c:\xampp\htdocs\Pagina_deportiva1\README_Arquitectura.md