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


    //Varias expresiones de inicio del contador
    // y en la parte del incremento

    for ( $i=10 , $j = 5; $i>= 5 and $j>4; $i-- , $j++;) { 
        echo " valor de i es $i y valor de j es $j ";
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

</body>
</html>