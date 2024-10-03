<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

    <h2> Operadores de asignacion aumentada</h2>

    <?php 
    
    /*     
    
    Operadors de asignacion aumentada;

    ++ incremento
    --Decremento
    +=
    -=
    *=
    /=
    %=
    
    */
    const SALTO = "<br>";
    
    $numero = 4;
    $numero++;              // Equivalente a $numero = $numero + 1;
    echo "Antes numero era 4 ahora es $numero" ,SALTO;
    
    ++$numero;  // Equivalente a $numero  =$numero + 1;
    echo "Antes el numero era 5 ahora es $numero";

    $numero = 10;
    $resultado = $numero++ *2; //Equivale a $resultado = $numero *2; $numero +1;

    echo "el resultado es $resultado y el numero es $numero" ,SALTO;

    $numero = 10;
    $resultado =++$numero*2; //Equivale a $numero = $numero + 1; $resultado = $numero * 2; 
    echo "el resultado es $resultado y el numero es $numero" ,SALTO;

    $numero +=3; //Equivale a $numero = $numero + 3;
    echo "el  numero es $numero" , SALTO;
    $numero -=3; //Equivale a $numero = $numero - 3;
    echo "el  numero es $numero" , SALTO;
    $numero *=3; //Equivale a $numero = $numero * 3;
    echo "el  numero es $numero" , SALTO;
    $numero /=3; //Equivale a $numero = $numero / 3;
    echo "el  numero es $numero" , SALTO;
    $numero %=3; //Equivale a $numero = $numero % 3;
    echo "el  numero es $numero" , SALTO;
    
    ?>

    <H2> Operadores relacionales</H2>

    <?php 
    
    
    /* 
    
    == igual a
    === identico a 
    != distinto a 
    !== distinto valor a distinto tipo
    > mayor que
    < menor que
    >= mayor o igual
    <= menor o igual
    <=> nave espacial
    
    */ 
    
    $n1 = 5;
    $cadena = "5";

    $n2 = 8;

    $resultado = $n1==$n2;
    
    echo "es n1 igual que n2: ", (int)$resultado , SALTO;

    $resultado = $n1 = $cadena;

    echo "Es n1 igual que cadena: " , (int)$resultado ,SALTO;
    //Operador ===. ES true si los valores de los operandos son igaules y del mismo tipo.
    $resultado = $n1 ===$cadena;
    echo "es n1 identico a cadena : " , (int)$resultado , SALTO;

    $resultado = $n1!=$n2;
    echo " es n1 identico a n2: " , (int)$resultado , SALTO;
    
    //Operador !== Es True si son distintos o de diferente tipo, false en caso contrario.
    $resultado = $n1 != $cadena;

    echo "Es n1 distinto de cadena: " , (int)$resultado , SALTO;

    $resultado = $n1 !== $cadena;

    echo "Es n1 distinto de cadena: " , (int)$resultado , SALTO;
    
    //Nave espacial

    //si n1 es mayor que n2 devuelve 1

    //si n1 es igual que n2 devuelve 0

    //si n1 es menor que n2 devuelve 1

    // se usa para evitar esto :
        // if($n1<$n2){}
        // else if($n1=$n2) {}


    $resultado  = $n1 <=> $n2; 
    echo "es n1 mayor menor o igual que n2: " , (int)$resultado , SALTO;

    $nombre1 ="Zacarias";
    $nombre2 = "Adela";
    
    $resultado = $nombre1 > $nombre2 ;

    echo "El resultado es " , (int)$resultado , SALTO;

    $nombre1 ="Mario";
    $nombre2 = "MariA";

    $resultado = $nombre1 < $nombre2 ;


    echo "El resultado es " , (int)$resultado , SALTO;


    $nombre1 ="maria";
    $nombre2 = "Maria";

    $resultado = $nombre1 === strtolower($nombre2);


    echo "El resultado es " , (int)$resultado , SALTO;
    ?>




    <h2>Opeeradores logicos</h2>

    <?php 
    
    // AND  and logico o conjuncion logica
    // OR or logico o disyuncion logica
    // XOR or exclusivo
    // && and logico
    // || or logico

    $n1 = 9;
    $n2 = 5;
    $n3 = 10;
    $resultado = $n1 == $n2 OR $n3 > $n2 ;
    $resultado = $n1 == $n2 AND $n3 > $n2 ;

    echo "El resultado es: " , (int)$resultado , SALTO;

    $resultado1 = $n1 == 9 OR $n2 < $n1;
    $resultado = $resultado AND $n3 > 10;

    echo "El resultado es: " , (int)$resultado , " y ", (int)$resultado1 , SALTO;

    $resultado = $n1 == 9 || $n2 < $n1 AND $n3 > 10;
    echo "El resultado es: " , (int)$resultado , SALTO;

    $resultado = $n1 + 5 / $n3 < $n1 ** 3 AND $n3 / 5 +$n2 *2 >= $n1 *$n2 /$n3 OR $n1 -3 % 2 == $n3 - 7;

    echo "El resultado de la expresion es: " , (int)$resultado , SALTO;

    $n1 = 9;
    $n2 = 5;
    $n3 = 10;
    if(($n1 == 9 OR $n2 < $n1) AND $n3>10){
        echo " el resultado global es true" ,SALTO;
    }else{
        echo "el resultado global es false", SALTO;
    }
    
    ?>
</body>
</html>