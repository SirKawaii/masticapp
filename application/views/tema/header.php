<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title><?php echo $title; ?></title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="<?php echo base_url('assets/css/materialize.css') ?>" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="<?php echo base_url('assets/css/style.css') ?>" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>

 <nav class="light-blue lighten-1" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo"><?php echo $title; ?></a>
      <ul class="right hide-on-med-and-down">
        <!-- <li><a href="#">Algun Link</a></li> -->
      </ul>

      <ul id="nav-mobile" class="side-nav">
        <!-- Inicio Tarjeta Nav -->
        <li><div class="userView">
          <img class="background responsive-img" src="http://www.combogamer.com/wp-content/uploads/2015/01/Ghost-in-the-Shell-Motoko-ComboGamer.jpg">
          <a href="#!user"><img class="circle responsive-img" src="https://static.betazeta.com/www.fayerwayer.com/up/2016/04/Motoko-Kusanagi1-960x623.jpg"></a>
          <a href="#!name"><span class="white-text name">John Doe</span></a>
          <a href="#!email"><span class="white-text email">jdandturk@gmail.com</span></a>
        </div></li>

        <!-- fin tarjeta Nav-->
        <li><a href="#" class="waves-effect btn-large">No va a ningun lado.</a></li>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
  </nav>
