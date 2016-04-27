<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title><?php echo $title; ?></title>
    <link rel="stylesheet" href="app/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="app/assets/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="app/assets/dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet"href="app/assets/stylesheets/<?php echo $css; ?>.css">
	<script type="text/javascript" src="app/assets/javascript/webcam.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  </head>
  <body>
  <div class="container">
	  	<header class="navbar navbar-fixed-top navbar-inverse">
	  		<div class="container">
	  			<a href="index.php" class="logo">Dress Code Violation</a>
	  			<nav>
	  				<ul class="nav navbar-nav pull-right">
	  					<li class="logo"><?php date_default_timezone_set('Asia/Manila'); echo date("F j, Y") ?></li>
	  				</ul>
	  			</nav>
	  		</div>
	  	</header>
	  	<div class="center jumbotron">