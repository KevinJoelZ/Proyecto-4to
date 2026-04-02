<?php
// Archivo de verificación del formulario de contacto
echo "<h1>Verificación del Formulario de Contacto</h1>";

// Verificar que los archivos existen
echo "<h2>1. Verificación de archivos:</h2>";

$archivos = [
    'contacto.php' => 'Formulario de contacto',
    'Procesamientof/procesar_formularios.php' => 'Procesador de formularios',
    'conexion.php' => 'Conexión a base de datos'
];

foreach ($archivos as $archivo => $descripcion) {
    if (file_exists($archivo)) {
        echo "<p style='color: green;'>✓ $descripcion ($archivo) existe</p>";
    } else {
        echo "<p style='color: red;'>✗ $descripcion ($archivo) NO existe</p>";
    }
}

// Verificar conexión a base de datos
echo "<h2>2. Verificación de conexión a base de datos:</h2>";
include 'conexion.php';

if ($conexion->connect_error) {
    echo "<p style='color: red;'>✗ Error de conexión: " . $conexion->connect_error . "</p>";
} else {
    echo "<p style='color: green;'>✓ Conexión exitosa a la base de datos 'plataforma_fitness'</p>";
    
    // Verificar si la tabla contactos existe
    $result = $conexion->query("SHOW TABLES LIKE 'contactos'");
    if ($result->num_rows > 0) {
        echo "<p style='color: green;'>✓ La tabla 'contactos' existe</p>";
        
        // Contar registros
        $result = $conexion->query("SELECT COUNT(*) as total FROM contactos");
        $row = $result->fetch_assoc();
        echo "<p>Total de registros: <strong>" . $row['total'] . "</strong></p>";
    } else {
        echo "<p style='color: red;'>✗ La tabla 'contactos' NO existe</p>";
        echo "<p>Ejecuta <a href='ejecutar_crear_tabla_contactos.php'>ejecutar_crear_tabla_contactos.php</a> para crearla.</p>";
    }
}

// Verificar que el formulario tiene los campos correctos
echo "<h2>3. Verificación del formulario:</h2>";
$formulario = file_get_contents('contacto.php');

$campos_requeridos = [
    'name="nombre"' => 'Campo nombre',
    'name="email"' => 'Campo email',
    'name="telefono"' => 'Campo teléfono',
    'name="motivo"' => 'Campo motivo',
    'name="mensaje"' => 'Campo mensaje',
    'name="privacidad"' => 'Campo privacidad',
    'name="form_type"' => 'Campo form_type',
    'value="contacto"' => 'Valor form_type = contacto'
];

foreach ($campos_requeridos as $campo => $descripcion) {
    if (strpos($formulario, $campo) !== false) {
        echo "<p style='color: green;'>✓ $descripcion encontrado</p>";
    } else {
        echo "<p style='color: red;'>✗ $descripcion NO encontrado</p>";
    }
}

// Verificar que el envío AJAX está configurado
echo "<h2>4. Verificación del envío AJAX:</h2>";

$ajax_checks = [
    "fetch('Procesamientof/procesar_formularios.php'" => 'URL de envío AJAX',
    "method: 'POST'" => 'Método POST',
    "body: formData" => 'FormData enviado',
    "response.json()" => 'Respuesta JSON',
    "data.success" => 'Verificación de éxito',
    "showNotification('success'" => 'Mensaje de éxito',
    "showNotification('error'" => 'Mensaje de error'
];

foreach ($ajax_checks as $check => $descripcion) {
    if (strpos($formulario, $check) !== false) {
        echo "<p style='color: green;'>✓ $descripcion encontrado</p>";
    } else {
        echo "<p style='color: red;'>✗ $descripcion NO encontrado</p>";
    }
}

// Verificar que el procesador tiene la función correcta
echo "<h2>5. Verificación del procesador:</h2>";
$procesador = file_get_contents('Procesamientof/procesar_formularios.php');

$procesador_checks = [
    "function procesarFormularioContacto" => 'Función procesarFormularioContacto',
    "case 'contacto':" => 'Case para form_type contacto',
    "INSERT INTO contactos" => 'Inserción en tabla contactos',
    "json_encode(['success' => true" => 'Respuesta JSON de éxito',
    "json_encode(['success' => false" => 'Respuesta JSON de error'
];

foreach ($procesador_checks as $check => $descripcion) {
    if (strpos($procesador, $check) !== false) {
        echo "<p style='color: green;'>✓ $descripcion encontrado</p>";
    } else {
        echo "<p style='color: red;'>✗ $descripcion NO encontrado</p>";
    }
}

// Resumen
echo "<h2>6. Resumen:</h2>";
echo "<p>El formulario de contacto está configurado para:</p>";
<ul>
    <li>Enviar datos a <strong>Procesamientof/procesar_formularios.php</strong> vía AJAX POST</li>
    <li>Incluir el campo <strong>form_type=contacto</strong> para identificar el formulario</li>
    <li>Procesar los datos en la función <strong>procesarFormularioContacto()</strong></li>
    <li>Guardar los datos en la tabla <strong>contactos</strong> de la base de datos</li>
    <li>Devolver una respuesta JSON con <strong>success: true</strong> o <strong>success: false</strong></li>
    <li>Mostrar una notificación de éxito o error al usuario</li>
</ul>

echo "<h2>7. Instrucciones:</h2>";
<ol>
    <li>Asegúrate de que XAMPP (Apache y MySQL) esté ejecutándose</li>
    <li>Si la tabla 'contactos' no existe, ejecuta <a href='ejecutar_crear_tabla_contactos.php'>ejecutar_crear_tabla_contactos.php</a></li>
    <li>Abre <a href='contacto.php'>contacto.php</a> en tu navegador</li>
    <li>Llena el formulario y haz clic en "Enviar Mensaje"</li>
    <li>Deberías ver una notificación de éxito y los datos deberían guardarse en la base de datos</li>
</ol>

<?php
if (isset($conexion)) {
    mysqli_close($conexion);
}
?>
