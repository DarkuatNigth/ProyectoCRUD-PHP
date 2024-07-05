export interface Empleado 
{
    Id: number,
	nombreCompleto:string,
	departamentoId:number,
	estado:string,
	correo:string,
	salario:number,
    fechaIngreso:Date,
    fechaModificacion:Date | null
}