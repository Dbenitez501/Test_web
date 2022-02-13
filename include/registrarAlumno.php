<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
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
                window.location = "../controlador.php";
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
    $matricula  = $_POST['mat'];
    $carrera    = $_POST['carreras'];
    $email      = $_POST['email'];
    $username   = $_POST['username'];
    $contra     = $_POST['contra'];
    $sexo;
    $pais     = $_POST['paises'];
    $telefono = $_POST['telefono'];
    $tipo = 3;

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

    //Consulta para insertar los datos del alumno
    $insertar = "INSERT INTO usuarios (username, contra, nombre, carrera, matricula, correo, telefono, sexo, pais, id_tipo) VALUES 
    ('$username', '$passCifrada', '$nombre', '$carrera', '$matricula', '$email', '$telefono', '$sexo', '$pais','$tipo')";

    //VERIFICA SI YA EXISTE EL USERNAME
    $verificarUsuario = $db->connect()->prepare("SELECT * FROM usuarios WHERE username = :user");
    $verificarUsuario->execute(['user' => $username]);

    if($verificarUsuario->rowCount() > 0) {
        echo '<script>
            alertaFalla("El nombre de usuario ya está registrado. Favor de colocar uno distinto a: '.$username.'.", "warning");
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
            alertaFalla("El correo '.$email.' ya está registrado. Favor de colocar uno distinto.", "warning");
            // alert("El correo ya está registrado");
            // window.history.go(-1);
        </script>';
        exit;
    }

    //VERIFICA SI YA EXISTE LA MATRICULA
    $verificarMatricula = $db->connect()->prepare("SELECT * FROM usuarios WHERE matricula = :mat");
    $verificarMatricula->execute(['mat' => $matricula]);

    if($verificarMatricula->rowCount() > 0) {
        echo '<script>
            alertaFalla("La matrícula '.$matricula.' ya está registrada. Favor de verificarla.", "warning");
            // alert("La matrícula ya existe");
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
                alertaCorrecto("Se registró correctamente. Bienvenido(a) '.$nombre.' ");
                // alert("Se registró correctamente");
                // window.location = "../controlador.php";
            </script>';
    }
    ?>
    
</body>
</html>