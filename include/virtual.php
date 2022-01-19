<?php
include_once 'db.php';

class Virtual extends DB 
{
    public function getPlataforma($id)
    {
        $query = $this->connect()->prepare('SELECT plataforma FROM virtual WHERE estado=1 AND id_virtual = :id');
        $query->execute(['id' => $id]);

        foreach($query as $plataforma) {
            return $plataforma['plataforma'];
        }
    }

    //OBTIENE EL ESTADO DE LA CONFERENCIA Y LO TRANSFORMA A TEXTO PARA MOSTRAR EN TABLA
    public function getEstado($estado)
    {
        if($estado == 1) {
            $est = "Activado";
            return $est;
        } else {
            $est = "Desactivado";
            return $est;
        }
    }

    public function getCodigoConf($id)
    {
        $consulta = "SELECT virtual.codigo_asistencia FROM virtual INNER JOIN registros ON virtual.id_virtual=registros.id_virtual WHERE id_registro=:id";
        $consulta = $this->connect()->prepare($consulta);
        $consulta->execute(['id'=>$id]);
        foreach($consulta as $codigo) {
            return $codigo['codigo_asistencia'];
        }
    }

    public function getTituloConf($id)
    {
        $consulta = "SELECT virtual.titulo FROM virtual INNER JOIN registros ON virtual.id_virtual=registros.id_virtual WHERE id_registro=:id";
        $consulta = $this->connect()->prepare($consulta);
        $consulta->execute(['id'=>$id]);
        foreach($consulta as $titulo) {
            return $titulo['titulo'];
        }
    }

    public function getFechaConf($id)
    {
        $consulta = "SELECT virtual.fecha_inicio FROM virtual INNER JOIN registros ON virtual.id_virtual=registros.id_virtual WHERE id_registro=:id";
        $consulta = $this->connect()->prepare($consulta);
        $consulta->execute(['id'=>$id]);
        foreach($consulta as $fecha) {
            return $fecha['fecha_inicio'];
        }
    }

    public function getHoraConf($id)
    {
        $consulta = "SELECT virtual.hora_inicio FROM virtual INNER JOIN registros ON virtual.id_virtual=registros.id_virtual WHERE id_registro=:id";
        $consulta = $this->connect()->prepare($consulta);
        $consulta->execute(['id'=>$id]);
        foreach($consulta as $hora) {
            return $hora['hora_inicio'];
        }
    }

    public function getIdConf($id)
    {
        $consulta = "SELECT id_virtual FROM registros WHERE id_registro=:id";
        $consulta = $this->connect()->prepare($consulta);
        $consulta->execute(['id'=>$id]);
        foreach($consulta as $idVirtual) {
            return $idVirtual['id_virtual'];
        }
    }
    
    public function getHoraAlt($id)
    {
        $consulta = "SELECT hora_inicio FROM virtual WHERE id_virtual=:id";
        $consulta = $this->connect()->prepare($consulta);
        $consulta->execute(['id'=>$id]);
        foreach($consulta as $hora) {
            return $hora['hora_inicio'];
        }
    }

    public function getFechaAlt($id)
    {
        $consulta = "SELECT fecha_inicio FROM virtual WHERE id_virtual=:id";
        $consulta = $this->connect()->prepare($consulta);
        $consulta->execute(['id'=>$id]);
        foreach($consulta as $fecha) {
            return $fecha['fecha_inicio'];
        }
    }
}  

?>