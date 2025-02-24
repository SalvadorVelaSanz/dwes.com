<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");

session_start();

inicio_html("Pagina de autentificacion" , ["/estilos/formulario.css" , "/estilos/general.css"]);
?>


<form action="/Ejercicios_BBDD/Ejercicio1/Pagina_principal.php" method="post">

<?php

    if (isset($_SESSION['error'])) {
        $error = $_SESSION['error'];
        echo "<h1>$error</h1>";
    }
?>
<fieldset>
<legend>Introduce los datos Necsarios de la base de datos para comenzar</legend>

<label for="usuario">Usuario de la base de datos</label>
<input type="text" name="usuario" id="usuario">

<label for="clave">Clave del usuario de la base de datos</label>
<input type="text" name="clave" id="clave">
</fieldset>
<input type="submit" name="operacion" id="operacion" value="Iniciar Sesion">
</form>

<?php
fin_html();

?>