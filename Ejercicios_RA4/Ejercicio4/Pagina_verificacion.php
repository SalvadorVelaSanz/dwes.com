<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");

function autenticar($usuario, $clave) {
    $usuarios = [
        'pepe@gmail.com' => ['nombre' => 'José Gómez',
                    'clave' => password_hash("usuario", PASSWORD_DEFAULT)],
        'manolo@gmail.com' => ['nombre' => 'Manuel García',
                      'clave' => password_hash("usuario", PASSWORD_DEFAULT)]
    ];

    if (array_key_exists($usuario, $usuarios)) {
        return password_verify($clave, $usuarios[$usuario]['clave']);
    } else {
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && htmlspecialchars($_POST['operacion']) == 'Iniciar sesion') {
 $correo = filter_input(INPUT_POST , "correo" , FILTER_SANITIZE_EMAIL);
 $correo = filter_var($correo , FILTER_VALIDATE_EMAIL);   
 if (!$correo) {
    echo "Error al recibir los datos, por favor vuelva a enviarlos";
    echo "<a href='/Ejercicios_RA4/Ejercicio4/Pagina_verificacion.php'>Pulse aquí</a>";
 }

 $clave = $_POST['contraseña'];

 $_SESSION['nombre_usuario'] = autenticar($correo , $clave) ? $correo : "error";

 header("Location: /Ejercicios_RA4/Ejercicio4/Pagina_carrito.php");
 exit();
}
inicio_html("Pagina_verificar" , ["/estilos/formulario.css"]);
?>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post">


<fieldset>
<legend>Iniciar Sesion</legend>

<label for="correo">Introduce tu correo</label>
<input type="text" name="correo" id="correo">

<label for="contraseña">Introduce tu contraseña</label>
<input type="password" name="contraseña" id="contraseña">

</fieldset>

<input type="submit" name="operacion" id="operacion" value="Iniciar sesion">




</form>


<?php
fin_html();

?>