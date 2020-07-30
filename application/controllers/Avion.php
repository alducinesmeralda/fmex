<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Avion (AvionController)
 * Avion Class to control all avion related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Avion extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('avion_model');
        $this->isLoggedIn();   
    }
    
    /**
     * Carga la pantalla inicial de aviones
     */
    public function index()
    {
        $this->global['pageTitle'] = 'FlightMex : Aviones';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
    }
    
    /**
     * Carga la lista de listaAviones
     */
    function aviones()
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
            
            $count = $this->avion_model->avionesCount($searchText);
            // echo $count;
			$returns = $this->paginationCompress ( "catalogos/aviones/", $count, 10 );
            // echo "<br/>Desde controller Page = ". $returns['page']. " Segmento = ". $returns['segment'];    
           
            
            $data['avionRecords'] = $this->avion_model->aviones($searchText, $returns["page"], $returns["segment"]);
           
            $someJSON = json_encode($data['avionRecords']);
            // echo $someJSON;
            
            $this->global['pageTitle'] = 'FlightMex : Aviones';
            
            $this->loadViews("catalogos/aviones", $this->global, $data, NULL);
        }
    }


   


    /**
     * Cargar el form de nuevo avion
     */
    function nuevoAvion()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('avion_model');
            
            $this->global['pageTitle'] = 'Admin : Agregar nuevo registro';

            $data['tipoHoraRecords'] = $this->avion_model->tiposHora();


            $this->loadViews("catalogos/nuevoAvion", $this->global, $data, NULL);
        }
    }

    
    /**
     * Inserta en base de datos la nuevo avion
     */
    function insertarAvion()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            // echo "aqui va";

            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('matricula','Matricula','trim|required|max_length[128]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->nuevoAvion();
            }
            else
            {
                $matricula = ucwords(strtolower($this->security->xss_clean($this->input->post('matricula'))));
                $marca =$this->security->xss_clean($this->input->post('marca'));
                $modelo =$this->security->xss_clean($this->input->post('modelo'));
                $year_fabricacion =$this->security->xss_clean($this->input->post('year_fabricacion'));
                $id_tipo_avion =$this->security->xss_clean($this->input->post('id_tipo_avion'));
                $numero_serie =$this->security->xss_clean($this->input->post('numero_serie'));
                $serie_motor1 =$this->security->xss_clean($this->input->post('serie_motor1'));
                $marca_motor1 =$this->security->xss_clean($this->input->post('marca_motor1'));
                $serie_motor2 =$this->security->xss_clean($this->input->post('serie_motor2'));
                $marca_motor2 =$this->security->xss_clean($this->input->post('marca_motor2'));
                $serie_helice1 =$this->security->xss_clean($this->input->post('serie_helice1'));
                $marca_helice1 =$this->security->xss_clean($this->input->post('marca_helice1'));
                $serie_helice2 =$this->security->xss_clean($this->input->post('serie_helice2'));
                $marca_helice2 =$this->security->xss_clean($this->input->post('marca_helice2'));
                $numero_asientos =$this->security->xss_clean($this->input->post('numero_asientos'));
                $horas_alta_avion =$this->security->xss_clean($this->input->post('horas_alta_avion'));
                $horas_alta_motor1 =$this->security->xss_clean($this->input->post('horas_alta_motor1'));
                $horas_alta_motor2 =$this->security->xss_clean($this->input->post('horas_alta_motor2'));
                $horas_alta_helice1 =$this->security->xss_clean($this->input->post('horas_alta_helice1'));
                $horas_alta_helice2 =$this->security->xss_clean($this->input->post('horas_alta_helice2'));
                $certificado_aeronautico =$this->security->xss_clean($this->input->post('certificado_aeronautico'));
                $fecha_expedicion_certificado =$this->security->xss_clean($this->input->post('fecha_expedicion_certificado'));
                $poliza_seguro =$this->security->xss_clean($this->input->post('poliza_seguro'));
                $fecha_expedicion_seguro =$this->security->xss_clean($this->input->post('fecha_expedicion_seguro'));
                $combustible =$this->security->xss_clean($this->input->post('combustible'));
                $consumo_combustible =$this->security->xss_clean($this->input->post('consumo_combustible'));
                $id_tipo_combustible =$this->security->xss_clean($this->input->post('id_tipo_combustible'));
                $aceite =$this->security->xss_clean($this->input->post('aceite'));
                $consumo_aceite =$this->security->xss_clean($this->input->post('consumo_aceite'));
                $mantenimiento =$this->security->xss_clean($this->input->post('mantenimiento'));
                $ifr =$this->security->xss_clean($this->input->post('ifr'));
                $id_tipo_hora =$this->security->xss_clean($this->input->post('id_tipo_hora'));


                $avionInfo = array( 'matricula'=> $matricula, 'activo'=>1,'marca'=>$marca, 'modelo'=>$modelo, 'year_fabricacion'=>$year_fabricacion, 'id_tipo_avion'=>$id_tipo_avion, 'numero_serie'=>$numero_serie, 'serie_motor1'=>$serie_motor1, 'marca_motor1'=>$marca_motor1, 'serie_motor2'=>$serie_motor2, 'marca_motor2'=>$marca_motor2, 'serie_helice1'=>$serie_helice1, 'marca_helice1'=>$marca_helice1, 'serie_helice2'=>$serie_helice2, 'marca_helice2'=>$marca_helice2, 'numero_asientos'=>$numero_asientos, 'horas_alta_avion'=>$horas_alta_avion, 'horas_alta_motor1'=>$horas_alta_motor1, 'horas_alta_motor2'=>$horas_alta_motor2, 'horas_alta_helice1'=>$horas_alta_helice1,'horas_alta_helice2'=>$horas_alta_helice2,'certificado_aeronautico'=>$certificado_aeronautico, 'poliza_seguro'=>$poliza_seguro, 'combustible'=>$combustible, 'consumo_combustible'=>$consumo_combustible, 'id_tipo_combustible'=>$id_tipo_combustible, 'consumo_aceite'=>$consumo_aceite, 'aceite'=>$aceite, 'mantenimiento'=>$mantenimiento, 'ifr'=>$ifr, 'id_tipo_hora'=>$id_tipo_hora, 'fecha_expedicion_seguro'=>date('Y-m-d H:i:s'), 'fecha_expedicion_certificado'=>date('Y-m-d H:i:s'),'fecha_alta'=>date('Y-m-d H:i:s'), 'fecha_ultima_modificacion'=>date('Y-m-d H:i:s'));

                $this->load->model('avion_model');
                $result = $this->avion_model->insertarAvion($avionInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Operación finalizada correctamente.');
                }
                else
                {
                    $this->session->set_flashdata('error', 'No se pudo ejecutar la operacion.');
                }
                
                redirect('catalogos/aviones');
            }
        }
    }

    
    /**
     * Dirigir a la edición de un registro de avion
     * @param number $id_avion  El id
     */
    function editarAvion($id_avion = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($id_avion == null)
            {
                redirect('aviones');
            }
            
            $data['avionInfo'] = $this->avion_model->getAvionInfo($id_avion);
            
            $data['tipoHoraRecords'] = $this->avion_model->tiposHora();


            $this->global['pageTitle'] = 'FlightMex : Editar Avion';
            
            $this->loadViews("catalogos/editarAvion", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * Actualizar avion, lo envia a la base de datos
     */
    function actualizarAvion()
    {
        // echo "desde el controller actualizarAvion";

        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $id_avion = $this->input->post('id_avion');
            
            $this->form_validation->set_rules('matricula','Matricula','trim|required|max_length[128]');
             
            if($this->form_validation->run() == FALSE)
            {
                $this->editarAvion($id_avion);
            }
            else
            {
                $matricula = ucwords(strtolower($this->security->xss_clean($this->input->post('matricula'))));
                $marca =$this->security->xss_clean($this->input->post('marca'));
                $modelo =$this->security->xss_clean($this->input->post('modelo'));
                $year_fabricacion =$this->security->xss_clean($this->input->post('year_fabricacion'));
                $id_tipo_avion =$this->security->xss_clean($this->input->post('id_tipo_avion'));
                $numero_serie =$this->security->xss_clean($this->input->post('numero_serie'));
                $serie_motor1 =$this->security->xss_clean($this->input->post('serie_motor1'));
                $marca_motor1 =$this->security->xss_clean($this->input->post('marca_motor1'));
                $serie_motor2 =$this->security->xss_clean($this->input->post('serie_motor2'));
                $marca_motor2 =$this->security->xss_clean($this->input->post('marca_motor2'));
                $serie_helice1 =$this->security->xss_clean($this->input->post('serie_helice1'));
                $marca_helice1 =$this->security->xss_clean($this->input->post('marca_helice1'));
                $serie_helice2 =$this->security->xss_clean($this->input->post('serie_helice2'));
                $marca_helice2 =$this->security->xss_clean($this->input->post('marca_helice2'));
                $numero_asientos =$this->security->xss_clean($this->input->post('numero_asientos'));
                $horas_alta_avion =$this->security->xss_clean($this->input->post('horas_alta_avion'));
                $horas_alta_motor1 =$this->security->xss_clean($this->input->post('horas_alta_motor1'));
                $horas_alta_motor2 =$this->security->xss_clean($this->input->post('horas_alta_motor2'));
                $horas_alta_helice1 =$this->security->xss_clean($this->input->post('horas_alta_helice1'));
                $horas_alta_helice2 =$this->security->xss_clean($this->input->post('horas_alta_helice2'));
                $certificado_aeronautico =$this->security->xss_clean($this->input->post('certificado_aeronautico'));
                $fecha_expedicion_certificado =$this->security->xss_clean($this->input->post('fecha_expedicion_certificado'));
                $poliza_seguro =$this->security->xss_clean($this->input->post('poliza_seguro'));
                $fecha_expedicion_seguro =$this->security->xss_clean($this->input->post('fecha_expedicion_seguro'));
                $combustible =$this->security->xss_clean($this->input->post('combustible'));
                $consumo_combustible =$this->security->xss_clean($this->input->post('consumo_combustible'));
                $id_tipo_combustible =$this->security->xss_clean($this->input->post('id_tipo_combustible'));
                $aceite =$this->security->xss_clean($this->input->post('aceite'));
                $consumo_aceite =$this->security->xss_clean($this->input->post('consumo_aceite'));
                $mantenimiento =$this->security->xss_clean($this->input->post('mantenimiento'));
                $ifr =$this->security->xss_clean($this->input->post('ifr'));
                $id_tipo_hora =$this->security->xss_clean($this->input->post('id_tipo_hora'));

                $activo = $this->input->post('activo') =="on" ? "1": "0";

                //echo "id_tipo_hora =" . $id_tipo_hora;
                
                
                $avionInfo = array();

                $avionInfo = array( 'matricula'=> $matricula, 'activo'=>$activo,'marca'=>$marca, 'modelo'=>$modelo, 'year_fabricacion'=>$year_fabricacion, 'id_tipo_avion'=>$id_tipo_avion, 'numero_serie'=>$numero_serie, 'serie_motor1'=>$serie_motor1, 'marca_motor1'=>$marca_motor1, 'serie_motor2'=>$serie_motor2, 'marca_motor2'=>$marca_motor2, 'serie_helice1'=>$serie_helice1, 'marca_helice1'=>$marca_helice1, 'serie_helice2'=>$serie_helice2, 'marca_helice2'=>$marca_helice2, 'numero_asientos'=>$numero_asientos, 'horas_alta_avion'=>$horas_alta_avion, 'horas_alta_motor1'=>$horas_alta_motor1, 'horas_alta_motor2'=>$horas_alta_motor2, 'horas_alta_helice1'=>$horas_alta_helice1,'horas_alta_helice2'=>$horas_alta_helice2,'certificado_aeronautico'=>$certificado_aeronautico, 'poliza_seguro'=>$poliza_seguro, 'combustible'=>$combustible, 'consumo_combustible'=>$consumo_combustible, 'id_tipo_combustible'=>$id_tipo_combustible, 'consumo_aceite'=>$consumo_aceite, 'aceite'=>$aceite, 'mantenimiento'=>$mantenimiento, 'ifr'=>$ifr, 'id_tipo_hora'=>$id_tipo_hora, 'fecha_expedicion_seguro'=>date('Y-m-d H:i:s'), 'fecha_expedicion_certificado'=>date('Y-m-d H:i:s'),'fecha_alta'=>date('Y-m-d H:i:s'), 'fecha_ultima_modificacion'=>date('Y-m-d H:i:s'));


                $result = $this->avion_model->actualizarAvion($avionInfo, $id_avion);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Operación finalizada correctamente.');
                }
                else
                {
                    $this->session->set_flashdata('error', 'No se pudo ejecutar la operación.');
                }
                
                redirect('catalogos/aviones');
            }
        }
    }


    /**
     * Invocar un delete from a la tabla
     * @return boolean $result : TRUE / FALSE
     */
    function deleteAvion()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $id_avion = $this->input->post('id');
            $avionInfo = array('eliminado'=>1, 'fecha_ultima_modificacion'=>date('Y-m-d H:i:s'));
            
            $result = $this->avion_model->deleteAvion($id_avion, $avionInfo);
            
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
