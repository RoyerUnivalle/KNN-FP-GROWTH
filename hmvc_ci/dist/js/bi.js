//Se invoca el controlador de inserción de Clientes.
function sincronizaDW(urlBase){
    $.ajax({
        url:urlBase+'bi/sincronizaDW',
        async:false,
        type:'POST',
        success:function(result){
            try{
                if(result == 'true'){
                    throw "Sincronización existosa";
                }
                else{
                    throw "Sincronización fallida";
                }
            }
            catch(err){
                alert(err);
            }
        }
    });
}

function consultaClientesFrecuentes(urlBase){
    var fechaInic = document.getElementById('fecha-inicio').value;
    var fechaFina = document.getElementById('fecha-final').value;
    var frecuMini = document.getElementById('frecuencia-minima').value;
    var porceMini = document.getElementById('porcentaje-recomendacion').value;
    var cliente   = document.getElementById('cliente').value;
    fechaInic     = $.trim(fechaInic);
    fechaFina     = $.trim(fechaFina);
    frecuMini     = $.trim(frecuMini);
    porceMini     = $.trim(porceMini);
    cliente       = $.trim(cliente);
    try{
        if(fechaInic === null || fechaInic.length === 0){
            if(cliente === null || cliente.length === 0){
                throw "El campo Fecha Inicial o el campo Cliente es obligatorio.";
            }
        }
        else{
            if(cliente !== "" || cliente.length > 0){
                throw "El campo Cliente debe ser nulo.";
            }
        }
        if(fechaFina === null || fechaFina.length === 0){
            if(cliente === null || cliente.length === 0){
                throw "El campo Fecha Final o el campo Cliente es obligatorio.";
            }
        }
        else{
            if(cliente !== "" || cliente.length > 0){
                throw "El campo Cliente debe ser nulo.";
            }
        }
        if(frecuMini === null || frecuMini.length === 0 || /^\s+$/.test(frecuMini) ) {
            throw "El campo Frecuencia Mínima es obligatorio.";
        }
        else{
            if(frecuMini <= 0){
                throw "El campo Frecuencia Mínima debe ser mayor o igual a 1.";
            }
        }
        if(porceMini === null || porceMini.length === 0 || /^\s+$/.test(porceMini) ) {
            throw "El campo Porcentaje de Recomendación Mínimo es obligatorio.";
        }
        else{
            if(porceMini <= 0){
                throw "El campo Porcentaje de Recomendación Mínimo debe ser mayor o igual a 1.";
            }
            else{
                if(porceMini > 100){
                    throw "El campo Porcentaje de Recomendación Mínimo debe ser menor o igual a 100.";
                }
            }
        }
        $.ajax({
            url:urlBase+'bi/consultaClientesFrecuentes',
            async:false,
            data:{
                fechaInic:fechaInic,
                fechaFina:fechaFina,
                frecuMini:frecuMini,
                porceMini:porceMini,
                cliente:cliente
            },
            type:'POST',
            success:function(result){
                try{
                    if(result === 'false'){
                        throw "No se encontraron Clientes frecuentes para el lapso dado.";
                    }
                    else{
                        document.getElementById('clientes').innerHTML = "";
                        document.getElementById('clientes').innerHTML = result;
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

function recomiendaProducto(urlBase,idCliente,frecuMini,porceMini){
    try{
        $.ajax({
            url:urlBase+'bi/consultaProduClien',
            async:false,
            data:{
                idCliente:idCliente,
                frecuMini:frecuMini,
                porceMini:porceMini
            },
            type:'POST',
            success:function(result){
                try{
                    if(result === 'false'){
                        throw "No se encontraron Clientes frecuentes para el lapso dado.";
                    }
                    else{
                        document.getElementById('productos').innerHTML = "";
                        document.getElementById('productos').innerHTML = result;
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

function consultaProveedoresFrecuentes(urlBase){
    var fechaInic = document.getElementById('fecha-inicio').value;
    var fechaFina = document.getElementById('fecha-final').value;
    var frecuMini = document.getElementById('frecuencia-minima').value;
    var porceMini = document.getElementById('porcentaje-recomendacion').value;
    var proveedor = document.getElementById('proveedor').value;
    fechaInic     = $.trim(fechaInic);
    fechaFina     = $.trim(fechaFina);
    frecuMini     = $.trim(frecuMini);
    porceMini     = $.trim(porceMini);
    proveedor       = $.trim(proveedor);
    try{
        if(fechaInic === null || fechaInic.length === 0){
            if(proveedor === null || proveedor.length === 0){
                throw "El campo Fecha Inicial o el campo Proveedor es obligatorio.";
            }
        }
        else{
            if(proveedor !== "" || proveedor.length > 0){
                throw "El campo Proveedor debe ser nulo.";
            }
        }
        if(fechaFina === null || fechaFina.length === 0){
            if(proveedor === null || proveedor.length === 0){
                throw "El campo Fecha Final o el campo Proveedor es obligatorio.";
            }
        }
        else{
            if(proveedor !== "" || proveedor.length > 0){
                throw "El campo Proveedor debe ser nulo.";
            }
        }
        if(frecuMini === null || frecuMini.length === 0 || /^\s+$/.test(frecuMini) ) {
            throw "El campo Frecuencia Mínima es obligatorio.";
        }
        else{
            if(frecuMini <= 0){
                throw "El campo Frecuencia Mínima debe ser mayor o igual a 1.";
            }
        }
        if(porceMini === null || porceMini.length === 0 || /^\s+$/.test(porceMini) ) {
            throw "El campo Porcentaje de Recomendación Mínimo es obligatorio.";
        }
        else{
            if(porceMini <= 0){
                throw "El campo Porcentaje de Recomendación Mínimo debe ser mayor o igual a 1.";
            }
            else{
                if(porceMini > 100){
                    throw "El campo Porcentaje de Recomendación Mínimo debe ser menor o igual a 100.";
                }
            }
        }
        $.ajax({
            url:urlBase+'bi/consultaProveedoresFrecuentes',
            async:false,
            data:{
                fechaInic:fechaInic,
                fechaFina:fechaFina,
                frecuMini:frecuMini,
                porceMini:porceMini,
                proveedor:proveedor
            },
            type:'POST',
            success:function(result){
                try{
                    if(result === 'false'){
                        throw "No se encontraron Proveedores frecuentes para el lapso dado.";
                    }
                    else{
                        document.getElementById('proveedores').innerHTML = "";
                        document.getElementById('proveedores').innerHTML = result;
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

function recomiendaIngrediente(urlBase,idProveedor,frecuMini,porceMini){
    try{
        $.ajax({
            url:urlBase+'bi/consultaIngreProve',
            async:false,
            data:{
                idProveedor:idProveedor,
                frecuMini:frecuMini,
                porceMini:porceMini
            },
            type:'POST',
            success:function(result){
                try{
                    if(result === 'false'){
                        throw "No se encontraron Proveedores frecuentes para el lapso dado.";
                    }
                    else{
                        document.getElementById('ingredientes').innerHTML = "";
                        document.getElementById('ingredientes').innerHTML = result;
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