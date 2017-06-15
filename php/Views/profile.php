<?php 

include_once ("../Controlers/Session_Controler.php");
include_once ("../Dao/Researcher_Dao.php");
require_once ("../../vendor/autoload.php");

$session = new SessionControler();
if(! $session->checkSession()){
    header('Location: '. "Login_View.php");
    exit();
}
$user = $session->getUserName();
$id = $session->getId();
$title = "Profile";

$dao = new ResearcherDao();
$researcher = $dao->getResearcherById($id);

$dir = "Templates/";
	$loader = new Twig_Loader_Filesystem($dir);
	$twig = new Twig_Environment($loader);
	echo $twig->render('profileTemplate.twig', compact('user','title','researcher'));
 ?>