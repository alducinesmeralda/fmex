<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Categoria (CategoriaController)
 * Categoria Class to control all categoria related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Categoria extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('categoria_model');
        $this->isLoggedIn();   
    }
    
    /**
     * Carga la pantalla inicial de categorias
     */
    public function index()
    {
        $this->global['pageTitle'] = 'FlightMex : Categorias';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
    }
    
    /**
     * Carga la lista de categorias
     */
    function categorias()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {        
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
          
            $this->load->library('pagination');
            
            $count = $this->categoria_model->categoriasCount($searchText);
            // echo $count;
			$returns = $this->paginationCompress ( "catalogos/categorias/", $count, 10 );
            // echo "<br/>Desde controller Page = ". $returns['page']. " Segmento = ". $returns['segment'];    
           
            
            $data['categoriaRecords'] = $this->categoria_model->categorias($searchText, $returns["page"], $returns["segment"]);
            
            $someJSON = json_encode($data['categoriaRecords']);
            // echo $someJSON;
            
            $this->global['pageTitle'] = 'FlightMex : Categorias';
            
            $this->loadViews("catalogos/categorias", $this->global, $data, NULL);
        }
    }

    /**
     * Cargar el form de nueva categoria
     */
    function nuevaCategoria()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('categoria_model');
            
            $this->global['pageTitle'] = 'Admin : Agregar nuevo registro';

            $this->loadViews("catalogos/nuevaCategoria", $this->global, NULL);
        }
    }

    
    /**
     * Inserta en base de datos la nueva categoria
     */
    function insertarCategoria()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            // echo "aqui va";

            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('descripcion_categoria','Descripcion_categoria','trim|required|max_length[128]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->nuevaCategoria();
            }
            else
            {
                $descripcion_categoria = ucwords(strtolower($this->security->xss_clean($this->input->post('descripcion_categoria'))));
                $id_tipo_categoria = $this->security->xss_clean($this->input->post('id_tipo_categoria'));

                $categoriaInfo = array( 'descripcion_categoria'=> $descripcion_categoria, 'id_tipo_categoria'=> $id_tipo_categoria,'activo'=>1, 'fecha_alta'=>date('Y-m-d H:i:s'), 'fecha_ultima_modificacion'=>date('Y-m-d H:i:s'));
                
                $this->load->model('categoria_model');
                $result = $this->categoria_model->insertarCategoria($categoriaInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Operación finalizada correctamente.');
                }
                else
                {
                    $this->session->set_flashdata('error', 'No se pudo ejecutar la operacion.');
                }
                
                redirect('catalogos/categorias');
            }
        }
    }

    
    /**
     * Dirigir a la edición de un registro de categoria
     * @param number $id_categoria  El id
     */
    function editarCategoria($id_categoria = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($id_categoria == null)
            {
                redirect('categorias');
            }
            
            $data['categoriaInfo'] = $this->categoria_model->getCategoriaInfo($id_categoria);
            
            $this->global['pageTitle'] = 'FlightMex : Editar Categoria';
            
            $this->loadViews("catalogos/editarCategoria", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * Actualizar categoria
     */
    function actualizarCategoria()
    {
        // echo "desde el controller actualizarCategoria";

        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $id_categoria = $this->input->post('id_categoria');
            
            $this->form_validation->set_rules('descripcion_categoria','Descripcion_categoria','trim|required|max_length[128]');
             
            if($this->form_validation->run() == FALSE)
            {
                $this->editarCategoria($id_categoria);
            }
            else
            {
                $descripcion_categoria = ucwords(strtolower($this->security->xss_clean($this->input->post('descripcion_categoria'))));
                $id_tipo_categoria = $this->security->xss_clean($this->input->post('id_tipo_categoria'));
                

                $activo = $this->input->post('activo') =="on" ? "1": "0";

                // echo "activo =" . $this->input->post('activo');
                
                
                $categoriaInfo = array();
                
                // id_tipo_categoria = 0 escuela, 
                // id_tipo_categoria = 1 aviones, 
                    

                $categoriaInfo = array( 'descripcion_categoria'=> $descripcion_categoria, 'id_tipo_categoria'=> $id_tipo_categoria, 'activo'=>$activo, 'fecha_alta'=>date('Y-m-d H:i:s'), 'fecha_ultima_modificacion'=>date('Y-m-d H:i:s'));


                    
               
                
                $result = $this->categoria_model->actualizarCategoria($categoriaInfo, $id_categoria);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Operación finalizada correctamente.');
                }
                else
                {
                    $this->session->set_flashdata('error', 'No se pudo ejecutar la operación.');
                }
                
                redirect('catalogos/categorias');
            }
        }
    }


    /**
     * Invocar un delete from a la tabla
     * @return boolean $result : TRUE / FALSE
     */
    function deleteCategoria()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $id_categoria = $this->input->post('id');
            $categoriaInfo = array('eliminado'=>1, 'fecha_ultima_modificacion'=>date('Y-m-d H:i:s'));
            
            $result = $this->categoria_model->deleteCategoria($id_categoria, $categoriaInfo);
            
            if ($result > 0) { 
                echo(json_encode(array('status'=>TRUE))); 
            }
            else { 
                echo(json_encode(array('status'=>FALSE))); 
            }
        }
    }
    
    /**
     * Page not found : error 404
     */
    function pageNotFound()
    {
        $this->global['pageTitle'] = 'Fmex : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }

    
}
