<?php

namespace Ejercicio1RA7\Entidad;
use DateTime;
use JsonSerializable;
use Reflection;
use ReflectionProperty;

class Pedido implements JsonSerializable {
    protected int $npedido;
    protected string $nif;
    protected DateTime $fecha;
    protected ?string $observaciones;
    protected ?float $total_pedido;

    public function __construct(array $datos){
        foreach ($datos as $propiedad => $valor) {
            $this->__set($propiedad, $valor);
        }
    }

    public function __get($propiedad){
        if (property_exists($this, $propiedad)) {
            return $this->$propiedad;
        }else{
            return null;
        }
    }


    public function __set($propiedad, $valor){
        if (property_exists($this, $propiedad)) {
            $reflexion = new ReflectionProperty($this , $propiedad);
            $tipo = $reflexion->getType()->getName();
            if ($tipo == DateTime::class && $valor) {
                if ($valor instanceof DateTime) {
                    $this->$propiedad = $valor;
                }elseif (gettype($valor) === "string") {
                    $this->$propiedad = new DateTime($valor);
                }
                
            }else{
                $this->$propiedad = $valor;
            }
        }
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