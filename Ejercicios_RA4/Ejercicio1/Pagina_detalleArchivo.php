<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['directorio']) && isset($_POST['archivo'])) {

    $directorio = filter_input(INPUT_POST , "directorio" , FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $archivo = filter_input(INPUT_POST , "archivo" , FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $archivo = basename($archivo);
    echo "$directorio <br>";
    echo "$archivo <br>";

    $ruta = $directorio . "/" . $archivo;
    echo "$ruta";
    if (file_exists($ruta)) {
        $tipo_mime = mime_content_type($ruta);
        $fecha_creacion = date("d/m/Y H:i:s" , filemtime($ruta));
        $tamaño_gigas = filesize($ruta) / (1024 * 1024 * 1024);

      
        inicio_html("Detalles Archivo" , ["/estilos/formulario.css"]);
        ?>
        <h1>Detalles del archivo</h1>

     <ul>
        <li>nombre : <?= $archivo?></li>
        <li>tamaño : <?= $tamaño_gigas?></li>
        <li>fecha de creación : <?=$fecha_creacion?></li>
        <li>tipo mime : <?=$tipo_mime?></li>
        <li>ruta del archivo : <?= $ruta ?></li>

    </ul>

    
    <br>
    <a href='Pagina_principal.php'>Volver a la pagina principal</a>
    <br>
    <a href="Pagina_descargar.php?directorio=<?= urlencode($directorio) ?>&archivo=<?= urlencode($archivo) ?>">Pulsa aquí para descargar tu archivo</a>

    <?php
    fin_html();

    }else{
        echo "<p>ERROR EL ARCHIVO NO EXISTE</p> <BR>";

        echo "<a href='Pagina_principal.php'>Volver a la pagina principal</a>";
        
    }

}else{
    echo "<p>ERROR PARAMETRO INCORRECTOS</p> <BR>";

    echo "<a href='Pagina_principal.php'>Volver a la pagina principal</a>";
}

    




?>


