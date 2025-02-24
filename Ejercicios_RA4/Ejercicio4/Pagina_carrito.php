<?php

session_start();


require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");
require_once("articulos_carrito.php");

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

inicio_html("Pagina del carrito de la compra" , ["/estilos/formulario.css" , "/estilos/tablas.css"]);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['operacion'] == 'cerrar') {
    $nombre_id = session_name();
    $parametros_cookie = session_get_cookie_params();
    setcookie($nombre_id, '', time() - 10000,
        $parametros_cookie['path'], $parametros_cookie['domain'],
        $parametros_cookie['secure'], $parametros_cookie['httponly']
    );
    
    session_unset();
    
    session_destroy();

    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && htmlspecialchars($_POST['operacion']) == 'Añadir carrito') {
    
    $articulo = filter_input(INPUT_POST , "articulo" , FILTER_SANITIZE_SPECIAL_CHARS);
    $cantidad = filter_input(INPUT_POST ,"cantidad", FILTER_SANITIZE_NUMBER_INT);
    $cantidad = filter_var($cantidad , FILTER_VALIDATE_INT);

    if (!$cantidad) {
        echo "ERROR AL RECIBIR LOS PARAMETROS ,RECARGE LA PAGINA PARA VOLVER A EMPEZAR";
        exit(1);
    }

    if (array_key_exists($articulo , $articulos) && $cantidad > 0) {
        $_SESSION['carrito'][$articulo] = ($_SESSION['carrito'][$articulo] ? $_SESSION['carrito'][$articulo] : 0 ) + $cantidad ;
    }

}elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && htmlspecialchars($_POST['operacion']) == 'Verificar') {
    header("Location: /Ejercicios_RA4/Ejercicio4/Pagina_verificacion.php");
    exit(2);
}elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && htmlspecialchars($_POST['operacion']) == 'Ir a pagar') {
    header("Location: /Ejercicios_RA4/Ejercicio4/Pagina_pago.php");
    exit(3);
}



?>

<h1>Carrito de la compra</h1>

<?php

if (isset($_SESSION['nombre_usuario'])) {
    $usuario = $_SESSION['nombre_usuario'];
    if ($usuario !== "error") {
        echo "Bienvenido $usuario <br> <br>" ;
    }else{
        echo "Ha habido algun error en su inicio de sesion";
        echo "<a href='/Ejercicios_RA4/Ejercicio4/Pagina_verificacion.php'>Pulse aquí para volver a inicar sesión</a>";
        exit(4);
    }

}else{
    echo "no ha iniciado sesion, recuerde que no puede pagar hasta que lo haga <br> <br>";
}

?>


<form action="<?=$_SERVER['PHP_SELF']?>" method="post">

<fieldset>
<legend>Añadir articulos al carrito</legend>

<label for="articulo"> Seleciona tu producto</label>
<select name="articulo" id="articulo">
<?php
    foreach( $articulos as $clave => $valor ) {
        echo "<option value='$clave'>{$valor['descripcion']} - {$valor['precio']}€ </option>";
    }
    
?>
</select>

<label for="cantidad">Selecciona la cantidad</label>
<input type="number" name="cantidad" id="cantidad" min="1">
</fieldset>
<input type="submit" name="operacion" id="operacion" value="Añadir carrito">
</form>

<br><br>

<?php 

if (!empty($_SESSION['carrito'])) {
    $carrito = $_SESSION['carrito'];
    $precio_carrito = 0;

    foreach ($carrito as $codigo => $cantidad) {
        $descripcion = $articulos[$codigo]['descripcion'];
        $precio = $articulos[$codigo]['precio'];
        $cantidad_articulo = $cantidad;
        $precio_total = $precio * $cantidad;
        $precio_carrito += $precio_total;

        echo "<table>
        <tr>
        <th>codigo</th>
        <th>descripcion</th>
        <th>cantidad</th>
        <th>precio</th>
        <th>subtotal</th>
        </tr>

        <tr>
        <td>$codigo</td>
        <td>$descripcion</td>
        <td>$cantidad_articulo</td>
        <td>$precio</td> 
        <td>$precio_total</td>
        </tr>
        </table>";
    }

    echo "El total es : $precio_carrito €";
}else{
    echo "No hay nada en el carrito de momento";
}

?>


<br><br>
<form action="/Ejercicios_RA4/Ejercicio4/Pagina_pago.php" method="post">
<fieldset>
    <legend>Pulsa para pagar</legend>

    <input type="submit" name="operacion" id="operacion" value="Ir a pagar">
</fieldset>
</form>

<form action="/Ejercicios_RA4/Ejercicio4/Pagina_verificacion.php" method="post">
<fieldset>
    <legend>Pulsa para Iniciar Sesion</legend>

    <input type="submit" name="operacion" id="operacion" value="Verificar">
</fieldset>
</form>
<?php

fin_html();

?>