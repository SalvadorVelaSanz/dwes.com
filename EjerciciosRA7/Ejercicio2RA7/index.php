<?php
$hola = "hola";
require_once($_SERVER["DOCUMENT_ROOT"] . "/EjerciciosRA7/Ejercicio2RA7/util/Autocarga.php");

use Ejercicio2RA7\util\Autocarga;
use Ejercicio2RA7\enrutador\Enrutador;
Autocarga::registro_autocarga();

$enrutador = new Enrutador();
$enrutador->despacha();



?>