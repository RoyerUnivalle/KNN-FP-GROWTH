function insertaCategoria(urlBase){
    //Se obtienen los valores digitados en el formulario.
    var nombre_categoria = document.getElementById('categoria-nombre').value;
    var estado         = document.getElementById('categoria-estado').value;
    var estado_idx     = document.getElementById('categoria-estado').selectedIndex;
    
    //Se eliminan espacios en blanco al inicio y al final de los valores ingresados.
    nombre_categoria = $.trim(nombre_categoria);
    nombre_categoria = nombre_categoria.toUpperCase();
    estado           = $.trim(estado);
    
    //Se realizan las validaciones sobre los campos ingresados.
    try{
        if(nombre_categoria === null || nombre_categoria.length === 0 || /^\s+$/.test(nombre_categoria)){
            throw "El campo Nombre Categoría es obligatorio.";
        }
        if(estado_idx === null){
            throw "Debe seleccionar un Estado de la lista.";
        }
        $.ajax({
            url:urlBase+'categorias/obtenerCategoria',
            async:false,
            data:{
                idCategoria:"",
                nombreCategoria:nombre_categoria
            },
            type:'POST',
            success:function(result){
                try{
                    if(result === "false"){
                        throw "La Categoría ya existe.";
                    }
                    else{
                        $.ajax({
                            url:urlBase+'categorias/guardarCategoria',
                            async:false,
                            data:{
                                nombreCate:nombre_categoria,
                                estadoCate:estado
                            },
                            type:'POST',
                            success:function(insert){
                                try{
                                    if(insert !== "true"){
                                        throw "Falló el registro de la Categoría.";
                                    }
                                    if(insert === "true"){
                                        alert("Categoría almacenada exitosamente.");
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

//Se invoca el controlador de modificación de Categorias para cargar el formulario de modificación.
function modificaCategoria(urlBase,idCategoria){
    $.ajax({
        url:urlBase+'categorias/modificarCategoria',
        async:false,
        data:{
            idCategoria:idCategoria
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

//Se invoca el controlador de actualización de Categorias.
function actualizaCategoria(urlBase){
    //Se obtienen los valores digitados en el formulario.
    var id_categoria     = document.getElementById('id-categoria').value;
    var nombre_categoria = document.getElementById('categoria-nombre').value;
    var estado_categoria = document.getElementById('categoria-estado').value;
    var estado_idx       = document.getElementById('categoria-estado').selectedIndex;
    
    //Se eliminan espacios en blanco al inicio y al final de los valores ingresados.
    id_categoria     = $.trim(id_categoria);
    nombre_categoria = $.trim(nombre_categoria);
    nombre_categoria = nombre_categoria.toUpperCase();
    estado_categoria = $.trim(estado_categoria);
    
    //Se realizan las validaciones sobre los campos ingresados.
    $.ajax({
        url:urlBase+'categorias/obtenerCategoria',
        async:false,
        data:{
            idCategoria:id_categoria,
            nombreCategoria:nombre_categoria
        },
        type:'POST',
        success:function(result){
            try{
                if(result === "false"){
                    throw "La Categoría ya existe.";
                }
                else{
                    if(result === "true"){
                        try{
                            if(nombre_categoria === null || nombre_categoria.length === 0 || /^\s+$/.test(nombre_categoria)){
                                throw "El campo Nombre Categoría es obligatorio.";
                            }
                            if(estado_idx === null){
                                throw "Debe seleccionar un Estado de la lista.";
                            }
                            $.ajax({
                                url:urlBase+'categorias/actualizarCategoria',
                                async:false,
                                data:{
                                    idCategoria:id_categoria,
                                    nombreCategoria:nombre_categoria,
                                    estadoCategoria:estado_categoria
                                },
                                type:'POST',
                                success:function(insert){
                                    try{
                                        if(insert !== "true"){
                                            throw "Falló la actualización de la Categoría";
                                        }
                                        if(insert === "true"){
                                            alert("Categoría actualizada exitosamente.");
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

//Se invoca el controlador de borrado de Categorías.
function borraCategoria(urlBase,idCategoria){
    if(confirm("¿Desea eliminar la categoría?")){;
        $.ajax({
            url:urlBase+'categorias/eliminarCategoria',
            async:false,
            data:{
                idCategoria:idCategoria
            },
            type:'POST',
            success:function(elimina){
                try{
                    if(elimina !== "false"){
                        if(elimina === "cateprod"){
                            throw "No es posible eliminar. Categoría tiene Productos asociados.";
                        }
                        document.getElementById('categorias').innerHTML = "";
                        document.getElementById('categorias').innerHTML = elimina;
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

//Se invoca el controlador de consulta de Categorias.
function consultaCategoria(urlBase){
    //Se obtienen los valores digitados en el campo de búsqueda.
    var categoria_valor = document.getElementById('categoria-valor').value;
    categoria_valor     = $.trim(categoria_valor);
    $.ajax({
        url:urlBase+'categorias/seleccionarCategoria',
        async:false,
        data:{
            categoria_valor:categoria_valor
        },
        type:'POST',
        success:function(select){
            try{
                if(select !== "false"){
                    document.getElementById('categorias').innerHTML = "";
                    document.getElementById('categorias').innerHTML = select;
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