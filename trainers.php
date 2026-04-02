<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrenadores | Entrenamiento Deportivo</title>
    <link rel="icon" type="image/svg+xml" href="favicon.svg">
    <link rel="stylesheet" href="css/estilos.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body style="background: linear-gradient(180deg, #f7fbff 0%, #e3f0ff 100%);">

<!-- Notificación Toast -->
<div id="notification" class="notification hidden">
    <span id="notification-message"></span>
    <button id="close-notification" style="background: none; border: none; font-size: 1.2rem; cursor: pointer; color: inherit; padding: 0 0.5rem; float: right;">&times;</button>
</div>

<style>
.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    min-width: 300px;
    max-width: 400px;
    padding: 1rem 1.5rem;
    border-radius: 0.5rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    z-index: 1000;
    transform: translateX(100%);
    transition: transform 0.3s ease, opacity 0.3s ease;
    font-family: Arial, sans-serif;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.notification.show {
    transform: translateX(0);
    opacity: 1;
}
.notification.hidden {
    opacity: 0;
    transform: translateX(100%);
}
.notification.success {
    background: linear-gradient(135deg, #4caf50, #45a049);
    color: white;
    border-left: 4px solid #81c784;
}
.notification.error {
    background: linear-gradient(135deg, #f44336, #da190b);
    color: white;
    border-left: 4px solid #ef5350;
}
@media (max-width: 480px) {
    .notification {
        top: 10px;
        right: 10px;
        left: 10px;
        min-width: auto;
    }
}
</style>
<?php include_once __DIR__ . '/template/headercliente.php'; ?>
                <div class="servicios-grid mejorado" style="display: flex; flex-direction: column; gap: 2rem; justify-content: center; align-items: center; max-width: 1000px; margin: 0 auto calc(2rem - 2cm) auto; padding: 1.5rem 1rem;">
                    <!-- Primera fila -->
                    <div style="display: flex; gap: 2.5rem; justify-content: center; flex-wrap: nowrap; width: 100%;">
                        <div class="servicio-card mejorado" style="width: 370px; min-height: 410px; background: #fff; border-radius: 1.1rem; box-shadow: 0 8px 24px rgba(25,118,210,0.12); border: 1px solid #e6eefc; display: flex; flex-direction: column; align-items: center;">
                            <img src="https://images.pexels.com/photos/1130626/pexels-photo-1130626.jpeg?auto=compress&w=400&q=80" alt="María López" style="width: 100%; height: 160px; object-fit: cover; border-radius: 1.1rem 1.1rem 0 0;">
                            <div class="servicio-info" style="padding: 1.1rem 1rem; width: 100%; flex: 1; display: flex; flex-direction: column; align-items: center; gap: 0.6rem; justify-content: flex-start; text-align: center;">
                                <span class="etiqueta">Head Coach</span>
                                <h3>María López</h3>
                                <p class="especialidad"><i class="fas fa-dumbbell"></i> Volley y Fitness</p>
                                <p class="experiencia">10 años de experiencia</p>
                                <p class="certificacion"><i class="fas fa-certificate"></i> Certificación ACE, FIVB</p>
                                <blockquote class="frase-entrenador" style="text-align: justify;">"El éxito es la suma de pequeños esfuerzos repetidos cada día."</blockquote>
                                    <!-- Redes sociales eliminadas -->
                                <a href="contacto.html" class="btn btn-secondary">Contactar</a>
                            </div>
                        </div>
                        <div class="servicio-card mejorado" style="width: 370px; min-height: 410px; background: #fff; border-radius: 1.1rem; box-shadow: 0 8px 24px rgba(25,118,210,0.12); border: 1px solid #e6eefc; display: flex; flex-direction: column; align-items: center;">
                            <img src="https://images.pexels.com/photos/2379005/pexels-photo-2379005.jpeg?auto=compress&w=400&q=80" alt="Carlos Pérez" style="width: 100%; height: 160px; object-fit: cover; border-radius: 1.1rem 1.1rem 0 0;">
                            <div class="servicio-info" style="padding: 1.1rem 1rem; width: 100%; flex: 1; display: flex; flex-direction: column; align-items: center; gap: 0.6rem; justify-content: flex-start; text-align: center;">
                                <span class="etiqueta">Entrenador Personal</span>
                                <h3>Carlos Pérez</h3>
                                <p class="especialidad"><i class="fas fa-running"></i> Multidisciplinario</p>
                                <p class="experiencia">8 años de experiencia</p>
                                <p class="certificacion"><i class="fas fa-certificate"></i> Certificación NSCA, ISSA</p>
                                <blockquote class="frase-entrenador" style="text-align: justify;">"La constancia vence al talento cuando el talento no se esfuerza."</blockquote>
                                    <!-- Redes sociales eliminadas -->
                                <a href="contacto.html" class="btn btn-secondary">Contactar</a>
                            </div>
                        </div>
                        <div class="servicio-card mejorado" style="width: 370px; min-height: 410px; background: #fff; border-radius: 1.1rem; box-shadow: 0 8px 24px rgba(25,118,210,0.12); border: 1px solid #e6eefc; display: flex; flex-direction: column; align-items: center;">
                            <img src="https://images.pexels.com/photos/863988/pexels-photo-863988.jpeg?auto=compress&w=400&q=80" alt="Andrés Ramírez - Natación" style="width: 100%; height: 160px; object-fit: cover; border-radius: 1.1rem 1.1rem 0 0;">
                            <div class="servicio-info" style="padding: 1.1rem 1rem; width: 100%; flex: 1; display: flex; flex-direction: column; align-items: center; gap: 0.6rem; justify-content: flex-start; text-align: center;">
                                <span class="etiqueta">Entrenador de Natación</span>
                                <h3>Andrés Ramírez</h3>
                                <p class="especialidad"><i class="fas fa-swimmer"></i> Natación</p>
                                <p class="experiencia">7 años de experiencia</p>
                                <p class="certificacion"><i class="fas fa-certificate"></i> Certificación FINA</p>
                                <blockquote class="frase-entrenador" style="text-align: justify;">"La disciplina y la constancia te llevan lejos, dentro y fuera del agua."</blockquote>
                                    <!-- Redes sociales eliminadas -->
                                <a href="contacto.html" class="btn btn-secondary">Contactar</a>
                            </div>
                        </div>
                    </div>
                    <!-- Segunda fila -->
                    <div style="display: flex; gap: 2.5rem; justify-content: center; flex-wrap: nowrap; width: 100%;">
                        <div class="servicio-card mejorado" style="width: 370px; min-height: 410px; background: #fff; border-radius: 1.1rem; box-shadow: 0 8px 24px rgba(25,118,210,0.12); border: 1px solid #e6eefc; display: flex; flex-direction: column; align-items: center;">
                            <img src="https://images.pexels.com/photos/3768913/pexels-photo-3768913.jpeg?auto=compress&w=400&q=80" alt="Lucía Fernández" style="width: 100%; height: 160px; object-fit: cover; border-radius: 1.1rem 1.1rem 0 0;">
                            <div class="servicio-info" style="padding: 1.1rem 1rem; width: 100%; flex: 1; display: flex; flex-direction: column; align-items: center; gap: 0.6rem; justify-content: flex-start; text-align: center;">
                                <span class="etiqueta">Psicóloga Deportiva</span>
                                <h3>Lucía Fernández</h3>
                                <p class="especialidad"><i class="fas fa-brain"></i> Psicología y Coaching</p>
                                <p class="experiencia">6 años de experiencia</p>
                                <p class="certificacion"><i class="fas fa-certificate"></i> Lic. Psicología, Cert. Coaching Deportivo</p>
                                <blockquote class="frase-entrenador" style="text-align: justify;">"La mente es el músculo más importante para un atleta."</blockquote>
                                    <!-- Redes sociales eliminadas -->
                                <a href="contacto.html" class="btn btn-secondary">Contactar</a>
                            </div>
                        </div>
                        <div class="servicio-card mejorado" style="width: 370px; min-height: 410px; background: #fff; border-radius: 1.1rem; box-shadow: 0 8px 24px rgba(25,118,210,0.12); border: 1px solid #e6eefc; display: flex; flex-direction: column; align-items: center;">
                            <img src="https://images.pexels.com/photos/1130624/pexels-photo-1130624.jpeg?auto=compress&w=400&q=80" alt="Gabriela Soto" style="width: 100%; height: 160px; object-fit: cover; border-radius: 1.1rem 1.1rem 0 0;">
                            <div class="servicio-info" style="padding: 1.1rem 1rem; width: 100%; flex: 1; display: flex; flex-direction: column; align-items: center; gap: 0.6rem; justify-content: flex-start; text-align: center;">
                                <span class="etiqueta">Entrenadora de Ciclismo</span>
                                <h3>Gabriela Soto</h3>
                                <p class="especialidad"><i class="fas fa-bicycle"></i> Ciclismo</p>
                                <p class="experiencia">5 años de experiencia</p>
                                <p class="certificacion"><i class="fas fa-certificate"></i> Certificación UCI</p>
                                <blockquote class="frase-entrenador" style="text-align: justify;">"El ciclismo es pasión, esfuerzo y libertad sobre dos ruedas."</blockquote>
                                    <!-- Redes sociales eliminadas -->
                                <a href="contacto.html" class="btn btn-secondary">Contactar</a>
                            </div>
                        </div>
                        <div class="servicio-card mejorado" style="width: 370px; min-height: 410px; background: #fff; border-radius: 1.1rem; box-shadow: 0 2px 12px rgba(25,118,210,0.07); display: flex; flex-direction: column; align-items: center;">
                            <img src="https://images.pexels.com/photos/614810/pexels-photo-614810.jpeg?auto=compress&w=400&q=80" alt="Javier Torres" style="width: 100%; height: 160px; object-fit: cover; border-radius: 1.1rem 1.1rem 0 0;">
                            <div class="servicio-info" style="padding: 1.1rem 1rem; width: 100%; flex: 1; display: flex; flex-direction: column; align-items: center; gap: 0.6rem; justify-content: flex-start; text-align: center;">
                                <span class="etiqueta">Árbitro y Formador</span>
                                <h3>Javier Torres</h3>
                                                                <p class="especialidad">
                                                                    <i class="fas fa-whistle"></i>
                                                                    <span style="margin-left:0px; color:#ff9800; font-size:1.5em; vertical-align:middle;">
                                                                        <i class="fas fa-volleyball-ball"></i>
                                                                    </span>
                                                                    Voleibol Sala y Playa
                                                                </p>
                                <p class="experiencia">12 años de experiencia</p>
                                <p class="certificacion"><i class="fas fa-certificate"></i> Árbitro Nacional, FIVB</p>
                                <blockquote class="frase-entrenador" style="text-align: justify;">"El respeto y la disciplina son la base del deporte."</blockquote>
                                    <!-- Redes sociales eliminadas -->
                                <a href="contacto.html" class="btn btn-secondary">Contactar</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulario para contactar entrenadores y guardar en la base de datos -->
                <section id="formulario-entrenadores" style="background: #fff; border-radius: 1.1rem; box-shadow: 0 2px 12px rgba(25,118,210,0.07); max-width: 600px; margin: 3rem auto 2rem auto; padding: calc(2.5rem - 2cm + 1cm) calc(1.5rem + 1cm) 2.5rem calc(1.5rem - 0.5cm + 0.5cm);">
                    <h2 style="color: #1976d2; margin-bottom: 1.2rem;">Contactar Entrenador</h2>
                                            <form id="entrenadoresForm">
                                                <input type="hidden" name="form_type" value="entrenadores">
                        <div style="margin-bottom: 1rem;">
                            <label for="nombre" style="display: block; margin-bottom: 0.3rem;">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" required style="width: 100%; padding: 0.6rem; border-radius: 0.5rem; border: 1px solid #b0bec5;">
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label for="email" style="display: block; margin-bottom: 0.3rem;">Correo electrónico:</label>
                            <input type="email" id="email" name="email" required style="width: 100%; padding: 0.6rem; border-radius: 0.5rem; border: 1px solid #b0bec5;">
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label for="telefono" style="display: block; margin-bottom: 0.3rem;">Teléfono:</label>
                            <input type="tel" id="telefono" name="telefono" pattern="[0-9]{10}" placeholder="Ej: 0991234567" style="width: 100%; padding: 0.6rem; border-radius: 0.5rem; border: 1px solid #b0bec5;">
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label for="motivo" style="display: block; margin-bottom: 0.3rem;">Motivo de contacto:</label>
                            <select id="motivo" name="motivo" required style="width: 100%; padding: 0.6rem; border-radius: 0.5rem; border: 1px solid #b0bec5;">
                                <option value="">Selecciona una opción</option>
                                <option value="informacion">Solicitar información</option>
                                <option value="soporte">Soporte técnico</option>
                                <option value="entrenadores">Contactar entrenador</option>
                                <option value="otros">Otros</option>
                            </select>
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label for="mensaje" style="display: block; margin-bottom: 0.3rem;">Mensaje:</label>
                            <textarea id="mensaje" name="mensaje" rows="3" required style="width: 100%; padding: 0.6rem; border-radius: 0.5rem; border: 1px solid #b0bec5;"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>
                </section>

                <!-- Bloque de Preguntas Frecuentes (FAQ) -->
                <section class="faq">
                    <h2 class="faq-title" style="text-align:center; color:#1976d2; font-weight:700; font-size:2.1rem; margin-bottom:1.2rem;">Preguntas Frecuentes sobre Nuestros Entrenadores</h2>
                    <div class="faq-grid" style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem; max-width:900px; margin:0 auto;">
                        <div class="faq-item" style="background:#fff; border-radius:1.1rem; box-shadow:0 2px 12px rgba(25,118,210,0.07); padding:1.2rem 1rem;">
                            <button class="faq-question" style="background:none; border:none; font-weight:600; font-size:1.1rem; color:#1976d2; display:flex; align-items:center; gap:0.7rem; cursor:pointer; width:100%; text-align:left;">
                                <i class="fas fa-user-check" style="color:#ff9800;"></i> ¿Cómo seleccionan a los entrenadores?
                            </button>
                            <div class="faq-answer" style="display:none; margin-top:0.7rem; color:#333;">Todos nuestros entrenadores pasan por un riguroso proceso de selección y cuentan con certificaciones reconocidas.</div>
                        </div>
                        <div class="faq-item" style="background:#fff; border-radius:1.1rem; box-shadow:0 2px 12px rgba(25,118,210,0.07); padding:1.2rem 1rem;">
                            <button class="faq-question" style="background:none; border:none; font-weight:600; font-size:1.1rem; color:#1976d2; display:flex; align-items:center; gap:0.7rem; cursor:pointer; width:100%; text-align:left;">
                                <i class="fas fa-user-friends" style="color:#ff9800;"></i> ¿Puedo elegir a mi entrenador?
                            </button>
                            <div class="faq-answer" style="display:none; margin-top:0.7rem; color:#333;">Sí, puedes seleccionar al entrenador que mejor se adapte a tus objetivos y necesidades.</div>
                        </div>
                        <div class="faq-item" style="background:#fff; border-radius:1.1rem; box-shadow:0 2px 12px rgba(25,118,210,0.07); padding:1.2rem 1rem;">
                            <button class="faq-question" style="background:none; border:none; font-weight:600; font-size:1.1rem; color:#1976d2; display:flex; align-items:center; gap:0.7rem; cursor:pointer; width:100%; text-align:left;">
                                <i class="fas fa-certificate" style="color:#ff9800;"></i> ¿Qué certificaciones tienen?
                            </button>
                            <div class="faq-answer" style="display:none; margin-top:0.7rem; color:#333;">Contamos con entrenadores certificados por organizaciones internacionales como FIVB, ACE, NSCA, ISSA y más.</div>
                        </div>
                        <div class="faq-item" style="background:#fff; border-radius:1.1rem; box-shadow:0 2px 12px rgba(25,118,210,0.07); padding:1.2rem 1rem;">
                            <button class="faq-question" style="background:none; border:none; font-weight:600; font-size:1.1rem; color:#1976d2; display:flex; align-items:center; gap:0.7rem; cursor:pointer; width:100%; text-align:left;">
                                <i class="fas fa-envelope-open-text" style="color:#ff9800;"></i> ¿Puedo contactar directamente a un entrenador?
                            </button>
                            <div class="faq-answer" style="display:none; margin-top:0.7rem; color:#333;">Sí, utiliza el botón "Contactar" en el perfil de cada entrenador o escríbenos desde la página de contacto.</div>
                        </div>
                    </div>
                </section>
                <!-- Preguntas Frecuentes (dinámicas) -->
                <section id="faqs-dynamic" class="faq" style="background:#fff; border-radius:1.1rem; box-shadow:0 2px 12px rgba(25,118,210,0.07); max-width:900px; margin:1rem auto 1.8rem auto; padding:1.2rem 1rem;">
                    <!-- Contenido dinámico -->
                </section>
                <script>
                // Acordeón para FAQ (varias abiertas)
                document.addEventListener('DOMContentLoaded', function() {
                    const questions = document.querySelectorAll('.faq-question');
                    questions.forEach(btn => {
                        btn.addEventListener('click', function() {
                            const answer = this.nextElementSibling;
                            if (answer.style.display === 'block') {
                                answer.style.display = 'none';
                            } else {
                                answer.style.display = 'block';
                            }
                        });
                    });
                });
                </script>

<script src="Scriptsindex/faqs.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function(){
    if (typeof loadFaqs === 'function') {
      loadFaqs('entrenadores', '#faqs-dynamic');
    }
  });
</script>
            </div>
        </section>
    </main>
    <footer class="main-footer">
    <div class="footer-content">
        <div class="footer-section">
            <h3>DeporteFit</h3>
            <p>La plataforma líder en entrenamiento deportivo personalizado con certificaciones profesionales.</p>
            <div class="social-links">
                <a href="https://www.facebook.com/kevin.zapata.167561" target="_blank" rel="noopener"><i class="fab fa-facebook"></i></a>
                <a href="https://www.instagram.com/kevinzapata1999/?hl=es" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a>
                <a href="https://x.com/KevinZapat42232" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a>
                <a href="https://www.youtube.com/@kevinzapatamoreno608" target="_blank" rel="noopener"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
        <div class="footer-section">
            <h4>Servicios</h4>
            <ul>
                <li><a href="servicios.html">Entrenamiento Personal</a></li>
                <li><a href="servicios.html">Cursos Certificados</a></li>
                <li><a href="planes.html">Planes de Nutrición</a></li>
                <li><a href="servicios.html">Asesoría Deportiva</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h4>Deportes</h4>
            <ul>
                <li><a href="servicios.html">Running</a></li>
                <li><a href="servicios.html">Fitness</a></li>
                <li><a href="servicios.html">Natación</a></li>
                <li><a href="servicios.html">Ciclismo</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h4>Contacto</h4>
            <p><i class="fas fa-envelope"></i> info@deportefit.com</p>
            <p><i class="fas fa-phone"></i> (593) 98 765 4321</p>
            <p><i class="fas fa-map-marker-alt"></i> Calle Deportiva 123, Ciudad Quito</p>
        </div>
    </div>
    <div class="footer-bottom">
        &copy; <?php echo date('Y'); ?> DeporteFit. Todos los derechos reservados.
    </div>
</footer>
<script>
    // Actualiza el año automáticamente en el footer
    document.addEventListener('DOMContentLoaded', function() {
        const footerBottom = document.querySelector('.footer-bottom');
        if (footerBottom) {
            footerBottom.innerHTML = footerBottom.innerHTML.replace('2025', new Date().getFullYear());
        }
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Manejo de notificaciones
    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');
    const error = urlParams.get('error');
    const notification = document.getElementById('notification');
    const messageEl = document.getElementById('notification-message');
    const closeBtn = document.getElementById('close-notification');

    function showNotification(type, message) {
        if (!notification || !messageEl) return;
        messageEl.textContent = message;
        notification.className = `notification ${type} show`;
        setTimeout(() => {
            hideNotification();
        }, 5000);
    }

    function hideNotification() {
        notification.classList.add('hidden');
        setTimeout(() => {
            notification.classList.remove('show');
            // Limpiar URL
            if (window.history.replaceState) {
                const url = new URL(window.location);
                url.searchParams.delete('success');
                url.searchParams.delete('error');
                window.history.replaceState({}, document.title, url.pathname);
            }
        }, 300);
    }

    if (success) {
        showNotification('success', '¡Éxito! Tu solicitud para contactar entrenadores ha sido enviada. Te contactaremos pronto.');
    } else if (error) {
        showNotification('error', 'Por favor, completa todos los campos obligatorios y verifica que tu email sea válido.');
    }

    closeBtn.addEventListener('click', hideNotification);
});
</script>

<script>
// Manejo del formulario con AJAX - Versión mejorada para entrenadores
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Script de entrenadores cargado');
    
    const form = document.getElementById('entrenadoresForm');
    
    if (!form) {
        console.error('❌ Formulario entrenadoresForm no encontrado');
        return;
    }
    
    console.log('✅ Formulario de entrenadores encontrado');
    
    form.addEventListener('submit', function(e) {
        console.log('📝 Formulario de entrenadores enviado');
        e.preventDefault();
        
        // Validación simple
        const nombre = form.nombre.value.trim();
        const email = form.email.value.trim();
        const telefono = form.telefono.value.trim();
        const motivo = form.motivo.value.trim();
        const mensaje = form.mensaje.value.trim();
        
        console.log('📊 Datos del formulario de entrenadores:', { nombre, email, telefono, motivo, mensaje });
        
        if (!nombre || !email || !motivo || !mensaje) {
            console.log('❌ Validación falló - campos vacíos');
            showNotification('error', 'Por favor, completa todos los campos obligatorios.');
            return false;
        }
        
        if (!validateEmail(email)) {
            console.log('❌ Validación falló - email inválido');
            showNotification('error', 'Por favor, ingresa un correo electrónico válido.');
            return false;
        }
        
        console.log('✅ Validación exitosa - Enviando datos de entrenador...');
        
        // Enviar con AJAX
        const formData = new FormData(form);
        console.log('📤 FormData creado para entrenadores');
        
        // Mostrar notificación de carga
        showNotification('success', 'Enviando tu solicitud de entrenador...');
        
        fetch('Procesamientof/procesar_formularios.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            console.log('📥 Respuesta recibida de entrenadores:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('📋 Datos de entrenadores procesados:', data);
            
            if (data.success) {
                showNotification('success', data.message);
                form.reset(); // Limpiar formulario
                console.log('✅ Éxito - Formulario de entrenadores limpiado');
            } else {
                showNotification('error', data.message || 'Hubo un error al enviar tu solicitud de entrenador. Inténtalo nuevamente.');
                console.log('❌ Error del servidor en entrenadores:', data.message);
            }
        })
        .catch(error => {
            console.error('💥 Error en la petición de entrenadores:', error);
            showNotification('error', 'Hubo un error al enviar tu solicitud de entrenador. Inténtalo nuevamente.');
        });
    });
    
    // Función de validación de email
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
    
    // Función global showNotification (por si acaso)
    window.showNotification = function(type, message) {
        const notification = document.getElementById('notification');
        const messageEl = document.getElementById('notification-message');
        
        if (!notification || !messageEl) {
            console.error('❌ Elementos de notificación no encontrados en entrenadores');
            alert(message); // Fallback
            return;
        }
        
        console.log('🔔 Mostrando notificación de entrenadores:', type, message);
        messageEl.textContent = message;
        notification.className = `notification ${type} show`;
        
        setTimeout(() => {
            notification.classList.add('hidden');
            setTimeout(() => {
                notification.classList.remove('show');
            }, 300);
        }, 5000);
    };
    
    console.log('🎯 Script de entrenadores completamente cargado');
});
</script>