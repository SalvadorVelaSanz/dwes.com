<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/Ejercicios_BBDD/Ejercicio4/Utils/Autocarga.php");



use Ejercicio4\entidad\proveedor;
use Ejercicio4\modelo\ORMproveedor;
use Ejercicio4\entidad\entidad;
use Ejercicio4\Utils\Html;
use Ejercicio4\Utils\Autocarga;


Autocarga::registro_autocarga();

Html::inicio("ORM en PHP", ["/estilos/general.css", "/estilos/tablas.css"]);
echo "<header>ORM en PHP</header>";

$orm_proveedor = new ORMproveedor();
$proveedor = $orm_proveedor->get("01000000A");
echo "<h3>Artículo con referencia 01000000A</h3>";
echo "$proveedor";

echo "<h3>Listado de todos los artículos</h3>";
$proveedores = $orm_proveedor->getAll();
echo <<<TABLA
    <table>
        <thead>
        <tr>
            <th>nif</th>
            <th>razon_social</th>
            <th>direccion</th>
            <th>cp</th>
            <th>poblacion</th>
            <th>provincia</th>
            <th>pais</th>
            <th>telefono</th>
            <th>contacto</th> 
            <th>email</th> 

        </tr>
        </thead>
        <tbody>
TABLA;
foreach($proveedores as $proveedor ) {
    echo "<tr>";
    echo "<td>{$proveedor->nif}</td>";
    echo "<td>{$proveedor->razon_social}</td>";
    echo "<td>{$proveedor->direccion}</td>";
    echo "<td>{$proveedor->cp} </td>";
    echo "<td>{$proveedor->poblacion}</td>";
    echo "<td>{$proveedor->provincia}</td>";
    echo "<td>{$proveedor->pais}</td>";
    echo "<td>{$proveedor->telefono}</td>";
    echo "<td>{$proveedor->contacto}</td>";
    echo "<td>{$proveedor->email}</td>";    echo "</tr>";
}
echo <<<FIN_TABLA
    </tbody>
</table>
FIN_TABLA;

echo "<p>Número de proveedores: " . count($proveedores) . "</p>";

echo "<h3>Insertamos un proveedor nuevo</h3>";
$proveedor = new proveedor(['nif'          => 'ACIe547',
                        'razon_social'          => 'aaaaaaaaa',
                        'direccion'                   => 'aaaaaaa',
                        'cp'             => '12',
                        'poblacion'          => 'aaaaaaaa',
                        'provincia'       => 'aaaaaa',
                        'pais'      => "españa",
                        'telefono'             => '672369776',
                        'contacto'             => 'sisisisisis',
                        'email'              => 'a@gmail.com']);

if( $orm_proveedor->insert($proveedor) ) {
    echo "<h4>El proveedor recién insertado</h4>";
    $nuevo_proveedor = $orm_proveedor->get($proveedor->nif);

    echo "$nuevo_proveedor";
}
else {
    echo "<h4>Error al insertar un nuevo artículo</h4>";
}

echo "<h3>Modificamos el artículo recién insertado</h3>";
$nuevo_proveedor->direccion = "bbbbbbbbbbbbbbbbbbb";
$nuevo_proveedor->cp = "44";
$nuevo_proveedor->email = "b@gmail.com";

if( $orm_proveedor->update($nuevo_proveedor->nif, $nuevo_proveedor) ) {
    echo "<h4>El artículo recién modificado</h4>";
    $proveedor_modificado = $orm_proveedor->get($nuevo_proveedor->nif);
    echo "$proveedor_modificado";
}
else {
    echo "<h4>Error al modificar un nuevo artículo</h4>";
}

echo "<h3>Borramos el artículo recién insertado y modificado</h3>";
if( $orm_proveedor->delete($proveedor_modificado->nif)) {
    echo "<h4>El artículo con referencia {$proveedor_modificado->nif} se ha borrado</h4>";
}
else {
    echo "<h4>Error al eliminar el artículo</h4>";
}

Html::fin();

// $dsn = "mysql:host=localhost;port=3306;dbname=tiendaol;charset=utf8mb4";
// $usuario = "usuario";
// $clave = "usuario";

// $opciones = [
// PDO::ATTR_ERRMODE               =>  PDO::ERRMODE_EXCEPTION,
// PDO::ATTR_DEFAULT_FETCH_MODE    =>  PDO::FETCH_ASSOC,
// PDO::ATTR_EMULATE_PREPARES      =>  false,
// PDO::ATTR_CASE                  =>  PDO::CASE_LOWER
// ];

// try {
//     $pdo = new PDO($dsn , $usuario ,$clave , $opciones);
//     $sql = "SELECT * FROM proveedor WHERE nif = :nif" ;
//     $stmt = $pdo->prepare($sql);
//     $stmt->bindValue(":nif" ,'01000000A'); if ( $stmt->execute()) {
//         $fila = $stmt->fetch();
        
//       var_dump($fila);
//     }
// } catch (PDOException $th) {
//     throw $th;
// }

?>