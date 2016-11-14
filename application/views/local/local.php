<?
//accediendo al objeto
$local_data = json_decode($local);
$local_dat = $local_data[0];
$precio = $puntaje['precio'][0];
$calidad = $puntaje['calidad'][0];


//variables de local
$promedio = round((($precio->prom_precio + $calidad->prom_calidad)/2),1);


?>
<div id="container">
<div class="row">
    <div class="col l4 s12 m10 offset-m1 offset-l2">
    <div class="card medium hoverable">
        <div class="card-image waves-effect waves-block waves-light">
          <img class="activator" src="http://casas.brick7.co.ve/media/ve/62501_62600/62549_29768c9021b84b25.jpg">
        </div>
        <div class="card-content">
          <span class="card-title activator grey-text text-darken-4"><?= $local_dat->ml_nombre_local;?><i class="material-icons right">more_vert</i></span>
            <p><a href="#">This is a link</a></p>
        </div>
        <div class="card-reveal">
          <span class="card-title grey-text text-darken-4">Card Title<i class="material-icons right">close</i></span>
          <p>Here is some more information about this product that is only revealed once clicked on.</p>
        </div>
    </div>
        <div class="card-panel grey lighten-5 z-depth-1 hoverable row">
            <div class='col s8'><fieldset>
                <legend>Calidad</legend>
                <div class='rating_calidad' data-rate-value= <?= $calidad->prom_calidad ;?>></div>
            </fieldset>
            <fieldset>
            <legend>Precio</legend>
                <div class='rating_precio' data-rate-value=<?= $precio->prom_precio ;?>></div>
            </fieldset>
            </div>
        <div class='col s4'>
            <fieldset ><legend>Puntaje</legend>
            <h1 class='center-align'><?= $promedio ?></h1>
            </fieldset>
        </div>
        </div>
    </div>

    <div class="col l4 s12 m10 l4 offset-m1">
        <div class="card-panel hoverable">
             <div class="row" id="agregar_comentario">
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                      <div class="collapsible-header"><i class="material-icons">comment</i>Comenta!</div>
                      <div class="collapsible-body">
                        <form>
                            <div class="row">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">account_circle</i>
                                    <input id="nombre" type="text" class="validate" >
                                    <label for="nombre">Nombre</label>
                                </div>
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">comment</i>
                                    <textarea id="comentario" class="materialize-textarea"></textarea>
                                    <label for="comentario">Comentario</label>
                                </div>
                                <div class="col offset-m8 offset-s7 offset-l6">
                                    <a class="waves-effect waves-light btn" id="enviar-comentario"><i class="material-icons right">send</i>Enviar</a>
                                </div>
                            </div>
                        </form>
                      </div>
                    </li>
                </ul>
              </div>
            <div>
                <div class="row">
                    <ul class="collection with-header" id="caja-comentarios">
                        <li class="collection-header"><h5>Comentarios</h5></li>
                        <?= $comentarios; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
<script>
$(".rating_precio").on("change", function(ev, data){
    console.log(data.from, data.to);
        $.ajax({
            url:"<?= base_url('local/actualiza_precio')?>" ,
            type:"POST",
            data:{id:<?= $precio->ml_id ?>,voto:data.to},
            success:function(respuesta){
                console.log(respuesta);
                Materialize.toast('Puntaje en Precio Agregado!', 4000) // 4000 is the duration of the toast
            },
            fail:function(respuesta){
                alert("el voto a fallado ");
            }

        });

});
$(".rating_calidad").on("change", function(ev, data){
    console.log(data.from, data.to);
        $.ajax({
            url:"<?= base_url('local/actualiza_calidad')?>" ,
            type:"POST",
            data:{id:<?= $precio->ml_id ?>,voto:data.to},
            success:function(respuesta){
                console.log(respuesta);
                Materialize.toast('Puntaje en Calidad Agregado!', 4000) // 4000 is the duration of the toast
            },
            fail:function(respuesta){
                alert("el voto a fallado ");
            }

        });

});
//inserta comentario
$("#enviar-comentario").on("click", function(){

    var id = <?= $local_dat->ml_id;?>;
    var nombre = document.getElementById('nombre').value;
    var comentario = document.getElementById('comentario').value;

    if(id == "" | nombre == "" | comentario == ""){
        Materialize.toast('Por favor, rellena todos los campos.', 4000) // 4000 is the duration of the toast
        Materialize.toast(id+" "+nombre+" "+comentario, 4000) // 4000 is the duration of the toast
    }else{
        $.ajax({
            url:"<?= base_url('local/agrega_comentario')?>" ,
            type:"POST",
            data:{id:id,nombre:nombre,comentario:comentario},
            success:function(respuesta){
                console.log(respuesta);
                $("#agregar_comentario").addClass( "hide" );
                $("#caja-comentarios").append("<li class='collection-item'><span class='title'><h5>"+nombre+"</h5></span><blockquote>"+comentario+"</blockquote></li>");
                Materialize.toast('Comentario Agregado', 4000) // 4000 is the duration of the toast
            },
            fail:function(respuesta){
                alert("el voto a fallado ");
                console.log(respuesta);
            }

        });
    }


});

</script>
