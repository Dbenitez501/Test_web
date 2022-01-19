<?php
include_once 'db.php';

if(isset($_POST['confe']) && isset($_POST['tipo']) && !$_POST['estado']) {
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
}

?>