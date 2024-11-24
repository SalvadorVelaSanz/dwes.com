<?php


session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");
require_once("articulos_carrito.php");

inicio_html("Pagina de pago" , ["/estilos/formulario.css" , "/estilos/tablas.css"]);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    header("Location: /Ejercicios_RA4/Ejercicio4/Pagina_carrito.php");
}

if (!isset($_SESSION['nombre_usuario']) || $_SESSION['nombre_usuario'] == "error") {
    header("Location: /Ejercicios_RA4/Ejercicio4/Pagina_carrito.php");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && htmlspecialchars($_POST['operacion']) == 'Pagar' ) {

    $nombre_tarjeta = filter_input(INPUT_POST , "nombre_tarjeta" , FILTER_SANITIZE_SPECIAL_CHARS);

    $numero_tarjeta = filter_input(INPUT_POST , "numero_tarjeta" , FILTER_SANITIZE_NUMBER_INT);
    $numero_tarjeta = filter_var($numero_tarjeta , FILTER_VALIDATE_INT);

    $CCV = filter_input(INPUT_POST , "CCV" , FILTER_SANITIZE_NUMBER_INT);
    $CCV = filter_var($CCV , FILTER_VALIDATE_INT);

    if (!$numero_tarjeta || !$CCV ) {
        echo "Error en los datos de su tarjeta , vuelva a añadirlos";
        echo "<a href='/Ejercicios_RA4/Ejercicio4/Pagina_pago.php'>Hazlo pulsando aqui</a>";
        exit();
    }

    $usuario = $_SESSION['nombre_usuario'];
    echo "<h1> Este es el final $usuario, tu pedido es el siguiente :</h1> <br><br> ";



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
    
        echo "El total es : $precio_carrito € <br>";

        echo "Sus datos del pago : <br>";
        echo "Numero de tarjeta: $numero_tarjeta <br>";
        echo "Nombre a cargo de la tarjeta: $nombre_tarjeta <br>";
        echo "CCV: $CCV <br>" ;

        echo "¿Quieres hacer otro pedido? ¡Pues pulsa el botón! Pero recuerda que cerraras sesion al hacerlo y tendras que volver a registarte <br>";
        echo "Nos vemos pronto $usuario <br> <br> <br>";    

        $caducidad = gmdate("D, d M Y G:i:s", time() + 60 * 60 * 3) . " GMT";
        header("Expires: {$caducidad}");
    }
}






?>
<form action="/Ejercicios_RA4/Ejercicio4/Pagina_carrito.php" method="post">
<fieldset>
    <legend>Cerrar sesion</legend>
    <input type="submit" name="operacion" id="operacion" value="cerrar">
</fieldset>
</form>
<?php 

fin_html();

?>