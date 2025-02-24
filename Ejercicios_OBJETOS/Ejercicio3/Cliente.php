<?php

require_once("Direccion.php");

Class Cliente{


    private string $email;
    private string $nombre_completo;
    private Direccion $direccion;

    public function __construct(string $em , string $no, Direccion $dir){
        $this->email = $em;
        $this->nombre_completo = $no;
        $this->direccion = $dir;
        
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
        $this->direccion = clone $this->direccion;;
    }

    public function __toString():string{
        $cadena = "Cliente: \n";
        $cadena.= "Email: " . $this->email . "\n";
        $cadena.= "Nombre completo: " . $this->nombre_completo . "\n";
        $cadena.= "" . $this->direccion . "\n";
       
        return $cadena;
    }







}





?>