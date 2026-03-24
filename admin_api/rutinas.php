<?php
/**
 * API para gestionar Rutinas - DeporteFit (POO)
 * Métodos: GET, POST, PUT, DELETE
 * 
 * Usa las clases POO: Database, Rutina
 */

// Configurar manejo de errores
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

// Obtener método de solicitud
$method = $_SERVER['REQUEST_METHOD'];

// Obtener usuario (simulado - en producción vendría de sesión/Firebase)
$usuario_id = isset($_GET['usuario_id']) ? $_GET['usuario_id'] : 'demo_user';

try {
    switch ($method) {
        case 'GET':
            getRutinas($usuario_id);
            break;
        case 'POST':
            $accion = $_GET['accion'] ?? '';
            if ($accion === 'agregar_ejercicio') {
                agregarEjercicio($usuario_id);
            } else {
                crearRutina($usuario_id);
            }
            break;
        case 'PUT':
            actualizarRutina();
            break;
        case 'DELETE':
            eliminarRutina();
            break;
        default:
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error del servidor: ' . $e->getMessage()]);
}

/**
 * Agregar ejercicio a una rutina existente
 */
function agregarEjercicio($usuario_id) {
    require_once __DIR__ . '/Rutina.php';

    $rutina = new Rutina();
    $data = json_decode(file_get_contents('php://input'), true);

    $rutinaId = (int)($data['rutina_id'] ?? 0);
    $nombre = trim($data['nombre'] ?? '');
    $series = (int)($data['series'] ?? 0);
    $repeticiones = (int)($data['repeticiones'] ?? 0);
    $peso = isset($data['peso']) && $data['peso'] !== '' ? $data['peso'] : null;
    $descanso = (int)($data['descanso'] ?? 60);

    if ($rutinaId <= 0 || $nombre === '' || $series <= 0 || $repeticiones <= 0) {
        echo json_encode(['success' => false, 'message' => 'Datos del ejercicio incompletos']);
        return;
    }

    $rutinaActual = $rutina->find($rutinaId);
    if (!$rutinaActual || (($rutinaActual['usuario_id'] ?? null) !== $usuario_id && !is_null($rutinaActual['usuario_id'] ?? null))) {
        echo json_encode(['success' => false, 'message' => 'Rutina no válida']);
        return;
    }

    $ejercicios = $rutina->getEjercicios($rutinaId);
    $orden = count($ejercicios);

    $insert = $rutina->addEjercicio($rutinaId, [
        'nombre' => $nombre,
        'series' => $series,
        'repeticiones' => $repeticiones,
        'peso' => $peso,
        'descanso' => $descanso,
        'orden' => $orden
    ]);

    if (($insert['affected_rows'] ?? 0) > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Ejercicio agregado con exito',
            'id' => $insert['insert_id'] ?? null
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al agregar ejercicio']);
    }
}

/**
 * Obtener todas las rutinas del usuario
 */
function getRutinas($usuario_id) {
    require_once __DIR__ . '/Rutina.php';
    
    $rutina = new Rutina();
    $rutinas = $rutina->getWithEjercicios($usuario_id);
    
    echo json_encode(['success' => true, 'data' => $rutinas]);
}

/**
 * Obtener rutinas predefinidas (para nuevos usuarios)
 */
function getRutinasPredeterminadas() {
    require_once __DIR__ . '/Rutina.php';
    
    $rutina = new Rutina();
    $rutinas = $rutina->getWithEjercicios(null); // Obtiene rutinas sin usuario_id
    
    echo json_encode(['success' => true, 'data' => $rutinas]);
}

/**
 * Crear una nueva rutina
 */
function crearRutina($usuario_id) {
    require_once __DIR__ . '/Rutina.php';
    
    $rutina = new Rutina();
    $data = json_decode(file_get_contents('php://input'), true);
    
    $nombre = $data['nombre'] ?? '';
    $tipo = $data['tipo'] ?? 'fuerza';
    $dificultad = $data['dificultad'] ?? 'principiante';
    $duracion = $data['duracion'] ?? 60;
    $notas = $data['notas'] ?? '';
    
    if (empty($nombre)) {
        echo json_encode(['success' => false, 'message' => 'El nombre es requerido']);
        return;
    }
    
    $rutinaData = [
        'usuario_id' => $usuario_id,
        'nombre' => $nombre,
        'tipo' => $tipo,
        'dificultad' => $dificultad,
        'duracion' => $duracion,
        'notas' => $notas,
        'estado' => 'activa'
    ];
    
    $ejercicios = $data['ejercicios'] ?? [];
    
    $result = $rutina->createWithEjercicios($rutinaData, $ejercicios);
    
    if ($result['success']) {
        echo json_encode(['success' => true, 'message' => 'Rutina guardada con exito', 'id' => $result['id']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al crear rutina: ' . $result['error']]);
    }
}

/**
 * Actualizar una rutina existente
 */
function actualizarRutina() {
    require_once __DIR__ . '/Rutina.php';
    
    $rutina = new Rutina();
    $data = json_decode(file_get_contents('php://input'), true);
    
    $id = $data['id'] ?? 0;
    $nombre = $data['nombre'] ?? '';
    $tipo = $data['tipo'] ?? 'fuerza';
    $dificultad = $data['dificultad'] ?? 'principiante';
    $duracion = $data['duracion'] ?? 60;
    $notas = $data['notas'] ?? '';
    $estado = $data['estado'] ?? 'activa';
    
    if (empty($id) || empty($nombre)) {
        echo json_encode(['success' => false, 'message' => 'ID y nombre son requeridos']);
        return;
    }
    
    $rutinaData = [
        'nombre' => $nombre,
        'tipo' => $tipo,
        'dificultad' => $dificultad,
        'duracion' => $duracion,
        'notas' => $notas,
        'estado' => $estado
    ];
    
    $result = $rutina->update($id, $rutinaData);
    
    if ($result) {
        // Actualizar ejercicios si existen
        if (isset($data['ejercicios'])) {
            // Eliminar ejercicios existentes
            $rutina->deleteEjercicios($id);
            
            // Agregar nuevos ejercicios
            foreach ($data['ejercicios'] as $index => $ej) {
                $rutina->addEjercicio($id, [
                    'nombre' => $ej['nombre'],
                    'series' => $ej['series'],
                    'repeticiones' => $ej['repeticiones'],
                    'peso' => $ej['peso'] ?? null,
                    'descanso' => $ej['descanso'] ?? 60,
                    'orden' => $index
                ]);
            }
        }
        
        echo json_encode(['success' => true, 'message' => 'Rutina actualizada']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar']);
    }
}

/**
 * Eliminar una rutina
 */
function eliminarRutina() {
    require_once __DIR__ . '/Rutina.php';
    
    $rutina = new Rutina();
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? 0;
    
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'ID requerido']);
        return;
    }
    
    $result = $rutina->deleteWithEjercicios($id);
    
    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Rutina eliminada']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar']);
    }
}
