<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    header("Location: /Ejercicios_RA4/Ejercicio5/Pagina_inicial.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && htmlspecialchars($_POST['operacion']) == 'Ir a cargar alumnos') {

    $nombre_actividad = filter_input(INPUT_POST , "nombre_actividad" , FILTER_SANITIZE_SPECIAL_CHARS);
    $fecha = filter_input(INPUT_POST , "fecha" , FILTER_SANITIZE_SPECIAL_CHARS);

    $_SESSION['nombre_actividad'] = $nombre_actividad;
    $_SESSION['fecha'] = $fecha;

}


inicio_html("Pagina de carga de alumnos" , ["/estilos/formulario.css" , "/estilos/tablas.css"]);

?>

<form action="/Ejercicios_RA4/Ejercicio5/Pagina_presupuesto.php" method="post" enctype="multipart/form-data">

<fieldset>

<legend>Carga de alumnos</legend>

<label for="alumnos_csv">Introducce el csv que contiene los datos de los alumnos</label>
<input type="file" name="alumnos_csv" id="alumnos_csv" accept=".csv">

</fieldset>

<input type="submit" name="operacion" id="operacion" value="Empezar el presupuesto">

</form>

<?php




?>