<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Habilitar mostrar errores para debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

try {
    // Log para debug
    error_log("Iniciando proceso de guardado de usuario");
    
    // Incluir conexión a la base de datos
    require_once '../conexion.php';
    
    
    error_log("Conexión establecida correctamente");

    // Leer datos JSON del cuerpo de la petición
    $input = file_get_contents('php://input');
    error_log("Datos recibidos: " . $input);
    
    $userData = json_decode($input, true);

    if (!$userData) {
        throw new Exception('No se recibieron datos válidos');
    }

    // Validar campos requeridos
    $requiredFields = ['uid', 'email'];
    foreach ($requiredFields as $field) {
        if (empty($userData[$field])) {
            throw new Exception("El campo '$field' es requerido");
        }
    }

    // Sanitizar datos
    $uid = htmlspecialchars(trim($userData['uid']));
    $name = isset($userData['name']) ? htmlspecialchars(trim($userData['name'])) : '';
    $email = htmlspecialchars(trim($userData['email']));
    $photoURL = isset($userData['photoURL']) ? htmlspecialchars(trim($userData['photoURL'])) : '';
    $emailVerified = isset($userData['emailVerified']) ? ($userData['emailVerified'] ? 1 : 0) : 0;
    // Lista de correos con rol admin (whitelist)
    $adminEmails = [
        'joelmoreno270599@gmail.com'
    ];

    // Determinar si el email corresponde a un admin
    $isAdminEmail = in_array(strtolower($email), array_map('strtolower', $adminEmails));

    // Rol por defecto según whitelist
    $rol = $isAdminEmail ? 'admin' : 'cliente';

    error_log("Datos procesados - UID: $uid, Email: $email, Nombre: $name");

    // Verificar si el usuario ya existe
    $checkSql = "SELECT id, uid, rol FROM usuarios WHERE uid = ? OR email = ?";
    $checkStmt = $conexion->prepare($checkSql);
    
    if (!$checkStmt) {
        throw new Exception('Error al preparar consulta de verificación: ' . $conexion->error);
    }
    
    $checkStmt->bind_param('ss', $uid, $email);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        // Usuario existe, actualizar datos
        error_log("Usuario existe, actualizando...");
        $existingUser = $result->fetch_assoc();
        
        // Mantener admin existente o escalar a admin si el email está en la whitelist
        $rolToUpdate = ($existingUser['rol'] === 'admin' || $isAdminEmail) ? 'admin' : 'cliente';

        $updateSql = "UPDATE usuarios SET
                      nombre = ?,
                      email = ?,
                      foto_perfil = ?,
                      email_verificado = ?,
                      ultima_conexion = NOW(),
                      rol = ?
                      WHERE uid = ?";
       
        $updateStmt = $conexion->prepare($updateSql);
        if (!$updateStmt) {
            throw new Exception('Error al preparar consulta de actualización: ' . $conexion->error);
        }
        
        $updateStmt->bind_param('sssiss', $name, $email, $photoURL, $emailVerified, $rolToUpdate, $uid);
       
        if ($updateStmt->execute()) {   
            error_log("Usuario actualizado exitosamente");
            echo json_encode([
                'success' => true,
                'message' => 'Usuario actualizado exitosamente',
                'action' => 'updated',
                'user_id' => $existingUser['id']
            ]);
        } else {
            throw new Exception('Error al actualizar usuario: ' . $updateStmt->error);
        }
       
    } else {
        // Usuario nuevo, insertar
        error_log("Usuario nuevo, insertando...");
        $insertSql = "INSERT INTO usuarios (uid, nombre, email, foto_perfil, email_verificado, fecha_registro, ultima_conexion, rol)
                      VALUES (?, ?, ?, ?, ?, NOW(), NOW(), ?)";
        
        $insertStmt = $conexion->prepare($insertSql);
        if (!$insertStmt) {
            throw new Exception('Error al preparar consulta de inserción: ' . $conexion->error);
        }
        
        $insertStmt->bind_param('ssssis', $uid, $name, $email, $photoURL, $emailVerified, $rol);
       
        if ($insertStmt->execute()) {
            $newUserId = $conexion->insert_id;
            error_log("Usuario insertado exitosamente con ID: " . $newUserId);
            echo json_encode([
                'success' => true,
                'message' => 'Usuario registrado exitosamente',
                'action' => 'created',
                'user_id' => $newUserId
            ]);
        } else {
            throw new Exception('Error al registrar usuario: ' . $insertStmt->error);
        }
    }

} catch (Exception $e) {
    error_log("Error en guardar_usuario.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>