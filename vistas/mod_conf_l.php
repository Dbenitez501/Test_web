<?php
include_once '../include/db.php';
include_once '../include/consultaLugar.php';
$db = new DB();
$cons = new ConsultaLugar();

$consulta = $cons->consultarLugar($_GET['id']);
include_once '../include/user_session.php';
include_once '../include/user.php';

$userSession = new UserSession();
$user = new User();

    if(!isset($_SESSION['user']))
    {
    echo '<script>
            window.location = "../controlador.php";
        </script>';
    } else if(isset($_SESSION['user'])) {

    $user->setUser($userSession->getCurrentUser());
    $tipo = $user->getTipo();
    if($tipo == "Administrador" || $tipo == "Auxiliar"){
        
    }else{
        echo '<script>
            window.location = "../controlador.php";
        </script>';
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Conferencias</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/estilos.css?v=<?php echo(rand()); ?>">
        <link rel="stylesheet" type="text/css" href="../css/tcal.css?v=<?php echo(rand()); ?>" />
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;600;700&display=swap" rel="stylesheet">

        <script src="https://kit.fontawesome.com/20e764b6ee.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="../js/tcal.js"></script>
        <script type="text/javascript" src="../js/validarLugar.js"></script>

    </head>
    <body>

    <section class="sub-header">
            <nav>
                <a href="../controlador.php"><img src="../img/logo_fime.png"></a>
                <div class="nav-links" id="navLinks">
                    <i class="fas fa-times" onclick="ocultarMenu()"></i>
                    <ul>
                        <li><a href="../controlador.php">INICIO</a></li>
                        <li><a href="https://www.fime.uanl.mx/" target="_blank" rel="noopener noreferrer">FIME</a></li>
                        <li><a href='../include/logout.php'>CERRAR SESIÓN</a></li>
                    </ul>
                </div>
                <i class="fas fa-bars" onclick="mostrarMenu()"></i>
            </nav>
            <div class="text-box">
            <h1>Administración</h1>
            <p>Panel para administradores</p>
            </div>
            
        </section>

        <section class="registro-usuario">
            <div class="row row-registro">
                <div class="registro-col">
                    <h2 style="color:#fff;">Modificar Lugar</h2>
                    <hr>
                    <form class="registro-form" action="../include/modificarLugar.php" target="" method="POST" name="formRegLugar" onsubmit="return validar();">

                        <input type="hidden" name="id" id="id" value="<?php echo $_GET['id'];?>">

                        <div class="input-container">
                            <h3 for="nombre">Nombre:</h3>
                            <input type="text" name="nombre" id="nombre" value="<?php echo $consulta[0];?>" placeholder="....." required>
                        </div>
                        <div class="input-container">
                            <h3 for="ubicacion">Ubicación:</h3>
                            <input type="text" name="ubicacion" id="ubicacion" value="<?php echo $consulta[1];?>" placeholder="(Edificio 2,CIDET, etc..)" required>
                        </div>
                        <div class="input-container input-txtarea-cont">
                            <h3 for="desc">Descripción:</h3>
                            <textarea class="input-textarea" type="text" name="desc" id="desc" " placeholder="descripción" required><?php echo $consulta[3];?></textarea>
                        </div>
                        <div class="input-container">
                            <h3 for="cap_max">Capacidad Máxima:</h3>
                            <input type="number" name="cap_max" id="cap_max" value="<?php echo $consulta[2];?>" placeholder="###" required>
                        </div>
                        <div class="input-container">
                            <h3 for="estado">Estado:</h3>
                                <label for="Activado" class="l-radio">
                                    <input type="radio" name="estado" value="Habilitado" id="Activado" <?php if($consulta[4] == "Habilitado") echo "checked"; ?>>
                                    <span>Habilitado</span>
                                </label>

                                <label for="Desactivado" class="l-radio">
                                    <input type="radio" name="estado" value="Deshabilitado" id="Desactivado" <?php if($consulta[4] == "Deshabilitado") echo "checked"; ?>>
                                    <span>Deshabilitado</span>
                                </label>
                        </div>
                        

                        <div class="btn-container">
                            <input type="submit" name="modificarLugar"  value="Modificar" class="registro-btn">
                        </div>
                    </form>
                </div>
                
            </div>
            <div class="div_regresar">
                <a href="admin_lugares.php"><input type="submit" value="Regresar" class="boton_regresar"></a>
                </div>
        </section>

        <footer>
            <div class="contact-info">
                <h5><span>| A</span>cerca de nosotros</h5>
                <p><i class="fas fa-map-marker-alt"></i>   Av. Universidad S/N, Ciudad Universitaria<br>San Nicolás de los Garza, N. L., C.P. 66455</p>
                <br>
                <p><i class="fas fa-phone-alt"></i>    (52) 81 8329 4020</p>
                <br>
                <p><i class="fas fa-envelope"></i>    contacto@fime.uanl.mx</p>
                <br>
                <a href="https://www.uanl.mx/enlinea/" style="color: #fff;"><i class="fas fa-desktop"></i>   Servicios en línea</a>
            </div>
            <div class="icons">
                <h5><span>| R</span>edes Sociales</h5>
                <a href="https://www.facebook.com/fime.oficial/" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook"></i>Facebook</a>
                <a href="https://www.instagram.com/fime.oficial/?hl=es-la" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i>Instagram</a>
                <a href="https://twitter.com/fime_oficial?lang=es" target="_blank" rel="noopener noreferrer"><i class="fab fa-twitter"></i>Twitter</a>
                <a href="https://www.youtube.com/channel/UCfmQiSfgZ5cMDe-kAYplmww/featured" target="_blank" rel="noopener noreferrer"><i class="fab fa-youtube"></i>Youtube</a>
            </div>
            <div class="logo-area"><img src="../img/Logos.png" alt=""></div>
        </footer>

        <script>
            //JAVASCRIPT PARA MOSTRAR Y OCULTAR EL MENU
            var navLinks = document.getElementById("navLinks");
            function mostrarMenu(){
                navLinks.style.right = "0";
            }
            function ocultarMenu(){
                navLinks.style.right = "-210px";
            }
        </script>

    </body>
</html>