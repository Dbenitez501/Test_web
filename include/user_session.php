<?php

class UserSession
{
    /**
     * Constructor, cada que se mande a llamar, se iniciará una sesión
     */
    public function __construct()
    {
        session_start();
    }

    /**
     * Recibe un nombre de usuario y lo almacena en variable tipo SESSION
     *
     * @param [type] $user
     * @return void
     */
    public function setCurrentUser($user)
    {
        $_SESSION['user'] = $user;
    }

    public function getCurrentUser()
    {
        return $_SESSION['user'];
    }

    /**
     * Al cerrar sesión, se manda llamar este método
     *
     * @return void
     */
    public function closeSession()
    {
        session_unset();
        session_destroy();
    }
}

?>