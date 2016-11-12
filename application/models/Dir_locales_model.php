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

        public function buscar_a($valor){
            $this->db->like('ml_nombre_local',$valor);
            $this->db->or_like('ml_ciudad',$valor);
            return  $this->db->get('m_dir_locales')->result();

        }

        public function buscar_en($valor){
            $this->db->like('ml_ciudad',$valor);
            return $this->db->get('m_dir_locales')->result();
        }

        public function obtener_local($valor){
            return $this->db->get_where('m_dir_locales', array('ml_id' => $valor))->result();

        }

        public function verificar_puntaje($id_local){
            //verificar puntaje calidad
            $query_calidad = $this->db->get_where('puntaje_calidad', array('ml_id' => $id_local));
            if($query_calidad->num_rows() > 0 ){
                $calidad  = $query_calidad;
            }
            else{
                $data = array(
                        'ml_id' => $id_local,
                        'prom_calidad' => '0',
                        'cant_votos' => '0'
                        );

                $this->db->insert('puntaje_calidad', $data);
                $calidad = $this->db->get_where('puntaje_calidad', array('ml_id' => $id_local));
            }

            //verificar puntaje precio
            $query_precio = $this->db->get_where('puntaje_precio', array('ml_id' => $id_local));
            if($query_precio->num_rows() > 0){
                $precio = $query_precio;
            }
            else{
                $data = array(
                    'ml_id' => $id_local,
                    'prom_precio' => '0',
                    'cant_votos' => '0'
                    );

                $this->db->insert('puntaje_precio', $data);
                $precio = $this->db->get_where('puntaje_precio', array('ml_id' => $id_local));
            }

            //retornar datos;
            $respuesta['precio'] = $precio->result();
            $respuesta['calidad'] = $calidad->result();

            return $respuesta;


        }


}
?>
