<?php

// Incluir la clase de conexión a la base de datos
require_once 'C:\xampp\htdocs\proyectos\Proyecto001\CrudBackEnd.Server\Configuration\ConexionBD.php';
// Incluir la clase DepartamentoService
require_once 'C:\xampp\htdocs\proyectos\Proyecto001\CrudBackEnd.Server\Services\DepartamentoServices.php';

// Incluir la clase EmpleadoService
require_once  'C:\xampp\htdocs\proyectos\Proyecto001\CrudBackEnd.Server\Services\EmpleadoServices.php';

// Definir la versión de la API
$version = "v1";

// Obtener la solicitud HTTP y el método
$request_method = $_SERVER["REQUEST_METHOD"];
$request_uri = $_SERVER["REQUEST_URI"];
$strDirApi = "/proyectos/Proyecto001/CrudBackEnd.Server";
// Establecer encabezados para permitir el acceso desde cualquier origen
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Instanciar la conexión a la base de datos
$conexion = new ConexionBD();

// Instanciar el servicio de Departamento
$departamentoService = new DepartamentoService($conexion);

// Instanciar el servicio de Empleado
$empleadoService = new EmpleadoService($conexion);

// Manejar las solicitudes según el método y la ruta
switch ($request_method) {
    case 'GET':
        // Endpoint: /api/{version}/empleados
        if (strpos($request_uri, $strDirApi."/api/{$version}/empleado") === 0) {
            if (isset($_GET["id"])) {
                // Endpoint: /api/{version}/empleados?id={id}
                $id = intval($_GET["id"]);
                $empleado = $empleadoService->obtenerEmpleado($id);
                if ($empleado) {
                    echo json_encode($empleado);
                } else {
                    echo json_encode(array("message" => "Empleado no encontrado."));
                }
            } else {
                // Endpoint: /api/{version}/empleados
                $empleados = $empleadoService->listarEmpleados();
                echo json_encode($empleados);
            }
        } elseif (strpos($request_uri, $strDirApi."/api/{$version}/departamento") === 0) {
            // Endpoint: /api/{version}/departamento
            $departamentos = $departamentoService->listarDepartamentos();
            echo json_encode($departamentos);
        } else {
            // Ruta no válida
            header("HTTP/1.0 404 Not Found");
            echo json_encode(array("message" => "Ruta no encontrada."));
        }
        break;
    case 'POST':
        // Endpoint: /api/{version}/empleados
        $data = json_decode(file_get_contents("php://input"));
        
        $empleado = new Empleado(
            $data->id,
            $data->nombreEmpleado,
            $data->departamentoId,
            $data->estado,
            $data->correo,
            new DateTime($data->fechaIngreso),
            $data->salario,
            null
        );
        $empleadoService->crearEmpleado($empleado);
        break;
    case 'PUT':
        // Endpoint: /api/{version}/empleados
        $data = json_decode(file_get_contents("php://input"));
        
        $empleado = new Empleado(
            $data->id,
            $data->nombreEmpleado,
            $data->departamentoId,
            $data->estado,
            $data->correo,
            new DateTime($data->fechaIngreso),
            $data->salario,
            null
        );
        $empleadoService->editarEmpleado($empleado);
        break;
    case 'DELETE':
        // Endpoint: /api/{version}/empleados
        $data = json_decode(file_get_contents("php://input"));
        $idEmpleado = $data->id;
        
        $empleadoService->eliminarEmpleado($idEmpleado);
        break;
    default:
        // Método no permitido
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode(array("message" => "Método no permitido."));
        break;
}

?>
