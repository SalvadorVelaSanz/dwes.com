<?php

require_once("Alumno.php");
require_once("DatosFormacion.php");
class Inscrito extends Alumno implements DatosFormacion{

    private int $numero;

    public function __construct(string $no , string $ape , string $em , DateTime $fecha , ActividadFormacion $act,int $num) {
        parent::__construct($no , $ape , $em ,$fecha , $act);
        $this->numero = $num;
    }


    public function __toString() :string{
        $cadena = parent::__toString() . __CLASS__ ."tiene estas propiedades:\n"; 
        $cadena.= "numero: ". $this->numero;
        return $cadena;
    }

    public function obtenerPrecio() :float{
        $precio = ($this->actividad_formacion->horas_presenciales * 50) + ($this->actividad_formacion->horas_online * 30);
        return $precio;
    }

    public function asignarHorario() :string{
        $nivel = $this->actividad_formacion->nivel;
        $horas_presenciales = $this->actividad_formacion->horas_presenciales;
        $horas_online = $this->actividad_formacion->horas_online; 

        if ($horas_presenciales !== null) {
            if ($nivel = "A" || $nivel == "B") {
                $cadena_presencial ="De lunes a sabado de 9:00 a 12:00";
            }else{
                $cadena_presencial ="De lunes a viernes de 10:00 a 14:00 y de 16:00 a 20:00";
            }
        }else{
            $cadena_presencial ="No tienes horas presenciales asignadas";
        }
      
        if ($horas_online !== null) {

            if ($nivel == "A") {
              $cadena_online ="De lunes a sabado de 9:00 a 12:00";
            }else{
                $cadena_online ="De lunes a sabado de 16:00 a 19:00";
            }
        }

        $cadena = "Horario para las horas presenciales : $horas_presenciales\n";
        $cadena.= "Horario para las horas online : $horas_online";
        return $cadena;
    }

}




?>