<?php 

include_once ("../Controlers/Session_Controler.php");
include_once ("../Dao/Test_Dao.php");
require_once ("../../vendor/autoload.php");

$session = new SessionControler();
if(! $session->checkSession()){
    header('Location: '. "login.php");
    exit();
}

//si no me pidieron el ID lo redirijo al index
if( ! isset( $_GET["id"] )){
    header('Location: '. "index.php");
    exit();
}

$idTest = $_GET["id"];
$dao = new TestDao();
$test = $dao->getTestById($idTest);

//para la plaqueta
$letras = array("A","B","C","D","E","F","G","H","I");
$nros = array(1,2,3,4,5,6,7,8,9,10,11,12);

$user = $session->getUserName();
$title = "Creando Test ";
$dir = "Templates/";
	$loader = new Twig_Loader_Filesystem($dir);
	$twig = new Twig_Environment($loader);
	echo $twig->render('testTemplate.twig', compact('user','title','test','letras','nros'));

 ?>