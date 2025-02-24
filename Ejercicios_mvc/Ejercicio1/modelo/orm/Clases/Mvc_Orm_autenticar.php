<?php

namespace Ejercicio1\modelo\orm\Clases;

use Ejercicio1\modelo\orm\Entidad\Articulos;
use PDO;
use PDOException;

class Mvc_Orm_autenticar {

   protected PDO $pdo ;

    public function __construct(){
        
        $dsn = "mysql:host=localhost;port=3306;dbname=tiendaol;charset=utf8mb4";
        $usuario = "usuario";
        $clave = "usuario";
        
        $opciones = [
            PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES      => false
        ];

        try {
            $this->pdo = new PDO($dsn , $usuario , $clave , $opciones);
        } catch (\PDOException $th) {
            throw $th;
        }
    }



    public function obtener_cliente( string $email){

        try {
            $sql_clientes = "SELECT nif, nombre , apellidos, clave from cliente Where email = :email ";

            $stmt = $this->pdo->prepare($sql_clientes);
            $stmt->bindValue(":email" ,$email);

            if ($stmt->execute()) {
                $resultado = $stmt->fetch();
                return $resultado;
            }
        } catch ( PDOException $th) {
            throw $th;
        }

    }

    public function obtener_articulos( string $nif){

        try {
            
        $sql_articulos = "SELECT a.referencia, a.descripcion , a.pvp , a.dto_venta , a.und_vendidas , a.und_disponibles , p.fecha, a.categoria , a.tipo_iva ";
        $sql_articulos .= "FROM articulo a INNER JOIN lpedido lp on a.referencia = lp.referencia ";
        $sql_articulos .= "INNER JOIN pedido p on lp.npedido = p.npedido ";
        $sql_articulos .=  "INNER JOIN cliente c on p.nif = c.nif ";
        $sql_articulos .= "WHERE c.nif = :nif ";
        $sql_articulos .= "ORDER BY p.fecha desc";
        
        $stmt = $this->pdo->prepare($sql_articulos);
        $stmt->bindValue(":nif" , $nif);
        $filas = [];
        if ($stmt->execute() && $stmt->rowCount() > 1) {
            while ($fila = $stmt->fetch()) {
                $filas[] = new Articulos($fila);
            }
        }

        } catch (\PDOException $th) {
            throw $th;
        }finally{
            return $filas;
        }


    }







}














?>