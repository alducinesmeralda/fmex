<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Avion_model
 * @author : Luis
 * @version : 1.1
 * @since : Abril 2020
 */
class Avion_model extends CI_Model
{
    /**
     * Carga el número de registros  de aviones
     * @param string $texto_buscar : Texto a buscar, opcional
     * @return number $count : Retorna el numero de registros
     */
    function avionesCount($texto_buscar = '')
    {
        $this->db->select('id_avion, matricula ');
        $this->db->from('avion');
        if(!empty($texto_buscar)) {
            $likeCriteria = "(matricula  LIKE '%".$texto_buscar."%')";
            $this->db->where($likeCriteria);
        }        
        $this->db->where('eliminado !=', 1);

        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    /**
     * Carga los registros de aviones 
     * @param string $texto_buscar : Texto a buscar, opcional
     * @param number $pagina : Número de registro, o posicion de la tabla
     * @param number $num_registros_por_pagina : Cuantos registros queremos traer a partir de la posicion dada
     * @return array $result : Lista de registros
     */
    function aviones($texto_buscar = '', $pagina, $num_registros_por_pagina)
    {
        // echo "<br/>desde model,  pagina = $pagina, num_registros_por_pagina = $num_registros_por_pagina  ";

        $this->db->select('a.id_avion, a.matricula, a.activo, a.marca, a.modelo, a.year_fabricacion, a.id_tipo_avion, a.numero_serie, a.serie_motor1, a.marca_motor1, a.serie_motor2, a.marca_motor2, a.serie_helice1, a.marca_helice1, a.serie_helice2, a.marca_helice2, a.numero_asientos, a.horas_alta_avion, a.horas_alta_motor1, a.horas_alta_motor2, a.horas_alta_helice1, a.horas_alta_helice2, a.certificado_aeronautico, a.poliza_seguro, a.combustible, a.consumo_combustible, a.id_tipo_combustible, a.consumo_aceite, a.aceite, a.mantenimiento, a.ifr, a.id_tipo_hora, a.fecha_expedicion_seguro, a.fecha_expedicion_certificado, a.fecha_alta, a.fecha_ultima_modificacion, t.matricula, a.nombre as nombre_tipo_hora');
        
        $this->db->from('avion a');
        $this->db->join('tipo_hora t', 'a.id_tipo_hora = t.id_tipo_hora', 'inner');

        if(!empty($texto_buscar)) {
            $likeCriteria = "(a.matricula  LIKE '%".$texto_buscar."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('a.eliminado !=', 1);

        $this->db->order_by('a.id_avion', 'ASC');
        $this->db->limit($pagina, $num_registros_por_pagina);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
    
    function tiposHora()
    {
       
        $this->db->select('id_tipo_hora, matricula, activo, fecha_alta, fecha_ultima_modificacion');
        $this->db->from('tipo_hora');
        $this->db->order_by('id_tipo_hora', 'ASC');
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
  
    
    /**
     * Insetar nueva avion a la base de datos
     * @return number $insert_id : El ultimo id insertado
     */
    function insertarAvion($avionInfo)
    {
        $this->db->trans_start();
        $this->db->insert('avion', $avionInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * Obtener información de la tabla avion por id
     * @param number $id_avion : Id de la avion
     * @return array $result : Datos de la avion
     */
    function getAvionInfo($id_avion)
    {
        $this->db->select('id_avion, matricula, cantidad, costo, activo, fecha_alta, fecha_ultima_modificacion, id_tipo_avion, id_tipo_hora');
        $this->db->from('avion');
        $this->db->where('id_avion', $id_avion);
        $query = $this->db->get();
        
        return $query->row();
    }
    
    
    /**
     * Ejecuta un update a la base de datos
     * @param array $avionInfo : Datos de la avion
     * @param number $id_avion : Id de la avion
     */
    function actualizarAvion($avionInfo, $id_avion)
    {
        $this->db->where('id_avion', $id_avion);
        $this->db->update('avion', $avionInfo);
        
        return TRUE;
    }
    
    
    
    /**
     * Borrar un registro de la tabla avion
     * @param number $id_avion : Su id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteAvion($id_avion, $avionInfo)
    {
        $this->db->where('id_avion', $id_avion);
        $this->db->update('avion', $avionInfo);
        
        return $this->db->affected_rows();
    }

    
    /**
     * This function used to get avion information by id
     * @param number $id_avion : This is avion id
     * @return array $result : This is avion information
     */
    function getAvionInfoById($id_avion)
    {
        $this->db->select('id_avion, matricula');
        $this->db->from('avion');
        $this->db->where('id_avion', $id_avion);
        $query = $this->db->get();
        
        return $query->row();
    }



}

  