<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios | Entrenamiento Deportivo</title>
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
                <div class="servicios-grid mejorado" style="display: flex; flex-wrap: wrap; gap: 2.5rem; justify-content: center; max-width: 1200px; margin: 0 auto 2.5rem auto; padding: 2rem 1.5rem;">
                    <!-- Primera fila -->
                    <div style="display: flex; gap: 2.5rem; justify-content: center; flex-wrap: nowrap; width: 100%;">
                        <div class="servicio-card mejorado">
                            <img src="imagenes/voleibolsala.jpg" alt="Voleibol Sala" style="width: 100%; height: 180px; object-fit: cover; border-radius: 1.1rem 1.1rem 0 0;">
                            <div class="servicio-info" style="padding: 1.2rem 1rem; width: 450px; height: 340px; background: #fff; border-radius: 0 0 1.1rem 1.1rem; box-shadow: 0 2px 12px rgba(25,118,210,0.07); display: flex; flex-direction: column; align-items: center; gap: 0.7rem; justify-content: space-between;">
                                <span class="etiqueta">Más popular</span>
                                <i class="fas fa-volleyball-ball"></i>
                                <h3>Voleibol Sala</h3>
                                <p>Entrenamientos personalizados de voleibol en sala para todos los niveles, enfocados en técnica, táctica y condición física.</p>
                                <a href="#solicitar-info" class="btn btn-primary">Solicitar información</a>
                                <blockquote class="testimonio-servicio">"Mejoré mi técnica y ahora juego en el equipo universitario. ¡Entrenadores muy dedicados!"<br><span>- Andrea, 19 años</span></blockquote>
                            </div>
                        </div>
                        <div class="servicio-card mejorado">
                            <img src="imagenes/voleibolplaya.jpg" alt="Voleibol Playa" style="width: 100%; height: 180px; object-fit: cover; border-radius: 1.1rem 1.1rem 0 0;">
                            <div class="servicio-info" style="padding: 1.2rem 1rem; width: 450px; height: 340px; background: #fff; border-radius: 0 0 1.1rem 1.1rem; box-shadow: 0 2px 12px rgba(25,118,210,0.07); display: flex; flex-direction: column; align-items: center; gap: 0.7rem; justify-content: space-between;">
                                <span class="etiqueta">Nuevo</span>
                                <i class="fas fa-umbrella-beach"></i>
                                <h3>Voleibol Playa</h3>
                                <p>Programas de entrenamiento para voleibol playa, desarrollando habilidades específicas y preparación física adaptada.</p>
                                <a href="#solicitar-info" class="btn btn-primary">Solicitar información</a>
                                <blockquote class="testimonio-servicio">"Las sesiones en la playa son dinámicas y divertidas. Aprendí mucho sobre táctica."<br><span>- Luis, 22 años</span></blockquote>
                            </div>
                        </div>
                    </div>
                    <!-- Segunda fila -->
                    <div style="display: flex; gap: 2.5rem; justify-content: center; flex-wrap: nowrap; width: 100%;">
                        <div class="servicio-card mejorado">
                            <img src="imagenes/clinicasvoleibol.jpg" alt="Clínicas de Voleibol" style="width: 100%; height: 180px; object-fit: cover; border-radius: 1.1rem 1.1rem 0 0;">
                            <div class="servicio-info" style="padding: 1.2rem 1rem; width: 450px; height: 340px; background: #fff; border-radius: 0 0 1.1rem 1.1rem; box-shadow: 0 2px 12px rgba(25,118,210,0.07); display: flex; flex-direction: column; align-items: center; gap: 0.7rem; justify-content: space-between;">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <h3>Clínicas de Voleibol</h3>
                                <p>Sesiones intensivas para perfeccionar fundamentos técnicos y tácticos, dirigidas por entrenadores expertos.</p>
                                <a href="#solicitar-info" class="btn btn-primary">Solicitar información</a>
                                <blockquote class="testimonio-servicio">"Las clínicas me ayudaron a perfeccionar mi saque y remate. ¡Muy recomendadas!"<br><span>- Sofía, 17 años</span></blockquote>
                            </div>
                        </div>
                        <div class="servicio-card mejorado">
                            <img src="imagenes/psicologia-deporte.jpg" alt="Psicología del Deporte" style="width: 100%; height: 180px; object-fit: cover; border-radius: 1.1rem 1.1rem 0 0;">
                            <div class="servicio-info" style="padding: 1.2rem 1rem; width: 450px; height: 340px; background: #fff; border-radius: 0 0 1.1rem 1.1rem; box-shadow: 0 2px 12px rgba(25,118,210,0.07); display: flex; flex-direction: column; align-items: center; gap: 0.7rem; justify-content: space-between;">
                                <i class="fas fa-brain"></i>
                                <h3>Psicología del Deporte</h3>
                                <p>Asesoría y acompañamiento psicológico para potenciar el rendimiento, la motivación y el bienestar de los deportistas.</p>
                                <a href="#solicitar-info" class="btn btn-primary">Solicitar información</a>
                                <blockquote class="testimonio-servicio">"Aprendí a controlar mis nervios antes de los partidos. El apoyo psicológico es fundamental."<br><span>- Mateo, 20 años</span></blockquote>
                            </div>
                        </div>
                    </div>
                    <!-- Tercera fila -->
                    <div style="display: flex; gap: 2.5rem; justify-content: center; flex-wrap: nowrap; width: 100%;">
                        <div class="servicio-card mejorado">
                            <img src="imagenes/arbitraje.jpg" alt="Talleres de Arbitraje en Voleibol" style="width: 100%; height: 180px; object-fit: cover; border-radius: 1.1rem 1.1rem 0 0;">
                            <div class="servicio-info" style="padding: 1.2rem 1rem; width: 450px; height: 340px; background: #fff; border-radius: 0 0 1.1rem 1.1rem; box-shadow: 0 2px 12px rgba(25,118,210,0.07); display: flex; flex-direction: column; align-items: center; gap: 0.7rem; justify-content: space-between;">
                                                                <span style="display: flex; justify-content: center; align-items: center; margin-bottom:0.7rem;">
                                                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M3 12a6 6 0 0 1 6-6h7a2 2 0 0 1 2 2v2.5a2 2 0 0 1-2 2h-4.5a2 2 0 0 0-2 2V18a2 2 0 0 1-2 2H9a6 6 0 0 1-6-6z" fill="#ff9800"/>
                                                                        <circle cx="17.5" cy="17.5" r="1.5" fill="#ff9800"/>
                                                                    </svg>
                                                                </span>
                                <h3>Talleres de Arbitraje en Voleibol</h3>
                                <p>Capacitación teórica y práctica en arbitraje de voleibol, dirigida a quienes desean formarse como árbitros o mejorar sus conocimientos.</p>
                                <a href="#solicitar-info" class="btn btn-primary">Solicitar información</a>
                                <blockquote class="testimonio-servicio">"Ahora entiendo mejor las reglas y puedo arbitrar partidos locales. Excelente formación."<br><span>- Carla, 25 años</span></blockquote>
                            </div>
                        </div>
                        <div class="servicio-card mejorado">
                            <img src="imagenes/NUTRICIÓN-DEPORTIVA.jpg" alt="Nutrición Deportiva" style="width: 100%; height: 180px; object-fit: cover; border-radius: 1.1rem 1.1rem 0 0;">
                            <div class="servicio-info" style="padding: 1.2rem 1rem; width: 450px; height: 340px; background: #fff; border-radius: 0 0 1.1rem 1.1rem; box-shadow: 0 2px 12px rgba(25,118,210,0.07); display: flex; flex-direction: column; align-items: center; gap: 0.7rem; justify-content: space-between;">
                                <i class="fas fa-apple-alt"></i>
                                <h3>Nutrición Deportiva</h3>
                                <p>Planes de alimentación y asesoría nutricional para mejorar el rendimiento y la recuperación de los deportistas.</p>
                                <a href="#solicitar-info" class="btn btn-primary">Solicitar información</a>
                                <blockquote class="testimonio-servicio">"Mi energía y recuperación mejoraron mucho con el plan nutricional personalizado."<br><span>- Diego, 23 años</span></blockquote>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

         <!-- Sección Solicitar Información (debajo de las cardviews, antes de FAQ) -->
    <section id="solicitar-info" style="background: #fff; border-radius: 1.1rem; box-shadow: 0 2px 12px rgba(25,118,210,0.07); max-width: 600px; margin: calc(1rem - 2cm + 1cm) auto 2rem auto; padding: calc(2.5rem - 1cm) calc(1.5rem + 1cm) 2.5rem 1.5rem;">
            <h2 style="color: #1976d2; margin-bottom: 1.2rem;">Solicitar Información</h2>
            <p style="margin-bottom: 1.5rem;">Déjanos tus datos y te contactaremos para resolver tus dudas o ayudarte a inscribirte en el servicio que te interesa.</p>
                                    <form id="serviciosForm">
                                        <input type="hidden" name="form_type" value="servicios">
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
        <!-- Preguntas Frecuentes (FAQ) -->
    <section class="faq" style="background: #fff; border-radius: 1.1rem; box-shadow: 0 2px 12px rgba(25,118,210,0.07); max-width: 900px; margin: 2rem auto 1.4rem auto; padding: 1.6rem 1rem 1rem 1rem;">
            <h2 class="faq-title" style="text-align:center; color:#1976d2; font-weight:700; font-size:2.1rem; margin-bottom:1.2rem;">Preguntas Frecuentes</h2>
            <div class="faq-grid" style="display:grid; grid-template-columns:1fr 1fr; gap:1.6rem; max-width:900px; margin:0 auto;">
                <div class="faq-item" style="background:#fff; border-radius:1.1rem; box-shadow:0 2px 12px rgba(25,118,210,0.07); padding:1.4rem 1.2rem;">
                    <button class="faq-question" style="background:none; border:none; font-weight:600; font-size:1.12rem; color:#1976d2; display:flex; align-items:center; gap:0.7rem; cursor:pointer; width:100%; text-align:left;">
                        <i class="fas fa-user-graduate" style="color:#ff9800;"></i> ¿Necesito experiencia previa para inscribirme?
                    </button>
                    <div class="faq-answer" style="display:none; margin-top:0.7rem; color:#333;">No, nuestros programas están diseñados para todos los niveles, desde principiantes hasta avanzados.</div>
                </div>
                <div class="faq-item" style="background:#fff; border-radius:1.1rem; box-shadow:0 2px 12px rgba(25,118,210,0.07); padding:1.4rem 1.2rem;">
                    <button class="faq-question" style="background:none; border:none; font-weight:600; font-size:1.12rem; color:#1976d2; display:flex; align-items:center; gap:0.7rem; cursor:pointer; width:100%; text-align:left;">
                        <i class="fas fa-box-open" style="color:#ff9800;"></i> ¿Qué incluye la inscripción a un servicio?
                    </button>
                    <div class="faq-answer" style="display:none; margin-top:0.7rem; color:#333;">Incluye acceso a entrenadores, materiales de entrenamiento, seguimiento personalizado y participación en eventos internos.</div>
                </div>
                <div class="faq-item" style="background:#fff; border-radius:1.1rem; box-shadow:0 2px 12px rgba(25,118,210,0.07); padding:1.4rem 1.2rem;">
                    <button class="faq-question" style="background:none; border:none; font-weight:600; font-size:1.12rem; color:#1976d2; display:flex; align-items:center; gap:0.7rem; cursor:pointer; width:100%; text-align:left;">
                        <i class="fas fa-layer-group" style="color:#ff9800;"></i> ¿Puedo combinar varios servicios?
                    </button>
                    <div class="faq-answer" style="display:none; margin-top:0.7rem; color:#333;">Sí, puedes inscribirte en más de un servicio y recibirás un plan adaptado a tus objetivos.</div>
                </div>
                <div class="faq-item" style="background:#fff; border-radius:1.1rem; box-shadow:0 2px 12px rgba(25,118,210,0.07); padding:1.4rem 1.2rem;">
                    <button class="faq-question" style="background:none; border:none; font-weight:600; font-size:1.12rem; color:#1976d2; display:flex; align-items:center; gap:0.7rem; cursor:pointer; width:100%; text-align:left;">
                        <i class="fas fa-info-circle" style="color:#ff9800;"></i> ¿Cómo solicito más información?
                    </button>
                    <div class="faq-answer" style="display:none; margin-top:0.7rem; color:#333;">Puedes usar el botón “Solicitar información” en cada servicio o contactarnos directamente desde la página de contacto.</div>
                </div>
            </div>
        </section>
        <!-- Preguntas Frecuentes (dinámicas) -->
        <section id="faqs-dynamic" class="faq" style="background:#fff; border-radius:1.1rem; box-shadow:0 2px 12px rgba(25,118,210,0.07); max-width:900px; margin:1rem auto 1.8rem auto; padding:1.2rem 1rem;">
            <!-- Contenido dinámico -->
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
    // FAQ acordeón para preguntas frecuentes (varias abiertas)
    document.addEventListener('DOMContentLoaded', function() {
        const faqQuestions = document.querySelectorAll('.faq-question');
        faqQuestions.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const answer = btn.nextElementSibling;
                if (answer.style.display === 'block') {
                    answer.style.display = 'none';
                } else {
                    answer.style.display = 'block';
                }
            });
        });
    });
    </script>

    <script>
    // Año actual en el footer
    document.addEventListener('DOMContentLoaded', function() {
        // Actualiza el año automáticamente si existe el elemento
        const yearElement = document.querySelector('.footer-bottom p');
        if (yearElement) {
            yearElement.innerHTML = yearElement.innerHTML.replace('2025', new Date().getFullYear());
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
            showNotification('success', '¡Éxito! Tu solicitud de información sobre servicios ha sido enviada. Te contactaremos pronto.');
        } else if (error) {
            showNotification('error', 'Por favor, completa todos los campos obligatorios y verifica que tu email sea válido.');
        }
    
        closeBtn.addEventListener('click', hideNotification);
    });
    </script>
    <script>
    // Manejo del formulario con AJAX - Versión mejorada
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🚀 Script de servicios cargado');
        
        const form = document.getElementById('serviciosForm');
        
        if (!form) {
            console.error('❌ Formulario serviciosForm no encontrado');
            return;
        }
        
        console.log('✅ Formulario encontrado');
        
        form.addEventListener('submit', function(e) {
            console.log('📝 Formulario enviado');
            e.preventDefault();
            
            // Validación simple
            const nombre = form.nombre.value.trim();
            const email = form.email.value.trim();
            const telefono = form.telefono.value.trim();
            const motivo = form.motivo.value.trim();
            const mensaje = form.mensaje.value.trim();
            
            console.log('📊 Datos del formulario:', { nombre, email, telefono, motivo, mensaje });
            
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
            
            console.log('✅ Validación exitosa - Enviando datos...');
            
            // Enviar con AJAX
            const formData = new FormData(form);
            console.log('📤 FormData creado');
            
            // Mostrar notificación de carga
            showNotification('success', 'Enviando tu solicitud...');
            
            fetch('Procesamientof/procesar_formularios.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log('📥 Respuesta recibida:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('📋 Datos procesados:', data);
                
                if (data.success) {
                    showNotification('success', data.message);
                    form.reset(); // Limpiar formulario
                    console.log('✅ Éxito - Formulario limpiado');
                } else {
                    showNotification('error', data.message || 'Hubo un error al enviar tu solicitud. Inténtalo nuevamente.');
                    console.log('❌ Error del servidor:', data.message);
                }
            })
            .catch(error => {
                console.error('💥 Error en la petición:', error);
                showNotification('error', 'Hubo un error al enviar tu solicitud. Inténtalo nuevamente.');
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
                console.error('❌ Elementos de notificación no encontrados');
                alert(message); // Fallback
                return;
            }
            
            console.log('🔔 Mostrando notificación:', type, message);
            messageEl.textContent = message;
            notification.className = `notification ${type} show`;
            
            setTimeout(() => {
                notification.classList.add('hidden');
                setTimeout(() => {
                    notification.classList.remove('show');
                }, 300);
            }, 5000);
        };
        
        console.log('🎯 Script de servicios completamente cargado');
    });
    </script>
    <script src="Scriptsindex/faqs.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function(){
        if (typeof loadFaqs === 'function') {
          loadFaqs('servicios', '#faqs-dynamic');
        }
      });
    </script>
    
    </body>
</html>