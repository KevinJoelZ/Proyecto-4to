<?php
// Archivo para procesar solicitudes específicas de entrenadores y planes
include '../PHP/conexión.php';

// Verificar que la conexión esté activa
if (!$conexion) {
    die("Error: No se pudo conectar a la base de datos");
}

// Verifica que los datos lleguen por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo_solicitud = isset($_POST['tipo_solicitud']) ? trim($_POST['tipo_solicitud']) : '';
    
    if ($tipo_solicitud === 'entrenador') {
        procesarSolicitudEntrenador($conexion);
    } elseif ($tipo_solicitud === 'plan') {
        procesarSolicitudPlan($conexion);
    } else {
        echo "<script>alert('Tipo de solicitud no válido.'); window.history.back();</script>";
    }
    
    mysqli_close($conexion);
} else {
    // Si no es POST, redirigir a la página principal
    header("Location: index.html");
    exit;
}

function procesarSolicitudEntrenador($conexion) {
    // Validar y limpiar los datos de entrada
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
    $entrenador_id = isset($_POST['entrenador_id']) ? (int)$_POST['entrenador_id'] : 0;
    $entrenador_nombre = isset($_POST['entrenador_nombre']) ? trim($_POST['entrenador_nombre']) : '';
    $especialidad_interes = isset($_POST['especialidad_interes']) ? trim($_POST['especialidad_interes']) : '';
    $mensaje = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';

    // Validaciones básicas
    if (empty($nombre) || empty($email) || empty($mensaje)) {
        echo "<script>alert('Por favor, complete todos los campos obligatorios.'); window.history.back();</script>";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Por favor, ingrese un email válido.'); window.history.back();</script>";
        exit;
    }

    // Determinar la página de origen para redirigir correctamente
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
    $redirect_page = 'entrenadores.html';
    
    if (strpos($referer, 'contacto.html') !== false) {
        $redirect_page = 'contacto.html';
    }

    // Consulta SQL para insertar solicitud de entrenador
    $sql = "INSERT INTO solicitudes_entrenadores (nombre, email, telefono, entrenador_id, entrenador_nombre, especialidad_interes, mensaje, fecha_solicitud) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
    
    // Preparar la consulta
    $stmt = mysqli_prepare($conexion, $sql);
    
    if ($stmt) {
        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "sssisss", $nombre, $email, $telefono, $entrenador_id, $entrenador_nombre, $especialidad_interes, $mensaje);
        
        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo "<script>
                    alert('¡Éxito! Tu solicitud para contactar al entrenador ha sido enviada. Te contactaremos pronto.');
                    window.location.href = '$redirect_page';
                </script>";
            } else {
                echo "<script>alert('Error: No se pudo enviar la solicitud. Por favor, inténtalo de nuevo.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Error al enviar la solicitud: " . mysqli_stmt_error($stmt) . "'); window.history.back();</script>";
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Error en el sistema: " . mysqli_error($conexion) . "'); window.history.back();</script>";
    }
}

function procesarSolicitudPlan($conexion) {
    // Validar y limpiar los datos de entrada
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
    $plan_id = isset($_POST['plan_id']) ? (int)$_POST['plan_id'] : 0;
    $plan_nombre = isset($_POST['plan_nombre']) ? trim($_POST['plan_nombre']) : '';
    $mensaje = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';

    // Validaciones básicas
    if (empty($nombre) || empty($email) || empty($mensaje)) {
        echo "<script>alert('Por favor, complete todos los campos obligatorios.'); window.history.back();</script>";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Por favor, ingrese un email válido.'); window.history.back();</script>";
        exit;
    }

    // Determinar la página de origen para redirigir correctamente
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
    $redirect_page = 'planes.html';
    
    if (strpos($referer, 'contacto.html') !== false) {
        $redirect_page = 'contacto.html';
    }

    // Consulta SQL para insertar solicitud de plan
    $sql = "INSERT INTO solicitudes_planes (nombre, email, telefono, plan_id, plan_nombre, mensaje, fecha_solicitud) VALUES (?, ?, ?, ?, ?, ?, NOW())";
    
    // Preparar la consulta
    $stmt = mysqli_prepare($conexion, $sql);
    
    if ($stmt) {
        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "sssisss", $nombre, $email, $telefono, $plan_id, $plan_nombre, $mensaje);
        
        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo "<script>
                    alert('¡Éxito! Tu solicitud para el plan ha sido enviada. Te contactaremos pronto con más información.');
                    window.location.href = '$redirect_page';
                </script>";
            } else {
                echo "<script>alert('Error: No se pudo enviar la solicitud. Por favor, inténtalo de nuevo.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Error al enviar la solicitud: " . mysqli_stmt_error($stmt) . "'); window.history.back();</script>";
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Error en el sistema: " . mysqli_error($conexion) . "'); window.history.back();</script>";
    }
}
?>
