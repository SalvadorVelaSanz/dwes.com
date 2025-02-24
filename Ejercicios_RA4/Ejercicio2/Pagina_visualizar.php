<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");

// Verificar que los datos lleguen correctamente por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['directorio']) && isset($_POST['imagenes'])) {
    $directorio = filter_input(INPUT_POST, 'directorio', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $imagenes = filter_input(INPUT_POST, 'imagenes', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

    // Validar que el directorio sea válido
    if (!is_dir($directorio)) {
        echo "<p>El directorio proporcionado no es válido.</p>";
        echo "<p><a href='/Ejercicios_RA4/Ejercicio2/Pagina_principal.php'>Volver al inicio</a></p>";
        exit;
    }

    // Recorrer las imágenes seleccionadas y devolverlas al navegador
    foreach ($imagenes as $imagen) {
        $imagen = basename($imagen); // Prevenir rutas absolutas maliciosas
        $ruta = $directorio . "/" . $imagen;

        if (is_file($ruta)) {
            // $tipo_mime = mime_content_type($ruta); // Obtener el tipo MIME
            // header("Content-Type: $tipo_mime");
            // readfile($ruta);

            
            $ruta_relativa = str_replace($_SERVER['DOCUMENT_ROOT'], '', $directorio . '/' . $imagen);
            echo "<img src='$ruta_relativa' alt='Imagen' style='max-width:300px;max-height:300px;'>";
            echo "<br>$ruta_relativa";

            // $tipo_mime = mime_content_type($ruta);
            // $contenido = base64_encode(file_get_contents($ruta)); // Codifica la imagen en base64
            // echo "<figure>";
            // echo "<img src='data:$tipo_mime;base64,$contenido' alt='Imagen' style='max-width:300px;max-height:300px;'>";
            // echo "<figcaption>$imagen</figcaption>";
            // echo "</figure>";
            // Añadir separación entre imágenes para navegadores
            echo "<hr>";
        } else {
            echo "<p>No se pudo encontrar la imagen: $imagen</p>";
        }


    }
    echo "<p><a href='/Ejercicios_RA4/Ejercicio2/Pagina_principal.php'>Volver al inicio</a></p>";
} else {
    echo "<p>No se recibieron datos válidos.</p>";
    echo "<p><a href='/Ejercicios_RA4/Ejercicio2/Pagina_principal.php'>Volver al inicio</a></p>";
}
