<?php
include_once("../Dao/Researcher_Dao.php");

class Login{
    
    public function __contruct(){
    }
    
    public function newResearcher(){
        $name = $surname = $bday = $mail = $use = $pass1 = $pass2 = null;
        $errores = [];
        if( isset( $_POST["name"] ) ){
            $name = trim( $_POST["name"] );
        }
        if( isset( $_POST["surname"] ) ){
            $surname = trim( $_POST["surname"] );
        }
        if( isset( $_POST["bday"] ) ){
            $bday = trim( $_POST["bday"] );
        }
        if( isset( $_POST["mail"] ) ){
            $mail = trim( $_POST["mail"] );
        }
        if( isset( $_POST["username"] ) ){
            $user = trim( $_POST["username"] );
        }
        if( isset( $_POST["pass1"] ) ){
            $pass1 = trim( $_POST["pass1"] );
        }
        if( isset( $_POST["pass2"] ) ){
            $pass2 = trim( $_POST["pass2"] );
        }
        
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

if(! isset($_POST['do']) ){
    exit();
}
$accion = $_POST["do"];
$login = new Login();
switch($accion){
    case "login":
        $login->checkUserPass();
        break;
    case "newResearcher":
        $login->newResearcher();
        break;
}

?>