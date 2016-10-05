<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapa extends CI_Controller{

    function __construct(){
        parent::__construct();

    }

    function index ($page = 'mapa'){

        $data['title'] = ucfirst($page); // Capitalize the first letter

        $this->load->view('tema/header', $data);

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


        $this->load->view('tema/footer', $data);

    }
}



?>
