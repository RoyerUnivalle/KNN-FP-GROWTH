<?php
Class Cliente extends CI_Model{

    //Lista de valores de Estados.
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
    
    //Lista de valores de Ciudades.
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
    
    //Lista de valores de Géneros.
    function listaGeneros(){
        $this->db->trans_begin();
        $sql = "SELECT CONCAT(id_genero, ' - ', genero_descripcion) As genero "
               . "FROM generos "
               ."ORDER BY genero";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $generos  = array();
            foreach($datos as $keyDato=>$dato){
                $generoDatos = $datos[$keyDato]['genero'];
                $generos[$keyDato] = $generoDatos;
            }
            return ($generos);
        }
        else{
            return false;
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
    
    //Asigna la Ciudad en el formulario de Actualización de Clientes.
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
    
    //Asigna el Género en el formulario de Actualización de Clientes.
    function selGenero($id_genero){
        $this->db->trans_begin();
        $sql = "SELECT CONCAT(id_genero, ' - ', genero_descripcion) As genero "
               . "FROM generos "
               . "WHERE id_genero = '$id_genero' "
               ."ORDER BY genero";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    //Realiza la inserción del Cliente en la tabla Clientes.
    function insCliente($codigoClie,$nombreClie,$generoClie,$telefonoClie,$ciudadCodi,
                        $direccionClie,$emailClie,$estadoClie,$fechaNaci,$personaClie){
        $this->db->trans_begin();
        $sql = "INSERT INTO clientes(id_cliente,cliente_nombre,cliente_genero_id,cliente_telefono,cliente_ciudad_id,"
                                      . "cliente_direccion,cliente_email,cliente_estado_id,cliente_fecha_nacimiento,"
                                      . "cliente_fecha_registro,cliente_persona_id) "
              ."VALUES ('$codigoClie', '$nombreClie', '$generoClie', '$telefonoClie', '$ciudadCodi', "
                     . "'$direccionClie', '$emailClie', '$estadoClie', STR_TO_DATE('$fechaNaci', '%Y-%m-%d'),null, "
                     . "'$personaClie')";
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
    
    //Consulta la tabla Clientes por el código del cliente.
    function selCliente($idCliente){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM clientes "
               . "WHERE id_cliente = '$idCliente'"
                ."ORDER BY id_cliente";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            return(1);
        }
        else{
            return(0);
        }
    }
    
    //Consulta la tabla Clientes por un criterio de búsqueda dado.
    function consCliente($valorCliente){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM clientes "
               . "WHERE id_cliente LIKE '%$valorCliente%'"
               . "OR UPPER(cliente_nombre) LIKE UPPER('%$valorCliente%')"
               . "OR UPPER(cliente_genero_id) LIKE UPPER('%$valorCliente%')"
               . "OR UPPER(cliente_estado_id) LIKE UPPER('%$valorCliente%')"
                ."ORDER BY id_cliente";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $clientes  = array();
            foreach($datos as $dato){
                $clienteDatos = $dato['id_cliente'].'|'.$dato['cliente_nombre'].'|'.$dato['cliente_genero_id'].'|'.
                                $dato['cliente_telefono'].'|'.$dato['cliente_ciudad_id'].'|'.$dato['cliente_direccion'].'|'.
                                $dato['cliente_email'].'|'.$dato['cliente_fecha_nacimiento'].'|'.$dato['cliente_frecuencia'].'|'.
                                $dato['cliente_costacum_ventas'].'|'.$dato['cliente_fecha_registro'].'|'.$dato['cliente_persona_id'].'|'.
                                $dato['cliente_estado_id'].'|';
                
                $clientes[$dato['id_cliente']]=$clienteDatos;
            }
            return ($clientes);
        }
        else{
            return false;
        }
    }
    
    //Realiza el borrado de un cliente en la tabla Clientes.
    function borCliente($codigoClie){
        $this->db->trans_begin();
        $sql = "DELETE FROM clientes WHERE id_cliente = '$codigoClie'";
        $result = mysql_query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            $clientes = $this->consCliente("");
            return $clientes;
        }
    }
    
    //Selecciona el cliente a actualizar
    function selModiCliente($idCliente){
        $this->db->trans_begin();
        $sql = "SELECT id_cliente,cliente_nombre,cliente_genero_id,cliente_telefono,cliente_ciudad_id,cliente_direccion,"
                . "cliente_email,cliente_fecha_nacimiento,cliente_estado_id "
               . "FROM clientes "
               . "WHERE id_cliente = '$idCliente'"
                ."ORDER BY id_cliente";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    //Realiza la actualización de un cliente en la base de datos.
    function updCliente($codigoClie,$nombreClie,$generoClie,$telefonoClie,$ciudadCodi,
                        $direccionClie,$emailClie,$estadoClie,$fechaNaci,$personaClie){
        $this->db->trans_begin();
        $sql = "UPDATE clientes "
                . "SET cliente_nombre = '$nombreClie', "
                    . "cliente_genero_id = '$generoClie', "
                    . "cliente_telefono = '$telefonoClie', "
                    . "cliente_ciudad_id = '$ciudadCodi', "
                    . "cliente_direccion = '$direccionClie', "
                    . "cliente_email = '$emailClie', "
                    . "cliente_estado_id = '$estadoClie', "
                    . "cliente_fecha_nacimiento = STR_TO_DATE('$fechaNaci', '%Y-%m-%d') "
               ."WHERE id_cliente = '$codigoClie'";
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
    
    function descCiudad($idCiudad){
        $this->db->trans_begin();
        $sql = "SELECT ciudad_nombre "
               . "FROM ciudades "
              . "WHERE id_ciudad = $idCiudad "
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
    
    function descGenero($idGenero){
        $this->db->trans_begin();
        $sql = "SELECT genero_descripcion "
               . "FROM generos "
              . "WHERE id_genero = $idGenero "
               ."ORDER BY genero_descripcion";
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