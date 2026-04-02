<?php
// ============================================
// CONFIGURACIÓN PARA INFINITYFREE
// ============================================
// Reemplaza estos valores con los datos de tu cuenta de InfinityFree

// Datos de conexión MySQL de InfinityFree
// Encuéntralos en: Control Panel → MySQL Databases
$host = "sqlXXX.epizy.com";           // MySQL Host
$user = "epiz_XXXXX";                  // MySQL Username
$password = "tu_contraseña_aquí";      // MySQL Password
$database = "epiz_XXXXX_plataforma_fitness"; // MySQL Database Name

// Crear conexión
$conexion = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Establecer charset a utf8
$conexion->set_charset("utf8");

//echo "Conexión exitosa a InfinityFree"; // Para pruebas
?>
