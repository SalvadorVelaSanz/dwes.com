<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");

if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['directorio'])) {
    $directorio_usuario = filter_input(INPUT_POST , "directorio" , FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $directorio = $_SERVER['DOCUMENT_ROOT'] . "/$directorio_usuario";

    if (is_dir($directorio)){
        $archivos = scandir($directorio);
        $imagenes = [];
        $tipos_permitidos = ["png" , "jpg" , "webp"]; 

        foreach ($archivos as $archivo ) {
            $ruta = $directorio . "/" . $archivo;
            $nombre_archivo = basename($archivo);

            $partes = explode('.', $nombre_archivo);
            $extension = strtolower(end($partes)); 

            if (is_file($ruta) && in_array($extension , $tipos_permitidos)) {
                $imagenes[] = $archivo;
            }

        }

        inicio_html("Listado de imagenes" , ["/estilos/formulario.css"]);

        ?>

        <form action="/Ejercicios_RA4/Ejercicio2/Pagina_visualizar.php" method="post">

        <fieldset>

        <legend>Seleccion de imagenes</legend>
   

        <label for="Imagen">Selecciona las imagenes que quieras visualizar</label>

        <?php
        if (empty($imagenes)) {
            echo "<p>NO hay imaganes para mostrar</p>";
        }else{
            foreach ($imagenes as $key => $imagen) {
                echo "<input type='checkbox' name='imagenes[]' id='imagenes' value='$imagen'> $imagen";
            }
            echo "<input type='hidden' name='directorio' id='directorio' value='$directorio'>";
            echo "<input type='submit' name='operacion' id='operacion'>";
        }
        ?>
        </fieldset>
        </form>

        <?php
    fin_html();


    }else{
        echo "<p> NO ES UN DIRECTORIO</p>";
        echo "<p> <a href='/Ejercicios_RA4/Ejercicio2/Pagina_principal.php'>Volver al inicio</a></p>";
    }


}else{
    echo "<p> ERROR AL PASAR LOS DATOS </p>";
    echo "<p> <a href='/Ejercicios_RA4/Ejercicio2/Pagina_principal.php'>Volver al inicio</a></p>";
}



?>