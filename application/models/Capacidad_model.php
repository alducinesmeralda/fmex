<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Capacidad_model
 * @author : Luis
 * @version : 1.1
 * @since : Abril 2020
 */
class Capacidad_model extends CI_Model
{
    /**
     * Carga el número de registros  de capacidades
     * @param string $texto_buscar : Texto a buscar, opcional
     * @return number $count : Retorna el numero de registros
     */
    function capacidadesCount($texto_buscar = '')
    {
        $this->db->select('id_capacidad, nombre ');
        $this->db->from('capacidad');
        if(!empty($texto_buscar)) {
            $likeCriteria = "(nombre  LIKE '%".$texto_buscar."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('eliminado !=', 1);

        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    /**
     * Carga los registros de capacidades 
     * @param string $texto_buscar : Texto a buscar, opcional
     * @param number $pagina : Número de registro, o posicion de la tabla
     * @param number $num_registros_por_pagina : Cuantos registros queremos traer a partir de la posicion dada
     * @return array $result : Lista de registros
     */
    function capacidades($texto_buscar = '', $pagina, $num_registros_por_pagina)
    {
        // echo "<br/>desde model,  pagina = $pagina, num_registros_por_pagina = $num_registros_por_pagina  ";

        $this->db->select('id_capacidad, nombre, activo, fecha_alta, fecha_ultima_modificacion');
        $this->db->from('capacidad');
        if(!empty($texto_buscar)) {
            $likeCriteria = "(nombre  LIKE '%".$texto_buscar."%')";
            $this->db->where($likeCriteria);
        }

        $this->db->where('eliminado !=', 1);

        $this->db->order_by('id_capacidad', 'ASC');
        $this->db->limit($pagina, $num_registros_por_pagina);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
    
  
  
    
    /**
     * Insetar nueva capacidad a la base de datos
     * @return number $insert_id : El ultimo id insertado
     */
    function insertarCapacidad($capacidadInfo)
    {
        $this->db->trans_start();
        $this->db->insert('capacidad', $capacidadInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * Obtener información de la tabla capacidad por id
     * @param number $id_capacidad : Id de la capacidad
     * @return array $result : Datos de la capacidad
     */
    function getCapacidadInfo($id_capacidad)
    {
        $this->db->select('id_capacidad, nombre, activo, fecha_alta, fecha_ultima_modificacion');
        $this->db->from('capacidad');
        $this->db->where('id_capacidad', $id_capacidad);
        $query = $this->db->get();
        
        return $query->row();
    }
    
    
    /**
     * Ejecuta un update a la base de datos
     * @param array $capacidadInfo : Datos de la capacidad
     * @param number $id_capacidad : Id de la capacidad
     */
    function actualizarCapacidad($capacidadInfo, $id_capacidad)
    {
        $this->db->where('id_capacidad', $id_capacidad);
        $this->db->update('capacidad', $capacidadInfo);
        
        return TRUE;
    }
    
    
    
    /**
     * Borrar un registro de la tabla capacidad
     * @param number $id_capacidad : Su id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteCapacidad($id_capacidad, $capacidadInfo)
    {
        $this->db->where('id_capacidad', $id_capacidad);
        $this->db->update('capacidad', $capacidadInfo);
        
        return $this->db->affected_rows();
    }

    
    /**
     * This function used to get capacidad information by id
     * @param number $id_capacidad : This is capacidad id
     * @return array $result : This is capacidad information
     */
    function getCapacidadInfoById($id_capacidad)
    {
        $this->db->select('id_capacidad, nombre');
        $this->db->from('capacidad');
        $this->db->where('id_capacidad', $id_capacidad);
        $query = $this->db->get();
        
        return $query->row();
    }



}

  