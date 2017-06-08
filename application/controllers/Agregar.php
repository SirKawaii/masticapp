<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agregar extends CI_Controller{

    public $pagina, $nombreSitio, $variables;

    function __construct(){
        parent::__construct();
        //helpers
        $this->load->helper('url','form');
        //bibliotecas
        $this->load->library('navegacion', array('mapa','busqueda'));
        //modelos
        $this->load->model('dir_locales_model');
        $this->load->model('user');

        //inicializacion de Atributos Globales
        $this->nombreSitio = 'Masticapp';
        $this->pagina = 'Agregar Local';
        $this->variables['navegacion'] = $this->navegacion->construir_Navegacion();
        $this->variables['nombreSitio'] = $this->nombreSitio;
        $this->variables['titulo'] = ucfirst($this->pagina); // Capitalize the first letter
        //FinAtributos
    }

    function index (){
        $this->load->library('upload');

        $data = array();
        if($this->session->userdata('isUserLoggedIn')){
            $data['user'] = $this->user->getRows(array('id_usuario'=>$this->session->userdata('userId')));
                //cargando geolocalizacion.
                $this->load->library('googlemaps');
                $config['apiKey'] = 'AIzaSyBmBDBqhuIcPwFmj6pWDCO4ylTCmWQab-M';
                $config['center'] = 'auto';
                $config['onboundschanged'] = 'if (!centreGot) {
                    var mapCentre = map.getCenter();
                    marker_0.setOptions({
                        position: new google.maps.LatLng(mapCentre.lat(), mapCentre.lng())
                    });
                }
                centreGot = true;';
                $this->googlemaps->initialize($config);

                $marker = array();
                $marker['position'] = 'auto';
                $marker['draggable'] = true;
                $marker['ondragend'] = 'Materialize.toast(\'Poscion asignada\', 4000);
                    $(\'#lat\').val(event.latLng.lat());
                    $(\'#lng\').val(event.latLng.lng());
                    ';
                $this->googlemaps->add_marker($marker);
                $data['map'] = $this->googlemaps->create_map();

                //cargar vistas
                $this->load->view('tema/header',$this->variables);
                $this->load->view('admin/agregar_local',$data);
                $this->load->view('tema/footer',$this->variables);
        }else{
            redirect('users/login');
        }
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

        public function agregarlocal(){

            $nombre = $this->input->post("nombre");
            $calle = $this->input->post("calle");
            $numero = $this->input->post("numero");
            $direccion = $this->input->post("direccion");
            $detalle = $this->input->post("detalle");
            $ciudad = $this->input->post("ciudad");
            $comuna = $this->input->post("comuna");
            $region = $this->input->post("region");
            $lat = $this->input->post("lat");
            $lng = $this->input->post("lng");
            $descripcion = $this->input->post("descripcion");
            $tipo_local = $this->input->post("tipo_local");
            $tipo_comida = $this->input->post("tipo_comida");
            $telefono = $this->input->post("telefono");

            $id = $this->dir_locales_model->nuevo_local($nombre,$calle,$numero,$direccion,$detalle,$ciudad,$comuna,$region);

            $this->dir_locales_model->modifica_detalles($id,$descripcion,$tipo_local,$tipo_comida,$telefono);
            $this->dir_locales_model->ingresa_marcadores($id,$direccion,$lat,$lng);

            echo $id;
        }


}



?>
