<?php
include_once 'include/user_session.php';
include_once 'include/user.php';
include_once 'include/presencial.php';
include_once 'include/virtual.php';
include_once 'include/db.php';

$userSession = new UserSession();
$user = new User();
$db = new DB();
$presencial = new Presencial();
$virtual = new Virtual();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="css/estilos.css?v=<?php echo(rand()); ?>">  
    <script src = " https://unpkg.com/sweetalert/dist/sweetalert.min.js "></script>
</head>
<body>
    <script>
        function alertaWarningMsg(msg) {
            swal({
                title: "Alerta",
                text: msg, 
                icon: "warning",
                button: "Ok",
            }).then((value)  => {
                window.location = "controlador.php";
            });
        }
        function alertaCorrecto() {
            swal({
                title: "Éxito",
                text: "Se inscribió correctamente", 
                icon: "success",
                button: "Ok",
            }).then((value)  => {
                window.location = "controlador.php";
            });
        }
        function alertaError(msg) {
            swal({
                title: "Error",
                text: msg, 
                icon: "error",
                button: "Ok",
            }).then((value)  => {
                window.history.go(-1);
            });
        }
    </script>
    
    <?php
    
    if(!isset($_SESSION['user']))
    {
        //header("location: controlador.php");
        echo '<script>
                window.location = "controlador.php";
            </script>';
    } else if(isset($_SESSION['user'])) {

        $user->setUser($userSession->getCurrentUser());

        $idConf = $_GET['id'];
        $idUsu = $user->getIdUsu();
        $asistencia = 0;

        $insertar = "INSERT INTO registros (id_presencial, id_usuario, asistencia) VALUES ('$idConf', '$idUsu', '$asistencia')";

        //Ver si ya se pasó el límite de capacidad máxima de la conferencia en caso de que no se refresque la página
        $cap_actual = $presencial->getCapacidadActual($idConf);
        $cap_max = $presencial->getCapacidadMaxima($idConf);

        if($cap_max <= $cap_actual) {
            echo '<script>
                alertaWarningMsg("Ya se ocuparon todos los lugares disponibles");
            </script>';
            exit;
        }

        //VERIFICA SI YA SE INSCRIBIÓ A ESA CONFERENCIA
        $verificaInscripcion = $db->connect()->prepare("SELECT * FROM registros WHERE id_usuario=:user AND id_presencial=:id");
        $verificaInscripcion->execute(['user'=>$idUsu, 'id'=>$idConf]);
        if($verificaInscripcion->rowCount() > 0) {
            echo '<script>
                alertaWarningMsg("Ya está inscrito");
                //alert("Ya está inscrito");
                //window.location = "controlador.php";
            </script>';
            exit;
        }

        //VERIFICA QUE NO SE INSCRIBA A LA MISMA HORA Y EL MISMO DÍA EN UNA PRESENCIAL
        $horaP = $presencial->getHoraAlt($idConf);
        $fechaP = $presencial->getFechaAlt($idConf);

        $verificaDiaHoraVirtual = $db->connect()->prepare("SELECT * FROM registros INNER JOIN usuarios ON registros.id_usuario=usuarios.id_usuario 
            INNER JOIN virtual ON registros.id_virtual=virtual.id_virtual WHERE usuarios.id_usuario=:user AND fecha_inicio=:fecha AND hora_inicio=:hora");    
        $verificaDiaHoraVirtual->execute(['user'=>$idUsu, 'fecha'=>$fechaP, 'hora'=>$horaP]);

        $verificaDiaHoraPre = $db->connect()->prepare("SELECT * FROM registros INNER JOIN usuarios ON registros.id_usuario=usuarios.id_usuario 
        INNER JOIN presencial ON registros.id_presencial=presencial.id_presencial WHERE usuarios.id_usuario=:user AND fecha_inicio=:fecha AND hora_inicio=:hora");    
        $verificaDiaHoraPre->execute(['user'=>$idUsu, 'fecha' => $fechaP, 'hora' => $horaP]);

        if($verificaDiaHoraVirtual->rowCount() > 0 || $verificaDiaHoraPre->rowCount() > 0) {
            echo '<script>
                alertaWarningMsg("Ocupado en la fecha '.$fechaP.' a las '.$horaP.' horas");
                //alert("Ocupado en la fecha '.$fechaP.' a las '.$horaP.' horas");
                //window.location = "controlador.php";
            </script>';
            exit;
        }

        //Ejecutamos el procedimiento
        $procedure = $db->connect()->prepare('CALL conteo_capacidad_presencial(?)');
        $procedure->bindParam(1, $idConf, PDO::PARAM_INT);
        $procedure->execute();

        $query = $db->connect()->prepare($insertar);
        $query->execute();

        if(!$query) {
        echo '<script>
            alertaError("Error al inscribirse");
            //alert("Error al inscribirse");
            //window.history.go(-1);
        </script>';
        } else {
        echo '<script>
                alertaCorrecto();
                //alert("Se inscribió correctamente");
                //window.location = "controlador.php";
            </script>';
        }
    }

    ?>


</body>
</html>



