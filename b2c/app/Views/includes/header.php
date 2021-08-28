<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title><?php echo str_replace('App\Controllers\\',' ', service('router')->controllerName());?></title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url("writable/themeData/");?>plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url("writable/themeData/");?>dist/css/adminlte.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo base_url("writable/themeData/");?>plugins/toastr/toastr.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('writable');?>/faviconnew.ico">
  <!-- jQuery -->
  <script src="<?php echo base_url("writable/themeData/");?>plugins/jquery/jquery.min.js"></script>
  <link href="<?php echo base_url("writable/themeData/");?>sweetalert/sweetalert2.min.css?v=1" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url("writable/themeData/");?>sweetalert/animate.min.css?v=1" rel="stylesheet" type="text/css">
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css"> -->

  <script src="<?php echo base_url("writable/themeData/");?>sweetalert/sweetalert2.all.min.js?v=1"></script>
  <style>
    .swal2-container.swal2-backdrop-show
		{
			background: #00000066;
		}
		.swal-size-sm
		{
			width: auto;
		}
    .swal-size-sm
    {
      width: auto;
    }
  </style>
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to to the body tag
to get the desired effect
|---------------------------------------------------------|
|LAYOUT OPTIONS | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo base_url();?>" class="nav-link">Home</a>
      </li>
      <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> -->
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3" method="post" onsubmit="return searchGame(event);">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" id="gameSearch" name="gameSearch" oninput="return searchGameData();" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
    <!-- start of 3 buttons -->
    <li class="nav-item">
        <?php if( isset($_SESSION['loginUserData']) && !empty($_SESSION['loginUserData']) ): ?>
        <?php $redirectURL = "https://simulessons.com/trgroi2/auto-login?user_Email=" . $_SESSION['loginUserData']->user_Email . '&user_Password=' . $_SESSION['loginUserData']->user_Password ?>
            <a class="nav-link" title="Home" href="<?php echo $redirectURL ?>">
              <button type="button" class="btn btn-primary btn-flat">
                <i class="fa fa-home"></i>
              </button>
            </a>
        <?php else: ?>
            <a class="nav-link" title="Home" href="https://simulessons.com">
              <button type="button" class="btn btn-primary btn-flat">
                <i class="fa fa-home"></i>
              </button>
            </a>
        <?php endif; ?>
      </li>

      <li class="nav-item">
        <a class="nav-link" title="Cart" href="<?php echo base_url('Cart'); ?>">
          <button type="button" class="btn btn-primary btn-flat">
            <i class="fa fa-shopping-cart"></i>
            <span class="badge badge-warning navbar-badge" id="gameCountInCart">0</span>
          </button>
        </a>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" title="Action" href="#">
          <button type="button" class="btn btn-primary btn-flat">
            <i class="fas fa-th-large"></i>
          </button>
        </a>
        <!-- showing dropdown here -->
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <!-- <a href="<?php // echo base_url('profile'); ?>" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Profile
            <span class="float-right text-muted text-sm">3 mins</span>
          </a> -->
          <div class="dropdown-divider"></div>
          <!-- <a href="<?php // echo base_url('resetpassword'); ?>" class="dropdown-item">
            <i class="fas fa-lock mr-2"></i> Change Password
            <span class="float-right text-muted text-sm">12 hours</span>
          </a> -->
          <div class="dropdown-divider"></div>
          <a href="<?php echo base_url('logout'); ?>" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
            <!-- <span class="float-right text-muted text-sm">2 days</span> -->
          </a>
        </div>
        <!-- end of dropdown here -->
      </li>
      <!-- end of 3 buttons -->
      
    </ul>

  </nav>
  <!-- /.navbar -->
