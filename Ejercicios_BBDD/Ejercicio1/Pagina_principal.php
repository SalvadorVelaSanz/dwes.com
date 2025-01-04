<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && htmlspecialchars($_POST['operacion'] == "Iniciar Sesion")) {
    $usuario = filter_input(INPUT_POST , "usuario" , FILTER_SANITIZE_SPECIAL_CHARS);
    $clave = $_POST['clave'];

    $_SESSION['usuario'] = $usuario;
    $_SESSION['clave']=$clave;
}

$dsn = "mysql:host=localhost;port=3306;dbname=tiendaol;charset=utf8mb4";
$usuario = $_SESSION['usuario'];
$clave = $_SESSION['clave'];

$opciones = [
PDO::ATTR_ERRMODE               =>  PDO::ERRMODE_EXCEPTION,
PDO::ATTR_DEFAULT_FETCH_MODE    =>  PDO::FETCH_ASSOC,
PDO::ATTR_EMULATE_PREPARES      =>  false
];
try {
    $pdo = new PDO($dsn , $usuario , $clave , $opciones);        
} catch (\PDOException $e) {
    $e = "Datos mal introducidos , vuelve a intentarlo";
    $_SESSION['error'] = $e;
    header("Location: /Ejercicios_BBDD/Ejercicio1/Pagina_autentificacion.php");
    exit();
}
$e = "";
$_SESSION['error'] = $e;

$filtro = $_GET['filtro_nombre'] ?? '';

$sql = "SELECT * FROM articulo ";

if ($filtro) {
    $sql.= "WHERE descripcion LIKE :filtro";
}

try {
    
$stmt = $pdo->prepare($sql);
if ($filtro) {
    $stmt->bindValue(":filtro" , "%$filtro%");
}

$stmt->execute();
$articulos = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "$e";
}



if ($_SERVER['REQUEST_METHOD'] == 'POST' && htmlspecialchars($_POST['operacion']) == 'eliminar') {

$referencia = $_POST['referencia'];

    $sqlDeleteLenvio = "DELETE FROM lenvio WHERE npedido IN (SELECT npedido FROM lpedido WHERE referencia = :referencia)";
    $sqlDeleteLpedido = "DELETE FROM lpedido WHERE referencia = :referencia";
    $sqlDeleteArticulo = "DELETE FROM articulo WHERE referencia = :referencia";

    try {
        // Eliminar los registros de lenvio
        $stmtLenvio = $pdo->prepare($sqlDeleteLenvio);
        $stmtLenvio->bindValue(":referencia", $referencia);
        $stmtLenvio->execute();

        // Luego eliminar de lpedido
        $stmtLpedido = $pdo->prepare($sqlDeleteLpedido);
        $stmtLpedido->bindValue(":referencia", $referencia);
        $stmtLpedido->execute();

        // Finalmente eliminar de articulo
        $stmtDeleteArticulo = $pdo->prepare($sqlDeleteArticulo);
        $stmtDeleteArticulo->bindValue(":referencia", $referencia);
        $stmtDeleteArticulo->execute();
        header("Location: /Ejercicios_BBDD/Ejercicio1/Pagina_principal.php");
} catch (PDOException $e) {
    echo " <h1>Ha habido un error al eliminar su articulo , Vuelva a intentarlo</h1>";
    echo $e->getMessage();
}


}

inicio_html("Pagina_principal" , ["/estilos/formulario.css" , "/estilos/general.css" , "/estilos/tablas.css"]);
?>


<form action="<?=$_SERVER['PHP_SELF'] ?>" method="get">
<fieldset>
<legend> Filtro</legend>

<label for="filtro_nombre">Filtrar por nombre</label>
<input type="text" name="filtro_nombre" id="filtro_nombre">

</fieldset>
<input type="submit" name="operacion" id="operacion" value="Filtrar">
</form>



<table>
<tr>

<th>Referencia</th>
<th>Descripcion</th>
<th>pvp</th>
<th>dto_venta</th>
<th>und_vendidas</th>
<th>und_disponibles</th>
<th>Fecha_disponible</th>
<th>categoria</th>
<th>tipo_iva</th>
</tr>
<tr>
<?php

foreach ($articulos as $articulo) {
    echo<<<VALORES
    <td>{$articulo['referencia']}</td>
    <td>{$articulo['descripcion']}</td>
    <td>{$articulo['pvp']}</td>
    <td>{$articulo['dto_venta']}</td>
    <td>{$articulo['und_vendidas']}</td>
    <td>{$articulo['und_disponibles']}</td>
    <td>{$articulo['fecha_disponible']}</td>
    <td>{$articulo['categoria']}</td>
    <td>{$articulo['tipo_iva']}</td>
    VALORES;
    ?>
    <td>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <input type="hidden" name="referencia" id="referencia" value="<?=$articulo['referencia']?>">
        <input type="submit" name="operacion" id="operacion" value="eliminar">
        </form>
    </td>
    <td>
        <form action="/Ejercicios_BBDD/Ejercicio1/Pagina_datos.php" method="get">
        <input type="hidden" name="referencia" id="referencia" value="<?=$articulo['referencia']?>">
        <input type="submit" name="operacion" id="operacion" value="modificar">
        </form>
    </td>
    </tr>
    <?php
 }
 ?>
?>
</table>

<h3><a href="/Ejercicios_BBDD/Ejercicio1/Pagina_datos.php">Crear nuevo articulo</a></h3>


<?php
fin_html();

?>
