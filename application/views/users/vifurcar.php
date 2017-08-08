<div class="container">
    <div class="row">
       <center>
        <div id="contenido">
            <div class="col s12 l10 offset-l1">
                <h2>¿Que deseas sugerir en el local?</h2>
            </div>
            <div class="col s12 l10 offset-l1">
                <div class="col s12">
                    <a id="elimina" onclick="eliminar()" class="col s12 waves-effect waves-light btn orange hoverable">Este local no existe.</a>
                </div>
                <div>
                    <br>
                    <br>
                    <br>
                </div>
                <div class="col s12">
                    <?= anchor("sugerencia/sugerir/$id","Sugerir cambios en el local.","class='col s12 waves-effect waves-light btn orange hoverable'"); ?>
                </div>
                <div>
                    <br>
                    <br>
                    <br>
                </div>
                <div class="col s12">
                    <?= anchor("sugerencia/sugerir/NUEVO","Sugerir un nuevo local.","class='col s12 waves-effect waves-light btn orange hoverable'"); ?>
                </div>
            </div>
        </div>
        </center>
    </div>
    <div class="row hide" id="confirmar">
        <center>
            <div class="col s12 l10 offset-l1">
                <h2>Gracias por tus sugerencias</h2>
            </div>
        </center>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function(valor){

        window_size = $(window).height();
        $('#contenido').css('min-height', window_size /2);

    });

    function eliminar(){

        if (confirm("¿Deseas enviar esta sugerencia?") == true) {
            $.ajax({
                url:"<?= base_url('sugerencia/eliminarPost/');?>",
                type:"POST",
                data:{id:'<?= $id;?>',
                      nombre:'<? $nombre_local;?>',
                      estado:'Eliminar'
                     },
                success:function(respuesta){
                    console.log(respuesta);
                    url = "<a href='<?= base_url('local/index/'.$id) ;?>' class='col s12 waves-effect waves-light btn orange'>Volver</a>";
                    $("#contenido").html("<center><h3>Sugerencia enviada</h3></center>" + url);
                    Materialize.toast('Sugerencia enviada.', 4000) // 4000 is the duration of the toast
                },
                fail:function(respuesta){
                    alert("la actualizacion Falló");
                    console.log(respuesta);
                }

             });
        } else {

        }


    }
</script>
