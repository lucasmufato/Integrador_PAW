<?php

class Status{
    
    protected $id;
    protected $name;
    
    public static $sinIniciar = 4;
    public static $iniciado = 3;
    public static $enProceso = 2;
    public static $finalizado = 1;
    
    public function __construct(){
    }
}