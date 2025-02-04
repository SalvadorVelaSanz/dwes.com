<?php


session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/ra4/autenticacion/03jwt_include.php");




if ($_SERVER['REQUEST_METHOD'] == 'POST' && htmlspecialchars($_POST['operacion']) == 'Ver lista') {
    if (!isset($_COOKIE['token'])) {
        header("Location: /Ejercicios_RA4/Ejercicio6/Pagina_inicial.php?operacion=cerrar");
        exit();
    }

    $jwt = $_COOKIE['token'];
    $payload = verificar_token($jwt);

    if (!$payload) {
        header("Location: /Ejercicios_RA4/Ejercicio6/Pagina_inicial.php?operacion=cerrar");
        exit();
    }

    if (!isset($_SESSION['comentarios'])) {
        $_SESSION['comentarios'] = [];
    }

    $tema = filter_input(INPUT_POST, "tema", FILTER_SANITIZE_SPECIAL_CHARS);
    $comentario = filter_input(INPUT_POST, "comentario", FILTER_SANITIZE_SPECIAL_CHARS);
    $hora = gmdate("D, d M Y G:i:s", time()) . " GMT";

    if ($tema && $comentario) {
        $nuevo_comentario = [
            'tema' => $tema,
            'comentario' => $comentario,
            'hora' => $hora
        ];

        $_SESSION['comentarios'][] = $nuevo_comentario;
    } else {
        echo "<p>Error el comentario o el tema no son validos</p>";
        echo "<a href='/Ejercicios_RA4/Ejercicio6/Pagina_comentario.php?operacion=comentario'>Pulse aqui pare rellenarlo de nuevo</a>";
        exit();
    }

    inicio_html("Pagina lista", ["/estilos/tablas.css"]);
    $comentarios = $_SESSION['comentarios'];
?>
    <table>
        <tr>
            <th>tema</th>
            <th>comentario</th>
            <th>hora</th>
        </tr>

  
            <?php
           
            foreach ($comentarios as $comentario) {
                echo  "<tr>";
                echo "<td>{$comentario['tema']} </td>";
                echo "<td>{$comentario['comentario']}</td>";
                echo "<td>{$comentario['hora']}</td>";
                echo "</tr>";
            }
  
            ?>



      




    </table>
    <br> <br>

    <hr>

    <p> Para añadir otro comentario <a href="/Ejercicios_RA4/Ejercicio6/Pagina_comentario.php?operacion=comentario">Pulse aqui</a></p>

    <br><br>
    <p> Para finalizar <a href="/Ejercicios_RA4/Ejercicio6/Pagina_final.php?operacion=finalizar">Pulse aqui</a></p>

<?php
    fin_html();
} else {
    header("Location: /Ejercicios_RA4/Ejercicio6/Pagina_inicial.php?operacion=cerrar");
    exit();
}

?>