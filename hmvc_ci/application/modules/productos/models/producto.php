<?php
Class Producto extends CI_Model{
    function listaEstados(){
        $this->db->trans_begin();
        $sql = "SELECT CONCAT(id_estado, ' - ', estado_descripcion) As estado "
               . "FROM estados "
               ."ORDER BY estado";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $estados  = array();
            foreach($datos as $keyDato=>$dato){
                $estadoDatos = $datos[$keyDato]['estado'];
                $estados[$keyDato] = $estadoDatos;
            }
            return ($estados);
        }
        else{
            return false;
        }
    }
    
    function listaUnidades(){
        $this->db->trans_begin();
        $sql = "SELECT CONCAT(id_unidad, ' - ', unidad_nombre) As unidad "
               . "FROM unidades "
               ."ORDER BY unidad";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $unidades  = array();
            foreach($datos as $keyDato=>$dato){
                $unidadDatos = $datos[$keyDato]['unidad'];
                $unidades[$keyDato] = $unidadDatos;
            }
            return ($unidades);
        }
        else{
            return false;
        }
    }
    
    function listaCategorias(){
        $this->db->trans_begin();
        $sql = "SELECT CONCAT(id_categoria, ' - ', categoria_nombre) As categoria "
               . "FROM categorias "
               ."ORDER BY categoria";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $categorias  = array();
            foreach($datos as $keyDato=>$dato){
                $categoriaDatos = $datos[$keyDato]['categoria'];
                $categorias[$keyDato] = $categoriaDatos;
            }
            return ($categorias);
        }
        else{
            return false;
        }
    }
    
    function insProducto($nombreProd,$categoriaCodi,$estadoCodi,$personaProd){
        $this->db->trans_begin();
        $sql = "INSERT INTO productos (producto_nombre,producto_categoria_id,producto_fecha_registro,"
                                    . "producto_persona_id,producto_estado_id) "
              ."VALUES ('$nombreProd', '$categoriaCodi', null, '$personaProd', '$estadoCodi')";
        $result = mysql_query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return $result;
        }
    }
    
    function selProducto($idProducto,$nombreProd){
        $this->db->trans_begin();
        if($idProducto == ""){
            $sql = "SELECT * "
                   . "FROM productos "
                   . "WHERE upper(producto_nombre) = upper('$nombreProd') "
                   ."ORDER BY id_producto";
        }
        else{
            $sql = "SELECT * "
                   . "FROM productos "
                   . "WHERE upper(producto_nombre) = upper('$nombreProd') "
                     . "AND id_producto != '$idProducto' "
                   ."ORDER BY id_producto";
        }
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
           return(1);
        }
        else{
            return(0);
        }
    }
    
    //Consulta la tabla Productos por un criterio de búsqueda dado.
    function consProducto($valorProducto){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM productos "
               . "WHERE id_producto LIKE '%$valorProducto%'"
               . "OR UPPER(producto_nombre) LIKE UPPER('%$valorProducto%')"
               . "OR UPPER(producto_estado_id) LIKE UPPER('%$valorProducto%')"
                ."ORDER BY id_producto";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $productos  = array();
            foreach($datos as $dato){
                $productoDatos = $dato['id_producto'].'|'.$dato['producto_nombre'].'|'.$dato['producto_categoria_id'].'|'.
                                $dato['producto_fecha_registro'].'|'.$dato['producto_persona_id'].'|'.
                                $dato['producto_estado_id'].'|';
                $productos[$dato['id_producto']]=$productoDatos;
            }
            return ($productos);
        }
        else{
            return false;
        }
    }
    
    //Selecciona el producto a actualizar
    function selModiProducto($idProducto){
        $this->db->trans_begin();
        $sql = "SELECT id_producto,producto_nombre,producto_categoria_id,producto_fecha_registro, "
                       ."producto_persona_id,producto_estado_id "
               . "FROM productos "
               . "WHERE id_producto = '$idProducto'"
                ."ORDER BY id_producto";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    //Asigna la Categoria en el formulario de Actualización de Productos.
    function selCategoria($id_categoria){
        $this->db->trans_begin();
        $sql = "SELECT CONCAT(id_categoria, ' - ', categoria_nombre) As categoria "
               . "FROM categorias "
               . "WHERE id_categoria = '$id_categoria' "
               ."ORDER BY categoria";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    //Asigna la Persona en el formulario de Actualización de Productos.
    function selPersona($id_persona){
        $this->db->trans_begin();
        $sql = "SELECT CONCAT(id_persona, ' - ', persona_nombre) As persona "
               . "FROM personas "
               . "WHERE id_persona = '$id_persona' "
               ."ORDER BY persona";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    //Asigna el Estado en el formulario de Actualización de Productos.
    function selEstado($id_estado){
        $this->db->trans_begin();
        $sql = "SELECT CONCAT(id_estado, ' - ', estado_descripcion) As estado "
               . "FROM estados "
               . "WHERE id_estado = $id_estado "
               ."ORDER BY estado";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    //Asigna el Estado en el formulario de Actualización de Productos.
    function selUnidad($id_unidad){
        $this->db->trans_begin();
        $sql = "SELECT CONCAT(id_unidad, ' - ', unidad_nombre) As unidad "
               . "FROM unidades "
               . "WHERE id_unidad = '$id_unidad' "
               ."ORDER BY unidad";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    //Realiza la actualización de un producto en la base de datos.
    function updProducto($idProducto,$nombreProd,$categoriaCodi,$estadoCodi){
        $this->db->trans_begin();
        $sql = "UPDATE productos "
                . "SET producto_nombre = '$nombreProd', "
                    . "producto_categoria_id = '$categoriaCodi', "
                    . "producto_estado_id = '$estadoCodi' "
               ."WHERE id_producto = '$idProducto'";
        $result = mysql_query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return $result;
        }
    }
    
    //Realiza el borrado de un producto en la tabla Productos.
    function borProducto($idProducto){
        $this->db->trans_begin();
        $sql = "DELETE FROM productos WHERE id_producto = '$idProducto'";
        $result = mysql_query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            $productos = $this->consProducto("");
            return $productos;
        }
    }
    
    function selMoveProd($idProducto){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM movivent "
               . "WHERE movivent_producto_id = '$idProducto' "
                ."ORDER BY id_movivent_venta,id_movivent_secuencia";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
           return(1);
        }
        else{
            return(0);
        }
    }
    
    function selIngrProd($idProducto){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM ingreprodu "
               . "WHERE ingreprodu_producto_id = '$idProducto' "
                ."ORDER BY ingreprodu_producto_id,ingreprodu_ingrediente_id";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
           return(1);
        }
        else{
            return(0);
        }
    }
    
    
    //Consulta la tabla Productos por un criterio de búsqueda dado.
    function consIngreProdu($idProducto,$valor){
        $this->db->trans_begin();
        if($valor === ""){
            $sql = "SELECT * "
                   . "FROM ingreprodu "
                   . "WHERE ingreprodu_producto_id = '$idProducto'"
                    ."ORDER BY ingreprodu_producto_id,ingreprodu_ingrediente_id";
        }
        else{
            $sql = "SELECT * "
                   . "FROM ingreprodu "
                   . "WHERE ingreprodu_producto_id = '$idProducto' "
                     . "AND (UPPER(ingreprodu_ingrediente_id) LIKE UPPER('%$valor%') "
                            ."OR UPPER(ingreprodu_unidad_id) LIKE UPPER('%$valor%')) "
                    ."ORDER BY ingreprodu_producto_id,ingreprodu_ingrediente_id";
        }
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $ingreprodu  = array();
            foreach($datos as $dato){
                $ingreproduDatos = $dato['ingreprodu_producto_id'].'|'.$dato['ingreprodu_ingrediente_id'].'|'.
                                 $dato['ingreprodu_unidad_id'].'|'.$dato['ingreprodu_cantidad'].'|'.
                                 $dato['ingreprodu_fecha_registro'].'|'.$dato['ingreprodu_persona_id'].'|'.
                                 $dato['ingreprodu_estado_id'].'|';
                $ingreprodu[$dato['ingreprodu_producto_id']."-".$dato['ingreprodu_ingrediente_id']]=$ingreproduDatos;
            }
            return ($ingreprodu);
        }
        else{
            return false;
        }
    }
    
    
    //Selecciona la composición del producto a actualizar
    function selModiIngreProdu($idProducto,$idIngrediente){
        $this->db->trans_begin();
        $sql = "SELECT ingreprodu_producto_id,ingreprodu_ingrediente_id,ingreprodu_unidad_id,ingreprodu_cantidad, "
                       ."ingreprodu_fecha_registro,ingreprodu_persona_id,ingreprodu_estado_id "
               . "FROM ingreprodu "
               . "WHERE ingreprodu_producto_id = '$idProducto'"
                 . "AND ingreprodu_ingrediente_id = '$idIngrediente'"
                ."ORDER BY ingreprodu_producto_id,ingreprodu_ingrediente_id";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    //Realiza la actualización de un producto en la base de datos.
    function updIngreProdu($idProducto,$idIngrediente,$unidadCodi,$cantidadIngreProd,$estadoCodi){
        $this->db->trans_begin();
        $sql = "UPDATE ingreprodu "
                . "SET ingreprodu_unidad_id = '$unidadCodi', "
                    . "ingreprodu_cantidad = '$cantidadIngreProd', "
                    . "ingreprodu_estado_id = '$estadoCodi' "
               ."WHERE ingreprodu_producto_id = '$idProducto' "
                 ."AND ingreprodu_ingrediente_id = '$idIngrediente'";
        $result = mysql_query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }
    
    //Realiza el borrado de un producto en la tabla Productos.
    function borIngreProdu($idProducto,$idIngrediente){
        $this->db->trans_begin();
        $sql = "DELETE ".
                 "FROM ingreprodu ".
                "WHERE ingreprodu_producto_id = '$idProducto' ".
                  "AND ingreprodu_ingrediente_id = '$idIngrediente'";
        $result = mysql_query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            $ingreprodu = $this->consIngreProdu($idProducto,"");
            return $ingreprodu;
        }
    }
    
    function descEstado($idEstado){
        $this->db->trans_begin();
        $sql = "SELECT estado_descripcion "
               . "FROM estados "
              . "WHERE id_estado = '$idEstado' "
               ."ORDER BY estado_descripcion";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    function descCategoria($idCategoria){
        $this->db->trans_begin();
        $sql = "SELECT categoria_nombre "
               . "FROM categorias "
              . "WHERE id_categoria = '$idCategoria' "
               ."ORDER BY categoria_nombre";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    function descUnidad($idUnidad){
        $this->db->trans_begin();
        $sql = "SELECT unidad_nombre "
               . "FROM unidades "
              . "WHERE id_unidad = '$idUnidad' "
               ."ORDER BY unidad_nombre";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    function descIngrediente($idIngrediente){
        $this->db->trans_begin();
        $sql = "SELECT ingrediente_nombre "
               . "FROM ingredientes "
              . "WHERE id_ingrediente = '$idIngrediente' "
               ."ORDER BY ingrediente_nombre";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
}
?>