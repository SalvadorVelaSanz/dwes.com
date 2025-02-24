<?php

namespace Ejercicio1RA7\modelo;
use PDO;
use PDOException;
use Exception;
use Ejercicio1RA7\Entidad\Forma_envio;

class RpcOrmForma_envio {

    protected PDO $pdo;


    public function __construct(){
        $dsn = "mysql:host=localhost;port=3306;dbname=tiendaol;charset=utf8mb4";
        $usuario = "usuario";
        $clave = "usuario";

        $opciones = [
            PDO::ATTR_EMULATE_PREPARES  => false,
            PDO::ATTR_ERRMODE =>    PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try {
            $this->pdo = new PDO($dsn , $usuario , $clave , $opciones);    
        } catch (\PDOException $th) {
            throw $th;
        }

        
    }


    public function obtenerCoste($n){
        $formas_envio = [];
        try {
            $sql = "SELECT * from forma_envio where coste <= :n order by coste DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":n" , $n);
            if ($stmt->execute()) {
                
                while ($linea = $stmt->fetch()) {
                    $formas_envio[] = new Forma_envio($linea);
                }
            }

        } catch (PDOException $th) {
            throw $th;
        }finally{
            return $formas_envio;
        }

    }








}












?>