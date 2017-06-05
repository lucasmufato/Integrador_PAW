<?php

class SessionControler{

    public function __construct(){
    }

    public function checkSession(){
        session_start();
        return isset( $_SESSION["id"] );
    }
    
    public function newSession($id){
        session_start();
        $_SESSION["id"]=$id;
    }
    
    public function deleteSession(){
        session_start();
        session_unset(); 
        session_destroy(); 
    }

    public function getUserName(){

        session_start();
        return $_SESSION["userName"];
    	
    }

    public function setUserName($userName){
        $_SESSION["userName"] = $userName;
    }
    
    public function getId(){
        return $_SESSION["id"];
    }
}//FIN DE LA CLASE

if( isset($_POST["action"]) ){
    if($_POST["action"] === "deslogear"){
        $se = new SessionControler();
        $se->deleteSession();
        $rta= array("status"=>"ok");
        echo json_encode($rta);
    }
}