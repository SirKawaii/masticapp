<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class navegacion{
    private $arr_menu;
    public function __construct($arr){
        $this->arr_menu = $arr;
    }

    public function construir_navegacion(){
        $ret_menu = "";
        foreach($this->arr_menu as $opcion){
            $ret_menu .="<li>".anchor($opcion,$opcion,"class='waves-effect waves-light'")."</li>";
            $ret_menu .="<li><div class='divider'></div></li>";
        }
        return $ret_menu;
    }
}
?>
