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

        public function obtener_locales_array(){
                $query = $this->db->get('m_dir_locales');
                if ($query->num_rows()>0){
                        return $query->result_array();
                }
                else{return false;}
        }

        public function obtener_locales_cercanos($lat,$lng){
            $query = $this->db->query("SELECT ml_id, ( 6371 * acos( cos( radians($lat) ) * cos( radians( lat ) )
                                        * cos( radians( lng ) - radians($lng) ) + sin( radians($lat) ) * sin(radians(lat)) ) ) AS distance
                                        FROM marcadores
                                        HAVING distance < 25
                                        ORDER BY distance
                                        ");

            if ($query->num_rows()>0){
                return $query->result_array();
            }
            else{return false;}
        }

        public function total_locales(){
            $query = $this->db->get('m_dir_locales');
            $total = $query->num_rows();
            return $total;
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

        public function obtener_local2($valor){
            return $this->db->get_where("m_dir_locales",array('ml_id' => $valor))->row();
        }

        public function obtener_local_sugerido($id){
             return $this->db->get_where("sugerencias",array('id_sugerencias' => $id))->row();
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

        public function actualiza_precio($id_local,$voto){
            $this->db->select('prom_precio');
            $this->db->where('ml_id', $id_local);
            $query = $this->db->get('puntaje_precio')->result_array();
            $result_q = array_shift($query);
            $promedio = $result_q['prom_precio'];


            $this->db->select('cant_votos');
            $this->db->where('ml_id', $id_local);
            $query = $this->db->get('puntaje_precio')->result_array();
            $result_q = array_shift($query);
            $votos = $result_q['cant_votos'] + 1;

            $data = array(
                'prom_precio' => ($promedio + $voto)/2,
                'cant_votos' => $votos
            );

        $this->db->where('ml_id', $id_local);
        $this->db->update('puntaje_precio', $data);

        return true;
        }

        public function actualiza_calidad($id_local,$voto){
            $this->db->select('prom_calidad');
            $this->db->where('ml_id', $id_local);
            $query = $this->db->get('puntaje_calidad')->result_array();
            $result_q = array_shift($query);
            $promedio = $result_q['prom_calidad'];


            $this->db->select('cant_votos');
            $this->db->where('ml_id', $id_local);
            $query = $this->db->get('puntaje_calidad')->result_array();
            $result_q = array_shift($query);
            $votos = $result_q['cant_votos'] + 1;

            $data = array(
                'prom_calidad' => ($promedio + $voto)/2,
                'cant_votos' => $votos
            );

        $this->db->where('ml_id', $id_local);
        $this->db->update('puntaje_calidad', $data);

        return true;
        }

        public function obtener_comentarios($id_local){
            $this->db->where('ml_id',$id_local);
            $respuesta = $this->db->get('comentarios')->result_array();

            return $respuesta;
        }

        public function agrega_comentario($id_local,$nombre_usuario,$comentario){
            $data = array(
                'ml_id' => $id_local,
                'nombre_usuario' => $nombre_usuario,
                'comentario'=> $comentario,
                'fecha' => date("Y-m-d H:i:s")
            );

            $respuesta = $this->db->insert('comentarios', $data);

            return true;
        }

        public function obtener_detalles($id_local){
            $this->db->where('ml_id',$id_local);
            $query = $this->db->get('m_detalles_locales');

            if($query->num_rows() > 0 ){
                $resultado = $query->result_array();
            }
            else{
                $data = array(
                    'ml_id' => $id_local,
                );

                $this->db->insert('m_detalles_locales', $data);
                $this->db->where('ml_id',$id_local);
                $resultado = $this->db->get('m_detalles_locales')->result_array();
            }
            return $resultado;
        }

            public function obtener_detalles2($id_local){
            $this->db->where('ml_id',$id_local);
            $query = $this->db->get('m_detalles_locales');

            if($query->num_rows() > 0 ){
                $resultado = $query->row();
            }
            else{
                $data = array(
                    'ml_id' => $id_local,
                );

                $this->db->insert('m_detalles_locales', $data);
                $this->db->where('ml_id',$id_local);
                $resultado = $this->db->get('m_detalles_locales')->row();
            }
            return $resultado;
        }

        public function modifica_locales($id,$nombre,$calle,$numero,$direccion,$detalle,$ciudad,$comuna,$region){

            //actualiza datos
            $data = array(
                'ml_id' => $id,
                'ml_nombre_local' => $nombre,
                'ml_calle' => $calle,
                'ml_numero' => $numero,
                'ml_direccion' => $direccion,
                'ml_detalle' => $detalle,
                'ml_ciudad' => $ciudad,
                'ml_comuna' => $comuna,
                'ml_region' => $region
            );
            $this->db->where('ml_id',$id);
            $query[1] = $this->db->update('m_dir_locales', $data);
            return $query;
        }

        public function modifica_detalles($id,$descripcion,$tipo_local,$tipo_comida,$telefono){
            //actualiza detalles aqui
            $this->db->where('ml_id',$id);
            $query = $this->db->get('m_detalles_locales');
            if($query->num_rows() > 0 ){
                $data = array(
                    'descripcion' => $descripcion,
                    'tipo_local' => $tipo_local,
                    'tipo_comida' => $tipo_comida,
                    'telefono' => $telefono
                );
                $this->db->where('ml_id', $id);
                $query = $this->db->update('m_detalles_locales', $data);
            return $query;
            }
            else{
                $data = array(
                    'ml_id' => $id,
                    'descripcion' => $descripcion,
                    'tipo_local' => $tipo_local,
                    'tipo_comida' => $tipo_comida,
                    'telefono' => $telefono
                );
                $query = $this->db->insert('m_detalles_locales', $data);
                return $query;
            }

        }

            public function modifica_detalles2($id,$descripcion,$tipo_local,$tipo_comida,$telefono,$imagen){
            //actualiza detalles aqui
            $this->db->where('ml_id',$id);
            $query = $this->db->get('m_detalles_locales');
            if($query->num_rows() > 0 ){
                $data = array(
                    'descripcion' => $descripcion,
                    'imagen'=> $imagen,
                    'tipo_local' => $tipo_local,
                    'tipo_comida' => $tipo_comida,
                    'telefono' => $telefono
                );
                $this->db->where('ml_id', $id);
                $query = $this->db->update('m_detalles_locales', $data);
            return $query;
            }
            else{
                $data = array(
                    'ml_id' => $id,
                    'descripcion' => $descripcion,
                    'imagen'=> $imagen,
                    'tipo_local' => $tipo_local,
                    'tipo_comida' => $tipo_comida,
                    'telefono' => $telefono
                );
                $query = $this->db->insert('m_detalles_locales', $data);
                return $query;
            }

        }

        public function sube_imagen($id,$ruta){
            $data = array(
                'imagen' => $ruta
            );
            $this->db->where('ml_id', $id);
            $query = $this->db->update('m_detalles_locales', $data);

            return $query;

        }

        public function ingresa_marcadores($id,$direccion,$lat,$lng){
            $this->db->where('ml_id',$id);
            $query = $this->db->get('marcadores');
            if($query->num_rows() > 0 ){
                $data = array(
                    'ml_id' => $id,
                    'direccion'=> $direccion,
                    'lat' => $lat,
                    'lng' => $lng
                );
                $this->db->where('ml_id', $id);
                $this->db->update('marcadores', $data);
                return true;
            }
            else{
                $data = array(
                    'ml_id' => $id,
                    'direccion'=> $direccion,
                    'lat' => $lat,
                    'lng' => $lng
                );
                $this->db->insert('marcadores', $data);
                return true;
            }

        }

        public function obtener_marcador($id){
            $this->db->where('ml_id',$id);
            $query = $this->db->get('marcadores');
            if ($query->num_rows() > 0){
                return $query->result();
            }
            else{return false;}
        }

        public function obtener_marcador2($id){
            $this->db->where('ml_id',$id);
            $query = $this->db->get('marcadores');
            if ($query->num_rows() > 0){
                return $query->result();
            }
            else{return -1;}
        }

        public function obtener_marcador_sugerido($id){
            $this->db->where('id_sugerencias',$id);
            $query = $this->db->get('sugerencias');
            if ($query->num_rows()>0){
                return $query->result();
            }
            else{return false;}
        }



        public function ultimo_marcador(){
            $query = $last_row=$this->db->select('ml_id')->order_by('ml_id',"desc")->limit(1)->get('marcadores');
            if ($query->num_rows()>0){
                $cosa = $query->result();
                return $cosa[0]->ml_id;
            }
            else{return 0;}

        }

        public function nuevo_local($nombre,$calle,$numero,$direccion,$detalle,$ciudad,$comuna,$region){

            $datalocal = array(
                'ml_nombre_local' => $nombre,
                'ml_calle' => $calle,
                'ml_numero' => $numero,
                'ml_direccion' => $direccion,
                'ml_detalle' => $detalle,
                'ml_ciudad' => $ciudad,
                'ml_comuna' => $comuna,
                'ml_region' => $region
            );

            $this->db->insert('m_dir_locales', $datalocal);
            return $this->db->insert_id();
        }

        public function elimina_local($id){
            $tables = array('m_dir_locales', 'marcadores', 'm_detalles_locales','puntaje_calidad','puntaje_precio','comentarios');
            $this->db->where('ml_id',$id);
            return $this->db->delete($tables);

        }

        public function sugiere_eliminar($id,$estado,$nombre){

            $datalocal = array(
                'id_local' => $id,
                'ml_nombre_local' => $nombre,
                'estado' => $estado
            );

            $query = $this->db->insert('sugerencias',$datalocal);
            return $query;
        }

        public function sugiere_nuevo($estado,$id,$nombre,$calle,$numero,$direccion,$detalle,$ciudad,$comuna,$region,$imagen,$descripcion,$tipo_local,$tipo_comida,$telefono,$lat,$lng){

            $datalocal = array(
                'id_local' => $id,
                'estado' => $estado,
                'ml_nombre_local' => $nombre,
                'ml_calle' => $calle,
                'ml_numero' => $numero,
                'ml_direccion' => $direccion,
                'ml_detalle' => $detalle,
                'ml_ciudad' => $ciudad,
                'ml_comuna' => $comuna,
                'ml_region' => $region,
                'imagen' => $imagen,
                'descripcion' => $descripcion,
                'tipo_local' => $tipo_local,
                'tipo_comida' => $tipo_comida,
                'telefono' => $telefono,
                'lat' => $lat,
                'lng' => $lng
            );

            return $this->db->insert('sugerencias', $datalocal);
            //return $this->db->insert_id();
        }

    public function obtiene_usuarios(){
                $this->db->where('status',"1");
                $query = $this->db->get('usuarios');
                if ($query->num_rows()>0){
                        return $query->result_array();
                }
                else{return false;}
    }

    public function modificar_usuario($id,$nuevoNombre,$nuevoTipo){
        $data = array(
                'nombre' => $nuevoNombre,
                'tipo_usuario' => $nuevoTipo
            );

        $this->db->where('id_usuario', $id);
        $query = $this->db->update('usuarios', $data);
        return $query;

    }
    public function eliminarUsuario($id){
               $data = array(
                'status' => "0"
            );

        $this->db->where('id_usuario', $id);
        $this->db->where('tipo_usuario <',7);
        $query = $this->db->update('usuarios', $data);
        return $query;
    }

    public function retornar_sugerencias(){
            $query = $this->db->get('sugerencias');
            if ($query->num_rows()>0){
                return $query->result_array();
            }
                else{return false;}
    }

    public function eliminar_sugerencia($id){
            $query = $this->db->where('id_sugerencias', $id);
            $query = $this->db->delete('sugerencias');
    }



}//fin modelo.
?>
