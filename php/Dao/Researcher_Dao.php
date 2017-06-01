<?php
include_once("../Controlers/DataBase_Controler.php");

class ResearcherDao{
	protected $connection = null;

    public function __construct(){
        // por alguna razon no 
    	$bd = new DataBase();
    	$this->connection = $bd->getConnection();
    }

    #devuelve todos los investigadores de la base
    public function getResearchers(){
    
    }
    
    public function validateResearcher($userName, $password){
    	if (! is_null($this->connection)){
    		$query = $this->connection->prepare(" SELECT COUNT(username) as c FROM researcher WHERE username = :username and pass = :password" );
    		$query->bindParam('username', $userName);
    		$query->bindParam('password', $password);
    		if ($query->execute()) {
    			$showResult = $query->fetch(PDO::FETCH_ASSOC);
    			if($showResult["c"] == 1){
    				return true;
    			} else {
    				return false;
    			}
    		}
    	}
    }
    
    #se encarga de persistir en la BD
    public function newResearcher($researcher){
    	if(! is_null($this->connection)){
 
    		$name = $researcher->getName();
    		$surname = $researcher->getSurname();
    		$username = $researcher->getUserName();
    		$pass = $researcher->getPassword();
    		$email = $researcher->getEmail();
    		$birthday = $researcher->getBirthday();

    		$query = $connection->prepare("INSERT INTO researcher (name, surname, email, pass, username, birthday) VALUES (:name, :surname, :email, :pass, :username, :birthday)");
    		
    		$query->bindParam(':name', $name);
    		$query->bindParam(':surname', $surname);
    		$query->bindParam(':email', $email);
    		$query->bindParam(':pass', $pass);
    		$query->bindParam(':username', $username);
    		$query->bindParam(':birthday', $birthday);

    		return $query->execute();
    		#hacer una devolucion de porque no se pudo almacenar en la base de datos
    		#ver como capturar los constrains de a base de datos. rodear 
    	}
    
    }

    #encargada de dar cierre de la correccion
    public function close(){
    	$this->connection = null;
    }
}