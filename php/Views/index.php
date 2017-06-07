<?php 

include_once ("../Controlers/Session_Controler.php");
require_once ("../../vendor/autoload.php");

$session = new SessionControler();
if(! $session->checkSession()){
    header('Location: '. "Login_View.php");
    exit();
}
$user = $session->getUserName();
$id = $session->getId();
$title = "index";
$dir = "Templates/";
	$loader = new Twig_Loader_Filesystem($dir);
	$twig = new Twig_Environment($loader);
	echo $twig->render('indexTemplate.twig', compact('user','title'));
 ?>