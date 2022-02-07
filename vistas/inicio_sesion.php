<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Inicio de sesión</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/estilos.css?v=<?php echo(rand()); ?>">
        <link rel="stylesheet" href="css/soluciones.css?v=<?php echo(rand()); ?>">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;600;700&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/20e764b6ee.js" crossorigin="anonymous"></script>
        <script src = " https://unpkg.com/sweetalert/dist/sweetalert.min.js "></script>

    </head>
    <body>

        <section class="sub-header">
            <nav>
                <a href="index.php" class="logo-header"><img src="img/logo_fime.png"></a>
                <div class="nav-links" id="navLinks">
                    <i class="fas fa-times" onclick="ocultarMenu()"></i>
                    <ul>
                        <li><a href="index.php">INICIO</a></li>
                        <li><a href="https://www.fime.uanl.mx/" target="_blank" rel="noopener noreferrer">FIME</a></li>
                        <li><a href="vistas/nosotros.php">ACERCA DE</a></li>
                    </ul>
                </div>
                <i class="fas fa-bars" onclick="mostrarMenu()"></i>
            </nav>
            <div class="text-box">
            <h1>CONFERENCIAS</h1>
            <p>Inscríbete para prepararte en las nuevas tendencias.</p>
            </div>
        </section>
        
        
        <section class="inicio-sesion">
            <div class="row row-sesion">
                <div class="sesion-col">
                    <?php
                    //Arroja un error si el usuario y/o contraseña están incorrectos
                    //variable $errorLogin se encuentra en el archivo controlador.php
                    if(isset($errorLogin)) {
                    echo '<script>
                    swal({
                        title: "Error",
                        text: "Nombre de usuario y/o Contraseña incorrectos", 
                        icon: "error",
                        button: "Ok",
                    }).then((value)  => {
                        window.history.go(-1);
                    });
                    </script>';
                    }
                    ?>
                    <h2 style="color:#fff;">Inicio de Sesión</h2>
                    <form action="" method="POST" class="sesion-form">
                        <div class="input-container">
                            <i class="fas fa-user icon"></i>
                            <input type="text" name="username" placeholder="Usuario">
                        </div>
                        <div class="input-container">
                            <i class="fas fa-key icon"></i>
                            <input type="password" name="password" placeholder="Contraseña">
                        </div>
                        <div class="input-container">
                            <input type="submit" value="Ingresar" class="sesion-btn">
                        </div>
                        <div class="input-container">
                            <h4>¿No tienes una cuenta? <a class="link" href="vistas/nuevo_usu.php">Regístrate</a></h4>
                        </div>
                        <br>
                        <div class="input-container">
                            <h4>¿Olvidaste la contraseña? <a class="link" href="vistas/recuperar_con.php">Recuperar</a></h4>
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
    </body>
</html>