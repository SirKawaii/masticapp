<?
//accediendo al objeto
$local_data = json_decode($local);
$local_dat = $local_data[0];
$precio = $puntaje['precio'][0];
$calidad = $puntaje['calidad'][0];


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
            <h1 class='center-align'>5.0</h1>
            </fieldset>
        </div>
        </div>
    </div>

</div>
</div>
<script>
$(".rating_precio").on("change", function(ev, data){
    console.log(data.from, data.to);

});
</script>
