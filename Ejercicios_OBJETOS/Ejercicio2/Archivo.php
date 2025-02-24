<?php

class Archivo{

private string $nombre;
private string $path;
private string $tipo_mime;

private $puntero;

private const MIMES_PERMITIDOS = ["text/plain","text/csv"];

public function __construct(string $no , string $pa , string $mime){
    $this->nombre = $no;
    $this->path = $pa;
    $this->setMime($mime);

    // Intentar abrir el archivo y verificar si la apertura fue exitosa
    $this->puntero = fopen($this->path,"a+");
    if (!$this->puntero) {
        throw new Exception("No se pudo abrir el archivo: " . $this->path);
    }
}




private function setMime(string $mime) :void{

    if (in_array($mime, self::MIMES_PERMITIDOS)) {
        $this->tipo_mime = $mime;
    }else{
        throw new Exception("Error tipo mime no permitido", 1);
        
    }

}



public function escribirLinea(string $cadena) :bool {
  
    if ($this->puntero) {
        $cadena .= PHP_EOL;
        if (fwrite($this->puntero, $cadena)) {
            return true;
        } else {
            throw new Exception("Error al escribir en el archivo", 1);
        }
    } else {
        throw new Exception("Error al escribir en el archivo", 1);
    }
}

public function leerLinea(int $lineas_leer): string {
    // Verificar si el archivo tiene un puntero válido
    if ($this->puntero) {
        $cadena = "";
        $contador = 0;

        // Si el archivo es un CSV, reiniciar el puntero al principio
        if ($this->tipo_mime === "text/csv") {
            rewind($this->puntero); // Reinicia el puntero al principio del archivo
            
            // Leer las líneas del archivo CSV
            while (($linea = fgetcsv($this->puntero)) !== false) {
                if (!empty($linea)) {
                    // Convertir la línea (array) a una cadena y agregar un salto de línea HTML
                    $cadena .= implode(", ", $linea) . "<br>";
                    $contador++;
                }

                // Detenerse después de leer el número requerido de líneas
                if ($contador > $lineas_leer) {
                    break;
                }
            }

        } else {
            // Leer líneas normales para un archivo de texto
            while (($linea = fgets($this->puntero)) !== false) {
                $cadena .= htmlspecialchars($linea) . "<br>"; // Evitar HTML malicioso
                $contador++;

                // Detenerse después de leer el número requerido de líneas
                if ($contador == $lineas_leer) {
                    break;
                }
            }
          
       
        }
               
        if (empty($cadena)) {
            throw new Exception("No se encontraron líneas para leer.");
        }
        return $cadena;
    } else {
        throw new Exception("El archivo no está abierto.");
    }
}



public function __toString() :string{
    $cadena = "Archivo: \n";
    $cadena.=  "nombre: " . $this->nombre . "\n";
    $cadena.= "ruta: " . $this->path . "\n";
    $cadena.= "tipo mime: " . $this->tipo_mime;

    return $cadena;
}

public function __sleep(){
    if ($this->puntero) {
        fclose($this->puntero);
    }

    return ["nombre" , "path", "tipo_mime"];
}

public function __wakeup() {
    if (!$this->puntero) {
        $this->puntero = fopen($this->path, "a+");
    }
}



}
?>