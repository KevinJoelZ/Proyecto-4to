<?php
// Archivo para procesar formularios según la página de origen
include __DIR__ . '/../conexion.php';

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
            case 'rutina':
                procesarFormularioRutina($conexion);
                mysqli_close($conexion);
                exit;
            case 'ejercicio':
                procesarFormularioEjercicio($conexion);
                mysqli_close($conexion);
                exit;
            case 'peso':
                procesarFormularioPeso($conexion);
                mysqli_close($conexion);
                exit;
            case 'medidas':
                procesarFormularioMedidas($conexion);
                mysqli_close($conexion);
                exit;
            case 'entrenamiento':
                procesarFormularioEntrenamiento($conexion);
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
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Por favor, completa todos los campos obligatorios y acepta la política de privacidad.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Por favor, ingresa un correo electrónico válido.']);
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
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => '¡Éxito! Tu mensaje de contacto ha sido enviado. Te contactaremos pronto.']);
                exit;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Hubo un error al guardar tu mensaje. Inténtalo nuevamente.']);
                exit;
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Hubo un error al procesar tu solicitud. Inténtalo nuevamente.']);
            exit;
        }
        
        mysqli_stmt_close($stmt);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Error en la base de datos. Inténtalo más tarde.']);
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
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Por favor, completa todos los campos obligatorios.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Por favor, ingresa un correo electrónico válido.']);
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
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => '¡Éxito! Tu solicitud de entrenador ha sido enviada. Te contactaremos pronto.']);
                exit;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Hubo un error al enviar tu solicitud. Inténtalo nuevamente.']);
                exit;
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Hubo un error al procesar tu solicitud. Inténtalo nuevamente.']);
            exit;
        }
        
        mysqli_stmt_close($stmt);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Error en la base de datos. Inténtalo más tarde.']);
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
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Por favor, completa todos los campos obligatorios.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Por favor, ingresa un correo electrónico válido.']);
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
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => '¡Éxito! Tu solicitud de plan ha sido enviada. Te contactaremos pronto.']);
                exit;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Hubo un error al enviar tu solicitud. Inténtalo nuevamente.']);
                exit;
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Hubo un error al procesar tu solicitud. Inténtalo nuevamente.']);
            exit;
        }
        
        mysqli_stmt_close($stmt);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Error en la base de datos. Inténtalo más tarde.']);
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
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Por favor, completa todos los campos obligatorios.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Por favor, ingresa un correo electrónico válido.']);
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
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => '¡Éxito! Tu solicitud de servicio ha sido enviada. Te contactaremos pronto.']);
                exit;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Hubo un error al enviar tu solicitud. Inténtalo nuevamente.']);
                exit;
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Hubo un error al procesar tu solicitud. Inténtalo nuevamente.']);
            exit;
        }
        
        mysqli_stmt_close($stmt);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Error en la base de datos. Inténtalo más tarde.']);
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

function procesarFormularioRutina($conexion) {
    // Validar y limpiar los datos de entrada
    $usuario_id = isset($_POST['usuario_id']) ? trim($_POST['usuario_id']) : 'demo_user';
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $tipo = isset($_POST['tipo']) ? trim($_POST['tipo']) : '';
    $dificultad = isset($_POST['dificultad']) ? trim($_POST['dificultad']) : '';
    $duracion = isset($_POST['duracion']) ? intval($_POST['duracion']) : 0;
    $notas = isset($_POST['notas']) ? trim($_POST['notas']) : '';

    // Validaciones básicas
    if (empty($nombre) || empty($tipo) || empty($dificultad) || $duracion <= 0) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Por favor, completa todos los campos obligatorios de la rutina.']);
        exit;
    }

    // Consulta SQL para insertar en la tabla rutinas
    $sql = "INSERT INTO rutinas (usuario_id, nombre, tipo, dificultad, duracion, notas, fecha_creacion, estado) VALUES (?, ?, ?, ?, ?, ?, NOW(), 'activa')";
    
    // Preparar la consulta
    $stmt = mysqli_prepare($conexion, $sql);
    
    if ($stmt) {
        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "ssssis", $usuario_id, $nombre, $tipo, $dificultad, $duracion, $notas);
        
        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => '¡Éxito! Tu rutina ha sido creada. Puedes agregar ejercicios ahora.']);
                exit;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Hubo un error al crear tu rutina. Inténtalo nuevamente.']);
                exit;
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Hubo un error al procesar tu rutina. Inténtalo nuevamente.']);
            exit;
        }
        
        mysqli_stmt_close($stmt);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Error en la base de datos. Inténtalo más tarde.']);
        exit;
    }
}

function procesarFormularioEjercicio($conexion) {
    // Validar y limpiar los datos de entrada
    $rutina_id = isset($_POST['rutina_id']) ? intval($_POST['rutina_id']) : 0;
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $series = isset($_POST['series']) ? intval($_POST['series']) : 0;
    $repeticiones = isset($_POST['repeticiones']) ? intval($_POST['repeticiones']) : 0;
    $peso = isset($_POST['peso']) && $_POST['peso'] !== '' ? floatval($_POST['peso']) : null;
    $descanso = isset($_POST['descanso']) ? intval($_POST['descanso']) : 60;

    // Validaciones básicas
    if (empty($nombre) || $rutina_id <= 0 || $series <= 0 || $repeticiones <= 0) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Por favor, completa todos los campos obligatorios del ejercicio.']);
        exit;
    }

    // Consulta SQL para insertar en la tabla ejercicios
    $sql = "INSERT INTO ejercicios (rutina_id, nombre, series, repeticiones, peso, descanso, fecha_creacion) VALUES (?, ?, ?, ?, ?, ?, NOW())";
    
    // Preparar la consulta
    $stmt = mysqli_prepare($conexion, $sql);
    
    if ($stmt) {
        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "isiiid", $rutina_id, $nombre, $series, $repeticiones, $peso, $descanso);
        
        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => '¡Éxito! El ejercicio ha sido agregado a tu rutina.']);
                exit;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Hubo un error al agregar el ejercicio. Inténtalo nuevamente.']);
                exit;
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Hubo un error al procesar el ejercicio. Inténtalo nuevamente.']);
            exit;
        }
        
        mysqli_stmt_close($stmt);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Error en la base de datos. Inténtalo más tarde.']);
        exit;
    }
}

function procesarFormularioPeso($conexion) {
    // Validar y limpiar los datos de entrada
    $usuario_id = isset($_POST['usuario_id']) ? trim($_POST['usuario_id']) : 'demo_user';
    $peso = isset($_POST['peso']) ? floatval($_POST['peso']) : 0;
    $fecha_medicion = isset($_POST['fecha_medicion']) ? trim($_POST['fecha_medicion']) : date('Y-m-d');
    $notas = isset($_POST['notas']) ? trim($_POST['notas']) : '';

    // Validaciones básicas
    if ($peso <= 0 || $peso > 300) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'El peso debe estar entre 0.1 y 300 kg.']);
        exit;
    }

    // Consulta SQL para insertar en la tabla progreses_peso
    $sql = "INSERT INTO progresos_peso (usuario_id, peso, fecha_medicion, notas, fecha_creacion) VALUES (?, ?, ?, ?, NOW())";
    
    // Preparar la consulta
    $stmt = mysqli_prepare($conexion, $sql);
    
    if ($stmt) {
        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "sdss", $usuario_id, $peso, $fecha_medicion, $notas);
        
        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => '¡Éxito! Tu peso ha sido registrado.']);
                exit;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Hubo un error al registrar tu peso. Inténtalo nuevamente.']);
                exit;
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Hubo un error al procesar tu peso. Inténtalo nuevamente.']);
            exit;
        }
        
        mysqli_stmt_close($stmt);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Error en la base de datos. Inténtalo más tarde.']);
        exit;
    }
}

function procesarFormularioMedidas($conexion) {
    // Validar y limpiar los datos de entrada
    $usuario_id = isset($_POST['usuario_id']) ? trim($_POST['usuario_id']) : 'demo_user';
    $fecha_medicion = isset($_POST['fecha_medicion']) ? trim($_POST['fecha_medicion']) : date('Y-m-d');
    $pecho = isset($_POST['pecho']) && $_POST['pecho'] !== '' ? floatval($_POST['pecho']) : null;
    $cintura = isset($_POST['cintura']) && $_POST['cintura'] !== '' ? floatval($_POST['cintura']) : null;
    $cadera = isset($_POST['cadera']) && $_POST['cadera'] !== '' ? floatval($_POST['cadera']) : null;
    $biceps = isset($_POST['biceps']) && $_POST['biceps'] !== '' ? floatval($_POST['biceps']) : null;
    $pierna = isset($_POST['pierna']) && $_POST['pierna'] !== '' ? floatval($_POST['pierna']) : null;
    $notas = isset($_POST['notas']) ? trim($_POST['notas']) : '';

    // Validaciones básicas - al menos una medida debe estar presente
    if ($pecho === null && $cintura === null && $cadera === null && $biceps === null && $pierna === null) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Debes registrar al menos una medida corporal.']);
        exit;
    }

    // Consulta SQL para insertar en la tabla medidas_corporales
    $sql = "INSERT INTO medidas_corporales (usuario_id, fecha_medicion, pecho, cintura, cadera, biceps, pierna, notas, fecha_creacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    
    // Preparar la consulta
    $stmt = mysqli_prepare($conexion, $sql);
    
    if ($stmt) {
        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "sdddddss", $usuario_id, $fecha_medicion, $pecho, $cintura, $cadera, $biceps, $pierna, $notas);
        
        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => '¡Éxito! Tus medidas corporales han sido registradas.']);
                exit;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Hubo un error al registrar tus medidas. Inténtalo nuevamente.']);
                exit;
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Hubo un error al procesar tus medidas. Inténtalo nuevamente.']);
            exit;
        }
        
        mysqli_stmt_close($stmt);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Error en la base de datos. Inténtalo más tarde.']);
        exit;
    }
}

function procesarFormularioEntrenamiento($conexion) {
    // Validar y limpiar los datos de entrada
    $usuario_id = isset($_POST['usuario_id']) ? trim($_POST['usuario_id']) : 'demo_user';
    $rutina_id = isset($_POST['rutina_id']) ? intval($_POST['rutina_id']) : null;
    $nombre_rutina = isset($_POST['nombre_rutina']) ? trim($_POST['nombre_rutina']) : '';
    $intensidad = isset($_POST['intensidad']) ? intval($_POST['intensidad']) : 5;
    $sensacion = isset($_POST['sensacion']) ? trim($_POST['sensacion']) : '';
    $duracion_real = isset($_POST['duracion_real']) && $_POST['duracion_real'] !== '' ? intval($_POST['duracion_real']) : null;
    $calorias = isset($_POST['calorias']) && $_POST['calorias'] !== '' ? intval($_POST['calorias']) : null;

    // Validaciones básicas
    if (empty($nombre_rutina) || empty($sensacion)) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Por favor, completa todos los campos obligatorios del entrenamiento.']);
        exit;
    }

    if ($intensidad < 1 || $intensidad > 10) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'La intensidad debe estar entre 1 y 10.']);
        exit;
    }

    // Consulta SQL para insertar en la tabla entrenamientos_realizados
    $sql = "INSERT INTO entrenamientos_realizados (usuario_id, rutina_id, nombre_rutina, intensidad, sensacion, duracion_real, calorias, fecha_entrenamiento) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
    
    // Preparar la consulta
    $stmt = mysqli_prepare($conexion, $sql);
    
    if ($stmt) {
        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "sisisiii", $usuario_id, $rutina_id, $nombre_rutina, $intensidad, $sensacion, $duracion_real, $calorias);
        
        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => '¡Éxito! Tu entrenamiento ha sido registrado.']);
                exit;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Hubo un error al registrar tu entrenamiento. Inténtalo nuevamente.']);
                exit;
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Error en la base de datos al procesar el entrenamiento.']);
            exit;
        }
        
        mysqli_stmt_close($stmt);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Error en la base de datos al preparar el entrenamiento.']);
        exit;
    }
}
?>
