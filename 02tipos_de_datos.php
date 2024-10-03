<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<h1>tipos de datos escalares(simples)</h1>


<ul>

<li>Booleanos</li>
<li>numerico entero</li>
<li>en coma flotante</li>
<li>Cadena de caractares</li>



</ul>


<h1>tipos de datos escalares compuestos</h1>


<ul>

<li>Arrays</li>
<li>Objetos</li>
<li>Callable</li>
<li>Iterable</li>

</ul>

<h1>tipos de datos especiales</h1>


<ul>

<li>Resource</li>
<li>NULL</li>

</ul>


<h2>Booleanos</h2>

<p> Iinicialmente las constantes True y False, Sin embargo, otros tipos de datos tiene conversión implicita al tipo booleano</p>

<ul>

<li>Numerico entero: 0 y -0 es false, cualquier otra cosa es true </li>
<li>Numerico coon coma flotante:0.0 y -0.0 es false, otro valor es true</li>
<li>un array con 0 elementos es false, con elementos es true</li>
<li>el tipo especial null es false, otro valor distinto  de null es true</li>
<li>una variable no definida es false</li>

</ul>

<?php 
$valorBooleano = true;
$edad = 20;
$mayor_edad= $edad >18 ;

echo "Mayor de edad es booleano: " , is_bool($mayor_edad);

$dinero = 0;
if($dinero) echo"<br> Soy rico";
else echo"<br> Soy pobre";

$mi_nombre="";

if($mi_nombre) echo"<br> me llamo $mi_nombre";
else echo"<br>No tengo nombre";

?>
<br>
<h2>Numeros enteros</h2>
<p>Numeros enteros en PHP son de 32 bits (depende de la plataforma). pueden expresarse en diferentes nomenclaturas, tambien pueden ser negativos</p>
<?php 

$numero_entero= 1234;

echo "<br> el numero es $numero_entero";

$numero_negativo= -1111;

echo "<br> el numero negativo es $numero_negativo";

//Sistema de numeracion del 0 al 7(empezar en 0 para que lo detecte)
$numero_octal = 0123;

echo "<br> el numero 0123 en decimal es: $numero_octal";

//Se puede mostrar un numero entero en octal ya que se guarda en decimal 
echo "<br> el numero: $numero_octal es en octal:" , decoct($numero_octal);

//NUmero entero en hexadecimal(empezar en 0x para que detecte)
$numero_hexadecimal= 0x8AE;

echo "<br> el numero 0x8AE en decimal es: $numero_hexadecimal";

//Mostrar numero en hexadecimal

echo "<br> el numero en hexadecimal es : " , dechex($numero_hexadecimal);

//NUmero entero en binario

$nummero_binario = 0b11011010101010;

echo "<br> el numero 0b11011010101010; en decimal es: $numero_binario";

//Mostrar numero en binario

echo "<br> el numero en binario es:" , decbin($numero_binario);

?>
<br>
<h2>NUmeros en punto flotante</h2>
<p> El separador decimal es el punto y se pueden expresar en numeros muy grandes o muy pequeños mediante la notación cientifica en base 10</p>


<?php 


$pi = 3.14149;

echo "<br> el numero PI es: $pi";

//redondear a 2 decimales 

echo "el numero PI con dos decimales es:" , round($pi,2);

$inf_int = 7.9e13;

echo "<br> Informacion que circula en internet en un dia $inf_int";

$tamaño_virus = 0.2e-9;

echo "<br> un virus tiene un tamño de $tamaño_virus";


?>

<br>

<h2>Cadenas de caracteres</h2>

<p>El string o cadena es una serie de caracteres donde cada caracter equivale a un bit, esto significa que php solo admite 256 caracteres por eso no
    ofrece soprte nativo a UTF-8

    un lineal de tipo string se expressa de 4 fromas distintas:
</p>

<ul>
    <li>Comillas simples</li>
    <li>Comillas doblles</li>
    <li>Heredoc</li>
    <li>Nowdoc</li>
</ul>

<h3>Comillas simples</h3>

<?php 

//una cadena encerrada entre comilla simples
//solo admite el caracter escape\' \\

echo 'Esto es una cadena sencilal <br>';

echo 'Puedo poner
una cadena en varias 
lienas hasta que no acabe en 
punto y coma';

// no se reconocen caracteres de escape excepto el ' y el \

echo' El mejor pub de la ciudad es 0\'Donel<br> ';
echo' LA raiz del disco duro es C:\ <br>';

echo 'esta cadena tiene\mas de una linea <br> ';

//no interpola variables

$$mi_nombre= "Manuel";
echo 'Hola , $mi_nombre , como estas <br>';

?>

<br>

<h3>Comillas dobles </h3>

<p> La forma habitual de expresar cadenas de caracteres ya que expnade los caracteres de escape y las variables</p>

<?php 

// las cadenas de php no son objetos, son primarios 

$cadena = "<br>Esto es una cadena con comillas dobles";

echo "<br> es una cadena un objeto????" , is_object($cadena);

if (is_object($cadena)) {
    echo "las cadenas en php son objetos";
}else {
    echo "LAS CADENAS NO SON OBJETOS PHP";
}


$con_secuencias_esc = "\t\t El simbolo \$ se emplea para las variables\n y si
lo quieres en una caadena hay que escaparlo con \\. es mejor usar \" para delimitar las cadenas en lugar de <br>";


echo $con_secuencias_esc;
?> 

<h3> cadenas Heredoc</h3>
<p> Es una cadena muy larga que empieza con <<< le sigue un identificador y justo despues un salto de linea 
A continuacion se escrbibe la cadena, con los saltos que necesitemos, podemos interpolar variable y poner caracteres de escape
Para finalizar hay que hacer un salto de linea y volver a poner el identificador
</p>



<?php 

$cadena_Hd = <<<HD
Esto es una cadena 
heredoc que respeta los saltos
de linea
les puedo poner variables como
$mi_nombre y ademas seecuencias
de escape. el identificador no necesita \$ y tampoco usamos \"
simplemente le escribimos y acabamos con un salto de linea 
mas el identificador <br>
HD;

echo $cadema_Hd;
?>

<h3> Cadenas Nowdoc</h3>

<p> la cadena Nowdoc es como heredoc pero con comillas simples. No se interpolan variables ni se reconocen seecuencias
    de escape mas alla de \ y '. Si se respetan los saltos de linea.
</p>

<?php 


$cadena_nd= <<<'ND'
Esto es una cadena nowdoc
y el salto de linea lo respeta
no puedo meter variables y 
solo reconoce \\ y \' <br>
ND;

echo $cadena_nd ;
?>

<h2>Conversiones de datos</h2>

<p> Hay dos conversiones: implicitas y explicitas. Las primeras ocurren cuando en una 
    expresion hay operadores de diferente tipo. PHP convierte algunos de ellos al evaluar la expresion
</p>

<?php 

$cadena = "25";
$numero = 8;
$booleano = true;
$resultado = $cadena + $numero + $booleano ;

echo $resultado;

?>

<p> IMÒRTANTE  CUANDO SE HACE UNA CONVERSION IMPLICITA SOLO AFECTA AL OPERANDO, PERO NO A LA VARIABLE. ES DECIR, 
    LA CONVERSION DE $CADENA A ENTERO SOLAMENTE PARA VALUAR LA EXPRESION, PERO $CADENA SIGUE SIENDO STRING
</p>


<?php 

$flotante = 3.5;
$resultado = $cadena + $flotante + $numero + $booleano;

echo "el resultado ahora es: $resultado<br>";

$cadena = "25 marranos dan mucho provecho";
$resultado = "$numero + cadena";
echo "el resultado es $resultado<br>";

$cadena = "mas de 25 marranos dan mucho provecho , mejor qu 7  lechones";
$resultado = $numero + $cadena;
echo "el resultado es $resultado<br>";


?>

<p> Las conversiones explicitas se conocen como casting o modelo y se hacen 
    precediendo la expresion con el tipo de dato a convertir entre parentesis
</p>

<?php 

// si quiero convertir a float a un entero -> (int)expresion
//si quiero convertir a float -> (float)expresion
// si quiero convertir a un string -> (string)expresion

echo "Conversiones a entero<br>";

$valor_booleano = True;
$valor_convertido = (int)$valor_booleano;
echo "El valor convertido a entero es: $valor_convertido<br>";

$valor_float = 3.14159;
$valor_convertido= (int)$valor_float;
echo "El valor convertido a entero es: $valor_floatbr>";




?>
</body>
</html>