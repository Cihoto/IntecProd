<?php
class bd{
    protected $servidor;
    protected $usuario;
    protected $password;
    protected $database;
    protected $port;
    public $mysqli;


    
    public function __construct() {

        /*
        $this->servidor = getenv('mysql_host'); 
        $this->usuario = getenv('mysql_user');
        $this->password = getenv('mysql_password');
        $this->database = getenv('mysql_database');
        $this->port = getenv('mysql_port');
        */
        
        $this->servidor = '154.49.142.103';
        $this->usuario = 'u136839350_intec_admin';
        $this->password = 'intecBd2023';
        // $this->password = 'Intec2023.';
        $this->database = 'u136839350_intec';
        $this->port ='3306';
        
    }


    // protected $mysqli;

    // public function bd(){
    //     $this->mysqli = new mysqli('DB_HOST','DB_USER','DB_PASS','DB_NAME');

    //     if($this->mysqli->connect_errno){
    //         echo "fallo al conectar a Mysql:". $this->mysqli->connect_error;
    //         return;
    //     }

    //     $this->mysqli->set_charset('DB_CHARSET');
    // }



    public function conectar() {
        
        $this->mysqli = new mysqli($this->servidor, $this->usuario, $this->password, $this->database, $this->port);
        if (mysqli_connect_errno()) {
            echo 'Error en base de datos: '. mysqli_connect_error();
            exit();
        }
        $this->mysqli->set_charset("utf8");
        $this->mysqli->query("SET NAMES 'utf8'");
        $this->mysqli->query("SET CHARACTER SET utf8");
    }

    public function desconectar() {
        mysqli_close($this->mysqli);
    }
}

?>