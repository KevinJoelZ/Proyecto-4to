<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeporteFit - Acceso Deportivo</title>
    <link rel="icon" type="image/svg+xml" href="favicon.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Firebase SDK -->
    <link rel="stylesheet" href="./css/styleindex.css">
</head>

<body>
    <div id="particles-js"></div>

    <div class="container">
        <div class="logo">
            <i class="fas fa-running logo-icon"></i>
            <span class="logo-text">DeporteFit</span>
        </div>

        <!-- Modal de selección de cuenta -->
        <div id="accountModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:1000; align-items:center; justify-content:center;">
            <div style="background:#fff; width:90%; max-width:420px; border-radius:14px; box-shadow:0 12px 40px rgba(0,0,0,.18); overflow:hidden;">
                <div style="padding:16px 18px; background:#f7fbff; border-bottom:1px solid #e5e7eb; display:flex; align-items:center; gap:.6rem;">
                    <i class="fas fa-user-check" style="color:#4CAF50;"></i>
                    <strong>Selecciona el correo para iniciar sesión</strong>
                </div>
                <div style="padding:16px 18px; display:flex; flex-direction:column; gap:.6rem;">
                    <button class="account-option" data-email="kevinjoelzapata1999@gmail.com" style="display:flex; align-items:center; gap:.7rem; padding:10px 12px; border:1px solid #e5e7eb; border-radius:10px; background:#fff; cursor:pointer;">
                        <i class="fas fa-envelope" style="color:#1976d2;"></i>
                        <div style="text-align:left;">
                            <div style="font-weight:700; color:#111827;">Cliente</div>
                            <div style="color:#374151; font-size:.92rem;">kevinjoelzapata1999@gmail.com</div>
                        </div>
                    </button>
                    <button class="account-option" data-email="joelmoreno270599@gmail.com" style="display:flex; align-items:center; gap:.7rem; padding:10px 12px; border:1px solid #e5e7eb; border-radius:10px; background:#fff; cursor:pointer;">
                        <i class="fas fa-user-shield" style="color:#ff9800;"></i>
                        <div style="text-align:left;">
                            <div style="font-weight:700; color:#111827;">Administrador</div>
                            <div style="color:#374151; font-size:.92rem;">joelmoreno270599@gmail.com</div>
                        </div>
                    </button>
                    <button id="closeAccountModal" style="margin-top:6px; align-self:flex-end; background:#fff; color:#374151; border:1px solid #e5e7eb; padding:8px 10px; border-radius:8px; cursor:pointer;">Cancelar</button>
                </div>
            </div>
        </div>

        <div class="hero">
            <h1>Conecta con el mundo deportivo</h1>
            <p>Accede a estadísticas personalizadas, conecta con otros atletas y lleva tu rendimiento al siguiente nivel.</p>
        </div>

        <div class="divider"></div>

        <div class="features">
            <div class="feature">
                <i class="fas fa-chart-line"></i>
                <h3>Estadísticas Avanzadas</h3>
                <p>Seguimiento detallado de tu progreso deportivo</p>
            </div>

            <div class="feature">
                <i class="fas fa-users"></i>
                <h3>Comunidad Global</h3>
                <p>Conecta con deportistas de todo el mundo</p>
            </div>

            <div class="feature">
                <i class="fas fa-layer-group"></i>
                <h3>Servicios y Planes</h3>
                <p>Descubre nuestros servicios y planes: elige el que mejor se adapte a tus objetivos.</p>
            </div>
        </div>

        <button id="googleSignIn" class="google-btn">
            <i class="fab fa-google google-icon"></i>
            Iniciar sesión con Google
        </button>

        <div id="loading" class="message loading" style="display: none;">Cargando...</div>
        <div id="success" class="message success" style="display: none;">¡Inicio de sesión exitoso! Redirigiendo...</div>
        <div id="error" class="message error" style="display: none;"></div>

        <div class="footer">
            <p> 2025 DeporteFit. Todos los derechos reservados.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script src="./Scriptsindex/Particulas.js"></script>
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

        // Elementos del DOM
        const googleSignInBtn = document.getElementById('googleSignIn');
        const loadingDiv = document.getElementById('loading');
        const successDiv = document.getElementById('success');
        const errorDiv = document.getElementById('error');
        const accountModal = document.getElementById('accountModal');
        let selectedEmail = null;

        // Función para mostrar mensajes
        function showMessage(type, message = '') {
            loadingDiv.style.display = 'none';
            successDiv.style.display = 'none';
            errorDiv.style.display = 'none';
            switch (type) {
                case 'loading':
                    loadingDiv.style.display = 'block';
                    break;
                case 'success':
                    successDiv.style.display = 'block';
                    break;
                case 'error':
                    errorDiv.style.display = 'block';
                    if (message) errorDiv.textContent = ' ' + message;
                    break;
            }
        }

        // Guardar usuario en BD
        async function saveUserToDatabase(user) {
            const userData = {
                uid: user.uid,
                name: user.displayName,
                email: user.email,
                photoURL: user.photoURL,
                emailVerified: user.emailVerified,
                rol: "cliente"
            };
            const response = await fetch('./login/guardar_usuario.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(userData)
            });
            const result = await response.json().catch(() => ({ success: false }));
            return result.success;
        }

        // Obtener rol desde BD
        async function getUserRole(uid) {
            try {
                const response = await fetch('./login/obtener_rol.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ uid })
                });
                const result = await response.json();
                return result.success ? result.rol : 'cliente';
            } catch (e) {
                return 'cliente';
            }
        }

        // Parámetros de URL
        function getUrlParameter(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        // Sanitizar returnUrl para evitar open redirects
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
            return sanitizeReturnUrl(getUrlParameter('returnUrl'));
        }

        // Login con Google
        async function signInWithGoogle() {
            try {
                showMessage('loading');
                googleSignInBtn.disabled = true;
                sessionStorage.clear();
                const result = await signInWithPopup(auth, provider);
                const user = result.user;

                // Verificar que el correo coincida con el seleccionado
                if (selectedEmail && user.email.toLowerCase() !== selectedEmail.toLowerCase()) {
                    await signOut(auth).catch(() => {});
                    showMessage('error', 'Debes iniciar sesión con el correo seleccionado: ' + selectedEmail);
                    return;
                }

                await saveUserToDatabase(user);
                const userRole = await getUserRole(user.uid);

                const userData = {
                    uid: user.uid,
                    name: user.displayName,
                    email: user.email,
                    photoURL: user.photoURL,
                    rol: userRole
                };
                sessionStorage.setItem('user', JSON.stringify(userData));
                sessionStorage.setItem('justLoggedIn', 'true');

                showMessage('success');
                setTimeout(async () => {
                    if (userRole === 'admin') {
                        // Crear sesión PHP para que admin.php no rebote
                        try { await fetch('./login/crear_sesion.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ uid: user.uid }) }); } catch (e) {}
                        window.location.href = 'admin.php';
                    } else {
                        // Crear sesión PHP también para clientes (para usar APIs que requieren $_SESSION)
                        try { await fetch('./login/crear_sesion.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ uid: user.uid }) }); } catch (e) {}
                        const returnUrl = getReturnUrl();
                        window.location.href = returnUrl ? returnUrl : 'cliente.php';
                    }
                }, 2000);
            } catch (error) {
                console.error('Error en la autenticación:', error);
                showMessage('error', error.message || 'Error de autenticación');
            } finally {
                googleSignInBtn.disabled = false;
            }
        }

        // Abrir modal de selección antes de login
        function openAccountModal() {
            accountModal.style.display = 'flex';
        }
        function closeAccountModal() {
            accountModal.style.display = 'none';
        }
        document.getElementById('closeAccountModal').addEventListener('click', () => { selectedEmail = null; closeAccountModal(); });
        accountModal.addEventListener('click', (e) => { if (e.target === accountModal) { selectedEmail = null; closeAccountModal(); } });
        document.querySelectorAll('.account-option').forEach(btn => {
            btn.addEventListener('click', () => {
                selectedEmail = btn.getAttribute('data-email');
                closeAccountModal();
                signInWithGoogle();
            });
        });
        // Click del botón principal abre el modal
        googleSignInBtn.addEventListener('click', openAccountModal);

        // onAuthStateChanged para redirección post-login
        onAuthStateChanged(auth, async (user) => {
            if (getUrlParameter('action') === 'logout') {
                sessionStorage.clear();
                const newUrl = window.location.pathname;
                window.history.replaceState(null, '', newUrl);
                return;
            }
            if (user && sessionStorage.getItem('justLoggedIn') === 'true') {
                sessionStorage.removeItem('justLoggedIn');
                try {
                    const userRole = await getUserRole(user.uid);
                    if (userRole === 'admin') {
                        try { await fetch('./login/crear_sesion.php', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ uid: user.uid }) }); } catch(e){}
                        window.location.href = 'admin.php';
                    } else {
                        // Crear sesión PHP también para clientes
                        try { await fetch('./login/crear_sesion.php', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ uid: user.uid }) }); } catch(e){}
                        const returnUrl = getReturnUrl();
                        window.location.href = returnUrl ? returnUrl : 'cliente.php';
                    }
                } catch (e) {
                    console.error('Error al obtener rol durante redirección:', e);
                }
            }
        });

        console.log('Firebase inicializado correctamente');
    </script>


</body>

</html>