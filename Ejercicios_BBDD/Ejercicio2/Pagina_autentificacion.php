<?php


require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/funciones.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/ra4/autenticacion/03jwt_include.php");


session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && htmlspecialchars($_POST['operacion']) == 'Iniciar sesion') {
    $correo = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS );
    $correo = filter_var($correo , FILTER_VALIDATE_EMAIL);

    $clave = $_POST['clave'];


    $servidor_local = "localhost";
    $puerto_local = 3306;
    $usuario_local = "usuario";
    $contraseña = "usuario";
    $esquema_local = "tiendaol";

    try {
        $cbd = new mysqli($servidor_local , $usuario_local , $contraseña , $esquema_local ,$puerto_local);

        $sql = "SELECT nif, email, clave, nombre  FROM cliente WHERE email = ?";
        $stmt = $cbd->prepare($sql);
        $stmt->bind_param('s' ,$correo);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows == 1 ) {

            $cliente = $resultado->fetch_assoc();

            if (password_verify($clave , $cliente['clave'] )) {
                $payload = ['nombre' => $cliente['nombre'],
                            'email' => $cliente['email'],
                            'nif' => $cliente['nif']];
                
                $jwt = generar_token($payload);
                
                setcookie("token", $jwt, time() + 30 * 600);

                echo "<h3>Cliente autenticado con éxito</h3>";
                echo "<p>¡Bienvenido, {$payload['nombre']}! Desde aquí puede acceder a ";
                echo "<a href='/Ejercicios_BBDD/Ejercicio2/Pagina_principal.php'>la gestion de direcciones</a></p>";
                fin_html();
                exit(0);
            }
        }else {
            echo "<h3>Error en la aplicación</h3>";
            echo "<p>El usuario $email no existe.<br>";
            echo "<a href='{$_SERVER['PHP_SELF']}'>Inténtelo de nuevo</a></p>";
            fin_html();
            exit(1);
        }
    } catch (\mysqli_sql_exception $th) {
        echo "$th";
    }

}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && htmlspecialchars($_POST['operacion']) == 'Cerrar sesion') {
    cerrar_sesion();
    session_start();
}


inicio_html("Pagina de autentificacion" , ["/estilos/formulario.css" , "/estilos/general.css"]);
?>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post">

<fieldset>
    <legend>Registro de cliente</legend>

    <label for="email">Introduce tu correo</label>
    <input type="email" name="email" id="email">

    <label for="clave">Introduce tu contraseña</label>
    <input type="password" name="clave" id="clave">
</fieldset>
<input type="submit" name="operacion" id="operacion" value="Iniciar sesion">

</form>


<?php

fin_html();

?>