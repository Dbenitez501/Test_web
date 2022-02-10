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

        <!--font awesome con CDN-->  
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css?v=<?php echo(rand()); ?>" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
        <script src="../jquery/jquery-3.3.1.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function(){                                

                $('#tipo').append('<option selected="" disabled="">Seleccione una opción</option>');
                $('#tipo').append('<option value="p">Presencial</option>');
                $('#tipo').append('<option value="v">Virtual</option>');
                
                
                $('#conf').append('<option selected="" disabled="">Seleccione una opción</option>');
                
                $("#tipo").change(function(){
                    var tipoId = $("#tipo").val();
                    $.ajax({
                        url: '../include/data_filtrado.php',
                        method: 'post',
                        data: 'tipoId=' + tipoId
                        
                    }).done(function(conferencias){
                       
                        console.log(conferencias);
                        conferencias = JSON.parse(conferencias);
                        $('#conf').empty();
                        
                        $('#conf').append('<option selected="" disabled="">Seleccione una opción</option>');
                        conferencias.forEach(function(conferencia){
                            const id = conferencia.id_presencial || conferencia.id_virtual;
                            $('#conf').append('<option id="opt" value=' + id + '>' + conferencia.titulo + ', ' + conferencia.fecha_inicio + '</option>')
                        })
                    })
                    
                });
                $('#btn').on('click', function(){
                    const tipo = $('#tipo').val();
                    let id;
                    if(tipo === "p") {
                        id = $('#conf').val();
                        if(tipo && id) {
                            window.location = 'tabla_filtrado_conferencias.php?idP=' + id;
                        } else {
                            swal({
                            title: "Completar datos",
                            text: "Favor de seleccionar una conferencia", 
                            icon: "warning",
                        });
                        }

                    } else {
                        id = $('#conf').val();
                        if(tipo && id) {
                            window.location = 'tabla_filtrado_conferencias.php?idV=' + id;
                        } else {
                            swal({
                            title: "Completar datos",
                            text: "Favor de seleccionar una conferencia", 
                            icon: "warning",
                        });
                        }
                    }
                });
            });
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
                    
                        <h2 style="color:#fff;">Filtrado por conferencias</h2>
                        <hr>
                        <div class="registro-form">
                            <div class="input-container">
                                <h3 for="tipo">Tipo</h3>
                                <select class="com-box" name="tipo" id="tipo">
                                    <!-- <option selected="" disabled="">Seleccione una opción</option> -->
                                </select>
                            </div>
                            <div class="input-container">
                                <h3 for="conf">Conferencia</h3>
                                <select class="com-box" name="conf" id="conf" onfocus='this.size=1;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
                                    <!-- <option selected="" disabled="">Seleccione una opción</option> -->
                                </select>
                            </div>
                        </div>
                            <div class="input-container">
                                <input type="submit" id="btn" value="Filtrar" class="sesion-btn">
                            </div>
                </div>
                </div>
                <div class="div_regresar">
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

    </body>
</html>