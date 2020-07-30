<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Licencia (LicenciaController)
 * Licencia Class to control all licencia related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Licencia extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('licencia_model');
        $this->isLoggedIn();   
    }
    
    /**
     * Carga la pantalla inicial de licencias
     */
    public function index()
    {
        $this->global['pageTitle'] = 'FlightMex : Licencias';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
    }
    
    /**
     * Carga la lista de licencias
     */
    function licencias()
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
            
            $count = $this->licencia_model->licenciasCount($searchText);
            // echo $count;
			$returns = $this->paginationCompress ( "catalogos/licencias/", $count, 10 );
            // echo "<br/>Desde controller Page = ". $returns['page']. " Segmento = ". $returns['segment'];    
           
            
            $data['licenciaRecords'] = $this->licencia_model->licencias($searchText, $returns["page"], $returns["segment"]);
            // echo $data['licenciaRecords']->nombre;
            
            $this->global['pageTitle'] = 'FlightMex : Licencias';
            
            $this->loadViews("catalogos/licencias", $this->global, $data, NULL);
        }
    }

    /**
     * Cargar el form de nueva licencia
     */
    function nuevaLicencia()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('licencia_model');
            
            $this->global['pageTitle'] = 'Admin : Agregar nuevo registro';

            $this->loadViews("catalogos/nuevaLicencia", $this->global, NULL);
        }
    }

    
    /**
     * Inserta en base de datos la nueva licencia
     */
    function insertarLicencia()
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
                $this->nuevaLicencia();
            }
            else
            {
                $nombre = ucwords(strtolower($this->security->xss_clean($this->input->post('nombre'))));
                // echo $nombre;

                $licenciaInfo = array( 'nombre'=> $nombre, 'activo'=>1, 'fecha_alta'=>date('Y-m-d H:i:s'), 'fecha_ultima_modificacion'=>date('Y-m-d H:i:s'));
                
                $this->load->model('licencia_model');
                $result = $this->licencia_model->insertarLicencia($licenciaInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Operación finalizada correctamente.');
                }
                else
                {
                    $this->session->set_flashdata('error', 'No se pudo ejecutar la operacion.');
                }
                
                redirect('catalogos/licencias');
            }
        }
    }

    
    /**
     * Dirigir a la edición de un registro de licencia
     * @param number $id_licencia  El id
     */
    function editarLicencia($id_licencia = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($id_licencia == null)
            {
                redirect('licencias');
            }
            
            $data['licenciaInfo'] = $this->licencia_model->getLicenciaInfo($id_licencia);
            
            $this->global['pageTitle'] = 'FlightMex : Editar Licencia';
            
            $this->loadViews("catalogos/editarLicencia", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * Actualizar licencia
     */
    function actualizarLicencia()
    {
        // echo "desde el controller actualizarLicencia";

        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $id_licencia = $this->input->post('id_licencia');
            // echo "Id licencia actualiza = $id_licencia";
            
            $this->form_validation->set_rules('nombre','Nombre','trim|required|max_length[128]');
             
            if($this->form_validation->run() == FALSE)
            {
                $this->editarLicencia($id_licencia);
            }
            else
            {
                $nombre = ucwords(strtolower($this->security->xss_clean($this->input->post('nombre'))));
                

                $activo = $this->input->post('activo') =="on" ? "1": "0";

                // echo "activo =" . $this->input->post('activo');
                
                
                $licenciaInfo = array();
                
             
                    
                $licenciaInfo = array( 'nombre'=> $nombre, 'activo'=>$activo, 'fecha_alta'=>date('Y-m-d H:i:s'), 'fecha_ultima_modificacion'=>date('Y-m-d H:i:s'));


                    
               
                
                $result = $this->licencia_model->actualizarLicencia($licenciaInfo, $id_licencia);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Operación finalizada correctamente.');
                }
                else
                {
                    $this->session->set_flashdata('error', 'No se pudo ejecutar la operación.');
                }
                
                redirect('catalogos/licencias');
            }
        }
    }


    /**
     * Invocar un delete from a la tabla
     * @return boolean $result : TRUE / FALSE
     */
    function deleteLicencia()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $id_licencia = $this->input->post('id');
            $licenciaInfo = array('eliminado'=>1, 'fecha_ultima_modificacion'=>date('Y-m-d H:i:s'));
            
            $result = $this->licencia_model->deleteLicencia($id_licencia, $licenciaInfo);
            
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
