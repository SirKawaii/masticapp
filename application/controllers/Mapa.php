<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapa extends CI_Controller{

    public $pagina, $nombreSitio, $variables;

    function __construct(){
        parent::__construct();
        //helpers
        $this->load->helper('url','cookie');
        //bibliotecas
        $this->load->library('navegacion', array('mapa','busqueda'));
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

    function index (){



        //Llamada a base de detos
        $data['basedatos'] = $this->dir_locales_model->obtener_locales();

        //creando Pagina

        $this->load->view('tema/header', $this->variables);

        //carga capa mapa
        $this->load->library('googlemaps');
        $config = array();
        $config['center'] = 'auto';
        //importante
        $config['apiKey'] = 'AIzaSyBmBDBqhuIcPwFmj6pWDCO4ylTCmWQab-M';
        $config['onboundschanged'] = 'if (!centreGot) {
                var mapCentre = map.getCenter();
                marker_0.setOptions({
                position: new       google.maps.LatLng(mapCentre.lat(), mapCentre.lng())
                });
                }
                centreGot = true;';

        $config['geocodeCaching'] = FALSE;
        $this->googlemaps->initialize($config);


        $marker = array();
        $this->googlemaps->add_marker($marker);

        foreach($data['basedatos']->result() as $list_locales_map ){
            $marker = array();
            $marcador = $this->dir_locales_model->obtener_marcador($list_locales_map->ml_id);
            if($marcador == FALSE){
                $lat = 0;
                $lng = 0;
            }else{
                $lat = $marcador[0]->lat;
                $lng = $marcador[0]->lng;
            }
            $marker['position'] = $lat.",".$lng;
            $marker['infowindow_content'] = "<a href='".base_url()."local/index/".$list_locales_map->ml_id."'>".$list_locales_map->ml_nombre_local."</a>";
            $marker['icon'] = 'assets/img/micon.png';
            $this->googlemaps->add_marker($marker);
        }
        $data['map'] = $this->googlemaps->create_map();

        //fin mapa;
        $this->load->view('mapa/mapa', $data);

        $this->load->view('tema/footer', $this->variables);

    }
}



?>
