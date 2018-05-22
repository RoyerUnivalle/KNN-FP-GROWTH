<?php
Class Menu extends CI_Model{
    
    function contenidoMenu($perfil){
        $this->db->trans_begin();
        $sql = "SELECT id_perfil,perfil_nombre,submodulo_modulo_id,modulo_nombre,"
                    . "opcion_submodulo_id,submodulo_nombre,opciperf_opcion_id,"
                    . "opcion_nombre,opcion_metodo "
               . "FROM PERFILES,OPCIPERF,OPCIONES,SUBMODULOS,MODULOS "
              . "WHERE id_perfil = '$perfil' "
                . "AND perfil_estado_id = 1 "
                . "AND opciperf_perfil_id = id_perfil "
                . "AND opciperf_estado_id = 1 "
                . "AND id_opcion = opciperf_opcion_id "
                . "AND opcion_estado_id = 1 "
                . "AND id_submodulo = opcion_submodulo_id "
                . "AND submodulo_estado_id = 1 "
                . "AND id_modulo = submodulo_modulo_id "
                . "AND modulo_estado_id = 1 "
               ."ORDER BY id_perfil,submodulo_modulo_id,opcion_submodulo_id,opciperf_opcion_id";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $opciones  = array();
            foreach($datos as $dato){
                $moduloDatos = $dato['submodulo_modulo_id'].'|'.$dato['modulo_nombre'];
                $submoduloDatos = $dato['opcion_submodulo_id'].'|'.$dato['submodulo_nombre'];
                $opcionDatos = $moduloDatos.'|'.$submoduloDatos.'|'.$dato['opciperf_opcion_id'].'|'.$dato['opcion_nombre'].'|'.$dato['opcion_metodo'].'|';
                $opciones[$dato['submodulo_modulo_id']][$dato['opcion_submodulo_id']][$dato['opciperf_opcion_id']]=$opcionDatos;
            }
            return ($opciones);
        }
        else{
            return false;
        }
    }
    
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
    
    function datosCompra(){
        $this->db->trans_begin();
        $sql = "SELECT COUNT(id_compra) cantidad_compras, SUM(compra_costo) costo_compras "
                ."FROM compras "
               ."WHERE compra_fecha BETWEEN DATE_FORMAT(compra_fecha,'%Y-%m-01') AND LAST_DAY(compra_fecha)";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    function datosVenta(){
        $this->db->trans_begin();
        $sql = "SELECT COUNT(id_venta) cantidad_ventas, SUM(venta_costo) costo_ventas "
                ."FROM ventas "
               ."WHERE venta_fecha BETWEEN DATE_FORMAT(venta_fecha,'%Y-%m-01') AND LAST_DAY(venta_fecha)";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    function cantidadProveedoresMes(){
        $this->db->trans_begin();
        $sql = "SELECT COUNT(*) cantidad_proveedores "
                ."FROM proveedores "
               ."WHERE DATE_FORMAT(proveedor_fecha_registro,'%Y-%m-%d') "
                     ."BETWEEN DATE_FORMAT(CURDATE(),'%Y-%m-01') AND DATE_FORMAT(LAST_DAY(CURDATE()),'%Y-%m-%d') ";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    function cantidadClientesMes(){
        $this->db->trans_begin();
        $sql = "SELECT COUNT(*) cantidad_clientes "
                ."FROM clientes "
               ."WHERE DATE_FORMAT(cliente_fecha_registro,'%Y-%m-%d') "
                     ."BETWEEN DATE_FORMAT(CURDATE(),'%Y-%m-01') AND DATE_FORMAT(LAST_DAY(CURDATE()),'%Y-%m-%d') ";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    function maxProductoMes(){
        $this->db->trans_begin();
        $sql = "SELECT t.movivent_producto_id,MAX(t.cantimovi) as cantidad "
                ."FROM (SELECT movivent_producto_id,SUM(movivent_cantidad) cantimovi "
                        ."FROM movivent "
                       ."WHERE EXISTS(SELECT 'X' "
                                      ."FROM ventas "
                                     ."WHERE venta_fecha BETWEEN DATE_FORMAT(venta_fecha,'%Y-%m-01') "
                                             ."AND LAST_DAY(venta_fecha) "
                                       ."AND id_venta = id_movivent_venta) "
                       ."GROUP BY movivent_producto_id) t";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    function selProducto($id_producto){
        $this->db->trans_begin();
        $sql = "SELECT * "
                ."FROM productos "
               ."WHERE id_producto = '$id_producto'";
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