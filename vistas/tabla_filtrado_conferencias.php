<?php
include_once '../include/db.php';
include_once '../include/presencial.php';
include_once '../include/virtual.php';
$db = new DB();
$pre = new Presencial();
$virtual = new Virtual();
$titulo;
$queryTitulo;

if(isset($_GET["idP"])){
    $queryTitulo = $db->connect()->prepare("SELECT titulo FROM presencial WHERE id_presencial =:id");
    $queryTitulo->execute(['id'=>$_GET["idP"]]);
    if($queryTitulo->rowCount()) {
        while ($data = $queryTitulo->fetch(PDO::FETCH_ASSOC)) {
            $titulo = $data["titulo"];
        }
    }
} elseif(isset($_GET["idV"])){
    $queryTitulo = $db->connect()->prepare("SELECT titulo FROM virtual WHERE id_virtual =:id");
    $queryTitulo->execute(['id'=>$_GET["idV"]]);
    if($queryTitulo->rowCount()) {
        while ($data = $queryTitulo->fetch(PDO::FETCH_ASSOC)) {
            $titulo = $data["titulo"];
        }
    }
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
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $titulo?></title>
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
        <!--datables CSS b??sico-->
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
                        <li><a href='../include/logout.php'>CERRAR SESI??N</a></li>
                    </ul>
                </div>
                <i class="fas fa-bars" onclick="mostrarMenu()"></i>
            </nav>
            <div class="text-box">
            <h1>Administraci??n</h1>
            <p>Panel para administradores</p>
            </div>
            
        </section>

        <div class="tablas_seccion_conferencias">
                <h2>Conferencia: <i><?php echo $titulo?></i></h2>
                <br>
                <div class="table-responsive">
                <table id="example5" class="table_p_admin" >
                    <thead>    
                        <tr>
                            <th>Nombre</th>
                            <th>Matricula</th>
                            <th>Carrera</th>
                            <th>Correo</th>
                            <th>Pa??s</th>
                            <th>Tel??fono</th>
                            <th>Tipo</th>
                            <th>Genero</th>
                            <th>Asistencia</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $query;
                    if(isset($_GET["idP"])) {
                        $query = $db->connect()->prepare("SELECT usuarios.nombre, usuarios.matricula, usuarios.carrera, usuarios.correo, usuarios.pais, usuarios.telefono, tipo_usuario.tipo, usuarios.sexo, registros.asistencia 
                        FROM registros JOIN usuarios on registros.id_usuario = usuarios.id_usuario JOIN tipo_usuario ON usuarios.id_tipo = 
                        tipo_usuario.id_tipo WHERE registros.id_presencial =:id");

                        $query->execute(['id'=> $_GET["idP"]]);

                    } elseif(isset($_GET["idV"])) {
                        $query = $db->connect()->prepare("SELECT usuarios.nombre, usuarios.matricula, usuarios.carrera, usuarios.correo, usuarios.pais, usuarios.telefono, tipo_usuario.tipo, usuarios.sexo, registros.asistencia 
                        FROM registros JOIN usuarios on registros.id_usuario = usuarios.id_usuario JOIN tipo_usuario ON usuarios.id_tipo = 
                        tipo_usuario.id_tipo WHERE registros.id_virtual =:id");

                        $query->execute(['id'=> $_GET["idV"]]);
                    }                    

                    if($query->rowCount()) {
                        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {                       
                    ?>
                    <tr> 
                        <td data-label="Nombre"><?php echo $data["nombre"];?></td>
                        <td data-label="Matricula"><?php echo $data["matricula"];?></td>
                        <td data-label="Carrera"><?php echo $data["carrera"];?></td>
                        <td data-label="Correo"><?php echo $data["correo"];?></td>
                        <td data-label="Pais"><?php echo $data["pais"];?></td>
                        <td data-label="Telefono"><?php echo $data["telefono"];?></td>
                        <td data-label="Tipo"><?php echo $data["tipo"];?></td>
                        <td data-label="Sexo"><?php echo $data["sexo"];?></td>
                        <td data-label="Asistencia">
                        <?php 
                            if($data["asistencia"] == 1) {
                                echo "Asistencia";
                            } else {
                                echo "Falta";
                            }
                         ?></td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                    </tbody>         
                </table>               
                </div>
                <!-- Btn para regresar -->
                <div class="div_regresar">
                
                <a href="
                <?php 
                /*Si cuenta con un valor de href (que proviene de filtrado_conferencias.php) 
                entonces lo direccionara a filtrado_conferencias.php */
                if(isset($_GET["href"])){
                    echo $_GET["href"];
                }else{
                /*De no contar con href, entonces quiere decir que probiene de tabla_filtrado_fechas.php, por lo que
                se crea una variable llamada $url la cual va a incluir la url de la tabla_filtrado_fechas.php
                Se tuvo que concatenar href_fechas mas aparte &fecha_fin=".$_GET["fecha_fin"] ya que href_fecha no contiene todo
                lo necesario para la url*/
                $url = $_GET["href_fecha"]."&fecha_fin=".$_GET["fecha_fin"];
                echo $url;
                }
                ?>
                "><input type="submit" value="Regresar" class="boton_regresar"></a>
                </div>
                
                </div>
        </div>

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
                    title: "Confirmaci??n",
                    text: "??Seguro que quieres eliminar la conferencia?", 
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
                            swal("No se elimin??");
                    }
                });


                // if(confirm('??Seguro que quieres eliminar?')) {
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
        
        <!-- c??digo JS prop??o-->    
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