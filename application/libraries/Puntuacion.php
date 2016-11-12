<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class puntuacion{
    private $punt_menu;
    public function __construct(){
        //$this->arr_menu = $arr;
    }

    public function construir_puntuacion(){
        $punt_menu =  "<div class='col s8'><fieldset><legend>Calidad</legend>";
        $punt_menu .= "<div class='rating_calidad' data-rate-value=5></div>";
        $punt_menu .= "</fieldset>";
        $punt_menu .= "<fieldset><legend>Precio</legend>";
        $punt_menu .= "<div class='rating_precio' data-rate-value=5></div>";
        $punt_menu .= "</fieldset>";
        $punt_menu .= "</div>";
        $punt_menu .= "<div class='col s4'>";
        $punt_menu .= "<fieldset ><legend>Puntaje</legend>";
        $punt_menu .= "<h1 class='center-align'>5.0</h1>";
        $punt_menu .= "</fieldset>";
        $punt_menu .= "</div>";


        return $punt_menu;
    }
}
?>
