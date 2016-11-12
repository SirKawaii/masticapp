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

    function index ($id_local){
        //$this->load->library('puntuacion');
        //$local['puntuacion'] = $this->puntuacion->construir_puntuacion();



        //obterner local especifico
        $post = $this->dir_locales_model->obtener_local($id_local);
        $local['local'] = json_encode($post);
        //obtener puntaje del local
        $post = $this->dir_locales_model->verificar_puntaje($id_local);
        $local['puntaje'] = $post;

        //cargar libreria de rater
        $this->load->library('incluye_estrellas');
        $this->variables['estrellas'] = $this->incluye_estrellas->put_estrellas();

        //cargar vistas
        $this->load->view('tema/header', $this->variables);

        $this->load->view('local/local',$local);

        $this->load->view('tema/footer', $this->variables);

    }

        public function user_data_submit() {
        $buscar = $this->input->post("valor");
        $post = $this->dir_locales_model->buscar_a($buscar);
        echo json_encode($post);
    }

}



?>
