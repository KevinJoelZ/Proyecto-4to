<?php
// Configuración para XAMPP local
$host = "localhost";
$user = "root";          // Usuario por defecto de XAMPP
$password = "";          // Contraseña por defecto (vacía en XAMPP)
$database = "guardarbd"; // Nombre de la base de datos local en XAMPP

// Crear conexión
$conexion = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión a XAMPP: " . $conexion->connect_error);
}

// Establecer charset a utf8
$conexion->set_charset("utf8");

//echo "Conexión exitosa a XAMPP"; // Para pruebas
?>