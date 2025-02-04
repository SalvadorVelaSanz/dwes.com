<?php
namespace Ejercicio2\controlador;
use Exception;

class Controlador{


    protected string $peticion;
    protected array  $peticiones;



    public function __construct(){
        $this->peticiones = [
            "Main" => ["modelo" => "Ejercicio2\\modelo\\M_Main",
                       "vista" => "Ejercicio2\\vista\\V_Main"],

            "Autenticar" => ["modelo" => "Ejercicio2\\modelo\\M_Autenticar",
                       "vista" => "Ejercicio2\\vista\\V_Autenticar"],

            "Reseña" => ["modelo" => "Ejercicio2\\modelo\\M_Reseña",
                       "vista" => "Ejercicio2\\vista\\V_Reseña"],
        ];
    }

    public function gestiona_peticion(){

        try {
            $peticion = $_GET['idp'] ?? $_POST['idp'] ?? "Main";
            $this->peticion = filter_var($peticion , FILTER_SANITIZE_SPECIAL_CHARS);

            if (array_key_exists($this->peticion , $this->peticiones)) {
                $clase_modelo = $this->peticiones[$this->peticion]['modelo'];
                $clase_vista = $this->peticiones[$this->peticion]['vista'];
            }

            if (!class_exists($clase_modelo)) {
                throw new Exception("Error Processing Request", 1);
            }

            if (!class_exists($clase_vista)) {
                throw new Exception("Error Processing Request", 1);
            }

            $modelo = new $clase_modelo();
            $datos = $modelo->despacha();

            $vista = new $clase_vista();
            $vista->genera_salida($datos);

        } catch (Exception $th) {
            throw $th;
        }


    }








}















?>