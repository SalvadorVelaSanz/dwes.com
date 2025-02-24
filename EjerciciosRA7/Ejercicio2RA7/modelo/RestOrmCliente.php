<?php

namespace Ejercicio2RA7\modelo;
use PDO;
use PDOException;
use Exception;
use Ejercicio2RA7\entidad\Cliente;
use Ejercicio2RA7\entidad\Pedido;


class RestOrmCliente {

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
            $this->pdo = new PDO($dsn , $usuario , $clave , $opciones);
        } catch (\PDOException $th) {
            throw $th;
        }
    }


    public function validarDatos(bool $nuevo = true){
        $cuerpo = file_get_contents("php://input");
        $peticion  = json_decode($cuerpo , true);


        $filtro_saneamiento = [
            'nif' => FILTER_SANITIZE_SPECIAL_CHARS,
            'nombre' => FILTER_SANITIZE_SPECIAL_CHARS,
            'apellidos' => FILTER_SANITIZE_SPECIAL_CHARS,
            'clave' => FILTER_SANITIZE_SPECIAL_CHARS,
            'iban' => FILTER_SANITIZE_SPECIAL_CHARS,
            'telefono' => FILTER_SANITIZE_SPECIAL_CHARS,
            'email' => FILTER_SANITIZE_EMAIL,
            'ventas' => ["filter" => FILTER_SANITIZE_NUMBER_FLOAT , "flags" => FILTER_FLAG_ALLOW_FRACTION]
        ];

        $datos_saneados =  filter_var_array($peticion ,$filtro_saneamiento , true);

        $filtro_validacion = [
            'nif' => FILTER_DEFAULT,
            'nombre' => FILTER_DEFAULT,
            'apellidos' => FILTER_DEFAULT,
            'clave' => FILTER_DEFAULT,
            'iban' => FILTER_DEFAULT,
            'telefono' => FILTER_DEFAULT,
            'email' => FILTER_VALIDATE_EMAIL,
            'ventas' => ["filter" => FILTER_VALIDATE_FLOAT , "options" =>["min" => 0] , "flags" => FILTER_NULL_ON_FAILURE]
        ];

        $datos_validados = filter_var_array($datos_saneados , $filtro_validacion);

        if ($nuevo === true) {
            $cliente = new Cliente($datos_validados);
            return $cliente;
        }else{
            $cliente = new Cliente (array_filter($datos_validados));
            return $cliente;
        }

    }

    public function getFiltro(){

        $filtro_saneamiento = [
            'nif' => FILTER_SANITIZE_SPECIAL_CHARS , 
            'nombre' => FILTER_SANITIZE_SPECIAL_CHARS , 
            'email' => FILTER_SANITIZE_SPECIAL_CHARS
        ];

        $datos_devolver = filter_input_array(INPUT_GET , $filtro_saneamiento , false);

        if ($datos_devolver) {
            $cliente = new Cliente($datos_devolver);
            return $cliente;
            return ;
        }else{
            return null;
        }




    }


    public function getAll(){
        $clientes = [];
   
        try {
            $filtro = $this->getFiltro();
            $filtros = $filtro->toArray();
            $clausula_where = "WHERE ";

            if ($filtro) {
                foreach ($filtros as $columna) {
                    $clausula_where ="$columna LIKE :$columna AND";
                }
            }
            $clausula_where = rtrim("AND" , $clausula_where);

            

            $sql = "SELECT * FROM cliente";
            $sql.= $clausula_where;

            $stmt = $this->pdo->prepare($sql);
            
            if ($clausula_where) {
                foreach ($filtros as $propiedad => $valor) {
                    $stmt->bindValue("$:propiedad" , $valor);
                }
            }
            
            if ($stmt->execute()) {
                while ($linea = $stmt->fetch()) {
                    $clientes[] = new Cliente($linea); 
                }
    
                // Respuesta exitosa
                $resultado["exito"] = true;
                $resultado["error"] = null;
                $resultado["datos"] = $clientes;
                $resultado["codigo"] = 200; // Código HTTP 200 OK
            } else {
                // Si no se obtienen resultados
                $resultado["exito"] = false;
                $resultado["error"] = "No se pudieron obtener los clientes.";
                $resultado["datos"] = $clientes;
                $resultado["codigo"] = 404; // Código HTTP 404 Not Found
            }
        } catch (\PDOException $th) {
            // Manejo de errores
            $resultado["exito"] = false;
            $resultado["error"] = [$th->getCode(), $th->getMessage()];
            $resultado["datos"] = $clientes;
            $resultado["codigo"] = 500; // Código HTTP 500 Internal Server Error
        }

        return $resultado;
    }
    

    public function getCliente($nif){
        try {
            $sql = "SELECT * from cliente where nif = :nif";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":nif" , $nif);
            if ($stmt->execute() && $stmt->rowCount() ===1) {
                $linea = $stmt->fetch();
                $cliente = new Cliente($linea);

                $resultado["exito"] = true;
                $resultado["error"] = null;
                $resultado["datos"] = $cliente;
                $resultado["codigo"] = "200 ok";

                return $resultado;
            }else{
                $resultado["exito"] = False;
                $resultado["error"] = null;
                $resultado["datos"] = null;
                $resultado["codigo"] = "404 Not found";

                return $resultado;
            }
        
        } catch (\PDOException $th) {
            $resultado["exito"] = false;
            $resultado["error"] = [$th->getCode() , $th->getMessage()];
            $resultado["datos"] = null;
            $resultado["codigo"] = "400 Bad Request";
            return $resultado;
        }

    }

    public function insertCliente(){
     
            try {
                $objeto = $this->validarDatos();

                $datos = $objeto->toArray();
        
                $sql = "Insert into cliente ";
                $values = "VALUES( ";
        
                foreach ($datos as $propiedad => $valor) {
                    $values .= ":$propiedad, ";
                }
                $values = rtrim($values , ", ") . ")";
        
                $sql.= $values;
        
                $stmt = $this->pdo->prepare($sql);
        
                foreach ($datos as $propiedad => $valor) {
                    $stmt->bindValue(":$propiedad" , $valor);
                }
        
                if ($stmt->execute() ) {
                    $resultado["exito"] = true;
                    $resultado["error"] = null;
                    $resultado["datos"] = "/cliente/{$datos['nif']}";
                    $resultado["codigo"] = "201 created";
        
                    return $resultado;
                }else{
                  
                        $resultado["exito"] = false;
                        $resultado["error"] = null;
                        $resultado["datos"] = null;
                        $resultado["codigo"] = "422 Unprocesable Entity";
                        return $resultado;
                
                        
            
                    }   
            } catch (\Exception $th) {
                $resultado["exito"] = false;
                $resultado["error"] = [$th->getCode() , $th->getMessage()];
                $resultado["datos"] = null;
                $resultado["codigo"] = "422 Unprocesable Entity";
                return $resultado;
            }
    
    
        }


        public function updateCliente($nif): array {
            try {
                $objeto = $this->validarDatos(false);
    
                $datos = $objeto->toArray();
    
                $sql = "UPDATE cliente ";
                $clausula_set = "SET ";
                foreach( $datos as $propiedad => $valor) {
                    if ($propiedad !== "nif") {
                        $clausula_set.= "$propiedad = :$propiedad, ";
                    }
                }
                $clausula_set = rtrim($clausula_set, ", ");
    
                $clausula_where = " WHERE nif = :nif";
    
                $sql.= $clausula_set . $clausula_where;
    
                $stmt = $this->pdo->prepare($sql);
                foreach($datos as $propiedad => $valor) {
                    $stmt->bindValue(":$propiedad", $valor);
                }
                $stmt->bindValue(":nif", $nif);
                if( $stmt->execute() ) {
                    if( $stmt->rowCount() == 1 ) {
                        $resultado['exito'] = True;
                        $resultado['datos'] = null;
                        $resultado['codigo'] = "204 No Content";
                        $resultado['error'] = null;
                    }
                    else {
                        $resultado['exito'] = False;
                        $resultado['datos'] = null;
                        $resultado['codigo'] = "422 Unprocessable Entity";
                        $resultado['error'] = [4001, 'No existe una fila con clave $nif'];
                    }
                }
            }
            catch(Exception $e) {
                $resultado['exito'] = False;
                $resultado['datos'] = null;
                $resultado['codigo'] = "422 Unprocessable Entity";
                $resultado['error'] = [$e->getCode(), $e->getMessage()];
            }
            return $resultado;
        }

        public function deleteCliente($nif): array {
            try {
                $sql = "DELETE FROM cliente WHERE nif = :nif";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(":nif", $nif);
                if( $stmt->execute() ) {
                    $resultado['error'] = null;
                    $resultado['codigo'] = "204 No Content";
                    $resultado['datos'] = null;
                    $resultado['exito'] = true;
                }
                else {
                    $resultado['exito'] = false;
                    $resultado['codigo'] = "404 Not Found";
                    $resultado['datos'] = null;
                    $resultado['error'] = null;
                }
            }
            catch(Exception $e) {
                $resultado['exito'] = false;
                $resultado['codigo'] = "422 Unprocessable Entity";
                $resultado['datos'] = null;
                $resultado['error'] = [$e->getCode(), $e->getMessage()];
            }
            return $resultado;
        }


        public function getPedidosCliente($nif){
            $pedidos = [];
            try {

                $sql = "SELECT * FROM pedido where nif = :nif";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(":nif" , $nif);
                if ($stmt->execute()) {
                    while ($linea = $stmt->fetch()) {
                        $pedidos[] = new Pedido($linea);
                    }
                    $resultado['exito'] = true;
                    $resultado['codigo'] = "200 ok";
                    $resultado['datos'] = $pedidos;
                    $resultado['error'] = null;
                }else{
                    $resultado['exito'] = false;
                    $resultado['codigo'] = "200 ok";
                    $resultado['datos'] = null;
                    $resultado['error'] = null;
                }
            } catch (\Exception $th) {
                $resultado['exito'] = false;
                $resultado['codigo'] = "200 ok";
                $resultado['datos'] = null;
                $resultado['error'] = null;
            }

            return $resultado;
        }



}









?>