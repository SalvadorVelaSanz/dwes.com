<?php 

require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/funciones.php");
require_once("Archivo.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/ra4/autenticacion/03jwt_include.php");

session_start();
if (!$_SESSION['ruta_dir']) {
    header("Location: /Ejercicios_OBJETOS/Ejercicio2/Pagina_inicial");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && htmlspecialchars($_POST['operacion'] == "Enviar Archivo")) {
    
  
    $archivo_usuario = filter_input(INPUT_POST, "archivo" , FILTER_SANITIZE_SPECIAL_CHARS);
    if (!$archivo_usuario) {
        $archivo_usuario = $_SESSION['archivo_usuario'];
    }
    $_SESSION['archivo_usuario'] = $archivo_usuario;
    
    $ruta = $_SESSION['ruta_dir'] . "/$archivo_usuario";
    $tipo_mime = mime_content_type($ruta);
 
   

    try {
        $archivo = new Archivo($archivo_usuario , $ruta , $tipo_mime);
    } catch (Error $th) {
        echo "Ha ocurrido un error al determinar el tipo mime del archivo";
        exit(2);
    }
    
    $_SESSION['archivo'] = $archivo;

}

inicio_html("Pagina operacion" , ["/estilos/formulario.css" , "/estilos/general.css"]);

?>

<form action="/Ejercicios_OBJETOS/Ejercicio2/Pagina_resultado.php" method="post">

<fieldset>
<legend>Primera operacion del archivo</legend>

<label for="cadena">Escribir en el archivo</label>
<input type="text" name="cadena" id="cadena">

<input type="submit" name="operacion" id="operacion" value="Escribir en el archivo">
</fieldset>

<fieldset>
<legend> Segunda operacion del archivo</legend>

<label for="numero">Selecciona cuantas lineas quieres leer del archivo</label>
<input type="number" name="numero" id="numero">

<input type="submit" name="operacion" id="operacion2" value="Leer en el archivo">
</fieldset>



</form>


<?php
fin_html();
?>