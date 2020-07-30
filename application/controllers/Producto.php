<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Producto (ProductoController)
 * Producto Class to control all producto related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Producto extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('producto_model');
        $this->isLoggedIn();   
    }
    
    /**
     * Carga la pantalla inicial de productos
     */
    public function index()
    {
        $this->global['pageTitle'] = 'FlightMex : Productos';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
    }
    
    /**
     * Carga la lista de listaProductos
     */
    function productos()
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
            
            $count = $this->producto_model->productosCount($searchText);
            // echo $count;
			$returns = $this->paginationCompress ( "catalogos/productos/", $count, 10 );
            // echo "<br/>Desde controller Page = ". $returns['page']. " Segmento = ". $returns['segment'];    
           
            
            $data['productoRecords'] = $this->producto_model->productos($searchText, $returns["page"], $returns["segment"]);
           
            $someJSON = json_encode($data['productoRecords']);
            // echo $someJSON;
            
            $this->global['pageTitle'] = 'FlightMex : Productos';
            
            $this->loadViews("catalogos/productos", $this->global, $data, NULL);
        }
    }


   


    /**
     * Cargar el form de nuevo producto
     */
    function nuevoProducto()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('producto_model');
            
            $this->global['pageTitle'] = 'Admin : Agregar nuevo registro';

            $data['tipoHoraRecords'] = $this->producto_model->tiposHora();


            $this->loadViews("catalogos/nuevoProducto", $this->global, $data, NULL);
        }
    }

    
    /**
     * Inserta en base de datos la nuevo producto
     */
    function insertarProducto()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            // echo "aqui va";

            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('nombre','Nombre','trim|required|max_length[128]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->nuevoProducto();
            }
            else
            {
                $nombre = ucwords(strtolower($this->security->xss_clean($this->input->post('nombre'))));
                $cantidad =$this->security->xss_clean($this->input->post('cantidad'));
                $costo =$this->security->xss_clean($this->input->post('costo'));
                // $id_tipo_producto =$this->security->xss_clean($this->input->post('id_tipo_producto'));
                $id_tipo_hora =$this->security->xss_clean($this->input->post('id_tipo_hora'));


                $productoInfo = array( 'nombre'=> $nombre, 'activo'=>1,'cantidad'=>$cantidad, 'costo'=>$costo, 'id_tipo_hora'=>$id_tipo_hora,'fecha_alta'=>date('Y-m-d H:i:s'), 'fecha_ultima_modificacion'=>date('Y-m-d H:i:s'));

                $this->load->model('producto_model');
                $result = $this->producto_model->insertarProducto($productoInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Operación finalizada correctamente.');
                }
                else
                {
                    $this->session->set_flashdata('error', 'No se pudo ejecutar la operacion.');
                }
                
                redirect('catalogos/productos');
            }
        }
    }

    
    /**
     * Dirigir a la edición de un registro de producto
     * @param number $id_producto  El id
     */
    function editarProducto($id_producto = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($id_producto == null)
            {
                redirect('productos');
            }
            
            $data['productoInfo'] = $this->producto_model->getProductoInfo($id_producto);
            
            $data['tipoHoraRecords'] = $this->producto_model->tiposHora();


            $this->global['pageTitle'] = 'FlightMex : Editar Producto';
            
            $this->loadViews("catalogos/editarProducto", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * Actualizar producto, lo envia a la base de datos
     */
    function actualizarProducto()
    {
        // echo "desde el controller actualizarProducto";

        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $id_producto = $this->input->post('id_producto');
            
            $this->form_validation->set_rules('nombre','Nombre','trim|required|max_length[128]');
             
            if($this->form_validation->run() == FALSE)
            {
                $this->editarProducto($id_producto);
            }
            else
            {
                $nombre = ucwords(strtolower($this->security->xss_clean($this->input->post('nombre'))));
                $cantidad =$this->security->xss_clean($this->input->post('cantidad'));
                $costo =$this->security->xss_clean($this->input->post('costo'));
                // $id_tipo_producto =$this->security->xss_clean($this->input->post('id_tipo_producto'));
                $id_tipo_hora =$this->security->xss_clean($this->input->post('id_tipo_hora'));

                $activo = $this->input->post('activo') =="on" ? "1": "0";

                //echo "id_tipo_hora =" . $id_tipo_hora;
                
                
                $productoInfo = array();

                $productoInfo = array( 'nombre'=> $nombre, 'activo'=>$activo,'cantidad'=>$cantidad, 'costo'=>$costo, 'id_tipo_hora'=>$id_tipo_hora,'fecha_alta'=>date('Y-m-d H:i:s'), 'fecha_ultima_modificacion'=>date('Y-m-d H:i:s'));

                $result = $this->producto_model->actualizarProducto($productoInfo, $id_producto);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Operación finalizada correctamente.');
                }
                else
                {
                    $this->session->set_flashdata('error', 'No se pudo ejecutar la operación.');
                }
                
                redirect('catalogos/productos');
            }
        }
    }


    /**
     * Invocar un delete from a la tabla
     * @return boolean $result : TRUE / FALSE
     */
    function deleteProducto()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $id_producto = $this->input->post('id');
            $productoInfo = array('eliminado'=>1, 'fecha_ultima_modificacion'=>date('Y-m-d H:i:s'));
            
            $result = $this->producto_model->deleteProducto($id_producto, $productoInfo);
            
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
