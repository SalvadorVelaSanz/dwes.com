<?php


require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/ra4/autenticacion/03jwt_include.php");

session_start();

if ( !isset($_COOKIE['token']) ) {
    header("Location: /Ejercicios_BBDD/Ejercicio3/Pagina_autentificacion.php");
    exit(3);
}

$jwt = $_COOKIE['token'];
$payload = verificar_token($jwt);

if ( !$payload ) {
    header("Location: /Ejercicios_BBDD/Ejercicio3/Pagina_autentificacion.php");
    exit(1);
}

$dsn = "mysql:host=localhost;port=3306;dbname=tiendaol;charset=utf8mb4";
$usuario = "usuario";
$clave = "usuario";

$opciones = [
PDO::ATTR_ERRMODE               =>  PDO::ERRMODE_EXCEPTION,
PDO::ATTR_DEFAULT_FETCH_MODE    =>  PDO::FETCH_ASSOC,
PDO::ATTR_EMULATE_PREPARES      =>  false
];

try {
    $pdo = new PDO($dsn , $usuario , $clave , $opciones);

    $sql = $sql = "
    SELECT 
        lp.referencia, 
        a.descripcion, 
        p.fecha, 
        lp.unidades, 
        lp.precio, 
        lp.dto
    FROM 
        pedido p
    JOIN 
        lpedido lp ON p.npedido = lp.npedido
    JOIN 
        articulo a ON lp.referencia = a.referencia
    WHERE 
        p.nif = :nif;
";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":nif" , $payload['nif']);
    $stmt->execute();
    $articulos = $stmt->fetchAll();

} catch (PDOException $th) {
    echo $th;
}

inicio_html("Pagina_principal" , ["/estilos/general.css" , "/estilos/tablas.css"]);
?>

<table>

<tr>
    <th>Referencia</th>
    <th>Descripcion</th>
    <th>Fecha_pedido</th>
    <th>Unidades</th>
    <th>Precio</th>
    <th>Descuento</th>

</tr>
<?php
foreach ($articulos as $articulo) {
    echo <<<TD
    <tr>
    <td>{$articulo['referencia']}</td>
    <td>{$articulo['descripcion']}</td>
    <td>{$articulo['fecha']}</td>
    <td>{$articulo['unidades']}</td>
    <td>{$articulo['precio']}</td>
    <td>{$articulo['dto']}</td>
    TD;
    ?>
    <td>
        <form action="/Ejercicios_BBDD/Ejercicio3/Pagina_datos.php" method="get">
            <input type="hidden" name="referencia" id="referencia" value="<?=$articulo['referencia']?>">
            <input type="submit" name="operacion" id="operacion" value="Añadir reseña">
        </form>
    </td>
    </tr>
  <?php
}

?>
</table>

<form action="/Ejercicios_BBDD/Ejercicio3/Pagina_autentificacion.php" method="post">
    <fieldset>
        <input type="submit" name="operacion" id="operacion" value="Cerrar sesion">
    </fieldset>
</form>

<?php
fin_html();
?>