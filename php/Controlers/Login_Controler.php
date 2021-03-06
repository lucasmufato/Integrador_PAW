<?php
include_once("../Dao/Researcher_Dao.php");
include_once("../Model/Researcher_Model.php");
include_once("Session_Controler.php");

class Login{
   
    public function __construct(){
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
            #dao que controla la persistencia del modelo
            $dao = new ResearcherDao();
            
            $desdeBD = $dao->newResearcher($researcher);
            
            $sesionControler = new SessionControler();
            $sesionControler->newSession($desdeBD);
            $sesionControler->setUserName($user);
            
            $dao->close();
            
            if( is_numeric( $desdeBD )){
                //$resultadoQuery = "Se ha registrado un nuevo Investigador. Bienvenido!";
                $status = "ok";
            } else {
                $status = "wrong";                
            }
            $rta = array("status"=>$status, "errores"=>$desdeBD);
            echo json_encode($rta);
        }
        
        
    }
    
    public function checkUserPass(){

        $user = trim( $_POST["l_user"] );
        $pass = trim( $_POST["l_pass"] );
        $errores=null;
        if($user == "" ){
            $errores[] = "Falta el nombre de usuario";
        }
        if($pass == ""){
            $errores[] = "Falta el password";
        }
        if($errores != null){
            echo json_encode( array("status"=>"wrong", "errores"=>$errores) );
            return;
        }
        $dao = new ResearcherDao();
        $rta = $dao->validateResearcher($user,$pass);
        $dao->close();
        $serverResponse;
        if( is_numeric($rta) ){
            $serverResponse =  array("status" => "ok");
            $sesionControler = new SessionControler();
            $sesionControler->newSession($rta);
            $sesionControler->setUserName($user);
        }else{
            $serverResponse = array("status" => "wrong","errores"=>"Usuario o password invalidos.");
        }
        echo json_encode($serverResponse);
    }
    
    private function validarFormNewResearcher($name,$surname,$bday,$mail,$user,$pass1,$pass2){
        $errores = [];

        if(strlen($name)< 3 || strlen($name)>50){
            $errores[] = "El nombres es muy largo o corto" ;
        }
        if(strlen($surname)< 3 || strlen($surname)>50){
            $errores[] = "El apellido es muy largo o corto" ;
        }
        if($bday == "" || $mail == "" || $user == "" || $pass1=="" || $pass2==""){
            $errores[] = "Faltan datos importantes" ;
        }
        
        if(count($errores)>0){
            return $errores;
        }
        $valuesDate;
        
        try{
            $valuesDate = explode('-', $bday);
            //$valuesDate = explode('/', $bday);
        }catch(Exceptio $e){
        }
                
        #verificamos que sea una fecha valida
        if(checkdate($valuesDate[1], $valuesDate[0], $valuesDate[2])){
            $today = date("d/m/y");
            echo "     " . $today;
            $valuesToday = explode('/', $today);
            if ($valuesDate[2] < 1950){
               $errores[] = "no se aceptan viejos :O, solo ṕersonas mayores que 1950";
            } else {
                $valuesToday[2] = $valuesToday[2] + 2000;
                if ($valuesDate[1] <= $valuesToday[1] && $valuesDate[0] <= $valuesToday[0] && $valuesDate[2] <= $valuesToday[2]){
                        $errores[] = "la fecha de nacimiento no puede ser mayor que hoy";
                   }
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