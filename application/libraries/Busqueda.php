<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class busqueda{
    private $arr_lst;
    public function __construct(){
        //$this->arr_menu = $arr;
    }

    public function IniciarBusqueda($arr){
        $this->arr_lst = $arr;
    }

    public function construir_busqueda(){
        $ret_menu = "";
        foreach($this->arr_lst as $opcion){
            $ret_menu .="<li>".anchor($opcion['ml_nombre_local'],$opcion['ml_nombre_local'],"class='waves-effect waves-teal'")."</li>";
            $ret_menu .="<li><div class='divider'></div></li>";
        }
        return $ret_menu;
    }
}
?>
