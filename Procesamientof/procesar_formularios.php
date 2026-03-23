<?php
// Archivo para procesar formularios según la página de origen
include '../conexión.php';

// Verificar que la conexión esté activa
if (!$conexion) {
    die("Error: No se pudo conectar a la base de datos");
}

// Verifica que los datos lleguen por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar form_type hidden si existe
    if (isset($_POST['form_type'])) {
        switch ($_POST['form_type']) {
            case 'planes':
                procesarFormularioPlanes($conexion);
                mysqli_close($conexion);
                exit;
            case 'servicios':
                procesarFormularioServicios($conexion);
                mysqli_close($conexion);
                exit;
            case 'entrenadores':
                procesarFormularioEntrenadores($conexion);
                mysqli_close($conexion);
                exit;
            case 'contacto':
                procesarFormularioContacto($conexion);
                mysqli_close($conexion);
                exit;
            // Agregar más cases si se implementan hidden fields en otros formularios
        }
    }

    // Fallback a referer si no hay form_type
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
    
    // Determinar qué tipo de formulario es y procesarlo
    if (strpos($referer, 'contacto.html') !== false) {
        procesarFormularioContacto($conexion);
    } elseif (strpos($referer, 'entrenadores.html') !== false) {
        procesarFormularioEntrenadores($conexion);
    } elseif (strpos($referer, 'planes.html') !== false) {
        procesarFormularioPlanes($conexion);
    } elseif (strpos($referer, 'servicios.html') !== false) {
        procesarFormularioServicios($conexion);
    } else {
        // Si no se puede determinar, usar el formulario general
        procesarFormularioGeneral($conexion);
    }
    
    mysqli_close($conexion);
} else {
    // Si no es POST, redirigir a la página principal (cliente.php)
    header("Location: ../cliente.php");
    exit;
}

function procesarFormularioContacto($conexion) {
    // Validar y limpiar los datos de entrada
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
    $motivo = isset($_POST['motivo']) ? trim($_POST['motivo']) : '';
    $mensaje = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';
    $privacidad = isset($_POST['privacidad']) ? 1 : 0;

    // Validaciones básicas
    if (empty($nombre) || empty($email) || empty($motivo) || empty($mensaje) || !$privacidad) {
        header("Location: ../contacto.html?error=1");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../contacto.html?error=1");
        exit;
    }

    // Consulta SQL para insertar en la tabla contactos
    $sql = "INSERT INTO contactos (nombre, email, telefono, motivo, mensaje, privacidad, fecha_creacion) VALUES (?, ?, ?, ?, ?, ?, NOW())";
    
    // Preparar la consulta
    $stmt = mysqli_prepare($conexion, $sql);
    
    if ($stmt) {
        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "sssssi", $nombre, $email, $telefono, $motivo, $mensaje, $privacidad);
        
        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                header("Location: ../contacto.html?success=1");
                exit;
            } else {
                header("Location: ../contacto.html?error=1");
                exit;
            }
        } else {
            header("Location: ../contacto.html?error=1");
            exit;
        }
        
        mysqli_stmt_close($stmt);
    } else {
        header("Location: ../contacto.html?error=1");
        exit;
    }
}

function procesarFormularioEntrenadores($conexion) {
    // Validar y limpiar los datos de entrada
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
    $motivo = isset($_POST['motivo']) ? trim($_POST['motivo']) : '';
    $mensaje = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';

    // Validaciones básicas
    if (empty($nombre) || empty($email) || empty($motivo) || empty($mensaje)) {
        header("Location: ../entrenadores.html?error=1");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../entrenadores.html?error=1");
        exit;
    }

    // Consulta SQL para insertar en la tabla solicitudes_entrenadores
    $sql = "INSERT INTO solicitudes_entrenadores (nombre, email, telefono, motivo, mensaje, fecha_solicitud) VALUES (?, ?, ?, ?, ?, NOW())";
    
    // Preparar la consulta
    $stmt = mysqli_prepare($conexion, $sql);
    
    if ($stmt) {
        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "sssss", $nombre, $email, $telefono, $motivo, $mensaje);
        
        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                header("Location: ../entrenadores.html?success=1");
                exit;
            } else {
                header("Location: ../entrenadores.html?error=1");
                exit;
            }
        } else {
            header("Location: ../entrenadores.html?error=1");
            exit;
        }
        
        mysqli_stmt_close($stmt);
    } else {
        header("Location: ../entrenadores.html?error=1");
        exit;
    }
}

function procesarFormularioPlanes($conexion) {
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

    // Consulta SQL para insertar en la tabla solicitudes_planes
    $sql = "INSERT INTO solicitudes_planes (nombre, email, telefono, motivo, mensaje, fecha_solicitud) VALUES (?, ?, ?, ?, ?, NOW())";
    
    // Preparar la consulta
    $stmt = mysqli_prepare($conexion, $sql);
    
    if ($stmt) {
        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "sssss", $nombre, $email, $telefono, $motivo, $mensaje);
        
        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                header("Location: ../planes.html?success=1");
                exit;
            } else {
                header("Location: ../planes.html?error=1");
                exit;
            }
        } else {
            header("Location: ../planes.html?error=1");
            exit;
        }
        
        mysqli_stmt_close($stmt);
    } else {
        header("Location: ../planes.html?error=1");
        exit;
    }
}

function procesarFormularioServicios($conexion) {
    // Validar y limpiar los datos de entrada
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
    $motivo = isset($_POST['motivo']) ? trim($_POST['motivo']) : '';
    $mensaje = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';

    // Validaciones básicas
    if (empty($nombre) || empty($email) || empty($motivo) || empty($mensaje)) {
        header("Location: ../servicios.html?error=1");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../servicios.html?error=1");
        exit;
    }

    // Consulta SQL para insertar en la tabla solicitudes_servicios
    $sql = "INSERT INTO solicitudes_servicios (nombre, email, telefono, motivo, mensaje, fecha_solicitud) VALUES (?, ?, ?, ?, ?, NOW())";
    
    // Preparar la consulta
    $stmt = mysqli_prepare($conexion, $sql);
    
    if ($stmt) {
        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "sssss", $nombre, $email, $telefono, $motivo, $mensaje);
        
        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                header("Location: ../servicios.html?success=1");
                exit;
            } else {
                header("Location: ../servicios.html?error=1");
                exit;
            }
        } else {
            header("Location: ../servicios.html?error=1");
            exit;
        }
        
        mysqli_stmt_close($stmt);
    } else {
        header("Location: ../servicios.html?error=1");
        exit;
    }
}

function procesarFormularioGeneral($conexion) {
    // Validar y limpiar los datos de entrada
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
    $motivo = isset($_POST['motivo']) ? trim($_POST['motivo']) : '';
    $mensaje = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';

    // Validaciones básicas
    if (empty($nombre) || empty($email) || empty($motivo) || empty($mensaje)) {
        header("Location: ../cliente.php?error=1");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../cliente.php?error=1");
        exit;
    }

    // Consulta SQL para insertar en la tabla contactos (tabla general)
    $sql = "INSERT INTO contactos (nombre, email, telefono, motivo, mensaje, privacidad, fecha_creacion) VALUES (?, ?, ?, ?, ?, 0, NOW())";
    
    // Preparar la consulta
    $stmt = mysqli_prepare($conexion, $sql);
    
    if ($stmt) {
        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "sssss", $nombre, $email, $telefono, $motivo, $mensaje);
        
        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                header("Location: ../cliente.php?success=1");
                exit;
            } else {
                header("Location: ../cliente.php?error=1");
                exit;
            }
        } else {
            header("Location: ../cliente.php?error=1");
            exit;
        }
        
        mysqli_stmt_close($stmt);
    } else {
        header("Location: ../index.html?error=1");
        exit;
    }
}
?>
