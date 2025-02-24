<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/funciones.php");
require_once("Archivo.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/ra4/autenticacion/03jwt_include.php");

session_start();
if (!$_SESSION['archivo']) {
    header("Location: /Ejercicios_OBJETOS/Ejercicio2/Pagina_inicial");
}

$archivo = $_SESSION['archivo'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && htmlspecialchars($_POST['operacion']) =="Escribir en el archivo") {
    
    $cadena = filter_input(INPUT_POST , "cadena" , FILTER_SANITIZE_SPECIAL_CHARS);
    
    try {
        if($archivo->escribirLinea($cadena)){
            echo "Se ha escrito el texto solicitado correctamente";
        }else{
            echo "NO se ha podido escribir en el archivo";
        }
    } catch (Error $th) {
       echo "Ha habido un error";
       exit(3);
    }
   


}


if ($_SERVER["REQUEST_METHOD"] == "POST" && htmlspecialchars($_POST['operacion']) =="Leer en el archivo") {
  
    $numero = filter_input(INPUT_POST, "numero", FILTER_SANITIZE_NUMBER_INT);
    $opciones = array(
        'options' => array(
            'default' => 0, // valor a retornar si el filtro falla
            // más opciones aquí
            'min_range' => 0
        ),
        'flags' => FILTER_FLAG_ALLOW_OCTAL,
    );

    $numero = filter_var($numero ,FILTER_DEFAULT , $opciones);

    if (!$numero) {
        echo "Error al obtener el numero de lineas a leer, vuelve a intentarlo";
        exit(4);
    }

    try {
        $contenido = $archivo->leerLinea($numero);
        if ($contenido) {
            echo "$contenido";
        }else {
            echo "no hay nada que leer en el archivo";
        }
    } catch (Error $th) {
        echo "Ha habido un error";
        exit(4);
    }
}

inicio_html("Pagina_resultados" , ["/estilos/formulario.css" ,"/estilos/general.css"])
?>

<BR></BR> <BR></BR>
<a href="/Ejercicios_OBJETOS/Ejercicio2/Pagina_inicial.php?operacion=cerrar">CERRAR SESION Y VOLVER A EMPEZAR</a> <BR></BR>
<a href="/Ejercicios_OBJETOS/Ejercicio2/Pagina_operacion.php">ELEGIR OPERACION</a> <BR></BR>
<a href="/Ejercicios_OBJETOS/Ejercicio2/Pagina_lilstaArchivo.php">ELEGIR ARCHIVO</a> <BR></BR>