<?php

use Ejercicio2\controlador\Controlador;
use Ejercicio2\utils\Autocarga\Autocarga;

require_once($_SERVER['DOCUMENT_ROOT'] . "/Ejercicios_mvc/Ejercicio2/utils/Autocarga.php");


Autocarga::registro_autocarga();

session_start();

$controlador = new Controlador();
$controlador->gestiona_peticion(); 




?>