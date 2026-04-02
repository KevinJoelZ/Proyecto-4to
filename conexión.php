<?php
// Configuración para XAMPP local
$host = "localhost";
$user = "root";          // Usuario por defecto de XAMPP
$password = "";          // Contraseña por defecto (vacía en XAMPP)
$database = "plataforma_fitness"; // Base de datos plataforma_fitness

// Crear conexión
$conexion = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión a plataforma_fitness: " . $conexion->connect_error);
}

// Establecer charset a utf8
$conexion->set_charset("utf8");

//echo "Conexión exitosa a plataforma_fitness"; // Para pruebas
?>