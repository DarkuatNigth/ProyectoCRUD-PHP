<?php

class Departamento {
    public $id;
    public $nombreDepartamento;
    public $estado;
    public $fechaCreacion;
    public $fechaModificacion;

    public function __construct($id, $nombreDepartamento, $estado, $fechaCreacion, $fechaModificacion) {
        $this->id = $id;
        $this->nombreDepartamento = $nombreDepartamento;
        $this->estado = $estado;
        $this->fechaCreacion = $fechaCreacion;
        $this->fechaModificacion = $fechaModificacion;
    }


    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNombreDepartamento() {
        return $this->nombreDepartamento;
    }

    public function setNombreDepartamento($nombreDepartamento) {
        $this->nombreDepartamento = $nombreDepartamento;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function getFechaCreacion() {
        return $this->fechaCreacion;
    }

    public function setFechaCreacion($fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;
    }

    public function getFechaModificacion() {
        return $this->fechaModificacion;
    }

    public function setFechaModificacion($fechaModificacion) {
        $this->fechaModificacion = $fechaModificacion;
    }
}
?>