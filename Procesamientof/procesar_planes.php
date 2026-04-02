<?php
// Procesador dedicado para el formulario de planes
include '../conexión.php';

// Función para obtener fecha/hora de Ecuador (corregir desfase en InfinityFree)
function obtenerFechaHoraEcuador() {
    date_default_timezone_set('America/Guayaquil');
    return date('Y-m-d H:i:s');
}

// Verificar que la conexión esté activa
if (!$conexion) {
    header("Location: ../planes.html?error=1");
    exit;
}

// Verifica que los datos lleguen por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y limpiar los datos de entrada
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
    $motivo = isset($_POST['motivo']) ? trim($_POST['motivo']) : '';
    $mensaje = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';

    // Validaciones básicas
    if (empty($nombre) || empty($email) || empty($motivo) || empty($mensaje)) {
        header("Location: ../planes.html?error=1");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../planes.html?error=1");
        exit;
    }

    // Consulta SQL para insertar en la tabla solicitudes_planes (nombre correcto sin espacios)
    $fechaHora = obtenerFechaHoraEcuador();
    $sql = "INSERT INTO solicitudes_planes (nombre, email, telefono, motivo, mensaje, fecha_solicitud) VALUES (?, ?, ?, ?, ?, ?)";

    // Preparar la consulta
    $stmt = mysqli_prepare($conexion, $sql);

    if ($stmt) {
        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "ssssss", $nombre, $email, $telefono, $motivo, $mensaje, $fechaHora);

        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                mysqli_stmt_close($stmt);
                mysqli_close($conexion);
                header("Location: ../planes.html?success=1");
                exit;
            } else {
                mysqli_stmt_close($stmt);
                mysqli_close($conexion);
                header("Location: ../planes.html?error=1");
                exit;
            }
        } else {
            mysqli_stmt_close($stmt);
            mysqli_close($conexion);
            header("Location: ../planes.html?error=1");
            exit;
        }
    } else {
        mysqli_close($conexion);
        header("Location: ../planes.html?error=1");
        exit;
    }
} else {
    // Si no es POST, redirigir a la página principal
    header("Location: ../index.html");
    exit;
}
?>