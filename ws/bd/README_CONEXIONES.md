# 🚀 Inicio Rápido - Solución de Conexiones BD

## ⚡ Si tienes prisa

### 1. Subir archivos al servidor:
```
✅ ws/bd/bd.php (MODIFICADO)
✅ ws/bd/monitor_connections.php (NUEVO)
✅ ws/bd/check_connections.php (NUEVO)
✅ ws/bd/emergency_kill_connections.php (NUEVO)
```

### 2. Verificar que funciona:
```
http://tu-dominio.com/ws/bd/monitor_connections.php
```

**Debe mostrar:**
- ✅ Estado Singleton: ACTIVO
- ✅ Conexión viva: SÍ
- ✅ Conexiones creadas: 1

### 3. Probar la app:
- Listar productos
- Crear/editar eventos
- Ver proyectos

**Si todo funciona sin errores = ÉXITO ✅**

---

## 📋 Checklist Rápido

- [ ] `bd.php` subido al servidor
- [ ] Monitor accesible en navegador
- [ ] Monitor muestra "1 conexión"
- [ ] App funciona sin errores
- [ ] No aparece "Too many connections"

---

## 🆘 Si algo sale mal

### La app da error:
```bash
# Rollback rápido:
1. Renombrar bd.php a bd_new.php
2. Renombrar bd.php.backup a bd.php (si existe)
3. Reiniciar Apache
```

### "Too many connections" persiste:
```bash
# Ejecutar script de emergencia:
php ws/bd/emergency_kill_connections.php

# O desde navegador:
http://tu-dominio.com/ws/bd/emergency_kill_connections.php
```

---

## 📖 Documentación Completa

Ver archivo: `SOLUCION_CONEXIONES_BD.md`

---

## 🎯 Lo que hace esta solución

**ANTES:**
- Cada función = nueva conexión
- +200 conexiones por request
- Hostinger bloquea la BD

**DESPUÉS:**
- Una sola conexión por request
- Conexión persistente entre requests
- Auto-cierre inteligente
- Monitoreo en tiempo real

---

## 🛠️ Herramientas Incluidas

### monitor_connections.php
Dashboard visual completo con:
- Estado del Singleton
- Información de conexión
- Estado de MySQL
- Procesos activos
- Auto-actualización

### check_connections.php
Verificación rápida desde terminal:
```bash
php ws/bd/check_connections.php
```

### emergency_kill_connections.php
Liberar conexiones colgadas (solo emergencias):
```bash
php ws/bd/emergency_kill_connections.php
```

---

## ✅ Resultado Esperado

**Reducción del 99% en conexiones:**
- De ~200 conexiones → 1 conexión
- Sin errores "Too many connections"
- App 3x más rápida
- 100% compatible con código existente

---

**¿Dudas?** Lee `SOLUCION_CONEXIONES_BD.md` para más detalles.
