function insertaVenta(urlBase){
    //Se obtienen los valores digitados en el formulario.
    var id_venta     = document.getElementById('id-venta').value;
    var cliente      = document.getElementById('venta-cliente-id').value;
    var cliente_idx  = document.getElementById('venta-cliente-id').selectedIndex;
    var fecha        = document.getElementById('venta-fecha').value;
    var costo        = document.getElementById('venta-costo').value;
    var estado       = document.getElementById('venta-estado-id').value;
    var estado_idx   = document.getElementById('venta-estado-id').selectedIndex;
    var descripcion  = document.getElementById('venta-descripcion').value;
    
    //Se eliminan espacios en blanco al inicio y al final de los valores ingresados.
    id_venta   = $.trim(id_venta);
    cliente   = $.trim(cliente);
    fecha       = $.trim(fecha);
    costo       = $.trim(costo);
    estado      = $.trim(estado);
    descripcion = $.trim(descripcion);
    
    //Se realizan las validaciones sobre los campos ingresados.
    try{
        if(id_venta === null || id_venta.length === 0 || /^\s+$/.test(id_venta) ) {
            throw "El campo Código de la Venta es obligatorio.";
        }
        if(cliente_idx === null){
            throw "Debe seleccionar un Cliente de la lista.";
        }
        if(fecha === null || fecha.length === 0){
            throw "El campo Fecha es obligatorio.";
        }
        if(estado_idx === null){
            throw "Debe seleccionar un Estado de la lista.";
        }
        
        if(descripcion === null || descripcion.length === 0 || /^\s+$/.test(descripcion) ) {
            throw "El campo Descripción de la Venta es obligatorio.";
        }
        //Se valida si la venta a registrar ya existe,
        //de lo contrario se realiza el registro
        $.ajax({
            url:urlBase+'ventas/obtenerVenta',
            async:false,
            data:{
                idVent:id_venta
            },
            type:'POST',
            success:function(result){
                try{
                    if(result == 1){
                        throw "La Venta ya existe.";
                    }
                    else{
                        $.ajax({
                            url:urlBase+'ventas/guardarVenta',
                            async:false,
                            data:{
                                idVent:id_venta,
                                clienteVent:cliente,
                                fechaVent:fecha,
                                costoVent:costo,
                                estadoVent:estado,
                                descriVent:descripcion
                            },
                            type:'POST',
                            success:function(insert){
                                try{
                                    if(insert !== ""){
                                        alert("Venta almacenada exitosamente.")
                                        document.getElementById('movivent').innerHTML = "";
                                        document.getElementById('movivent').innerHTML = insert;
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

function insertaMovivent(urlBase){
    //Se obtienen los valores digitados en el formulario.
    var id_venta     = document.getElementById('id-venta').value;
    var secuencia    = document.getElementById('id-movivent-secuencia').value;
    var producto     = document.getElementById('movivent-producto-id').value;
    var producto_idx = document.getElementById('movivent-producto-id').selectedIndex;
    var cantidad     = document.getElementById('movivent-cantidad').value;
    var costo_unit   = document.getElementById('movivent-costo-unit').value;
    var costo_total  = document.getElementById('movivent-costo-total').value;
    var bodega       = document.getElementById('movivent-bodega-id').value;
    var bodega_idx   = document.getElementById('movivent-bodega-id').selectedIndex;
    var estado       = document.getElementById('venta-estado-id').value;
    var estado_idx   = document.getElementById('venta-estado-id').selectedIndex;
    
    //Se eliminan espacios en blanco al inicio y al final de los valores ingresados.
    id_venta    = $.trim(id_venta);
    secuencia   = $.trim(secuencia);
    producto    = $.trim(producto);
    cantidad    = $.trim(cantidad);
    costo_unit  = $.trim(costo_unit);
    costo_total = $.trim(costo_total);
    bodega      = $.trim(bodega);
    estado      = $.trim(estado);
    
    //Se realizan las validaciones sobre los campos ingresados.
    try{
        if(id_venta === null || id_venta.length === 0 || /^\s+$/.test(id_venta) ) {
            throw "El campo Código de la Venta es obligatorio.";
        }
        if(secuencia === null || secuencia.length === 0 || /^\s+$/.test(secuencia) ) {
            throw "El campo Secuencia del Movimiento de Venta es obligatorio.";
        }
        if(producto_idx === null){
            throw "Debe seleccionar un Producto de la lista.";
        }
        if(cantidad === null || cantidad.length === 0 || /^\s+$/.test(cantidad) ) {
            throw "El campo Cantidad es obligatorio.";
        }
        if(costo_unit === null || costo_unit.length === 0 || /^\s+$/.test(costo_unit) ) {
            throw "El campo Costo Unitario es obligatorio.";
        }
        if(bodega_idx === null){
            throw "Debe seleccionar una Bodega de la lista.";
        }
        if(estado_idx === null){
            throw "Debe seleccionar un Estado de la lista.";
        }
        
        //Se valida si la venta a registrar ya existe,
        //de lo contrario se realiza el registro
        $.ajax({
            url:urlBase+'ventas/obtenerMovivent',
            async:false,
            data:{
                idVent:id_venta,
                secuencia:secuencia
            },
            type:'POST',
            success:function(result){
                try{
                    if(result === 1){
                        throw "El Movimiento de Venta ya existe.";
                    }
                    else{
                        $.ajax({
                            url:urlBase+'ventas/afectaIngreBode',
                            async:false,
                            data:{bodega:bodega,
                                  producto:producto,
                                  cantProdu:cantidad,
                                  signo:'-'
                            },
                            type:'POST',
                            success:function(afecta){
                                try{
                                    if(afecta === "true"){
                                        var cantmovi = document.getElementById('movivent-cantidad').value;
                                        var bodemovi = document.getElementById('movivent-bodega-id').value;
                                        //Se eliminan espacios en blanco al inicio y al final de los valores ingresados.
                                        cantmovi = $.trim(cantmovi);
                                        bodemovi = $.trim(bodemovi);
                                        $.ajax({
                                            url:urlBase+'ventas/guardarMovivent',
                                            async:false,
                                            data:{id_venta:id_venta,
                                                  secuencia:secuencia,
                                                  producto:producto,
                                                  cantidad:cantmovi,
                                                  costo_unit:costo_unit,
                                                  costo_total:costo_total,
                                                  bodega:bodemovi,
                                                  estado:estado
                                            },
                                            type:'POST',
                                            success:function(insert){
                                                try{
                                                    if(insert !== ""){
                                                        alert("Movimiento de Venta almacenado exitosamente.")
                                                        document.getElementById('movivent').innerHTML = "";
                                                        document.getElementById('movivent').innerHTML = insert;
                                                    }
                                                    else{
                                                       alert("Falló el registro del Movimiento de Venta.");
                                                    }
                                                }
                                                catch(err){
                                                    alert(err);
                                                }
                                            }
                                        });
                                    }
                                    else{
                                        if(afecta === "false"){
                                            alert("Falló el registro del Movimiento de Venta.");
                                        }
                                        else{
                                            var posiInic = afecta.indexOf("|") + 1;
                                            var posiFina = afecta.indexOf("|",posiInic + 1);
                                            var ingrediente = afecta.substring(posiInic,posiFina);
                                            
                                            var posiInic = posiFina + 1;
                                            var posiFina = afecta.indexOf("|",posiInic + 1);
                                            var bodega = afecta.substring(posiInic,posiFina);
                                            
                                            var posiInic = posiFina + 1;
                                            var posiFina = afecta.indexOf("|",posiInic + 1);
                                            var cantidad = afecta.substring(posiInic,posiFina);
                                            throw ("Cantidad insuficiente del Ingrediente ["+ingrediente+
                                                   "] en la Bodega ["+bodega+
                                                   "]. La cantidad requerida es de ["+cantidad+"] o mayor.");
                                        }
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


//Se invoca el controlador de borrado de Clientes.
function borraMovivent(urlBase,idVenta,idSecuencia,idBodega,idProducto,cantidad){
    if(confirm("¿Desea eliminar el Movimiento de Venta?")){;
        $.ajax({
            url:urlBase+'ventas/afectaIngreBode',
            async:false,
            data:{
                bodega:idBodega,
                producto:idProducto,
                cantProdu:cantidad,
                signo:'+'
            },
            type:'POST',
            success:function(afecta){
                try{
                    if(afecta === "true"){
                        var cantmovi = document.getElementById('movivent-cantidad').value;
                        var bodemovi = document.getElementById('movivent-bodega-id').value;
                        //Se eliminan espacios en blanco al inicio y al final de los valores ingresados.
                        cantmovi = $.trim(cantmovi);
                        bodemovi = $.trim(bodemovi);
        
                        $.ajax({
                            url:urlBase+'ventas/eliminarMovivent',
                            async:false,
                            data:{
                                idVenta:idVenta,
                                idSecuencia:idSecuencia
                            },
                            type:'POST',
                            success:function(elimina){
                                try{
                                    if(elimina !== ""){
                                        document.getElementById('movivent').innerHTML = "";
                                        document.getElementById('movivent').innerHTML = elimina;
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
                catch(err){
                    alert(err);
                }
            }
        });
    }
}

//Se invoca el controlador de consulta de Ventas.
function consultaVenta(urlBase){
    //Se obtienen los valores digitados en el campo de búsqueda.
    var venta_valor = document.getElementById('venta-valor').value;
    venta_valor     = $.trim(venta_valor);
    $.ajax({
        url:urlBase+'ventas/seleccionarVenta',
        async:false,
        data:{
            venta_valor:venta_valor
        },
        type:'POST',
        success:function(select){
            try{
                if(select !== "false"){
                    document.getElementById('ventas').innerHTML = "";
                    document.getElementById('ventas').innerHTML = select;
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

//Se invoca el controlador de consulta de Ventas.
function modificaVenta(urlBase,idVenta){
    $.ajax({
        url:urlBase+'ventas/modificarVenta',
        async:false,
        data:{
            idVenta:idVenta
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

//Actualiza datos de la venta
function actualizaVenta(urlBase){
    //Se obtienen los valores digitados en el formulario.
    var id_venta    = document.getElementById('id-venta').value;
    var cliente     = document.getElementById('venta-cliente-id').value;
    var cliente_idx = document.getElementById('venta-cliente-id').selectedIndex;
    var fecha       = document.getElementById('venta-fecha').value;
    var costo       = document.getElementById('venta-costo').value;
    var estado      = document.getElementById('venta-estado-id').value;
    var estado_idx  = document.getElementById('venta-estado-id').selectedIndex;
    var descripcion = document.getElementById('venta-descripcion').value;
    
    //Se eliminan espacios en blanco al inicio y al final de los valores ingresados.
    id_venta    = $.trim(id_venta);
    cliente     = $.trim(cliente);
    fecha       = $.trim(fecha);
    costo       = $.trim(costo);
    estado      = $.trim(estado);
    descripcion = $.trim(descripcion);
    
    //Se realizan las validaciones sobre los campos ingresados.
    try{
        if(id_venta === null || id_venta.length === 0 || /^\s+$/.test(id_venta) ) {
            throw "El campo Código de la Venta es obligatorio.";
        }
        if(cliente_idx === null){
            throw "Debe seleccionar un Cliente de la lista.";
        }
        if(fecha === null || fecha.length === 0){
            throw "El campo Fecha es obligatorio.";
        }
        if(estado_idx === null){
            throw "Debe seleccionar un Estado de la lista.";
        }
        
        if(descripcion === null || descripcion.length === 0 || /^\s+$/.test(descripcion) ) {
            throw "El campo Descripción de la Venta es obligatorio.";
        }
        //Se valida si la venta a registrar ya existe,
        //de lo contrario se realiza el registro
        $.ajax({
            url:urlBase+'ventas/actualizarVenta',
            async:false,
            data:{
                idVent:id_venta,
                clienteVent:cliente,
                fechaVent:fecha,
                costoVent:costo,
                estadoVent:estado,
                descriVent:descripcion
            },
            type:'POST',
            success:function(update){
                try{
                    if(update !== "true"){
                        throw "Falló la actualización de la Venta";
                    }
                    if(update === "true"){
                        alert("Venta actualizada exitosamente.");
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

//Se invoca el controlador de eliminado de Ventas.
function borraVenta(urlBase,idVenta){
    if(confirm("¿Desea eliminar la Venta?")){;
        $.ajax({
            url:urlBase+'ventas/eliminarVenta',
            async:false,
            data:{
                idVenta:idVenta
            },
            type:'POST',
            success:function(elimina){
                try{
                   if(elimina == "false"){
                        throw "Falló la eliminación de la Compra";
                    }
                    else{
                        if(elimina == "movivent"){
                            throw "No es posible eliminar. Venta con movimientos de venta asociados.";
                        }
                        else{
                            document.getElementById('page-wrapper').innerHTML = "";
                            document.getElementById('page-wrapper').innerHTML = elimina;
                        }
                    }
                }
                catch(err){
                    alert(err);
                }
            }
        });
    }
}