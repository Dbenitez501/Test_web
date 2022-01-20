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

//PARA ELIMINAR REGISTRO
if(isset($_GET['delV'])) {
  $id_del = $_GET['delV'];

  $procedure = $db->connect()->prepare('CALL restar_capacidad_virtual(?)');
  $procedure->bindParam(1, $id_del, PDO::PARAM_INT);
  $procedure->execute();

  $queryDel = $db->connect()->prepare("DELETE FROM registros WHERE id_registro = :id_del");
  $queryDel->execute(['id_del'=>$id_del]);
  header("location: tabla_asistencias.php");
}

if(isset($_GET['delP'])) {
  $id_del = $_GET['delP'];

  $procedure = $db->connect()->prepare('CALL restar_capacidad_presencial(?)');
  $procedure->bindParam(1, $id_del, PDO::PARAM_INT);
  $procedure->execute();

  $queryDel = $db->connect()->prepare("DELETE FROM registros WHERE id_registro = :id_del");
  $queryDel->execute(['id_del'=>$id_del]);
  header("location: tabla_asistencias.php");
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
        <link rel="stylesheet" href="../css/soluciones.css?v=<?php echo(rand()); ?>">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;600;700&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/20e764b6ee.js" crossorigin="anonymous"></script>
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
                            echo "<li><a href='../include/logout.php'>CERRAR SESIÓN</a></li>";
                            } 
                        ?>
                    </ul>
                </div>
                <i class="fas fa-bars" onclick="mostrarMenu()"></i>
            </nav>
            <h1>CONFERENCIAS</h1>
            <p>Inscríbete para prepararte en las nuevas tendencias.</p>
            
        </section>

        <div class="tablas_seccion">
        <section class="inicio-sesion">
            <h2>Conferencias presenciales</h2>

            <?php
            $consultaP="SELECT registros.id_registro, registros.asistencia, presencial.titulo, presencial.descripcion, presencial.fecha_inicio, presencial.hora_inicio, lugar_expo.nombre, lugar_expo.ubicacion FROM 
            registros INNER JOIN presencial ON registros.id_presencial=presencial.id_presencial INNER JOIN lugar_expo ON presencial.id_lugar=lugar_expo.id_lugar WHERE registros.id_usuario=:user";
            $queryP = $db->connect()->prepare($consultaP);
            $queryP->execute(['user' => $idUser]);
            if(!$queryP->rowCount()){
                echo '<h3 class="h2-misconfe">No hay conferencias presenciales registradas</h3><br><br>';
            } else {
            ?>

            <table class="table">
            <thead>    
            <tr>
                <th>Título</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Lugar</th>
                <th>Asistencia</th>
            </tr>
            </thead>
            <?php        
            while ($dataP = $queryP->fetch(PDO::FETCH_ASSOC)) {
                $idRegP = $dataP['id_registro'];
                $asistenciaP = $dataP['asistencia'];
            ?>
            <tr> 
                <td data-label="Título"><?php echo $dataP['titulo'];?></td>
                <td data-label="Fecha"><?php echo $dataP['fecha_inicio'];?></td>
                <td data-label="Hora"><?php echo $dataP['hora_inicio'];?></td>
                <td data-label="Lugar"><?php echo $dataP['nombre'] . ", " . $dataP['ubicacion'];?></td>
                <?php
                if(!$asistenciaP) {
                ?>
                    <td data-label="Asistencia" align='center'><a href='asistencia.php?idRegP= <?php echo $idRegP;?>'><input type='submit' value='Asistencia' class='boton_mod'></a><a href='#' onclick='preguntarP(<?php echo $idRegP;?>)'><input type='submit' value='Eliminar' id='btnEliminar' class='boton_elim'></a></td>
                <?php
                } else {
                ?>
                    <td data-label="Asistencia">Asistió</td>
                <?php
                }
                ?>
            </tr>
            <?php
                }
            }
            ?>             
            </table>

            <h2>Conferencias virtuales</h2>

            <?php
            $consultaV = "SELECT registros.id_registro, registros.asistencia, virtual.titulo, virtual.descripcion,virtual.fecha_inicio,virtual.hora_inicio,virtual.plataforma,virtual.codigo_plat 
            FROM registros INNER JOIN virtual ON registros.id_virtual= virtual.id_virtual WHERE registros.id_usuario=:user";

            $queryV = $db->connect()->prepare($consultaV);
            $queryV->execute(['user'=>$idUser]);
            if(!$queryV->rowCount()){
                echo '<h3 class="h2-misconfe">No hay conferencias virtuales registradas</h3><br><br>';
            } else {
            ?>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Plataforma</th>
                        <th>Código de Acceso</th>
                        <th>Asistencia</th>
                    </tr>
                </thead>
                    <?php    
                        while ($dataV = $queryV->fetch(PDO::FETCH_ASSOC)) {
                        $idRegV = $dataV['id_registro'];
                        $asistenciaV = $dataV['asistencia'];
                    ?>
                <tr>
                    <td data-label="Título"><?php echo $dataV['titulo'];?></td>
                    <td data-label="Fecha"><?php echo $dataV['fecha_inicio'];?></td>
                    <td data-label="Hora"><?php echo $dataV['hora_inicio'];?></td>
                    <td data-label="Plataforma"> <?php echo $dataV['plataforma'];?></td>
                    <td data-label="Código de Acceso"><?php echo $dataV['codigo_plat'];?></td>                
                    <?php
                    if(!$asistenciaV) {
                    ?>
                        <td data-label="Asistencia" align='center'><a href='asistencia.php?idRegV= <?php echo $idRegV;?>'><input type='submit' value='Asistencia' class='boton_mod'></a><a href='#' onclick='preguntarV(<?php echo $idRegV;?>)'><input type='submit' value='Eliminar' id='btnEliminar' class='boton_elim'></a></td>
                    <?php
                    } else {
                    ?>
                        <td data-label="Asistencia">Asistió</td>
                    <?php
                    }
                    ?>
                </tr>
                <?php
                    }
                }
                ?>
                </table>
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

            function preguntarP(id) {
                swal({
                    title: "Confirmación",
                    text: "¿Seguro que quieres desinscribirte?", 
                    icon: "warning",
                    dangerMode: true,
                    buttons: {
                        cancel: {
                            text: "Cancelar",
                            value: "no",
                            visible: true,
                        },
                        confirm: {
                            text: "Eliminar",
                            value: id,
                        }
                    },
                }).then((value)  => {
                    switch (value) {
                        case "no":
                            swal.close();
                            break;
                        case id:
                            window.location.href = "tabla_asistencias.php?delP="+id;
                            break;
                        default:
                            swal("No se desinscribió");
                    }
                });

                // if(confirm('¿Seguro que quieres eliminar?')) {
                // window.location.href = "tabla_asistencias.php?delP="+id;
                // }
            }

            function preguntarV(id) {
                swal({
                    title: "Confirmación",
                    text: "¿Seguro que quieres desinscribirte?", 
                    icon: "warning",
                    dangerMode: true,
                    buttons: {
                        cancel: {
                            text: "Cancelar",
                            value: "no",
                            visible: true,
                        },
                        confirm: {
                            text: "Eliminar",
                            value: id,
                        }
                    },
                }).then((value)  => {
                    switch (value) {
                        case "no":
                            swal.close();
                            break;
                        case id:
                            window.location.href = "tabla_asistencias.php?delV="+id;
                            break;
                        default:
                            swal("No se desinscribió");
                    }
                });


                // if(confirm('¿Seguro que quieres eliminar?')) {
                // window.location.href = "tabla_asistencias.php?delV="+id;
                // }
            }
        </script>

    </body>
</html>