<?php

class DataBase{
    
    /*   esto podria sacarse de un archivo de configuracion   */
    private $user="";
    private $password="";
    private $DBname="";
    private $host="";
    private $port=5432;
    
    public function __contruct(){
    
    }
    
    public function getConnection(){
         // se conecta a la BD y devuelve el objeto PDO
    }
    
}