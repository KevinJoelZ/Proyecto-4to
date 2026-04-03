<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏋️ Avance - DeporteFit</title>
    <link rel="icon" type="image/svg+xml" href="favicon.svg">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/avance.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="background: linear-gradient(180deg, #f7fbff 0%, #e3f0ff 100%); min-height: 100vh;">
    <!-- Header -->
    <?php include_once __DIR__ . '/template/headercliente.php'; ?>

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
        background: #4caf50;
        color: white;
    }
    .notification.error {
        background: #f44336;
        color: white;
    }
    </style>

    <!-- Contenido Principal -->
    <div class="av-wrapper">
        <!-- Header de la Página -->
        <div class="av-header">
            <h1><i class="fas fa-chart-line"></i> Seguimiento de Avance</h1>
            <p>Gestiona tus rutinas de entrenamiento y registra tu progreso deportivo de manera profesional</p>
        </div>

        <!-- Tabs de Navegación -->
        <div class="av-tabs">
            <button class="av-tab active" data-tab="rutinas">
                <i class="fas fa-dumbbell"></i>
                <span>Crear Rutinas</span>
            </button>
            <button class="av-tab" data-tab="progresos">
                <i class="fas fa-trophy"></i>
                <span>Registrar Progresos</span>
            </button>
            <button class="av-tab" data-tab="estadisticas">
                <i class="fas fa-chart-pie"></i>
                <span>Estadísticas</span>
            </button>
        </div>

        <!-- ==================== TAB: CREAR RUTINAS ==================== -->
        <div class="av-tab-content active" id="rutinas">
            <div class="av-dashboard">
                <!-- Card: Nueva Rutina -->
                <div class="av-card">
                    <div class="av-card-header">
                        <h3 class="av-card-title"><i class="fas fa-plus-circle"></i> Nueva Rutina</h3>
                        <div class="av-card-icon blue"><i class="fas fa-clipboard-list"></i></div>
                    </div>
                    
                    <form id="formNuevaRutina">
                        <input type="hidden" name="form_type" value="rutina">
                        <input type="hidden" name="usuario_id" value="demo_user">
                        <div class="av-form-group">
                            <label class="av-form-label">Nombre de la Rutina</label>
                            <input type="text" class="av-form-input" name="nombre" placeholder="Ej: Rutina de Piernas - Lunes" required>
                        </div>
                        
                        <div class="av-form-group">
                            <label class="av-form-label">Tipo de Entrenamiento</label>
                            <select class="av-form-select" name="tipo" required>
                                <option value="">Selecciona el tipo</option>
                                <option value="fuerza">💪 Fuerza</option>
                                <option value="cardio">🏃 Cardio</option>
                                <option value="flexibilidad">🧘 Flexibilidad</option>
                                <option value="tecnica">🎯 Técnica</option>
                                <option value="resistencia">🔥 Resistencia</option>
                            </select>
                        </div>
                        
                        <div class="av-form-group">
                            <label class="av-form-label">Dificultad</label>
                            <select class="av-form-select" name="dificultad" required>
                                <option value="">Selecciona nivel</option>
                                <option value="principiante">🌱 Principiante</option>
                                <option value="intermedio">🌿 Intermedio</option>
                                <option value="avanzado">🌳 Avanzado</option>
                            </select>
                        </div>
                        
                        <div class="av-form-group">
                            <label class="av-form-label">Duración (minutos)</label>
                            <input type="number" class="av-form-input" name="duracion" placeholder="60" min="15" max="180" required>
                        </div>
                        
                        <div class="av-form-group">
                            <label class="av-form-label">Notas Adicionales</label>
                            <textarea class="av-form-textarea" name="notas" placeholder="Comentarios adicionales sobre la rutina..."></textarea>
                        </div>
                        
                        <button type="submit" class="av-btn av-btn-primary" style="width: 100%;">
                            <i class="fas fa-save"></i> Crear Rutina
                        </button>
                    </form>
                </div>

                <!-- Card: Agregar Ejercicios -->
                <div class="av-card">
                    <div class="av-card-header">
                        <h3 class="av-card-title"><i class="fas fa-bullseye"></i> Agregar Ejercicio</h3>
                        <div class="av-card-icon green"><i class="fas fa-running"></i></div>
                    </div>
                    
                    <form id="formEjercicio">
                        <input type="hidden" name="form_type" value="ejercicio">
                        <div class="av-form-group">
                            <label class="av-form-label">Rutina</label>
                            <select class="av-form-select" name="rutina_id" required>
                                <option value="">Selecciona una rutina</option>
                            </select>
                        </div>

                        <div class="av-form-group">
                            <label class="av-form-label">Ejercicio</label>
                            <input type="text" class="av-form-input" name="nombre" placeholder="Ej: Sentadillas" required>
                        </div>
                        
                        <div class="av-form-group">
                            <label class="av-form-label">Serie</label>
                            <div style="display: flex; gap: 0.5rem; align-items: center;">
                                <input type="number" class="av-form-input" name="series" placeholder="3" min="1" max="10" required style="flex: 1;">
                                <span style="color: #6b7280;">series</span>
                            </div>
                        </div>
                        
                        <div class="av-form-group">
                            <label class="av-form-label">Repeticiones</label>
                            <div style="display: flex; gap: 0.5rem; align-items: center;">
                                <input type="number" class="av-form-input" name="repeticiones" placeholder="12" min="1" max="100" required style="flex: 1;">
                                <span style="color: #6b7280;">rep</span>
                            </div>
                        </div>
                        
                        <div class="av-form-group">
                            <label class="av-form-label">Peso (kg)</label>
                            <input type="number" class="av-form-input" name="peso" placeholder="20" min="0" step="0.5">
                        </div>
                        
                        <div class="av-form-group">
                            <label class="av-form-label">Descanso entre series</label>
                            <select class="av-form-select" name="descanso">
                                <option value="30">30 segundos</option>
                                <option value="60" selected>60 segundos</option>
                                <option value="90">90 segundos</option>
                                <option value="120">2 minutos</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="av-btn av-btn-success" style="width: 100%;">
                            <i class="fas fa-plus"></i> Agregar Ejercicio
                        </button>
                    </form>
                </div>

                <!-- Dashboard de Historial -->
                <div class="av-card" style="grid-column: 1 / -1;">
                    <div class="av-card-header">
                        <h3 class="av-card-title"><i class="fas fa-history"></i> Historial de Rutinas y Ejercicios</h3>
                        <div class="av-card-icon blue"><i class="fas fa-list-alt"></i></div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                        <!-- Columna de Rutinas -->
                        <div>
                            <h4 style="color: #1976d2; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-dumbbell"></i> Rutinas Creadas
                            </h4>
                            <div id="historialRutinas" style="max-height: 400px; overflow-y: auto;">
                                <div style="text-align: center; padding: 2rem; color: #666;">
                                    <i class="fas fa-spinner fa-spin" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                                    <p>Cargando historial de rutinas...</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Columna de Ejercicios -->
                        <div>
                            <h4 style="color: #4caf50; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-running"></i> Ejercicios Agregados
                            </h4>
                            <div id="historialEjercicios" style="max-height: 400px; overflow-y: auto;">
                                <div style="text-align: center; padding: 2rem; color: #666;">
                                    <i class="fas fa-spinner fa-spin" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                                    <p>Cargando historial de ejercicios...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div style="margin-top: 1.5rem; text-align: center;">
                        <button onclick="cargarHistorial()" class="av-btn av-btn-primary" style="padding: 0.75rem 1.5rem;">
                            <i class="fas fa-sync-alt"></i> Actualizar Historial Rutinas
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== TAB: REGISTRAR PROGRESOS ==================== -->
        <div class="av-tab-content" id="progresos">
            <div class="av-dashboard">
                <!-- Card: Registrar Peso -->
                <div class="av-card">
                    <div class="av-card-header">
                        <h3 class="av-card-title"><i class="fas fa-weight"></i> Registrar Peso</h3>
                        <div class="av-card-icon green"><i class="fas fa-scale-balanced"></i></div>
                    </div>
                    
                    <form id="formPeso">
                        <input type="hidden" name="form_type" value="peso">
                        <input type="hidden" name="usuario_id" value="demo_user">
                        <div class="av-form-group">
                            <label class="av-form-label">Peso Actual (kg)</label>
                            <input type="number" class="av-form-input" name="peso" placeholder="75.5" min="20" max="300" step="0.1" required>
                        </div>
                        
                        <div class="av-form-group">
                            <label class="av-form-label">Fecha de Medición</label>
                            <input type="date" class="av-form-input" name="fecha_medicion" required>
                        </div>
                        
                        <div class="av-form-group">
                            <label class="av-form-label">Notas</label>
                            <textarea class="av-form-textarea" name="notas" placeholder="Observaciones..."></textarea>
                        </div>
                        
                        <button type="submit" class="av-btn av-btn-success" style="width: 100%;">
                            <i class="fas fa-save"></i> Registrar Peso
                        </button>
                    </form>
                </div>

                <!-- Card: Medidas Corporales -->
                <div class="av-card">
                    <div class="av-card-header">
                        <h3 class="av-card-title"><i class="fas fa-ruler"></i> Medidas Corporales</h3>
                        <div class="av-card-icon orange"><i class="fas fa-child"></i></div>
                    </div>
                    
                    <form id="formMedidas">
                        <input type="hidden" name="form_type" value="medidas">
                        <input type="hidden" name="usuario_id" value="demo_user">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                            <div class="av-form-group">
                                <label class="av-form-label">Fecha de Medición</label>
                                <input type="date" class="av-form-input" name="fecha_medicion" required>
                            </div>
                            <div class="av-form-group">
                                <label class="av-form-label">Pecho (cm)</label>
                                <input type="number" class="av-form-input" name="pecho" placeholder="100" step="0.1">
                            </div>
                            <div class="av-form-group">
                                <label class="av-form-label">Cintura (cm)</label>
                                <input type="number" class="av-form-input" name="cintura" placeholder="80" step="0.1">
                            </div>
                            <div class="av-form-group">
                                <label class="av-form-label">Cadera (cm)</label>
                                <input type="number" class="av-form-input" name="cadera" placeholder="95" step="0.1">
                            </div>
                            <div class="av-form-group">
                                <label class="av-form-label">Bíceps (cm)</label>
                                <input type="number" class="av-form-input" name="biceps" placeholder="35" step="0.1">
                            </div>
                            <div class="av-form-group">
                                <label class="av-form-label">Pierna (cm)</label>
                                <input type="number" class="av-form-input" name="pierna" placeholder="55" step="0.1">
                            </div>
                        </div>
                        
                        <div class="av-form-group">
                            <label class="av-form-label">Notas</label>
                            <textarea class="av-form-textarea" name="notas" placeholder="Observaciones sobre las medidas..."></textarea>
                        </div>
                        
                        <button type="submit" class="av-btn av-btn-primary" style="width: 100%;">
                            <i class="fas fa-save"></i> Guardar Medidas
                        </button>
                    </form>
                </div>


            </div>
            
            <!-- Dashboard de Historial de Progresos -->
            <div class="av-card" style="grid-column: 1 / -1;">
                <div class="av-card-header">
                    <h3 class="av-card-title"><i class="fas fa-history"></i> Historial de Progresos</h3>
                    <div class="av-card-icon orange"><i class="fas fa-chart-line"></i></div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                    <!-- Columna de Peso -->
                    <div>
                        <h4 style="color: #4caf50; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-weight"></i> Registro de Peso
                        </h4>
                        <div id="historialPeso" style="max-height: 500px; overflow-y: auto;">
                            <div style="text-align: center; padding: 2rem; color: #666;">
                                <i class="fas fa-spinner fa-spin" style="font-size: 1.5rem; margin-bottom: 1rem;"></i>
                                <p>Cargando historial de peso...</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Columna de Medidas -->
                    <div>
                        <h4 style="color: #ff9800; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-ruler"></i> Medidas Corporales
                        </h4>
                        <div id="historialMedidas" style="max-height: 500px; overflow-y: auto;">
                            <div style="text-align: center; padding: 2rem; color: #666;">
                                <i class="fas fa-spinner fa-spin" style="font-size: 1.5rem; margin-bottom: 1rem;"></i>
                                <p>Cargando historial de medidas...</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div style="margin-top: 1.5rem; text-align: center;">
                    <button onclick="cargarHistorialProgresos()" class="av-btn av-btn-success" style="padding: 0.75rem 1.5rem;">
                        <i class="fas fa-sync-alt"></i> Actualizar Historial Progresos
                    </button>
                </div>

            </div>
        </div>

        <!-- ==================== TAB: ESTADÍSTICAS ==================== -->
        <div class="av-tab-content" id="estadisticas">
            <div class="av-dashboard">
                <h3 style="color: #1976d2; margin-bottom: 1.5rem;"><i class="fas fa-chart-pie"></i> Estadísticas</h3>
                <div id="estadisticasContent">
                    <div style="text-align: center; padding: 2rem; color: #666;">
                        <i class="fas fa-spinner fa-spin" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                        <p>Cargando estadísticas...</p>
                    </div>
                </div>
                
                <div style="margin-top: 1.5rem; text-align: center;">
                    <button onclick="cargarEstadisticas()" class="av-btn av-btn-primary" style="padding: 0.75rem 1.5rem;">
                        <i class="fas fa-sync-alt"></i> Actualizar Estadísticas
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
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
        // JavaScript simplificado para el módulo de avance
        
        // Funciones globales para actualización de historiales
        function cargarHistorial() {
            console.log('🔄 Cargando historial...');
            
            const divRutinas = document.getElementById('historialRutinas');
            const divEjercicios = document.getElementById('historialEjercicios');
            
            if (divRutinas) {
                divRutinas.innerHTML = `
                    <div style="text-align: center; padding: 2rem; color: #666;">
                        <i class="fas fa-spinner fa-spin" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                        <p>Cargando historial de rutinas...</p>
                    </div>
                `;
            }
            
            if (divEjercicios) {
                divEjercicios.innerHTML = `
                    <div style="text-align: center; padding: 2rem; color: #666;">
                        <i class="fas fa-spinner fa-spin" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                        <p>Cargando historial de ejercicios...</p>
                    </div>
                `;
            }
            
            fetch('Procesamientof/cargar_historial.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'cargar_historial', usuario_id: 'demo_user' })
            })
            .then(response => response.json())
            .then(data => {
                console.log('📋 Historial recibido:', data);
                
                if (data.success) {
                    if (divRutinas && data.rutinas) {
                        if (data.rutinas.length === 0) {
                            divRutinas.innerHTML = `
                                <div style="text-align: center; padding: 2rem; color: #999;">
                                    <i class="fas fa-dumbbell" style="font-size: 2rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                                    <p>No hay rutinas creadas aún</p>
                                </div>
                            `;
                        } else {
                            divRutinas.innerHTML = data.rutinas.map(rutina => `
                                <div style="border: 1px solid #e0e0e0; border-radius: 8px; padding: 1rem; margin-bottom: 1rem; background: #fafafa;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                        <h5 style="margin: 0; color: #1976d2; font-size: 1rem;">🏋️ ${rutina.nombre}</h5>
                                        <span style="background: #e3f2fd; color: #1976d2; padding: 0.25rem 0.5rem; border-radius: 12px; font-size: 0.8rem;">${rutina.tipo}</span>
                                    </div>
                                    <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 0.5rem;">
                                        <span style="color: #666; font-size: 0.85rem;">📊 ${rutina.dificultad}</span>
                                        <span style="color: #666; font-size: 0.85rem;">⏱️ ${rutina.duracion} min</span>
                                        <span style="color: #666; font-size: 0.85rem;">📅 ${new Date(rutina.fecha_creacion).toLocaleDateString()}</span>
                                    </div>
                                </div>
                            `).join('');
                        }
                    }
                    
                    if (divEjercicios && data.ejercicios) {
                        if (data.ejercicios.length === 0) {
                            divEjercicios.innerHTML = `
                                <div style="text-align: center; padding: 2rem; color: #999;">
                                    <i class="fas fa-list" style="font-size: 2rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                                    <p>No hay ejercicios registrados aún</p>
                                </div>
                            `;
                        } else {
                            divEjercicios.innerHTML = data.ejercicios.map(ejercicio => `
                                <div style="border: 1px solid #e0e0e0; border-radius: 8px; padding: 1rem; margin-bottom: 1rem; background: #fafafa;">
                                    <h5 style="margin: 0 0 0.5rem 0; color: #4caf50; font-size: 1rem;">💪 ${ejercicio.nombre}</h5>
                                    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                                        <span style="color: #666; font-size: 0.85rem;">🔄 ${ejercicio.series} series</span>
                                        <span style="color: #666; font-size: 0.85rem;">🔁 ${ejercicio.repeticiones} reps</span>
                                        ${ejercicio.peso ? `<span style="color: #666; font-size: 0.85rem;">⚖️ ${ejercicio.peso} kg</span>` : ''}
                                    </div>
                                </div>
                            `).join('');
                        }
                    }
                } else {
                    console.error('Error al cargar historial:', data.message);
                }
            })
            .catch(error => {
                console.error('Error de conexión:', error);
                if (divRutinas) divRutinas.innerHTML = '<p style="color: #f44336; text-align: center;">Error de conexión</p>';
                if (divEjercicios) divEjercicios.innerHTML = '<p style="color: #f44336; text-align: center;">Error de conexión</p>';
            });
        }
        
        function cargarHistorialProgresos() {
            console.log('🔄 Cargando historial de progresos...');
            
            const divPeso = document.getElementById('historialPeso');
            const divMedidas = document.getElementById('historialMedidas');
            
            if (divPeso) {
                divPeso.innerHTML = `
                    <div style="text-align: center; padding: 2rem; color: #666;">
                        <i class="fas fa-spinner fa-spin" style="font-size: 1.5rem; margin-bottom: 1rem;"></i>
                        <p>Cargando historial de peso...</p>
                    </div>
                `;
            }
            
            if (divMedidas) {
                divMedidas.innerHTML = `
                    <div style="text-align: center; padding: 2rem; color: #666;">
                        <i class="fas fa-spinner fa-spin" style="font-size: 1.5rem; margin-bottom: 1rem;"></i>
                        <p>Cargando historial de medidas...</p>
                    </div>
                `;
            }
            
            fetch('Procesamientof/cargar_historial_progresos.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'cargar_historial_progresos', usuario_id: 'demo_user' })
            })
            .then(response => response.json())
            .then(data => {
                console.log('📋 Historial de progresos recibido:', data);
                
                if (data.success) {
                    if (divPeso && data.pesos) {
                        if (data.pesos.length === 0) {
                            divPeso.innerHTML = `
                                <div style="text-align: center; padding: 2rem; color: #999;">
                                    <i class="fas fa-weight" style="font-size: 1.5rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                                    <p>No hay registros de peso aún</p>
                                </div>
                            `;
                        } else {
                            divPeso.innerHTML = data.pesos.map((peso, index) => {
                                const esMasReciente = index === 0;
                                const fechaCorrecta = new Date(peso.fecha_medicion + 'T00:00:00');
                                return `
                                    <div style="border: 1px solid #e0e0e0; border-radius: 8px; padding: 1rem; margin-bottom: 1rem; background: #fafafa; ${esMasReciente ? 'border-left: 4px solid #4caf50;' : ''}">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                            <h5 style="margin: 0; color: #4caf50; font-size: 1rem;">
                                                ⚖️ ${peso.peso} kg
                                                ${esMasReciente ? ' 🆕' : ''}
                                            </h5>
                                            <span style="color: #999; font-size: 0.8rem;">
                                                ${fechaCorrecta.toLocaleDateString()}
                                            </span>
                                        </div>
                                        ${peso.notas ? `<p style="margin: 0.5rem 0 0 0; color: #666; font-size: 0.9rem; font-style: italic;">${peso.notas}</p>` : ''}
                                    </div>
                                `;
                            }).join('');
                        }
                    }
                    
                    if (divMedidas && data.medidas) {
                        if (data.medidas.length === 0) {
                            divMedidas.innerHTML = `
                                <div style="text-align: center; padding: 2rem; color: #999;">
                                    <i class="fas fa-ruler" style="font-size: 1.5rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                                    <p>No hay registros de medidas aún</p>
                                </div>
                            `;
                        } else {
                            divMedidas.innerHTML = data.medidas.map((medida, index) => {
                                const esMasReciente = index === 0;
                                const fechaCorrecta = new Date(medida.fecha_medicion + 'T00:00:00');
                                return `
                                    <div style="border: 1px solid #e0e0e0; border-radius: 8px; padding: 1rem; margin-bottom: 1rem; background: #fafafa; ${esMasReciente ? 'border-left: 4px solid #ff9800;' : ''}">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                            <h5 style="margin: 0; color: #ff9800; font-size: 1rem;">
                                                📏 Medidas ${esMasReciente ? ' 🆕' : ''}
                                            </h5>
                                            <span style="color: #999; font-size: 0.8rem;">
                                                ${fechaCorrecta.toLocaleDateString()}
                                            </span>
                                        </div>
                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; margin-top: 0.5rem;">
                                            ${medida.pecho ? `<span style="color: #666; font-size: 0.85rem;">🏋️ Pecho: ${medida.pecho} cm</span>` : ''}
                                            ${medida.cintura ? `<span style="color: #666; font-size: 0.85rem;">📐 Cintura: ${medida.cintura} cm</span>` : ''}
                                            ${medida.cadera ? `<span style="color: #666; font-size: 0.85rem;">🦵 Cadera: ${medida.cadera} cm</span>` : ''}
                                            ${medida.biceps ? `<span style="color: #666; font-size: 0.85rem;">💪 Bíceps: ${medida.biceps} cm</span>` : ''}
                                            ${medida.pierna ? `<span style="color: #666; font-size: 0.85rem;">🦿 Pierna: ${medida.pierna} cm</span>` : ''}
                                        </div>
                                        ${medida.notas ? `<p style="margin: 0.5rem 0 0 0; color: #666; font-size: 0.9rem; font-style: italic;">${medida.notas}</p>` : ''}
                                    </div>
                                `;
                            }).join('');
                        }
                    }
                } else {
                    console.error('Error al cargar historial de progresos:', data.message);
                }
            })
            .catch(error => {
                console.error('Error de conexión:', error);
                if (divPeso) divPeso.innerHTML = '<p style="color: #f44336; text-align: center;">Error de conexión</p>';
                if (divMedidas) divMedidas.innerHTML = '<p style="color: #f44336; text-align: center;">Error de conexión</p>';
            });
        }
        
        // Función para cargar estadísticas
        function cargarEstadisticas() {
            console.log('📊 Cargando estadísticas...');
            
            const divEstadisticas = document.getElementById('estadisticasContent');
            
            // Contar elementos en los historiales
            const divRutinas = document.getElementById('historialRutinas');
            const divEjercicios = document.getElementById('historialEjercicios');
            const divPeso = document.getElementById('historialPeso');
            const divMedidas = document.getElementById('historialMedidas');
            
            // Contar rutinas (divs con border)
            const rutinas = divRutinas ? divRutinas.querySelectorAll('div[style*="border"]').length : 0;
            
            // Contar ejercicios
            const ejercicios = divEjercicios ? divEjercicios.querySelectorAll('div[style*="border"]').length : 0;
            
            // Contar registros de peso
            const peso = divPeso ? divPeso.querySelectorAll('div[style*="border"]').length : 0;
            
            // Contar registros de medidas
            const medidas = divMedidas ? divMedidas.querySelectorAll('div[style*="border"]').length : 0;
            
            // Total de registros
            const totalRegistros = rutinas + ejercicios + peso + medidas;
            
            if (divEstadisticas) {
                divEstadisticas.innerHTML = `
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                        <!-- Card: Rutinas -->
                        <div style="background: linear-gradient(135deg, #1976d2, #42a5f5); color: white; padding: 1.5rem; border-radius: 12px; text-align: center;">
                            <i class="fas fa-dumbbell" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                            <h3 style="margin: 0; font-size: 2rem;">${rutinas}</h3>
                            <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">Rutinas</p>
                        </div>
                        
                        <!-- Card: Registros de Peso -->
                        <div style="background: linear-gradient(135deg, #43a047, #66bb6a); color: white; padding: 1.5rem; border-radius: 12px; text-align: center;">
                            <i class="fas fa-weight" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                            <h3 style="margin: 0; font-size: 2rem;">${peso}</h3>
                            <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">Registros de Peso</p>
                        </div>
                        
                        <!-- Card: Registros de Medidas -->
                        <div style="background: linear-gradient(135deg, #ff9800, #ffb74d); color: white; padding: 1.5rem; border-radius: 12px; text-align: center;">
                            <i class="fas fa-ruler" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                            <h3 style="margin: 0; font-size: 2rem;">${medidas}</h3>
                            <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">Registros de Medidas</p>
                        </div>
                        
                        <!-- Card: Ejercicios -->
                        <div style="background: linear-gradient(135deg, #7b1fa2, #ba68c8); color: white; padding: 1.5rem; border-radius: 12px; text-align: center;">
                            <i class="fas fa-running" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                            <h3 style="margin: 0; font-size: 2rem;">${ejercicios}</h3>
                            <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">Ejercicios</p>
                        </div>
                    </div>
                    
                    <!-- Resumen -->
                    <div style="background: #f5f5f5; border-radius: 12px; padding: 1.5rem; margin-bottom: 2rem;">
                        <h4 style="margin: 0 0 1rem 0; color: #333;"><i class="fas fa-chart-bar"></i> Resumen Total</h4>
                        <div style="display: flex; justify-content: space-around; align-items: center;">
                            <div style="text-align: center;">
                                <div style="font-size: 2.5rem; font-weight: bold; color: #1976d2;">${totalRegistros}</div>
                                <div style="color: #666;">Total de Registros</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Desglose -->
                    <div style="background: white; border-radius: 12px; padding: 1.5rem; border: 1px solid #e0e0e0;">
                        <h4 style="margin: 0 0 1rem 0; color: #333;"><i class="fas fa-list"></i> Desglose</h4>
                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            <div style="display: flex; justify-content: space-between; padding: 0.5rem; background: #e3f2fd; border-radius: 8px;">
                                <span>🏋️ Rutinas creadas</span>
                                <strong>${rutinas}</strong>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 0.5rem; background: #e8f5e9; border-radius: 8px;">
                                <span>⚖️ Registros de peso</span>
                                <strong>${peso}</strong>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 0.5rem; background: #fff3e0; border-radius: 8px;">
                                <span>📏 Registros de medidas</span>
                                <strong>${medidas}</strong>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 0.5rem; background: #f3e5f5; border-radius: 8px;">
                                <span>💪 Ejercicios registrados</span>
                                <strong>${ejercicios}</strong>
                            </div>
                        </div>
                    </div>
                `;
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🚀 Módulo de avance iniciado');
            
            // Sistema de tabs
            const tabs = document.querySelectorAll('.av-tab');
            const tabContents = document.querySelectorAll('.av-tab-content');
            
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => t.classList.remove('active'));
                    tabContents.forEach(c => c.classList.remove('active'));
                    tab.classList.add('active');
                    const tabId = tab.getAttribute('data-tab');
                    document.getElementById(tabId).classList.add('active');
                    
                    console.log(`🔄 Cambiando a la pestaña: ${tabId}`);
                    
                    // Cargar estadísticas cuando se active la pestaña
                    if (tabId === 'estadisticas') {
                        cargarEstadisticas();
                    }
                });
            });
            
            // Función global showNotification
            window.showNotification = function(type, message) {
                const notification = document.getElementById('notification');
                const messageEl = document.getElementById('notification-message');
                
                if (!notification || !messageEl) {
                    console.error('❌ Elementos de notificación no encontrados');
                    alert(message); // Fallback
                    return;
                }
                
                console.log('🔔 Mostrando notificación de avance:', type, message);
                messageEl.textContent = message;
                notification.className = `notification ${type} show`;
                
                setTimeout(() => {
                    notification.classList.add('hidden');
                    setTimeout(() => {
                        notification.classList.remove('show');
                    }, 300);
                }, 5000);
            };
            
            // Manejo de todos los formularios
            const formRutina = document.getElementById('formNuevaRutina');
            const formEjercicio = document.getElementById('formEjercicio');
            const formPeso = document.getElementById('formPeso');
            const formMedidas = document.getElementById('formMedidas');
            const formEntrenamiento = document.getElementById('formEntrenamiento');
            
            // Función genérica para manejar envío de formularios
            function handleFormSubmit(form, formType, successMessage, onSuccessCallback) {
                form.addEventListener('submit', function(e) {
                    console.log(`📝 Enviando formulario de ${formType}`);
                    e.preventDefault();
                    
                    // Enviar con AJAX
                    const formData = new FormData(form);
                    showNotification('success', `🔄 Procesando ${formType}...`);
                    
                    fetch('Procesamientof/procesar_formularios.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        console.log(`📥 Respuesta de ${formType}:`, response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log(`📋 Datos de ${formType} procesados:`, data);
                        
                        if (data.success) {
                            showNotification('success', data.message || successMessage);
                            form.reset();
                            console.log(`✅ ${formType} procesado exitosamente`);
                            
                            // Ejecutar callback de éxito si existe
                            if (onSuccessCallback && typeof onSuccessCallback === 'function') {
                                setTimeout(onSuccessCallback, 500);
                            }
                        } else {
                            showNotification('error', data.message || `Error al procesar ${formType}`);
                            console.log(`❌ Error en ${formType}:`, data.message);
                        }
                    })
                    .catch(error => {
                        console.error(`💥 Error en ${formType}:`, error);
                        showNotification('error', `Error de conexión al procesar ${formType}`);
                    });
                });
            }
            
            // Configurar cada formulario
            if (formRutina) {
                handleFormSubmit(formRutina, 'rutina', '¡Éxito! Tu rutina ha sido creada.', function() {
                    cargarHistorial(); // Actualizar historial
                    cargarRutinasDisponibles(); // Actualizar selects de rutinas
                });
            }
            
            if (formEjercicio) {
                handleFormSubmit(formEjercicio, 'ejercicio', '¡Éxito! El ejercicio ha sido agregado a tu rutina.', cargarHistorial);
            }
            
            if (formPeso) {
                handleFormSubmit(formPeso, 'peso', '¡Éxito! Tu peso ha sido registrado.', cargarHistorialProgresos);
            }
            
            if (formMedidas) {
                handleFormSubmit(formMedidas, 'medidas', '¡Éxito! Tus medidas corporales han sido registradas.', cargarHistorialProgresos);
            }
            
            if (formEntrenamiento) {
                handleFormSubmit(formEntrenamiento, 'entrenamiento', '¡Éxito! Tu entrenamiento ha sido registrado.', cargarHistorialProgresos);
            }
            
            // Función para cargar rutinas disponibles en el select de ejercicios
            function cargarRutinasDisponibles() {
                console.log('🔄 Cargando rutinas disponibles...');
                
                fetch('Procesamientof/cargar_rutinas.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ action: 'cargar_rutinas', usuario_id: 'demo_user' })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('📋 Respuesta de rutinas:', data);
                    
                    if (data.success && data.rutinas) {
                        // Actualizar select de ejercicios
                        const selectEjercicio = document.querySelector('select[name="rutina_id"]');
                        if (selectEjercicio) {
                            selectEjercicio.innerHTML = '<option value="">Selecciona una rutina</option>';
                            data.rutinas.forEach(rutina => {
                                const option = document.createElement('option');
                                option.value = rutina.id;
                                option.textContent = rutina.nombre;
                                selectEjercicio.appendChild(option);
                            });
                            console.log(`✅ ${data.rutinas.length} rutinas cargadas para ejercicios`);
                        }
                        
                        // Actualizar select de entrenamientos realizados
                        const selectEntrenamiento = document.querySelector('form#formEntrenamiento select[name="rutina_id"]');
                        if (selectEntrenamiento) {
                            selectEntrenamiento.innerHTML = '<option value="">Selecciona una rutina</option>';
                            data.rutinas.forEach(rutina => {
                                const option = document.createElement('option');
                                option.value = rutina.id;
                                option.textContent = rutina.nombre;
                                selectEntrenamiento.appendChild(option);
                            });
                            console.log(`✅ ${data.rutinas.length} rutinas cargadas para entrenamientos`);
                        }
                    } else {
                        console.log('❌ Error al cargar rutinas:', data.message || 'Error desconocido');
                    }
                })
                .catch(error => {
                    console.error('💥 Error en la petición de rutinas:', error);
                });
            }
            
            // Cargar rutinas disponibles al iniciar
            cargarRutinasDisponibles();
            
            // Establecer fecha actual en los formularios de progresos
            const fechaActual = new Date().toISOString().split('T')[0];
            const inputFechaPeso = document.querySelector('#formPeso input[name="fecha_medicion"]');
            const inputFechaMedidas = document.querySelector('#formMedidas input[name="fecha_medicion"]');
            
            if (inputFechaPeso) {
                inputFechaPeso.value = fechaActual;
            }
            if (inputFechaMedidas) {
                inputFechaMedidas.value = fechaActual;
            }
            

            

            

            
            // Cargar historiales automáticamente al iniciar
            setTimeout(cargarHistorial, 1000);
            setTimeout(cargarHistorialProgresos, 1500);
            setTimeout(cargarEstadisticas, 2000);
            
            console.log('🎯 Módulo de avance completamente cargado');
        });
    </script>
</body>
</html>
