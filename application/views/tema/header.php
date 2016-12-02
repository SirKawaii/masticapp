<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title><?php echo $titulo; ?></title>
  <link rel="icon" href="<?= base_url('assets/imagenes/favicon.gif');?>" type="image/gif" sizes="32x32">
  <meta name="description" content="Buscador de Locales BAES - Encuentra locales asociados a la beca BAES Junaeb">

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="<?php echo base_url('assets/css/materialize.css') ?>" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="<?php echo base_url('assets/css/style.css') ?>" type="text/css" rel="stylesheet" media="screen,projection"/>
  <!--Scripts -->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="<?php echo base_url('assets/js/materialize.js') ?>"></script>
  <script src="<?php echo base_url('assets/js/init.js') ?>"></script>
    <!-- De ser nesesario -->
    <? if (isset($estrellas)) {
    echo $estrellas;
    } ?>
</head>
<body>

 <nav class="orange" role="navigation">
    <div class="nav-wrapper container">
        <a id="logo-container" href="<?= base_url(); ?>" class="brand-logo"><?= $titulo; ?></a>
      <ul class="right hide-on-med-and-down">
        <?= $navegacion;?>
        <li><a href="#" class="waves-effect" onclick="$('.button-collapse').sideNav('show');"><i class="material-icons">menu</i></a></li>
      </ul>

      <ul id="nav-mobile" class="side-nav">
        <!-- Inicio Tarjeta Nav -->
        <li><div class="userView">
          <img class="background orange responsive-img" src='<?= base_url('assets/img/masticapp.png'); ?>'>
          <a href="#!email"><span class="white-text email">Masticapp</span></a>
            <br><br><br><br><br>
        </div></li>
        <?= $navegacion;?>
      </ul>
      <ul class="right waves-effect waves-light">
        <li><a href="<?= base_url('busqueda'); ?>"><i class="material-icons">search</i></a></li>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
  </nav>
