<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");

inicio_html("Ejercicio 3", ["/estilos/general.css", "/estilos/formulario.css"]);
$ingredientes_info = [
    "Pepino" => "1",
    "Calabacin" => "1.5",
    "Pimiento verde" => "1.25",
    "Pimiento rojo" => "1.75",
    "Tomate" => "1.5",
    "Aceitunas" => "3",
    "Cebolla" => "1",
    "Atun" => "2",
    "Carne picada" => "2.5",
    "Pepperoni" => "1.75",
    "Morcilla" => "2.25",
    "Anchoas" => "1.5",
    "Salmon" => "3",
    "Gambas" => "4",
    "Langostinos" => "4",
    "Mejillones" => "2",
];

function calcular_precio($tipo_pizza, $precio_ingredientes, $cantidad)
{
  

    $precio_base = 5;

    if ($tipo_pizza == "vegetariana") {
        $precio_base += 3;
    } elseif ($tipo_pizza == "no vegetariana") {
        $precio_base += 2;
    }else{
       echo "ERROR EN EL TIPO DE PIZZA";
       exit();
    }

    $precio_base += $precio_ingredientes; 
   

    return $precio_base * $cantidad;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitización y validación de datos
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);
    $direccion = filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_NUMBER_INT);
    $telefono = preg_match("/[0-9]{9}/", $telefono) == 0 ? "": $telefono;

    $tipo_pizza = filter_input(INPUT_POST, 'tipo_pizza', FILTER_SANITIZE_SPECIAL_CHARS);

    // Sanitizar los ingredientes como un array
    $ingredientes_recibidos = filter_input(INPUT_POST, 'ingredientes', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    $ingredientes = [];
   
    if (is_array($ingredientes_recibidos)) {
        // Sanitización usando foreach
        foreach ($ingredientes_recibidos as $key => $ingrediente) {
            if (array_key_exists($key , $ingredientes_info)) {
               $ingredintes[$key] = $ingrediente;
                break;
            }
        }
    } else {
        $ingredientes = []; 
    }

    $extra_queso = isset($_POST['extra_queso']) ? "si" : "no";
    $bordes_rellenos = isset($_POST['bordes_rellenos']) ? "si" : "no";

    // Validar número de pizzas
    $cantidad = filter_input(INPUT_POST, 'numero_pizzas' , FILTER_SANITIZE_SPECIAL_CHARS);
    $cantidad = filter_var($cantidad, FILTER_VALIDATE_INT, [
        'options' => [
            'default' => 1,
            'min_range' => 1,
            'max_range' => 5
        ]
    ]);

    $precio_ingredientes=0;
    foreach ($ingredientes as $ingrediente) {
       
        $precio_ingredientes += floatval($ingredientes_info[$ingrediente]);
        
    }
    // Calcular precio total
    $precio_total = calcular_precio($tipo_pizza, $precio_ingredientes, $cantidad);

    // Mostrar resumen del pedido
    echo "RESUMEN DE SU PEDIDO <br>";
    echo "Nombre: $nombre <br>";
    echo "Dirección: $direccion <br>";
    echo "Teléfono: $telefono <br>";
    echo "Tipo de Pizza: $tipo_pizza <br>";
    echo "Ingredientes: <br>";
    foreach ($ingredientes as $ingrediente) {
        echo " $ingrediente <br>";
    }
    echo "<br> Extra de queso: $extra_queso";
    echo "<br> Bordes rellenos: $bordes_rellenos";
    echo "<br> Número de pizzas pedidas: $cantidad";
    echo "<br> Precio total: $precio_total €";
    echo "<br> <a href='{$_SERVER['PHP_SELF']}'>Hacer otro pedido</a>";
}

?>

<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
    <fieldset>
        <legend>Datos personales</legend>
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" required>

        <label for="direccion">Dirección</label>
        <input type="text" name="direccion" id="direccion" required>

        <label for="telefono">Teléfono</label>
        <input type="text" name="telefono" id="telefono" required>
    </fieldset>

    <fieldset>
        <legend>Pizza</legend>
        <label for="tipo_pizza">Tipo de Pizza</label>
        <div>
            <input type="radio" name="tipo_pizza" id="tipo_pizza_VEG" value="vegetariana" required> Vegetariana <br>
            <input type="radio" name="tipo_pizza" id="tipo_pizza_NOVEG" value="no vegetariana"> No Vegetariana
        </div>

        <label for="ingredientes_veg"></label>
        <select name="ingredientes[]" id="ingredientes_veg" multiple>
            <option value="Pepino">Pepino - 1€</option>
            <option value="Calabacin">Calabacin - 1,5€</option>
            <option value="Pimiento verde">Pimiento verde - 1,25€ </option>
            <option value="Pimiento rojo">Pimiento rojo - 1,75€</option>
            <option value="Tomate">Tomate - 1.5€</option>
            <option value="Aceitunas">Aceitunas - 3€</option>
            <option value="Cebolla">Cebolla - 1€</option>
        </select>

        <label for="ingredientes_noveg"></label>
        <select name="ingredientes[]" id="ingredientes_noveg" multiple>
            <option value="Atun">Atun - 2€</option>
            <option value="Carne picada">Carne picada - 2,5€</option>
            <option value="Peperoni">Peperoni - 1,75€ </option>
            <option value="Morcilla">Morcilla - 2,25€</option>
            <option value="Anchoas">Anchoas - 1,5 €</option>
            <option value="Salmon">Salmón - 3 €</option>
            <option value="Gambas">Gambas - 4 €</option>
            <option value="Langostinos">Langostinos - 4 €</option>
            <option value="Mejillones">Mejillones - 2 €</option>
        </select>

        <label for="extra_queso">Extra de Queso</label>
        <input type="checkbox" name="extra_queso" id="extra_queso">

        <label for="bordes_rellenos">Bordes Rellenos</label>
        <input type="checkbox" name="bordes_rellenos" id="bordes_rellenos">

        <label for="numero_pizzas">Número de Pizzas</label>
        <input type="number" name="numero_pizzas" id="numero_pizzas" min="1" max="5" value="1" required>
    </fieldset>

    <input type="submit" name="operacion" id="operacion" value="Enviar">
</form>

<?php
fin_html();
?>