<?php

include_once("../Model/Step.php");
include_once("../Model/StepPlate.php");
include_once("../Dao/Steps_Dao.php");
include_once("../Dao/Test_Dao.php");
include_once("Test_Controler.php");

//para seguridad habria que chequear que el usuario que pide el ajax ser el dueño del test correspondiente

if(! isset($_POST["action"]) &&  ! isset($_GET["action"])){
    // si no tiene el campo action devuelve error
    echo json_encode( array("status"=>"wrong","errores"=>"falta la action") );
    exit();
}

//arreglo de errores, se envia al final del archivo si contiene algo
$errores=[];

//separo las funcionalidad por GET o POST, GET para pedir info, POST para guardar info
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    switch($_POST["action"]){
        //crea un nuevo paso
        case "newStep":
            newStep();
            break;
        case "wellForStep":
            wellForStep();
            break;
        case "startTest":
            startTest();
            break;
        case "endTest":
            endTest();
            break;
        default:
            echo json_encode( array("status"=>"wrong","errores"=>"la accion deseada no se encontro") );
            break;
    }    
}
if($_SERVER["REQUEST_METHOD"] == "GET"){
    switch($_GET["action"]){
        //devuelve los steps asociados a un plate
        case "getStepPlate":
            getStepPlate();
            break;
            
        default:
            echo json_encode( array("status"=>"wrong","errores"=>"la accion deseada no se encontro") );
            break;
    }
}

//ultimo paso, si hay errores los envia
if( count($errores)>0 ){
    $rta = array("status"=>"wrong","errores"=>$GLOBALS["errores"]);
    echo json_encode( $rta );
}

//  DE ACA PARA ABAJO SON TODOS METODOS PARA LOS GET O POST

function newStep(){
    //primero hago los chequeos
    if(! isset($_POST["idTest"]) || $_POST["idTest"]=="" ){
        $GLOBALS["errores"][]="Falta el id del Test";
    }
    if(! isset($_POST["description"]) || $_POST["description"]=="" ){
        $GLOBALS["errores"][]="Falta la descripcion del paso";
    }
    if(! isset($_POST["type"]) || $_POST["type"]=="" ){
        $GLOBALS["errores"][]="Falta el tipo de paso";
    }
     if(! isset($_POST["order"]) || $_POST["order"]=="" ){
        $GLOBALS["errores"][]="Falta el order de paso";
    }
    //si hay errores salgo
    if( count( $GLOBALS["errores"] ) >0 ){
        return;
    }
    $testId = $_POST["idTest"];
    $step = new Step();
    $step->id=null;
    $step->description = $_POST["description"];
    $step->type = $_POST["type"];
    $step->status = 4;  //HARDCODEADO
    $stepPlate = new StepPlate();
    $daoTest = new TestDao();
    $stepPlate->idPlate = $daoTest->getPlatesFromTestId($testId);
    $stepPlate->idStep =0;
    $stepPlate->order = $_POST["order"];
    $stepPlate->status = 4;     //hardcodeado
    $daoSteps = new StepsDao();
    $step = $daoSteps->NewStep($step);   //me devuelve el mismo step pero con el id con el q lo inserto a la BD
    $stepPlate->idStep = $step->id;
    $daoSteps->newStepPlate($stepPlate);
    //respuesta asi nomas
    $rta = array("status"=>"ok", "stepId"=> $stepPlate->idStep);
    echo json_encode( $rta );
}

function getStepPlate(){
    if(! isset($_GET["idPlate"]) || $_GET["idPlate"]=="" ){
        $GLOBALS["errores"][]="Falta el id del Plate";
        return;
    }
    $dao = new StepsDao();
    $steps = $dao->getStepsFromPlate($_GET["idPlate"]);
    $rta = array("status"=>"ok", "steps"=>$steps);
    echo json_encode($rta);
}

//funcion que se encarga de guarda que en un well se realiza un paso
function wellForStep(){
 
    if(! isset($_POST["idPlate"]) || $_POST["idPlate"]=="" ){
        $GLOBALS["errores"][]="Falta el id del Test";
    }
    if(! isset($_POST["stepID"]) || $_POST["stepID"]=="" ){
        $GLOBALS["errores"][]="Falta el paso";
    }
    if(! isset($_POST["wellRow"]) || $_POST["wellRow"]=="" ){
        $GLOBALS["errores"][]="Falta la fila del well";
    }
    if(! isset($_POST["wellCol"]) || $_POST["wellCol"]=="" ){
        $GLOBALS["errores"][]="Falta la columna del well";
    }
    if(! isset($_POST["event"]) || $_POST["event"]=="" ){
        $GLOBALS["errores"][]="Falta el evento";
    }
    $amount=null;
    if (isset($_POST["amount"])){
        $amount = $_POST["amount"];
    }
    //si hay errores salgo
    if( count( $GLOBALS["errores"] ) >0 ){
        return;
    }
    $tc = new TestControler();
    $evento = $_POST["event"];
    switch($evento){
        case "add":
            $rta = $tc->addStep($_POST["idPlate"], $_POST["stepID"], $_POST["wellRow"], $_POST["wellCol"], $amount);
            if($rta){
                $rta = array("status"=>"ok");
                echo json_encode($rta);
                return;
            }
            $GLOBALS["errores"][]=$rta;
            break;
        case "remove":
            $rta = $tc->removeStep($_POST["idPlate"], $_POST["stepID"], $_POST["wellRow"], $_POST["wellCol"]);
            if($rta){
                $rta = array("status"=>"ok");
                echo json_encode($rta);
                return;
            }
            $GLOBALS["errores"][]=$rta;
            break;
        default:
            $GLOBALS["errores"][]="no existe el evento: $evento";
            break;
    }
   
}//fin del metodo wellForStep

//metodo que recibe el id de un test en "creando" y lo pasa a "en trabajo"
function startTest(){
    //TODO crear metodos
    $testControler = new TestControler();
    //$testControler->startTest();
    $rta = array("status"=>"ok");
    echo json_encode($rta);
}

//metodo que recibe id de un test "en trabajo " y lo pasa a "finalizado".
function endTest(){
    $testControler = new TestControler();
    //$testControler->endTest();
    $rta = array("status"=>"ok");
    echo json_encode($rta);
}