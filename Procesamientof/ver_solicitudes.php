<?php
// Archivo para visualizar solicitudes de información en la base de datos
include '../PHP/conexión.php';

// Verificar conexión
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Consulta para obtener todas las solicitudes
$sql = "SELECT * FROM solicitudes_servicios ORDER BY fecha_solicitud DESC";
$resultado = mysqli_query($conexion, $sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes de Información - Admin</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .no-data { text-align: center; color: #666; font-style: italic; padding: 20px; }
        .success { color: green; background: #e8f5e8; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .error { color: red; background: #ffe8e8; padding: 10px; border-radius: 5px; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📋 Solicitudes de Información Recibidas</h1>
        <p>Esta página muestra todas las solicitudes de información enviadas a través del formulario de servicios.</p>
        
        <?php if (mysqli_num_rows($resultado) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Motivo (Servicio/Plan)</th>
                        <th>Mensaje</th>
                        <th>Fecha Solicitud</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['telefono'] ?? 'N/A'); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($row['motivo'])); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($row['mensaje'] ?? 'Sin mensaje')); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($row['fecha_solicitud'])); ?></td>
                            <td>
                                <?php if ($row['estado'] == 'pendiente'): ?>
                                    <span style="color: orange;">Pendiente</span>
                                <?php elseif ($row['estado'] == 'respondido'): ?>
                                    <span style="color: green;">Respondido</span>
                                <?php else: ?>
                                    <span style="color: gray;">Archivado</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <p><strong>Total de solicitudes:</strong> <?php echo mysqli_num_rows($resultado); ?></p>
        <?php else: ?>
            <div class="no-data">No hay solicitudes de información registradas aún.</div>
        <?php endif; ?>
        
        <hr>
        <a href="index.html" style="color: #007bff; text-decoration: none;">← Volver al sitio principal</a>
        <p><em>Accede a esta página en: http://localhost/Página_deportiva/Procesamientof/ver_solicitudes.php</em></p>
    </div>
</body>
</html>
<?php
mysqli_close($conexion);
?>