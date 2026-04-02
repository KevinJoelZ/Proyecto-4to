<?php
/**
 * Script de prueba para verificar que el formulario de entrenamiento
 * envía los datos correctamente al archivo procesar_formularios.php
 */

header('Content-Type: text/html; charset=utf-8');

echo "<h1>Test de Formulario de Entrenamiento</h1>";

// Simular datos del formulario
$_POST['form_type'] = 'entrenamiento';
$_POST['usuario_id'] = 'demo_user';
$_POST['rutina_id'] = '1';
$_POST['nombre_rutina'] = 'Rutina de Prueba';
$_POST['intensidad'] = '8';
$_POST['sensacion'] = 'bien';
$_POST['duracion_real'] = '60';
$_POST['calorias'] = '350';

echo "<h2>Datos del formulario simulados:</h2>";
echo "<ul>";
echo "<li>form_type: " . $_POST['form_type'] . "</li>";
echo "<li>usuario_id: " . $_POST['usuario_id'] . "</li>";
echo "<li>rutina_id: " . $_POST['rutina_id'] . "</li>";
echo "<li>nombre_rutina: " . $_POST['nombre_rutina'] . "</li>";
echo "<li>intensidad: " . $_POST['intensidad'] . "</li>";
echo "<li>sensacion: " . $_POST['sensacion'] . "</li>";
echo "<li>duracion_real: " . $_POST['duracion_real'] . "</li>";
echo "<li>calorias: " . $_POST['calorias'] . "</li>";
echo "</ul>";

// Incluir el archivo de procesamiento de formularios
require_once 'Procesamientof/procesar_formularios.php';

echo "<h2>Resultado del procesamiento:</h2>";
echo "<p>El formulario debería haber procesado los datos y guardado el entrenamiento en la base de datos.</p>";
echo "<p><a href='avance.php'>Ir a la página de avance</a> | <a href='index.php'>Ir al inicio</a></p>";
?>
