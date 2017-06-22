<html>
   <head>
        <script type="text/javascript">
            var centreGot = false;
        </script>
        <?php echo $map['js']; ?>
    </head>
<body>
   <div class="container">
    <div class="row" id="actualizador">
        <div class="card" >
            <h5 class="col">Datos Local</h5>
                <form>
                    <div class="row">
                    <div class="col s12 l12 m12">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input value="" id="nombre_local" type="text" class="validate" >
                            <label for="nombre_local">Nombre local</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix">store</i>
                            <input value="" id="calle" type="text" class="validate" >
                            <label for="calle">calle</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix">dialpad</i>
                            <input value="" id="numero" type="text" class="validate" >
                            <label for="numero">numero</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix">my_location</i>
                            <input value="" id="direccion" type="text" class="validate" >
                            <label for="direccion">direccion</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix">zoom_in</i>
                            <input value="" id="detalle" type="text" class="validate" >
                            <label for="detalle">detalle</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix">business</i>
                            <input value="" id="ciudad" type="text" class="validate" >
                            <label for="ciudad">ciudad</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix">group_work</i>
                            <input value="" id="comuna" type="text" class="validate" >
                            <label for="nombre">comuna</label>
                        </div>
                        <div class="input-field col s12">
                        <i class="material-icons prefix">language</i>
                            <select id="region">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                            </select>
                            <label>Region</label>
                        </div>
                        <div>
                            <?php echo $map['html']; ?>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix">location_on</i>
                            <input value="" id="lat" type="text" class="validate" disabled>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix">location_on</i>
                            <input value="" id="lng" type="text" class="validate" disabled>
                        </div>
                    </div>
                    </div>
                </form>
        </div>

        <div class="card row">
            <h5 class="col">Detalles Local</h5>
            <div class="col s12 l12 m12">
                <form name="subir_imagen" id="subir_imagen" >
                    <p>Imagen:</p>
                    <input id="file_upload" name="attachment_file" class="file_upload_icon input-field col s12" type="file"/>
                </form>
            </div>
            <form>
                <div class="row">
                    <div class="col s12 l12 m12">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">comment</i>
                            <textarea value="" id="descripcion" class="materialize-textarea"></textarea>
                            <label for="descripcion">Descripcion</label>
                        </div>
                        <div class="input-field col s12">
                        <i class="material-icons prefix">toc</i>
                            <select id="t_local">
                              <option value="Supermercado">Supermercado</option>
                              <option value="Casino universitario" default>Casino Universitario</option>
                              <option value="Restaurant">Restaurant</option>
                              <option value="Comida rapida">Comida Rapida</option>
                            </select>
                            <label>Tipo Local</label>
                        </div>
                        <div class="input-field col s12">
                        <i class="material-icons prefix">toc</i>
                            <select id="t_comida">
                              <option value="Casera" default>Casera</option>
                              <option value="Abarrotes">Abarrotes</option>
                              <option value="Menu">Menu</option>
                              <option value="Comida rapida">Comida Rapida</option>
                            </select>
                            <label>Tipo Comida</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix">phone</i>
                            <input value="" id="telefono" type="text" class="validate" >
                            <label for="telefono">Teléfono</label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
            <div class="col s12 l12 m12">
                <a class="waves-effect waves-light btn" id="mod_local"><i class="material-icons right">send</i>Agregar Local</a>
                <br><br>
            </div>

    </div>
</div>
<script>
  $(document).ready(function() {
    $('select').material_select();
  });

$(document).ready(function(valor){
        $(".boton").on("click", function(){
            //$( location ).attr("href", url);
        });

        window_size = $(window).height();
        $('#actualizador').css('min-height', window_size /2);
});

function sendData(id)
{
    var data = new FormData($('#subir_imagen')[0]);
    Materialize.toast('Subiendo Imagen, no cierres la ventana.', 3000);


     $.ajax({
            type:"POST",
            url:"<?php echo base_url('sugerencia/subir/');?>",
            data:data,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            success:function(data)
            {
                console.log(data);
                ruta = data;
                Materialize.toast('Imagen Subida', 3000) // 4000 is the duration of the toast
                Materialize.toast('Actualizando datos.', 3000)
                nuevos_datos(data);
            }
       });
}

function nuevos_datos(imagen){

    var estado = '<?= $estado; ?>';
    var id = ' ';
    var nombre = $('#nombre_local').val();
    var calle = $('#calle').val();
    var numero = $('#numero').val();
    var direccion = $('#direccion').val();
    var detalle = $('#detalle').val();
    var ciudad = $('#ciudad').val();
    var comuna = $('#comuna').val();
    var region = $('#region').val();
    var imagen = imagen;
    var descripcion = $('#descripcion').val();
    var t_local = $('#t_local').val();
    var t_comida = $('#t_comida').val();
    var telefono = $('#telefono').val();
    var lat = $('#lat').val();
    var lng = $('#lng').val();



        $.ajax({
            url:"<?= base_url('sugerencia/sugerirNuevoLocal/');?>",
            type:"POST",
            data:{estado:estado,
                  nombre:nombre,
                  calle:calle,
                  numero:numero,
                  direccion:direccion,
                  detalle:detalle,
                  ciudad:ciudad,
                  comuna:comuna,
                  region:region,
                  imagen:imagen,
                  descripcion:descripcion,
                  tipo_local:t_local,
                  tipo_comida:t_comida,
                  telefono:telefono,
                  lat:lat,
                  lng:lng
                 },
            success:function(respuesta){
                console.log(respuesta);
                Materialize.toast('Datos Actualizados', 4000); // 4000 is the duration of the toast
                url = "<a href='<?= base_url('');?>' class='col s12 waves-effect waves-light btn orange'>Volver.</a>";
                $("#actualizador").html("<p>Sugerencia Ingresada</p>" + url);
            },
            fail:function(respuesta){
                alert("la actualizacion Falló");
                console.log(respuesta);
            }

        });

};

$("#mod_local").on("click", function(){
    //enviar datos
    sendData();
});


</script>
</body>
</html>
