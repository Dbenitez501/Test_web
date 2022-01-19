<?php

/**
 * Clase para la conexión con la base de datos
 */
class DB
{
    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;

    //Constructor de la clase DB
    public function __construct()
    {
        $this->host     = 'localhost';
        $this->db       = 'conferencias';
        $this->user     = 'root';
        $this->password = '';
        $this->charset  = 'utf8mb4';
    }

    /**
     * Conexión a la base de datos
     * 
     * Esta función crea la cadena de conexión para la base de datos,
     * utilizando el método PDO que nos ayuda a debuguear errores más fácil.
     *
     * @return void
     */
    public function connect()
    {
        try{
            $connection = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                        PDO::ATTR_EMULATE_PREPARES => false];

            $pdo = new PDO($connection, $this->user, $this->password, $options);

            return $pdo;

        }catch(PDOException $e){
            print_r("Error connection: " . $e->getMessage());
        }
    }
}

?>