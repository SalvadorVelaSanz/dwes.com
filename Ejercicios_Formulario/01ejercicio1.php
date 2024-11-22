<?php 


require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");


inicio_html("Ejercicio 1" , [ "/estilos/formularios.css" ,"/estilos/general.css"  ]);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (isset($_POST['numero']) && intval($_POST['numero']) && is_numeric($_POST['numero'])) {
        $numero = htmlspecialchars($_POST['numero']);
        $numeroBinario = decbin($numero);
        $numeroOctal = decoct($numero);
        $numeroHexadecimal = dechex($numero);
        
        echo "tu numero en octal es : $numeroOctal <br>";
        echo "tu numero en binario es: $numeroBinario <br>";
        echo " tu numero en hexadecimal es : $numeroHexadecimal <br>";
        echo "tu numero en decimal es : $numero";
    }else{
        echo "ha habido un error";
    }

    

}



?>


<form action= "<?= $_SERVER['PHP_SELF'] ?>" method="post">

<label for="numero">numero entero a convertir</label>
<input type="number" name="numero" id="numero">

<input type="submit" name="operacion" id="operacion" value="enviar">



</form>


<?php 

fin_html();

?>