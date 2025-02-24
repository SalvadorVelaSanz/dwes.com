<?php


namespace Ejercicio1RA7\Entidad;

use DateTime;
use Exception;
use JsonSerializable;
use Reflection;
use ReflectionProperty;

class Articulo implements \JsonSerializable{

    protected string $referencia;
    protected string $descripcion;
    protected float $pvp;
    protected ?float $dto_venta;
    protected ?float $und_vendidas;
    protected ?float $und_disponibles;
    protected ?DateTime $fecha_disponible;
    protected string $categoria;
    protected ?string $tipo_iva;



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

    public function __set(string $propiedad, mixed $valor): void {
        if( property_exists($this, $propiedad) ) {
            $reflexion = new ReflectionProperty($this, $propiedad);
            $tipo_propiedad = $reflexion->getType();
            $nombre_tipo = $tipo_propiedad->getName();
            if( $nombre_tipo == DateTime::class ) {
                if( $valor instanceof DateTime ) {
                    $this->$propiedad = $valor;
                }
                elseif( gettype($valor) == "string") {
                    $this->$propiedad = new DateTime($valor);
                }
            }
            else {
                $this->$propiedad = $valor;
            }
        }
    }

    public function toArray(){
        $propiedades = get_object_vars($this);
        foreach ($propiedades as $propiedad => $valor) {
            if ($valor instanceof DateTime) {
               $propiedades[$propiedad] = $valor->format("Y-m-d H:m:s");
            }
        }
        return $propiedades;
    }

    public function jsonSerialize() : array{
        $objeto_json = [];
        foreach ($this as $propiedad => $valor) {
            $reflexion = new ReflectionProperty($this , $propiedad);
            $tipo  = $reflexion->getType()->getName();

            if ($tipo == DateTime::class) {
                $objeto_json[$propiedad] = $valor->format("Y-m-d H:m:s");
            }else{
                $objeto_json[$propiedad] = $valor;
            }
        }
        return $objeto_json;
    }
   

}














?>