<?php

namespace Ejercicio1\modelo;

use Ejercicio1\modelo\Modelo;
use Ejercicio1\modelo\orm\Clases\Mvc_Orm_autenticar;
use Ejercicio1\utils\seguridad\JWT;
use Exception;
session_start();
class M_Autenticar implements Modelo
{

    public function despacha()
    {

        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        $clave = $_POST['clave'];

        if (!isset($_COOKIE['jwt'])) {



            try {
               
            $orm_autenticar = new Mvc_Orm_autenticar();
            $cliente = $orm_autenticar->obtener_cliente($email);

            if (password_verify($clave, $cliente['clave'])) {
                $payload = [
                    'nombre' => $cliente['nombre'],
                    'nif' => $cliente['nif'],
                    'correo' => $email,
                    'apellidos' => $cliente['apellidos']
                ];

                $jwt = JWT::generar_token($payload);

                $_SESSION['cliente'] = "Bienvenido " . $cliente['nombre'] . " " . $cliente['apellidos'];

                setcookie("jwt", $jwt, time() + 30 * 60);

                $articulos = [];
                $articulos = $orm_autenticar->obtener_articulos($cliente['nif']);

                return $articulos;
            }else{
                throw new Exception("Error en la auntentificacion", 1);
                
            }

            } catch (Exception $th) {
                return "Error";
            }
        }
    }
}
