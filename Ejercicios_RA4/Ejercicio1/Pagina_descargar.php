<?php
if ( isset($_GET['directorio']) && isset($_GET['archivo'])) {
    
    $directorio = filter_input(INPUT_GET , "directorio" , FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $archivo = filter_input(INPUT_GET , "archivo" , FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $archivo = basename($archivo);
    echo "$directorio <br>";
    echo "$archivo <br>";
    $ruta = $directorio . "/" . $archivo;
    echo "$ruta";
    if (file_exists($ruta)) {
        $tipo_mime = mime_content_type($ruta);
        $fecha_creacion = date("d/m/Y H:i:s" , filemtime($ruta));
        $tamaño_gigas = filesize($ruta) / (1024 * 1024 * 1024);
    
        
//  header("Content-length: " . filesize(DIRECTORIO_ARCHIVOS . "/$archivo_saneado"));
    }else{
        echo "<p>ERROR EL ARCHIVO NO EXISTE</p>";
    }
}else{
    echo "<p>ERROR DATOS DE SOLICUTD INCORRECTOS</p>";
}


?>