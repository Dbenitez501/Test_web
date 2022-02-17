<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lugares de exposición</title>
    <link rel="stylesheet" href="../css/estilos.css?v=<?php echo(rand()); ?>">
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
    include_once 'db.php';
    $db = new DB();

    $nombre = $_POST['nombre'];
    $cap_max = $_POST['cap_max'];
    $ubicacion = $_POST['ubicacion'];
    $descripcion = $_POST['desc'];
    $estado = "Habilitado";

    //CONSULTA PARA INSERTAR DATOS DEL LUGAR DE EXPOSICION
    $insertar = "INSERT INTO lugar_expo (nombre, ubicacion, capacidad_max, descripcion, estado) VALUES ('$nombre', '$ubicacion', '$cap_max', '$descripcion', '$estado')";

    //VERIFICA SI YA EXISTE EL LUGAR
    $verificaLugar = $db->connect()->prepare("SELECT * FROM lugar_expo WHERE nombre=:nombre AND ubicacion=:ubi");
    $verificaLugar->execute(['nombre'=>$nombre, 'ubi'=>$ubicacion]);

    if($verificaLugar->rowCount()>0) {
        echo '<script>
            alertaFalla("El lugar ya existe", "warning");
            // alert("El lugar ya existe");
            // window.history.go(-1);
        </script>';
        exit; 
    }

    //EJECUTA LA CONSULTA DE INSERTAR
    $query = $db->connect()->prepare($insertar);
    $query->execute();

    if(!$query) {
        echo '<script>
            alertaFalla("Error al ingresar datos", "error");
            // alert("Error al ingresar datos");
            // window.history.go(-1);
        </script>';
    } else {
        echo '<script>
                alertaCorrecto("Lugar registrado exitosamente");
                // alert("Lugar registrado exitosamente");
                // window.location = "../vistas/admin_lugares.php";
            </script>';
    }

    ?>
    
</body>
</html>

