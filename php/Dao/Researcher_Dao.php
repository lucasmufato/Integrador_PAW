<?php

class ResearcherDao{
	$connection = null;

    public function __contruct(){
    	$this->connetion = new DataBase_Controler();
    	$this->connetion = $this->getConnection();
    }

    #devuelve todos los investigadores de la base
    public function getResearchers(){
    
    }
    
    public function validateResearcher($usarName, $password){
    	if (! is_null($connetion)){
    		$query = $connection->prepare(" SELECT COUNT(username) FROM researcher WHERE username = :username and pass = :password" );
    		$query->bindParam('username', $userName);
    		$query->bindParam('password', $password);
    		if ($query) {
    			$showResult = $query->fetch(PDO::FECTH_ASSOC);
    			if($showResult == 1){
    				return true;
    			} else {
    				return false;
    			}
    		}
    	}
    }
    
    #se encarga de persistir en la BD
    public function newResearcher($researcher){
    	if(! is_null($conexion)){
 
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
    	}
    
    }

    public function close(){
    	$this->connection = null;
    }
}