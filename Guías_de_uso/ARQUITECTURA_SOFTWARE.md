# Documentación de Arquitectura de Software - DeporteFit

## 1. Visión General

El proyecto **DeporteFit** es una plataforma web para la gestión de entrenamiento deportivo, seguimiento de progreso y administración de rutinas de ejercicio. La arquitectura ha evolucionado desde un enfoque procedimental hacia una estructura orientada a objetos (POO) para mejorar la mantenibilidad, escalabilidad y organización del código.

## 2. Estructura del Proyecto

```
Pagina_deportiva1/
├── admin_api/              # APIs y Modelos POO
│   ├── Database.php       # Conexión a BD (Singleton)
│   ├── ModeloBase.php     # Clase base para modelos
│   ├── Rutina.php         # Modelo de Rutinas
│   ├── Progreso.php       # Modelo de Progresos
│   ├── Estadistica.php    # Modelo de Estadísticas
│   ├── rutinas.php        # API REST de Rutinas
│   ├── progresos.php      # API REST de Progresos
│   ├── estadisticas.php   # API REST de Estadísticas
│   ├── users.php          # API de Usuarios
│   ├── planes.php         # API de Planes
│   ├── stats.php          # API de Estadísticas Admin
│   ├── faqs.php           # API de FAQs
│   └── forms.php          # API de Formularios
├── BD/                    # Archivos de Base de Datos
├── css/                   # Estilos CSS
├── imagenes/              # Recursos gráficos
├── login/                 # Gestión de autenticación
├── Procesamientof/       # Procesamiento de formularios
├── template/              # Plantillas reutilizables
│   ├── headercliente.php  # Encabezado reutilizable
│   └── footer.php         # Pie de página
├── cliente.php            # Panel del cliente
├── avance.php             # Página de Progresos
└── index.php              # Página principal
```

## 3. Arquitectura POO

### 3.1 Patrón de Diseño

Se implementa un patrón similar a **MVC** (Modelo-Vista-Controlador):

- **Modelos**: Clases en `admin_api/` que encapsulan la lógica de negocio
- **Vistas**: Archivos PHP/HTML en la raíz
- **Controladores**: APIs en `admin_api/*.php` que manejan las solicitudes REST

### 3.2 Clases Principales

#### Database (Singleton)

**Propósito**: Gestión centralizada de la conexión a la base de datos.

```php
// admin_api/Database.php
class Database {
    private static $instance = null;
    private $connection;
    
    public static function getInstance() { ... }
    public function query($sql, $params = []) { ... }
    public function execute($sql, $params = []) { ... }
    public function beginTransaction() { ... }
    public function commit() { ... }
    public function rollback() { ... }
}
```

**Características**:
- Patrón Singleton (una sola instancia)
- Métodos auxiliar para consultas y transacciones
- Inicialización lazy (solo cuando se necesita)

#### ModeloBase (Abstract)

**Propósito**: Clase base que proporciona métodos CRUD genéricos.

```php
// admin_api/ModeloBase.php
abstract class ModeloBase {
    protected $db;
    protected $tableName;
    
    public function all() { ... }
    public function find($id) { ... }
    public function first($conditions, $params) { ... }
    public function getByUsuario($usuarioId, $orderBy = null, $direction = 'ASC') { ... }
    public function create($data) { ... }
    public function update($id, $data) { ... }
    public function delete($id) { ... }
    public function count($conditions = '', $params = []) { ... }
}
```

#### Rutina

**Propósito**: Gestión de rutinas de entrenamiento y sus ejercicios.

```php
// admin_api/Rutina.php
class Rutina extends ModeloBase {
    public function getWithEjercicios($usuarioId = null) { ... }
    public function getEjercicios($rutinaId) { ... }
    public function createWithEjercicios($data, $ejercicios = []) { ... }
    public function createEjercicio($data) { ... }
    public function deleteWithEjercicios($id) { ... }
    public function deleteEjercicios($rutinaId) { ... }
    public function addEjercicio($rutinaId, $data) { ... }
}
```

#### Progreso

**Propósito**: Seguimiento de peso, medidas corporales y entrenamientos.

```php
// admin_api/Progreso.php
class Progreso extends ModeloBase {
    public function getHistorialPeso($usuarioId) { ... }
    public function getUltimoPeso($usuarioId) { ... }
    public function getPesoInicial($usuarioId) { ... }
    public function getKgPerdidos($usuarioId) { ... }
    public function getMedidas($usuarioId) { ... }
    public function saveMedidas($data) { ... }
    public function getEntrenamientos($usuarioId, $limit = 30) { ... }
    public function getEntrenamientosSemana($usuarioId) { ... }
    public function registrarEntrenamiento($data) { ... }
    public function getObjetivos($usuarioId) { ... }
}
```

#### Estadistica

**Propósito**: Cálculo de estadísticas, métricas y logros.

```php
// admin_api/Estadistica.php
class Estadistica extends Progreso {
    public function getEstadisticasCompletas($usuarioId) { ... }
    public function getSemanasActivo($usuarioId) { ... }
    public function getCumplimiento($usuarioId) { ... }
    public function getProgresoObjetivos($usuarioId) { ... }
    public function getProgresoSemanal($usuarioId) { ... }
    public function getLogros($usuarioId) { ... }
    public function getMetricasDiarias($usuarioId) { ... }
}
```

## 4. APIs REST

### 4.1 Endpoint: Rutinas

**Archivo**: `admin_api/rutinas.php`

| Método | Acción | Descripción |
|--------|--------|-------------|
| GET | `getRutinas($usuario_id)` | Obtiene todas las rutinas del usuario |
| POST | `crearRutina($usuario_id)` | Crea una nueva rutina con ejercicios |
| PUT | `actualizarRutina()` | Actualiza una rutina existente |
| DELETE | `eliminarRutina()` | Elimina una rutina y sus ejercicios |

### 4.2 Endpoint: Progresos

**Archivo**: `admin_api/progresos.php?tipo={peso|medidas|entrenamientos|objetivos}`

| Método | Acción | Descripción |
|--------|--------|-------------|
| GET | `getProgresos($usuario_id, $tipo)` | Obtiene progresos según el tipo |
| POST | `crearProgreso($usuario_id, $tipo)` | Registra nuevo progreso |
| PUT | `actualizarProgreso($tipo)` | Actualiza un registro |
| DELETE | `eliminarProgreso($tipo)` | Elimina un registro |

### 4.3 Endpoint: Estadísticas

**Archivo**: `admin_api/estadisticas.php?usuario_id={id}`

Retorna estadísticas completas del usuario:
- Total de entrenamientos
- Semanas activo
- Kg perdidos
- Cumplimiento semanal
- Objetivos con progreso
- Gráfico de progreso semanal
- Logros desbloqueados

## 5. Base de Datos

### 5.1 Tablas Principales

```sql
-- Usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE,
    nombre VARCHAR(100),
    rol ENUM('cliente', 'entrenador', 'admin'),
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Rutinas de entrenamiento
CREATE TABLE rutinas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id VARCHAR(100),
    nombre VARCHAR(100),
    tipo ENUM('fuerza', 'cardio', 'flexibilidad', 'tecnica', 'resistencia'),
    dificultad ENUM('principiante', 'intermedio', 'avanzado'),
    duracion INT,
    notas TEXT,
    estado ENUM('activa', 'inactiva') DEFAULT 'activa',
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Ejercicios dentro de rutinas
CREATE TABLE ejercicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rutina_id INT,
    nombre VARCHAR(100),
    series INT,
    repeticiones INT,
    peso DECIMAL(5,2),
    descanso INT,
    orden INT
);

-- Progreso de peso
CREATE TABLE progresos_peso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id VARCHAR(100),
    peso DECIMAL(5,2),
    fecha_medicion DATE,
    notas TEXT
);

-- Medidas corporales
CREATE TABLE medidas_corporales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id VARCHAR(100),
    fecha_medicion DATE,
    pecho DECIMAL(5,2),
    cintura DECIMAL(5,2),
    cadera DECIMAL(5,2),
    biceps DECIMAL(5,2),
    pierna DECIMAL(5,2),
    notas TEXT
);

-- Entrenamientos realizados
CREATE TABLE entrenamientos_realizados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id VARCHAR(100),
    rutina_id INT,
    nombre_rutina VARCHAR(100),
    intensidad INT DEFAULT 5,
    sensacion VARCHAR(50),
    duracion_real INT,
    calorias INT,
    fecha_entrenamiento DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Objetivos del usuario
CREATE TABLE objetivos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id VARCHAR(100),
    tipo ENUM('peso', 'entrenamientos_semana', 'cintura'),
    valor_objetivo DECIMAL(5,2),
    valor_actual DECIMAL(5,2),
    fecha_inicio DATE,
    fecha_objetivo DATE,
    estado ENUM('activo', 'completado', 'cancelado') DEFAULT 'activo'
);
```

## 6. Integración con el Frontend

### 6.1 Plantillas Reutilizables

```php
// Incluir header
include_once 'template/headercliente.php';

// Incluir footer
include_once 'template/footer.php';
```

El header detecta automáticamente la página activa para resaltar el menú:

```php
// template/headercliente.php
$pagina_actual = basename($_SERVER['PHP_SELF'], '.php');
// Genera clase 'active' automáticamente
```

### 6.2 Consumo de APIs

Ejemplo desde el frontend (JavaScript):

```javascript
// Obtener estadísticas
fetch('admin_api/estadisticas.php?usuario_id=demo_user')
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            console.log(data.data);
        }
    });

// Crear rutina
fetch('admin_api/rutinas.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
        nombre: 'Rutina de Fuerza',
        tipo: 'fuerza',
        dificultad: 'intermedio',
        duracion: 60,
        ejercicios: [
            { nombre: 'Press banca', series: 3, repeticiones: 10, peso: 60, descanso: 90 }
        ]
    })
});
```

## 7. Beneficios de la Arquitectura POO

| Aspecto | Antes (Procedimental) | Después (POO) |
|---------|----------------------|---------------|
| **Mantenimiento** | Funciones dispersas | Clases centralizadas |
| **Reutilización** | Duplicación de código | Herencia y composición |
| **Testabilidad** | Difícil de probar | Métodos encapsulados |
| **Escalabilidad** | Código espagueti | Estructura modular |
| **Transacciones** | Manual | Automático con transacciones |

## 8. Guías de Uso

Para más información sobre funcionalidades específicas, consulta:

- [Guía de Pruebas de Formularios](./GUIA_PRUEBAS_FORMULARIOS.md)
- [Guía de Tablas Avanzadas](./GUIA_TABLAS_AVANZADAS.md)
- [Guía de Tablas y Formularios](./GUIA_TABLAS_FORMULARIOS.md)
- [Instrucciones de Formularios](./INSTRUCCIONES_FORMULARIOS.md)

## 9. Conclusiones

1. La arquitectura del proyecto se integró con las APIs y los modelos POO para que las páginas de cliente y avance interactúen con la base de datos de forma consistente y modular.

2. El uso de controladores REST y clases de datos permitió que las funciones de la plataforma se conectaran mejor, reduciendo duplicación y facilitando el mantenimiento.

---

**Versión**: 1.0  
**Fecha de creación**: 2026  
**Última actualización**: 2026
