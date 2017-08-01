<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller{

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
        $this->pagina = 'Usuarios';
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
        $this->load->view('admin/usuarios',$this->variables);
        $this->load->view('tema/footer', $this->variables);
    }

    public function eliminarUsuario(){
            $usuario = $this->input->post('idUsuario');
            $post = $this->dir_locales_model->eliminarUsuario($usuario);
            echo json_encode($post);
    }

    public function modificarUsuario(){
            $idUsuario = $this->input->post('idUsuario');
            $nombre = $this->input->post('nombre');
            $tipoUsuario = $this->input->post('tipoUsuario');

            $post = $this->dir_locales_model->modificar_usuario($idUsuario,$nombre,$tipoUsuario);
            echo json_encode($post);
    }

}



?>
