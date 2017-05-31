<?php

class DataBase{
    
    /*   esto podria sacarse de un archivo de configuracion   */
    private $user="lucria";
    private $password="mufina";
    private $DBname="Inmunologia";
    private $host="localhost";
    private $port=5432;
    
    public function __contruct(){
    
    }
    
    public function getConnection(){
         // se conecta a la BD y devuelve el objeto PDO
        $pdo = new PDO("pgsql:host=$this->host;dbname=$this->DBname", $this->user, $this->password) or die("no me pude conectar a la BD");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
    
}