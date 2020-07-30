<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : TipoHora (TipoHoraController)
 * TipoHora Class to control all tipoHora related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class TipoHora extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tipoHora_model');
        $this->isLoggedIn();   
    }
    
    /**
     * Carga la pantalla inicial de tipoHoraes
     */
    public function index()
    {
        $this->global['pageTitle'] = 'FlightMex : TipoHora';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
    }
    
    /**
     * Carga la lista de listaTiposHora
     */
    function tiposHora()
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
            
            $count = $this->tipoHora_model->tiposHoraCount($searchText);
            // echo $count;
			$returns = $this->paginationCompress ( "catalogos/tiposHora/", $count, 10 );
            // echo "<br/>Desde controller Page = ". $returns['page']. " Segmento = ". $returns['segment'];    
           
            
            $data['tipoHoraRecords'] = $this->tipoHora_model->tiposHora($searchText, $returns["page"], $returns["segment"]);
            // echo $data['tipoHoraRecords']->nombre;
            $someJSON = json_encode($data['tipoHoraRecords']);
            // echo $someJSON;
            
            $this->global['pageTitle'] = 'FlightMex : TiposHora';
            
            $this->loadViews("catalogos/tiposHora", $this->global, $data, NULL);
        }
    }

    /**
     * Cargar el form de nueva tipoHora
     */
    function nuevaTipoHora()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('tipoHora_model');
            
            $this->global['pageTitle'] = 'Admin : Agregar nuevo registro';

            $this->loadViews("catalogos/nuevoTipoHora", $this->global, NULL);
        }
    }

    
    /**
     * Inserta en base de datos la nueva tipoHora
     */
    function insertarTipoHora()
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
                $this->nuevaTipoHora();
            }
            else
            {
                $nombre = ucwords(strtolower($this->security->xss_clean($this->input->post('nombre'))));
                // echo $nombre;

                $tipoHoraInfo = array( 'nombre'=> $nombre, 'activo'=>1, 'fecha_alta'=>date('Y-m-d H:i:s'), 'fecha_ultima_modificacion'=>date('Y-m-d H:i:s'));
                
                $this->load->model('tipoHora_model');
                $result = $this->tipoHora_model->insertarTipoHora($tipoHoraInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Operación finalizada correctamente.');
                }
                else
                {
                    $this->session->set_flashdata('error', 'No se pudo ejecutar la operacion.');
                }
                
                redirect('catalogos/tiposHora');
            }
        }
    }

    
    /**
     * Dirigir a la edición de un registro de tipoHora
     * @param number $id_tipo_hora  El id
     */
    function editarTipoHora($id_tipo_hora = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($id_tipo_hora == null)
            {
                redirect('tipoHora');
            }
            
            $data['tipoHoraInfo'] = $this->tipoHora_model->getTipoHoraInfo($id_tipo_hora);
            
            $this->global['pageTitle'] = 'FlightMex : Editar TipoHora';
            
            $this->loadViews("catalogos/editarTipoHora", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * Actualizar tipoHora
     */
    function actualizarTipoHora()
    {
        // echo "desde el controller actualizarTipoHora";

        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $id_tipo_hora = $this->input->post('id_tipo_hora');
            // echo "Id tipoHora actualiza = $id_tipoHora";
            
            $this->form_validation->set_rules('nombre','Nombre','trim|required|max_length[128]');
             
            if($this->form_validation->run() == FALSE)
            {
                $this->editarTipoHora($id_tipo_hora);
            }
            else
            {
                $nombre = ucwords(strtolower($this->security->xss_clean($this->input->post('nombre'))));
                

                $activo = $this->input->post('activo') =="on" ? "1": "0";

                // echo "activo =" . $this->input->post('activo');
                
                
                $tipoHoraInfo = array();
                
             
                    
                $tipoHoraInfo = array( 'nombre'=> $nombre, 'activo'=>$activo, 'fecha_alta'=>date('Y-m-d H:i:s'), 'fecha_ultima_modificacion'=>date('Y-m-d H:i:s'));


                    
               
                
                $result = $this->tipoHora_model->actualizarTipoHora($tipoHoraInfo, $id_tipo_hora);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Operación finalizada correctamente.');
                }
                else
                {
                    $this->session->set_flashdata('error', 'No se pudo ejecutar la operación.');
                }
                
                redirect('catalogos/tiposHora');
            }
        }
    }


    /**
     * Invocar un delete from a la tabla
     * @return boolean $result : TRUE / FALSE
     */
    function deleteTipoHora()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $id_tipo_hora = $this->input->post('id');
            $tipoHoraInfo = array('eliminado'=>1, 'fecha_ultima_modificacion'=>date('Y-m-d H:i:s'));
            
            $result = $this->tipoHora_model->deleteTipoHora($id_tipo_hora, $tipoHoraInfo);
            
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
