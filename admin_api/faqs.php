<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Función para obtener fecha/hora de Ecuador (corregir desfase en InfinityFree)
function obtenerFechaHoraEcuador() {
    date_default_timezone_set('America/Guayaquil');
    return date('Y-m-d H:i:s');
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

require_once __DIR__ . '/../conexion.php';

// Auto-crear tabla faqs si no existe
$conexion->query("CREATE TABLE IF NOT EXISTS faqs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pregunta VARCHAR(255) NOT NULL,
    respuesta TEXT NOT NULL,
    page_slug VARCHAR(64) NOT NULL DEFAULT 'cliente',
    creado_en DATETIME NULL,
    actualizado_en DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

// Asegurar columna page_slug si la tabla existía sin ella
try {
    $colCheck = $conexion->query("SHOW COLUMNS FROM faqs LIKE 'page_slug'");
    if ($colCheck && $colCheck->num_rows === 0) {
        $conexion->query("ALTER TABLE faqs ADD COLUMN page_slug VARCHAR(64) NOT NULL DEFAULT 'cliente'");
    }
} catch (Exception $e) { /* ignore */ }

// Asegurar columna page_slug si la tabla ya existía sin ella
try {
    $colCheck = $conexion->prepare("SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'faqs' AND COLUMN_NAME = 'page_slug'");
    $colCheck->execute();
    $hasCol = $colCheck->get_result()->num_rows > 0;
    if (!$hasCol) {
        $conexion->query("ALTER TABLE faqs ADD COLUMN page_slug VARCHAR(64) NOT NULL DEFAULT 'cliente'");
    }
} catch (Exception $e) {
    // Ignorar errores silenciosamente para no romper
}

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $_GET['action'] ?? $input['action'] ?? 'list';

function sanitize_page($p){
    $p = strtolower(trim((string)$p));
    if ($p === '') return 'cliente';
    // solo letras, números y guiones bajos
    return preg_replace('/[^a-z0-9_\-]/','', $p);
}

try {
    switch ($action) {
        case 'list':
            $page = isset($_GET['page']) ? sanitize_page($_GET['page']) : (isset($input['page']) ? sanitize_page($input['page']) : '');
            if ($page) {
                $stmt = $conexion->prepare("SELECT id, pregunta, respuesta, page_slug, creado_en, actualizado_en FROM faqs WHERE page_slug = ? ORDER BY id DESC");
                $stmt->bind_param('s', $page);
                $stmt->execute();
                $res = $stmt->get_result();
            } else {
                $res = $conexion->query("SELECT id, pregunta, respuesta, page_slug, creado_en, actualizado_en FROM faqs ORDER BY id DESC");
            }
            $faqs = [];
            while ($row = $res->fetch_assoc()) { $faqs[] = $row; }
            echo json_encode(['success' => true, 'items' => $faqs]);
            break;
        case 'create':
            $pregunta = trim($input['pregunta'] ?? '');
            $respuesta = trim($input['respuesta'] ?? '');
            $page_slug = sanitize_page($input['page'] ?? 'cliente');
            if ($pregunta === '' || $respuesta === '') throw new Exception('Pregunta y respuesta son requeridas');
            $fechaHora = obtenerFechaHoraEcuador();
            $stmt = $conexion->prepare("INSERT INTO faqs (pregunta, respuesta, page_slug, creado_en, actualizado_en) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param('sssss', $pregunta, $respuesta, $page_slug, $fechaHora, $fechaHora);
            $stmt->execute();
            echo json_encode(['success' => true, 'id' => $stmt->insert_id]);
            break;
        case 'update':
            $id = intval($input['id'] ?? 0);
            $pregunta = trim($input['pregunta'] ?? '');
            $respuesta = trim($input['respuesta'] ?? '');
            $page_slug = sanitize_page($input['page'] ?? 'cliente');
            if ($id <= 0 || $pregunta === '' || $respuesta === '') throw new Exception('Datos inválidos');
            $fechaHora = obtenerFechaHoraEcuador();
            $stmt = $conexion->prepare("UPDATE faqs SET pregunta = ?, respuesta = ?, page_slug = ?, actualizado_en = ? WHERE id = ?");
            $stmt->bind_param('ssssi', $pregunta, $respuesta, $page_slug, $fechaHora, $id);
            $stmt->execute();
            echo json_encode(['success' => true]);
            break;
        case 'delete':
            $id = intval($input['id'] ?? 0);
            if ($id <= 0) throw new Exception('ID inválido');
            $stmt = $conexion->prepare("DELETE FROM faqs WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            echo json_encode(['success' => true]);
            break;
        default:
            throw new Exception('Acción no soportada');
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
