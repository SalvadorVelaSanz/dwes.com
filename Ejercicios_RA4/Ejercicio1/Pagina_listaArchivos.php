<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['directorio'])) {

    $directorio_usuario = filter_input(INPUT_POST, "directorio", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $directorio = $_SERVER['DOCUMENT_ROOT'] . "/$directorio_usuario";

    if (is_dir($directorio)) {

        $archivos = scandir($directorio);
        inicio_html("listado de archivos", ["/estilos/formulario.css", "/estilos/tablas.css"]);
?>

        <form action="/Ejercicios_RA4/Ejercicio1/Pagina_detalleArchivo.php" method="post">

            <label for="archivo">Selecciona un archivo</label>

            <select name="archivo" id="archivo">
                <?php
                foreach ($archivos as $archivo) {
                    $ruta_asrchivo = $directorio . "/" . $archivo;
                    if (is_file($ruta_asrchivo)) {
                        echo "<option value='$archivo'>$archivo</option>";
                    }
                }
                ?>
            </select>

            <input type="hidden" name="directorio" id="directorio" value="<?= $directorio ?>">
            <input type="submit" name="operacion" id="operacion">
        </form>

        <p><a href="Pagina_principal.php">Volver a la pantalla inicial</a></p>

<?php
        fin_html();
    } else {
        echo "ERROR EL DIRECTORIO NO EXISTE";
        echo "p><a href='Pagina_principal.php'>Volver a la pantalla inicial</a></p>";
    }
} else {
    echo "ERROR NO SE HA PROPORCIONADO NINGUN DIRECTORIO";
    echo "p><a href='Pagina_principal.php'>Volver a la pantalla inicial</a></p>";
}



?>



<?php



?>