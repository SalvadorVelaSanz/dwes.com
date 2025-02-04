<?php
namespace Ejercicio1\modelo;

use Ejercicio1\modelo\Modelo;

class M_Main implements Modelo{


    public function despacha(){
        
        if (isset($_COOKIE['jwt']) ) {
            $this->cerrar_session();
            setcookie("jwt", '', time() - 60);
        }else{
            session_start();
        }

        return true;
        
       

    }

    private function cerrar_session(){   
        $nombre_id = session_name();
        $parametros_cookie = session_get_cookie_params();
        setcookie($nombre_id, '', time() - 10000,
            $parametros_cookie['path'], $parametros_cookie['domain'],
            $parametros_cookie['secure'], $parametros_cookie['httponly']
        );

        session_unset();

        session_destroy();

        session_start();
    } 



}







?>