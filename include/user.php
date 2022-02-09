<?php

include_once 'db.php';

class User extends DB
{
    private $idUsu;
    private $nombre;
    private $username;
    private $correo;
    private $sexo;
    private $tipo;
    private $tipoNombre;
    private $carrera;
    private $matricula;
    private $telefono;    

    public function userExists($user, $pass)
    {
        $query = $this->connect()->prepare('SELECT * FROM usuarios WHERE username = :user AND contra = :pass');
        $query->execute(['user' => $user, 'pass' => $pass]);

        if($query->rowCount())
        {
            return true;
        } else {
            return false;
        }
    }

    public function getPassCifrada($user) {
        $query = $this->connect()->prepare('SELECT contra FROM usuarios WHERE username = :user');
        $query->execute(['user' => $user]);
        foreach($query as $pass) {
            return $pass['contra'];
        }
    }

    /**
     * Una vez que se confirma que el usuario está registrado, obtenemos sus datos de la BD
     * y le asignamos los valores a las variables globales de esta clase para poder manejarlos
     * en el ciclo de vida de la sesión de usuario.
     *
     * @param [User] $user
     * @return void
     */
    public function setUser($user)
    {
        $query = $this->connect()->prepare('SELECT * FROM usuarios WHERE username = :user');
        $query->execute(['user' => $user]);

        foreach($query as $currentUser)
        {
            $this->idUsu = $currentUser['id_usuario'];
            $this->nombre = $currentUser['nombre'];
            $this->username = $currentUser['username'];
            $this->correo = $currentUser['correo'];
            $this->sexo = $currentUser['sexo'];
            $this->tipo = $currentUser['id_tipo'];
            $this->pass = $currentUser['contra'];
            $this->tel = $currentUser['telefono'];
            
            if($this->tipo == 1) {
                $this->telefono = 0;
                $this->carrera = "NO";
                $this->matricula = 0;
            } elseif($this->tipo == 2) {
                $this->matricula = $currentUser['matricula'];
                $this->carrera = "NO";
            } elseif($this->tipo == 3) {
                $this->matricula = $currentUser['matricula'];
                $this->carrera = $currentUser['carrera'];
            }
        }
    }

    public function getIdUsu()
    {
        return $this->idUsu;
    }
    
    public function getNombre()
    {
        return $this->nombre;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function getSexo()
    {
        return $this->sexo;
    }

    public function getPass()
    {
        return $this->pass;
    }

    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Hacemos consulta SQL para obtener el tipo de usuario del usuario actual
     *
     * @return void
     */
    public function getTipo()
    {
        $query = $this->connect()->prepare('SELECT tipo FROM tipo_usuario INNER JOIN usuarios ON tipo_usuario.id_tipo = usuarios.id_tipo WHERE usuarios.username = :user');
        $query->execute(['user' => $this->username]);

        foreach($query as $currentUser) {
            return $currentUser['tipo'];
        }
    }

    public function getCarrera()
    {
        return $this->carrera;
    }

    public function getMatricula()
    {
        return $this->matricula;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }
//Ver si me deja usarla en el menu_admin y menu_auxiliar  .php
    public function administrador() {

        if(!isset($_SESSION['user'])){
            echo '<script>
                    window.location = "controlador.php";
                </script>';
        }   else {
            $user = new User();
            $tipo = $user->getTipo();
            if($tipo == "Administrador" || $tipo == "Auxiliar"){
                echo '<script>
                    window.location = "menu_admin.php";
                </script>'; 
            }else{
            }
        }
        }
    
    //Ver si jala en todos los menus de los administradores
    public function administrador2() {
        
        if(!isset($_SESSION['user']))
        {
            echo '<script>
                    window.location = "../controlador.php";
                </script>';
        } else if(isset($_SESSION['user'])) {
        
            if($tipo == "Administrador" || $tipo == "Auxiliar"){
                
            }else{
                echo '<script>
                    window.location = "../controlador.php";
                </script>';
            }
        }
    }
    
       
        
}

?>