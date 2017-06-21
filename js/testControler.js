//variables globales
var controlador;

$(document).ready(function(){
    //instancio el controlador
    controlador = new TestControler();    
    controlador.crearTest();
    
});

TestControler = function(){
    this.url = "../php/Controlers/Test_Ajax_receiver.php";
    this.ultimoPaso = 1;
    this.test;
    
    //funcion que obtiene los datos del test del DOM y crea el objeto test
    this.crearTest = function(){
        this.test = new Test();
        this.test.name= $("#testName").text().replace("Nombre: ","");
        this.test.result = $("#testResult").text().replace("Resultado: ","").replace("Estado: ","");
        this.test.id = $("#testId").text();
    }
    
    this.prepare = function(){
        //en base al estado del test son las cosas que se pueden hacer
        switch(this.test.result){
            //crear pasos, ordenarlos y asignarles wells
            case "creando":
                this.prepareCreacion();
                break;
            //indicar por q paso voy y permitir completar los pasos en los wells
            case "en trabajo":
                break;
            //para todos los demas casos, solo se permite visualizar los datos
            default:

                break;
        }
    }//fin prepare
    
    //funcion que agrega al DOM
    this.prepareCreacion = function(){
        
    }
    
    this.newStep = function(){
        //obtengo los valores de los inputs para validarlos y despues crear la entrada en la tabla
        //si se guarda bien en la BD
        var divErrores = $("#stepsNewError").text("");  //limpio el contenedor de erorres
        
        var paso = new Step();
        paso.description = $("#stepsNewDescr").val().trim();
        paso.type = $('input[name=stepsNewType]:checked', '#stepsForm').val();
        paso.order = this.ultimoPaso;
        this.ultimoPaso++;
        
        if(paso.description == null || paso.description == "" ){
            divErrores.text("<p> falta la descripcion del paso </p>");
            return; 
        }
        
        //enviar a por ajax
        //estoy iria dentro de la funcion de si salio bien el ajax
        var select = '<td><input type="radio" name="selected" value="'+paso.id+'" onclick="controlador.selected()"></td>';
        var id= '<td style="display: none"> '+paso.id+' </td>';
        var desc = '<td> '+paso.description+' </td>';
        var type = '<td> '+paso.type+' </td>';
        var order = '<td><input type="number" value="'+paso.order+'" onchange="controlador.changeorder()></td>';
        var x = '<td> <button onclick="controlador.delete()" >x</button></td>'
        $('#stepsTable tr:last').after("<tr>"+select+id+desc+type+order+x+"</tr>");
        
    }
    
}//fin de la clase TestControler