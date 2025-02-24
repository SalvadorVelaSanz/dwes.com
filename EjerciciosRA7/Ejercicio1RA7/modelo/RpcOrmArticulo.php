<?php

namespace Ejercicio1RA7\modelo;

use Ejercicio1RA7\Entidad\Articulo;
use PDO;
use PDOException;
use Exception;


class RpcOrmArticulo {


    protected PDO $pdo;


    public function __construct(){
        $dsn = "mysql:host=localhost;port=3306;dbname=tiendaol;charset=utf8mb4";
        $usuario = "usuario";
        $clave = "usuario";

        $opciones = [
            PDO::ATTR_EMULATE_PREPARES => false , 
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try {
            $this->pdo = new PDO($dsn , $usuario , $clave , $opciones);
        } catch (\PDOException $th) {
            throw $th;
        }
    }


    public function obtenerArticulosMasVendidos(int $n){
        $articulos = [];
        try {
            $sql = "SELECT * from articulo order by und_vendidas DESC limit :n";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":n" , $n);
            if ($stmt->execute()) {
               
                while ($linea = $stmt->fetch()) {
                    $articulos[] = new Articulo($linea);
                }
            } 
        } catch (\PDOException $th) {
            throw $th;
        }finally{
            return $articulos;
        }

    }







}




?>