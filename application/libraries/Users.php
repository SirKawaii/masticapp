<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class users{

    public function listarUsuarios($usuarios){
        $ret_menu = "";
        foreach($usuarios as $usuario){
            $ret_menu .="<tr id='".$usuario['id_usuario']."'>";
            $ret_menu .="<td>".$usuario['nombre']."</td>";
            $ret_menu .="<td>".$usuario['email']."</td>";
            $ret_menu .="<td>".$usuario['status']."</td>";
            $ret_menu .="<td><i onclick='modificar(\"".$usuario['id_usuario']."\");' class='material-icons' style='cursor: pointer;'>mode_edit</i></td>";
            $ret_menu .="<td><i onclick='eliminar(\"".$usuario['id_usuario']."\");' class='material-icons' style='cursor: pointer;'>delete</i></td>";
            $ret_menu .="</tr>";
        }
        return $ret_menu;
    }
}
?>
