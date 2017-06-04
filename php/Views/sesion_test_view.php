<?php
    include_once("../Controlers/Session_Controler.php");
    $s = new SessionControler();
    if( ! $s->checkSession() ){
        header('Location: '. "Login_View.php");
    }
?>


<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../../js/jquery-3.2.1.min.js"></script>
    <script src="../../js/deslogeo.js"></script>
    <title>test</title>
</head>
<body>
    <section>
        <h1>Bienvenido: <?php echo $s->getId(); ?></h1>
        <button onclick="desloguear();">deslogearse</button>
    </section>
</body>
</html>