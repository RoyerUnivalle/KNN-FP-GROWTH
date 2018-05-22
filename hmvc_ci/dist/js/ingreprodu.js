function insertaIngreProdu(urlBase){
    //Se obtienen los valores digitados en el formulario.
    var producto_ingreprodu    = document.getElementById('ingreprodu-producto').value;
    var producto_idx           = document.getElementById('ingreprodu-producto').selectedIndex;
    var ingrediente_ingreprodu = document.getElementById('ingreprodu-ingrediente').value;
    var ingrediente_idx        = document.getElementById('ingreprodu-ingrediente').selectedIndex;
    var unidad_ingreprodu      = document.getElementById('ingreprodu-unidad').value;
    var unidad_idx             = document.getElementById('ingreprodu-unidad').selectedIndex;
    var cantidad_ingreprodu    = document.getElementById('ingreprodu-cantidad').value;
    var estado_ingreprodu      = document.getElementById('ingreprodu-estado').value;
    var estado_idx             = document.getElementById('ingreprodu-estado').selectedIndex;
    
    //Se eliminan espacios en blanco al inicio y al final de los valores ingresados.
    producto_ingreprodu    = $.trim(producto_ingreprodu);
    ingrediente_ingreprodu = $.trim(ingrediente_ingreprodu);
    unidad_ingreprodu      = $.trim(unidad_ingreprodu);
    cantidad_ingreprodu    = $.trim(cantidad_ingreprodu);
    estado_ingreprodu      = $.trim(estado_ingreprodu);
    //Se realizan las validaciones sobre los campos ingresados.
    try{
        if(producto_idx === null) {
            throw "Debe seleccionar un Producto de la lista";
        }
        if(ingrediente_idx === null) {
            throw "Debe seleccionar un Ingrediente de la lista";
        }
        if(unidad_idx === null) {
            throw "Debe seleccionar una Unidad de la lista";
        }
        if(cantidad_ingreprodu === null || cantidad_ingreprodu.length === 0 || /^\s+$/.test(cantidad_ingreprodu) ) {
            throw "El campo Cantidad es obligatorio.";
        }
        if(estado_idx === null){
            throw "Debe seleccionar un Estado de la lista.";
        }
        $.ajax({
            url:urlBase+'ingreprodus/obtenerIngreProdu',
            async:false,
            data:{
                productoIngreProd:producto_ingreprodu,
                ingredienteIngreProd:ingrediente_ingreprodu
            },
            type:'POST',
            success:function(result){
                try{
                    if(result === 1){
                        throw "La composición del Producto ya existe.";
                    }
                    else{
                        $.ajax({
                            url:urlBase+'ingreprodus/guardarIngreProdu',
                            async:false,
                            data:{
                                productoIngreProd:producto_ingreprodu,
                                ingredienteIngreProd:ingrediente_ingreprodu,
                                unidadIngreProd:unidad_ingreprodu,
                                cantidadIngreProd:cantidad_ingreprodu,
                                estadoIngreProd:estado_ingreprodu
                            },
                            type:'POST',
                            success:function(insert){
                                try{
                                    if(insert !== "true"){
                                        throw "Falló el registro de la composición del Producto.";
                                    }
                                    if(insert === "true"){
                                        alert("Composición de Producto almacenada exitosamente.");
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