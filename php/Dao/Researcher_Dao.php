<?php
include_once("../Controlers/DataBase_Controler.php");
include_once("../Model/Researcher_Model.php");

class ResearcherDao{
	protected $connection = null;

    public function __construct(){
    	$bd = new DataBase();
    	$this->connection = $bd->getConnection();
    }

    #devuelve todos los investigadores de la base
    public function getResearchers(){
    
    }
    
    public function getResearcherById($id){
        //hecho rapido para ver si andaba el perfil
        $query = $this->connection->prepare(" SELECT * FROM researcher WHERE  id_researcher = :id" );
        $query->bindParam('id', $id);
        $query->execute();
        $r = $query->fetch();
        
        $name = $r["name"];
        $surname = $r["surname"];
        $email = $r["email"];
        $pass = $r["pass"];
        $username = $r["username"];
        $bday = $r["birthday"];
        $image = $r["image"];
        $researcher = new Researcher($name, $surname, $username, $pass, $email, $bday);
        
        return $researcher;    
    }
    
    public function validateResearcher($userName, $password){
        //EL METODO DEBE DEVOLVER EL ID DEL USUARIO o NULL
    	if (! is_null($this->connection)){
    		$query = $this->connection->prepare(" SELECT id_researcher FROM researcher WHERE username = :username and pass = :password" );
    		$query->bindParam('username', $userName);
    		$query->bindParam('password', $password);
    		if ($query->execute()) {
    			$showResult = $query->fetchColumn();
                if(is_numeric( $showResult ) ){
    				return $showResult;
    			} else {
    				return false;
    			}
            }
    	}
        return false;
    }
    
    #se encarga de persistir en la BD
    public function newResearcher($researcher){
        
        $name = $researcher->getName();
        $surname = $researcher->getSurname();
        $username = $researcher->getUser();
        $pass = $researcher->getPassword();
        $email = $researcher->getEmail();
        $birthday = $researcher->getBirthday();
        $query = $this->connection->prepare("INSERT INTO researcher (name, surname, email, pass, username, birthday) VALUES (:name, :surname, :email, :pass, :username, :birthday)");

        $query->bindParam(':name', $name);
        $query->bindParam(':surname', $surname);
        $query->bindParam(':email', $email);
        $query->bindParam(':pass', $pass);
        $query->bindParam(':username', $username);
        $query->bindParam(':birthday', $birthday);

        try{
            if ($query->execute()){
                return true;
            }
        } catch (Exception $e){
            $error = $query->errorInfo();
            
            if (strpos($error[2], 'username')) {
                return "El nombre de usuario ya esta en uso";
            } else{
                if (strpos($error[2], 'mail')){
                    return "El email ya se encuentra en uso";
                }
            }
            return $error[2];
        }
         

        #hacer una devolucion de porque no se pudo almacenar en la base de datos
        #ver como capturar los constrains de a base de datos. 
        
    }

    #encargada de dar cierre de la correccion
    public function close(){
    	$this->connection = null;
    }
}