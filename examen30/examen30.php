
<?php
// Salvador Vela Sanz 


require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");



$cursos = [
    "of" => [ "nombre" => "Ofimática" , "precio" => 100 ],
    "pr" => [ "nombre" => "Programación" , "precio" => 200],
    "rep" => [ "nombre" => "Reparación de ordenadores" , "precio" => 150]
];


inicio_html("Examen Salvador Vela" , ["/estilos/general.css" , "/estilos/formulario.css" , "/estilos/tablas.css"]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    // SANEAMIENTO Y VALIDACION DE VARIABLES RECOGIDAS DEL FORMULARIO


    $email = filter_input(INPUT_POST , 'email' , FILTER_SANITIZE_EMAIL );
    $email = filter_var($email , FILTER_VALIDATE_EMAIL);

    $cursos_ok = true;
   
    $cursos_recibidos = filter_input(INPUT_POST , 'cursos' , FILTER_SANITIZE_SPECIAL_CHARS , FILTER_REQUIRE_ARRAY );
    if ($cursos_recibidos !== null) {
        foreach ($cursos_recibidos as $key => $value) {
           if (!array_key_exists($value , $cursos)) {
            $cursos_ok = false;
            echo "<h3>No se han recogido bien los cursos</h3>";
            break;
           } 
        }
    }

    $options=array('options'=>array('default'=>5, 'min_range'=>5, 'max_range'=>10));
    $numero_clases = filter_input(INPUT_POST , 'numero_clases' , FILTER_SANITIZE_NUMBER_INT );
    $numero_clases = filter_var($numero_clases , FILTER_VALIDATE_INT , $options);

    $desempleo = isset($_POST['desempleo']) && $_POST['desempleo'] == 'on' ? $desempleo : false ;
    
    $limite_pdf = filter_input(INPUT_POST , 'limite_pdf' , FILTER_SANITIZE_NUMBER_INT );
    $limite_pdf = filter_var($limite_pdf , FILTER_VALIDATE_INT);
    //VARIABLES SANEADAS Y SANITIZADAS, PROCEDO A CALCULAR EL PRESUPUESTO 

    ob_start();

    $total = 0;

    // SE CALCULA EL TOTAL
    if ($cursos_recibidos !== null) {
        if ($cursos_ok == true && $numero_clases) {
            foreach ($cursos as $key => $value) {
                $total_cursos += $cursos[$cursos_recibidos]['precio'];
            }

            $total += $total_cursos;
            
            $total_clases = 10 * $numero_clases;
            
            $total += $total_clases; 
        }else{
            ob_clean();
            echo "<h3>Algo ha salido mal, respecto a los cursos y el numero de clases, por favor vuelve a intertalo</h3>";
            muestra_formulario();
            fin_html();
            ob_flush();
            exit(2);
        }
       
    }else{
  
        echo "<h3>No has seleccionado ningun curso</h3>";
       
    }

    // SE APLICA EL DESCUENTO

    if ( $desempleo == 'on') {
        $descuento = (10 * $total)/100 ; 
        $total -= $descuento;

    }

    

    // SI ESTA EN SITUACION DE DESEMPLEO PUEDE SUBIR EL ARCHIVO
    if ($desempleo == 'on') {
        
        
        if (isset($_FILES['archivo_pdf'])) {
           $ruta = $_SERVER['DOCUMENT_ROOT'] . "/tarjetas";

            if (!dir($ruta)) {
                if (!mkdir($ruta, 0755)) {
                    ob_clean();
                    echo "<h3>Error al crear el directorio de subida</h3>"; 
                    muestra_formulario();
                    fin_html();
                    ob_flush();
                    exit(3);
                }
            }

            if ($_FILES['archivo_pdf']['size'] > $limite_pdf) {
                ob_clean();
                echo "<h3>El tamaño del archivo es superior a lo establecido</h3>"; 
                muestra_formulario();
                fin_html();
                ob_flush();
                exit(4);
            }else{
                $tipos_mime_admitidos = ["application/pdf"];
                $tipo_mime_1 = $_FILES['archivo_pdf']['type'];
                $tipo_mime_2 = mime_content_type($_FILES['archivo_pdf']['tmp_name']);

                if ($tipo_mime_1 === $tipo_mime_2 && array_key_exists($tipo_mime_2 , $tipos_mime_admitidos)) {
                    $nombre_archivo = $ruta . "/" .$_FILES['archivo_pdf']['name'];
                    if (move_uploaded_file($_FILES['archivo_pdf']['tmp_name'], $nombre_archivo)) {
                        echo "<h3>Archivo guardado: $nombre_archivo</h3>";

                    }
                }else{
                    ob_clean();
                    echo "<h3>El tipo del archivo no es el requerido, por favor mande sus archivos en pdf</h3>"; 
                    muestra_formulario();
                    fin_html();
                    ob_flush();
                    exit(4);

                }
            }




        }else {
            ob_clean();
            echo "<h3>Ha ocurrido un error al procesar su archivo</h3>"; 
            muestra_formulario();
            fin_html();
            ob_flush();
            exit(4);
        }
    }


    echo "
    <h1>DESGLOSE DE SU SOLICITUD</h1> <br>
    <table>

    <thead>
    <tr>
    <th>email</th>
    <th>Cursos</th>
    <th>Nº de clases presenciales</th>
    <th>Situacion de desempleo</th>"  ;
    if ($descuento == 'on') {
        echo "  
        <th>nombre archivo del usuario</th>
        <th>nombre archivo guardado</th>
        <th>tamaño</th>
        ";
    }
    echo "
    </tr>
    </thead>";

    echo "
    <tbody>
    <tr>
    <td>$email</td>
    <td>";
    foreach ($cursos as $key => $value) {
        echo "{$cursos[$cursos_recibidos]['nombre']} y su precio es : {$cursos[$cursos_recibidos]['precio']} € <br>";
    }
    echo "
    </td>    
    <td>" . (isset($desempleo) == 'on' ? "si" : "no") . "</td>
    ";
    if ($descuento == 'on') {
        echo "  
        <td>{$_FILES['archivo_pdf']['tmp_name']}</td>
        <td>{$_FILES['archivo_pdf']['name']}</td>
        <td>{$_FILES['archivo_pdf']['size']}</td>
        ";
    }

    echo"
    </tr>
    </tbody>
    </table>
    ";

}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    muestra_formulario();
}

function muestra_formulario() {
    
?>


    <form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>Presupuesto de cursos de formación online</legend>

        <label for="email">Email</label>
        <input type="email" name="email" id="email">

        <label for="cursos">Cursos disponibles</label>
        <div>
            <input type="checkbox" name="cursos[]" id="curso1" value="of">Ofimática
            <input type="checkbox" name="cursos[]" id="curso2" value="pr"> Programación
            <input type="checkbox" name="cursos[]" id="curso3" value="rep"> Reparación de ordenadores
        </div>

        <label for="numero_clases">N.º de clases presenciales</label>
        <input type="text" name="numero_clases" id="numero_clases" min="5" max="10" value="5">

        <label for="desempleo">Situacion de empleo</label>
        <input type="checkbox" name="desempleo" id="desempleo">

        <input type="hidden" name="limite_pdf" value="<?= 100 * 1024 ?>" id="limite_pdf">
        <label for="archivo_pdf">Tarjeta demandante de empleo (si no esta en situacion de desempleo no se guardara su archivo)</label>
        <input type="file" name="archivo_pdf" id="archivo_pdf">


    </fieldset>
<input type="submit" name="operacion" id="operacion" value="enviar">

    </form>




<?php
}
fin_html();

?>