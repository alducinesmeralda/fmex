<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Licencia_model
 * @author : Luis
 * @version : 1.1
 * @since : Abril 2020
 */
class Licencia_model extends CI_Model
{
    /**
     * Carga el número de registros  de licencias
     * @param string $texto_buscar : Texto a buscar, opcional
     * @return number $count : Retorna el numero de registros
     */
    function licenciasCount($texto_buscar = '')
    {
        $this->db->select('id_licencia, nombre ');
        $this->db->from('licencia');

        if(!empty($texto_buscar)) {
            $likeCriteria = "(nombre  LIKE '%".$texto_buscar."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('eliminado !=', 1);
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    /**
     * Carga los registros de licencias 
     * @param string $texto_buscar : Texto a buscar, opcional
     * @param number $pagina : Número de registro, o posicion de la tabla
     * @param number $num_registros_por_pagina : Cuantos registros queremos traer a partir de la posicion dada
     * @return array $result : Lista de registros
     */
    function licencias($texto_buscar = '', $pagina, $num_registros_por_pagina)
    {
        // echo "<br/>desde model,  pagina = $pagina, num_registros_por_pagina = $num_registros_por_pagina  ";

        $this->db->select('id_licencia, nombre, activo, fecha_alta, fecha_ultima_modificacion');
        $this->db->from('licencia');
        if(!empty($texto_buscar)) {
            $likeCriteria = "(nombre  LIKE '%".$texto_buscar."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('eliminado !=', 1);
        $this->db->order_by('id_licencia', 'ASC');
        $this->db->limit($pagina, $num_registros_por_pagina);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
    
  
  
    
    /**
     * Insetar nueva licencia a la base de datos
     * @return number $insert_id : El ultimo id insertado
     */
    function insertarLicencia($licenciaInfo)
    {
        $this->db->trans_start();
        $this->db->insert('licencia', $licenciaInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * Obtener información de la tabla licencia por id
     * @param number $id_licencia : Id de la licencia
     * @return array $result : Datos de la licencia
     */
    function getLicenciaInfo($id_licencia)
    {
        $this->db->select('id_licencia, nombre, activo, fecha_alta, fecha_ultima_modificacion');
        $this->db->from('licencia');
        $this->db->where('id_licencia', $id_licencia);
        $query = $this->db->get();
        
        return $query->row();
    }
    
    
    /**
     * Ejecuta un update a la base de datos
     * @param array $licenciaInfo : Datos de la licencia
     * @param number $id_licencia : Id de la licencia
     */
    function actualizarLicencia($licenciaInfo, $id_licencia)
    {
        $this->db->where('id_licencia', $id_licencia);
        $this->db->update('licencia', $licenciaInfo);
        
        return TRUE;
    }
    
    
    
    /**
     * Borrar un registro de la tabla licencia
     * @param number $id_licencia : Su id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteLicencia($id_licencia, $licenciaInfo)
    {
        $this->db->where('id_licencia', $id_licencia);
        $this->db->update('licencia', $licenciaInfo);
        
        return $this->db->affected_rows();
    }

    
    /**
     * This function used to get licencia information by id
     * @param number $id_licencia : This is licencia id
     * @return array $result : This is licencia information
     */
    function getLicenciaInfoById($id_licencia)
    {
        $this->db->select('id_licencia, nombre');
        $this->db->from('licencia');
        $this->db->where('id_licencia', $id_licencia);
        $query = $this->db->get();
        
        return $query->row();
    }



}

  