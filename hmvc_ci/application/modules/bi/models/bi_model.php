<?php
Class Bi_Model extends CI_Model{
    

    /************************INICIA SINCRONIZACIÓN DATAMART********************/
    
    //Se obtiene la última fecha de sincronización.
    function ultiSincroniza(){
        $this->db->trans_begin();
        $sql = "SELECT IFNULL(MAX(sincron_dw_fecha_registro),'No se ha realizado sincronización de datos') ULTISINC "
                ."FROM sincron_dw "
               ."WHERE sincron_dw_completa = 1";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    //Se obtienen los datos a sincronizar
    function tablas_campos(){
        $this->db->trans_begin();
        $sql = "SELECT CONCAT('SELECT ',GROUP_CONCAT(campo_dw_nombre SEPARATOR ','),' FROM ',tabla_dw_nombre) AS campos "
              ."FROM campos_dw,tablas_dw "
              ."WHERE campo_tabla_dw_id = id_tabla_dw "
              ."GROUP BY id_tabla_dw";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    function selDatosSincron($sql){
        $this->db->trans_begin();
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    function insDatosSincron($insertArray){
        $db_siatoddw = $this->load->database('siatoddw', TRUE);
        $db_siatoddw->trans_begin();
        //Se recorre el arreglo con los insert a ejecutar.
        foreach ($insertArray as $keyIns=>$insert){
            $result = mysql_query($insert);
        }
        
        if ($db_siatoddw->trans_status() === FALSE){
            $db_siatoddw>trans_rollback();
            return false;
        }
        else{
            $db_siatoddw->trans_commit();
            return true;
        }
    }
    
    function insSincron_Dw($sincronCompleta){
        $db_siatod = $this->load->database('default', TRUE);
        $db_siatod->trans_begin();
        $idUsuario = $this->session->userdata('id');
        $idPersona = $this->session->userdata('idPers');
        $sql = "INSERT INTO sincron_dw(sincron_dw_usuario_id,sincron_dw_persona_id,"
                                      ."sincron_dw_completa) "
                . "VALUES('$idUsuario','$idPersona',$sincronCompleta)";
        $result = mysql_query($sql);
        
        if ($db_siatod->trans_status() === FALSE){
            $db_siatod>trans_rollback();
            return false;
        }
        else{
            $db_siatod->trans_commit();
            return true;
        }
    }
    /***********************FINALIZA SINCRONIZACIÓN DATAMART*******************/
    
    //Consulta la tabla Clientes por un criterio de búsqueda dado.
    function consClieVent($fechaInic,$fechaFina,$cliente){
        $db_siatoddw = $this->load->database('siatoddw', TRUE);
        $db_siatoddw->trans_begin();
        if($fechaInic !== "" && $fechaFina !== ""){
            $sql = "SELECT * "
                   . "FROM factventas "
                  . "WHERE venta_fecha BETWEEN STR_TO_DATE('$fechaInic','%Y-%m-%d') AND STR_TO_DATE('$fechaFina','%Y-%m-%d') "
                   ."ORDER BY id_venta";
        }
        else{
            $sql = "SELECT * "
                   . "FROM factventas "
                  . "WHERE venta_cliente_id = '$cliente' "
                   ."ORDER BY id_venta";
        }
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $ventas  = array();
            foreach($datos as $dato){
                $venta = array($dato['venta_cliente_id']=>$dato['venta_cliente_id']);
                $ventas[$dato['id_venta']] = $venta;
            }
            return ($ventas);
        }
        else{
            return false;
        }
    }
    
    function datosCliente($idCliente){
        $db_siatod = $this->load->database('default', TRUE);
        $db_siatod->trans_begin();
        $sql = "SELECT * "
               . "FROM clientes "
              . "WHERE id_cliente = '$idCliente' "
               ."ORDER BY cliente_nombre";
        $datosSql = $db_siatod->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    function descGenero($idGenero){
        $db_siatod = $this->load->database('default', TRUE);
        $db_siatod->trans_begin();
        $sql = "SELECT * "
               . "FROM generos "
              . "WHERE id_genero = '$idGenero' "
               ."ORDER BY genero_descripcion";
        $datosSql = $db_siatod->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    function descCiudad($idCiudad){
        $db_siatod = $this->load->database('default', TRUE);
        $db_siatod->trans_begin();
        $sql = "SELECT * "
               . "FROM ciudades "
              . "WHERE id_ciudad = '$idCiudad' "
               ."ORDER BY ciudad_nombre";
        $datosSql = $db_siatod->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    //Consulta los productos comprados por el cliente.
    function consProdClie($idCliente){
        $db_siatoddw = $this->load->database('siatoddw', TRUE);
        $db_siatoddw->trans_begin();
        $sql = "SELECT * ".
                 "FROM factventas,dimmovivent ".
                "WHERE venta_cliente_id = '$idCliente' ".
                  "AND id_movivent_venta = id_venta";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $productos  = array();
            foreach($datos as $dato){
                $producto = array($dato['movivent_producto_id']=>$dato['movivent_producto_id']);
                $productos[$dato['id_venta'].'-'.$dato['id_movivent_secuencia']] = $producto;
            }
            return ($productos);
        }
        else{
            return false;
        }
    }
    
    //Selecciona la categoría de un producto
    function selCateProd($idProducto){
        $db_siatod = $this->load->database('siatoddw', TRUE);
        $db_siatod->trans_begin();
        $sql = "SELECT producto_categoria_id "
               . "FROM dimproductos "
              . "WHERE id_producto = '$idProducto' "
               ."ORDER BY id_producto";
        $datosSql = $db_siatod->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    //Selecciona los productos de una categoría
    function selProdCate($idCategoria,$idProdRefe){
        $db_siatod = $this->load->database('default', TRUE);
        $db_siatod->trans_begin();
        $sql = "SELECT id_producto "
               . "FROM productos "
              . "WHERE producto_categoria_id = '$idCategoria' "
                . "AND id_producto != '$idProdRefe' "
               ."ORDER BY id_producto";
        $datosSql = $db_siatod->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    //Selecciona los productos de una categoría
    function selIngrProd($idProducto){
        $db_siatod = $this->load->database('default', TRUE);
        $db_siatod->trans_begin();
        $sql = "SELECT ingreprodu_ingrediente_id "
               . "FROM ingreprodu "
              . "WHERE ingreprodu_producto_id = '$idProducto' "
               ."ORDER BY ingreprodu_ingrediente_id";
        $datosSql = $db_siatod->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    function descProducto($idProducto){
        $db_siatod = $this->load->database('default', TRUE);
        $db_siatod->trans_begin();
        $sql = "SELECT * "
               . "FROM productos "
              . "WHERE id_producto = '$idProducto' "
               ."ORDER BY producto_nombre";
        $datosSql = $db_siatod->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    function descCategoria($idCategoria){
        $db_siatod = $this->load->database('default', TRUE);
        $db_siatod->trans_begin();
        $sql = "SELECT * "
               . "FROM categorias "
              . "WHERE id_categoria = '$idCategoria' "
               ."ORDER BY categoria_nombre";
        $datosSql = $db_siatod->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    function listaClientes(){
        $db_siatod = $this->load->database('default', TRUE);
        $sql = "SELECT CONCAT(id_cliente, ' - ', cliente_nombre) As cliente "
               . "FROM clientes "
               . "WHERE cliente_estado_id = 1 "
               ."ORDER BY cliente";
        $datosSql = $db_siatod->query($sql);
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
    
    function listaProveedores(){
        $db_siatod = $this->load->database('default', TRUE);
        $sql = "SELECT CONCAT(id_proveedor, ' - ', proveedor_nombre) As proveedor "
               . "FROM proveedores "
               . "WHERE proveedor_estado_id = 1 "
               ."ORDER BY proveedor";
        $datosSql = $db_siatod->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $proveedores  = array();
            foreach($datos as $keyDato=>$dato){
                $proveedor = $datos[$keyDato]['proveedor'];
                $proveedores[$keyDato] = $proveedor;
            }
            return ($proveedores);
        }
        else{
            return false;
        }
    }
    
    function datosProveedor($idProveedor){
        $db_siatod = $this->load->database('default', TRUE);
        $db_siatod->trans_begin();
        $sql = "SELECT * "
               . "FROM proveedores "
              . "WHERE id_proveedor = '$idProveedor' "
               ."ORDER BY proveedor_nombre";
        $datosSql = $db_siatod->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    //Consulta los ingredientes vendidos por el proveedor.
    function consIngrProv($idProveedor){
        $db_siatoddw = $this->load->database('siatoddw', TRUE);
        $db_siatoddw->trans_begin();
        $sql = "SELECT * ".
                 "FROM factcompras,dimmovicomp ".
                "WHERE compra_proveedor_id = '$idProveedor' ".
                  "AND id_movicomp_compra = id_compra";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $ingredientes  = array();
            foreach($datos as $dato){
                $ingrediente = array($dato['movicomp_ingrediente_id']=>$dato['movicomp_ingrediente_id']);
                $ingredientes[$dato['id_compra'].'-'.$dato['id_movicomp_secuencia']] = $ingrediente;
            }
            return ($ingredientes);
        }
        else{
            return false;
        }
    }
    
    
    function consProvComp($fechaInic,$fechaFina,$idProveedor){
        $db_siatoddw = $this->load->database('siatoddw', TRUE);
        $db_siatoddw->trans_begin();
        if($fechaInic !== "" && $fechaFina !== ""){
            $sql = "SELECT * "
                   . "FROM factcompras "
                  . "WHERE compra_fecha BETWEEN STR_TO_DATE('$fechaInic','%Y-%m-%d') AND STR_TO_DATE('$fechaFina','%Y-%m-%d') "
                   ."ORDER BY id_compra";
        }
        else{
            $sql = "SELECT * "
                   . "FROM factcompras "
                  . "WHERE compra_proveedor_id = '$idProveedor' "
                   ."ORDER BY id_compra";
        }
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $compras  = array();
            foreach($datos as $dato){
                $compra = array($dato['compra_proveedor_id']=>$dato['compra_proveedor_id']);
                $compras[$dato['id_compra']] = $compra;
            }
            return ($compras);
        }
        else{
            return false;
        }
    }
    
    function descIngrediente($idIngrediente){
        $db_siatod = $this->load->database('default', TRUE);
        $db_siatod->trans_begin();
        $sql = "SELECT * "
               . "FROM ingredientes "
              . "WHERE id_ingrediente = '$idIngrediente' "
               ."ORDER BY ingrediente_nombre";
        $datosSql = $db_siatod->query($sql);
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