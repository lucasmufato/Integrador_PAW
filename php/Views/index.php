<?php 

include_once ("../Controlers/Session_Controler.php");
require_once ("/var/www/html/Integrador_PAW/vendor/autoload.php");

$session = new SessionControler();
$user = $session->getUserName();	 
$dir = "Templates/";
	$loader = new Twig_Loader_Filesystem($dir);
	$twig = new Twig_Environment($loader);
	echo $twig->render('indexTemplate.twig', compact('user'));
 ?>