<?php

namespace Ejercicio1\modelo;

use DateTime;
use Ejercicio1\modelo\orm\Clases\Mvc_Orm_reseña;
use Ejercicio1\modelo\orm\Entidad\Reseña;
use Ejercicio1\utils\seguridad\JWT;

session_start();

class M_Insertar_reseña implements Modelo{

    public function despacha(){
        if ( !isset($_COOKIE['jwt']) ) {
            header("Location: /Ejercicios_mvc/Ejercicio1/index.php?idp=Main");
            exit(3);
        }
        
        $jwt = $_COOKIE['jwt'];
        $payload = JWT::verificar_token($jwt);
        
        if ( !$payload ) {
     
            header("Location: /Ejercicios_mvc/Ejercicio1/index.php?idp=Main");
            exit(3);
        }

        $clasificacion =  filter_input(INPUT_POST ,"clasificacion", FILTER_VALIDATE_INT);

        $opciones = array(
            'options' => array(
                'default' => 0, 
                'min_range' => 0,
                'max-range' => 5
            ),
            'flags' => FILTER_FLAG_ALLOW_OCTAL,
        );

        $clasificacion = filter_var($clasificacion , FILTER_VALIDATE_INT , $opciones);
        $comentario = filter_input(INPUT_POST , "comentario" , FILTER_SANITIZE_SPECIAL_CHARS);
        $nif = $payload['nif'];
        $fecha = new DateTime();
        $fecha = $fecha->format("Y-m-d H:m:s");
        $referencia = $_SESSION['referencia'];

        $reseña = new Reseña([
           "id_reseña" => null,
           "nif" => $nif,
           "referencia" => $referencia,
           "fecha" => $fecha, 
           "clasificacion" => $clasificacion,
           "comentario" => $comentario
        ]);

        $orm_reseña = new Mvc_Orm_reseña();
        $reseña_insertada = $orm_reseña->insertar_reseñas($reseña);

        if ($reseña_insertada) {
            return $reseña;
        }else{
            return false;
        }






    }

}











?>