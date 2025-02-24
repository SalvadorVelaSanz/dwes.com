<?php

namespace Ejercicio1RA7\Entidad;

use JsonSerializable;
use Exception;

class Forma_envio implements JsonSerializable {

    protected string $id_fe;
    protected string $descripcion;
    protected string $telefono;
    protected string $contacto;
    protected string $email;
    protected float $coste;

    public function __construct(array $datos){
        foreach ($datos as $propiedad => $valor) {
            $this->__set($propiedad , $valor);
        }
    }

    public function __get($propiedad){
        if (property_exists($this , $propiedad)) {
            return $this->$propiedad;
        }else{
            return null;
        }
    }

    public function __set($propiedad , $valor){
        if (property_exists($this , $propiedad)) {
             $this->$propiedad = $valor;
        }else{
            throw new Exception("La propiedad no existe", 1);
            
        }
    }


    public function jsonSerialize(): array{
        $objeto_json = [];
        foreach ($this as $propiedad => $valor) {
            $objeto_json[$propiedad] = $valor;
        }
        return $objeto_json;
        
    }





}













?>