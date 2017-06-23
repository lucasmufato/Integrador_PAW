<?php
include_once("Result.php");

class Test{
    
    public $id;
    public $name;
    public $date;
    public $researcher;
    public $description;
    public $result;
    public $resultDescription;
    public $plates;
    
    public function __construct(){
    }
    
    //metodo que devuelve el resultado del test como un string para presentar al usuario
    public function resultAsString(){
        return Result::getEstadoByNro($this->result);
    }
    
}