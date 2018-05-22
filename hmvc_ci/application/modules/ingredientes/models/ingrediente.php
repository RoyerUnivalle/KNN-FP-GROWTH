<?php
Class Ingrediente extends CI_Model{
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
    
    function insIngrediente($nombreIngr,$cantMinIngr,$cantMaxIngr,$cantActIngr,
                            $unidadCodi,$estadoCodi,$personaIngr){
        $this->db->trans_begin();
        $sql = "INSERT INTO ingredientes (ingrediente_nombre,ingrediente_cantidad_minima,"
                                       . "ingrediente_cantidad_maxima,ingrediente_cantidad_actual,"
                                       . "ingrediente_unidad_id,ingrediente_fecha_registro,"
                                       . "ingrediente_persona_id,ingrediente_estado_id) "
              ."VALUES ('$nombreIngr', '$cantMinIngr', '$cantMaxIngr', '$cantActIngr',"
                     . "'$unidadCodi',  null, '$personaIngr', '$estadoCodi')";
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
    
    function selIngrediente($idIngrediente,$nombreIngr){
        $this->db->trans_begin();
        if($idIngrediente == ""){
            $sql = "SELECT * "
                   . "FROM ingredientes "
                   . "WHERE upper(ingrediente_nombre) like upper('$nombreIngr') "
                    ."ORDER BY id_ingrediente";
        }
        else{
            $sql = "SELECT * "
                   . "FROM ingredientes "
                   . "WHERE id_ingrediente  != '$idIngrediente' "
                   . "  AND upper(ingrediente_nombre) like upper('$nombreIngr') "
                    ."ORDER BY id_ingrediente";
        }
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
           return(1);
        }
        else{
            return(0);
        }
    }
    
    //Consulta la tabla Ingredientes por un criterio de búsqueda dado.
    function consIngrediente($valorIngrediente){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM ingredientes "
               . "WHERE id_ingrediente LIKE '%$valorIngrediente%'"
               . "OR UPPER(ingrediente_nombre) LIKE UPPER('%$valorIngrediente%')"
               . "OR UPPER(ingrediente_estado_id) LIKE UPPER('%$valorIngrediente%')"
                ."ORDER BY id_ingrediente";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $ingredientes  = array();
            foreach($datos as $dato){
                $ingredienteDatos = $dato['id_ingrediente'].'|'.$dato['ingrediente_nombre'].'|'.
                                    $dato['ingrediente_cantidad_minima'].'|'.$dato['ingrediente_cantidad_maxima'].'|'.
                                    $dato['ingrediente_cantidad_actual'].'|'.$dato['ingrediente_unidad_id'].'|'.
                                    $dato['ingrediente_fecha_registro'].'|'.$dato['ingrediente_persona_id'].'|'.
                                    $dato['ingrediente_estado_id'].'|';
                
                $ingredientes[$dato['id_ingrediente']]=$ingredienteDatos;
            }
            return ($ingredientes);
        }
        else{
            return false;
        }
    }
    
    //Selecciona el ingrediente a actualizar
    function selModiIngrediente($idIngrediente){
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
    
    //Asigna el Estado en el formulario de Actualización de Ingredientes.
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
    
    //Asigna la Unidad en el formulario de Actualización de Ingredientes.
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
    
    //Realiza la actualización de un ingrediente en la base de datos.
    function updIngrediente($idIngrediente,$nombreIngrediente,$cantMinIngrediente,$cantMaxIngrediente,
                            $cantActIngrediente,$unidadCodi,$estadoCodi){
        $this->db->trans_begin();
        $sql = "UPDATE ingredientes "
                . "SET ingrediente_nombre = '$nombreIngrediente', "
                    . "ingrediente_cantidad_minima = '$cantMinIngrediente', "
                    . "ingrediente_cantidad_maxima = '$cantMaxIngrediente', "
                    . "ingrediente_cantidad_actual = '$cantActIngrediente', "
                    . "ingrediente_unidad_id = '$unidadCodi', "
                    . "ingrediente_estado_id = '$estadoCodi' "
               ."WHERE id_ingrediente = '$idIngrediente'";
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
    
    function selMoviIngr($idIngrediente){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM movicomp "
               . "WHERE movicomp_ingrediente_id = '$idIngrediente' "
                ."ORDER BY id_movicomp_compra,id_movicomp_secuencia";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
           return(1);
        }
        else{
            return(0);
        }
    }
    
    function selProdIngr($idIngrediente){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM ingreprodu "
               . "WHERE ingreprodu_ingrediente_id = '$idIngrediente' "
                ."ORDER BY ingreprodu_ingrediente_id,ingreprodu_ingrediente_id";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
           return(1);
        }
        else{
            return(0);
        }
    }
    
    //Realiza el borrado de un ingrediente en la tabla Ingredientes.
    function borIngrediente($idIngrediente){
        $this->db->trans_begin();
        $sql = "DELETE FROM ingredientes WHERE id_ingrediente = '$idIngrediente'";
        $result = mysql_query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            $ingredientes = $this->consIngrediente("");
            return $ingredientes;
        }
    }
}
?>