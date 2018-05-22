<?php
Class Proveedor extends CI_Model{
    
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
    
    //Realiza la inserción del Proveedor en la tabla Proveedores.
    function insProveedor($codigoProv,$nombreProv,$telefonoProv,$direccionProv,
                          $emailProv,$personaProv,$estadoProv){
        $this->db->trans_begin();
        
        $sql = "INSERT INTO proveedores (id_proveedor,proveedor_nombre,proveedor_telefono,"
                                      . "proveedor_direccion,proveedor_email,"
                                      . "proveedor_fecha_registro,proveedor_persona_id,"
                                      . "proveedor_estado_id) "
              ."VALUES ('$codigoProv', '$nombreProv', '$telefonoProv', "
                     . "'$direccionProv', '$emailProv', null, '$personaProv', '$estadoProv')";
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
    
    //Consulta la tabla Proveedores por el código del proveedor.
    function selProveedor($idProveedor){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM proveedores "
               . "WHERE id_proveedor = '$idProveedor'"
                ."ORDER BY id_proveedor";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
           return(1);
        }
        else{
            return(0);
        }
    }
    
    //Selecciona el proveedor a actualizar
    function selModiProveedor($idProveedor){
        $this->db->trans_begin();
        $sql = "SELECT id_proveedor,proveedor_nombre,proveedor_direccion,proveedor_telefono,"
                . "proveedor_email,proveedor_estado_id,proveedor_frecuencia,proveedor_costacum_compras "
               . "FROM proveedores "
               . "WHERE id_proveedor = '$idProveedor'"
                ."ORDER BY id_proveedor";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    //Asigna el Estado en el formulario de Actualización de Proveedores.
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
    
    //Consulta la tabla Proveedores por un criterio de búsqueda dado.
    function consProveedor($valorProveedor){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM proveedores "
               . "WHERE id_proveedor LIKE '%$valorProveedor%'"
               . "OR UPPER(proveedor_nombre) LIKE UPPER('%$valorProveedor%')"
                ."ORDER BY id_proveedor";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $proveedores  = array();
            foreach($datos as $dato){
                $proveedorDatos = $dato['id_proveedor'].'|'.$dato['proveedor_nombre'].'|'.$dato['proveedor_telefono'].'|'.
                                $dato['proveedor_direccion'].'|'.$dato['proveedor_email'].'|'.$dato['proveedor_frecuencia'].'|'.
                                $dato['proveedor_costacum_compras'].'|'.$dato['proveedor_fecha_registro'].'|'.$dato['proveedor_persona_id'].'|'.
                                $dato['proveedor_estado_id'].'|'.'|'.$dato['proveedor_email'].'|';
                
                $proveedores[$dato['id_proveedor']]=$proveedorDatos;
            }
            return ($proveedores);
        }
        else{
            return false;
        }
    }
    
    function updProveedor($codigoProv,$nombreProv,$telefonoProv,$direccionProv,
                          $emailProv,$personaProv,$estadoCodi){
    
        $this->db->trans_begin();
        $sql = "UPDATE proveedores "
                . "SET proveedor_nombre = '$nombreProv', "
                    . "proveedor_telefono = '$telefonoProv', "
                    . "proveedor_direccion = '$direccionProv', "
                    . "proveedor_email = '$emailProv', "
                    . "proveedor_estado_id = '$estadoCodi' "
               ."WHERE id_proveedor = '$codigoProv'";
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
    
    
    //Realiza el borrado de un proveedor en la tabla Proveedores.
    function borProveedor($codigoProv){
        $this->db->trans_begin();
        $sql = "DELETE FROM proveedores WHERE id_proveedor = '$codigoProv'";
        $result = mysql_query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            $proveedores = $this->consProveedor("");
            return $proveedores;
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