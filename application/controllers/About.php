<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller{

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
        $this->pagina = 'Acerca de';
        $this->variables['navegacion'] = $this->navegacion->construir_Navegacion();

        $this->variables['nombreSitio'] = $this->nombreSitio;
        $this->variables['titulo'] = ucfirst($this->pagina); // Capitalize the first letter

        //FinAtributos


    }

    function index(){
        $this->load->library('users');
        $users = $this->dir_locales_model->obtiene_usuarios();
        $this->variables['usuarios'] = $this->users->listarUsuarios($users);

        //Views
        $this->load->view('tema/header', $this->variables);
        $this->load->view('about');
        $this->load->view('tema/footer', $this->variables);
    }

}



?>
