<?php
include_once 'db.php';

class Presencial extends DB
{
    //CONSULTA PARA MOSTRAR UBICACION EN EL INDEX (MENU PRINCIPAL)
    public function getUbicacion($titulo)
    {
        $query = $this->connect()->prepare('SELECT ubicacion FROM lugar_expo INNER JOIN presencial ON lugar_expo.id_lugar = presencial.id_lugar WHERE presencial.estado = 1 AND presencial.titulo = :titulo');
        $query->execute(['titulo' => $titulo]);

        foreach($query as $ubicacion) {
            return $ubicacion['ubicacion'];
        }
    }

    //CONSULTA PARA MOSTRAR NOMBRE DE LUGAR EN EL INDEX (MENU PRINICPAL)
    public function getNombreLugar($titulo)
    {
        $query = $this->connect()->prepare('SELECT nombre FROM lugar_expo INNER JOIN presencial ON lugar_expo.id_lugar = presencial.id_lugar WHERE presencial.estado = 1 AND presencial.titulo = :titulo');
        $query->execute(['titulo' => $titulo]);

        foreach($query as $nombre) {
            return $nombre['nombre'];
        }
    }

    //CONSULTA PARA MOSTRAR UBICAICON DE LUGAR POR ID
    public function getUbicacionTabla($id)
    {
        $query = $this->connect()->prepare('SELECT ubicacion FROM lugar_expo INNER JOIN presencial ON lugar_expo.id_lugar = presencial.id_lugar WHERE presencial.id_presencial = :id');
        $query->execute(['id' => $id]);

        foreach($query as $ubicacion) {
            return $ubicacion['ubicacion'];
        }
    }

    public function getEstadoTabla($id) {
        $query = $this->connect()->prepare('SELECT lugar_expo.estado FROM lugar_expo INNER JOIN presencial ON lugar_expo.id_lugar = presencial.id_lugar WHERE presencial.id_presencial = :id');
        $query->execute(['id' => $id]);
        foreach($query as $estado) {
            return $estado['estado'];
        }
    }

    //CONSULTA PARA MOSTRAR NOMBRE DE LUGAR POR ID
    public function getNombreLugarTabla($id)
    {
        $query = $this->connect()->prepare('SELECT nombre FROM lugar_expo INNER JOIN presencial ON lugar_expo.id_lugar = presencial.id_lugar WHERE presencial.id_presencial = :id');
        $query->execute(['id' => $id]);

        foreach($query as $nombre) {
            return $nombre['nombre'];
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
        $consulta = "SELECT presencial.codigo_asistencia FROM presencial INNER JOIN registros ON presencial.id_presencial=registros.id_presencial WHERE id_registro=:id";
        $consulta = $this->connect()->prepare($consulta);
        $consulta->execute(['id'=>$id]);
        foreach($consulta as $codigo) {
            return $codigo['codigo_asistencia'];
        }
    }

    public function getTituloConf($id)
    {
        $consulta = "SELECT presencial.titulo FROM presencial INNER JOIN registros ON presencial.id_presencial=registros.id_presencial WHERE id_registro=:id";
        $consulta = $this->connect()->prepare($consulta);
        $consulta->execute(['id'=>$id]);
        foreach($consulta as $titulo) {
            return $titulo['titulo'];
        }
    }

    public function getFechaConf($id)
    {
        $consulta = "SELECT presencial.fecha_inicio FROM presencial INNER JOIN registros ON presencial.id_presencial=registros.id_presencial WHERE id_registro=:id";
        $consulta = $this->connect()->prepare($consulta);
        $consulta->execute(['id'=>$id]);
        foreach($consulta as $fecha) {
            return $fecha['fecha_inicio'];
        }
    }

    public function getHoraConf($id)
    {
        $consulta = "SELECT presencial.hora_inicio FROM presencial INNER JOIN registros ON presencial.id_presencial=registros.id_presencial WHERE id_registro=:id";
        $consulta = $this->connect()->prepare($consulta);
        $consulta->execute(['id'=>$id]);
        foreach($consulta as $hora) {
            return $hora['hora_inicio'];
        }
    }

    public function getIdConf($id)
    {
        $consulta = "SELECT id_presencial FROM registros WHERE id_registro=:id";
        $consulta = $this->connect()->prepare($consulta);
        $consulta->execute(['id'=>$id]);
        foreach($consulta as $idPre) {
            return $idPre['id_presencial'];
        }
    }

    //CONSULTA PARA OBTENER NOMBRE DE LUGAR POR ID
    public function getNombreByID($id)
    {
        $query = $this->connect()->prepare('SELECT nombre FROM lugar_expo INNER JOIN presencial ON lugar_expo.id_lugar = presencial.id_lugar WHERE presencial.id_presencial = :id');
        $query->execute(['id' => $id]);

        foreach($query as $nombre) {
            return $nombre['nombre'];
        }
    }

    public function getHoraAlt($id)
    {
        $consulta = "SELECT hora_inicio FROM presencial WHERE id_presencial=:id";
        $consulta = $this->connect()->prepare($consulta);
        $consulta->execute(['id'=>$id]);
        foreach($consulta as $hora) {
            return $hora['hora_inicio'];
        }
    }

    public function getFechaAlt($id)
    {
        $consulta = "SELECT fecha_inicio FROM presencial WHERE id_presencial=:id";
        $consulta = $this->connect()->prepare($consulta);
        $consulta->execute(['id'=>$id]);
        foreach($consulta as $fecha) {
            return $fecha['fecha_inicio'];
        }
    }

    public function getCapacidadActual($id) {
        $consulta = "SELECT capacidad_actual FROM presencial WHERE id_presencial=:id";
        $consulta = $this->connect()->prepare($consulta);
        $consulta->execute(['id'=>$id]);
        foreach($consulta as $cap) {
            return $cap['capacidad_actual'];
        }
    }

    public function getCapacidadMaxima($id) {
        $consulta = "SELECT cap_max FROM presencial WHERE id_presencial=:id";
        $consulta = $this->connect()->prepare($consulta);
        $consulta->execute(['id'=>$id]);
        foreach($consulta as $cap) {
            return $cap['cap_max'];
        }
    }
}

?>