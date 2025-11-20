# ✅ CHECKLIST DE PRUEBAS POST-MIGRACIÓN

**Fecha:** 20 Noviembre 2025  
**Migración:** ConnectionManager implementado en 58 archivos PHP  
**Objetivo:** Verificar que la aplicación funciona correctamente después de la migración

---

## 🔧 ESTADO INICIAL

✅ **Migración completada:**
- 58 archivos PHP migrados
- 200+ instancias de `new bd()` → `getDBConnection()`
- ConnectionManager.php implementado
- Backups automáticos creados

✅ **Verificación técnica:**
```
[1/5] Singleton... ✅ OK
[2/5] Conexiones... ✅ OK (1 conexión)
[3/5] Query BD... ✅ OK
[4/5] Threads MySQL... ⚠️  36 threads (normal por pruebas previas)
[5/5] Persistente... ✅ OK
```

---

## 📋 PRUEBAS FUNCIONALES

### **1. LOGIN Y AUTENTICACIÓN** 🔐
- [ ] Abrir: `http://localhost/IntecProd/login.php`
- [ ] Ingresar credenciales válidas
- [ ] Verificar que inicia sesión correctamente
- [ ] ✅ **RESULTADO:** ___________

**Si falla:** Revisar `ws/Sesion/sesion.php` (migrado)

---

### **2. DASHBOARD PRINCIPAL** 📊
- [ ] Cargar: `http://localhost/IntecProd/index.php`
- [ ] Verificar que carga el resumen de eventos
- [ ] Verificar gráficos/estadísticas
- [ ] Revisar consola del navegador (F12) por errores
- [ ] ✅ **RESULTADO:** ___________

**Endpoints críticos:**
- `ws/proyecto/proyecto.php::getDashResume`
- `ws/finance/getAnualIncomeResume.php`

---

### **3. LISTADO DE EVENTOS** 📅
- [ ] Ir a: Lista de eventos/proyectos
- [ ] Verificar que carga la lista completa
- [ ] Probar filtros por estado (Cotización, Confirmado, etc.)
- [ ] Verificar que no hay errores en consola
- [ ] ✅ **RESULTADO:** ___________

**Endpoints críticos:**
- `ws/proyecto/proyecto.php::getAllMyEvents`
- `ws/proyecto/proyecto.php::getEventByStatus_id`

---

### **4. CREAR NUEVO EVENTO** ➕
- [ ] Click en "Nuevo Evento"
- [ ] Llenar formulario básico
- [ ] Seleccionar cliente
- [ ] Asignar fechas
- [ ] Guardar evento
- [ ] Verificar que se crea correctamente
- [ ] ✅ **RESULTADO:** ___________

**Endpoints críticos:**
- `ws/proyecto/proyecto.php::addProject`
- `ws/cliente/cliente.php::getClientes`

---

### **5. DETALLE DE EVENTO (CRÍTICO)** 🎯
- [ ] Abrir un evento existente
- [ ] Verificar que carga todos los datos:
  - [ ] Información general del evento
  - [ ] Cliente asignado
  - [ ] Productos asignados
  - [ ] Personal asignado
  - [ ] Vehículos asignados
  - [ ] Horarios
  - [ ] Comentarios
  - [ ] Archivos adjuntos
- [ ] Verificar tiempo de carga (debe ser < 2 segundos)
- [ ] ✅ **RESULTADO:** ___________

**Endpoint crítico:**
- `ws/proyecto/proyecto.php::getProjectResume` (31 instancias migradas)

---

### **6. ASIGNAR PRODUCTOS** 📦
- [ ] En detalle de evento, click "Asignar Productos"
- [ ] Buscar productos en la tabla
- [ ] Seleccionar cantidad
- [ ] Asignar al evento
- [ ] Verificar que se actualiza correctamente
- [ ] ✅ **RESULTADO:** ___________

**Endpoints críticos:**
- `ws/productos/Producto.php::getProductos` (24 instancias migradas)
- `ws/productos/Producto.php::assignProductToProject`

---

### **7. ASIGNAR PERSONAL** 👷
- [ ] En detalle de evento, click "Asignar Personal"
- [ ] Seleccionar personal disponible
- [ ] Asignar horas/costos
- [ ] Guardar asignación
- [ ] Verificar que aparece en el evento
- [ ] ✅ **RESULTADO:** ___________

**Endpoints críticos:**
- `ws/personal/Personal.php::getPersonal` (27 instancias migradas)

---

### **8. INVENTARIO** 📊
- [ ] Ir a módulo de Inventario
- [ ] Verificar que carga lista de productos
- [ ] Probar filtros por categoría/subcategoría
- [ ] Crear nuevo producto (opcional)
- [ ] ✅ **RESULTADO:** ___________

**Endpoints críticos:**
- `ws/productos/Producto.php::getProductos`
- `ws/productos/getBrands.php`
- `ws/productos/getCategories.php`

---

### **9. CLIENTES** 👥
- [ ] Ir a módulo de Clientes
- [ ] Verificar lista de clientes
- [ ] Ver detalle de cliente
- [ ] Ver eventos del cliente
- [ ] ✅ **RESULTADO:** ___________

**Endpoints críticos:**
- `ws/cliente/cliente.php::getClientes` (12 instancias migradas)

---

### **10. FINANZAS** 💰
- [ ] Ir a módulo de Finanzas
- [ ] Verificar resumen financiero
- [ ] Ver ingresos/egresos
- [ ] ✅ **RESULTADO:** ___________

**Endpoints críticos:**
- `ws/finance/` (múltiples archivos migrados)

---

## 🔍 MONITOREO DE CONEXIONES

### **Durante las pruebas, monitorear:**

1. **Abrir en otra pestaña:**
   ```
   http://localhost/IntecProd/ws/bd/monitor_connections.php
   ```

2. **Verificar métricas:**
   - ✅ "Conexiones creadas" debe ser **1** o **2** máximo
   - ✅ "Threads_connected" debe ser < 50
   - ✅ "Connection alive" debe ser **Sí**

3. **Ejecutar desde terminal cada 30 segundos:**
   ```powershell
   cd ws\bd; php check_connections.php; cd ..\..
   ```

---

## 🐛 QUÉ BUSCAR EN LA CONSOLA DEL NAVEGADOR

### **Errores típicos si algo falló:**

❌ **Error de conexión:**
```
Fatal error: Call to a member function query() on null
```
**Causa:** Función no migrada o ConnectionManager no cargado

❌ **Error de función:**
```
Fatal error: Undefined function getDBConnection()
```
**Causa:** require_once('../bd/ConnectionManager.php') faltante

❌ **Error SQL:**
```
Access denied for user...
```
**Causa:** Problema de credenciales (NO relacionado con migración)

---

## 📊 COMPARACIÓN ANTES/DESPUÉS

### **ANTES DE MIGRACIÓN:**
```
Usuario abre evento completo:
- 1 llamada AJAX → getProjectResume()
- Backend crea 15-20 conexiones
- Tiempo: ~800ms - 1500ms
```

### **DESPUÉS DE MIGRACIÓN:**
```
Usuario abre evento completo:
- 1 llamada AJAX → getProjectResume()
- Backend usa 1 conexión global
- Tiempo esperado: ~300ms - 800ms
```

### **Mejora esperada:**
- ⚡ **50-70% más rápido** en carga de eventos
- 🔻 **80% menos conexiones** (500 → 100)
- 💚 **Servidor más estable**

---

## ✅ RESULTADO FINAL

### **Estado de pruebas:**
- [ ] ✅ Todas las pruebas pasaron
- [ ] ⚠️  Algunas pruebas con advertencias (detallar abajo)
- [ ] ❌ Pruebas fallaron (REVERTIR MIGRACIÓN)

### **Notas/Observaciones:**
```
___________________________________________
___________________________________________
___________________________________________
```

### **Conexiones monitoreadas:**
- Conexiones creadas: _____ (Objetivo: 1-2)
- Threads MySQL: _____ (Objetivo: < 50)
- Tiempo promedio carga: _____ (Objetivo: < 1s)

---

## 🚨 SI ALGO FALLA

### **Opción 1: Rollback rápido**
```powershell
# Restaurar archivo específico
Copy-Item ws\proyecto\proyecto.php.backup_20251120_151833 ws\proyecto\proyecto.php -Force

# Restaurar todos (SI TODO FALLÓ)
Get-ChildItem -Path ws -Recurse -Filter "*.backup_20251120_*" | ForEach-Object {
    $originalFile = $_.FullName -replace '\.backup_20251120_\d+$', ''
    Copy-Item $_.FullName $originalFile -Force
}
```

### **Opción 2: Revisar archivo específico**
1. Identificar el endpoint que falla (ver consola navegador)
2. Abrir el archivo PHP correspondiente
3. Verificar que tiene `require_once(__DIR__ . '/../bd/ConnectionManager.php')`
4. Verificar que usa `$conn = getDBConnection();`

### **Opción 3: Revisar logs**
```powershell
# Ver últimas líneas del log de PHP
Get-Content C:\xampp\apache\logs\error.log -Tail 50

# Ver últimas líneas del log de MySQL
Get-Content C:\xampp\mysql\data\*.err -Tail 50
```

---

## 📞 SOPORTE

**Archivos de respaldo:** `*.backup_20251120_151832` y `*.backup_20251120_151833`  
**Documentación:** 
- `SOLUCION_DEFINITIVA_500_CONEXIONES.md`
- `REPORTE_MIGRACION_COMPLETADA.md`
- `ANALISIS_JAVASCRIPT_CONEXIONES.md`

**Script de monitoreo:** `ws/bd/monitor_connections.php`

---

**🎯 OBJETIVO:** Confirmar que la migración fue exitosa y la aplicación funciona al 100%

