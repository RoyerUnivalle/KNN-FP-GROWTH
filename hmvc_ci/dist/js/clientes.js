//Se invoca el controlador de inserción de Clientes.
function insertaCliente(urlBase){
    //Se obtienen los valores digitados en el formulario.
    var id_cliente     = document.getElementById('id-cliente').value;
    var nombre_cliente = document.getElementById('cliente-nombre').value;
    var genero         = document.getElementById('cliente-genero').value;
    var genero_idx     = document.getElementById('cliente-genero').selectedIndex;
    var telefono       = document.getElementById('cliente-telefono').value;
    var ciudad         = document.getElementById('cliente-ciudad').value;
    var ciudad_idx     = document.getElementById('cliente-ciudad').selectedIndex;
    var direccion      = document.getElementById('cliente-direccion').value;
    var email          = document.getElementById('cliente-email').value;
    var estado         = document.getElementById('cliente-estado').value;
    var estado_idx     = document.getElementById('cliente-estado').selectedIndex;
    var fechaNaci      = document.getElementById('cliente-fechanacimiento').value;
    
    //Se eliminan espacios en blanco al inicio y al final de los valores ingresados.
    id_cliente     = $.trim(id_cliente);
    nombre_cliente = $.trim(nombre_cliente);
    nombre_cliente = nombre_cliente.toUpperCase();
    genero         = $.trim(genero);
    telefono       = $.trim(telefono);
    ciudad         = $.trim(ciudad);
    direccion      = $.trim(direccion);
    email          = $.trim(email);
    estado         = $.trim(estado);
    fechaNaci      = $.trim(fechaNaci);
    
    //Se realizan las validaciones sobre los campos ingresados.
    try{
        if(id_cliente === null || id_cliente.length === 0 || /^\s+$/.test(id_cliente) ) {
            throw "El campo Código del Cliente es obligatorio.";
        }
        if(nombre_cliente === null || nombre_cliente.length === 0 || /^\s+$/.test(nombre_cliente)){
            throw "El campo Nombre Cliente es obligatorio.";
        }
        if(genero_idx === null){
            throw "El Género es obligatorio.";
        }
        if(telefono === null || telefono.length === 0 || /^\s+$/.test(telefono)){
            throw "El campo Teléfono es obligatorio.";
        }
        if(ciudad_idx === null){
            throw "Debe seleccionar una Ciudad de la lista.";
        }
        if(direccion === null || direccion.length === 0 || /^\s+$/.test(direccion)){
            throw "El campo Dirección es obligatorio.";
        }
        if(!(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(email)) ) {
            throw "El formato del Email es incorrecto.";
        }
        if(estado_idx === null){
            throw "Debe seleccionar un Estado de la lista.";
        }
        if(fechaNaci === null || fechaNaci.length === 0){
            throw "El campo Fecha de Nacimiento es obligatorio.";
        }
        /*if(!(/^([0][1-9]|[12][0-9]|3[01])(\/|-)([0][1-9]|[1][0-2])\2(\d{4})$/.test(fechaNaci)) ) {
            throw "El formato de la Fecha de Nacimiento es incorrecto.";
        }*/
        
        //Se valida si el cliente a registrar ya existe,
        //de lo contrario se realiza el registro
        $.ajax({
            url:urlBase+'clientes/obtenerCliente',
            async:false,
            data:{
                idClie:id_cliente
            },
            type:'POST',
            success:function(result){
                try{
                    if(result == 1){
                        throw "El Cliente ya existe.";
                    }
                    else{
                        $.ajax({
                            url:urlBase+'clientes/guardarCliente',
                            async:false,
                            data:{
                                idClie:id_cliente,
                                nombreClie:nombre_cliente,
                                genero:genero,
                                telefonoClie:telefono,
                                ciudadClie:ciudad,
                                direccionClie:direccion,
                                emailClie:email,
                                estadoClie:estado,
                                fechaNaci:fechaNaci
                            },
                            type:'POST',
                            success:function(insert){
                                try{
                                    if(insert !== "true"){
                                        throw "Falló el registro del Cliente";
                                    }
                                    if(insert === "true"){
                                        alert("Cliente almacenado exitosamente.");
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


//Se invoca el controlador de consulta de Clientes.
function consultaCliente(urlBase){
    //Se obtienen los valores digitados en el campo de búsqueda.
    var cliente_valor = document.getElementById('cliente-valor').value;
    cliente_valor     = $.trim(cliente_valor);
    $.ajax({
        url:urlBase+'clientes/seleccionarCliente',
        async:false,
        data:{
            cliente_valor:cliente_valor
        },
        type:'POST',
        success:function(select){
            try{
                if(select !== "false"){
                    document.getElementById('clientes').innerHTML = "";
                    document.getElementById('clientes').innerHTML = select;
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


//Se invoca el controlador de modificación de Clientes para cargar el formulario de modificación.
function modificaCliente(urlBase,idCliente){
    $.ajax({
        url:urlBase+'clientes/modificarCliente',
        async:false,
        data:{
            idCliente:idCliente
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


//Se invoca el controlador de borrado de Clientes.
function borraCliente(urlBase,idCliente){
    if(confirm("¿Desea eliminar el cliente?")){;
        $.ajax({
            url:urlBase+'clientes/eliminarCliente',
            async:false,
            data:{
                idCliente:idCliente
            },
            type:'POST',
            success:function(elimina){
                try{
                    if(elimina !== "false"){
                        document.getElementById('clientes').innerHTML = "";
                        document.getElementById('clientes').innerHTML = elimina;
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


//Se invoca el controlador de actualización de Clientes.
function actualizaCliente(urlBase){
    //Se obtienen los valores digitados en el formulario.
    var id_cliente     = document.getElementById('id-cliente').value;
    var nombre_cliente = document.getElementById('cliente-nombre').value;
    var genero         = document.getElementById('cliente-genero').value;
    var genero_idx     = document.getElementById('cliente-genero').selectedIndex;
    var telefono       = document.getElementById('cliente-telefono').value;
    var ciudad         = document.getElementById('cliente-ciudad').value;
    var ciudad_idx     = document.getElementById('cliente-ciudad').selectedIndex;
    var direccion      = document.getElementById('cliente-direccion').value;
    var email          = document.getElementById('cliente-email').value;
    var estado         = document.getElementById('cliente-estado').value;
    var estado_idx     = document.getElementById('cliente-estado').selectedIndex;
    var fechaNaci      = document.getElementById('cliente-fechanacimiento').value;
    
    //Se eliminan espacios en blanco al inicio y al final de los valores ingresados.
    id_cliente     = $.trim(id_cliente);
    nombre_cliente = $.trim(nombre_cliente);
    nombre_cliente = nombre_cliente.toUpperCase();
    genero         = $.trim(genero);
    telefono       = $.trim(telefono);
    ciudad         = $.trim(ciudad);
    direccion      = $.trim(direccion);
    email          = $.trim(email);
    estado         = $.trim(estado);
    fechaNaci      = $.trim(fechaNaci);
    
    //Se realizan las validaciones sobre los campos ingresados.
    try{
        if(nombre_cliente === null || nombre_cliente.length === 0 || /^\s+$/.test(nombre_cliente)){
            throw "El campo Nombre Cliente es obligatorio.";
        }
        if(genero_idx === null){
            throw "El Género es obligatorio.";
        }
        if(telefono === null || telefono.length === 0 || /^\s+$/.test(telefono)){
            throw "El campo Teléfono es obligatorio.";
        }
        if(ciudad_idx === null){
            throw "Debe seleccionar una Ciudad de la lista.";
        }
        if(direccion === null || direccion.length === 0 || /^\s+$/.test(direccion)){
            throw "El campo Dirección es obligatorio.";
        }
        if(!(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(email)) ) {
            throw "El formato del Email es incorrecto.";
        }
        if(estado_idx === null){
            throw "Debe seleccionar un Estado de la lista.";
        }
        if(fechaNaci === null || fechaNaci.length === 0){
            throw "El campo Fecha de Nacimiento es obligatorio.";
        }
        //if(!(/^([0][1-9]|[12][0-9]|3[01])(\/|-)([0][1-9]|[1][0-2])\2(\d{4})$/.test(fechaNaci)) ) {
        /*if(!(/^([0-9]{2})-([0-9]{2})-([0-9]{4})$/.test(fechaNaci)) ) {
            throw "El formato de la Fecha de Nacimiento es incorrecto.";
        }*/
        
        //Se valida si el cliente a registrar ya existe,
        //de lo contrario se realiza el registro
        $.ajax({
            url:urlBase+'clientes/actualizarCliente',
            async:false,
            data:{
                idClie:id_cliente,
                nombreClie:nombre_cliente,
                genero:genero,
                telefonoClie:telefono,
                ciudadClie:ciudad,
                direccionClie:direccion,
                emailClie:email,
                estadoClie:estado,
                fechaNaci:fechaNaci
            },
            type:'POST',
            success:function(insert){
                try{
                    if(insert !== "true"){
                        throw "Falló la actualización del Cliente";
                    }
                    if(insert === "true"){
                        alert("Cliente actualizado exitosamente.");
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