<?php


require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");

session_start();

if (!isset($_SESSION['usuario']) || !isset($_SESSION['clave'])) {
    header("Location: /Ejercicios_BBDD/Ejercicio1/Pagina_autentificacion.php");
    exit();
}


$dsn = "mysql:host=localhost;port=3306;dbname=tiendaol;charset=utf8mb4";
$usuario = $_SESSION['usuario'];
$clave = $_SESSION['clave'];

$opciones = [
PDO::ATTR_ERRMODE               =>  PDO::ERRMODE_EXCEPTION,
PDO::ATTR_DEFAULT_FETCH_MODE    =>  PDO::FETCH_ASSOC,
PDO::ATTR_EMULATE_PREPARES      =>  false
];

try {
    $pdo = new PDO($dsn , $usuario , $clave ,$opciones);
} catch (PDOException $e) {
    echo "<h1>Error al conectar con la base de datos</h1>";
}

$referencia = htmlspecialchars($_GET['referencia']) ?? '';

if ($referencia !== '') {
    $_SESSION['referencia_modificar'] = $referencia;
}

$articulo = null;

if ($referencia) {
    $sql = "SELECT * FROM articulo WHERE referencia = :referencia";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":referencia" , $referencia);
        $stmt->execute();
        $articulo = $stmt->fetch();
    } catch (PDOException $e) {
        echo "<h1>Ha habido un error a la hora de obtener el id de la url</h1>";
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $articulo_filtro = [

        'descripcion'       => $_POST['descripcion'],
        'pvp'               => $_POST['pvp'] ,
        'dto_venta'         => $_POST['dto_venta'] ,
        'und_vendidas'      => $_POST['und_vendidas'] ,
        'und_disponibles'   => $_POST['und_disponibles'] ,
        'fecha_disponible'  => $_POST['Fecha_disponible'] ,
        'categoria'         => $_POST['categoria'] ,
        'tipo_iva'          => $_POST['tipo_iva'] ,
    ];
    
    // Define los filtros para sanear y validar
    $filtros = [

        'descripcion'       => FILTER_SANITIZE_SPECIAL_CHARS, // Puede ser nulo
        'pvp'               => [
            'filter'    => FILTER_VALIDATE_FLOAT,
            'options'   => ['min_range' => 0]
        ],
       'dto_venta' => [
        'filter'  => FILTER_VALIDATE_FLOAT,
        'options' => [
            'min_range' => 0,
            'max_range' => 1
        ]
        ],

        'und_vendidas'      => [
            'filter'    => FILTER_VALIDATE_INT,
            'options'   => ['min_range' => 0]
        ],
        'und_disponibles'   => [
            'filter'    => FILTER_VALIDATE_INT,
            'options'   => ['min_range' => 0]
        ],
        'fecha_disponible'  => FILTER_SANITIZE_SPECIAL_CHARS, // Validar el formato después
        'categoria'         => FILTER_SANITIZE_SPECIAL_CHARS,
        'tipo_iva'          => FILTER_SANITIZE_SPECIAL_CHARS,
    ];
    
    // Sanear y validar los datos
    $datos_saneados = filter_var_array($articulo_filtro, $filtros);
    
    // Validar campos que tienen reglas adicionales o pueden ser nulos
    $errores = [];
    if ($datos_saneados['fecha_disponible'] !== null && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $datos_saneados['fecha_disponible'])) {
        $errores[] = "El campo 'Fecha_disponible' debe tener el formato AAAA-MM-DD.";
    }
    
    // Verificar si algún campo obligatorio es inválido o faltante
    foreach (['descripcion','pvp', 'dto_venta', 'und_vendidas', 'und_disponibles', 'categoria', 'tipo_iva'] as $campo) {
        if ($datos_saneados[$campo] === false) {
            $errores[] = "El campo '$campo' no es válido.";
        }
    }
    
    if (!empty($errores)) {
        // Mostrar errores y terminar el script
        foreach ($errores as $error) {
            echo "<p>Error: $error</p>";
        }
        exit;
    }

    $referencia = $_SESSION['referencia_modificar'];
    if ($referencia !== "") {
        $sqlUpdate = "UPDATE articulo SET descripcion = :descripcion , pvp = :pvp , dto_venta = :dto_venta , und_vendidas = :und_vendidas, ";
        $sqlUpdate.= "und_disponibles = :und_disponibles , fecha_disponible = :fecha_disponible, categoria = :categoria , tipo_iva = :tipo_iva WHERE referencia = :referencia" ;

        try {
            $stmtUpdate = $pdo->prepare($sqlUpdate);
            foreach ($datos_saneados as $dato => $value) {
                $stmtUpdate->bindValue(":$dato" , $value);
            }
            $stmtUpdate->bindValue(":referencia" , $referencia);
            $stmtUpdate->execute();
            $rowCount = $stmtUpdate->rowCount();
            echo "Filas afectadas: $rowCount<br>";

            if ($stmtUpdate->rowCount() == 1) {
                echo "Articulo actualizado correctamente";
               $_SESSION['referencia_modificar'] = "";
                header("Location: /Ejercicios_BBDD/Ejercicio1/Pagina_principal.php");
                exit();
            }else{
                echo "Algo ha salido mal, vuelva a intentarlo";
            }


        } catch (PDOException $th) {
           echo "Error al actualizar";
           echo "$th";
        }
    }else{
        $referencia_art = filter_input(INPUT_POST , "referencia" , FILTER_SANITIZE_SPECIAL_CHARS);

        $sqlInsert = "INSERT INTO articulo (referencia ,descripcion,pvp,dto_venta,und_vendidas,und_disponibles,fecha_disponible,categoria,tipo_iva) ";
        $sqlInsert.= "VALUES (:referencia ,:descripcion,:pvp,:dto_venta,:und_vendidas,:und_disponibles,:fecha_disponible,:categoria,:tipo_iva)";

        try {
            $stmtInsert = $pdo->prepare($sqlInsert);
            $stmtInsert->bindValue(":referencia", $referencia_art);
            foreach ($datos_saneados as $dato => $value) {
                $stmtInsert->bindValue(":$dato" , $value);
            }
            $stmtInsert->execute();
            if ($stmtInsert->rowCount() == 1) {
                header("Location: /Ejercicios_BBDD/Ejercicio1/Pagina_principal.php");
                exit();
            }else{
                echo "Algo ha salido mal, vuelva a intentarlo";
            }
        } catch (\PDOException $e) {
            echo "Error al añadir";
            echo "$e";
        }



    }
}


inicio_html("Pagina_datos" , ["/estilos/formulario.css" , "/estilos/general.css" , "/estilos/tablas.css"]);
?>

<h1><?= $referencia ? "Modificar articulo" : "Crear articulo"?></h1>

<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">

<fieldset>
    <legend> Introduce los valores</legend>

    <?php
        if ($referencia == "") {
            echo "<label for='referencia'>Introduzca la referencia (id) del producto</label>
            <input type='text' name='referencia' id='referencia' value='" . htmlspecialchars($articulo['referencia'] ?? '') . "'>";
        }
    ?>

    <label for="descripcion">Descripción del artículo</label>
    <input type="text" name="descripcion" id="descripcion" value="<?= htmlspecialchars($articulo['descripcion'] ?? "") ?>">

    <label for="pvp">PVP del artículo</label>
    <input type="number" name="pvp" id="pvp" value="<?= htmlspecialchars($articulo['pvp'] ?? "") ?>">

    <label for="dto_venta">DTO venta del artículo</label>
    <input type="number" name="dto_venta" id="dto_venta" value="<?= htmlspecialchars($articulo['dto_venta'] ?? "") ?>">

    <label for="und_vendidas">Unidades vendidas del artículo</label>
    <input type="number" name="und_vendidas" id="und_vendidas" value="<?= htmlspecialchars($articulo['und_vendidas'] ?? "") ?>">

    <label for="und_disponibles">Unidades disponibles del artículo</label>
    <input type="number" name="und_disponibles" id="und_disponibles" value="<?= htmlspecialchars($articulo['und_disponibles'] ?? "") ?>">

    <label for="Fecha_disponible">Fecha disponible del artículo (formato DD-MM-AAAA)</label>
    <input type="text" name="Fecha_disponible" id="Fecha_disponible" value="<?= htmlspecialchars($articulo['fecha_disponible'] ?? "") ?>">

    <label for="categoria">Categoría del artículo</label>
    <input type="text" name="categoria" id="categoria" value="<?= htmlspecialchars($articulo['categoria'] ?? "") ?>">

    <label for="tipo_iva">Tipo IVA</label>
    <input type="text" name="tipo_iva" id="tipo_iva" value="<?= htmlspecialchars($articulo['tipo_iva'] ?? "") ?>">

</fieldset>

<input type="submit" name="operacion" id="operacion" value="<?= $referencia ? "Modificar artículo" : "Crear artículo" ?>">
</form>


<?php
fin_html();
?>