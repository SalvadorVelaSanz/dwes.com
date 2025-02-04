<?php


namespace Ejercicio4\bd;


use \PDO;
use PDOException;

class Database{

    private static $instace = null;
    private PDO $pdo;

    public function __construct(){
        $dsn = "mysql:host=localhost;port=3306;dbname=tiendaol;charset=utf8mb4";
        $usuario = "usuario";
        $clave = "usuario";
    
        $opciones = [
        PDO::ATTR_ERRMODE               =>  PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE    =>  PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES      =>  false,
        PDO::ATTR_CASE                  =>  PDO::CASE_LOWER
        ];

        try {
            $this->pdo = new PDO($dsn , $usuario ,$clave , $opciones);
        } catch (PDOException $th) {
            throw $th;
        }
    }

    public static function getInstance() :Database{

        if (self::$instace === null) {
            self::$instace = new self();
        }
        return self::$instace;
    }

    public function getConexion() :PDO{
        return $this->pdo;
    }
}





?>