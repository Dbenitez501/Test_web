<?php
include_once 'db.php';

class ConsultaLugar extends DB
{
    public function consultarLugar($id)
    {
        $query = $this->connect()->prepare("SELECT * FROM lugar_expo WHERE id_lugar = :id");
        $query->execute(['id' => $id]);

        $filas = $query->fetch(PDO::FETCH_ASSOC);
        return [
            $filas['nombre'],
            $filas['ubicacion'],
            $filas['capacidad_max'],
            $filas['descripcion'],
            $filas['estado']
        ];
    }
}

?>