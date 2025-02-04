<?php


namespace Ejercicio4\modelo; 
use Ejercicio4\entidad\proveedor;

class ORMproveedor extends ORMbase{

    protected string $tabla = "proveedor";
    protected string $clave_primaria = "nif";

    public function getClaseEntidad(){
         return proveedor::class;
    }


}








?>