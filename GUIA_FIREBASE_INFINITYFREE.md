# Guía: Vincular Firebase con InfinityFree

## Tu Configuración Actual

✅ **Firebase Auth** configurado para login con Google
✅ **MySQL** como base de datos (InfinityFree ofrece MySQL gratuito)
✅ **Proyecto Firebase**: `proyectoweb-fc2d2`

---

## PASO 1: Autorizar Dominio de InfinityFree en Firebase Console

### 1.1 Obtén tu dominio de InfinityFree
1. Inicia sesión en [InfinityFree](https://www.infinityfree.com)
2. Ve a tu cuenta de hosting
3. Copia tu dominio (ejemplo: `tudominio.rf.gd` o `tudominio.epizy.com`)

### 1.2 Agrega el dominio a Firebase
1. Ve a [Firebase Console](https://console.firebase.google.com)
2. Selecciona tu proyecto: `proyectoweb-fc2d2`
3. Ve a **Authentication** → **Settings** → **Authorized domains**
4. Haz clic en **Add domain**
5. Agrega tu dominio de InfinityFree (ejemplo: `tudominio.rf.gd`)
6. También agrega: `localhost` (para pruebas locales)

### Dominios que debes autorizar:
```
localhost
tudominio.rf.gd
tudominio.epizy.com
```

---

## PASO 2: Actualizar Conexión a Base de Datos

### 2.1 Obtén los datos de MySQL de InfinityFree
1. En InfinityFree, ve a **Control Panel** → **MySQL Databases**
2. Copia estos datos:
   - **MySQL Host** (ejemplo: `sqlXXX.epizy.com`)
   - **MySQL Database Name** (ejemplo: `epiz_XXXXX_plataforma_fitness`)
   - **MySQL Username** (ejemplo: `epiz_XXXXX`)
   - **MySQL Password** (la que configuraste)

### 2.2 Actualiza el archivo `conexión.php`
Reemplaza el contenido de [`conexión.php`](conexión.php:1) con:

```php
<?php
// Configuración para InfinityFree
$host = "sqlXXX.epizy.com";  // Tu MySQL Host de InfinityFree
$user = "epiz_XXXXX";         // Tu MySQL Username de InfinityFree
$password = "tu_contraseña";  // Tu MySQL Password de InfinityFree
$database = "epiz_XXXXX_plataforma_fitness"; // Tu MySQL Database Name

// Crear conexión
$conexion = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Establecer charset a utf8
$conexion->set_charset("utf8");
?>
```

### 2.3 Importa tu base de datos a InfinityFree
1. En InfinityFree, ve a **phpMyAdmin**
2. Selecciona tu base de datos
3. Ve a la pestaña **Import**
4. Sube tu archivo SQL desde la carpeta [`BD/`](BD/)
5. Ejecuta la importación

---

## PASO 3: Verificar Configuración de Firebase Auth

### 3.1 Archivos que usan Firebase Auth
Estos archivos ya tienen Firebase configurado correctamente:
- [`index.php`](index.php:93) - Login en página principal
- [`cliente.php`](cliente.php:38) - Login en panel de cliente
- [`auth.php`](auth.php:5) - Verificación de tokens

### 3.2 Verifica que los scripts de Firebase se carguen
En [`index.php`](index.php:94) y [`cliente.php`](cliente.php:39), verifica que los scripts de Firebase se carguen desde CDN:
```javascript
import { initializeApp } from 'https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js';
import { getAuth, GoogleAuthProvider, signInWithPopup, onAuthStateChanged, signOut } from 'https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js';
```

✅ **Esto ya está configurado correctamente en tu proyecto**

---

## PASO 4: Subir Archivos a InfinityFree

### 4.1 Sube todos los archivos
1. Usa **File Manager** de InfinityFree o un cliente FTP (FileZilla)
2. Sube todos los archivos a la carpeta `htdocs` o `public_html`
3. Asegúrate de incluir:
   - Todos los archivos `.php`
   - Todas las carpetas (`css/`, `imagenes/`, `admin_api/`, etc.)
   - El archivo [`conexión.php`](conexión.php:1) actualizado

### 4.2 Estructura de archivos en InfinityFree
```
htdocs/
├── index.php
├── cliente.php
├── admin.php
├── auth.php
├── conexión.php  ← Actualizado con datos de InfinityFree
├── css/
├── imagenes/
├── admin_api/
├── BD/
└── ... (todos los demás archivos)
```

---

## PASO 5: Probar la Conexión

### 5.1 Prueba la conexión a la base de datos
1. Accede a: `https://tudominio.rf.gd/test_db.php`
2. Deberías ver "Conexión exitosa"

### 5.2 Prueba el login con Google
1. Accede a: `https://tudominio.rf.gd/index.php`
2. Haz clic en "Iniciar sesión con Google"
3. Debería abrirse una ventana de Google
4. Después de autenticarte, deberías ser redirigido a `cliente.php`

---

## Solución de Problemas

### Error: "Dominio no autorizado para Firebase"
**Solución**: Agrega tu dominio de InfinityFree a **Authorized domains** en Firebase Console

### Error: "Error de conexión a la base de datos"
**Solución**: Verifica los datos de MySQL en [`conexión.php`](conexión.php:1):
- MySQL Host
- MySQL Username
- MySQL Password
- MySQL Database Name

### Error: "Token inválido"
**Solución**: Verifica que el `project_id` en [`auth.php`](auth.php:6) sea correcto:
```php
$project_id = 'proyectoweb-fc2d2';
```

### El login con Google no abre la ventana
**Solución**: 
1. Verifica que tu dominio esté en **Authorized domains**
2. Limpia la caché del navegador
3. Verifica la consola del navegador (F12) para errores

---

## Resumen de Configuración

### Firebase Console
- **Project ID**: `proyectoweb-fc2d2`
- **Authorized domains**: 
  - `localhost`
  - `tudominio.rf.gd` (tu dominio de InfinityFree)

### Base de Datos MySQL (InfinityFree)
- **Host**: `sqlXXX.epizy.com`
- **Database**: `epiz_XXXXX_plataforma_fitness`
- **Username**: `epiz_XXXXX`
- **Password**: (tu contraseña)

### Archivos Actualizados
- [`conexión.php`](conexión.php:1) - Conexión a MySQL de InfinityFree
- [`auth.php`](auth.php:5) - Verificación de tokens Firebase (ya configurado)
- [`index.php`](index.php:93) - Login con Google (ya configurado)
- [`cliente.php`](cliente.php:38) - Login con Google (ya configurado)

---

## URLs de Prueba

Después de subir todo, prueba estas URLs:

1. **Página principal**: `https://tudominio.rf.gd/index.php`
2. **Test de base de datos**: `https://tudominio.rf.gd/test_db.php`
3. **Login con Google**: `https://tudominio.rf.gd/index.php` (botón de Google)

---

## Notas Importantes

1. **Firebase Auth es gratuito** para autenticación básica
2. **InfinityFree MySQL es gratuito** hasta 5GB
3. **No necesitas cambiar el código** de Firebase Auth, solo autorizar el dominio
4. **La base de datos es MySQL**, no Firebase Realtime Database
5. **Firebase solo se usa para autenticación**, los datos se guardan en MySQL

---

## Soporte

Si tienes problemas:
1. Revisa la consola del navegador (F12) para errores JavaScript
2. Revisa los logs de error de InfinityFree
3. Verifica que todos los dominios estén autorizados en Firebase Console
4. Asegúrate de que la base de datos MySQL esté importada correctamente

¡Tu plataforma debería funcionar perfectamente en InfinityFree con Firebase Auth!
