<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elementos del lenguaje  </title>
</head>
<body>

    <h1>Elementos del lenguage</h1>

    <h2>Entrada  y salida </h2>
    <p>Para la entrada de datos tenemos formularios y para la salida de datos teneos la funcion echo y la funcion print y para 
       datos con formato tebemos printf</p>

       

    <h3> funcion echo </h3>
    <?php 

    echo "la funcion echo escribe el resultado de una funcion a la salida, se puede usar como funcion o como construccion del lenguage";
  
    $nombre = "aa";
    echo "hola soy", $nombre, "222<br>" ; 

        echo("buenas familia");

        //Salto de linea al final
        echo "<br>holaaaaaaaaa\n";
        echo"sdefe4trt";


        $nombre = "obama";
        $apellidos = "james";

        echo" <br> mi nombre es: ", $nombre, " y mi apellido es: ", $apellidos ;

        echo "<br> mi nombre es $nombre y mi apellido es $apellidos";
 
        echo " <br> uno mas dos son: ", 1+2, " y tiene que salir 3";

       //forma abreviada de echo, cuando hay que enviar a la salida el resultado de una expresion pequeña disponemos de la forma abreviada de
       // echo que permite entercalarse en el codigo html con menos esfuerzo

       $portatil = true;
  ?>

    <p> mi nombre es <?=  $nombre ." ".  $apellidos  ?> y estoy programando en php</p>

    <!-- uso muy habitual valores por defecto de controles de formulario -->
  
    <input type="text" name="nombre" size="13" value="<?= $nombre?>">
    <input type="checkbox" name="portatil" <?=$portatil ?'checked ': '' ?> >tienes portatil?

    <!-- consejo las cadenas en PHP con "" y en HTML con '' -->

    <?php  
    
        echo "<input type='text' name = 'apellido' size ='50' ";

    ?>
<br>
    <h3>funcion print</h3>


    <?php

        print "Esto es una cadena\n que tiene mas de una linea\n y se envia a la salida\n"

        // lo mismo que echo

    ?>

<br>

    <h3>funcion printf</h3>


    <?php 
    
    $pi = 3.14159;
    $radio=3;
    $circunferencia = 2*$pi*$radio;
    


    printf("<br> la circunferencia de radio %d es %.2f" ,$radio , $circunferencia );


    
    ?>



    <h3>tipos de datos</h3>
 
    


</body>
</html>




