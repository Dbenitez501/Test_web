<?php
include_once 'include/db.php';
include_once 'include/presencial.php';
include_once 'include/virtual.php';
include_once 'include/SED.php';
$db = new DB();
$presencial = new Presencial();
$virtual = new Virtual();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Inicio</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/estilos.css?v=<?php echo(rand()); ?>">  
        <script src = " https://unpkg.com/sweetalert/dist/sweetalert.min.js "></script> 
        <script src="https://kit.fontawesome.com/20e764b6ee.js" crossorigin="anonymous"></script>
        <!-- Bootstrap CSS-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
    <body>

        <section class="header">
            <nav>
                <a href="index.php"><img src="img/logo_fime.png"></a>
                <div class="nav-links" id="navLinks">
                    <i class="fas fa-times" onclick="ocultarMenu()"></i>
                    <ul>
                            <?php
                            if(!isset($_SESSION['user'])) {
                            echo "<li><a href='controlador.php'> INICIO DE SESIÓN </a></li>";
                            }
                            ?>
                            <?php
                                if(!isset($_SESSION['user'])) {
                                echo "<li><a href='index.php'> INICIO </a></li>";
                                } elseif(isset($_SESSION['user'])) {
                                echo "<li><a href='controlador.php'> INICIO </a></li>";
                                }
                            ?>
                        <li>
                            <a href="https://www.fime.uanl.mx/" target="_blank" rel="noopener noreferrer">FIME</a>
                        </li>
                            <?php
                                if(isset($_SESSION['user'])) {
                                echo "<li><a href='vistas/tabla_asistencias.php'>MIS CONFERENCIAS</a></li>";
                                }
                            ?>
                         <?php
                                if(isset($_SESSION['user'])) {
                                echo "<li><a href='vistas/cuenta.php'>MI CUENTA</a></li>";
                                }
                            ?>
                        <li>
                            <a href="vistas/nosotros.php">ACERCA DE</a>
                        </li>
                            <?php
                                if(isset($_SESSION['user'])) {
                                echo "<li><a href='include/logout.php'>CERRAR SESIÓN</a></li>";
                                }
                            ?>
                    </ul>
                </div>
                <i class="fas fa-bars" onclick="mostrarMenu()"></i>
            </nav>

            <div class="text-box">
                <h1>CONFERENCIAS</h1>
                <p>Inscríbete para prepararte en las nuevas tendencias.</p>
                <a href="vistas/nosotros.php" class="header-btn">Acerca de nosotros</a>
            </div>
        </section>
        
        
        <section class="soluciones">
            <h1>Bienvenido/a<h2><?php
                if(isset($_SESSION['user'])) {
                echo $user->getNombre();
                echo "<br>";
                echo "<u><i>" . $user->getTipo() . "</i></u>";
                } else {
                echo "";
                }
                ?></h2>
            </h1>
            <h3 class="sol-p">
                Estas son las conferencias disponibles
            </h3>
            <br>    
            <!-- Contenedor de lar tarjetas -->
            <div class="row container-card">
                <!--CODIGO PARA GENERAR LAS CONFERENCIAS DISPONIBLES-->
                <?php
                    $queryVirtual = $db->connect()->prepare('SELECT * FROM virtual WHERE estado=1');
                    $queryVirtual->execute();

                    $queryPresencial = $db->connect()->prepare('SELECT *FROM presencial WHERE estado=1');
                    $queryPresencial->execute();
                    
                    if($queryVirtual->rowCount()) {
                    while ($dataV = $queryVirtual->fetch(PDO::FETCH_ASSOC)) {
                        $idV = $dataV["id_virtual"]; 
                ?>
                <!-- Tarjeta Virual -->
                <div class="prod-col">                   
                    <h2><?php echo $dataV["titulo"]; ?> <br>
                        <span><?php echo "(" . $dataV["tipo"] . ")";?></span>
                    </h2>
                    <img src="img/expositor_img/<?php echo $dataV['imagen'] ?>">
                    <p>
                        <b>Fecha:</b> <?php echo $dataV["fecha_inicio"]; ?><br><br>
                        <b>Hora:</b> <?php echo $dataV["hora_inicio"]; ?><br><br>
                        <b>Plataforma:</b> <?php echo $virtual->getPlataforma($idV);?><br><br>
                    </p>
                    <button type="button" class="header-btn prod-btn" data-toggle="modal" 
                    data-target="#virtual<?php echo $idV?>">
                    Mas Información </button>
                    <!-- <a href="controlador_inscribirV.php?id=<?php echo $idV?>"><input type="submit" value="Inscribir" class="header-btn prod-btn"></a> -->
                </div>
                <?php  include('Modal_Virtual.php'); ?>
                <?php
                        }
                    } 
                    if($queryPresencial->rowCount()) {
                    while($dataP = $queryPresencial->fetch(PDO::FETCH_ASSOC)) {
                        $idP = $dataP['id_presencial'];
                ?>
                <!-- Tarjeta Precencial -->
                <div class="prod-col">                    
                    <h2><?php echo $dataP["titulo"]; ?> <br>
                        <span><?php echo "(" . $dataP["tipo"] . ")";?></span>
                    </h2>
                    <img src="img/expositor_img/<?php echo $dataP['imagen'] ?>">
                    <p>
                        <b>Fecha:</b> <?php echo $dataP["fecha_inicio"]; ?><br><br>
                        <b>Hora:</b> <?php echo $dataP["hora_inicio"]; ?><br><br>
                        <b>Lugar:</b> <?php echo $presencial->getNombreLugarTabla($idP) . ", " .  $presencial->getUbicacionTabla($idP);?><br><br>
                    </p>
                    <button type="button" class="header-btn prod-btn" data-toggle="modal" 
                    data-target="#presencial<?php echo $idP?>">
                    Mas Información </button>
                    <!-- <a href="controlador_inscribirP.php?id=<?php echo $idP?>"><input type="submit" value="Inscribir" class="header-btn prod-btn"></a> -->
                </div>
                <?php  include('Modal_Presencial.php'); ?>
                <?php
                        }
                    }  
                ?>               
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
            <div class="logo-area"><img src="img/Logos.png" alt=""></div>
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

        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</html>