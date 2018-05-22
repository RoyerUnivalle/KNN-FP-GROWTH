<?php
Class Bodega extends CI_Model{
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
    
    function insBodega($codigoBode,$nombreBode,$estadoBode){
        $this->db->trans_begin();
        $sql = "INSERT INTO bodegas(id_bodega,bodega_nombre,bodega_estado_id) "
              ."VALUES ('$codigoBode', '$nombreBode', '$estadoBode')";
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
    
    function selBodega($idBodega,$nombreBodega,$operacion){
        $this->db->trans_begin();
        $sql = "SELECT * ".
                 "FROM bodegas ".
                "WHERE ((id_bodega = '$idBodega' ".
                        "OR upper(bodega_nombre) like upper('$nombreBodega')) ".
                        "AND '$operacion' = 'I') ".
                    "OR (id_bodega != '$idBodega' ".
                        "AND upper(bodega_nombre) like upper('$nombreBodega') ".
                        "AND '$operacion' = 'U') ".
                 "ORDER BY id_bodega";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
           return(1);
        }
        else{
            return(0);
        }
    }
    
    //Consulta la tabla Bodegas por un criterio de búsqueda dado.
    function consBodega($valorBodega){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM bodegas "
               . "WHERE id_bodega LIKE '%$valorBodega%'"
               . "OR UPPER(bodega_nombre) LIKE UPPER('%$valorBodega%')"
               . "OR UPPER(bodega_estado_id) LIKE UPPER('%$valorBodega%')"
                ."ORDER BY id_bodega";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
            $datos = $datosSql->result_array();
            $bodegas  = array();
            foreach($datos as $dato){
                $bodegaDatos = $dato['id_bodega'].'|'.$dato['bodega_nombre'].'|'.
                               $dato['bodega_estado_id'].'|';
                
                $bodegas[$dato['id_bodega']]=$bodegaDatos;
            }
            return ($bodegas);
        }
        else{
            return false;
        }
    }
    
    //Selecciona el bodega a actualizar
    function selModiBodega($idBodega){
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
    
    //Asigna el Estado en el formulario de Actualización de Bodegas.
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
    
    //Realiza la actualización de un bodega en la base de datos.
    function updBodega($idBodega,$nombreBodega,$estadoCodi){
        $this->db->trans_begin();
        $sql = "UPDATE bodegas "
                . "SET bodega_nombre = '$nombreBodega', "
                    . "bodega_estado_id = '$estadoCodi' "
               ."WHERE id_bodega = '$idBodega'";
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
    
    function selMoviBode($idBodega){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM movicomp "
               . "WHERE movicomp_bodega_id = '$idBodega' "
                ."ORDER BY id_movicomp_compra,id_movicomp_secuencia";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
           return(1);
        }
        else{
            return(0);
        }
    }
    
    function selIngrBode($idBodega){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM ingrebodes "
               . "WHERE ingrebode_bodega_id = '$idBodega' "
                ."ORDER BY ingrebode_bodega_id,ingrebode_bodega_id";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
           return(1);
        }
        else{
            return(0);
        }
    }
    
    function selMoveBode($idBodega){
        $this->db->trans_begin();
        $sql = "SELECT * "
               . "FROM movivent "
               . "WHERE movivent_bodega_id = '$idBodega' "
                ."ORDER BY id_movivent_venta,id_movivent_secuencia";
        $datosSql = $this->db->query($sql);
        if($datosSql->num_rows()>0){
           return(1);
        }
        else{
            return(0);
        }
    }
    
    //Realiza el borrado de un bodega en la tabla Bodegas.
    function borBodega($idBodega){
        $this->db->trans_begin();
        $sql = "DELETE FROM bodegas WHERE id_bodega = '$idBodega'";
        $result = mysql_query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            $bodegas = $this->consBodega("");
            return $bodegas;
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
}
?>