<?php
Class User extends CI_Model{
    
    function login($username, $password){
        $this->db->trans_begin();
        $sql = "SELECT id_usuario,usuario_nombre,usuario_clave,usuario_perfil_id,usuario_estado_id "
               . "FROM usuarios "
              . "WHERE usuario_nombre = '$username' and usuario_clave = MD5('$password')";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $this->db->trans_begin();
            $user_id = $datos[0]['id_usuario'];
            $sqlPersona = "SELECT id_persona,persona_nombre,persona_apellido "
                            ."FROM personas "
                            ."WHERE persona_usuario_id = '$user_id' AND persona_estado_id = 1";
            $registrosPersona = $this->db->query($sqlPersona);
            $datosPersona = $registrosPersona->result_array();
        
            $newdata = array('id'        => $datos[0]['id_usuario'],
                             'usuario'   => $datos[0]['usuario_nombre'],
                             'clave'     => $datos[0]['usuario_clave'],
                             'perfil'    => $datos[0]['usuario_perfil_id'],
                             'estado'    => $datos[0]['usuario_estado_id'],
                             'idPers'    => $datosPersona[0]['id_persona'],
                             'nombPers'  => $datosPersona[0]['persona_nombre'],
                             'apelPers'  => $datosPersona[0]['persona_apellido'],
                             'logged_in' => TRUE);
            
            $this->session->set_userdata($newdata);
            return true;
        }
        else{
            return false;
        }
    }
}
?>