<?php 

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");

inicio_html("Ejercicio 2", ["/estilos/general.css", "/estilos/formulario.css"]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $libros = [
        "123-4-56789-012-3" => ["autor" => "Ken Follet", "nombre" => "Los pilares de la Tierra", "genero" => "Novela histórica"],
        "987-6-54321-098-7" => ["autor" => "Ken Follet", "nombre" => "La caída de los gigantes", "genero" => "Novela histórica"],
        "345-1-91827-019-4" => ["autor" => "Max Hastings", "nombre" => "La guerra de Churchill", "genero" => "Biografía"],
        "908-2-10928-374-5" => ["autor" => "Isaac Asimov", "nombre" => "Fundación", "genero" => "Fantasía"],
        "657-4-39856-543-3" => ["autor" => "Isaac Asimov", "nombre" => "Yo, robot", "genero" => "Fantasía"],
        "576-4-23442-998-5" => ["autor" => "Carl Sagan", "nombre" => "Cosmos", "genero" => "Divulgación científica"],
        "398-4-92438-323-2" => ["autor" => "Carl Sagan", "nombre" => "La diversidad de la ciencia", "genero" => "Divulgación científica"],
        "984-5-39874-209-4" => ["autor" => "Steve Jacobson", "nombre" => "Jobs", "genero" => "Biografía"],
        "564-7-54937-300-6" => ["autor" => "George R.R. Martin", "nombre" => "Juego de tronos", "genero" => "Fantasía"],
        "677-2-10293-833-8" => ["autor" => "George R.R. Martin", "nombre" => "Sueño de primavera", "genero" => "Fantasía"]
    ];

    // Sanitizar y validar las entradas
    $isbn = filter_input(INPUT_POST, 'ISBN', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $titulo = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
    $autores = filter_input(INPUT_POST, 'autor', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY); 
    $generos = filter_input(INPUT_POST, 'genero', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY); 

    $resultados = []; // Inicializa el array para los resultados
    foreach ($libros as $key => $libro) {
        // Comprobar si ISBN y Título están vacíos
        if ($isbn == '' && $titulo == '') {
            // Si no se seleccionan autores y géneros, no añadimos nada
            if (empty($autores) && empty($generos)) {
                continue; // Salta a la siguiente iteración del foreach
            }
            
            // Filtrar por autores y géneros seleccionados
            if ((empty($autores) || in_array($libro['autor'], $autores)) &&
                (empty($generos) || in_array($libro['genero'], $generos))) {
                $resultados[$key] = $libro;
            }
        }
        // Si hay un ISBN o un título, aplicar filtrado
        elseif (($isbn == '' || strpos($key, $isbn) !== false) &&
                ($titulo == '' || strpos(strtolower($libro['nombre']), strtolower($titulo)) !== false) &&
                (empty($autores) || in_array($libro['autor'], $autores)) &&
                (empty($generos) || in_array($libro['genero'], $generos))) {
            $resultados[$key] = $libro;
        }
    }
    
    // Mostrar los resultados
    if (!empty($resultados)) {
        echo "<h2>Resultados de la búsqueda</h2>";
        echo "<table border='1'>
                <tr>
                    <th>ISBN</th>
                    <th>Autor</th>
                    <th>Título</th>
                    <th>Género</th>
                </tr>";
        foreach ($resultados as $isbn => $libro) {
            echo "<tr>
                    <td>" . htmlspecialchars($isbn) . "</td>
                    <td>" . htmlspecialchars($libro['autor']) . "</td>
                    <td>" . htmlspecialchars($libro['nombre']) . "</td> 
                    <td>" . htmlspecialchars($libro['genero']) . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<h2>No se encontraron libros que coincidan con los criterios de búsqueda.</h2>";
    }
}
?>

<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
<fieldset>
    <legend>biblioteca</legend>

    <label for="ISBN">ISBN</label>
    <input type="text" name="ISBN" id="ISBN" pattern="[0-9]{3}-[0-9]-[0-9]{5}-[0-9]{3}-[0-9]">

    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" id="nombre">

    <label for="autor">Autor</label>
    <select name="autor[]" id="autor" multiple>
        <option value="Ken Follet">Ken Follet</option>
        <option value="Max Hastings">Max Hastings</option>
        <option value="Isaac Asimov">Isaac Asimov</option>
        <option value="Carl Sagan">Carl Sagan</option>
        <option value="Steve Jacobson">Steve Jacobson</option>
        <option value="George R.R. Martin">George R.R. Martin</option>
    </select>

    <label for="genero">Género</label>
    <select name="genero[]" id="genero" multiple>
        <option value="Novela histórica">Novela histórica</option>
        <option value="Divulgación científica">Divulgación científica</option>
        <option value="Biografía">Biografía</option>
        <option value="Fantasía">Fantasía</option>
    </select>
</fieldset>
<input type="submit" name="operacion" id="operacion" value="enviar">
</form>

<?php 

fin_html();

?>
