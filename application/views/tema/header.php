<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title><?php echo $titulo; ?></title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="<?php echo base_url('assets/css/materialize.css') ?>" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="<?php echo base_url('assets/css/style.css') ?>" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>

 <nav class="light-blue lighten-1" role="navigation">
    <div class="nav-wrapper container">
        <a id="logo-container" href="#" class="brand-logo"><?= $titulo; ?></a>
      <ul class="right hide-on-med-and-down">
        <?= $navegacion;?>
        <li><a href="#" class="waves-effect" onclick="$('.button-collapse').sideNav('show');"><i class="material-icons">menu</i></a></li>
      </ul>

      <ul id="nav-mobile" class="side-nav">
        <!-- Inicio Tarjeta Nav -->
        <li><div class="userView">
          <img class="background responsive-img" src="http://www.combogamer.com/wp-content/uploads/2015/01/Ghost-in-the-Shell-Motoko-ComboGamer.jpg">
          <a href="#!name"><span class="white-text name">Mit</span></a>
          <a href="#!email"><span class="white-text email">Masticapp</span></a>
        </div></li>
        <?= $navegacion;?>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
  </nav>
