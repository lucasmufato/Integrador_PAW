//variables globales
var controlador;

$(document).ready(function(){
    //instancio el controlador
    controlador = new TestControler();    
    controlador.obtenerTest();
    controlador.prepare();
});

TestControler = function(){
    this.url = "../Controlers/Test_Ajax_receiver.php";
    this.ultimoPaso = 1;
    this.test;
    this.steps=[];
    
    //funcion que obtiene los datos del test del DOM y crea el objeto test
    this.obtenerTest = function(){
        this.test = new Test();
        this.test.name= $("#testName").text().replace("Nombre: ","");
        this.test.result = $("#testResult").text().replace("Resultado: ","").replace("Estado: ","");
        this.test.id = $("#testId").text();
        this.test.plates = $("#testsPlatesId").text();
    }
    
    this.prepare = function(){
        this.cargarPasosAjax();
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
        if(paso.type == "well"){
            paso.type = 0;
        }else{
            paso.type = 1;
        }
        paso.amount = $("#stepsNewAmount").val().trim();
        paso.order = this.ultimoPaso;
        this.ultimoPaso++;
        
        if(paso.description == null || paso.description == "" ){
            divErrores.text("<p> falta la descripcion del paso </p>");
            return; 
        }
        
        //enviar a por ajax
        //estoy iria dentro de la funcion de si salio bien el ajax
        var data = {
            action : "newStep",
            idTest : this.test.id,
            description : paso.description,
            type : paso.type,
            order : paso.order,
            amount : paso.amount
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
                    paso.id=data.idPaso;
                    controlador.showNewStep(paso);
                    break;
                case "wrong":
                    $("#stepsNewError") = data.errores;
                    break;
                default:
                    alert("error al parsear respuesta");
                    break;
            }
        
        };
        $.post(this.url,data,funcion);
    }//fin newStep
    
    //metodo que agrega a la tabla el nuevo paso que recibio del servidor
    this.showNewStep = function(paso){
        var select = '<td><input type="radio" name="selected" value="'+paso.id+'" onclick="controlador.selected()"></td>';
        var id= '<td style="display: none"> '+paso.id+' </td>';
        var desc = '<td> '+paso.description+' </td>';
        var type = '<td> '+paso.type+' </td>';
        var order = '<td><input type="number" value="'+paso.order+'" onchange="controlador.changeorder()></td>';
        var x = '<td> <button onclick="controlador.delete()" >x</button></td>'
        $('#stepsTable tr:last').after("<tr>"+select+id+desc+type+order+x+"</tr>");
    }
    
    //funcion de prueba q cambia el color de los wells
    this.clickCircle = function(letra,nro){
        console.log("hiciste click en "+letra+nro);
        //van a haber 3 tipos de clases, "clicked", "unclicked" y "none"
        var celda = $("#cell"+letra+nro+" div");    //agarro el div dentro de esa celda
        if(celda.hasClass("unclicked")){
            celda.removeClass("unclicked");
            celda.addClass("clicked");
        }else{
            if(celda.hasClass("none")){
                celda.removeClass("none");
                celda.addClass("unclicked");
            }else{
                celda.removeClass("clicked");
                celda.addClass("none");
            }
        }
    }
    
    //metodo que pide todos los steps asociados a este test y plaqueta
    this.cargarPasosAjax = function(){
        var data = {
            action : "getStepPlate",
            idPlate : this.test.plates
        }
        var funcion = function(data,status){
            if(status !== "success"){
                alert("No se pudo conectar con el servidor");
                return;
            }
            console.log(data);
            data = JSON.parse(data);
            if(data.status == "ok"){
                var i=0;
                for(i; i<data.steps.length;i++){
                    //parseo la respuesta del AJAX
                    var step = controlador.createStep(data.steps[i]);
                    //guardo el step en un arreglo
                    controlador.steps = controlador.steps.concat(step);
                    controlador.showNewStep(step);
                }
                //controlador.steps.forEach(,controlador);
            }
        }
        $.get(this.url,data,funcion);
    }
    
    //metodo que toma lo que devuelve el ajax de pasos y encapsula en un objeto Step
    this.createStep = function(ajaxStep){
        var step = new Step();
        step.id = ajaxStep.id;
        step.description = ajaxStep.descr;
        step.order = ajaxStep.ordinal;
        if(ajaxStep.type == 0){
            step.type = "well";
        }else{
            step.type = "plate";
        }
        
        step.status = ajaxStep.status;
        step.amount = ajaxStep.amount;
        step.wells = ajaxStep.wells;
        return step;
    }
    
}//fin de la clase TestControler