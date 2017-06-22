<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sugerencia extends CI_Controller{

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
        $this->pagina = 'Sugerir';
        $this->variables['navegacion'] = $this->navegacion->construir_Navegacion();
        $this->variables['nombreSitio'] = $this->nombreSitio;
        $this->variables['titulo'] = ucfirst($this->pagina); // Capitalize the first letter
        //FinAtributos
    }

    function index($id){
        $data['id'] = $id;
        $this->load->view('tema/header',$this->variables);
        $this->load->view('users/vifurcar',$data);
        $this->load->view('tema/footer',$this->variables);
    }


    function sugerir($id){
        $this->load->library('upload');
        $data['local'] = $this->dir_locales_model->obtener_local2($id);
        $data['detalles'] = $this->dir_locales_model->obtener_detalles2($id);
        $data['latitud'] = $this->dir_locales_model->obtener_marcador($id);

        //haciendo las cosas mas facil.

            if($id == "NUEVO"){
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
                    $marcador = $this->dir_locales_model->obtener_marcador($id);
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
                if($id == "NUEVO"){
                    $this->load->view('users/sugierenuevo',$data);
                }
                else{
                    $this->load->view('users/sugerencia',$data);
                }

                $this->load->view('tema/footer',$this->variables);

    }

    public function subir(){

        $attachment_file=$_FILES["attachment_file"];
              $output_dir = 'assets/imagenes/sugerencias/';
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

        public function eliminarPost(){

            $id = $this->input->post("id");
            $estado = $this->input->post("estado");


            $status = $this->dir_locales_model->sugiere_eliminar($id,$estado);

            echo $status;

        }


}



?>
