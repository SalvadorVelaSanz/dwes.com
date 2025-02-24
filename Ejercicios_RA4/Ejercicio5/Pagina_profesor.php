<?php 

session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");

function autenticar($usuario, $clave) {
    $usuarios = [
        'pepe' => ['nombre' => 'José Gómez',
                    'clave' => password_hash("usuario", PASSWORD_DEFAULT)],
        'manolo' => ['nombre' => 'Manuel García',
                      'clave' => password_hash("usuario", PASSWORD_DEFAULT)]
    ];

    if (array_key_exists($usuario, $usuarios)) {
        return password_verify($clave, $usuarios[$usuario]['clave']);
    } else {
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    header("Location: /Ejercicios_RA4/Ejercicio5/Pagina_inicial.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && htmlspecialchars($_POST['operacion']) == 'Acceder') {

    $usuario = filter_input(INPUT_POST , "usuario" , FILTER_SANITIZE_SPECIAL_CHARS);
    $clave = filter_input(INPUT_POST , "clave" , FILTER_SANITIZE_SPECIAL_CHARS);

    if (autenticar($usuario , $clave)) {
        $_SESSION['usuario'] = $usuario;
        header("Location: /Ejercicios_RA4/Ejercicio5/Pagina_final.php");
        exit();
    }else{
        echo "<h2>Error al Inicar sesion. intentelo de nuevo</h2>";
        echo "<a href='/Ejercicios_RA4/Ejercicio5/Pagina_profesor'>Pulse aquí</a>";
    }
}

inicio_html("Iniciar Sesion" , ["/estilos/formulario.css"]);

?>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post">


<fieldset>
<legend>Ingrese sus datos aqui para inicar sesion</legend>

<label for="usuario">Ingrese su usuario</label>
<input type="text" name="usuario" id="usuario">

<label for="clave">Introduzca su clave</label>
<input type="password" name="clave" id="clave">
</fieldset>

<input type="submit" name="operacion" id="operacion" value="Acceder">


</form>

<?php
fin_html();
?>



