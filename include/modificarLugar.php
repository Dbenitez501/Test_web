<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lugares de exposición</title>
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
                window.location = "../vistas/admin_lugares.php";
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
    modificarLugar($_POST['id'], $_POST['nombre'], $_POST['cap_max'], $_POST['ubicacion'], $_POST['desc'], $_POST['estado']);

    function modificarLugar($id, $nombre, $cap_max, $ubicacion, $desc, $estado)
    {
        include_once 'db.php';
        $db = new DB();
        $update = "UPDATE lugar_expo SET nombre=:nombre, ubicacion=:ubicacion, capacidad_max=:cap_max, descripcion=:descripcion, estado=:est WHERE id_lugar=:id";

        //EJECUTA LA CONSULTA
        $query = $db->connect()->prepare($update);
        $query->execute(['id'=>$id, 'nombre'=>$nombre, 'ubicacion'=>$ubicacion, 'cap_max'=>$cap_max, 'descripcion'=>$desc, 'est'=>$estado]);
        if(!$query) {
            echo '<script>
                alertaFalla("Error al modificar", "error");
                // alert("Error al modificar");
                // window.history.go(-1);
            </script>';
        } else {
            echo '<script>
                alertaCorrecto("Lugar modificado correctamente");
                // alert("Lugar modificado correctamente");
                // window.location = "../vistas/admin_lugares.php";
            </script>';

            if($estado === "Deshabilitado") {
                $procedure = $db->connect()->prepare('CALL cambiar_estado_presenciales(?)');
                $procedure->bindParam(1, $id, PDO::PARAM_INT);
                $procedure->execute();
            }
        }
    }
    ?>
    
</body>
</html>

