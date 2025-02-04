<?php
/*
    Actividad05 según el enunciado en Actividades RA3 - Proceso de formularios.pdf
*/

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");

ini_set("upload_max_filesize", 500 * 1024);

define("PRECIO_DESAYUNO", 20);

// Array de destinos
$destinos = ['paris'     => Array('nombre' => 'Paris', 'precio' => 100),
             'londres'   => Array('nombre' => 'Londres', 'precio' => 120),
             'estocolmo' => Array('nombre' => 'Estocolmo', 'precio' => 200),
             'edinburgo' => Array('nombre' => 'Edinburgo', 'precio' => 175),
             'praga'     => Array('nombre' => 'Praga', 'precio' => 125),
             'viena'     => Array('nombre' => 'Viena', 'precio' => 150)];

// Array de compañías
$compañias = ['myair'     => Array('nombre' => 'MyAir', 'precio' => 0),
             'airfly'   => Array('nombre' => 'AirFly', 'precio' => 50),
             'vuelaconmigo' => Array('nombre' => 'VuelaConmigo', 'precio' => 75),
             'apedalesair' => Array('nombre' => 'ApedalesAir', 'precio' => 150)];

$hoteles = [3 => 0,
            4 => 40,
            5 => 100 ];
            
$extras = ['vg'     => Array('nombre' => 'Visita guiada', 'precio' => 200),
           'bt'     => Array('nombre' => 'Bus turístico', 'precio' => 30),
           '2m'     => Array('nombre' => '2ª maleta facturada', 'precio' => 20),
           'sv'     => Array('nombre' => 'Seguro de viaje', 'precio' => 30)
];

$datos_formulario = [
    'responsable' => ['valor' => '', 'error' => ''],
    'telefono' => ['valor' => '', 'error' => ''],
    'email' => ['valor' => '', 'error' => ''],
    'destino' => '',
    'compañia' => '',
    'hotel' =>''

];

// Página autogenerada: El formulario se presenta con GET y el proceso se hace con POST

inicio_html("Actividad 05", ["/estilos/general.css", "/estilos/formulario.css"]);

if( $_SERVER['REQUEST_METHOD'] == "POST") {
    // Procesa el formulario
    // Si hay sticky form, se inicializan las variables 
    // con los datos del formulario para inicializar los valores 
    // de los controles del formulario.

    

    $responsable = filter_input(INPUT_POST, 'responsable', FILTER_SANITIZE_SPECIAL_CHARS);

    $datos_formulario['responsable']['valor'] = $responsable;
    $datos_formulario['responsable']['error'] = null;
    
    $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_NUMBER_INT);
    $telefono = preg_match("/[0-9]{9}/", $telefono) == 0 ? "": $telefono;

    $datos_formulario['telefono']['valor'] = $telefono;
    $datos_formulario['telefono']['error'] = "El teléfono no es válido";

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);

    $datos_formulario['email']['valor'] = $email;
    $datos_formulario['email']['error'] = "El email no es válido";

    $destino = filter_input(INPUT_POST, 'destino', FILTER_SANITIZE_SPECIAL_CHARS);
    $destino = array_key_exists($destino, $destinos) ? $destino : False;

    $compañia = filter_input(INPUT_POST, 'compañia', FILTER_SANITIZE_SPECIAL_CHARS);
    $compañia = array_key_exists($compañia, $compañias) ? $compañia : False;

    $hotel = filter_input(INPUT_POST, 'hotel', FILTER_SANITIZE_NUMBER_INT);   
    $hotel = filter_var($hotel, FILTER_VALIDATE_INT, 
                Array('min_range' => 3, 'max_range' => 5, 'default'   => 3 ));
    
    $hotel = $hotel >= 3 && $hotel <= 5 ? $hotel : 3;

    $desayuno = isset($_POST['desayuno']) && $_POST['desayuno'] == "on";
    //$desayuno = filter_input(INPUT_POST, 'desayuno', FILTER_VALIDATE_BOOL);


    $personas = filter_input(INPUT_POST, 'personas', FILTER_SANITIZE_NUMBER_INT);   
    $personas = filter_var($personas, FILTER_VALIDATE_INT, 
                Array('min_range' => 5, 'max_range' => 10, 'default'   => 5 ));

    $dias = filter_input(INPUT_POST, 'dias', FILTER_SANITIZE_NUMBER_INT);   
    $dias = $dias == 5 || $dias == 10 || $dias == 15 ? $dias : False;

    $extras_recibido = filter_input(INPUT_POST, 'extras', FILTER_SANITIZE_SPECIAL_CHARS, 
                                    FILTER_REQUIRE_ARRAY);
    
    $extras_ok = True;
    if ($extras_recibido !== null) {
        foreach( $extras_recibido as $clave => $valor) {
            if( !array_key_exists($valor, $extras) ) {
                $extras_ok = False;
                break;
            }
        }
    }
    
    
    
    // Datos se han recibido, saneado y validado.
    // Se genera el presupuesto

    // Se inicia un buffer de salida
    ob_start();

    // Datos personales
    echo "<h3>Datos del presupuesto para las vaciones</h3>";

    echo "<p>Persona responsable $responsable - " . ($email ? $email : "Email no válido" ) . "<br>";
    echo "Teléfono de contacto: " . ($telefono ? $telefono : "Tlf no válido" ) . "<br>";

    $total = 0;
    if( $destino && $personas && $dias ) {
        $datos_formulario['destino'] = $destino;
        echo "Destino: {$destinos[$destino]['nombre']}<br>";
        echo "Número de personas: $personas<br>";
        echo "Número de días: $dias<br>";
        $precio_destino = $destinos[$destino]['precio'] * intval($dias) * intval($personas);
        echo "Precio por ir a {$destinos[$destino]['nombre']} para $personas personas ";
        echo "durante $dias dias es de " . number_format($precio_destino) . " €</p>";
        $total += $precio_destino;
    }
    else {
        ob_clean();
        echo "<h3>Error. El destino, las personas o los días no son correctos</h3>";
        // Enviar el formulario
        muestra_formulario($datos_formulario);
        fin_html();
        ob_flush();
        exit(1);
    }

    if( $compañia && $personas ) {
        $datos_formulario['compañia'] = $compañia;
        echo "<p>Línea aérea: {$compañias[$compañia]['nombre']}<br>";
        if( strtoupper($compañia) == 'MYAIR') {
            echo "Sin sobrecoste por línea aérea<br>";
        }
        else {
            $precio_compañia = $compañias[$compañia]['precio'];
            $total_compañia = $precio_compañia * intval($personas);
            echo "Suplemento por línea aérea: $total_compañia €</p>";
            $total += $total_compañia;            
        }
    }
    else {
        ob_clean();
        echo "<h3>Error. La línea aérea o el número de personas es erróneo</h3>";
        muestra_formulario($datos_formulario);
        fin_html();
        ob_flush();
        exit(2);
    }

    if( $hotel && $personas && $dias ) {
        $datos_formulario['hotel'] = $hotel;
        echo "<p>Hotel: $hotel *<br>";
        $precio_hotel = $hoteles[$hotel];
        $total_hotel = $precio_hotel * intval($personas) * intval($dias);
        if( $precio_hotel == 0 ) {
            echo "Sin sobrecoste por hotel de $hotel *</p>";
        }
        else {
            echo "Suplemento por hotel de $hotel *: $total_hotel €</p>";
        }
    }
    else {
        ob_clean();
        echo "<h3>Error. La categoría de hotel o el número de dias o personas es erróneo</h3>";
        fin_html();
        ob_flush();
        exit(3);
    }

    if( $desayuno ) {
        if( $personas && $dias ) {
            $total_desayuno = PRECIO_DESAYUNO * intval($personas) * intval($dias);
            echo "<p>Suplemento por desayuno incluido es: $total_desayuno €</p>";
            $total += $total_desayuno;
        }
        else {
            ob_clean();
            echo "<h3>Error en el número de personas o días</h3>";
            muestra_formulario($datos_formulario);
            fin_html();
            ob_flush();
            exit(4);
        }
    }

    // Los extras
    if( $extras_ok ) {
        $total_extras = 0;
        echo "<p>Se incluyen los siguiente extras: <br>";
        if ($extras_recibido !== null) {
            foreach( $extras_recibido as $extra ) {
                if( $extra == "vg") {
                    echo "{$extras[$extra]['nombre']} : {$extras[$extra]['precio']} €<br>";    
                    $total_extras += $extras[$extra]['precio'];
                }
                else {
                    echo "{$extras[$extra]['nombre']} : {$extras[$extra]['precio']} €/p/d<br>";
                    $total_extras += $extras[$extra]['precio'] * intval($personas) * intval($dias);
                }
            }
            echo "Total extras: $total_extras €</p>";
            $total += $total_extras;
        }else {
            echo "No se han seleccionado extras</p>";
        }
        
    }
    else {
        ob_clean();
        echo "<h3>Error. Los extras enviados son erróneos</h3>";
        muestra_formulario($datos_formulario);
        fin_html();
        ob_flush();
        exit(5);
    }

    echo "<p>Total viaje: " . number_format($total) . " €</p>";
    // Subida del archivo
    if (isset($_FILES['libro']) && $_FILES['libro']['error'] === UPLOAD_ERR_OK) {
        $tipos_mime_admitidos = ["application/pdf"];
        $tipo_mime_files = $_FILES['libro']['type'];
        $tipo_mime_funcion = mime_content_type($_FILES['libro']['tmp_name']);
    
        // Comprobación de tipo MIME
        if ($tipo_mime_files === $tipo_mime_funcion && in_array($tipo_mime_files, $tipos_mime_admitidos)) {
            $path = $_SERVER['DOCUMENT_ROOT'] . "/actividades/act05/archivos/";
            $nombre_archivo = $path . $_FILES['libro']['name'];
    
            // Verificar y crear el directorio si no existe
            if (!is_dir($path) && !mkdir($path, 0755, true)) {
                ob_clean();
                echo "<h3>No se ha podido crear el directorio de subida</h3>";
                muestra_formulario($datos_formulario);
                fin_html();
                ob_flush();
                exit(6);
            }
        
    
            // Mover el archivo
            if (move_uploaded_file($_FILES['libro']['tmp_name'], $nombre_archivo)) {
                echo "<h3>Archivo guardado: $nombre_archivo</h3>";
            } else {
                ob_clean();
                echo "<h3>Error al guardar el archivo $nombre_archivo</h3>";
                muestra_formulario($datos_formulario);
                fin_html();
                ob_flush();
                exit(7);
            } 
        } else {
            echo "<h3>Tipo de archivo no válido. Solo se admite PDF.</h3>";
        }
    } else {
        echo "<h3>Error en la subida del archivo. Puede que no lo hayas mandado</h3>";
    }
    
}

if( $_SERVER['REQUEST_METHOD'] == "GET") {
    // Poner el formulario si no es sticky form

    // Si es sticky form, inicializar los valores de los controles
    // del formulario con valores por defecto.
    muestra_formulario($datos_formulario);
}

    // Si es sticky form, el formulario viene aquí

function muestra_formulario($datos) { 
    global $destinos, $compañias, $hoteles;
    ?>
    <header>Presupuesto de viaje</header>
    <form method="POST" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
        <input type="hidden" name="MAX_FILE_SIZE" value="<?=500*1024?>">
        <fieldset>
            <legend>Datos del viaje</legend>
            <label for="responsable">Responsable del grupo</label>
            <input type="text" name="responsable" id="responsable" 
                size="40" value="<?=isset($datos['responsable']['valor']) ? $datos['responsable']['valor'] : "" ?>" required>

            <label for="telefono">Teléfono</label>
            <div>
            <input type="tel" name="telefono" id="telefono" size="10" 
                value="<?=isset($datos['telefono']['valor']) ? $datos['telefono']['valor'] : ""?>" required>
            <span class="error"><?=!$datos['telefono']['valor'] ? $datos['telefono']['error'] : "" ?></span>
            </div>

            <label for="email">Email</label>
            <div>
            <input type="email" name="email" id="email" size="40" 
                value="<?=isset($datos['email']['valor']) ? $datos['email']['valor'] : ""?>" required>
            <span class="error"><?=!$datos['email']['valor'] ? $datos['email']['error'] : "" ?></span>

            </div>
          

            <label for="destino">Destino</label>
            <select name="destino" id="destino" size="1">
    <?php
            foreach( $destinos as $clave => $valor ) {
                echo "<option value='$clave'" . ($datos['destino'] == $clave ? ' selected' : '') . ">{$valor['nombre']}</option>";
            }
            
    ?>
            </select>

            <label for="compañia">Compañía aérea</label>
            <select name="compañia" id="compañia" size="1">
    <?php
            foreach( $compañias as $clave => $valor ) {
                echo "<option value='$clave'" . ($datos['compañia'] == $clave ? ' selected' : '') . ">{$valor['nombre']}</option>";
            }
    ?>
            </select>
            
            <label for="hotel">Hotel</label>
            <select name="hotel" id="hotel" size="1">
    <?php
            foreach( $hoteles as $clave => $valor ) {
                echo "<option value='$clave'". ($datos['hotel'] == $clave ? ' selected' : '') .">$clave * ($valor €/p/d)</option>";
            }
    ?>

    
            </select>

            <label for="desayuno">Desayuno incluido</label>
            <input type="checkbox" name="desayuno" id="desayuno">

            <label for="personas">Nº Personas</label>
            <input type="number" min="5" max="10" value="5" name="personas" id="personas">

            <label for="dias">Nº de días</label>
            <div>
                <input type="radio" name="dias" id="dias_5" value="5">5
                <input type="radio" name="dias" id="dias_10" value="10">10
                <input type="radio" name="dias" id="dias_15" value="15">15
            </div>

            <label for="extras[]">Extras</label>
            <div>
                <input type="checkbox" name="extras[]" id="extras_1" value='vg'>Visita guiada<br>
                <input type="checkbox" name="extras[]" id="extras_2" value='bt'>Bus turístico<br>
                <input type="checkbox" name="extras[]" id="extras_3" value='2m'>2ª Maleta facturada<br>
                <input type="checkbox" name="extras[]" id="extras_4" value='sv'>Seguro de viaje<br>
            </div>

            <label>Copia del libro de familia</label>
            <input type="file" name="libro" id="libro">
        </fieldset>
        <input type="submit" name="operacion" id="operacion" value="Calcular presupuesto">
    </form>
<?php
}
    fin_html();
    ob_flush();
?>

