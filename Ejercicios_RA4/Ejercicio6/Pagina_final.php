<?php 

session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/ra4/autenticacion/03jwt_include.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET' && htmlspecialchars($_GET['operacion']) == "finalizar") {
    if ( !isset($_COOKIE['token']) ) {
        header("Location: /Ejercicios_RA4/Ejercicio6/Pagina_inicial.php?operacion=cerrar");
        exit();
    }
    
    $jwt = $_COOKIE['token'];
    $payload = verificar_token($jwt);
    
    if ( !$payload ) {
        header("Location: /Ejercicios_RA4/Ejercicio6/Pagina_inicial.php?operacion=cerrar");
        exit();
    }

    inicio_html("Pagina_final" , ["/estilos/tablas.css"]);
?>
   <table>
        <tr>
            <th>tema</th>
            <th>comentario</th>
            <th>hora</th>
        </tr>

  
            <?php
           $comentarios = $_SESSION['comentarios'];
            foreach ($comentarios as $comentario) {
                echo  "<tr>";
                echo "<td>{$comentario['tema']} </td>";
                echo "<td>{$comentario['comentario']}</td>";
                echo "<td>{$comentario['hora']}</td>";
                echo "</tr>";
            }
  
            ?>

    </table>
    <br><br>
        <p> Para cerra sesion y volver a comenzar <a href="/Ejercicios_RA4/Ejercicio6/Pagina_inicial.php?operacion=cerrar">Pulse aqui</a></p>
<?php
fin_html();
    
}else{
    header("Location: /Ejercicios_RA4/Ejercicio6/Pagina_inicial.php?operacion=cerrar");
    exit();
}




?>