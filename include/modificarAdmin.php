<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administradores</title>
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
                window.location = "../vistas/administradores.php";
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
    modificarAdmin($_POST['id'], $_POST['nombre'], $_POST['email'], $_POST['telefono'], $_POST['sexo'], $_POST['username'], $_POST['contra'], $_POST['tipo']);

    function modificarAdmin($id, $nombre, $email, $telefono, $sexo, $username, $contra, $tipo)
    {
        include_once 'db.php';
        include_once 'SED.php';
        $db = new DB();
        $update = "UPDATE usuarios SET username=:username, contra=:contra, nombre=:nombre, correo=:correo, telefono=:telefono, sexo=:sexo, id_tipo=:tipo WHERE id_usuario=:id";

        //Encriptamos la contraseña del form para pasarla a la BDD
        $contraEnc = SED::encryption($contra);

        //EJECUTA LA CONSULTA
        $query = $db->connect()->prepare($update);
        $query->execute(['id'=>$id, 'username'=>$username, 'contra'=>$contraEnc, 'nombre'=>$nombre, 'correo'=>$email, 'telefono'=>$telefono, 'sexo'=>$sexo, 'tipo'=>$tipo]);
        if(!$query) {
            echo '<script>
                alertaFalla("Error al modificar", "warning");
                // alert("Error al modificar");
                // window.history.go(-1);
            </script>';
        } else {
            echo '<script>
                    alertaCorrecto("Administrador modificado correctamente");
                    // alert("Administrador modificado correctamente");
                    // window.location = "../vistas/administradores.php";
                </script>';
        }
    }

    ?>
    
</body>
</html>