# README - POO en `avance.php`

Este documento explica la implementación orientada a objetos (POO) usada en la sección **Avance** de la aplicación, especialmente en la creación de rutinas y ejercicios con persistencia en base de datos.

## 1) Objetivo de la arquitectura POO

La sección `avance.php` separa responsabilidades en capas:

- **Vista / Cliente (Frontend):** formulario y lógica JS en `avance.php`.
- **API (Controlador HTTP):** endpoints en `admin_api/rutinas.php` y `admin_api/progresos.php`.
- **Modelo de dominio (POO):** clases `Rutina`, `Progreso`, `Estadistica`.
- **Infraestructura de datos:** `Database` y `ModeloBase`.

Esta separación permite:

- Reutilizar código.
- Evitar lógica SQL duplicada.
- Mantener el código más limpio y escalable.

## 2) Clases principales POO

### `admin_api/Database.php`

Clase de conexión a MySQL con patrón **Singleton**.

Responsabilidades:

- Abrir conexión con MySQL (`guardarbd`).
- Ejecutar consultas (`query`, `execute`).
- Manejar transacciones (`beginTransaction`, `commit`, `rollback`).

Configuración actual:

- Host: `localhost`
- Usuario: `root`
- Contraseña: `''` (vacía en entorno local XAMPP)
- Base de datos: `guardarbd`

### `admin_api/ModeloBase.php`

Clase abstracta base para todos los modelos.

Incluye métodos genéricos:

- `all()`
- `find()`
- `create()`
- `update()`
- `delete()`
- `getByUsuario()`

Con esto, cada modelo hijo hereda operaciones CRUD comunes.

### `admin_api/Rutina.php`

Modelo de negocio para rutinas.

Funciones importantes:

- `getWithEjercicios($usuarioId)`: trae rutinas con su detalle de ejercicios.
- `createWithEjercicios($data, $ejercicios)`: crea rutina + ejercicios en una misma transacción.
- `createEjercicio($data)`: inserta un ejercicio.
- `addEjercicio($rutinaId, $data)`: agrega ejercicio a rutina existente.
- `deleteWithEjercicios($id)`: elimina rutina y sus ejercicios.

### `admin_api/Progreso.php` y `admin_api/Estadistica.php`

Modelos POO usados por la pestaña de progresos/estadísticas para peso, medidas, entrenamientos y cálculos agregados.

## 3) Endpoints usados en Avance

### `admin_api/rutinas.php`

Soporta métodos HTTP:

- `GET`: listar rutinas del usuario.
- `POST`: crear rutina.
- `POST` con `accion=agregar_ejercicio`: insertar ejercicio en rutina existente.
- `PUT`: actualizar rutina.
- `DELETE`: eliminar rutina.

### `admin_api/progresos.php`

Soporta registro y consulta de:

- Peso
- Medidas
- Entrenamientos
- Objetivos

## 4) Flujo de inserción en `avance.php`

## Crear Rutina

1. Usuario llena formulario `formNuevaRutina`.
2. Frontend envía `POST` a `admin_api/rutinas.php?usuario_id=...`.
3. API llama a `Rutina->createWithEjercicios(...)`.
4. Se guarda en BD `guardarbd`.
5. Frontend muestra toast verde: **"Rutina guardada con exito"**.

## Agregar Ejercicio

1. Usuario selecciona rutina en `formEjercicio`.
2. Frontend envía `POST` a:
   - `admin_api/rutinas.php?usuario_id=...&accion=agregar_ejercicio`
3. API valida datos y llama a `Rutina->addEjercicio(...)`.
4. Se guarda en tabla `ejercicios`.
5. Frontend muestra toast verde: **"Ejercicio agregado con exito"**.

## 5) Tablas involucradas

En la parte de rutinas/ejercicios se usan principalmente:

- `rutinas`
- `ejercicios`

En progresos:

- `progresos_peso`
- `medidas_corporales`
- `entrenamientos_realizados`
- `objetivos`

## 6) Ventajas de esta implementación

- **Consistencia de datos:** uso de transacciones al crear rutina con ejercicios.
- **Mantenibilidad:** lógica SQL centralizada en modelos.
- **Escalabilidad:** fácil agregar nuevas entidades y endpoints.
- **Reutilización:** `ModeloBase` evita repetir CRUD.

## 7) Recomendaciones futuras

- Reemplazar `usuario_id` simulado (`demo_user`) por sesión/autenticación real.
- Añadir validaciones más estrictas (tipos/rangos).
- Registrar logs de errores en archivo en producción.
- Crear pruebas automáticas para endpoints críticos.

## 8) Objetos POO reales que usa la sección Avance

Sí, la sección **Avance** usa objetos/clases POO en backend.  
Estos son los objetos que se instancian y participan directamente:

- `Database::getInstance()`  
  Objeto singleton de conexión a MySQL (`guardarbd`).
- `new Rutina()`  
  Objeto del modelo de rutinas para crear, listar y eliminar rutinas/ejercicios.
- `new Progreso()`  
  Objeto del modelo de progreso para peso, medidas y entrenamientos.
- `new Estadistica()`  
  Objeto para cálculos/resumen estadístico (cuando se consulta estadísticas).

También existe herencia POO:

- `Rutina`, `Progreso` y `Estadistica` heredan de `ModeloBase`.
- `ModeloBase` concentra CRUD común y evita duplicación.

## 9) Alcance exacto de POO en Avance (qué sí y qué no)

### Sí está en POO

- Capa de modelos (`Rutina`, `Progreso`, `Estadistica`, `ModeloBase`).
- Capa de acceso a datos (`Database` con patrón Singleton).
- Operaciones de negocio de rutinas/ejercicios/progresos en métodos de clase.

### No está en POO

- La parte visual y JS de `avance.php` (formularios, fetch, notificaciones) está en estilo procedural/funcional del lado cliente.
- Los archivos API (`rutinas.php`, `progresos.php`) actúan como controladores HTTP y enrutan peticiones hacia los objetos POO.

---

Documento generado para el módulo **Avance** con enfoque en arquitectura **POO** y persistencia en `guardarbd` (XAMPP local).
