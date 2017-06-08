<?php  

include_once("../Dao/CreateTest_Dao.php");

class CreateTestControler{
    
    public function creatTest(){
        
        if( ! isset( $_POST["name"] ) ){
            $rta = Array("status" => "wrong", "errores" => "falta el nombre del test!");
            echo json_encode($rta);
            return;
        }
        
        $name = $_POST["name"];
        $desc = $_POST["description"];
        
        $dao = new CreateTestDao();
        $id = $dao->createTest($name,$desc);
        
        if( ! is_numeric($id) ){
            $rta = Array("status" => "wrong", "errores" => $id);
            echo json_encode($rta);
            return;
        }
        
        $rta = Array("status" => "ok", "id" => $id);
        echo json_encode($rta);
        return;
        
    }
    
    public function getTestById($id){
        return "a";
    }
    
}//fin de la clase

if( isset($_POST['do']) ){
    $accion = $_POST["do"];
    $ctc = new CreateTestControler();
    switch($accion){
        case "nuevoTest":
            $ctc->creatTest();
            break;
    }
}


?>