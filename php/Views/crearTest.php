<?php 

include_once ("../Controlers/Session_Controler.php");
include_once ("../Controlers/CreateTest_Controler.php");
require_once ("../../vendor/autoload.php");

$session = new SessionControler();
if(! $session->checkSession()){
    header('Location: '. "Login_View.php");
    echo "sefse";
    exit();
}

//si no me pidieron el ID lo redirijo al index
if( ! isset( $_GET["id"] )){
    header('Location: '. "index.php");
    echo "sefededededse";
    exit();
}

$idTest = $_GET["id"];
$controlador = new CreateTestControler();
$test = $controlador->getTestById($idTest);


$user = $session->getUserName();
$title = "Creando Test ";
$dir = "Templates/";
	$loader = new Twig_Loader_Filesystem($dir);
	$twig = new Twig_Environment($loader);
	echo $twig->render('createTemplate.twig', compact('user','title','test'));

 ?>