<?php
Class Tablas_Campos_dw extends CI_Model{
    //Se obtiene la última fecha de sincronización.
    function ultiSincroniza(){
        $this->db->trans_begin();
        $sql = "SELECT IFNULL(MAX(sincron_dw_fecha_registro),'No se ha realizado sincronización de datos') ULTISINC "
                ."FROM sincron_dw "
               ."WHERE sincron_dw_completa = TRUE";
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
}
?>