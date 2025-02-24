<?php



Class Direccion {

    private string $tipo_via;
    private String $nombre_via;
    private float $numero;
    private string $localidad;
    private string $provincia;
    private string $pais;


    public function __construct(string $tv , string $nv , float $num , string $loc, string $pro, string $pa){
        $this->tipo_via = $tv;
        $this->nombre_via = $nv;
        $this->numero = $num;
        $this->localidad = $loc;
        $this->provincia = $pro;
        $this->pais = $pa;
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


    public function __toString():string{
        $cadena = "Direcion: \n";
        $cadena.= "Tipo via: " . $this->tipo_via . "\n";
        $cadena.= "Nombre via: " . $this->nombre_via . "\n";
        $cadena.= "Numero: " . $this->numero . "\n";
        $cadena.= "Localidad: " . $this->localidad . "\n";
        $cadena.= "Provincia: " . $this->provincia . "\n";
        $cadena.= "Pais: " . $this->pais . "\n";

        return $cadena;
    }








}






?>