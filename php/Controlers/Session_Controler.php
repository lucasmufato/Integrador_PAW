<?php

class SessionControler{

    public function __construct(){
        session_start();
    }

    public function checkSession(){
        return isset( $_SESSION["id"] );
    }
    
    public function newSession($id){
        $_SESSION["id"]=$id;
    }
    
    public function deleteSession(){
        session_unset(); 
        session_destroy(); 
    }

    public function getUserName(){
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