<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<h1> Estructuras e control</h1>

<h2>Sentencias</h2>

<p> La sentencia simples acaban en ;, puediendo haber mas de una en la misma linea</p>
<?php 
const SALTO = "<br>";
$numero =3; echo "el numero es $numero" , SALTO; $numero += 3; print " ahora es $numero:" . SALTO;


?>

<p> Un bloque de sentencias en un conjunto de sentencias encerradas entre llaves.
    NO suelen ir solas , sino formar parte de una estructura de control .Ademas, 
    se pueden anidar.
</p>


<?php 

{

    $numero = 3;
    echo "EL numero es $numero" , SALTO;
    $numero -= 2;
    echo "Ahora es $numero" , SALTO;
    {

        $numero = 8;
        $numero *=2; 
        echo "El resultado es $numero" , SALTO;
    
    }



}


?>

<h2>Estructuras de control simples</h2>

<?php 


// if (expresion) sentencia

$numero = 4 ;

if ($numero >=4) {
    echo "el numero es mayor o igual a 4 ", SALTO;

}


if ($numero ===4 and $numero %2 ==0){
    echo " el numero es igual a 4 y su resto al dividir por 2 es 0" , SALTO;


}

$edad = 21;


if($edad > 18 ){

    echo " puedes ver la peli" ,SALTO ;


}else{
    echo "No puedes ver la peli" , SALTO;

}

$Tipo_carnet = "C1";

if ($edad > 18 AND $Tipo_carnet =="C1") {

    echo "Obtencion del carnet del camion" , SALTO;
    echo "Tienes $edad y al superar los 21 puedes obtene el carnet $Tipo_carnet", SALTO;
    
}else {
    echo " No Tienes $edad" , SALTO;
}


// Uso de cdigo html en las estructuras de control

if($edad > 18 AND $edad < 65) {?>
<h3>SErvicios de gimnasio disponibles</h3>
<ul>

    <li>Spining</li>
    <li>Boxeo</li>
    <li>Zumba</li>

</ul>
<?php }
else {?>
    <h3> Servicios para jubilados o mneores de 18</h3>

    <ul>
        <li>Taichi</li>
        <li>Pilates</li>
        <li>Yoga</li>
    
    </ul>
<?php 

}


if ($Tipo_carnet =="C1") 

    echo <<< CARNET_C1

    <h2>Documentacion para obtener el carnet $tipo_carnet</h2>

    <ul>
    <li>Fotocopia de carnet</li>
    <li> Certificado de penales</li>
    <li> Carnet B2 </li>
    
    </ul>
    
    CARNET_C1

?>




<h2> if else anidado </h2>

<?php 

$nota = 6.5;

if($nota >=0 AND $nota < 5){
    echo "Aprobado" , SALTO;
}else {
    if ($nota <6) {
        echo "bien" ,SALTO;
    }else {
        if ($nota < 7) {
            echo "notable" , SALTO;
        }else{
            if ($nota < 9) {
                echo " sobrelasiente" , SALTO;
            }
        }
    }
}

// hacer lo mismo pero con else if(condicion)

if ($nota < 5) {
    echo "suspenso" , SALTO;
}elseif ( $nota < 6) {

    echo " bien" , SALTO;
}


// hacer lo mismo con switch(match en php)

$nota = 7;


switch ($nota) {
    case 1:
        echo "Supenso" , SALTO;
        break;

    case 2:
    case 3:
    case 4:
        echo "Supenso" ,SALTO;
        break;

    case 5:
        echo "Aprobado", SALTO; 
        break;    
    case 6:
        echo "Bien" , SALTO;
        break;
    default:
        echo "valor incorrecto" , SALTO;
        break;
}


//Expresion match

$calificacion = match($nota){

    0, 1, 2, 3, 4 => "suspenso" ,
    5             => "Aprobado" ,
    6             => "Bien",
    7 , 8         =>" notable" , 
    9, 10         => "Sobresaliente",
    default       =>"Nota erronea"

};
// poner ; al final del match


echo "con tu nota $nota tienes una calificación de $calificacion" , SALTO;


?>


<h2>Operador ternario ? </h2>

<?php 

// Sintaxis : 

// <condicion> ? <expresion_true> : <expresion_false> ;

$nota = 6;

$resultado = $nota >= 5 ? "Con un $nota estas aprobado" : "Con un $nota suspenso";

echo "$resultado" ,SALTO;

$con_beca = true;
$nombre= "Juan gomez";
?>


<form action="" method="POST">

    ...

    <input type="text" name="nombre" size="30" value="<?= isset($nombre) ? $nombre : "" ?>">
    <input type="checkbox" name="con_beca" <?= $con_beca ? "checked" : "" ?>>con beca <br>
    <button>Enviar</button>



</form>


<h2>Operador dde fusion NULL</h2>

<?php

    $metodo = "POST";
    $segundo_metodo = "GET";
    $por_defecto = "main";

    $resultado = $metodo ?? $segundo_metodo;

    echo "El resultado es $resultado" , SALTO;


    //$metodo = "NULL";
    unset($metodo);
    $segundo_metodo = "GET";
    $por_defecto = "main";

    $resultado = $metodo ?? $segundo_metodo;

    echo "El resultado es $resultado" , SALTO;
    

    unset($metodo);
    unset($segundo_metodo);
    $por_defecto = "main";

    $resultado = $metodo ?? $segundo_metodo ?? $por_defecto;

    echo "El resultado es $resultado" , SALTO;


?>


<h2>Bucles</h2>

<ul>

<li>For con contador (Estilo java y c++)</li>
<li>For para colecciones de datos</li>
<li>while</li>
<li> do while </li>
<li> Sentencias break y continue</li>

</ul>


<?php 

$numero = 4;

for ($i = 1; $i <=10; $i++){

  echo "$numero x $i =" , strval($numero * $i) . SALTO;

}




// Diferencias entre :
    // $i ++ , ++$i => niguna 


    echo "los 10 primeros numeros pares" , SALTO;

    for ($i=2; $i < 2*10 ; $i+2) { 
        
        echo "numero par: $i ";
    }



    echo "La cuenta atras para el lanzamiento" ,SALTO;
    
    for ($i=0; $i >=0 ; $i--) { 
        echo $i , "segundos";

    }

    echo "Ignicion" , SALTO;


    // Varias expresiones en el inicio del contador
                // y en la parte del incremento
                for( $i = 10, $j = 0; $i >= 5 And $j < 8; $i--, $j+=2 ){
                    echo "Valor de i es $i y valor de j es $j<br>";
                }
?>


<h2>bucle while</h2>

<?php 

//Sumar los numero pares que se generan aleatoriamente
// hasta que salga el 0

$numero = rand(0,10);
$total = 0;
while ($numero !=0) {
    echo "el numero generado es $numero" , SALTO;
    if ($numero % 2==0) {
        $total += $numero;
    }
    $numero = rand(0,10);

    echo"El total de los pares es : $total";

}


?>


<<h3>Do .. while</h3>
  <?php
            // Contar cuantos números impares
            // se generan aleatoriamente
            // hasta que se genera uno negativo
            $total = 0;
            do {
                $numero = rand(-5, 50);
                if( abs($numero) % 2 == 1 ) 
                    $total ++;

            }while( $numero >= 0);
            echo "Se han generado $total números impares";

 ?>



<h2>Sentencias break y continue </h2>

<?php

// Bucle repetir .. hasta un break
            $total = 0;
        do {
            
            $numero = rand(0,20);
            if($numero % 3 == 0){
                $total++;
                echo " el numero generado es $numero" ,SALTO ;
                
            }
            if (!$numero ) {
                break;

            }
          
        } while (true);

        echo " Se han generado un total de $total de multiplods de 3" , SALTO;

        //Generar numeros aleatorios entre 1 y 10 y sumar los pares
        // hasta que la suma sea superior a 100 o se hayan generado como maximo 20 numeros


        while (True) {
            $numero = rand(1,10);
            $contador = 0;
            $suma_pares += $numero;

            if ($numero %2 ==0) {
                $suma_pares +=$numero;
            }

            if ($suma_pares > 100) {
                break;
            }

            $contador++;
            if ($contador = 20) {
                break;
            }

        }
        echo "SE han generado $contador numeros y la suma de los pares es: $suma_pares";


        //Break admite un argumento numerico entero par indica de que bucle se sale
        //Solo sirve si hay bucles anidados.

        // Generar 200 numeros aleatoriosentre 1 y 1000

        // por cada numero se comprueba cuantos numero hay desde 1 hasta ese numero
        // Si hay mas de 10 numeros primos que termine.
        // Al final visualizar cada numero generado y los primos hasta ese numero.



        /*
        
        
        ej: se genera aleatoriamente el 25:

        el nuemro es 25 y los primos son: 1,2,3,5,7,11,13,17,19.....
        
        */


        for ($i=0; $i < 200; $i++) { 
            
            $numero  = rand(1,1000);
            $cuantos_primos = 0;
            echo "EL numero generado es: $numero" , SALTO;

            for ($j=1; $j <$numero ; $j++) { 
                // Averiguar si j es primo
                $es_primo = true;
                $k = 2;
                $raiz_cuadrada = sqrt($j);
                while ($es_primo && $k<=$raiz_cuadrada) {
                    if ($j % $k ==0) {
                        $es_primo = false;
                    }
                    $k++;


                }
                //¿Como podemos saber si el numero j es primo?
                if ($es_primo) {
                    echo "$j" , SALTO;
                    $cuantos_primos++;

                    if($cuantos_primos > 10){
                        break;
                    }

                }



            }

        }




        //Genera 10 numeros aleatorios
        //por cada  uno genera 10 caracteres en minuscula aleatorios
        // si alguno de los caracteres generados es z, se acaba y no se generan

        for ($i=0; $i < 10; $i++) { 
            $numero = rand(1,10);
            echo "el numero es $numero";
            if ($numero % 2 ==1) {
                continue;
            }
            for ($j=0; $j <=$numero ; $j++) { 
                //Genero un caracter aleatorio
                $codigo_ascii_letra = chr(97,122);
                $caracter = chr($codigo_ascii_letra);
                echo "$caracter";
                if ($caracter == "2") {
                    break 2;
                }
            }
        }





?>

<h2>Sintaxixs alternativa a las estructuras de control</h2>

<?php


        $numero = rand(1,100);
        if ($numero % 2 ==0):
            echo "El numero $numero es par" ,SALTO;
        else :
            echo " el numero $numero es impar" , SALTO;
        endif;
        
        for ($i=1; $i <=10 ; $i++) {
            echo "$i x $numero = " , $i *$numero , SALTO; 
        }

        $i = 10;
        while ($i >0 ) {
            echo "el valor de i es $i";
            $i++;
        }


?>



</body>
</html>