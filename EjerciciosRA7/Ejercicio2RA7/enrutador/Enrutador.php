<?php

// RewriteEngine On


// RewriteCond %{DOCUMENT_ROOT}%{REQUEST_FILENAME} !-f
// RewriteCond %{DOCUMENT_ROOT}%{REQUEST_FILENAME} !-d

// RewriteRule ^.*$ /EjerciciosRA7/Ejercicio2RA7/index.php [QSA,L]


namespace Ejercicio2RA7\enrutador;

use Ejercicio2RA7\enrutador\Ruta;
use Ejercicio2RA7\modelo\RestOrmCliente;
use Exception;

class Enrutador{

    protected array $rutas = [];

    public function __construct(){
        $this->rutas[] = new Ruta("GET" , "#^/clientes$#" , RestOrmCliente::class , "getAll");
        $this->rutas[] = new Ruta("GET" , "#^/clientes/(\w+)$#" , RestOrmCliente::class , "getCliente");
        $this->rutas[] = new Ruta("GET" , "#^/pedidos/(\w+)$#" , RestOrmCliente::class , "getPedidosCliente");
        $this->rutas[] = new Ruta("POST" , "#^/clientes$#" , RestOrmCliente::class , "insertCliente");
        $this->rutas[] = new Ruta("PUT" , "#^/clientes/(\w+)$#" , RestOrmCliente::class , "updateCliente");
        $this->rutas[] = new Ruta("PATCH" , "#^/clientes/(\w+)$#" , RestOrmCliente::class , "updateCliente");
        $this->rutas[] = new Ruta("DELETE" , "#^/clientes/(\w+)$#" , RestOrmCliente::class , "deleteCliente");
    }

    public function despacha(){
        try {
            $verbo = $this->obtenerVerbo();

            $path = $this->obtenerPath();
    
            $ruta = $this->buscarRuta($verbo , $path);
    
            $datos = $this->ejecutaRuta($ruta , $path);
    
            if ($datos['exito']) {
                header($_SERVER['SERVER_PROTOCOL'] . "" . $datos['codigo']);
                header("Content-Type: application/json");
                echo json_encode($datos , JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }else{
                $this->gestionaError($datos);
            }
        } catch (Exception $th) {
            $this->gestionaError($th);
        }

       

    }

    public function obtenerVerbo(){
        $verbo = filter_input(INPUT_SERVER , "REQUEST_METHOD" , FILTER_SANITIZE_SPECIAL_CHARS);
        return $verbo;


    }


    public function obtenerPath(){
        $url = filter_input(INPUT_SERVER , "REQUEST_URI" , FILTER_SANITIZE_SPECIAL_CHARS);
        $url = parse_url($url , PHP_URL_PATH);
     // $url = preg_replace("#/EjerciciosRA7/Ejercicio2RA7/index\.php#", "" , $url);
        return $url;
    }

    public function buscarRuta($verbo , $path){
        foreach ($this->rutas as $ruta ) {
            if ($ruta->esIgual($verbo , $path)) {
                return $ruta;
            }
        }
    }

    public function ejecutaRuta(Ruta $ruta , $path_peticion){

        $clase_modelo = $ruta->getClase();

        $metodo = $ruta->getFuncion();

        $parametros = $this->obtenerParametros($ruta->getPath() , $path_peticion);
        $instacia_modelo = new $clase_modelo();

        $datos = call_user_func_array([$instacia_modelo, $metodo] ,$parametros);

        return $datos;

    }

    public function obtenerParametros($preg_match , $ruta_peticion){
        if (preg_match($preg_match , $ruta_peticion , $parametros)) {
            array_shift($parametros);
            return $parametros;
        }else{
            return [];
        }
    }

    public function gestionaError($error){
        if( $error instanceof Exception ) {
            header($_SERVER['SERVER_PROTOCOL'] . " " . $error->getCode() . " " . $error->getMessage() );
            header("Content-Type: application/json");
            echo json_encode($error);

        }
        else {
            header($_SERVER['SERVER_PROTOCOL'] . " " . $error['codigo']);
            header("Content-Type: application/json");
            echo json_encode($error);
        }
    }

}






?>