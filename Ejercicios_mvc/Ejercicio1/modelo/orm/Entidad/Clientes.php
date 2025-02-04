<?php

namespace Ejercicio1\modelo\orm\Entidad;

use Exception;



class Clientes {

    protected string $nif;
    protected string $nombre;
    protected string $apellidos;
    protected string $clave;
    protected float $iban;
    protected ?int $telefono;
    protected string $email;
    protected ?float $ventas;


    public function __construct(array $datos){
        foreach ($datos as $propiedad => $valor) {
            $this->__set($propiedad,$valor);
        }
    }


    public function __get($propiedad){
        if (property_exists($this , $propiedad)) {
            return $this->$propiedad;
        }else{
            return null;
        }
    }

    public function __set($propiedad, $valor){
        if (property_exists($this , $propiedad)) {
            $this->$propiedad = $valor;
        }else{
            throw new Exception("Error Processing Request", 1);
        }
    }


    public function toArray(){
        return get_object_vars($this);
    }
}








?>