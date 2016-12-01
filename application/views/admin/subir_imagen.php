<?
$det = json_decode($detalles);
$detalle = $det[0];
?>

<div id="container">
    <div class="row">
        <div class="col s12 m 10 l8 offset-l2">
            <p>Imagen Actual:</p>
                <img class="responsive-img" src="<? if ($detalle->imagen != ""){echo $detalle->imagen;}else{echo base_url('assets/imagenes/404.png');} ?>">
        </div>
        <div class="col">
            <form name="subir_imagen" id="subir_imagen" >
                <input id="file_upload" name="attachment_file" class="file_upload_icon" type="file"/>
                <input type="button" class="post postbtn" style="border: none;outline:none;" value="Post" onclick = "return sendData()"/>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
function sendData()
{
    var url = "<?= base_url('modifica/cambio/'.$detalle->ml_id);?>";

    var data = new FormData($('#subir_imagen')[0]);
    Materialize.toast('Subiendo Imagen, no cierres la ventana.', 8000);


     $.ajax({
               type:"POST",
               url:"<?php echo base_url('modifica/subir/'.$detalle->ml_id);?>",
               data:data,
               mimeType: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
               success:function(data)
              {
                console.log(data);
                Materialize.toast('Imagen Subida correctamente', 4000);

                $( location ).attr("href", url);

               }
       });

}

</script>
