<?php

Class Componente{


    private string $tipo;
    private string $descripcion;
    private float $precio;

    private const TIPOS_PERMITIDOS = ["PLACA" , "MICRO" , "RAM" , "HD"];

    public function __construct(string $ti , string $des, float $pre){
        $this->setTipo($ti);
        $this->descripcion = $des;
        $this->precio = $pre;
    }

    public function setTipo(string $tipo){
        if (in_array($tipo , self::TIPOS_PERMITIDOS)) {
            $this->tipo = $tipo;
        }else{
            throw new Exception("Error, tipo no permitido", 1);
            
        }
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
            if ($propiedad =="tipo") {
                $this->setTipo($valor);
            }else{
                $this->$propiedad = $valor;
            }
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

    public function __toString():string{
        $cadena = "Componente: \n";
        $cadena.= "Tipo: " . $this->tipo . "\n";
        $cadena.= "Descripcion: " . $this->descripcion . "\n";
        $cadena.= "Precio" . $this->precio . "\n";
       
        return $cadena;
    }


}







?>