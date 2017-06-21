desloguear = function(){
    var url = "../Controlers/Session_Controler.php";
    var data = { "action": "deslogear"};
    var funcion = function(data,status){
        if(status !== "success"){
            alert("No se pudo conectar con el servidor");
            return;
        }else{
            data = JSON.parse(data);
            console.log(data);
            window.location.href = "login.php";
        }
        
    };
    $.post(url,data,funcion);
}