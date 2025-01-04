<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");



if (!isset($_SESSION['usuario']) || ($_SESSION['usuario'] !== "pepe" && $_SESSION['usuario'] !== "manolo")) {
    header("Location: /Ejercicios_RA4/Ejercicio5/Pagina_inicial.php");
    exit();
}

$alumnos = $_SESSION['alumnos'];

inicio_html("Pagina Final" , ["/estilos/formulario.css" , "/estilos/tablas.css"]);

?>

<h1><?= $_SESSION['usuario']?> , Se ha realizado con exito su solicitud </h1>

<h1>Lista de alumnos</h1>
<table>

<tr>
<th>NIF</th>
<th>Nombre</th>
<th>Apellidos</th>
<th>Grupo</th>
</tr>



<?php
foreach ($alumnos as $alumno) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($alumno['nif']) .  "</td>";
    echo "<td>" . htmlspecialchars($alumno['nombre']) .  "</td>";
    echo "<td>" . htmlspecialchars($alumno['apellidos']) .  "</td>";
    echo "<td>" . htmlspecialchars($alumno['grupo']) .  "</td>";
    echo "</tr>";
}

?>


</table>

<br> <br>
<h2>Su precio total a pagar es <?= $_SESSION['precio_total'] ?>€</h2>
<br> <br>

<form action="/Ejercicios_RA4/Ejercicio5/Pagina_inicial.php" method="post">
    <fieldset>
        <legend>Empezar de nuevo y cerrar sesion</legend>
        <input type="submit" name="operacion" id="operacion" value="cerrar">
    </fieldset>
</form>


<?php

fin_html();

?>