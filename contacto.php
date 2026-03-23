<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto | Entrenamiento Deportivo</title>
    <link rel="icon" type="image/svg+xml" href="favicon.svg">
    <link rel="stylesheet" href="css/estilos.css?v=2">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body style="background: linear-gradient(180deg, #f7fbff 0%, #e3f0ff 100%);">
<?php include_once __DIR__ . '/template/headercliente.php'; ?>
    <main class="container">
    <div class="contacto-flex" style="display: flex; gap: 2.5rem; justify-content: center; flex-wrap: wrap; margin: 2.2rem auto 2.2rem auto;">
        <div class="servicio-card mejorado" style="max-width: 500px; width: 500px; margin: 0; background: linear-gradient(135deg, #f7fbff 0%, #e3f0ff 100%);">
            <img src="imagenes/formulario.png" alt="Formulario de Contacto" style="height: 140px; object-fit: cover; border-radius: 12px 12px 0 0;">
            <div class="servicio-info" style="padding: 1.5rem 1.2rem; text-align: center;">
                <h3 style="font-size: 1.25rem; margin-bottom: 1rem; color: #1976d2;">Formulario de Contacto</h3>
                <form class="form-contacto" action="Procesamientof/procesar_formularios.php" method="POST" style="padding: 0; max-width: 100%;">
                    <input type="hidden" name="form_type" value="contacto">
                    <div style="margin-bottom: 1rem; display: flex; flex-direction: column; align-items: center;">
                        <label for="nombre" style="display: flex; align-items: center; gap: 0.5rem; font-size: 1rem; font-weight: 600; color: #333; margin-bottom: 0.5rem; width: 100%; justify-content: flex-start;"><i class="fas fa-user" style="color: #4fc3f7;"></i>Nombre:</label>
                        <input type="text" id="nombre" name="nombre" required style="padding: 0.8rem; font-size: 1rem; margin-bottom: 0; border: 2px solid #e3f2fd; border-radius: 8px; transition: border-color 0.3s; width: 100%; max-width: 300px;">
                    </div>
                    <div style="margin-bottom: 1rem; display: flex; flex-direction: column; align-items: center;">
                        <label for="email" style="display: flex; align-items: center; gap: 0.5rem; font-size: 1rem; font-weight: 600; color: #333; margin-bottom: 0.5rem; width: 100%; justify-content: flex-start;"><i class="fas fa-envelope" style="color: #4fc3f7;"></i>Correo electrónico:</label>
                        <input type="email" id="email" name="email" required style="padding: 0.8rem; font-size: 1rem; margin-bottom: 0; border: 2px solid #e3f2fd; border-radius: 8px; transition: border-color 0.3s; width: 100%; max-width: 300px;">
                    </div>
                    <div style="margin-bottom: 1rem; display: flex; flex-direction: column; align-items: center;">
                        <label for="telefono" style="display: flex; align-items: center; gap: 0.5rem; font-size: 1rem; font-weight: 600; color: #333; margin-bottom: 0.5rem; width: 100%; justify-content: flex-start;"><i class="fas fa-phone" style="color: #4fc3f7;"></i>Teléfono:</label>
                        <input type="tel" id="telefono" name="telefono" pattern="[0-9]{10}" placeholder="Ej: 0991234567" style="padding: 0.8rem; font-size: 1rem; margin-bottom: 0; border: 2px solid #e3f2fd; border-radius: 8px; transition: border-color 0.3s; width: 100%; max-width: 300px;">
                    </div>
                    <div style="margin-bottom: 1rem; display: flex; flex-direction: column; align-items: center;">
                        <label for="motivo" style="display: flex; align-items: center; gap: 0.5rem; font-size: 1rem; font-weight: 600; color: #333; margin-bottom: 0.5rem; width: 100%; justify-content: flex-start;"><i class="fas fa-question-circle" style="color: #4fc3f7;"></i>Motivo de contacto:</label>
                        <select id="motivo" name="motivo" required style="padding: 0.8rem; font-size: 1rem; margin-bottom: 0; border: 2px solid #e3f2fd; border-radius: 8px; transition: border-color 0.3s; background: white; width: 100%; max-width: 300px;">
                            <option value="">Selecciona una opción</option>
                            <option value="informacion">Solicitar información</option>
                            <option value="soporte">Soporte técnico</option>
                            <option value="entrenadores">Contactar entrenador</option>
                            <option value="otros">Otros</option>
                        </select>
                    </div>
                    <div style="margin-bottom: 1rem; display: flex; flex-direction: column; align-items: center;">
                        <label for="mensaje" style="display: flex; align-items: center; gap: 0.5rem; font-size: 1rem; font-weight: 600; color: #333; margin-bottom: 0.5rem; width: 100%; justify-content: flex-start;"><i class="fas fa-comment" style="color: #4fc3f7;"></i>Mensaje:</label>
                        <textarea id="mensaje" name="mensaje" rows="4" required style="padding: 0.8rem; font-size: 1rem; margin-bottom: 0; border: 2px solid #e3f2fd; border-radius: 8px; transition: border-color 0.3s; resize: vertical; min-height: 80px; width: 100%; max-width: 300px;"></textarea>
                    </div>
                    <div class="privacidad" style="margin-bottom: 1.2rem; display: flex; align-items: center; gap: 0.5rem; justify-content: center;">
                        <input type="checkbox" id="privacidad" name="privacidad" required style="transform: scale(1.2);">
                        <label for="privacidad" style="font-size: 0.95rem; color: #555; cursor: pointer; text-align: center;">Acepto la <a href="#" style="color: #1976d2;">política de privacidad</a></label>
                    </div>
                    <button type="submit" class="btn btn-primary" style="padding: 0.9rem 2rem; font-size: 1.05rem; background: linear-gradient(90deg, #43e97b 0%, #38f9d7 100%); border: none; border-radius: 25px; transition: transform 0.3s, box-shadow 0.3s;">Enviar Mensaje</button>
                </form>
            </div>
        </div>
                    <div class="servicio-card mejorado" style="max-width: 500px; width: 500px; margin: 0; background: linear-gradient(135deg, #f7fbff 0%, #e3f0ff 100%); min-height: 480px; display: flex; flex-direction: column;">
                        <img src="imagenes/contacto.jpg" alt="Datos de Contacto" style="height: 140px; object-fit: cover; border-radius: 12px 12px 0 0; flex-shrink: 0;">
                        <div class="servicio-info" style="padding: 1.5rem 1.2rem; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                            <div>
                                <h3 style="font-size: 1.25rem; margin-bottom: 1rem; color: #1976d2;">Datos de Contacto</h3>
                                <div style="margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                                    <i class="fas fa-map-marker-alt" style="font-size: 1.2rem; color: #4fc3f7;"></i>
                                    <p style="margin: 0; font-size: 1rem; color: #333;">Hermandad Ferroviaria S13-267 y Pasaje Francisco Arcia, Quito, Ecuador</p>
                                </div>
                                <div style="margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                                    <i class="fas fa-envelope" style="font-size: 1.2rem; color: #4fc3f7;"></i>
                                    <p style="margin: 0; font-size: 1rem;"><a href="mailto:info@deportefit.com" style="color: #1976d2; text-decoration: none; font-weight: 600;">info@deportefit.com</a></p>
                                </div>
                                <div style="margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                                    <i class="fas fa-phone" style="font-size: 1.2rem; color: #4fc3f7;"></i>
                                    <p style="margin: 0; font-size: 1rem; color: #333;">3110-914</p>
                                </div>
                                <div style="margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                                    <i class="fab fa-whatsapp" style="font-size: 1.2rem; color: #25D366;"></i>
                                    <p style="margin: 0; font-size: 1rem; color: #333;"><a href="https://wa.me/593998591201" target="_blank" style="color: #25D366; text-decoration: none; font-weight: 600;">WhatsApp: 099 859 1201</a></p>
                                </div>
                                <div style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                                    <i class="fas fa-clock" style="font-size: 1.2rem; color: #4fc3f7;"></i>
                                    <p style="margin: 0; font-size: 1rem; color: #333;">Lunes a Viernes: 8h00 - 18h00</p>
                                </div>
                            </div>
                            <div class="mapa-contacto" style="flex: 1; display: flex; justify-content: center; align-items: center; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); margin-top: 1rem;">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3981.123456789012!2d-78.512345!3d-0.253!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zSGVybWFuZGFkIEZlcnJvdmlhcmlhIFNJMzI2NyB5IFBhc2FqZSBGcmFuc2lzY28gQXJjaWE!5e0!3m2!1ses!2sec!4v1726400000000!5m2!1ses!2sec" width="100%" height="100%" style="border:0; display: block; margin: 0; min-height: 200px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <!-- FAQ mejorada como en entrenadores -->
                <section class="faq">
                    <h2 class="faq-title" style="text-align:center; color:#1976d2; font-weight:700; font-size:2.1rem; margin-bottom:1.2rem;">Preguntas Frecuentes sobre Contacto</h2>
                    <div class="faq-grid" style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem; max-width:900px; margin:0 auto;">
                        <div class="faq-item" style="background:#fff; border-radius:1.1rem; box-shadow:0 2px 12px rgba(25,118,210,0.07); padding:1.2rem 1rem;">
                            <button class="faq-question" style="background:none; border:none; font-weight:600; font-size:1.1rem; color:#1976d2; display:flex; align-items:center; gap:0.7rem; cursor:pointer; width:100%; text-align:left;">
                                <i class="fas fa-envelope" style="color:#ff9800;"></i> ¿En cuánto tiempo responden los mensajes?
                            </button>
                            <div class="faq-answer" style="display:none; margin-top:0.7rem; color:#333;">Normalmente respondemos en menos de 24 horas en días laborables. Para consultas urgentes, usa el teléfono de contacto.</div>
                        </div>
                        <div class="faq-item" style="background:#fff; border-radius:1.1rem; box-shadow:0 2px 12px rgba(25,118,210,0.07); padding:1.2rem 1rem;">
                            <button class="faq-question" style="background:none; border:none; font-weight:600; font-size:1.1rem; color:#1976d2; display:flex; align-items:center; gap:0.7rem; cursor:pointer; width:100%; text-align:left;">
                                <i class="fas fa-calendar-check" style="color:#ff9800;"></i> ¿Puedo agendar una cita presencial?
                            </button>
                            <div class="faq-answer" style="display:none; margin-top:0.7rem; color:#333;">Sí, indícalo en el mensaje y te contactaremos para coordinar la cita según disponibilidad de nuestros entrenadores.</div>
                        </div>
                        <div class="faq-item" style="background:#fff; border-radius:1.1rem; box-shadow:0 2px 12px rgba(25,118,210,0.07); padding:1.2rem 1rem;">
                            <button class="faq-question" style="background:none; border:none; font-weight:600; font-size:1.1rem; color:#1976d2; display:flex; align-items:center; gap:0.7rem; cursor:pointer; width:100%; text-align:left;">
                                <i class="fab fa-whatsapp" style="color:#ff9800;"></i> ¿Ofrecen atención por WhatsApp?
                            </button>
                            <div class="faq-answer" style="display:none; margin-top:0.7rem; color:#333;">Próximamente habilitaremos atención directa por WhatsApp. Mientras tanto, usa el formulario o email para consultas rápidas.</div>
                        </div>
                        <div class="faq-item" style="background:#fff; border-radius:1.1rem; box-shadow:0 2px 12px rgba(25,118,210,0.07); padding:1.2rem 1rem;">
                            <button class="faq-question" style="background:none; border:none; font-weight:600; font-size:1.1rem; color:#1976d2; display:flex; align-items:center; gap:0.7rem; cursor:pointer; width:100%; text-align:left;">
                                <i class="fas fa-user-tie" style="color:#ff9800;"></i> ¿Cómo puedo contactar a un entrenador específico?
                            </button>
                            <div class="faq-answer" style="display:none; margin-top:0.7rem; color:#333;">Selecciona “Contactar entrenador” en el motivo del formulario, indica el nombre en el mensaje, o visita la sección de entrenadores.</div>
                        </div>
                    </div>
                </section>
                <!-- Preguntas Frecuentes (dinámicas) -->
                <section id="faqs-dynamic" class="faq" style="background:#fff; border-radius:1.1rem; box-shadow:0 2px 12px rgba(25,118,210,0.07); max-width:900px; margin:1rem auto 1.8rem auto; padding:1.2rem 1rem;">
                    <!-- Contenido dinámico -->
                </section>
                <script>
                // Acordeón para FAQ (múltiples abiertas como en entrenadores)
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
          loadFaqs('contacto', '#faqs-dynamic');
        }
      });
    </script>
            </div>
        </section>
        <script>
        // Validación del formulario antes del envío y efectos de foco
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.form-contacto');
            const inputs = form.querySelectorAll('input, select, textarea');
            
            // Efectos de foco en inputs
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.style.borderColor = '#4fc3f7';
                    this.style.boxShadow = '0 0 0 3px rgba(79, 195, 247, 0.1)';
                });
                input.addEventListener('blur', function() {
                    this.style.borderColor = '#e3f2fd';
                    this.style.boxShadow = 'none';
                });
            });
            
            const exito = document.querySelector('.mensaje-exito');
            const error = document.querySelector('.mensaje-error');
            
            if (form) {
                form.addEventListener('submit', function(e) {
                    // Validación simple: todos los campos requeridos
                    const nombre = form.nombre.value.trim();
                    const email = form.email.value.trim();
                    const telefono = form.telefono.value.trim();
                    const motivo = form.motivo.value.trim();
                    const mensaje = form.mensaje.value.trim();
                    const privacidad = form.privacidad.checked;
                    
                    if (!nombre || !email || !telefono || !motivo || !mensaje || !privacidad) {
                        e.preventDefault();
                        if (exito) exito.style.display = 'none';
                        if (error) error.style.display = 'block';
                        return false;
                    }
                    
                    // Si todo está bien, permitir el envío
                    if (exito) exito.style.display = 'none';
                    if (error) error.style.display = 'none';
                });
            }
        });
        </script>
    </main>

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
                <li><a href="#">Entrenamiento Personal</a></li>
                <li><a href="#">Cursos Certificados</a></li>
                <li><a href="#">Planes de Nutrición</a></li>
                <li><a href="#">Asesoría Deportiva</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h4>Deportes</h4>
            <ul>
                <li><a href="#">Running</a></li>
                <li><a href="#">Fitness</a></li>
                <li><a href="#">Natación</a></li>
                <li><a href="#">Ciclismo</a></li>
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
        showNotification('success', '¡Éxito! Tu mensaje de contacto ha sido enviado. Te contactaremos pronto.');
    } else if (error) {
        showNotification('error', 'Por favor, completa todos los campos obligatorios y verifica que tu email sea válido.');
    }

    closeBtn.addEventListener('click', hideNotification);
});
</script>