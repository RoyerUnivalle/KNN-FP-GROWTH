function insertaMovitras(urlBase){
    //Se obtienen los valores digitados en el formulario.
    var bodefuen        = document.getElementById('movitras-bodefuen-id').value;
    var bodefuen_idx    = document.getElementById('movitras-bodefuen-id').selectedIndex;
    var bodedest        = document.getElementById('movitras-bodedest-id').value;
    var bodedest_idx    = document.getElementById('movitras-bodedest-id').selectedIndex;
    var ingrediente     = document.getElementById('movitras-ingrediente-id').value;
    var ingrediente_idx = document.getElementById('movitras-ingrediente-id').selectedIndex;
    var cantidad        = document.getElementById('movitras-cantidad').value;
    var observacion     = document.getElementById('movitras-observacion').value;
    
    //Se eliminan espacios en blanco al inicio y al final de los valores ingresados.
    bodefuen    = $.trim(bodefuen);
    bodedest    = $.trim(bodedest);
    ingrediente = $.trim(ingrediente);
    cantidad    = $.trim(cantidad);
    observacion = $.trim(observacion);
    
    //Se realizan las validaciones sobre los campos ingresados.
    try{
        if(bodefuen_idx === null){
            throw "Debe seleccionar una Bodega Fuente de la lista.";
        }
        if(ingrediente_idx === null){
            throw "Debe seleccionar un Ingrediente de la lista.";
        }
        if(cantidad === null || cantidad.length === 0 || /^\s+$/.test(cantidad) ) {
            throw "El campo Cantidad es obligatorio.";
        }
        if(bodedest_idx === null){
            throw "Debe seleccionar una Bodega Destino de la lista.";
        }
        if(observacion === null || observacion.length === 0 || /^\s+$/.test(observacion) ) {
            throw "El campo Observación es obligatorio.";
        }
        
        //Se registra el movimiento de traslado de bodega.
        $.ajax({
            url:urlBase+'movitras/guardarMovitras',
            async:false,
            data:{
                bodefuen:bodefuen,
                ingrediente:ingrediente,
                cantidad:cantidad,
                bodedest:bodedest,
                observacion:observacion
            },
            type:'POST',
            success:function(insert){
                try{
                    if(insert == "bofu_no_disponible"){
                        throw "La cantidad a trasladar supera la cantidad disponible en la bodega fuente.";
                    }
                    if(insert == "false"){
                        throw "Falló la actualización de las cantidades en Bodega";
                    }
                    if(insert === "true"){
                        alert("Movimiento de traslado registrado exitosamente. Actualización de cantidades en Bodega exitosa.");
                    }
                }
                catch(err){
                    alert(err);
                }
            }
        });
    }
    catch(err){
        alert(err);
    }
}

//Se invoca el controlador de consulta de Ingredientes por Bodega.
function consultaMoviTras(urlBase){
    //Se obtienen los valores digitados en el campo de búsqueda.
    var movitras_valor = document.getElementById('movitras-valor').value;
    movitras_valor     = $.trim(movitras_valor);
    $.ajax({
        url:urlBase+'movitras/seleccionarMoviTras',
        async:false,
        data:{
            movitras_valor:movitras_valor
        },
        type:'POST',
        success:function(select){
            try{
                if(select !== "false"){
                    document.getElementById('movitras').innerHTML = "";
                    document.getElementById('movitras').innerHTML = select;
                }
                else{
                    alert("No se encontraron datos.");
                }
            }
            catch(err){
                alert(err);
            }
        }
    });
}