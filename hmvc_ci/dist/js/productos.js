function insertaProducto(urlBase){
    //Se obtienen los valores digitados en el formulario.
    var nombre_producto    = document.getElementById('producto-nombre').value;
    var categoria_producto = document.getElementById('producto-categoria').value;
    var categoria_idx      = document.getElementById('producto-categoria').selectedIndex;
    var estado_producto    = document.getElementById('producto-estado').value;
    var estado_idx         = document.getElementById('producto-estado').selectedIndex;
    //Se eliminan espacios en blanco al inicio y al final de los valores ingresados.
    nombre_producto    = $.trim(nombre_producto);
    nombre_producto    = nombre_producto.toUpperCase();
    categoria_producto = $.trim(categoria_producto);
    estado_producto    = $.trim(estado_producto);
    //Se realizan las validaciones sobre los campos ingresados.
    try{
        if(nombre_producto === null || nombre_producto.length === 0 || /^\s+$/.test(nombre_producto) ) {
            throw "El campo Nombre del Producto es obligatorio.";
        }
        if(categoria_idx === null) {
            throw "Debe seleccionar una Categoría de la lista";
        }
        if(estado_idx === null){
            throw "Debe seleccionar un Estado de la lista.";
        }
        $.ajax({
            url:urlBase+'productos/obtenerProducto',
            async:false,
            data:{
                idProducto:"",
                nombreProd:nombre_producto
            },
            type:'POST',
            success:function(result){
                try{
                    if(result === "false"){
                        throw "El Producto ya existe.";
                    }
                    else{
                        $.ajax({
                            url:urlBase+'productos/guardarProducto',
                            async:false,
                            data:{
                                nombreProd:nombre_producto,
                                categoriaProd:categoria_producto,
                                estadoProd:estado_producto
                            },
                            type:'POST',
                            success:function(insert){
                                try{
                                    if(insert !== "true"){
                                        throw "Falló el registro del Producto.";
                                    }
                                    if(insert === "true"){
                                        alert("Producto almacenado exitosamente.");
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

//Se invoca el controlador de modificación de Productos para cargar el formulario de modificación.
function modificaProducto(urlBase,idProducto){
    $.ajax({
        url:urlBase+'productos/modificarProducto',
        async:false,
        data:{
            idProducto:idProducto
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

//Se invoca el controlador de actualización de Producto.
function actualizaProducto(urlBase){
    //Se obtienen los valores digitados en el formulario.
    var id_producto    = document.getElementById('id-producto').value;
    var nombre_producto    = document.getElementById('producto-nombre').value;
    var categoria_producto = document.getElementById('producto-categoria').value;
    var categoria_idx      = document.getElementById('producto-categoria').selectedIndex;
    var estado_producto    = document.getElementById('producto-estado').value;
    var estado_idx         = document.getElementById('producto-estado').selectedIndex;
    //Se eliminan espacios en blanco al inicio y al final de los valores ingresados.
    id_producto    = $.trim(id_producto);
    nombre_producto    = $.trim(nombre_producto);
    nombre_producto    = nombre_producto.toUpperCase();
    categoria_producto = $.trim(categoria_producto);
    estado_producto    = $.trim(estado_producto);
    //Se realizan las validaciones sobre los campos ingresados.
    try{
        if(nombre_producto === null || nombre_producto.length === 0 || /^\s+$/.test(nombre_producto) ) {
            throw "El campo Nombre del Producto es obligatorio.";
        }
        if(categoria_idx === null) {
            throw "Debe seleccionar una Categoría de la lista";
        }
        if(estado_idx === null){
            throw "Debe seleccionar un Estado de la lista.";
        }
        
        $.ajax({
            url:urlBase+'productos/obtenerProducto',
            async:false,
            data:{
                idProducto:id_producto,
                nombreProd:nombre_producto
            },
            type:'POST',
            success:function(result){
                try{
                    if(result === "false"){
                        throw "El Producto ya existe.";
                    }
                    else{
                        if(result === "true"){
                            $.ajax({
                                url:urlBase+'productos/actualizarProducto',
                                async:false,
                                data:{
                                    idProd:id_producto,
                                    nombreProd:nombre_producto,
                                    categoriaProd:categoria_producto,
                                    estadoProd:estado_producto
                                },
                                type:'POST',
                                success:function(insert){
                                    try{
                                        if(insert !== "true"){
                                            throw "Falló la actualización del Producto";
                                        }
                                        if(insert === "true"){
                                            alert("Producto actualizado exitosamente.");
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

//Se invoca el controlador de borrado de Productos.
function borraProducto(urlBase,idProducto){
    if(confirm("¿Desea eliminar el producto?")){;
        $.ajax({
            url:urlBase+'productos/eliminarProducto',
            async:false,
            data:{
                idProducto:idProducto
            },
            type:'POST',
            success:function(elimina){
                try{
                    if(elimina !== "false"){
                        if(elimina === "movivent"){
                            throw "No es posible eliminar. Producto tiene Movimientos de Venta asociados.";
                        }
                        else{
                            if(elimina === "ingreprodu"){
                                throw "No es posible eliminar. Producto tiene Ingredientes asociados.";
                            }
                            else{
                                document.getElementById('productos').innerHTML = "";
                                document.getElementById('productos').innerHTML = elimina;
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

//Se invoca el controlador de consulta de Productos.
function consultaProducto(urlBase){
    //Se obtienen los valores digitados en el campo de búsqueda.
    var producto_valor = document.getElementById('producto-valor').value;
    producto_valor     = $.trim(producto_valor);
    $.ajax({
        url:urlBase+'productos/seleccionarProducto',
        async:false,
        data:{
            producto_valor:producto_valor
        },
        type:'POST',
        success:function(select){
            try{
                if(select !== "false"){
                    document.getElementById('productos').innerHTML = "";
                    document.getElementById('productos').innerHTML = select;
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

//Se invoca el controlador de modificación de Productos para cargar el formulario de modificación.
function modificaIngreProdu(urlBase,idProducto,idIngrediente){
    $.ajax({
        url:urlBase+'productos/modificarIngreProdu',
        async:false,
        data:{
            idProducto:idProducto,
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

//Se invoca el controlador de actualización de Producto.
function actualizaIngreProdu(urlBase){
    //Se obtienen los valores digitados en el formulario.
    var idProducto      = document.getElementById('ingreprodu-producto').value;
    var idIngrediente   = document.getElementById('ingreprodu-ingrediente').value;
    var idUnidad        = document.getElementById('ingreprodu-unidad').value;
    var unidad_idx      = document.getElementById('ingreprodu-unidad').selectedIndex;
    var cantidad        = document.getElementById('ingreprodu-cantidad').value;
    var estado          = document.getElementById('ingreprodu-estado').value;
    var estado_idx      = document.getElementById('ingreprodu-estado').selectedIndex;
    //Se eliminan espacios en blanco al inicio y al final de los valores ingresados.
    idProducto    = $.trim(idProducto);
    idIngrediente = $.trim(idIngrediente);
    idUnidad      = $.trim(idUnidad);
    cantidad      = $.trim(cantidad);
    estado        = $.trim(estado);
    //Se realizan las validaciones sobre los campos ingresados.
    try{
        if(unidad_idx === null) {
            throw "Debe seleccionar una Unidad de la lista";
        }
        if(cantidad === null || cantidad.length === 0 || /^\s+$/.test(cantidad) ) {
            throw "El campo Cantidad es obligatorio.";
        }
        if(estado_idx === null){
            throw "Debe seleccionar un Estado de la lista.";
        }
        
        $.ajax({
            url:urlBase+'productos/actualizarIngreProdu',
            async:false,
            data:{
                idProducto:idProducto,
                idIngrediente:idIngrediente,
                idUnidad:idUnidad,
                cantidad:cantidad,
                estado:estado
            },
            type:'POST',
            success:function(insert){
                try{
                    if(insert !== "true"){
                        throw "Falló la actualización de la composición del Producto.";
                    }
                    if(insert === "true"){
                        alert("Composición de Producto actualizada exitosamente.");
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

//Se invoca el controlador de borrado de Productos.
function borraIngreProdu(urlBase,idProducto,idIngrediente){
    if(confirm("¿Desea eliminar la Composición del producto?")){;
        $.ajax({
            url:urlBase+'productos/eliminarIngreProdu',
            async:false,
            data:{
                idProducto:idProducto,
                idIngrediente:idIngrediente
            },
            type:'POST',
            success:function(elimina){
                try{
                    if(elimina !== "false"){
                        document.getElementById('ingreprodu').innerHTML = "";
                        document.getElementById('ingreprodu').innerHTML = elimina;
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

//Se invoca el controlador de consulta de Ingredientes por Productos.
function consultaIngreProdu(urlBase){
    //Se obtienen los valores digitados en el campo de búsqueda.
    var idProducto       = document.getElementById('id-producto').value;
    var ingreprodu_valor = document.getElementById('ingreprodu-valor').value;
    idProducto           = $.trim(idProducto);
    ingreprodu_valor     = $.trim(ingreprodu_valor);
    $.ajax({
        url:urlBase+'productos/seleccionarIngreProdu',
        async:false,
        data:{
            idProducto:idProducto,
            ingreprodu_valor:ingreprodu_valor
        },
        type:'POST',
        success:function(select){
            try{
                if(select !== "false"){
                    document.getElementById('ingreprodu').innerHTML = "";
                    document.getElementById('ingreprodu').innerHTML = select;
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