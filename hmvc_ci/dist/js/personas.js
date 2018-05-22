function insertaPersona(urlBase){
    //Se obtienen los valores digitados en el formulario.
    var id_persona          = document.getElementById('id-persona').value;
    var nombre_persona      = document.getElementById('persona-nombre').value;
    var apellido_persona    = document.getElementById('persona-apellido').value;
    var email_persona       = document.getElementById('persona-email').value;
    var ciudad_persona      = document.getElementById('persona-ciudad').value;
    var ciudad_idx          = document.getElementById('persona-ciudad').selectedIndex;
    var direccion_persona   = document.getElementById('persona-direccion').value;
    var telefono_persona    = document.getElementById('persona-telefono').value;
    var usuario_persona     = document.getElementById('persona-usuario').value;
    var usuario_persona_idx = document.getElementById('persona-usuario').selectedIndex;
    var estado_persona      = document.getElementById('persona-estado').value;
    var estado_persona_idx  = document.getElementById('persona-estado').selectedIndex;
    //Se eliminan espacios en blanco al inicio y al final de los valores ingresados.
    id_persona        = $.trim(id_persona);
    nombre_persona    = $.trim(nombre_persona);
    nombre_persona    = nombre_persona.toUpperCase();
    apellido_persona  = $.trim(apellido_persona);
    apellido_persona  = apellido_persona.toUpperCase();
    email_persona     = $.trim(email_persona);
    ciudad_persona    = $.trim(ciudad_persona);
    direccion_persona = $.trim(direccion_persona);
    telefono_persona  = $.trim(telefono_persona);
    usuario_persona   = $.trim(usuario_persona);
    estado_persona    = $.trim(estado_persona);
    
    //Se realizan las validaciones sobre los campos ingresados.
    try{
        if(id_persona == null || id_persona.length == 0 || /^\s+$/.test(id_persona) ) {
            throw "El campo Código Persona es obligatorio.";
        }
        if(nombre_persona == null || nombre_persona.length == 0 || /^\s+$/.test(nombre_persona)){
            throw "El campo Nombres es obligatorio.";
        }
        if(apellido_persona == null || apellido_persona.length == 0 || /^\s+$/.test(apellido_persona)){
            throw "El campo Apellidos es obligatorio.";
        }
        if(!(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(email_persona)) ) {
            throw "El formato del campo Email es incorrecto.";
        }
        if(ciudad_idx == null){
            throw "Debe seleccionar una Ciudad de la lista.";
        }
        if(direccion_persona == null || direccion_persona.length == 0) {
            throw "El campo Dirección es obligatorio.";
        }
        if(telefono_persona == null || telefono_persona.length == 0){
            throw("El campo Teléfono es obligatorio.");
        }
        if(usuario_persona_idx == null){
            throw "Debe seleccionar un Usuario de la lista.";
        }
        if(estado_persona_idx == null){
            throw("Debe seleccionar un Estado de la lista.");
        }
        
        //Se valida si la persona a registrar ya existe,
        //de lo contrario se realiza el registro
        $.ajax({
            url:urlBase+'personas/obtenerPersona',
            async:false,
            data:{
                idPers:id_persona
            },
            type:'POST',
            success:function(result){
                try{
                    if(result == 1){
                        throw "La Persona ya existe.";
                    }
                    else{
                        $.ajax({
                            url:urlBase+'personas/validarUsuaPers',
                            async:false,
                            data:{
                                idPers:id_persona,
                                usuarioPers:usuario_persona
                            },
                            type:'POST',
                            success:function(usuario){
                                try{
                                    if(usuario == 1){
                                        throw "El Usuario ["+usuario_persona+"] ya ha sido asignado a otra Persona.";
                                    }
                                    else{
                                        $.ajax({
                                            url:urlBase+'personas/guardarPersona',
                                            async:false,
                                            data:{
                                                idPers:id_persona,
                                                nombrePers:nombre_persona,
                                                apellidoPers:apellido_persona,
                                                emailPers:email_persona,
                                                ciudadPers:ciudad_persona,
                                                direccionPers:direccion_persona,
                                                telefonoPers:telefono_persona,
                                                usuarioPers:usuario_persona,
                                                estadoPers:estado_persona
                                            },
                                            type:'POST',
                                            success:function(insert){
                                                try{
                                                    if(insert !== "true"){
                                                        throw "Falló el registro de la persona.";
                                                    }
                                                    if(insert === "true"){
                                                        alert("Persona almacenada exitosamente.");
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



function actualizaPersona(urlBase){
    //Se obtienen los valores digitados en el formulario.
    var id_persona          = document.getElementById('id-persona').value;
    var nombre_persona      = document.getElementById('persona-nombre').value;
    var apellido_persona    = document.getElementById('persona-apellido').value;
    var email_persona       = document.getElementById('persona-email').value;
    var ciudad_persona      = document.getElementById('persona-ciudad').value;
    var ciudad_idx          = document.getElementById('persona-ciudad').selectedIndex;
    var direccion_persona   = document.getElementById('persona-direccion').value;
    var telefono_persona    = document.getElementById('persona-telefono').value;
    var usuario_persona     = document.getElementById('persona-usuario').value;
    var usuario_persona_idx = document.getElementById('persona-usuario').selectedIndex;
    var estado_persona      = document.getElementById('persona-estado').value;
    var estado_persona_idx  = document.getElementById('persona-estado').selectedIndex;
    //Se eliminan espacios en blanco al inicio y al final de los valores ingresados.
    id_persona        = $.trim(id_persona);
    nombre_persona    = $.trim(nombre_persona);
    nombre_persona    = nombre_persona.toUpperCase();
    apellido_persona  = $.trim(apellido_persona);
    apellido_persona  = apellido_persona.toUpperCase();
    email_persona     = $.trim(email_persona);
    ciudad_persona    = $.trim(ciudad_persona);
    direccion_persona = $.trim(direccion_persona);
    telefono_persona  = $.trim(telefono_persona);
    usuario_persona   = $.trim(usuario_persona);
    estado_persona    = $.trim(estado_persona);
    
    //Se realizan las validaciones sobre los campos ingresados.
    try{
        if(nombre_persona == null || nombre_persona.length == 0 || /^\s+$/.test(nombre_persona)){
            throw "El campo Nombres es obligatorio.";
        }
        if(apellido_persona == null || apellido_persona.length == 0 || /^\s+$/.test(apellido_persona)){
            throw "El campo Apellidos es obligatorio.";
        }
        if(!(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(email_persona)) ) {
            throw "El formato del campo Email es incorrecto.";
        }
        if(ciudad_idx == null){
            throw "Debe seleccionar una Ciudad de la lista.";
        }
        if(direccion_persona == null || direccion_persona.length == 0) {
            throw "El campo Dirección es obligatorio.";
        }
        if(telefono_persona == null || telefono_persona.length == 0){
            throw("El campo Teléfono es obligatorio.");
        }
        if(usuario_persona_idx == null){
            throw "Debe seleccionar un Usuario de la lista.";
        }
        if(estado_persona_idx == null){
            throw("Debe seleccionar un Estado de la lista.");
        }
        
        //Se valida si la persona a registrar ya existe,
        //de lo contrario se realiza el registro
        $.ajax({
            url:urlBase+'personas/validarUsuaPers',
            async:false,
            data:{
                idPers:id_persona,
                usuarioPers:usuario_persona,
            },
            type:'POST',
            success:function(usuario){
                try{
                    if(usuario == 1){
                        throw "El Usuario ["+usuario_persona+"] ya ha sido asignado a otra Persona.";
                    }
                    else{
                        $.ajax({
                            url:urlBase+'personas/actualizarPersona',
                            async:false,
                            data:{
                                idPers:id_persona,
                                nombrePers:nombre_persona,
                                apellidoPers:apellido_persona,
                                emailPers:email_persona,
                                ciudadPers:ciudad_persona,
                                direccionPers:direccion_persona,
                                telefonoPers:telefono_persona,
                                usuarioPers:usuario_persona,
                                estadoPers:estado_persona
                            },
                            type:'POST',
                            success:function(insert){
                                try{
                                    if(insert !== "true"){
                                        throw "Falló la actualización de la persona.";
                                    }
                                    if(insert === "true"){
                                        alert("Persona actualizada exitosamente.");
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



//Se invoca el controlador de consulta de Personas.
function consultaPersona(urlBase){
    //Se obtienen los valores digitados en el campo de búsqueda.
    var persona_valor = document.getElementById('persona-valor').value;
    persona_valor     = $.trim(persona_valor);
    $.ajax({
        url:urlBase+'personas/seleccionarPersona',
        async:false,
        data:{
            persona_valor:persona_valor
        },
        type:'POST',
        success:function(select){
            try{
                if(select !== "false"){
                    document.getElementById('personas').innerHTML = "";
                    document.getElementById('personas').innerHTML = select;
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
function modificaPersona(urlBase,idPersona){
    $.ajax({
        url:urlBase+'personas/modificarPersona',
        async:false,
        data:{
            idPersona:idPersona
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
function borraPersona(urlBase,idPersona){
    if(confirm("¿Desea eliminar la persona?")){;
        $.ajax({
            url:urlBase+'personas/eliminarPersona',
            async:false,
            data:{
                idPersona:idPersona
            },
            type:'POST',
            success:function(elimina){
                try{
                    if(elimina !== "false"){
                        document.getElementById('personas').innerHTML = "";
                        document.getElementById('personas').innerHTML = elimina;
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