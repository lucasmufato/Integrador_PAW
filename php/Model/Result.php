<?php

class Result{
    
    protected $id;
    protected $tipo;
    
    public static $creando = 1 ;
    public static $noIniciado = 2 ;
    public static $enTrabajo = 3 ;
    public static $exitoso = 4 ;
    public static $fallido = 5 ;
    public static $descartado = 6 ;
    
    public function __construct(){
    }
    
    //recibe el estado como un string y devuelve el nro de id q le corresponde
    public static function getNroByEstado($nro){
        $estados = array("creando" => 1,"noIniciado" => 2,"enTrabajo" => 3,"exitoso" => 4,"fallido" => 5,"descartado" => 6 );
        return $estados[$nro];
    }
    
    //recibe un nro y devuelve el nombre del estado en string
    // ej: recibe 1 y devuelve "creando"
    public static function getEstadoByNro($nro){
         $estados = array(1 => "creando",2 => "noIniciado",3 => "enTrabajo",4 => "exitoso", 5 => "fallido", 6 => "descartado" );
        return $estados[$nro];
    }
    
}