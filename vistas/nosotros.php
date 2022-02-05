<?php
include_once '../include/db.php';
include_once '../include/presencial.php';
include_once '../include/virtual.php';
include_once '../include/user.php';
include_once '../include/user_session.php';
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
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Acerca de</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/estilos.css?v=<?php echo(rand()); ?>">
        <link rel="stylesheet" href="../css/soluciones.css?v=<?php echo(rand()); ?>">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;600;700&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/20e764b6ee.js" crossorigin="anonymous"></script>

    </head>
    <body>

        <section class="sub-header">
            <nav>
                <a href="../index.php"><img src="../img/logo_fime.png"></a>
                <div class="nav-links" id="navLinks">
                    <i class="fas fa-times" onclick="ocultarMenu()"></i>
                    <ul>
                            <?php
                                if(!isset($_SESSION['user'])) {
                                echo "<li><a href='../controlador.php'> INICIO DE SESIÓN </a></li>";
                                }
                            ?>
                            <?php
                                if(!isset($_SESSION['user'])) {
                                echo "<li><a href='../index.php'> INICIO </a></li>";
                                } elseif(isset($_SESSION['user'])) {
                                echo "<li><a href='../controlador.php'> INICIO </a></li>";
                                }
                            ?>
                        <li>
                            <a href="https://www.fime.uanl.mx/" target="_blank" rel="noopener noreferrer">FIME</a>
                        </li>
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
                        <li>
                            <a href="nosotros.php">ACERCA DE</a>
                        </li>
                            <?php
                                if(isset($_SESSION['user'])) {
                                echo "<li><a href='../include/logout.php'>CERRAR SESIÓN</a></li>";
                                }
                            ?>
                    </ul>
                </div>
                <i class="fas fa-bars" onclick="mostrarMenu()"></i>
            </nav>
            <div class="text-box">
            <h1>Acerca de La FIME</h1>
            </div>
            
        </section>

        <section class="sobre-cct">
            <div class="row">
                <div class="sobre-col">
                    <img src="../img/fime1.jpg" alt="">
                </div>                
                <div class="sobre-col">
                    <h1>La FIME</h1>
                    <p>
                        La Facultad de Ingeniería Mecánica y Eléctrica (FIME), es una Institución educativa de nivel superior y pertenece a la Universidad Autónoma de Nuevo León.
                        <br><br>

                        Nuestras 11 carreras a nivel Licenciatura, 25 programas de Posgrado y más de 120 cursos de Educación Continua que satisfacen los requerimientos y necesidades del estudiante y de la industria. La FIME cuenta con una planta aproximada de más de 660 maestros, de los cuales, algunos cuentan con perfil PRODEP, otros pertenecen al SNI (Sistema Nacional de Investigadores), varios de ellos con reconocimientos, premios y certificaciones en diferentes áreas.
                        <br><br>

                        Para una atención efectiva, Nuestra Facultad cuenta con una importante infraestructura consistente en aulas climatizadas, extensos laboratorios, salas de cómputo, oficinas, salas de tutorías, estacionamientos, canchas deportivas, etc. y que le dan al estudiante toda una oportunidad de desarrollo tanto académico, social, cultural y deportivo.
                        <br><br>

                        Conscientes de la competencia internacional, actualmente la FIME se encuentra certificada bajo la norma ISO 9001:2015, y cuenta con 11 programas de Licenciatura acreditados por CACEI y en Nivel 1 de CIEES, así como 11 programas de Posgrado en el PNPC.
                        <br><br>

                        El intercambio académico con otras instituciones educativas internacionales es una actividad de gran importancia y que la FIME viene realizando tanto con sus estudiantes como con sus docentes.
                    </p>
                </div>                                
            </div>

            <div class="h-line"></div>

            <div class="row">
                <div class="sobre-col">
                    <h1>Coordinación de Servicio Social y Empresarial</h1>
                    <p><i class="fas fa-phone-alt"></i>83294020, Ext. 5970</p>
                    <p><i class="fas fa-envelope"></i>bolsa.fime@uanl.mx</p>
                    <p><a href="https://www.facebook.com/bolsadetrabajo.defime" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook"></i>Bolsa De Trabajo y Seguimiento de Egresados FIME</a></p>
                </div>
                <div class="sobre-col">
                    <h1>Desarrolladores de la página</h1>
                    <p><strong>Back-end: </strong> Diego Benítez Reyna</p>
                    <p><i class="fas fa-envelope"></i>diegobenitez@live.com.mx</p>
                    <p><strong>Front-end:</strong> Abiam Alberto Escobedo Ruíz</p>
                    <p><i class="fas fa-envelope"></i>abiamalberto.19@gmail.com</p>
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