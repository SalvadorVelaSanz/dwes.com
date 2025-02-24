<?php 

class ActividadFormacion {

private int $codigo;
private string $titulo;
private ?int $horas_presenciales;
private ?int $horas_online;
private ?int $horas_no_presenciales;
private string $nivel;

private const MAX_HORAS_P = 200;
private const MAX_HORAS_0 = 100;
private const niveles_permitidos = ["A","B","C"];


public function __construct(int $co , string $tit , ?int $hp , ?int $ho , ?int $hnp , string $ni){
    $this->codigo = $co;
    $this->titulo = $tit;
    $this->sethorasP($hp);
    $this->sethorasO($ho);
    $this->horas_no_presenciales = $hnp;
    $this->setNivel($ni);
}

public function sethorasP(int $hp) : void{
    if ($hp <= self::MAX_HORAS_P) {
        $this->horas_presenciales = $hp;
    }else {
        throw new Exception("Error, las horas maximas presenciales son 200  ", 1);
        
    }

}


public function sethorasO(int $ho) : void{
    if ($ho <= self::MAX_HORAS_0) {
        $this->horas_online = $ho;
    }else {
        throw new Exception("Error, las horas maximas online son 100  ", 1);
        
    }

}

public function setNivel(String $ni) : void {

    if (in_array($ni , self::niveles_permitidos)) {
        $this->nivel = strtoupper($ni);
    }else{
        throw new Exception("Error, Nivel no reconocido ", 1);
    }

}

public function __get(string $propiedad): mixed{

    if (property_exists(self::class ,$propiedad)) {
        return $this->$propiedad;
    }else{
        echo "LA propiedad $propiedad no existe en la clase" . __CLASS__;
        return null;
    }
}

public function __set( string $propiedad,  mixed $valor) : void{
    
    if (property_exists(self::class ,$propiedad)) {
        if ($propiedad == "horas_presenciales") {
            $this->sethorasP($valor);
        }elseif ($propiedad == "horas_online") {
            $this->sethorasO($valor);   
        }elseif ($propiedad == "nivel") {
            $this->setNivel($valor);
        }else{
            $this->$propiedad = $valor;
        }
    }else{
        echo "LA propiedad $propiedad no existe en la clase" . __CLASS__;
    }
}

public function __toString() :string{

    $cadena = "Clase " . __CLASS__ . " con sus valores: Código: " . $this->codigo .
    ", Título: " . $this->titulo .
    ", Horas Presenciales: " . ($this->horas_presenciales ?? "No definido") .
    ", Horas Online: " . ($this->horas_online ?? "No definido") .
    ", Horas No Presenciales: " . ($this->horas_no_presenciales ?? "No definido") .
    ", Nivel: " . $this->nivel;

return $cadena;
}


}
?>