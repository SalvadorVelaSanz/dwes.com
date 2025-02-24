<?php

namespace Ejercicio1RA7\controlador;
use Exception;

class JsonRpcControlador {

  private string $espacio_de_nombres_modelo = "Ejercicio1RA7\\modelo\\";
  
      public function manejar_peticion(){
          $cuerpo = file_get_contents("php://input");
  
          $peticion = json_decode($cuerpo , true);
  
          if (!$this->esPeticionValida($peticion)) {
              $this->enviarRespuesta(null ,null, ["code" => -32600 , "message" => "invalid request"]);
              return;
          }
  
          $id = $peticion["id"] ?? null;
  
          try {
              [$modelo, $metodo] = $this->obtenerMetodo($peticion["method"]);
  
              $clase_modelo = $this->espacio_de_nombres_modelo . $modelo;
  
              if (class_exists($clase_modelo) && method_exists($clase_modelo , $metodo)) {
                  $instancia_modelo = new $clase_modelo();
  
                  $parametros = $peticion['params'] ?? [];
  
                  $resultado = call_user_func_array([$instancia_modelo , $metodo] , $parametros);
  
                  $this->enviarRespuesta($id , $resultado , null);
  
  
  
              }else{
                  $this->enviarRespuesta(null ,null, ["code" => -32600 , "message" => "Method not found"]);
              }
          } catch (\Exception $th) {
              $this->enviarRespuesta(null ,null, ["code" => -32600 , "message" => "internal error" , "data" => $th->getMessage()]);
          }
  
  
  
  
  
  
  
  
      }
  
      public function esPeticionValida($peticion){
          return isset($peticion["jsonrpc"] , $peticion["method"]) && $peticion["jsonrpc"] === "2.0";
      }
  
  
      public function obtenerMetodo($metodo){
          if (!strpos($metodo , ".")) {
              throw new Exception("Error el formato no es correcto, deber ser Clase.Modelo", 1);
          }
  
          return explode("." , $metodo);
      }
  
      public function enviarRespuesta($id , $resultado , $error) {
  
          $respuesta["jsonrpc"] = "2.0";
  
          if ($resultado) {
              $respuesta["result"] = $resultado;
          }
          
          if ($error) {
              $respuesta["error"] = $error;
          }
  
          $respuesta['id'] = $id;
  
        
          $respuesta_json =  json_encode($respuesta , JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
          header("Content-Type: application/json");
          echo $respuesta_json;
  
  
      }
  
  }
  
  
  
?>