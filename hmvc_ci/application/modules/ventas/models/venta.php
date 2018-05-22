<?php
Class Venta extends CI_Model{
    
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
    
    function MaxId_Venta(){
        $this->db->trans_begin();
        $sql =  "SELECT IFNULL(MAX(id_venta) + 1,20170001) id_venta FROM ventas";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            foreach($datos as $keyDato=>$dato){
                $id_venta = $datos[$keyDato]['id_venta'];
            }
            return ($id_venta);
        }
        else{
            $id_venta = "20170001";
            return ($id_venta);
        }
    }
    
    function MaxId_Secuencia($id_venta){
        $this->db->trans_begin();
        $sql =  "SELECT IFNULL(MAX(id_movivent_secuencia) + 1,001) id_movivent_secuencia FROM movivent "
                ."WHERE id_movivent_venta = '$id_venta'";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            foreach($datos as $keyDato=>$dato){
                $id_movivent_secuencia = $datos[$keyDato]['id_movivent_secuencia'];
            }
            return ($id_movivent_secuencia);
        }
        else{
            $id_movivent_secuencia = "001";
            return ($id_movivent_secuencia);
        }
    }
    
    function listaClientes(){
        $this->db->trans_begin();
        $sql = "SELECT CONCAT(id_cliente, ' - ', cliente_nombre) As cliente "
               . "FROM clientes "
               . "WHERE cliente_estado_id = 1 "
               ."ORDER BY cliente";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $clientes  = array();
            foreach($datos as $keyDato=>$dato){
                $estadoDatos = $datos[$keyDato]['cliente'];
                $clientes[$keyDato] = $estadoDatos;
            }
            return ($clientes);
        }
        else{
            return false;
        }
    }
    
    function listaProductos(){
        $this->db->trans_begin();
        $sql = "SELECT CONCAT(id_producto, ' - ', producto_nombre) As producto "
               . "FROM productos "
               . "WHERE producto_estado_id = 1 "
               ."ORDER BY producto";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $productos  = array();
            foreach($datos as $keyDato=>$dato){
                $productoDatos = $datos[$keyDato]['producto'];
                $productos[$keyDato] = $productoDatos;
            }
            return ($productos);
        }
        else{
            return false;
        }
    }
    
    function listaBodegas(){
        $this->db->trans_begin();
        $sql = "SELECT CONCAT(id_bodega, ' - ', bodega_nombre) As bodega "
               . "FROM bodegas "
               . "WHERE bodega_estado_id = 1 "
               ."ORDER BY bodega";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $bodegas  = array();
            foreach($datos as $keyDato=>$dato){
                $bodegaDatos = $datos[$keyDato]['bodega'];
                $bodegas[$keyDato] = $bodegaDatos;
            }
            return ($bodegas);
        }
        else{
            return false;
        }
    }
    
    function selVenta($idVenta){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM ventas "
               . "WHERE id_venta = '$idVenta'"
                ."ORDER BY id_venta";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
           return(1);
        }
        else{
            return(0);
        }
    }
    
    function selIdVenta($idVenta){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM ventas "
               . "WHERE id_venta = '$idVenta'"
                ."ORDER BY id_venta";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return($datos);
        }
        else{
            return (0);
        }
    }
    
    function insVenta($codigoVent,$clienteCodi,$fechaVent,$estadoCodi,$descriVent){
        $this->db->trans_begin();
        $sql = "INSERT INTO ventas(id_venta,venta_cliente_id,venta_fecha,venta_estado_id,venta_descripcion) "
              ."VALUES ('$codigoVent', '$clienteCodi', STR_TO_DATE('$fechaVent', '%Y-%m-%d'), '$estadoCodi', '$descriVent')";
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
    
    function selMovivent($idVenta,$secuencia){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM movivent "
               . "WHERE id_movivent_venta = '$idVenta' "
               . "AND id_movivent_secuencia = '$secuencia'"
                ."ORDER BY id_movivent_venta,id_movivent_secuencia";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
           return(1);
        }
        else{
            return(0);
        }
    }
    
    function selMoviOrdeVent($idVenta){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM movivent "
               . "WHERE id_movivent_venta = '$idVenta' "
                ."ORDER BY id_movivent_venta,id_movivent_secuencia";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $MoviOrdeVent  = array();
            foreach($datos as $dato){
                $MoviVentDatos = $dato['id_movivent_secuencia'].'|'.$dato['movivent_producto_id'].'|'.$dato['movivent_cantidad'].'|'.
                                $dato['movivent_costo_unit'].'|'.$dato['movivent_costo_total'].'|'.$dato['movivent_bodega_id'].'|'.
                                $dato['movivent_estado_id'].'|';
                
                $MoviOrdeVent[$idVenta.'-'.$dato['id_movivent_secuencia']]=$MoviVentDatos;
            }
            return ($MoviOrdeVent);
        }
        else{
            return false;
        }
    }
    
    function insMovivent($idVentaMovi,$secuenciaMovi,$productoCodi,$cantidadMovi,
                         $costoUnitMovi,$costoTotalMovi,$bodegaCodi,$estadoCodi,
                         $personaMovi){
        $this->db->trans_begin();
        $sql = "INSERT INTO movivent(id_movivent_venta,id_movivent_secuencia,movivent_producto_id,movivent_cantidad, "
                                     ."movivent_costo_unit, movivent_costo_total,movivent_bodega_id, "
                                     ."movivent_estado_id,movivent_persona_id) "
              ."VALUES ('$idVentaMovi','$secuenciaMovi','$productoCodi','$cantidadMovi',"
                      ."'$costoUnitMovi','$costoTotalMovi','$bodegaCodi','$estadoCodi',"
                      ."'$personaMovi')";
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
    
    function selIngreBode($idBodega,$idIngred,$cantidad){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM ingrebodes "
               . "WHERE ingrebode_bodega_id = '$idBodega' "
                 . "AND ingrebode_ingrediente_id = '$idIngred' "
                 . "AND ingrebode_cantidad >= '$cantidad' "
                ."ORDER BY ingrebode_bodega_id,ingrebode_ingrediente_id";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
           return(1);
        }
        else{
            return(0);
        }
    }
    
    //Actualiza las cantidades de los ingredientes por bodega por movimientos de venta registrado o borrado.
    function actIngreBode($idBodega,$idIngred,$cantidad,$signo){
        $this->db->trans_begin();
        $sql = "UPDATE ingrebodes "
                . "SET ingrebode_cantidad = ingrebode_cantidad ".$signo." '$cantidad' "
              . "WHERE ingrebode_bodega_id = '$idBodega' "
                . "AND ingrebode_ingrediente_id = '$idIngred'";
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
    
    //Realiza el borrado de un movimiento de compra en la tabla MoviComp.
    function borMovivent($idVenta,$idSecuencia){
        $this->db->trans_begin();
        $sql = "DELETE FROM movivent WHERE id_movivent_venta = '$idVenta' AND id_movivent_secuencia = '$idSecuencia'";
        $result = mysql_query($sql);
        $movivent = $this->selMoviOrdeVent($idVenta);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return $movivent;
        }
    }
    
    function selVentas($valorVent){
        $this->db->trans_begin();
        if(empty($valorVent)){
            $sql = "SELECT * "
                   . "FROM ventas "
                   ."ORDER BY id_venta";
        }
        else{
            $sql = "SELECT * "
                   ."FROM ventas "
                   ."WHERE id_venta LIKE UPPER('%$valorVent%') "
                   ."OR UPPER(venta_descripcion) LIKE UPPER('%$valorVent%') "
                   ."OR UPPER(venta_cliente_id) LIKE UPPER('%$valorVent%') "
                   ."ORDER BY id_venta";
        }
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $ventas  = array();
            foreach($datos as $dato){
                $VentaDatos = $dato['id_venta'].'|'.$dato['venta_cliente_id'].'|'.$dato['venta_fecha'].'|'.
                                $dato['venta_costo'].'|'.$dato['venta_descripcion'].'|'.$dato['venta_estado_id'].'|';
                
                $ventas[$dato['id_venta']]=$VentaDatos;
            }
            return ($ventas);
        }
        else{
            return false;
        }
    }
    
    //Asigna el Estado en el formulario de Actualización de Compras.
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
    
    //Asigna el Estado en el formulario de Actualización de Compras.
    function selCliente($id_cliente){
        $this->db->trans_begin();
        $sql = "SELECT CONCAT(id_cliente, ' - ', cliente_nombre) As cliente "
               . "FROM clientes "
               . "WHERE id_cliente = $id_cliente "
               ."ORDER BY cliente";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    //Realiza la actualización de una compra en la base de datos.
    function updVenta($codigoVent,$clienteCodi,$fechaVent,$costoVent,
                        $estadoCodi,$descripcionVent,$personaClie){
        $this->db->trans_begin();
        $sql = "UPDATE ventas "
                . "SET venta_cliente_id = '$clienteCodi', "
                    . "venta_fecha = '$fechaVent', "
                    . "venta_descripcion = '$descripcionVent', "
                    . "venta_estado_id = '$estadoCodi' "
               ."WHERE id_venta = '$codigoVent'";
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
    
    //Realiza la eliminación de una venta en la base de datos.
    function delVenta($idVenta){
        $this->db->trans_begin();
        $sql = "DELETE FROM ventas "
               ."WHERE id_venta = '$idVenta'";
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
    
    //Selecciona las ingredientes del producto registrado en el movimiento de venta.
    function selIngreProdu($idProducto){
        $this->db->trans_begin();
        $sql = "SELECT * "
                ."FROM ingreprodu "
               ."WHERE ingreprodu_producto_id = $idProducto "
                . "AND ingreprodu_estado_id = 1 "
               ."ORDER BY ingreprodu_producto_id,ingreprodu_ingrediente_id";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $ingreProdu  = array();
            foreach($datos as $dato){
                $ingreProduDatos = $dato['ingreprodu_producto_id'].'|'.$dato['ingreprodu_ingrediente_id'].'|'.
                                $dato['ingreprodu_unidad_id'].'|'.$dato['ingreprodu_cantidad'].'|'.
                                $dato['ingreprodu_fecha_registro'].'|'.$dato['ingreprodu_persona_id'].'|'.
                                $dato['ingreprodu_estado_id'].'|';
                
                $ingreProdu[$dato['ingreprodu_producto_id'].'-'.$dato['ingreprodu_ingrediente_id']]=$ingreProduDatos;
            }
            return ($ingreProdu);
        }
        else{
            return false;
        }
    }
    
    function descEstado($idEstado){
        $this->db->trans_begin();
        $sql = "SELECT estado_descripcion "
               . "FROM estados "
              . "WHERE id_estado = $idEstado "
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
    
    function descCliente($idCliente){
        $this->db->trans_begin();
        $sql = "SELECT cliente_nombre "
               . "FROM clientes "
              . "WHERE id_cliente = $idCliente "
               ."ORDER BY cliente_nombre";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    function descBodega($idBodega){
        $this->db->trans_begin();
        $sql = "SELECT bodega_nombre "
               . "FROM bodegas "
              . "WHERE id_bodega = '$idBodega' "
               ."ORDER BY bodega_nombre";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    function descProducto($idProducto){
        $this->db->trans_begin();
        $sql = "SELECT producto_nombre "
               . "FROM productos "
              . "WHERE id_producto = '$idProducto' "
               ."ORDER BY producto_nombre";
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