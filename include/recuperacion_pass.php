<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación Contraseña</title>
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
    recuperacion($_POST['email']);

    function recuperacion($email)
    {
        // Poner las alertas chidas en esta seccion que diga que no son iguales las contraseñas -->
        if ($email == "") {
            echo '<script>
            alertaFalla("Complete los campos correctamente", "warning");
            </script>';
        }else{
        
        include_once 'db.php';
        include_once 'SED.php';

        $db = new DB();

        $consulta = "SELECT username,contra FROM usuarios WHERE correo=:email";

        //EJECUTA LA CONSULTA
        $query = $db->connect()->prepare($consulta);
        $query->execute(['email'=>$email]);

        if($query->rowCount() == 0) {
        echo '<script>
            alertaFalla("No existe la cuenta con el correo proporcionado", "warning");
        </script>';
        }else{
            foreach($query as $pass) {
                $contraDes = SED::decryption($pass['contra']);

                $destinatario = $email;
                $asunto = ("Recuperacion de Cuenta");
                $mensaje = ("Usuario:   ".$pass['username']."    Contraseña:   ".$contraDes);
                $hader = ("Buen dia, te enviamos tu contraseña para que puedas volver a acceder a la página web");
                mail($destinatario,$asunto,$mensaje,$hader);

               echo '<script>
                    alertaCorrecto("Se envio tu contraseña al correo: '.$email.'");
                </script>';
            }
        }

        }
    }

    ?>
    
</body>
</html>