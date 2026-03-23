<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

require_once __DIR__ . '/../conexion.php';

// Auto-crear tabla de estadísticas si no existe
$conexion->query("CREATE TABLE IF NOT EXISTS site_stats (
  id INT AUTO_INCREMENT PRIMARY KEY,
  stat_key VARCHAR(64) UNIQUE,
  stat_value VARCHAR(255) NOT NULL,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

// Pre-cargar claves por defecto si están ausentes
$defaults = [
  'deportes' => '10+',
  'entrenadores' => '30+',
  'alumnos' => '300+',
  'alumnos_activos' => '250+',
  'soporte' => '24/7'
];
foreach ($defaults as $k => $v) {
  $stmt = $conexion->prepare("INSERT IGNORE INTO site_stats (stat_key, stat_value) VALUES (?, ?)");
  $stmt->bind_param('ss', $k, $v);
  $stmt->execute();
}

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $_GET['action'] ?? $input['action'] ?? 'get';

try {
  if ($action === 'get') {
    $res = $conexion->query("SELECT stat_key, stat_value FROM site_stats");
    $stats = [];
    while ($row = $res->fetch_assoc()) { $stats[$row['stat_key']] = $row['stat_value']; }
    echo json_encode(['success' => true, 'stats' => $stats]);
  } elseif ($action === 'set') {
    $stats = $input['stats'] ?? [];
    if (!is_array($stats)) throw new Exception('Formato inválido');
    $stmt = $conexion->prepare("INSERT INTO site_stats (stat_key, stat_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE stat_value = VALUES(stat_value)");
    foreach ($stats as $k => $v) {
      $key = substr(trim($k), 0, 64);
      $val = substr(trim((string)$v), 0, 255);
      $stmt->bind_param('ss', $key, $val);
      $stmt->execute();
    }
    echo json_encode(['success' => true]);
  } else {
    throw new Exception('Acción no soportada');
  }
} catch (Exception $e) {
  http_response_code(400);
  echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
