<?php
Class IngreProdu extends CI_Model{
    function listaProductos(){
        $this->db->trans_begin();
        $sql = "SELECT CONCAT(id_producto, ' - ', producto_nombre) As producto "
               . "FROM productos "
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
    
    function listaIngredientes(){
        $this->db->trans_begin();
        $sql = "SELECT CONCAT(id_ingrediente, ' - ', ingrediente_nombre) As ingrediente "
               . "FROM ingredientes "
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
    
    function insIngreProdu($productoCodi,$ingredienteCodi,$unidadCodi,
                           $cantidadIngreProd,$estadoCodi,$personaIngreProd){
        $this->db->trans_begin();
        $sql = "INSERT INTO ingreprodu (ingreprodu_producto_id,ingreprodu_ingrediente_id,ingreprodu_unidad_id,"
                                    . "ingreprodu_cantidad,ingreprodu_fecha_registro,ingreprodu_persona_id,"
                                    . "ingreprodu_estado_id) "
              ."VALUES ('$productoCodi', '$ingredienteCodi', '$unidadCodi', '$cantidadIngreProd', null, "
                      . "'$personaIngreProd', '$estadoCodi')";
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
    
    function selIngreProdu($productoIngreProd,$ingredienteIngreProd){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM ingreprodu "
               . "WHERE ingreprodu_producto_id = '$productoIngreProd' "
               . "AND ingreprodu_ingrediente_id = '$ingredienteIngreProd' "
                ."ORDER BY ingreprodu_producto_id,ingreprodu_ingrediente_id";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
           return(1);
        }
        else{
            return(0);
        }
    }
}
?>