<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    



inicio_html("Principal" , ["/estilos/formulario.css"]);
?>

<form action="/Ejercicios_RA4/Ejercicio2/Pagina_lista.php" method="post">


<fieldset>
<legend>selecion de directorio</legend>

<label for="directorio">Elige la ruta del directorio para ver sus archivos(por favor que no acabe en /)</label>
<input type="text" name="directorio" id="directorio">
</fieldset>

<input type="submit" name="operacion" id="operacion">
</form>




<?php
fin_html();
}
?>