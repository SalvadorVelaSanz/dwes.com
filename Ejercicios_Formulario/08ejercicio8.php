<?php

define('DIRECTORIO_BASE', $_SERVER['DOCUMENT_ROOT'] . "/fotos");

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");

inicio_html("Ejercicio 8 ", ["/estilos/general.css", "/estilos/formulario.css", "/estilos/tablas.css"]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    

    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $limite_png = filter_input(INPUT_POST, 'limite_png', FILTER_SANITIZE_NUMBER_INT);
    $limite_png = filter_var($limite_png , FILTER_VALIDATE_INT);

    $limite_jpg = filter_input(INPUT_POST, 'limite_jpg', FILTER_SANITIZE_NUMBER_INT);
    $limite_jpg = filter_var($limite_jpg , FILTER_VALIDATE_INT);

    $limite_webp = filter_input(INPUT_POST, 'limite_webp', FILTER_SANITIZE_NUMBER_INT);
    $limite_webp = filter_var($limite_webp , FILTER_VALIDATE_INT);

    if (preg_match("/^[a-z0-9]+$/", $login)) {
        echo "El campo es válido";
    } else {
        echo "El campo solo debe contener letras minúsculas y números.";
        exit;
    }

    $directorio_usuario =  DIRECTORIO_BASE . "/$login";
    if (!is_dir($directorio_usuario)) {
        if (!mkdir($directorio_usuario, 0750)) {
            echo "Error";
        } else {
            echo "El directorio de subida se ha creado correctamente";
        }
    }

    if (isset($_FILES['archivo_foto'])) {

        if ($_FILES['archivo_foto']['error'] == UPLOAD_ERR_NO_FILE) {
            echo "no has subido el archivo";
        } elseif ($_FILES['archivo_foto']['error'] == UPLOAD_ERR_INI_SIZE) {
            echo "El archivo a superado el valor de upload_file_size ";
        } elseif ($_FILES['archivo_foto']['error'] == UPLOAD_ERR_FORM_SIZE) {
            echo "El archivo a superado el valor de MAX_FILE_SIZE";
        } else {
            // Obtener la extensión del archivo subido
            $partes = explode('.', $nombre_archivo);
            $extension = strtolower(end($partes)); // Obtiene la última parte como extensión
            $archivo_tamaño = $_FILES['archivo_foto']['size'];

            // Aplicar los límites según la extensión
            if ($extension === "png" && $archivo_tamaño > $limite_png) {
                echo "El archivo PNG ha superado el límite de tamaño permitido.";
            } elseif ($extension === "jpg" && $archivo_tamaño > $limite_jpg) {
                echo "El archivo JPG ha superado el límite de tamaño permitido.";
            } elseif ($extension === "webp" && $archivo_tamaño > $limite_webp) {
                echo "El archivo WEBP ha superado el límite de tamaño permitido.";
            } else {
                echo "El archivo cumple con los requisitos de tamaño y tipo.";



                $tipos_permitidos = ['image/png', 'image/jpeg', 'image/webp'];

                $tipo_mime1 = mime_content_type($_FILES['archivo_foto']['tmp_name']);

                $file_info = finfo_open(FILEINFO_MIME_TYPE);
                $tipo_mime2 = finfo_file($file_info, $_FILES['archivo_foto']['tmp_name']);
                finfo_close($file_info);

                $tipo_mime3 =  $_FILES['archivo_foto']['type'];

                if ($tipo_mime1 == $tipo_mime2 && $tipo_mime2 == $tipo_mime3 && in_array($tipo_mime1, $tipos_permitidos)) {

                    $nombre_archivo = $directorio_usuario . "/" . $_FILES['archivo_foto']['name'];

                    if (move_uploaded_file($_FILES['archivo_foto']['tmp_name'], $nombre_archivo)) {
                        echo "archivo subido son problemas";
                    } else {
                        echo "error al subir el archivo";
                    }
                }else {
                   echo "error con los tipos permitidos"; 
                }
            }
        }
    }

    if (is_dir($directorio_usuario)) {
        $archivos_subidos = scandir($directorio_usuario);
        echo "<h2>Archivos subidos:</h2>";
        echo "<table border='1'>";
        echo "<thead>";
        echo "<tr><th>Nombre del Archivo</th><th>Tamaño (KB)</th></tr>";
        echo "</thead>";
        echo "<tbody>";
        foreach ($archivos_subidos as $archivo) {
            if ($archivo !== '.' && $archivo !== '..') {
                $ruta_archivo = $directorio_usuario . "/" . $archivo;
                $tamaño_archivo = filesize($ruta_archivo) / 1024; // Convertir a KB
                echo "<tr>";
                echo "<td>" . htmlspecialchars($archivo) . "</td>";
                echo "<td>" . round($tamaño_archivo, 2) . " KB</td>";
                echo "</tr>";
            }
        }
        echo "</tbody>";
        echo "</table>";

        
    }

}



?>


<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">

    <fieldset>
        <legend>Subida de imagenes</legend>

        <label for="login">login</label>
        <input type="text" name="login" id="login">

        <input type="hidden" name="MAX_FILE_SIZE" value="<?= 1024 * 1024 ?>">

        <input type="hidden" name="limite_png" value="<?= 225 * 1024 ?>">
        <input type="hidden" name="limite_jpg" value="<?= 250 * 1024 ?>">
        <input type="hidden" name="limite_webp" value="<?= 200 * 1024 ?>">

        <label for="archivo_foto">Foto</label>
        <input type="file" name="archivo_foto" id="archivo_foto" accept="image/png , image/jpg , image/webp">

        <label for="titulo">Titulo</label>
        <input type="text" name="titulo" id="titulo">

    </fieldset>
    <input type="submit" name="operacion" id="operacion" value="enviar">




</form>


<?php

fin_html();



?>