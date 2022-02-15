<?php
include_once '../include/db.php';
include_once '../include/consultaAdmin.php';
include_once '../include/SED.php';
$db = new DB();
$cons = new ConsultaAdmin();
$consulta = $cons->consultarAdmin($_GET['id']);
//Desencriptamos primero la contraseña para mostrarla
$contraDes = SED::decryption($consulta[1]);

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
        <title>Administradores</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/estilos.css?v=<?php echo(rand()); ?>">
        <link rel="stylesheet" type="text/css" href="../css/tcal.css?v=<?php echo(rand()); ?>" />
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;600;700&display=swap" rel="stylesheet">

        <script src="https://kit.fontawesome.com/20e764b6ee.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="../js/tcal.js"></script>
        <script type="text/javascript" src="../js/validarAdmin.js"></script>

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
                    <h2 style="color:#fff;">Modificar Administrador</h2>
                    <hr>
                    <form class="registro-form" action="../include/modificarAdmin.php" target="" method="POST" name="formAdmin" onsubmit="return validar();">

                        <input type="hidden" name="id" id="id" value="<?php echo $_GET['id'];?>">

                        <div class="input-container">
                            <h3 for="nombre">Nombre:</h3>
                            <input type="text" name="nombre" id="nombre" value="<?php echo $consulta[2];?>"  placeholder="Nombre(s) y Apellido(s)" required pattern="^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$" title="Sólo se aceptan letras">
                        </div>
                        <div class="input-container">
                            <h3 for="email">Email:</h3>
                            <input type="email" name="email" id="email" value="<?php echo $consulta[3];?>" placeholder="ejemplo@gmail.com" required title="Correo invalido. Ejemplo: ejemplo@gmail.com">
                        </div>
                        <div class="input-container">
                            <h3 for="telefono">Teléfono:</h3>
                            <input type ="text" name="telefono" id="telefono" value="<?php echo $consulta[4];?>" placeholder="1234567890 (10 Digitos)" pattern="[0-9]{10}" required title="Sólo se aceptan dígitos (10 Dígitos necesarios)">
                        </div>
                        <div class="input-container">
                            <h3 for="sexo">Sexo:</h3>
                            <div class="radio-btn">
                                <input type="radio" name="sexo" value="H" id="sexo" <?php if($consulta[5] == "H") echo "checked"; ?>>
                                <label for="1">Masculino</label>		
                                <input type="radio" name="sexo" value="M" id="sexo" <?php if($consulta[5] == "M") echo "checked"; ?>>
                                <label for="0">Femenino</label>
                            </div>
                        </div>
                        <div class="input-container">
                            <h3 for="tipo">Tipo:</h3>
                            <div class="radio-btn">
                                <input type="radio" name="tipo" value=1 id="tipo" <?php if($consulta[6] == 1) echo "checked"; ?>>
                                <label for="1">Administrador</label>		
                                <input type="radio" name="tipo" value=5 id="tipo" <?php if($consulta[6] == 5) echo "checked"; ?>>
                                <label for="5">Auxiliar</label>
                            </div>
                        </div>
                        <div class="input-container">
                            <h3 for="username">Usuario:</h3>
                            <input type ="text" name="username" id="username" value="<?php echo $consulta[0];?>"  placeholder="Inicio de sesión (Mínimo 7 caracteres)" required minlength="7">
                        </div>
                        <div class="input-container">
                            <h3 for="contra">Contraseña:</h3>
                            <input type ="password" name="contra" id="contra" value="<?php echo $contraDes;?>" placeholder="******* (Mínimo 7 caracteres)" required minlength="7">
                        </div>                        

                        <div class="btn-container">
                            <input type="submit" name="enviar_admin"  value="Modificar" class="registro-btn">
                        </div>
                    </form>
                </div>
            </div>
            <div class="div_regresar">
                <a href="administradores.php"><input type="submit" value="Regresar" class="boton_regresar"></a>
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