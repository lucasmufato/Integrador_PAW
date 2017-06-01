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
        if(status === "success"){
            alert(data);
            //window.location("index_view.php");
        }else{
            alert("logeo incorrecto");
        }
    };
    $.post(url,data,funcion);
};

registrarse = function(){
    
};
