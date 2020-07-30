<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Base (BaseController)
 * Base Class to control all base related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Base extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('base_model');
        $this->isLoggedIn();   
    }
    
    /**
     * Carga la pantalla inicial de bases
     */
    public function index()
    {
        $this->global['pageTitle'] = 'FlightMex : Bases';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
    }
    
    /**
     * Carga la lista de bases
     */
    function bases()
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
            
            $count = $this->base_model->basesCount($searchText);
            // echo $count;
			$returns = $this->paginationCompress ( "catalogos/bases/", $count, 10 );
            // echo "<br/>Desde controller Page = ". $returns['page']. " Segmento = ". $returns['segment'];    
           
            
            $data['baseRecords'] = $this->base_model->bases($searchText, $returns["page"], $returns["segment"]);
           
            $someJSON = json_encode($data['baseRecords']);
            // echo $someJSON;

            $this->global['pageTitle'] = 'FlightMex : Bases';
            
            $this->loadViews("catalogos/bases", $this->global, $data, NULL);
        }
    }

    /**
     * Cargar el form de nueva base
     */
    function nuevaBase()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('base_model');
            
            $this->global['pageTitle'] = 'Admin : Agregar nuevo registro';

            $this->loadViews("catalogos/nuevaBase", $this->global, NULL);
        }
    }

    
    /**
     * Inserta en base de datos la nueva base
     */
    function insertarBase()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            // echo "aqui va";

            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('nombre','Nombre','trim|required|max_length[128]',
            array('required'=>'El campo Nombre es obligatorio.'));
     

            if($this->form_validation->run() == FALSE)
            {
                $this->nuevaBase();
            }
            else
            {
                $nombre = ucwords(strtolower($this->security->xss_clean($this->input->post('nombre'))));
                $calle = $this->security->xss_clean($this->input->post('calle'));
                $numero_exterior = $this->security->xss_clean($this->input->post('numero_exterior'));
                $numero_interior = $this->security->xss_clean($this->input->post('numero_interior'));
                $colonia = $this->security->xss_clean($this->input->post('colonia'));
                $municipio = $this->security->xss_clean($this->input->post('municipio'));
                $ciudad = $this->security->xss_clean($this->input->post('ciudad'));
                $estado = $this->security->xss_clean($this->input->post('estado'));
                $codigo_postal = $this->security->xss_clean($this->input->post('codigo_postal'));
                $pais = $this->security->xss_clean($this->input->post('pais'));
                $correo = $this->security->xss_clean($this->input->post('correo'));
                $telefono = $this->security->xss_clean($this->input->post('telefono'));


                // echo $nombre;

                $baseInfo = array( 'nombre'=> $nombre, 'calle'=> $calle, 'numero_exterior'=> $numero_exterior, 'numero_interior'=> $numero_interior, 'colonia'=> $colonia, 'municipio'=> $municipio, 'ciudad'=> $ciudad, 'estado'=> $estado, 'codigo_postal'=> $codigo_postal, 'pais'=> $pais, 'correo'=> $correo, 'telefono'=> $telefono, 'activo'=>1, 'fecha_alta'=>date('Y-m-d H:i:s'), 'fecha_ultima_modificacion'=>date('Y-m-d H:i:s'));
                
                $this->load->model('base_model');
                $result = $this->base_model->insertarBase($baseInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Operación finalizada correctamente.');
                }
                else
                {
                    $this->session->set_flashdata('error', 'No se pudo ejecutar la operacion.');
                }
                
                redirect('catalogos/bases');
            }
        }
    }

    
    /**
     * Dirigir a la edición de un registro de base
     * @param number $id_base  El id
     */
    function editarBase($id_base = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($id_base == null)
            {
                redirect('bases');
            }
            
            $data['baseInfo'] = $this->base_model->getBaseInfo($id_base);
            
            $this->global['pageTitle'] = 'FlightMex : Editar Base';
            
            $this->loadViews("catalogos/editarBase", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * Actualizar base
     */
    function actualizarBase()
    {
        // echo "desde el controller actualizarBase";

        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $id_base = $this->input->post('id_base');
            // echo "Id base actualiza = $id_base";
            
            $this->form_validation->set_rules('nombre','Nombre','trim|required|max_length[128]');
             
            if($this->form_validation->run() == FALSE)
            {
                $this->editarBase($id_base);
            }
            else
            {
                $nombre = ucwords(strtolower($this->security->xss_clean($this->input->post('nombre'))));
                $calle = $this->security->xss_clean($this->input->post('calle'));
                $numero_exterior = $this->security->xss_clean($this->input->post('numero_exterior'));
                $numero_interior = $this->security->xss_clean($this->input->post('numero_interior'));
                $colonia = $this->security->xss_clean($this->input->post('colonia'));
                $municipio = $this->security->xss_clean($this->input->post('municipio'));
                $ciudad = $this->security->xss_clean($this->input->post('ciudad'));
                $estado = $this->security->xss_clean($this->input->post('estado'));
                $codigo_postal = $this->security->xss_clean($this->input->post('codigo_postal'));
                $pais = $this->security->xss_clean($this->input->post('pais'));
                $correo = $this->security->xss_clean($this->input->post('correo'));
                $telefono = $this->security->xss_clean($this->input->post('telefono'));


                $activo = $this->input->post('activo') =="on" ? "1": "0";

                // echo "activo =" . $this->input->post('activo');
                
                
                $baseInfo = array();
                
             
                    
                $baseInfo = array( 'nombre'=> $nombre, 'calle'=> $calle, 'numero_exterior'=> $numero_exterior, 'numero_interior'=> $numero_interior, 'colonia'=> $colonia, 'municipio'=> $municipio, 'ciudad'=> $ciudad, 'estado'=> $estado, 'codigo_postal'=> $codigo_postal, 'pais'=> $pais, 'correo'=> $correo, 'telefono'=> $telefono, 'activo'=>1, 'fecha_alta'=>date('Y-m-d H:i:s'), 'fecha_ultima_modificacion'=>date('Y-m-d H:i:s'));

                    
               
                
                $result = $this->base_model->actualizarBase($baseInfo, $id_base);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Operación finalizada correctamente.');
                }
                else
                {
                    $this->session->set_flashdata('error', 'No se pudo ejecutar la operación.');
                }
                
                redirect('catalogos/bases');
            }
        }
    }

/**
     * Invocar un delete from a la tabla
     * @return boolean $result : TRUE / FALSE
     */
    function deleteBase()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $id_base = $this->input->post('id');
            $baseInfo = array('eliminado'=>1, 'fecha_ultima_modificacion'=>date('Y-m-d H:i:s'));
            
            $result = $this->base_model->deleteBase($id_base, $baseInfo);
            
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
