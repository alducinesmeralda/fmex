<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Producto_model
 * @author : Luis
 * @version : 1.1
 * @since : Abril 2020
 */
class Producto_model extends CI_Model
{
    /**
     * Carga el número de registros  de productos
     * @param string $texto_buscar : Texto a buscar, opcional
     * @return number $count : Retorna el numero de registros
     */
    function productosCount($texto_buscar = '')
    {
        $this->db->select('id_producto, nombre ');
        $this->db->from('producto');
        if(!empty($texto_buscar)) {
            $likeCriteria = "(nombre  LIKE '%".$texto_buscar."%')";
            $this->db->where($likeCriteria);
        }        
        $this->db->where('eliminado !=', 1);

        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    /**
     * Carga los registros de productos 
     * @param string $texto_buscar : Texto a buscar, opcional
     * @param number $pagina : Número de registro, o posicion de la tabla
     * @param number $num_registros_por_pagina : Cuantos registros queremos traer a partir de la posicion dada
     * @return array $result : Lista de registros
     */
    function productos($texto_buscar = '', $pagina, $num_registros_por_pagina)
    {
        // echo "<br/>desde model,  pagina = $pagina, num_registros_por_pagina = $num_registros_por_pagina  ";

        $this->db->select('p.id_producto, p.nombre, p.cantidad, p.costo, p.activo, p.fecha_alta, p.fecha_ultima_modificacion, p.id_tipo_producto, p.id_tipo_hora, t.nombre as nombre_tipo_hora');
        $this->db->from('producto p');
        $this->db->join('tipo_hora t', 'p.id_tipo_hora = t.id_tipo_hora', 'inner');
        // $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');

        if(!empty($texto_buscar)) {
            $likeCriteria = "(p.nombre  LIKE '%".$texto_buscar."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('p.eliminado !=', 1);

        $this->db->order_by('p.id_producto', 'ASC');
        $this->db->limit($pagina, $num_registros_por_pagina);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
    
    function tiposHora()
    {
       
        $this->db->select('id_tipo_hora, nombre, activo, fecha_alta, fecha_ultima_modificacion');
        $this->db->from('tipo_hora');
        $this->db->order_by('id_tipo_hora', 'ASC');
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
  
    
    /**
     * Insetar nueva producto a la base de datos
     * @return number $insert_id : El ultimo id insertado
     */
    function insertarProducto($productoInfo)
    {
        $this->db->trans_start();
        $this->db->insert('producto', $productoInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * Obtener información de la tabla producto por id
     * @param number $id_producto : Id de la producto
     * @return array $result : Datos de la producto
     */
    function getProductoInfo($id_producto)
    {
        $this->db->select('id_producto, nombre, cantidad, costo, activo, fecha_alta, fecha_ultima_modificacion, id_tipo_producto, id_tipo_hora');
        $this->db->from('producto');
        $this->db->where('id_producto', $id_producto);
        $query = $this->db->get();
        
        return $query->row();
    }
    
    
    /**
     * Ejecuta un update a la base de datos
     * @param array $productoInfo : Datos de la producto
     * @param number $id_producto : Id de la producto
     */
    function actualizarProducto($productoInfo, $id_producto)
    {
        $this->db->where('id_producto', $id_producto);
        $this->db->update('producto', $productoInfo);
        
        return TRUE;
    }
    
    
    
    /**
     * Borrar un registro de la tabla producto
     * @param number $id_producto : Su id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteProducto($id_producto, $productoInfo)
    {
        $this->db->where('id_producto', $id_producto);
        $this->db->update('producto', $productoInfo);
        
        return $this->db->affected_rows();
    }

    
    /**
     * This function used to get producto information by id
     * @param number $id_producto : This is producto id
     * @return array $result : This is producto information
     */
    function getProductoInfoById($id_producto)
    {
        $this->db->select('id_producto, nombre');
        $this->db->from('producto');
        $this->db->where('id_producto', $id_producto);
        $query = $this->db->get();
        
        return $query->row();
    }



}

  