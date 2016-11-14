<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class comentarios{
    private $array_comentarios;
    public function __construct($arr){
        if (isset($arr)) {
            $this->array_comentarios = $arr;
        }
        else{
            $this->array_comentarios = NULL;
        }

    }

    public function cargar_comentarios(){
        if($this->array_comentarios != NULL){
            $comentarios = "";
                foreach($this->array_comentarios as $coment){
                    $comentarios .="<li class='collection-item'>";
                    $comentarios .= "<span class='title'><h5>".$coment['nombre_usuario']."</h5></span>";
                    $comentarios .= "<blockquote>".$coment['comentario']."</blockquote>";
                    $comentarios .= "<p>".$coment['fecha']."</p>";
                    $comentarios .= "</li>";
                }
        }
        else{
            $comentarios = "<li class='collection-item'><p>No Hay comentarios</p></li>";
        }

        return $comentarios;
    }
}
?>
