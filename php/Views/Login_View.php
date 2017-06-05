<?php
    //esta clase se encarga de checkear la sesion, y redirigir en caso que este logeado.
    include_once("../Controlers/Session_Controler.php");
    $s = new SessionControler();
    if(  $s->checkSession() ){
        header('Location: '. "sesion_test_view.php");
    }
    //si sigue por aca es q no esta logueado
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta name="google-signin-client_id" content="YOUR_CLIENT_ID.apps.googleusercontent.com">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="../../css/login/login.css">
    <script src="../../js/jquery-3.2.1.min.js"></script>
    <script src="../../js/login.js"></script>
    <!-- script para logearse con G+ -->
    <script src="https://apis.google.com/js/platform.js" async defer></script>
</head>
<body>
    <section>
        <h1>Iniciar Sesión</h1>
        <form id="login" method="post" action="index.php">
            <label for="">Nombre de Usuario</label>
            <input type="text" min="3" max="50" required name="l_user">
            <label for="">Password</label>
            <input type="password" min="8" max="50" required name="l_pass">
            <label for="">Remember me</label>
            <input type="checkbox" checked="checked" id="rememberMe"> 
            <p class="boton verde" id="enter_button"> Ingresar </p>
        </form>
        
        <!--   BOTON DE GOOGLE    -->
        <div class="g-signin2" data-onsuccess="onSignIn"> </div>
        
        <h2>no tienes cuenta? hacete una!</h2>
        <form id="newResearcher">
            <label for="">Nombre</label>
            <input type="text" min="3" max="50" required name="name">
            <label for="">Apellido</label>
            <input type="text" min="3" max="50" required name="surname">
            <label for="">Fecha Nacimiento</label>
            <input type="date" min="1950-01-01" max="<?php echo date('Y-m-d'); ?>" required name="bday">
            <label for="">Email</label>
            <input type="email" min="5" max="70" required name="mail">
            <label for="">Nombre de Usuario</label>
            <input type="text" min="3" max="50" required name="username">
            <label for="">Password</label>
            <input type="password" min="8" max="50" required name="pass1">
            <label for="">Ingresa tu password otra vez</label>
            <input type="password" min="8" max="50" required name="pass2">
            <p class="boton verde" id="register_button"> Registrarse </p>
        </form>
    </section>
</body>
</html>
    