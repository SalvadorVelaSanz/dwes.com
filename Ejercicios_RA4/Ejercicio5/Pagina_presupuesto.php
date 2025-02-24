<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    header("Location: /Ejercicios_RA4/Ejercicio5/Pagina_inicial.php");
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && htmlspecialchars($_POST['operacion']) == 'Empezar el presupuesto') {
    if (isset($_FILES['alumnos_csv'])) {
        $csvFile = $_FILES['alumnos_csv']['tmp_name'];
        if (is_uploaded_file($csvFile)) {
            $alumnos = [];
    
            if (($handle = fopen($csvFile, "r")) !== false) {
                // Leer encabezados y datos
                while (($datos = fgetcsv($handle, 1000, ",")) !== false) {
                    $alumnos_recibidos[] = [
                        'nif' => $datos[0],
                        'nombre' => $datos[1],
                        'apellidos' => $datos[2],
                        'grupo' => $datos[3]
                    ];
                }
                fclose($handle);
    
                $_SESSION['alumnos'] = $alumnos_recibidos;

                $precio_total = count($_SESSION['alumnos']) * 10 ;

                $_SESSION['precio_total'] = $precio_total;
            }
        }else {
            echo "Error al subir el archivo CSV. Vuelva a intertarlo";
            echo "<a href='/Ejercicios_RA4/Ejercicio5/Pagina_carga_alumnos.php'>Pulse aquí</a>";
            exit(1);
        }
    }else {
        echo "Error al subir el archivo CSV. Vuelva a intertarlo";
        echo "<a href='/Ejercicios_RA4/Ejercicio5/Pagina_carga_alumnos.php'>Pulse aquí</a>";
        exit(2);
    }
    }



inicio_html("Pagina de carga de alumnos" , ["/estilos/formulario.css" , "/estilos/tablas.css"]);

    $alumnos= $_SESSION['alumnos'];
    if (!isset($_SESSION['alumnos']) || $alumnos <= 0) {
        echo "No hay almunos en su archivo csv.Le recomendamos que suba otro ";
        echo "<a href='/Ejercicios_RA4/Ejercicio5/Pagina_carga_alumnos.php'>Pulse aquí</a>";
        exit(3);
    } 

    

?>

<h1>Lista de alumnos</h1>

<table>

<tr>
<th>NIF</th>
<th>Nombre</th>
<th>Apellidos</th>
<th>Grupo</th>
</tr>


<?php
foreach ($alumnos as $alumno) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($alumno['nif']) .  "</td>";
    echo "<td>" . htmlspecialchars($alumno['nombre']) .  "</td>";
    echo "<td>" . htmlspecialchars($alumno['apellidos']) .  "</td>";
    echo "<td>" . htmlspecialchars($alumno['grupo']) .  "</td>";
    echo "</tr>";
}

?>


</table>

<br> <br>
<h2>Su precio total a pagar es <?= $_SESSION['precio_total'] ?>€</h2>
<br> <br>

<h2>Le recordamos que si el profesor no ha iniciado sesion no podra terminar el proceso</h2>

<form action="/Ejercicios_RA4/Ejercicio5/Pagina_profesor.php" method="post">

<fieldset>
    <input type="submit" name="operacion" id="operacion" value="Iniciar Sesion">
</fieldset>


</form>

<?php

fin_html();

?>