<div class="container">
<div class="row">
    <div class="col s12 l10 offset-l1">
       <center>
        <div class="col s12 l3">
            <?= anchor("modifica","Buscar Local","class='col s12 waves-effect waves-light btn orange'"); ?>
        </div>
        <div class="col s12 l3">
            <?= anchor("agregar","Agregar Local","class='col s12 waves-effect waves-light btn orange'"); ?>
        </div>
        <div class="col s12 l3">
            <a class="col s12 waves-effect waves-light btn orange">Usuarios</a>
        </div>
        <div class="col s12 l3">
            <?= anchor("users/logout","Cerrar Sesión","class='col s12 waves-effect waves-light btn orange'"); ?>
        </div>
        </center>
    </div>
</div>
<?= anchor("users/registration","Crear Nuevo Usuario");?>
</div>