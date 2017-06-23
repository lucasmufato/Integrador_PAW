<?php
include_once("../Controlers/DataBase_Controler.php");
include_once("../Model/Step.php");
include_once("../Model/StepPlate.php");


//esta clase se encarga de ABM de pasos y de ABM pasos-plaqueta, osea que pasos se realizan en q plaqueta
class StepsDao{
    protected $connection = null;

    public function __construct(){
    	$bd = new DataBase();
    	$this->connection = $bd->getConnection();
    }

    //recibe un objeto step, lo persiste en la BD y lo devuelve, si hay error devuelve []Strings
    public function NewStep($step){
        $query = $this->connection->prepare("INSERT INTO step(description, id_status)VALUES (?, ?);" );
        $query->bindParam(1, $step->description);
        $query->bindParam(2, $step->status);
        $query->execute();
        $step->id = $this->connection->lastInsertId();
        return $step;
    }

    //funcion que guarda la relacion estre un paso y una placa
    public function newStepPlate($stepPlate){
         $query = $this->connection->prepare("INSERT INTO step_plaque(id_plaque, id_step, ordina) VALUES (?, ?, ?);" );
        $query->bindParam(1, $stepPlate->idPlate);
        $query->bindParam(2, $stepPlate->idStep);
        $query->bindParam(3, $stepPlate->order);
        $query->execute();
    }

}