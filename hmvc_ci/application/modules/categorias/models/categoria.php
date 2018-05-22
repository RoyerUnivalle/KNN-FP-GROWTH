<?php
Class Categoria extends CI_Model{
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
    
    function insCategoria($nombreCate,$personaCate,$estadoCate){
        $this->db->trans_begin();
        $sql = "INSERT INTO categorias(categoria_nombre,categoria_fecha_registro,"
                         . "categoria_persona_id,categoria_estado_id) "
              ."VALUES ('$nombreCate', null, '$personaCate', '$estadoCate')";
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
    
    function selCategoria($idCategoria,$nombreCate){
        $this->db->trans_begin();
        if($idCategoria == ""){
            $sql = "SELECT * "
                   . "FROM categorias "
                   . "WHERE upper(categoria_nombre) LIKE upper('$nombreCate')"
                    ."ORDER BY id_categoria";
        }
        else{
            $sql = "SELECT * "
                   . "FROM categorias "
                   . "WHERE id_categoria != '$idCategoria' "
                     . "AND upper(categoria_nombre) LIKE upper('$nombreCate')"
                    ."ORDER BY id_categoria";
        }
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
           return(1);
        }
        else{
            return(0);
        }
    }
    
    //Consulta la tabla Categorias por un criterio de búsqueda dado.
    function consCategoria($valorCategoria){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM categorias "
               . "WHERE id_categoria LIKE '%$valorCategoria%'"
               . "OR UPPER(categoria_nombre) LIKE UPPER('%$valorCategoria%')"
               . "OR UPPER(categoria_estado_id) LIKE UPPER('%$valorCategoria%')"
                ."ORDER BY id_categoria";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $categorias  = array();
            foreach($datos as $dato){
                $categoriaDatos = $dato['id_categoria'].'|'.$dato['categoria_nombre'].'|'.$dato['categoria_fecha_registro'].'|'.
                                $dato['categoria_persona_id'].'|'.$dato['categoria_estado_id'].'|';
                
                $categorias[$dato['id_categoria']]=$categoriaDatos;
            }
            return ($categorias);
        }
        else{
            return false;
        }
    }
    
    //Selecciona el categoria a actualizar
    function selModiCategoria($idCategoria){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM categorias "
               . "WHERE id_categoria = '$idCategoria'"
                ."ORDER BY id_categoria";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            return ($datos);
        }
        else{
            return(0);
        }
    }
    
    //Asigna el Estado en el formulario de Actualización de Categorias.
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
    
    //Realiza la actualización de un categoria en la base de datos.
    function updCategoria($idCategoria,$nombreCategoria,$estadoCodi){
        $this->db->trans_begin();
        $sql = "UPDATE categorias "
                . "SET categoria_nombre = '$nombreCategoria', "
                    . "categoria_estado_id = '$estadoCodi' "
               ."WHERE id_categoria = '$idCategoria'";
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
    
    function selCateProd($idCategoria){
        $this->db->trans_begin();
        $sql = "SELECT id_producto "
               . "FROM productos "
               . "WHERE producto_categoria_id = '$idCategoria' "
                ."ORDER BY id_producto";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
           return(1);
        }
        else{
            return(0);
        }
    }
    
    //Realiza el borrado de un cliente en la tabla Clientes.
    function borCategoria($idCategoria){
        $this->db->trans_begin();
        $sql = "DELETE FROM categorias WHERE id_categoria = '$idCategoria'";
        $result = mysql_query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            $categorias = $this->consCategoria("");
            return $categorias;
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
}
?>