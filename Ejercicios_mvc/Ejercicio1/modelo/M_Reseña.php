<?php


namespace Ejercicio1\modelo;
use Ejercicio1\modelo\Modelo;
use Ejercicio1\modelo\orm\Clases\Mvc_Orm_reseña;
use Ejercicio1\utils\seguridad\JWT;
session_start();

class M_Reseña implements Modelo{

    public function despacha() {

      if ( !isset($_COOKIE['jwt']) ) {
          header("Location: /Ejercicios_mvc/Ejercicio1/index.php");
          exit(3);
      }
      
      $jwt = $_COOKIE['jwt'];
 
      $payload = JWT::verificar_token($jwt);
      if ( !$payload ) {
        header("Location: /Ejercicios_mvc/Ejercicio1/index.php");
        exit(3);
      }

      $referencia = filter_input(INPUT_POST , "referencia" , FILTER_SANITIZE_SPECIAL_CHARS);
      $_SESSION['referencia'] = $referencia;
    

      $orm_reseña = new Mvc_Orm_reseña();
      $reseñas = $orm_reseña->obtener_reseñas($referencia , $payload['nif']);
      
      if ($reseñas) {
        return $reseñas;
      }else{
        return 1;
      }

   

    }


} 
















?>