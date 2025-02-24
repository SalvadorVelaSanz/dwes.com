<?php


require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/funciones.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/ra4/autenticacion/03jwt_include.php");


session_start();

if (!isset($_COOKIE['token'])) {
    header("Location: /Ejercicios_BBDD/Ejercicio2/Pagina_autentificacion.php");
    exit(3);
}

$jwt = $_COOKIE['token'];
$payload = verificar_token($jwt);

if (!$payload) {
    header("Location: /Ejercicios_BBDD/Ejercicio2/Pagina_autentificacion.php");
    exit(1);
}
$servidor_local = "localhost";
$puerto_local = 3306;
$usuario_local = "usuario";
$contraseña = "usuario";
$esquema_local = "tiendaol";

$id_direccion = isset($_GET['id_dir_env']) ? htmlspecialchars($_GET['id_dir_env']) : '';
if ($id_direccion !== '') {
    $_SESSION['id_direccion']=$id_direccion;
}


$direccion = null;

if ($id_direccion) {
    try {
        $cbd = new mysqli($servidor_local, $usuario_local, $contraseña, $esquema_local, $puerto_local);

        $sql = "SELECT  direccion, cp, poblacion, provincia, pais  FROM direccion_envio WHERE nif = ? and id_dir_env = ?";
        $stmt = $cbd->prepare($sql);
        $stmt->bind_param('si', $payload['nif'] ,$id_direccion);
      
        $stmt->execute();
        $resultSet = $stmt->get_result();
        $direccion = $resultSet->fetch_assoc();
    } catch (mysqli_sql_exception $th) {
        echo $th;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_direccion_nuevo = filter_input(INPUT_POST, "id_dir_env", FILTER_SANITIZE_SPECIAL_CHARS);
    $direccion = filter_input(INPUT_POST, "direccion", FILTER_SANITIZE_SPECIAL_CHARS);
    $cp =  filter_input(INPUT_POST, "cp", FILTER_SANITIZE_SPECIAL_CHARS);
    $opciones = array(
        'options' => array(
            'min_range' => 0
        ),
        'flags' => FILTER_FLAG_ALLOW_OCTAL,
    );
    $cp = filter_var($cp, FILTER_VALIDATE_INT, $opciones);
    $poblacion = filter_input(INPUT_POST, "poblacion", FILTER_SANITIZE_SPECIAL_CHARS);
    $provincia = filter_input(INPUT_POST, "provincia", FILTER_SANITIZE_SPECIAL_CHARS);
    $pais = filter_input(INPUT_POST, "pais", FILTER_SANITIZE_SPECIAL_CHARS);

    if (!$cp) {
        echo "Errores en el formulario ,vuelve a intentarlo";
        echo "<a href='/Ejercicios_BBDD/Ejercicio2/Pagina_principal.php'>Pulse aqui</a>";
        exit();
    
    }
    $id_direccion = $_SESSION['id_direccion'];
    if ($id_direccion) {
        try {
            $cbdUpdate = new mysqli($servidor_local, $usuario_local, $contraseña, $esquema_local, $puerto_local);
            $sqlUpdate = "UPDATE direccion_envio SET direccion = ?, cp = ?, poblacion = ?, provincia = ?, pais = ? 
            WHERE nif = ? AND id_dir_env = ?";

            $stmtUpdate = $cbdUpdate->prepare($sqlUpdate);
            $stmtUpdate->bind_param('sissssi', $direccion, $cp, $poblacion, $provincia, $pais, $payload['nif'], $id_direccion);
            $stmtUpdate->execute();


            if ($stmtUpdate->affected_rows == 1) {
                $_SESSION['id_direccion'] = '';
                header("Location: /Ejercicios_BBDD/Ejercicio2/Pagina_principal.php");
                exit();
            } else {
                header("Location: /Ejercicios_BBDD/Ejercicio2/Pagina_principal.php");
                exit();
            }
        } catch (mysqli_sql_exception $th) {
            echo $th;
        }
    } else {
        try {
            $cbdInsert = new mysqli($servidor_local, $usuario_local, $contraseña, $esquema_local, $puerto_local);
            $sqlInsert = "INSERT INTO direccion_envio (nif, id_dir_env , direccion, cp, poblacion, provincia, pais) VALUES (?, ?, ?, ?, ?, ? ,?)";
            $stmtInsert = $cbdInsert->prepare($sqlInsert);
            $stmtInsert->bind_param("sisisss", $payload['nif'], $id_direccion_nuevo, $direccion, $cp, $poblacion, $provincia, $pais);
            $stmtInsert->execute();


            if ($stmtInsert->affected_rows == 1) {
                echo "bien";
                echo "<a href='/Ejercicios_BBDD/Ejercicio2/Pagina_principal.php'>Pulse aqui</a>";
                exit();
            } else {
                echo "Ha ocurrido un error a la hora de añadir su direccion, intentelo de nuevo";
                echo "<a href='/Ejercicios_BBDD/Ejercicio2/Pagina_principal.php'>Pulse aqui</a>";
                exit();
            }
        } catch (mysqli_sql_exception $th) {
            echo $th;
        }
    }
}











inicio_html("Pagina de datos", ["/estilos/general.css", "/estilos/formulario.css"]);
?>

<h1> <?= $direccion ? "Modificar Direccion" : "Añadir direccion" ?></h1>

<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">

    <fieldset>
        <legend><?= $direccion ? "Modifica los valores" : "Introduce los valores" ?></legend>

        <?php
        if (!$direccion) {
            echo <<<FORM
            <label for="id_dir_env">Id de la direccion de envio</label>
            <input type="number" name="id_dir_env" id="id_dir_env" min="0">
            FORM;
        }
        ?>

        <label for="direccion">Direccion</label>
        <input type="text" name="direccion" id="direccion" value="<?= $direccion['direccion'] ?? '' ?>">

        <label for="cp">Codigo postal</label>
        <input type="number" name="cp" id="cp" value="<?= $direccion['cp'] ?? '' ?>">

        <label for="poblacion">Poblacion o ciudad de residencia</label>
        <input type="text" name="poblacion" id="poblacion" value="<?= $direccion['poblacion'] ?? '' ?>">

        <label for="provincia">Provincia</label>
        <input type="text" name="provincia" id="provincia" value="<?= $direccion['provincia'] ?? '' ?>">

        <label for="pais">Pais</label>
        <input type="text" name="pais" id="pais" value="<?= $direccion['pais'] ?? '' ?>">

    </fieldset>

    <input type="submit" name="operacion" id="operacion" value="<?= $direccion ? "Modificar Direccion" : "Añadir Direccion" ?>">

</form>



<?php
fin_html();
?>