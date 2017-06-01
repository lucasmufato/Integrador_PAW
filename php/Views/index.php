<?php 

include 'Index_View.php'; #incluyo la vista que quiero mostrar

$templateIndex = new Index_View();
$templateIndex->userName = ['Victoria'];
$templateIndex->render('index.phtml');


 ?>