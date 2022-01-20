<?php
include_once 'include/user_session.php';
include_once 'include/user.php';
include_once 'include/db.php';
include_once 'include/SED.php';

$userSession = new UserSession();
$user = new User();
$db = new DB();

if(isset($_SESSION['user']))
{
    //"Hay sesión existente";
    $user->setUser($userSession->getCurrentUser());
    $tipo = $user->getTipo();
    if($tipo == "Administrador") {
        include_once 'menu_admin.php';
    } elseif($tipo == "Auxiliar"){
        include_once 'menu_auxiliar.php';
    } else {
        include_once 'index.php';
    }    

} elseif(isset($_POST['username']) && isset($_POST['password'])) {
    //"Si no hay sesión, pero hay valores en los campos de texto del inicio de sesión";
    //Obtenemos los valores de los campos con POST
    $userForm = $_POST['username'];
    $passForm = $_POST['password'];
    $passBD = $user->getPassCifrada($userForm);

    //Desencriptamos la contraseña de la bdd para compararla con la contraseña del form
    $passBdDes = SED::decryption($passBD);
    
    if(strcmp($passBdDes, $passForm) == 0) {
        if($user->userExists($userForm, $passBD))
        {
            //Si el usuario existe en la BD, entonces obtenemos sus datos";
            $userSession->setCurrentUser($userForm);
            $user->setUser($userForm);
            $tipo = $user->getTipo();
    
            if($tipo == "Administrador") {
                include_once 'menu_admin.php';
            } elseif($tipo == "Auxiliar"){
                include_once 'menu_auxiliar.php';
            } else {
                include_once 'index.php';
            }
    
        } else {
            //Nombre de usuario y/o contraseña incorrectos";
            $errorLogin = "Nombre de usuario y/o Contraseña incorrectos";
            include_once 'vistas/inicio_sesion.php';
        }
    } else {
        //Nombre de usuario y/o contraseña incorrectos";
        $errorLogin = "Nombre de usuario y/o Contraseña incorrectos";
        include_once 'vistas/inicio_sesion.php';
    }



} else {
    //"Login";
    include_once 'vistas/inicio_sesion.php';
}
?>