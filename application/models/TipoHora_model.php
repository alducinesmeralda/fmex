<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : TipoHora_model
 * @author : Luis
 * @version : 1.1
 * @since : Abril 2020
 */
class TipoHora_model extends CI_Model
{
    /**
     * Carga el número de registros  de tiposHora
     * @param string $texto_buscar : Texto a buscar, opcional
     * @return number $count : Retorna el numero de registros
     */
    function tiposHoraCount($texto_buscar = '')
    {
        $this->db->select('id_tipo_hora, nombre ');
        $this->db->from('tipo_hora');
        if(!empty($texto_buscar)) {
            $likeCriteria = "(nombre  LIKE '%".$texto_buscar."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('eliminado !=', 1);

        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    /**
     * Carga los registros de tiposHora 
     * @param string $texto_buscar : Texto a buscar, opcional
     * @param number $pagina : Número de registro, o posicion de la tabla
     * @param number $num_registros_por_pagina : Cuantos registros queremos traer a partir de la posicion dada
     * @return array $result : Lista de registros
     */
    function tiposHora($texto_buscar = '', $pagina, $num_registros_por_pagina)
    {
        // echo "<br/>desde model,  pagina = $pagina, num_registros_por_pagina = $num_registros_por_pagina  ";

        $this->db->select('id_tipo_hora, nombre, activo, fecha_alta, fecha_ultima_modificacion');
        $this->db->from('tipo_hora');
        if(!empty($texto_buscar)) {
            $likeCriteria = "(nombre  LIKE '%".$texto_buscar."%')";
            $this->db->where($likeCriteria);
        }
        
        $this->db->where('eliminado !=', 1);

        $this->db->order_by('id_tipo_hora', 'ASC');
        $this->db->limit($pagina, $num_registros_por_pagina);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
    
  
  
    
    /**
     * Insetar nueva tipoHora a la base de datos
     * @return number $insert_id : El ultimo id insertado
     */
    function insertarTipoHora($tipoHoraInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tipo_hora', $tipoHoraInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * Obtener información de la tabla tipoHora por id
     * @param number $id_tipo_hora : Id de la tipoHora
     * @return array $result : Datos de la tipoHora
     */
    function getTipoHoraInfo($id_tipo_hora)
    {
        $this->db->select('id_tipo_hora, nombre, activo, fecha_alta, fecha_ultima_modificacion');
        $this->db->from('tipo_hora');
        $this->db->where('id_tipo_hora', $id_tipo_hora);
        $query = $this->db->get();
        
        return $query->row();
    }
    
    
    /**
     * Ejecuta un update a la base de datos
     * @param array $tipoHoraInfo : Datos de la tipoHora
     * @param number $id_tipo_hora : Id de la tipoHora
     */
    function actualizarTipoHora($tipoHoraInfo, $id_tipo_hora)
    {
        $this->db->where('id_tipo_hora', $id_tipo_hora);
        $this->db->update('tipo_hora', $tipoHoraInfo);
        
        return TRUE;
    }
    
    
    
    /**
     * Borrar un registro de la tabla tipoHora
     * @param number $id_tipo_hora : Su id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteTipoHora($id_tipo_hora, $tipoHoraInfo)
    {
        $this->db->where('id_tipo_hora', $id_tipo_hora);
        $this->db->update('tipo_hora', $tipoHoraInfo);
        
        return $this->db->affected_rows();
    }

    
    /**
     * This function used to get tipoHora information by id
     * @param number $id_tipo_hora : This is tipoHora id
     * @return array $result : This is tipoHora information
     */
    function getTipoHoraInfoById($id_tipo_hora)
    {
        $this->db->select('id_tipo_hora, nombre');
        $this->db->from('tipo_hora');
        $this->db->where('id_tipo_hora', $id_tipo_hora);
        $query = $this->db->get();
        
        return $query->row();
    }



}

  