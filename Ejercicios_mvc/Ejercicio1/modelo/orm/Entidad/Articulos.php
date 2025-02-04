<?php
namespace Ejercicio1\modelo\orm\Entidad;

use Exception;
use DateTime;
use ReflectionProperty;
use DateTimeZone;





class Articulos{

    protected string $referencia;
    protected string $descripcion;
    protected float $pvp;
    protected ?float $dto_venta;
    protected ?float $und_vendidas;
    protected ?float $und_disponibles;
    protected ?DateTime $fecha;
    protected string $categoria;
    protected ?string $tipo_iva;


    public function __construct($datos){
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
        if (property_exists($this , $propiedad)) {
            $nombre_tipo = $this->tipoPropiedad($this ,$propiedad);

            if ($nombre_tipo == DateTime::class && $valor) {
                
                if ($valor instanceof DateTime) {
                    $this->$propiedad =$valor;
                }else{
                    $this->$propiedad = new DateTime($valor, new DateTimeZone("Europe/Madrid"));
                }


            }else{
                $this->$propiedad =$valor;
            }
            
        }else{
            throw new Exception("Error la propiedad $propiedad no existe", 1);
            
        }

    }



    public function toArray(){
        return get_object_vars($this);
    }



    public static function tipoPropiedad($objeto, $propiedad) {
        $info_propiedad = new ReflectionProperty($objeto, $propiedad);
        $tipo_propiedad = $info_propiedad->getType();
        $nombre_tipo = $tipo_propiedad->getName();
        return $nombre_tipo;
    }




}









?>