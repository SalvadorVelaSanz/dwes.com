<?php

require_once("ActividadFormacion.php");

abstract class Alumno {

    private string $nombre;
    private string $apellidos;
    private string $email;
    private DateTime $fecha_inscripcion;
    private ActividadFormacion $actividad_formacion;


    public function __construct(string $no , string $ape , string $em , DateTime $fecha , ActividadFormacion $act ){
        
        $this->nombre = $no;
        $this->apellidos = $ape;
        $this->email = $em;
        $this->fecha_inscripcion = $fecha;
        $this->actividad_formacion = $act;
    }



    public function __get(string $propiedad): mixed{

        if (property_exists($this ,$propiedad)) {
            return $this->$propiedad;
        }else{
            echo "LA propiedad $propiedad no existe en la clase" . __CLASS__;
            return null;
        }
    }
    
    public function __set( string $propiedad,  mixed $valor) : void{
        
        if (property_exists($this ,$propiedad)) {
                $this->$propiedad = $valor;
        }else{
            echo "LA propiedad $propiedad no existe en la clase" . __CLASS__;
        }
    }
    
    public function __clone() :void{
        $this->actividad_formacion = clone $this->actividad_formacion;
    }

    public function __toString() :string {
        // Construir una representación legible de la clase
        $cadena = "Alumno: \n";
        $cadena .= "Nombre: {$this->nombre}\n";
        $cadena .= "Apellidos: {$this->apellidos}\n";
        $cadena .= "Email: {$this->email}\n";
        $cadena .= "Fecha de inscripción: " . $this->fecha_inscripcion->format('Y-m-d') . "\n";
        $cadena .= "Actividad de formación: {$this->actividad_formacion}\n";
        return $cadena;
    
    }




}






?>