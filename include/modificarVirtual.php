<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conferencias</title>
    <link rel="stylesheet" href="../css/estilos.css?v=<?php echo(rand()); ?>">
    <link rel="stylesheet" href="../css/soluciones.css?v=<?php echo(rand()); ?>">
    <script src = " https://unpkg.com/sweetalert/dist/sweetalert.min.js "></script>
</head>
<body>

    <script>
        function alertaCorrecto(msg){
            swal({
                title: "Éxito",
                text: msg, 
                icon: "success",
                button: "Ok",
            }).then((value)  => {
                window.location = "../vistas/conferenciasV.php";
            });
        }

        function alertaFalla(msg, tipo){
            swal({
                title: "Error",
                text: msg, 
                icon: tipo,
                button: "Ok",
            }).then((value)  => {
                window.history.go(-1);
            });
        }
    </script>

    <?php
    include_once '../include/consultaVirtual.php';
    $cons = new ConsultaVir();
    $consulta = $cons->consultarVir($_POST['id']);

    // IMAGEN
    $img_file = $_FILES['imagen']['name'];
    $tmp_dir = $_FILES['imagen']['tmp_name'];
    $img_size = $_FILES['imagen']['size'];

    // $upload_dir = '../img/expositor_img/'; // upload directory
    // $img_ext = strtolower(pathinfo($img_file, PATHINFO_EXTENSION)); // obtener la extension de la imagen
    // $valid_ext = array('jpeg', 'jpg', 'png'); // extensiones validas

    $userpic;

    if($img_file) {
        $upload_dir = '../img/expositor_img/'; // upload directory
        $img_ext = strtolower(pathinfo($img_file, PATHINFO_EXTENSION)); // obtener la extension de la imagen
        $valid_ext = array('jpeg', 'jpg', 'png'); // extensiones validas
        $userpic = rand(1000,1000000).".".$img_ext;

        if(in_array($img_ext, $valid_ext)) {
            //checar tamaño del archivo 5MB
            if($img_size < 5000000) {
                unlink($upload_dir.$consulta[10]);
                move_uploaded_file($tmp_dir, $upload_dir.$userpic);

                modificarVir($_POST['id'], $_POST['titulo'], $_POST['descripcion'], $_POST['expositor'], $_POST['fecha'], $_POST['hora'], $_POST['plataforma'], $_POST['codigo_plat'], $_POST['codigo_as'], $_POST['cap_max'], $_POST['estado'], $userpic);
            } else {
                echo '<script>
                alertaFalla("El archivo es muy largo, menor a 5MB", "warning");
                // alert("El archivo es muy largo, menor a 5MB");
                // window.history.go(-1);
                </script>';
            }
        } else {
            echo '<script>
                alertaFalla("Solo formatos de imagen JPG, JPEG y PNG", "warning");
                // alert("Solo formatos de imagen JPG, JPEG y PNG");
                // window.history.go(-1);
                </script>';
        }
    } else {
        //if no image selected
        $userpic = $consulta[10]; // old image

        modificarVir($_POST['id'], $_POST['titulo'], $_POST['descripcion'], $_POST['expositor'], $_POST['fecha'], $_POST['hora'], $_POST['plataforma'], $_POST['codigo_plat'], $_POST['codigo_as'], $_POST['cap_max'], $_POST['estado'], $userpic);
    }    

    function modificarVir($id, $titulo, $desc, $expositor, $fecha, $hora, $plat, $codigo_plat, $codigo_as, $cap_max, $estado, $imagen)
    {
        include_once 'db.php';
        $db = new DB();
        $update = "UPDATE virtual SET titulo=:titulo, descripcion=:descripcion, expositor=:expositor, fecha_inicio=:fecha, hora_inicio=:hora, plataforma=:plataforma, codigo_plat=:codigo_plat, estado=:estado, cap_max=:cap_max, codigo_asistencia=:codigo_as, imagen=:imagen, hora_creacion=now() WHERE id_virtual=:id";

        //EJECUTA LA CONSULTA
        $query =$db->connect()->prepare($update);
        $query->execute(['id'=>$id, 'titulo'=>$titulo, 'descripcion'=>$desc, 'expositor'=>$expositor, 'fecha'=>$fecha, 'hora'=>$hora, 'plataforma'=>$plat, 'codigo_plat'=>$codigo_plat, 'estado'=>$estado, 'cap_max'=>$cap_max, 'codigo_as'=>$codigo_as, 'imagen'=>$imagen]);
        if(!$query) {
            echo '<script>
                alertaFalla("Error al modificar", "error");
                // alert("Error al modificar");
                // window.history.go(-1);
            </script>';
        } else {
            echo '<script>
                    alertaCorrecto("Conferencia modificada correctamente");
                    // alert("Conferencia modificada correctamente");
                    // window.location = "../vistas/conferenciasV.php";
                </script>';
        }
    }
    ?>

    
</body>
</html>


