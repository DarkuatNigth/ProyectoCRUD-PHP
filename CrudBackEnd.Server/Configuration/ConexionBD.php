<?php

class ConexionBD {
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $conn;

    public function __construct() {
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "DBempleados";
        $this->conn = null; // Inicializamos la conexión como nula al inicio
    }

    public function ejecutar($opcion) {
        try {
            if ($opcion == "Conectarse") {
                $this->conectar();
            } elseif ($opcion == "Desconectarse") {
                $this->desconectar();
            } else {
                throw new Exception("Opción no válida.");
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    private function conectar() {
        try {
            // Crear conexión
            $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

            // Verificar la conexión
            if ($this->conn->connect_error) {
                throw new Exception("Conexión fallida: " . $this->conn->connect_error);
            }

        } catch (Exception $e) {
            echo "Error al conectar: " . $e->getMessage();
        }
    }

    private function desconectar() {
        try {
            // Cerrar conexión
            if ($this->conn != null) {
                $this->conn->close();
            } else {
                throw new Exception("No hay conexión abierta.");
            }
        } catch (Exception $e) {
            echo "Error al desconectar: " . $e->getMessage();
        }
    }
    public function getConnection() {
    return $this->conn;
    }
}


?>
