<?php

namespace Ejercicio1\modelo\orm\Entidad;

use ReflectionProperty;
use DateTime;
use DateTimeZone;
use Exception;
class Reseña {

    protected ?int $id_reseña;
    protected ?string $nif;
    protected ?string $referencia;
    protected Datetime $fecha;
    protected int $clasificacion;
    protected ?string $comentario;


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