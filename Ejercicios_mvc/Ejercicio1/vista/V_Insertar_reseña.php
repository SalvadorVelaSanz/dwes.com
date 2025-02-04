<?php

namespace Ejercicio1\vista;



class V_Insertar_reseña extends Vista{



    public function genera_salida($datos){
        $this->inicio_html("Vista INsertar reseña" , ["/estilos/general.css" , "/estilos/tablas.css" , "/estilos/formulario.css"]);



        if ($datos) {
            
            if ($datos == false ) {
                echo "Ha habido un error a la hora de insertar su reseña, vuelva a intentarlo";
                echo "<a href='/Ejercicios_mvc/Ejercicio1/index.php?idp=Reseña'>Pulse aqui</a>";
                exit();
            }

            $fecha = $datos->fecha->format("Y-m-d H:m:s");


            echo <<<TABLA
            <h1>Su reseña : </h1>

            <table>
            <thead>
            <tr>
            <th>nif</th>
            <th>referencia</th>
            <th>fecha</th>
            <th>clasificacion</th>
            <th>comentario</th>
            </tr>
            </thead>
            
            <tbody>
            <tr>
            <th>$datos->nif</th>
            <th>$datos->referencia</th>
            <th>$fecha</th>
            <th>$datos->clasificacion</th>
            <th>$datos->comentario</th>
            </tr>
            </tbody>
            </table>

    

            TABLA;
            $refencia = $datos->referencia;
            ?>

                <form action="/Ejercicios_mvc/Ejercicio1/index.php" method="post">
                    <input type="hidden" name="referencia" id="referencia" value="<?=$refencia?>">
                    <button type="submit" id="idp" name="idp" value="Reseña">Añadir mas reseñas</button>
                </form>
            <?php
          
        }
    }
}











?>

