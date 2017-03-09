<?php
  /*session_start();
  if(!isset($_SESSION['login'])){
    session_destroy();
    echo "<script type='text/javascript'>window.location='login.php';</script>";
    exit();
  }*/
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1, user-scalable=yes">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sux Admin</title>
  <link rel="stylesheet" type="text/css" href="css/vendor.css">
  <link rel="stylesheet" type="text/css" href="css/sux-admin.min.css">
  <meta name="description" content="Sux-Admin - Free Bootstrap Admin Theme">
  <meta name="keyword" content="bootstrap, admin, theme, sux-admin, fesuydev">
</head>

<body>
  <!-- .navbar-top -->
  <nav class="navbar navbar-top" role="navigation">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-inline-collapse">
          <span class="fa fa-chevron-down"></span>
        </button>
        <a class="navbar-brand" href="index.php">Sux Admin</a>
      </div>
      <ul class="nav navbar-toolbar">
        <li><a href="#" data-toggle="sidebar-collapse"><span class="fa fa-chevron-left"></span></a></li>
        <li>
          <a href="#" class="search-toggle" data-toggle="collapse" data-target=".form-search-collapse"><span class="fa fa-search"></span></a>
          <form class="collapse form-search-collapse" method="GET">
            <div class="form-group">
              <input type="text" class="form-control" name="search">
            </div>
           </form>
        </li>
      </ul>
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse navbar-inline-collapse">
        <div class="navbar-scroller">
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown dropdown-nav">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-user"></span> Hello, user <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#"><span class="fa fa-gear"></span> Setting</a></li>
                <li><a href="#"><span class="fa fa-power-off"></span> Logout</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
      <!-- /.navbar-collapse -->
    </div>
  </nav>
  <!-- /.navbar-top -->