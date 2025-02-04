<?php

namespace Ejercicio1\modelo\orm\Clases;

use Ejercicio1\modelo\orm\Entidad\Reseña;
use PDO;
use PDOException;

class Mvc_Orm_reseña {

    protected PDO $pdo;

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
            $this->pdo = new PDO($dsn ,$usuario ,$clave, $opciones);
        } catch (PDOException $th) {
            throw $th;
        }
    }

    public function obtener_reseñas($referencia , $nif){

        try {
            $sql_reseñas = "SELECT * FROM reseña WHERE referencia = :referencia AND nif = :nif";
            $stmt = $this->pdo->prepare($sql_reseñas);
            $stmt->bindValue(":referencia" , $referencia);
            $stmt->bindValue(":nif" , $nif);

            $reseñas = [];
            if ($stmt->execute()) {
                while ($linea = $stmt->fetch()) {
                    $reseñas[] = new Reseña($linea);
                }
            }

        } catch (PDOException $th) {
            throw $th;
        }finally{
            return $reseñas;
        }

    }

    public function insertar_reseñas( Reseña $nueva_reseña){
        $objeto = $nueva_reseña->toArray();
      
        try {
            $sql_insertar = "INSERT into reseña (nif ,referencia, fecha, clasificacion , comentario) VALUES (:nif,:referencia,:fecha,:clasificacion,:comentario)";

        $stmtInsertar = $this->pdo->prepare($sql_insertar);

        foreach ($objeto as $columna => $valor) {
            if ($columna !== "id_reseña") {
                if ($columna == "fecha") {
                    $stmtInsertar->bindValue(":$columna" , $valor->format("Y-m-d H:m:s"));
                }else{
                    $stmtInsertar->bindValue(":$columna" , $valor);
                }
               
            }
        }
        // $stmtInsertar->bindValue(":nif" , $nif);
        // $stmtInsertar->bindValue(":referencia" , $referencia);
        // $stmtInsertar->bindValue(":fecha" , $fecha);
        // $stmtInsertar->bindValue(":clasificacion" , $clasificacion);
        // $stmtInsertar->bindValue(":comentario" , $comentario);

        if ($stmtInsertar->execute() && $stmtInsertar->rowCount() ==1) {
            return true;
        }else{
            return false;
        }

        } catch (PDOException $th) {
            throw $th;
        }
    }












}

















?>