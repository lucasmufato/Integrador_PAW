<?php  

include_once("../Dao/Test_Dao.php");
include_once("Session_Controler.php");

class TestControler{
    
    public function creatTest(){
        
        if( ! isset( $_POST["name"] ) ){
            $rta = Array("status" => "wrong", "errores" => "falta el nombre del test!");
            echo json_encode($rta);
            return;
        }
        
        $name = $_POST["name"];
        $desc = $_POST["description"];
        $idUser = $GLOBALS["sesion"]->getId();
        
        $dao = new TestDao();
        $id = $dao->createTest($name,$desc,$idUser);
        
        if( ! is_numeric($id) ){
            $rta = Array("status" => "wrong", "errores" => $id);
            echo json_encode($rta);
            return;
        }
        
        $dao->createPlateForTest($id);
        
        $rta = Array("status" => "ok", "id" => $id);
        echo json_encode($rta);
        return;
        
    }//fin funcion crearTest()
    
    //metodo que crea una relacion entre el paso y el well de un plate
    public function addStep($idPlate, $stepId, $wellRow, $wellCol, $amount){
        $dao = new StepsDao();
        $wellId = $dao->getIdWell($wellRow,$wellCol);
        $rta = $dao->saveStepPlateWell($idPlate,$stepId,$wellId,$amount);
        return $rta;
    }//fin funcion addStep()
    
    //funcion que remueve una tupla de la tabla step_in_plate_well
    public function removeStep($idPlate, $stepId, $wellRow, $wellCol){
        $dao = new StepsDao();
        $wellId = $dao->getIdWell($wellRow,$wellCol);
        $rta = $dao->removeStepPlateWell($idPlate,$stepId,$wellId);
        return $rta;
    }
    
}//fin de la clase

$sesion = new SessionControler();
if(! $sesion->checkSession() ){
    exit();
}

if( isset($_POST['do']) ){
    $accion = $_POST["do"];
    $tc = new TestControler();
    switch($accion){
        case "nuevoTest":
            $tc->creatTest();
            break;
    }
}


?>