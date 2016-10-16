<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapa extends CI_Controller{

    public $pagina, $nombreSitio, $variables;

    function __construct(){
        parent::__construct();
        //helpers
        $this->load->helper('url');
        //bibliotecas
        $this->load->library('navegacion', array('mapa','lista'));

        //inicializacion de Atributos Globales
        $this->nombreSitio = 'Masticapp';
        $this->pagina = 'Mapa';
        $this->variables['navegacion'] = $this->navegacion->construir_Navegacion();

        $this->variables['nombreSitio'] = $this->nombreSitio;
        $this->variables['titulo'] = ucfirst($this->pagina); // Capitalize the first letter

        //FinAtributos


    }

    function index (){




        $this->load->view('tema/header', $this->variables);
        //carga capa mapa
        $this->load->library('googlemaps');
        $config = array();
        $config['center'] = 'auto';
        //importante
        $config['apiKey'] = 'AIzaSyBmBDBqhuIcPwFmj6pWDCO4ylTCmWQab-M';
        $this->googlemaps->initialize($config);
        $config['onboundschanged'] = 'if (!centreGot) {
        var mapCentre = map.getCenter();
            marker_0.setOptions({
                position: new       google.maps.LatLng(mapCentre.lat(), mapCentre.lng())
            });
        }
        centreGot = true;';
        $this->googlemaps->initialize($config);

        $marker = array();
        $this->googlemaps->add_marker($marker);
        $data['map'] = $this->googlemaps->create_map();

        $this->load->view('mapa/mapa', $data);


        $this->load->view('tema/footer', $this->variables);

    }
}



?>
