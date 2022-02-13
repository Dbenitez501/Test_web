<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta</title>
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
                window.location = "../vistas/cuenta.php";
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
    modificarCuenta($_POST['id'], $_POST['telefono'], $_POST['contra'], $_POST['contraconf']);

    function modificarCuenta($id, $telefono, $contra, $contraconf)
    {
        // Poner las alertas chidas en esta seccion que diga que no son iguales las contraseñas -->
        if ($contra !== $contraconf) {
            echo '<script>
                alertaFalla("Confirme la contraseña correctamente", "warning");
            </script>';
        }else if($contra=="" || $telefono=="" || $contraconf=""){
            echo '<script>
            alertaFalla("Complete los campos correctamente", "warning");
        </script>';
        }else if(strlen ($telefono)!==10){
            echo '<script>
            alertaFalla("El teléfono debe de contener 10 digitos", "warning");
        </script>';
        }else {
        include_once 'db.php';
        include_once 'SED.php';
        $db = new DB();
        $update = "UPDATE usuarios SET contra=:contra, telefono=:telefono WHERE id_usuario=:id";

        //Encriptamos la contraseña del form para pasarla a la BDD
        $contraEnc = SED::encryption($contra);

        //EJECUTA LA CONSULTA
        $query = $db->connect()->prepare($update);
        $query->execute(['id'=>$id, 'contra'=>$contraEnc, 'telefono'=>$telefono]);
        if(!$query) {
            echo '<script>
                alertaFalla("Error al modificar", "warning");
                // alert("Error al modificar");
                // window.history.go(-1);
            </script>';
        } else {
            echo '<script>
                    alertaCorrecto("Datos modificados correctamente");
                    // alert("Administrador modificado correctamente");
                    // window.location = "../vistas/administradores.php";
                </script>';
        }

        }
    }

    ?>
    
</body>
</html>