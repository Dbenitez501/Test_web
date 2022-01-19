<?php
include_once 'db.php';

class ConsultaVir extends DB
{
    public function consultarVir($id)
    {
        $query = $this->connect()->prepare("SELECT * FROM virtual WHERE id_virtual = :id");
        $query->execute(['id' => $id]);

        $filas = $query->fetch(PDO::FETCH_ASSOC);
        return [
            $filas['titulo'],
            $filas['descripcion'],
            $filas['expositor'],
            $filas['fecha_inicio'],
            $filas['hora_inicio'],
            $filas['plataforma'],
            $filas['codigo_plat'],
            $filas['codigo_asistencia'],
            $filas['cap_max'],
            $filas['estado'],
            $filas['imagen']
        ];
    }
}

?>