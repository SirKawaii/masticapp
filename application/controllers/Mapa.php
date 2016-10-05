<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapa extends CI_Controller{

    public $pagina, $nombreSitio, $variables;

    function __construct(){
        parent::__construct();
        //inicializacion de Atributos Globales
        $this->nombreSitio = 'Masticapp';
        $this->pagina = 'Mapa';

        $this->variables['nombreSitio'] = $this->nombreSitio;
        $this->variables['titulo'] = ucfirst($this->pagina); // Capitalize the first letter

        //FinAtributos


    }

    function index (){



        $this->load->view('tema/header', $this->variables);
        //carga capa mapa
        $this->load->library('googlemaps');
        $config['center'] = '37.4419, -122.1419';
        $config['zoom'] = 'auto';
        $config['apiKey'] = 'AIzaSyBmBDBqhuIcPwFmj6pWDCO4ylTCmWQab-M';
        $this->googlemaps->initialize($config);

        $marker = array();
        $marker['position'] = '37.429, -122.1419';
        $this->googlemaps->add_marker($marker);
        $data['map'] = $this->googlemaps->create_map();

        $this->load->view('mapa/mapa', $data);


        $this->load->view('tema/footer', $this->variables);

    }
}



?>
