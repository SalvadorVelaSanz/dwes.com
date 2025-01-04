<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/ra4/autenticacion/03jwt_include.php");

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && htmlspecialchars($_POST['operacion']) == 'Cerrar sesion') {
    cerrar_sesion();
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && htmlspecialchars($_POST['operacion']) == 'Iniciar sesion') {
    $correo = filter_input(INPUT_POST , "email" , FILTER_SANITIZE_SPECIAL_CHARS);
    $correo = filter_var($correo , FILTER_VALIDATE_EMAIL);

    if (!$correo) {
        echo "Datos en el formulario mal rellenados, Intentalo de nuevo <br>";
        echo "<a href='/Ejercicios_BBDD/Ejercicio3/Pagina_autentificacion.php'</a>Pulse aqui";
        exit();
    }
    $contraseña = $_POST['clave'];

    $dsn = "mysql:host=localhost;port=3306;dbname=tiendaol;charset=utf8mb4";
    $usuario = "usuario";
    $clave = "usuario";

    $opciones = [
    PDO::ATTR_ERRMODE               =>  PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE    =>  PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES      =>  false
    ];

    try {
        $pdo = new PDO($dsn ,$usuario ,$clave , $opciones);
        $sql = "SELECT nif ,nombre, email,clave from cliente where email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":email" , $correo);
        $stmt->execute();
        $cliente = $stmt->fetch();
        if ($stmt->rowCount() ==1) {
            if (password_verify($contraseña ,$cliente['clave'])) {
                $payload = ['nombre' => $cliente['nombre'],
                            'nif' => $cliente['nif'],
                            'emaill' => $cliente['email']];
                
                $jwt = generar_token($payload);
                
                setcookie("token", $jwt, time() + 30 * 60);

                header("Location: /Ejercicios_BBDD/Ejercicio3/Pagina_principal.php");
                exit();
            }else{
                echo "Contraseña incorrecta";
            }
        }else{
            echo "Ha habido un problema intentalo de nuevo";
        }
    } catch (PDOException $th) {
        echo $th;
    }
}



inicio_html("Pagina de auntentificacion" , ["/estilos/general.css" , "/estilos/formulario.css"]);
?>
<form action="<?= $_SERVER['PHP_SELF']?>" method="post">

<fieldset>
    <legend>Introduzca sus datos</legend>

    <label for="email">Introduce tu email</label>
    <input type="email" name="email" id="email">

    <label for="clave">Introduce tu contraseña</label>
    <input type="password" name="clave" id="clave">

</fieldset>
<input type="submit" name="operacion" id="operacion" value="Iniciar sesion">
</form>

<?php
fin_html();
?>