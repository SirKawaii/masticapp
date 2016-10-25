<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Busqueda extends CI_Controller{

    public $pagina, $nombreSitio, $variables;

    function __construct(){
        parent::__construct();
        //helpers
        $this->load->helper('url');
        //bibliotecas
        $this->load->library('navegacion', array('mapa','lista'));
        //modelos
        $this->load->model('dir_locales_model');

        //inicializacion de Atributos Globales
        $this->nombreSitio = 'Masticapp';
        $this->pagina = 'Mapa';
        $this->variables['navegacion'] = $this->navegacion->construir_Navegacion();

        $this->variables['nombreSitio'] = $this->nombreSitio;
        $this->variables['titulo'] = ucfirst($this->pagina); // Capitalize the first letter

        //FinAtributos


    }

    public function index (){
        $this->load->view('tema/header',$this->variables);
        $this->load->view('mapa/busqueda');
        $this->load->view('tema/footer',$this->variables);
    }

    function buscar(){
        $this->load->view('mapa/buscar');

    }

    public function user_data_submit() {
        $data = array(
        'username' => $this->input->post('name'),
        'pwd'=>$this->input->post('pwd')
        );

        //Either you can print value or you can send value to database
        echo json_encode($data);
    }
}



?>