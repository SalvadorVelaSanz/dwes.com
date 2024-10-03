<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Variables</h1>

    <?php
        // Las variables se definen con $identificador
        $nombre_variable = "valor de la variable";

        // Variables que no se han definido
        $resultado = $numero + 25;
        echo "El valor del numero es $numero y el resultado es $resultado<br>";

        $resultado = $sin_definir + 5.5;
        echo "El valor de sin definir es $sin_definir y el resultado es $resultado<br>";

        // Si la variable está en un contexto lógico su valor
        // lógico asume por defecto
    ?>

    <h2>Análisis de variables</h2>
    <h3>Análisis simple</h3>

    <?php
        // Consiste en introducir una variable en una cadena con " o heredoc
        // para incrustar su valor dentro de la cadena.
        echo "El resultado es $resultado<br>";
    ?>

    <h3>Análisis complejo</h3>
    <?php
        // En algunas situaciones nos encontramos ambiguedad en
        // una variable interpolada. Para ello usamos la llaves
        // y se elimina la ambiguedad.
        $calle = "Trafalgar Sq";
        $numero = "5";
        $pblacion = "London";
        $distrito = "5000";

        echo "Mi dirección en Londres es {$numero}th, $calle<br>$pblacion<br>$distrito<br>";
    ?>

    <h2>Funciones para variables</h2>
    <?php
        // Función gettype()
        $numero = 10;
        echo "El tipo de datos de $resultado es " . gettype($resultado) . "<br>";
        echo "El tipo de datos de una expresión es " . gettype($numero + 5.5) . "<br>";

        // Función empty()
        /* Comprueba si una variable si tiene un valor
            - Si es entero devuelve True si es 0, False en caso contrario.
            - Si es float devuelve True si es 0.0, False en caso contrario.
            - Si es cadena devuelve True si es "", False en caso contrario.
            - Devuelve True si es NULL o False
        */

        if(empty($numero) ) echo "\$numero tiene el valor $numero<br>";
        else echo "\$numero tiene un valor no vacio<br>";


        $numero = NULL;
        if ( empty($numero) ) $numero = 18;
        else echo "\$numero ya tiene un valor asignado y es $numero<br>";

        // Funcion isset()
        // Devuelve True si la variable está definida y no es NULL
        if( isset($nueva_varianle)) echo "La variable está definada y su 
                                        valores es $nueva_varianle<br>";
        else echo "La variable no está definida<br>";

        $variable_null = NULL;
        if( isset($variable_null) ) echo "La variabe está definida<br>";
        else echo "La variable $variable_null no está definida o tiene valor NULL";

        /* Funciones que comprueban los tipos de datos
                - is_bool() -> True si la expresión es booleana
                - is_int() -> True si  la expresión es integer
                - is_float() -> True si la expresiń es float
                - is_string() -> True si la expresión es una cadena
                - is_array() -> True si la expresión es un array

                En cualquier otro caso, devuelve False.
        */

        $edad = 25;
        $mayor_edad = $edad > 18;
        $numero_e = 2.71;
        $mensaje = "El número e es " . $numero_e . "<br>";

        if( is_int($edad) ) echo "\$edad es un entero<br>";

        if( is_bool($mayor_edad) ) echo "\$mayor_edad es booleana<br>";

        if( is_float($numero_e) ) echo "\$numero_e es float<br>";

        if( is_string($mensaje) ) echo "\$mensaje es una cadena<br>";
    ?>

    <h2>Constantes</h2>
    <p>Una constante es un valor con nombre que no puede cambiar de valor en el programa.
        Se le asigna un valor en la declaración y permanece invariable. Se definen de dos formas:<br>
        -Mediante la función define()<br>
        -Mediante la palabra clave const
    </p>

    <?php
        define("PI", 3.14159);
        define("PRECIO_BASE", 1500);
        define("DIRECTORIO_SUBIDAS", "/uploads/archivos");

        echo "El número PI es " . PI . "<br>";
        $area_circulo = PI * PI * 5;
        echo "El área del círculo de radio 5 es $area_circulo<br>";

        $path_archivo = DIRECTORIO_SUBIDAS . "/archivo.pdf";
        echo "El archivo subido es $path_archivo<br>";

        const SESION_USUARIO = 600;
        echo "La sesión de usuario finaliza en " . SESION_USUARIO . " segundos<br>";

        // Constantes predefinidas por PHP
        echo "El script es " . __FILE__ . " y la línea es " . __LINE__ . "<br>";
    ?>


    <h2>Expresiones, operadores y operandos</h2>
    <p>Una expresion es una combinacion de operandos y operadores que arroja un resultado. tiene tipos de datos,
        de sus operandos y de la operacion realizada <br>
        un operador es un simbolo formado por uno dos o tres caracteres que denota una operacion <br>
        los operadores pueden ser <br>
        uninarios: solo necesita un operando
        binarios: utilizan dos operandos
        terciarios: utilizan tres operandos

        un operando es un expresion que en si misma, siendo la mas simples un litteral o una variable,, pero tambien puede ser un valor
        devuelto por una funcion ob_clean el resultado de otra expresion <br>
        La operaciones de una expresion no se ejecutan a la vez sino en orden segun la precedencia y asociatividad de los operadores . esta puede alterar 
        a conveniencia.


    </p>

    <h2>Operadores</h2>
    <h3>Asignación</h3>


    <?php 
    
    
    // El operador de asignacion es =

    $numero = 45;
    $resultado = $numero + 5 -29 ;
    $sin_valor = NULL;
    
    ?>


    <?php 

    // + suma 
    // - resta 
    // * multiplicacion
    // / division
    // % modulo
    // ** U_MALFORMED_EXPONENTIAL_PATTERN

    // unarios
    // + conversion a entero
    // - el opuesto

    const SALTO = "<br>";

    $numero1 = 15;
    $numero2 = 18;

    $suma = $numero1 + 10;
    $resta = 25 - $numero2;
    $opuesto = -$numero1;
    $multiplicacion = $numero1 * 3 ;
    $division = $numero2 / 3;
    $modulo = $numero1 % 4;
    $potencia = $numero1**2;
    
    echo "$numero1 y  $numero2" . SALTO;
    echo "$suma , $resta , $opuesto , $multiplicacion, $division , $modulo , $potencia" . SALTO;

    $numero3 ="35";
    $numero4 = +$numero3;

    echo " el \$numero4 es $numero4 y su tipo es " , gettype($numero4) , SALTO;

    $numero5 = PI;
    $numero6 = +$numero5;

    echo " el \$numero6 es $numero4 y su tipo es " , gettype($numero6) , SALTO;
    ?>  



</body>
</html>