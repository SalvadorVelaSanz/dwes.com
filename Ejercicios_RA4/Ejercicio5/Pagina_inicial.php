<?php

session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");


if ($_SERVER['REQUEST_METHOD'] == 'POST' && htmlspecialchars($_POST['operacion']) == "cerrar") {
    $nombre_id = session_name();
    $parametros_cookie = session_get_cookie_params();
    setcookie($nombre_id, '', time() - 10000,
        $parametros_cookie['path'], $parametros_cookie['domain'],
        $parametros_cookie['secure'], $parametros_cookie['httponly']
    );
    
    session_unset();
    
    session_destroy();

    session_start();
}

inicio_html("Pagina inical" , ["/estilos/formulario.css"]);

?>

<form action="/Ejercicios_RA4/Ejercicio5/Pagina_carga_alumnos.php" method="post">


<fieldset>
<legend>Introduce los datos de la actividad escolar</legend>

<label for="nombre_actividad">Nombre de la actividad</label>
<input type="text" name="nombre_actividad" id="nombre_actividad">

<label for="fecha">Fecha de la actividad</label>
<input type="date" name="fecha" id="fecha">

</fieldset>

<input type="submit" name="operacion" id="operacion" value="Ir a cargar alumnos">

</form>

<?php

fin_html();

?>