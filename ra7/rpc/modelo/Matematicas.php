<?php
namespace rpc\modelo;

class Matematicas {
    public function suma($a, $b) {
        return $a + $b;
    }
    
    public function resta($a, $b) {
        return $a - $b;
    }

    public function multiplicar($a, $b){
        return $a * $b;
    }
}
?>