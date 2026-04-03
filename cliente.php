<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏋️ DeporteFit - Plataforma de Entrenamiento Deportivo</title>
    <link rel="icon" type="image/svg+xml" href="favicon.svg">
    <link rel="stylesheet" href="css/estilos.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body style="background: linear-gradient(180deg, #f7fbff 0%, #e3f0ff 100%);">
    <!-- Encabezado reutilizado -->
    <?php include_once __DIR__ . '/template/headercliente.php'; ?>

    <!-- Barra superior para Login con Google -->
    <div class="auth-toolbar" style="display:flex; justify-content:center; gap:1rem; padding:0.8rem; background:#f1f5ff; border-bottom:1px solid #e0e7ff;">
        <button id="googleSignIn" class="btn btn-secondary" style="background:#fff; color:#333; border:1px solid #ddd; display:inline-flex; align-items:center; gap:.5rem;">
            <i class="fab fa-google" style="color:#DB4437;"></i>
            Iniciar sesión con Google
        </button>
        <a href="admin.php" id="goAdminBtn" class="btn" style="display:none; background:#fff; color:#333; border:1px solid #ddd; display:inline-flex; align-items:center; gap:.5rem; text-decoration:none;">
            <i class="fas fa-shield-alt" style="color:#1976d2;"></i>
            Volver a Panel Admin
        </a>
        <a href="#" id="clientLogout" class="btn" style="display:none; background:#fff; color:#333; border:1px solid #ddd; display:inline-flex; align-items:center; gap:.5rem; text-decoration:none;">
            <i class="fas fa-sign-out-alt" style="color:#c62828;"></i>
            Cerrar sesión
        </a>
        <div id="loading" class="message loading" style="display:none; color:#1976d2; align-self:center;">Cargando...</div>
        <div id="success" class="message success" style="display:none; color:#2e7d32; align-self:center;">✅ ¡Inicio de sesión exitoso! Redirigiendo...</div>
        <div id="error" class="message error" style="display:none; color:#c62828; align-self:center;"></div>
    </div>

    <!-- Contenido principal completo reutilizado -->
    <?php include_once __DIR__ . '/template/maincliente.php'; ?>

    <!-- Script de Firebase para login con Google -->
    <script type="module">
        import { initializeApp } from 'https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js';
        import { getAuth, GoogleAuthProvider, signInWithPopup, onAuthStateChanged, signOut } from 'https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js';

        const firebaseConfig = {
            apiKey: "AIzaSyBZoUGrSk3V-yFW6QHxXLeXQfPMgnYUeQo",
            authDomain: "proyectoweb-fc2d2.firebaseapp.com",
            projectId: "proyectoweb-fc2d2",
            storageBucket: "proyectoweb-fc2d2.firebasestorage.app",
            messagingSenderId: "508269230145",
            appId: "1:508269230145:web:d183a7c70873785487eec0",
            measurementId: "G-3HX251Y5DH"
        };
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const provider = new GoogleAuthProvider();

        const googleSignInBtn = document.getElementById('googleSignIn');
        const loadingDiv = document.getElementById('loading');
        const successDiv = document.getElementById('success');
        const errorDiv = document.getElementById('error');

        function showMessage(type, message = '') {
            loadingDiv.style.display = 'none';
            successDiv.style.display = 'none';
            errorDiv.style.display = 'none';
            if (type === 'loading') loadingDiv.style.display = 'block';
            if (type === 'success') successDiv.style.display = 'block';
            if (type === 'error') {
                errorDiv.style.display = 'block';
                if (message) errorDiv.textContent = '❌ ' + message;
            }
        }

        async function saveUserToDatabase(user) {
            const userData = {
                uid: user.uid,
                name: user.displayName,
                email: user.email,
                photoURL: user.photoURL,
                emailVerified: user.emailVerified,
                rol: 'cliente'
            };
            const response = await fetch('./login/guardar_usuario.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(userData)
            });
            return response.ok;
        }

        async function getUserRole(uid) {
            const response = await fetch('./login/obtener_rol.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ uid })
            });
            if (!response.ok) return 'cliente';
            const result = await response.json();
            return result.success ? result.rol : 'cliente';
        }

        // Utilidades para returnUrl
        function getUrlParameter(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }
        function sanitizeReturnUrl(url) {
            if (!url) return null;
            try {
                const parsed = new URL(url, window.location.origin);
                if (parsed.origin !== window.location.origin) return null;
                return parsed.pathname + parsed.search + parsed.hash;
            } catch (_) {
                return null;
            }
        }
        function getReturnUrl() {
            // Solo respetar returnUrl explícito si pertenece al mismo origen; de lo contrario, permanecer en cliente.php
            const fromParam = sanitizeReturnUrl(getUrlParameter('returnUrl'));
            return fromParam ? fromParam : null;
        }

        async function signInWithGoogle() {
            try {
                showMessage('loading');
                googleSignInBtn.disabled = true;
                sessionStorage.clear();
                const result = await signInWithPopup(auth, provider);
                const user = result.user;
                await saveUserToDatabase(user);
                const userRole = await getUserRole(user.uid);
                const userData = {
                    uid: user.uid, name: user.displayName, email: user.email, photoURL: user.photoURL, rol: userRole
                };
                sessionStorage.setItem('user', JSON.stringify(userData));
                sessionStorage.setItem('justLoggedIn', 'true');
                showMessage('success');
                setTimeout(() => {
                    if (userRole === 'admin') {
                        window.location.href = 'admin.php';
                    } else {
                        // Forzar que los clientes permanezcan en cliente.php
                        window.location.href = 'cliente.php';
                    }
                }, 1200);
            } catch (error) {
                let msg = error?.message || 'Error en la autenticación';
                if (error?.code === 'auth/popup-closed-by-user') msg = 'Autenticación cancelada por el usuario';
                if (error?.code === 'auth/popup-blocked') msg = 'El navegador bloqueó la ventana emergente';
                if (error?.code === 'auth/unauthorized-domain') msg = 'Dominio no autorizado para Firebase';
                showMessage('error', msg);
            } finally {
                googleSignInBtn.disabled = false;
            }
        }

        googleSignInBtn?.addEventListener('click', signInWithGoogle);

        // Mostrar/ocultar botón de Cerrar sesión para el cliente específico
        const clientLogoutBtn = document.getElementById('clientLogout');
        function isClientUser(){
            try {
                const u = JSON.parse(sessionStorage.getItem('user')||'{}');
                return (u.rol === 'cliente' && (u.email||'').toLowerCase() === 'kevinjoelzapata1999@gmail.com');
            } catch { return false; }
        }
        function isAdminUser(){
            try {
                const u = JSON.parse(sessionStorage.getItem('user')||'{}');
                return (u.rol === 'admin' || (u.email||'').toLowerCase() === 'joelmoreno270599@gmail.com');
            } catch { return false; }
        }
        function refreshAuthButtons(){
            const goAdminBtn = document.getElementById('goAdminBtn');
            if (isClientUser()) clientLogoutBtn.style.display = 'inline-flex';
            else clientLogoutBtn.style.display = 'none';
            if (goAdminBtn) goAdminBtn.style.display = isAdminUser() ? 'inline-flex' : 'none';
        }
        clientLogoutBtn.addEventListener('click', async (e)=>{
            e.preventDefault();
            try { await signOut(auth); } catch(e){}
            try { await fetch('logout.php').catch(()=>{}); } catch(e){}
            sessionStorage.clear();
            window.location.href = 'index.php';
        });
        refreshAuthButtons();

        // Si venimos desde admin, limpiar el flag para evitar redirección de rebote
        try {
            const params = new URLSearchParams(window.location.search);
            if (params.get('from') === 'admin') {
                sessionStorage.removeItem('justLoggedIn');
            }
        } catch(_) {}

        onAuthStateChanged(auth, async (user) => {
            refreshAuthButtons();
            if (user && sessionStorage.getItem('justLoggedIn') === 'true') {
                sessionStorage.removeItem('justLoggedIn');
                try {
                    const userRole = await getUserRole(user.uid);
                    if (userRole === 'admin') {
                        window.location.href = 'admin.php';
                    } else {
                        // Forzar que los clientes permanezcan en cliente.php
                        window.location.href = 'cliente.php';
                    }
                } catch (e) { /* noop */ }
            }
        });
    </script>

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
<script src="Scriptsindex/faqs.js"></script>
<script>
    // Actualiza el año automáticamente en el footer
    document.addEventListener('DOMContentLoaded', function() {
        const footerBottom = document.querySelector('.footer-bottom');
        if (footerBottom) {
            footerBottom.innerHTML = footerBottom.innerHTML.replace('2025', new Date().getFullYear());
        }
        // Insertar contenedor de FAQs dinámicas justo debajo de la sección de FAQs existente
        try {
            const faqSection = document.querySelector('section.faq');
            if (faqSection) {
                const dyn = document.createElement('section');
                dyn.className = 'faq';
                dyn.id = 'faqs-dynamic-container';
                dyn.style.marginTop = '1.2rem';
                dyn.innerHTML = '<div class="container"><div id="faqs-dynamic"></div></div>';
                faqSection.insertAdjacentElement('afterend', dyn);
                if (typeof loadFaqs === 'function') {
                    loadFaqs('cliente', '#faqs-dynamic');
                }
            }
        } catch(e) {}
    });
</script>
<script>
    // Cargar estadísticas dinámicamente desde admin_api/stats.php y reflejarlas en la UI
    (async function loadDynamicStats(){
        try {
            const res = await fetch('admin_api/stats.php?action=get');
            if (!res.ok) return;
            const data = await res.json();
            const s = data.stats || {};

            // Hero stats (4 elementos): 0=deportes, 1=entrenadores, 2=alumnos, 3=alumnos_activos
            const heroNums = document.querySelectorAll('.hero .hero-stats .stat .stat-number');
            if (heroNums[0]) heroNums[0].textContent = s.deportes || heroNums[0].textContent;
            if (heroNums[1]) heroNums[1].textContent = s.entrenadores || heroNums[1].textContent;
            if (heroNums[2]) heroNums[2].textContent = s.alumnos || heroNums[2].textContent;
            if (heroNums[3]) heroNums[3].textContent = s.alumnos_activos || heroNums[3].textContent;

            // Sección Estadísticas (5 elementos): 0=deportes,1=entrenadores,2=alumnos, luego otros 2 cards (alumnos_activos y soporte)
            const statsNums = document.querySelectorAll('.estadisticas .stat-number');
            if (statsNums[0]) statsNums[0].textContent = s.deportes || statsNums[0].textContent;
            if (statsNums[1]) statsNums[1].textContent = s.entrenadores || statsNums[1].textContent;
            if (statsNums[2]) statsNums[2].textContent = s.alumnos || statsNums[2].textContent;
            if (statsNums[3]) statsNums[3].textContent = s.alumnos_activos || statsNums[3].textContent;
            if (statsNums[4]) statsNums[4].textContent = s.soporte || statsNums[4].textContent;
        } catch(e) {
            // Silencioso: no romper UI si falla la API
        }
    })();
    </script>