<?php

include_once("../Model/Step.php");
include_once("../Model/StepPlate.php");
include_once("../Dao/Steps_Dao");

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
        default:
            echo json_encode( array("status"=>"wrong","errores"=>"la accion deseada no se encontro") );
            break;
    }    
}
if($_SERVER["REQUEST_METHOD"] == "GET"){
         
}

//ultimo paso, si hay errores los envia
if(count($errores)>0){
    echo json_encode( array("status"=>"wrong","errores"=>$errores) );
}

//  DE ACA PARA ABAJO SON TODOS METODOS PARA LOS GET O POST

function newStep(){
    //primero hago los chequeos
    if(! isset($_POST["decription"]) || $_POST["decription"]=="" ){
        $errores[]="Falta la descripcion del paso";
    }
    if(! isset($_POST["type"]) || $_POST["type"]=="" ){
        $errores[]="Falta el tipo de paso";
    }
     if(! isset($_POST["order"]) || $_POST["order"]=="" ){
        $errores[]="Falta el order de paso";
    }
    //si hay errores salgo
    if( count($errores)>0 ){
        return;
    }
    $step = new Step();
    $step->id=null;
    $step->description = $_POST["description"];
    $step->type = $_POST["type"];
    $stepPlate = new StepPlate();
    $stepPlate->idPlate = 1;    //hardcodeado
    $stepPlate->idStep =0;
    $stepPlate->order = $_POST["order"];
    $stepPlate->status = 4;     //hardcodeado
    
}