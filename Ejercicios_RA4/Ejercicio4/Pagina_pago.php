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


if ($_SERVER['REQUEST_METHOD'] =='POST' && isset($_SESSION['nombre_usuario']) && $_SESSION['nombre_usuario'] !== "error") {




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
        echo "No hay nada en el carrito de momento, deberias de añadir algo ;)";
        echo "<a href='/Ejercicios_RA4/Ejercicio4/Pagina_carrito.php'>Hazlo pulsando aqui</a>";
    }
}


?>

<form action="/Ejercicios_RA4/Ejercicio4/Pagina_final.php" method="post">

<fieldset>
<legend>Credenciales bancarias</legend>

<label for="nombre_tarjeta">Nombre del titular de la tarjeta</label>
<input type="text" name="nombre_tarjeta" id="nombre_tarjeta">

<label for="numero_tarjeta">Numero de la tarjeta de credito (SIN ESPACIOS)</label>
<input type="text" name="numero_tarjeta" id="numero_tarjeta">

<label for="CCV">CCV</label>
<input type="text" name="CCV" id="CCV">

</fieldset>

<input type="submit" name="operacion" id="operacion" value="Pagar">



</form>

<?php

fin_html();

?>