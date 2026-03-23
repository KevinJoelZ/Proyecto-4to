<?php
/**
 * API para obtener estadísticas del dashboard - DeporteFit (POO)
 * 
 * Usa las clases POO: Database, Estadistica
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Obtener usuario
$usuario_id = isset($_GET['usuario_id']) ? $_GET['usuario_id'] : 'demo_user';

// Usar la clase Estadistica POO
require_once __DIR__ . '/Estadistica.php';

$estadistica = new Estadistica();
$stats = $estadistica->getEstadisticasCompletas($usuario_id);

echo json_encode(['success' => true, 'data' => $stats]);
