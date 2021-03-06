<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting( E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING );

class Modifica extends CI_Controller{

    public $pagina, $nombreSitio, $variables;

    function __construct(){
        parent::__construct();
        //helpers
        $this->load->helper('url','form');
        //bibliotecas
        $this->load->library('navegacion', array('Mapa','Busqueda'));
        //modelos
        $this->load->model('dir_locales_model');
        $this->load->model('user');

        //inicializacion de Atributos Globales
        $this->nombreSitio = 'Masticapp';
        $this->pagina = 'Modificar Locales';
        $this->variables['navegacion'] = $this->navegacion->construir_Navegacion();
        $this->variables['nombreSitio'] = $this->nombreSitio;
        $this->variables['titulo'] = ucfirst($this->pagina); // Capitalize the first letter
        //FinAtributos
    }

    function index (){
        $data = array();
        if($this->session->userdata('isUserLoggedIn')){
            $data['user'] = $this->user->getRows(array('id_usuario'=>$this->session->userdata('userId')));
                //cargar vistas
                $this->load->view('tema/header',$this->variables);
                $this->load->view('admin/busca');
                $this->load->view('tema/footer',$this->variables);
        }else{
            redirect('users/login');
        }
    }

    function cambio($id_local){
        $data = array();
        if($this->session->userdata('isUserLoggedIn')){
            $data['user'] = $this->user->getRows(array('id_usuario'=>$this->session->userdata('userId')));
                //obterner local especifico
                $post = $this->dir_locales_model->obtener_local($id_local);
                $local['local'] = json_encode($post);
                //obtener detalles del local
                $local['detalles'] = json_encode($this->dir_locales_model->obtener_detalles($id_local));

                //obtener direccion para buscarla con geocodificacion.
                $row = $this->dir_locales_model->obtener_local2($id_local);
                if (isset($row))
                    {
                    $direccionlocal = $row->ml_calle ." ". $row->ml_numero ." ". $row->ml_direccion ." ". $row->ml_ciudad;
                    }
                else{
                    $direccionlocal = auto;
                }
                $local['direcciongeo'] = $direccionlocal;

                //cargando geolocalizacion.
                $this->load->library('googlemaps');
                $config['apiKey'] = 'AIzaSyBmBDBqhuIcPwFmj6pWDCO4ylTCmWQab-M';
                $config['center'] = $direccionlocal;

                $this->googlemaps->initialize($config);

                $marker = array();

                $marker['position'] = $direccionlocal;
                $marker['draggable'] = true;
                $marker['ondragend'] = 'Materialize.toast(\'Poscion asignada\', 4000);
                    $(\'#lat\').val(event.latLng.lat());
                    $(\'#lng\').val(event.latLng.lng());
                    ';
                $marker['onclick'] = '$(\'#lat\').val(event.latLng.lat());
                    $(\'#lng\').val(event.latLng.lng());';
                $this->googlemaps->add_marker($marker);
                //anterior marcador
                $marcador = $this->dir_locales_model->obtener_marcador($id_local);
                if($marcador == false){
                    $lat = 0;
                    $lng = 0;
                    $marcador[0]->lat = '0';
                    $marcador[0]->lng = '0';
                }else{
                    $lat = $marcador[0]->lat;
                    $lng = $marcador[0]->lng;
                }
                $local['latitud'] = $marcador;
                $marker['position'] = $lat.",".$lng;
                $marker['draggable'] = false;
                $marker['infowindow_content'] = 'Posicion anterior';
                $marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|9999FF|000000';
                $this->googlemaps->add_marker($marker);

                $local['map'] = $this->googlemaps->create_map();

                //cargar vistas
                $this->load->view('tema/header',$this->variables);
                $this->load->view('admin/modifica',$local);
                $this->load->view('tema/footer',$this->variables);
        }else{
            redirect('users/login');
        }
    }


    function view_imagen($id_local){
        $data = array();
        if($this->session->userdata('isUserLoggedIn')){
            $data['user'] = $this->user->getRows(array('id_usuario'=>$this->session->userdata('userId')));
                //cargar vistas
                $this->load->library('upload');
                $this->load->helper(array('url'));

                //obtener detalles del local
                $local['detalles'] = json_encode($this->dir_locales_model->obtener_detalles($id_local));

                //cargar vistas
                $this->load->view('tema/header',$this->variables);
                $this->load->view('admin/subir_imagen',$local);
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

        public function actualiza_local() {

            $id = $this->input->post("id");
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

            $this->dir_locales_model->modifica_locales($id,$nombre,$calle,$numero,$direccion,$detalle,$ciudad,$comuna,$region);
            $post = $this->dir_locales_model->modifica_detalles($id,$descripcion,$tipo_local,$tipo_comida,$telefono);
            $this->dir_locales_model->ingresa_marcadores($id,$direccion,$lat,$lng);
            echo json_encode($descripcion);
        }

        public function actualiza_local2(){
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

            $this->dir_locales_model->modifica_locales($id,$nombre,$calle,$numero,$direccion,$detalle,$ciudad,$comuna,$region);
            $post = $this->dir_locales_model->modifica_detalles($id,$imagen,$descripcion,$tipo_local,$tipo_comida,$telefono);
            $this->dir_locales_model->ingresa_marcadores($id,$direccion,$lat,$lng);

            echo "1";
        }

        function elimina($id){
            $dato['id'] = $id;
            $data = array();
            if($this->session->userdata('isUserLoggedIn')){
                $data['user'] = $this->user->getRows(array('id_usuario'=>$this->session->userdata('userId')));
                //cargar vistas
                $this->load->view('tema/header',$this->variables);
                $this->load->view('admin/elimina',$dato);
                $this->load->view('tema/footer',$this->variables);
            }else{
                redirect('users/login');
            }

        }

        public function eliminarLocal($id){
            $data = array();
            if($this->session->userdata('isUserLoggedIn')){
                $data['user'] = $this->user->getRows(array('id_usuario'=>$this->session->userdata('userId')));
                //Proceder a eliminar
                if($id){
                    $id = $this->input->post("id");
                    $result = $this->dir_locales_model->elimina_local($id);
                    return $result;
                }
                else{
                    return FALSE;
                }
            }else{
                redirect('users/login');
            }

        }


}



?>
