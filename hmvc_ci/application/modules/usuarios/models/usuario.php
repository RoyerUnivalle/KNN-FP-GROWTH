<?php
Class Usuario extends CI_Model{
    
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
    
    function listaPerfiles(){
        $this->db->trans_begin();
        $sql = "SELECT CONCAT(id_perfil, ' - ', perfil_nombre) As perfil "
               . "FROM perfiles "
               ."ORDER BY perfil";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $perfiles  = array();
            foreach($datos as $keyDato=>$dato){
                $perfilDatos = $datos[$keyDato]['perfil'];
                $perfiles[$keyDato] = $perfilDatos;
            }
            return ($perfiles);
        }
        else{
            return false;
        }
    }
    
    function insUsuario($usuarioNombre,$usuarioClave,
                        $usuarioPerfil,$usuarioEstado){
        $this->db->trans_begin();
        $sql = "INSERT INTO usuarios (usuario_nombre,usuario_clave,usuario_perfil_id,"
                . "usuario_estado_id) "
                ."VALUES ('$usuarioNombre', '$usuarioClave', '$usuarioPerfil', "
                . "'$usuarioEstado')";
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
    
    function selUsuario($idUsuario,$nombreUsua){
        $this->db->trans_begin();
        if($idUsuario == ""){
            $sql = "SELECT * "
                   . "FROM usuarios "
                   . "WHERE usuario_nombre LIKE '$nombreUsua'"
                    ."ORDER BY usuario_nombre";
        }
        else{
            $sql = "SELECT * "
                   . "FROM usuarios "
                   . "WHERE usuario_nombre LIKE '$nombreUsua' "
                     . "AND id_usuario != '$idUsuario' "
                    ."ORDER BY usuario_nombre";
        }
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
           return(1);
        }
        else{
            return(0);
        }
    }
    
    //Consulta la tabla Clientes por un criterio de búsqueda dado.
    function consUsuario($valorUsua){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM usuarios "
               . "WHERE id_usuario LIKE '%$valorUsua%'"
               . "OR UPPER(usuario_nombre) LIKE UPPER('%$valorUsua%')"
               . "OR UPPER(usuario_perfil_id) LIKE UPPER('%$valorUsua%')"
               . "OR UPPER(usuario_estado_id) LIKE UPPER('%$valorUsua%')"
                ."ORDER BY id_usuario";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $usuarios  = array();
            foreach($datos as $dato){
                $usuarioDatos = $dato['id_usuario'].'|'.$dato['usuario_nombre'].'|'.$dato['usuario_perfil_id'].'|'.
                                $dato['usuario_estado_id'].'|';
                
                $usuarios[$dato['id_usuario']]=$usuarioDatos;
            }
            return ($usuarios);
        }
        else{
            return false;
        }
    }
    
    //Selecciona el cliente a actualizar
    function selModiUsuario($idUsuario){
        $this->db->trans_begin();
        $sql = "SELECT id_usuario,usuario_nombre,usuario_clave,usuario_perfil_id,usuario_estado_id "
               . "FROM usuarios "
               . "WHERE id_usuario = '$idUsuario'"
                ."ORDER BY id_usuario";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    //Asigna el Perfil en el formulario de Actualización de Usuarios.
    function selPerfil($id_perfil){
        $this->db->trans_begin();
        $sql = "SELECT CONCAT(id_perfil, ' - ', perfil_nombre) As perfil "
               . "FROM perfiles "
               . "WHERE id_perfil = '$id_perfil' "
               ."ORDER BY perfil";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    //Asigna el Estado en el formulario de Actualización de Clientes.
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
    
    //Realiza la actualización de un usuario en la base de datos.
    function updUsuario($codigoUsua,$nombreUsua,$claveUsua,$perfilCodi,$estadoCodi){
        $this->db->trans_begin();
        $sql = "UPDATE usuarios "
                . "SET usuario_nombre = '$nombreUsua', "
                    . "usuario_clave = '$claveUsua', "
                    . "usuario_perfil_id = '$perfilCodi', "
                    . "usuario_estado_id = '$estadoCodi' "
               ."WHERE id_usuario = '$codigoUsua'";
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
    
    //Realiza el borrado de un usuario en la tabla Usuarios.
    function borUsuario($idUsuario){
        $this->db->trans_begin();
        $sql = "DELETE FROM usuarios WHERE id_usuario = '$idUsuario'";
        //echo($sql);
        $result = mysql_query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            $usuarios = $this->consUsuario("");
            return $usuarios;
        }
    }
    
    function selPersUsua($idUsuario){
        $this->db->trans_begin();
        $sql = "SELECT id_persona "
               . "FROM personas "
               . "WHERE persona_usuario_id = '$idUsuario' "
                ."ORDER BY id_persona";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
           return(1);
        }
        else{
            return(0);
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
    
    function descPerfil($idPerfil){
        $this->db->trans_begin();
        $sql = "SELECT perfil_nombre "
               . "FROM perfiles "
              . "WHERE id_perfil = $idPerfil "
               ."ORDER BY perfil_nombre";
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