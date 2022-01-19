<?php
include_once 'db.php';

if(isset($_POST['tipoId'])) {
    $db = new DB();
    $conn = $db->connect();
    
    if($_POST['tipoId'] === "p") {
        $queryP = $conn->prepare("SELECT id_presencial, titulo, fecha_inicio FROM presencial ORDER BY id_presencial DESC");
        $queryP->execute();
        $confP = $queryP->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($confP);
    } else {
        $queryV = $conn->prepare("SELECT id_virtual, titulo, fecha_inicio FROM virtual ORDER BY id_virtual DESC");
        $queryV->execute();
        $confV = $queryV->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($confV);
    }
}

/* if(isset($_POST['confe']) && isset($_POST['tipo'])) {
    $db = new DB();
    $conn = $db->connect();

    $idConf = $_POST['confe'];
    if($_POST['tipo'] === "p") {
        $stmtP = $conn->prepare("SELECT usuarios.nombre, usuarios.correo, tipo_usuario.tipo, usuarios.sexo, registros.asistencia FROM registros JOIN presencial ON registros.id_presencial = presencial.id_presencial JOIN usuarios ON registros.id_usuario = usuarios.id_usuario JOIN tipo_usuario ON usuarios.id_tipo = tipo_usuario.id_tipo WHERE registros.id_presencial =:confId");
        $stmtP->execute(['confId'=>$idConf]);
        $personaP = $stmtP->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($personaP);
    } else {
        $stmtV = $conn->prepare("SELECT usuarios.nombre, usuarios.correo, tipo_usuario.tipo, usuarios.sexo, registros.asistencia FROM registros JOIN virtual ON registros.id_virtual = virtual.id_virtual JOIN usuarios ON registros.id_usuario = usuarios.id_usuario JOIN tipo_usuario ON usuarios.id_tipo = tipo_usuario.id_tipo WHERE registros.id_virtual =:confId");
        $stmtV->execute(['confId'=>$idConf]);
        $personaV = $stmtV->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($personaV);
    }
} */

?>