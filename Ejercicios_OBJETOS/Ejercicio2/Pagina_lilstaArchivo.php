<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/funciones.php");
require_once("Archivo.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/ra4/autenticacion/03jwt_include.php");

session_start();


if ($_SERVER['REQUEST_METHOD'] == "POST" && htmlspecialchars($_POST["operacion"] == "Enviar Directorio")) {

    $directorio_usuario = filter_input(INPUT_POST , "directorio" , FILTER_SANITIZE_SPECIAL_CHARS);

    $directorio = $_SERVER['DOCUMENT_ROOT'] . "/$directorio_usuario";

    if (is_dir($directorio)) {
        $_SESSION['ruta_dir'] = $directorio;
        $archivos_directorio = scandir($directorio);
        $_SESSION['ARC_DIR'] = $archivos_directorio;
    
    }else {
        echo "Error al seleccionar su directorio, vuelva a intertarlo. <br>";
        echo "<a href='/Ejercicios_OBJETOS/Ejercicio2/Pagina_inicial.php'>Pulse aqui</a>";
        exit(1);
    }

}



inicio_html("Pagina lista de archivos" , ["/estilos/general.css", "/estilos/tablas.css" , "/estilos/formulario.css"])
?>

<form action="/Ejercicios_OBJETOS/Ejercicio2/Pagina_operacion.php" method="post">

<fieldset>
<legend>Seleccion del archivo</legend>

<label for="archivo">Seleciona el archivo del directorio</label>

<select name="archivo" id="archivo">
<?php
if (isset($archivos_directorio)) {
    foreach( $archivos_directorio as $archivo) {
        if ($archivo !== "." && $archivo !== "..") {
            echo "<option value = $archivo> $archivo</option>";
        }
     
    }
}else{
    $archivos_directorio_session= $_SESSION['ARC_DIR'];
    foreach( $archivos_directorio_session as $archivo) {
        if ($archivo !== "." && $archivo !== "..") {
            echo "<option value = $archivo> $archivo</option>";
        }
     
    }
}

?>
</select>



</fieldset>

<input type="submit" name="operacion" id="operacion" value="Enviar Archivo">

</form>

<?php

fin_html();

?>