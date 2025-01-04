<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");

inicio_html("Ejercicio 6", ["/estilos/general.css", "/estilos/formulario.css", "/estilos/tablas.css"]);

// Inicialización de variables
$email = "";
$autorizo = "no autoriza"; // Valor predeterminado
$cantidad = 0;
$proyecto = "";
$propuesta = "";

$proyectos = [
    "Agua potable" , "Escuela de primaria" ,"Placas solares", "Centro medico"
];

// Recogida y sanitización de datos si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = isset($_POST['email']) ? filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) : "";
    $email = filter_var($email , FILTER_VALIDATE_EMAIL); 

    $autorizo = isset($_POST['autorizo']) && $_POST['autorizo'] == "autoriza" ? "autoriza" : "no autoriza";
    $cantidad = isset($_POST['cantidad']) ? filter_input(INPUT_POST, 'cantidad', FILTER_SANITIZE_NUMBER_INT) : 0;
    $cantidad = filter_var($cantidad , FILTER_VALIDATE_INT);
    $proyecto = isset($_POST['proyecto']) ? filter_input(INPUT_POST, 'proyecto', FILTER_SANITIZE_SPECIAL_CHARS) : "";
    $proyecto = array_key_exists($proyecto , $proyectos) ? $proyecto : "";
    
    $propuesta = isset($_POST['propuesta']) ? filter_input(INPUT_POST, 'propuesta', FILTER_SANITIZE_SPECIAL_CHARS) : "";

    // Mostrar la tabla con los resultados
    echo "<table>
    <thead>
    <tr>
        <th>Email</th>
        <th>Autorización</th>
        <th>Cantidad</th>
        <th>Proyecto</th>
        <th>Propuesta</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>" . htmlspecialchars($email) . "</td>
        <td>" . htmlspecialchars($autorizo) . "</td>
        <td>" . htmlspecialchars($cantidad) . "</td>
        <td>" . htmlspecialchars($proyecto) . "</td>
        <td>" . htmlspecialchars($propuesta) . "</td>
    </tr>
    </tbody>
    </table>";

    echo "<br> <a href='{$_SERVER['PHP_SELF']}'> Vuelve a enviar el formulario</a>";
}

?>

<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
    <fieldset>
        <legend>Datos solicitante</legend>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($email) ?>" >

        <label for="autorizo">Autorizo el registro</label>
        <input type="checkbox" name="autorizo" id="autorizo" <?= $autorizo == "autoriza" ? "checked" : "" ?> />

        <label for="cantidad">Cantidad</label>
        <input type="number" name="cantidad" id="cantidad" value="<?= htmlspecialchars($cantidad) ?>" >
    </fieldset>

    <fieldset>
        <legend>Propuesta</legend>

        <label for="proyecto">Proyecto</label>
        <select name="proyecto" id="proyecto">
            <option value="Agua potable" <?= $proyecto == "Agua potable" ? "selected" : "" ?>>Agua potable</option>
            <option value="Escuela de primaria" <?= $proyecto == "Escuela de primaria" ? "selected" : "" ?>>Escuela de primaria</option>
            <option value="Placas solares" <?= $proyecto == "Placas solares" ? "selected" : "" ?>>Placas solares</option>
            <option value="Centro medico" <?= $proyecto == "Centro medico" ? "selected" : "" ?>>Centro médico</option>
        </select>

        <label for="propuesta">Propuesta</label>
        <textarea name="propuesta" id="propuesta" cols="30" rows="10"><?= htmlspecialchars($propuesta) ?></textarea>
    </fieldset>

    <input type="submit" name="operacion" id="operacion" value="Enviar">
</form>

<?php
fin_html();
?>
