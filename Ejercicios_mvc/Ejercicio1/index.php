<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/Ejercicios_mvc/Ejercicio1/utils/Autocarga.php");

use Ejercicio1\controlador\Controlador;
use Ejercicio1\utils\Autocarga\Autocarga;

Autocarga::registro_autocarga();


$controlador = new Controlador;
$controlador->gestiona_peticion();


?>