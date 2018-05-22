<?php
Class Compra extends CI_Model{
    
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
    
    function MaxId_Compra(){
        $this->db->trans_begin();
        $sql =  "SELECT IFNULL(MAX(id_compra) + 1,20160001) id_compra FROM compras";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            foreach($datos as $keyDato=>$dato){
                $id_compra = $datos[$keyDato]['id_compra'];
            }
            return ($id_compra);
        }
        else{
            $id_compra = "20160001";
            return ($id_compra);
        }
    }
    
    function MaxId_Secuencia($id_compra){
        $this->db->trans_begin();
        $sql =  "SELECT IFNULL(MAX(id_movicomp_secuencia) + 1,001) id_movicomp_secuencia FROM movicomp "
                ."WHERE id_movicomp_compra = '$id_compra'";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            foreach($datos as $keyDato=>$dato){
                $id_movicomp_secuencia = $datos[$keyDato]['id_movicomp_secuencia'];
            }
            return ($id_movicomp_secuencia);
        }
        else{
            $id_compra = "001";
            return ($id_compra);
        }
    }
    
    function listaProveedores(){
        $this->db->trans_begin();
        $sql = "SELECT CONCAT(id_proveedor, ' - ', proveedor_nombre) As proveedor "
               . "FROM proveedores "
               . "WHERE proveedor_estado_id = 1 "
               ."ORDER BY proveedor";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $proveedores  = array();
            foreach($datos as $keyDato=>$dato){
                $estadoDatos = $datos[$keyDato]['proveedor'];
                $proveedores[$keyDato] = $estadoDatos;
            }
            return ($proveedores);
        }
        else{
            return false;
        }
    }
    
    function listaIngredientes(){
        $this->db->trans_begin();
        $sql = "SELECT CONCAT(id_ingrediente, ' - ', ingrediente_nombre) As ingrediente "
               . "FROM ingredientes "
               . "WHERE ingrediente_estado_id = 1 "
               ."ORDER BY ingrediente";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $ingredientes  = array();
            foreach($datos as $keyDato=>$dato){
                $ingredienteDatos = $datos[$keyDato]['ingrediente'];
                $ingredientes[$keyDato] = $ingredienteDatos;
            }
            return ($ingredientes);
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
    
    function selCompra($idCompra){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM compras "
               . "WHERE id_compra = '$idCompra'"
                ."ORDER BY id_compra";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
           return(1);
        }
        else{
            return(0);
        }
    }
    
    function selIdCompra($idCompra){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM compras "
               . "WHERE id_compra = '$idCompra'"
                ."ORDER BY id_compra";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return($datos);
        }
        else{
            return (0);
        }
    }
    
    function insCompra($codigoComp,$proveedorCodi,$fechaComp,$estadoCodi,$descriComp){
        $this->db->trans_begin();
        $sql = "INSERT INTO compras(id_compra,compra_proveedor_id,compra_fecha,compra_estado_id,compra_descripcion) "
              ."VALUES ('$codigoComp', '$proveedorCodi', STR_TO_DATE('$fechaComp', '%Y-%m-%d'), '$estadoCodi', '$descriComp')";
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
    
    function selMovicomp($idCompra,$secuencia){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM movicomp "
               . "WHERE id_movicomp_compra = '$idCompra' "
               . "AND id_movicomp_secuencia = '$secuencia'"
                ."ORDER BY id_movicomp_compra,id_movicomp_secuencia";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
           return(1);
        }
        else{
            return(0);
        }
    }
    
    function selMoviOrdeComp($idCompra){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM movicomp "
               . "WHERE id_movicomp_compra = '$idCompra' "
                ."ORDER BY id_movicomp_compra,id_movicomp_secuencia";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $MoviOrdeComp  = array();
            foreach($datos as $dato){
                $MoviCompDatos = $dato['id_movicomp_secuencia'].'|'.$dato['movicomp_ingrediente_id'].'|'.$dato['movicomp_cantidad'].'|'.
                                $dato['movicomp_costo_unit'].'|'.$dato['movicomp_costo_total'].'|'.$dato['movicomp_bodega_id'].'|'.
                                $dato['movicomp_estado_id'].'|';
                
                $MoviOrdeComp[$idCompra.'-'.$dato['id_movicomp_secuencia']]=$MoviCompDatos;
            }
            return ($MoviOrdeComp);
        }
        else{
            return false;
        }
    }
    
    function insMovicomp($idCompraMovi,$secuenciaMovi,$ingredienteCodi,$cantidadMovi,
                         $costoUnitMovi,$costoTotalMovi,$bodegaCodi,$estadoCodi,
                         $personaMovi){
        $this->db->trans_begin();
        $sql = "INSERT INTO movicomp(id_movicomp_compra,id_movicomp_secuencia,movicomp_ingrediente_id,movicomp_cantidad, "
                                     ."movicomp_costo_unit, movicomp_costo_total,movicomp_bodega_id, "
                                     ."movicomp_estado_id,movicomp_persona_id) "
              ."VALUES ('$idCompraMovi','$secuenciaMovi','$ingredienteCodi','$cantidadMovi',"
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
    
    function selIngreBode($bodegaCodi,$ingredienteCodi){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM ingrebodes "
               . "WHERE ingrebode_bodega_id = '$bodegaCodi' "
               . "AND ingrebode_ingrediente_id = '$ingredienteCodi'"
                ."ORDER BY ingrebode_bodega_id,ingrebode_ingrediente_id";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
           return(1);
        }
        else{
            return(0);
        }
    }
    
    function insIngreBode($bodegaCodi,$ingredienteCodi,$cantidadIngreBode,$personaIngreBode){
        $this->db->trans_begin();
        $sql = "INSERT INTO ingrebodes(ingrebode_bodega_id,ingrebode_ingrediente_id,ingrebode_cantidad,"
                                    . "ingrebode_persona_id) "
              ."VALUES ('$bodegaCodi','$ingredienteCodi','$cantidadIngreBode','$personaIngreBode')";
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
    
    function actIngreBode($bodegaCodi,$ingredienteCodi,$cantidadIngreBode,$personaIngreBode){
        $this->db->trans_begin();
        $sql = "UPDATE ingrebodes "
                . "SET ingrebode_cantidad = ingrebode_cantidad + '$cantidadIngreBode' "
              . "WHERE ingrebode_bodega_id = '$bodegaCodi' "
                . "AND ingrebode_ingrediente_id = '$ingredienteCodi'";
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
    
    //Realiza el borrado de un movimiento de compra en la tabla MoviComp.
    function borMovicomp($idCompra,$idSecuencia){
        $this->db->trans_begin();
        $sql = "DELETE FROM movicomp WHERE id_movicomp_compra = '$idCompra' AND id_movicomp_secuencia = '$idSecuencia'";
        $result = mysql_query($sql);
        $movicomp = $this->selMoviOrdeComp($idCompra);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return $movicomp;
        }
    }
    
    function selCompras($valorComp){
        $this->db->trans_begin();
        if(empty($valorComp)){
            $sql = "SELECT * "
                   . "FROM compras "
                   ."ORDER BY id_compra";
        }
        else{
            $sql = "SELECT * "
                   ."FROM compras "
                   ."WHERE id_compra LIKE UPPER('%$valorComp%') "
                   ."OR UPPER(compra_descripcion) LIKE UPPER('%$valorComp%') "
                   ."OR UPPER(compra_proveedor_id) LIKE UPPER('%$valorComp%') "
                   ."ORDER BY id_compra";
        }
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $compras  = array();
            foreach($datos as $dato){
                $CompraDatos = $dato['id_compra'].'|'.$dato['compra_proveedor_id'].'|'.$dato['compra_fecha'].'|'.
                                $dato['compra_costo'].'|'.$dato['compra_descripcion'].'|'.$dato['compra_estado_id'].'|';
                
                $compras[$dato['id_compra']]=$CompraDatos;
            }
            return ($compras);
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
    function selProveedor($id_proveedor){
        $this->db->trans_begin();
        $sql = "SELECT CONCAT(id_proveedor, ' - ', proveedor_nombre) As proveedor "
               . "FROM proveedores "
               . "WHERE id_proveedor = $id_proveedor "
               ."ORDER BY proveedor";
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
    function updCompra($codigoComp,$proveedorCodi,$fechaComp,$costoComp,
                        $estadoCodi,$descripcionComp,$personaClie){
        $this->db->trans_begin();
        $sql = "UPDATE compras "
                . "SET compra_proveedor_id = '$proveedorCodi', "
                    . "compra_fecha = '$fechaComp', "
                    . "compra_descripcion = '$descripcionComp', "
                    . "compra_estado_id = '$estadoCodi' "
               ."WHERE id_compra = '$codigoComp'";
        //echo($sql);
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
    
    //Realiza la eliminación de una compra en la base de datos.
    function delCompra($idCompra){
        $this->db->trans_begin();
        $sql = "DELETE FROM compras "
               ."WHERE id_compra = '$idCompra'";
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
    
    function descProveedor($idProveedor){
        $this->db->trans_begin();
        $sql = "SELECT proveedor_nombre "
               . "FROM proveedores "
              . "WHERE id_proveedor = '$idProveedor' "
               ."ORDER BY proveedor_nombre";
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