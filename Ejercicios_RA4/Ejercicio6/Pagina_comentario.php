<?php 

session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/ra4/autenticacion/03jwt_include.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET' && htmlspecialchars($_GET['operacion'] == 'comentario')) {
    if ( !isset($_COOKIE['token']) ) {
        header("Location: /Ejercicios_RA4/Ejercicio6/Pagina_inicial.php?operacion=cerrar");
        exit();
    }
    
    $jwt = $_COOKIE['token'];
    $payload = verificar_token($jwt);
    
    if ( !$payload ) {
        header("Location: /Ejercicios_RA4/Ejercicio6/Pagina_inicial.php?operacion=cerrar");
        exit();
    }

    inicio_html("Pagina comentario" , ["/estilos/formulario.css"]);
}
?>
<form action="/Ejercicios_RA4/Ejercicio6/Pagina_lista.php" method="post">


<fieldset>

<legend>comentarios</legend>

<label for="tema">tema del comentario</label>
<select name="tema" id="tema">
    <option value="bueno">bueno</option>
    <option value="malo">malo</option>
    <option value="reseña">reseña</option>
    <option value="critica">critica</option>
</select>

<label for="comentario">Comentario</label>
<textarea name="comentario" id="comentario" cols="30" rows="10"></textarea>
</fieldset>

<input type="submit" name="operacion" id="operacion" value="Ver lista">
</form>



<?php 

fin_html();

?>