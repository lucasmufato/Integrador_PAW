<?php
include_once("../Controlers/DataBase_Controler.php");

class CreateTestDao{
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
    
}//fin de la clase