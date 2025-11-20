<?php

/**
 * ============================================================================
 * CLASE DE CONEXIÓN A BASE DE DATOS - PATRÓN SINGLETON MEJORADO
 * ============================================================================
 * 
 * PROBLEMA RESUELTO:
 * - Hostinger limita las conexiones concurrentes (10-30)
 * - Este código estaba abriendo una nueva conexión en cada operación
 * - Resultado: +200 conexiones por request = App caída
 * 
 * SOLUCIÓN:
 * - Singleton: Una sola conexión compartida por todo el request
 * - Conexiones persistentes MySQL (p:host): Reutiliza conexiones entre requests
 * - Auto-cierre al final del script
 * - 100% compatible con código existente
 * 
 * USO (ambos funcionan igual):
 * - $conn = new bd(); $conn->conectar();  ✅ (código existente)
 * - $conn = bd::getInstance();             ✅ (recomendado)
 * 
 * MONITOREO:
 * - Ver estadísticas: bd::getStats()
 * - Ver estado: bd::getConnectionInfo()
 * 
 * @version 2.0 - Optimizado para Hostinger
 * @date 2024-11-20
 */
class bd
{
    // Propiedades protegidas (mantener compatibilidad)
    protected $servidor;
    protected $usuario;
    protected $password;
    protected $database;
    protected $port;
    
    // Propiedad pública mysqli (MANTENER - crítico para compatibilidad)
    public $mysqli;

    // Instancia singleton (privada)
    private static $instance = null;
    
    // Contador de conexiones (debug/monitoreo)
    private static $connectionCount = 0;
    private static $requestStartTime = 0;
    
    // Flag para saber si ya se registró el shutdown
    private static $shutdownRegistered = false;

    /**
     * Constructor - MANTIENE COMPORTAMIENTO ORIGINAL
     * Ahora usa el Singleton internamente, pero sigue funcionando con 'new bd()'
     */
    public function __construct() 
    {
        // Registrar tiempo de inicio del request (solo la primera vez)
        if (self::$requestStartTime === 0) {
            self::$requestStartTime = microtime(true);
        }
        
        // Si ya existe una instancia singleton, reutilizarla
        if (self::$instance !== null) {
            // Copiar propiedades de la instancia singleton
            $this->servidor = self::$instance->servidor;
            $this->usuario = self::$instance->usuario;
            $this->password = self::$instance->password;
            $this->database = self::$instance->database;
            $this->port = self::$instance->port;
            $this->mysqli = self::$instance->mysqli;
        } else {
            // Primera instancia - configurar credenciales
            // IMPORTANTE: Usar 'p:' para conexión persistente
            $this->servidor = 'p:145.223.105.141';  // p: = persistent connection
            $this->usuario = 'u136839350_intec_admin';
            $this->password = 'intecBd2023';
            $this->database = 'u136839350_intec';
            $this->port = '3306';
            
            // Guardar como instancia singleton
            self::$instance = $this;
            
            // Registrar función de cierre automático (solo una vez)
            if (!self::$shutdownRegistered) {
                register_shutdown_function([__CLASS__, 'shutdownHandler']);
                self::$shutdownRegistered = true;
            }
        }
    }

    /**
     * Método Singleton estático (NUEVO - RECOMENDADO)
     * Uso recomendado: $conn = bd::getInstance();
     * 
     * @return bd Instancia única de la clase
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
            self::$instance->conectar();
        }
        return self::$instance;
    }

    /**
     * Conectar a la base de datos
     * MANTIENE COMPORTAMIENTO ORIGINAL + mejoras automáticas
     */
    public function conectar() 
    {
        // Si ya hay conexión activa, verificar que funcione
        if ($this->mysqli instanceof mysqli) {
            // Verificar si la conexión está viva
            if (@$this->mysqli->ping()) {
                return; // Conexión ya existe y funciona
            } else {
                // Conexión perdida, cerrar y reconectar
                @$this->mysqli->close();
                $this->mysqli = null;
                self::$connectionCount--; // Decrementar porque vamos a reconectar
            }
        }

        // Crear nueva conexión (solo si no existe)
        // NOTA: $this->servidor ya incluye 'p:' para conexión persistente
        $this->mysqli = new mysqli($this->servidor, $this->usuario, $this->password, $this->database, $this->port);
        
        if (mysqli_connect_errno()) {
            error_log("ERROR BD [" . date('Y-m-d H:i:s') . "]: " . mysqli_connect_error());
            
            // Si falla la conexión persistente, intentar sin 'p:'
            if (strpos($this->servidor, 'p:') === 0) {
                $servidor_sin_p = substr($this->servidor, 2);
                $this->mysqli = new mysqli($servidor_sin_p, $this->usuario, $this->password, $this->database, $this->port);
                
                if (mysqli_connect_errno()) {
                    echo 'Error en base de datos: '. mysqli_connect_error();
                    exit();
                }
            } else {
                echo 'Error en base de datos: '. mysqli_connect_error();
                exit();
            }
        }
        
        // Configuración UTF-8
        $this->mysqli->set_charset("utf8");
        $this->mysqli->query("SET NAMES 'utf8'");
        $this->mysqli->query("SET CHARACTER SET utf8");
        
        // Configuraciones adicionales para optimizar la conexión
        $this->mysqli->query("SET SESSION wait_timeout = 28800"); // 8 horas
        $this->mysqli->query("SET SESSION interactive_timeout = 28800");
        
        // Incrementar contador (debug)
        self::$connectionCount++;
        
        // Actualizar la instancia singleton si existe
        if (self::$instance !== null && self::$instance !== $this) {
            self::$instance->mysqli = $this->mysqli;
        }
    }

    /**
     * Desconectar - MODIFICADO para Singleton
     * Ya NO cierra la conexión compartida, solo libera la referencia local
     */
    public function desconectar() 
    {
        // En modo singleton, NO cerramos la conexión compartida
        // La conexión se cierra automáticamente al final del script
        // Esto es 100% seguro y mantiene compatibilidad con código existente
        
        // Solo limpiar referencia si no es la instancia principal
        if ($this !== self::$instance && $this->mysqli !== null) {
            // Esta instancia no es el singleton, solo limpiar referencia
            $this->mysqli = null;
        }
        // Si ES el singleton, mantener conexión abierta para reutilizar
    }
    
    /**
     * Forzar cierre de conexión (NUEVO - para scripts CLI o cierre final)
     */
    public function desconectarForzado()
    {
        if ($this->mysqli instanceof mysqli) {
            @mysqli_close($this->mysqli);
            $this->mysqli = null;
        }
        
        if (self::$instance !== null && self::$instance->mysqli instanceof mysqli) {
            @mysqli_close(self::$instance->mysqli);
            self::$instance->mysqli = null;
        }
        
        self::$instance = null;
    }
    
    /**
     * Handler que se ejecuta al final del script PHP
     * Cierra la conexión automáticamente
     */
    public static function shutdownHandler()
    {
        // Solo cerrar si hay una instancia activa
        if (self::$instance !== null && self::$instance->mysqli instanceof mysqli) {
            
            // Log de estadísticas (opcional, comentar si genera muchos logs)
            if (self::$connectionCount > 0) {
                $duration = microtime(true) - self::$requestStartTime;
                $stats = self::getStats();
                
                // Solo loguear si hubo actividad significativa o errores
                if ($duration > 5 || self::$connectionCount > 3) {
                    error_log(sprintf(
                        "BD Stats: %d conexiones, %.2fs, Status: %s",
                        self::$connectionCount,
                        $duration,
                        $stats['connection_alive'] ? 'OK' : 'FAILED'
                    ));
                }
            }
            
            // Cerrar conexión
            @self::$instance->mysqli->close();
            self::$instance->mysqli = null;
        }
    }
    
    /**
     * Obtener estadísticas de conexión (NUEVO - para debugging)
     * 
     * @return array Información de debug
     */
    public static function getStats()
    {
        return [
            'connection_count' => self::$connectionCount,
            'singleton_active' => self::$instance !== null,
            'connection_alive' => (self::$instance && self::$instance->mysqli instanceof mysqli && @self::$instance->mysqli->ping()),
            'request_duration' => microtime(true) - self::$requestStartTime,
            'memory_usage' => memory_get_usage(true) / 1024 / 1024 . ' MB'
        ];
    }
    
    /**
     * Obtener información detallada de la conexión (NUEVO - para monitoreo)
     * 
     * @return array|false Información de la conexión o false si no hay conexión
     */
    public static function getConnectionInfo()
    {
        if (self::$instance === null || !self::$instance->mysqli instanceof mysqli) {
            return false;
        }
        
        $mysqli = self::$instance->mysqli;
        
        return [
            'server_info' => $mysqli->server_info,
            'host_info' => $mysqli->host_info,
            'protocol_version' => $mysqli->protocol_version,
            'thread_id' => $mysqli->thread_id,
            'character_set' => $mysqli->character_set_name(),
            'is_persistent' => strpos(self::$instance->servidor, 'p:') === 0,
            'stats' => self::getStats()
        ];
    }
    
    /**
     * Verificar y reparar conexión si está caída (NUEVO)
     * 
     * @return bool True si la conexión está OK, false si falló
     */
    public function checkAndRepair()
    {
        if (!$this->mysqli instanceof mysqli || !@$this->mysqli->ping()) {
            error_log("BD: Conexión caída, intentando reconectar...");
            $this->conectar();
            return ($this->mysqli instanceof mysqli && @$this->mysqli->ping());
        }
        return true;
    }
}

?>
