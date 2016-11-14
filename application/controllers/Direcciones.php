<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Direcciones extends CI_Controller{

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
        $this->pagina = 'Direcciones';
        $this->variables['navegacion'] = $this->navegacion->construir_Navegacion();

        $this->variables['nombreSitio'] = $this->nombreSitio;
        $this->variables['titulo'] = ucfirst($this->pagina); // Capitalize the first letter

        //FinAtributos


    }

    function index ($id_local){


        //Llamada a base de detos
        $resultado= json_encode($this->dir_locales_model->obtener_local($id_local));
        $rere = json_decode($resultado);
        $local = $rere[0];
        //creando Pagina



        //carga capa mapa
        $this->load->library('googlemaps');

        $config = array();
        $config['center'] = 'auto';
        $config['center'] = 'auto';
        $config['zoom'] = 'auto';
        $config['apiKey'] = 'AIzaSyBmBDBqhuIcPwFmj6pWDCO4ylTCmWQab-M';
        $config['directions'] = TRUE;
        $config['directionsStart'] = 'auto';
        $config['directionsEnd'] = $local->ml_calle.' '.$local->ml_direccion.' '.$local->ml_numero.','.$local->ml_ciudad;
        $config['directionsDivID'] = 'directionsDiv';
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();



        //fin mapa;
        $this->load->view('tema/header', $this->variables);
        $this->load->view('mapa/direcciones', $data);
        $this->load->view('tema/footer', $this->variables);

    }
}
