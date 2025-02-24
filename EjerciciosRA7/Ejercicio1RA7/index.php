<?php
$hola = "hola";

require_once($_SERVER["DOCUMENT_ROOT"] . "/EjerciciosRA7/Ejercicio1RA7/util/Autocarga.php");
use Ejercicio1RA7\util\Autocarga;
use Ejercicio1RA7\controlador\JsonRpcControlador;


Autocarga::registro_autocarga();



$controladorJSON = new JsonRpcControlador();
$controladorJSON->manejar_peticion();


?>