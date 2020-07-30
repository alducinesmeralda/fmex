<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Categoria_model
 * @author : Luis
 * @version : 1.1
 * @since : Abril 2020
 */
class Categoria_model extends CI_Model
{
    /**
     * Carga el número de registros  de categorias
     * @param string $texto_buscar : Texto a buscar, opcional
     * @return number $count : Retorna el numero de registros
     */
    function categoriasCount($texto_buscar = '')
    {
        $this->db->select('id_categoria, descripcion_categoria');
        $this->db->from('categoria');
        if(!empty($texto_buscar)) {
            $likeCriteria = "(descripcion_categoria LIKE '%".$texto_buscar."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('eliminado !=', 1);

        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    /**
     * Carga los registros de categorias 
     * @param string $texto_buscar : Texto a buscar, opcional
     * @param number $pagina : Número de registro, o posicion de la tabla
     * @param number $num_registros_por_pagina : Cuantos registros queremos traer a partir de la posicion dada
     * @return array $result : Lista de registros
     */
    function categorias($texto_buscar = '', $pagina, $num_registros_por_pagina)
    {
        // echo "<br/>desde model,  pagina = $pagina, num_registros_por_pagina = $num_registros_por_pagina  ";

        $this->db->select('id_categoria, descripcion_categoria, id_tipo_categoria, activo, fecha_alta, fecha_ultima_modificacion');
        $this->db->from('categoria');
        if(!empty($texto_buscar)) {
            $likeCriteria = "(descripcion_categoria LIKE '%".$texto_buscar."%')";
            $this->db->where($likeCriteria);
        }
        
        $this->db->where('eliminado !=', 1);

        $this->db->order_by('id_categoria', 'ASC');
        $this->db->limit($pagina, $num_registros_por_pagina);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
    
  
  
    
    /**
     * Insetar nueva categoria a la base de datos
     * @return number $insert_id : El ultimo id insertado
     */
    function insertarCategoria($categoriaInfo)
    {
        $this->db->trans_start();
        $this->db->insert('categoria', $categoriaInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * Obtener información de la tabla categoria por id
     * @param number $id_categoria : Id de la categoria
     * @return array $result : Datos de la categoria
     */
    function getCategoriaInfo($id_categoria)
    {
        $this->db->select('id_categoria, descripcion_categoria, id_tipo_categoria, activo, fecha_alta, fecha_ultima_modificacion');
        $this->db->from('categoria');
        $this->db->where('id_categoria', $id_categoria);
        $query = $this->db->get();
        
        return $query->row();
    }
    
    
    /**
     * Ejecuta un update a la base de datos
     * @param array $categoriaInfo : Datos de la categoria
     * @param number $id_categoria : Id de la categoria
     */
    function actualizarCategoria($categoriaInfo, $id_categoria)
    {
        $this->db->where('id_categoria', $id_categoria);
        $this->db->update('categoria', $categoriaInfo);
        
        return TRUE;
    }
    
    
    
    /**
     * Borrar un registro de la tabla categoria
     * @param number $id_categoria : Su id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteCategoria($id_categoria, $categoriaInfo)
    {
        $this->db->where('id_categoria', $id_categoria);
        $this->db->update('categoria', $categoriaInfo);
        
        return $this->db->affected_rows();
    }

    
    /**
     * This function used to get categoria information by id
     * @param number $id_categoria : This is categoria id
     * @return array $result : This is categoria information
     */
    function getCategoriaInfoById($id_categoria)
    {
        $this->db->select('id_categoria, descripcion_categoria');
        $this->db->from('categoria');
        $this->db->where('id_categoria', $id_categoria);
        $query = $this->db->get();
        
        return $query->row();
    }



}

  