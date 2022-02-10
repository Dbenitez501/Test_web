<?php
include_once '../include/db.php';
include_once '../include/presencial.php';
$db = new DB();
$pre = new Presencial();

//PARA ELIMINAR REGISTRO
if(isset($_GET['del'])) {
  $id_del = $_GET['del'];
  $queryDel = $db->connect()->prepare("DELETE FROM presencial WHERE id_presencial = :id_del");
  $queryDel->execute(['id_del'=>$id_del]);
  header("location: conferenciasP.php");
}


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

/*
    include_once '../include/user.php';
    $user = new User();
    $user -> administrador2();*/
}

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
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;600;700&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/20e764b6ee.js" crossorigin="anonymous"></script>
        <script src = " https://unpkg.com/sweetalert/dist/sweetalert.min.js "></script>

        <!-- searchPanes -->
        <link rel="stylesheet" href="https://cdn.datatables.net/searchpanes/1.3.0/css/searchPanes.dataTables.min.css">
        <!-- esta rompe la tabla xd -->    
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css"/> 
        
        <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/searchpanes/1.3.0/css/searchPanes.dataTables.css"/> -->
        <script type="text/javascript" src="../datatables/DataTables-1.10.18/js/jquery-3.3.1.js"></script>
        

        <!-- Bootstrap CSS-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <!--datables CSS básico-->
        <link rel="stylesheet" type="text/css" href="../datatables/datatables.min.css?v=<?php echo(rand()); ?>"/>
        <!--datables estilo bootstrap 4 CSS-->  
        <!-- <link rel="stylesheet"  type="text/css" href="../datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css?v=<?php echo(rand()); ?>"> -->


        <!--font awesome con CDN-->  
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css?v=<?php echo(rand()); ?>" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">

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

        <div class="tablas_seccion_conferencias">
                <h2>Conferencias presenciales</h2>           
                <div class="boton_nuevo_conferencia_p">
                <a href="nueva_conf_p.php"><input type="submit" value="Nuevo" class="boton_nuevo"></a>
                </div>
                <br>
                <div class="table-responsive">
                <table id="example" class="table_p_admin">
                    <thead>    
                        <tr>
                            <th>Id</th>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Expositor</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Lugar</th>
                            <th>Asistencia</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $query = $db->connect()->prepare("SELECT * FROM presencial");
                    $query->execute();

                    if($query->rowCount()) {
                        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
                        $id = $data['id_presencial'];
                        $estLugar = $pre->getEstadoTabla($id);
                    ?>
                    <tr> 
                        <td data-label="Id"><?php echo $id;?></td>
                        <td data-label="Título"><?php echo $data["titulo"];?></td>
                        <td data-label="Descripción"><?php echo $data["descripcion"];?></td>
                        <td data-label="Expositor"><?php echo $data["expositor"];?></td>
                        <td data-label="Fecha"><?php echo $data["fecha_inicio"];?></td>
                        <td data-label="Hora"><?php echo $data["hora_inicio"];?></td>
                        <td data-label="Lugar"><?php
                            if($estLugar == "Deshabilitado") {
                                echo "(" . $estLugar . ") " . $pre->getUbicacionTabla($id) . ", " . $pre->getNombreLugarTabla($id);
                            } else {
                                echo $pre->getUbicacionTabla($id) . ", " . $pre->getNombreLugarTabla($id);
                            }
                         ?></td>
                        <td data-label="Asistencia"><?php echo $data["codigo_asistencia"];?></td>
                        <td data-label="Estado"><?php echo $pre->getEstado($data['estado']);?></td>
                        <td data-label="Botones"><a href='mod_conf_p.php?id=<?php echo $id?>'><input type="submit" value="Modificar" class="boton_mod"></a>
                        <a href='#' onclick="preguntar(<?php echo $id?>)"><input type="submit" value="Eliminar" id="btnEliminar" class="boton_elim"></a></td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                    </tbody>         
                </table>               
                </div>
                <div class="div_regresar">
                <a href="menu_tipo.php"><input type="submit" value="Regresar" class="boton_regresar"></a>
                </div>  
        </div>

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

        <script type="text/javascript">
            //JAVASCRIPT PARA MOSTRAR Y OCULTAR EL MENU
            var navLinks = document.getElementById("navLinks");
            function mostrarMenu(){
                navLinks.style.right = "0";
            }
            function ocultarMenu(){
                navLinks.style.right = "-210px";
            }
            function preguntar(id) {
                swal({
                    title: "Confirmación",
                    text: "¿Seguro que quieres eliminar la conferencia?", 
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
                            window.location.href = "conferenciasP.php?del="+id;
                            break;
                        default:
                            swal("No se eliminó");
                    }
                });


                // if(confirm('¿Seguro que quieres eliminar?')) {
                // window.location.href = "conferenciasP.php?del="+id;
                // }
            }
        </script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        
        <!-- jQuery, Popper.js, Bootstrap JS -->
        <script src="../popper/popper.min.js"></script>
        <!-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> -->
        
        <!-- datatables JS -->
        <script type="text/javascript" src="../datatables/datatables.min.js"></script>
        
        <!-- para usar botones en datatables JS -->  
        <script src="../datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>  
        <script src="../datatables/JSZip-2.5.0/jszip.min.js"></script>    
        <script src="../datatables/pdfmake-0.1.36/pdfmake.min.js"></script>    
        <script src="../datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
        <script src="../datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>

        <!-- <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>  
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>    
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>    
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script> -->
        
        <!-- código JS propìo-->    
        <script type="text/javascript" src="../js/main.js"></script> 

        <!-- Para los estilos en Excel-->
        <script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.1.1/js/buttons.html5.styles.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.1.1/js/buttons.html5.styles.templates.min.js"></script>
        <!-- searchPanes   -->
        <script src="https://cdn.datatables.net/searchpanes/1.3.0/js/dataTables.searchPanes.min.js"></script>
        <!-- select -->
        <script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>  
        <!-- <script src="https://cdn.datatables.net/searchpanes/1.3.0/js/searchPanes.bootstrap4.min.js"></script> -->
    
    
    </body>
</html>