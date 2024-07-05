<?php

require_once 'C:\xampp\htdocs\proyectos\Proyecto001\CrudBackEnd.Server\Configuration\ConexionBD.php';
require_once 'C:\xampp\htdocs\proyectos\Proyecto001\CrudBackEnd.Server\Models\Empleado.php'; // Asegúrate de incluir la clase Empleado

class EmpleadoService {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function listarEmpleados() {
        try {
            $this->conexion->ejecutar("Conectarse"); // Conectar a la base de datos
            
            $stmt = $this->conexion->getConnection()->prepare("CALL sp_listaEmpleados()");
            $stmt->execute();
            $result = $stmt->get_result();

            $empleados = [];
            while ($row = $result->fetch_assoc()) {
                $empleado = new Empleado(
                    $row["Id"],
                    $row["nombreEmpleado"],
                    $row["departamentoId"],
                    $row["estado"],
                    $row["correo"],
                    $row["fechaIngreso"],
                    $row["salario"],
                    $row["fechaModificacion"]
                );
                $empleados[] = $empleado;
            }

            $stmt->close();
            return $empleados;
        } catch (Exception $e) {
            echo "Error al listar empleados: " . $e->getMessage();
        } finally {
            $this->conexion->ejecutar("Desconectarse"); // Desconectar de la base de datos
        }
    }

    public function obtenerEmpleado($idEmpleado) {
        try {
            $this->conexion->ejecutar("Conectarse"); // Conectar a la base de datos

            $stmt = $this->conexion->getConnection()->prepare("CALL sp_obtenerEmpleado(?)");
            $stmt->bind_param("i", $idEmpleado);
            $stmt->execute();
            $result = $stmt->get_result();
            $empleado = null;
            if ($row = $result->fetch_assoc()) {
                $empleado = new Empleado(
                    $row["Id"],
                    $row["nombreEmpleado"],
                    $row["departamentoId"],
                    $row["estado"],
                    $row["correo"],
                    $row["fechaIngreso"],
                    $row["salario"],
                    $row["fechaModificacion"]
                );
            }

            $stmt->close();
            return $empleado;
        } catch (Exception $e) {
            echo "Error al obtener empleado: " . $e->getMessage();
        } finally {
            $this->conexion->ejecutar("Desconectarse"); // Desconectar de la base de datos
        }
    }

    public function crearEmpleado($objEmpleado) {
        $blejecuto = false;
        try {
            $this->conexion->ejecutar("Conectarse"); // Conectar a la base de datos
            // Convertir DateTime a string formateado
            $fechaIngresoString = $objEmpleado->getFechaIngreso()->format('Y-m-d H:i:s');

            // Preparar y ejecutar la consulta
            $stmt = $this->conexion->getConnection()->prepare("CALL sp_crearEmpleado(?, ?, ?, ?, ?)");
            
            // Asignar los parámetros por referencia
            $nombreEmpleado = $objEmpleado->getNombreEmpleado();
            $departamentoId = $objEmpleado->getDepartamentoId();
            $correo = $objEmpleado->getCorreo();
            $salario = $objEmpleado->getSalario();
            
            $stmt->bind_param("sisds", $nombreEmpleado, $departamentoId, $correo, $salario, $fechaIngresoString);
            $stmt->execute();

            $stmt->close();   
            $blejecuto = true; 
            $response = [
                "isSuccess" => $blejecuto,
                "message" => "Empleado creado exitosamente."
            ];
            echo json_encode($response);
        } catch (Exception $e) {

        // En caso de error
        $response = [
            "isSuccess" => $blejecuto,
            "error" => "Error al crear empleado: " . $e->getMessage()
        ];

        } finally {
            $this->conexion->ejecutar("Desconectarse"); // Desconectar de la base de datos
        }
    }

    public function editarEmpleado($objEmpleado) {
        $blejecuto = false;
        try {
            $this->conexion->ejecutar("Conectarse"); // Conectar a la base de datos
            $fechaIngresoString = $objEmpleado->getFechaIngreso()->format('Y-m-d H:i:s');

            // Preparar y ejecutar la consulta
            $stmt = $this->conexion->getConnection()->prepare("CALL sp_editarEmpleado(?, ?, ?, ?, ?, ?)");
            
            // Asignar los parámetros por referencia
            $id = $objEmpleado->getId();
            $nombreEmpleado = $objEmpleado->getNombreEmpleado();
            $departamentoId = $objEmpleado->getDepartamentoId();
            $correo = $objEmpleado->getCorreo();
            $salario = $objEmpleado->getSalario();
            
            $stmt->bind_param("isssds", $id, $nombreEmpleado, $departamentoId, $correo, $salario, $fechaIngresoString);
    
            $stmt->execute();

            $stmt->close();
            $blejecuto = true; 
            $response = [
                "isSuccess" => $blejecuto,
                "message" => "Empleado actualizado exitosamente."
            ];
            echo json_encode($response);
        } catch (Exception $e) { // En caso de error
            $response = [
                "isSuccess" => $blejecuto,
                "error" => "Error al editar empleado: " . $e->getMessage()
            ];
        } finally {
            $this->conexion->ejecutar("Desconectarse"); // Desconectar de la base de datos
        }
    }

    public function eliminarEmpleado($idEmpleado) {
        $blejecuto = false;
        try {
            $this->conexion->ejecutar("Conectarse"); // Conectar a la base de datos

            $stmt = $this->conexion->getConnection()->prepare("CALL sp_eliminarEmpleado(?)");
            $stmt->bind_param("i", $idEmpleado);
            $stmt->execute();

            $stmt->close();
            $blejecuto = true; 
            $response = [
                "isSuccess" => $blejecuto,
                "message" => "Empleado eliminado exitosamente."
            ];
            echo json_encode($response);
        } catch (Exception $e) {// En caso de error
            $response = [
                "isSuccess" => $blejecuto,
                "error" => "Error al eliminar empleado: " . $e->getMessage()
            ];
        } finally {
            $this->conexion->ejecutar("Desconectarse"); // Desconectar de la base de datos
        }
    }
}

?>

