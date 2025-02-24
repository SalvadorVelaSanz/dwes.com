<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/funciones.php");
require_once("Archivo.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/ra4/autenticacion/03jwt_include.php");

session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET" && htmlspecialchars($_GET["operacion"] == "cerra")) {
    $nombre_id = session_name();
    $parametros_cookie = session_get_cookie_params();
    setcookie($nombre_id, '', time() - 10000,
        $parametros_cookie['path'], $parametros_cookie['domain'],
        $parametros_cookie['secure'], $parametros_cookie['httponly']
    );
    
    session_unset();
    
    session_destroy();
}


inicio_html("Pagina inicial" , ["/estilos/general.css", "/estilos/tablas.css" , "/estilos/formulario.css"])
?>

<form action="/Ejercicios_OBJETOS/Ejercicio2/Pagina_lilstaArchivo.php" method="post">


<fieldset>
<legend>Datds del archivo</legend>

<label for="directorio">Directorio del archivo</label>
<input type="text" name="directorio" id="directorio">

</fieldset>

<input type="submit" name="operacion" value="Enviar Directorio" id="operacion">

</form>


<?php

fin_html();
?>