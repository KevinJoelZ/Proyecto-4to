<?php
$host = 'localhost';
$usuario = 'root';
$contraseña = '';
$base_datos = 'guardarbd';

$conexion = new mysqli($host, $usuario, $contraseña, $base_datos);

if ($conexion->connect_error) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos: ' . $conexion->connect_error]);
    exit;
}

$conexion->set_charset("utf8mb4");
?>