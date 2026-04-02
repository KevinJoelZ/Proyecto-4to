<?php
// Configuración para InfinityFree
$host = "sql107.infinityfree.com";
$user = "if0_39340780";
$password = "Vd30M31z3a";
$database = "if0_39340780_base_datos";

// Crear conexión
$conexion = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Establecer charset a utf8mb4
$conexion->set_charset("utf8mb4");
?>
