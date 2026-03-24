<?php
/**
 * API para gestionar Progresos - DeporteFit (POO)
 * Métodos: GET, POST, PUT, DELETE
 * 
 * Usa las clases POO: Database, Progreso, Estadistica
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

// Obtener usuario
$usuario_id = isset($_GET['usuario_id']) ? $_GET['usuario_id'] : 'demo_user';
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'peso';

try {
    switch ($method) {
        case 'GET':
            getProgresos($usuario_id, $tipo);
            break;
        case 'POST':
            crearProgreso($usuario_id, $tipo);
            break;
        case 'PUT':
            actualizarProgreso($tipo);
            break;
        case 'DELETE':
            eliminarProgreso($tipo);
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
 * Obtener progresos según el tipo
 */
function getProgresos($usuario_id, $tipo) {
    require_once __DIR__ . '/Progreso.php';
    
    $progreso = new Progreso();
    
    switch ($tipo) {
        case 'peso':
            $data = $progreso->getHistorialPeso($usuario_id);
            break;
        case 'medidas':
            $data = $progreso->getMedidas($usuario_id);
            break;
        case 'entrenamientos':
            $data = $progreso->getEntrenamientos($usuario_id);
            break;
        case 'objetivos':
            $data = $progreso->getObjetivos($usuario_id);
            break;
        default:
            $data = $progreso->getHistorialPeso($usuario_id);
    }
    
    echo json_encode(['success' => true, 'data' => $data, 'tipo' => $tipo]);
}

/**
 * Crear nuevo registro de progreso
 */
function crearProgreso($usuario_id, $tipo) {
    require_once __DIR__ . '/Progreso.php';
    
    $progreso = new Progreso();
    $data = json_decode(file_get_contents('php://input'), true);
    
    switch ($tipo) {
        case 'peso':
            $result = crearPesoPOO($progreso, $usuario_id, $data);
            break;
        case 'medidas':
            $result = $progreso->saveMedidas([
                'usuario_id' => $usuario_id,
                'fecha' => $data['fecha'] ?? date('Y-m-d'),
                'pecho' => $data['pecho'] ?? null,
                'cintura' => $data['cintura'] ?? null,
                'cadera' => $data['cadera'] ?? null,
                'biceps' => $data['biceps'] ?? null,
                'pierna' => $data['pierna'] ?? null,
                'notas' => $data['notas'] ?? ''
            ]);
            break;
        case 'entrenamientos':
            $result = $progreso->registrarEntrenamiento([
                'usuario_id' => $usuario_id,
                'rutina_id' => $data['rutina_id'] ?? null,
                'nombre_rutina' => $data['nombre_rutina'] ?? 'Entrenamiento Libre',
                'intensidad' => $data['intensidad'] ?? 5,
                'sensacion' => $data['sensacion'] ?? 'bien',
                'duracion' => $data['duracion'] ?? null,
                'calorias' => $data['calorias'] ?? null
            ]);
            break;
        case 'objetivos':
            $result = crearObjetivoPOO($usuario_id, $data);
            break;
        default:
            $result = ['success' => false, 'message' => 'Tipo no válido'];
    }
    
    echo json_encode($result);
}

/**
 * Crear peso usando POO
 */
function crearPesoPOO($progreso, $usuario_id, $data) {
    $peso = $data['peso'] ?? 0;
    $fecha = $data['fecha'] ?? date('Y-m-d');
    $notas = $data['notas'] ?? '';
    
    if (empty($peso)) {
        return ['success' => false, 'message' => 'El peso es requerido'];
    }
    
    $result = $progreso->create([
        'usuario_id' => $usuario_id,
        'peso' => $peso,
        'fecha_medicion' => $fecha,
        'notas' => $notas
    ]);
    
    if ($result['success']) {
        return [
            'success' => true,
            'message' => 'Peso registrado exitosamente',
            'id' => $result['id']
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Error al registrar peso: ' . ($result['error'] ?? 'Error desconocido')
        ];
    }
}

/**
 * Crear objetivo usando POO
 */
function crearObjetivoPOO($usuario_id, $data) {
    require_once __DIR__ . '/Database.php';
    
    $tipo = $data['tipo'] ?? 'peso';
    $valor_objetivo = $data['valor_objetivo'] ?? 0;
    $fecha_objetivo = $data['fecha_objetivo'] ?? null;
    
    // Obtener valor actual
    $valor_actual = 0;
    if ($tipo === 'peso') {
        $progreso = new Progreso();
        $ultimoPeso = $progreso->getUltimoPeso($usuario_id);
        $valor_actual = $ultimoPeso['peso'] ?? 0;
    }
    
    $db = Database::getInstance();
    $sql = "INSERT INTO objetivos (usuario_id, tipo, valor_objetivo, valor_actual, fecha_inicio, fecha_objetivo, estado) 
            VALUES (?, ?, ?, ?, NOW(), ?, 'activo')";
    
    $result = $db->execute($sql, [$usuario_id, $tipo, $valor_objetivo, $valor_actual, $fecha_objetivo]);
    
    return [
        'success' => $result['affected_rows'] > 0,
        'message' => $result['affected_rows'] > 0 ? 'Objetivo creado' : 'Error al crear',
        'id' => $result['insert_id'] ?? null
    ];
}

/**
 * Actualizar progreso
 */
function actualizarProgreso($tipo) {
    require_once __DIR__ . '/Progreso.php';
    
    $progreso = new Progreso();
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? 0;
    
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'ID requerido']);
        return;
    }
    
    require_once __DIR__ . '/Database.php';
    $db = Database::getInstance();
    
    switch ($tipo) {
        case 'peso':
            $peso = $data['peso'] ?? 0;
            $sql = "UPDATE progresos_peso SET peso = ? WHERE id = ?";
            $result = $db->execute($sql, [$peso, $id]);
            break;
        case 'objetivos':
            $valor_actual = $data['valor_actual'] ?? 0;
            $estado = $data['estado'] ?? 'activo';
            $sql = "UPDATE objetivos SET valor_actual = ?, estado = ? WHERE id = ?";
            $result = $db->execute($sql, [$valor_actual, $estado, $id]);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Tipo no válido para actualizar']);
            return;
    }
    
    echo json_encode(['success' => $result['affected_rows'] > 0, 'message' => $result['affected_rows'] > 0 ? 'Actualizado correctamente' : 'Error al actualizar']);
}

/**
 * Eliminar progreso
 */
function eliminarProgreso($tipo) {
    require_once __DIR__ . '/Database.php';
    
    $db = Database::getInstance();
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? 0;
    
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'ID requerido']);
        return;
    }
    
    switch ($tipo) {
        case 'peso':
            $sql = "DELETE FROM progresos_peso WHERE id = ?";
            break;
        case 'medidas':
            $sql = "DELETE FROM medidas_corporales WHERE id = ?";
            break;
        case 'entrenamientos':
            $sql = "DELETE FROM entrenamientos_realizados WHERE id = ?";
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Tipo no válido']);
            return;
    }
    
    $result = $db->execute($sql, [$id]);
    
    echo json_encode(['success' => $result['affected_rows'] > 0, 'message' => $result['affected_rows'] > 0 ? 'Eliminado correctamente' : 'Error al eliminar']);
}
