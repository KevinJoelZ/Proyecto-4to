<?php
// Función para cargar rutinas disponibles
header('Content-Type: application/json');

// Incluir conexión
require_once '../conexión.php';

// Verificar si es una petición POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['action']) && $data['action'] === 'cargar_rutinas') {
        $usuario_id = isset($data['usuario_id']) ? $data['usuario_id'] : 'demo_user';
        
        try {
            // Consultar rutinas del usuario
            $sql = "SELECT id, nombre, tipo, dificultad, duracion, fecha_creacion 
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
                    'fecha_creacion' => $row['fecha_creacion']
                ];
            }
            
            mysqli_stmt_close($stmt);
            
            echo json_encode([
                'success' => true,
                'rutinas' => $rutinas
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error al cargar rutinas: ' . $e->getMessage()
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
