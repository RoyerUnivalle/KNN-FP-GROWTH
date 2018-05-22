function insertaCompra(urlBase){
    //Se obtienen los valores digitados en el formulario.
    var id_compra      = document.getElementById('id-compra').value;
    var proveedor      = document.getElementById('compra-proveedor-id').value;
    var proveedor_idx  = document.getElementById('compra-proveedor-id').selectedIndex;
    var fecha          = document.getElementById('compra-fecha').value;
    var costo          = document.getElementById('compra-costo').value;
    var estado         = document.getElementById('compra-estado-id').value;
    var estado_idx     = document.getElementById('compra-estado-id').selectedIndex;
    var descripcion    = document.getElementById('compra-descripcion').value;
    
    //Se eliminan espacios en blanco al inicio y al final de los valores ingresados.
    id_compra   = $.trim(id_compra);
    proveedor   = $.trim(proveedor);
    fecha       = $.trim(fecha);
    costo       = $.trim(costo);
    estado      = $.trim(estado);
    descripcion = $.trim(descripcion);
    
    //Se realizan las validaciones sobre los campos ingresados.
    try{
        if(id_compra === null || id_compra.length === 0 || /^\s+$/.test(id_compra) ) {
            throw "El campo Código de la Compra es obligatorio.";
        }
        if(proveedor_idx === null){
            throw "Debe seleccionar un Proveedor de la lista.";
        }
        if(fecha === null || fecha.length === 0){
            throw "El campo Fecha es obligatorio.";
        }
        if(estado_idx === null){
            throw "Debe seleccionar un Estado de la lista.";
        }
        
        if(descripcion === null || descripcion.length === 0 || /^\s+$/.test(descripcion) ) {
            throw "El campo Descripción de la Compra es obligatorio.";
        }
        //Se valida si la compra a registrar ya existe,
        //de lo contrario se realiza el registro
        $.ajax({
            url:urlBase+'compras/obtenerCompra',
            async:false,
            data:{
                idComp:id_compra
            },
            type:'POST',
            success:function(result){
                try{
                    if(result == 1){
                        throw "La Compra ya existe.";
                    }
                    else{
                        $.ajax({
                            url:urlBase+'compras/guardarCompra',
                            async:false,
                            data:{
                                idComp:id_compra,
                                proveedorComp:proveedor,
                                fechaComp:fecha,
                                costoComp:costo,
                                estadoComp:estado,
                                descriComp:descripcion
                            },
                            type:'POST',
                            success:function(insert){
                                try{
                                    if(insert !== ""){
                                        alert("Compra almacenada exitosamente.")
                                        document.getElementById('movicomp').innerHTML = "";
                                        document.getElementById('movicomp').innerHTML = insert;
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

function insertaMovicomp(urlBase){
    //Se obtienen los valores digitados en el formulario.
    //var id_compra       = document.getElementById('movicomp-compra-id').value;
    var id_compra       = document.getElementById('id-compra').value;
    var secuencia       = document.getElementById('id-movicomp-secuencia').value;
    var ingrediente     = document.getElementById('movicomp-ingrediente-id').value;
    var ingrediente_idx = document.getElementById('movicomp-ingrediente-id').selectedIndex;
    var cantidad        = document.getElementById('movicomp-cantidad').value;
    var costo_unit      = document.getElementById('movicomp-costo-unit').value;
    var costo_total     = document.getElementById('movicomp-costo-total').value;
    var bodega          = document.getElementById('movicomp-bodega-id').value;
    var bodega_idx      = document.getElementById('movicomp-bodega-id').selectedIndex;
    var estado          = document.getElementById('compra-estado-id').value;
    var estado_idx      = document.getElementById('compra-estado-id').selectedIndex;
    
    //Se eliminan espacios en blanco al inicio y al final de los valores ingresados.
    id_compra   = $.trim(id_compra);
    secuencia   = $.trim(secuencia);
    ingrediente   = $.trim(ingrediente);
    cantidad    = $.trim(cantidad);
    costo_unit  = $.trim(costo_unit);
    costo_total = $.trim(costo_total);
    bodega      = $.trim(bodega);
    estado      = $.trim(estado);
    
    //Se realizan las validaciones sobre los campos ingresados.
    try{
        if(id_compra === null || id_compra.length === 0 || /^\s+$/.test(id_compra) ) {
            throw "El campo Código de la Compra es obligatorio.";
        }
        if(secuencia === null || secuencia.length === 0 || /^\s+$/.test(secuencia) ) {
            throw "El campo Secuencia del Movimiento de Compra es obligatorio.";
        }
        if(ingrediente_idx === null){
            throw "Debe seleccionar un Ingrediente de la lista.";
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
        
        //Se valida si la compra a registrar ya existe,
        //de lo contrario se realiza el registro
        $.ajax({
            url:urlBase+'compras/obtenerMovicomp',
            async:false,
            data:{
                idComp:id_compra,
                secuencia:secuencia
            },
            type:'POST',
            success:function(result){
                try{
                    if(result == 1){
                        throw "El Movimiento de Compra ya existe.";
                    }
                    else{
                        $.ajax({
                            url:urlBase+'compras/guardarMovicomp',
                            async:false,
                            data:{id_compra:id_compra,
                                  secuencia:secuencia,
                                  ingrediente:ingrediente,
                                  cantidad:cantidad,
                                  costo_unit:costo_unit,
                                  costo_total:costo_total,
                                  bodega:bodega,
                                  estado:estado
                            },
                            type:'POST',
                            success:function(insert){
                                try{
                                    if(insert !== ""){
                                        document.getElementById('movicomp').innerHTML = "";
                                        document.getElementById('movicomp').innerHTML = insert;
                                        /**************************************************************************************************/
                                        $.ajax({
                                            url:urlBase+'compras/afectaIngrebode',
                                            async:false,
                                            data:{bodega:bodega,
                                                  ingrediente:ingrediente,
                                                  cantidad:cantidad
                                            },
                                            type:'POST',
                                            success:function(afecta){
                                                try{
                                                    if(afecta !== "true"){
                                                        throw "Falló el registro del Movimiento de Compra";
                                                    }
                                                    if(afecta === "true"){
                                                        alert("Movimiento de Compra almacenado exitosamente.")
                                                    }
                                                }
                                                catch(err){
                                                    alert(err);
                                                }
                                            }
                                        });
/**************************************************************************************************/
                                    }
                                    else{
                                        throw "Falló el registro del Movimiento de Compra";
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
function borraMovicomp(urlBase,idCompra,idSecuencia){
    if(confirm("¿Desea eliminar el Movimiento de Compra?")){;
        $.ajax({
            url:urlBase+'compras/eliminarMovicomp',
            async:false,
            data:{
                idCompra:idCompra,
                idSecuencia:idSecuencia
            },
            type:'POST',
            success:function(elimina){
                try{
                    if(elimina !== ""){
                        document.getElementById('movicomp').innerHTML = "";
                        document.getElementById('movicomp').innerHTML = elimina;
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

//Se invoca el controlador de consulta de Compras.
function consultaCompra(urlBase){
    //Se obtienen los valores digitados en el campo de búsqueda.
    var compra_valor = document.getElementById('compra-valor').value;
    compra_valor     = $.trim(compra_valor);
    $.ajax({
        url:urlBase+'compras/seleccionarCompra',
        async:false,
        data:{
            compra_valor:compra_valor
        },
        type:'POST',
        success:function(select){
            try{
                if(select !== "false"){
                    document.getElementById('compras').innerHTML = "";
                    document.getElementById('compras').innerHTML = select;
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

//Se invoca el controlador de consulta de Compras.
function modificaCompra(urlBase,idCompra){
    $.ajax({
        url:urlBase+'compras/modificarCompra',
        async:false,
        data:{
            idCompra:idCompra
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

//Actualiza datos de la compra
function actualizaCompra(urlBase){
    //Se obtienen los valores digitados en el formulario.
    var id_compra      = document.getElementById('id-compra').value;
    var proveedor      = document.getElementById('compra-proveedor-id').value;
    var proveedor_idx  = document.getElementById('compra-proveedor-id').selectedIndex;
    var fecha          = document.getElementById('compra-fecha').value;
    var costo          = document.getElementById('compra-costo').value;
    var estado         = document.getElementById('compra-estado-id').value;
    var estado_idx     = document.getElementById('compra-estado-id').selectedIndex;
    var descripcion    = document.getElementById('compra-descripcion').value;
    
    //Se eliminan espacios en blanco al inicio y al final de los valores ingresados.
    id_compra   = $.trim(id_compra);
    proveedor   = $.trim(proveedor);
    fecha       = $.trim(fecha);
    costo       = $.trim(costo);
    estado      = $.trim(estado);
    descripcion = $.trim(descripcion);
    
    //Se realizan las validaciones sobre los campos ingresados.
    try{
        if(id_compra === null || id_compra.length === 0 || /^\s+$/.test(id_compra) ) {
            throw "El campo Código de la Compra es obligatorio.";
        }
        if(proveedor_idx === null){
            throw "Debe seleccionar un Proveedor de la lista.";
        }
        if(fecha === null || fecha.length === 0){
            throw "El campo Fecha es obligatorio.";
        }
        if(estado_idx === null){
            throw "Debe seleccionar un Estado de la lista.";
        }
        
        if(descripcion === null || descripcion.length === 0 || /^\s+$/.test(descripcion) ) {
            throw "El campo Descripción de la Compra es obligatorio.";
        }
        //Se valida si la compra a registrar ya existe,
        //de lo contrario se realiza el registro
        $.ajax({
            url:urlBase+'compras/actualizarCompra',
            async:false,
            data:{
                idComp:id_compra,
                proveedorComp:proveedor,
                fechaComp:fecha,
                costoComp:costo,
                estadoComp:estado,
                descriComp:descripcion
            },
            type:'POST',
            success:function(update){
                try{
                    if(update !== "true"){
                        throw "Falló la actualización de la Compra";
                    }
                    if(update === "true"){
                        alert("Compra actualizada exitosamente.");
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

//Se invoca el controlador de eliminado de Compras.
function borraCompra(urlBase,idCompra){
    if(confirm("¿Desea eliminar la Compra?")){;
        $.ajax({
            url:urlBase+'compras/eliminarCompra',
            async:false,
            data:{
                idCompra:idCompra
            },
            type:'POST',
            success:function(elimina){
                try{
                   if(elimina == "false"){
                        throw "Falló la eliminación de la Compra";
                    }
                    else{
                        if(elimina == "movicomp"){
                            throw "No es posible eliminar. Compra con movimientos de compra asociados.";
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