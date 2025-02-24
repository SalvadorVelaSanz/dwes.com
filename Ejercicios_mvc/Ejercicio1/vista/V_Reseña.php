<?php
namespace Ejercicio1\vista;

class V_Reseña extends Vista{


    public function genera_salida($datos){
        
        if ($datos) {
            $this->inicio_html("Vista Reseña" , ["/estilos/formulario.css" , "/estilos/general.css" , "/estilos/tablas.css"]);
        
            if ($datos !==1 ) {
                
                echo <<<TABLA

                <h1>Tus reseñas</h1>

                <table>
                
                <thead>
                
                <tr>
                <th>id_reseña</th>
                <th>referencia</th>
                <th>nif</th>
                <th>fecha</th>
                <th>clasificacion</th>
                <th>comentario</th>
                </tr>
                
                </thead>
                
                <tbody>
                TABLA;
                foreach ($datos as $reseña) {
                    $fecha = $reseña->fecha->format("Y-m-d H:m:s");
                    echo <<<TABLA2

                    <tr>
                    <td>$reseña->id_reseña</td>
                    <td>$reseña->referencia</td>
                    <td>$reseña->nif</td>
                    <td>$fecha</td>
                    <td>$reseña->clasificacion</td>
                    <td>$reseña->comentario</td>
                    </tr>
                    TABLA2;
                }
               echo "</tbody>"; 
               echo " </table>";
            }else{
                echo "<h2>No hay reseñas para este usuario</h2>";
            }
        ?>


            <form action="/Ejercicios_mvc/Ejercicio1/index.php" method="post">

                <fieldset>
                    <legend>Introduce una reseña para el articulo previamente seleccionado</legend>

                    <label for="clasificacion">Clasificacion</label>
                    <input type="number" name="clasificacion" id="clasificacion" max="5" min="0">

                    <label for="comentario">Comentario</label>
                    <input type="text" name="comentario" id="comentario ">
                </fieldset>

                <button type="submit" name="idp" id="idp" value="Insertar_reseña">Añadir reseña</button>
            </form>

        <?php
            
            $this->fin_html();

        
        
        
        }
    }




}















?>