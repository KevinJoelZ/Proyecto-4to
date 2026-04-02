<?php
// API para obtener historial de progresos
header('Content-Type: application/json');

// Incluir conexión
require_once '../conexion.php';

// Verificar si es una petición POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['action']) && $data['action'] === 'cargar_historial_progresos') {
        $usuario_id = isset($data['usuario_id']) ? $data['usuario_id'] : 'demo_user';
        
        try {
            $historial = [];
            
            // Cargar progresos de peso
            $sql = "SELECT id, peso, fecha_medicion, notas, fecha_creacion
                    FROM progresos_peso 
                    WHERE usuario_id = ? 
                    ORDER BY fecha_medicion DESC 
                    LIMIT 10";
            
            $stmt = mysqli_prepare($conexion, $sql);
            mysqli_stmt_bind_param($stmt, "s", $usuario_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            $pesos = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $pesos[] = [
                    'id' => $row['id'],
                    'peso' => $row['peso'],
                    'fecha_medicion' => $row['fecha_medicion'],
                    'notas' => $row['notas'],
                    'fecha_creacion' => $row['fecha_creacion'],
                    'tipo' => 'peso'
                ];
            }
            mysqli_stmt_close($stmt);
            
            // Cargar medidas corporales
            $sql = "SELECT id, fecha_medicion, pecho, cintura, cadera, biceps, pierna, notas, fecha_creacion
                    FROM medidas_corporales 
                    WHERE usuario_id = ? 
                    ORDER BY fecha_medicion DESC 
                    LIMIT 10";
            
            $stmt = mysqli_prepare($conexion, $sql);
            mysqli_stmt_bind_param($stmt, "s", $usuario_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            $medidas = [];
            while ($row = mysqli_fetch_assoc($result)) {
                // Asegurar que la fecha sea válida y formatearla correctamente
                $fecha_medicion = $row['fecha_medicion'];
                if ($fecha_medicion && $fecha_medicion !== '0000-00-00') {
                    // Convertir a objeto DateTime para mejor manejo
                    try {
                        $date_obj = new DateTime($fecha_medicion);
                        $fecha_formateada = $date_obj->format('Y-m-d');
                    } catch (Exception $e) {
                        // Si hay error al parsear la fecha, usar fecha actual
                        $fecha_formateada = date('Y-m-d');
                    }
                } else {
                    // Si la fecha es null o inválida, usar fecha actual
                    $fecha_formateada = date('Y-m-d');
                }
                
                $medidas[] = [
                    'id' => $row['id'],
                    'fecha_medicion' => $fecha_formateada,
                    'pecho' => $row['pecho'],
                    'cintura' => $row['cintura'],
                    'cadera' => $row['cadera'],
                    'biceps' => $row['biceps'],
                    'pierna' => $row['pierna'],
                    'notas' => $row['notas'],
                    'fecha_creacion' => $row['fecha_creacion'],
                    'tipo' => 'medidas'
                ];
            }
            mysqli_stmt_close($stmt);
            
            // Cargar entrenamientos realizados (opcional - la tabla puede no existir)
            $entrenamientos = [];
            
            // Verificar si la tabla existe antes de consultar
            $check_table = mysqli_query($conexion, "SHOW TABLES LIKE 'entrenamientos_realizados'");
            if (mysqli_num_rows($check_table) > 0) {
                $sql = "SELECT id, rutina_id, nombre_rutina, intensidad, sensacion, duracion_real, calorias, fecha_entrenamiento
                        FROM entrenamientos_realizados 
                        WHERE usuario_id = ? 
                        ORDER BY fecha_entrenamiento DESC 
                        LIMIT 10";
                
                $stmt = mysqli_prepare($conexion, $sql);
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "s", $usuario_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        $entrenamientos[] = [
                            'id' => $row['id'],
                            'rutina_id' => $row['rutina_id'],
                            'nombre_rutina' => $row['nombre_rutina'],
                            'intensidad' => $row['intensidad'],
                            'sensacion' => $row['sensacion'],
                            'duracion_real' => $row['duracion_real'],
                            'calorias' => $row['calorias'],
                            'fecha_entrenamiento' => $row['fecha_entrenamiento'],
                            'tipo' => 'entrenamiento'
                        ];
                    }
                    mysqli_stmt_close($stmt);
                }
            }
            
            echo json_encode([
                'success' => true,
                'pesos' => $pesos,
                'medidas' => $medidas,
                'entrenamientos' => $entrenamientos
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error al cargar historial de progresos: ' . $e->getMessage()
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Acción no válida'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
}
?>
