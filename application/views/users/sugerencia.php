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
                            <input value="<?= $local->ml_nombre_local;?>" id="nombre_local" type="text" class="validate" >
                            <label for="nombre_local">Nombre local</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix">store</i>
                            <input value="<?= $local->ml_calle;?>" id="calle" type="text" class="validate" >
                            <label for="calle">calle</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix">dialpad</i>
                            <input value="<?= $local->ml_numero;?>" id="numero" type="text" class="validate" >
                            <label for="numero">numero</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix">my_location</i>
                            <input value="<?= $local->ml_direccion;?>" id="direccion" type="text" class="validate" >
                            <label for="direccion">direccion</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix">zoom_in</i>
                            <input value="<?= $local->ml_detalle;?>" id="detalle" type="text" class="validate" >
                            <label for="detalle">detalle</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix">business</i>
                            <input value="<?= $local->ml_ciudad;?>" id="ciudad" type="text" class="validate" >
                            <label for="ciudad">ciudad</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix">group_work</i>
                            <input value="<?= $local->ml_comuna;?>" id="comuna" type="text" class="validate" >
                            <label for="nombre">comuna</label>
                        </div>
                        <div class="input-field col s12">
                        <i class="material-icons prefix">language</i>
                            <select id="region">
                               <option value ="<?= $local->ml_region;?>" default><?= $local->ml_region;?></option>
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
                            <input value="<?= $latitud[0]->lat;?>" id="lat" type="text" class="validate" disabled>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix">location_on</i>
                            <input value="<?= $latitud[0]->lng;?>" id="lng" type="text" class="validate" disabled>
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
                            <textarea value="" id="descripcion" class="materialize-textarea"><?= $detalles->descripcion;?></textarea>
                            <label for="descripcion">Descripcion</label>
                        </div>
                        <div class="input-field col s12">
                        <i class="material-icons prefix">toc</i>
                            <select id="t_local">
                             <option value="<?= $detalles->tipo_local;?>" default><?= $detalles->tipo_local;?></option>
                              <option value="supermercado">Supermercado</option>
                              <option value="casino universitario">Casino Universitario</option>
                              <option value="restaurant">Restaurant</option>
                              <option value="comida rapida">Comida Rapida</option>
                            </select>
                            <label>Tipo Local</label>
                        </div>
                        <div class="input-field col s12">
                        <i class="material-icons prefix">toc</i>
                            <select id="t_comida">
                             <option value="<?= $detalles->tipo_comida;?>" default><?= $detalles->tipo_comida;?></option>
                              <option value="casera">Casera</option>
                              <option value="abarrotes">Abarrotes</option>
                              <option value="menu">Menu</option>
                              <option value="comida rapida">Comida Rapida</option>
                            </select>
                            <label>Tipo Comida</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix">phone</i>
                            <input value="<?= $detalles->telefono;?>" id="telefono" type="text" class="validate" >
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
    var id = '<?= $local->ml_id; ?>';
    var nombre = $('#nombre_local').val();
    var calle = $('#calle').val();
    var numero = $('#numero').val();
    var direccion = $('#direccion').val();
    var detalle = $('#detalle').val();
    var ciudad = $('#ciudad').val();
    var comuna = $('#comuna').val();
    var region = $('#region').val();
    var lat = $('#lat').val();
    var lng = $('#lng').val();
    var descripcion = $('#descripcion').val();
    var t_local = $('#t_local').val();
    var t_comida = $('#t_comida').val();
    var telefono = $('#telefono').val();
    var imagen = imagen;



        $.ajax({
            url:"<?= base_url('sugerencia/sugerirNuevoLocal/');?>",
            type:"POST",
            data:{estado:estado,
                  id:id,
                  nombre:nombre,
                  calle:calle,
                  numero:numero,
                  direccion:direccion,
                  detalle:detalle,
                  ciudad:ciudad,
                  comuna:comuna,
                  region:region,
                  lat:lat,
                  lng:lng,
                  imagen:imagen,
                  descripcion:descripcion,
                  tipo_local:t_local,
                  tipo_comida:t_comida,
                  telefono:telefono
                 },
            success:function(respuesta){
                console.log(respuesta);
                Materialize.toast('Datos Actualizados', 4000); // 4000 is the duration of the toast
                url = "<a href='<?= base_url('local/index/').$local->ml_id;?>' class='col s12 waves-effect waves-light btn orange'>Volver al Local.</a>";
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
