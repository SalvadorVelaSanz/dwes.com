<?php

namespace Ejercicio4\entidad;

use ReflectionProperty;

class entidad{

    public function __construct( array $datos){
        foreach ($datos as $propiedad => $valor) {
            $this->__set($propiedad ,$valor);
        }
    }

    public function __get($propiedad) :mixed{
        if (property_exists($this ,$propiedad)) {
            return $this->$propiedad;
        }else{
            return "La propiedad $propiedad , no existe en $this";
        }
    }

    public function __set($propiedad ,$valor){
        if (property_exists($this , $propiedad)) {
            $this->$propiedad = $valor;
        }
    }

    public function toArray(){
        return get_object_vars($this);
    }

    public function __toString() :string{
        $cadena ="Clase: " . self::class . "<br>";
        foreach ($this as $propiedad => $valor) {
            $cadena.= "$propiedad = $valor <br>"; 
        }
       
        return $cadena;
    }
}



?>