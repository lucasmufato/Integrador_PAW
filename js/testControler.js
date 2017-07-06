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
    this.ultimoPaso = 1;    //nro de orden del ultimo paso
    this.test;              //test actual
    this.steps=[];          //arreglo con todos los pasos
    this.stepSelected=null;      //ultimo paso seleccionado
    
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
                    paso.id=data.stepId;
                    controlador.showNewStep(paso);
                    controlador.steps.push(paso);
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
        var select = '<td><input type="radio" name="selected" value="'+paso.id+'" onclick="controlador.selectStep('+paso.id+')"></td>';
        var id= '<td style="display: none"> '+paso.id+' </td>';
        var desc = '<td> '+paso.description+' </td>';
        var type = '<td> '+paso.type+' </td>';
        var order = '<td><input type="number" value="'+paso.order+'" onchange="controlador.changeorder()></td>';
        var x = '<td> <button onclick="controlador.delete()" >x</button></td>'
        $('#stepsTable tr:last').after("<tr id='step"+paso.id+"'>"+select+id+desc+type+order+x+"</tr>");
    }
    
    //funcion que recibe el click en la matriz, pinta el circulo y envia el ajax correspondiente
    this.clickCircle = function(letra,nro){
        var steps = $.grep(this.steps, function(e){ return e.id == controlador.stepSelected; });  //devuelve los steps con ese id
        var wells = steps[0].wells;
        var celda = $("#cell"+letra+nro+" div");
        //si contenia a ese well
        var estado=false;
        //chequeo si esta 
        var i=0;
        for(i;i<wells.length;i++){
            if( (wells[i].row == letra) && (wells[i].column == nro) ){
                estado=true;
                break;
            }
        }
        
        //data para enviar al servidor
         var data = {
                action : "wellForStep",
                idPlate : controlador.test.plates,
                stepID : steps[0].id,
                wellRow : letra,
                wellCol : nro
         }
        
        //funcion a ser llamada
        var funcion;    
        
        if( estado ){
            
            //dato que indica que se debe sacar el paso de ese well
            data.event = "remove";
            
            //funcion que se ejecuta al salir bien este ajax
            funcion = function(data,status){
                if(status !== "success"){
                    alert("No se pudo conectar con el servidor");
                    return;
                }
                console.log(data);
                data = JSON.parse(data);
                if(data.status == "ok"){
                    
                    /*     ESTO SE COPIA Y PEGA     */
                    //despinto
                    celda.removeClass("clicked");
                    celda.addClass("none");
                    //saco del arreglo. en realidad reemplazo el arreglo por otro q no contiene ese well
                    console.log("borrando: "+wells[i]);
                    //wells = wells.filter(function(w){w.row != letra && w.column != nro})
                    wells.splice(i,1);
                    
                }else{
                    alert(data.errores);
                }
            }
        }else{
            
            //agrego al data la informacion necesaria
            data.event = "add";
            
            funcion = function(data,status){
                if(status !== "success"){
                    alert("No se pudo conectar con el servidor");
                    return;
                }
                console.log(data);
                data = JSON.parse(data);
                if(data.status == "ok"){
                    
                    /*     ESTO SE COPIA Y PEGA     */
                //si NO lo contenia, ahora lo contiene
                celda.addClass("clicked");
                celda.removeClass("none");
                var well = new Well();
                well.row = letra;
                well.column = nro;
                wells.push(well);
                    
                }else{
                    alert(data.errores);
                }
            }
        }//fin del if-else
    
    $.post(this.url,data,funcion);
        
    }//fin del metodo
    
    //funcion que se activa cuando se da click a un radio de seleccionar
    this.selectStep = function(idPaso){
        //si no habia step seleccionado lo selecciono
        if( this.stepSelected == null){
            this.stepSelected = idPaso;
            $("#step"+idPaso).addClass("selectedStep");
            this.showWellsForStep(idPaso);
            return;
        }
        //si es el mismo que estaba seleccionado, limpio los wells y deselecciono
        if( this.stepSelected == idPaso ){
            $("#step"+idPaso).removeClass("selectedStep");
            this.stepSelected = null;
            this.clearWells();
            return;
        }
        //si el seleccionado es uno distinto al anterior
        //no es necesario el if, pero se entiende mas y es mas facil modificar
        if( this.stepSelected != idPaso ){
            $("#step"+this.stepSelected).removeClass("selectedStep");
            this.clearWells();
            this.stepSelected = idPaso;
            $("#step"+idPaso).addClass("selectedStep");
            this.showWellsForStep(idPaso);
        }
    }
    
    //funcion que limpia los wells 
    this.clearWells = function(){
        //saco todos las clases q le dan color, incluyendo none por las dudas
        $(".circulo").removeClass("clicked");
        $(".circulo").removeClass("none");
        $(".circulo").removeClass("unclicked");
        //y se la pongo a todos devuelta
        $(".circulo").addClass("none");
    }
    
    //funcion que dado el ID del paso, pinta todos los wells de ese paso
    this.showWellsForStep = function(idPaso){
        var steps = $.grep(this.steps, function(e){ return e.id == idPaso; });  //devuelve los steps con ese id
        console.log("paso al step: "+steps[0].id);
        var wells = steps[0].wells;
        //por cada well en el paso que lo pinte
        wells.forEach(function(well){
            console.log("pinto:"+well);
           $("#cell"+well.row+well.column+" div").addClass("clicked");
            $("#cell"+well.row+well.column+" div").removeClass("none");
        });
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
        if(ajaxStep.wells != null){
            //si tiene wells asociados
            var i=0
            for(i;i<ajaxStep.wells.length;i++){
                //por cada well que recibo, lo envio a la funcion q lo parsea y devuelve un objeto well
                //el cual despues agrego a la lista de wells
                step.wells.push( this.createWell(ajaxStep.wells[i] ));
            }
            
        }
        return step;
    }
    
    //creo un objeto well atraves del ajax recibido
    this.createWell = function(ajaxWell){
        var well = new Well();
        well.id = ajaxWell.id;
        well.row = ajaxWell.fila;
        well.column = ajaxWell.columna;
        well.status = ajaxWell.status;
        well.amount = ajaxWell.quantity;
        return well;
    }
    
    //funcion que envia un ajax pidiendo en cambio de estado del test, si es aceptado recarga la pagina, sino muestra el error.
    this.terminarCrear = function(){
        var data = {
            action : "startTest",
            idTest : this.test.id
        }
        
        var funcion = function(data,status){
            if(status !== "success"){
                alert("No se pudo conectar con el servidor");
                return;
            }
            console.log(data);
            data = JSON.parse(data);
            if(data.status == "ok"){
                //si salio bien recargo la pagina, pidiendosela al servidor devuelta
                location.reload(true);
            }else{
                //si tiro errores los imprimo donde corresponde
                controlador.printErrors("#endTestErrors",data.errores);
            }
        }
        $.post(this.url,data,funcion);
        
    }
    
    this.finalizarTest = function(){
        var data = {
            action : "endTest",
            idTest : this.test.id
        }
        
        var funcion = function(data,status){
            if(status !== "success"){
                alert("No se pudo conectar con el servidor");
                return;
            }
            console.log(data);
            data = JSON.parse(data);
            if(data.status == "ok"){
                //si salio bien pido el resultado del test
                controlador.pedirResultado();
            }else{
                //si tiro errores los imprimo donde corresponde
                controlador.printErrors("#endTestErrors",data.errores);
            }
        }
        $.post(this.url,data,funcion);
    }
    
    this.pedirResultado = function(){
        alert("pediria los resultado TODO");
    }
    
    //funcion general que recibe un selector de conetenedor, lo limpia y despues carga los errores que recibe como lista en el segundo paramentro.
    this.printErrors = function(selector, errorList){
        var conteiner = $(selector);
        conteiner.text("");
        var i=0;
        for(i;i<errorList.length;i++){
            conteiner.append("<p class='error'>"+errorList[i]+"<p>")
        }
    }
    
}//fin de la clase TestControler