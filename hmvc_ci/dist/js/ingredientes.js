function insertaIngrediente(urlBase){
    //Se obtienen los valores digitados en el formulario.
    var nombre_ingrediente  = document.getElementById('ingrediente-nombre').value;
    var cantmin_ingrediente = document.getElementById('ingrediente-cantidad-minima').value;
    var cantmax_ingrediente = document.getElementById('ingrediente-cantidad-maxima').value;
    var cantact_ingrediente = document.getElementById('ingrediente-cantidad-actual').value;
    var unidad_ingrediente  = document.getElementById('ingrediente-unidad').value;
    var unidad_idx          = document.getElementById('ingrediente-unidad').selectedIndex;
    var estado_ingrediente  = document.getElementById('ingrediente-estado').value;
    var estado_idx          = document.getElementById('ingrediente-estado').selectedIndex;
    
    //Se eliminan espacios en blanco al inicio y al final de los valores ingresados.
    nombre_ingrediente    = $.trim(nombre_ingrediente);
    nombre_ingrediente    = nombre_ingrediente.toUpperCase();
    cantmin_ingrediente   = $.trim(cantmin_ingrediente);
    cantmax_ingrediente   = $.trim(cantmax_ingrediente);
    cantact_ingrediente   = $.trim(cantact_ingrediente);
    unidad_ingrediente    = $.trim(unidad_ingrediente);
    estado_ingrediente    = $.trim(estado_ingrediente);
    
    //Se realizan las validaciones sobre los campos ingresados.
    try{
        if(nombre_ingrediente == null || nombre_ingrediente.length == 0 || /^\s+$/.test(nombre_ingrediente) ) {
            throw "El campo Nombre del Ingrediente es obligatorio.";
        }
        if(unidad_idx == null){
            throw "La Unidad es obligatoria.";
        }
        if(cantmin_ingrediente == null || cantmin_ingrediente.length == 0 || /^\s+$/.test(cantmin_ingrediente)){
            throw "La Cantidad Mínima es obligatoria.";
        }
        if(cantmax_ingrediente == null || cantmax_ingrediente.length == 0 || /^\s+$/.test(cantmax_ingrediente)){
            throw "La Cantidad Máxima es obligatoria.";
        }
        if(cantact_ingrediente == null || cantact_ingrediente.length == 0 || /^\s+$/.test(cantact_ingrediente)){
            throw "La Cantidad Actual es obligatoria.";
        }
        if(estado_idx == null){
            throw "Debe seleccionar un Estado de la lista.";
        }
        $.ajax({
            url:urlBase+'ingredientes/obtenerIngrediente',
            async:false,
            data:{
                idIngrediente:"",
                nombreIngrediente:nombre_ingrediente
            },
            type:'POST',
            success:function(result){
                try{
                    if(result === "false"){
                        throw "El Ingrediente ya existe.";
                    }
                    else{
                        $.ajax({
                            url:urlBase+'ingredientes/guardarIngrediente',
                            async:false,
                            data:{
                                nombreIngr:nombre_ingrediente,
                                cantMinIngr:cantmin_ingrediente,
                                cantMaxIngr:cantmax_ingrediente,
                                cantActIngr:cantact_ingrediente,
                                unidadIngr:unidad_ingrediente,
                                estadoIngr:estado_ingrediente
                            },
                            type:'POST',
                            success:function(insert){
                                try{
                                    if(insert !== "true"){
                                        throw "Falló el registro del Ingrediente.";
                                    }
                                    if(insert == "true"){
                                        alert("Ingrediente almacenado exitosamente.");
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

//Se invoca el controlador de modificación de Ingredientes para cargar el formulario de modificación.
function modificaIngrediente(urlBase,idIngrediente){
    $.ajax({
        url:urlBase+'ingredientes/modificarIngrediente',
        async:false,
        data:{
            idIngrediente:idIngrediente
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

//Se invoca el controlador de actualización de Ingredientes.
function actualizaIngrediente(urlBase){
    //Se obtienen los valores digitados en el formulario.
    var id_ingrediente      = document.getElementById('id-ingrediente').value;
    var nombre_ingrediente  = document.getElementById('ingrediente-nombre').value;
    var cantMin_ingrediente = document.getElementById('ingrediente-cantidad-minima').value;
    var cantMax_ingrediente = document.getElementById('ingrediente-cantidad-maxima').value;
    var cantAct_ingrediente = document.getElementById('ingrediente-cantidad-actual').value;
    var unidad_ingrediente  = document.getElementById('ingrediente-unidad').value;
    var unidad_idx          = document.getElementById('ingrediente-unidad').selectedIndex;
    var estado_ingrediente  = document.getElementById('ingrediente-estado').value;
    var estado_idx          = document.getElementById('ingrediente-estado').selectedIndex;
    
    //Se eliminan espacios en blanco al inicio y al final de los valores ingresados.
    id_ingrediente     = $.trim(id_ingrediente);
    nombre_ingrediente = $.trim(nombre_ingrediente);
    nombre_ingrediente = nombre_ingrediente.toUpperCase();
    cantMin_ingrediente = $.trim(cantMin_ingrediente);
    cantMax_ingrediente = $.trim(cantMax_ingrediente);
    cantAct_ingrediente = $.trim(cantAct_ingrediente);
    unidad_ingrediente = $.trim(unidad_ingrediente);
    estado_ingrediente = $.trim(estado_ingrediente);
    
    //Se realizan las validaciones sobre los campos ingresados.
    try{
        if(nombre_ingrediente === null || nombre_ingrediente.length === 0 || /^\s+$/.test(nombre_ingrediente) ) {
            throw "El campo Nombre del Ingrediente es obligatorio.";
        }
        if(cantMin_ingrediente === null || cantMin_ingrediente.length === 0 || /^\s+$/.test(cantMin_ingrediente)){
            throw "La Cantidad Mínima es obligatoria.";
        }
        if(cantMax_ingrediente === null || cantMax_ingrediente.length === 0 || /^\s+$/.test(cantMax_ingrediente)){
            throw "La Cantidad Máxima es obligatoria.";
        }
        if(unidad_idx === null){
            throw "La Unidad es obligatoria.";
        }
        if(estado_idx === null){
            throw "Debe seleccionar un Estado de la lista.";
        }
        $.ajax({
            url:urlBase+'ingredientes/obtenerIngrediente',
            async:false,
            data:{
                idIngrediente:id_ingrediente,
                nombreIngrediente:nombre_ingrediente
            },
            type:'POST',
            success:function(result){
                try{
                    if(result === "false"){
                        throw "El Ingrediente ya existe.";
                    }
                    else{
                        if(result === "true"){
                            try{
                                $.ajax({
                                    url:urlBase+'ingredientes/actualizarIngrediente',
                                    async:false,
                                    data:{
                                        idIngrediente:id_ingrediente,
                                        nombreIngrediente:nombre_ingrediente,
                                        cantMinIngrediente:cantMin_ingrediente,
                                        cantMaxIngrediente:cantMax_ingrediente,
                                        cantActIngrediente:cantAct_ingrediente,
                                        unidadIngrediente:unidad_ingrediente,
                                        estadoIngrediente:estado_ingrediente
                                    },
                                    type:'POST',
                                    success:function(insert){
                                        try{
                                            if(insert !== "true"){
                                                throw "Falló la actualización del Ingrediente";
                                            }
                                            if(insert === "true"){
                                                alert("Ingrediente actualizado exitosamente.");
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

//Se invoca el controlador de borrado de Ingredientes.
function borraIngrediente(urlBase,idIngrediente){
    if(confirm("¿Desea eliminar el ingrediente?")){;
        $.ajax({
            url:urlBase+'ingredientes/eliminarIngrediente',
            async:false,
            data:{
                idIngrediente:idIngrediente
            },
            type:'POST',
            success:function(elimina){
                try{
                    if(elimina !== "false"){
                        if(elimina === "movicomp"){
                            throw "No es posible eliminar. Ingrediente tiene Movimientos de Compra asociados.";
                        }
                        else{
                            if(elimina === "ingreprodu"){
                                throw "No es posible eliminar. Ingrediente tiene Ingredientes asociados.";
                            }
                            else{
                                document.getElementById('ingredientes').innerHTML = "";
                                document.getElementById('ingredientes').innerHTML = elimina;
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

//Se invoca el controlador de consulta de Ingredientes.
function consultaIngrediente(urlBase){
    //Se obtienen los valores digitados en el campo de búsqueda.
    var ingrediente_valor = document.getElementById('ingrediente-valor').value;
    ingrediente_valor     = $.trim(ingrediente_valor);
    $.ajax({
        url:urlBase+'ingredientes/seleccionarIngrediente',
        async:false,
        data:{
            ingrediente_valor:ingrediente_valor
        },
        type:'POST',
        success:function(select){
            try{
                if(select !== "false"){
                    document.getElementById('ingredientes').innerHTML = "";
                    document.getElementById('ingredientes').innerHTML = select;
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