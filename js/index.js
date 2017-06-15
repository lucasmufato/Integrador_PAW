var url = "../Controlers/CreateTest_Controler.php";

$(document).ready(function(){    
    $("#create_button").click(function(){
       nuevoTest();
    });
    
});

nuevoTest = function(){
    var nombre = $("#name").val();
    var desc = $("#desc").val();
    
    if(nombre === ""){
        $("#errores").text("el nombre no puede estar vacio");
        return;
    }
    if(nombre.length>100){
        $("#errores").text("el nombre debe tener menos de 100 caracteres");
        return;
    }
    
    var data = {
        "name" : nombre,
        "description" : desc,
        "do" : "nuevoTest"
    }
    
    var funcion = function(data,status){
        if(status !== "success"){
            alert("No se pudo conectar con el servidor");
            return;
        }
        console.log(data);
        data = JSON.parse(data);
        switch (data.status){
            case "ok":
                window.location.href = "crearTest.php?id="+data.id;
                break;
            case "wrong":
                $("#errores") = data.errores;
                break;
            default:
                alert("error al parsear respuesta");
                break;
        }
        
    };
    $.post(url,data,funcion);
    
}