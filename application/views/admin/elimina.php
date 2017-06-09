<div class="container">
    <div class="row">
        <div class="col s12">
           <center>
               <div id="contenido">
                    <p>¿Estas seguro que deseas eliminar este local?</p>
                    <button class="col s12 waves-effect waves-light btn orange" onclick="killemall()">ELIMINAR</button>
                </div>
            </center>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function(valor){
        window_size = $(window).height();
        $('#contenido').css('min-height', window_size);
    });


    function killemall(){
        var id = '<?= $id; ?>';
        if (confirm("¿Estas seguro que deseas Elininarlo?") == true) {
        $.ajax({
           type:"POST",
           url:"<?php echo base_url('modifica/eliminarLocal/');?>"+id,
           data:{
            id:id
            },
           success:function(data){
            console.log(data);
            Materialize.toast('Eliminado Correctamente.', 3000);
            url = "<a href='<?= base_url('mapa') ;?>' class='col s12 waves-effect waves-light btn orange'>Volver al Mapa</a>";
            $("#contenido").html("<p>Local Eliminado</p>" + url);
           },
            fail:function(respuesta){
                alert("La eliminación falló");
                console.log(respuesta);
                }
            });

        }else {
            Materialize.toast('Eliminación Cancelada.', 3000);
        }
    }
</script>
