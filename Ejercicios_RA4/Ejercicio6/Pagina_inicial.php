<?php 

session_start();

require_once($_SERVER['DOCUMENT_ROOT'] ."/includes/funciones.php");


if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['operacion']) && htmlspecialchars($_GET['operacion']) == 'cerrar') {
    $nombre_id = session_name();
    $parametros_cookie = session_get_cookie_params();
    setcookie($nombre_id, '', time() - 10000,
        $parametros_cookie['path'], $parametros_cookie['domain'],
        $parametros_cookie['secure'], $parametros_cookie['httponly']
    );
    
    session_unset();
    
    session_destroy();
}

inicio_html("Pagina Inicial" , ["/estilos/formulario.css"]);
?>

<form action="/Ejercicios_RA4/Ejercicio6/Pagina_registro.php" method="post">
<fieldset>
    <legend>Inicar Sesion</legend>

    <label for="email">Introduzca su correo</label>
    <input type="email" name="email" id="email">

    <label for="clave">Introduzca su contraseña</label>
    <input type="password" name="clave" id="clave">

</fieldset>
    <input type="submit" name="operacion" id="operacion" value="Iniciar sesion">
</form>

<?php 

fin_html();

?>