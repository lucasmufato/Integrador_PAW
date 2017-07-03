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
        $query = $this->connection->prepare("INSERT INTO step(description, id_status,amount,type)VALUES (?, ?, ?, ?);" );
        $query->bindParam(1, $step->description);
        $query->bindParam(2, $step->status);
        $query->bindParam(3, $step->amount);
        $query->bindParam(4, $step->type);
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
    
    //funcion que devuelve un arreglo con los steps de un plate
    public function getStepsFromPlate($plateId){
        $query = $this->connection->prepare("select s.id_step, s.description, s.id_status, sp.ordina, s.amount, s.type from step s inner join step_plaque sp on s.id_step = sp.id_step inner join plaque p on p.id_plaque = sp.id_plaque where p.id_plaque = :plateID ;" );
        $query->bindParam("plateID", $plateId);
        $query->execute();
        $resultado = $query->fetchAll();
        $rta=[];
        //por cada tupla
        foreach($resultado as $tupla){
            $id = $tupla["id_step"];
            $d = $tupla["description"];
            $s = $tupla["id_status"];
            $o = $tupla["ordina"];
            $a = $tupla["amount"];
            $t = $tupla["type"];
            //pongo la tupla en un arreglo
            $r = array("id" => $id, "descr" => $d, "status" => $s, "ordinal" => $o, "amount" => $a, "type" => $t, "wells" => null );
            //agrego el arreglo al arreglo de respuesta (INCEPTION!)
            $rta[] = $r;
        }
        return $rta;
    }

    //metodo que se debe usar una sola vez para crear los wells en la BD
    public function crearWells(){
        echo "creando... </br>";
        $letras = range('A','I');   //las letras son las filas
        $nros = range(1,12);        //los nros son las columnas
        foreach($letras as $letra){
            foreach($nros as $nro){
                $query = $this->connection->prepare("INSERT INTO well(fila, columna) VALUES (?, ?) ;" );
                $query->bindParam(1, $letra);
                $query->bindParam(2, $nro);
                $query->execute();
            }
        }
        echo "fin... </br>";
    }
    
    //funcion q devuelve el id del well dado la fila y columna
    public function getIdWell($wellRow,$wellCol){
        $query = $this->connection->prepare("SELECT * FROM WELL WHERE fila = :fila AND columna = :col ;" );
        $query->bindParam("fila", $wellRow);
        $query->bindParam("col", $wellCol);
        $query->execute();
        $rta = $query->fetch();
        //si explota devuelve false
        if($rta === false){
            return null;
        }
        
        return $rta["id_well"];
    }
     /*
    public function checkStepPlateWell($idPlate, $stepId, $wellId){
        $query = $this->connection->prepare("SELECT * FROM step_in_plaque_well WHERE id_plaque = :plate AND id_well = :well AND id_step = :step ;" );
        $query->bindParam("plate", $idPlate);
        $query->bindParam("well", $wellId);
        $query->bindParam("step", $stepId);
        $query->execute();
        $rta = $query->fetch(PDO::FETCH_ASSOC);
        if(! $rta){
            //no existe la relacion por q es un arreglo vacio
            return false;
        }
        return true;
    }
    */
    
    //metodo que crea la relacion entre
    public function saveStepPlateWell($idPlate,$stepId,$wellId,$amount){
        $query = $this->connection->prepare("INSERT INTO step_in_plaque_well(id_step, id_plaque, id_well, id_status, quantity)VALUES (?, ?, ?, ?, ?);" );
        $query->bindParam(1, $stepId);
        $query->bindParam(2, $idPlate);
        $query->bindParam(3, $wellId);
        $status = 4;//Status::sinIniciar;
        $query->bindParam(4, $status);
        $query->bindParam(5, $amount);
        $query->execute();
        return true;
    }
    
    public function removeStepPlateWell($idPlate,$stepId,$wellId){
        $query = $this->connection->prepare("DELETE FROM step_in_plaque_well WHERE ID_STEP = :step AND ID_PLAQUE = :plate AND ID_WELL = :well ;" );
        $query->bindParam("step", $stepId);
        $query->bindParam("plate", $idPlate);
        $query->bindParam("well", $wellId);
        $query->execute();
        return true;
    }
    
    
}//fin de la clase