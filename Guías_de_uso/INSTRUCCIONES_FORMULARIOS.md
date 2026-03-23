# 📋 INSTRUCCIONES PARA FORMULARIOS Y BASE DE DATOS

## 🔧 CONFIGURACIÓN INICIAL

### 1. **Base de Datos InfinityFree**
- Los datos de conexión ya están configurados en `conexión.php`
- Host: `sql107.infinityfree.com`
- Base de datos: `if0_39340780_guardar_base_datos`

### 2. **Crear Tablas en la Base de Datos**
Ejecuta el archivo `crear_tablas.sql` en tu panel de control de InfinityFree:
- Ve a tu panel de control de InfinityFree
- Accede a phpMyAdmin
- Selecciona tu base de datos
- Ejecuta el contenido del archivo `crear_tablas.sql`

## 📝 FORMULARIOS DISPONIBLES

### **Formulario de Contacto** (`contacto.html`)
- **Archivo de procesamiento**: `guardar.php`
- **Campos**: nombre, email, teléfono, motivo, mensaje, privacidad
- **Tabla**: `contactos`

### **Formulario de Planes** (`planes.html`)
- **Archivo de procesamiento**: `guardar.php`
- **Campos**: nombre, email, teléfono, motivo, mensaje
- **Tabla**: `contactos`

### **Formulario de Entrenadores** (`entrenadores.html`)
- **Archivo de procesamiento**: `guardar.php`
- **Campos**: nombre, email, teléfono, motivo, mensaje
- **Tabla**: `contactos`

### **Formulario de Servicios** (`servicios.html`)
- **Archivo de procesamiento**: `guardar.php`
- **Campos**: nombre, email, teléfono, motivo, mensaje
- **Tabla**: `contactos`

## 🧪 PRUEBAS

### **Verificar Conexión**
1. Sube todos los archivos a tu hosting
2. Accede a `test_conexion.php` desde tu navegador
3. Verifica que aparezcan mensajes de éxito

### **Probar Formularios**
1. Llena cualquier formulario con datos de prueba
2. Envía el formulario
3. Verifica que aparezca el mensaje de éxito
4. Revisa en la base de datos que se haya guardado el registro

## 🚨 SOLUCIÓN DE PROBLEMAS

### **Error de Conexión**
- Verifica que los datos en `conexión.php` sean correctos
- Asegúrate de que tu hosting permita conexiones MySQL externas

### **Error de Tablas**
- Ejecuta el archivo `crear_tablas.sql` en tu base de datos
- Verifica que las tablas se hayan creado correctamente

### **Formularios No Funcionan**
- Verifica que `guardar.php` esté en la misma carpeta que los HTML
- Asegúrate de que PHP esté habilitado en tu hosting
- Revisa los logs de error de tu hosting

## 📊 ESTRUCTURA DE LA BASE DE DATOS

### **Tabla `contactos`**
```sql
- id (AUTO_INCREMENT)
- nombre (VARCHAR 100)
- email (VARCHAR 100)
- telefono (VARCHAR 20)
- motivo (VARCHAR 50)
- mensaje (TEXT)
- fecha_creacion (DATETIME)
- estado (ENUM: pendiente, respondido, archivado)
```

### **Tabla `solicitudes_info`**
```sql
- id (AUTO_INCREMENT)
- nombre (VARCHAR 100)
- email (VARCHAR 100)
- telefono (VARCHAR 20)
- servicio (VARCHAR 100)
- plan (VARCHAR 50)
- mensaje (TEXT)
- fecha_solicitud (DATETIME)
- estado (ENUM: pendiente, respondido, archivado)
```

## 🔒 SEGURIDAD

- Todos los formularios usan consultas preparadas para prevenir SQL injection
- Los datos se validan tanto en el frontend como en el backend
- Se incluye validación de email y campos obligatorios

## 📁 ARCHIVOS IMPORTANTES

- `conexión.php` - Configuración de la base de datos
- `guardar.php` - Procesamiento de formularios
- `crear_tablas.sql` - Script para crear tablas
- `test_conexion.php` - Archivo de prueba (eliminar en producción)

## ✅ VERIFICACIÓN FINAL

Después de la configuración, todos los formularios deberían:
1. ✅ Conectarse correctamente a la base de datos
2. ✅ Guardar los datos en las tablas correspondientes
3. ✅ Mostrar mensajes de éxito/error apropiados
4. ✅ Redirigir a la página correcta después del envío

---

**Nota**: Una vez que todo funcione correctamente, elimina los archivos `test_conexion.php` y `crear_tablas.sql` de tu servidor por seguridad.
