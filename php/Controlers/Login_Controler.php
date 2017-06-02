<?php
include_once("../Dao/Researcher_Dao.php");
include_once("../Model/Researcher_Model.php");

class Login{
    
    public function __contruct(){
    }
    
    public function newResearcher(){
        $name = trim( $_POST["name"] );
        $surname = trim( $_POST["surname"] );
        $bday = trim( $_POST["bday"] );
        $mail = trim( $_POST["mail"] );
        $user = trim( $_POST["username"] );
        $pass1 = trim( $_POST["pass1"] );
        $pass2 = trim( $_POST["pass2"] );
        
        $errores = $this->validarFormNewResearcher($name,$surname,$bday,$mail,$user,$pass1,$pass2);
        
        if( count($errores)>0 ){
            $rta = array("status"=>"wrong", "errores"=>$errores);
            echo json_encode($rta);
        }else{
            #creamos el nuevo researcher en base a los datos ingresados y que sean las claves iguales
            $researcher = new Researcher($name, $surname, $user, $pass1, $mail, $bday);
            echo "r: " . $researcher->toString();
            #dao que controla la persistencia del modelo
            $dao = new ResearcherDao();
            
            $rta = $dao->newResearcher($researcher);
            $dao->close();
            if ($rta){
                echo "Se ha registrado un nuevo Investigador. Bienvenido!";
            } else {
                echo "Error..! Lo lamentamos, algo no salió bien :|";
            }
            $rta = array("status"=>"ok", "errores"=>$errores);
            echo json_encode($rta);

        }
        $dao->close();
        
    }
    
    public function checkUserPass(){
        $user = $_POST["l_user"];
        $pass = $_POST["l_pass"];
        $dao = new ResearcherDao();
        $rta = $dao->validateResearcher($user,$pass);
        $dao->close();
        $serverResponse;
        if($rta){
            $serverResponse =  array("status" => "ok");
        }else{
            $serverResponse = array("status" => "wrong");
        }
        echo json_encode($serverResponse);
    }
    
    private function validarFormNewResearcher($name,$surname,$bday,$mail,$user,$pass1,$pass2){
        $errores = [];

        if(strlen($name)<3 || strlen($name)>50){
            $errores[] = "el nombres es muy largo o corto" ;
        }
        if(strlen($name)<3 || strlen($name)>50){
            $errores[] = "el nombres es muy largo o corto" ;
        }
        
        $bday = date( "d/m/y", strtotime($bday) );
        $today = date("d/m/y");
        
        if($bday>$today){
            //$errores[] = "la fecha de nacimiento no puede ser mayor que hoy";
        }else{
            $minDate = date( "d/m/y", strtotime("01/01/1950") );
            if($bday<$minDate){
                //$errores[] = "no se aceptan viejos :O, solo ṕersonas mayores que 1950";
            }
        }
        
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "el mail no es correcto";
        }
        
        if(str_word_count($user)>1){
            $errores[] = "el nombre de usuario no puede tener espacios";
        }
        
        if($pass1 !== $pass2){
            $errores[] = "los passwords son distintos";
        }else{
            //if( str_word_count($pass1)>1 ){
            if( strpos($pass1, " ") !== false ){    //si no contiene espacios devuelve false
                $errores[] = "el password no puede tener espacios";
            }else{
                $uppercase = preg_match('@[A-Z]@', $pass1);
                $lowercase = preg_match('@[a-z]@', $pass1);
                $number    = preg_match('@[0-9]@', $pass1);

                if(!$uppercase || !$lowercase || !$number || strlen($pass1) < 8) {
                    $errores = "el password debe contener una minuscula, una mayuscula, un numero y 8 o mas caracteres";
                }
            }
        }
        return $errores;
    }
    
}  // FIN DE LA CLASE

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