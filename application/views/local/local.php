<?
//accediendo al objeto
$local_data = json_decode($local);
$local_dat = $local_data[0];
?>
<div id="container">
<div class="row">
    <div class="col l4 s12 m10 offset-m1 offset-l2">
    <div class="card medium">
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
    </div>
</div>

</div>
