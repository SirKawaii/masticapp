<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class busqueda{
    private $arr_menu;
    public function __construct($arr){
        $this->arr_menu = $arr;
    }

    public function construir_busqueda(){
        $ret_menu = "";
        foreach($this->arr_menu as $opcion){
            $ret_menu .="<li>".anchor($opcion,$opcion,"class='waves-effect waves-teal'")."</li>";
            $ret_menu .="<li><div class='divider'></div></li>";
        }
        return $ret_menu;
    }
}
?>
