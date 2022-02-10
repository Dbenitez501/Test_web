<?php
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
        <script src="../js/validarRegistroVirtual.js"></script>

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
                    <h2 style="color:#fff;">Nueva Conferencia Virtual</h2>
                    <hr>
                    <form class="registro-form" action="../include/registrarCVirtual.php" target="" method="POST" enctype="multipart/form-data" name="formRegConfVirtual" onsubmit="return validar();">

                        <div class="input-container">
                            <h3 for="titulo">Título</h3>
                            <input type="text" name="titulo" id="titulo" placeholder="..." required>
                        </div>
                        <div class="input-container input-txtarea-cont">
                            <h3 for="descripcion">Descripción</h3>
                            <textarea class="input-textarea" type="text" name="descripcion" id="descripcion" placeholder="Descripción" required></textarea>
                        </div>
                        <div class="input-container">
                            <h3 for="expositor">Expositor</h3>
                            <input type="text" name="expositor" id="expositor" placeholder="Nombre" required>
                        </div>
                        <div class="input-container">
                            <h3 for="fecha">Fecha</h3>
                            <input type="date" name="fecha" id="fecha" class="tcal" placeholder="año/mes/día (Seleccionar)" required>
                        </div>
                        <div class="input-container">
                            <h3 for="hora">Hora</h3>
                            <input type ="time" name="hora" id="hora">
                        </div>
                        <div class="input-container">
                            <h3 for="plataforma">Plataforma</h3>
                            <input type ="text" name="plataforma" id="plataforma" placeholder="(MsTeams,Zoom..)" required>
                        </div>
                        <div class="input-container">
                            <h3 for="codigo_plat">Código de Plataforma</h3>
                            <input type ="text" name="codigo_plat" id="codigo_plat" placeholder="" required>
                        </div>
                        <div class="input-container">
                            <h3 for="codigo_as">Código de asistencia</h3>
                            <input type ="text" name="codigo_as" id="codigo_as" required>
                        </div>
                        <div class="input-container">
                            <h3 for="cap_max">Capacidad Máxima </h3>
                            <input type ="number" name="cap_max" id="cap_max" placeholder="###" min="0" required>
                        </div>
                        <div class="input-container">
                            <h3 for="imagen">Imagen</h3>
                            <input type="file" class="form-img" id="imagen" name="imagen" multiple>
                        </div>


                        <div class="btn-container">
                            <input type="submit" name="registrar_conf_v"  value="Registrar" class="registro-btn">
                        </div>
                    </form>
                </div>
            </div>
            <div class="div_regresar">
                <a href="conferenciasV.php"><input type="submit" value="Regresar" class="boton_regresar"></a>
                </div>
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