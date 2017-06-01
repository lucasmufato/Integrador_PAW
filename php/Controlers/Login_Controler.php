<?php
include_once("../Dao/Researcher_Dao.php");

class Login{
    
    public function __contruct(){
    }
    
    public function newResearcher(){
        
    }
    
    public function checkUserPass(){
        $user = $_POST["l_user"];
        $pass = $_POST["l_pass"];
        $dao = new ResearcherDao();
        $rta = $dao->validateResearcher($user,$pass);
        $dao->close();
        if($rta){
            echo "logeo exitoso";
        }else{
            echo "usuario o contraseña incorrectos";
        }
    }
    
}

$accion = $_POST["do"];
$login = new Login();
switch($accion){
    case "login":
        $login->checkUserPass();
        break;
}

?>