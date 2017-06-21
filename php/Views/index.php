<?php 

include_once ("../Controlers/Session_Controler.php");
include_once ("../Dao/Test_Dao.php");
require_once ("../../vendor/autoload.php");

$session = new SessionControler();
if(! $session->checkSession()){
    header('Location: '. "login.php");
    exit();
}

//cargo informacion del usuario y del template base
$user = $session->getUserName();
$id = $session->getId();
$title = "index";
$dir = "Templates/";

//cargo los test de este usuario
$dao = new TestDao();
$tests = $dao->getTestsByResearcherId($id);

$loader = new Twig_Loader_Filesystem($dir);
$twig = new Twig_Environment($loader);
echo $twig->render('indexTemplate.twig', compact('user','title','tests'));
 ?>