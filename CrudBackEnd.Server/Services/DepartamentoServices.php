<?php

require_once 'C:\xampp\htdocs\proyectos\Proyecto001\CrudBackEnd.Server\Configuration\ConexionBD.php';
require_once 'C:\xampp\htdocs\proyectos\Proyecto001\CrudBackEnd.Server\Models\Departamento.php'; // Asegúrate de incluir la clase Departamento

class DepartamentoService {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function listarDepartamentos() {
        try {
            $this->conexion->ejecutar("Conectarse"); // Conectar a la base de datos
            
            $stmt = $this->conexion->getConnection()->prepare("CALL sp_listaDepartamentos()");
            $stmt->execute();
            $result = $stmt->get_result();
            
            $departamentos = [];
            while ($row = $result->fetch_assoc()) {
                $departamento = new Departamento(
                    $row["Id"],
                    $row["nombreDepartamento"],
                    $row["estado"],
                    $row["fechaCreacion"],
                    $row["fechaModificacion"]
                );
                $departamentos[] = $departamento;
            }

            $stmt->close();
            return $departamentos;
        } catch (Exception $e) {
            echo "Error al listar departamentos: " . $e->getMessage();
        } finally {
            $this->conexion->ejecutar("Desconectarse"); // Desconectar de la base de datos
        }
    }
}

?>
