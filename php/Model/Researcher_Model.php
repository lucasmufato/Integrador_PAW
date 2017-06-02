<?php

class Researcher{
    
    protected $name;
    protected $surname;
    protected $user;
    protected $password;
    protected $email;
    protected $birthday;
    protected $image;
    
    public function __construct($name, $surname, $user, $password, $email, $birthday){
    	$this->name = $name;
    	$this->surname = $surname;
    	$this->user = $user;
    	$this->password = $password;
    	$this->email = $email;
    	$this->birthday = $birthday;
    }

    public function getName(){
    	return $this->name;
    }

    public function getSurname(){
    	return $this->surname;
    }

    public function getUser(){
    	return $this->user;
    }
    
    public function getPassword(){
    	return $this->password;
    }

    public function getEmail(){
    	return $this->email;
    }

    public function getBirthday(){
    	return $this->birthday;
    }

    public function setPasswors($newPassword){
    	$this->password = $newPassword;
    }
    
    public function toString(){
        return $this->name . $this->surname .  $this->user .$this->password . $this->email . $this->birthday;
    }
}
?>