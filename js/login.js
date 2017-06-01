var url = "../Controlers/Login_Controler.php";

$(document).ready(function(){
    $("#enter_button").click(function(){
       ingresar(); 
    });
    
    $("#register_button").click(function(){
       registrarse();
    });
    
});

ingresar = function(){
    
    var data = $("#login").serialize();
    data = data + "&do=login";
    var funcion = function(data,status){
        if(status !== "success"){
            alert("No se pudo conectar con el servidor");
            return;
        }
        alert(data);
    };
    $.post(url,data,funcion);
};

registrarse = function(){
    console.log("apretaste el boton");
    var data = $("#newResearcher").serialize();
    data = data + "&do=newResearcher";
    var funcion = function(data,status){
        if(status !== "success"){
            alert("No se pudo conectar con el servidor");
            return;
        }
        alert(data);
    };
    $.post(url,data,funcion);
};
