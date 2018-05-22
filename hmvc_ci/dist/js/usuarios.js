function insertaUsuario(urlBase){
    //Se obtienen los valores digitados en el formulario.
    var nombre_usuario   = document.getElementById('usuario-nombre').value;
    var clave_usuario    = document.getElementById('usuario-clave').value;
    var estado           = document.getElementById('usuario-estado-id').value;
    var estado_idx       = document.getElementById('usuario-estado-id').selectedIndex;
    var perfil           = document.getElementById('usuario-perfil-id').value;
    var perfil_idx       = document.getElementById('usuario-perfil-id').selectedIndex;
    //Se eliminan espacios en blanco al inicio y al final de los valores ingresados.
    nombre_usuario = $.trim(nombre_usuario);
    clave_usuario  = $.trim(clave_usuario);
    estado         = $.trim(estado);
    perfil         = $.trim(perfil);
    //Se realizan las validaciones sobre los campos ingresados.
    if(nombre_usuario == null || nombre_usuario.length == 0 || /^\s+$/.test(nombre_usuario) ) {
        alert("El campo Usuario es obligatorio.");
    }
    else{
        if(clave_usuario == null || clave_usuario.length == 0 || /^\s+$/.test(clave_usuario)){
            alert("El campo Clave es obligatorio.");
        }
        else{
            if(estado_idx == null){
                alert("El Estado es obligatorio.");
            }
            else{
                if(perfil_idx == null){
                    alert("El campo Perfil es obligatorio.");
                }
                else{
                    $.ajax({
                        url:urlBase+'usuarios/obtenerUsuario',
                        async:false,
                        data:{
                            idUsuario:"",
                            nombreUsua:nombre_usuario
                        },
                        type:'POST',
                        success:function(result){
                            if(result === "false"){
                                throw "El Usuario ya existe.";
                            }
                            else{
                                if(result === "true"){
                                    $.ajax({
                                        url:urlBase+'usuarios/guardarUsuario',
                                        async:false,
                                        data:{
                                            nombreUsua:nombre_usuario,
                                            claveUsua:clave_usuario,
                                            estadoUsua:estado,
                                            perfilUsua:perfil
                                        },
                                        type:'POST',
                                        success:function(insert){
                                            if(insert == "true"){
                                                alert("Usuario almacenado exitosamente.");
                                                document.location.href=urlBase+'home/';
                                            }
                                            else{
                                                alert("Falló el registro del Usuario.");
                                            }
                                        }
                                    });
                                }
                            }
                        }
                    });
                }
            }
        }
    }
}

//Se invoca el controlador de modificación de Usuarios para cargar el formulario de modificación.
function modificaUsuario(urlBase,idUsuario){
    $.ajax({
        url:urlBase+'usuarios/modificarUsuario',
        async:false,
        data:{
            idUsuario:idUsuario
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

//Se invoca el controlador de actualización de Usuarios.
function actualizaUsuario(urlBase){
    //Se obtienen los valores digitados en el formulario.
    var id_usuario     = document.getElementById('id-usuario').value;
    var nombre_usuario = document.getElementById('usuario-nombre').value;
    var perfil         = document.getElementById('usuario-perfil').value;
    var perfil_idx     = document.getElementById('usuario-perfil').selectedIndex;
    var clave_usuario  = document.getElementById('usuario-clave').value;
    var estado         = document.getElementById('usuario-estado').value;
    var estado_idx     = document.getElementById('usuario-estado').selectedIndex;
    
    //Se eliminan espacios en blanco al inicio y al final de los valores ingresados.
    id_usuario     = $.trim(id_usuario);
    nombre_usuario = $.trim(nombre_usuario);
    nombre_usuario = nombre_usuario.toLowerCase();
    clave_usuario  = $.trim(clave_usuario);
    perfil         = $.trim(perfil);
    estado         = $.trim(estado);
    
    //Se realizan las validaciones sobre los campos ingresados.
    try{    
        if(nombre_usuario === null || nombre_usuario.length === 0 || /^\s+$/.test(nombre_usuario) ) {
            throw "El campo Usuario es obligatorio.";
        }
        if(clave_usuario === null || clave_usuario.length === 0 || /^\s+$/.test(clave_usuario)){
            throw "El campo Clave es obligatorio.";
        }
        if(estado_idx === null){
            throw "El Estado es obligatorio.";
        }
        if(perfil_idx === null){
            throw("El campo Perfil es obligatorio.");
        }
        $.ajax({
            url:urlBase+'usuarios/obtenerUsuario',
            async:false,
            data:{
                idUsuario:id_usuario,
                nombreUsua:nombre_usuario
            },
            type:'POST',
            success:function(result){
                try{
                    if(result === "false"){
                        throw "El Usuario ya existe.";
                    }
                    else{
                        if(result === "true"){
                            $.ajax({
                                url:urlBase+'usuarios/actualizarUsuario',
                                async:false,
                                data:{
                                    idUsuario:id_usuario,
                                    nombreUsua:nombre_usuario,
                                    claveUsua:clave_usuario,
                                    perfilUsua:perfil,
                                    estadoUsua:estado
                                },
                                type:'POST',
                                success:function(insert){
                                    try{
                                        if(insert === "true"){
                                            alert("Usuario actualizado exitosamente.");
                                        }
                                        else{
                                            throw "Falló la actualización del Usuario.";
                                        }
                                    }
                                    catch(err){
                                        alert(err);
                                    }
                                }
                            });
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

//Se invoca el controlador de borrado de Usuarios.
function borraUsuario(urlBase,idUsuario){
    if(confirm("¿Desea eliminar el Usuario?")){;
        $.ajax({
            url:urlBase+'usuarios/eliminarUsuario',
            async:false,
            data:{
                idUsuario:idUsuario
            },
            type:'POST',
            success:function(elimina){
                try{
                    if(elimina !== "false"){
                        if(elimina === "persusua"){
                            throw "No es posible eliminar. Usuario tiene una Persona asociada.";
                        }
                        else{
                            document.getElementById('usuarios').innerHTML = "";
                            document.getElementById('usuarios').innerHTML = elimina;
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

//Se invoca el controlador de consulta de Usuarios.
function consultaUsuario(urlBase){
    //Se obtienen los valores digitados en el campo de búsqueda.
    var usuario_valor = document.getElementById('usuario-valor').value;
    usuario_valor     = $.trim(usuario_valor);
    $.ajax({
        url:urlBase+'usuarios/seleccionarUsuario',
        async:false,
        data:{
            usuario_valor:usuario_valor
        },
        type:'POST',
        success:function(select){
            try{
                if(select !== "false"){
                    document.getElementById('usuarios').innerHTML = "";
                    document.getElementById('usuarios').innerHTML = select;
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