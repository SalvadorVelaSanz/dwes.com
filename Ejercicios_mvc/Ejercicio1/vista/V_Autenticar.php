<?php


namespace Ejercicio1\vista;

use Ejercicio1\utils\seguridad\JWT;
use Ejercicio1\vista\Vista;

class V_Autenticar extends Vista {


    public function genera_salida($datos){
        if ($datos) {
            
            $this->inicio_html("Vista_auntenticar" , ["/estilos/general.css" , "/estilos/formulario.css" , "/estilos/tablas.css"]);

            if ($datos == "Error") {
                echo "Ha habido un error en la auntentificacion";
                echo "<a href='/Ejercicios_mvc/Ejercicio1/index.php'>Pulsa aqui para intentar de nuevo</a>";
                exit();
            }



           echo "<h2> {$_SESSION['cliente']} </h2>";
            


            echo <<<TABLA
            <table>
            
            <thead>
            
                <tr>
                    <td>Referencia</td>
                    <td>Descripcion</td>
                    <td>pvp</td>
                    <td>dto_ventas</td>
                    <td>und_vendidas</td>
                    <td>und_disponibles</td>
                    <td>fecha_disponible</td>
                    <td>categoria</td>
                    <td>tipo_iva</td> 
                    <td>accion</td>   
                </tr>
            </thead>
            <tbody>
            TABLA;
            
            foreach ($datos as $articulo) {
                if ($articulo->fecha !== null) {
                    $fecha = $articulo->fecha->format("Y-m-d H:m:s");
                }else{
                    $fecha = "No hay fecha";
                }

                
               echo <<<TABLA2
                <tr>
                <td>$articulo->referencia</td>
                <td>$articulo->descripcion</td>
                <td>$articulo->pvp</td>
                <td>$articulo->dto_venta</td>
                <td>$articulo->und_vendidas</td>
                <td>$articulo->und_disponibles</td>
                <td>$fecha</td>
                <td>$articulo->categoria</td>
                <td>$articulo->tipo_iva</td> 
                <td>
                TABLA2;
                ?>

                <form action="/Ejercicios_mvc/Ejercicio1/index.php" method="post">
                    <input type="hidden" name="referencia" id="referencia" value="<?=$articulo->referencia?>">
                    <button type="submit" id="idp" name="idp" value="Reseña">Añadir reseña</button>
                </form>
                <?php
                
                
               echo "</td>";
               echo "</tr>";


            }            
           echo " </tbody>";
           echo" </table>";
                


        }else{
            echo "Ha habido un error al recibir la informacion del modelo";
        }



    }



}
















?>