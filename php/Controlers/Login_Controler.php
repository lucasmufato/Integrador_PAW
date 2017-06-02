<?php
include_once("../Dao/Researcher_Dao.php");
include_once("../Model/Researcher_Model.php");

class Login{
    
    public function __contruct(){
    }
    
    public function newResearcher(){
        $name = $surname = $bday = $mail = $user = $pass1 = $pass2 = null;
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
    
       
        if ($pass1 == $pass2){
            #creamos el nuevo researcher en base a los datos ingresados y que sean las claves iguales
            $researcher = new Researcher($name, $surname, $user, $pass1, $mail, $bday);

            #dao que controla la persistencia del modelo
            $dao = new ResearcherDao();
            
            $rta = $dao->newResearcher($this->researcher);

            if ($rta){
                echo "Se ha registrado un nuevo Investigador. Bienvenido!";
            } else {
                echo "Error..! Lo lamentamos, algo no salió bien :|";
            }
        } else {
            echo "Error..! las claves no coinciden :|";
        }
        $dao->close();
        
    }
    
    public function checkUserPass(){
        $user = $_POST["l_user"];
        $pass = $_POST["l_pass"];
        $dao = new ResearcherDao();
        $rta = $dao->validateResearcher($user,$pass);
        $dao->close();
        echo $rta;
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