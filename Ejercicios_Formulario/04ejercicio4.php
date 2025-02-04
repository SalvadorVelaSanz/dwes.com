<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");

inicio_html("Ejercicio 4 " , ["/estilos/general.css" , "/estilos/formulario.css"]);


function calcular_financiacion($precio_total , $meses){

$cuota_inicial= $precio_total * 0.25;
$cuota_final= $precio_total * 0.25;
$resto = $precio_total - $cuota_inicial - $cuota_final ;
$resultado = $resto / $meses ;  

return $resultado;

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_NUMBER_INT);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    // Validación de email
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email no válido.";
        exit;
    }

    list($modelo_nombre, $modelo_precio) = explode("-", filter_input(INPUT_POST, 'modelo', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $modelo_precio = floatval($modelo_precio);

    list($motor_nombre, $motor_precio) = explode("-", filter_input(INPUT_POST, 'motor', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $motor_precio = floatval($motor_precio);

    list($pintura_nombre, $pintura_precio) = explode("-", filter_input(INPUT_POST, 'pintura', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $pintura_precio = floatval($pintura_precio);

    $extras = filter_input(INPUT_POST, 'extras', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY) ?? [];
    $precio_extras = 0;
    foreach ($extras as $extra) {
        list($extra_nombre, $extra_precio) = explode("-", filter_var($extra, FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $precio_extras += floatval($extra_precio);
    }

    $precio_total = $modelo_precio + $motor_precio + $pintura_precio + $precio_extras;


    echo "REGISTRO DEL PEDIDO <br>";
    echo "tu nombre es : $nombre <br>";
    echo "tu telefono es : $telefono <br>";
    echo "tu email es : $email <br>";

    echo "DATOS DEL COCHE <br>";
    echo "El modelo elegido es : $modelo_nombre y su precio es $modelo_precio € <br>" ;
    echo "El motor elegido es : $motor_nombre y su precio es $motor_precio € <br>";
    echo "La pintura elegida es : $pintura_nombre y su precio es $pintura_precio € <br>";
    echo "los extras que has elegido son : <br>";
    foreach ($extras as $extra) {
        list($extra_nombre, $extra_precio) = explode("-", filter_var($extra, FILTER_SANITIZE_FULL_SPECIAL_CHARS));
       echo "$extra_nombre y su precio es $extra_precio <br>";
    }

    if (isset($_POST['financiado']) && $_POST['financiado'] == 'si') {
        
        $meses = filter_input(INPUT_POST, 'meses', FILTER_SANITIZE_NUMBER_INT);
        if ($meses && ctype_digit($meses)) {
            $financiacion = calcular_financiacion($precio_total, $meses);
            echo "La cuota de financiación es $financiacion <br>";
        } else {
            echo "Meses de financiación no válidos.<br>";
        }
        
    }

    echo "El precio final del coche es :  $precio_total <br>";

}else{

?>

<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">


<fieldset>
        <legend>Datos personales</legend>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required><br>

        <label for="telefono">Teléfono:</label>
        <input type="tel" name="telefono" id="telefono" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>
    </fieldset>

    <fieldset>
        <legend>Configuración del coche</legend>

        <label for="modelo">Modelo:</label>
        <select name="modelo" id="modelo" required>
            <option value="Monroy - 20000 ">Monroy – 20000 €</option>
            <option value="Muchopami - 21000 ">Muchopami – 21000 €</option>
            <option value="Zapatoveloz - 22000">Zapatoveloz – 22000 €</option>
            <option value="Guperino - 25500 ">Guperino – 25500 €</option>
            <option value="Alomejor - 29750 ">Alomejor – 29750 €</option>
            <option value="Telapegas - 32550 ">Telapegas – 32550 €</option>
        </select><br>

        <label>Motor:</label><br>
        <input type="radio" name="motor" value="Gasolina - 0 " required> Gasolina - 0 €<br>
        <input type="radio" name="motor" value="Diesel - 2000 " > Diesel - 2000 €<br>
        <input type="radio" name="motor" value="Híbrido - 5000 "> Híbrido - 5000 €<br>
        <input type="radio" name="motor" value="Electrico - 10000 "> Eléctrico - 10000 €<br>

        <label for="pintura">Pintura:</label>
        <select name="pintura" id="pintura" required>
            <option value="Gris triste - 0">Gris triste – Sin coste</option>
            <option value="Rojo sangre - 250 ">Rojo sangre – 250 €</option>
            <option value="Rojo pasión - 150 ">Rojo pasión – 150 €</option>
            <option value="Azul noche - 175 ">Azul noche – 175 €</option>
            <option value="Caramelo - 300 ">Caramelo – 300 €</option>
            <option value="Mango - 275 ">Mango – 275 €</option>
        </select><br>

        <label>Extras:</label><br>
        <input type="checkbox" name="extras[]" value="Navegador GPS - 500"> Navegador GPS – 500 €<br>
        <input type="checkbox" name="extras[]" value="Calefacción asientos - 250"> Calefacción asientos – 250 €<br>
        <input type="checkbox" name="extras[]" value="Antena aleta tiburón - 50"> Antena aleta tiburón – 50 €<br>
        <input type="checkbox" name="extras[]" value="Acceso y arranque sin llave - 150"> Acceso y arranque sin llave – 150 €<br>
        <input type="checkbox" name="extras[]" value="Arranque en pendiente - 150"> Arranque en pendiente – 200 €<br>
        <input type="checkbox" name="extras[]" value="Cargador inalámbrico - 300"> Cargador inalámbrico – 300 €<br>
        <input type="checkbox" name="extras[]" value="Control de crucero - 500"> Control de crucero – 500 €<br>
        <input type="checkbox" name="extras[]" value="Detectar ángulo muerto - 350"> Detectar ángulo muerto – 350 €<br>
        <input type="checkbox" name="extras[]" value="Faros led automáticos - 400"> Faros led automáticos – 400 €<br>
        <input type="checkbox" name="extras[]" value="Frenada emergencia - 375"> Frenada emergencia – 375 €<br>
    </fieldset>

    <fieldset>
        <legend>Pago</legend>
        <label>¿Pago financiado?:</label><br>
        <input type="radio" name="financiado" value="si"> Sí<br>
        <input type="radio" name="financiado" value="no" checked> No<br>

        <label>Meses de financiación:</label><br>
        <input type="radio" name="meses" value="24"> 2 años<br>
        <input type="radio" name="meses" value="60"> 5 años<br>
        <input type="radio" name="meses" value="120"> 10 años<br>
    </fieldset>

    <input type="submit" value="Enviar">
</form>






<?php
}
fin_html();

?>