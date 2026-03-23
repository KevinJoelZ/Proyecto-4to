<?php
// Incluir archivo de conexión
include '../PHP/conexión.php';

// Verificar que la conexión esté activa
if (!$conexion) {
    die("Error: No se pudo conectar a la base de datos");
}

// Verifica que los datos lleguen por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y limpiar los datos de entrada
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
    $servicio = isset($_POST['servicio']) ? trim($_POST['servicio']) : '';
    $plan = isset($_POST['plan']) ? trim($_POST['plan']) : '';
    $mensaje = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';
    $fecha_solicitud = date('Y-m-d H:i:s');

    // Validaciones básicas
    if (empty($nombre) || empty($email) || empty($servicio)) {
        echo "<script>alert('Por favor, complete los campos obligatorios (nombre, email y servicio).'); window.history.back();</script>";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Por favor, ingrese un email válido.'); window.history.back();</script>";
        exit;
    }

    // Consulta SQL para insertar solicitud de información
    $sql = "INSERT INTO solicitudes_servicios (nombre, email, telefono, motivo, mensaje, fecha_solicitud, estado) VALUES (?, ?, ?, ?, ?, ?, 'pendiente')";
    
    // Preparar la consulta
    $stmt = mysqli_prepare($conexion, $sql);
    
    if ($stmt) {
        // Concatenar servicio y plan en motivo
        $motivo = "Servicio: " . $servicio . " - Plan: " . ($plan ?: 'No especificado');
        
        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "ssssss", $nombre, $email, $telefono, $motivo, $mensaje, $fecha_solicitud);
        
        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            // Verificar que realmente se insertó
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                // Obtener el ID de la solicitud insertada
                $id_solicitud = mysqli_insert_id($conexion);
                
                echo "<script>
                    alert('¡Éxito! Tu solicitud de información ha sido registrada correctamente. ID de solicitud: " . $id_solicitud . ". Te contactaremos pronto.');
                    window.location.href = 'servicios.html';
                </script>";
            } else {
                echo "<script>alert('Error: No se pudo registrar la solicitud en la base de datos.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Error al ejecutar la consulta: " . mysqli_stmt_error($stmt) . "'); window.history.back();</script>";
        }
        
        // Cerrar el statement
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Error en la preparación de la consulta: " . mysqli_error($conexion) . "'); window.history.back();</script>";
    }
    
    // Cerrar la conexión
    mysqli_close($conexion);
    
} else {
    // Si no es POST, redirigir a la página de servicios
    header("Location: servicios.html");
    exit;
}
?>
