<?php
Class Movitrasl extends CI_Model{
    
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
    
    function insMovitras($bodefuenCodi,$bodedestCodi,$ingredienteCodi,$cantidadMovi,$observacion,$personaMovi){
        $this->db->trans_begin();
        $sql = "INSERT INTO movitras(movitras_bodefuen_id,movitras_bodedest_id,movitras_ingrediente_id,"
                                  . "movitras_cantidad,movitras_observacion,movitras_persona_id) "
              ."VALUES ('$bodefuenCodi','$bodedestCodi','$ingredienteCodi','$cantidadMovi','$observacion','$personaMovi')";
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
        $sql = "SELECT IFNULL(ingrebode_cantidad,0) AS cantidad "
               . "FROM ingrebodes "
               . "WHERE ingrebode_bodega_id = '$bodegaCodi' "
               . "AND ingrebode_ingrediente_id = '$ingredienteCodi'"
                ."ORDER BY ingrebode_bodega_id,ingrebode_ingrediente_id";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $ingrebodeCantidad = $datos[0]['cantidad'];
            return ($ingrebodeCantidad);
        }
        else{
            return(-1);
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
    
    function actIngreBofu($bodegaCodi,$ingredienteCodi,$cantidadIngreBode,$personaIngreBode){
        $this->db->trans_begin();
        $sql = "UPDATE ingrebodes "
                . "SET ingrebode_cantidad = ingrebode_cantidad - '$cantidadIngreBode' "
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
    
    //Consulta la tabla de ingredientes por bodega a partir de un criterio de búsqueda dado.
    function consMoviTras($valorMoviTras){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM movitras "
               . "WHERE UPPER(id_movitras) LIKE UPPER('%$valorMoviTras%') "
                  . "OR UPPER(movitras_bodefuen_id) LIKE UPPER('%$valorMoviTras%') "
                  . "OR UPPER(movitras_bodedest_id) LIKE UPPER('%$valorMoviTras%') "
                  . "OR UPPER(movitras_ingrediente_id) LIKE UPPER('%$valorMoviTras%') "
                ."ORDER BY id_movitras";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $movitras  = array();
            foreach($datos as $dato){
                $movitrasDatos = $dato['id_movitras'].'|'.$dato['movitras_bodefuen_id'].'|'.
                                    $dato['movitras_bodedest_id'].'|'.$dato['movitras_ingrediente_id'].'|'.
                                    $dato['movitras_cantidad'].'|'.$dato['movitras_observacion'].'|'.
                                    $dato['movitras_fecha_registro'].'|'.$dato['movitras_persona_id'].'|';
                
                $movitras[$dato['id_movitras']]=$movitrasDatos;
            }
            return ($movitras);
        }
        else{
            return false;
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
    
    function descPersona($idPersona){
        $this->db->trans_begin();
        $sql = "SELECT CONCAT(persona_nombre,' ',persona_apellido) AS persona_nombre "
               . "FROM personas "
              . "WHERE id_persona = $idPersona "
               ."ORDER BY persona_nombre";
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