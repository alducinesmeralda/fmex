<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Base_model
 * @author : Luis
 * @version : 1.1
 * @since : Abril 2020
 */
class Base_model extends CI_Model
{
    /**
     * Carga el número de registros  de bases
     * @param string $texto_buscar : Texto a buscar, opcional
     * @return number $count : Retorna el numero de registros
     */
    function basesCount($texto_buscar = '')
    {
        $this->db->select('id_base, nombre ');
        $this->db->from('base');
        if(!empty($texto_buscar)) {
            $likeCriteria = "(nombre  LIKE '%".$texto_buscar."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('eliminado !=', 1);

        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    /**
     * Carga los registros de bases 
     * @param string $texto_buscar : Texto a buscar, opcional
     * @param number $pagina : Número de registro, o posicion de la tabla
     * @param number $num_registros_por_pagina : Cuantos registros queremos traer a partir de la posicion dada
     * @return array $result : Lista de registros
     */
    function bases($texto_buscar = '', $pagina, $num_registros_por_pagina)
    {
        // echo "<br/>desde model,  pagina = $pagina, num_registros_por_pagina = $num_registros_por_pagina  ";

        $this->db->select('id_base, nombre, calle, numero_exterior, numero_interior, colonia, municipio, ciudad, estado, codigo_postal, pais, correo, telefono, activo, fecha_alta, fecha_ultima_modificacion');
        $this->db->from('base');
        if(!empty($texto_buscar)) {
            $likeCriteria = "(nombre  LIKE '%".$texto_buscar."%')";
            $this->db->where($likeCriteria);
        }
        
        $this->db->where('eliminado !=', 1);

        $this->db->order_by('id_base', 'ASC');
        $this->db->limit($pagina, $num_registros_por_pagina);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
    
  
  
    
    /**
     * Insetar nueva base a la base de datos
     * @return number $insert_id : El ultimo id insertado
     */
    function insertarBase($baseInfo)
    {
        $this->db->trans_start();
        $this->db->insert('base', $baseInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * Obtener información de la tabla base por id
     * @param number $id_base : Id de la base
     * @return array $result : Datos de la base
     */
    function getBaseInfo($id_base)
    {
        $this->db->select('id_base, nombre, calle, numero_exterior, numero_interior, colonia, municipio, ciudad, estado, codigo_postal, pais, correo, telefono, activo, fecha_alta, fecha_ultima_modificacion');
        $this->db->from('base');
        $this->db->where('id_base', $id_base);
        $query = $this->db->get();
        
        return $query->row();
    }
    
    
    /**
     * Ejecuta un update a la base de datos
     * @param array $baseInfo : Datos de la base
     * @param number $id_base : Id de la base
     */
    function actualizarBase($baseInfo, $id_base)
    {
        $this->db->where('id_base', $id_base);
        $this->db->update('base', $baseInfo);
        
        return TRUE;
    }
    
    
    
    /**
     * Borrar un registro de la tabla base
     * @param number $id_base : Su id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteBase($id_base, $baseInfo)
    {
        $this->db->where('id_base', $id_base);
        $this->db->update('base', $baseInfo);
        
        return $this->db->affected_rows();
    }

    
    /**
     * This function used to get base information by id
     * @param number $id_base : This is base id
     * @return array $result : This is base information
     */
    function getBaseInfoById($id_base)
    {
        $this->db->select('id_base, nombre, calle, numero_exterior, numero_interior, colonia, municipio, ciudad, estado, codigo_postal, pais, correo, telefono');
        $this->db->from('base');
        $this->db->where('id_base', $id_base);
        $query = $this->db->get();
        
        return $query->row();
    }



}

  