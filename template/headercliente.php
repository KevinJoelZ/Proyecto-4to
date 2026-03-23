<?php
// Obtener la página actual
$pagina_actual = basename($_SERVER['PHP_SELF'], '.php');
?>
<header class="main-header" style="background: linear-gradient(90deg, #1976d2 0%, #1565c0 100%);">
    <nav class="main-nav">
        <div class="logo">
            <i class="fas fa-dumbbell" style="font-size: 2.2rem; color: #ffb74d;"></i>
            <span style="font-size: 1.5rem; color: #fff; font-weight: 700; letter-spacing: 1px;">DeporteFit</span>
        </div>
        <ul class="main-menu" style="display: flex; align-items: center; gap: 5px; list-style: none; margin: 0; padding: 0;">
            <li><a href="cliente.php" <?php echo ($pagina_actual == 'cliente') ? 'class="activo"' : ''; ?> style="padding: 8px 14px; border-radius: 18px; color: #fff; text-decoration: none; font-weight: 500; transition: all 0.3s; white-space: nowrap;">Inicio</a></li>
            <li><a href="servicios.php" <?php echo ($pagina_actual == 'servicios') ? 'class="activo"' : ''; ?> style="padding: 8px 14px; border-radius: 18px; color: #fff; text-decoration: none; font-weight: 500; transition: all 0.3s; white-space: nowrap;">Servicios</a></li>
            <li><a href="trainers.php" <?php echo ($pagina_actual == 'trainers') ? 'class="activo"' : ''; ?> style="padding: 8px 14px; border-radius: 18px; color: #fff; text-decoration: none; font-weight: 500; transition: all 0.3s; white-space: nowrap;">Entrenadores</a></li>
            <li><a href="planes.php" <?php echo ($pagina_actual == 'planes') ? 'class="activo"' : ''; ?> style="padding: 8px 14px; border-radius: 18px; color: #fff; text-decoration: none; font-weight: 500; transition: all 0.3s; white-space: nowrap;">Planes y Precios</a></li>
            <li><a href="avance.php" <?php echo ($pagina_actual == 'avance') ? 'class="activo"' : ''; ?> style="padding: 8px 14px; border-radius: 18px; color: #fff; text-decoration: none; font-weight: 500; transition: all 0.3s; white-space: nowrap;"><i class="fas fa-chart-line" style="margin-right: 4px;"></i>Avance</a></li>
            <li><a href="contacto.php" <?php echo ($pagina_actual == 'contacto') ? 'class="activo"' : ''; ?> style="padding: 8px 14px; border-radius: 18px; color: #fff; text-decoration: none; font-weight: 500; transition: all 0.3s; white-space: nowrap;">Contacto</a></li>
        </ul>
    </nav>
</header>
<style>
.main-menu a.activo {
    background: linear-gradient(90deg, #ff9800, #ffb74d) !important;
    color: #fff !important;
    box-shadow: 0 2px 8px rgba(255, 152, 0, 0.4);
}
.main-menu a:hover:not(.activo) {
    background: rgba(255, 255, 255, 0.15);
}
</style>
