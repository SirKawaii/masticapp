   <div class="container">
    <div class="row">
        <div class="col l6 s12">
           <div class="card-panel grey lighten-5 z-depth-1 hoverable">
               <table class="striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                        if($sugerencias == NULL){
                            echo "<tr><td>No</td><td>hay</td><td>Datos</td></tr>";
                        }
                        else{
                            foreach ($sugerencias as $sugerencia){
                                echo "<tr id='".$sugerencia['id_sugerencias']."'>";
                                echo "<td>".anchor("local/index/".$sugerencia['id_local'],$sugerencia['ml_nombre_local'])."</td>";
                                if($sugerencia['estado'] == "Eliminar"){
                                    echo "<td>".anchor("modifica/elimina/".$sugerencia['id_local'],"<i class='material-icons'>delete</i>","class='col s12 waves-effect waves-light btn orange'")."</td>";
                                }
                                else{
                                    echo "<td>".anchor("sugerencias/localSugerido/".$sugerencia['id_sugerencias'],"<i class='material-icons'>edit</i>","class='col s12 waves-effect waves-light btn blue'")."</td>";
                                }
                                echo "<td><a onclick='eliminar(".$sugerencia['id_sugerencias'].")' class='col s12 waves-effect waves-light btn red'><i class='material-icons'>delete_forever</i></a></td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
           </div>
        </div>
    </div>
</div>


<script type="text/javascript">
function eliminar(id){
    var txt;
    if (confirm("¿Deseas realmente eliminar esta sugerencia?") == true) {
        $.ajax({
           type:"POST",
           url:"<?php echo base_url('sugerencias/eliminar_sugerencia/');?>",
           data:{
            id:id
            },
           success:function(data){
            console.log(data);
            Materialize.toast('Eliminado Correctamente.', 3000);
            $("#"+id).remove();
           },
            fail:function(respuesta){
                alert("La eliminación falló");
                console.log(respuesta);
                }
            });
    } else {
        Materialize.toast('Eliminación Cancelada.', 3000);
    }
}
</script>
