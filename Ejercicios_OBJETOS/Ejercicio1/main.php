<?php

require_once("ActividadFormacion.php");
require_once("Alumno.php");
require_once("DatosFormacion.php");
require_once("Inscrito.php");
require_once("Socio.php");

require_once( $_SERVER["DOCUMENT_ROOT"] . "/includes/funciones.php");

$actividad_formacion1 = new ActividadFormacion(123, "JAJAJ", 70,20,3,"A");
$actividad_formacion2 =  new ActividadFormacion(12345, "JAJA111J", 170,60,3,"B");

echo "$actividad_formacion1 <br>";
echo "$actividad_formacion2 <br>";

$fecha1 = new DateTime("2002-01-01");

$Socio = new Socio("Salvador" ,"Vela Sanz" , "salvadorvelasan@gmail.com" ,$fecha1 ,$actividad_formacion1, 223, "holajiji" , "mañana" );
$Inscrito = new Inscrito("Salvador" ,"Vela Sanz" , "salvadorvelasan@gmail.com" ,$fecha1 ,$actividad_formacion1, 1);

echo "$Socio <br>";

echo "$Inscrito <br>";

echo "<br><br><br><br><br><br><br><br><br>";

$precio_socio = $Socio->obtenerPrecio();

$horario_socio = $Socio->asignarHorario();

echo "$precio_socio <br> <br>";

echo "$horario_socio";

echo "$Socio->nombre";




?>