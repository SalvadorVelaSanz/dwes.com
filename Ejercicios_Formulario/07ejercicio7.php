<?php

define("DIRECTORIO_PDF" , $_SERVER['DOCUMENT_ROOT'] . "/curriculums");

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");

inicio_html("EJERCICIO 7" , ["/estilos/general.css" , "/estilos/formulario.css"]);

if ($_SERVER['REQUEST_METHOD'] =='POST') {
    
    $dni = filter_input(INPUT_POST , 'dni' , FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (preg_match("/[0-9]{8}[A-Z]/" , $dni )) {
        // dni correcto
    }else{
        echo "DNI INCORRECTO";
        exit();
    }

    $nombre = filter_input(INPUT_POST , 'nombre' , FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;
    $limite_pdf = filter_input(INPUT_POST , 'limite_pdf' , FILTER_SANITIZE_NUMBER_INT);
    $limite_pdf = filter_var($limite_pdf , FILTER_VALIDATE_INT);

    $aceptacion = isset($_POST['aceptacion']) && $_POST['aceptacion'] == 1 ? 1 : 0 ;




    if ($aceptacion == 1) {
        
        if (!is_dir(DIRECTORIO_PDF)) {
            if (!mkdir(DIRECTORIO_PDF, 0750)) {
                echo "<h3>ERROR NO SE HA PODIDO CREAR EL DIRECTORIO DE SUBIDA</h3>";
            }else{
                echo "<h3><DIRECTORIO DE SUBIDA CREADO SIN PROBLEMAS/h3>";
            }
        }

        if (isset($_FILES['curriculum'])) {

            if ($_FILES['curriculum']['error'] == UPLOAD_ERR_NO_FILE) {
                echo "no has subido el archivo";
            }elseif ($_FILES['curriculum']['error'] == UPLOAD_ERR_INI_SIZE) {
                echo "<h3>Error supera el limite definifo por upload_file_size</h3>";
            }elseif ($_FILES['curriculum']['error'] == UPLOAD_ERR_FORM_SIZE) {
                echo "<h3>Error supera el limite definifo por MAX_file_size</h3>";
            }elseif ($_FILES['curriculum']['size']> $limite_pdf) {
                echo "<h3>Error supera los $limite_pdf bytes/h3>";
            }else{

                $tipos_permitidos = ["application/pdf"];

                $tipo_mime1 = mime_content_type($_FILES['curriculum']['tmp_name']);

                $file_info = finfo_open(FILEINFO_MIME_TYPE);

                $tipo_mime2 = finfo_file($file_info , $_FILES['curriculum']['tmp_name']);

                finfo_close($file_info);

                $tipo_mime3 = $_FILES['curriculum']['type'];

                if ($tipo_mime1 == $tipo_mime2 && $tipo_mime2 == $tipo_mime3 && in_array($tipo_mime1 , $tipos_permitidos)) {
               
                    $nombre_archivo = DIRECTORIO_PDF . "/" . $dni . ".pdf";

                    if (move_uploaded_file($_FILES['curriculum']['tmp_name'] , $nombre_archivo)) {

                        echo "<h2>ARCHIVO guardado CON EXITO</h2>";
                    }else {
                        echo "Error al guardar el archivo";
                    }
                }else {
                    echo "Tipo de archivo no permitido debe de ser pdf";
                }                
            }
        }   
    }else{
        echo "<h3>ACEPTA LOS REGISTROS PERSONALES PARA PPODER SUBIR EL ARCHIVO</h3>";
        $dniError = $dni;
        $nombreError = $nombre;
    }
}


?>

<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">


<fieldset>

<legend>Datos del solicitante</legend>

<input type="hidden" name="MAX_FILE_SIZE" id="MAX_FILE_SIZE" value="<?=1024*1024?>">

<label for="dni">DNI</label>
<input type="text" name="dni" id="dni" value="<?=isset($dniError) ? $dniError : ""?>" pattern="[0-9]{8}[A-Z]" title="8 numeros y una letra mayuscula">

<input type="hidden" name="limite_pdf" id="limite_pdf" value="<?=1024*1024?>">
<label for="curriculum">Curriculum</label>
<input type="file" name="curriculum" id="curriculum" accept="application/pdf">

<label for="nombre">Nombre</label>
<input type="text" name="nombre" id="nombre"  value="<?=isset($nombreError) ? $nombreError : ""?>">

<label for="aceptacion">Aceptación de registros personales</label>
<input type="checkbox" name="aceptacion" id="aceptacion" value="1">
</fieldset>

<input type="submit" name="operacion" id="operacion"  value="Enviar">



</form>


<?php

fin_html();

?>