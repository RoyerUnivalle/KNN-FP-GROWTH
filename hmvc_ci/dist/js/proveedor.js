//Se invoca el controlador de inserción de Proveedores.
function insertaProveedor(urlBase){
    //Se obtienen los valores digitados en el formulario.
    var id_proveedor     = document.getElementById('id-proveedor').value;
    var nombre_proveedor = document.getElementById('proveedor-nombre').value;
    var telefono         = document.getElementById('proveedor-telefono').value;
    var direccion        = document.getElementById('proveedor-direccion').value;
    var email            = document.getElementById('proveedor-email').value;
    var estado           = document.getElementById('proveedor-estado-id').value;
    var estado_idx       = document.getElementById('proveedor-estado-id').selectedIndex;
    
    //Se eliminan espacios en blanco al inicio y al final de los valores ingresados.
    id_proveedor     = $.trim(id_proveedor);
    nombre_proveedor = $.trim(nombre_proveedor);
    nombre_proveedor = nombre_proveedor.toUpperCase();
    telefono         = $.trim(telefono);
    direccion        = $.trim(direccion);
    email            = $.trim(email);
    estado           = $.trim(estado);
    
    //Se realizan las validaciones sobre los campos ingresados.
    try{
        if(id_proveedor == null || id_proveedor.length == 0 || /^\s+$/.test(id_proveedor) ) {
            throw "El campo Código Proveedor es obligatorio.";
        }
        if(nombre_proveedor == null || nombre_proveedor.length == 0 || /^\s+$/.test(nombre_proveedor)){
            throw "El campo Nombre Proveedor es obligatorio.";
        }
        if(direccion == null || direccion.length == 0 || /^\s+$/.test(direccion)){
            throw "El campo Dirección es obligatorio.";
        }
        if(telefono == null || telefono.length == 0 || /^\s+$/.test(telefono)){
            throw "El campo Teléfono es obligatorio.";
        }
        if( !(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(email)) ) {
            throw "El formato del Email es incorrecto.";
        }
        if(estado_idx == null){
            throw "Debe seleccionar un Estado de la lista.";
        }
        $.ajax({
            url:urlBase+'proveedores/obtenerProveedor',
            async:false,
            data:{
                idProv:id_proveedor
            },
            type:'POST',
            success:function(result){
                try{
                    if(result == 1){
                        throw "El Proveedor ya existe.";
                    }
                    else{
                        $.ajax({
                            url:urlBase+'proveedores/guardarProveedor',
                            async:false,
                            data:{
                                idProv:id_proveedor,
                                nombreProv:nombre_proveedor,
                                telefonoProv:telefono,
                                direccionProv:direccion,
                                emailProv:email,
                                estadoProv:estado
                            },
                            type:'POST',
                            success:function(insert){
                                try{
                                    if(insert !== "true"){
                                        throw "Falló el registro del proveedor.";
                                    }
                                    if(insert == "true"){
                                        alert("Proveedor almacenado exitosamente.");
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


//Se invoca el controlador de consulta de Proveedores.
function consultaProveedor(urlBase){
    //Se obtienen los valores digitados en el campo de búsqueda.
    var proveedor_valor = document.getElementById('proveedor-valor').value;
    proveedor_valor     = $.trim(proveedor_valor);
    $.ajax({
        url:urlBase+'proveedores/seleccionarProveedor',
        async:false,
        data:{
            proveedor_valor:proveedor_valor
        },
        type:'POST',
        success:function(select){
            try{
                if(select !== "false"){
                    document.getElementById('proveedores').innerHTML = "";
                    document.getElementById('proveedores').innerHTML = select;
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

//Se invoca el controlador de modificación de Proveedores para cargar el formulario de modificación.
function modificaProveedor(urlBase,idProveedor){
    $.ajax({
        url:urlBase+'proveedores/modificarProveedor',
        async:false,
        data:{
            idProveedor:idProveedor
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


//Se invoca el controlador de actualización de Proveedores.
function actualizaProveedor(urlBase){
    //Se obtienen los valores digitados en el formulario.
    var id_proveedor     = document.getElementById('id-proveedor').value;
    var nombre_proveedor = document.getElementById('proveedor-nombre').value;
    var telefono         = document.getElementById('proveedor-telefono').value;
    var direccion        = document.getElementById('proveedor-direccion').value;
    var email            = document.getElementById('proveedor-email').value;
    var estado           = document.getElementById('proveedor-estado-id').value;
    var estado_idx       = document.getElementById('proveedor-estado-id').selectedIndex;
    
    //Se eliminan espacios en blanco al inicio y al final de los valores ingresados.
    id_proveedor     = $.trim(id_proveedor);
    nombre_proveedor = $.trim(nombre_proveedor);
    nombre_proveedor = nombre_proveedor.toUpperCase();
    telefono         = $.trim(telefono);
    direccion        = $.trim(direccion);
    email            = $.trim(email);
    estado           = $.trim(estado);
    
    //Se realizan las validaciones sobre los campos ingresados.
    try{
        if(nombre_proveedor == null || nombre_proveedor.length == 0 || /^\s+$/.test(nombre_proveedor)){
            throw "El campo Nombre Proveedor es obligatorio.";
        }
        if(direccion == null || direccion.length == 0 || /^\s+$/.test(direccion)){
            throw "El campo Dirección es obligatorio.";
        }
        if(telefono == null || telefono.length == 0 || /^\s+$/.test(telefono)){
            throw "El campo Teléfono es obligatorio.";
        }
        if( !(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(email)) ) {
            throw "El formato del Email es incorrecto.";
        }
        if(estado_idx == null){
            throw "Debe seleccionar un Estado de la lista.";
        }
        $.ajax({
            url:urlBase+'proveedores/actualizarProveedor',
            async:false,
            data:{
                idProv:id_proveedor,
                nombreProv:nombre_proveedor,
                telefonoProv:telefono,
                direccionProv:direccion,
                emailProv:email,
                estadoProv:estado
            },
            type:'POST',
            success:function(update){
                try{
                    if(update !== "true"){
                        throw "Falló la actualización del proveedor.";
                    }
                    if(update === "true"){
                        alert("Proveedor actualizado exitosamente.");
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

//Se invoca el controlador de borrado de Proveedores.
function borraProveedor(urlBase,idProveedor){
    if(confirm("¿Desea eliminar el proveedor?")){;
        $.ajax({
            url:urlBase+'proveedores/eliminarProveedor',
            async:false,
            data:{
                idProveedor:idProveedor
            },
            type:'POST',
            success:function(elimina){
                try{
                    if(elimina !== "false"){
                        document.getElementById('proveedores').innerHTML = "";
                        document.getElementById('proveedores').innerHTML = elimina;
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
