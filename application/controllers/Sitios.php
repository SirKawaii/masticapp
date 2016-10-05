<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitios extends CI_Controller{

            function __construct(){
            parent::__construct();
        }


		public function view ($page = 'Kohisekai'){

			$data['title'] = ucfirst($page); // Capitalize the first letter

			$this->load->view('tema/header', $data);
            $this->load->view('estaticas/bienvenido');
			$this->load->view('tema/footer', $data);

		}
}



?>
