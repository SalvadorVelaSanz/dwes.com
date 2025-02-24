<?php

require_once("Componente.php");

Class PC {

    private int $numero_serie;
    private string $descripcion;
    private float $tiempo_construccion;
    private array $componentes = [];

    public function __construct(int $num , string $des , float $tie, array $com){
        $this->numero_serie = $num;
        $this->descripcion = $des;
        $this->tiempo_construccion =$tie;

        foreach ($com as $componente) {
            if (!$componente instanceof Componente) {
                throw new Exception("Error, solo pueden ser componentes", 1);
            }
        }
        $this->componentes = $com;
        
    }

    public function __get($propiedad) :mixed{
        
        if (property_exists(self::class , $propiedad)) {
            return $this->$propiedad;
        }else{
            echo "LA propiedad $propiedad no existe en la clase" . __CLASS__;
            return null;
        }
    }

    public function __set($propiedad, $valor) :void{
        if (property_exists(self::class , $propiedad)) {
                $this->$propiedad = $valor;
        }else {
            echo "LA propiedad $propiedad no existe en la clase" . __CLASS__;
        }
        
    }

    public function __isset($propiedad){
        if (property_exists(self::class, $propiedad)) {
            return isset($this->$propiedad);
        }else{
            echo "LA propiedad $propiedad no existe en la clase" . __CLASS__;
        }
    }

    public function __unsset($propiedad){
        if (property_exists(self::class, $propiedad)) {
             unset($this->$propiedad);
        }else{
            echo "LA propiedad $propiedad no existe en la clase" . __CLASS__;
        }
    }

    public function __clone(){
        $this->componentes = clone $this->componentes;
    }
    public function __toString():string{
        $cadena = "PC: \n";
        $cadena.= "NUmero de serie: " . $this->numero_serie . "\n";
        $cadena.= "Descripcion: " . $this->descripcion . "\n";
        $cadena.= "Tiempo de construccion" . $this->tiempo_construccion . "\n";
        $array = $this->componentes;
        foreach ($array as $componente) {
            $cadena.= "" . $componente. "\n";
        }

       
        return $cadena;
    }


}






?>