<?php


include_once '../include/db.php';
include_once '../include/presencial.php';
include_once '../include/virtual.php';
include_once '../include/user.php';
include_once '../include/user_session.php';
include_once '../include/SED.php';

$db = new DB();
$presencial = new Presencial();
$virtual = new Virtual();
$userSession = new UserSession();
$user = new User();

$idUser;

if(isset($_SESSION['user'])) {
  $user->setUser($userSession->getCurrentUser());
  $idUser = $user->getIdUsu();
}
if(isset($_SESSION['user'])) {
    $user->setUser($userSession->getCurrentUser());
    $password = $user->getPass();
  }

$contraDes = SED::decryption($password);

    if(!isset($_SESSION['user']))
    {
    echo '<script>
            window.location = "../controlador.php";
        </script>';
    } else if(isset($_SESSION['user'])) {

    $user->setUser($userSession->getCurrentUser());
    $tipo = $user->getTipo();
    if($tipo == "Docente" || $tipo == "Estudiante" ||  $tipo == "Externo"){
        
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
        <title>Cuenta</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/estilos.css?v=<?php echo(rand()); ?>">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;600;700&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/20e764b6ee.js" crossorigin="anonymous"></script>
        <script src = " https://unpkg.com/sweetalert/dist/sweetalert.min.js "></script>
        

        <!-- Funcion que manda a llamar que los campos son obligatorios dentro del formulario -->
       <!--   <script type="text/javascript" src="../js/validaAlumno.js"></script>-->

        
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
                        <?php
                            if(isset($_SESSION['user'])) {
                            echo "<li><a href='tabla_asistencias.php'>MIS CONFERENCIAS</a></li>";
                            }
                        ?>
                        <?php
                            if(isset($_SESSION['user'])) {
                            echo "<li><a href='cuenta.php'>MI CUENTA</a></li>";
                            }
                        ?>
                        <li><a href="nosotros.php">ACERCA DE</a></li>
                        <?php
                            if(isset($_SESSION['user'])) {
                            echo "<li><a href='../include/logout.php'>CERRAR SESI??N</a></li>";
                            } 
                        ?>
                    </ul>
                </div>
                <i class="fas fa-bars" onclick="mostrarMenu()"></i>
            </nav>
            <div class="text-box">
            <h1>CUENTA</h1>
            </div>
            
        </section>

        <section class="registro-usuario">
            <div class="row row-registro">
                <div class="registro-col">
                    <h2 style="color:#fff;">Datos</h2>
                    <hr>
                    <!-- onsubmit="return validar2(); en el form en dado caso que se ocupe-->
                    <form class="registro-form" action="../include/modificarCuenta.php" target="" method="POST" name="formCuenta">
                        
                        <input type="hidden" name="id" id="id" value="<?php echo $idUser?>">
                        
                        <div class="input-container">
                            <h3 for="email">Tel??fono</h3>
                            <input type="text" name="telefono" id="telefono" placeholder="1234567890 (10 Digitos)" value="<?php echo $user->getTel();?>" pattern="[0-9]{10}" required title="S??lo se aceptan d??gitos (10 D??gitos necesarios)">
                        </div>
                        <div class="input-container">
                            <h3 for="contra">Contrase??a</h3>
                            <input type ="password" name="contra" id="contra" value="<?php echo $contraDes ?>" placeholder="******* (M??nimo 7 caracteres)" required minlength="7">
                        </div>  
                        <div class="input-container">
                            <h3 for="contra">Confirmar contrase??a</h3>
                            <input type ="password" name="contraconf" id="contraconf" value="" placeholder="******* (M??nimo 7 caracteres)" required minlength="7">
                        </div>  
                        <br>

                        <div class="btn-container">
                            <input type="submit" name="enviar_cuenta" value="Modificar" class="registro-btn">
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <footer>
            <div class="contact-info">
                <h5><span>| A</span>cerca de nosotros</h5>
                <p><i class="fas fa-map-marker-alt"></i>   Av. Universidad S/N, Ciudad Universitaria<br>San Nicol??s de los Garza, N. L., C.P. 66455</p>
                <br>
                <p><i class="fas fa-phone-alt"></i>    (52) 81 8329 4020</p>
                <br>
                <p><i class="fas fa-envelope"></i>    contacto@fime.uanl.mx</p>
                <br>
                <a href="https://www.uanl.mx/enlinea/" style="color: #fff;"><i class="fas fa-desktop"></i>   Servicios en l??nea</a>
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
