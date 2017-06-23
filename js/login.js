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
        data = JSON.parse(data);
        console.log(data);
        switch (data.status){
            case "ok":
                window.location.href = "index.php";
                break;
            case "wrong":
                mostrarMensajesErrores("errorLogeo",data.errores);
                break;
            default:
                alert("error al parsear respuesta");
                break;
        }
        
    };
    $.post(url,data,funcion);
};

function mostrarMensajesErrores(elemento, errores){
    var contenedorErrores =  document.getElementById( elemento );
    console.log(contenedorErrores);
    contenedorErrores.innerHTML="";
    var i=0;
    var p = document.createElement("p");
    p.innerHTML = errores;
    contenedorErrores.appendChild(p);
    /*
    console.log(errores + typeof(errores));
    for (i; i<errores.lenght ;i++){
        console.log("entro al for");
        var p = document.createElement("p");
        var text = document.createTextNode(errores[i]);
        p.appendChild(text);
        contenedorErrores.appendChild(p);
    }
    */
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
    
    var funcion = function(data,status){
        if( status != "success"){
            alert("fallo la conexion con el servidor!");
            return;
        }
        data = JSON.parse(data);
        if (status == "success") {
            switch(data.status){
                case "ok":
                    alert(data);
                    window.location.href = "index.php";
                    break;
                case "wrong":
                    mostrarMensajesErrores("errorRegistro",data.errores);
                    break;
                default:
                    alert("mensaje del servidor no entendido");
                    break;
            }
        }
    };
    $.post(url,data,funcion);
};
