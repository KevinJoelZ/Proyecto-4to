<?php
/**
 * API para gestionar Rutinas - DeporteFit (POO)
 * Métodos: GET, POST, PUT, DELETE
 * 
 * Usa las clases POO: Database, Rutina
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

// Obtener método de solicitud
$method = $_SERVER['REQUEST_METHOD'];

// Obtener usuario (simulado - en producción vendría de sesión/Firebase)
$usuario_id = isset($_GET['usuario_id']) ? $_GET['usuario_id'] : 'demo_user';

switch ($method) {
    case 'GET':
        getRutinas($usuario_id);
        break;
    case 'POST':
        crearRutina($usuario_id);
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
        echo json_encode(['success' => true, 'message' => 'Rutina creada exitosamente', 'id' => $result['id']]);
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
