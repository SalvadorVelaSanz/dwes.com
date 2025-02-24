<?php 

session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/ra4/autenticacion/03jwt_include.php");

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
    
    $correo = filter_input(INPUT_POST , "email" , FILTER_SANITIZE_EMAIL);
    $correo = filter_var($correo, FILTER_VALIDATE_EMAIL);

    if (!$correo) {
        echo " <h1>ERROR EN EL REGISTRO</h1>";
        echo "<p><a href='/Ejercicios_RA4/Ejercicio6/Pagina_inicial.php'>Pulse aqui</a></p>";   
        exit();
    }
    $clave = $_POST['clave'];

    if (!autenticar($correo , $clave)) {
        echo " <h1>ERROR EN EL REGISTRO</h1>";
        echo "<p><a href='/Ejercicios_RA4/Ejercicio6/Pagina_inicial.php'>Pulse aqui</a></p>";   
        exit();
    }

    $usuario = ['nombre' => $correo,
                'mensaje' => "validado"];
    
    $jwt = generar_token($usuario);
    
    setcookie("token", $jwt, time() + 30 * 60);

    echo "<h1>Bienvenido/a $correo </h1>";
    echo "<p><a href='/Ejercicios_RA4/Ejercicio6/Pagina_comentario.php?operacion=comentario'>Pulse aqui</a></p>";


}else{
    header("Location: /Ejercicios_RA4/Ejercicio6/Pagina_inicial.php");
    exit();
}



?>


