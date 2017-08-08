<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Busqueda extends CI_Controller{

    public $pagina, $nombreSitio, $variables;

    function __construct(){
        parent::__construct();
        //helpers
        $this->load->helper('url');
        //bibliotecas
        $this->load->library('navegacion', array('Mapa','Busqueda'));

        //modelos
        $this->load->model('dir_locales_model');

        //inicializacion de Atributos Globales
        $this->nombreSitio = 'Masticapp';
        $this->pagina = 'Busqueda';
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


    public function user_data_submit() {
        $buscar = $this->input->post("buscar");
        $post = $this->dir_locales_model->buscar_a($buscar);
        echo json_encode($post);
    }
}



?>
