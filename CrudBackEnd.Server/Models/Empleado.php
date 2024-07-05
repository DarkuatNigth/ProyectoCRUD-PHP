<?php
class Empleado {
    public $id;
    public $nombreEmpleado;
    public $departamentoId;
    public $estado;
    public $correo;
    public $fechaIngreso;
    public $salario;
    public $fechaModificacion;

    public function __construct($id, $nombreEmpleado, $departamentoId, $estado, $correo, $fechaIngreso, $salario, $fechaModificacion) {
        $this->id = $id;
        $this->nombreEmpleado = $nombreEmpleado;
        $this->departamentoId = $departamentoId;
        $this->estado = $estado;
        $this->correo = $correo;
        $this->fechaIngreso = $fechaIngreso;
        $this->salario = $salario;
        $this->fechaModificacion = $fechaModificacion;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNombreEmpleado() {
        return $this->nombreEmpleado;
    }

    public function setNombreEmpleado($nombreEmpleado) {
        $this->nombreEmpleado = $nombreEmpleado;
    }

    public function getDepartamentoId() {
        return $this->departamentoId;
    }

    public function setDepartamentoId($departamentoId) {
        $this->departamentoId = $departamentoId;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    public function getFechaIngreso() {
        return $this->fechaIngreso;
    }

    public function setFechaIngreso($fechaIngreso) {
        $this->fechaIngreso = $fechaIngreso;
    }

    public function getSalario() {
        return $this->salario;
    }

    public function setSalario($salario) {
        $this->salario = $salario;
    }

    public function getFechaModificacion() {
        return $this->fechaModificacion;
    }

    public function setFechaModificacion($fechaModificacion) {
        $this->fechaModificacion = $fechaModificacion;
    }
}
?>