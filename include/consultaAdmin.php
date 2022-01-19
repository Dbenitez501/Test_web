<?php
include_once 'db.php';

class ConsultaAdmin extends DB
{
    public function consultarAdmin($id)
    {
        $query = $this->connect()->prepare("SELECT username, contra, nombre, correo, telefono, sexo, id_tipo FROM usuarios WHERE id_usuario = :id AND (id_tipo=1 OR id_tipo=5)");
        $query->execute(['id' => $id]);

        $filas = $query->fetch(PDO::FETCH_ASSOC);
        return [
            $filas['username'],
            $filas['contra'],
            $filas['nombre'],
            $filas['correo'],
            $filas['telefono'],
            $filas['sexo'],
            $filas['id_tipo']
        ];
    }
}

?>