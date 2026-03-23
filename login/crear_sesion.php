<?php
session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

require_once __DIR__ . '/../conexion.php';

try {
    $input = json_decode(file_get_contents('php://input'), true) ?? [];
    $uid = isset($input['uid']) ? trim($input['uid']) : '';
    if ($uid === '') throw new Exception('UID requerido');

    $stmt = $conexion->prepare("SELECT id, uid, nombre, email, rol, ultima_conexion FROM usuarios WHERE uid = ? LIMIT 1");
    $stmt->bind_param('s', $uid);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows === 0) throw new Exception('Usuario no encontrado');
    $user = $res->fetch_assoc();

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_nombre'] = $user['nombre'] ?: $user['email'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_rol'] = $user['rol'];

    echo json_encode(['success' => true, 'rol' => $user['rol']]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
