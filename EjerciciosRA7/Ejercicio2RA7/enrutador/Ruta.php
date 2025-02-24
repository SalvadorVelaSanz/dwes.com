<?php

namespace Ejercicio2RA7\enrutador;


class Ruta{

    protected string $verbo;
    protected string $path;
    protected string $clase;
    protected string $funcion;


    public function __construct(string $verbo , string $path , string $clase , string $funcion){
        $this->verbo = $verbo;
        $this->path = $path;
        $this->clase = $clase;
        $this->funcion = $funcion;
    }

    public function getPath(){
        return $this->path;
    }

    public function getClase(){
        return $this->clase;
    }

    public function getFuncion(){
        return $this->funcion;
    }

    public function esIgual($verbo , $path) :bool{
        return $this->verbo === $verbo && preg_match($this->path , $path);
    }



}









?>