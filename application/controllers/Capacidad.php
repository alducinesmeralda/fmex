<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Capacidad (CapacidadController)
 * Capacidad Class to control all capacidad related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Capacidad extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('capacidad_model');
        $this->isLoggedIn();   
    }
    
    /**
     * Carga la pantalla inicial de capacidades
     */
    public function index()
    {
        $this->global['pageTitle'] = 'FlightMex : Capacidades';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
    }
    
    /**
     * Carga la lista de listaCapacidades
     */
    function capacidades()
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
            
            $count = $this->capacidad_model->capacidadesCount($searchText);
            // echo $count;
			$returns = $this->paginationCompress ( "catalogos/capacidades/", $count, 10 );
            // echo "<br/>Desde controller Page = ". $returns['page']. " Segmento = ". $returns['segment'];    
           
            
            $data['capacidadRecords'] = $this->capacidad_model->capacidades($searchText, $returns["page"], $returns["segment"]);
            
            $someJSON = json_encode($data['capacidadRecords']);
            // echo $someJSON;

            $this->global['pageTitle'] = 'FlightMex : Capacidades';
            
            $this->loadViews("catalogos/capacidades", $this->global, $data, NULL);
        }
    }

    /**
     * Cargar el form de nueva capacidad
     */
    function nuevaCapacidad()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('capacidad_model');
            
            $this->global['pageTitle'] = 'Admin : Agregar nuevo registro';

            $this->loadViews("catalogos/nuevaCapacidad", $this->global, NULL);
        }
    }

    
    /**
     * Inserta en base de datos la nueva capacidad
     */
    function insertarCapacidad()
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
                $this->nuevaCapacidad();
            }
            else
            {
                $nombre = ucwords(strtolower($this->security->xss_clean($this->input->post('nombre'))));
                // echo $nombre;

                $capacidadInfo = array( 'nombre'=> $nombre, 'activo'=>1, 'fecha_alta'=>date('Y-m-d H:i:s'), 'fecha_ultima_modificacion'=>date('Y-m-d H:i:s'));
                
                $this->load->model('capacidad_model');
                $result = $this->capacidad_model->insertarCapacidad($capacidadInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Operación finalizada correctamente.');
                }
                else
                {
                    $this->session->set_flashdata('error', 'No se pudo ejecutar la operacion.');
                }
                
                redirect('catalogos/capacidades');
            }
        }
    }

    
    /**
     * Dirigir a la edición de un registro de capacidad
     * @param number $id_capacidad  El id
     */
    function editarCapacidad($id_capacidad = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($id_capacidad == null)
            {
                redirect('capacidades');
            }
            
            $data['capacidadInfo'] = $this->capacidad_model->getCapacidadInfo($id_capacidad);
            
            $this->global['pageTitle'] = 'FlightMex : Editar Capacidad';
            
            $this->loadViews("catalogos/editarCapacidad", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * Actualizar capacidad
     */
    function actualizarCapacidad()
    {
        // echo "desde el controller actualizarCapacidad";

        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $id_capacidad = $this->input->post('id_capacidad');
            // echo "Id capacidad actualiza = $id_capacidad";
            
            $this->form_validation->set_rules('nombre','Nombre','trim|required|max_length[128]');
             
            if($this->form_validation->run() == FALSE)
            {
                $this->editarCapacidad($id_capacidad);
            }
            else
            {
                $nombre = ucwords(strtolower($this->security->xss_clean($this->input->post('nombre'))));
                

                $activo = $this->input->post('activo') =="on" ? "1": "0";

                // echo "activo =" . $this->input->post('activo');
                
                
                $capacidadInfo = array();
                
             
                    
                $capacidadInfo = array( 'nombre'=> $nombre, 'activo'=>$activo, 'fecha_alta'=>date('Y-m-d H:i:s'), 'fecha_ultima_modificacion'=>date('Y-m-d H:i:s'));


                    
               
                
                $result = $this->capacidad_model->actualizarCapacidad($capacidadInfo, $id_capacidad);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Operación finalizada correctamente.');
                }
                else
                {
                    $this->session->set_flashdata('error', 'No se pudo ejecutar la operación.');
                }
                
                redirect('catalogos/capacidades');
            }
        }
    }


    /**
     * Invocar un delete from a la tabla
     * @return boolean $result : TRUE / FALSE
     */
    function deleteCapacidad()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $id_capacidad = $this->input->post('id');
            $capacidadInfo = array('eliminado'=>1, 'fecha_ultima_modificacion'=>date('Y-m-d H:i:s'));
            
            $result = $this->capacidad_model->deleteCapacidad($id_capacidad, $capacidadInfo);
            
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
