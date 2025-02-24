<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $operacion = filter_input(INPUT_GET, "operacion", FILTER_SANITIZE_SPECIAL_CHARS);

    if ($operacion == 'cerrar') {
        $nombre_id = session_name();
        $parametros_cookie = session_get_cookie_params();
        setcookie(
            $nombre_id,
            '',
            time() - 10000,
            $parametros_cookie['path'],
            $parametros_cookie['domain'],
            $parametros_cookie['secure'],
            $parametros_cookie['httponly']
        );

        session_unset();
        session_destroy();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['operacion'] == 'Empezar pedido') {
    $nombre = filter_input(INPUT_POST, "nombre", FILTER_SANITIZE_SPECIAL_CHARS);
    $direccion = filter_input(INPUT_POST, "direccion", FILTER_SANITIZE_SPECIAL_CHARS);
    $telefono = filter_input(INPUT_POST, "telefono", FILTER_SANITIZE_NUMBER_INT);
    $tipo_pizza = filter_input(INPUT_POST, "tipo_pizza", FILTER_SANITIZE_SPECIAL_CHARS);

    $_SESSION['nombre'] = $nombre;
    $_SESSION['direccion'] = $direccion;
    $_SESSION['telefono'] = $telefono;
    $_SESSION['tipo_pizza'] = $tipo_pizza;    
    $_SESSION['precio'] = $_SESSION['tipo_pizza'] == "vegetariana" ? 7 : 5;

    header("Location: /Ejercicios_RA4/Ejercicio3/Pagina_ingredientes.php");
    exit(); 
}

inicio_html("Pizzeria PEPE", ["/estilos/formulario.css"]);
?>
<p>Se informa de que todas las pizzas llevan tomate frito y queso con un coste de 5€, Las pizzas vegetarianas cuestan 2€ más.</p>
<form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
    <fieldset>
        <legend>Pagina de registro</legend>

        <label for="nombre"> Nombre</label>
        <input type="text" name="nombre" id="nombre">

        <label for="direccion">Direccion</label>
        <input type="text" name="direccion" id="direccion">

        <label for="telefono">Telefono</label>
        <input type="text" name="telefono" id="telefono">

        <label for="tipo_pizza">Tipo de Pizza</label>
        <div>
            <input type="radio" name="tipo_pizza" id="tipo_pizza_VEG" value="vegetariana" required> Vegetariana <br>
            <input type="radio" name="tipo_pizza" id="tipo_pizza_NOVEG" value="no vegetariana"> No Vegetariana
        </div>
    </fieldset>

    <input type="submit" name="operacion" id="operacion" value="Empezar pedido">
</form>
<?php
fin_html();
?>
