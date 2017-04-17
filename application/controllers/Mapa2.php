<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapa2 extends CI_Controller{

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
        $data['basedatos'] = $this->dir_locales_model->obtener_locales_array();
        $data['totalDB'] = $this->dir_locales_model->total_locales();
        $data['ultimo'] = $this->dir_locales_model->ultimo_marcador();
        //creando Pagina
        $this->load->view('mapa/mapa2',$data);

    }

    function ingresar(){
        $id = $this->input->post("id");
        $direccion = $this->input->post("direccion");
        $lat = $this->input->post("lat");
        $lng = $this->input->post("lng");

        $result = $this->dir_locales_model->ingresa_marcadores($id,$direccion,$lat,$lng);
        echo $result;

    }
}
?>
