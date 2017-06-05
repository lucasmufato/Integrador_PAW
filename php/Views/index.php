<?php 

require_once('./vedor/autoloarder.php');



$user = $_POST['l_user'];
$password = $_POST['l_pass'];

$dao = new Researcher_Dao();
if ($dao->validateResearcher($user, $password)) {
	echo "Error, no existen investigadores con ese nombre";
} else {
	$dir = './Templates/indexTemplate.twig'; 
	$loader = new Twig_Loader_Filesystem($dir);
	$twig = new Twig_Environment($loader);
}

 ?>