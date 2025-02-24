<?php
namespace Ejercicio1\Entidad;
use Exception;


class Cliente{

    protected string $nif;
    protected string $nombre;
    protected string $apellidos;
    protected string $clave;
    protected int $iban;
    protected ?string $telefono;
    protected string $email;
    protected ?string $ventas;


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
        if (property_exists($this , $propiedad)) {
            $this->$propiedad = $valor;
        }else {
            throw new Exception("Error en el setter , la propiedad no existe", 1);
        }
    }

    public function toArray(){
        return get_object_vars($this);
    }

    public function jsonSerialize(){
        $objeto_json = [];

        foreach ($this as $propiedad => $valor) {
            $objeto_json[$propiedad] = $valor;
        }
        return $objeto_json;
    }



}








?>