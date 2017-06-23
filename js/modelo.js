//EN ESTE ARCHIVO ESTA TODO EL MODELO

function Test(){
    this.id;
    this.name;
    this.date;
    this.researcher;
    this.description;
    this.result;
    this.resultDescription;
    this.plates;
    
}

function Result(){
    this.creando = 1 ;
    this.noIniciado = 2 ;
    this.enTrabajo = 3 ;
    this.exitoso = 4 ;
    this.fallido = 5 ;
    this.descartado = 6 ;
    
    //recibe el estado como un string y devuelve el nro de id q le corresponde
    this.getNroByEstado = function (str){
        var estados = {"creando" : 1,"noIniciado" : 2,"enTrabajo" : 3,"exitoso" : 4,"fallido" : 5,"descartado" : 6 };
        return $estados[str];
    }
    
    //recibe un nro y devuelve el nombre del estado en string
    // ej: recibe 1 y devuelve "creando"
    this.getEstadoByNro = function (nro){
         var estados = {1 : "creando",2 : "no iniciado",3 : "en trabajo",4 : "exitoso", 5 : "fallido", 6 : "descartado" };
        return $estados[nro];
    }
}

function Step(){
    this.id;
    this.name;  //este no iria
    this.description;
    this.order;
    this.type;
    this.wells;
}

function Well(){
    this.id;
    this.row;
    this.column;
}
    