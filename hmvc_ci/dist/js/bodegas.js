function insertaBodega(urlBase){
    //Se obtienen los valores digitados en el formulario.
    var id_bodega     = document.getElementById('id-bodega').value;
    var nombre_bodega = document.getElementById('bodega-nombre').value;
    var estado_bodega = document.getElementById('bodega-estado').value;
    var estado_idx    = document.getElementById('bodega-estado').selectedIndex;
    
    //Se eliminan espacios en blanco al inicio y al final de los valores ingresados.
    id_bodega     = $.trim(id_bodega);
    nombre_bodega = $.trim(nombre_bodega);
    nombre_bodega = nombre_bodega.toUpperCase();
    estado_bodega = $.trim(estado_bodega);
    
    //Se realizan las validaciones sobre los campos ingresados.
    try{
        if(id_bodega === null || id_bodega.length === 0 || /^\s+$/.test(id_bodega) ) {
            throw "El campo Código de la Bodega es obligatorio.";
        }
        if(nombre_bodega === null || nombre_bodega.length === 0 || /^\s+$/.test(nombre_bodega)){
            throw "El campo Nombre Bodega es obligatorio.";
        }
        if(estado_idx === null){
            throw "Debe seleccionar un Estado de la lista.";
        }
        
        //Se valida si el bodega a registrar ya existe,
        //de lo contrario se realiza el registro
        $.ajax({
            url:urlBase+'bodegas/obtenerBodega',
            async:false,
            data:{
                idBodega:id_bodega,
                nombreBodega:nombre_bodega,
                operacion:"I"
            },
            type:'POST',
            success:function(result){
                try{
                   if(result === "false"){
                        throw "La Bodega ya existe.";
                    }
                    else{
                        $.ajax({
                            url:urlBase+'bodegas/guardarBodega',
                            async:false,
                            data:{
                                idBode:id_bodega,
                                nombreBode:nombre_bodega,
                                estadoBode:estado_bodega
                            },
                            type:'POST',
                            success:function(insert){
                                try{
                                    if(insert !== "true"){
                                        throw "Falló el registro de la Bodega";
                                    }
                                    if(insert === "true"){
                                        alert("Bodega almacenada exitosamente.");
                                    }
                                }
                                catch(err){
                                    alert(err);
                                }
                            }
                        });
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

//Se invoca el controlador de modificación de Bodegas para cargar el formulario de modificación.
function modificaBodega(urlBase,idBodega){
    $.ajax({
        url:urlBase+'bodegas/modificarBodega',
        async:false,
        data:{
            idBodega:idBodega
        },
        type:'POST',
        success:function(modifica){
            try{
                if(modifica !== "false"){
                    document.getElementById('page-wrapper').innerHTML = "";
                    document.getElementById('page-wrapper').innerHTML = modifica;
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

//Se invoca el controlador de actualización de Bodegas.
function actualizaBodega(urlBase){
    //Se obtienen los valores digitados en el formulario.
    var id_bodega     = document.getElementById('id-bodega').value;
    var nombre_bodega = document.getElementById('bodega-nombre').value;
    var estado_bodega = document.getElementById('bodega-estado').value;
    var estado_idx    = document.getElementById('bodega-estado').selectedIndex;
    
    //Se eliminan espacios en blanco al inicio y al final de los valores ingresados.
    id_bodega     = $.trim(id_bodega);
    nombre_bodega = $.trim(nombre_bodega);
    nombre_bodega = nombre_bodega.toUpperCase();
    estado_bodega = $.trim(estado_bodega);
    
    //Se realizan las validaciones sobre los campos ingresados.
    try{
        if(id_bodega === null || id_bodega.length === 0 || /^\s+$/.test(id_bodega) ) {
            throw "El campo Código de la Bodega es obligatorio.";
        }
        if(nombre_bodega === null || nombre_bodega.length === 0 || /^\s+$/.test(nombre_bodega)){
            throw "El campo Nombre Bodega es obligatorio.";
        }
        if(estado_idx === null){
            throw "Debe seleccionar un Estado de la lista.";
        }
        
        //Se valida si la bodega a registrar ya existe,
        //de lo contrario se realiza el registro
        $.ajax({
            url:urlBase+'bodegas/obtenerBodega',
            async:false,
            data:{
                idBodega:id_bodega,
                nombreBodega:nombre_bodega,
                operacion:"U"
            },
            type:'POST',
            success:function(result){
                try{
                    if(result === "false"){
                        throw "La Bodega ya existe.";
                    }
                    else{
                        if(result === "true"){
                            try{
                                $.ajax({
                                    url:urlBase+'bodegas/actualizarBodega',
                                    async:false,
                                    data:{
                                        idBodega:id_bodega,
                                        nombreBodega:nombre_bodega,
                                        estadoBodega:estado_bodega
                                    },
                                    type:'POST',
                                    success:function(insert){
                                        try{
                                            if(insert !== "true"){
                                                throw "Falló la actualización de la Bodega";
                                            }
                                            if(insert === "true"){
                                                alert("Bodega actualizada exitosamente.");
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

//Se invoca el controlador de borrado de Bodegas.
function borraBodega(urlBase,idBodega){
    if(confirm("¿Desea eliminar la bodega?")){;
        $.ajax({
            url:urlBase+'bodegas/eliminarBodega',
            async:false,
            data:{
                idBodega:idBodega
            },
            type:'POST',
            success:function(elimina){
                try{
                    if(elimina !== "false"){
                        if(elimina === "movibode"){
                            throw "No es posible eliminar. Bodega tiene Movimientos de Compra asociados.";
                        }
                        else{
                            if(elimina === "ingrebode"){
                                throw "No es posible eliminar. Bodega tiene Bodegas asociados.";
                            }
                            else{
                                if(elimina === "movebode"){
                                    throw "No es posible eliminar. Bodega tiene Movimientos de Venta asociados.";
                                }
                                else{
                                    document.getElementById('bodegas').innerHTML = "";
                                    document.getElementById('bodegas').innerHTML = elimina;
                                }
                            }
                        }
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
}

//Se invoca el controlador de consulta de Bodegas.
function consultaBodega(urlBase){
    //Se obtienen los valores digitados en el campo de búsqueda.
    var bodega_valor = document.getElementById('bodega-valor').value;
    bodega_valor     = $.trim(bodega_valor);
    $.ajax({
        url:urlBase+'bodegas/seleccionarBodega',
        async:false,
        data:{
            bodega_valor:bodega_valor
        },
        type:'POST',
        success:function(select){
            try{
                if(select !== "false"){
                    document.getElementById('bodegas').innerHTML = "";
                    document.getElementById('bodegas').innerHTML = select;
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