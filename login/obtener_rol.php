<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

try {
    require_once '../conexion.php';
    

    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // DEBUG: Log de datos recibidos
    error_log("DEBUG obtener_rol - Datos recibidos: " . print_r($data, true));

    if (!isset($data['uid']) || empty($data['uid'])) {
        throw new Exception('UID es requerido');
    }

    $uid = htmlspecialchars(trim($data['uid']));
    
    // DEBUG: Log del UID procesado
    error_log("DEBUG obtener_rol - UID procesado: " . $uid);

    $sql = "SELECT uid, nombre, email, rol FROM usuarios WHERE uid = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('s', $uid);
    $stmt->execute();
    $result = $stmt->get_result();

    // DEBUG: Log del número de resultados
    error_log("DEBUG obtener_rol - Número de resultados: " . $result->num_rows);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // DEBUG: Log del usuario encontrado
        error_log("DEBUG obtener_rol - Usuario encontrado: " . print_r($user, true));
        
        echo json_encode([
            'success' => true,
            'rol' => $user['rol'],
            'debug_info' => $user // Información adicional para debugging
        ]);
    } else {
        // DEBUG: Usuario no encontrado
        error_log("DEBUG obtener_rol - Usuario no encontrado para UID: " . $uid);
        
        // Buscar si existe con email para debugging
        $sql_debug = "SELECT uid, email, rol FROM usuarios LIMIT 5";
        $stmt_debug = $conexion->prepare($sql_debug);
        $stmt_debug->execute();
        $result_debug = $stmt_debug->get_result();
        $all_users = $result_debug->fetch_all(MYSQLI_ASSOC);
        
        error_log("DEBUG obtener_rol - Usuarios en BD: " . print_r($all_users, true));
        
        throw new Exception('Usuario no encontrado');
    }

} catch (Exception $e) {
    error_log("DEBUG obtener_rol - Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>