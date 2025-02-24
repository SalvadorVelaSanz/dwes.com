<?php

namespace Ejercicio4\modelo; 

use Ejercicio4\bd\Database;
use Ejercicio4\entidad\entidad;
use PDO;
use PDOException;

abstract class  ORMbase {


    protected string $clave_primaria ;
    protected string $tabla;

    private PDO $pdo;

    public function __construct(){
        $instancia_database = Database::getInstance();
        $this->pdo = $instancia_database->getConexion();

    }


    public function get(mixed $id){
       try {
        $sql = "SELECT * FROM {$this->tabla} WHERE {$this->clave_primaria} = :nif" ;
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":nif" ,$id);
        if ( $stmt->execute()) {
            $fila = $stmt->fetch();
            
            $clase = $this->getClaseEntidad();
            $objeto = new $clase($fila);
            return $objeto;
        }
        return null;
       } catch (\PDOException $th) {
        throw $th;
       }
        
    }

    public function getAll() :array{
        try {
            $sql = "SELECT * FROM {$this->tabla}";
        $stmt = $this->pdo->query($sql);
        $filas =[];
        if ($stmt->execute()) {
            while ($fila = $stmt->fetch()) {
                $clase = $this->getClaseEntidad();
                $objeto = new $clase($fila);
                $filas[] = $objeto;
            }
            
        }
        } catch (\PDOException $th) {
            throw $th;
        }
        finally{
            return $filas;
        }
    }

    public function insert(entidad $nuevaFila) :bool{
        $array_objeto = $nuevaFila->toArray();
        $columnas = array_keys($array_objeto);

        $sql = "INSERT INTO {$this->tabla} VALUES(:" .implode( ", :" ,$columnas) . ")";

        try {
            $stmt = $this->pdo->prepare($sql);
            foreach ($array_objeto as $columna => $valor) {
                $stmt->bindValue(":$columna" , $valor);
            }
            return $stmt->execute() && $stmt->rowCount() ==1;
        } catch (\PDOException $th) {
            throw $th;
        }
   
    }


    public function update( mixed $id ,entidad $fila) :bool{

        $array_objeto = $fila->toArray();

        $sql = "UPDATE {$this->tabla} SET ";
        foreach($array_objeto as $columna => $valor ) {
            $sql.= "$columna = :$columna, ";    
        }
        $sql = rtrim($sql, ", ");
        
        $sql.= " WHERE {$this->clave_primaria} = :id";



        // $array_objeto = $fila->toArray();

        // $sql = "UPDATE {$this->tabla} SET";
        // foreach ($array_objeto as $columna => $valor) {
        //     $sql.= "$columna = :$columna, ";
        // }
        // $sql = rtrim($sql , ",");
        // $sql.= "WHERE {$this->clave_primaria} = :id";

        try {
            $stmt = $this->pdo->prepare($sql);
            foreach ($array_objeto as $columna => $valor) {
                $stmt->bindValue(":$columna" ,$valor);
            }
            $stmt->bindValue(":id" ,$id);
            return $stmt->execute() && $stmt->rowCount() ==1;
        } catch (\PDOException $th) {
            throw $th;
        }

    }

    public function delete(mixed $id){
        $sql = "DELETE FROM {$this->tabla} WHERE {$this->clave_primaria} = :id";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":id" , $id);
            return $stmt->execute() && $stmt->rowCount() ==1;
        } catch (\PDOException $th) {
            throw $th;
        }
    }

    public abstract function getClaseEntidad();


}







?>