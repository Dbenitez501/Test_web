<?php
include_once '../include/db.php';
$db = new DB();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Administración</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/estilos.css?v=<?php echo(rand()); ?>">
        <link rel="stylesheet" href="../css/soluciones.css?v=<?php echo(rand()); ?>">
        <link rel="stylesheet" type="text/css" href="../css/tcal.css?v=<?php echo(rand()); ?>" />
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;600;700&display=swap" rel="stylesheet">

        <script src="https://kit.fontawesome.com/20e764b6ee.js" crossorigin="anonymous"></script>
        <script src = " https://unpkg.com/sweetalert/dist/sweetalert.min.js "></script>
        <script type="text/javascript" src="../js/tcal.js"></script>
        <script src="../jquery/jquery-3.3.1.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                $('#btn').on('click', function(){
                    const fecha_inicial = $('#fecha_inicial').val();
                    const fecha_final = $('#fecha_final').val();
                    console.log(fecha_inicial, fecha_final);

                    if(fecha_inicial && fecha_final) {
                        //Implementar alerta en caso de estar vacío
                        window.location = 'tabla_filtrado_fechas.php?fecha_in=' + fecha_inicial + '&fecha_fin=' + fecha_final;                        
                    } else {
                        swal({
                            title: "Completar datos",
                            text: "Favor de seleccionar ambas fechas", 
                            icon: "warning",
                        });
                        //window.location = 'filtrado_fecha.php';
                    }
                })
            })
        </script>

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
                        <h2 style="color:#fff;">Filtrado por Fechas</h2>
                        <hr>
                        <div class="registro-form">
                        <div class="input-container">
                            <h3 for="fecha">Fecha Inicial</h3>
                            <input type="date" name="fecha" id="fecha_inicial" required>
                        </div>
                        <div class="input-container">
                            <h3 for="fecha">Fecha Final</h3>
                            <input type="date" name="fecha" id="fecha_final"required>
                        </div>
                        </div>
                            <div class="input-container">
                                <input type="submit" id="btn" value="Filtrar" class="sesion-btn">
                            </div>
                </div>
              
            </div>
            </div>
                <div class="boton_nuevo_conferencia_p">
                <a href="menu_filtrado.php"><input type="submit" value="Regresar" class="boton_regresar"></a>
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