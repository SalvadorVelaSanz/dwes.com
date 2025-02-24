<?php

require_once("Alumno.php");
require_once("DatosFormacion.php");

class Socio extends Alumno implements DatosFormacion{

private int $login;
private string $clave;
private string $disponibilidad;

private const tipos_disponibilidad = ["mañana" , "tarde"];


public function __construct(string $no , string $ape , string $em , DateTime $fecha , ActividadFormacion $act, int $log , string $cla , string $dis ){
    parent::__construct($no , $ape , $em ,$fecha , $act);
    $this->login = $log;
    $this->clave = $cla;
    $this->setDisponibilidad($dis);
}

public function setDisponibilidad(string $dis) :void{
    if (in_array($dis , self::tipos_disponibilidad)) {
        $this->disponibilidad = $dis;
    } else {
       throw new Exception("Error, disponibilidad mal introducida", 1);
       
    }
    
}

public function __set(string $propiedad, mixed $valor): void{
    if ($propiedad == "disponibilidad") {
        $this->setDisponibilidad($valor);
    } else {
        parent::__set($propiedad , $valor);
    }
    
}

public function calcularAntiguedad(): string {
    $fechaActual = new DateTime(); 
    $diferencia = $this->fecha_inscripcion->diff($fechaActual); 
    // return "Antigüedad: " . $diferencia->y . " años, " . $diferencia->m . " meses y " . $diferencia->d . " días.";
    return $diferencia->y;
}
public function __toString() :string{
    $cadena = parent::__toString() . __CLASS__ ."tiene estas propiedades:\n"; 
    $cadena.= "login: ". $this->login ."\n";
    $cadena.= "clave: ". $this->clave."\n";
    $cadena.= "disponibilidad: ". $this->disponibilidad ."\n";
    return $cadena;
}


public function obtenerPrecio() :float{
    $precio =0;
    $precio_presencial = $this->actividad_formacion->horas_presenciales;
    $precio_online = $this->actividad_formacion->horas_online;

   $años_diferencia = $this->calcularAntiguedad();
   
   if ($precio_presencial == null) {
        $precio_presencial = 0;
   }

   if ($precio_online == null ) {
        $precio_online = 0; 
   }

   if($años_diferencia <= 3) {
        $precio = ($precio_presencial + $precio_online) * 20 ; 
    }elseif ($años_diferencia > 3 && $años_diferencia <= 6) {
        $precio = ($precio_presencial + $precio_online) * 10 ;     
    }elseif ($años_diferencia > 6 ) {
        $precio = $precio_presencial * 5 ;  
    }
   
    return $precio;
}

public function asignarHorario() :string{

    $horas_presenciales = $this->actividad_formacion->horas_presenciales;
    $horas_online = $this->actividad_formacion->horas_online; 

    if ( $horas_presenciales !== null) {
        if ($this->disponibilidad == "mañana") {
            if ($horas_presenciales >= 100 && $horas_presenciales <= 200) {
                $cadena_presencial = "De lunes a viernes de 9:00 a 13:00";
            }elseif ($horas_presenciales < 100) {
                $cadena_presencial = "De lunes a viernes de 9:00 a 11:00";            
            }           
        }else{
            if ($horas_presenciales >= 100 && $horas_presenciales <= 200) {
                $cadena_presencial = "De lunes a viernes de 16:00 a 20:00";
            }elseif ($horas_presenciales < 100) {
                $cadena_presencial = "De lunes a viernes de 16:00 a 18:00";            
            }  
        }
    }else{
        $cadena_presencial = "No tienes asignadas horas presenciales";
    }

    if ($horas_online !== null) {
        if ($horas_online >= 50 && $horas_online <= 100) {
            $cadena_online = "De sabados a domingos de 9:00 a 12:00";
        }else{
            $cadena_online = "De sabados a domingos de 8:00 a 10:00";
        }
    }else{
        $cadena_online = "NO tienes asignadas horas online";
    }
        
    $cadena = "Horario para las horas presenciales : $cadena_presencial\n";
    $cadena.= "Horario para las horas online : $cadena_online";
    return $cadena;
}
}

?>