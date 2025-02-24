<?php

namespace Ejercicio1RA7\modelo;

use PDO;
use PDOException;
use Exception;

class RpcOrmCliente {


    private PDO $pdo;


    public function __construct(){
        $dsn = "mysql:host=localhost;port=3306;dbname=tiendaol;charset=utf8mb4";
        $usuario = "usuario";
        $clave = "usuario";

        $opciones = [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

       try {
            $this->pdo = new PDO($dsn , $usuario , $clave , $opciones);     
       } catch (\PDOException $th) {
            throw $th;
       }
        
    }


    public function verificarCliente($email , $clave){

        $sql_verificar = "SELECT * from cliente where email = :email";
        $stmt = $this->pdo->prepare($sql_verificar);
        $stmt->bindValue(":email" , $email);
        if ($stmt->execute()) {
            $cliente = $stmt->fetch();
            if ($cliente && password_verify($clave , $cliente['clave'])) {
                return "verificado";
            }else{
                throw new Exception("Error al verificar", 1);
                
            }
        }


    }

    public function obtenerVentas($nif){
        $sql_ventas = "SELECT ventas from cliente where nif = :nif";
        $stmt= $this->pdo->prepare($sql_ventas);
        $stmt->bindValue("nif" , $nif);
        if ($stmt->execute()) {
            $ventas = $stmt->fetch();
            return $ventas;
        }
    }

}












?>