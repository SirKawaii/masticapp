<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Local extends CI_Controller{

    public $pagina, $nombreSitio, $variables;

    function __construct(){
        parent::__construct();
        //helpers
        $this->load->helper('url');
        //bibliotecas
        $this->load->library('navegacion', array('mapa','busqueda'));
        //modelos
        $this->load->model('dir_locales_model');

        //inicializacion de Atributos Globales
        $this->nombreSitio = 'Masticapp';
        $this->pagina = 'Local';
        $this->variables['navegacion'] = $this->navegacion->construir_Navegacion();

        $this->variables['nombreSitio'] = $this->nombreSitio;
        $this->variables['titulo'] = ucfirst($this->pagina); // Capitalize the first letter

        //FinAtributos


    }

    function index (){


        //Llamada a base de detos
        $data['basedatos'] = $this->dir_locales_model->obtener_locales();
        //creando Pagina

        $this->load->view('tema/header', $this->variables);

        $this->load->view('local/local');

        $this->load->view('tema/footer', $this->variables);

    }
}



?>
