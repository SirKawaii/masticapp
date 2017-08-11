<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting( E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING );

class Sugerencias extends CI_Controller{

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
        $this->pagina = 'Sugerencias';
        $this->variables['navegacion'] = $this->navegacion->construir_Navegacion();

        $this->variables['nombreSitio'] = $this->nombreSitio;
        $this->variables['titulo'] = ucfirst($this->pagina); // Capitalize the first letter

        //FinAtributos


    }

    function index(){
        $this->load->library('users');
        //$users = $this->dir_locales_model->obtiene_usuarios();
        $sugerencias = $this->dir_locales_model->retornar_sugerencias();
        $this->variables['sugerencias'] = $sugerencias;
        $data = array();

        if($this->session->userdata('isUserLoggedIn')){
            $this->load->view('tema/header', $this->variables);
            $this->load->view('admin/sugerencias',$this->variables);
            $this->load->view('tema/footer', $this->variables);
        }else{
            redirect('users/login');
        }
        //Views

    }

    function localSugerido($id){
        $this->load->library('upload');
        $data['local'] = $this->dir_locales_model->obtener_local_sugerido($id);
        $data['detalles'] = $this->dir_locales_model->obtener_local_sugerido($id);
        //$data['latitud'] = $this->dir_locales_model->obtener_local_sugerido($id);
        $marcador = $this->dir_locales_model->obtener_marcador($id);
        if($marcador == false){
            $marcador[0]->lat = '0';
            $marcador[0]->lng = '0';

            $data['latitud'] = $marcador;
        }else{
            $data['latitud'] = $marcador;
        }

        //haciendo las cosas mas facil.

            if($id == "NUEVO" || $id == "Nuevo"){
                $estado = "Nuevo";
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
            }else{
                $estado = "Modificar";

                    //Posicion marcador
                    $marcador = $this->dir_locales_model->obtener_marcador_sugerido($id);
                    if($marcador == FALSE){
                        $lat = 0;
                        $lng = 0;
                    }else{
                        $lat = $marcador[0]->lat;
                        $lng = $marcador[0]->lng;
                    }
                    //cargando geolocalizacion.
                    $this->load->library('googlemaps');
                    $config['apiKey'] = 'AIzaSyBmBDBqhuIcPwFmj6pWDCO4ylTCmWQab-M';
                    $config['center'] = $lat.",".$lng;

                    $this->googlemaps->initialize($config);

                    $marker = array();
                    $marker['position'] = $lat.",".$lng;
                    $marker['draggable'] = true;
                    $marker['ondragend'] = 'Materialize.toast(\'Poscion asignada\', 4000);
                        $(\'#lat\').val(event.latLng.lat());
                        $(\'#lng\').val(event.latLng.lng());
                        ';
                    $marker['onclick'] = '$(\'#lat\').val(event.latLng.lat());
                        $(\'#lng\').val(event.latLng.lng());';
                    $marker['infowindow_content'] = 'Posicion Actual, mueveme para sugerir otra ubicación.';
                    $marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|9999FF|000000';
                    $this->googlemaps->add_marker($marker);

                    $data['map'] = $this->googlemaps->create_map();
                }
                $data['estado'] = $estado;



                //cargar vistas
                $this->load->view('tema/header',$this->variables);
                $this->load->view('admin/localsugerido',$data);
                $this->load->view('tema/footer',$this->variables);

    }

    public function subir(){

        $attachment_file=$_FILES["attachment_file"];
              $output_dir = 'assets/imagenes/locales/';
              $fileName = $_FILES["attachment_file"]["name"];
		move_uploaded_file($_FILES["attachment_file"]["tmp_name"],$output_dir.$fileName);

        if($fileName == NULL){
            $ruta = NULL;
        }else{
            $ruta = base_url($output_dir.$fileName);
        }

		echo $ruta;

    }

        public function sugerirNuevoLocal(){
            $estado = $this->input->post("estado");
            $id = $this->input->post("id");
            $nombre = $this->input->post("nombre");
            $calle = $this->input->post("calle");
            $numero = $this->input->post("numero");
            $direccion = $this->input->post("direccion");
            $detalle = $this->input->post("detalle");
            $ciudad = $this->input->post("ciudad");
            $comuna = $this->input->post("comuna");
            $region = $this->input->post("region");
            $imagen = $this->input->post("imagen");
            $descripcion = $this->input->post("descripcion");
            $tipo_local = $this->input->post("tipo_local");
            $tipo_comida = $this->input->post("tipo_comida");
            $telefono = $this->input->post("telefono");
            $lat = $this->input->post("lat");
            $lng = $this->input->post("lng");

            $id = $this->dir_locales_model->sugiere_nuevo($estado,$id,$nombre,$calle,$numero,$direccion,$detalle,$ciudad,$comuna,$region,$imagen,$descripcion,$tipo_local,$tipo_comida,$telefono,$lat,$lng);

            echo $id;
        }

            public function actualiza_local(){
            $id = $this->input->post("id");
            $nombre = $this->input->post("nombre");
            $calle = $this->input->post("calle");
            $numero = $this->input->post("numero");
            $direccion = $this->input->post("direccion");
            $detalle = $this->input->post("detalle");
            $ciudad = $this->input->post("ciudad");
            $comuna = $this->input->post("comuna");
            $region = $this->input->post("region");
            $imagen = $this->input->post("imagen");
            $descripcion = $this->input->post("descripcion");
            $tipo_local = $this->input->post("tipo_local");
            $tipo_comida = $this->input->post("tipo_comida");
            $telefono = $this->input->post("telefono");
            $lat = $this->input->post("lat");
            $lng = $this->input->post("lng");

            if($id == 0){
                $id = $this->dir_locales_model->nuevo_local($nombre,$calle,$numero,$direccion,$detalle,$ciudad,$comuna,$region);
            }else{
                $this->dir_locales_model->modifica_locales($id,$nombre,$calle,$numero,$direccion,$detalle,$ciudad,$comuna,$region);
            }
            $post = $this->dir_locales_model->modifica_detalles2($id,$descripcion,$tipo_local,$tipo_comida,$telefono,$imagen);
            $this->dir_locales_model->ingresa_marcadores($id,$direccion,$lat,$lng);

            echo $id;
        }

        public function eliminar_sugerencia(){
            $id = $this->input->post('id');

            $post = $this->dir_locales_model->eliminar_sugerencia($id);
            echo json_encode($post);
        }


}



?>
