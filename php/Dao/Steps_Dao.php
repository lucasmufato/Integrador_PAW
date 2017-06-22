<?php
include_once("../Controlers/DataBase_Controler.php");
include_once("../Model/Step.php");
include_once("../Model/StepPlate.php");


//esta clase se encarga de ABM de pasos y de ABM pasos-plaqueta, osea que pasos se realizan en q plaqueta
class TestDao{
    protected $connection = null;

    public function __construct(){
    	$bd = new DataBase();
    	$this->connection = $bd->getConnection();
    }

    //recibe un objeto step, lo persiste en la BD y lo devuelve, si hay error devuelve []Strings
    public function NewStep($step){
        
    }


}