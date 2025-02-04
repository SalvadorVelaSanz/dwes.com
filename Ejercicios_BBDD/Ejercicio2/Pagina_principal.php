<?php


require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/funciones.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/ra4/autenticacion/03jwt_include.php");


session_start();


if ( !isset($_COOKIE['token']) ) {
    header("Location: /Ejercicios_BBDD/Ejercicio2/Pagina_autentificacion.php");
    exit(3);
}

$jwt = $_COOKIE['token'];
$payload = verificar_token($jwt);

if ( !$payload ) {
    header("Location: /Ejercicios_BBDD/Ejercicio2/Pagina_autentificacion.php");
    exit(3);
}



$servidor_local = "localhost";
$puerto_local = 3306;
$usuario_local = "usuario";
$contraseña = "usuario";
$esquema_local = "tiendaol";

try {
    $cbd = new mysqli($servidor_local , $usuario_local , $contraseña , $esquema_local ,$puerto_local);

    $sql = "SELECT id_dir_env, direccion, cp, poblacion, provincia, pais  FROM direccion_envio WHERE nif = ?";
    $stmt = $cbd->prepare($sql);
    $stmt->bind_param('s' ,$payload['nif']);
    $stmt->execute();
    $resultSet = $stmt->get_result();
    
} catch (mysqli_sql_exception $th) {
  echo $th;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && htmlspecialchars($_POST['operacion']) == 'eliminar') {

    try {
        $cbdDelete = new mysqli($servidor_local , $usuario_local , $contraseña , $esquema_local ,$puerto_local);
        $sqlDelete ="DELETE from direccion_envio WHERE nif = ? and id_dir_env = ?"; 
        
        $stmt = $cbdDelete->prepare($sqlDelete);
        $stmt->bind_param('si' ,$payload['nif'] ,htmlspecialchars($_POST['id_dir_env']));
        $stmt->execute();
        if ($stmt->affected_rows == 1) {
            header("Location: /Ejercicios_BBDD/Ejercicio2/Pagina_principal.php");
            exit();
        }else{
            echo "ha ocurrido un error a la hora de eliminar su direccion, vuelva a intentarlo";
        }

    } catch (mysqli_sql_exception $th) {
        echo "$th";
    }

}

inicio_html("Pagina_principal" , ["/estilos/general.css" , "/estilos/tablas.css" , "/estilos/formulario.css"]);
?>

    <table>
    <tr>
    <th>id_dir_env</th>
    <th>direccion</th>
    <th>cp</th>
    <th>poblacion</th>
    <th>provincia</th>
    <th>pais</th>
    </tr>
<?php
    while ($fila = $resultSet->fetch_assoc()) {
    echo <<<TABLA
        <tr>
        <td>{$fila['id_dir_env']}</td>
        <td>{$fila['direccion']}</td>
        <td>{$fila['cp']}</td>
        <td>{$fila['poblacion']}</td>
        <td>{$fila['provincia']}</td>
        <td>{$fila['pais']}</td>
   
        TABLA;
        ?>
        <td>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                <input type="hidden" name="id_dir_env" id="id_dir_env" value="<?= $fila['id_dir_env']?>">
                <input type="submit" name="operacion" id="operacion" value="eliminar">
            </form>   
        </td>

        <td>
            <form action="/Ejercicios_BBDD/Ejercicio2/Pagina_datos.php" method="get">
                <input type="hidden" name="id_dir_env" id="id_dir_env" value="<?= $fila['id_dir_env']?>">
                <input type="submit" name="operacion" id="operacion" value="modificar">
            </form>   
        </td>
        </tr>
        <?php
    }
?>
</table>
<br>
<br>

<form action="/Ejercicios_BBDD/Ejercicio2/Pagina_autentificacion.php" method="post">
    <input type="submit" name="operacion" id="operacion" value="Cerrar sesion">
</form>

<form action="/Ejercicios_BBDD/Ejercicio2/Pagina_datos.php" method="get">
<input type="submit" name="operacion" id="operacion" value="Añadir direccion">
</form>

<?php
fin_html();
?>