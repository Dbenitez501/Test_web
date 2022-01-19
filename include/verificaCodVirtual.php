<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asistencia</title>
    <link rel="stylesheet" href="../css/estilos.css?v=<?php echo(rand()); ?>">
    <link rel="stylesheet" href="../css/soluciones.css?v=<?php echo(rand()); ?>">
    <script src = " https://unpkg.com/sweetalert/dist/sweetalert.min.js "></script>
</head>
<body>
    <script>
        function alertaCorrecto(id){
            swal({
                title: "Éxito",
                text: "Asistencia registrada correctamente", 
                icon: "success",
                button: {
                    value: id,
                },
            }).then((value)  => {
                window.location = "../vistas/tabla_asistencias.php";
            });
        }

        function alertaError(id){
            swal({
                title: "Error",
                text: "Código incorrecto", 
                icon: "error",
                button: {
                    value: id,
                },
            }).then((value)  => {
                window.location = "../vistas/asistencia.php?idRegV=" + value;
            });
        }
    </script>
    
    <?php
    verificaAsistencia($_POST['id'], $_POST['codigo'], $_POST['comentario']);

    function verificaAsistencia($idReg, $cod_as, $comentario)
    {
        include_once 'db.php';
        include_once 'virtual.php';
        $db = new DB();
        $virtual = new Virtual();
        $asist = 1;
        $idVirtual = $virtual->getIdConf($idReg);

        $update = "UPDATE registros SET asistencia=:asist, comentario=:comentario WHERE id_registro=:id";

        $codigo = $virtual->getCodigoConf($idReg);

        if($cod_as == $codigo) {
            $verificaRepetido = $db->connect()->prepare("SELECT * FROM registros WHERE id_registro=:id AND id_virtual=:pre AND asistencia=1");
            $verificaRepetido->execute(['id'=>$idReg, 'pre'=>$idVirtual]);
            if($verificaRepetido->rowCount()>0) {
                echo '<script>
                    alert("Ya registró esta asistencia");
                    window.location = "../vistas/tabla_asistencias.php";
                </script>';
                exit; 
            }

            $query = $db->connect()->prepare($update);
            $query->execute(['id'=>$idReg, 'asist'=>$asist, 'comentario'=>$comentario]);
            if(!$query) {
                echo '<script>
                    alert("Error al guardar");
                    window.history.go(-1);
                </script>';
            } else {
                echo '<script>
                        alertaCorrecto('.$idReg.');
                        //alert("Asistencia guardada correctamente");
                        //window.location = "../vistas/tabla_asistencias.php";
                    </script>';
            }
        } else {
            echo '<script>
                    alertaError('.$idReg.');
                    //alert("Código no es igual"); 
                    //window.location = "../vistas/asistencia.php?idRegV="+"'.$idReg.'";
            </script>';
        }
    }
    ?>
</body>
</html>





