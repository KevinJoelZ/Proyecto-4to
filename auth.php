<?php
session_start();
include 'conexión.php';

// Configuración de Firebase para verificación
$project_id = 'proyectoweb-fc2d2'; // Para verificar aud en tokeninfo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id_token = $input['id_token'] ?? '';

    if (empty($id_token)) {
        echo json_encode(['success' => false, 'error' => 'Token faltante']);
        exit;
    }

    // Verificar token con Google
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://oauth2.googleapis.com/tokeninfo?id_token=' . $id_token);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code !== 200) {
        echo json_encode(['success' => false, 'error' => 'Token inválido']);
        exit;
    }

    $token_info = json_decode($response, true);
    if (!$token_info || $token_info['aud'] !== $project_id || $token_info['iss'] !== 'https://securetoken.google.com/' . $project_id) {
        echo json_encode(['success' => false, 'error' => 'Token no válido para este proyecto']);
        exit;
    }

    $email = $token_info['email'];
    $nombre = $token_info['name'] ?? $token_info['email'];
    $uid = $token_info['sub'] ?? '';
    $foto_perfile = $token_info['picture'] ?? '';
    $mail_verificado = isset($token_info['email_verified']) && $token_info['email_verified'] ? 1 : 0;

    // Verificar/crear usuario en BD
    $stmt = $conexion->prepare("SELECT id, rol FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_id = $user['id'];
        $rol = $user['rol'];
        // Actualizar datos si cambiaron
        $update_stmt = $conexion->prepare("UPDATE usuarios SET nombre = ?, foto_perfile = ?, mail_verificado = ?, ultima_conexion = NOW() WHERE id = ?");
        $update_stmt->bind_param("sssi", $nombre, $foto_perfile, $mail_verificado, $user_id);
        $update_stmt->execute();
    } else {
        // Insertar nuevo usuario como 'cliente'
        $rol = 'cliente'; // Todos clientes por defecto. Para admin, actualizar manualmente en BD: UPDATE usuarios SET rol='admin' WHERE email='admin@email.com';
        $stmt = $conexion->prepare("INSERT INTO usuarios (uid, nombre, email, foto_perfile, mail_verificado, fecha_registro, ultima_conexion, estado, rol) VALUES (?, ?, ?, ?, ?, NOW(), NOW(), 'activo', ?)");
        $stmt->bind_param("sssiss", $uid, $nombre, $email, $foto_perfile, $mail_verificado, $rol);
        $stmt->execute();
        $user_id = $conexion->insert_id;
    }

    // Establecer sesión
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_nombre'] = $nombre;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_rol'] = $rol;

    // Determinar redirección
    $redirect = ($rol === 'admin') ? 'admin.php' : 'cliente.php';

    echo json_encode(['success' => true, 'redirect' => $redirect]);
} else {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}
?>