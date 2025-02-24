<?php

namespace Ejercicio1\controlador;

use Exception;

class Controlador {

    protected string $peticion;
    protected string $vista_error = "Ejercicio1\\vista\\V_Error";

    protected array $peticiones;

    public function __construct() {
        $this->peticiones = [
            'Main' => [
                'modelo' => 'Ejercicio1\\modelo\\M_Main',
                'vista'  => 'Ejercicio1\\vista\\V_Main',
            ],
            'Autenticar' => [
                'modelo' => 'Ejercicio1\\modelo\\M_Autenticar',
                'vista'  => 'Ejercicio1\\vista\\V_Autenticar',
            ],
            'Reseña' => [
                'modelo' => 'Ejercicio1\\modelo\\M_Reseña',
                'vista'  => 'Ejercicio1\\vista\\V_Reseña',
            ],
            'Insertar_reseña' => [
                'modelo' => 'Ejercicio1\\modelo\\M_Insertar_reseña',
                'vista'  => 'Ejercicio1\\vista\\V_Insertar_reseña',
            ],
        ];
    }

    public function gestiona_peticion() {
        try {
       
            $this->peticion = $_GET['idp'] ?? $_POST['idp'] ?? "Main";
            $this->peticion = filter_var($this->peticion, FILTER_SANITIZE_SPECIAL_CHARS);

    
            if (array_key_exists($this->peticion, $this->peticiones)) {
                $clase_modelo = $this->peticiones[$this->peticion]['modelo'];
                $clase_vista = $this->peticiones[$this->peticion]['vista'];
            } else {
                throw new Exception("La petición '{$this->peticion}' no es válida.");
            }

          
            if (!class_exists($clase_modelo)) {
                throw new Exception("Clase modelo '{$clase_modelo}' no existe.");
            }

            if (!class_exists($clase_vista)) {
                throw new Exception("Clase vista '{$clase_vista}' no existe.");
            }

        
            $modelo = new $clase_modelo();
            $datos = $modelo->despacha();

            $vista = new $clase_vista();
            $vista->genera_salida($datos);

        } catch (Exception $th) {
            $vista_error = new $this->vista_error();
            $vista_error->genera_salida($th);
            
        }
    }
}




?>