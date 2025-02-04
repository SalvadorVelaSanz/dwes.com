<?php
echo "";
require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/ra4/autenticacion/03jwt_include.php");

session_start();

if ( !isset($_COOKIE['token']) ) {
    header("Location: /Ejercicios_BBDD/Ejercicio3/Pagina_autentificacion.php");
    exit(3);
}

$jwt = $_COOKIE['token'];
$payload = verificar_token($jwt);

if ( !$payload ) {
    header("Location: /Ejercicios_BBDD/Ejercicio3/Pagina_autentificacion.php");
    exit(1);
}

$dsn = "mysql:host=localhost;port=3306;dbname=tiendaol;charset=utf8mb4";
$usuario = "usuario";
$clave = "usuario";

$opciones = [
PDO::ATTR_ERRMODE               =>  PDO::ERRMODE_EXCEPTION,
PDO::ATTR_DEFAULT_FETCH_MODE    =>  PDO::FETCH_ASSOC,
PDO::ATTR_EMULATE_PREPARES      =>  false
];

$referencia = isset($_GET['referencia']) ? htmlspecialchars($_GET['referencia']) : '';


if ($referencia) {
    $_SESSION['referencia'] = $referencia;
}

if (!$referencia) {
    $referencia = $_SESSION['referencia'] ? $_SESSION['referencia'] :"";
}
try {
    $pdo = new PDO($dsn ,$usuario , $clave ,$opciones);

    $sql = "SELECT id_reseña, clasificacion, comentario ,fecha from reseña where nif = :nif and referencia = :referencia";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":nif" ,$payload['nif']);
    $stmt->bindValue(":referencia" ,$referencia);
    $stmt->execute();
    $reseñas = $stmt->fetchAll();

} catch (PDOException $th) {
    echo $th->getMessage();
}

if ($_SERVER['REQUEST_METHOD']== 'POST' && htmlspecialchars($_POST['operacion']) == 'Añadir reseña') {

    $clasificacion = filter_input(INPUT_POST, "clasificacion" , FILTER_SANITIZE_NUMBER_INT);
    $opciones = array(
        'options' => array(
            'max_range' => 5,
            'min_range' => 0
        ),
        'flags' => FILTER_FLAG_ALLOW_OCTAL,
    );
    $clasificacion = filter_var($clasificacion ,FILTER_VALIDATE_INT , $opciones);
    $comentario = filter_input(INPUT_POST, "comentario" , FILTER_SANITIZE_SPECIAL_CHARS);
    $fecha = filter_input(INPUT_POST, "fecha" , FILTER_SANITIZE_SPECIAL_CHARS);

    try {
        $pdoInsert = new PDO($dsn , $usuario ,$clave ,$opciones);
        $sqlInsert ="INSERT into reseña (nif,referencia ,clasificacion ,comentario ,fecha) VALUES(:nif,:referencia, :clasificacion, :comentario, :fecha)";
        $nif =$payload['nif'];
        $stmtInsert = $pdoInsert->prepare($sqlInsert);
        $stmtInsert->bindValue(":nif" , $nif);
        $stmtInsert->bindValue(":referencia" , $referencia);
        $stmtInsert->bindValue(":clasificacion" , $clasificacion);
        $stmtInsert->bindValue(":comentario" , $comentario);
        $stmtInsert->bindValue(":fecha" , $fecha);
        $stmtInsert->execute();

        if ($stmtInsert->rowCount() ==1) {
            header("Location: /Ejercicios_BBDD/Ejercicio3/Pagina_datos.php");
            exit();
        }else{
            echo "Ha ocurrido un error al añadir la reseña";
        }
    } catch (PDOException $th) {
        echo $th;
    }

}

if ($_SERVER['REQUEST_METHOD']== 'POST' && htmlspecialchars($_POST['operacion']) == 'Volver a la pantalla anterior') {
    $_SESSION['referencia'] = '';
    header("Location: /Ejercicios_BBDD/Ejercicio3/Pagina_principal.php");
    exit();
}



inicio_html("Pagina_Datos" , ["/estilos/general.css" , "/estilos/formulario.css" ,"/estilos/tablas.css"]);
?>


<?php 
if ($reseñas) {
    echo <<<TABLA
    <table>
     <tr>
        <th>id_reseña</th>
        <th>clasificacion</th>
        <th>comentario</th>
        <th>fecha</th>
     </tr>   
    TABLA;
    foreach ($reseñas as $reseña) {
        echo <<<TR
        <tr>
        
        <td>{$reseña['id_reseña']}</td>
        <td>{$reseña['clasificacion']}</td>
        <td>{$reseña['comentario']}</td>
        <td>{$reseña['fecha']}</td>
        </tr>
        TR;
    }
    
}else{
    echo "No hay reseñas para este articulo de este usuario";
}

echo "</table>";
?>
<br><br><br>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post">

<fieldset>
    <legend>Introduce los valores</legend>

  

    <label for="clasificacion">Introduce la puntuacion (0-10)</label>
    <input type="number" name="clasificacion" id="clasificacion">

    <label for="comentario">Introduce el comentario de la reseña</label>
    <input type="text" name="comentario" id="comentario">

    <label for="fecha">Introduce la fecha de tu reseña</label>
    <input type="date" name="fecha" id="fecha">
</fieldset>

<input type="submit" name="operacion" id="operacion" value="Añadir reseña">
</form>

<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
    <input type="submit" name="operacion" id="operacion" value="Volver a la pantalla anterior">
</form>


<?php
fin_html();
?>