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
        console.log(data);
        data = JSON.parse(data);
        switch (data.status){
            case "ok":
                window.location.href = "index.php";
                break;
            case "wrong":
            /*crear una funcion que analice los errores*/
               
                alert("usuario o contraseña incorrectas");
                break;
            default:
                alert("error al parsear respuesta");
                break;
        }
        
    };
    $.post(url,data,funcion);
};

function mostrarMensajesErrores(error){
    var body = document.getElementsByTagName("body")[0];
    var contenedorErrores =  document.createElement("div");
    contenedorErrores.setAttribute("class", "msjErrores");
    var p = document.createElement("p");
    var text = document.createTextNode(error);
    p.appendChild(text);
    contenedorErrores.appendChild(p);
    body.appendChild(contenedorErrores);

} 

registrarse = function(){
    var data = $("#newResearcher").serialize();
    data = data + "&do=newResearcher";
    var funcion = function(data,status){
        if(status !== "success"){
            alert("No se pudo conectar con el servidor");
            return;
        }else {
             mostrarMensajesErrores(data.errores);
        }
        /*alert(data);*/
    };
    $.post(url,data,funcion);
};
