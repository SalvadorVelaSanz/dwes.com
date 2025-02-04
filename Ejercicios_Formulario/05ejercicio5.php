<?php 

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");

inicio_html("Ejercicio 5" , ["/estilos/general.css" , "/estilos/formulario.css"]);



function calcularPrecio($destino_precio , $compania_precio , $hotel_precio , $desayuno_incluido , $numero_personas , $numero_dias , $precio_extras ){

    $precioFinal = 0;

    $precioFinal += $destino_precio * $numero_dias * $numero_personas;
    $precioFinal += $compania_precio * $numero_dias * $numero_personas;
    $precioFinal += $hotel_precio * $numero_dias * $numero_personas;
    $precioFinal += $desayuno_incluido * $numero_dias * $numero_personas;
    $precioFinal += $precio_extras ;

    return $precioFinal;

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
     // Sanitización y validación de datos
     $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);
     $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_SPECIAL_CHARS);
     $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
 
     // Validar y extraer el destino
     $destino = filter_input(INPUT_POST, 'destino', FILTER_SANITIZE_SPECIAL_CHARS);
     list($destino_nombre, $destino_precio) = explode("-", trim($destino));
 
     // Validar y extraer la compañía aérea
     $compania_aerea = filter_input(INPUT_POST, 'compania_aerea', FILTER_SANITIZE_SPECIAL_CHARS);
     list($compania_nombre, $compania_precio) = explode("-", trim($compania_aerea));
  
     // Validar y extraer el hotel
     $hotel = filter_input(INPUT_POST, 'hotel', FILTER_SANITIZE_SPECIAL_CHARS);
     list($hotel_nombre, $hotel_precio) = explode("-", trim($hotel));
 
     // Desayuno incluido
     $desayuno_incluido = isset($_POST['desayuno_incluido']) ? 20 : 0;
     
     // Validar número de personas y días
     $numero_personas = filter_input(INPUT_POST, 'numero_personas', FILTER_VALIDATE_INT, [
         "options" => ["min_range" => 5, "max_range" => 10]
     ]);
     
     $numero_dias = filter_input(INPUT_POST, 'numero_dias', FILTER_VALIDATE_INT);
 
     $extras = isset($_POST['extras']) ? $_POST['extras'] : [];
     $precio_extras = 0;
 
     if (is_array($extras)) {
         foreach ($extras as $extra) {
             list($extra_nombre, $extra_precio) = explode("-", trim($extra));
             $extra_precio = filter_var(trim($extra_precio), FILTER_VALIDATE_FLOAT); // Validar que el precio sea un número
 
             if ($extra_nombre == "Visita guiada en la ciudad") {
                 $precio_extras += $extra_precio;
             } else {
                 $precio_extras += $extra_precio * $numero_dias * $numero_personas;
             }
         }
     }

    

    $precioFinal = calcularPrecio($destino_precio, $compania_precio , $hotel_precio , $desayuno_incluido , $numero_personas ,$numero_dias , $precio_extras);

    echo "RESUMEN DEL PEDIDO <br>";
    echo "El nombre de la persona responsable es : $nombre <br>";
    echo "El telefono proporcionado es :$telefono <br>";
    echo "Su dirección de correo es : $email <br>";
    echo "Su destino es : $destino_nombre y su precio es : $destino_precio €/p/d <br>";
    echo "Su compañia aerea es : $compania_nombre y su precio es : $compania_precio €/p/d <br>";
    echo "Su hotel es : $hotel_nombre y su precio es : $hotel_precio €/p/d <br>";
    echo "Desayuno incluido : " . ($desayuno_incluido ? "si, 20€/p/d <br>" : "no <br>");
    echo "El numero de personas que van al viaje es : $numero_personas durante $numero_dias <br>";
    echo "Sus extras son : <br>";
    if (!empty($extras)) {
        foreach ($extras as $extra) {
            list($extra_nombre, $extra_precio) = explode("-", trim($extra));
            $extra_precio = filter_var(trim($extra_precio), FILTER_VALIDATE_FLOAT); 
            $extra_nombre = filter_var(trim($extra_nombre) , FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if ($extra_nombre === "Visita guiada en la ciudad ") {
                echo "$extra_nombre, precio: $extra_precio € <br>";
            } else {
                echo "$extra_nombre, precio: $extra_precio €/p/d <br>";
            }
        }
    }

    echo "El precio total de su viaje es : $precioFinal €";
    
}else {
    


?>

<form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">

<fieldset>

<legend>Datos de usuario</legend>

<label for="nombre">Nombre de la Persona responsable del grupo</label>
<input type="text" name="nombre" id="nombre">

<label for="telefono">Telefono</label>
<input type="tel" name="telefono" id="telefono">

<label for="email">Email</label>
<input type="email" name="email" id="email">

</fieldset>

<fieldset>

<legend>Datos de viaje</legend>

<label for="destino">Destino</label>
<select name="destino" id="destino">
    <option value="Paris - 100"> París 100€ / persona / día</option>
    <option value="Londres - 120"> Londres 120€ / persona / día</option>
    <option value="Estocolmo - 200"> Estocolmo 200€ / persona / día</option>
    <option value="Ediburgo - 175"> París 175€ / persona / día</option>
    <option value="Praga - 125"> Praga 125€ / persona / día</option>
    <option value="Viena - 150"> Viena 150€ / persona / día</option>
</select>


<label for="compania_aerea">Compañia aerea</label>
<select name="compania_aerea" id="compania_aerea">
    <option value="Miair - 0"> MiAir - Incluído</option>
    <option value="Airfly - 50"> AirFly – Suplemento de 50 €/p</option>
    <option value="VuelaConmigo - 75"> VuelaConmigo– Sup 75 €/p</option>
    <option value="ApedalesAir - 150"> ApedalesAir– Sup 150€/p</option>
</select>


<label for="hotel">Hotel</label>
<select name="hotel" id="hotel">
    <option value="Incluido-0"> Incluído</option>
    <option value="Sup-40"> Sup 40 €/p</option>
    <option value="Sup-100"> Sup 100 €/p</option>
</select>

<label for="desayuno_incluido">Desayuno incluido</label>
<input type="checkbox" name="desayuno_incluido" id="desayuno_incluido" >

<label for="numero_personas">Numero de personas (entre 5 y 10) </label>
<input type="number" name="numero_personas" id="numeros_personas" min="5" max="10">

<label for="numero_dias">Numero de días</label>
<div>

    <input type="radio" name="numero_dias" id="numero_dias" value="5">5
    <input type="radio" name="numero_dias" id="numero_dias2" value="10">10
    <input type="radio" name="numero_dias" id="numero_dias3" value="15">15

</div>

<label for="extras">Extras</label>
<div>
    <input type="checkbox" name="extras[]" id="extras1" value="Visita guiada en la ciudad - 200 ">Visita guiada en la ciudad – 200 €
    <input type="checkbox" name="extras[]" id="extras2" value="Bus turístico - 30 ">Bus turístico – 30 €/p/d
    <input type="checkbox" name="extras[]" id="extras3" value="Maleta facturada - 20">2ª Maleta facturada – 20€/p/d
    <input type="checkbox" name="extras[]" id="extras4" value="Seguro de viaje - 30">Seguro de viaje - 30€/p/d



</div>
</fieldset>


<input type="submit" value="enviar" name="operacion" id="operacion">





</form>

<?php
}
fin_html();

?>