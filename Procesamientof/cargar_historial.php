<?php
// API para obtener historial de rutinas y ejercicios
header('Content-Type: application/json');

// Incluir conexión
require_once '../conexión.php';

// Verificar si es una petición POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['action']) && $data['action'] === 'cargar_historial') {
        $usuario_id = isset($data['usuario_id']) ? $data['usuario_id'] : 'demo_user';
        
        try {
            $historial = [];
            
            // Cargar rutinas del usuario
            $sql = "SELECT id, nombre, tipo, dificultad, duracion, notas, fecha_creacion, estado
                    FROM rutinas 
                    WHERE usuario_id = ? 
                    ORDER BY fecha_creacion DESC";
            
            $stmt = mysqli_prepare($conexion, $sql);
            mysqli_stmt_bind_param($stmt, "s", $usuario_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            $rutinas = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $rutinas[] = [
                    'id' => $row['id'],
                    'nombre' => $row['nombre'],
                    'tipo' => $row['tipo'],
                    'dificultad' => $row['dificultad'],
                    'duracion' => $row['duracion'],
                    'notas' => $row['notas'],
                    'fecha_creacion' => $row['fecha_creacion'],
                    'estado' => $row['estado']
                ];
            }
            mysqli_stmt_close($stmt);
            
            // Cargar ejercicios del usuario
            $sql = "SELECT e.id, e.rutina_id, e.nombre, e.series, e.repeticiones, e.peso, e.descanso, e.fecha_creacion, r.nombre as nombre_rutina
                    FROM ejercicios e
                    LEFT JOIN rutinas r ON e.rutina_id = r.id
                    WHERE r.usuario_id = ? 
                    ORDER BY e.fecha_creacion DESC";
            
            $stmt = mysqli_prepare($conexion, $sql);
            mysqli_stmt_bind_param($stmt, "s", $usuario_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            $ejercicios = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $ejercicios[] = [
                    'id' => $row['id'],
                    'rutina_id' => $row['rutina_id'],
                    'nombre' => $row['nombre'],
                    'series' => $row['series'],
                    'repeticiones' => $row['repeticiones'],
                    'peso' => $row['peso'],
                    'descanso' => $row['descanso'],
                    'fecha_creacion' => $row['fecha_creacion'],
                    'nombre_rutina' => $row['nombre_rutina']
                ];
            }
            mysqli_stmt_close($stmt);
            
            echo json_encode([
                'success' => true,
                'rutinas' => $rutinas,
                'ejercicios' => $ejercicios
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error al cargar historial: ' . $e->getMessage()
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
