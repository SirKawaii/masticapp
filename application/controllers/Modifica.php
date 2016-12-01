<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modifica extends CI_Controller{

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
        $this->pagina = 'Modificar Locales';
        $this->variables['navegacion'] = $this->navegacion->construir_Navegacion();

        $this->variables['nombreSitio'] = $this->nombreSitio;
        $this->variables['titulo'] = ucfirst($this->pagina); // Capitalize the first letter


        //FinAtributos


    }

    function index (){

        //cargar vistas
        $this->load->view('tema/header',$this->variables);
        $this->load->view('admin/busca');
        $this->load->view('tema/footer',$this->variables);

    }

    function cambio($id_local){

        //obterner local especifico
        $post = $this->dir_locales_model->obtener_local($id_local);
        $local['local'] = json_encode($post);
        //obtener detalles del local
        $local['detalles'] = json_encode($this->dir_locales_model->obtener_detalles($id_local));

        //cargar vistas
        $this->load->view('tema/header',$this->variables);
        $this->load->view('admin/modifica',$local);
        $this->load->view('tema/footer',$this->variables);

    }


    function view_imagen($id_local){
        $this->load->library('upload');
        $this->load->helper(array('url'));

        //obtener detalles del local
        $local['detalles'] = json_encode($this->dir_locales_model->obtener_detalles($id_local));

        //cargar vistas
        $this->load->view('tema/header',$this->variables);
        $this->load->view('admin/subir_imagen',$local);
        $this->load->view('tema/footer',$this->variables);


    }

    public function subir($id_local){
        $attachment_file=$_FILES["attachment_file"];
              $output_dir = 'assets/imagenes/locales/';
              $fileName = $_FILES["attachment_file"]["name"];
		move_uploaded_file($_FILES["attachment_file"]["tmp_name"],$output_dir.$fileName);

        $ruta = base_url($output_dir.$fileName);
        $this->dir_locales_model->sube_imagen($id_local,$ruta);

		echo "El archivo se ha subido correctamente";

    }

        public function actualiza_local() {

            $id = $this->input->post("id");
            $nombre = $this->input->post("nombre");
            $calle = $this->input->post("calle");
            $numero = $this->input->post("numero");
            $direccion = $this->input->post("direccion");
            $detalle = $this->input->post("detalle");
            $ciudad = $this->input->post("ciudad");
            $comuna = $this->input->post("comuna");
            $region = $this->input->post("comina");
            $descripcion = $this->input->post("descripcion");
            $tipo_local = $this->input->post("tipo_local");
            $tipo_comida = $this->input->post("tipo_comida");
            $telefono = $this->input->post("telefono");


            $post[0] = $this->dir_locales_model->modifica_locales($id,$nombre,$calle,$numero,$direccion,$detalle,$ciudad,$comuna,$region);
            $post[1] = $this->dir_locales_model->modifica_detalles($descripcion,$tipo_local,$tipo_comida,$telefono);
            echo json_encode($post);
        }


}



?>