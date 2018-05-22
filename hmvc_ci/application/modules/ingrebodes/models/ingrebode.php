<?php
Class IngreBode extends CI_Model{
    
    //Consulta la tabla de ingredientes por bodega a partir de un criterio de búsqueda dado.
    function consIngreBode($valorIngreBode){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM ingrebodes "
               . "WHERE UPPER(ingrebode_bodega_id) LIKE UPPER('%$valorIngreBode%')"
                  . "OR UPPER(ingrebode_ingrediente_id) LIKE UPPER('%$valorIngreBode%')"
                  . "OR UPPER(ingrebode_persona_id) LIKE UPPER('$valorIngreBode')"
                ."ORDER BY ingrebode_bodega_id,ingrebode_ingrediente_id";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $ingrebodes  = array();
            foreach($datos as $dato){
                $ingrebodeDatos = $dato['ingrebode_bodega_id'].'|'.$dato['ingrebode_ingrediente_id'].'|'.
                                    $dato['ingrebode_cantidad'].'|'.$dato['ingrebode_fecha_registro'].'|'.
                                    $dato['ingrebode_persona_id'].'|';
                
                $ingrebodes[$dato['ingrebode_bodega_id']."-".$dato['ingrebode_ingrediente_id']]=$ingrebodeDatos;
            }
            return ($ingrebodes);
        }
        else{
            return false;
        }
    }
    
    function selIngrediente($idIngrediente){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM ingredientes "
               . "WHERE id_ingrediente = '$idIngrediente' "
               ."ORDER BY id_ingrediente";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    function selBodega($idBodega){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM bodegas "
               . "WHERE id_bodega = '$idBodega' "
               ."ORDER BY id_bodega";
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