<?php

/**
 * Clase de conexión a Base de Datos con patrón Singleton
 * 
 * RETROCOMPATIBILIDAD TOTAL:
 * - Funciona con: $conn = new bd(); $conn->conectar();
 * - Funciona con: $conn = bd::getInstance();
 * - Mantiene acceso a $conn->mysqli
 * 
 * MEJORAS:
 * - Singleton pattern: Una sola conexión compartida
 * - Auto-reconexión: Si la conexión se pierde, se reconecta
 * - Lazy loading: Conexión solo cuando se necesita
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
    
    // Contador de conexiones (debug)
    private static $connectionCount = 0;

    /**
     * Constructor - MANTIENE COMPORTAMIENTO ORIGINAL
     * Ahora usa el Singleton internamente, pero sigue funcionando con 'new bd()'
     */
    public function __construct() 
    {
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
            $this->servidor = '145.223.105.141';
            $this->usuario = 'u136839350_intec_admin';
            $this->password = 'intecBd2023';
            $this->database = 'u136839350_intec';
            $this->port = '3306';
            
            // Guardar como instancia singleton
            self::$instance = $this;
        }
    }

    /**
     * Método Singleton estático (NUEVO - OPCIONAL)
     * Uso recomendado: $conn = bd::getInstance();
     * 
     * @return bd Instancia única de la clase
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
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
            }
        }

        // Crear nueva conexión (solo si no existe)
        $this->mysqli = new mysqli($this->servidor, $this->usuario, $this->password, $this->database, $this->port);
        
        if (mysqli_connect_errno()) {
            echo 'Error en base de datos: '. mysqli_connect_error();
            exit();
        }
        
        $this->mysqli->set_charset("utf8");
        $this->mysqli->query("SET NAMES 'utf8'");
        $this->mysqli->query("SET CHARACTER SET utf8");
        
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
        // Solo liberamos la referencia si no es la instancia principal
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
            'connection_alive' => (self::$instance && self::$instance->mysqli instanceof mysqli && @self::$instance->mysqli->ping())
        ];
    }
}

?>
