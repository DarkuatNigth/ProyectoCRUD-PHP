-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS DBempleados;
USE DBempleados;

-- Crear la tabla departamento
CREATE TABLE departamento (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    nombreDepartamento VARCHAR(255) NOT NULL,
    estado VARCHAR(50) NOT NULL DEFAULT 'Activo',
    fechaCreacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    fechaModificacion DATETIME NULL
);

-- Crear la tabla empleado
CREATE TABLE empleado (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    nombreEmpleado VARCHAR(255) NOT NULL,
    departamentoId INT NOT NULL,
    estado VARCHAR(50) NOT NULL DEFAULT 'Activo',
    correo VARCHAR(50) NOT NULL,
    fechaIngreso DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    salario DECIMAL(10, 2) NOT NULL,
    fechaModificacion DATETIME NULL,
    FOREIGN KEY (departamentoId) REFERENCES departamento(Id)
);

-- Procedimiento almacenado: sp_listaEmpleados
DELIMITER //

CREATE PROCEDURE sp_listaEmpleados()
BEGIN
    SELECT 
        Id,
        nombreEmpleado,
        departamentoId,
        estado,
        correo,
        salario,
        DATE_FORMAT(fechaIngreso, '%d/%m/%Y') AS fechaIngreso,
        DATE_FORMAT(fechaModificacion, '%d/%m/%Y') AS fechaModificacion
    FROM empleado;
END //

DELIMITER ;

-- Procedimiento almacenado: sp_obtenerEmpleado
DELIMITER //

CREATE PROCEDURE sp_obtenerEmpleado(
    IN IdEmpleado INT
)
BEGIN
    SELECT 
        Id,
        nombreEmpleado,
        departamentoId,
        estado,
        correo,
        salario,
        DATE_FORMAT(fechaIngreso, '%d/%m/%Y') AS fechaIngreso,
        DATE_FORMAT(fechaModificacion, '%d/%m/%Y') AS fechaModificacion
    FROM empleado
    WHERE Id = IdEmpleado;
END //

DELIMITER ;

-- Procedimiento almacenado: sp_crearEmpleado
DELIMITER //

CREATE PROCEDURE sp_crearEmpleado(
    IN NombreCompleto VARCHAR(50),
    IN DepartamentoId INT,
    IN Correo VARCHAR(50),
    IN Sueldo DECIMAL(10,2),
    IN FechaContrato VARCHAR(20)
)
BEGIN
    INSERT INTO empleado
    (
        nombreEmpleado,
        departamentoId,
        correo,
        salario,
        fechaIngreso,
        estado
    )
    VALUES
    (
        NombreCompleto,
        DepartamentoId,
        Correo,
        Sueldo,
        STR_TO_DATE(FechaContrato, '%Y-%m-%d'),
        'Activo'
    );
END //

DELIMITER ;

-- Procedimiento almacenado: sp_editarEmpleado
DELIMITER //

CREATE PROCEDURE sp_editarEmpleado(
    IN IdEmpleado INT,
    IN NombreCompleto VARCHAR(50),
    IN DepartamentoId INT,
    IN Correo VARCHAR(50),
    IN Sueldo DECIMAL(10,2),
    IN FechaContrato VARCHAR(20)
)
BEGIN
    UPDATE empleado
    SET
        nombreEmpleado = NombreCompleto,
        correo = Correo,
        salario = Sueldo,
        departamentoId = DepartamentoId,
        fechaIngreso = STR_TO_DATE(FechaContrato, '%Y-%m-%d')
    WHERE Id = IdEmpleado;
END //

DELIMITER ;

-- Procedimiento almacenado: sp_eliminarEmpleado
DELIMITER //

CREATE PROCEDURE sp_eliminarEmpleado(
    IN IdEmpleado INT
)
BEGIN
    DECLARE strEstado VARCHAR(20);
    SET strEstado = 'Eliminado';
    
    UPDATE empleado
    SET
        estado = strEstado,
        fechaModificacion = CURRENT_TIMESTAMP()
    WHERE Id = IdEmpleado;
END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE sp_listaDepartamentos()
BEGIN
    SELECT 
        Id,
        nombreDepartamento,
        estado,
        fechaCreacion,
        fechaModificacion
    FROM departamento;
END //

DELIMITER ;

INSERT INTO departamento (nombreDepartamento, estado, fechaCreacion)
VALUES ('Recursos Humanos', 'Activo', CURRENT_TIMESTAMP()),
       ('Finanzas', 'Activo', CURRENT_TIMESTAMP()),
       ('IT', 'Activo', CURRENT_TIMESTAMP());
-- Ejecutar los procedimientos almacenados para agregar empleados
CALL sp_crearEmpleado('Juan Pérez', 1, 'juan.perez@example.com', 50000, '2019-05-01');
CALL sp_crearEmpleado('María García', 2, 'maria.garcia@example.com', 60000, '2018-03-15');
CALL sp_crearEmpleado('Carlos Sánchez', 3, 'carlos.sanchez@example.com', 70000, '2017-08-20');
