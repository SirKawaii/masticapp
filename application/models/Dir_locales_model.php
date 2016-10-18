<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dir_locales_model extends CI_Model {

        //public $title;


        public function __construct(){
                // Call the CI_Model constructor
                parent::__construct();
        }

        public function obtener_locales(){
                $query = $this->db->get('m_dir_locales');
                if ($query->num_rows()>0){
                        return $query;
                }
                else{return false;}
        }


}
?>
