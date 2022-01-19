<?php
include_once '../include/db.php';
include_once '../include/presencial.php';
include_once '../include/virtual.php';

$db = new DB();
$pre = new Presencial();
$virtual = new Virtual();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Asistencia</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/estilos.css?v=<?php echo(rand()); ?>">
        <link rel="stylesheet" href="../css/soluciones.css?v=<?php echo(rand()); ?>">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;600;700&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/20e764b6ee.js" crossorigin="anonymous"></script>

        <script type="text/javascript" src="../js/tcal.js"></script>
        <script src="../js/validarCodAsistencia.js"></script>
        <script src = " https://unpkg.com/sweetalert/dist/sweetalert.min.js "></script>

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
                        <li><a href='tabla_asistencias.php'>MIS CONFERENCIAS</a></li>
                        <li><a href="nosotros.php">ACERCA DE</a></li>
                        <li><a href='../include/logout.php'>CERRAR SESIÓN</a></li>
                    </ul>
                </div>
                <i class="fas fa-bars" onclick="mostrarMenu()"></i>
            </nav>
            <h1>ASISTENCIA</h1>
            
        </section>

        <section class="registro-usuario">
            <div class="row row-registro">
                <div class="registro-col">                    
                    <form class="registro-form" action="<?php
                    if(isset($_GET['idRegP'])) {
                        echo '../include/verificaCodPre.php';
                    } elseif (isset($_GET['idRegV'])) {
                        echo '../include/verificaCodVirtual.php';
                    }
                    ?>" target="" method="POST" name="regAsistencia" onsubmit="return validar();">

                        <h2 style="color:#fff;">Asistencia<br> <h3><?php
                        if(isset($_GET['idRegP'])) {
                            $id = $_GET['idRegP'];
                            echo $pre->getTituloConf($id);
                        } elseif (isset($_GET['idRegV'])) {
                            $id = $_GET['idRegV'];
                            echo $virtual->getTituloConf($id);
                        }
                        ?></h3></h2>
                        <h4>Fecha: <?php
                        if(isset($_GET['idRegP'])) {
                            $id = $_GET['idRegP'];
                            echo $pre->getFechaConf($id);
                        } elseif (isset($_GET['idRegV'])) {
                            $id = $_GET['idRegV'];
                            echo $virtual->getFechaConf($id);
                        }
                        ?></h4>
                        <h4>Hora: <?php
                        if(isset($_GET['idRegP'])) {
                            $id = $_GET['idRegP'];
                            echo $pre->getHoraConf($id);
                        } elseif (isset($_GET['idRegV'])) {
                            $id = $_GET['idRegV'];
                            echo $virtual->getHoraConf($id);
                        }
                        ?></h4>

                        <hr>
                        <input type="hidden" name="id" id="id" value="<?php
                        if(isset($_GET['idRegP'])) {
                            $id = $_GET['idRegP'];
                            echo $id;
                        } elseif (isset($_GET['idRegV'])) {
                            $id = $_GET['idRegV'];
                            echo $id;
                        }
                        ?>">

                        <div class="input-container">
                            <h3 for="code">Código de asistencia:</h3>
                            <input type="text" name="codigo" id="codigo" placeholder="......">
                        </div>
                        <div class="input-container input-txtarea-cont">
                            <h3 for="comentario">Comentario:</h3>
                            <textarea class="input-textarea" type="textarea" name="comentario" id="comentario" placeholder=""></textarea>
                        </div>
                        <br>
                        <div class="btn-container">
                        <input type="submit" name="guardar_asistencia"  value="Guardar" class="registro-btn">
                        </div>
                    </form>
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