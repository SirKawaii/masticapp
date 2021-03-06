<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Local extends CI_Controller{

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
        //obtener detalles del local
        $local['detalles'] = json_encode($this->dir_locales_model->obtener_detalles($id_local));
        //obtener puntaje del local
        $post = $this->dir_locales_model->verificar_puntaje($id_local);
        $local['puntaje'] = $post;
        $local['id'] = $id_local;

        //cargar libreria de rater
        $this->load->library('incluye_estrellas');
        $this->variables['estrellas'] = $this->incluye_estrellas->put_estrellas();

        //Cargar Comentarios
        $comentarios = $this->dir_locales_model->obtener_comentarios($id_local);
        $this->load->library('comentarios',$comentarios);
        $local['comentarios'] =  $this->comentarios->cargar_comentarios();


        //cargar vistas
        $this->load->view('tema/header', $this->variables);

        $this->load->view('local/local',$local);

        $this->load->view('local/opciones',$local);
        //opciones de administrador.
        if($this->session->userdata('isUserLoggedIn')){
            $this->load->view('local/modificarLocal',$local);
        }

        $this->load->view('tema/footer', $this->variables);

    }

        public function actualiza_precio() {
            $id = $this->input->post("id");
            $voto = $this->input->post("voto");
            $post = $this->dir_locales_model->actualiza_precio($id,$voto);
            echo json_encode($post);
        }

         public function actualiza_calidad() {
            $id = $this->input->post("id");
            $voto = $this->input->post("voto");
            $post = $this->dir_locales_model->actualiza_calidad($id,$voto);
            echo json_encode($post);
        }

        public function agrega_comentario(){
            $local = $this->input->post('id');
            $nombre = $this->input->post('nombre');
            $comentario = $this->input->post('comentario');

            $post = $this->dir_locales_model->agrega_comentario($local,$nombre,$comentario);
            echo json_encode($post);
        }

        public function modificar_local(){
            $id = $this->input->post('id');
            $imagen = $this->input->post('imagen');
            $descripcion = $this->input->post('descripcion');
            $tipo_local = $this->input->post('tipo_local');
            $tipo_comida = $this->input->post('tipo_comida');
            $tel = $this->input->post('telefono');

            $post = $this->dir_locales_model->modificar_detalles($id,$imagen,$descripcion,$tipo_local,$tipo_comida,$tel);
            echo json_encode($post);
        }

}



?>
