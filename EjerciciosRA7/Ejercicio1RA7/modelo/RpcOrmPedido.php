<?php
namespace Ejercicio1RA7\modelo;
use PDO;
use PDOException;



class RpcOrmPedido {

    protected PDO $pdo;



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

    public function obtenerTotal($fecha){

        try {
           $sql = "SELECT SUM(total_pedido) as suma_total from pedido where fecha = :fecha";
           $stmt = $this->pdo->prepare($sql);
           $stmt->bindValue(":fecha" , $fecha);
           if ($stmt->execute()) {
                $resultado = $stmt->fetch();
                return $resultado['suma_total'];
           }
        } catch (\PDOException $th) {
            throw $th;
        }

    }


}
















?>