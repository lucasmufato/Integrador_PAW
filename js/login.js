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

function mostrarMensajeExito(){
    var body = document.getElementsByTagName("body")[0];
    var contenedor = document.createElement("div");
    contenedor.setAttribute("class", "msjExito");
    var p = document.createElement("p");
    var text = document.createTextNode("Se ha resistrado con éxito..!");
    p.appendChild(text);
    contenedor.appendChild(p);
    body.appendChild(contenedor);
}

registrarse = function(){
    var data = $("#newResearcher").serialize();
    data = data + "&do=newResearcher";
    console.log(data);
    console.log();
    /*como tomo el array que se envia?*/
    
    var funcion = function(status){
        if( status != "success"){
            mostrarMensajesErrores("Error, usuario o correo ya utilizados");  
            return;
        }else {
           if (status == "success") {
            mostrarMensajeExito();
           }
              
        
        }
        /*alert(data);*/
   };
    $.post(url,data,funcion);
};
