<?php
    //esta clase se encarga de checkear la sesion, y redirigir en caso que este logeado.
    include_once("../Controlers/Session_Controler.php");
    //si sigue por aca es q no esta logueado
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="google-signin-client_id" content="YOUR_CLIENT_ID.apps.googleusercontent.com">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="../../css/login/login.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="../../js/login.js"></script>
    <!-- script para logearse con G+ -->
    <script src="https://apis.google.com/js/platform.js" async defer></script>
</head>
<body>
    <section>
        <h1>Inicia sesion!</h1>
        <form id="login">
            <label for="">Nombre de Usuario</label>
            <input type="text" min="3" max="50" required="true" id="login_username" name="l_user">
            <label for="">Password</label>
            <input type="password" min="8" max="50" required="true" id="login_password" name="l_pass">
            <label for="">Remember me</label>
            <input type="checkbox" checked="checked" id="rememberMe"> 
            <p class="boton verde" id="enter_button"> Ingresar </p>
        </form>
        
        <!--   BOTON DE GOOGLE    -->
        <div class="g-signin2" data-onsuccess="onSignIn"> </div>
        
        <h2>no tienes cuenta? hacete una!</h2>
        <form action="" id="newResearcher">
            <label for="">Nombre</label>
            <input type="text" min="3" max="50" required="true">
            <label for="">Apellido</label>
            <input type="text" min="3" max="50" required="true">
            <label for="">Fecha Nacimiento</label>
            <input type="date" min="1950-01-01" max="2015-01-01" required="true">
            <label for="">Email</label>
            <input type="email" min="5" max="70" required="true">
            <label for="">Nombre de Usuario</label>
            <input type="text" min="3" max="50" required="true">
            <label for="">Password</label>
            <input type="password" min="8" max="50" required="true">
            <label for="">Ingresa tu password otra vez</label>
            <input type="password" min="8" max="50" required="true">
            <p class="boton verde" id="register_button"> Registrarse </p>
        </form>
    </section>
</body>
</html>
    