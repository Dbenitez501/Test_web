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
    include_once 'db.php';
    include_once 'SED.php';
    $db = new DB();

    //Recibe los datos y los almacena en variables
    $nombre     = $_POST['nombre'];
    $email      = $_POST['email'];
    $username   = $_POST['username'];
    $contra     = $_POST['contra'];
    $sexo;
    $telefono;
    $tipo = $_POST['tipo'];

    //Encriptamos la contraseña para mandarla a la BDD
    $passCifrada = SED::encryption($contra);

    if(isset($_POST['sexo'])) {
        $sexo = $_POST['sexo'];
    } else {
        $sexo = "";
    }

    if(isset($_POST['telefono'])) {
        $telefono = $_POST['telefono'];
    }

    //Consulta para insertar los datos del Admin
    $insertar = "INSERT INTO usuarios (username, contra, nombre, correo, telefono, sexo, id_tipo) VALUES 
    ('$username', '$passCifrada', '$nombre', '$email', '$telefono', '$sexo', '$tipo')";

    //VERIFICA SI YA EXISTE EL USERNAME
    $verificarUser = $db->connect()->prepare("SELECT * FROM usuarios WHERE username = :user");
    $verificarUser->execute(['user' => $username]);

    if($verificarUser->rowCount() > 0) {
        echo '<script>
            alertaFalla("El usuario ya está registrado", "warning");
            // alert("El usuario ya está registrado");
            // window.history.go(-1);
        </script>';
        exit;
    }

    //VERIFICA SI YA EXISTE EL CORREO
    $verificarCorreo = $db->connect()->prepare("SELECT * FROM usuarios WHERE correo = :email");
    $verificarCorreo->execute(['email' => $email]);

    if($verificarCorreo->rowCount() > 0) {
        echo '<script>
            alertaFalla("El correo ya está registrado", "warning");
            // alert("El correo ya está registrado");
            // window.history.go(-1);
        </script>';
        exit;
    }

    //EJECUTA LA CONSULTA DE INSERTAR
    $query = $db->connect()->prepare($insertar);
    $query->execute();

    if(!$query) {
        echo '<script>
            alertaFalla("Error al registrarse", "error");
            // alert("Error al registrarse");
            // window.history.go(-1);
        </script>';
    } else {
        echo '<script>
                alertaCorrecto("Se registró correctamente");
                // alert("Se registró correctamente");
                // window.location = "../vistas/administradores.php";
            </script>';
        //header("location: ../controlador.php");
    }

    ?>
    
</body>
</html>

