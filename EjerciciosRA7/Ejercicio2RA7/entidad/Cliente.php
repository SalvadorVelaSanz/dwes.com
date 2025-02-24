<?php

namespace Ejercicio2RA7\entidad;

use DateTime;
use Exception;
use JsonSerializable;
use ReflectionProperty;


class Cliente implements JsonSerializable {

    protected ?string $nif;
    protected ?string $nombre;
    protected ?string $apellidos;
    protected ?string $clave;
    protected ?string $iban;
    protected ?string $telefono;
    protected ?string $email;    
    protected ?float $ventas;

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

    public function __set($propiedad, $valor){
        if (property_exists($this, $propiedad)) {
            $reflexion = new ReflectionProperty($this , $propiedad);
            $tipo = $reflexion->getType()->getName();
            if ($tipo === DateTime::class && $valor) {
                if ($valor instanceof DateTime) {
                    $this->$propiedad = $valor;
                }elseif (gettype($tipo) == "String") {
                    $this->$propiedad = new DateTime($valor);
                }
            }else{
                $this->$propiedad = $valor;
            }
        }else{
            throw new Exception("Error, la propiedad no existe", 1);
            
        }
    }

    public function toArray(){
        $propiedades = get_object_vars($this);

        foreach ($propiedades as $propiedad => $valor) {
            if ($valor instanceof DateTime) {
                $propiedades[$propiedad] = $valor->format("Y-m-d H:i:s");
            }else{
                $propiedades[$propiedad] = $valor;
            }
        }
        return $propiedades;
    }

    public function jsonSerialize():array{
        $objeto_json = [];

        foreach ($this as $propiedad => $valor) {
            $reflexion = new ReflectionProperty($this , $propiedad);
            $tipo = $reflexion->getType()->getName();

            if ($tipo == DateTime::class) {
                $objeto_json[$propiedad] = $valor->format("Y-m-d H:i:s");
            }else{
                $objeto_json[$propiedad] = $valor;
            } 
        }
        return $objeto_json;
    }

}







?>