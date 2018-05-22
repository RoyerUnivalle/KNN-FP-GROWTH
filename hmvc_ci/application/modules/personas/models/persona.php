<?php
Class Persona extends CI_Model{
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
    
    function listaCiudades(){
        $this->db->trans_begin();
        $sql = "SELECT CONCAT(id_ciudad, ' - ', ciudad_nombre) As ciudad "
               . "FROM ciudades "
              . "WHERE ciudad_estado_id = 1 "
               ."ORDER BY ciudad";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $ciudades  = array();
            foreach($datos as $keyDato=>$dato){
                $ciudadDatos = $datos[$keyDato]['ciudad'];
                $ciudades[$keyDato] = $ciudadDatos;
            }
            return ($ciudades);
        }
        else{
            return false;
        }
    }
    
    function listaUsuarios(){
        $this->db->trans_begin();
        $sql = "SELECT CONCAT(id_usuario, ' - ', usuario_nombre) As usuario "
               . "FROM usuarios "
              . "WHERE usuario_estado_id = 1 "
               ."ORDER BY usuario";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $usuarios  = array();
            foreach($datos as $keyDato=>$dato){
                $usuarioDatos = $datos[$keyDato]['usuario'];
                $usuarios[$keyDato] = $usuarioDatos;
            }
            return ($usuarios);
        }
        else{
            return false;
        }
    }
    
    function insPersona($idPers,$nombrePers,$apellidoPers,$emailPers,
                        $ciudadCodi,$direccionPers,$telefonoPers,$usuarioPers,
                        $estadoCodi,$personaPers){
        $this->db->trans_begin();
        $sql = "INSERT INTO personas (id_persona,persona_nombre,persona_apellido,persona_email,"
                                      . "persona_ciudad_id,persona_direccion,persona_telefono,persona_usuario_id,"
                                      . "persona_estado_id,persona_persona_registra) "
              ."VALUES ('$idPers', '$nombrePers', '$apellidoPers', '$emailPers', "
                     . "'$ciudadCodi', '$direccionPers', '$telefonoPers', '$usuarioPers', '$estadoCodi', '$personaPers')";
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
    
    function selPersona($idPersona){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM personas "
               . "WHERE id_persona = '$idPersona'"
                ."ORDER BY id_persona";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
           return(1);
        }
        else{
            return(0);
        }
    }
    
    function selUsuaPers($idPers,$usuaPers){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM personas "
               . "WHERE persona_usuario_id = '$usuaPers' "
               . "AND id_persona != '$idPers' "
               . "AND persona_estado_id = 1 "
                ."ORDER BY id_persona";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
           return(1);
        }
        else{
            return(0);
        }
    }
    
    //Consulta la tabla Clientes por un criterio de búsqueda dado.
    function consPersona($valorPersona){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM personas "
               . "WHERE id_persona LIKE '%$valorPersona%'"
               . "OR UPPER(persona_nombre) LIKE UPPER('%$valorPersona%')"
               . "OR UPPER(persona_apellido) LIKE UPPER('%$valorPersona%')"
               . "OR UPPER(persona_usuario_id) LIKE '%$valorPersona%'"
               . "OR UPPER(persona_estado_id) LIKE '%$valorPersona%'"
                ."ORDER BY id_persona";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $personas  = array();
            foreach($datos as $dato){
                $personaDatos = $dato['id_persona'].'|'.$dato['persona_nombre'].'|'.$dato['persona_apellido'].'|'.
                                $dato['persona_email'].'|'.$dato['persona_ciudad_id'].'|'.$dato['persona_direccion'].'|'.
                                $dato['persona_telefono'].'|'.$dato['persona_usuario_id'].'|'.$dato['persona_estado_id'].'|'.
                                $dato['persona_fecha_registro'].'|'.$dato['persona_persona_registra'].'|';
                
                $personas[$dato['id_persona']]=$personaDatos;
            }
            return ($personas);
        }
        else{
            return false;
        }
    }
    
    
    //Selecciona el cliente a actualizar
    function selModiPersona($idPersona){
        $this->db->trans_begin();
        $sql = "SELECT id_persona,persona_nombre,persona_apellido,persona_email,persona_ciudad_id,persona_direccion,"
                . "persona_telefono,persona_usuario_id,persona_estado_id "
               . "FROM personas "
               . "WHERE id_persona = '$idPersona'"
                ."ORDER BY id_persona";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    
    //Asigna la Ciudad en el formulario de Actualización de Personas.
    function selCiudad($id_ciudad){
        $this->db->trans_begin();
        $sql = "SELECT CONCAT(id_ciudad, ' - ', ciudad_nombre) As ciudad "
               . "FROM ciudades "
              . "WHERE id_ciudad = $id_ciudad "
               ."ORDER BY ciudad";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    
    //Asigna el Estado en el formulario de Actualización de Personas.
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
    
    
    //Asigna el Usuario en el formulario de Actualización de Personas.
    function selUsuario($id_usuario){
        $this->db->trans_begin();
        $sql = "SELECT CONCAT($id_usuario, ' - ', usuario_nombre) As usuario "
               . "FROM usuarios "
               . "WHERE id_usuario = $id_usuario "
               ."ORDER BY usuario";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    
    //Realiza el borrado de un cliente en la tabla Clientes.
    function borPersona($codigoPers){
        $this->db->trans_begin();
        $sql = "DELETE FROM personas WHERE id_persona = '$codigoPers'";
        $result = mysql_query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            $personas = $this->consPersona("");
            return $personas;
        }
    }
    
    
    //Realiza la actualización de un cliente en la base de datos.
    function updPersona($idPers,$nombrePers,$apellidoPers,$emailPers,
                        $ciudadCodi,$direccionPers,$telefonoPers,$usuarioCodi,
                        $estadoCodi,$personaPers){
        $this->db->trans_begin();
        $sql = "UPDATE personas "
                . "SET persona_nombre = '$nombrePers', "
                    . "persona_apellido = '$apellidoPers', "
                    . "persona_email = '$emailPers', "
                    . "persona_ciudad_id = '$ciudadCodi', "
                    . "persona_direccion = '$direccionPers', "
                    . "persona_telefono = '$telefonoPers', "
                    . "persona_usuario_id = '$usuarioCodi', "
                    . "persona_estado_id = '$estadoCodi' "
               ."WHERE id_persona = '$idPers'";
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
    
    function descUsuario($idUsuario){
        $this->db->trans_begin();
        $sql = "SELECT usuario_nombre "
               . "FROM usuarios "
              . "WHERE id_usuario = '$idUsuario' "
               ."ORDER BY usuario_nombre";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    function descCiudad($idCiudad){
        $this->db->trans_begin();
        $sql = "SELECT ciudad_nombre "
               . "FROM ciudades "
              . "WHERE id_ciudad = '$idCiudad' "
               ."ORDER BY ciudad_nombre";
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