<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user');
        $this->load->library('navegacion', array('Mapa','Busqueda'));

        //inicializacion de Atributos Globales
        $this->nombreSitio = 'Masticapp';
        $this->pagina = 'Administración';
        $this->variables['navegacion'] = $this->navegacion->construir_Navegacion();

        $this->variables['nombreSitio'] = $this->nombreSitio;
        $this->variables['titulo'] = ucfirst($this->pagina); // Capitalize the first letter
    }

    function index(){
        $data = array();
        if($this->session->userdata('isUserLoggedIn')){
            redirect('users/account');
        }else{
            redirect('users/login');
        }
    }

    public function account(){
        $data = array();
        if($this->session->userdata('isUserLoggedIn')){
            $data['user'] = $this->user->getRows(array('id_usuario'=>$this->session->userdata('userId')));
            //load the view
            $this->load->view('tema/header', $this->variables);
            $this->load->view('users/account', $data);
            $this->load->view('admin/account_options');
            $this->load->view('tema/footer', $this->variables);

        }else{
            redirect('users/login');
        }
    }

    /*
     * User login
     */
    public function login(){
        $data = array();
        if($this->session->userdata('success_msg')){
            $data['success_msg'] = $this->session->userdata('success_msg');
            $this->session->unset_userdata('success_msg');
        }
        if($this->session->userdata('error_msg')){
            $data['error_msg'] = $this->session->userdata('error_msg');
            $this->session->unset_userdata('error_msg');
        }
        if($this->input->post('loginSubmit')){
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'password', 'required');
            if ($this->form_validation->run() == true) {
                $con['returnType'] = 'single';
                $con['conditions'] = array(
                    'email'=>$this->input->post('email'),
                    'password' => md5($this->input->post('password')),
                    'status' => '1'
                );
                $checkLogin = $this->user->getRows($con);
                if($checkLogin){
                    if($checkLogin['tipo_usuario'] >= 3){
                        $this->session->set_userdata('isUserLoggedIn',TRUE);
                    }
                    else{
                        $this->session->set_userdata('isUserLoggedIn',FALSE);
                    }
                    //$this->session->set_userdata('isUserLoggedIn',TRUE);
                    $this->session->set_userdata('userId',$checkLogin['id_usuario']);
                    redirect('users/account/');
                }else{
                    $data['error_msg'] = 'EL correo electronico es incorrecto, por favor intentalo nuevamente.';
                }
            }
        }
        //load the view
        $this->load->view('tema/header', $this->variables);
        $this->load->view('users/login', $data);
        $this->load->view('tema/footer', $this->variables);
    }

    /*
     * User registration
     */
    public function registration(){
        $data = array();
        $userData = array();
        if($this->input->post('regisSubmit')){
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
            $this->form_validation->set_rules('password', 'password', 'required');
            $this->form_validation->set_rules('conf_password', 'confirm password', 'required|matches[password]');

            $userData = array(
                'nombre' => strip_tags($this->input->post('name')),
                'email' => strip_tags($this->input->post('email')),
                'password' => md5($this->input->post('password')),
                'tipo_usuario' => '0',
                'status' => '1'
            );

            if($this->form_validation->run() == true){
                $insert = $this->user->insert($userData);
                if($insert){
                    $this->session->set_userdata('success_msg', 'Tu registro a sido exitoso. Por favor inicia sesión.');
                    redirect('users/login');
                }else{
                    $data['error_msg'] = 'Some problems occured, please try again.';
                }
            }
        }
        $data['user'] = $userData;
        //load the view
        $this->load->view('tema/header', $this->variables);
        $this->load->view('users/registration', $data);
        $this->load->view('tema/footer', $this->variables);
    }

    /*
    *Users Administration
    */

    function manageUsers(){
        $data = array();
        if($this->session->userdata('isUserLoggedIn')){
            $this->load->view('admin/usuarios');
        }else{
            redirect('users/login');
        }
    }

    /*
     * User logout
     */
    public function logout(){
        $this->session->unset_userdata('isUserLoggedIn');
        $this->session->unset_userdata('userId');
        $this->session->sess_destroy();
        redirect('users/login/');
    }

    /*
     * Existing email check during validation
     */
    public function email_check($str){
        $con['returnType'] = 'count';
        $con['conditions'] = array('email'=>$str);
        $checkEmail = $this->user->getRows($con);
        if($checkEmail > 0){
            $this->form_validation->set_message('email_check', 'The given email already exists.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
}
