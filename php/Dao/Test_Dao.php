<?php
include_once("../Controlers/DataBase_Controler.php");
include_once("../Model/Test.php");

class TestDao{
    protected $connection = null;

    public function __construct(){
    	$bd = new DataBase();
    	$this->connection = $bd->getConnection();
    }
    
    public function createTest($name, $descr){
        $query = $this->connection->prepare(" INSERT INTO test(test_name, test_date, test_description, id_result, result_description)VALUES ( ?, ?, ?, ?, ?); " );
        $query->bindParam(1, $name);
        $date = date("Y/m/d");
        $query->bindParam(2, $date);   //la fecha de ahora
        $query->bindParam(3, $descr);
        $resultado = 1; // HARCODEADO EL CODIGO DE "EN CREACION" O ALGO PARECIDO
        $query->bindParam(4, $resultado);
        $result_desc = null;
        $query->bindParam(5, $result_desc);
        
        $query->execute();
        $r = $query->fetch();
        
        //devuelvo esto, aunq podria ser mejor hacer una query por el nombre del test para obtener el id
        return $this->connection->lastInsertId();
    }
    
    //la funcion devuelve un arreglo con los test de un usuario, si el usuario no tiene devuelve nulo
    public function getTestsByResearcherId($id_researcher){
        $query = $this->connection->prepare("SELECT  id_test,  test_name,  test_date,                
             test_description,  id_result,  id_researcher,  result_description
            FROM test WHERE  id_researcher = :id;" );
        $query->bindParam("id", $id_researcher);
        $query->execute();
        
        $r = $query->fetchAll();
        $tests=null;
        foreach($r as $tupla){
            $tests[] = $this->getTestFromTupla($tupla);;
        }
        return $tests;
    }
    
    //devuelve el test con ese id_test
    public function getTestById($id){
       $query = $this->connection->prepare("SELECT  id_test,  test_name,  test_date,                
             test_description,  id_result,  id_researcher,  result_description
            FROM test WHERE  id_test = :id;" );
        $query->bindParam("id", $id);
        $query->execute();
        $tupla = $query->fetch();
        return $this->getTestFromTupla($tupla);
        
    }
    
    //funcion interna que dada una tupla de la BD en la que se saquen TODOS los datos de la tabla test, devuelve una instacia con esos datos
    private function getTestFromTupla($tupla){
        $t = new Test();
        $t->id = $tupla["id_test"];
        $t->name = $tupla["test_name"];
        $t->date= $tupla["test_date"];
        $t->description = $tupla["test_description"];
        $t->result = $tupla["id_result"];
        $t->researcher = $tupla["id_researcher"];
        $t->resultDescription = $tupla["result_description"];
        return $t;
    }
    
    
}//fin de la clase