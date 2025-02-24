<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");

if (!isset($_SESSION['nombre']) || !isset($_SESSION['nombre']) || !isset($_SESSION['nombre']) || !isset($_SESSION['nombre'])) {
    header("Location: /Ejercicios_RA4/Ejercicio3/Pagina_inicial");
    exit();

}



$ingredientes_veg = [
    'pep'     => array('nombre' => 'pepino', 'precio' => 1),
    'cal'     => array('nombre' => 'calabacin', 'precio' => 1.5),
    'pimR'     => array('nombre' => 'pimiento rojo', 'precio' => 1.25),
    'pimV'     => array('nombre' => 'pimiento verde', 'precio' => 1.75),
    'tom'     => array('nombre' => 'tomate', 'precio' => 1.5),
    'ace'     => array('nombre' => 'aceituna', 'precio' => 3),
    'ceb'     => array('nombre' => 'cebolla', 'precio' => 1)
];

$ingredientes_no = [
    'at'     => array('nombre' => 'atun', 'precio' => 2),
    'car'     => array('nombre' => 'crane picada', 'precio' => 2.5),
    'pepe'     => array('nombre' => 'peperoni', 'precio' => 1.75),
    'mor'     => array('nombre' => 'morcilla', 'precio' => 2.25),
    'anc'     => array('nombre' => 'anchos', 'precio' => 1.5),
    'sal'     => array('nombre' => 'salmon', 'precio' => 3),
    'gam'     => array('nombre' => 'gambas', 'precio' => 4),
    'lan'     => array('nombre' => 'langostinos', 'precio' => 4)
];

$ingredientes = $_SESSION['tipo_pizza'] == "vegetariana" ? $ingredientes_veg : $ingredientes_no;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $ingrediente_usuario = filter_input(INPUT_POST , "ingrediente" , FILTER_SANITIZE_SPECIAL_CHARS);

    if ($ingrediente_usuario && isset($ingredientes[$ingrediente_usuario])) {
        $detalle = $ingredientes[$ingrediente_usuario];
        $_SESSION['ingredientes'][] = $detalle; 
        $_SESSION['precio'] += $detalle['precio'];
    }

    if (htmlspecialchars($_POST['operacion']) =="siguiente") {
        if (count($_SESSION['ingredientes']) > 0) {
            header("Location: /Ejercicios_RA4/Ejercicio3/Pagina_extras.php");
            exit();
        }else{
            echo "INTRODUCE AL MENOS UN INGREDIENTE";
        }

     
    }


}


inicio_html("Pagina Ingredientes", ["/estilos/formulario.css"]);
?>

<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">


    <fieldset>
        <legend>Selecciona los ingredientes que va a llevar tu pizza</legend>

        <select name="ingrediente" id="ingrediente">
            <?php
            foreach ($ingredientes as $clave => $valor) {
                echo "<option value='$clave'>{$valor['nombre']} - {$valor['precio']} €</option>";
            }
            ?>
        </select>
        <br>
        <p>Al seleccionar añadir otro ingrediente recargara la pagina cuando lo hayas elegido nuevamente y no quieras añadir mas pulsa siguiente</p>
        <input type="submit" name="operacion" id="operacion" value="Añadir otro ingrediente">
        <input type="submit" name="operacion" id="operacion" value="siguiente">

    </fieldset>








</form>